<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  shoppingcart Admin Controller
 *
 *  To perform admin shoppingcart related tasks
 * 
 * @package CIDemo Application
 * @subpackage Shoppingcart  
 * @copyright	(c) 2013, TatvaSoft
 * @author Bhavesh Patel <bhavesh.patel@sparsh.com>
 */
class Shoppingcart_admin extends Base_Admin_Controller
{
    /**
     * 	Create an instance
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->access_control($this->access_rules());
        // Load required helpers
        $this->load->helper('url');
        $this->load->helper('ckeditor');
        // Load models
        $this->load->model('default_model');
        $this->load->model('shoppingcart/shoppingcart_categories_model');
        $this->load->model('shoppingcart/shoppingcart_coupons_model');
        $this->load->model('shoppingcart/shoppingcart_orders_model');
        $this->load->model('shoppingcart/shoppingcart_relatedproducts_model');
        $this->load->model('shoppingcart/shoppingcart_images_model');
        $this->load->model('shoppingcart/shoppingcart_payments_model');
        $this->load->model('urls/urls_model');
        // Load language
        $this->lang->load('shoppingcart');
        $this->breadcrumb->add('Shoppingcart Management', base_url() . get_current_section($this) . '/shoppingcart');
    }

    /**
     * function accessRules to check page access     
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('action', 'index', 'ajax_index', 'ajax_action', 'delete',
                    'coupons', 'ajax_coupons', 'action_coupon', 'ajax_action_coupon', 'delete_coupon',
                    'images', 'ajax_images', 'action_image', 'ajax_action_image', 'delete_product_image',
                    'orders', 'ajax_orders', 'action_order', 'ajax_action_order',
                    'view', 'ajax_control_panel', 'categories', 'ajax_category_index', 'action_category', 'ajax_action_category', 'delete_category', 'products', 'ajax_products_index',
                    'payments', 'ajax_payments', 'ajax_payments_index', 'action_payments', 'delete_payments'),
                'users' => array('@'),
            )
        );
    }

    /**
     * Default Method: index
     * Action to display control panel.
     * @params string $language_code
     */
    public function index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        if ($language_code == '')
        {
            $language_code = $this->session->userdata[get_current_section($this)]['site_lang_code'];
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        //Set page title
        $this->theme->set('page_title', lang('control_panel'));

        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        $this->theme->view($data);
    }

    /**
     * Action to load shopping cart control panel
     * @params string $language_code
     */
    public function ajax_control_panel($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[get_current_section($this)]['site_lang_code'];
        }
        // Initialise variables
        $data = array();
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_model->offset = $offset;

        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        $total_products = $this->shoppingcart_model->get_total_product($language_id);
        $total_categories = $this->shoppingcart_categories_model->get_total_categories($language_id);
        $this->shoppingcart_model->_record_count = true;

