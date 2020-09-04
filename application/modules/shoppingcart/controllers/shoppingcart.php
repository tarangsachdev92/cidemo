<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  shoppingcart Front Controller
 *
 *  To perform front shoppingcart related tasks
 * 
 * @package CIDemo Application
 * @subpackage Shoppingcart  
 * @copyright	(c) 2013, TatvaSoft
 * @author Bhavesh Patel <bhavesh.patel@sparsh.com>
 */
class Shoppingcart extends Base_Front_Controller
{
    /**
     * 	Create an instance
     * 
     */
    public function __construct()
    {
        parent::__construct();

        $this->access_control($this->access_rules());

        $this->load->library('cart');
        $this->load->library('form_validation');
        $this->load->model('users/users_model');
        $this->load->model('shoppingcart_categories_model');
        $this->load->model('shoppingcart_orders_model');
        $this->load->model('shoppingcart_relatedproducts_model');
        $this->load->model('shoppingcart_images_model');
        $this->load->model('shoppingcart_payments_model');
        $this->load->add_package_path(APPPATH . 'modules/shoppingcart/libraries/');
        $this->load->library('shoppingcart_paypal');
    }

    public function access_rules()
    {
        return array(
            array(
                'actions' => array('index', 'categories', 'products', 'checkout',
                    'addtocart', 'cart', 'updatecartitem', 'removecartitem', 'emptycart',
                    'login', 'userlogin',
                    'address', 'checkoutaddress', 'add_checkoutaddress', 'savecheckoutaddress',
                    'order_confirm', 'order_cancel',
                    'ini_coupon_session', 'unset_coupon_session', 'set_coupon_session_data', 'category_products','orders','order_details'),
                'users' => array('*')
            ),
        );
    }

    /**
     * Displays a home page for shopping catr module
     * In this page display all categries, best seller products, feature products and display cart item
     */
    public function index()
    {

        $data = $categories = $feature_products = $best_sellers = array();

        $language_id = $this->session->userdata[$this->section_name]['site_lang_id'];
        $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $feature_products = $this->shoppingcart_model->get_all_featured_products($language_id);
        $best_sellers = $this->shoppingcart_categories_model->getallcategories($language_id);

        $this->shoppingcart_categories_model->_record_count_front = true;

        $data['section_name'] = $this->section_name;
        $data['language_id'] = $language_id;
        $data['base_val'] = $this->base_val;
        $data['categories'] = $categories;
        $data['feature_products'] = $feature_products;
        $data['best_sellers'] = $best_sellers;
        $data['frontuserdata'] = $this->session->userdata['front'];
        $data['cart_data'] = $this->cart->contents();
        $data['cart_total'] = $this->cart->total();

        $this->theme->set('page_title', 'home ');
        $this->theme->view($data, 'index');
    }

    /**
     * Displays a list of categories data or category detail page.
     * @params string $slug_url : if then category detail page otherwise list of categories
     */
    public function categories($slug_url = NULL)
    {
        $data = $related_prddata = array();
        $myview = 'shoppingcart_categories';
        $page_title = lang('prd_all');

        // Initialise variables
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_categories_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_categories_model->offset = $offset;

        $language_id = $this->session->userdata[$this->section_name]['site_lang_id'];
        $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $category_details = $this->shoppingcart_categories_model->get_category_detail_by_slugurl($language_id, $slug_url);

        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_model->offset = $offset;
        $product_lists = $this->shoppingcart_model->get_category_all_product($language_id, 0, $slug_url);

        $this->shoppingcart_model->_record_count_front = true;
        $total_record = $this->shoppingcart_model->get_category_all_product($language_id, 0, $slug_url);


        if (empty($category_details))
        {
            $this->theme->set_message(lang('category_not_found'), "error");
            redirect(site_url() . 'shoppingcart');
            exit;
        }

        $best_sellers = $this->shoppingcart_categories_model->getallcategories($language_id);

        $this->shoppingcart_categories_model->_record_count_front = true;
        $data['section_name'] = $this->section_name;
        $data['base_val'] = $this->base_val;
        $data['frontuserdata'] = $this->session->userdata['front'];
        $data['category_details'] = $category_details;
        $data['product_lists'] = $product_lists;
        $data['page_number'] = $this->page_number;
        $data['total_records'] = $total_record;
        $data['language_id'] = $language_id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['related_prddata'] = $related_prddata;
        $data['best_sellers'] = $best_sellers;

        if ($category_details[0]['scc']['meta_keywords'] != '')
            $this->theme->set_meta(array('name' => 'keywords', 'content' => $category_details[0]['scc']['meta_keywords']));

        if ($category_details[0]['scc']['meta_description'] != '')
            $this->theme->set_meta(array('name' => 'description', 'content' => $category_details[0]['scc']['meta_description']));

        $this->theme->set('page_title', $category_details[0]['scc']['title']);
        $this->theme->view($data, 'shoppingcart_categories');
    }

