<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *  Sample Admin Controller
 *
 *  An example class with few methods to show how controller can be created
 * 
 * @package CIDemoApplication
 * @subpackage Sample
 * @copyright	(c) 2013, TatvaSoft
 * @author NIPT
 */
class quiz_admin extends Base_Admin_Controller
{

    /**
     * 	Create an instance
     * 
     */
    public function __construct()
    {
        parent::__construct();
        // Login check for admin
        $this->access_control($this->access_rules());

        // Load required helpers
        $this->load->helper(array('url', 'form'));

        // Load required libraries
        $this->load->library('form_validation');

        // load required models
        $this->load->model('quiz_categories_model');
        $this->load->model('quiz_subjects_model');
        $this->load->model('quiz_chapters_model');
        $this->load->model('quizzes_model');
        $this->load->model('quizzes_questions_model');
        $this->load->model('quiz_questions_model');
        $this->load->model('quiz_question_options_model');

        // load quiz module language file for labels translation
        $this->lang->load('quiz');

        //Load the configuaration file of the quiz module ie. config.php, for more details regarding config class refer the link : http://ellislab.com/codeigniter/user-guide/libraries/config.html

        $this->config->load('config');

        $all_configurations_array = $this->config->config;
        //pre($all_configurations_array);
        // Retrieve a config item named quiz_configuartions
        $quiz_configuartions = $this->config->item('quiz_configuartions');
        $quiz_module_id = $quiz_configuartions['module_id'];

        //set the quiz module id in the global configuratoins so that its value can be retrieved in all models
        $this->config->set_item('quiz_module_id', $quiz_module_id);
        //pre($this->config);
    }

    /**
     * function accessRules to check page access
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('index', 'admin_ajax_index',
                    'category_action', 'categories', 'ajax_categories_list', 'delete_category',
                    'subject_action', 'ajax_subject_action', 'subjects', 'ajax_subjects_list', 'delete_subject',
                    'chapter_action', 'ajax_chapter_action', 'chapters', 'ajax_chapters_list', 'delete_chapter', 'select_chapters_from_subjects',
                    'question_action', 'ajax_question_action', 'questions', 'ajax_questions_list', 'delete_question',
                    'quizzes_action', 'ajax_quizzes_action', 'quizzes', 'ajax_quizzes_list', 'delete_quizzes', 'select_questions_from_categories', 'select_quizzes_questions_from_categories'),
                'users' => array('@'),
            )
        );
    }

    /**
     * Default Method: index
     * Displays a list of data.
     */
    public function index($language_code = "")
    {
        // Initialise variables
        $quizzes = array();
        //language logic

        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();

        // set breadcrumb
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url() . $this->section_name.'/quiz');
        //Set page title
        $this->theme->set('page_title', lang('page_title_quiz_management'));

        $quizzes['language_code'] = $language_detail[0]['l']['language_code'];
        $quizzes['language_id'] = $language_id;
        $quizzes['languages_list'] = $language_list;
        $quizzes['csrf_token'] = $this->security->get_csrf_token_name();
        $quizzes['csrf_hash'] = $this->security->get_csrf_hash();

