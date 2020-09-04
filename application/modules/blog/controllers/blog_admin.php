<?php

/**
 *  Blog Admin Controller
 *
 *  To perform blog management.
 * 
 * @package CIDemoApplication
 * @subpackage Blog
 * @copyright	(c) 2013, TatvaSoft
 * @author SGNSH
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog_admin extends Base_Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        // Login check for admin
        $this->access_control($this->access_rules());
        $this->load->model('blog_model', null, true);
        $this->load->model('categories/categories_model', null, true);
        $this->load->model('urls/urls_model');
        $this->lang->load('blog');
        // Breadcrumb settings
        $this->breadcrumb->add(lang('blog-management'), base_url() . get_current_section($this) . '/blog');
    }

    /**
     * Function access_rules to check login
     */
    public function access_rules()
    {
        return array(
            array(
                'actions' => array('index', 'ajax_index', 'action', 'ajax_action', 'save', 'delete', 'blog_validation_rules', 'comment', 'edit_comment', 'comment_action', 'comment_delete', 'view', 'ajax_view'),
                'users' => array('@'),
            ),
        );
    }

    /**
     * Function index to view listing of blogs
     */
    function index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[get_current_section($this)]['site_lang_code'];
        }
        //Logic             
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        //Create page-title       
        $this->theme->set('page_title', lang('blog-management'));
        // Breadcrumb settings
        // No breadcrumb as it's index page
        // Pass data to view file
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_id'] = $language_id;
        $data['languages_list'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->theme->view($data);
    }

    /**
     * action to load list of blogs based on language passed or from default language
     * @param string $language_code
     */
    function ajax_index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[get_current_section($this)]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->blog_model->record_per_page = $this->record_per_page;
        $this->blog_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_term']))
            {
                $this->blog_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->blog_model->sort_by = $data['sort_by'];
                $this->blog_model->sort_order = $data['sort_order'];
            }
            if (isset($data['type']) && $data['type'] == 'delete')
            {
                if ($this->blog_model->delete_records($data['ids']))
                {
                    echo $this->theme->message(lang('blog-delete-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                if ($this->blog_model->active_records($data['ids']))
                {
                    echo $this->theme->message(lang('blog-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                if ($this->blog_model->inactive_records($data['ids']))
                {
                    echo $this->theme->message(lang('blog-inactive-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                if ($this->blog_model->active_all_records())
                {
                    echo $this->theme->message(lang('blog-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                if ($this->blog_model->inactive_all_records())
                {
                    echo $this->theme->message(lang('blog-inactive-success'), 'success');
                    exit;
                }
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $blog_list = $this->blog_model->get_blogpost_listing($language_detail[0]['l']['id']);
        $this->blog_model->_record_count = true;
        $total_records = $this->blog_model->get_blogpost_listing($language_detail[0]['l']['id']);
        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view        
        $data = array(
            'blogpost' => $blog_list,
            'language_code' => $language_code,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->blog_model->search_term,
            'sort_by' => $this->blog_model->sort_by,
            'sort_order' => $this->blog_model->sort_order
        );
        $this->theme->view($data, 'admin_ajax_index');
    }

    /**
     * Function action to perform insert & update by action parameter
     * @param string $action default = 'add'  
     * @param integer $id default = 0
     */
    function action($action = "add", $language_code = '', $id = 0)
    {
        //Type Casting 
        $id = intval($id);
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        //Variable Assignment   
        //Logic
        if ($this->input->post('mysubmit'))
        {
            $data = $this->input->post();
            //Variable Assignment   
            $title = trim(strip_tags($data['blogtitle']));
            $slug_url = trim(strip_tags($data['slug_url']));
            $category_id = intval($data['category_id']);
            $view_permission = trim(strip_tags($data['view_permission']));
            $blog_text = html_entity_decode(trim(strip_tags($data['blog_text'])));
            $status = trim(strip_tags($data['status']));
        }


        if ($action == 'add' || $action == 'edit')
        {
            //Initialize
            $blog_list = array();
            $blog_list_result = array();
            if ($language_code == '')
            {
                $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
            }

            // Logic
            $language_detail = $this->languages_model->get_languages_by_code($language_code);
            $language_id = $language_detail[0]['l']['id'];
            if ($this->input->post('mysubmit'))
            {
                //load library
                $this->load->library('form_validation');
                $data = $this->input->post();
                // field name, error message, validation rules
                $this->form_validation->set_rules('blogtitle', "Blog Title", 'trim|required|min_length[2]|xss_clean');
                $this->form_validation->set_rules('slug_url', 'slug_url', 'required|callback_check_unique_slug_url|xss_clean');
                if ($this->form_validation->run($this))
                {
                    $blog_data = $this->blog_model->get_related_lang_blog($id, $language_id);


                    //file uploading code........
                    if (isset($_FILES['blog_image']) && $_FILES['blog_image']['name'] != "")
                    {
                        $config['upload_path'] = "assets/uploads/blog_images/";
                        $config['allowed_types'] = 'gif|jpg|png';
                        //$config['max_size']	= '100';
                        //$config['max_width']  = '1024';
                        //$config['max_height']  = '768';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('blog_image'))
                        {
                            $error = array('error' => $this->upload->display_errors());
                            echo $this->upload->display_errors();
                        }
                        else
                        {
                            $uploaded_file_details = $this->upload->data();
                            $this->blog_model->blog_image = $config['upload_path'] . $uploaded_file_details['file_name'];
                        }
                    }
                    $this->blog_model->title = $title;
                    $this->blog_model->category_id = $category_id;
                    $this->blog_model->slug_url = $slug_url;
                    $this->blog_model->view_permission = $view_permission;
                    $this->blog_model->blog_text = $blog_text;
                    $this->blog_model->status = $status;
                    if (count($blog_data) > 0)
                    {
                      // $this->cms_model->update_blog($id, $language_id);
                        $this->blog_model->update_blog($id, $language_id);
                        $this->theme->set_message(lang('blog-edit-success'), 'success');
                    }
                    else
                    {
                        if ($id == '0' || $id == '')
                        {
                            $last_blogpost_id = $this->blog_model->get_last_blogpost_id();
                            $id = $last_blogpost_id + 1;
                        }
                        $this->blog_model->insert_blog($id, $language_id);
                        $this->theme->set_message(lang('blog-add-success'), 'success');
                    }
                    $this->config_model->change_slug_url_management($this->input->post('old_slug_url'), $this->input->post('slug_url'), 'blog', $id, 'index/' . $this->input->post('slug_url'), $this->input->post('status'), $language_id);
                    $this->load->module('urls/urls_admin');
                    $this->urls_admin->generate_custom_url();

                    redirect($this->section_name . '/blog/index/' . $language_detail[0]['l']['language_code']);
                }
            }
            if (!$this->input->post())
            {
                if (isset($id) && $id != '' && $id != '0')
                {
                    $blog_list_result = $this->blog_model->get_blog_detail('', $id, $language_id);
                    if (!empty($blog_list_result))
                    {
                        if (!empty($blog_list_result[0]['b']))
                            $blog_list = $blog_list_result[0]['b'];
                    }
                }
            }
            else
            {
                $blog_list = $this->input->post();
            }
            $language_list = $this->languages_model->get_languages(); // get list of languages
            //create breadcrumbs & page-title
            if ($action == 'add')
            {
                $this->theme->set('page_title', lang('add-blog'));
                $this->breadcrumb->add(lang('add-blog'));
            }
            else
            {
                $this->theme->set('page_title', lang('edit-blog'));
                $this->breadcrumb->add(lang('edit-blog'));
            }
            $data = array();
            $data['action'] = $action;
            $data['id'] = $id;
            $data['language_code'] = $language_detail[0]['l']['language_code'];
            $data['language_name'] = $language_detail[0]['l']['language_name'];
            $data['language_id'] = $language_id;
            $data['csrf_token'] = $this->security->get_csrf_token_name();
            $data['csrf_hash'] = $this->security->get_csrf_hash();
            $data['languages'] = $language_list;
            $data['blog'] = $blog_list;
            //Render view
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
     * action to add/edit blog page load form from ajax based on language
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
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[get_current_section($this)]['site_lang_code'];
        }
        //Variable Assignment
        $blog_list = array();
        $blog_list_result = array();
        $data = array();
        //logic        
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        if (isset($id) && $id != '' && $id != '0')
        {

            $blog_list_result = $this->blog_model->get_blog_detail('', $id, $language_id);
            if (!empty($blog_list_result))
            {
                if (!empty($blog_list_result[0]['b']))
                    $blog_list = $blog_list_result[0]['b'];
            }
        }
        //Variable assignments to view        
        $data['action'] = $action;
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['blog'] = $blog_list;
        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_action', $data);
        else
            return $this->load->view('admin_ajax_action', $data);
    }

    /**
     * Function delete for blog delete
     */
    function delete()
    {
        $data = $this->input->post();
        $id = intval($data['id']);
        $slug_url = trim(strip_tags($data['slug_url']));
        if ($id != 0 && $id != '' && is_numeric($id))
        {
            $res = $this->blog_model->delete_blog($id);
            if ($slug_url != '')
            {
                $this->urls_model->delete_url_by_slug($slug_url);
            }
            echo $this->theme->message(lang('blog-delete-success'), 'success');
        }
        else
        {
            echo $this->theme->message(lang('invalid-id-msg'), 'error');
        }
    }

    /**
     * Function users_validation_rules to validate input
     */
    function blog_validation_rules()
    {
        $this->form_validation->set_rules('blogtitle', lang('blog-title'), 'trim|required|min_length[2]|xss_clean');
        // $this->form_validation->set_rules('slug_url', lang('slug_url'), 'required|callback_check_unique_slug_url|xss_clean');
        $id = intval($this->input->post('id'));
    }

    /**
     * Function comment to view listing of comments
     */
    function comment()
    {
        //Paging parameters
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->blog_model->record_per_page = $this->record_per_page;
        $this->blog_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->blog_model->sort_by = $data['sort_by'];
                $this->blog_model->sort_order = $data['sort_order'];
            }
        }

        //Load data for url listing 
        $blogcomment = $this->blog_model->get_comment_listing();
        $this->blog_model->_record_count = true;
        $total_records = $this->blog_model->get_comment_listing();
        // Pass data to view file   
        $data['blogcomment'] = $blogcomment;
        $data['page_number'] = $this->page_number;
        $data['total_records'] = $total_records;
        $data['sort_by'] = $this->blog_model->sort_by;
        $data['sort_order'] = $this->blog_model->sort_order;

        //Create page-title
        $this->breadcrumb->add(lang('comment-management'));
        $this->theme->set('page_title', lang('blog-comment'));


        //Render view
        $this->theme->view($data);
    }

    /*
      Function edit_comment  for edit blog comment from admin side
  */

    function edit_comment()
    {
        //set form validation to check server side validation
        $this->load->library('form_validation');

        if ($this->input->post('mysubmit'))
        {
            $data = $this->input->post();

            //Type Casting 
            $id = intval($data['id']);

            //Variable Assignment   

            $comment_data = trim(strip_tags($data['comment_data']));
            $status = trim(strip_tags($data['status']));
            // field name, error message, validation rules
            $data_array['id'] = $id;
            $data_array['comment'] = $comment_data;
            $data_array['status '] = $status;
            $this->blog_model->save_comment($data_array);
            $this->theme->set_message(lang('comment-edit-success'), 'success');
            redirect(base_url() . get_current_section($this) . '/blog/comment');
            exit;
        }
    }

    /*     * **********************************
     * comment_action method call when click on edit button..
     */

    function comment_action($action = "edit", $id = 0)
    {
        $id = intval($id);
        $action = trim(strip_tags($action));
        $type = custom_filter_input('integer', $id);

        //Variable Assignment   
        $blogpost_id = "";
        $name = "";
        $email = "";
        $comment = "";
        $website = "";
        $status = "";

        //Logic
        switch ($action)
        {
            case 'edit':
                //Get user info by id
                $result = $this->blog_model->get_blog_comment_detail($id);

                if (!empty($result))
                {
                    $name = $result['name'];
                    $email = $result['email'];
                    $comment = $result['comment'];
                    $website = $result['website'];
                    $status = $result['status'];
                    $blogpost_id = $result['blogpost_id'];
                }
                else
                {
                    //If comment not exist then redirecting to listing page
                    redirect('admin/blog/comment');
                }
                break;
            default :
                $this->theme->set_message(lang('action-not-allowed'), 'error');
                redirect('admin/blog/comment');
                break;
        }
        // Pass data to view file  
        $data['id'] = $id;
        $data['status'] = $status;
        $data['name'] = $name;
        $data['email'] = $email;
        $data['comment'] = $comment;
        $data['website'] = $website;
        $data['blogpost_id'] = $blogpost_id;
        //create breadcrumbs & page-title
        if ($action == 'edit')
        {
            $this->theme->set('page_title', lang('edit-comment'));
            $this->breadcrumb->add(lang('edit-comment'));
        }


        //Render view
        $this->theme->view($data, 'admin_comment_edit');
    }

    /**
     * Function comment_delete for blog delete
     */
    function comment_delete()
    {
        $data = $this->input->post();
        $id = intval($data['id']);
        $result = $this->blog_model->get_blog_comment_detail($id);

        if (!empty($result))
        {
            $res = $this->blog_model->delete_blog_comment($id);
            if ($res)
            {
                echo $this->theme->message(lang('blog-comment-delete'), 'success');
            }
        }
        else
        {
            echo $this->theme->message(lang('invalid-id-msg'), 'error');
        }
    }

    /**
     * function check_unique_slug_url to check unique slug url     
     */
    public function check_unique_slug_url()
    {
        $slug_url = $this->input->post('slug_url');
        $result = $this->blog_model->check_unique_slug($slug_url);

        if (count($result) > 0)
        {
            $this->form_validation->set_message('check_unique_slug_url', lang('msg_available_slug_url'));
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * action view to view blog page
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
        $blog_detail = array();
        $blog_list_result = array();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        if (isset($id) && $id != '' && $id != '0')
        {
            $blog_list_result = $this->blog_model->get_related_lang_blog($id, $language_id);
            $category_list = $this->categories_model->get_category_detail_by_id($blog_list_result[0]['b']['category_id'], $language_id);
            $category_name = array('category_name' => $category_list[0]['c']['title']);
            $blog_detail = array_merge($blog_list_result[0]['b'], $category_name);
        }
        $language_list = $this->languages_model->get_languages(); // get list of languages
        // Breadcrumb settings

        $this->theme->set('page_title', lang('view-blog'));
        $this->breadcrumb->add(lang('view-blog'));

        //Variable assignments to view        
        $data = array();
        $data['id'] = $id;
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['languages'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['blog_detail'] = $blog_detail;
        //pre($data);
        
        $data['content'] = $this->load->view('admin_ajax_view', $data, TRUE);
        $this->theme->view($data);
    }

    /**
     * action to add/edit blog page load form from ajax based on language
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
        $blog_detail = array();
        $blog_list_result = array();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        //logic        
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        if (isset($id) && $id != '' && $id != '0')
        {
            
            $blog_list_result = $this->blog_model->get_blog_detail('', $id, $language_id);
           
            $category_list = $this->categories_model->get_category_detail_by_id($blog_list_result[0]['b']['category_id'], $language_id);
            $category_name = array('category_name' => $category_list[0]['c']['title']);
            //pre($category_name);
            $blog_detail = array_merge($blog_list_result, $category_name);
            
            //pre($blog_detail);
        }
        //Variable assignments to view                
        $data['id'] = $id;
        $data['language_id'] = $language_detail[0]['l']['id'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_code'] = $language_code;
        $data['blog_detail'] = $blog_detail;
        if ($ajax_load == '1'){
          
             echo $this->load->view('admin_ajax_view', $data);
        }
           
        else
            return $this->load->view('admin_ajax_view', $data);
    }

}