    /**
     * Displays a list of product data or product detail page.
     * @params string $slug_url : if then product detail page otherwise list of products
     */
    public function products($slug_url = NULL)
    {
        // Initialise variables
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_model->offset = $offset;

        $language_id = $this->session->userdata[$this->section_name]['site_lang_id'];
        $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $data = array();
        $data['section_name'] = $this->section_name;
        $data['base_val'] = $this->base_val;

        $records = $this->shoppingcart_model->getallproducts($language_id);
        $this->shoppingcart_model->_record_count_front = true;
        $total_record = $this->shoppingcart_model->getallproducts($language_id);

        $data['allrecords'] = $records;
        $data['frontuserdata'] = $this->session->userdata['front'];

        $related_prddata = $product_gallery_images = array();
        // Logic
        if ($slug_url == "")
        {
            $myview = 'shoppingcart_products';
            $page_title = lang('prd_all');
        }
        else
        {
            $product_record = $this->shoppingcart_model->get_product($language_id, $id = 0, $product_id = 0, $slug_url);
            if (count($product_record))
            {
                $related_prddata = $this->shoppingcart_relatedproducts_model->getfront_relatedproducts($language_id, $product_record['0']['scp']['product_id']);
                $data['single_record'] = $product_record['0'];
                $myview = 'shoppingcart_product_detail';
                $page_title = $product_record['0']['scp']['name'];

                $this->shoppingcart_model->add_product_visitor($product_record['0']['scp']['id'], $product_record['0']['scp']['visiters']);

                $product_gallery_images = $this->shoppingcart_images_model->get_product_gallery($product_record['0']['scp']['product_id']);
            }
            else
            {
                $data['records'] = $records;
                $myview = 'shoppingcart_products';
                $page_title = lang('prd_all');
            }
        }

        $data['page_number'] = $this->page_number;
        $data['total_records'] = $total_record;
        $data['language_id'] = $language_id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['related_prddata'] = $related_prddata;
        $data['product_gallery_images'] = $product_gallery_images;
        $data['per_row'] = 5;

        if (isset($data['single_record']['scp']['meta_keywords']) && $data['single_record']['scp']['meta_keywords'] != '')
            $this->theme->set_meta(array('name' => 'keywords', 'content' => $data['single_record']['scp']['meta_keywords']));

        if (isset($data['single_record']['scp']['meta_description']) && $data['single_record']['scp']['meta_description'] != '')
            $this->theme->set_meta(array('name' => 'description', 'content' => $data['single_record']['scp']['meta_description']));

        $this->theme->set('page_title', $page_title);
        $this->theme->view($data, $myview);
    }

    /**
     * Function to insert product into cart
     */
    public function addtocart()
    {
        // # Initialize coupon session
        $this->ini_coupon_session();
        // # EOF Initialize coupon session
        $post_data = $this->input->post();

        $post_data['product_id'] = trim(strip_tags($post_data['product_id']));
        $post_data['price'] = trim(strip_tags($post_data['price']));
        $post_data['pname'] = trim(strip_tags($post_data['pname']));
        $post_data['discount_price'] = trim(strip_tags($post_data['discount_price']));
        $post_data['currency_code'] = trim(strip_tags($post_data['currency_code']));
        $post_data['slug_url'] = trim(strip_tags($post_data['slug_url']));
        $post_data['product_image'] = trim(strip_tags($post_data['product_image']));

        $data_cart = array();
        $update_cart = 0;

        if (isset($post_data['product_submit']))
        {
            $cart_content = $this->cart->contents();
            if (count($cart_content))
            {
                $row_id = '';
                $qty = '';
                foreach ($cart_content as $items)
                {
                    if ($post_data['product_id'] == $items['id'])
                    {
                        $row_id = $items['rowid'];
                        $qty = $items['qty'];
                    }
                }
                if ($row_id != '' && $qty != '')
                {
                    $update_cart = 1;
                    $qty = $qty + 1;
                    $data_cart = array('rowid' => $row_id, 'qty' => $qty);
                }
            }
            if ($update_cart == 1 && count($data_cart))
            {
                $this->cart->update($data_cart);
            }
            else
            {
                $data_cart = array('id' => $post_data['product_id'], 'qty' => 1, 'price' => $post_data['price'], 'name' => $post_data['pname'], 'slug_url' => $post_data['slug_url'], 'product_image' => $post_data['product_image']);
                $this->cart->insert($data_cart);
            }

            redirect(base_url() . 'shoppingcart/cart');
        }
        else
        {
            redirect(base_url() . 'shoppingcart/products');
        }
    }

    /**
     * Function to cart data
     */
    public function cart()
    {
        $data['cart_data'] = $this->cart->contents();
        $data['cart_total'] = $this->cart->total();
        $data['front_user'] = $this->session->userdata['front'];
        // # Stock check
        $stocknotavail = $this->shoppingcart_model->checkproduct_stock();
        if ($stocknotavail == 1)
        {
            $this->theme->set_message(lang('product_out_of_stock'), "error");
        }
        $data['product_outofstock'] = $stocknotavail;
        // # EOF Stock check
        $this->theme->set('page_title', lang('cart'));
        $this->theme->view($data, 'shoppingcart_cart');
    }

    /**
     * Function to update cart record
     */
    public function updatecartitem()
    {
        if ($this->cart->total_items() == 0)
        {
            // # Initialize coupon session
            $this->ini_coupon_session();
            // # EOF Initialize coupon session
            redirect(site_url() . 'shoppingcart/cart');
        }

        $post_data = $this->input->post();

        if (isset($post_data))
        {
            $this->cart->update($post_data);
        }

        redirect(site_url() . 'shoppingcart/cart');
    }

    /**
     * Function to remove cart record
     */
    public function removecartitem($row_id)
    {
        if ($this->cart->total_items() == 0)
        {
            // # Initialize coupon session
            $this->ini_coupon_session();
            // # EOF Initialize coupon session
            redirect(site_url() . 'shoppingcart/cart');
        }

        $cart_item = array('rowid' => $row_id, 'qty' => '0');
        $this->cart->update($cart_item);

        redirect(site_url() . 'shoppingcart/cart');
    }

