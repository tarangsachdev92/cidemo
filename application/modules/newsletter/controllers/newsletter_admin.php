<?php
/**
 *  NewsLetter Admin Controller
 *
 *  To perform NewsLetter management.
 * 
 * @package CIDemoApplication
 * @subpackage NewsLetter
 * @copyright	(c) 2013, TatvaSoft
 * @author NIPT
 */
if (!defined ('BASEPATH')) exit ('No direct script access allowed');
class Newsletter_admin extends Base_Admin_Controller
{
    /*
     * Create an instance
     */

    function __construct ()
    {
        parent::__construct ();
        // Login check for admin
        $this->access_control ($this->access_rules ());
        // Load required helpers
        $this->load->helper (array ('url'));
        $this->load->library ('form_validation');
        $this->load->library ('email');
        // Breadcrumb settings
        $this->breadcrumb->add (lang ('dashboard'), base_url () . get_current_section ($this) . '/newsletter');
    }
    /*
     * access_rules() - this function is used for access control
     * based on login
     * * - all can access ['users' => array('*')]
     * @ - logged person can access ['users' => array('@')]
     */

    private function access_rules ()
    {
        return array (
            array (
                'actions' => array ('index', 'all_dashboard_subscribers', 'all_dashboard_newsletter',
                    'subscribers_actions', 'all_subscribers', 'check_unique_email', 'delete',
                    'newsletters_actions', 'ajax_newsletters_actions', 'all_newsletters', 'ajax_index', 'view_newsletter', 'send_all_newsletter', 'delete_newsletter',
                    'templates_actions', 'ajax_templates_actions', 'all_templates', 'ajax_all_templates', 'delete_template',
                    'add_newsletter_category', 'delete_category',),
                'users' => array ('@'),
            ),
            array (
                'actions' => array ('unsubscribe', 'send_all_newsletter'),
                'users' => array ('*'),
            )
        );
    }
    /**
     * Function index to display last five newsletters and subscribers on dashboard
     */
    public function index ()
    {
        $this->newsletter_model->record_per_page = 5;
        $this->newsletter_model->offset = 0;
        $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_id = $language_detail[0]['l']['id'];
        //Load data for Subscriber listing
        $subcribers = $this->newsletter_model->get_all_subscribers ();
        //Load data for newsletter listing
        $newsletters = $this->newsletter_model->get_all_newletters ($language_id);

        // Pass data to view file
        $data['users'] = $subcribers;
        $data['language_code'] = $language_code;
        $data['language_id'] = $language_id;
        $data['all_newletters'] = $newsletters;

        //Create page-title
        $this->theme->set ('page_title', lang ('dashboard'));
        $this->theme->view ($data);
    }
    /*
     * for the dashboard subscribers
     * this method is called by ajax
     */

    public function all_dashboard_subscribers ()
    {
        //Load data for Subscriber listing
        $this->newsletter_model->record_per_page = 5;
        $this->newsletter_model->offset = 0;
        $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $subcribers = $this->newsletter_model->get_all_subscribers ();
        // Pass data to view file   
        $data['users'] = $subcribers;
        $data['language_code'] = $language_code;
        $data['language_id'] = $language_id;
        $this->theme->view ($data, 'admin_ajax_dash_subscribers');
    }
    /*
     * for the dashboard newsletter
     * this method is called by ajax
     */

    public function all_dashboard_newsletter ()
    {
        //Load data for newsletter listing
        $this->newsletter_model->record_per_page = 5;
        $this->newsletter_model->offset = 0;
        $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $data['all_newletters'] = $this->newsletter_model->get_all_newletters ($language_id);
        $data['language_code'] = $language_code;
        $data['language_id'] = $language_id;
        $this->theme->view ($data, 'admin_ajax_dash_newsletters');
    }
    /*
     * for the subscriber logics
     * @param string $action,$language_code,$id
     */

