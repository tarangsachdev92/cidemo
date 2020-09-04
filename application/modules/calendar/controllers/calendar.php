<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Calendar Front Controller
 *
 *  Calendar Front controller to display add / Edit / Delete / List events page for each language.
 *
 * @package CIDemoApplication
 *
 * @copyright	(c) 2013, TatvaSoft
 * @author KG
 */
class Calendar extends Base_Front_Controller
{
    /*
     * Create an instance
     */
    function __construct()
    {
        parent::__construct();
        // Login check for user
        $this->access_control($this->access_rules());
        $this->breadcrumb->add('Calendar', base_url() . 'calendar');
        $this->theme->set_theme("front");
        // Load required helpers
        $this->load->helper('url');
        $this->load->helper('ckeditor');
        $this->load->library('calendar');
        // load required models
        $this->load->model('calendar/calendar_model');
        $this->load->model('urls/urls_model');
    }

    /**
     * function accessRules to check page access
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('index', 'event_list', 'action', 'delete', 'ajax_calendar', 'open_form', 'open_dialog', 'upcoming_events', 'share_event', 'event_detail', 'calendar_public', 'upcoming_events_public', 'validate', 'session_set'),
                'users' => array('@'),
            ),
            array(
                'actions' => array('share_event', 'event_detail', 'calendar_public', 'upcoming_events_public', 'event_list'),
                'users' => array('*'),
            )
        );
    }

    /**
     * action to display language wise  calendar
     * @param string $language_code
     */
    function index($language_code = '')
    {
        //Initialize
        $data=array();
        //Type Casting
        $language_code = strip_tags($language_code);
        $user_id = $this->session->userdata[$this->section_name]['user_id']; 
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        $event_list = $this->calendar_model->get_event_list($language_detail[0]['l']['id'], $user_id);
        $this->calendar_model->_record_count = true;
        $total_records = $this->calendar_model->get_event_list($language_detail[0]['l']['id'], $user_id);
        //Set page title
        $this->theme->set('page_title', 'Calendar');
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data=array(
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_id' => $language_id,
            'languages_list' => $language_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'event_list' => $event_list,
            'total_records' => $total_records
        );
        $this->theme->view($data);
    }

