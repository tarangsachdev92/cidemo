<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Email Template Admin Controller
 *
 *  Email Template Admin controller to display add / Edit / Delete / List email template page for each language.
 * 
 * @package CIDemoApplication
 *  
 * @copyright	(c) 2013
 * @author AMPT 
 */
class Email_template_admin extends Base_Admin_Controller
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
        $this->load->helper('ckeditor');
        // Breadcrumb settings
        $this->breadcrumb->add('Email Template Management', base_url() . $this->section_name . '/email_template');
    }

    /**
     * function accessRules to check page access     
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('action', 'index', 'ajax_index', 'ajax_action', 'delete', 'view_data', 'view', 'ajax_view'),
                'users' => array('@'),
            )
        );
    }

    /**
     * action to display language wise list of email template  page
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
        $this->theme->set('page_title', lang('page-title'));

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
     * action to load list of email template based on language passed or from default language
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
        $this->email_template_model->record_per_page = $this->record_per_page;
        $this->email_template_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_term']))
            {   $this->email_template_model->search_term = trim($data['search_term']);
               // $this->email_template_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->email_template_model->sort_by = $data['sort_by'];
                $this->email_template_model->sort_order = $data['sort_order'];
            }
            if (isset($data['type']) && $data['type'] == 'delete')
            {
                if ($this->email_template_model->delete_records($data['ids']))
                {
                    echo $this->theme->message(lang('delete_success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                if ($this->email_template_model->active_records($data['ids']))
                {
                    echo $this->theme->message(lang('email-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                if ($this->email_template_model->inactive_records($data['ids']))
                {
                    echo $this->theme->message(lang('email-inactive-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                if ($this->email_template_model->active_all_records($data['lang']))
                {
                    echo $this->theme->message(lang('email-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                if ($this->email_template_model->inactive_all_records($data['lang']))
                {
                    echo $this->theme->message(lang('email-inactive-success'), 'success');
                    exit;
                }
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $email_template_model_list = $this->email_template_model->get_email_template_listing($language_detail[0]['l']['id']);
        $this->email_template_model->_record_count = true;
        $total_records = $this->email_template_model->get_email_template_listing($language_detail[0]['l']['id']);

        //Variable assignments to view        
        $data = array(
            'email_template_list' => $email_template_model_list,
            'language_code' => $language_code,
            'language_id' => $language_detail[0]['l']['id'],
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->email_template_model->search_term,
            'sort_by' => $this->email_template_model->sort_by,
            'sort_order' => $this->email_template_model->sort_order
        );
        $this->theme->view($data, 'admin_ajax_index');
    }

    /**
     * action to add/edit Email Template page
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
        if ($this->input->post('email_template_submit'))
        {
            $template_name = trim(strip_tags($this->input->post('template_name')));
            $template_subject = trim(strip_tags($this->input->post('template_subject')));
            $template_body = trim($this->input->post('template_body'));
            $status = trim(strip_tags($this->input->post('status')));
			
        }
		else
		{
			$template_body = "";
			$status = "";
		}

        if ($action == 'add' || $action == 'edit')
        {
            //Initialize
            $template_list = array();
            $template_list_result = array();
            if ($language_code == '')
            {
                $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
            }

            // Logic
            $language_detail = $this->languages_model->get_languages_by_code($language_code);
            $language_id = $language_detail[0]['l']['id'];
            $this->lang_id = $language_id;
            if ($this->input->post('email_template_submit'))
            {
                //Validation Check
                $this->load->library('form_validation');
                $this->form_validation->set_rules('template_name', 'Template Name', 'required|callback_check_space|callback_check_unique_email_template_name|xss_clean');

                $this->form_validation->set_rules('template_subject', 'Template Subject', 'required|xss_clean');

                if ($this->form_validation->run($this) == true)
                {

                    $template_data = $this->email_template_model->get_related_lang_template($id, $language_id);

                    $this->email_template_model->template_name = $template_name;
                    $this->email_template_model->template_subject = $template_subject;
                    $this->email_template_model->template_body = $template_body;
                    $this->email_template_model->status = $status;


                    if (count($template_data) > 0)
                    {
                        $this->email_template_model->update_email_template($id, $language_id);
                        $this->theme->set_message(lang('msg-update-success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_template_id = $this->email_template_model->get_last_email_template_id();
                            $id = $last_template_id + 1;
                        }
                        $this->email_template_model->insert_email_template($id, $language_id);
                        $this->theme->set_message(lang('msg-add-success'), 'success');
                    }


                    redirect($this->section_name . '/email_template/index/' . $language_detail[0]['l']['language_code']);
                }
            }

            if (!$this->input->post())
            {
                if (isset($id) && $id != '' && $id != '0')
                {
                    $template_list = $this->email_template_model->get_template_detail_by_id($id, $language_detail[0]['l']['id']);
                }
            }
            else
            {
                $template_list = $this->input->post();
            }
            $language_list = $this->languages_model->get_languages(); // get list of languages
            // Breadcrumb settings
            if ($action == "add")
            {
                $this->theme->set('page_title', lang('add-email-template'));
                $this->breadcrumb->add(lang('add-email-template'));
                $id = '';
            }
            elseif ($action == "edit")
            {
                $this->theme->set('page_title', lang('edit-email-template'));
                $this->breadcrumb->add(lang('edit-email-template'));
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
            $data['template'] = $template_list;
			$data['status'] = $status;
			$data['template_body'] = $template_body;
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
     * action to add/edit email template page load form from ajax based on language
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
        $template_list = array();
        $template_list_result = array();
        $data = array();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic        
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        if (isset($id) && $id != '' && $id != '0')
        {
            $template_list_result = $this->email_template_model->get_template_detail_by_id($id, $language_detail[0]['l']['id']);
        }
        //Variable assignments to view        
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['template'] = $template_list_result;
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_action', $data);
        else
            return $this->load->view('admin_ajax_action', $data);
    }

    /**
     * action view to view email template page
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
        $template_list = array();

        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        if (isset($id) && $id != '' && $id != '0')
        {
            $template_list = $this->email_template_model->get_template_detail_by_id($id, $language_detail[0]['l']['id']);
        }

        $language_list = $this->languages_model->get_languages(); // get list of languages
        // Breadcrumb settings

        $this->theme->set('page_title', lang('view-email-template'));
        $this->breadcrumb->add(lang('view-email-template'));

        //Variable assignments to view        
        $data = array();
        $data['id'] = $id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['languages'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['template'] = $template_list;
        $data['content'] = $this->load->view('admin_ajax_view', $data, TRUE);
        $this->theme->view($data);
    }

    /**
     * action to add/edit email template page load form from ajax based on language
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
        $template_list = array();

        $data = array();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic        
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        if (isset($id) && $id != '' && $id != '0')
        {
            $template_list = $this->email_template_model->get_template_detail_by_id($id, $language_detail[0]['l']['id']);
        }
        //Variable assignments to view                
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['template'] = $template_list;
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_view', $data);
        else
            return $this->load->view('admin_ajax_view', $data);
    }

    // Function to delete the email template record and related url management record
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
            $data['email_template'] = $this->email_template_model->delete_email_template($id);
            $message = $this->theme->message(lang('delete_success'), 'success');
        }
        else
        {
            $message = $this->theme->message(lang('invalid-id-msg'), 'error');
        }
        echo $message;
    }

    /**
     * function check_unique_email_template_name to check unique template name     
     */
    public function check_unique_email_template_name()
    {

        //variable assignement
        $id = '';

        //Get url management id
        if ($this->input->post('old_template_name') != '')
        {
            $template_detail = $this->email_template_model->get_template_id_by_name($this->input->post('old_template_name'), $this->lang_id);

            $id = $template_detail[0]['c']['id'];
        }

        $template_name = $this->input->post('template_name');
        $result = $this->email_template_model->check_unique_template_name($template_name, $id);

        if (count($result) > 0)
        {
            $this->form_validation->set_message('check_unique_email_template_name', lang('msg-alvailable-template_name'));
            return false;
        }
        else
        {
            return true;
        }
    }

    public function check_space()
    {
        $template_name = $this->input->post('template_name');


        if (strpos($template_name, " "))
        {
            $this->form_validation->set_message('check_space', lang('msg-space-not-allowed'));
            return false;
        }
        else
        {
            return true;
        }
    }

}
?>