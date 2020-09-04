<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Products Controller
 *
 *  Products controller to display Products page in front site.
 *  Also dispaly default page of Products.
 * 
 * @package CIDemoApplication
 *  
 
 */
class Products extends Base_Front_Controller
{
    /*
     * Create an instance
    */
    function __construct()
    {
        parent::__construct();
        
        // Login check for admin
        $this->access_control($this->access_rules());
        
        //load helpers
        $this->load->helper(array('url', 'cookie'));
        //load theme        
        $this->theme->set_theme("front");

        $this->load->model('products/products_image_model');
        
    }

    public function access_rules()
    {
        return array(
            array(
                'actions' => array( 'index', 'ajax_index','view', 'ajax_view',  'image_index', 'ajax_image_index','ajax_image_view'),
                'users' => array('*')
            ),

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
         $this->theme->set('page_title', lang('products'));
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
     * action to load list of cms based on language passed or from default language
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

        //set sort/search parameters in pagging
        if ($this->input->post())
        {   
            $data_array = $this->input->post();            
            if (isset($data_array['category_id']))
            {
                $this->products_model->category_id = $data_array['category_id'];
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        
        $list = $this->products_model->get_listing($language_detail[0]['l']['id']);
        $this->products_model->_record_count = true;
        $total_records = $this->products_model->get_listing($language_detail[0]['l']['id']);
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'list' => $list,
            'language_code' => $language_code,
            'language_id' => $language_id,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search' => $this->input->post('search'),
            'search_name' => $this->products_model->search_name,
            'search_status' => $this->products_model->search_status,
            'sort_by' => $this->products_model->sort_by,
            'sort_order' => $this->products_model->sort_order
        );
        if (isset($data_array['category_id']))
            {                
                $data['search_category'] = $data_array['category_id'];
            }        
        $this->theme->view($data);
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
            $result_images=$this->products_image_model->get_listing($id);
     
        }

        $language_list = $this->languages_model->get_languages(); // get list of languages
        // Breadcrumb settings

        $this->theme->set('page_title', lang('view_cms'));
        
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
        $data['result_images']=$result_images;
        $data['content'] = $this->load->view('ajax_view', $data, TRUE);
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
            $result_images=$this->products_image_model->get_listing($id);
        }



        //Variable assignments to view                
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['result'] = $result;
        $data['result_images']=$result_images;
        if ($ajax_load == '1')
            echo $this->load->view('ajax_view', $data);
        else
            return $this->load->view('ajax_view', $data);
    }

    

    function image_index($product_id = '')
    {

        $product_id = intval($product_id);
        //Set page title
        $this->theme->set('page_title', lang('product_image_list'));

        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view

        $this->breadcrumb->add(lang('product_image_management'), base_url() . 'admin/products/image_index/' . $product_id);

        $data['product_id'] = $product_id;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->theme->view($data);
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
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                $this->products_image_model->active_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                $this->products_image_model->inactive_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                $this->products_image_model->active_all_records();
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                $this->products_image_model->inactive_all_records();
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
        $this->theme->view($data, 'ajax_image_index');
    }
    
    
}


?>