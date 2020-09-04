<?php

class Testimonial_admin extends Base_Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        //Logic
        $this->access_control($this->access_rules());
        $this->load->library('form_validation');
         $this->load->helper(array('form', 'url'));
        $this->load->model('testimonial_model');

        $this->breadcrumb->add('Manage Testimonials', base_url() . $this->section_name . '/testimonial');
    }

    /**
     * Function for set permission
     * @return array
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('index', 'action', 'delete', 'save', 'view_data', 'ajax_index', 'ajax_action', 'testimonial_detail', 'ajax_view','session_set'),
                'users' => array('@'),
            )
        );
    }

    /**
     * Function index for listing
     * @return array
     */
    function index($language_code = '')
    {

        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '')
        {
           $array = array(
            'search_category' => '',
            'search_status' => '',
            'search_type' => '',
            'search_term' => '',
            'date_from' => '',
            'date_to' => '',
            'search_lang' => '',
        );
        $this->session->set_custom_userdata($this->section_name,$array);
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        //Paging parameters
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->testimonial_model->record_per_page = $this->record_per_page;
        $this->testimonial_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_type']))
            {
                $this->testimonial_model->search_type = $data['search_type'];
            }
            if (isset($data['search_term']))
            {
                $this->testimonial_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->testimonial_model->sort_by = $data['sort_by'];
                $this->testimonial_model->sort_order = $data['sort_order'];
            }
        }

        //Get role listing data
        $records = $this->testimonial_model->get_record_listing($language_id);
        $this->testimonial_model->_record_count = true;
        $total_records = $this->testimonial_model->get_record_listing($language_id);

        // $this->breadcrumb->add(lang('testimonial-management'));
        $this->theme->set('page_title', lang('testimonial-management'));
        // Pass data to view file
        $data = array(
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_id' => $language_id,
            'languages_list' => $language_list,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'records' => $records,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->testimonial_model->search_term,
            'sort_by' => $this->testimonial_model->sort_by,
            'sort_order' => $this->testimonial_model->sort_order
        );
        //Render view
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
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->testimonial_model->record_per_page = $this->record_per_page;
        $this->testimonial_model->offset = $offset;
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        $search_type = '';
        $search_lang = '';
        $search_category = '';
        $search_status = '';

        $search_lang =$this->session->userdata[$this->section_name]['search_lang'];
        if($search_lang == $language_code)
        {
            $search_type =$this->session->userdata[$this->section_name]['search_type'];
            $search_category = $this->session->userdata[$this->section_name]['search_category'];
            $search_status = $this->session->userdata[$this->section_name]['search_status'];
        }
        //set sort/search parameters in pagging

        if ($this->input->post())
        {
            $data = $this->input->post();

            if (isset($data['search_type']))
            {
                $this->testimonial_model->search_type = $data['search_type'];
            }
            else
            {
                 $this->testimonial_model->search_type = $search_type;
            }

            if (isset($data['search_term']))
            {
                $this->testimonial_model->search_term = $data['search_term'];
            }
            else
            {
                 if($search_type == "testimonial_name")
                    $this->testimonial_model->search_term = $this->session->userdata[$this->section_name]['search_term'];
                  if($search_type == "testimonial_slug")
                    $this->testimonial_model->search_term = $this->session->userdata[$this->section_name]['search_term'];
                 if($search_type == "person_name")
                    $this->testimonial_model->search_term = $this->session->userdata[$this->section_name]['search_term'];
                 if($search_type == "company_name")
                    $this->testimonial_model->search_term = $this->session->userdata[$this->section_name]['search_term'];


            }
            if (isset($data['search_category']))
            {
                $this->testimonial_model->search_category = $data['search_category'];
            }
            else
            {
                    $this->testimonial_model->search_category = $search_category;
            }
            if (isset($data['date_from']))
            {
                $this->testimonial_model->date_from = $data['date_from'];
            }
            else
            {
                 if($search_type == "created_on")
                      $this->testimonial_model->date_from = $this->session->userdata[$this->section_name]['date_from'];
            }
            if (isset($data['date_to']))
            {
                $this->testimonial_model->date_to = $data['date_to'];
            }
            else
            {
                 if($search_type == "created_on")
                      $this->testimonial_model->date_to = $this->session->userdata[$this->section_name]['date_to'];
            }

            if (isset($data['search_status']))
            {
                $this->testimonial_model->search_status = $data['search_status'];
            }
            else
            {
                $this->testimonial_model->search_status = $search_status;
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->testimonial_model->sort_by = $data['sort_by'];
                $this->testimonial_model->sort_order = $data['sort_order'];
            }

            if (isset($data['type']) && $data['type'] == 'delete')
            {

                if ($this->testimonial_model->delete_records($data['ids']))
                {
                    echo $this->theme->message(lang('delete_success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                    if (isset($data['ids']))
                    {

                        if($data['ids'][0] == '0')
                        {
                          $flag = 1;
                        }
                        else
                        {
                            $flag = 0;
                        }

                        for ($i = $flag; $i < count($data['ids']); $i++)
                        {
                            $result = $this->testimonial_model->get_record_from_id($data['ids'][$i], $language_id);
                            $data_array['result'] = $result;

                            if ($data_array['result']['role_id'] != 1)
                            {
                                if($data_array['result']['is_published'] != 1)
                                {
                                    $bool = $this->testimonial_model->send_confirm_email($data_array);
                                }
                            }
                        }
                    }
                     if ($this->testimonial_model->active_records($data['ids']))
                    {
                        echo $this->theme->message(lang('testimonial-active-success'), 'success');
                        exit;
                    }
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                if ($this->testimonial_model->inactive_records($data['ids']))
                {
                    echo $this->theme->message(lang('testimonial-inactive-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                 $result = $this->testimonial_model->get_record_listing($language_id);
                 for($i = 0; $i<count($result); $i++)
                 {
                     $data_array[] = $result[$i]['R']+$result[$i]['U'];
                         if ($data_array[$i]['role_id'] != 1)
                            {
                                if($data_array[$i]['is_published'] != 1)
                                {
                                    $data_array['result']=$data_array[$i];
                                    $bool = $this->testimonial_model->send_confirm_email($data_array);
                                }
                            }
                }
                if ($this->testimonial_model->active_all_records($language_id))
                {
                    echo $this->theme->message(lang('testimonial-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                if ($this->testimonial_model->inactive_all_records($language_id))
                {
                    echo $this->theme->message(lang('testimonial-inactive-success'), 'success');
                    exit;
                }
            }
        }

        //Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $testimonial_list = $this->testimonial_model->get_record_listing($language_detail[0]['l']['id']);
        $this->testimonial_model->_record_count = true;
        $total_records = $this->testimonial_model->get_record_listing($language_detail[0]['l']['id']);

        // Breadcrumb settings
        // No breadcrumb as it's index page
        //Variable assignments to view
        $data = array(
            'records' => $testimonial_list,
            'language_code' => $language_code,
            'language_id' => $language_id,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_type_cont' => $this->testimonial_model->search_type,
            'search_term' => $this->testimonial_model->search_term,
            'search_category' => $this->testimonial_model->search_category,
            'search_status' => $this->testimonial_model->search_status,
            'date_from' => $this->testimonial_model->date_from,
            'date_to' => $this->testimonial_model->date_to,
            'sort_by' => $this->testimonial_model->sort_by,
            'sort_order' => $this->testimonial_model->sort_order
        );

        $this->theme->view($data, 'admin_ajax_index');
    }

    /**
     * Function action to perform insert & update by action parameter
     * @param string $action default = 'add'
     * @param integer $id default = 0
     */
    public function action($action, $language_code, $id = 0)
    {

        //Type Casting
        $id = intval($id);
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        custom_filter_input('integer', $id);

        //Variable Assignment
        $category_id = "";
        $testimonial_id = "";
        $testimonial_name = "";
        $testimonial_slug = "";
        $testimonial_description = "";
        $logo = "";
        $company_name = "";
        $website = "";
        $position = "";
        $video_type = "";
        $video_src = "";
        $is_published = "";


        //Logic
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        // Logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        switch ($action)
        {
            case 'add':
                break;
            case 'edit':

                $result = $this->testimonial_model->get_record_by_id($id, $language_id);

                if (!empty($result))
                {
                    //Variable assignment for edit view
                    $id = $result['id'];
                    $testimonial_id = $result['testimonial_id'];
                    $category_id = $result['category_id'];
                    $testimonial_name = $result['testimonial_name'];
                    $testimonial_slug = $result['testimonial_slug'];
                    $testimonial_description = $result['testimonial_description'];
                    $logo = $result['logo'];
                    $company_name = $result['company_name'];
                    $website = $result['website'];
                    $position = $result['position'];
                    $video_type = $result['video_type'];
                    $video_src = $result['video_src'];
                    $is_published = $result['is_published'];
                }
                else
                {
                    redirect($this->section_name.'testimonial');
                }
                break;
            default :
                $this->theme->set_message(lang('action-not-allowed'), 'error');
                redirect($this->section_name.'/testimonial');
                break;
        }

        // Pass data to view file
        $data = array(
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'languages' => $language_list,
            'language_id' => $language_id,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'action' => $action,
            'file_error' => '',
            'logo_error' => '',
            'id' => $id,
            'testimonial_id' => $testimonial_id,
            'category_id' => $category_id,
            'testimonial_name' => $testimonial_name,
            'testimonial_slug' => $testimonial_slug,
            'testimonial_description' => $testimonial_description,
            'logo' => $logo,
            'company_name' => $company_name,
            'website' => $website,
            'position' => $position,
            'video_type' => $video_type,
            'video_src' => $video_src,
            'is_published' => $is_published,
        );



        if ($action == 'add')
        {
            $this->theme->set('page_title', lang('add-testimonial'));
            $this->breadcrumb->add(lang('add-testimonial'));
        }
        else
        {
            $this->theme->set('page_title', lang('edit-testimonial'));
            $this->breadcrumb->add(lang('edit-testimonial'));
        }

        //Render view
        $data['content'] = $this->load->view('admin_add', $data, TRUE);
        $this->theme->view($data, 'admin_action');
    }

    /**
     * action to add/edit testimonial page load form from ajax based on language
     * @param string $action : add or edit
     * @param string $language_code
     * @param string $id : if in edit mode
     * @param string $ajax_load : will be 1 if load from ajax mode
     */
    function ajax_action($action, $language_code = '', $testimonial_id = '', $ajax_load = 1)
    {
        //Type Casting
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);
        $testimonial_id = intval($testimonial_id);
        $ajax_load = intval($ajax_load);

        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Variable Assignment
        $category_id = "";
        $testimonial_name = "";
        $testimonial_slug = "";
        $testimonial_description = "";
        $logo = "";
        $company_name = "";
        $website = "";
        $position = "";
        $video_type = "";
        $video_src = "";
        $is_published = "";

        //logic
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        if (isset($testimonial_id) && $testimonial_id != '' && $testimonial_id != '0')
        {

            $result = $this->testimonial_model->get_record_by_id($testimonial_id, $language_id);

            if (!empty($result))
            {
                //Variable assignment for edit view
                $id = $result['id'];
                $testimonial_id = $result['testimonial_id'];
                $category_id = $result['category_id'];
                $testimonial_name = $result['testimonial_name'];
                $testimonial_slug = $result['testimonial_slug'];
                $testimonial_description = $result['testimonial_description'];
                $logo = $result['logo'];
                $company_name = $result['company_name'];
                $website = $result['website'];
                $position = $result['position'];
                $video_type = $result['video_type'];
                $video_src = $result['video_src'];
                $is_published = $result['is_published'];
            }
        }
        $language_list = $this->languages_model->get_languages();
        //Variable assignments to view

        $data = array(
            'language_code' => $language_detail[0]['l']['language_code'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'languages' => $language_list,
            'language_id' => $language_id,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'action' => $action,
            'file_error' => '',
            'logo_error' => '',
            //'id' => $id,
            'testimonial_id' => $testimonial_id,
            'category_id' => $category_id,
            'testimonial_name' => $testimonial_name,
            'testimonial_slug' => $testimonial_slug,
            'testimonial_description' => $testimonial_description,
            'logo' => $logo,
            'company_name' => $company_name,
            'website' => $website,
            'position' => $position,
            'video_type' => $video_type,
            'video_src' => $video_src,
            'is_published' => $is_published,
        );


        if ($ajax_load == '1')
            echo $this->load->view('admin_add', $data);
        else
            return $this->load->view('admin_add', $data);
    }

    /**
     * Function action to perform insert & update by action parameter
     * @param string $action default = 'add'
     * @param integer $id default = 0
     */
    public function save($language_code = '')
    {
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();


        if ($this->input->post('mysubmit'))
        {

            $data = $this->input->post();
            //Type Casting
            $id = intval($data['id']);
            $testimonial_id = intval($data['testimonial_id']);
            $action = $data['action'];
            //Variable Assignment
            $category_id = intval($data['category_id']);
            $user_id = $this->session->userdata[$this->section_name]['user_id'];
            $testimonial_name = trim($data['testimonial_name']);
            $testimonial_slug = trim($data['testimonial_slug']);
            $testimonial_description = trim($data['testimonial_description']);
            $company_name = trim($data['company_name']);
            $logo = trim($data['logo']);
            $website = $data['website'];
            $position = trim($data['position']);
            $video_type = trim($data['video_type']);
            if ($video_type == YOUTUBE)
            {
                $video_src = $data['video_link'];
            }
            else
            {
                $video_src = '';
            }
            $is_published = $data['is_published'];


                 $this->form_validation->set_rules('category_id', 'category', 'required');
                 $this->form_validation->set_rules('testimonial_name', 'Name', 'required|trim|xss_clean|max_length[100]');
                 $this->form_validation->set_rules('testimonial_slug', 'Tesimonial Slug', 'required|callback_check_unique_slug_url');
                 $this->form_validation->set_rules('testimonial_description', 'Description', 'required|trim|xss_clean');
                 $this->form_validation->set_rules('logo', 'Logo', 'callback_handle_upload|xss_clean');
                  if ($video_type == SRC)
                  {
                       $this->form_validation->set_rules('video_src', 'Video Source', 'callback_handle_upload_video|xss_clean');
                  }


            if ($this->form_validation->run($this) == true)
            {
                //assign validate type

                    if(isset($_POST['video_src_val']))
                 {
                     $video_src = $_POST['video_src_val'];
                 }
                 else
                 {
                      if ($video_type == YOUTUBE)
                      {
                          $video_src = $data['video_link'];
                      }
                      else if($video_type == SRC)
                      {
                          $video_src = $data['video_src'];
                      }
                      else
                      {
                        $video_src ='';
                      }
                 }
               if(isset($_POST['logo_val']))
                 {
                     $logo = $_POST['logo_val'];
                 }
                 else
                 {
                       $logo = $data['logo'];
                 }

                    $data_array = array(
                        'language_id' => $language_id,
                        'id' => $id,
                        'testimonial_id' => $testimonial_id,
                        'user_id' => $this->session->userdata[$this->section_name]['user_id'],
                        'category_id' => $category_id,
                        'testimonial_name' => $testimonial_name,
                        'testimonial_slug' => $testimonial_slug,
                        'testimonial_description' => $testimonial_description,
                        'logo' => $logo,
                        'company_name' => $company_name,
                        'website' => $website,
                        'position' => $position,
                        'video_type' =>  $video_type,
                        'video_src' => $video_src,
                        'is_published' => $is_published,
                    );

                    if ($testimonial_id == '0' || $testimonial_id == '')
                    {
                        $last_test_id = $this->testimonial_model->get_last_test_id();
                        $testimonial_id = $last_test_id + 1;
                        $data_array['testimonial_id'] = $testimonial_id;
                    }
                    if ($data_array['is_published'] == PUBLISH)
                    {
                        if ($id != 0)
                        {
                            $result = $this->testimonial_model->get_record_by_id($testimonial_id, $language_id);
                            $data_array['result'] = $result;
                            if ($data_array['result']['role_id'] != 1)
                            {
                                $bool = $this->testimonial_model->send_confirm_email($data_array);
                            }
                        }
                    }

                    // run insert model to write data to db
                    $lastId = $this->testimonial_model->save_record($data_array);

                    //mentainence by slug
                    $this->config_model->change_slug_url_management($this->input->post('old_slug_url'), $this->input->post('testimonial_slug'), 'testimonial', $id, 'index/' . $this->input->post('testimonial_slug'), $this->input->post('is_published'), $language_id);
                    $this->load->module('urls/urls_admin');
                    $this->urls_admin->generate_custom_url();


                    if ($id == 0)
                    {
                        $this->theme->set_message(lang('record-add-success'), 'success');
                    }
                    else
                    {
                        $this->theme->set_message(lang('record-edit-success'), 'success');
                    }

                    redirect($this->section_name.'/testimonial/index/' . $language_code);
                    exit;
                }
    //            $this->theme->message(validation_errors('<div class="warning-msg">', '</div>'), 'error');
    //            redirect(uri_string());
    //            exit;
            }

        else
        {
            $testimonial_name = "";
            $testimonial_slug = "";
            $testimonial_description = "";
            $logo = "";
            $company_name = "";
            $website = "";
            $position = "";
            $video_type = "";
            $video_src = "";
            $is_published = "";
            $id = "";
        }

        // Pass data to view file
        $data = array(
            'languages' => $language_list,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'id' => $id,
            'user_id' => $this->session->userdata[$this->section_name]['user_id'],
            'category_id' => $category_id,
            'testimonial_name' => $testimonial_name,
            'testimonial_slug' => $testimonial_slug,
            'testimonial_description' => $testimonial_description,
            'logo' =>  $_POST['logo'],
            'company_name' => $company_name,
            'website' => $website,
            'position' => $position,
            'video_type' => $video_type,
            'video_src' =>  $_POST['video_src'],
            'is_published' => $is_published,
            'action' => $action,
        );



        //create breadcrumbs & page-title
        if ($id == '')
        {
            $this->theme->set('page_title', lang('add-record'));
            $this->breadcrumb->add(lang('add-record'));
        }
        else
        {
            $this->theme->set('page_title', lang('edit-record'));
            $this->breadcrumb->add(lang('edit-record'));
        }

        //Render view
        $data['content'] = $this->load->view('admin_add', $data, TRUE);

        $this->theme->view($data, 'admin_action');
    }


     /* handle upload file validation */

    public function handle_upload()
    {


                if ($_FILES['logo']['tmp_name'] != '' && $_FILES['logo']['name'] != '')
                {
                    $config['upload_path'] = VIDEOIMAGEPATH;
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size'] = '10299';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('logo'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        $this->form_validation->set_message('handle_upload', $error['error']);
                        return false;
                    }
                    else
                    {
                        $uploaded_file_details = $this->upload->data();
                        $_POST['logo_val']= $config['upload_path'] . $uploaded_file_details['file_name'];
                         return true;
                    }
                }
    }


    /* handle video uploading */

    public function handle_upload_video()
    {
              if ($_FILES['video_src']['tmp_name'] != '' && $_FILES['video_src']['name'] != '')
                {
                    $config['upload_path'] = VIDEOPATH;
                    $config['allowed_types'] = 'mp4|wmv|flv';
                    $config['max_size'] = '102999';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $p = $_FILES['video_src']['name'];
                    $arr = explode('.', $p);
                    $ext = strtolower(end($arr));
                    $video_name = preg_replace("/\\.[^.]*$/", "", basename($_FILES['video_src']['name']));
                    $vid = $video_name . time() . rand();
                    $vdoname = $vid . "." . $ext;
                    $flv_vdoname = $vid . ".flv";
                    $pth = FFMPEG_PATH;
                    $dest = VIDEOPATH . $flv_vdoname;
                    exec("$pth -i $dest -ar 22050 -ab 32 -f flv -s 426×234 $dest");
                     $_FILES['video_src']['name'] = $flv_vdoname;


                    if (!$this->upload->do_upload('video_src'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        $this->form_validation->set_message('handle_upload_video', $error['error']);
                        return false;
                    }
                    else
                    {


                        $uploaded_file_details = $this->upload->data();
                        $_POST['video_src_val'] = $config['upload_path'] . $uploaded_file_details['file_name'];
                        return true;

                    }
                }
    }


    /**
     * Function delete to Role (Ajax-Post)
     */
    function delete()
    {
        $data = $this->input->post();
        $id = intval($data['id']);


        $res = $this->testimonial_model->delete_record($id);

        if ($res)
        {
            $message = $this->theme->message(lang('record-delete-success'), 'success');
        }
        //message
        echo $message;
    }

    /* testimonial Details */

    function testimonial_detail($language_code = '', $slug)
    {

        //Type Casting
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Paging parameters
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->testimonial_model->record_per_page = $this->record_per_page;
        $this->testimonial_model->offset = $offset;
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages(); // get list of l
        //Get role listing data
        if (isset($this->session->userdata[$this->section_name]['user_id']))
        {
            $user_id = $this->session->userdata[$this->section_name]['user_id'];
            $data['user_id'] = $user_id;
        }
        $this->theme->set('page_title', lang('view_testimonial'));
        $this->breadcrumb->add(lang('view_testimonial'));
        $records = $this->testimonial_model->get_record_by_slug($slug, $language_id);
        if(!empty($records)){
                $data['slug'] = $records['testimonial_slug'];
        }
        $data['language_code'] = $language_detail[0]['l']['language_code'];
        $data['language_name'] = $language_detail[0]['l']['language_name'];
        $data['language_id'] = $language_id;
        $data['languages'] = $language_list;
        $data['csrf_token'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $data['records'] = $records;
        // Pass data to view file
        $data['content'] = $this->load->view('admin_ajax_detail', $data, TRUE);
        //Render view
        $this->theme->view($data);
    }

    /* ajax view of detail page of testimnial */

    function ajax_view($language_code = '', $slug, $ajax_load = '1')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages(); // get list of l
        //Initialize
        $records = $this->testimonial_model->get_record_by_slug($slug, $language_id);

        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        // Pass data to view file
        $data = array(
            'languages' => $language_list,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'records' => $records
        );

        if ($ajax_load == '1')
            echo $this->load->view('admin_ajax_detail', $data);
        else
            return $this->load->view('admin_ajax_detail', $data);
    }



    /* set search values in session */
    function session_set($language_code)
    {
        //Initialize
        $array = array();
        //Type Casting
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }

        $data = $this->input->post();
        $array = array(
            'search_category' => $this->input->post('search_category'),
            'search_status' => $this->input->post('search_status'),
            'search_type' => $this->input->post('search_type'),
            'search_term' => $this->input->post('search_term'),
            'date_from' => $this->input->post('date_from'),
            'date_to' => $this->input->post('date_to'),
            'search_lang' => $language_code
        );
        $this->session->set_custom_userdata($this->section_name,$array);
    }

    /**
     * Function check_unique_slug_url to check unique slug url
     */
    public function check_unique_slug_url()
    {

        //variable assignement
        $id = '';

        //Get url management id
        if ($this->input->post('old_slug_url') != '')
        {
            $url_detail = $this->testimonial_model->get_testimonial_detail_by_slug($this->input->post('old_slug_url'));
            $id = $url_detail[0]['testimonial']['id'];
        }
        $slug_url = $this->input->post('testimonial_slug');

        $result = $this->testimonial_model->check_unique_slug($slug_url, $id);

        if (count($result) > 0)
        {
            $this->form_validation->set_message('check_unique_slug_url', lang('msg_alvailable_slug_url'));
            return false;
        }
        else
        {
            return true;
        }
    }
}

?>