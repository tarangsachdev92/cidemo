<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  COUNTRY_Admin Controller
 *
 *  COUNTRY Admin controller to display add / Edit / Delete / List Country for each language.
 * 
 * @package CIDemoApplication
 *  
 * @author HP
 */
class Country_admin extends Base_Admin_Controller
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

        // Breadcrumb settings
        $this->breadcrumb->add('Country Management', base_url() . $this->section_name . '/country');
    }

    /**
     * function access_rules to check page access
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('action', 'set_session', 'index', 'ajax_index', 'ajax_action', 'delete', 'view', 'ajax_view'),
                'users' => array('@'),
            )
        );
    }

    /**
     * action to display language wise list of country page
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
        $this->theme->set('page_title', 'Country List');

        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_id' => $language_id,
            'lang_code' => $lang_code,
            'languages_list' => $language_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' =>  $this->security->get_csrf_hash()
        );        
        $this->theme->view($data);
    }

    /**
     * action to load list of country based on language passed or from default language
     * @param string $language_code
     */
    function ajax_index($language_code)
    {
        //Initialize
        $data = array();
        
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //set sort/search parameters in pagging

        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->country_model->record_per_page = $this->record_per_page;
        $this->country_model->offset = $offset;
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
            if (isset($data_array['search_country_name']))
            {
                $this->country_model->search_country_name = trim(strip_tags($data_array['search_country_name']));
            }
            else
            {
                if ($search == "country")
                    $this->country_model->search_country_name = $this->session->userdata('searchval');
            }
            if (isset($data_array['search_country_iso']))
            {
                $this->country_model->search_country_iso = trim(strip_tags($data_array['search_country_iso']));
            }
            else
            {
                if ($search == "iso")
                    $this->country_model->search_country_iso = $this->session->userdata('searchval');
            }
            if (isset($data_array['search_status']))
            {
                $this->country_model->search_status = trim(strip_tags($data_array['search_status']));
            }
            else
            {
                if ($search == "status")
                    $this->country_model->search_country_status = $this->session->userdata('searchval');
            }
            if (isset($data_array['sort_by']) && $data_array['sort_order'])
            {
                $this->country_model->sort_by = $data_array['sort_by'];
                $this->country_model->sort_order = $data_array['sort_order'];
            }
            if (isset($data_array['type']) && $data_array['type'] == 'delete')
            {
                $countries = $this->country_model->get_id_to_delete($data_array['ids']);
                if (!empty($countries))
                {
                    foreach ($countries as $country)
                    {
                        $this->country_model->delete_country_state_city($country['c']['country_id'], $country['c']['lang_id']);
                    }
                }
            }
            if (isset($data_array['type']) && $data_array['type'] == 'active')
            {
                $this->country_model->active_records($data_array['ids']);
            }
            if (isset($data_array['type']) && $data_array['type'] == 'inactive')
            {

                $this->country_model->inactive_records($data_array['ids']);
            }
            if (isset($data_array['type']) && $data_array['type'] == 'active_all')
            {
                $this->country_model->active_all_records();
            }
            if (isset($data_array['type']) && $data_array['type'] == 'inactive_all')
            {
                $this->country_model->inactive_all_records();
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $country_list = $this->country_model->get_country_listing($language_detail[0]['l']['id']);
        $this->country_model->_record_count = true;
        $total_records = $this->country_model->get_country_listing($language_detail[0]['l']['id']);

        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'country_list' => $country_list,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search' => $search,
            'search_country_name' => $this->country_model->search_country_name,
            'search_country_iso' => $this->country_model->search_country_iso,
            'search_status' => $this->country_model->search_status,
            'sort_by' => $this->country_model->sort_by,
            'sort_order' => $this->country_model->sort_order
        );
        $this->theme->view($data, 'admin_ajax_index');
    }

    /**
     * action to add/edit country 
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function action($action, $language_code, $id = 0)
    {
        if ($this->check_permission())
        {
            //Initialize
            $country_list = array();
            $country_list_result = array();
            $data = array();
             
            //Type Casting
            $action = trim(strip_tags($action));
            $language_code = strip_tags($language_code);
            $id = intval($id);
            if ($this->input->post('countrysubmit'))
            {
                $country_name = trim(strip_tags($this->input->post('country_name')));
                $country_iso = trim(strip_tags($this->input->post('country_iso')));
                $status = trim(strip_tags($this->input->post('status')));
            }            
            if ($language_code == '')
            {
                $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
            }

            // Logic
            $language_detail = $this->languages_model->get_languages_by_code($language_code);
            $language_id = $language_detail[0]['l']['id'];
            if ($this->input->post('countrysubmit'))
            {
                //Validation Check
                $this->load->library('form_validation');
                $this->form_validation->set_rules('country_name', 'Country Name', 'required|callback_check_unique_countryname[' . $id . ']|xss_clean');                
                $this->form_validation->set_rules('country_iso', 'ISO ', 'required|exact_length[2]|callback_check_unique_iso[' . $language_id . ',' . $id . ']|alpha|xss_clean');
                if ($this->form_validation->run($this) == true)
                {
                    $country_data = $this->country_model->is_country_exist($id, $language_id);
                    $this->country_model->country_name = ucwords($country_name);
                    $this->country_model->country_iso = strtoupper($country_iso);
                    $this->country_model->status = $status;
                    if (count($country_data) > 0)
                    {
                        $this->country_model->update_country($id, $language_id);
                        $this->theme->set_message(lang('msg-update-success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_country_id = $this->country_model->get_last_country_id();
                            $id = $last_country_id + 1;
                        }
                        $this->country_model->insert_country($id, $language_id);
                        $this->theme->set_message(lang('msg-add-success'), 'success');
                    }
                    redirect($this->section_name . '/country/index/' . $language_detail[0]['l']['language_code']);
                }
            }
            if (!$this->input->post())
            {
                if (isset($id) && $id != '' && $id != '0')
                {
                    $country_list_result = $this->country_model->get_country_detail_by_id($id, $language_detail[0]['l']['id']);
                    $country_list = $country_list_result[0]['c'];
                }
            }
            else
            {
                $country_list = $this->input->post();
            }
            $language_list = $this->languages_model->get_languages(); // get list of languages
            // Breadcrumb settings
            if ($action == "add")
            {
                $this->theme->set('page_title', lang('add_country'));
                $this->breadcrumb->add(lang('add_country'));
                $id = '';
            }
            elseif ($action == "edit")
            {
                $this->theme->set('page_title', $this->lang->line('edit_country'));
                $this->breadcrumb->add($this->lang->line('edit_country'));
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
                'country' => $country_list,
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
     * action to add/edit country load from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_action($action, $language_code, $id = 0, $ajax_load = 1)
    {
        //Initialize
        $country_list = array();
        $country_list_result = array();
        $data = array();
        
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
        if (isset($id) && $id != '' && $id != '0')
        {
            $country_list_result = $this->country_model->get_country_detail_by_id($id, $language_detail[0]['l']['id']);

            if (!empty($country_list_result))
            {
                $country_list = $country_list_result[0]['c'];
            }
        }
        //Variable assignments to view 
        $data = array(
            'action' => $action,
            'id' => $id,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'country' => $country_list
        );        
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_action', $data);
        else
            return $this->load->view('admin_ajax_action', $data);
    }

    // Function to delete the country record 
    function delete()
    {
        $id = $this->input->post('id');
        $country_id = $this->input->post('country_id');
        $country_name = $this->input->post('country_name');

        //Type casting
        $id = intval($id);
        $country_id = intval($country_id);

        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $this->country_model->delete_country($id, $country_id, $country_name);
            $message = $this->theme->message(lang('delete_success'), 'success');
        }
        else
        {
            $message = $this->theme->message(lang('invalid-id-msg'), 'error');
        }
        echo $message;
    }

    /**
     * action view to view countrty page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function view($language_code, $id = 0)
    {
         //Initialize
        $country_list = array();
        $country_list_result = array();
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
            $country_list_result = $this->country_model->get_country_detail_by_id($id, $language_detail[0]['l']['id']);
            $country_list = $country_list_result[0]['c'];
        }
        $language_list = $this->languages_model->get_languages(); // get list of languages
        
        // Breadcrumb settings
        $this->theme->set('page_title', lang('view_country'));
        $this->breadcrumb->add(lang('view_country'));

        //Variable assignments to view
        $data = array(
            'id' => $id,
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_id' => $language_id,
            'languages' => $language_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'country' => $country_list            
        );        
        $data['content'] = $this->load->view('admin_ajax_view', $data, TRUE);
        $this->theme->view($data);
    }

    /**
     * action to add/edit country load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_view($language_code, $id = 0, $ajax_load = 1)
    {
        //Initialize
        $country_list = array();
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
            $country_list_result = $this->country_model->get_country_detail_by_id($id, $language_detail[0]['l']['id']);
            if (!empty($country_list_result))
            {
                $country_list = $country_list_result[0]['c'];
            }
        }
        //Variable assignments to view
        $data = array(
            'id' => $id,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'country' => $country_list
        );        
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_view', $data);
        else
            return $this->load->view('admin_ajax_view', $data);
    }

    /*
     * Check If countryname already exists
     */
    public function check_unique_countryname($country_name, $data)
    {
        //get data
        $data = explode(',', $data);
        $c_id = $data['0'];
        $data = $this->input->post();
        $this->country_model->country_name = ucwords(trim(strip_tags($data['country_name'])));
        $language_detail = $this->languages_model->get_languages_by_code($data['value']);
        $this->country_model->lang_id = $language_detail[0]['l']['id'];
        //logic
        $result = $this->country_model->check_unique_countryname();
        if (!empty($result))
        {
            if ($c_id == $result[0]['country']['country_id'])
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('check_unique_countryname', lang('msg-alvailable-countryname'));
                return false;
            }
        }
        else
        {
            return true;
        }
    }

    /*
     * Check If countryname already exists
     */
    public function check_unique_iso($country_iso, $data)
    {
        //get data
        $data = explode(',', $data);
        $c_id = $data['1'];
        $lang_id = $data['0'];
        $data = $this->input->post();
        $this->country_model->country_iso = strtoupper(trim(strip_tags($data['country_iso'])));
        $this->country_model->lang_id = $lang_id;
        //logic
        $result = $this->country_model->check_unique_iso();
        if (!empty($result))
        {
            if ($c_id == $result[0]['country']['country_id'])
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('check_unique_iso', lang('msg-alvailable-countryiso'));
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