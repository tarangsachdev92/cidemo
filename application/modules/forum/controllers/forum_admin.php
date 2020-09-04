<?php

/**
 *  FORUM Admin Controller
 *
 *  To perform FORUM management.
 *
 * @package CIDemoApplication
 * @subpackage Forum
 * @author AVSH
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forum_admin extends Base_Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        // Login check for admin
        $this->access_control($this->access_rules());

        // Load required helpers
        $this->load->helper('download');
        $this->load->library('form_validation');
        $this->load->library('session');

        // load required models
        $this->load->model('forum_category_model');
        $this->load->model('forum_post_model');
        $this->load->model('forum_topics_model');
        $this->load->model('forum_activity_log_model');
        $this->load->model('urls/urls_model');

        // Breadcrumb settings
        $this->breadcrumb->add(lang('forum'), base_url() . $this->section_name . '/forum');
    }

    /**
     * Function access_rules to check login
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('index', 'ajax_forum_listing', 'delete_forum', 'delete_topic', 'forum_listing', 'action', 'forum_post', 'topic_edit', 'ajax_index', 'check_unique_slug', 'view_data'),
                'users' => array('@'),
            )
        );
    }

    /**
     * Function index for fetching Forum Categories,we can choose category and see their forums
     */
    public function index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        $data = array();
        $categories = array();

        //Load data for url listing
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->forum_category_model->record_per_page = $this->record_per_page;
        $this->forum_category_model->offset = $offset;

        // language code
        $language_list = $this->languages_model->get_languages();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        // Pass data to view file

        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['languages'] = $language_list;

        //Create page-title
        $this->theme->set('page_title', lang('forum_category'));
        //Render view
        $this->theme->view($data);
    }

    /**
     * Function ajax_index for fetching index page view.
     */
    function ajax_index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);

        //Initialize
        $data = array();
        $categories = array();

        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->forum_category_model->record_per_page = $this->record_per_page;
        $this->forum_category_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_term']))
            {
                $this->forum_category_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->forum_category_model->sort_by = $data['sort_by'];
                $this->forum_category_model->sort_order = $data['sort_order'];
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $categories = $this->forum_category_model->get_category_listing($language_id);
        foreach ($categories as $k => $v)
        {
            $categories[$k]['categories']['total_forum' . $categories[$k]['categories']['category_id']] = $this->forum_post_model->total_forum_by_category($categories[$k]['categories']['category_id'], $language_id);
        }

        //Variable assignments to view
        $data['categories'] = $categories;
        $data['page_number'] = $this->page_number;
        $this->forum_category_model->_record_count = true;
        $total_records = $this->forum_category_model->get_category_listing($language_id);
        $data['total_records'] = $total_records; // $this->forum_category_model->record_count($language_id);
        $data['search_term'] = $this->forum_category_model->search_term;
        $data['sort_by'] = $this->forum_category_model->sort_by;
        $data['sort_order'] = $this->forum_category_model->sort_order;
        $data['language_code'] = $language_detail[0]['l']['language_code'];

        //Render view
        $this->theme->view($data, 'admin_ajax_index');
    }

    /**
     * Function action for add & edit Forum.
     */
    function action($action = "add", $id = 0, $language_code = '')
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = trim(strip_tags($language_code));
        $id = trim(strip_tags($id));

        //Initialize
        $data = array();
        $categories = array();

        //language parameters
        $language_list = $this->languages_model->get_languages();
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //pr($language_code);
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        //pr($language_detail);
        $language_id = $language_detail[0]['l']['id'];

        // Logic
        $categories = $this->forum_category_model->get_category_listing($language_id);
        if ($action == "edit")
        {
            $this->forum_post_model->id = $id;
            $forum_data = $this->forum_post_model->get_forum_listing("", $language_id);
            $data['id'] = $id;
        }
        if ($this->input->post('mysubmit'))
        {
            $data = $this->input->post();

            //Type Casting
            $id = intval($data['id']);

            //Variable Assignment
            $forum_title = trim(strip_tags($data['forum_title']));
            $forum_description = html_entity_decode(trim($data['forum_description']));
            $forum_category = trim(strip_tags($data['forum_category']));
            $is_private = trim(strip_tags($data['is_private']));
            $slug_url = trim(strip_tags($data['slug_url']));

            // field name, error message, validation rules

            $this->form_validation->set_rules('forum_title', lang('forum_title'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('forum_description', lang('forum_description'), 'trim|xss_clean');
            $this->form_validation->set_rules('slug_url', 'Slug URL', 'trim|required|callback_check_unique_slug|xss_clean');

            if ($this->form_validation->run($this) == TRUE)
            {
                $data_array['forum_post_title'] = $forum_title;
                $data_array['slug_url'] = $slug_url;
                $data_array['forum_post_text'] = $forum_description;
                $data_array['category_id'] = $forum_category;
                $data_array['is_private'] = $is_private;
                $data_array['lang_id'] = $language_id;
                if ($action == "add")
                {
                    $data_array['status'] = 1;
                }
                else
                {
                    $data_array['status'] = $data['status'];
                    $data_array['modified_by'] = $this->session->userdata[$this->theme->get('section_name')]['user_id'];
                }
                $data_array['created_by'] = $this->session->userdata[$this->theme->get('section_name')]['user_id'];
                $data_array['id'] = $id;
                $this->forum_post_model->forum_adder($data_array);

                if ($id == 0)
                {
                    $this->theme->set_message(lang('forum-add-success'), 'success');
                }
                else
                {
                    $this->theme->set_message(lang('forum-edit-success'), 'success');
                }
                redirect($this->section_name.'/forum/forum_listing/' . $forum_category . "/" . $language_code);
                exit;
            }
            else
            {
                $this->theme->set_message(lang('slug_exist'), 'danger');
            }
        }
        else
        {
            //Variable Assignment
            $forum_title = "";
            $forum_description = "";
            $forum_category = "";
        }

        //  Pass data to view file
        if ($action == "edit")
        {
            //Variable assignments to view
            $data['forum_name'] = $forum_data[0]['forum_post']['forum_post_title'];
            $data['status'] = $forum_data[0]['forum_post']['status'];
            $data['forum_description'] = $forum_data[0]['forum_post']['forum_post_text'];
            $data['is_private'] = $forum_data[0]['forum_post']['is_private'];
            $data['forum_category'] = $forum_data[0]['forum_post']['category_id'];
            $data['slug_url'] = $forum_data[0]['forum_post']['slug_url'];
        }

        //Variable assignments to view
        $data['categories'] = $categories;
        $data['action'] = $action;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['languages'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['languages'] = $language_list;

        //create breadcrumbs & page-title
        if ($id == 0)
        {
            $status = 1;
            $this->theme->set('page_title', lang('add-forum'));
            $this->breadcrumb->add(lang('add-forum'));
        }
        else
        {
            $status = $data['status'];
            $this->theme->set('page_title', lang('edit-forum'));
            $this->breadcrumb->add(lang('edit-forum'));
        }

        //Render view
        $this->theme->view($data, 'admin_action');
    }

    /**
     * Function delete_forum for delete Forum.
     */
    function delete_forum($language_code)
    {
        //Type Casting
        $language_code = trim(strip_tags($language_code));

        //Initialize
        $data = array();

        // language code
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $data = $this->input->post();

        //Type Casting
        $id = intval($data['id']);

        //Logic
        $this->forum_post_model->id = $id;
        $result = $this->forum_post_model->get_forum_listing($data['category'], $language_id);

        if (!empty($result))
        {
            $res = $this->forum_post_model->delete_forum($id);
            $this->forum_topics_model->post_id = $id;
            $res1 = $this->forum_topics_model->delete_topic();
            if ($res)
            {
                echo $this->theme->message(lang('forum-delete-success'), 'success');
            }
        }
        else
        {
            echo $this->theme->message(lang('invalid-id-msg'), 'danger');
        }
    }

    /**
     * Function delete_topic for delete topic.
     */
    function delete_topic()
    {
        //Initialize
        $data = array();

        //Logic
        $data = $this->input->post();

        //Type Casting
        $id = intval($data['id']);
        $this->forum_topics_model->id = $id;
        $res = $this->forum_topics_model->delete_topic();
        if ($res)
        {
            echo $this->theme->message(lang('forum-topic-delete-success'), 'success');
        }
        else
        {
            echo $this->theme->message(lang('invalid-id-msg'), 'danger');
        }
    }

    /**
     * Function forum_listing for display Forum of selected category.
     */
    public function forum_listing($category, $language_code = '')
    {
        //Type Casting
        $category = trim(strip_tags($category));
        $language_code = trim(strip_tags($language_code));

        // language code
        $language_list = $this->languages_model->get_languages();
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        //Variable assignments to view
        $data['category_id'] = $category;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['languages'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['languages'] = $language_list;

        //Create page-title
        $this->theme->set('page_title', lang('forum'));

        //Render view
        $this->breadcrumb->add(lang('forum-listing'));
        $this->theme->view($data, 'admin_forum_listing');
    }

    /**
     * Function ajax_forum_listing for fetching forum_listing page view.
     */
    public function ajax_forum_listing($category, $language_code = '')
    {
        //Type Casting
        $category = trim(strip_tags($category));
        $language_code = trim(strip_tags($language_code));

        //Load data for url listing
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->forum_post_model->record_per_page = $this->record_per_page;
        $this->forum_post_model->offset = $offset;

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_term']))
            {
                $this->forum_post_model->search_term = $data['search_term'];
            }

            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->forum_post_model->sort_by = $data['sort_by'];
                $this->forum_post_model->sort_order = $data['sort_order'];
            }

            if (isset($data['type']) && $data['type'] == 'delete')
            {
                if ($this->forum_post_model->delete_records($data['ids']))
                {
                    echo $this->theme->message(lang('forum-delete-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                if ($this->forum_post_model->active_records($data['ids']))
                {
                    echo $this->theme->message(lang('forum-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                if ($this->forum_post_model->inactive_records($data['ids']))
                {
                    echo $this->theme->message(lang('forum-inactive-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                if ($this->forum_post_model->active_all_records())
                {
                    echo $this->theme->message(lang('forum-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                if ($this->forum_post_model->inactive_all_records())
                {
                    echo $this->theme->message(lang('forum-inactive-success'), 'success');
                    exit;
                }
            }
        }

        //logic
        $forums = $this->forum_post_model->get_forum_listing($category, $language_id);
        $category_name = $this->forum_category_model->get_category_from_id($category, $language_id);

        //Variable assignments to view
        if (!empty($category_name))
        {
            $data['category'] = $category_name;
        }

        $data['forums'] = $forums;
        $data['category_id'] = $category;
        $data['page_number'] = $this->page_number;
        $this->forum_post_model->category_id = $category;
        $this->forum_post_model->_record_count = true;
        $total_records = $this->forum_post_model->get_forum_listing($category, $language_id);
        $data['total_records'] = $total_records;
        $data['search_term'] = $this->forum_post_model->search_term;
        $data['sort_by'] = $this->forum_post_model->sort_by;
        $data['sort_order'] = $this->forum_post_model->sort_order;
        $data['language_id'] = $language_id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        foreach ($forums as $k => $v)
        {
            $this->forum_topics_model->id = $v['forum_post']['id'];
            $data["forums"][$k]["forum_post"]['rly_count'] = $this->forum_topics_model->record_count($language_id);
        }
        //Render view
        $this->theme->view($data, 'admin_ajax_forum_listing');
    }

    /**
     * Function forum_post for display Forum Posts.
     */
    public function forum_post($language_code = '', $id)
    {
        //Type Casting
        $language_code = trim(strip_tags($language_code));
        $id = trim(strip_tags($id));
        //Initialize
        $data = array();
        $data_array = array();

        //Load data for url listing
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->forum_topics_model->record_per_page = $this->record_per_page;
        $this->forum_topics_model->offset = $offset;

        // language code
        $language_list = $this->languages_model->get_languages();
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        // Logic
        $uri = mysql_real_escape_string($_SERVER['REQUEST_URI']);
        $view_count = $this->forum_activity_log_model->get_view_count($uri);
        if ($this->input->post('mysubmit'))
        {
            $data = $this->input->post();

            //Variable Assignment
            $topic_title = trim(strip_tags($data['topic_title']));
            $topic_text = html_entity_decode(trim($data['topic_text']));
            $this->form_validation->set_rules('topic_title', lang('topic_title'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('topic_text', lang('topic_text'), 'trim|required|xss_clean');
            if ($this->form_validation->run())
            {
                $data_array['post_id'] = $id;
                $data_array['id'] = 0;
                $data_id['id'] = $id;
                $data_array['topic_title'] = $topic_title;
                $data_array['topic_text'] = $topic_text;
                $data_array['lang_id'] = $language_id;
                $data_array['created_by'] = $this->session->userdata[$this->theme->get('section_name')]['user_id'];

                //Type Casting
                $forum_title = trim(strip_tags($data['topic_title']));

                // field name, error message, validation rules
                $this->form_validation->set_rules('topic_title', lang('topic_title'), 'trim|required|xss_clean');
                if ($_FILES)
                {
                    $config['upload_path'] = FCPATH . 'assets/uploads/forum_files';
                    $config['allowed_types'] = '*';
                    //$config['max_size'] = '10000';
                    $config['max_width'] = '1024';
                    $config['max_height'] = '768';
                    $config['name'] = $_FILES['attachment']['name'];
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $field_name = "attachment";
                    if ($_FILES['attachment']['name'] && !$this->upload->do_upload('attachment'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        echo $this->upload->display_errors();
                    }
                    else
                    {
                        $uploaded_data = array('upload_data' => $this->upload->data());
                        $data_array['attachment'] = $config['name'];
                    }
                    if (isset($data_array['topic_title']) && $data_array['topic_title'] != '')
                    {
                        $this->forum_post_model->updated_date($data_id, $language_id);
                        $this->forum_topics_model->add_reply($data_array);
                        $this->theme->set_message('Reply successfully added', 'success');
                    }
                    else
                    {
                        $this->theme->set_message('Please fill all required fields', 'danger');
                    }
                }
                redirect(current_url());
            }
            else
            {
                $this->theme->set_message('Please fill all required fields', 'danger');
                redirect(current_url());
            }
        }
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['type']) && $data['type'] == 'delete')
            {
                if ($this->forum_topics_model->delete_records($data['ids']))
                {
                    echo $this->theme->message(lang('forum-delete-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                if ($this->forum_topics_model->active_records($data['ids']))
                {
                    echo $this->theme->message(lang('forum-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                if ($this->forum_topics_model->inactive_records($data['ids']))
                {
                    echo $this->theme->message(lang('forum-inactive-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                if ($this->forum_topics_model->active_all_records())
                {
                    echo $this->theme->message(lang('forum-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                if ($this->forum_topics_model->inactive_all_records())
                {
                    echo $this->theme->message(lang('forum-inactive-success'), 'success');
                    exit;
                }
            }
        }
        $forum_first_post = $this->forum_post_model->forum_post_by_id($id, $language_id);
        $forum_post_comments = $this->forum_topics_model->get_topics_from_post($id, $language_id);
        $last_post = $this->forum_topics_model->last_update_datetime($id);

        //Variable assignments to view
        $data['forum_first_post'] = $forum_first_post;
        $data['forum_post_comments'] = $forum_post_comments;
        $data['id'] = $id;
        $data['last_post'] = $last_post;
        $data['view_count'] = $view_count;
        $data['page_number'] = $this->page_number;
        $this->forum_topics_model->id = $id;
        $this->forum_topics_model->_record_count = true;
        $total_records = $this->forum_topics_model->get_topics_from_post($id, $language_id);
        $data['total_records'] = $total_records;
        $data['search_term'] = $this->forum_topics_model->search_term;
        $data['sort_by'] = $this->forum_topics_model->sort_by;
        $data['sort_order'] = $this->forum_topics_model->sort_order;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['languages'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['languages'] = $language_list;

        //create breadcrumbs & page-title
        $this->theme->set('page_title', lang('forum-topics'));
        $this->breadcrumb->add(lang('forum-topics'));

        //Render view
        $this->theme->view($data, 'admin_forum_post');
    }

    /**
     * Function topic_edit for edit Forum topic.
     */
    public function topic_edit($id, $post_id, $language_code = '')
    {
        //Type Casting
        $post_id = trim(strip_tags($post_id));
        $id = trim(strip_tags($id));
        $language_code = trim(strip_tags($language_code));

        //Initialize
        $data = array();
        $data_array = array();

        // language code
        $language_list = $this->languages_model->get_languages();
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        // Logic
        $result = $this->forum_topics_model->get_record_by_id($id, $language_id);
        if ($this->input->post())
        {
            $data = $this->input->post();
            $topic_title = trim(strip_tags($data['topic_title']));
            $topic_text = html_entity_decode(trim($data['topic_text']));
            $data_array['id'] = $id;
            $data_id['id'] = $id;
            $data_array['topic_title'] = $topic_title;
            $data_array['topic_text'] = $topic_text;
            $data_array['status'] = $data['status'];

            //Variable Assignment
            $forum_title = trim(strip_tags($data['topic_title']));

            // field name, error message, validation rules
            $this->form_validation->set_rules('topic_title', lang('topic_title'), 'trim|required|xss_clean');

            if ($_FILES)
            {
                //pre($data['file_exist']);
                $config['upload_path'] = 'assets/uploads/forum_files';
                $config['allowed_types'] = 'doc|docx|pdf';
                //$config['max_size'] = '10000';
                $config['max_width'] = '1024';
                $config['max_height'] = '768';
                $config['name'] = $_FILES['attachment']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $field_name = "attachment";
                $uploaded_data = array('upload_data' => $this->upload->data());

                if (isset($data['file_exist']) && $data['file_exist'] != "" && $config['name'] == "")
                {
                    $data_array['attachment'] = $data['file_exist'];
                }
                else
                {
                    $data_array['attachment'] = $config['name'];
                }
                if (isset($data_array['topic_title']) && $data_array['topic_title'] != '')
                {
                    $this->forum_post_model->updated_date($data_id);
                    $this->forum_topics_model->add_reply($data_array);
                    $this->theme->set_message('Topic successfully Edited', 'success');
                    redirect($this->section_name.'/forum/forum_post/' . $language_code . '/' . $post_id);
                    exit;
                }
                else
                {
                    $this->theme->set_message('Please fill all fields', 'danger');
                }
            }
        }

        //Variable assignments to view
        $data['topic_title'] = $result['forum_topics']['topic_title'];
        $data['topic_text'] = $result['forum_topics']['topic_text'];
        $data['status'] = $result['forum_topics']['status'];
        $data['attach'] = $result['forum_topics']['attachment'];
        $data['post_id'] = $post_id;
        $data['language_id'] = $language_id;
        $data['language_code'] = $language_code;
        $this->theme->set('page_title', 'Edit Forum Topics');

        //create breadcrumbs & page-title
        $this->breadcrumb->add(lang('edit-forum-topics'));

        //Render view
        $this->theme->view($data, 'admin_topic_edit');
    }

    /**
     * Function check_unique_slug for check is slug unique?
     */
    public function check_unique_slug()
    {
        $slug_url = $this->input->post('slug_url');
        
        $id = $this->input->post('id');
        $id = intval($id);

        //Type Casting
        $slug_url = trim(strip_tags($slug_url));

        //Logic
        $result = $this->forum_post_model->check_unique_slug($slug_url, $id);

        if (count($result) > 0)
        {
            $this->form_validation->set_message('check_unique_slug', lang('msg_available_slug_url'));
            //$this->form_validation->set_message('slug_url', lang('msg_available_slug_url'));
            return false;
        }
        else
        {
            return true;
        }
    }

    public function view_data($id = 0, $lang)
    {
        $result = $this->forum_post_model->forum_post_by_id($id, "");

        //Initialize
        $data = array();

        //Variable assignments to view
        $data = $result;
        $data['lang'] = $lang;
        $data['id'] = $id;

        //Render view
        $this->theme->view($data);
    }

}

?>
