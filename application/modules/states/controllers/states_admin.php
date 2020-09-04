<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  States_Admin Controller
 *
 *  State Admin controller to display add / Edit / Delete / List States for each language.
 *
 * @package CIDemoApplication
 *
 * @author HP
 */
class states_admin extends Base_Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        //load helpers
        $this->access_control($this->access_rules());

        // Load required helpers
        $this->load->helper('url');

        // load required models
        $this->load->model('country/country_model');

        // Breadcrumb settings
        $this->breadcrumb->add('States Management', base_url() . $this->section_name . '/states');
    }

    /**
     * function accessRules to check page access
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('action', 'index', 'set_session', 'ajax_index', 'ajax_action', 'delete', 'view', 'ajax_view'),
                'users' => array('@'),
            )
        );
    }

    /**
     * action to display language wise list of states
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
            $this->session->set_userdata('search', '');
            $this->session->set_userdata('searchval', '');
            $this->session->set_userdata('lang_code', '');
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        //Set page title
        $this->theme->set('page_title', 'State List');
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_id' => $language_id,
            'languages_list' => $language_list,
            'lang_code' => $lang_code,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );        
        $this->theme->view($data);
    }

    /**
     * action to load list of state based on language passed or from default language
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
        //set sort/search parameters in pagging
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->states_model->record_per_page = $this->record_per_page;
        $this->states_model->offset = $offset;
        $search_lang = '';
        $search = '';
        $search_lang = $this->session->userdata('search_lang');
        if ($search_lang == $language_code)
            $search = $this->session->userdata('search');
        if ($this->input->post())
        {
            $data_array = $this->input->post();
            if (isset($data_array['search']))
            {
                $search = $this->input->post('search');
            }
            if (isset($data_array['search_state_name']))
            {
                $this->states_model->search_state = $data_array['search_state_name'];
            }
            else
            {
                if ($search == "state")
                    $this->states_model->search_state = $this->session->userdata('searchval');
            }
            if (isset($data_array['search_country']))
            {
                $this->states_model->search_country = $data_array['search_country'];
            }
            else
            {
                if ($search == "country")
                    $this->states_model->search_country = $this->session->userdata('searchval');
            }
            if (isset($data_array['search_status']))
            {
                $this->states_model->search_status = $data_array['search_status'];
            }
            else
            {
                if ($search == "status")
                    $this->states_model->search_status = $this->session->userdata('searchval');
            }
            if (isset($data_array['sort_by']) && $data_array['sort_order'])
            {
                $this->states_model->sort_by = $data_array['sort_by'];
                $this->states_model->sort_order = $data_array['sort_order'];
            }
            if (isset($data_array['type']) && $data_array['type'] == 'delete')
            {
                $states = $this->states_model->get_id_to_delete($data_array['ids']);               
                if (!empty($states))
                {
                    foreach ($states as $state)
                    {
                        $this->states_model->delete_state_city($state['s']['state_id'], $state['s']['lang_id']);
                    }
                }
            }
            if (isset($data_array['type']) && $data_array['type'] == 'active')
            {               
                $this->states_model->active_records($data_array['ids']);
            }
            if (isset($data_array['type']) && $data_array['type'] == 'inactive')
            {
                $this->states_model->inactive_records($data_array['ids']);
            }
            if (isset($data_array['type']) && $data_array['type'] == 'active_all')
            {
                $this->states_model->active_all_records();
            }
            if (isset($data_array['type']) && $data_array['type'] == 'inactive_all')
            {
                $this->states_model->inactive_all_records();
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $state_list = $this->states_model->get_state_listing($language_detail[0]['l']['id']);   
        $this->states_model->_record_count = true;
        $total_records = $this->states_model->get_state_listing($language_detail[0]['l']['id']);       
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'state' => $state_list,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search' => $search,
            'search_state_name' => $this->states_model->search_state,
            'search_country' => $this->states_model->search_country,
            'search_status' => $this->states_model->search_status,
            'sort_by' => $this->states_model->sort_by,
            'sort_order' => $this->states_model->sort_order
        );
        $this->theme->view($data, 'admin_ajax_index');
    }

    /**
     * action to add/edit States
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function action($action, $language_code, $id = 0)
    {
        if ($this->check_permission())
        {
            //Initialize
            $state_list = array();
            $state_list_result = array();
            $data = array();
            
            //Type Casting
            $action = trim(strip_tags($action));
            $language_code = strip_tags($language_code);
            $id = intval($id);
            if ($this->input->post('addstate'))
            {
                $state_name = ucwords(trim(strip_tags($this->input->post('state_name'))));
                $status = trim(strip_tags($this->input->post('status')));
                $country_id = trim(strip_tags($this->input->post('country_id')));
            }        
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
            $country_list[''] = "---Select Country---";            
            foreach ($country_list_result as $country)
            {
                $country_list[$country['c']['country_id']] = $country['c']['country_name'];           
            }
            $state_list_result = $this->states_model->get_state_listing($language_id);
            if ($this->input->post('addstate'))
            {
                $country_list1['country_id'] = $country_id;
                //Validation Check
                $this->load->library('form_validation');
                $this->form_validation->set_rules('state_name', 'State Name', 'required||callback_check_unique_statename[' . $id . ']|alpha|xss_clean');
                $this->form_validation->set_rules('country_id', 'Country', 'required|xss_clean');
                if ($this->form_validation->run($this) == true)
                {
                    $state_data = $this->states_model->is_state_exist($id, $language_id);
                    $this->states_model->country_id = $country_id;
                    $this->states_model->state_name = $state_name;
                    $this->states_model->status = $status;
                    if (count($state_data) > 0)
                    {
                        $this->states_model->update_state($id, $language_id, $country_list1['country_id']);
                        $this->theme->set_message(lang('msg-update-success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_state_id = $this->states_model->get_last_state_id();
                            $id = $last_state_id + 1;
                        }
                        $this->states_model->insert_state($id, $language_id);
                        $this->theme->set_message(lang('msg-add-success'), 'success');
                    }
                    redirect($this->section_name . '/states/index/' . $language_detail[0]['l']['language_code']);
                }
            }
            else
            {
                if (!$this->input->post())
                {
                    if (isset($id) && $id != '' && $id != '0')
                    {
                        $state_list_result = $this->states_model->get_state_detail_by_id($id, $language_detail[0]['l']['id']);
                        $state_list = $state_list_result;
                    }
                }
                else
                {
                    $state_list = $this->input->post();
                }

                // Breadcrumb settings
                if ($action == "add")
                {
                    $this->theme->set('page_title', lang('add_state'));
                    $this->breadcrumb->add(lang('add_state'));
                    $id = '';
                    $country_list1 = '';
                }
                elseif ($action == "edit")
                {
                    $this->theme->set('page_title', $this->lang->line('edit_state'));
                    $this->breadcrumb->add($this->lang->line('edit_state'));               
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
                'country_list' => $country_list,
                'state' => $state_list                
            );            
            $data['content'] = $this->load->view('admin_ajax_action', $data, TRUE);
            $this->theme->view($data, 'admin_action');
        }
        else
        {
            $this->theme->set_message(lang('permission-not-allowed'), 'error');
            redirect($this->section_name . '/users');
            exit;
        }
    }

    /**
     * action to add/edit State page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_action($action, $language_code, $id = 0, $ajax_load = 1)
    {
        //Initialize
        $state_list = array();
        $state_list_result = array();
        $data = array();
        $country_list1 = array();
        
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
            $state_list_result = $this->states_model->get_state_detail_by_id($id, $language_detail[0]['l']['id']);
            if (!empty($state_list_result))
            {
                $state_list = $state_list_result;
            }
        }

        // To get countries
        $country_list_result = $this->country_model->get_country_listing($language_id);
        $i = 0;
        $country_list[$i] = "---Select Country---";
        foreach ($country_list_result as $country)
        {
            $country_list[$country['c']['country_id']] = $country['c']['country_name'];
            $i++;
        }
        //Variable assignments to view
        $data = array(
            'action' => $action,
            'id' => $id,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'state' => $state_list,
            'country_list' => $country_list,
            'state' => $state_list
        );        
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_action', $data);
        else
            return $this->load->view('admin_ajax_action', $data);
    }

    // Function to delete the state record and related url management record
    function delete()
    {
        //Initialise
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        //Type casting
        $id = intval($id);
        
        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $data['state'] = $this->states_model->delete_state($id, $name);
            $message = $this->theme->message(lang('delete_success'), 'success');
        }
        else
        {
            $message = $this->theme->message(lang('invalid-id-msg'), 'error');
        }
        echo $message;
    }

    /**
     * action view to view State page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function view($language_code, $id = 0)
    {
        //Initialize
        $state_list = array();
        $state_list_result = array();
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
            $state_list_result = $this->states_model->get_state_detail_by_id($id, $language_detail[0]['l']['id']);
            $state_list = $state_list_result;
        }
        $language_list = $this->languages_model->get_languages(); // get list of languages
        
        // Breadcrumb settings
        $this->theme->set('page_title', lang('view-state'));
        $this->breadcrumb->add(lang('view-state'));

        //Variable assignments to view
        $data = array(
            'id' => $id,
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_id' => $language_id,
            'languages' => $language_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'state' => $state_list[0]
        );        
        $data['content'] = $this->load->view('admin_ajax_view', $data, TRUE);
        $this->theme->view($data);
    }

    /**
     * action to add/edit State page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_view($language_code, $id = 0, $ajax_load = 1)
    {
        //Initialize
        $state_list = array();
        $state_list_result = array();
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
            $state_list_result = $this->states_model->get_state_detail_by_id($id, $language_detail[0]['l']['id']);
            if (!empty($state_list_result))
            {
                $state_list = $state_list_result;
            }
        }
        //Variable assignments to view
        $data = array(
            'id' => $id,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code
        );       
        if (!empty($state_list))
        {
            $data['state'] = $state_list[0];
        }
        else
        {
            $data['state'] = array();
        }
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_view', $data);
        else
            return $this->load->view('admin_ajax_view', $data);
    }

    /*
     * Check If statename already exists
     */
    public function check_unique_statename($state_name, $data)
    {
        //get data
        $data = explode(',', $data);
        $s_id = $data['0'];
        $data = $this->input->post();
        $this->states_model->state_name = ucwords($data['state_name']);
        $language_detail = $this->languages_model->get_languages_by_code($data['value']);
        $this->states_model->lang_id = $language_detail[0]['l']['id'];
        
        //logic
        $result = $this->states_model->check_unique_statename();
        if (!empty($result))
        {
            if ($s_id == $result[0]['state']['state_id'])
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('check_unique_statename', lang('msg-alvailable-statename'));
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
