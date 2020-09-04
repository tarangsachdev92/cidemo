<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  product Admin Controller
 *
 *  product Admin controller to display add / Edit / Delete / List product page for each language.
 *
 * @package CIDemoApplication
 *
 * @copyright	(c) 2013, TatvaSoft
 * @author Dipesh Gangani <dipesh.gangani@sparsh.com>
 */
class Products_admin extends Base_Admin_Controller
{
    /*
     * Create an instance
     */

    function __construct()
    {
        parent::__construct();
        // Login check for admin
        $this->access_control($this->access_rules());

        // Load required helpers
        $this->load->helper('url');
        $this->load->helper('ckeditor');

        // load required models
        $this->load->model('products/products_image_model');
        $this->load->model('urls/urls_model');

        // Breadcrumb settings
        $this->breadcrumb->add('Product Management', base_url() . $this->section_name.'/products');
    }

    /**
     * function accessRules to check page access
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('action', 'index', 'ajax_index', 'ajax_action', 'view', 'ajax_view', 'delete_product', 'image_action', 'image_index', 'ajax_image_index', 'ajax_image_action', 'delete_product_image','session_set'),
                'users' => array('@'),
            )
        );
    }

    /**
     * action to display language wise list of product page
     * @param string $language_code
     */
    function index($language_code = '')
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
        $this->theme->set('page_title', 'Product List');

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
     * action to load list of product based on language passed or from default language
     * @param string $language_code
     */
    function ajax_index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->products_model->record_per_page = $this->record_per_page;
        $this->products_model->offset = $offset;
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
       
        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();           
            if (isset($data['search_status']))
            {
                $this->products_model->search_status = $data['search_status'];
            }
             if (isset($data['search_category']))
            {
                $this->products_model->search_category = $data['search_category'];
            }
            if (isset($data['search']))
            {
                $this->products_model->search = $data['search'];
            }
            if (isset($data['search_name']))
            {
                $this->products_model->search_name = $data['search_name'];
            }
            if (isset($data['search_slug'])){
                $this->products_model->search_slug = $data['search_slug'];
            }
            if(isset($data['search_from']))
            {
                $this->products_model->search_from = $data['search_from'];
            }
            if(isset($data['search_to']))
            {
                $this->products_model->search_to = $data['search_to'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->products_model->sort_by = $data['sort_by'];
                $this->products_model->sort_order = $data['sort_order'];
            }

            if (isset($data['type']) && $data['type'] == 'delete')
            {
                $this->products_model->delete_records($data['ids']);
                echo $this->theme->message(lang('delete_success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                $this->products_model->active_records($data['ids']);
                echo $this->theme->message(lang('product-active-success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                $this->products_model->inactive_records($data['ids']);
                echo $this->theme->message(lang('product-inactive-success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                $this->products_model->active_all_records($language_id);
                echo $this->theme->message(lang('products-active-success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                $this->products_model->inactive_all_records($language_id);
                echo $this->theme->message(lang('products-inactive-success'), 'success');
                    exit;
            }
        }

        //Logic        
        $list = $this->products_model->get_listing($language_id);
        //echo '<pre>'; print_r($list); echo '</pre>'; die();
        $this->products_model->_record_count = true;
        $total_records = $this->products_model->get_listing($language_detail[0]['l']['id']);
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view        
        $data = array(
            'list' => $list,
            'language_id' => $language_id,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search' => $this->input->post('search'),
            'search_name' => $this->products_model->search_name,
            'search_slug' => $this->products_model->search_slug,
            'search_status' => $this->products_model->search_status,
            'search_category' => $this->products_model->search_category,
            'search_from' => $this->products_model->search_from,
            'search_to' => $this->products_model->search_to,
            'sort_by' => $this->products_model->sort_by,
            'sort_order' => $this->products_model->sort_order
        );        
        $this->theme->view($data, 'admin_ajax_index');
    }

    /**
     * action to add/edit product page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function action($action, $language_code = '', $id = 0)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        if ($this->input->post('submit'))
        {
            
            
            $name = trim(strip_tags($this->input->post('name')));
            $slug_url = trim(strip_tags($this->input->post('slug')));
            $description = trim($this->input->post('description'));
            $status = trim(strip_tags($this->input->post('status')));
            $price = trim(strip_tags($this->input->post('price')));
            $featured = trim(strip_tags($this->input->post('featured')));
            $category_id = trim(strip_tags($this->input->post('category_id')));
            $meta_keywords = trim(strip_tags($this->input->post('meta_keywords')));
            $meta_description = trim(strip_tags($this->input->post('meta_description')));
            $product_image = '';
        }


        if ($action == 'add' || $action == 'edit')
        {
            $result = array();
            if ($language_code == '')
            {
                $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
            }

            // Logic
            $language_detail = $this->languages_model->get_languages_by_code($language_code);
            $language_id = $language_detail[0]['l']['id'];
            if ($this->input->post('submit'))
            {                
                //Validation Check
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
                $this->form_validation->set_rules('slug', 'Slug URL', 'required|callback_check_unique_slug_url|xss_clean');
//                $this->form_validation->set_rules('product_image', 'Product image', 'callback_handle_upload|xss_clean');
               
                if($action == 'add'){
                    $this->form_validation->set_rules('price','Price','required|integer');                
                }
                else if($action == 'edit'){
                    $this->form_validation->set_rules('price','Price','required|decimal'); 
                }
                $data = $this->products_model->get_detail_by_id($id, $language_id);
                //pr($this->check_unique_slug_url());exit;
                /* -------------------------------------------------------------------------------------------------------------------- */
                if ($this->form_validation->run($this) == true)
                {
                    $product_image = trim(strip_tags($_POST['product_image']));
                    $this->products_model->name = $name;
                    $this->products_model->slug = $slug_url;
                    $this->products_model->description = $description;
                    $this->products_model->status = $status;
                    $this->products_model->price = $price;
                    $this->products_model->featured = $featured;
                    $this->products_model->category_id = $category_id;
                    $this->products_model->meta_keywords = $meta_keywords;
                    $this->products_model->meta_description = $meta_description;
                    $this->products_model->product_image = $product_image;

                    if (count($data) > 0)
                    {
                        $this->products_model->update($id, $language_id);
                        $this->theme->set_message(lang('msg-update-success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_id = $this->products_model->get_last_id();
                            $id = $last_id + 1;
                        }
                        $this->products_model->insert($id, $language_id);
                        $this->theme->set_message(lang('msg-add-success'), 'success');
                    }
                    redirect($this->section_name.'/products/index/' . $language_detail[0]['l']['language_code']);
                }
            }

            if (!$this->input->post())
            {
                if (isset($id) && $id != '' && $id != '0')
                {
                    $result = $this->products_model->get_detail_by_id($id, $language_detail[0]['l']['id']);
                }
            }
            else
            {
                $result = $this->input->post();
                
            }
            $language_list = $this->languages_model->get_languages(); // get list of languages
            // Breadcrumb settings
            if ($action == "add")
            {
                $this->theme->set('page_title', lang('add_Product'));
                $this->breadcrumb->add(lang('add_Product'));
                $id = '';
            }
            elseif ($action == "edit")
            {
                $this->theme->set('page_title', lang('edit_Product'));
                $this->breadcrumb->add(lang('edit_Product'));
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
            $data['result'] = $result;
            $data['content'] = $this->load->view('add-edit-action', $data, TRUE);
            $this->theme->view($data, 'add-edit');
        }
        else
        {
            $this->theme->set_message(lang('permission-not-allowed'), 'error');
            redirect($this->section_name.'/users');
            exit;
        }
    }

    /**
     * action to add/edit Product page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_action($action, $language_code = '', $id = 0, $ajax_load = 1)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $ajax_load = intval($ajax_load);

        //Initialize
        $data = array();
        $list = array();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        if (isset($id) && $id != '' && $id != '0')
        {
            $list = $this->products_model->get_detail_by_id($id, $language_detail[0]['l']['id']);
        }
        //Variable assignments to view
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['result'] = $list;
        if ($ajax_load == '1')
            echo $this->load->view('add-edit-action', $data);
        else
            return $this->load->view('add-edit-action', $data);
    }

    /**
     * action view to view product page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function view($language_code = '', $id = 0)
    {
        //Type Casting        
        $language_code = strip_tags($language_code);
        $id = intval($id);

        //Initialize

        $result = array();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        if (isset($id) && $id != '' && $id != '0')
        {
            $result = $this->products_model->get_detail_by_id($id, $language_detail[0]['l']['id']);
        }

        $language_list = $this->languages_model->get_languages(); // get list of languages
        // Breadcrumb settings
        
        $this->theme->set('page_title', lang('view_product'));
        $this->breadcrumb->add(lang('view_product'));        
        //Variable assignments to view        
        $data = array();
        $data['id'] = $id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['languages'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['result'] = $result;
        $data['content'] = $this->load->view('admin_ajax_view', $data, TRUE);
        $this->theme->view($data);
    }

    /**
     * action to add/edit product page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_view($language_code = '', $id = 0, $ajax_load = 1)
    {
        //Type Casting        
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $ajax_load = intval($ajax_load);

        //Initialize
        $result = array();
        $data = array();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic        
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        if (isset($id) && $id != '' && $id != '0')
        {
            $result = $this->products_model->get_detail_by_id($id, $language_detail[0]['l']['id']);
        }
        //Variable assignments to view                
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['result'] = $result;
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_view', $data);
        else
            return $this->load->view('admin_ajax_view', $data);
    }

    // Function to delete the product record and related url management record
    function delete_product()
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
            
            $data['product'] = $this->products_model->delete_product($id);
            
            if ($slug_url != '')
            {
                $this->urls_model->delete_url_by_slug($slug_url);
            }
            $message = $this->theme->message(lang('delete_success'), 'success');
        }
        else
        {
            $message = $this->theme->message(lang('invalid-id-msg'), 'error');
        }
        echo $message;
    }

    /**
     * function check_unique_slug_url to check unique slug url
     */
    public function check_unique_slug_url()
    {
        //variable assignement
        $id = '';

        //Get url management id
        if ($this->input->post('old_slug_url') != '')
        {   
            $product_detail = $this->products_model->get_product_detail_by_slug($this->input->post('old_slug_url'));
            if(!empty($product_detail))
            {
                $id = $product_detail[0]['products']['id'];
            }
        }
        $slug_url = $this->input->post('slug');
        $result = $this->products_model->check_unique_slug($slug_url, $id);
        //pre($result);
        if (count($result) > 0)
        {   
            $this->form_validation->set_message('check_unique_slug_url', lang('msg-alvailable-slug_url'));
            return false;
        }
        else
        {
            return true;
        }
    }

    function image_index($product_id = '')
    {

        $product_id = intval($product_id);
        //Set page title
        $this->theme->set('page_title', lang('product_image_list'));

        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view

        $this->breadcrumb->add(lang('product_image_management'), base_url() .$this->section_name. '/products/image_index/' . $product_id);

        $data['product_id'] = $product_id;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->theme->view($data, 'admin_index_image');
    }

    /**
     * action to load list of product image based on product 
     * @param string $product
     */
    function ajax_image_index($product_id = '')
    {
        //Type Casting
        $product_id = intval($product_id);


        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->products_image_model->record_per_page = $this->record_per_page;
        $this->products_image_model->offset = $offset;
        //pr($_REQUEST);exit;
        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_status']))
            {
                $this->products_image_model->search_status = $data['search_status'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->products_image_model->sort_by = $data['sort_by'];
                $this->products_image_model->sort_order = $data['sort_order'];
            }
            if (isset($data['type']) && $data['type'] == 'delete')
            {
                $this->products_image_model->delete_records($data['ids']);
                echo $this->theme->message(lang('delete_success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                $this->products_image_model->active_records($data['ids']);
                 echo $this->theme->message(lang('product-image-active-success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                $this->products_image_model->inactive_records($data['ids']);
                 echo $this->theme->message(lang('product-image-inactive-success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                $this->products_image_model->active_all_records();
                 echo $this->theme->message(lang('product-images-active-success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                $this->products_image_model->inactive_all_records();
                   echo $this->theme->message(lang('product-images-inactive-success'), 'success');
                    exit;
            }
        }

        //Logic


        $list = $this->products_image_model->get_listing($product_id);
        $this->products_image_model->_record_count = true;
        $total_records = $this->products_image_model->get_listing($product_id);
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'list' => $list,
            'product_id' => $product_id,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search' => $this->input->post('search'),
            'sort_by' => $this->products_image_model->sort_by,
            'sort_order' => $this->products_image_model->sort_order,
            'search_status' => $this->products_image_model->search_status
        );
        $this->theme->view($data, 'admin_ajax_image_index');
    }

    /**
     * action to add/edit product image  page
     * @param string $action : add or edit
     * @param string $product id
     * @param string $id : if in edit mode
     */
    function image_action($action, $product_id = 0, $id = 0)
    {
        //echo $product_id;exit;
        //Type Casting
        $action = trim(strip_tags($action));
        $product_id = intval($product_id);
        $id = intval($id);
        if ($this->input->post('submit'))
        {
            $status = trim(strip_tags($this->input->post('status')));
            $product_image = '';
        }


        if ($action == 'add' || $action == 'edit')
        {
            $result = array();

            if ($this->input->post('submit'))
            {
                //Validation Check
                $this->load->library('form_validation');

                $this->form_validation->set_rules('status', 'status', 'required|xss_clean');

                $this->form_validation->set_rules('product_image', 'Product image', 'callback_handle_upload|xss_clean');

                $data = $this->products_image_model->get_detail_by_id($id, $product_id);

                //echo $this->handle_upload();exit;
                /* -------------------------------------------------------------------------------------------------------------------- */
                if ($this->form_validation->run($this) == true)
                {
                    $product_image = trim(strip_tags($_POST['product_image']));
                    $this->products_image_model->status = $status;
                    $this->products_image_model->product_image = $product_image;

                    if (count($data) > 0)
                    {
                        $this->products_image_model->update($id, $product_id);
                        $this->theme->set_message(lang('msg-update-image-success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_id = $this->products_image_model->get_last_id();
                            $id = $last_id + 1;
                        }
                        $this->products_image_model->insert($product_id);
                        $this->theme->set_message(lang('msg-add-image-success'), 'success');
                    }
                    redirect($this->section_name.'/products/image_index/' . $product_id);
                }
            }

            if (!$this->input->post())
            {
                if (isset($id) && $id != '' && $id != '0')
                {
                    $result = $this->products_image_model->get_detail_by_id($id, $product_id);
                }
            }
            else
            {
                $result = $this->input->post();
            }

            // Breadcrumb settings
            if ($action == "add")
            {
                $this->theme->set('page_title', lang('add_product_image'));
                $this->breadcrumb->add(lang('product_image_management'), base_url() .$this->section_name. '/products/image_index/' . $product_id);
                $this->breadcrumb->add(lang('add_product_image'));
                $id = '';
            }
            elseif ($action == "edit")
            {
                $this->theme->set('page_title', lang('edit_product_image'));
                $this->breadcrumb->add(lang('product_image_management'), base_url() .$this->section_name. '/products/image_index/' . $product_id);
                $this->breadcrumb->add(lang('edit_product_image'));
            }

            //Variable assignments to view

            $data = array();
            $data['action'] = $action;
            $data['id'] = $id;
            $data['product_id'] = $product_id;
            $data['csrf_token'] = $this->security->get_csrf_token_name();
            $data['csrf_hash'] = $this->security->get_csrf_hash();
            $data['result'] = $result;
            $data['content'] = $this->load->view('add-edit-action-image', $data, TRUE);
            $this->theme->view($data, 'add-edit-image');
        }
        else
        {
            $this->theme->set_message(lang('permission-not-allowed'), 'error');
            redirect($this->section_name.'/users');
            exit;
        }
    }

    /**
     * action to add/edit product image  page load form from ajax based on product
     * @param string $action : add or edit
     * @param string $product_id
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_image_action($action, $product_id = 0, $id = 0, $ajax_load = 1)
    {

        //Type Casting
        $action = trim(strip_tags($action));
        $product_id = intval($product_id);
        $id = intval($id);
        $ajax_load = intval($ajax_load);

        //Initialize
        $data = array();
        $list = array();

        if (isset($id) && $id != '' && $id != '0')
        {
            $list = $this->products_image_model->get_detail_by_id($id, $product_id);
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

    // Function to delete the product image record and related url management record
    function delete_product_image()
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
            $data['product'] = $this->products_image_model->delete_product($id);
            if ($slug_url != '')
            {
                $this->urls_model->delete_url_by_slug($slug_url);
            }
            $message = $this->theme->message(lang('delete_success_product_image'), 'success');
        }
        else
        {
            $message = $this->theme->message(lang('invalid-id-msg'), 'error');
        }
        echo $message;
    }

    // To upload and validate image upload
    public function handle_upload()
    {
        if ($_FILES['product_image']['name'] != '' && $_FILES['product_image']['tmp_name'] != '')
        {

            $config['upload_path'] = "assets/uploads/products/main/";
            $config['allowed_types'] = 'gif|png|jpg|png';
            $config['max_size'] = '10299'; 
            $config['file_name'] = 'product-image-' . date("Ymd-His");
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

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
                $config['source_image'] = 'assets/uploads/products/main/' . $uploaded_file_details['file_name'];
                $config['new_image'] = 'assets/uploads/products/thumbs/' . $uploaded_file_details['file_name'];
                $config['width'] = 100;
                $config['height'] = 100;

                //load resize library
                $this->load->library('image_lib');
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $_POST['product_image'] = $uploaded_file_details['file_name'];

                if ($this->input->post('hdnphoto'))
                {
                    unlink('assets/uploads/products/main/' . $this->input->post('hdnphoto'));
                    unlink('assets/uploads/products/thumbs/' . $this->input->post('hdnphoto'));
                }
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
    
    /* set search values in session */
    function session_set($language_code)
    {
        //Initialize
        $array = array();
        //Type Casting
        $language_code = strip_tags($language_code);       
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        
        $data = $this->input->post();
     
        $array = array(            
            'search_status' => $this->input->post('search_status'),
            'search' => $this->input->post('search'),
            'search_slug' => $this->input->post('search_slug'),
            'search_name' => $this->input->post('search_name'),   
            'search_category' => $this->input->post('search_category'),
            'search_from' => $this->input->post('search_from'),
            'search_to' => $this->input->post('search_to'),
            'search_lang' => $language_code
        );         
       $this->session->set_custom_userdata($this->section_name,$array);
    }
    

}

?>