    /**
     * Add and Edit action for adding events
     * @param string $language_code
     * @param string $type
     * @param string $action
     * @param integer $id
     */
    function action($action, $type, $language_code, $id = 0)
    {
        if ($this->check_permission())
        {
            //Initialize
            $data=array();
            $event_list = array(); 
            //Type Casting
            $action = trim(strip_tags($action));
            $language_code = strip_tags($language_code);
            $id = intval($id);
            $user_id = trim(strip_tags($this->session->userdata[$this->section_name]['user_id']));
            $start_time = $this->input->post('start_time');
            $end_time = $this->input->post('end_time');
            $event_title = trim(strip_tags($this->input->post('event_title')));
            $event_desc = trim(strip_tags($this->input->post('event_desc')));
            $event_location = trim(strip_tags($this->input->post('event_loc')));
            $event_organizer = trim(strip_tags($this->input->post('event_org')));
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $event_fees = $this->input->post('event_fees');
            $repeat = intval($this->input->post('repeat'));
            if ($repeat != 0)
            {
                $repeat_end_date = $this->input->post('repeat_end_date');
                $is_repeat = intval($this->input->post('is_repeat'));
            }
            $privacy = intval($this->input->post('privacy'));

            if ($action == 'add' || $action == 'edit')
            {
                if ($language_code == '')
                {
                    $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
                }
                // Logic
                $language_detail = $this->languages_model->get_languages_by_code($language_code);
                $language_id = $language_detail[0]['l']['id'];
                if ($this->input->post())
                {
                    $cal_data = $this->calendar_model->is_event_exist($id, $language_id);
                    $this->calendar_model->event_title = $event_title;
                    $this->calendar_model->event_desc = $event_desc;
                    $this->calendar_model->event_location = $event_location;
                    $this->calendar_model->event_organizer = $event_organizer;
                    $this->calendar_model->event_fees = $event_fees;
                    $this->calendar_model->start_date = $start_date;
                    $this->calendar_model->end_date = $end_date;
                    $this->calendar_model->start_time = $start_time;
                    $this->calendar_model->end_time = $end_time;
                    $this->calendar_model->privacy = $privacy;
                    $this->calendar_model->repeat = $repeat;
                    if ($repeat != 0)
                    {
                        $this->calendar_model->repeat_end_date = $repeat_end_date;
                        $this->calendar_model->is_repeat = $is_repeat;
                    }

                    if (count($cal_data) > 0)
                    {
                        $this->calendar_model->update_eve($id, $language_id, $user_id);
                        $this->theme->set_message(lang('msg-update-success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_event_id = $this->calendar_model->get_last_eve_id();
                            $id = $last_event_id + 1;
                        }
                        $this->calendar_model->insert_event($id, $language_id, $user_id);
                        $this->theme->set_message(lang('msg-add-success'), 'success');
                    }
                    if ($action == 'add' && $type == 'cal')
                    {
                        redirect('calendar');
                    }
                    elseif ($action == 'add' && $type == 'list')
                    {
                        redirect('calendar/event_list/'.$language_code);
                    }
                    elseif ($action == 'edit' && $type == 'cal')
                    {
                        redirect('calendar');
                    }
                    elseif ($action == 'edit' && $type == 'list')
                    {
                        redirect('calendar/event_list/'.$language_code);
                    }
                }
                if (!$this->input->post())
                {
                    if (isset($id) && $id != '' && $id != '0')
                    {
                        $event_list = $this->calendar_model->get_event_list($language_detail[0]['l']['id'], $user_id);
                    }
                }
                else
                {
                    $event_list = $this->input->post();
                }
                $language_list = $this->languages_model->get_languages(); // get list of languages
                if ($action == "edit")
                {
                    $event_list = $this->calendar_model->get_event_detail_by_id($id, $language_detail[0]['l']['id']);
                    $this->theme->set('page_title', $this->lang->line('edit_event'));
                    $this->breadcrumb->add($this->lang->line('edit_event'));
                }
                $data = array(
                    'action' =>  $action, 
                    'id' => $id,
                    'language_code' => $language_detail[0]['l']['language_code'],
                    'language_name' => $language_detail[0]['l']['language_name'],
                    'language_id' => $language_id,
                    'csrf_token' => $this->security->get_csrf_token_name(),
                    'csrf_hash' => $this->security->get_csrf_hash(),
                    'languages' => $language_list,
                    'type' => $type,
                    'cal' => $event_list,
                );
                $data['content'] = $this->load->view('open_form', $data, TRUE);
                $this->theme->view($data, 'action');
            }
        }
        else
        {
            $this->theme->set_message(lang('permission-not-allowed'), 'error');
            redirect('calendar');
            exit;
        }
    }

    /**
     *  Listing of Events
     * @param string $language_code
     * @param string $type
     */
    function event_list($language_code, $type = '', $ajax = '')
    {
        //Initialize
        $data = array();
        //Type Casting
        $language_code = strip_tags($language_code);
        $type = strip_tags($type);
        $search = '';
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        if ($type == '')
        {
            $type = 'private';
        }
        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        // Breadcrumb settings
        $this->theme->set('page_title', $this->lang->line('event_list'));
        $this->breadcrumb->add($this->lang->line('event_list'));
        
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->calendar_model->record_per_page = $this->record_per_page;
        $this->calendar_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data_array = $this->input->post();

            if (isset($data_array['search_term']))
            {
                $this->calendar_model->search_term = $data_array['search_term'];
            }
            if (isset($data_array['search_type']))
            {
                $this->calendar_model->search_type = $data_array['search_type'];
            }
            if (isset($data_array['date_from']))
            {
                $this->calendar_model->date_from = $data_array['date_from'];
            }
            if (isset($data_array['date_to']))
            {
                $this->calendar_model->date_to = $data_array['date_to'];
            }
            if (isset($data_array['sort_by']) && $data_array['sort_order'])
            {
                $this->calendar_model->sort_by = $data_array['sort_by'];
                $this->calendar_model->sort_order = $data_array['sort_order'];
            }
        }
        //logic    
        if ($type == 'private')
        {
            if ($this->check_permission())
            {
                $user_id = $this->session->userdata[$this->section_name]['user_id'];
                $event_list = $this->calendar_model->get_event_list($language_detail[0]['l']['id'], $user_id);
                $this->calendar_model->_record_count = true;
                $total_records = $this->calendar_model->get_event_list($language_detail[0]['l']['id'], $user_id);
            }
            else
            {
                $this->theme->set_message(lang('do_login'), 'error');
                redirect('');
            }
        }
        else
        {
            $event_list = $this->calendar_model->get_admin_events($language_detail[0]['l']['id']);
            $this->calendar_model->_record_count = true;
            $total_records = $this->calendar_model->get_admin_events($language_detail[0]['l']['id']);
            $data['type'] = $type;
        }
        if (isset($this->session->userdata[$this->theme->get('section_name')]['user_id']))
        {
            $data['logged_in'] = $this->session->userdata[$this->theme->get('section_name')]['user_id'];
        }
        $data = array(
            'language_code' => $language_code,
            'total_records' => $total_records,
            'page_number' => $this->page_number,
            'search_term' => $this->calendar_model->search_term,
            'search_type_cont' => $this->calendar_model->search_type,
            'sort_by' => $this->calendar_model->sort_by,
            'sort_order' => $this->calendar_model->sort_order,
            'date_from' => $this->calendar_model->date_from,
            'date_to' => $this->calendar_model->date_to,
            'type' => $type,
            'is_search' => $ajax,
            'event_list' => $event_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );
        if ($type == 'public')
        {
            $this->theme->view($data, 'event_list');
        }
        elseif ($ajax == '1' && $type == 'private')
        {
            $this->theme->view($data, 'event_list');
        }
        else
        {
            $this->theme->view($data, 'ajax_action');
        }
    }

