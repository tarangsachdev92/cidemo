<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  City Admin Controller
 *
 *  City Admin controller to display add / Edit / Delete / List City page for each language.
 * 
 * @package CIDemoApplication
 *  
 * @copyright	(c) 2013, TatvaSoft
 * @author KS
 */
class City_admin extends Base_Admin_Controller
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
        $this->load->model('country/country_model');
        $this->load->model('states/states_model');
        $this->load->model('urls/urls_model');

        // Breadcrumb settings
        $this->breadcrumb->add('City Management', base_url() .$this->section_name. '/city');
    }

    /**
     * function accessRules to check page access     
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('action', 'index', 'ajax_index', 'ajax_action', 'get_related_state', 'view_data', 'ajax_view', 'delete', 'set_session'),
                'users' => array('@'),
            )
        );
    }

    /**
     * action to display language wise list of city page
     * @param string $language_code
     */
    function index($lang_code = '')
    {
        //Initialize
        $data = array();
        
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
        $this->theme->set('page_title', 'City List');

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
     * action to load list of city based on language passed or from default language
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
        $this->city_model->record_per_page = $this->record_per_page;
        $this->city_model->offset = $offset;
        $search_lang ='';
        $search ='';
        $search_lang =$this->session->userdata('search_lang');
        if($search_lang == $language_code)
            $search =$this->session->userdata('search');
        
        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data_array = $this->input->post();
            if(isset($data_array['search']))
            {
                $search = $this->input->post('search');
            }
            if (isset($data_array['search_city']))
            {
                $this->city_model->search_city = $data_array['search_city'];
            }
            else
            {
                if($search == "city")
                    $this->city_model->search_city = $this->session->userdata('searchval');
            }
            if (isset($data_array['search_state']))
            {
                $this->city_model->search_state = $data_array['search_state'];
            }
            else
            {
                if($search == "state")
                    $this->city_model->search_state = $this->session->userdata('searchval');
            }
            if (isset($data_array['search_country']))
            {
                $this->city_model->search_country = $data_array['search_country'];
            }
            else
            {
                if($search == "country")
                    $this->city_model->search_country = $this->session->userdata('searchval');
            }
            if (isset($data_array['search_status']))
            {
                $this->city_model->search_status = $data_array['search_status'];
            }
            else
            {
                if($search == "status")
                    $this->city_model->search_status = $this->session->userdata('searchval');
            }
            if (isset($data_array['sort_by']) && $data_array['sort_order'])
            {
                $this->city_model->sort_by = $data_array['sort_by'];
                $this->city_model->sort_order = $data_array['sort_order'];
            }
            if(isset($data_array['type']) && $data_array['type']=='delete')
            {
                if($this->city_model->delete_records($data_array['ids']))
                {
                     echo $this->theme->message(lang('delete_success'), 'success');exit; 
                }
            }
            if(isset($data_array['type']) && $data_array['type']=='active')
            {
                if($this->city_model->active_records($data_array['ids']))
                {
                    echo $this->theme->message(lang('city-active-success'), 'success');exit; 
                }
            }
            if(isset($data_array['type']) && $data_array['type']=='inactive')
            {
                if($this->city_model->inactive_records($data_array['ids']))
                {
                    echo $this->theme->message(lang('city-inactive-success'), 'success');exit;  
                }
            }
            if(isset($data_array['type']) && $data_array['type']=='active_all')
            {
                if($this->city_model->active_all_records())
                {
                    echo $this->theme->message(lang('city-active-success'), 'success');exit; 
                }
            }
            if(isset($data_array['type']) && $data_array['type']=='inactive_all')
            {
                if($this->city_model->inactive_all_records())
                {
                    echo $this->theme->message(lang('city-inactive-success'), 'success');exit;
                }
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $city_list = $this->city_model->get_city_listing($language_detail[0]['l']['id']);
        $this->city_model->_record_count = true;
        $total_records = $this->city_model->get_city_listing($language_detail[0]['l']['id']);
        
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view        
        $data = array(
            'city_list' => $city_list,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search' => $search,
            'search_city' => $this->city_model->search_city,
            'search_state' => $this->city_model->search_state,
            'search_country' => $this->city_model->search_country,
            'search_status' => $this->city_model->search_status,
            'sort_by' => $this->city_model->sort_by,
            'sort_order' => $this->city_model->sort_order
        );
        $this->theme->view($data, 'admin_ajax_index');
    }

    /**
     * action to add/edit city page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function action($action, $language_code, $id = 0)
    {
        //Initialize
        $city_list = array();
        $city_list_result = array();
        $data = array();
        
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);        
        if ($this->input->post('citysubmit'))
        {
            $city_name = trim(strip_tags($this->input->post('city_name')));
            $country_id = trim(strip_tags($this->input->post('country_id')));
            $state_id = trim(strip_tags($this->input->post('state_id')));
            $status = trim(strip_tags($this->input->post('status')));
        }       
        if ($action == 'add' || $action == 'edit')
        {            
            if ($language_code == '')
            {
                $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
            }
            // Logic
            $language_detail = $this->languages_model->get_languages_by_code($language_code);
            $language_id = $language_detail[0]['l']['id'];            
            $language_list = $this->languages_model->get_languages(); // get list of languages           
            
            // To get countries
            $country_list_result = $this->country_model->get_country_listing($language_id);
            $country_list['']="---Select Country---";
            foreach($country_list_result as $country)
            {
                $country_list[$country['c']['country_id']] = $country['c']['country_name'];
            }
            $state_list_result = $this->states_model->get_state_listing($language_id);
            $state_list['']="---Select State---";                                  
            if ($this->input->post('citysubmit'))
            {
                $data = $this->input->post();                
                $country_list1['country_id'] = $data['country_id'];
                $state_list1['state_id'] = $data['state_id'];                
                $state_list_result = $this->states_model->get_state_listing_by_country($language_id,$data['country_id']);
                foreach($state_list_result as $result)
                {
                    $state_list[$result['s']['state_id']] = $result['s']['state_name'];
                }
                
                //Validation Check
                $this->load->library('form_validation');
                $this->form_validation->set_rules('city_name', 'City Name', 'required|callback_check_unique_cityname['.$language_id.','.$id.']|xss_clean');
                $this->form_validation->set_rules('country_id', 'Country', 'required|xss_clean');
                $this->form_validation->set_rules('state_id', 'State', 'required|xss_clean');
                if ($this->form_validation->run($this) == true)
                {
                    $city_data = $this->city_model->is_city_exist($id, $language_id);
                    
                    $this->city_model->city_name = ucwords($city_name);
                    $this->city_model->country_id = $country_id;
                    $this->city_model->state_id = $state_id;
                    $this->city_model->status = $status;                    
                    if (count($city_data) > 0)
                    {                        
                        $this->city_model->update_city($id, $language_id);
                        $this->theme->set_message(lang('msg-update-success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_city_id = $this->city_model->get_last_city_id();
                            $id = $last_city_id + 1;
                        }
                        $this->city_model->insert_city($id, $language_id);
                        $this->theme->set_message(lang('msg-add-success'), 'success');
                    }
                    redirect($this->section_name.'/city/index/' . $language_detail[0]['l']['language_code']);
                }
            }
            else 
            {
                if (!$this->input->post())
                {
                    if (isset($id) && $id != '' && $id != '0')
                    {
                        $city_list_result = $this->city_model->get_city_detail_by_id($id, $language_detail[0]['l']['id']);
                        $city_list = $city_list_result[0]['c'];
                        $country_list1 = $city_list_result[0]['cnt'];
                        if($country_list1['country_id'])
                        {
                            $state_list_result = $this->states_model->get_state_listing_by_country($language_id,$country_list1['country_id']);
                            foreach($state_list_result as $result)
                            {
                                $state_list[$result['s']['state_id']] = $result['s']['state_name'];
                            }
                        }
                        $state_list1 = $city_list_result[0]['s'];
                    }
                }
                else
                {
                    $city_list = $this->input->post();
                }

                // Breadcrumb settings
                if ($action == "add")
                {
                    $this->theme->set('page_title', $this->lang->line('add_city'));
                    $this->breadcrumb->add($this->lang->line('add_city'));
                    $id = '';
                    $country_list1 = '';
                    $state_list1 = '';
                }
                elseif ($action == "edit")
                {
                    $this->theme->set('page_title', $this->lang->line('edit_city'));
                    $this->breadcrumb->add($this->lang->line('edit_city'));
                }
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
                'city' => $city_list,
                'country_list' => $country_list,
                'state_list' => $state_list,
                'country' => $country_list1,
                'state' => $state_list1
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
     * action to add/edit city page load form from ajax based on language
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
        $country_list1 = array();
        $state_list1 = array();
        
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $ajax_load = intval($ajax_load);       
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic        
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        if (isset($id) && $id != '' && $id != '0')
        {
            $city_list_result = $this->city_model->get_city_detail_by_id($id, $language_detail[0]['l']['id']);
            if (!empty($city_list_result))
            {
                $city_list = $city_list_result[0]['c'];
                $country_list1 = $city_list_result[0]['cnt'];
                if($country_list1['country_id'])
                {
                    $state_list_result = $this->states_model->get_state_listing_by_country($language_id,$country_list1['country_id']);
                    foreach($state_list_result as $result)
                    {
                        $state_list[$result['s']['state_id']] = $result['s']['state_name'];
                    }
                }
                $state_list1 = $city_list_result[0]['s'];
            }
        }
        
        // To get countries
        $country_list_result = $this->country_model->get_country_listing($language_id);
        $country_list['']="---Select Country---";
        foreach($country_list_result as $country)
        {
            $country_list[$country['c']['country_id']] = $country['c']['country_name'];
        }
        $state_list_result = $this->states_model->get_state_listing($language_id);
        $state_list['']="---Select State---";
        
        //Variable assignments to view        
        $data = array(
            'action' => $action,
            'id' => $id,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'city' => $city_list,
            'country_list' => $country_list,
            'state_list' => $state_list,
            'country' => $country_list1,
            'state' => $state_list1
        );        
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_action', $data);
        else
            return $this->load->view('admin_ajax_action', $data);
    }

    // Function to delete the city record and related url management record
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
            $data['city'] = $this->city_model->delete_city($id);
            $message = $this->theme->message(lang('delete_success'), 'success');
        }
        else
        {
            $message = $this->theme->message(lang('invalid-id-msg'), 'error');
        }
        echo $message;
    }
    
    /**
     * action view to view city page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function view_data($language_code, $id = 0)
    {
        //Initialize
        $data = array();
        
        //Type Casting        
        $language_code = strip_tags($language_code);
        $id = intval($id);
        
        //Initialize
        $city_list = array();
        $city_list_result = array();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        if (isset($id) && $id != '' && $id != '0')
        {
            $city_list_result = $this->city_model->get_city_detail_by_id($id, $language_detail[0]['l']['id']);
            $city_list = $city_list_result[0];
        }
        $language_list = $this->languages_model->get_languages(); // get list of languages
        // Breadcrumb settings
        $this->theme->set('page_title', lang('view_city'));
        $this->breadcrumb->add(lang('view_city'));

        //Variable assignments to view        
        $data = array(
            'id' => $id,
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_id' => $language_id,
            'languages' => $language_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'city' => $city_list
        );        
        $data['content'] = $this->load->view('admin_ajax_view', $data, TRUE);
        $this->theme->view($data);
    }

    /**
     * action to add/edit city page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_view($language_code, $id = 0, $ajax_load = 1)
    {
        //Initialize
        $city_list = array();
        $city_list_result = array();
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
            $city_list_result = $this->city_model->get_city_detail_by_id($id, $language_detail[0]['l']['id']);
            if (!empty($city_list_result))
            {
                if (!empty($city_list_result[0]['c']))
                    $city_list = $city_list_result[0];
            }
        }
        //Variable assignments to view 
        $data = array(
            'id' => $id,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'city' => $city_list
        );        
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_view', $data);
        else
            return $this->load->view('admin_ajax_view', $data);
    }
    
    //To load states related to selected country in dropdown
    public function get_related_state()
    {
        $country_id = trim(strip_tags($this->input->post('country_id')));
        $lang_id = trim(strip_tags($this->input->post('lang_id')));
        $data = array();
        $data['pages'] = $this->states_model->get_state_listing_by_country($lang_id,$country_id);
        $this->theme->view($data);
    }
    
    //function check_unique_cityname is to check city name is unique or not
    public function check_unique_cityname($city_name,$data)
    {        
        $data = explode(',', $data);
        $language_id = $data[0];
        $city_id = $data[1];        
        $this->city_model->city_name = $city_name;
        $this->city_model->city_id = $city_id;
        $this->city_model->country_id = intval(mysql_escape_string($this->input->post('country_id')));
        $this->city_model->state_id = intval(mysql_escape_string($this->input->post('state_id')));
        $this->city_model->lang_id = $language_id;
        $result = $this->city_model->check_unique_cityname();        
        if ($result)
        {
            $ct_id = $result[0]['city_id'];
            if($ct_id == $city_id)
            {
                return true;
            }
            else 
            {
                $this->form_validation->set_message('check_unique_cityname', lang('msg_already_exists'));
                return false;
            }
        }
        else
        {
            return true;
        }
    }
    
    //This is to set session for search
    public function set_session($language_code)
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
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