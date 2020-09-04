<?php

class Testimonial extends Base_Front_Controller
{
    function __construct()
    {
        parent::__construct();
        //Logic
        $this->access_control($this->access_rules());
        $this->load->library('email');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->model('testimonial_model');
    }

    /**
     * Function for set permission
     * @return array
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('index', 'action', 'delete', 'save', 'testimonial_detail', 'recaptcha','session_set'),
                'users' => array('@'),
            ),
            array(
                'actions' => array('index', 'testimonial_detail'),
                'users' => array('*'),
            )
        );
    }

    /**
     * Function index for listing
     * @return array
     */
    function index()
    {       
        //Initialize
        $data = array();
        $data_array = array();
        $ajax = '';
        $language_code = '';
       
        //Type Casting 
//        $language_code = strip_tags($language_code);
        
     
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
       
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];      
        //Paging parameters
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->testimonial_model->record_per_page = $this->record_per_page;
        $this->testimonial_model->offset = $offset;
        //set sort/search parameters in pagging
      
        if ($this->input->post())
        {                        
            $ajax = 1;
            $data_array = $this->input->post();
            if (isset($data_array['search_term']))
            {
                $this->testimonial_model->search_term = $data_array['search_term'];
            }
         
            if (isset($data_array['search_type']))
            {
                $this->testimonial_model->search_type = $data_array['search_type'];
            }
            
            if (isset($data_array['date_from']))
            {
                $this->testimonial_model->date_from = $data_array['date_from'];
            }
            
            if (isset($data_array['date_to']))
            {
                $this->testimonial_model->date_to = $data_array['date_to'];
            }
           
            if (isset($data_array['search_category']))
            {
                $this->testimonial_model->search_category = $data_array['search_category'];
            }
            
            if (isset($data_array['type']) && $data_array['type'] == 'delete')
            {
                if ($this->testimonial_model->delete_records($data_array['ids']))
                {
                    echo $this->theme->message(lang('delete_success'), 'success');
                    exit;
                }
            }
            if (isset($data_array['sort_by']) && $data_array['sort_order']) 
            {
                $this->testimonial_model->sort_by = $data_array['sort_by'];
                $this->testimonial_model->sort_order = $data_array['sort_order'];
            }
        }
        else
        {            
        $search_type = '';
        $search_lang = '';
        $search_category = '';
        $search_status = '';
        $search_lang = '';
        $search_lang = $this->session->userdata[$this->section_name]['search_lang'];
        if($search_lang == $language_code)
            {
            $search_type =$this->session->userdata[$this->section_name]['search_type'];
            $search_category = $this->session->userdata[$this->section_name]['search_category'];
            }                               
           $this->testimonial_model->search_type = $search_type;
           $this->testimonial_model->search_category = $search_category;
         if($search_type == "testimonial_name")
            $this->testimonial_model->search_term = $this->session->userdata[$this->section_name]['search_term'];
          if($search_type == "testimonial_slug")
            $this->testimonial_model->search_term = $this->session->userdata[$this->section_name]['search_term'];
         if($search_type == "person_name")
            $this->testimonial_model->search_term = $this->session->userdata[$this->section_name]['search_term'];
         if($search_type == "company_name")
            $this->testimonial_model->search_term = $this->session->userdata[$this->section_name]['search_term'];
         if($search_type == "created_on")
         {
              $this->testimonial_model->date_from = $this->session->userdata[$this->section_name]['date_from'];  
              $this->testimonial_model->date_to =  $this->session->userdata[$this->section_name]['date_to'];      
         }
            }                                                             
        //Get role listing data        
        $records = $this->testimonial_model->get_record_listing($language_id);
        $this->testimonial_model->_record_count = true;
        $total_records = $this->testimonial_model->get_record_listing($language_id);
        // Pass data to view file  
        $data = array(
            'records' => $records,
            'page_number' => $this->page_number,
            'total_records' => $total_records,
            'search_term' => $this->testimonial_model->search_term,
            'search_type_cont' => $this->testimonial_model->search_type,
            'search_category' => $this->testimonial_model->search_category,
            'date_from' => $this->testimonial_model->date_from,
            'date_to' => $this->testimonial_model->date_to,            
            'language_code' => $language_code,
            'language_id' => $language_id,
            'is_ajax' => $ajax
        );        
        if (isset($this->session->userdata[$this->section_name]['user_id']))
        {
            $user_id = $this->session->userdata[$this->section_name]['user_id'];
            $data['user_id'] = $user_id;           
        }
        //Render view
        $this->theme->view($data);
    }

    /**
     * Function action to perform insert & update by action parameter
     * @param string $action default = 'add'  
     * @param integer $id default = 0
     */
    public function action($action, $language_code, $id = 0)
    {
        //Initialize
        $data = array();
        
        //Type Casting 
        $CI = & get_instance();
        $id = intval($id);
        $action = trim(strip_tags($action));
        $language_code = strip_tags($language_code);

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

        //Logic
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
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
                    $category_id = $result['category_id'];
                    $testimonial_id = $result['testimonial_id'];
                    $testimonial_name = $result['testimonial_name'];
                    $testimonial_slug = $result['testimonial_slug'];
                    $testimonial_description = $result['testimonial_description'];
                    $logo = $result['logo'];
                    $company_name = $result['company_name'];
                    $website = $result['website'];
                    $position = $result['position'];
                    $video_type = $result['video_type'];
                    $video_src = $result['video_src'];
                }
                else
                {
                    redirect('testimonial');
                }
                break;
            default :
                $this->theme->set_message(lang('action-not-allowed'), 'error');
                redirect('testimonial');
                break;
        }
        // Pass data to view file
        $data = array(
            'language_id' => $language_id,
            'language_code' => $language_code,
            'languages' => $language_list,
            'category_id' => $category_id,
            'csrf_token' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'action' => $action,           
            'id' => $id,
            'testimonial_id' => $testimonial_id,
            'testimonial_name' => $testimonial_name,
            'testimonial_slug' => $testimonial_slug,
            'testimonial_description' => $testimonial_description,
            'logo' => $logo,
            'company_name' => $company_name,
            'website' => $website,
            'position' => $position,
            'video_type' => $video_type,
            'video_src' => $video_src,
            'captcha' => $this->my_captcha->deleteImage()->createWord()->createCaptcha(),
            'ci' => $CI,
            'word' => $this->session->userdata('word')
        );  
       // var_dump($data);
       
        //Render view
        $this->theme->view($data, 'add');
    }

    /**
     * Function save to perform insert & update    
     */
    public function save($language_code)
    {
         
        //Initialize
        $data = array();
        $data_array = array();
        
        //Type Casting
        $language_code = strip_tags($language_code);
         $CI = & get_instance();
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        $user_id = $this->session->userdata[$this->section_name]['user_id'];     
       
        if ($this->input->post('mysubmit'))
        {
            $data = $this->input->post(); 
         
            //Variable Assignment  
            $id = intval($data['id']);
            $category_id = intval(strip_tags($data['category_id']));
            $testimonial_id = intval($data['testimonial_id']);
            $testimonial_name = trim(strip_tags($data['testimonial_name']));
            $testimonial_slug = trim(strip_tags($data['testimonial_slug']));
            $testimonial_description = trim($data['testimonial_description']);
//            $logo = trim($data['logo']);
            $company_name = trim(strip_tags($data['company_name']));
            $position = trim(strip_tags($data['position']));
            $website = trim(strip_tags($data['website']));
            $video_type = $data['video_type'];
                            	
            
                 $this->form_validation->set_rules('category_id', 'category', 'required');
                 $this->form_validation->set_rules('testimonial_name', 'Name', 'required|trim|xss_clean|max_length[100]');
                 $this->form_validation->set_rules('testimonial_slug', 'Tesimonial Slug', 'required|callback_check_unique_slug_url');
                 $this->form_validation->set_rules('testimonial_description', 'Description', 'required|trim|xss_clean');
                 $this->form_validation->set_rules('logo', 'Logo', 'callback_handle_upload');
                  if ($video_type == SRC)
                  {
                       $this->form_validation->set_rules('video_src', 'Video Source', 'callback_handle_upload_video');                       
                  }                 
                if (CAPTCHA_SETTING)
                    $this->form_validation->set_rules('captcha', 'Captcha', 'required|validate_captcha[' . $this->input->post("captcha") . ']');
               
            if ($this->form_validation->run($this))
            {
              
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
                  
                unset($data["captcha"]);
                $data_array = array(
                    'language_id' => $language_id,
                    'id' => $id,
                    'user_id' => $this->session->userdata[$this->section_name]['user_id'],
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
                    'is_published' => UNPUBLISH
                );    
               
                if ($testimonial_id == '0' || $testimonial_id == '')
                {
                  
                    $last_test_id = $this->testimonial_model->get_last_test_id();
                    $testimonial_id = $last_test_id + 1;
                    $data_array['testimonial_id'] = $testimonial_id;
                }     
              
                // run insert model to write data to db
                $lastId = $this->testimonial_model->save_record($data_array);
                 $is_sent = $this->testimonial_model->send_email($data_array);
                if ($id == 0 || $id == '')
                {
                    $this->theme->set_message(lang('record-add-success'), 'success');
                }
                else
                {
                    $this->theme->set_message(lang('record-edit-success'), 'success');
                }
                redirect('testimonial/index/' . $language_code);
                exit;
            }
           
        }
        else
        {
            $testimonial_name = "";
            $testimonial_slug = "";
            $testimonial_description = "";
            $logo = "";
            $company_name = "";
            $position = "";
            $website = "";
            $video_type = "";
            $video_src = "";
            $id = "";
        }
        // Pass data to view file
        $data = array(
            'languages' => $language_list,
            'language_id' => $language_detail[0]['l']['id'],
            'language_name' => $language_detail[0]['l']['language_name'],
            'language_code' => $language_code,
            'captcha' => $this->my_captcha->deleteImage()->createWord()->createCaptcha(),                      
            'captcha' => $this->my_captcha->deleteImage()->createWord()->createCaptcha(),
            'ci' => $CI,
            'word' => $this->session->userdata('word'),
            'id' => $id,
            'testimonial_id' => $testimonial_id,
            'category_id' => $category_id,
            'user_id' => $this->session->userdata[$this->section_name]['user_id'],            
            'testimonial_name' => $testimonial_name,
            'testimonial_slug' => $testimonial_slug,
            'testimonial_description' => $testimonial_description,
            'logo' => $_POST['logo'],
            'company_name' => $company_name,
            'website' => $website,
            'position' => $position,
            'video_type' => $video_type,
            'video_src' => $_POST['video_src'],
            'is_published' => UNPUBLISH
        );          
        $this->theme->view($data, 'add');
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
     * Function delete to Delete Testimonial
     */
    function delete()
    {
        //Type Casting
        $id = intval($data['id']);
        //Logic
        $data = $this->input->post();
        $res = $this->testimonial_model->delete_record($id);
        if ($res)
        {
            $message = $this->theme->message(lang('record-delete-success'), 'success');
        }
        //message
        echo $message;
    }

    /**
     * Function testimonial_detail to List detail of Testimonial
     */
    function testimonial_detail($slug, $language_code)
    {
        //Initialize
        $data = array();
        //Type Casting
        $language_code = strip_tags($language_code);
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        
        //Get role listing data        
        $records = $this->testimonial_model->get_record_by_slug($slug, $language_id);

        // Pass data to view file  
        $data = array(
            'language_code' => $language_code,
            'language_id' => $language_id,
            'records' => $records
        );
        if (isset($this->session->userdata[$this->section_name]['user_id']))
        {
            $user_id = $this->session->userdata[$this->section_name]['user_id'];
            $data['user_id'] = $user_id;
        }
        //Render view
        $this->theme->view($data);
    }
    
    //regenerate captcha code
    function recaptcha()
    {
        $data['captcha'] = $this->my_captcha->deleteImage()->createWord()->createCaptcha();
        echo $data['captcha'];       
    }
    
    // set search values in session 
    function session_set($language_code){
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