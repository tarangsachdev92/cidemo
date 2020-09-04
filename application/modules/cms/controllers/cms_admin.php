<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  CMS Admin Controller
 *
 *  CMS Admin controller to display add / Edit / Delete / List CMS page for each language.
 *
 * @package CIDemoApplication
 *
 * @copyright	(c) 2013, TatvaSoft
 * @author AMPT
 */
class Cms_admin extends Base_Admin_Controller {
    /*
     * Create an instance
     */

    function __construct() {
        parent::__construct();
        // Login check for admin
        $this->access_control($this->access_rules());

        // Load required helpers
        $this->load->helper('url');
        $this->load->helper('ckeditor');

        // load required models
        $this->load->model('cms/cms_meta_model');
        $this->load->model('urls/urls_model');

        // Breadcrumb settings
        $this->breadcrumb->add('CMS Management', base_url() .$this->section_name. '/cms');
    }

    /**
     * function accessRules to check page access
     */
    private function access_rules() {
        return array(
            array(
                'actions' => array('action', 'index', 'ajax_index', 'ajax_action', 'delete', 'view_data', 'view', 'ajax_view'),
                'users' => array('@'),
            )
        );
    }

    /**
     * action to display language wise list of cms page
     * @param string $language_code
     */
    function index($language_code = '') {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();

        //Set page title
        $this->theme->set('page_title', 'CMS List');

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
    function ajax_index($language_code = '') {





        // -X-X-X-X-X-X-X-X-X-X-X-X-X-X-X-X-X-X-X-X-X-X-X-X-
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->cms_model->record_per_page = $this->record_per_page;
        $this->cms_model->offset = $offset;

//        if (!empty($this->cms_model->offset)) {
//            $this->session->set_custom_userdata($this->section_name, "cms_offset", $this->cms_model->offset);
//        }
//        if (!empty($this->cms_model->offset)) {
//            $this->session->set_custom_userdata($this->section_name, "cms_page_number", $this->page_number);
//        }





        //set sort/search parameters in pagging
        if ($this->input->post()) {
            $data = $this->input->post();

            if(empty($data['page_number']) || $data['page_number'] == 1)
            {
                $this->session->set_custom_userdata($this->section_name, "cms_offset", "");
                $this->session->set_custom_userdata($this->section_name, "cms_page_number", "");
            }


            if (isset($data['search_term'])) {
                $this->cms_model->search_term = trim($data['search_term']);
                 $this->session->set_custom_userdata($this->section_name, "cms_search_term", $this->input->post('search_term'));
            }
            else {
                $this->session->set_custom_userdata($this->section_name, "cms_search_term", "");
            }


            if (isset($data['sort_by']) && $data['sort_order']) {
                $this->cms_model->sort_by = $data['sort_by'];
                $this->cms_model->sort_order = $data['sort_order'];
                $this->session->set_custom_userdata($this->section_name, "cms_sort_by", $this->input->post('sort_by'));
                $this->session->set_custom_userdata($this->section_name, "cms_sort_order", $this->input->post('sort_order'));
            }
            else {
                $this->session->set_custom_userdata($this->section_name, "cms_sort_by", "");
                $this->session->set_custom_userdata($this->section_name, "cms_sort_order", "");
            }


            if (isset($data['type']) && $data['type'] == 'delete') {
                if ($this->cms_model->delete_records($data['ids'])) {
                    echo $this->theme->message(lang('delete_success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active') {
                if ($this->cms_model->active_records($data['ids'])) {
                    echo $this->theme->message(lang('cms-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive') {
                if ($this->cms_model->inactive_records($data['ids'])) {
                    echo $this->theme->message(lang('cms-inactive-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active_all') {
                if ($this->cms_model->active_all_records($data['lang'])) {
                    echo $this->theme->message(lang('cms-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all') {
                if ($this->cms_model->inactive_all_records($data['lang'])) {
                    echo $this->theme->message(lang('cms-inactive-success'), 'success');
                    exit;
                }
            }
        }


        if (!empty($this->session->userdata[$this->section_name]['cms_search_term'])) {
            $this->cms_model->search_term = trim($this->session->userdata[$this->section_name]['cms_search_term']);
        }
        if (!empty($this->session->userdata[$this->section_name]['cms_sort_by'])) {
            $this->cms_model->sort_by = $this->session->userdata[$this->section_name]['cms_sort_by'];
        }
        if (!empty($this->session->userdata[$this->section_name]['cms_sort_order'])) {
            $this->cms_model->sort_order = $this->session->userdata[$this->section_name]['cms_sort_order'];
        }
        if (!empty($this->session->userdata[$this->section_name]['cms_offset'])) {
            $this->cms_model->offset = $this->session->userdata[$this->section_name]['cms_offset'];
        }
        if (!empty($this->session->userdata[$this->section_name]['cms_page_number'])) {
            $this->page_number = $this->session->userdata[$this->section_name]['cms_page_number'];
        }

        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $cms_list = $this->cms_model->get_cms_listing($language_detail[0]['l']['id']);

        $this->cms_model->_record_count = true;
        $total_records = $this->cms_model->get_cms_listing($language_detail[0]['l']['id']);

        //Variable assignments to view
        $data = array(
            'cms_list' => $cms_list,
            'language_code' => $language_code,
            'language_id' => $language_detail[0]['l']['id'],
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->cms_model->search_term,
            'sort_by' => $this->cms_model->sort_by,
            'sort_order' => $this->cms_model->sort_order
        );
        
        $this->theme->view($data, 'admin_ajax_index');
        
        
    }

    /**
     * action to add/edit cms page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function action($action, $language_code = '', $id = 0) {

        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        if ($this->input->post('cmssubmit')) {
            $title = trim(strip_tags($this->input->post('title')));
            $slug_url = trim(strip_tags($this->input->post('slug_url')));
            $description = trim($this->input->post('description'));
            $status = trim(strip_tags($this->input->post('status')));
            $meta_title = trim(strip_tags($this->input->post('meta_title')));
            $meta_keywords = trim(strip_tags($this->input->post('meta_keywords')));
            $meta_description = trim(strip_tags($this->input->post('meta_description')));
        }

        if ($action == 'add' || $action == 'edit') {

            //var_dump($this->session->userdata[$this->section_name]['cms']);
            //exit;
            //Initialize
            $cms_list = array();
            $cms_list_result = array();
            if ($language_code == '') {
                $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
            }

            // Logic
            $language_detail = $this->languages_model->get_languages_by_code($language_code);
            $language_id = $language_detail[0]['l']['id'];
            if ($this->input->post('cmssubmit')) {
                //Validation Check
                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
                //$this->form_validation->set_rules('slug_url', 'Slug URL', 'required|is_unique[cms.slug_url.cms_id.' . $id . ']|xss_clean');
                $this->form_validation->set_rules('slug_url', 'Slug URL', 'required|callback_check_unique_slug_url|xss_clean');

                if ($this->form_validation->run($this) == true) {
                    $cms_data = $this->cms_model->get_related_lang_cms($id, $language_id);

                    $this->cms_model->title = $title;
                    $this->cms_model->slug_url = $slug_url;
                    $this->cms_model->description = $description;
                    $this->cms_model->status = $status;
                    $this->cms_meta_model->meta_title = $meta_title;
                    $this->cms_meta_model->meta_keywords = $meta_keywords;
                    $this->cms_meta_model->meta_description = $meta_description;

                    if (count($cms_data) > 0) {
                        $this->cms_model->update_cms($id, $language_id);
                        $this->theme->set_message(lang('msg-update-success'), 'success');
                    } else {
                        if ($id == '0' || $id == '') {
                            $last_cms_id = $this->cms_model->get_last_cms_id();
                            $id = $last_cms_id + 1;
                        }

                        $this->cms_model->insert_cms($id, $language_id);
                        $this->theme->set_message(lang('msg-add-success'), 'success');
                    }

                    if (isset($cms_data[0]['cm']['cms_id']) && $cms_data[0]['cm']['cms_id'] != '') {
                        $this->cms_meta_model->update_cms_meta($id, $language_id);
                    } else {
                        $this->cms_meta_model->insert_cms_meta($id, $language_id);
                    }
                    $this->config_model->change_slug_url_management($this->input->post('old_slug_url'), $this->input->post('slug_url'), 'cms', $id, 'index/' . $this->input->post('slug_url'), $this->input->post('status'), $language_id);

                    $this->load->module('urls/urls_admin');
                    $this->urls_admin->generate_custom_url();

                    redirect($this->section_name . '/cms/index/' . $language_detail[0]['l']['language_code']);
                }
            }

            if (!$this->input->post()) {
                if (isset($id) && $id != '' && $id != '0') {
                    $cms_list_result = $this->cms_model->get_cms_detail_by_id($id, $language_detail[0]['l']['id']);
                    $cms_list = array_merge($cms_list_result[0]['c'], $cms_list_result[0]['cm']);
                }
            } else {
                $cms_list = $this->input->post();
            }
            $language_list = $this->languages_model->get_languages(); // get list of languages
            // Breadcrumb settings
            if ($action == "add") {
                $this->theme->set('page_title', lang('add_cms'));
                $this->breadcrumb->add(lang('add_cms'));
                $id = '';
            } elseif ($action == "edit") {
                $this->theme->set('page_title', lang('edit_cms'));
                $this->breadcrumb->add(lang('edit_cms'));
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
            $data['cms'] = $cms_list;
            $data['content'] = $this->load->view('admin_ajax_action', $data, TRUE);
            $this->theme->view($data, 'admin_action');
        } else {
            $this->theme->set_message(lang('permission-not-allowed'), 'error');
            redirect($this->section_name . '/users');
            exit;
        }
    }

    /**
     * action to add/edit cms page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_action($action, $language_code = '', $id = 0, $ajax_load = 1) {
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $ajax_load = intval($ajax_load);

        //Initialize
        $cms_list = array();
        $cms_list_result = array();
        $data = array();
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        if (isset($id) && $id != '' && $id != '0') {
            $cms_list_result = $this->cms_model->get_cms_detail_by_id($id, $language_detail[0]['l']['id']);
            if (!empty($cms_list_result)) {
                if (!empty($cms_list_result[0]['c']) && !empty($cms_list_result[0]['cm']))
                    $cms_list = array_merge($cms_list_result[0]['c'], $cms_list_result[0]['cm']);
            }
        }
        //Variable assignments to view
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['cms'] = $cms_list;
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_action', $data);
        else
            return $this->load->view('admin_ajax_action', $data);
    }

    /**
     * action view to view cms page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    function view($language_code = '', $id = 0) {
        //Type Casting
        $language_code = strip_tags($language_code);
        $id = intval($id);

        //Initialize
        $cms_list = array();
        $cms_list_result = array();
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        if (isset($id) && $id != '' && $id != '0') {
            $cms_list_result = $this->cms_model->get_cms_detail_by_id($id, $language_detail[0]['l']['id']);
            $cms_list = array_merge($cms_list_result[0]['c'], $cms_list_result[0]['cm']);
        }
        $language_list = $this->languages_model->get_languages(); // get list of languages
        // Breadcrumb settings

        

        //Variable assignments to view
        $data = array();
        $data['id'] = $id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['languages'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['cms'] = $cms_list;
        $data['content'] = $this->load->view('admin_ajax_view', $data, TRUE);
        
        $this->theme->set('page_title', lang('view_cms'));
        $this->breadcrumb->add(lang('view_cms'));
        
        $this->theme->view($data);
    }

    /**
     * action to add/edit cms page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_view($language_code = '', $id = 0, $ajax_load = 1) {
        //Type Casting
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $ajax_load = intval($ajax_load);

        //Initialize
        $cms_list = array();
        $cms_list_result = array();
        $data = array();
        if ($language_code == '') {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        if (isset($id) && $id != '' && $id != '0') {
            $cms_list_result = $this->cms_model->get_cms_detail_by_id($id, $language_detail[0]['l']['id']);
            if (!empty($cms_list_result)) {
                if (!empty($cms_list_result[0]['c']) && !empty($cms_list_result[0]['cm']))
                    $cms_list = array_merge($cms_list_result[0]['c'], $cms_list_result[0]['cm']);
            }
        }
        //Variable assignments to view
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['cms'] = $cms_list;
        
        $this->theme->set('page_title', lang('view_cms'));
        $this->breadcrumb->add(lang('view_cms'));
        
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_view', $data);
        else
            return $this->load->view('admin_ajax_view', $data);
    }

    // Function to delete the cms record and related url management record
    function delete() {
        //Initialise
        $id = $this->input->post('id');
        $slug_url = $this->input->post('slug_url');

        //Type casting
        $id = intval($id);
        $slug_url = trim(strip_tags($slug_url));

        //logic
        if ($id != 0 && $id != '' && is_numeric($id)) {
            $data['cms'] = $this->cms_model->delete_cms($id);
            if ($slug_url != '') {
                $this->urls_model->delete_url_by_slug($slug_url);
            }
            $message = $this->theme->message(lang('delete_success'), 'success');
        } else {
            $message = $this->theme->message(lang('invalid-id-msg'), 'error');
        }
        echo $message;
    }

    /**
     * function check_unique_slug_url to check unique slug url
     */
    public function check_unique_slug_url() {
        //variable assignement
        $id = '';

        //Get url management id
        if ($this->input->post('old_slug_url') != '') {
            $url_detail = $this->urls_model->get_url_management_id_by_slug($this->input->post('old_slug_url'));
            $id = $url_detail[0]['um']['id'];
        }

        $slug_url = $this->input->post('slug_url');

        $result = $this->urls_model->check_unique_slug($slug_url, $id);

        if (count($result) > 0) {
            $this->form_validation->set_message('check_unique_slug_url', lang('msg-alvailable-slug_url'));
            return false;
        } else {
            return true;
        }
    }

}

?>