    /**
     * Form for adding events with different languages
     * @param string $language_code
     * @param string $type
     * @param string $action
     * @param integer $id
     */
    function open_form($action, $type, $language_code, $id = 0, $ajax_load = 1)
    {
        //Initialize
        $event_list = array();
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
        if (!$this->input->post())
        {
            if (isset($id) && $id != '' && $id != '0')
            {
                $event_list = $this->calendar_model->get_event_detail_by_id($id, $language_detail[0]['l']['id']);
            }
        }
        else
        {
            $event_list = $this->input->post();
        }
        //Variable assignments to view 
        $data = array(
            'action' => $action,
            'id' => $id,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'type' => $type,
            'cal' => $event_list
        );
        if ($ajax_load == '1')
            echo $this->load->view('open_form', $data);
        else
            return $this->load->view('open_form', $data);
    }

    /**
     *  Add or Edit events form
     * @param string $language_code
     * @param string $type
     * @param string $action
     * @param string $start_time
     * @param string $end_time
     * @param integer $id
     */
    function open_dialog($action, $type, $language_code, $start_date, $start_time, $end_time, $id = 0)
    {
        //Initialize
        $data = array();
        $cal = array();
        
        //Type Casting
        $language_code = strip_tags($language_code);
        $action = trim(strip_tags($action));
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages(); // get list of languages
        $cal = array(
            'start_date' => $start_date,
            'end_date' => $start_date,
            'start_time' => $start_time,
            'end_time' => $end_time
        );
        $data = array(
            'id' => $id,
            'action' => $action,
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_id' => $language_id,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'languages' => $language_list,
            'type' => $type,
            'cal' => $cal
        );
        $data['content'] = $this->load->view('open_form', $data, TRUE);
        $this->theme->view($data, 'action');
    }

