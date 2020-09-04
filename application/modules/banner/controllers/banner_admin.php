<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *  Banner Admin Controller
 *
 *  Banner Admin controller to display add / Edit / Delete / List Banner/Ad for each language.
 * 
 * @package CIDemoApplication
 *  
 * @copyright	(c) 2013
 * @author HP & KS
 */
class Banner_admin extends Base_Admin_Controller
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
        $this->config->load('banner');
        $this->banner_config_data = $this->config->item('banner');

        // load required models
        $this->load->model('country/country_model');
        $this->load->model('states/states_model');
        $this->load->model('city/city_model');
        $this->load->model('urls/urls_model');

        // Breadcrumb settings
        $this->breadcrumb->add('Banner Management', base_url() .$this->section_name. '/banner');
    }

    /**
     * function accessRules to check page access     
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('action','index', 'ajax_index', 'ajax_action', 'get_related_state', 'get_related_city', 'view_data', 'ajax_view', 'visitor_index','visitor_ajax_index', 'set_session', 'delete'),
                'users' => array('@'),
            )
        );
    }

    /**
     * action to display language wise list of banner/ad
     * @param string $language_code
     */
    function index($lang_code = '')
    {
        //Type Casting
        $language_code = strip_tags($lang_code);
        if ($lang_code == '')
        {
            $this->session->set_userdata('search','');
            $this->session->set_userdata('searchval','');
            $this->session->set_userdata('lang_code','');
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //Logic             
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        
        //Set page title
        $this->theme->set('page_title', 'Banner List');

        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'language_code' => $language_detail[0]['l']['language_code'],
            'lang_code' => $lang_code,
            'language_id' => $language_id,
            'languages_list' => $language_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );       
        $this->theme->view($data);
    }

    /**
     * action to load list of banner/ad based on language passed or from default language
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
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->banner_model->record_per_page = $this->record_per_page;
        $this->banner_model->offset = $offset;
        $search = '';
        $search_lang = '';
        $search_lang =$this->session->userdata('search_lang');
        if($search_lang == $language_code)
            $search =$this->session->userdata('search');
        
        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();            
            if(isset($data['search']))
            {
                $search = $this->input->post('search');
            }
            if (isset($data['search_title']))
            {
                $this->banner_model->search_title = $data['search_title'];
            }
            else
            {
                if($search == "title")
                    $this->banner_model->search_title = $this->session->userdata('searchval');
            }
            if (isset($data['search_status']))
            {
                $this->banner_model->search_status = $data['search_status'];
            }
            else
            {
                if($search == "status")
                    $this->banner_model->search_status = $this->session->userdata('searchval');
            }
            if (isset($data['search_section']))
            {
                $this->banner_model->search_section = $data['search_section'];
            }
            else
            {
                if($search == "section")
                    $this->banner_model->search_section = $this->session->userdata('searchval');
            }            
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->banner_model->sort_by = $data['sort_by'];
                $this->banner_model->sort_order = $data['sort_order'];
            }
            if(isset($data['type']) && $data['type']=='delete')
            {
                if($this->banner_model->delete_records($data['ids']))
                {
                     echo $this->theme->message(lang('delete_success'), 'success');exit; 
                }
            }
            if(isset($data['type']) && $data['type']=='active')
            {
                if($this->banner_model->active_records($data['ids']))
                {
                    echo $this->theme->message(lang('banner-active-success'), 'success');exit; 
                }
            }
            if(isset($data['type']) && $data['type']=='inactive')
            {
                if($this->banner_model->inactive_records($data['ids']))
                {
                    echo $this->theme->message(lang('banner-inactive-success'), 'success');exit;  
                }
            }
            if(isset($data['type']) && $data['type']=='active_all')
            {
                if($this->banner_model->active_all_records())
                {
                    echo $this->theme->message(lang('banner-active-success'), 'success');exit; 
                }
            }
            if(isset($data['type']) && $data['type']=='inactive_all')
            {
                if($this->banner_model->inactive_all_records())
                {
                    echo $this->theme->message(lang('banner-inactive-success'), 'success');exit;
                }
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $banner_list = $this->banner_model->get_advertisement_listing($language_detail[0]['l']['id']);
        $this->banner_model->_record_count = true;
        $total_records = $this->banner_model->get_advertisement_listing($language_detail[0]['l']['id']);        
        $country_list_result = $this->country_model->get_country_listing($language_id);
        $country_list['']="---All Countries---";
        foreach($country_list_result as $country)
        {
            $country_list[$country['c']['country_id']] = $country['c']['country_name'];
        }        
        $state_list_result = $this->states_model->get_state_listing($language_id);
        $state_list['']="---All States---";
        foreach($state_list_result as $state)
        {
            $state_list[$state['s']['state_id']] = $state['s']['state_name'];
        }
        $city_list_result = $this->city_model->get_city_listing($language_id);
        $city_list['']="---All Cities---";
        foreach($city_list_result as $city)
        {
            $city_list[$city['c']['city_id']] = $city['c']['city_name'];
        }        
        
        // Breadcrumb settings
        // No breadcrumb as it's index page         
        //Variable assignments to view        
        $data = array(
            'banner_list' => $banner_list,
            'country_list' => $country_list,
            'state_list' => $state_list,
            'city_list' => $city_list,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search' => $search,
            'search_title' => $this->banner_model->search_title,
            'search_status' => $this->banner_model->search_status,
            'search_section' => $this->banner_model->search_section,
            'sort_by' => $this->banner_model->sort_by,
            'sort_order' => $this->banner_model->sort_order,
            'banner_data' => $this->banner_config_data,
        );
        $this->theme->view($data, 'admin_ajax_index');
    }

    /**
     * action to add/edit banner/ad
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function action($action, $language_code, $id = 0)
    {
        //Initialize
        $banner_list = array();
        $banner_list_result = array();
        $data = array();
            
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $this->load->library('form_validation');
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];        
        if ($this->input->post('bannersubmit'))
        {            
            $title = trim(strip_tags($this->input->post('title')));
            $description  = trim(strip_tags($this->input->post('description')));
            $section_id = intval($this->input->post('section_id'));
            if(isset($section_id) && $section_id == 1)
            {
                $page_id = '';
                $position = '';
                $country_id = '';
                $state_id = '';
                $city_id = '';
            }
            else
            {
                $page_id = intval(trim(strip_tags($this->input->post('page_id'))));
                $position = trim(strip_tags($this->input->post('position')));
                $country_id = intval(trim(strip_tags($this->input->post('country_id'))));
                $state_id = intval(trim(strip_tags($this->input->post('state_id'))));
                $city_id = intval(trim(strip_tags($this->input->post('city_id'))));
            }            
            $order = trim(strip_tags($this->input->post('order')));
            $banner_type = trim(strip_tags($this->input->post('type')));
            $link = trim(strip_tags($this->input->post('link')));            
            $status = trim(strip_tags($this->input->post('status')));
        }              
        if ($action == 'add' || $action == 'edit')
        {            
            //to get country list for country dropdown
            $country_list_result = $this->country_model->get_country_listing($language_id);
            $country_list['']="---Select Country---";
            foreach($country_list_result as $country)
            {
                $country_list[$country['c']['country_id']] = $country['c']['country_name'];
            }

            //for state dropdown
            $state_list_result = $this->states_model->get_state_listing($language_id);
            $state_list['']="---Select State---";
            
            // For city dropdown
            $city_list_result = $this->city_model->get_city_listing($language_id);
            $city_list['']="---Select City---";                       
            if ($this->input->post('bannersubmit'))
            {
                //Validation Check                
                $this->form_validation->set_rules('title', 'Title', 'required|callback_check_unique_title['.$language_id.','.$id.']|xss_clean');
                $this->form_validation->set_rules('order', 'Order', 'is_natural|xss_clean');
                $this->form_validation->set_rules('link', 'link/URL ', 'callback_is_valid_url|xss_clean');
                $this->form_validation->set_rules('type', 'Type', 'required|xss_clean');
                $this->form_validation->set_rules('section_id', 'Section', 'required|xss_clean');
                $this->form_validation->set_rules('page_id', 'Page', 'required|xss_clean');
                $this->form_validation->set_rules('position', 'Position', 'required|xss_clean');
                if($banner_type == AD_IMAGE)
                {
                    $this->form_validation->set_rules('image', 'Image', 'callback_handle_upload['.$language_id.']|xss_clean');
                }
                if($banner_type == AD_EMBEDDED)
                {
                    $this->form_validation->set_rules('code', 'Embedded code', 'required|xss_clean');
                }
                if ($this->form_validation->run($this) == true)
                {
                    // To get data of uploaded image
                    if($banner_type == AD_IMAGE)
                    {
                        $image_url = trim(strip_tags($_POST['image']));
                        $embedded_code = '';
                    }
                    if($banner_type == AD_EMBEDDED)
                    {
                        $link = '';
                        $image_url = '';
                        $embedded_code = trim($this->input->post('code'));
                    }
                    $banner_data = $this->banner_model->is_advertisement_exist($id, $language_id);
                    $lang_id = intval($language_id);
                    $this->banner_model->title = $title ;
                    $this->banner_model->description  = $description;
                    $this->banner_model->section_id = $section_id;
                    $this->banner_model->page_id = $page_id;
                    $this->banner_model->position = $position;
                    $this->banner_model->order = $order;
                    $this->banner_model->banner_type = $banner_type;
                    $this->banner_model->image_url = $image_url;
                    $this->banner_model->link = $link;
                    $this->banner_model->embedded_code = $embedded_code;
                    $this->banner_model->country_id = $country_id;
                    $this->banner_model->state_id = $state_id;
                    $this->banner_model->city_id = $city_id;
                    $this->banner_model->status = $status;                    
                    if (count($banner_data) > 0)
                    {
                        $ad_id = intval($id);
                        $this->banner_model->update_advertisement($ad_id, $lang_id);
                        $this->theme->set_message(lang('msg-update-success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_banner_id = $this->banner_model->get_last_advertisement_id();
                            $id = $last_banner_id + 1;
                        }
                        $ad_id = intval($id);
                        $this->banner_model->insert_advertisement($ad_id, $lang_id);
                        $this->theme->set_message(lang('msg-add-success'), 'success');
                    }
                    redirect($this->section_name.'/banner/index/' . $language_detail[0]['l']['language_code']);
                }
            }
            if (!$this->input->post())
            {
                if (isset($id) && $id != '' && $id != '0')
                {
                    $banner_list_result = $this->banner_model->get_advertisement_detail_by_id($id, $language_detail[0]['l']['id']);
                    $banner_list = array_merge($banner_list_result[0]['ad'],$banner_list_result[0]['c'],$banner_list_result[0]['s'],$banner_list_result[0]['cnt'],$banner_list_result[0]['l']);
                    $banner_list['status'] = $banner_list_result[0]['ad']['status'];
                    if($banner_list['country_id'] != '0')
                    {
                        $state_list_result = $this->states_model->get_state_listing_by_country($language_id,$banner_list['country_id']);
                        foreach($state_list_result as $result)
                        {
                            $state_list[$result['s']['state_id']] = $result['s']['state_name'];
                        }
                    }
                    if($banner_list['state_id'] != '0')
                    {
                        $city_list_result = $this->city_model->get_city_listing_by_state($language_id,$banner_list['state_id']);
                        foreach($city_list_result as $result)
                        {
                            $city_list[$result['c']['city_id']] = $result['c']['city_name'];
                        }
                    }
                }
            }
            else
            {
                $banner_list = $this->input->post();
            }
            $language_list = $this->languages_model->get_languages(); // get list of languages
            // Breadcrumb settings
            if ($action == "add")
            {
                $this->theme->set('page_title', $this->lang->line('add_banner'));
                $this->breadcrumb->add($this->lang->line('add_banner'));
                $id = '';
            }
            elseif ($action == "edit")
            {
                $this->theme->set('page_title', $this->lang->line('edit_banner'));
                $this->breadcrumb->add($this->lang->line('edit_banner'));
            }
            
            //Variable assignments to view        
            $data = array(
                'action' => $action,
                'id' => $id,
                'language_code' => $language_detail[0]['l']['language_code'],
                'language_name' => $language_detail[0]['l']['language_name'],
                'language_id' => $language_id,
                'csrf_token' => $this->security->get_csrf_token_name(),
                'csrf_hash' => $this->security->get_csrf_hash(),
                'languages' => $language_list,
                'city_list' => $city_list,
                'country_list' => $country_list,
                'state_list' => $state_list,
                'banner' => $banner_list,
                'banner_data' => $this->banner_config_data                
            );            
            $data['content'] = $this->load->view('admin_ajax_action', $data, TRUE);
            $this->theme->view($data, 'admin_action');
        }
        else
        {
            $this->theme->set_message(lang('permission-not-allowed'), 'error');
            redirect($this->section_name.'/users');
            exit;
        }
    }

    /**
     * action to add/edit banner load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_action($action, $language_code, $id = 0, $ajax_load = 1)
    {        
        //Initialize
        $city_list = array();
        $city_list_result = array();
        $data = array();
        $banner_list = array();      
        
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $ajax_load = intval($ajax_load);               
        if($this->input->post('section_id'))
        {
            $banner_list['section_id'] = $this->input->post('section_id');
        }
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic        
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        // To get country list for country dropdown
        $country_list_result = $this->country_model->get_country_listing($language_id);
        $country_list['']="---Select Country---";
        foreach($country_list_result as $country)
        {
            $country_list[$country['c']['country_id']] = $country['c']['country_name'];
        }
        $state_list_result = $this->states_model->get_state_listing($language_id);
        $state_list['']="---Select State---";        
        $city_list_result = $this->city_model->get_city_listing($language_id);
        $city_list['']="---Select City---";        
        if (isset($id) && $id != '' && $id != '0')
        {
            $banner_list_result = $this->banner_model->get_advertisement_detail_by_id($id, $language_detail[0]['l']['id']);
            if (!empty($banner_list_result))
            {
                $banner_list = array_merge($banner_list_result[0]['ad'],$banner_list_result[0]['c'],$banner_list_result[0]['s'],$banner_list_result[0]['cnt'],$banner_list_result[0]['l']);
                $banner_list['status'] = $banner_list_result[0]['ad']['status'];
                if($banner_list['country_id'] != '0')
                {
                    $state_list_result = $this->states_model->get_state_listing_by_country($language_id,$banner_list['country_id']);
                    foreach($state_list_result as $result)
                    {
                        $state_list[$result['s']['state_id']] = $result['s']['state_name'];
                    }
                }
                if($banner_list['state_id'] != '0')
                {
                    $city_list_result = $this->city_model->get_city_listing_by_state($language_id,$banner_list['state_id']);
                    foreach($city_list_result as $result)
                    {
                        $city_list[$result['c']['city_id']] = $result['c']['city_name'];
                    }
                }
            }
        }
        
        //Variable assignments to view
        $data = array(
            'action' => $action,
            'id' => $id,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'country_list' => $country_list,
            'state_list' => $state_list,
            'city_list' => $city_list,
            'banner' => $banner_list,
            'banner_data' => $this->banner_config_data
        );        
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_action', $data);
        else
            return $this->load->view('admin_ajax_action', $data);
    }
    
    /**
     * action view to view banner page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function view_data($language_code, $id = 0)
    {
         //Initialize        
        $banner_list = array();
        $banner_list_result = array();
        $data = array();   
        
        //Type Casting        
        $language_code = strip_tags($language_code);
        $id = intval($id);       
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        if (isset($id) && $id != '' && $id != '0')
        {
            $banner_list_result = $this->banner_model->get_advertisement_detail_by_id($id, $language_detail[0]['l']['id']);
            $banner_list = $banner_list_result[0];
        }
        $language_list = $this->languages_model->get_languages(); // get list of languages
     
        // Breadcrumb settings
        $this->theme->set('page_title', lang('view_banner'));
        $this->breadcrumb->add(lang('view-banner'));
        
        //Variable assignments to view        
        $data = array(
            'id' => $id,
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_id' => $language_id,
            'languages' => $language_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'banner' => $banner_list,
            'banner_data' => $this->banner_config_data
        );        
        $data['content'] = $this->load->view('admin_ajax_view', $data, TRUE);
        $this->theme->view($data);
    }

    /**
     * action to add/edit banner/ad page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_view($language_code, $id = 0, $ajax_load = 1)
    {
        //Initialize
        $banner_list = array();
        $banner_list_result = array();
        $data = array();
        
        //Type Casting        
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $ajax_load = intval($ajax_load);        
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic        
        $language_detail = $this->languages_model->get_languages_by_code($language_code);        
        if (isset($id) && $id != '' && $id != '0')
        {
            $banner_list_result = $this->banner_model->get_advertisement_detail_by_id($id, $language_detail[0]['l']['id']);
            if (!empty($banner_list_result))
            {
                if (!empty($banner_list_result[0]['c']))
                    $banner_list = $banner_list_result[0];
            }
        }
        
        //Variable assignments to view  
        $data = array(
            'id' => $id,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'banner' => $banner_list,
            'banner_data' => $this->banner_config_data
        );        
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_view', $data);
        else
            return $this->load->view('admin_ajax_view', $data);
    }       

    // Function to delete the banner/ad record
    function delete()
    {
        //Initialise
        $id = $this->input->post('id');
        $slug_url = $this->input->post('slug_url');

        //Type casting
        $id = intval($id);

        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $data['city'] = $this->banner_model->delete_advertisement($id);
            $message = $this->theme->message(lang('delete_success'), 'success');
        }
        else
        {
            $message = $this->theme->message(lang('invalid-id-msg'), 'error');
        }
        echo $message;
    }
      
    // Function to get states related to selected country
    public function get_related_state()
    {
        //Initialize
        $data = array();
        //Type Casting
        $country_id = trim($this->input->post('country_id'));
        $lang_id = trim($this->input->post('lang_id'));        
        //Logic
        $data['pages'] = $this->states_model->get_state_listing_by_country($lang_id,$country_id);
        $this->theme->view($data);
    }
    
    // Function to get cities related to selected state
    public function get_related_city()
    {
        //Initialize
        $data = array();
        //Type Casting
        $state_id = trim($this->input->post('state_id'));
        $lang_id = trim($this->input->post('lang_id'));        
        //Logic
        $data['pages'] = $this->city_model->get_city_listing_by_state($lang_id,$state_id);
        $this->theme->view($data);
    }
    
    /**
     * Function visitior_index to display ad visitors
     * @param type $language_code
     */    
    function visitor_index($language_code)
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
        $this->theme->set('page_title', 'Visitor List');
        $this->breadcrumb->add($this->lang->line('visitor-list'));


        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->theme->view($data,'admin_visitor_index');
    }

    /**
     * Function visitior_ajax_index to display ad visitors by language
     * @param type $language_code
     */ 
    function visitor_ajax_index($language_code)
    {
        //Type Casting
        $language_code = strip_tags($language_code);
       
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->banner_model->record_per_page = $this->record_per_page;
        $this->banner_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data_array = $this->input->post();            
            if (isset($data_array['sort_by']) && isset($data_array['sort_order']))
            {
                
                $this->banner_model->sort_by = $data_array['sort_by'];
                $this->banner_model->sort_order = $data_array['sort_order'];
            }
            if(isset($data_array['end_date']) && isset($data_array['start_date']))
            {
                $this->banner_model->start_date=trim(strip_tags($data_array['start_date']));
                $this->banner_model->end_date=trim(strip_tags($data_array['end_date']));
            }
            if(isset($data_array['ad_id']))
            {
               // echo $data['ad_id'];exit;
                $this->banner_model->ad_id=trim(strip_tags($data_array['ad_id']));
            
            }
            if(isset($data_array['user_id']))
            {
                $this->banner_model->user_id=trim(strip_tags($data_array['user_id']));

            }           
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $visitor_list = $this->banner_model->get_visitor_listing($language_detail[0]['l']['id']);
        $this->banner_model->_record_count = true;
        $total_records = $this->banner_model->get_visitor_listing($language_detail[0]['l']['id']);
        $ad_list_result=$this->banner_model->get_ad_by_languageId();
        $ad_list[0]='--select ad--';
        if(!empty($ad_list_result))
       {
        foreach($ad_list_result as $ad)
        {
            $ad_list[$ad['a']['ad_id']] = $ad['a']['title'];
        }
       }
    
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'visitor_list' => $visitor_list,
            'lang_id'=>$language_detail[0]['l']['id'],
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->banner_model->search_term,
            'sort_by' => $this->banner_model->sort_by,
            'sort_order' => $this->banner_model->sort_order,
            'start_date'=>$this->banner_model->start_date,
            'end_date'=>$this->banner_model->end_date,
            'ad_id'=>$this->banner_model->ad_id,
            'user_id'=>$this->banner_model->user_id,
            'ad_list'=>$ad_list
        );
        $this->theme->view($data, 'admin_visitor_ajax_index');
    }

    /**
     * Function to check duplicate entry for title in banner/ad 
     * @param type $title
     * @param type $data
     * @return boolean
     */
    public function check_unique_title($title,$data)
    {        
        $data = explode(',', $data);
        $language_id = $data[0];
        $ad_id = $data[1];
        $this->banner_model->title = $title;
        $this->banner_model->lang_id = $language_id;
        $result = $this->banner_model->check_unique_title();
        if ($result)
        {
            $adv_id = $result[0]['advertisement']['ad_id'];
            if($adv_id == $ad_id)
            {
                return true;
            }
            else 
            {
                $this->form_validation->set_message('check_unique_title', lang('msg_already_exists'));
                return false;
            }
        }
        else
        {
            return true;
        }
    }
    
    /**
     * To check if url is valid or not 
     * @param type $url
     * @return boolean
     */
    function is_valid_url($url)
    {        
        $url_regex = "/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~)|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d)|(([a-z]|\d)([a-z]|\d|-|\.|_|~)*([a-z]|\d)))\.)+(([a-z])|(([a-z])([a-z]|\d|-|\.|_|~)*([a-z])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~)|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~)|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~)|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~)|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i";
        if($url != '')
        {
            if(!preg_match($url_regex, $url))
            {
                $this->form_validation->set_message('is_valid_url', lang('msg-url-invalid'));
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }
    
    /**
     * To upload and validate image upload
     * @param type $image
     * @param type $language_id
     * @return boolean
     */
    public function handle_upload($image,$language_id)
    {
        if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
        {
            $config['upload_path'] = "assets/uploads/banner_ad_images/main";
            $config['allowed_types'] = 'gif|jpg|png';
            $config['file_name'] = 'banner-'.$this->input->post('title')."-".date("Ymd-His");
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('image'))
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
                $config['source_image'] = 'assets/uploads/banner_ad_images/main/'. $uploaded_file_details['file_name'];
                $config['new_image'] = 'assets/uploads/banner_ad_images/thumbs/'.$uploaded_file_details['file_name'];
                $config['width'] = THUMB_WIDTH;
                $config['height'] = THUMB_HEIGHT;

                //load resize library
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $_POST['image'] = $uploaded_file_details['file_name'];
                
                if($this->input->post('hdnphoto'))
                {
                    unlink('assets/uploads/banner_ad_images/main/'.$this->input->post('hdnphoto'));
                    unlink('assets/uploads/banner_ad_images/thumbs/' . $this->input->post('hdnphoto'));
                }
                return true;
            }
        }
        else
        {
            if($this->input->post('hdnphoto') != "")
            {
                    $_POST['image'] = $this->input->post('hdnphoto');
                    return true;
            }
            else
            {
                $this->form_validation->set_message('handle_upload', 'you must have to upload an image.');
                return false;    
            }
            
        }
    }
    
    //This function is to set session for search
    public function set_session($language_code)
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
          'search' => $this->input->post('search'),
          'searchval' => $this->input->post('searchval'),
          'search_lang' => $language_code
        );
        $this->session->set_userdata($array);
    }
    
}

?>