        //get order information   0-Pending,1-Cancelled,2-Processing,3-Dispatched,4-Completed
        $today_pending_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'today', 0);
        $today_cancelled_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'today', 1);
        $today_processing_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'today', 2);
        $today_dispatched_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'today', 3);
        $today_completed_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'today', 4);
        $today_order_total_cost_details = $this->shoppingcart_orders_model->get_current_month_order_total_details($language_id, 'today', 4);

        $week_pending_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'week', 0);
        $week_cancelled_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'week', 1);
        $week_processing_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'week', 2);
        $week_dispatched_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'week', 3);
        $week_completed_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'week', 4);
        $week_order_total_cost_details = $this->shoppingcart_orders_model->get_current_month_order_total_details($language_id, 'week', 4);

        $current_pending_month_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'month', 0);
        $current_month_cancelled_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'month', 1);
        $current_month_processing_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'month', 2);
        $current_month_dispatched_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'month', 3);
        $current_month_completed_order_details = $this->shoppingcart_orders_model->get_current_month_order_details($language_id, 'month', 4);
        $current_month_order_total_cost_details = $this->shoppingcart_orders_model->get_current_month_order_total_details($language_id, 'month', 4);

        //best seller 10 products
        $best_seller_products = $this->shoppingcart_orders_model->get_best_seller_items($language_id, 1);

        //most viewed 10 products
        $most_viewed_products = $this->shoppingcart_model->get_most_viewed_products($language_id, 1);

        $data = array(
            'today_pending_order_details' => $today_pending_order_details,
            'today_cancelled_order_details' => $today_cancelled_order_details,
            'today_processing_order_details' => $today_processing_order_details,
            'today_dispatched_order_details' => $today_dispatched_order_details,
            'today_completed_order_details' => $today_completed_order_details,
            'today_order_total_cost_details' => $today_order_total_cost_details,
            'week_pending_order_details' => $week_pending_order_details,
            'week_cancelled_order_details' => $week_cancelled_order_details,
            'week_processing_order_details' => $week_processing_order_details,
            'week_dispatched_order_details' => $week_dispatched_order_details,
            'week_completed_order_details' => $week_completed_order_details,
            'week_order_total_cost_details' => $week_order_total_cost_details,
            'current_pending_month_order_details' => $current_pending_month_order_details,
            'current_month_cancelled_order_details' => $current_month_cancelled_order_details,
            'current_month_processing_order_details' => $current_month_processing_order_details,
            'current_month_dispatched_order_details' => $current_month_dispatched_order_details,
            'current_month_completed_order_details' => $current_month_completed_order_details,
            'current_month_order_total_cost_details' => $current_month_order_total_cost_details,
            'best_seller_products' => $best_seller_products,
            'most_viewed_products' => $most_viewed_products,
            'total_products' => $total_products,
            'total_categories' => $total_categories,
            'language_code' => $language_code
        );

        //load view and pass data array to view file
        $this->theme->set('page_title', lang('control_panel'));
        $this->theme->view($data, 'admin_control_panel');
    }

    /**
     * Action to load list of products based on language passed or from default language
     * @params string $language_code
     */
    public function ajax_index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[get_current_section($this)]['site_lang_code'];
        }
        // Initialise variables
        $data = array();
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_model->offset = $offset;
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_term']))
            {
                $this->shoppingcart_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->shoppingcart_model->sort_by = $data['sort_by'];
                $this->shoppingcart_model->sort_order = $data['sort_order'];
            }
            if (isset($data['type']) && $data['type'] == 'delete')
            {
                $this->shoppingcart_model->delete_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                $this->shoppingcart_model->active_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                $this->shoppingcart_model->inactive_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                $this->shoppingcart_model->active_all_records();
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                $this->shoppingcart_model->inactive_all_records();
            }
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $list = $this->shoppingcart_model->get_all_productsdata($language_id);
        $this->shoppingcart_model->_record_count = true;
        $total_records = $this->shoppingcart_model->get_all_productsdata($language_id);
        $data = array(
            'list' => $list,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->shoppingcart_model->search_term,
            'sort_by' => $this->shoppingcart_model->sort_by,
            'sort_order' => $this->shoppingcart_model->sort_order
        );
        //load view and pass data array to view file
        $this->theme->set('page_title', lang('prd_title'));
        // $this->breadcrumb->add(lang('prd-title'));
        $this->theme->view($data, 'admin_products');
    }

    /**
     * action to add/edit product page
     * @params string $action : add or edit
     * @params string $language_code
     * @params string $id : if in edit mode
     */
    function action($action, $language_code = '', $id = 0)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $default_lang = 0;
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $message = '';

        //get default lang
        $default_language = $this->languages_model->get_default_language();
        if ($default_language[0]['l']['id'] == $language_id)
        {
            $default_lang = 1;
        }

        if ($this->input->post('submit'))
        {
            $name = trim(strip_tags($this->input->post('name')));
            $slug_url = trim(strip_tags($this->input->post('slug_url')));
            $description = trim($this->input->post('description'));
            $status = trim(strip_tags($this->input->post('status')));
            $price = trim(strip_tags($this->input->post('price')));
            $featured = trim(strip_tags($this->input->post('featured')));
            $category_id = trim(strip_tags($this->input->post('category_id')));
            $meta_keywords = trim(strip_tags($this->input->post('meta_keywords')));
            $meta_description = trim(strip_tags($this->input->post('meta_description')));
            $product_image = '';
            $old_product_image = trim(strip_tags($this->input->post('old_product_image')));
            $discount_price = trim(strip_tags($this->input->post('discount_price')));
            $currency_code = trim(strip_tags($this->input->post('currency_code')));
            $stock = trim(strip_tags($this->input->post('stock')));
            $related_prdid = array();

            if ($this->input->post('related_prdid'))
            {
                $related_prdid = $this->input->post('related_prdid');
            }
        }

        if ($action == 'add' || $action == 'edit')
        {
            $result = array();
            if ($language_code == '')
            {
                $language_code = $this->session->userdata[get_current_section($this)]['site_lang_code'];
            }

            // Logic
            $language_detail = $this->languages_model->get_languages_by_code($language_code);
            $language_id = $language_detail[0]['l']['id'];

            if ($message == '')
            {
                if (isset($_FILES['product_image']['name']) && $_FILES['product_image']['name'] != '' && $_FILES['product_image']['tmp_name'] != '' && isset($_FILES['product_image']['tmp_name']) && $this->input->post('submit'))
                {
                    list($width, $height, $type, $attr) = getimagesize($_FILES['product_image']['tmp_name']);

                    if ($width < 240 || $height < 320)
                    {
                        $message = lang('msg_add_image_fail');
                    }
                }

                if ($this->input->post('submit') && $message == '')
                {
                    //Validation Check
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
                    $this->form_validation->set_rules('slug_url', 'Slug URL', 'required|callback_check_unique_slug_url|xss_clean');

                    if (intval($this->input->post('default_language')) == 1)
                    {
                        $this->form_validation->set_rules('price', 'Price', 'required');
                        $this->form_validation->set_rules('stock', 'stock', 'required|numeric');
                    }

                    /* -------------------------------------------------------------------------------------------------------------------- */
                    if ($this->form_validation->run($this) == true && $message == '')
                    {
                        $data = $this->shoppingcart_model->is_exist_product($id, $language_id);
                        $this->shoppingcart_model->name = $name;
                        $this->shoppingcart_model->slug_url = $slug_url;
                        $this->shoppingcart_model->description = $description;
                        $this->shoppingcart_model->meta_keywords = $meta_keywords;
                        $this->shoppingcart_model->meta_description = $meta_description;

                        if (intval($this->input->post('default_language')) == 1)
                        {
                            $this->shoppingcart_model->status = $status;
                            $this->shoppingcart_model->price = $price;
                            $this->shoppingcart_model->featured = $featured;
                            $this->shoppingcart_model->category_id = $category_id;
                        }

                        if (isset($_FILES['product_image']['name']) && $_FILES['product_image']['name'] != '')
                        {
                            $product_image = $this->image_upload_resize();
                            $this->shoppingcart_model->product_image = $product_image;

                            if ($product_image != $old_product_image && $old_product_image != '')
                            {
                                $this->delete_images('', $old_product_image);
                            }
                        }

                        $this->shoppingcart_model->discount_price = $discount_price;
                        $this->shoppingcart_model->currency_code = $currency_code;
                        $this->shoppingcart_model->stock = $stock;
                        $this->shoppingcart_model->rprd_arry = $related_prdid;

                        if (count($data) > 0)
                        {
                            $this->shoppingcart_model->update($id, $language_id);

                            //save same image name for multi lang
                            $language_lists = array();
                            $language_lists = $this->languages_model->get_languages(0, 1);

                            if (!empty($language_lists) && count($language_lists) > 1)
                            {
                                foreach ($language_lists as $key => $val)
                                {
                                    $alias = end(array_keys($val));

                                    if ($val[$alias]['id'] != $language_id)
                                    {
                                        $this->shoppingcart_model->update_product_image($id, $val[$alias]['id']);

                                        if (intval($this->input->post('default_language')) == 1)
                                        {
                                            $this->shoppingcart_model->active_inactive_product_for_all_lang($id, $val[$alias]['id'], $status);
                                        }
                                    }
                                }
                            }
                            $this->theme->set_message(lang('msg_update_success'), 'success');
                        }
                        else
                        {
                            if ($id == '0' || $id == '')
                            {
                                $last_id = $this->shoppingcart_model->get_last_id();
                                $id = $last_id + 1;
                            }

                            $language_lists = array();
                            $language_lists = $this->languages_model->get_languages(0, 1);

                            if (!empty($language_lists) && count($language_lists) > 1)
                            {
                                foreach ($language_lists as $key => $val)
                                {
                                    $alias = end(array_keys($val));

                                    if (count($this->shoppingcart_model->is_exist($id, $val[$alias]['id'])) == 0)
                                    {
                                        $this->shoppingcart_model->insert($id, $val[$alias]['id']);
                                    }
                                }
                            }
                            else
                            {
                                $this->shoppingcart_model->insert($id, $language_id);
                            }

                            $this->theme->set_message(lang('msg_add_success'), 'success');
                        }

                        if ($id != 0 && $id != '')
                        {
                            $prd_id = $id;
                            $related_products = $this->shoppingcart_relatedproducts_model->check_relatedproduct($language_id, $prd_id, $rprd_id = 0);

                            if (count($related_products))
                            {
                                $this->shoppingcart_relatedproducts_model->delete_relatedproduct($r_id = 0, $prd_id, $related_prdid = 0, $language_id);
                            }

                            if (count($this->shoppingcart_model->rprd_arry))
                            {
                                foreach ($this->shoppingcart_model->rprd_arry as $related_productid)
                                {
                                    $this->shoppingcart_relatedproducts_model->insert_relatedproducts($prd_id, $related_productid, $language_id);
                                }
                            }
                        }

                        $this->config_model->change_slug_url_management($this->input->post('old_slug_url'), $this->input->post('slug_url'), 'shoppingcart', $id, 'index/' . $this->input->post('slug_url'), $this->input->post('status'));
                        $this->load->module('urls/urls_admin');
                        $this->urls_admin->generate_custom_url();
                        redirect(get_current_section($this) . '/shoppingcart/products/' . $language_detail[0]['l']['language_code']);
                    }
                }
            }

            if (!$this->input->post() && $message == '')
            {
                if (isset($id) && $id != '' && $id != '0')
                {
                    $result = $this->shoppingcart_model->get_detail_by_id($id, $language_detail[0]['l']['id']);
                }
            }
            else
            {
                $result[0]['products'] = $this->input->post();
            }

            $language_list = $this->languages_model->get_languages(); // get list of languages
            // Breadcrumb settings
            if ($action == "add")
            {
                $this->theme->set('page_title', lang('add_product'));
                $this->breadcrumb->add(lang('add_product'));
                $id = '';
            }
            elseif ($action == "edit")
            {
                $this->theme->set('page_title', lang('edit_product'));
                $this->breadcrumb->add(lang('edit_product'));
            }

            $rproduct_data = array();
            $allprd_for_related = $this->shoppingcart_relatedproducts_model->allproductsto_related_combo($language_id, $product_id = 0, $id);

            if (count($allprd_for_related))
            {
                foreach ($allprd_for_related as $related_product)
                {
                    $rproduct_data[$related_product['scp']['id']] = $related_product['scp']['name'];
                }
            }

            $rproduct_seldata = array();

            if ($id != 0)
            {
                $prd_id = $id;
                $related_product_data = $this->shoppingcart_relatedproducts_model->check_relatedproduct($language_id, $prd_id, $rprd_id = 0);
                foreach ($related_product_data as $rproduct_rec)
                {
                    $rproduct_seldata[] = $rproduct_rec['scpr']['related_product_id'];
                }
            }

            //Get all categories
            $category_array = $this->get_n_categories_option(0, $language_id, '');
            $category_data = array();
            $category_data = explode("|", $category_array);


            //Variable assignments to view
            $data = array();
            $data['action'] = $action;
            $data['id'] = $id;
            $data['category_data'] = $category_data;
            $data['language_code'] = $language_detail[0]['l']['language_code'];
            $data['language_name'] = $language_detail[0]['l']['language_name'];
            $data['language_id'] = $language_id;
            $data['csrf_token'] = $this->security->get_csrf_token_name();
            $data['csrf_hash'] = $this->security->get_csrf_hash();
            $data['languages'] = $language_list;
            $data['result'] = $result;
            //$data['cat_dropdown'] = $category_dropdown;
            $data['rprd_multidropdown'] = $rproduct_data;
            $data['rprd_selectdata'] = $rproduct_seldata;
            $data['default_language'] = $default_lang;
            $data['message'] = $message;

            $data['content'] = $this->load->view('admin_product_add', $data, TRUE);
            $this->theme->view($data, 'admin_action');
        }
        else
        {
            $this->theme->set_message(lang('permission_not_allowed'), 'error');
            redirect(get_current_section($this) . '/users');
        }
    }

    /**
     * action to get_n_categories_option fetch all parent and child category with parent child ordering
     * @params string $parent : category ID
     * @params string $language_id : language ID
     * @params string $child_level : pass '-' for display child category
     */
    function get_n_categories_option($parent = 0, $language_id, $child_level = '')
    {
        $image_path = site_url() . 'assets/uploads/shoppingcart/categories/';
        $html = '';
        $categories = $this->shoppingcart_categories_model->getallcategories($language_id, $parent);

        if (count($categories) > 0)
        {
            foreach ($categories as $category)
            {
                if ($category['scc']['status'] == 1)
                {
                    $current_id = $category['scc']['category_id'];
                    $html .= $current_id . '=>' . $child_level . ' ' . ucfirst($category['scc']['title']) . '|';

                    if (count($this->shoppingcart_categories_model->getallcategories($language_id, $current_id)) > 0)
                    {
                        $html .= $this->get_n_categories_option($current_id, $language_id, $child_level . '-');
                    }
                }
            }
        }

        return $html;
    }

    /**
     * action to add/edit Product page load form from ajax based on language
     * @params string $action : add or edit
     * @params string $language_code
     * @params string $id : if in edit mode
     * @params string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_action($action, $language_code = '', $id = 0, $ajax_load = 1)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $ajax_load = intval($ajax_load);
        $default_lang = 0;
        $message = '';
        //Initialize
        $data = array();
        $list = array();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[get_current_section($this)]['site_lang_code'];
        }
        //logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        //get default lang
        $default_language = $this->languages_model->get_default_language();
        if ($default_language[0]['l']['id'] == $language_id)
        {
            $default_lang = 1;
        }

        $rproduct_data = array();
        $rproduct_seldata = array();

        if (isset($id) && $id != '' && $id != '0')
        {
            $list = $this->shoppingcart_model->get_detail_by_id($id, $language_detail[0]['l']['id']);
            $allprd_for_related = $this->shoppingcart_relatedproducts_model->allproductsto_related_combo($language_id, $product_id = 0, $id);

            if (count($allprd_for_related))
            {
                foreach ($allprd_for_related as $related_product)
                {
                    $rproduct_data[$related_product['scp']['id']] = $related_product['scp']['name'];
                }
            }

            if ($id != 0)
            {
                $prd_id = $id;
                $related_product_data = $this->shoppingcart_relatedproducts_model->check_relatedproduct($language_id, $prd_id, $rprd_id = 0);

                foreach ($related_product_data as $rproduct_rec)
                {
                    $rproduct_seldata[] = $rproduct_rec['scpr']['related_product_id'];
                }
            }
        }

        $category_array = $this->get_n_categories_option(0, $language_id, '');
        $category_data = array();
        $category_data = explode("|", $category_array);

        //Variable assignments to view
        // $data['cat_dropdown'] = $category_dropdown;
        $data['rprd_multidropdown'] = $rproduct_data;
        $data['rprd_selectdata'] = $rproduct_seldata;
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['result'] = $list;
        $data['category_data'] = $category_data;
        $data['default_language'] = $default_lang;
        $data['message'] = $message;

        if ($ajax_load == '1')
        {
            echo $this->load->view('admin_product_add', $data);
        }
        else
        {
            return $this->load->view('admin_product_add', $data);
        }
    }

    /**
     * Function delete the product record and related url management record
     */
    function delete()
    {
        //Initialise
        $id = $this->input->post('id');
        $slug_url = $this->input->post('slug_url');
        //Type casting
        $id = intval($id);
        $slug_url = trim(strip_tags($slug_url));
        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $data['list'] = $this->shoppingcart_model->delete_product($id);
            if ($slug_url != '')
            {
                $this->urls_model->delete_url_by_slug($slug_url);
            }
            $message = $this->theme->message(lang('delete_success'), 'success');
        }
        else
        {
            $message = $this->theme->message(lang('invalid_id_msg'), 'error');
        }
        echo $message;
    }

    /**
     * Function check_unique_slug_url to check unique slug url
     */
    public function check_unique_slug_url()
    {
        //variable assignement
        $id = '';
        //Get url management id
        if ($this->input->post('old_slug_url') != '')
        {
            $url_detail = $this->urls_model->get_url_management_id_by_slug($this->input->post('old_slug_url'));
            if (count($url_detail) > 0)
            {
                $id = $url_detail[0]['um']['id'];
            }
        }

        $slug_url = $this->input->post('slug_url');
        $result = $this->urls_model->check_unique_slug($slug_url, $id);
        if (count($result) > 0)
        {
            $this->form_validation->set_message('check_unique_slug_url', lang('msg_alvailable_slug_url'));
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Function image_upload_resize to create thumbnail of Product Image in two different size (75*15) and (175*150)
     */
    function image_upload_resize($upload_path = '', $source_image = '', $product_image = '', $image_name = '')
    {
        $image_sizes = array();
        $image_path = 'assets/uploads/shoppingcart';

        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name'] = $image_name = date('YmdHis');

        //configuration for file upload
        if (empty($upload_path))
        {
            $config['upload_path'] = "assets/uploads/shoppingcart/main";
        }
        else
        {
            $config['upload_path'] = "assets/uploads/shoppingcart/" . $upload_path . "/main";

            if (!file_exists(FCPATH . 'assets/uploads/shoppingcart/' . $upload_path))
            {
                mkdir(FCPATH . 'assets/uploads/shoppingcart/' . $upload_path, 0755, TRUE);
            }

            if (!file_exists(FCPATH . $config['upload_path']))
            {
                mkdir(FCPATH . $config['upload_path'], 0755, TRUE);
            }

            if (!file_exists(FCPATH . 'assets/uploads/shoppingcart/' . $upload_path . '/thumbs'))
            {
                mkdir(FCPATH . 'assets/uploads/shoppingcart/' . $upload_path . '/thumbs', 0755, TRUE);
            }

            if (!file_exists(FCPATH . 'assets/uploads/shoppingcart/' . $upload_path . '/medium'))
            {
                mkdir(FCPATH . 'assets/uploads/shoppingcart/' . $upload_path . '/medium', 0755, TRUE);
            }

            $image_path = 'assets/uploads/shoppingcart/' . $upload_path;
        }

        if (empty($product_image))
        {
            $product_image = 'product_image';
        }
        else
        {
            $product_image = $product_image;
        }

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($product_image))
        {
            $error = array('error' => $this->upload->display_errors());
            return $this->upload->display_errors();
        }
        else
        {
            $uploaded_file_details = $this->upload->data();

            $config['image_library'] = 'gd2';
            $config['maintain_ratio'] = FALSE;
            $image_sizes[0]['width'] = 48;
            $image_sizes[0]['height'] = 64;
            $image_sizes[0]['image_path'] = $image_path . '/thumbs/' . $uploaded_file_details['file_name'];

            $image_sizes[1]['width'] = 240;
            $image_sizes[1]['height'] = 320;
            $image_sizes[1]['image_path'] = $image_path . '/medium/' . $uploaded_file_details['file_name'];



            if (empty($source_image))
            {
                $config['source_image'] = 'assets/uploads/shoppingcart/main/' . $uploaded_file_details['file_name'];
            }
            else
            {
                $config['source_image'] = 'assets/uploads/shoppingcart/' . $source_image . '/main/' . $uploaded_file_details['file_name'];
            }

            // resize image
            $this->load->library('image_lib');
            $config['image_library'] = 'gd2';

            foreach ($image_sizes as $image_size)
            {
                $config['width'] = $image_size['width'];
                $config['height'] = $image_size['height'];
                $config['new_image'] = $image_size['image_path'];

                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                if (!$this->image_lib->resize())
                {
                    return $this->image_lib->display_errors();
                }
            }

            return $uploaded_file_details['file_name'];
        }
    }

    /**
     * Action to display list of coupon page
     */
    public function coupons()
    {
        //Set page title
        $this->theme->set('page_title', lang('coupon_title'));
        // Breadcrumb settings
        $this->breadcrumb->add(lang('coupons_title'));
        //Variable assignments to view
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->theme->view($data, 'admin_index_coupons');
    }

    /**
     * Action to load list of coupons
     */
    public function ajax_coupons()
    {
        // Initialise variables
        $data = array();
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_coupons_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_coupons_model->offset = $offset;
        //Logic
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_term']))
            {
                $this->shoppingcart_coupons_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->shoppingcart_coupons_model->sort_by = $data['sort_by'];
                $this->shoppingcart_coupons_model->sort_order = $data['sort_order'];
            }
            if (isset($data['type']) && $data['type'] == 'delete')
            {
                $this->shoppingcart_coupons_model->delete_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                $this->shoppingcart_coupons_model->active_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                $this->shoppingcart_coupons_model->inactive_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                $this->shoppingcart_coupons_model->active_all_records();
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                $this->shoppingcart_coupons_model->inactive_all_records();
            }
        }
        $allcoupons = $this->shoppingcart_coupons_model->get_all_coupons();
        $this->shoppingcart_coupons_model->_record_count = true;
        $total_records = $this->shoppingcart_coupons_model->get_all_coupons();
        // Set page title
        $this->theme->set('page_title', lang('coupon_title'));
        //Variable assignments to view
        $data = array(
            'allcoupons' => $allcoupons,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->shoppingcart_coupons_model->search_term,
            'sort_by' => $this->shoppingcart_coupons_model->sort_by,
            'sort_order' => $this->shoppingcart_coupons_model->sort_order
        );
        $this->theme->view($data, 'admin_coupons');
    }

    /**
     * action to add/edit coupon page
     * @params string $action : add or edit
     * @params string $id : if in edit mode
     */
    function action_coupon($action, $id = 0)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $id = intval($id);
        //Initialize
        $record_list = array();
        $record_list_result = array();
        // Logic
        if ($this->input->post('mysubmit'))
        {
            //Validation Check
            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_name', 'Coupon Name', 'required|xss_clean');
            $this->form_validation->set_rules('coupon_price', 'Coupon Price', 'required|number|xss_clean');
            $this->form_validation->set_rules('coupon_maxuse', 'Coupon Max use', 'required|integer|xss_clean');
            // $this->form_validation->set_rules('slug_url', 'Slug URL', 'required|callback_check_unique_slug_url|xss_clean');
            if ($this->form_validation->run($this) == true)
            {
                $post_var = $this->input->post();
                $coupon_name = trim(strip_tags($this->input->post('coupon_name')));
                $coupon_code = trim(strip_tags($this->input->post('coupon_code')));
                $coupon_price = trim(strip_tags($this->input->post('coupon_price')));
                $coupon_percentage = trim($this->input->post('coupon_percentage'));
                $coupon_maxuse = trim(strip_tags($this->input->post('coupon_maxuse')));
                $coupon_sdate = trim($this->input->post('coupon_sdate'));
                $coupon_edate = trim(strip_tags($this->input->post('coupon_edate')));
                $status = trim(strip_tags($this->input->post('status')));
                if ($coupon_code == "")
                {
                    $characters = 'A12B1C2D2E3F3G4H3I5J5K6L6M7N7O8P8Q9R9S0T1U2V3W4X5Y6Z';
                    $random_string = '';
                    for ($i = 0; $i < 8; $i++)
                    {
                        $random_string .= $characters[rand(0, strlen($characters) - 1)];
                    }
                    $coupon_code = $random_string;
                }
                $coupon_ins_update_data = array(
                    'coupon_name' => $coupon_name,
                    'coupon_code' => $coupon_code,
                    'coupon_price' => $coupon_price,
                    'coupon_percentage' => $coupon_percentage,
                    'coupon_maxuse' => $coupon_maxuse,
                    'coupon_sdate' => $coupon_sdate,
                    'coupon_edate' => $coupon_edate,
                    'status' => $status
                );
                $record_data = $this->shoppingcart_coupons_model->is_coupon_exist($id);
                if (count($record_data) > 0)
                {
                    $this->shoppingcart_coupons_model->update_coupon($id, $coupon_ins_update_data);
                    $this->theme->set_message(lang('msg_update_success'), 'success');
                }
                else
                {
                    $this->shoppingcart_coupons_model->insert_coupon($coupon_ins_update_data);
                    $this->theme->set_message(lang('msg_add_success'), 'success');
                }
                redirect(get_current_section($this) . '/shoppingcart/coupons');
            }
        }
        if (!$this->input->post())
        {
            if (isset($id) && $id != '' && $id != '0')
            {
                $record_list_result = $this->shoppingcart_coupons_model->get_coupon_detail_by_id($id);
                $record_list = $record_list_result[0]['sccp'];
            }
        }
        else
        {
            $record_list = $this->input->post();
        }
        // Page title & Breadcrumb settings
        if ($action == "add")
        {
            $this->theme->set('page_title', $this->lang->line('add_coupon'));
            $this->breadcrumb->add($this->lang->line('add_coupon'));
            $id = '';
        }
        elseif ($action == "edit")
        {
            $this->theme->set('page_title', $this->lang->line('edit_coupon'));
            $this->breadcrumb->add($this->lang->line('edit_coupon'));
        }
        //Variable assignments to view 
        $data = array();
        $data['action'] = $action;
        $data['id'] = $id;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['recorddata'] = $record_list;
        $data['content'] = $this->load->view('admin_coupon_add', $data, TRUE);
        $this->theme->view($data, 'admin_action_coupon');
    }

    /**
     * action to add/edit coupon page load form from ajax based on language
     * @params string $action : add or edit
     * @params string $id : if in edit mode
     * @params string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_action_coupon($action, $id = 0, $ajax_load = 1)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $id = intval($id);
        $ajax_load = intval($ajax_load);
        //Initialize
        $record_list = array();
        $record_list_result = array();
        $data = array();
        // Logic
        if (isset($id) && $id != '' && $id != '0')
        {
            $record_list_result = $this->shoppingcart_coupons_model->get_coupon_detail_by_id($id);
            if (!empty($record_list_result))
            {
                $record_list = $record_list_result[0]['sccp'];
            }
        }
        //Variable assignments to view 
        $data['action'] = $action;
        $data['id'] = $id;
        $data['recorddata'] = $record_list;
        if ($ajax_load == '1')
            echo $this->load->view('admin_coupon_add', $data);
        else
            return $this->load->view('admin_coupon_add', $data);
    }

    // Function to delete the coupon record and related url management record
    function delete_coupon()
    {
        $data = $this->input->post();
        $id = intval($data['id']);
        $message = '';
        $result = $this->shoppingcart_coupons_model->get_coupon_detail_by_id($id);

        if (!empty($result))
        {
            $res = $this->shoppingcart_coupons_model->delete_coupon($id);
            if ($res)
            {
                $message = $this->theme->message(lang('delete_success'), 'success');
            }
        }
        else
        {
            $message = $this->theme->message(lang('invalid_id_msg'), 'error');
        }

        echo $message;
    }

    /**
     * action to display list of order page
     */
    public function orders()
    {
        // Set page title
        $this->theme->set('page_title', lang('orders_title'));
        // Breadcrumb setting
        $this->breadcrumb->add(lang('orders_title'));
        //Variable assignments to view 
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->theme->view($data, 'admin_index_orders');
    }

    /**
     * Action to load list of orders
     */
    public function ajax_orders()
    {
        // Initialise variables
        $data = array();
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_orders_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_orders_model->offset = $offset;

        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_term']))
            {
                $this->shoppingcart_orders_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->shoppingcart_orders_model->sort_by = $data['sort_by'];
                $this->shoppingcart_orders_model->sort_order = $data['sort_order'];
            }
        }
        $allorders = $this->shoppingcart_orders_model->get_all_orders();
        $this->shoppingcart_orders_model->_record_count = true;
        $total_records = $this->shoppingcart_orders_model->get_all_orders();

        $data = array(
            'allorders' => $allorders,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->shoppingcart_orders_model->search_term,
            'sort_by' => $this->shoppingcart_orders_model->sort_by,
            'sort_order' => $this->shoppingcart_orders_model->sort_order
        );
        //load view and pass data array to view file
        $this->theme->set('page_title', lang('orders_title'));
        $this->theme->view($data, 'admin_orders');
    }

    /**
     * action to edit order page
     * @params string $action : edit
     * @params string $id : if in edit mode
     */
    function action_order($action, $id = 0)
    {
        // Type Casting
        $action = trim(strip_tags($action));
        $id = intval($id);
        // Initialize
        $record_list = array();
        $record_list_result = array();
        $record_billaddress = array();
        $record_shipaddress = array();
        $record_orderitems = array();
        // Logic
        $record_list_result = $this->shoppingcart_orders_model->get_order_detail_by_id($id);
        if (count($record_list_result) == 0)
        {
            $this->theme->set_message(lang('msg_no_order_exists_error'), 'error');
            redirect(get_current_section($this) . '/shoppingcart/orders');
        }
        $record_list = $record_list_result[0]['sco'];
        $billrecord_list_result = $this->shoppingcart_orders_model->get_billaddress_detail_by_id($record_list['bill_address_id']);
        $shiprecord_list_result = $this->shoppingcart_orders_model->get_shipaddress_detail_by_id($record_list['ship_address_id']);
        $record_orderitems = $this->shoppingcart_orders_model->get_order_items($record_list['id']);

        if ($this->input->post('mysubmit'))
        {
            //Validation Check
            $post_var = $this->input->post();
            if (count($record_list_result) > 0)
            {
                $order_status = trim(strip_tags($this->input->post('order_status')));
                $data_order_array = array('order_status' => $order_status);
                $this->shoppingcart_orders_model->update_order($id, $data_order_array);
                $user_data_id = $record_list_result[0]['u'];

                $data_mail = array();
                $data_mail['email'] = $user_data_id['email'];
                $data_mail['firstname'] = $user_data_id['firstname'];
                $data_mail['lastname'] = $user_data_id['lastname'];
                $data_mail['recorddata'] = $record_list;
                $data_mail['billrecorddata'] = $billrecord_list_result[0]['scba'];
                $data_mail['shiprecorddata'] = $shiprecord_list_result[0]['scsa'];
                $data_mail['orderitemsdata'] = $record_orderitems;
                $this->load->library('mailer');
                $data_mail['is_adminmail'] = 0;
                $subject = 'Order Detail';
                // =============== Send mail to User
                $this->mailer->mail->SetFrom(SITE_FROM_EMAIL, SITE_NAME);
                $this->mailer->mail->IsHTML(true);
                $this->mailer->sendmail(
                        $data_mail['email'], $data_mail['firstname'] . " " . $data_mail['lastname'], $subject, $this->load->view('email_order', $data_mail, true)
                );
                // =========== EOF Send mail to User
                $this->theme->set_message(lang('msg_order_status_success'), 'success');
            }
            redirect(get_current_section($this) . '/shoppingcart/orders');
        }
        if (isset($id) && $id != '' && $id != '0')
        {
            if (count($record_list))
            {
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
                if ($action == "edit")
                {
                    $order_title = $this->lang->line('order_title') . '#' . $record_list['id'];
                    $this->theme->set('page_title', $order_title);
                    $this->breadcrumb->add($order_title);
                }
            }
        }
        //Variable assignments to view 
        $data = array();
        $data['action'] = $action;
        $data['id'] = $id;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['recorddata'] = $record_list;
        $data['billrecorddata'] = $record_billaddress;
        $data['shiprecorddata'] = $record_shipaddress;
        $data['orderitemsdata'] = $record_orderitems;
        $data['content'] = $this->load->view('admin_order_add', $data, TRUE);
        $this->theme->view($data, 'admin_action_order');
    }

    function images($product_id = '')
    {
        $product_id = intval($product_id);
        //Set page title
        $this->theme->set('page_title', lang('product_images'));
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $this->breadcrumb->add(lang('product_image_management'), base_url() . 'admin/shoppingcart/images/' . $product_id);

        $data['product_id'] = $product_id;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->theme->view($data, 'admin_index_image');
    }

    function ajax_images($product_id = '')
    {
        //Type Casting
        $product_id = intval($product_id);
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_images_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_images_model->offset = $offset;
        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_status']))
            {
                $this->shoppingcart_images_model->search_status = $data['search_status'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->shoppingcart_images_model->sort_by = $data['sort_by'];
                $this->shoppingcart_images_model->sort_order = $data['sort_order'];
            }
            if (isset($data['type']) && $data['type'] == 'delete')
            {
                $this->shoppingcart_images_model->delete_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                $this->shoppingcart_images_model->active_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                $this->shoppingcart_images_model->inactive_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                $this->shoppingcart_images_model->active_all_records();
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                $this->shoppingcart_images_model->inactive_all_records();
            }
        }
        $list = $this->shoppingcart_images_model->get_listing($product_id);
        $this->shoppingcart_images_model->_record_count = true;
        $total_records = $this->shoppingcart_images_model->get_listing($product_id);
        $data = array(
            'list' => $list,
            'product_id' => $product_id,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search' => $this->input->post('search'),
            'sort_by' => $this->shoppingcart_images_model->sort_by,
            'sort_order' => $this->shoppingcart_images_model->sort_order,
            'search_status' => $this->shoppingcart_images_model->search_status
        );
        $this->theme->view($data, 'admin_ajax_image_index');
    }

    function action_image($action, $product_id = 0, $id = 0)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $product_id = intval($product_id);
        $id = intval($id);
        $product_image_data = array();
        $message = '';

        if ($this->input->post('submit'))
        {
            $status = trim(strip_tags($this->input->post('status')));
            $old_image = trim(strip_tags($this->input->post('old_image')));
            $product_image = '';
        }

        if ($action == 'add' || $action == 'edit')
        {
            $result = array();

            if ($this->input->post('submit'))
            {
                if ($_FILES['product_image']['name'] != '' && $_FILES['product_image']['tmp_name'] != '')
                {
                    list($width, $height, $type, $attr) = getimagesize($_FILES['product_image']['tmp_name']);

                    if ($width < 240 || $height < 320)
                    {
                        $message = lang('msg_add_image_fail');
                    }
                }

                if ($message == '')
                {
                    //start file uploading code........
                    if ($_FILES['product_image']['name'] != '' && $_FILES['product_image']['tmp_name'] != '')
                    {
                        $product_image = $this->image_upload_resize('gallery', 'gallery', 'product_image');
                        $this->shoppingcart_images_model->product_image = $product_image;

                        if ($action == 'edit' && $old_image != $_FILES['product_image']['name'])
                        {
                            $this->delete_images('gallery/', $old_image);
                        }
                    }
                    //End file uploading code
                    /* -------------------------------------------------------------------------------------------------------------------- */

                    $this->shoppingcart_images_model->status = $status;

                    if ($action == 'edit')
                    {
                        $this->shoppingcart_images_model->update($id, $product_id);
                        $this->theme->set_message(lang('msg-update-image-success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_id = $this->shoppingcart_images_model->get_last_id();
                            $id = $last_id + 1;
                        }

                        $this->shoppingcart_images_model->insert($product_id);
                        $this->theme->set_message(lang('msg-add-image-success'), 'success');
                    }
                    redirect(get_current_section($this) . '/shoppingcart/images/' . $product_id);
                }
            }

            // Breadcrumb settings
            if ($action == "add")
            {
                $this->theme->set('page_title', lang('add_product_image'));
                $this->breadcrumb->add(lang('product_image_management'), base_url() . get_current_section($this) . '/shoppingcart/images/' . $product_id);
                $this->breadcrumb->add(lang('add_product_image'));
                $id = '';
            }
            else if ($action == "edit")
            {
                if (isset($id) && $id != '' && $id != '0')
                {
                    $product_image_data = $this->shoppingcart_images_model->get_detail_by_id($id, $product_id);
                }

                $this->theme->set('page_title', lang('edit_product_image'));
                $this->breadcrumb->add(lang('product_image_management'), base_url() . get_current_section($this) . '/shoppingcart/images/' . $product_id);
                $this->breadcrumb->add(lang('edit_product_image'));
            }

            //Variable assignments to view
            $data = array();
            $data['action'] = $action;
            $data['id'] = $id;
            $data['product_id'] = $product_id;
            $data['product_image_data'] = $product_image_data;
            $data['message'] = $message;
            $data['csrf_token'] = $this->security->get_csrf_token_name();
            $data['csrf_hash'] = $this->security->get_csrf_hash();
            $data['content'] = $this->load->view('admin_add_edit_action_image', $data, TRUE);
            $this->theme->view($data, 'admin_add_edit_image');
        }
        else
        {
            $this->theme->set_message(lang('permission-not-allowed'), 'error');
            redirect(get_current_section($this) . '/users');
        }
    }

    function ajax_action_image($action, $product_id = 0, $id = 0, $ajax_load = 1)
    {
        // Type Casting
        $action = trim(strip_tags($action));
        $product_id = intval($product_id);
        $id = intval($id);
        $ajax_load = intval($ajax_load);
        //Initialize
        $data = array();
        $list = array();
        if (isset($id) && $id != '' && $id != '0')
        {
            $list = $this->shoppingcart_images_model->get_detail_by_id($id, $product_id);
        }
        //Variable assignments to view
        $data['action'] = $action;
        $data['id'] = $id;
        $data['product_id'] = $product_id;
        $data['result'] = $list;
        if ($ajax_load == '1')
            echo $this->load->view('add-edit-action-image', $data);
        else
            return $this->load->view('add-edit-action-image', $data);
    }

    // Function to delete the product record and related url management record
    function delete_product_image()
    {
        //Initialise
        $id = $this->input->post('id');
        //Type casting
        $id = intval($id);
        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $data['product'] = $this->shoppingcart_images_model->delete_product_image($id);
            $message = $this->theme->message(lang('delete_success_product_image'), 'success');
        }
        else
        {
            $message = $this->theme->message(lang('invalid-id-msg'), 'error');
        }
        echo $message;
    }

    /**
     * Action view to view product page, order page or coupon page
     * @params string $type : product,coupon and order
     * @params string $language_code
     * @params string $id
     */
    function view($type, $id, $language_code = '')
    {
        //Type casting
        $id = intval($id);
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        // Logic
        if ($type == 'product')
        {
            $language_list = $this->languages_model->get_languages();
            $language_detail = $this->languages_model->get_languages_by_code($language_code);
            $language_id = $language_detail[0]['l']['id'];
            $data['languages'] = $language_list;
            $data['language_code'] = $language_detail[0]['l']['language_code'];
            $data['language_name'] = $language_detail[0]['l']['language_name'];
            $data['language_id'] = $language_id;
            $product_id = $id;
            $result = $this->shoppingcart_model->get_detail_by_id($product_id, $language_detail[0]['l']['id']);
            $related_products = $this->shoppingcart_relatedproducts_model->getrelated_products_by_ids($language_id, $product_id, $rprd_id = 0);
            $data['related_products'] = $related_products;
            $data['result'] = $result;
            $this->theme->set('page_title', lang('view_product'));
            $this->breadcrumb->add($this->lang->line('view_product'));

            $data['content'] = $this->load->view('admin_product_view_ajax', $data, TRUE);
            $this->theme->view($data, 'admin_product_view');
        }
        if ($type == 'coupon')
        {
            $coupon_id = $id;
            $record_list_result = $this->shoppingcart_coupons_model->get_coupon_detail_by_id($coupon_id);
            $record_list = $record_list_result[0]['sccp'];
            $data['recorddata'] = $record_list;
            $this->theme->set('page_title', lang('view_coupon'));
            $this->breadcrumb->add($this->lang->line('view_coupon'));
            $this->theme->view($data, 'admin_coupon_view');
        }
        if ($type == 'order')
        {
            $order_id = $id;
            $record_list_result = $this->shoppingcart_orders_model->get_order_detail_by_id($order_id);
            if (count($record_list_result) == 0)
            {
                $this->theme->set_message(lang('msg_no_order_exists_error'), 'error');
                redirect(get_current_section($this) . '/shoppingcart/orders');
            }
            $record_list = $record_list_result[0]['sco'];
            $billrecord_list_result = $this->shoppingcart_orders_model->get_billaddress_detail_by_id($record_list['bill_address_id']);
            $shiprecord_list_result = $this->shoppingcart_orders_model->get_shipaddress_detail_by_id($record_list['ship_address_id']);
            $record_orderitems = $this->shoppingcart_orders_model->get_order_items($record_list['id']);
            if (count($record_list))
            {
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
                $data['id'] = $order_id;
                $data['recorddata'] = $record_list;
                $data['billrecorddata'] = $record_billaddress;
                $data['shiprecorddata'] = $record_shipaddress;
                $data['orderitemsdata'] = $record_orderitems;
                $this->theme->set('page_title', lang('view_order'));
                $this->breadcrumb->add($this->lang->line('view_order'));
                $this->theme->view($data, 'admin_order_view');
            }
        }
    }

    /**
     * Action for view product not in editable mode
     */
    function view_product($language_code = '', $id)
    {
        // Type casting
        $id = intval($id);
        // Logic 
        $language_list = $this->languages_model->get_languages();
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        // Breadcrumb setting
        $this->breadcrumb->add($this->lang->line('view_product'));
        // Variable assignments to view
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['languages'] = $language_list;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $product_id = $id;
        $result = $this->shoppingcart_model->get_detail_by_id($product_id, $language_detail[0]['l']['id']);
        $related_products = $this->shoppingcart_relatedproducts_model->getrelated_products_by_ids($language_id, $product_id, $rprd_id = 0);
        $data['related_products'] = $related_products;
        $data['result'] = $result;
        $data['content'] = $this->load->view('admin_product_view_ajax', $data, TRUE);
        $this->theme->view($data, 'admin_product_view_ajax');
    }

    // To upload and validate image upload
    public function handle_upload()
    {
        if (isset($_FILES['product_image']['name']) && !empty($_FILES['product_image']['name']))
        {
            if ($this->input->post('hdnphoto'))
            {
                unlink('assets/uploads/banner_ad_images/main/' . $this->input->post('hdnphoto'));
            }
            $config['upload_path'] = "assets/uploads/shoppingcart/main/";
            $config['allowed_types'] = 'gif|jpg|png';
            $config['file_name'] = 'product-image-' . date("Ymd-His");
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            //call function
            if (!$this->upload->do_upload('product_image'))
            {
                $error = array('error' => $this->upload->display_errors());
                $this->form_validation->set_message('handle_upload', $error['error']);
                return false;
            }
            else
            {
                $uploaded_file_details = $this->upload->data();
                //resize image
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/uploads/shoppingcart/main/' . $uploaded_file_details['file_name'];
                $config['new_image'] = 'assets/uploads/shoppingcart/thumbs/' . $uploaded_file_details['file_name'];
                $config['width'] = THUMB_WIDTH;
                $config['height'] = THUMB_HEIGHT;
                //load resize library
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $_POST['product_image'] = $uploaded_file_details['file_name'];
                return true;
            }
        }
        else
        {
            if ($this->input->post('hdnphoto') != "")
            {
                $_POST['product_image'] = $this->input->post('hdnphoto');
                return true;
            }
            else
            {
                $this->form_validation->set_message('handle_upload', 'you must have to upload an image.');
                return false;
            }
        }
    }

    /**
     * action to display language wise list of categories page
     * @param string $language_code
     */
    public function categories($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();

        //Set page title
        $this->theme->set('page_title', lang('category'));

        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->theme->view($data);
    }

    /**
     * action to load list of categories based on language passed or from default language
     * @param string $language_code
     */
    function ajax_category_index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_categories_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_categories_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_term']))
            {
                $this->shoppingcart_categories_model->search_term = $data['search_term'];
            }

            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->shoppingcart_categories_model->sort_by = $data['sort_by'];
                $this->shoppingcart_categories_model->sort_order = $data['sort_order'];
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $category_list = $this->shoppingcart_categories_model->get_category_listing($language_detail[0]['l']['id']);
        $this->shoppingcart_categories_model->_record_count = true;
        $total_records = $this->shoppingcart_categories_model->get_category_listing($language_detail[0]['l']['id']);

        if (!empty($category_list))
        {
            $i = 0;
            foreach ($category_list as $category)
            {
                $category_list[$i]['subcategory'] = $this->shoppingcart_categories_model->get_category_child($category['scc']['category_id'], $language_detail[0]['l']['id']);
                $category_list[$i]['totalproduct'] = $this->shoppingcart_model->get_category_total_product($category['scc']['category_id'], $language_detail[0]['l']['id']);
                $i++;
            }
        }

        //Variable assignments to view
        $data = array(
            'category_list' => $category_list,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->shoppingcart_categories_model->search_term,
            'sort_by' => $this->shoppingcart_categories_model->sort_by,
            'sort_order' => $this->shoppingcart_categories_model->sort_order
        );

        $this->theme->view($data, 'admin_ajax_category_index');
    }

    /**
     * action to add/edit category page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function action_category($action, $language_code = '', $id = 0)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $category_image = '';
        $default_lang = 0;

        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        //get default lang
        $default_language = $this->languages_model->get_default_language();
        if ($default_language[0]['l']['id'] == $language_id)
        {
            $default_lang = 1;
        }

        //delete category image
        if ($action == 'deleteImage')
        {
            if (isset($id) && $id != '' && $id != '0')
            {
                $category_image = trim(strip_tags($this->input->post('image_name')));

                $this->delete_images('categories/', $category_image);

                $this->shoppingcart_categories_model->category_image = '';
                $this->shoppingcart_categories_model->update_category($id, $language_id);
            }
        }

        if ($this->input->post('categorysubmit'))
        {
            $parent_id = intval($this->input->post('parent_id'));
            $title = trim(strip_tags($this->input->post('title')));
            $slug_url = trim(strip_tags($this->input->post('slug_url')));
            $description = trim($this->input->post('description'));
            $meta_keywords = trim(strip_tags($this->input->post('meta_keywords')));
            $meta_description = trim(strip_tags($this->input->post('meta_description')));
            $status = trim(strip_tags($this->input->post('status')));
        }

        if ($action == 'add' || $action == 'edit')
        {
            //Initialize
            $category_list = $category_list_result = array();

            if ($language_code == '')
            {
                $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
            }

            // Logic
            if ($this->input->post('categorysubmit'))
            {
                //Validation Check
                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', lang('title'), 'trim|required|min_length[2]|xss_clean');
                $this->form_validation->set_rules('slug_url', lang('slug_url'), 'required|callback_check_unique_slug_url|xss_clean');
                $this->form_validation->set_rules('description', lang('description'), 'trim|xss_clean');
                $this->form_validation->set_rules('category_image', 'Category image', 'xss_clean');
                $this->form_validation->set_rules('meta_keywords', lang('meta_keywords'), 'trim|xss_clean');
                $this->form_validation->set_rules('meta_description', lang('meta_description'), 'trim|xss_clean');

                if ($this->form_validation->run($this) == true)
                {
                    $category_data = $this->shoppingcart_categories_model->get_related_lang_category($id, $language_id);

                    $this->shoppingcart_categories_model->title = $title;
                    $this->shoppingcart_categories_model->slug_url = $slug_url;
                    $this->shoppingcart_categories_model->description = $description;
                    $this->shoppingcart_categories_model->meta_keywords = $meta_keywords;
                    $this->shoppingcart_categories_model->meta_description = $meta_description;

                    if (intval($this->input->post('default_language')) == 1)
                    {
                        $this->shoppingcart_categories_model->parent_id = $parent_id;
                        $this->shoppingcart_categories_model->status = $status;
                    }

                    if (isset($_FILES) && isset($_FILES['category_image']) && $_FILES['category_image']['name'] != '')
                    {
                        $category_image = $this->image_upload_resize('categories', 'categories', 'category_image');
                        $this->shoppingcart_categories_model->category_image = $category_image;

                        if ($category_image != trim(strip_tags($this->input->post('category_old_image'))))
                        {
                            $this->delete_images('categories/', trim(strip_tags($this->input->post('category_old_image'))));
                        }
                    }

                    if (count($category_data) > 0)
                    {
                        $this->shoppingcart_categories_model->update_category($id, $language_id);

                        if (intval($this->input->post('default_language')) == 1)
                        {
                            $categories_child = $this->get_n_categories($id, 0);

                            $cat_id_array = array();

                            if ($categories_child != '')
                            {
                                $cat_id_array = array_unique(array_merge(array_filter(explode("|", $categories_child)), array($id)));
                            }
                            else
                            {
                                $cat_id_array[] = $id;
                            }

                            $this->shoppingcart_categories_model->active_inactive_all_child_category($cat_id_array, 0, $status);

                            if ($status == 0)
                            {
                                $this->shoppingcart_model->inactive_all_category_products($cat_id_array, $language_id);
                            }
                        }

                        if (isset($_FILES) && isset($_FILES['category_image']) && $_FILES['category_image']['name'] != '')
                        {
                            //save same image name for multi lang
                            $language_lists = array();
                            $language_lists = $this->languages_model->get_languages(0, 1);

                            if (!empty($language_lists) && count($language_lists) > 1)
                            {
                                foreach ($language_lists as $key => $val)
                                {
                                    $alias = end(array_keys($val));
                                    if ($val[$alias]['id'] != $language_id)
                                    {
                                        $this->shoppingcart_categories_model->update_category_image($id, $val[$alias]['id']);
                                    }
                                }
                            }
                        }

                        $this->theme->set_message(lang('msg_update_success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_category_id = $this->shoppingcart_categories_model->get_last_category_id();
                            $id = $last_category_id + 1;
                        }

                        $language_lists = array();
                        $language_lists = $this->languages_model->get_languages(0, 1);

                        if (!empty($language_lists) && count($language_lists) > 1)
                        {
                            foreach ($language_lists as $key => $val)
                            {
                                $alias = end(array_keys($val));

                                if (count($this->shoppingcart_categories_model->get_related_lang_category($id, $val[$alias]['id'])) == 0)
                                {
                                    $this->shoppingcart_categories_model->insert_category($id, $val[$alias]['id']);
                                }
                            }
                        }
                        else
                        {
                            $this->shoppingcart_categories_model->insert_category($id, $language_id);
                        }

                        $this->theme->set_message(lang('msg-add-success'), 'success');
                    }

                    /* $this->config_model->change_slug_url_management($this->input->post('old_slug_url'), $this->input->post('slug_url'), 'shoppingcart', $id, 'index/' . $this->input->post('slug_url'), $this->input->post('status'));

                      $this->load->module('urls/urls_admin');

                      $this->urls_admin->generate_custom_url();

                      redirect($this->section_name.'/shoppingcart/categories/' . $language_detail[0]['l']['language_code']); */
                    redirect(get_current_section($this) . '/shoppingcart/categories');
                }
            }

            if (!$this->input->post())
            {
                if (isset($id) && $id != '' && $id != '0')
                {
                    $category_list_result = $this->shoppingcart_categories_model->get_category_detail_by_id($id, $language_detail[0]['l']['id']);
                    $category_list = $category_list_result[0]['scc'];
                }
            }
            else
            {
                $category_list = $this->input->post();
            }

            $language_list = $this->languages_model->get_languages(); // get list of languages
            //Get all categories
            //$category_data = $this->shoppingcart_categories_model->get_category_listing($language_detail[0]['l']['id']);
            $category_array = $this->get_n_categories_option(0, $language_detail[0]['l']['id'], '');
            $category_data = array();
            $category_data = explode("|", $category_array);

            // Breadcrumb settings
            if ($action == "add")
            {
                $this->theme->set('page_title', $this->lang->line('add_category'));
                $this->breadcrumb->add($this->lang->line('add_category'));
                $id = '';
            }
            elseif ($action == "edit")
            {
                $this->theme->set('page_title', $this->lang->line('edit_category'));
                $this->breadcrumb->add($this->lang->line('edit_category'));
            }

            //Variable assignments to view
            $data = array();
            $data['action'] = $action;
            $data['id'] = $id;
            $data['language_code'] = $language_detail[0]['l']['language_code'];
            $data['language_name'] = $language_detail[0]['l']['language_name'];
            $data['language_id'] = $language_id;
            $data['csrf_token'] = $this->security->get_csrf_token_name();
            $data['csrf_hash'] = $this->security->get_csrf_hash();
            $data['languages'] = $language_list;
            $data['category'] = $category_list;
            $data['category_data'] = $category_data;
            $data['default_language'] = $default_lang;

            $data['content'] = $this->load->view('admin_ajax_action_category', $data, TRUE);
            $this->theme->view($data, 'admin_action_category');
        }
        else
        {
            $this->theme->set_message(lang('permission_not_allowed'), 'error');
            redirect($this->section_name . '/shoppingcart');
            exit;
        }
    }

    /**
     * Displays a list of categories and sub categories data
     * @params string $parent : category id
     * @params string $language_id : language id
     */
    function get_n_categories($parent = 0, $language_id)
    {
        $html = '';

        $categories = $this->shoppingcart_categories_model->getallcategories($language_id, $parent, $html);

        if (count($categories) > 0)
        {
            foreach ($categories as $category)
            {
                $current_id = $category['scc']['category_id'];

                $html .= $current_id . '|';

                if (count($this->shoppingcart_categories_model->getallcategories($language_id, $current_id, $html)) > 0)
                {
                    $html .= $this->get_n_categories($current_id, $language_id);
                }
            }
        }

        return $html;
    }

    /**
     * action to add/edit category page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_action_category($action, $language_code = '', $id = 0, $ajax_load = 1)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $ajax_load = intval($ajax_load);
        $default_lang = 0;
        //Initialize
        $category_list = array();
        $category_list_result = array();
        $data = array();

        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        //get default lang
        $default_language = $this->languages_model->get_default_language();
        if ($default_language[0]['l']['id'] == $language_detail[0]['l']['id'])
        {
            $default_lang = 1;
        }

        if (isset($id) && $id != '' && $id != '0')
        {
            $category_list_result = $this->shoppingcart_categories_model->get_category_detail_by_id($id, $language_detail[0]['l']['id']);

            if (!empty($category_list_result))
            {
                if (!empty($category_list_result[0]['scc']))
                    $category_list = $category_list_result[0]['scc'];
            }
        }

        //Get all categories
        $category_array = $this->get_n_categories_option(0, $language_detail[0]['l']['id'], '');
        $category_data = array();
        $category_data = explode("|", $category_array);

        //Variable assignments to view
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['category'] = $category_list;
        $data['category_data'] = $category_data;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['default_language'] = $default_lang;

        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_action_category', $data);
        else
            return $this->load->view('admin_ajax_action_category', $data);
    }

    /**
     * Function delete_images to images in all folder
     */
    private function delete_images($type, $image_name)
    {
        if (file_exists(FCPATH . 'assets/uploads/shoppingcart/' . $type . 'main/' . $image_name))
        {
            unlink(FCPATH . 'assets/uploads/shoppingcart/' . $type . 'main/' . $image_name);
        }

        if (file_exists(FCPATH . 'assets/uploads/shoppingcart/' . $type . 'thumbs/' . $image_name))
        {
            unlink(FCPATH . 'assets/uploads/shoppingcart/' . $type . 'thumbs/' . $image_name);
        }

        if (file_exists(FCPATH . 'assets/uploads/shoppingcart/' . $type . 'medium/' . $image_name))
        {
            unlink(FCPATH . 'assets/uploads/shoppingcart/' . $type . 'medium/' . $image_name);
        }
    }

    // Function to delete the category and related all sub category and products
    function delete_category()
    {
        $categories_child = array();
        $message = '';
        $data = $this->input->post();
        $id = intval($data['id']);

        $result = $this->shoppingcart_categories_model->get_category_by_id($id);

        if (!empty($result))
        {
            $categories_child = $this->get_n_categories($result[0]['scc']['category_id'], 0);

            $cat_id_array = array();

            if ($categories_child != '')
            {
                $cat_id_array = array_unique(array_merge(array_filter(explode("|", $categories_child)), array($result[0]['scc']['category_id'])));
            }
            else
            {
                $cat_id_array[] = $result[0]['scc']['category_id'];
            }

            $this->shoppingcart_categories_model->delete_all_child_category($cat_id_array);
            $this->shoppingcart_model->delete_all_category_products($cat_id_array);

            $res = $this->shoppingcart_categories_model->delete_category($id);

            if ($res)
            {
                $message = $this->theme->message(lang('delete_success'), 'success');
            }
        }
        else
        {
            $message = $this->theme->message(lang('invalid_id_msg'), 'error');
        }

        echo $message;
    }

    public function products($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[get_current_section($this)]['site_lang_code'];
        }
        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        //Set page title
        $this->theme->set('page_title', lang('prd_title'));
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->theme->view($data);
    }

    /**
     * Default Method: index
     * Action to display control panel.
     * @params string $language_code
     */
    public function ajax_products_index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[get_current_section($this)]['site_lang_code'];
        }

        // Initialise variables
        $data = array();
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_model->offset = $offset;

        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_term']))
            {
                $this->shoppingcart_model->search_term = $data['search_term'];
            }

            if (isset($data['search_category_id']))
            {
                $this->shoppingcart_model->search_category_id = $data['search_category_id'];
            }

            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->shoppingcart_model->sort_by = $data['sort_by'];
                $this->shoppingcart_model->sort_order = $data['sort_order'];
            }

            if (isset($data['type']) && $data['type'] == 'delete')
            {
                $this->shoppingcart_model->delete_records($data['ids']);
            }

            if (isset($data['type']) && $data['type'] == 'active')
            {
                $this->shoppingcart_model->active_records($data['ids']);
            }

            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                $this->shoppingcart_model->inactive_records($data['ids']);
            }

            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                $this->shoppingcart_model->active_all_records();
            }

            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                $this->shoppingcart_model->inactive_all_records();
            }

            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                $this->shoppingcart_model->inactive_all_records();
            }
        }

        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        //Get all categories
        $category_array = $this->get_n_categories_option(0, $language_id, '');
        $category_data = array();
        $category_data = explode("|", $category_array);

        $list = $this->shoppingcart_model->get_all_productsdata($language_id);
        $this->shoppingcart_model->_record_count = true;
        $total_records = $this->shoppingcart_model->get_all_productsdata($language_id);

        $data = array(
            'list' => $list,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->shoppingcart_model->search_term,
            'search_category_id' => $this->shoppingcart_model->search_category_id,
            'sort_by' => $this->shoppingcart_model->sort_by,
            'sort_order' => $this->shoppingcart_model->sort_order
        );

        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['category_data'] = $category_data;
        //load view and pass data array to view file
        $this->theme->set('page_title', lang('prd_title'));
        // $this->breadcrumb->add(lang('prd-title'));
        $this->theme->view($data, 'admin_ajax_products_index');
    }

    /**
     * Default Method: Payment
     * Action to display payment module listing page
     * @params string $language_code
     */
    public function payments($language_code = '')
    {
        //Set page title
        $this->theme->set('page_title', lang('payments'));

        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        $this->theme->view($data);
    }

    /**
     * Action to load list of Payment
     * @params string $language_code
     */
    public function ajax_payments($language_code = '')
    {
        $data = array();
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_payments_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_payments_model->offset = $offset;

        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_term']))
            {
                $this->shoppingcart_payments_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->shoppingcart_payments_model->sort_by = $data['sort_by'];
                $this->shoppingcart_payments_model->sort_order = $data['sort_order'];
            }
            if (isset($data['type']) && $data['type'] == 'delete')
            {
                $this->shoppingcart_payments_model->delete_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                $this->shoppingcart_payments_model->active_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                $this->shoppingcart_payments_model->inactive_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                $this->shoppingcart_payments_model->active_all_records();
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                $this->shoppingcart_payments_model->inactive_all_records();
            }
        }


        $payment_lists = $this->shoppingcart_payments_model->get_all_payment_module();
        $this->shoppingcart_payments_model->_record_count = true;
        $total_records = $this->shoppingcart_payments_model->get_all_payment_module();

        $data = array(
            'payment_lists' => $payment_lists,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->shoppingcart_payments_model->search_term,
            'sort_by' => $this->shoppingcart_payments_model->sort_by,
            'sort_order' => $this->shoppingcart_payments_model->sort_order,
            'type' => isset($data['type']) ? $data['type'] : ''
        );

        $this->theme->set('page_title', lang('payments'));
        $this->theme->view($data, 'admin_ajax_payments');
    }

    /**
     * action to load list of Payment
     * @param string $language_code
     */
    function ajax_payments_index()
    {
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->shoppingcart_categories_model->record_per_page = $this->record_per_page;
        $this->shoppingcart_categories_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_term']))
            {
                $this->shoppingcart_categories_model->search_term = $data['search_term'];
            }

            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->shoppingcart_categories_model->sort_by = $data['sort_by'];
                $this->shoppingcart_categories_model->sort_order = $data['sort_order'];
            }
        }

        $category_list = $this->shoppingcart_categories_model->get_category_listing();
        $this->shoppingcart_categories_model->_record_count = true;
        $total_records = $this->shoppingcart_categories_model->get_category_listing();

        //Variable assignments to view
        $data = array(
            'category_list' => $category_list,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->shoppingcart_categories_model->search_term,
            'sort_by' => $this->shoppingcart_categories_model->sort_by,
            'sort_order' => $this->shoppingcart_categories_model->sort_order
        );

        $this->theme->view($data, 'admin_ajax_payments_index');
    }

    /**
     * action to add/edit Payment page
     * @params string $action : add or edit
     * @params string $id : if in edit mode
     */
    function action_payments($action, $id = 0)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $id = intval($id);

        if ($this->input->post('paymentsubmit'))
        {
            $payment_title = trim(strip_tags($this->input->post('payment_title')));
            $payment_username = trim(strip_tags($this->input->post('payment_username')));
            $payment_password = trim(strip_tags($this->input->post('payment_password')));
            $payment_status = intval($this->input->post('payment_status'));
            $payment_mode = intval($this->input->post('payment_mode'));
            $payment_key = trim(strip_tags($this->input->post('payment_key')));
        }

        if ($action == 'add' || $action == 'edit')
        {
            $result = array();

            if ($this->input->post('paymentsubmit'))
            {
                //Validation Check
                $this->load->library('form_validation');
                $this->form_validation->set_rules('payment_title', 'Name', 'required|xss_clean');
                $this->form_validation->set_rules('payment_username', 'Name', 'required|xss_clean');
                $this->form_validation->set_rules('payment_password', 'Name', 'xss_clean');
                $this->form_validation->set_rules('payment_key', 'Name', 'xss_clean');

                /* -------------------------------------------------------------------------------------------------------------------- */
                if ($this->form_validation->run($this) == true)
                {
                    $data = $this->shoppingcart_payments_model->is_exist_payment($id);

                    $this->shoppingcart_payments_model->title = $payment_title;
                    $this->shoppingcart_payments_model->username = $payment_username;
                    $this->shoppingcart_payments_model->password = $payment_password;
                    $this->shoppingcart_payments_model->key = $payment_key;
                    $this->shoppingcart_payments_model->mode = $payment_mode;
                    $this->shoppingcart_payments_model->status = $payment_status;

                    if (count($data) > 0)
                    {
                        $this->shoppingcart_payments_model->update($id);
                        $this->theme->set_message(lang('msg_update_success'), 'success');
                    }
                    else
                    {
                        $this->shoppingcart_payments_model->insert();
                        $this->theme->set_message(lang('msg_add_success'), 'success');
                    }

                    redirect(get_current_section($this) . '/shoppingcart/payments');
                }
            }


            if (!$this->input->post())
            {
                if (isset($id) && $id != '' && $id != '0')
                {
                    $result = $this->shoppingcart_payments_model->get_payment_detail_by_id($id);
                }
            }

            // Breadcrumb settings
            if ($action == "add")
            {
                $this->theme->set('page_title', lang('add_payment'));
                $this->breadcrumb->add(lang('add_payment'));
                $id = '';
            }
            elseif ($action == "edit")
            {
                $this->theme->set('page_title', lang('edit_payment'));
                $this->breadcrumb->add(lang('edit_payment'));
            }

            //Variable assignments to view
            $data = array();
            $data['action'] = $action;
            $data['id'] = $id;
            $data['csrf_token'] = $this->security->get_csrf_token_name();
            $data['csrf_hash'] = $this->security->get_csrf_hash();
            $data['result'] = $result;
            $data['content'] = $this->load->view('admin_payments_add', $data, TRUE);
            $this->theme->view($data, 'admin_action_payments');
        }
        else
        {
            $this->theme->set_message(lang('permission_not_allowed'), 'error');
            redirect(get_current_section($this) . '/users');
        }
    }

    // Function to delete the Payment record 
    function delete_payments()
    {
        $data = $this->input->post();
        $id = intval($data['id']);
        $message = '';
        $result = $this->shoppingcart_payments_model->get_payment_detail_by_id($id);

        if (!empty($result))
        {
            $res = $this->shoppingcart_payments_model->delete_records($id);
            if ($res)
            {
                $message = $this->theme->message(lang('delete_success'), 'success');
            }
        }
        else
        {
            $message = $this->theme->message(lang('invalid_id_msg'), 'error');
        }

        echo $message;
    }
}
?>