    /**
     * delete Events
     */
    function delete()
    {
        //Initialise
        $id = $this->input->post('id');
        //Type casting
        $id = intval($id);
        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $data['calendar'] = $this->calendar_model->delete_event($id);
            $message = $this->theme->message(lang('delete_success'), 'success');
        }
        else
        {
            $message = $this->theme->message(lang('invalid-id-msg'), 'error');
        }
        echo $message;
    }

    /* Function for displaying upcoming Events
     * @param string $language_code
     */
    function upcoming_events($language_code = '')
    {
        //Initialize
        $event_list = array();
        $data = array();
        
        //Type casting
        $language_code = strip_tags($language_code);
        $user_id = $this->session->userdata[$this->section_name]['user_id'];
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $event_list = $this->calendar_model->get_event_list($language_detail[0]['l']['id'], $user_id);
        $this->calendar_model->_record_count = true;
        $total_records = $this->calendar_model->get_event_list($language_detail[0]['l']['id'], $user_id);

        //Variable assignments to view
        $data = array(
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'total_records' => $total_records,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'event_list' => $event_list
        );
        $this->theme->view($data, 'upcoming_events');
    }

    /* Function send email to user
     * @params $data for sending email
     */
    function share_event($language_code = '', $type = '', $eve_id = 0)
    {
        //Initialize
        $data = array();
        
        //Type casting
        $language_code = strip_tags($language_code);
        $event_id = intval($eve_id);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        if (!($this->input->post()))
        {
            $data = array(
                'language_code' => $language_code,
                'event_id' => $event_id,
                'type' => $type,
                'section_name' => $this->section_name,
                'event_list' => $this->calendar_model->get_event_detail_by_id($event_id, $language_detail[0]['l']['id'])
            );
            $this->theme->view($data, 'share_event');
        }
        else
        {
            $data = $this->input->post();
            if (!isset($data['txtbox']))
            {
                $this->theme->set_message(lang('mail_not_sent_success'), 'error');
                redirect('calendar/event_list/' . $language_code . '/' . $type);
            }
            else
            {
                $data = array(
                    "section_name" => $this->section_name,
                    "post" => $data,
                    "type" => $type,
                    "event_list" => $this->calendar_model->get_event_detail_by_id($event_id, $language_detail[0]['l']['id'])
                );

                $is_sent = $this->calendar_model->send_email($data);
                if ($is_sent == true)
                {
                    $this->theme->set_message(lang('mail_sent_success'), 'success');
                }
                else
                {
                    $this->theme->set_message(lang('mail_not_sent_success'), 'error');
                }
                redirect('calendar/event_list/' . $language_code . '/' . $type);
            }
        }
    }

    /* Event details Preview
     * @param string $language_code
     * @param string $type
     */
    function event_detail($language_code, $type = '', $eve_id = 0)
    {
        //Type casting
        $language_code = strip_tags($language_code);
        $event_id = intval($eve_id);
        if ($type == '')
        {
            $type = 'private';
        }
        if ($type == 'private')
        {
            if (!$this->check_permission())
            {
                $this->theme->set_message(lang('do_login'), 'error');
                redirect('');
            }
        } 
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $user = $this->calendar_model->get_all_admin_id();
        if (isset($type))
        {
            $cal_type = $type;
        }
        else
        {
            $cal_type = 'private';
        }
        // set meta keywords for sharing events  
        $event_list = $this->calendar_model->get_event_detail_by_id($event_id, $language_detail[0]['l']['id']);
        $this->theme->set_meta(array('name' => 'description', 'content' => $event_list['event_desc']));
        $this->theme->set_meta(array('property' => 'og:title', 'content' => $event_list['event_title']));
        
        //Variable assignments to view
        $data = array(
            "type" => $type,
            "admin_id" => $user,
            "language_code" => $language_code,
            "event_list" => $this->calendar_model->get_event_detail_by_id($event_id, $language_detail[0]['l']['id'])
        );
        $this->theme->view($data, 'event_detail');
    }

    //displaying public calendar
    function calendar_public($language_code='')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $user = $this->calendar_model->get_all_admin_id();
        $event_list = $this->calendar_model->get_admin_events($language_detail[0]['l']['id']);
        
        //Variable assignments to view
        $data = array(
            'id' => $user,
            'language_code' => $language_code,
            'event_list' => $event_list
        );
        $this->theme->view($data, 'calendar_public');
    }

    // function for displaying upcoming Events Publically
    function upcoming_events_public($language_code)
    {
        //Initialize
        $event_list = array();
        $data = array();
        
        //Type Casting
        $language_code = strip_tags($language_code); 
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        
        //logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $event_list = $this->calendar_model->get_admin_events($language_detail[0]['l']['id']);
        
        //Variable assignments to view
        $data = array(
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'event_list' =>  $event_list
        );
        $this->theme->view($data, 'upcoming_events');
    }

    /* Event details validation while addnig or editing the record */
    function validate()
    {
        // $language_code = strip_tags($language_code);
        if ($this->input->post())
        {
            //Validation Check
            $this->load->library('form_validation');
            $this->form_validation->set_rules('event_title', 'Event Title', 'required|min_lenght[3]|max_lenght[100]|xss_clean');
            $this->form_validation->set_rules('event_desc', 'Event Description', 'required|min_lenght[3]|xss_clean');
            $this->form_validation->set_rules('event_loc', 'Event Location', 'required|min_lenght[3]|max_lenght[100]|xss_clean');
            $this->form_validation->set_rules('event_org', 'Event Organizer', 'required|min_lenght[3]|max_lenght[100]|xss_clean');
            $this->form_validation->set_rules('event_fees', 'Event Fees', 'numeric|max_lenght[10]');
            if ($this->form_validation->run($this) == true)
            {
                echo $this->form_validation->run($this);
            }
            else
            {
                echo validation_errors('<div class="warning-msg">', '</div>');
            }
        }
    }

    /* set search values in session */
    function session_set()
    {
        $array = array(
            'search_type' => $this->input->post('search_type'),
            'search_term' => $this->input->post('search_term'),
            'date_from' => $this->input->post('date_from'),
            'date_to' => $this->input->post('date_to'),
        );
        $this->session->set_userdata($array);
    }
}

?>