        //load view and pass data array to view file
        $this->theme->view($quizzes);
    }

    /**
     * action to load list of newsletters based on language passed or from default language
     * @param string $language_code
     */
    function admin_ajax_index($language_code = '')
    {
        //pagging
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->quizzes_model->record_per_page = $this->record_per_page;
        $this->quizzes_model->offset = $offset;

        //Type Casting
        $language_code = strip_tags($language_code);

        //language logic
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        $this->lang->load($this->_module, $language_detail[0]['l']['language_name']); //loads selected language file
        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_term']))
            {
                $this->quizzes_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->quizzes_model->sort_by = $data['sort_by'];
                $this->quizzes_model->sort_order = $data['sort_order'];
            }
        }
        $quizzes = $this->quizzes_model->get_quizzes_report_dashboard($language_id);
        $this->quizzes_model->_record_count = true;
        $total_records = $this->quizzes_model->get_quizzes_report_dashboard($language_id);
        $data = array(
            'quizzes' => $quizzes,
            'language_code' => $language_code,
            'language_list' => $language_list,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->quizzes_model->search_term,
            'sort_by' => $this->quizzes_model->sort_by,
            'sort_order' => $this->quizzes_model->sort_order
        );
        $this->theme->view($data, 'admin_ajax_index');
    }

    ////////-----------------  Categories  -------------------------///////////////
    /**
     * action to add/edit category page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    public function category_action($action = "add", $language_code = '', $id = 0)
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        $id = intval($id); //echo 'id = '.$id;
        $action = strip_tags($action);
        custom_filter_input('integer', $id);

        //Initialize
        $details_arr = array();

        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        //pre($language_detail);
        $language_id = $language_detail[0]['l']['id'];

        $languages_list = $this->languages_model->get_languages();

        //check for post data
        if ($this->input->post())
        {
            //pre($this->input->post());exit;
            $this->form_validation->set_rules('category_title', lang('category_title'), 'required|xss_clean');
            $this->form_validation->set_rules('parent_category_id', lang('parent_category'), 'required|xss_clean');
            $this->form_validation->set_rules('status', lang('status'), 'required|xss_clean');

            //check for validation errors
            if ($this->form_validation->run() == true)
            {
                $category_title = trim(strip_tags($this->input->post('category_title')));
                $parent_category_id = trim(strip_tags($this->input->post('parent_category_id')));
                $status = trim(strip_tags($this->input->post('status')));

                //if it is edit mode
                if ($id != '' && $action == 'edit')
                {
                    $data_array = array(
                        'title' => $category_title,
                        'parent_id' => $parent_category_id,
                        'status' => $status,
                        'lang_id' => $language_id,
                        'module_id' => $this->config->item("quiz_module_id")
                    );

                    //check whether the category_id with such a language_id already exists or not, if it exists then update the details
                    if($this->quiz_categories_model->check_existence($language_id, $id))
                    {
                        $this->quiz_categories_model->update($language_id, $id, $data_array);
                        $this->theme->set_message(lang('msg_category_details_update_success'), 'success');
                    }
                    else//if category does not exist then insert details
                    {
                        $data_array['category_id'] = $id;
                        $this->quiz_categories_model->insert($data_array);
                        $this->theme->set_message(lang('msg_category_created_success'), 'success');
                    }
                    //exit;

                }
                ///if it is add mode
                else if (($id == '0' || $id == '') && $action == "add")
                {
                    $last_category_id = $this->quiz_categories_model->get_last_category_id();
                    $category_id = $last_category_id + 1;

                    $data_array = array(
                        'category_id' => $category_id,
                        'title' => $category_title,
                        'parent_id' => $parent_category_id,
                        'status' => $status,
                        'lang_id' => $language_id,
                        'module_id' => $this->config->item("quiz_module_id")
                    );
                    $this->quiz_categories_model->insert($data_array);
                    $this->theme->set_message(lang('msg_category_created_success'), 'success');
                }
                redirect($this->section_name.'/quiz/categories/' . $language_detail[0]['l']['language_code']);
            }
        }

        //if no data has been posted i.e. during edit mode, fetch the details from the id and language_id
        if (!$this->input->post())
        {
            if (isset($id) && $id != '' && $id != '0' && $action == "edit")
            {
                //echo $language_code;

                $details_arr = $this->quiz_categories_model->get_details_by_ids($language_id, $id_array = array($id));
                //echo '<pre>details_arr = ';print_r($details_arr);exit;

                //Check whether record exist or not?
                if (empty($details_arr))
                {
                    //$this->theme->set_message('No such category found', 'error');
                    //redirect('admin/quiz/categories/' . $lang_code);
                    //break;

                }
                else
                {
                    $details_arr = $details_arr[0]['c'];
                    //echo '<pre>details_arr = ';print_r($details_arr);exit;
                }
            }
        }
        else
        {
            $details_arr = $this->input->post();
        }

        // get list of languages
        $language_list = $this->languages_model->get_languages();

        // get list of root categories
        $root_categories_list = array();
        $root_categories_list = $this->quiz_categories_model->get_root_categories($language_id, $category_ids = array($id));

        // Breadcrumb settings
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url().$this->section_name.'/quiz');
        $this->breadcrumb->add(lang('bc_quiz_categories'), base_url().$this->section_name.'/quiz/categories');

        if ($action == 'add' && ($id == '' || $id == '0'))
        {
            $this->theme->set('page_title', lang('add_new_category'));
            $this->breadcrumb->add(lang('add_new_category'));
        }
        else if (isset($id) && $id != '' && $id != '0' && $action == "edit")
        {
            $this->theme->set('page_title', lang('edit_category'));
            $this->breadcrumb->add(lang('edit_category'));
        }
        else
        {
            $this->theme->set_message(lang('msg_no_such_action_allowed'), 'error');
            redirect($this->section_name.'/quiz/categories/' . $lang_code);
            break;
        }

        // Pass data to view file
        $data = array();
        $data['details'] = $details_arr;
        $data['root_categories_list'] = $root_categories_list;
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $languages_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['languages'] = $language_list;

        //Render view
        $this->theme->view($data, 'category_action');
    }
    /*
     * listing of category page
     * @param string $language_code
     */

    public function categories($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $data = array();
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url().$this->section_name.'/quiz');
        $this->breadcrumb->add(lang('bc_quiz_categories'), base_url().$this->section_name.'/quiz/categories');
        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        $this->quiz_categories_model->_record_count = true;
        $record_count = $this->quiz_categories_model->get_categories_listing($language_detail[0]['l']['id']);
        if ($record_count == 0)
        {
            $data['msg_no_category_records'] = $this->lang->line('msg_no_category_records');
        }
        else
        {
            $data['msg_no_category_records'] = "";
        }

        //Variable assignments to view
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        //Set page title
        $this->theme->set('page_title', lang('page_title_categories_list'));

        //load view and pass data array to view file
        $this->theme->view($data, 'categories');
    }
    /*
     * listing of category page by ajax
     * @param string $language_code
     */

    function ajax_categories_list($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->quiz_categories_model->record_per_page = $this->record_per_page;
        $this->quiz_categories_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_term']))
            {
                $this->quiz_categories_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->quiz_categories_model->sort_by = $data['sort_by'];
                $this->quiz_categories_model->sort_order = $data['sort_order'];
            }
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $this->lang->load($this->_module, $language_detail[0]['l']['language_name']); //loads selected language file

        $listing_data = $this->quiz_categories_model->get_categories_listing($language_detail[0]['l']['id']);
        $this->quiz_categories_model->_record_count = true;
        $total_records = $this->quiz_categories_model->get_categories_listing($language_detail[0]['l']['id']);
        $data = array(
            'listing_data' => $listing_data,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->quiz_categories_model->search_term,
            'sort_by' => $this->quiz_categories_model->sort_by,
            'sort_order' => $this->quiz_categories_model->sort_order
        );
        $this->theme->view($data, 'ajax_categories_list');
    }
    /*
     * to perform delete action of category
     */

    function delete_category()
    {
        //Initialise
        $id = $this->input->post('id');
        //Type casting
        $id = intval($id);
        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $this->quiz_categories_model->delete($id);
            $this->quiz_categories_model->_record_count = true;
            $total_records = $this->quiz_categories_model->get_categories_listing($language_detail[0]['l']['id']);

            if ($total_records > 0)
                $response = array('no_records' => 'FALSE');
            else
                $response = array('no_records' => 'TRUE');

            echo json_encode($response);
        }
    }

    ////////-----------------  Subjects  -------------------------///////////////
    /**
     * action to add/edit subject page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    public function subject_action($action = "add", $language_code = '', $id = 0)
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        $id = intval($id); //echo 'id = '.$id;
        $action = strip_tags($action);
        custom_filter_input('integer', $id);
        //Initialize
        $details_arr = array();

        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();

        if ($this->input->post())
        {
            //pre($this->input->post());exit;
            $this->form_validation->set_rules('subject_name', lang('subject_name'), 'required|xss_clean');
            $this->form_validation->set_rules('category_id', lang('category_name'), 'required|xss_clean');
            $this->form_validation->set_rules('status', lang('status'), 'required|xss_clean');

            if ($this->form_validation->run() == true)
            {
                $subject_name = trim(strip_tags($this->input->post('subject_name')));
                $category_id = trim(strip_tags($this->input->post('category_id')));
                $status = trim(strip_tags($this->input->post('status')));

                //if it is edit mode
                if ($id != '' && $action == 'edit')
                {
                    $data_array = array(
                        'subject_name' => $subject_name,
                        'category_id' => $category_id,
                        'status' => $status,
                        'lang_id' => $language_id
                    );

                    //check whether the category_id with such a language_id already exists or not, if it exists then update the details
                    if($this->quiz_subjects_model->check_existence($language_id, $id))
                    {
                        $this->quiz_subjects_model->update($language_id, $id, $data_array);
                        $this->theme->set_message(lang('msg_subject_details_update_success'), 'success');
                    }
                    else//if category does not exist then insert details
                    {
                        $data_array['subject_id'] = $id;
                        $this->quiz_subjects_model->insert($data_array);
                        $this->theme->set_message(lang('msg_subject_created_success'), 'success');
                    }
                    //exit;
                }

                ///if it is add mode
                else if (($id == '0' || $id == '') && $action == "add")
                {
                    $last_id = $this->quiz_subjects_model->get_max_id();
                    $subject_id = $last_id + 1;

                    $data_array = array(
                        'subject_id' => $subject_id,
                        'subject_name' => $subject_name,
                        'category_id' => $category_id,
                        'status' => $status,
                        'lang_id' => $language_id
                    );
                    $this->quiz_subjects_model->insert($data_array);
                    $this->theme->set_message(lang('msg_subject_created_success'), 'success');
                }
                redirect($this->section_name.'/quiz/subjects/'.$language_code);
            }
        }


        if (!$this->input->post())
        {
            if (isset($id) && $id != '' && $id != '0' && $action == "edit")
            {
                //Check whether record exist or not?
                $details_arr = $this->quiz_subjects_model->get_details_by_ids($language_id, $id_array = array($id));

                if (empty($details_arr))
                {
                    //$this->theme->set_message(lang('msg_no_such_subject_found'), 'error');
                    //redirect('admin/quiz/subjects/' . $language_code);
                    //break;
                }
                else
                {
                    $details_arr = $details_arr[0]['s'];
                }
            }
        }
        else
        {
            $details_arr = $this->input->post();
        }

        // get list of languages
        $language_list = $this->languages_model->get_languages();
        $categories_list = array();
        $categories_list = $this->quiz_categories_model->select_all($fetch_details_arr = array('mode' => 'fetch_all_active', 'language_id' => $language_id));

        // Breadcrumb settings
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url().$this->section_name.'/quiz');
        $this->breadcrumb->add(lang('bc_quiz_subjects'), base_url().$this->section_name.'/quiz/subjects');

        if ($action == 'add' && ($id == '' || $id == '0'))
        {
            $this->theme->set('page_title', lang('add_new_subject'));
            $this->breadcrumb->add(lang('add_new_subject'));
        }
        else if (isset($id) && $id != '' && $id != '0' && $action == "edit")
        {
            $this->theme->set('page_title', lang('edit_subject'));
            $this->breadcrumb->add(lang('edit_subject'));
        }
        else
        {
            $this->theme->set_message(lang('msg_no_such_action_allowed'), 'error');
            redirect($this->section_name.'/quiz/subjects/' . $lang_code);
            break;
        }
        // Pass data to view file
        $data = array();
        $data['details'] = $details_arr;
        $data['categories_list'] = $categories_list;
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['languages_list'] = $language_list;
        //Render view
        $this->theme->view($data, 'subject_action');
    }


    /*
     * listing of subjects page
     * @param string $language_code
     */

    public function subjects($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $data = array();
        //Logic
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url().$this->section_name.'/quiz');
        $this->breadcrumb->add(lang('bc_quiz_subjects'), base_url().$this->section_name.'/quiz/subjects');
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        $this->quiz_subjects_model->_record_count = true;
        $record_count = $this->quiz_subjects_model->get_subjects_listing($language_detail[0]['l']['id']);

        if ($record_count == 0)
        {
            $data['msg_no_subject_records'] = $this->lang->line('msg_no_subject_records');
        }
        else
        {
            $data['msg_no_subject_records'] = "";
        }
        //Variable assignments to view
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        //Set page title
        $this->theme->set('page_title', lang('page_title_subjects_list'));

        //load view and pass data array to view file
        $this->theme->view($data, 'subjects');
    }
    /*
     * listing of category page by ajax
     * @param string $language_code
     */

    function ajax_subjects_list($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->quiz_subjects_model->record_per_page = $this->record_per_page;
        $this->quiz_subjects_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_term']))
            {
                $this->quiz_subjects_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->quiz_subjects_model->sort_by = $data['sort_by'];
                $this->quiz_subjects_model->sort_order = $data['sort_order'];
            }
        }
        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $this->lang->load($this->_module, $language_detail[0]['l']['language_name']); //loads selected language file

        $listing_data = $this->quiz_subjects_model->get_subjects_listing($language_detail[0]['l']['id']);
        $this->quiz_subjects_model->_record_count = true;
        $total_records = $this->quiz_subjects_model->get_subjects_listing($language_detail[0]['l']['id']);

        //Variable assignments to view
        $data = array(
            'listing_data' => $listing_data,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->quiz_subjects_model->search_term,
            'sort_by' => $this->quiz_subjects_model->sort_by,
            'sort_order' => $this->quiz_subjects_model->sort_order
        );
        $this->theme->view($data, 'ajax_subjects_list');
    }
    /*
     * to perform delete action of category
     */

    function delete_subject()
    {
        //Initialise
        $id = $this->input->post('id');
        //Type casting
        $id = intval($id);
        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $this->quiz_subjects_model->delete($id);
            $this->quiz_subjects_model->_record_count = true;
            $total_records = $this->quiz_subjects_model->get_subjects_listing($language_detail[0]['l']['id']);

            if ($total_records > 0)
                $response = array('no_records' => 'FALSE');
            else
                $response = array('no_records' => 'TRUE');

            echo json_encode($response);
        }
    }

    ////////-----------------  Chapters  -------------------------///////////////
    /**
     * action to add/edit chapter page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    public function chapter_action($action = "add", $language_code = '', $id = 0)
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        $id = intval($id); //echo 'id = '.$id;
        $action = strip_tags($action);
        custom_filter_input('integer', $id);

        //Initialize
        $details_arr = array();

        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];


        if ($this->input->post())
        {
            $this->form_validation->set_rules('chapter_name', lang('chapter_name'), 'required|xss_clean');
            $this->form_validation->set_rules('subject_id', lang('subject'), 'required|xss_clean');
            $this->form_validation->set_rules('status', lang('status'), 'required|xss_clean');

            if ($this->form_validation->run() == true)
            {
                $chapter_name = trim(strip_tags($this->input->post('chapter_name')));
                $subject_id = trim(strip_tags($this->input->post('subject_id')));
                $status = trim(strip_tags($this->input->post('status')));


                //if it is edit mode
                if ($id != '' && $action == 'edit')
                {
                    $data_array = array(
                        'chapter_name' => $chapter_name,
                        'subject_id' => $subject_id,
                        'status' => $status,
                        'lang_id' => $language_id
                    );

                    //check whether the category_id with such a language_id already exists or not, if it exists then update the details
                    if($this->quiz_chapters_model->check_existence($language_id, $id))
                    {
                        $this->quiz_chapters_model->update($language_id, $id, $data_array);
                        $this->theme->set_message(lang('msg_chapter_details_update_success'), 'success');
                    }
                    else//if category does not exist then insert details
                    {
                        $data_array['chapter_id'] = $id;
                        $this->quiz_chapters_model->insert($data_array);
                        $this->theme->set_message(lang('msg_chapter_created_success'), 'success');
                    }
                    //exit;
                }

                ///if it is add mode
                else if (($id == '0' || $id == '') && $action == "add")
                {
                    $last_id = $this->quiz_chapters_model->get_max_id();
                    $chapter_id = $last_id+1;
                    //exit("last_id = ".$chapter_id);
                    $data_array = array(
                        'chapter_id' => $chapter_id,
                        'chapter_name' => $chapter_name,
                        'subject_id' => $subject_id,
                        'status' => $status,
                        'lang_id' => $language_id
                    );
                    $this->quiz_chapters_model->insert($data_array);
                    $this->theme->set_message(lang('msg_chapter_created_success'), 'success');
                }
                redirect($this->section_name.'/quiz/chapters/'.$language_code);
            }
        }

        if (!$this->input->post())
        {
            if (isset($id) && $id != '' && $id != '0' && $action == "edit")
            {
                //Check whether record exist or not?
                $details_arr = $this->quiz_chapters_model->get_details_by_ids($language_id, $id_array = array($id));
                if (empty($details_arr))
                {
                    //$this->theme->set_message(lang('msg_no_such_chapter_found'), 'error');
                    //redirect('admin/quiz/chapters/' . $language_code);
                    //break;
                }
                else
                {
                    $details_arr = $details_arr[0]['ch'];
                }
            }
        }
        else
        {
            $details_arr = $this->input->post();
        }
        $language_list = $this->languages_model->get_languages(); // get list of languages

        $subjects_list = array();
        $subjects_list = $this->quiz_subjects_model->select_all($fetch_details_arr = array('mode' => 'fetch_all_active', 'language_id' => $language_id));

        // Breadcrumb settings
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url().$this->section_name.'/quiz');
        $this->breadcrumb->add(lang('bc_quiz_chapters'), base_url().$this->section_name.'/quiz/chapters');

        if ($action == 'add' && ($id == '' || $id == '0'))
        {
            $this->theme->set('page_title', lang('add_new_chapter'));
            $this->breadcrumb->add(lang('add_new_chapter'));
        }
        else if (isset($id) && $id != '' && $id != '0' && $action == "edit")
        {
            $this->theme->set('page_title', lang('edit_chapter'));
            $this->breadcrumb->add(lang('edit_chapter'));
        }
        else
        {
            $this->theme->set_message(lang('msg_no_such_action_allowed'), 'error');
            redirect($this->section_name.'/quiz/chapters/' . $lang_code);
            break;
        }

        // Pass data to view file
        $data = array();
        $data['details'] = $details_arr;
        $data['subjects_list'] = $subjects_list;
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['languages_list'] = $language_list;
        //create breadcrumbs
        //pre($data);exit;
        //Render view
        $this->theme->view($data, 'chapter_action');
    }

    /*
     * listing of chapters page
     * @param string $language_code
     */

    public function chapters($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        $data = array();

        //Logic
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url().$this->section_name.'/quiz');
        $this->breadcrumb->add(lang('bc_quiz_chapters'), base_url().$this->section_name.'/quiz/chapters');

        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();

        $this->quiz_chapters_model->_record_count = true;
        $record_count = $this->quiz_chapters_model->get_chapters_listing($language_detail[0]['l']['id']);
        if ($record_count == 0)
        {
            $data['msg_no_chapters_records'] = $this->lang->line('msg_no_chapters_records');
        }
        else
        {
            $data['msg_no_chapters_records'] = "";
        }

        //Variable assignments to view
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        //Set page title
        $this->theme->set('page_title', lang('page_title_chapters_list'));

        //load view and pass data array to view file
        $this->theme->view($data, 'chapters');
    }
    /*
     * listing of category page by ajax
     * @param string $language_code
     */

    function ajax_chapters_list($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->quiz_chapters_model->record_per_page = $this->record_per_page;
        $this->quiz_chapters_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_term']))
            {
                $this->quiz_chapters_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->quiz_chapters_model->sort_by = $data['sort_by'];
                $this->quiz_chapters_model->sort_order = $data['sort_order'];
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $this->lang->load($this->_module, $language_detail[0]['l']['language_name']); //loads selected language file


        $listing_data = $this->quiz_chapters_model->get_chapters_listing($language_detail[0]['l']['id']);
        $this->quiz_chapters_model->_record_count = true;
        $total_records = $this->quiz_chapters_model->get_chapters_listing($language_detail[0]['l']['id']);

        $data = array(
            'listing_data' => $listing_data,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->quiz_chapters_model->search_term,
            'sort_by' => $this->quiz_chapters_model->sort_by,
            'sort_order' => $this->quiz_chapters_model->sort_order
        );
        $this->theme->view($data, 'ajax_chapters_list');
    }
    /*
     * to perform delete action of chapter
     */

    function delete_chapter()
    {
        //Initialise
        $id = $this->input->post('id');

        //Type casting
        $id = intval($id);

        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $this->quiz_chapters_model->delete($id);
            $this->quiz_chapters_model->_record_count = true;
            $total_records = $this->quiz_chapters_model->get_chapters_listing($language_detail[0]['l']['id']);

            if ($total_records > 0)
                $response = array('no_records' => 'FALSE');
            else
                $response = array('no_records' => 'TRUE');

            echo json_encode($response);
        }
    }

    function select_chapters_from_subjects()
    {
        //Initialise
        $response = array();
        $language_id = $this->input->post('language_id');
        $subject_id_string = $this->input->post('subject_id');
        $return_data_mode = $this->input->post('return_data_mode');

        //logic
        if ($subject_id_string != '' && $this->input->post('select_chapters_from_subjects') && $this->input->post('select_chapters_from_subjects') == 'select_chapters_from_subjects')
        {
            $data_arr = $this->quiz_chapters_model->select_all($fetch_details_arr = array('mode' => 'fetch_all_from_subjects', 'subject_id_string' => $subject_id_string, 'language_id' => $language_id));
            //echo 'data_arr = ';pre($data_arr);exit;
            if (!empty($data_arr))
            {
                $response['has_records'] = 'TRUE';
                $response['result_data'] = $data_arr;

                if ($return_data_mode == "json")
                {
                    echo json_encode($response);
                }
                else if ($return_data_mode == "normal")
                {
                    return $response;
                }
            }
            else
            {
                $response['has_records'] = 'FALSE';
                $response['result_data'] = "";
            }
        }
    }

    ////////-----------------  Questions  -------------------------///////////////
    /**
     * action to add/edit question page
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     */
    public function question_action($action = "add", $language_code = '', $id = 0)
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        $id = intval($id); //echo 'id = '.$id;
        $action = strip_tags($action);
        custom_filter_input('integer', $id);

        //Initialize
        $details_arr = array(
            'question' => '',
            'chapter_id' => '',
            'subject_id' => '',
            'is_correct_answer' => '',
            'status' => '',
            'lang_id' => ''
        );
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }


        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];


        if ($this->input->post())
        {
            //pre($this->input->post());exit;
            $this->form_validation->set_rules('question', lang('question'), 'required|xss_clean');
            $this->form_validation->set_rules('chapter_id', lang('chapter'), 'required|xss_clean');
            $this->form_validation->set_rules('status', lang('status'), 'required|xss_clean');
            $this->form_validation->set_rules('is_correct_answer', lang('correct_answer'), 'required|xss_clean');
            $this->form_validation->set_rules('status', lang('status'), 'required|xss_clean');
            $this->form_validation->set_rules('option[]', lang('all_options'), 'required|xss_clean');


            if ($this->form_validation->run() == true)
            {//exit('here');
                $option = array();
                $option = $this->input->post('option');

                $question = trim(strip_tags($this->input->post('question')));
                $chapter_id = trim(strip_tags($this->input->post('chapter_id')));
                $status = trim(strip_tags($this->input->post('status')));
                $is_correct_answer = trim(strip_tags($this->input->post('is_correct_answer')));


                if ($id != '' && $action == 'edit')
                {
                    $data_array = array(
                        'question' => $question,
                        'chapter_id' => $chapter_id,
                        'status' => $status,
                        'lang_id' => $language_id
                    );

                    $old_option = array();
                    $old_option = $this->input->post('old_option');

                    //check whether the question_id with such a language_id already exists or not, if it exists then update the details
                    if($this->quiz_questions_model->check_existence($language_id, $id))
                    {
                        $this->quiz_questions_model->update($language_id, $id, $data_array);
                        $this->theme->set_message(lang('msg_question_details_update_success'), 'success');

                        $question_id = $id;

                        $cnt = 0;

                        foreach ($option as $opt_key => $opt_val)
                        {
                            $opt_val = trim(strip_tags($opt_val));

                            if ($is_correct_answer == $opt_key)
                            {
                                $correct_answer = '1';
                            }
                            else
                            {
                                $correct_answer = '0';
                            }

                            $data_array = array(
                                //'question_id' => $question_id,
                                'is_correct_answer' => $correct_answer,
                                'option' => $opt_val,
                                'lang_id' => $language_id
                            );

                            $opt_id = $old_option[$cnt];
                            $this->quiz_question_options_model->update($language_id, $opt_id, $question_id, $data_array);
                            $cnt++;
                        }
                    }
                    else//if category does not exist then insert details
                    {
                        $data_array['question_id'] = $id;
                        $this->quiz_questions_model->insert($data_array);

                        $cnt = 0;
                        foreach ($option as $opt_key => $opt_val)
                        {
                            $opt_val = trim(strip_tags($opt_val));

                            if ($is_correct_answer == $opt_key)
                            {
                                $correct_answer = '1';
                            }
                            else
                            {
                                $correct_answer = '0';
                            }

                            $opt_id = $old_option[$cnt];

                            $data_array = array(
                                'option_id' => $opt_id,
                                'question_id' => $id,
                                'is_correct_answer' => $correct_answer,
                                'option' => $opt_val,
                                'lang_id' => $language_id
                            );

                            $this->quiz_question_options_model->insert($data_array);
                            $cnt++;
                        }
                        $this->theme->set_message(lang('msg_question_created_success'), 'success');
                    }
                }
                else if (($id == '0' || $id == '') && $action == "add")
                {
                    $last_id = $this->quiz_questions_model->get_max_id();
                    $question_id = $last_id + 1;

                    $data_array = array(
                        'question_id' => $question_id,
                        'question' => $question,
                        'chapter_id' => $chapter_id,
                        'status' => $status,
                        'lang_id' => $language_id
                    );

                    $this->quiz_questions_model->insert($data_array);

                    foreach ($option as $opt_key => $opt_val)
                    {
                        $opt_val = trim(strip_tags($opt_val));

                        if ($is_correct_answer == $opt_key)
                        {
                            $correct_answer = '1';
                        }
                        else
                        {
                            $correct_answer = '0';
                        }

                        $last_opt_id = $this->quiz_question_options_model->get_max_id();
                        $option_id = $last_opt_id + 1;

                        $data_array = array(
                            'option_id' => $option_id,
                            'question_id' => $question_id,
                            'is_correct_answer' => $correct_answer,
                            'option' => $opt_val,
                            'lang_id' => $language_id
                        );

                        $this->quiz_question_options_model->insert($data_array);
                    }

                    $this->theme->set_message(lang('msg_question_created_success'), 'success');
                }
                redirect($this->section_name.'/quiz/questions/' . $language_detail[0]['l']['language_code']);
            }
        }

        if (!$this->input->post())
        {
            if (isset($id) && $id != '' && $id != '0' && $action == "edit")
            {
                //Check whether record exist or not?
                $details_arr = $this->quiz_questions_model->get_details_by_ids($language_id, $id_array = array($id));

                $details_arr = $details_arr[0]['qq'];

                $que_options_arr = $this->quiz_question_options_model->select_all($fetch_details_arr = array('mode' => 'fetch_all_from_questions', 'question_id_array' => array($details_arr['question_id']), 'language_id' => $language_id));

                $options_arr = array();

                for ($i = 0; $i < count($que_options_arr); $i++)
                {
                    $options_arr[$i] = $que_options_arr[$i]['qop']['option'];
                    $old_options_arr[$i] = $que_options_arr[$i]['qop']['option_id'];

                    if ($que_options_arr[$i]['qop']['is_correct_answer'] == '1')
                    {
                        $details_arr['is_correct_answer'] = $i;
                    }
                }
                $details_arr['option'] = $options_arr;


                $que_opt_arr = $this->quiz_question_options_model->select_all($fetch_details_arr = array('mode' => 'fetch_all_distinct_from_questions', 'question_id_array' => array($id)));
                //pre($que_opt_arr);
                $old_options_arr = array();
                for ($i = 0; $i < count($que_opt_arr); $i++)
                {
                    $old_opt_id = $que_opt_arr[$i]['qop']['option_id'];
                    array_push($old_options_arr, $old_opt_id);
                }
                //pre($old_options_arr);
                $details_arr['old_option'] = $old_options_arr;

                $chapter_dtls = $this->quiz_chapters_model->get_details_by_ids($language_id, $id_array = array($details_arr['chapter_id']), $selectparam = "*");
                $details_arr['subject_id'] = $chapter_dtls[0]['ch']['subject_id'];

            }
        }
        else
        {
            $details_arr = $this->input->post();
        }
        $language_list = $this->languages_model->get_languages(); // get list of languages

        $subjects_list = array();
        $subjects_list = $this->quiz_subjects_model->select_all($fetch_details_arr = array('mode' => 'fetch_all_active', 'language_id' => $language_id));

        // Breadcrumb settings
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url().$this->section_name.'/quiz');
        $this->breadcrumb->add(lang('bc_quiz_questions'), base_url().$this->section_name.'/quiz/questions');

        if ($action == 'add' && ($id == '' || $id == '0'))
        {
            $this->theme->set('page_title', lang('add_new_question'));
            $this->breadcrumb->add(lang('add_new_question'));
        }
        else if (isset($id) && $id != '' && $id != '0' && $action == "edit")
        {
            $this->theme->set('page_title', lang('edit_question'));
            $this->breadcrumb->add(lang('edit_question'));
        }
        else
        {
            $this->theme->set_message(lang('msg_no_such_action_allowed'), 'error');
            redirect($this->section_name.'/quiz/questions/' . $lang_code);
            break;
        }

        // Pass data to view file
        $data = array();
        $data['details'] = $details_arr;
        $data['subjects_list'] = $subjects_list;
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['languages_list'] = $language_list;
        //create breadcrumbs
        //pre($data);exit;
        //Render view
        $this->theme->view($data, 'question_action');
    }

    /*
     * listing of questions page
     * @param string $language_code
     */

    public function questions($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        $data = array();

        //Logic
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url().$this->section_name.'/quiz');
        $this->breadcrumb->add(lang('bc_quiz_questions'), base_url().$this->section_name.'/quiz/questions');

        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();

        $this->quiz_questions_model->_record_count = true;
        $record_count = $this->quiz_questions_model->get_questions_listing($language_detail[0]['l']['id']);
        if ($record_count == 0)
        {
            $data['msg_no_questions_records'] = $this->lang->line('msg_no_questions_records');
        }
        else
        {
            $data['msg_no_questions_records'] = "";
        }
        //Variable assignments to view
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        //Set page title
        $this->theme->set('page_title', lang('page_title_questions_list'));

        //load view and pass data array to view file
        $this->theme->view($data, 'questions');
    }
    /*
     * listing of question page by ajax
     * @param string $language_code
     */

    function ajax_questions_list($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->quiz_questions_model->record_per_page = $this->record_per_page;
        $this->quiz_questions_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_term']))
            {
                $this->quiz_questions_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->quiz_questions_model->sort_by = $data['sort_by'];
                $this->quiz_questions_model->sort_order = $data['sort_order'];
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $this->lang->load($this->_module, $language_detail[0]['l']['language_name']); //loads selected language file


        $listing_data = $this->quiz_questions_model->get_questions_listing($language_detail[0]['l']['id']);
        $this->quiz_questions_model->_record_count = true;
        $total_records = $this->quiz_questions_model->get_questions_listing($language_detail[0]['l']['id']);

        $data = array(
            'listing_data' => $listing_data,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->quiz_questions_model->search_term,
            'sort_by' => $this->quiz_questions_model->sort_by,
            'sort_order' => $this->quiz_questions_model->sort_order
        );
        $this->theme->view($data, 'ajax_questions_list');
    }
    /*
     * to perform delete action of question
     */

    function delete_question()
    {
        //Initialise
        $id = $this->input->post('id');

        //Type casting
        $id = intval($id);

        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $this->quiz_questions_model->delete($id);
            $this->quiz_questions_model->_record_count = true;
            $total_records = $this->quiz_questions_model->get_questions_listing($language_detail[0]['l']['id']);

            if ($total_records > 0) $response = array('no_records' => 'FALSE');
            else $response = array('no_records' => 'TRUE');

            echo json_encode($response);
        }
    }

    ////////-----------------  Quizzes  -------------------------///////////////
    public function quizzes_action($action = "add", $language_code = '', $id = 0)
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        $id = intval($id);
        $action = strip_tags($action);
        custom_filter_input('integer', $id);

        //Initialize
        $details_arr = array(
            'quiz_title' => '',
            'description' => '',
            'status' => '',
            'lang_id' => ''
        );
        $categories = "";
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }


        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();


        if ($this->input->post())
        {
            $this->form_validation->set_rules('quiz_title', lang('quiz_title'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('description', lang('quiz_description'), 'required|xss_clean');
            $this->form_validation->set_rules('status', lang('status'), 'required|xss_clean');

            if ($this->form_validation->run() == true)
            {
                $subject_name = trim(strip_tags($this->input->post('quiz_title')));
                $category_id = trim(strip_tags($this->input->post('description')));
                $status = trim(strip_tags($this->input->post('status')));
                $questions = $this->input->post('questions_array');

                if ($id != '' && $action == 'edit')
                {
                    $data_array = array(
                        'quiz_title' => $subject_name,
                        'description' => $category_id,
                        'status' => $status,
                        'lang_id' => $language_id
                    );

                    //check whether the category_id with such a language_id already exists or not, if it exists then update the details
                    if($this->quizzes_model->check_existence($language_id, $id))
                    {
                        $this->quizzes_model->update($language_id, $id, $data_array);

                        //delete old data of question regarding this $quiz_id
                        $this->quizzes_model->delete_quizzes_questions($id);
                        foreach ($questions as $key => $question_id)
                        {
                            $this->quizzes_questions_model->insert(array('quiz_id' => $id, 'question_id' => $question_id));
                        }

                        $this->theme->set_message(lang('msg_quiz_details_update_success'), 'success');
                    }
                    else//if category does not exist then insert details
                    {
                        $data_array['quiz_id'] = $id;
                        $this->quizzes_model->insert($data_array);

                        foreach ($questions as $key => $question_id)
                        {
                            $this->quizzes_questions_model->insert(array('quiz_id' => $id, 'question_id' => $question_id));
                        }
                        $this->theme->set_message(lang('msg_quiz_created_success'), 'success');
                    }
                }
                else if (($id == '0' || $id == '') && $action == "add")
                {
                    $last_id = $this->quizzes_model->get_max_id();
                    $quiz_id = $last_id + 1;

                    $data_array = array(
                        'quiz_id' => $quiz_id,
                        'quiz_title' => $subject_name,
                        'description' => $category_id,
                        'status' => $status,
                        'lang_id' => $language_id
                    );

                    $this->quizzes_model->insert($data_array);

                    /*foreach ($questions as $key => $question_id)
                    {
                        $this->quizzes_questions_model->insert(array('quiz_id' => $quiz_id, 'question_id' => $question_id));
                    }*/
                    $this->theme->set_message(lang('msg_quiz_created_success'), 'success');
                }
                redirect($this->section_name.'/quiz/quizzes/'.$language_code);
            }
        }
        if (!$this->input->post())
        {
            if (isset($id) && $id != '' && $id != '0' && $action == "edit")
            {
                //Check whether record exist or not?
                $details_arr = $this->quizzes_model->get_details_by_ids($language_id, $id_array = array($id));
                $categories = $this->quizzes_model->get_category_by_quizzes($language_id, $id);
                //pre($categories);
                if (empty($details_arr))
                {
                    //$this->theme->set_message(lang('msg_no_such_category_found'), 'error');
                    //redirect('admin/quiz/categories/' . $lang_code);
                    //break;
                }
                else
                {
                    $details_arr = $details_arr[0]['q'];
                    $details_arr['categories'] = $categories;
                }
            }
        }
        else
        {
            $details_arr = $this->input->post();
        }

        $categories_list = array();
        $categories_list = $this->quiz_categories_model->select_all($fetch_details_arr = array('mode' => 'fetch_all_active', 'language_id' => $language_id));
        //pre($categories_list);
        // Breadcrumb settings
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url().$this->section_name.'/quiz');
        $this->breadcrumb->add(lang('bc_quizzes'), base_url().$this->section_name.'/quiz/quizzes');

        if ($action == 'add' && ($id == '' || $id == '0'))
        {
            $this->theme->set('page_title', lang('add_new_quiz'));
            $this->breadcrumb->add(lang('add_new_quiz'));
        }
        else if (isset($id) && $id != '' && $id != '0' && $action == "edit")
        {
            $this->theme->set('page_title', lang('edit_subject'));
            $this->breadcrumb->add(lang('edit_quiz'));
        }
        else
        {
            $this->theme->set_message(lang('msg_no_such_action_allowed'), 'error');
            redirect($this->section_name.'/quiz/subjects/' . $lang_code);
            break;
        }

        // Pass data to view file
        $data = array();
        $data['details'] = $details_arr;
        $data['categories_list'] = $categories_list;
        $data['categories'] = $categories;
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['languages_list'] = $language_list;

        //Render view
        $this->theme->view($data, 'quizzes_action');
    }


    /*
     * listing of quizzes page
     * @param string $language_code
     */

    public function quizzes($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        $data = array();

        //Logic
        $this->breadcrumb->add(lang('bc_quiz_management'), base_url().$this->section_name.'/quiz');
        $this->breadcrumb->add(lang('bc_quizzes'), base_url().$this->section_name.'/quiz/quizzes');

        $language_detail = $this->languages_model->get_languages_by_code($language_code);

        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        $this->quizzes_model->_record_count = true;
        $record_count = $this->quizzes_model->get_quizzes_listing($language_detail[0]['l']['id']);
        if ($record_count == 0)
        {
            $data['msg_no_category_records'] = $this->lang->line('msg_no_category_records');
        }
        else
        {
            $data['msg_no_category_records'] = "";
        }


        //Variable assignments to view
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        //Set page title
        $this->theme->set('page_title', lang('page_title_quizzes_list'));

        //load view and pass data array to view file
        $this->theme->view($data, 'quizzes');
    }
    /*
     * listing of category page by ajax
     * @param string $language_code
     */

    function ajax_quizzes_list($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->quizzes_model->record_per_page = $this->record_per_page;
        $this->quizzes_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_term']))
            {
                $this->quizzes_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->quizzes_model->sort_by = $data['sort_by'];
                $this->quizzes_model->sort_order = $data['sort_order'];
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $this->lang->load($this->_module, $language_detail[0]['l']['language_name']); //loads selected language file


        $listing_data = $this->quizzes_model->get_quizzes_listing($language_detail[0]['l']['id']);
        $this->quizzes_model->_record_count = true;
        $total_records = $this->quizzes_model->get_quizzes_listing($language_detail[0]['l']['id']);

        $data = array(
            'listing_data' => $listing_data,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->quizzes_model->search_term,
            'sort_by' => $this->quizzes_model->sort_by,
            'sort_order' => $this->quizzes_model->sort_order
        );
        $this->theme->view($data, 'ajax_quizzes_list');
    }
    /*
     * to perform delete action of quizzes
     */

    function delete_quizzes()
    {
        //Initialise
        $id = $this->input->post('id');

        //Type casting
        $id = intval($id);

        //logic
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $res = $this->quizzes_model->delete($id);
            if ($res)
            {
                echo $this->theme->message(lang('quizzes_delete_success'), 'success');
            }
            else
            {
                echo $this->theme->message(lang('quizzes_delete_error'), 'error');
            }
        }
    }
    /*
     * get questions by category
     */

    public function select_questions_from_categories($language_id, $category_id, $return_data_mode)
    {
        $category_id = rawurldecode($category_id);
        $data['questions'] = $this->quizzes_model->get_questions_by_categories($language_id, $category_id);
        $this->theme->view($data, 'ajax_quizzes_questions');
    }
    /*
     * get quiz question by quiz id
     * @param int $quiz_id
     */

    public function select_quizzes_questions_from_categories($language_id, $quiz_id)
    {
        $data['questions'] = $this->quizzes_model->get_questions_by_quiz($language_id, $quiz_id);
        $this->theme->view($data, 'ajax_quizzes_questions');
    }
}

?>