    public function subscribers_actions ($action = "add", $language_code = "", $id = 0)
    {
        //Type Casting
        $language_code = strip_tags ($language_code);
        $id = intval ($id);
        $action = strip_tags ($action);

        //Initialize
        $subscribers = array (
            "firstname" => "",
            "lastname" => "",
            "email" => "",
            "status" => ""
        );
        if ($language_code == "") {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages ();

        if ($this->input->post ("save")) {
            $this->form_validation->set_rules ('firstname', 'First Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules ('lastname', 'Last Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules ('email', 'Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run ($this) == TRUE) {
                $subscribers = array (
                    "firstname" => $this->input->post ("firstname"),
                    "lastname" => $this->input->post ("lastname"),
                    "email" => $this->input->post ("email"),
                    "status" => $this->input->post ("status")
                );
                if ($id != '' && $action == 'edit') {
                    if ($this->newsletter_model->update_subscribers ($id, $subscribers)) {
                        $this->theme->set_message (lang ('subscriber-update-success'), 'success');
                        redirect ($this->section_name . '/newsletter/all_subscribers');
                    } else {
                        $this->theme->set_message (lang ('something_wrong'), 'error');
                    }
                } else if (($id == '0' || $id == '') && $action == "add") {
                    if ($this->newsletter_model->save_subscribers ($subscribers)) {
                        $this->theme->set_message (lang ('subscriber_added_successfully'), 'success');
                        $this->newsletter_model->send_email ($subscribers);
                        redirect ($this->section_name . '/newsletter/all_subscribers');
                    } else {
                        $this->theme->set_message (lang ('something_wrong'), 'error');
                        redirect ($this->section_name . '/newsletter/add_templates');
                    }
                }
            }
        }
        if (!$this->input->post ()) {
            if (isset ($id) && $id != '' && $id != '0' && $action == "edit") {
                //Check whether record exist or not?
                $subcriber_data = $this->newsletter_model->get_user_detail ($id);
                if (!empty ($subcriber_data)) {
                    $subscribers = $subcriber_data;
                }
            }
        } else {
            $subscribers = $this->input->post ();
        }
        if ($action == 'add' && ($id == '' || $id == '0')) {
            // Breadcrumb
            $this->breadcrumb->add (lang ('subscribers'), base_url () . $this->section_name . '/newsletter/all_subscribers');
            $this->breadcrumb->add (lang ('add_subscribers'), base_url () . $this->section_name . '/newsletter/add_subscribers');

            //create page title
            $this->theme->set ('page_title', lang ('add_subscribers'));
        } else if (isset ($id) && $id != '' && $id != '0' && $action == "edit") {
            // Breadcrumb
            $this->breadcrumb->add (lang ('subscribers'), base_url () . $this->section_name . '/newsletter/all_subscribers');
            $this->breadcrumb->add (lang ('edit_subscribers'), base_url () . $this->section_name . '/newsletter/edit_subscribers');

            //create page title
            $this->theme->set ('page_title', lang ('edit_subscribers'));
        } else {
            $this->theme->set_message ('No such action allowed', 'error');
            redirect ($this->section_name . '/newsletter');
            break;
        }
        // Pass data to view file
        $data['subscribers'] = $subscribers;
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['csrf_token'] = $this->security->get_csrf_token_name ();
        $data['csrf_hash'] = $this->security->get_csrf_hash ();
        $data['languages_list'] = $language_list;

        $this->theme->view ($data);
    }
    /*
     * view all Subscribers for subscriber listing
     */

    public function all_subscribers ()
    {
        //Paging parameters
        $offset = get_offset ($this->page_number, $this->record_per_page);
        $this->newsletter_model->record_per_page = $this->record_per_page;
        $this->newsletter_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post ()) {
            $data = $this->input->post ();
            if (isset ($data['search_term'])) {
                $this->newsletter_model->search_term = $data['search_term'];
            }
            if (isset ($data['sort_by']) && $data['sort_order']) {
                $this->newsletter_model->sort_by = $data['sort_by'];
                $this->newsletter_model->sort_order = $data['sort_order'];
            }
            if (isset ($data['type']) && $data['type'] == 'delete') {
                if ($this->newsletter_model->delete_records_subscribers ($data['ids'])) {
                    echo $this->theme->message (lang ('user-delete-success'), 'success');
                    exit;
                }
            }
            if (isset ($data['type']) && $data['type'] == 'active') {
                if ($this->newsletter_model->active_records_subscribers ($data['ids'])) {
                    echo $this->theme->message (lang ('user-active-success'), 'success');
                    exit;
                }
            }
            if (isset ($data['type']) && $data['type'] == 'inactive') {
                if ($this->newsletter_model->inactive_records_subscribers ($data['ids'])) {
                    echo $this->theme->message (lang ('user-inactive-success'), 'success');
                    exit;
                }
            }
            if (isset ($data['type']) && $data['type'] == 'active_all') {
                if ($this->newsletter_model->active_all_records_subscribers ()) {
                    echo $this->theme->message (lang ('user-active-success'), 'success');
                    exit;
                }
            }
            if (isset ($data['type']) && $data['type'] == 'inactive_all') {
                if ($this->newsletter_model->inactive_all_records_subscribers ()) {
                    echo $this->theme->message (lang ('user-inactive-success'), 'success');
                    exit;
                }
            }
        }
        //Load data for Subscriber listing
        $subcribers = $this->newsletter_model->get_all_subscribers ();
        $this->newsletter_model->_record_count = true;
        $total_records = $this->newsletter_model->get_all_subscribers ();
        // Pass data to view file
        $data['users'] = $subcribers;
        $data['page_number'] = $this->page_number;
        $data['total_records'] = $total_records;
        $data['search_term'] = $this->newsletter_model->search_term;
        $data['sort_by'] = $this->newsletter_model->sort_by;
        $data['sort_order'] = $this->newsletter_model->sort_order;

        // Breadcrumb
        $this->breadcrumb->add (lang ('subscribers'), base_url () . $this->section_name . '/newsletter/all_subscribers');
        //Create page-title
        $this->theme->set ('page_title', lang ('subscribers'));
        $this->theme->view ($data);
    }
    /*
     * function for check unique email
     */

    public function check_unique_email ()
    {
        $data = $this->input->post ('subscribersubmit');
        $result = $this->newsletter_model->check_unique_mail ($data);
        if ($result > 0) {
            $this->form_validation->set_message ('check_unique_email', lang ('user_already_exists'));
            return false;
        } else {
            return true;
        }
    }

    /**
     * Function delete to subscriber Ajax-Post
     */
    public function delete ()
    {
        $data = $this->input->post ();
        //casting
        $id = intval ($data['id']);
        $result = $this->newsletter_model->get_user_detail ($id);
        if (!empty ($result)) {
            $res = $this->newsletter_model->delete_user ($id);
            if ($res) {
                echo $this->theme->message (lang ('user-delete-success'), 'success');
            }
        } else {
            echo $this->theme->message (lang ('something_wrong'), 'error');
        }
    }
    /*
     * for the newsletters logics
     * @param string $action,$language_code,$id
     */

    public function newsletters_actions ($action = "add", $language_code = "", $id = "")
    {
        //Type Casting
        $action = trim (strip_tags ($action));
        $language_code = strip_tags ($language_code);
        $id = intval ($id);
        if ($this->input->post ('save')) {
            $subject = trim (strip_tags ($this->input->post ('subject')));
            $category = trim (strip_tags ($this->input->post ('category')));
            $title = trim (strip_tags ($this->input->post ('title')));
            $content = html_entity_decode (trim ($this->input->post ('content')));
            $template = trim (strip_tags ($this->input->post ('template')));
            $schedule = trim (strip_tags ($this->input->post ('schedule')));
            $schedule_now = trim (strip_tags ($this->input->post ('schedule_now')));
            $status = trim (strip_tags ($this->input->post ('status')));
        }
        if ($action == 'add' || $action == 'edit') {
            //Initialize
            $newsletter = array ();
            if ($language_code == '') {
                $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
            }
            // Logic
            $language_detail = $this->languages_model->get_languages_by_code ($language_code);
            $language_id = $language_detail[0]['l']['id'];
            if ($this->input->post ('save')) {
                $this->form_validation->set_rules ('title', 'Title', 'trim|required|xss_clean');
                $this->form_validation->set_rules ('content', 'Content', 'trim|required|xss_clean');
                $this->form_validation->set_rules ('subject', 'Subject', 'trim|required|xss_clean');
                $this->form_validation->set_rules ('schedule', 'Schedule date', 'trim|required|xss_clean');
                if ($this->form_validation->run ($this) == TRUE) {
                    $newsletter_data = $this->newsletter_model->get_related_lang_newsletter ($id, $language_id);
                    $this->newsletter_model->subject = $subject;
                    $this->newsletter_model->category = $category;
                    $this->newsletter_model->title = $title;
                    $this->newsletter_model->content = $content;
                    $this->newsletter_model->template = $template;
                    $this->newsletter_model->schedule = $schedule;
                    $this->newsletter_model->schedule_now = $schedule_now;
                    $this->newsletter_model->status = $status;

                    if (count ($newsletter_data) > 0) {
                        $this->newsletter_model->update_newsletter ($id, $language_id);
                        $this->theme->set_message (lang ('newsletter-update-success'), 'success');
                    } else {
                        if ($id == '0' || $id == '') {
                            $last_newsletter_id = $this->newsletter_model->get_last_newsletter_id ();
                            $id = $last_newsletter_id + 1;
                        }
                        $this->newsletter_model->add_newsletter ($id, $language_id);
                        $this->theme->set_message (lang ('newsletter-added-success'), 'success');
                    }
                    if (isset ($newsletter_data[0]['n']['newsletter_id']) && $newsletter_data[0]['n']['newsletter_id'] != '') {
                        $this->newsletter_model->update_content ($id, $language_id);
                    } else {
                        $this->newsletter_model->save_content ($id, $language_id);
                    }
                    if ($this->input->post ("schedule_now") == "yes") {
                        $subscriber_data = $this->newsletter_model->get_all_active_subscribers ();
                        foreach ($subscriber_data as $key1 => $value1) {
                            $data['to'] = $value1['s']['email'];
                            $data['user_id'] = $value1['s']['id'];
                            $data['id'] = $id;
                            $data['subject'] = $this->input->post ("subject");
                            $data['title'] = $this->input->post ("title");
                            $data['text'] = $this->input->post ("content");
                            $data['template_id'] = $this->input->post ("template");
                            $data['language_id'] = $language_id;
                            $this->newsletter_model->send_newsletter ($data);
                        }
                    }
                    redirect ($this->section_name . '/newsletter/all_newsletters/' . $language_code);
                }
            }
            if ($this->input->post ()) {
                $newsletter = $this->input->post ();
            } else {
                $newsletter = $this->input->post ();
            }
            $language_list = $this->languages_model->get_languages (); // get list of languages
            // Breadcrumb settings
            if ($action == "add") {
                $this->breadcrumb->add (lang ('newsletters'), base_url () . $this->section_name . '/newsletter/all_newsletters');
                $this->breadcrumb->add (lang ('add-newsletter'), base_url () . $this->section_name . '/newsletter/add_newsletters');
                //page title
                $this->theme->set ('page_title', lang ('add-newsletter'));
                $id = '';
            } elseif ($action == "edit") {
                $this->breadcrumb->add (lang ('newsletters'), base_url () . $this->section_name . '/newsletter/all_newsletters');
                $this->breadcrumb->add (lang ('edit_newsletter'), base_url () . $this->section_name . '/newsletter/edit_newsletters');
                //Create page-title
                $this->theme->set ('page_title', lang ('edit_newsletter'));
            }
            //Variable assignments to view        
            $data = array ();
            $data['action'] = $action;
            $data['id'] = $id;
            $data['language_code'] = $language_detail[0]['l']['language_code'];
            $data['language_name'] = $language_detail[0]['l']['language_name'];
            $data['language_id'] = $language_id;
            $data['csrf_token'] = $this->security->get_csrf_token_name ();
            $data['csrf_hash'] = $this->security->get_csrf_hash ();
            $data['languages_list'] = $language_list;
            $data['newsletters'] = $newsletter;
            $data['all_category'] = $this->newsletter_model->get_all_category ();
            $data['all_template'] = $this->newsletter_model->get_all_templates ($language_id);
            $this->theme->view ($data, 'admin_newsletters_actions');
        } else {
            $this->theme->set_message (lang ('permission-not-allowed'), 'error');
            redirect ($this->section_name . '/users');
            exit;
        }
    }
    /*
     * Function ajax_newsletters_actions For newsletter logic action performed by ajax post
     * * @param string $action,$language_code,$id,$ajax_load
     */

    public function ajax_newsletters_actions ($action = "add", $language_code = '', $id = '', $ajax_load = 1)
    {
        //Type Casting
        $action = trim (strip_tags ($action));
        $language_code = strip_tags ($language_code);
        $id = intval ($id);
        $ajax_load = intval ($ajax_load);

        //Initialize
        $newsletter = array ();
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        // Logic
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_id = $language_detail[0]['l']['id'];
        if (isset ($id) && $id != '' && $id != '0') {
            //Check whether record exist or not?
            $newsletter = $this->newsletter_model->get_newsletter_detail ($id, $language_detail[0]['l']['id']);
        }
        //Variable assignments to view        
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['newsletters'] = $newsletter;
        $data['all_category'] = $this->newsletter_model->get_all_category ();
        $data['all_template'] = $this->newsletter_model->get_all_templates ($language_id);
        if ($ajax_load == '1') echo $this->load->view ('admin_ajax_newsletters_actions', $data);
        else return $this->load->view ('admin_ajax_newsletters_actions', $data);
    }
    /*
     * Function all_newsletters for newsletter listing
     */

    public function all_newsletters ($language_code = '')
    {
        //Paging parameters
        $offset = get_offset ($this->page_number, $this->record_per_page);
        $this->newsletter_model->record_per_page = $this->record_per_page;
        $this->newsletter_model->offset = $offset;

        //language logic
        $language_code = strip_tags ($language_code);
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages ();


        //set sort/search parameters in pagging
        if ($this->input->post ()) {
            $data = $this->input->post ();
            if (isset ($data['search_term'])) {
                $this->newsletter_model->search_term = $data['search_term'];
            }
            if (isset ($data['sort_by']) && $data['sort_order']) {
                $this->newsletter_model->sort_by = $data['sort_by'];
                $this->newsletter_model->sort_order = $data['sort_order'];
            }
        }
        $all_newletters = $this->newsletter_model->get_all_newletters ($language_id);
        $this->newsletter_model->_record_count = true;
        $total_records = $this->newsletter_model->get_all_newletters ($language_id);

        $all_newletters['all_newletters'] = $all_newletters;
        $all_newletters['page_number'] = $this->page_number;
        $all_newletters['total_records'] = $total_records;
        $all_newletters['search_term'] = $this->newsletter_model->search_term;
        $all_newletters['sort_by'] = $this->newsletter_model->sort_by;
        $all_newletters['sort_order'] = $this->newsletter_model->sort_order;
        $all_newletters['language_code'] = $language_detail[0]['l']['language_code'];
        $all_newletters['language_id'] = $language_id;
        $all_newletters['languages_list'] = $language_list;
        $all_newletters['csrf_token'] = $this->security->get_csrf_token_name ();
        $all_newletters['csrf_hash'] = $this->security->get_csrf_hash ();

        //Breadcrums
        $this->breadcrumb->add (lang ('newsletters'), base_url () . $this->section_name . '/newsletter/all_newsletters');

        //Create page-title
        $this->theme->set ('page_title', lang ('newsletters'));
        $this->theme->view ($all_newletters);
    }

    /**
     * action to load list of newsletters based on language passed or from default language
     * @param string $language_code
     */
    function ajax_index ($language_code = '')
    {
        //pagging
        $offset = get_offset ($this->page_number, $this->record_per_page);
        $this->newsletter_model->record_per_page = $this->record_per_page;
        $this->newsletter_model->offset = $offset;

        //Type Casting
        $language_code = strip_tags ($language_code);

        //language logic
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_list = $this->languages_model->get_languages ();
        $language_id = $language_detail[0]['l']['id'];
        $this->lang->load ($this->_module, $language_detail[0]['l']['language_name']); //loads selected language file
        //set sort/search parameters in pagging
        if ($this->input->post ()) {
            $data = $this->input->post ();
            if (isset ($data['search_term'])) {
                $this->newsletter_model->search_term = $data['search_term'];
            }
            if (isset ($data['sort_by']) && $data['sort_order']) {
                $this->newsletter_model->sort_by = $data['sort_by'];
                $this->newsletter_model->sort_order = $data['sort_order'];
            }
            if (isset ($data['type']) && $data['type'] == 'delete') {
                if ($this->newsletter_model->delete_records_newsletters ($data['ids'])) {
                    echo $this->theme->message (lang ('newsletter-delete-success'), 'success');
                    exit;
                }
            }
            if (isset ($data['type']) && $data['type'] == 'active') {
                if ($this->newsletter_model->active_records_newsletters ($data['ids'])) {
                    echo $this->theme->message (lang ('newsletter-active-success'), 'success');
                    exit;
                }
            }
            if (isset ($data['type']) && $data['type'] == 'inactive') {
                if ($this->newsletter_model->inactive_records_newsletters ($data['ids'])) {
                    echo $this->theme->message (lang ('newsletter-inactive-success'), 'success');
                    exit;
                }
            }
            if (isset ($data['type']) && $data['type'] == 'active_all') {
                if ($this->newsletter_model->active_all_records_newsletters ()) {
                    echo $this->theme->message (lang ('newsletter-active-success'), 'success');
                    exit;
                }
            }
            if (isset ($data['type']) && $data['type'] == 'inactive_all') {
                if ($this->newsletter_model->inactive_all_records_newsletters ()) {
                    echo $this->theme->message (lang ('newsletter-inactive-success'), 'success');
                    exit;
                }
            }
        }
        $all_newletters = $this->newsletter_model->get_all_newletters ($language_id);
        $this->newsletter_model->_record_count = true;
        $total_records = $this->newsletter_model->get_all_newletters ($language_id);

        $data = array (
            'all_newletters' => $all_newletters,
            'language_code' => $language_code,
            'language_list' => $language_list,
            'language_id' => $language_id,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->newsletter_model->search_term,
            'sort_by' => $this->newsletter_model->sort_by,
            'sort_order' => $this->newsletter_model->sort_order
        );
        $this->theme->view ($data, 'admin_ajax_all_newsletter');
    }
    /*
     * Finction view_newsletter for view of perticular newsletter
     * @params integer $id, string $language_code
     */

    public function view_newsletter ($id, $language_code)
    {
        $id = intval ($id);
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $newsletterData = $this->newsletter_model->get_newsletter_detail ($id, $language_id);
        $newsletterData['user_id'] = $this->section_name['user_id'];
        //Breadcrums
        $this->breadcrumb->add (lang ('newsletters'), base_url () . $this->section_name . '/newsletter/all_newsletters');
        $this->breadcrumb->add (lang ('view_newsletters'), base_url () . $this->section_name . '/newsletter/view_newsletter');
        //page title
        $this->theme->set ('page_title', lang ('view_newsletters'));
        $data['subject'] = $newsletterData[0]['n']['subject'];
        $data['user_id'] = $this->session->userdata[$this->section_name]['user_id'];
        $data['title'] = $newsletterData[0]['nc']['title'];
        $data['text'] = $newsletterData[0]['nc']['text'];
        $data['view'] = '1';
      
        $this->theme->view ($data, $newsletterData[0]['t']['template_view_file']);
    }
    /*
     * Function send_all_newsletter to send mail to all active subscribers
     */

    public function send_all_newsletter ()
    {
        $newsletterData = $this->newsletter_model->get_all_active_newsletters ();
        $subscriberData = $this->newsletter_model->get_all_active_subscribers ();
        foreach ($subscriberData as $key1 => $value1) {
            $data['to'] = $value1['s']['email'];
            $data['user_id'] = $value1['s']['id'];
            foreach ($newsletterData as $key => $value) {
                $data['id'] = $value['n']['id'];
                $data['subject'] = $value['n']['subject'];
                $data['title'] = $value['c']['title'];
                $data['text'] = $value['c']['text'];
                $data['template'] = $value['t']['template_view_file'];
//                echo "<pre>";print_r($data);echo "</pre><hr><hr>";
                $this->newsletter_model->send_newsletter ($data);
            }
        }
    }
    /*
     * Function delete_newsletter to delete newsletter
     */

    public function delete_newsletter ()
    {
        $data = $this->input->post ();
        $id = intval ($data['id']);
        $language_id = intval ($data['language_id']);
        if (!empty ($id)) {
            $res = $this->newsletter_model->delete_newsletter ($id, $language_id);
            if ($res) {
                echo $this->theme->message (lang ('newsletter-delete-success'), 'success');
            }
        } else {
            echo $this->theme->message (lang ('something_wrong'), 'error');
        }
    }

    /**
     * Function  templates_actions for templates logic
     * @param $action,$language_code,$id
     */
    public function templates_actions ($action = "add", $language_code = "", $id = 0)
    {
        //Type Casting
        $action = trim (strip_tags ($action));
        $language_code = strip_tags ($language_code);
        $id = intval ($id);
        if ($this->input->post ('save')) {
            $template_title = trim (strip_tags ($this->input->post ('template_title')));
            $template_view_file = trim (strip_tags ($this->input->post ('template_view_file')));
        }
        if ($action == 'add' || $action == 'edit') {
            //Initialize
            $template = array ();
            if ($language_code == '') {
                $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
            }
            // Logic
            $language_detail = $this->languages_model->get_languages_by_code ($language_code);
            $language_id = $language_detail[0]['l']['id'];
            if ($this->input->post ('save')) {
                $this->form_validation->set_rules ('template_title', ' Template title', 'trim|required|xss_clean');
                $this->form_validation->set_rules ('template_view_file', 'Template view file', 'trim|required|xss_clean');
                if ($this->form_validation->run ($this) == true) {
                    $template_data = $this->newsletter_model->get_related_lang_template ($id, $language_id);

                    $this->newsletter_model->template_title = $template_title;
                    $this->newsletter_model->template_view_file = $template_view_file;

                    if (count ($template_data) > 0) {
                        $this->newsletter_model->update_templates ($id, $language_id);
                        $this->theme->set_message (lang ('template_updated_successfully'), 'success');
                    } else {
                        if ($id == '0' || $id == '') {
                            $last_template_id = $this->newsletter_model->get_last_template_id ();
                            $id = $last_template_id + 1;
                        }
                        $this->newsletter_model->add_newsletter_template ($id, $language_id);
                        $this->theme->set_message (lang ('template_created_successfully'), 'success');
                    }
                    redirect ($this->section_name . '/newsletter/all_templates/' . $language_detail[0]['l']['language_code']);
                }
            }
            if (!$this->input->post ()) {
                if (isset ($id) && $id != '' && $id != '0') {
                    $template = $this->newsletter_model->get_template_detail ($id, $language_detail[0]['l']['id']);
                }
            } else {
                $template = $this->input->post ();
            }
            $language_list = $this->languages_model->get_languages (); // get list of languages
            // Breadcrumb settings
            if ($action == "add") {
                $this->breadcrumb->add (lang ('newsletters'), base_url () . $this->section_name . '/newsletter/all_newsletters');
                $this->breadcrumb->add (lang ('templates'), base_url () . $this->section_name . '/newsletter/all_templates');
                $this->breadcrumb->add ('add_templates', base_url () . $this->section_name . '/newsletter/add_templates');
                //page title
                $this->theme->set ('page_title', lang ('add_templates'));
                $id = '';
            } elseif ($action == "edit") {
                //Breadcrums
                $this->breadcrumb->add (lang ('newsletters'), base_url () . $this->section_name . '/newsletter/all_newsletters');
                $this->breadcrumb->add (lang ('templates'), base_url () . $this->section_name . '/newsletter/all_templates');
                $this->breadcrumb->add (lang ('edit_templates'), base_url () . $this->section_name . '/newsletter/edit_templates');
                //page title
                $this->theme->set ('page_title', lang ('edit_templates'));
            }
            //Variable assignments to view        
            $data = array ();
            $data['action'] = $action;
            $data['id'] = $id;
            $data['language_code'] = $language_detail[0]['l']['language_code'];
            $data['language_name'] = $language_detail[0]['l']['language_name'];
            $data['language_id'] = $language_id;
            $data['csrf_token'] = $this->security->get_csrf_token_name ();
            $data['csrf_hash'] = $this->security->get_csrf_hash ();
            $data['languages_list'] = $language_list;
            $data['template'] = $template;
            $this->theme->view ($data);
        } else {
            $this->theme->set_message (lang ('permission-not-allowed'), 'error');
            redirect ($this->section_name . '/users');
            exit;
        }
    }

    /**
     * action to add/edit template page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    public function ajax_templates_actions ($action, $language_code = '', $id = 0, $ajax_load = 1)
    {
        //Type Casting
        $action = trim (strip_tags ($action));
        $language_code = strip_tags ($language_code);
        $id = intval ($id);
        $ajax_load = intval ($ajax_load);

        //Initialize
        $template = array ();
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic        
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_list = $this->languages_model->get_languages (); // get list of languages
        if (isset ($id) && $id != '' && $id != '0') {
            $template = $this->newsletter_model->get_template_detail ($id, $language_detail[0]['l']['id']);
        }
        //Variable assignments to view        
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['languages_list'] = $language_list;
        $data['template'] = $template;
        if ($ajax_load == '1') echo $this->load->view ('admin_ajax_templates_actions', $data);
        else return $this->load->view ('admin_ajax_templates_actions', $data);
    }
    /*
     * Function all_templates to listing all templates
     */

    public function all_templates ($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags ($language_code);

        //Initialize
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages ();

        //Paging parameters
        $offset = get_offset ($this->page_number, $this->record_per_page);
        $this->newsletter_model->record_per_page = $this->record_per_page;
        $this->newsletter_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post ()) {
            $templates = $this->input->post ();
            if (isset ($templates['search_term'])) {
                $this->newsletter_model->search_term = $templates['search_term'];
            }
            if (isset ($templates['sort_by']) && $templates['sort_order']) {
                $this->newsletter_model->sort_by = $templates['sort_by'];
                $this->newsletter_model->sort_order = $templates['sort_order'];
            }
        }
        $all_templates = $this->newsletter_model->get_all_templates ($language_id);
        $this->newsletter_model->_record_count = true;
        $total_records = $this->newsletter_model->get_all_templates ($language_id);

        $templates['language_code'] = $language_detail[0]['l']['language_code'];
        $templates['language_id'] = $language_id;
        $templates['languages_list'] = $language_list;
        $templates['csrf_token'] = $this->security->get_csrf_token_name ();
        $templates['csrf_hash'] = $this->security->get_csrf_hash ();
        $templates['templates'] = $all_templates;
        $templates['page_number'] = $this->page_number;
        $templates['total_records'] = $total_records;
        $templates['search_term'] = $this->newsletter_model->search_term;
        $templates['sort_by'] = $this->newsletter_model->sort_by;
        $templates['sort_order'] = $this->newsletter_model->sort_order;
        //Breadcrums
        $this->breadcrumb->add (lang ('newsletters'), base_url () . $this->section_name . '/newsletter/all_newsletters');
        $this->breadcrumb->add (lang ('all_templates'), base_url () . $this->section_name . '/newsletter/all_templates');
        //page title
        $this->theme->set ('page_title', lang ('all_templates'));
        $this->theme->view ($templates);
    }