    /**
     * Function to empty cart
     */
    public function emptycart()
    {
        $coupon_data = array(
            'coupon_code' => '',
            'coupon_name' => '',
            'coupon_percentage' => '',
            'coupon_price' => '',
            'coupon_discount_price' => ''
        );

        $this->cart->destroy();
        $this->session->unset_userdata($coupon_data);

        redirect(site_url() . 'shoppingcart/cart');
    }

    /**
     * Function to check if user has already login
     */
    public function login()
    {
        if ($this->cart->total_items() == 0)
        {
            // # Initialize coupon session
            $this->ini_coupon_session();
            // # EOF Initialize coupon session
            redirect(site_url() . 'shoppingcart/cart');
        }
        $data = array();
        if (isset($this->session->userdata['front']['user_id']) && $this->session->userdata['front']['user_id'] != 0)
        {
            redirect(site_url() . 'shoppingcart/checkoutaddress');
            return false;
        }
        $this->theme->view($data, 'shoppingcart_login');
    }

    /**
     * Function for user login
     */
    public function userlogin()
    {
        if ($this->cart->total_items() == 0)
        {
            // ########## Initialize coupon session
            $this->ini_coupon_session();
            // ###### EOF Initialize coupon session
            redirect(site_url() . 'shoppingcart/cart');
        }
        if (isset($this->session->userdata['front']['user_id']))
        {
            redirect(site_url() . 'shoppingcart/checkoutaddress');
        }
        // Initializing
        $data = $this->input->post();
        if (!empty($data) && $this->input->post('Login'))
        {
            //form validation
            $email = trim(strip_tags($data['email_w']));
            $password = trim(strip_tags($data['password_w']));

            $this->form_validation->set_rules('email_w', lang('email'), 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('password_w', lang('password'), 'trim|required|xss_clean');

            if ($this->form_validation->run() == TRUE)
            {
                $result = $this->users_model->check_front_login($email, $password);

                if (!empty($result))
                {
                    if ($result[0]['u']['status'] == 1)
                    {
                        $data['user_id'] = $result[0]['u']['id'];
                        $data['role_id'] = $result[0]['u']['role_id'];
                        $data['email'] = $result[0]['u']['email'];
                        $data['firstname'] = $result[0]['u']['firstname'];
                        $data['lastname'] = $result[0]['u']['lastname'];
                        $data['logged_in'] = TRUE;
                        $this->allowed_permission_list($data['role_id']);
                        $this->session->set_custom_userdata($this->section_name, $data);
                        //Update last login entry
                        $this->users_model->update_last_login($result[0]['u']['id']);
                        redirect(site_url() . 'shoppingcart/checkoutaddress');
                    }
                    else
                    {
                        $this->theme->set_message(lang('inactive-account-msg'), "error");
                        redirect(site_url() . 'shoppingcart/login');
                    }
                }
                else
                {
                    $this->theme->set_message(lang('invalid_email_password'), "error");
                    redirect(site_url() . 'shoppingcart/login');
                }
            }
        }
        else
        {
            redirect(site_url() . 'shoppingcart/login');
        }
    }

    /**
     * Function checkoutaddress to show shipping and billing adress
     */
    public function checkoutaddress()
    {
        if ($this->cart->total_items() == 0)
        {
            // # Initialize coupon session
            $this->ini_coupon_session();
            redirect(site_url() . 'shoppingcart/cart');
        }

        if (!isset($this->session->userdata['front']['user_id']))
        {
            redirect(site_url() . 'shoppingcart/cart');
        }

        // # Stock check
        $coupon_discount_price = 0;
        $post_data = $this->input->post();
        $data = array();
        $stocknotavail = $this->shoppingcart_model->checkproduct_stock();

        if ($stocknotavail == 1)
        {
            $this->theme->set_message(lang('product_out_of_stock'), "error");
            redirect(site_url() . 'shoppingcart/cart');
        }
        // # EOF Stock check

        $data['cart_data'] = $this->cart->contents();
        $data['cart_total'] = $this->cart->total();
        $data['cart_gross_total'] = $this->cart->total();
        $data['front_user'] = $this->session->userdata['front'];

        // # Check for product Coupon
        if (isset($post_data['coupon_submit']))
        {
            if ($stocknotavail == 1)
            {
                $this->theme->set_message(lang('product_out_of_stock'), "error");
                redirect(site_url() . 'shoppingcart/cart');
            }

            $coupon_code = trim(strip_tags($this->input->post('coupon_code')));
            $check_coupon = $this->shoppingcart_model->checkcouponcode($coupon_code, $expired = 0);

            if (count($check_coupon))
            {
                $check_coupon_expire = $this->shoppingcart_model->checkcouponcode($coupon_code, $expired = 1);

                if (count($check_coupon_expire) == 0)
                {
                    $this->set_coupon_session_data();
                    $this->theme->set_message(lang('error_coupon_expire'), "error");
                    redirect(site_url() . 'shoppingcart/checkoutaddress');
                }

                if ($check_coupon['coupon_maxuse'] == 0)
                {
                    $this->set_coupon_session_data();
                    $this->theme->set_message(lang('error_coupon_max_use'), "error");
                    redirect(site_url() . 'shoppingcart/checkoutaddress');
                }

                $coupon_discount_price = $check_coupon['coupon_price'];

                if ($check_coupon['coupon_percentage'] != 0)
                {
                    $coupon_discount_price = $data['cart_total'] * ($check_coupon['coupon_price'] / 100);
                }

                $coupon_discount_price = number_format($coupon_discount_price, 2);

                if ($coupon_discount_price > $this->cart->total())
                {
                    $this->set_coupon_session_data();
                    $this->theme->set_message(lang('error_coupon_price_greater_than_total_price'), "error");
                    redirect(site_url() . 'shoppingcart/checkoutaddress');
                }

                $coupon_data = array(
                    'coupon_code' => $check_coupon['coupon_code'],
                    'coupon_name' => $check_coupon['coupon_name'],
                    'coupon_percentage' => $check_coupon['coupon_percentage'],
                    'coupon_price' => $check_coupon['coupon_price'],
                    'coupon_discount_price' => $coupon_discount_price
                );
            }
            else
            {
                $this->set_coupon_session_data();
                $this->theme->set_message(lang('error_invalid_coupon_code_msg'), "error");

                redirect(site_url() . 'shoppingcart/checkoutaddress');
            }

            $this->session->set_userdata($coupon_data);
            redirect(site_url() . 'shoppingcart/checkoutaddress');
        }
        else
        {
            if (isset($this->session->userdata['coupon_code']))
            {
                if ($this->session->userdata['coupon_percentage'] != 0)
                {
                    $coupon_discount_price = $data['cart_total'] * ($this->session->userdata['coupon_price'] / 100);

                    $this->session->userdata['coupon_discount_price'] = $coupon_discount_price;
                }
            }
        }
        // # EOF Check for product Coupon

        $mycoupon_session = array(
            'coupon_code' => $this->session->userdata['coupon_code'],
            'coupon_name' => $this->session->userdata['coupon_name'],
            'coupon_percentage' => $this->session->userdata['coupon_percentage'],
            'coupon_price' => $this->session->userdata['coupon_price'],
            'coupon_discount_price' => isset($this->session->userdata['coupon_discount_price']) ? $this->session->userdata['coupon_discount_price'] : $coupon_discount_price
        );

        $data['coupon_session'] = $mycoupon_session;

        $billaddress_data = $this->shoppingcart_model->get_billaddresses($this->session->userdata['front']['user_id'], 0);
        $shipaddress_data = $this->shoppingcart_model->get_shipaddresses($this->session->userdata['front']['user_id'], 0);

        if (count($billaddress_data) != 0)
        {
            $data['billaddress_data'] = $billaddress_data;
            $data['shipaddress_data'] = $shipaddress_data;
            $this->theme->view($data, 'shoppingcart_checkout');
        }
        else
        {
            redirect(site_url() . 'shoppingcart/add_checkoutaddress');
        }
    }

    /**
     * Action for add address of shipping and billing
     */
    public function add_checkoutaddress()
    {
        if ($this->cart->total_items() == 0)
        {
            // # Initialize coupon session
            $this->ini_coupon_session();
            // # EOF Initialize coupon session
            redirect(site_url() . 'shoppingcart/cart');
        }
        if (!isset($this->session->userdata['front']['user_id']))
        {
            redirect(site_url() . 'shoppingcart/cart');
        }
        $billaddress_data = $this->shoppingcart_model->get_billaddresses($this->session->userdata['front']['user_id'], 0);
        $shipaddress_data = $this->shoppingcart_model->get_shipaddresses($this->session->userdata['front']['user_id'], 0);
        $data = array();
        $data['user_logininfo'] = $this->session->userdata['front'];
        $data['billaddress_data'] = $billaddress_data;
        $data['shipaddress_data'] = $shipaddress_data;
        $this->theme->view($data, 'shoppingcart_shipbilladd');
    }

    /**
     * Function to add shipping and billing address
     */
    public function savecheckoutaddress($id = 0)
    {
        if ($this->cart->total_items() == 0)
        {
            // # Initialize coupon session
            $this->ini_coupon_session();
            // # EOF Initialize coupon session
            redirect(site_url() . 'shoppingcart/cart');
        }
        $post_data = $this->input->post();
        if (isset($this->session->userdata['front']['user_id']) && $this->session->userdata['front']['user_id'] != 0)
        {
            $user_id = $this->session->userdata['front']['user_id'];
            if (isset($post_data['add_chkaddress']))
            {
                $this->form_validation->set_rules('bill_fname', 'Street', 'required|xss_clean');
                $this->form_validation->set_rules('bill_lname', 'Country', 'required|xss_clean');
                $this->form_validation->set_rules('bill_street', 'Street', 'required|xss_clean');
                $this->form_validation->set_rules('bill_country', 'Country', 'required|xss_clean');
                $this->form_validation->set_rules('bill_state', 'State', 'required|xss_clean');
                $this->form_validation->set_rules('bill_city', 'City', 'required|xss_clean');
                $this->form_validation->set_rules('bill_postcode', 'Postcode', 'required|xss_clean');

                $this->form_validation->set_rules('ship_fname', 'Street', 'required|xss_clean');
                $this->form_validation->set_rules('ship_lname', 'Country', 'required|xss_clean');
                $this->form_validation->set_rules('ship_street', 'Street', 'required|xss_clean');
                $this->form_validation->set_rules('ship_country', 'Country', 'required|xss_clean');
                $this->form_validation->set_rules('ship_state', 'State', 'required|xss_clean');
                $this->form_validation->set_rules('ship_city', 'City', 'required|xss_clean');
                $this->form_validation->set_rules('ship_postcode', 'Postcode', 'required|xss_clean');

                if ($this->form_validation->run($this) == true)
                {
                    $user_id = intval($user_id);
                    $bill_fname = trim(strip_tags($this->input->post('bill_fname')));
                    $bill_lname = trim(strip_tags($this->input->post('bill_lname')));
                    $bill_address = trim(strip_tags($this->input->post('bill_address')));
                    $bill_street = trim($this->input->post('bill_street'));
                    $bill_country = trim(strip_tags($this->input->post('bill_country')));
                    $bill_state = trim(strip_tags($this->input->post('bill_state')));
                    $bill_city = trim(strip_tags($this->input->post('bill_city')));
                    $bill_postcode = trim(strip_tags($this->input->post('bill_postcode')));
                    $bill_default = 0;
                    $ins_bill_data = array(
                        'user_id' => $user_id,
                        'bill_fname' => $bill_fname,
                        'bill_lname' => $bill_lname,
                        'bill_address' => $bill_address,
                        'bill_street' => $bill_street,
                        'bill_country' => $bill_country,
                        'bill_state' => $bill_state,
                        'bill_city' => $bill_city,
                        'bill_postcode' => $bill_postcode,
                        'bill_default' => $bill_default
                    );
                    $this->shoppingcart_model->insert_billaddress($ins_bill_data);
                    $ship_fname = trim(strip_tags($this->input->post('ship_fname')));
                    $ship_lname = trim(strip_tags($this->input->post('ship_lname')));
                    $ship_address = trim(strip_tags($this->input->post('ship_address')));
                    $ship_street = trim($this->input->post('ship_street'));
                    $ship_country = trim(strip_tags($this->input->post('ship_country')));
                    $ship_state = trim(strip_tags($this->input->post('ship_state')));
                    $ship_city = trim(strip_tags($this->input->post('ship_city')));
                    $ship_postcode = trim(strip_tags($this->input->post('ship_postcode')));
                    $ship_default = 0;
                    $ins_ship_data = array(
                        'user_id' => $user_id,
                        'ship_fname' => $ship_fname,
                        'ship_lname' => $ship_lname,
                        'ship_address' => $ship_address,
                        'ship_street' => $ship_street,
                        'ship_country' => $ship_country,
                        'ship_state' => $ship_state,
                        'ship_city' => $ship_city,
                        'ship_postcode' => $ship_postcode,
                        'ship_default' => $ship_default
                    );
                    $this->shoppingcart_model->insert_shipaddress($ins_ship_data);
                    $this->theme->set_message(lang('msg_add_success'), 'success');
                    redirect(site_url() . 'shoppingcart/checkoutaddress');
                }
                else
                {
                    $message = $this->theme->message('Error Found', 'error');
                    if ($id != 0)
                    {
                        redirect(site_url() . 'shoppingcart/add_checkoutaddress/' . $id);
                    }
                    else
                    {
                        redirect(site_url() . 'shoppingcart/add_checkoutaddress');
                    }
                }
            }
        }
        else
        {
            $message = $this->theme->message(lang('login_required'), 'error');
            redirect(site_url() . 'shoppingcart/login');
        }
    }

    /**
     * Function for confirm order after successful transaction from paypal
     */
    public function order_confirm($order_id)
    {
        $token = $_REQUEST['token'];
        $PayerID = $_REQUEST['PayerID'];
        $TransactionId = '';
        $PaymentStatus = 'Pending';

        $order_record = $this->shoppingcart_model->get_order_detail_by_id($order_id);
        $ItemTotalPrice = $order_record['total_amount'];
        $PayPalCurrencyCode = $order_record['currency_code'];

        if(count($order_record) < 0)
        {
            switch (ENVIRONMENT)
            {
                case 'development':
                    $API_details = $this->shoppingcart_payments_model->get_paypal_login_details(0, 'SetExpressCheckout');
                    $PayPalMode = 'sandbox';
                    break;
                case 'testing':
                case 'production':
                    $API_details = $this->shoppingcart_payments_model->get_paypal_login_details(1, 'SetExpressCheckout');
                    $PayPalMode = '';
                    break;
            }

            if (!empty($API_details))
            {
                $API_UserName = urlencode($API_details[0]['scpm']['username']);
                $API_Password = urlencode($API_details[0]['scpm']['password']);
                $API_Signature = urlencode($API_details[0]['scpm']['key']);
            }
            else
            {
                $this->theme->set_message(lang('payment_method_not_available'), "error");
                redirect(site_url() . 'shoppingcart/checkoutaddress');
            }

            $padata = '&TOKEN=' . urlencode($token) .
                    '&PAYERID=' . urlencode($PayerID) .
                    '&PAYMENTACTION=' . urlencode("SALE") .
                    '&AMT=' . urlencode($ItemTotalPrice) .
                    '&CURRENCYCODE=' . urlencode($PayPalCurrencyCode);

            $httpParsedResponseAr = $this->shoppingcart_paypal->PaypalHttpPost('DoExpressCheckoutPayment', $padata, $API_UserName, $API_Password, $API_Signature, $PayPalMode);

            if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
            {
                $TransactionId = urldecode($httpParsedResponseAr["TRANSACTIONID"]);
                $PaymentStatus = $httpParsedResponseAr["PAYMENTSTATUS"];

                if ($PaymentStatus == 'Pending')
                {
                    $order_status = 0;
                }

                if ($PaymentStatus == 'Completed')
                {
                    $order_status = 4;
                }

                $order_data_array = array('order_status' => $order_status, 'payapl_transactionid' => $TransactionId);
                $this->shoppingcart_model->update_order_record($order_data_array, $order_record['id']);
                $this->theme->set_message(lang('payment_made_successfully'), "success");

                redirect(site_url() . 'shoppingcart/products');
            }
            else
            {
                $this->theme->set_message(urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]), "error");
                redirect(site_url() . 'shoppingcart/checkoutaddress');
            }
        }
        else
        {
            $this->theme->set_message(urldecode(lang('order_not_found')), "error");
            redirect(site_url() . 'shoppingcart/products');
        }
    }

    /**
     * Function for cancel_order for cancelling the order
     */
    public function order_cancel($order_id)
    {
        $order_record = $this->shoppingcart_model->get_order_detail_by_id($order_id);

        if (count($order_record))
        {
            $order_items = $this->shoppingcart_model->get_order_items_by_order_id($order_record['id']);

            if (count($order_items))
            {
                foreach ($order_items as $order_item)
                {
                    $this->shoppingcart_model->update_product_stock($order_item['product_id'], $order_item['product_qty'], $add = 1);
                }
            }

            $this->shoppingcart_model->update_coupon_maxuse($order_record['id'], $add = 1);
            $this->shoppingcart_model->delete_order_items($id = 0, $order_record['id']);
            $this->shoppingcart_model->delete_order_record($order_record['id']);
        }

        $this->theme->set_message(lang('order_cancelled'), "error");
        redirect(site_url() . 'shoppingcart/products');
    }

    /**
     * Function for checkout
     */
    public function checkout()
    {
        $post_data = $this->input->post();
        $API_details = array();

        if (!isset($this->session->userdata['front']['user_id']))
        {
            redirect(site_url() . 'shoppingcart/cart');
        }

        if (isset($post_data))
        {
            switch (ENVIRONMENT)
            {
                case 'development':
                    $API_details = $this->shoppingcart_payments_model->get_paypal_login_details(0, 'SetExpressCheckout');
                    $PayPalMode = 'sandbox';
                    break;
                case 'testing':
                case 'production':
                    $API_details = $this->shoppingcart_payments_model->get_paypal_login_details(1, 'SetExpressCheckout');
                    $PayPalMode = '';
                    break;
            }

            if (!empty($API_details))
            {
                $API_UserName = urlencode($API_details[0]['scpm']['username']);
                $API_Password = urlencode($API_details[0]['scpm']['password']);
                $API_Signature = urlencode($API_details[0]['scpm']['key']);
            }
            else
            {
                $this->theme->set_message(lang('payment_method_not_available'), "error");
                redirect(site_url() . 'shoppingcart/checkoutaddress');
            }
        }

        $stocknotavail = $this->shoppingcart_model->checkproduct_stock();

        if ($stocknotavail == 1)
        {
            $this->theme->set_message(lang('product_out_of_stock'), "error");
            redirect(site_url() . 'shoppingcart/cart');
        }

        if (isset($post_data))
        {
            $user_id = $this->session->userdata['front']['user_id'];
            $currency_code = CURRENCY_CODE;
            $bill_address_id = trim(strip_tags($this->input->post('chose_bill')));
            $ship_address_id = trim(strip_tags($this->input->post('chose_ship')));
            $coupon_code = trim(strip_tags($this->input->post('coupon_ocode')));
            $order_amount = trim(strip_tags($this->input->post('order_amount')));
            $coupon_discount = trim(strip_tags($this->input->post('coupon_discount')));
            $order_tax = trim(strip_tags($this->input->post('order_tax')));
            $total_amount = trim(strip_tags($this->input->post('total_amount')));
            $notes = trim(strip_tags($this->input->post('notes')));
            $order_items = $this->cart->total_items();
            $order_date = date('Y-m-d');
            $order_status = 0;

            $ins_order_data = array(
                'user_id' => $user_id,
                'currency_code' => $currency_code,
                'bill_address_id' => $bill_address_id,
                'ship_address_id' => $ship_address_id,
                'coupon_code' => $coupon_code,
                'order_amount' => $order_amount,
                'coupon_discount' => $coupon_discount,
                'order_tax' => $order_tax,
                'total_amount' => $total_amount,
                'order_items' => $order_items,
                'order_date' => $order_date,
                'order_status' => $order_status,
                'notes' => $notes
            );

            $ins_orderid = $this->shoppingcart_model->insert_orders($ins_order_data);

            if ($ins_orderid)
            {
                $order_record = $this->shoppingcart_model->get_order_detail_by_id($ins_orderid);
                $this->shoppingcart_model->insert_order_items($ins_orderid);

                $data_mail = array();
                $data_mail['email'] = $this->session->userdata['front']['email'];
                $data_mail['firstname'] = $this->session->userdata['front']['firstname'];
                $data_mail['lastname'] = $this->session->userdata['front']['lastname'];

                $record_list = $order_record;

                if (count($record_list))
                {
                    $billrecord_list_result = $this->shoppingcart_orders_model->get_billaddress_detail_by_id($record_list['bill_address_id']);
                    $shiprecord_list_result = $this->shoppingcart_orders_model->get_shipaddress_detail_by_id($record_list['ship_address_id']);
                    $record_orderitems = $this->shoppingcart_orders_model->get_order_items($record_list['id']);

                    if (count($billrecord_list_result))
                    {
                        $record_billaddress = $billrecord_list_result[0]['scba'];
                    }

                    if (count($shiprecord_list_result))
                    {
                        $record_shipaddress = $shiprecord_list_result[0]['scsa'];
                    }

                    if (count($record_orderitems))
                    {
                        $record_orderitems = $record_orderitems;
                    }

                    $data_mail['recorddata'] = $record_list;
                    $data_mail['billrecorddata'] = $record_billaddress;
                    $data_mail['shiprecorddata'] = $record_shipaddress;
                    $data_mail['orderitemsdata'] = $record_orderitems;
                }

                $this->load->library('mailer');
                $data_mail['is_adminmail'] = 0;
                $subject = 'Order Detail';

                // # Send mail to User
                $this->mailer->mail->SetFrom(SITE_FROM_EMAIL, SITE_NAME);
                $this->mailer->mail->IsHTML(true);
                $this->mailer->sendmail(
                        $data_mail['email'], $data_mail['firstname'] . " " . $data_mail['lastname'], $subject, $this->load->view('email_order', $data_mail, true)
                );
                // # EOF Send mail to User
                // # Send mail to admin
                $data_mail['is_adminmail'] = 1;
                $this->mailer->mail->SetFrom($data_mail['email'], SITE_NAME);
                $this->mailer->mail->IsHTML(true);
                $this->mailer->sendmail(
                        SITE_FROM_EMAIL, 'Administrator', $subject, $this->load->view('email_order', $data_mail, true)
                );
                // # EOF Send mail to admin

                $this->cart->destroy();
                $this->unset_coupon_session();

                $PayPalReturnURL = site_url() . 'shoppingcart/order_confirm/' . $ins_orderid;
                $PayPalCancelURL = site_url() . 'shoppingcart/order_cancel/' . $ins_orderid;
                $PayPalCurrencyCode = $order_record['currency_code'];
                $ItemName = 'Product Order#' . $record_list['id']; //Item Name
                $ItemPrice = $order_record['total_amount']; //Item Price
                $total_amount = $ItemPrice;

                // Data to be sent to paypal
                $padata = '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($ItemPrice) .
                        '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($ItemName) .
                        '&CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
                        '&PAYMENTACTION=Sale' .
                        '&ALLOWNOTE=1' .
                        '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
                        '&PAYMENTREQUEST_0_AMT=' . urlencode($total_amount) .
                        '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($total_amount) .
                        '&AMT=' . urlencode($total_amount) .
                        '&RETURNURL=' . urlencode($PayPalReturnURL) .
                        '&CANCELURL=' . urlencode($PayPalCancelURL);
                //We need to execute the "SetExpressCheckOut" method to obtain paypal token

                $httpParsedResponseAr = $this->shoppingcart_paypal->PaypalHttpPost('SetExpressCheckout', $padata, $API_UserName, $API_Password, $API_Signature, $PayPalMode);

                if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
                {
                    if ($PayPalMode == 'sandbox')
                    {
                        $paypalmode = '.sandbox';
                    }
                    else
                    {
                        $paypalmode = '';
                    }
                    //Redirect user to PayPal store with Token received.
                    $paypalurl = 'https://www' . $paypalmode . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $httpParsedResponseAr["TOKEN"] . '';
                    redirect($paypalurl);
                }
                else
                {
                    $this->theme->set_message(urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]), "error");
                    redirect(site_url() . 'shoppingcart/checkoutaddress');
                }
            }
            else
            {
                $this->cart->destroy();
                $this->unset_coupon_session();
                redirect(site_url() . 'shoppingcart/checkoutaddress');
            }

            $this->cart->destroy();
            $this->unset_coupon_session();

            redirect(site_url() . 'shoppingcart/order_confirm/' . $ins_orderid);
        }
    }

    /**
     * Function initialize coupon session if coupon session is not set
     */
    public function ini_coupon_session()
    {
        if (!isset($this->session->userdata['coupon_code']))
        {
            $coupon_data = array(
                'coupon_code' => '',
                'coupon_name' => '',
                'coupon_percentage' => '',
                'coupon_price' => '0'
            );
            $this->session->set_userdata($coupon_data);
        }
    }

    /**
     * Function unset coupon session if coupon session is set
     */
    public function unset_coupon_session()
    {
        if (isset($this->session->userdata['coupon_code']))
        {
            $coupon_data = array(
                'coupon_code' => '',
                'coupon_name' => '',
                'coupon_percentage' => '',
                'coupon_price' => '0'
            );
            $this->session->unset_userdata($coupon_data);
        }
    }

    /**
     * Function set coupon session data
     */
    public function set_coupon_session_data()
    {
        $coupon_data = array(
            'coupon_code' => '',
            'coupon_name' => '',
            'coupon_percentage' => '',
            'coupon_price' => '0'
        );
        $this->session->set_userdata($coupon_data);
    }

    /**
     * Function edit shipping or billing address
     * @params $address_type : billaddress or shipaddress
     * @params $id : billingaddress id or shippingaddress id
     */
    public function address($address_type, $id)
    {
        $post_data = $this->input->post();
        $id = intval($id);
        $user_id = $this->session->userdata['front']['user_id'];
        $data = $address_data = array();

        if (!isset($this->session->userdata['front']['user_id']))
        {
            redirect(site_url() . 'shoppingcart/cart');
        }

        if (($address_type != 'billaddress' && $address_type != 'shipaddress') || $id == 0)
        {
            $this->theme->set_message(lang('error_ship_bill_address'), "error");
            redirect(site_url() . 'shoppingcart/checkoutaddress');
        }

        if (isset($post_data['address_submit']))
        {
            $fname = trim(strip_tags($this->input->post('fname')));
            $lname = trim(strip_tags($this->input->post('lname')));
            $address = trim(strip_tags($this->input->post('address')));
            $street = trim(strip_tags($this->input->post('street')));
            $country = trim(strip_tags($this->input->post('country')));
            $state = trim(strip_tags($this->input->post('state')));
            $city = trim(strip_tags($this->input->post('city')));
            $postcode = trim(strip_tags($this->input->post('postcode')));

            $update_ship_bill_data = array(
                'fname' => $fname,
                'lname' => $lname,
                'address' => $address,
                'street' => $street,
                'country' => $country,
                'state' => $state,
                'city' => $city,
                'postcode' => $postcode
            );

            $this->shoppingcart_model->update_ship_bill_address($post_data['user_id'], $post_data['id'], $post_data['address_type'], $update_ship_bill_data);
            $this->theme->set_message(lang('msg_update_success'), "success");
            redirect(site_url() . 'shoppingcart/checkoutaddress');
        }

        if ($address_type == 'billaddress')
        {
            $bill_addressdata = $this->shoppingcart_model->check_ship_bill_address($user_id, $id, $address_type);

            if (count($bill_addressdata))
            {
                $address_data['id'] = $bill_addressdata['id'];
                $address_data['user_id'] = $bill_addressdata['user_id'];
                $address_data['fname'] = $bill_addressdata['bill_fname'];
                $address_data['lname'] = $bill_addressdata['bill_lname'];
                $address_data['address'] = $bill_addressdata['bill_address'];
                $address_data['street'] = $bill_addressdata['bill_street'];
                $address_data['country'] = $bill_addressdata['bill_country'];
                $address_data['state'] = $bill_addressdata['bill_state'];
                $address_data['city'] = $bill_addressdata['bill_city'];
                $address_data['postcode'] = $bill_addressdata['bill_postcode'];
            }
            else
            {
                $this->theme->set_message(lang('error_user_bill_address_update'), "error");
                redirect(site_url() . 'shoppingcart/checkoutaddress');
            }
        }
        if ($address_type == 'shipaddress')
        {
            $ship_addressdata = $this->shoppingcart_model->check_ship_bill_address($user_id, $id, $address_type);

            if (count($ship_addressdata))
            {
                $address_data['id'] = $ship_addressdata['id'];
                $address_data['user_id'] = $ship_addressdata['user_id'];
                $address_data['fname'] = $ship_addressdata['ship_fname'];
                $address_data['lname'] = $ship_addressdata['ship_lname'];
                $address_data['address'] = $ship_addressdata['ship_address'];
                $address_data['street'] = $ship_addressdata['ship_street'];
                $address_data['country'] = $ship_addressdata['ship_country'];
                $address_data['state'] = $ship_addressdata['ship_state'];
                $address_data['city'] = $ship_addressdata['ship_city'];
                $address_data['postcode'] = $ship_addressdata['ship_postcode'];
            }
            else
            {
                $this->theme->set_message(lang('error_user_ship_address_update'), "error");
                redirect(site_url() . 'shoppingcart/checkoutaddress');
            }
        }

        $data['address_data'] = $address_data;
        $data['address_type'] = $address_type;
        $this->theme->view($data, 'shoppingcart_shipbilledit');
    }

    /**
     * Function category_products get product list as per page number and category
     * @params $category_id : category id
     */
    public function category_products($category_id, $language_id)
    {
        $data = $related_prddata = array();
        $myview = 'shoppingcart_products';
        $page_title = lang('prd_all');

        $category_id = intval($category_id);
        $language_id = intval($language_id);

        // Initialise variables
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_model->offset = $offset;

        $records = $this->shoppingcart_model->get_category_all_product($language_id, $category_id, '');
        $this->shoppingcart_model->_record_count_front = true;
        $total_record = $this->shoppingcart_model->get_category_all_product($language_id, $category_id, '');

        $data['section_name'] = $this->section_name;
        $data['base_val'] = $this->base_val;
        $data['allrecords'] = $records;
        $data['total_records'] = $total_record;
        $data['frontuserdata'] = $this->session->userdata['front'];
        $data['page_number'] = $this->page_number;
        $data['language_code'] = $this->session->userdata[$this->section_name]['site_lang_code'];
        $data['per_row'] = 3;
        $data['post_url'] = base_url() . "/shoppingcart/category_products/" . $category_id . "/" . $this->session->userdata[$this->section_name]['site_lang_code'];

        $this->theme->view($data, 'shoppingcart_products');
    }

    /**
    * In this page display user all orders history
    */
    public function orders()
    {
        if(!isset($this->session->userdata['front']['user_id']))
        {
            redirect(site_url() . 'users/login');
        }

        $language_id = $this->session->userdata[$this->section_name]['site_lang_id'];
        $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];

        $order_lists = $this->shoppingcart_orders_model->get_user_all_orders();

        $data['section_name'] = $this->section_name;
        $data['language_id'] = $language_id;
        $data['base_val'] = $this->base_val;
        $data['order_lists'] = $order_lists;
        $data['frontuserdata'] = $this->session->userdata['front'];

        $this->theme->set('page_title', 'order_history');
        $this->theme->view($data, 'shoppingcart_order_history');
    }

    /**
    * order_details
    * In this page display user orders detais
    * @params $order_id : order id
    */
    public function order_details($order_id)
    {
        if(!isset($this->session->userdata['front']['user_id']))
        {
            redirect(site_url() . 'users/login');
        }

        $order_id = intval($order_id);
        $language_id = $this->session->userdata[$this->section_name]['site_lang_id'];
        $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];

        $order_details = $this->shoppingcart_orders_model->get_user_order_detail_by_id($order_id);

        $data['section_name'] = $this->section_name;
        $data['language_id'] = $language_id;
        $data['base_val'] = $this->base_val;
        $data['order_details'] = $order_details;
        $data['frontuserdata'] = $this->session->userdata['front'];

        $this->theme->set('page_title', 'order_history');
        $this->theme->view($data, 'shoppingcart_order_details');
    }
}
?>