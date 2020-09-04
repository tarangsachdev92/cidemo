<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Banner Front Controller
 *
 *  Banner Front controller to display advertise for each language.
 *
 * @package CIDemoApplication
 *
 * @author HP & KS
 */
class Banner extends Base_Front_Controller
{
    /*
     * Create an instance
     */
    function __construct()
    {
        parent::__construct();
        // Login check for user
        $this->access_control($this->access_rules());
        $this->breadcrumb->add('Banner', base_url() . 'Banner');
        $this->theme->set_theme("front");
        // Load required helpers
        $this->load->helper('url');
        // load required models
        $this->load->model('urls/urls_model');
        //load banner config
        $this->config->load('banner');
        $this->banner_config_data = $this->config->item('banner');
        $this->pages = $this->banner_config_data['pages'];
    }

    /**
     * function accessRules to check page access
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('index', 'ajax_index', 'home_index', 'add_visitor'),
                'users' => array('*'),
            )
        );
    }

    /**
     * action to display language wise list of banner 
     */
    function index($language_code = '')
    {
        //Initialize
        $data = array();
        
        //Type Casting
        $language_code = strip_tags($language_code);        
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();

        $this->banner_model->section_id = intval(HOME_BANNER);
        $home_banner_list = $this->banner_model->get_home_banner_listing($language_id);

        //Set page title
        $this->theme->set('page_title', 'Banner');

        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'banner_list' => $home_banner_list,
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_id' => $language_id,
            'languages_list' => $language_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' =>  $this->security->get_csrf_hash()
        );        
        $this->theme->view($data, 'banner_index');
    }

    /**
     * action to display language wise list of Home banners
     * @param string $language_code
     */
    function home_index($language_code = '')
    {
        //Initialize
        $data = array();
        
        //Type Casting
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        $this->banner_model->section_id = intval(HOME_BANNER);
        $home_banner_list = $this->banner_model->get_advertisement_listing($language_id);
        $this->banner_model->_record_count = true;
        $total_records = $this->banner_model->get_advertisement_listing($language_detail[0]['l']['id']);

        //Set page title
        $this->theme->set('page_title', 'Banner');

        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'banner_list' => $home_banner_list,
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_id' => $language_id,
            'languages_list' => $language_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'page_id' => array_search('About us', $this->pages),
            'total_records' => $total_records
        );        
        $this->theme->view($data, 'home_index');
    }

    /**
     * action to display language wise list of Ad-banners
     * @param string $language_code
     */
    function ajax_index($language_code)
    {
        //Initialize
        $data = array();
        
        //Type Casting
        $language_code = strip_tags($language_code);       
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Logic
        $user_id = isset($this->session->userdata['front']['user_id']) ? $this->session->userdata['front']['user_id'] : 0;
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        
        //Set page title
        $this->theme->set('page_title', 'Banner');
        
        //Variable assignments to view
        $data = array(
            'language_code' => $language_code,
            'language_id' => $language_id,
            'page_id' => array_search('Contact us', $this->pages),
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );        
        $this->theme->view($data, 'ajax_index');
    }

    /**
     * action to add visitor clicks on ads not within 24 hrs consecutive
     * @param string $language_code
     */
    function add_visitor()
    {
        //initialize
        $ip = trim(strip_tags($this->input->post('ip')));        
        $ip = $_SERVER['REMOTE_ADDR'];
        $this->banner_model->ip = $ip;
        $id = trim(strip_tags($this->input->post('id')));
        $this->banner_model->id = $id;

        //logic
        if (isset($ip) && isset($id))
        {
            $user_id = isset($this->session->userdata['front']['user_id']) ? $this->session->userdata['front']['user_id'] : 0;
            $this->banner_model->user_id = $user_id;

            //check if this IP is spam
            if ($this->banner_model->valid_visitor())
            {
                //insert entry
                $this->banner_model->insert_visitor();
            }
        }
    }
}
?>