    /**
     * action to load list of newsletters templates based on language passed or from default language
     * @param string $language_code
     */
    public function ajax_all_templates ($language_code = '')
    {
        //pagging
        $offset = get_offset ($this->page_number, $this->record_per_page);
        $this->newsletter_model->record_per_page = $this->record_per_page;
        $this->newsletter_model->offset = $offset;

        //Type Casting
        $language_code = strip_tags ($language_code);

        //language logic
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code ($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages ();
        $this->lang->load ($this->_module, $language_detail[0]['l']['language_name']); //loads selected language file
        //set sort/search parameters in pagging
        if ($this->input->post ()) {
            $data = $this->input->post ();
            if (isset ($data['search_term'])) {
                $this->newsletter_model->search_term = $data['search_term'];
            }
            if (isset ($data['sort_by']) && $data['sort_order']) {
                $this->newsletter_model->sort_by = $data['sort_by'];
                $this->newsletter_model->sort_order = $data['sort_order'];
            }
        }
        $all_templates = $this->newsletter_model->get_all_templates ($language_id);
        $this->newsletter_model->_record_count = true;
        $total_records = $this->newsletter_model->get_all_templates ($language_id);
        $templates['language_code'] = $language_detail[0]['l']['language_code'];
        $templates['language_id'] = $language_id;
        $templates['languages_list'] = $language_list;
        $templates['csrf_token'] = $this->security->get_csrf_token_name ();
        $templates['csrf_hash'] = $this->security->get_csrf_hash ();
        $templates['templates'] = $all_templates;
        $templates['page_number'] = $this->page_number;
        $templates['total_records'] = $total_records;
        $templates['search_term'] = $this->newsletter_model->search_term;
        $templates['sort_by'] = $this->newsletter_model->sort_by;
        $templates['sort_order'] = $this->newsletter_model->sort_order;
        $this->theme->view ($templates);
    }
    /*
     * Delete template
     */

    public function delete_template ()
    {
        $data = $this->input->post ();
        $id = intval ($data['id']);
        $language_id = intval ($data['language_id']);

        $result = $this->newsletter_model->get_template_detail ($id, $language_id);
        if (!empty ($result)) {
            $res = $this->newsletter_model->delete_template ($id, $language_id);
            if ($res) {
                echo $this->theme->message (lang ('template_deleted_successfully'), 'success');
            }
        } else {
            echo $this->theme->message (lang ('something_wrong'), 'error');
        }
    }
}
?>