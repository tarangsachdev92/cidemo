<?php

/**
 *  Blog Controller (Front)
 *
 *  To perform login,registration and forgot password process.
 * 
 * @package CIDemoApplication
 * @subpackage Users
 * @copyright	(c) 2013, TatvaSoft
 * @author SGNSH
 */
class Blog extends Base_Front_Controller 
{

    function __construct() 
    {
        parent::__construct();
        //load helpers
        $this->load->helper(array('url', 'cookie'));
        //load library
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->access_control($this->access_rules());
        //load theme        
        $this->theme->set_theme("front");
    }

    /**
     * Function access_rules to check login
     */
    private function access_rules() 
    {
        return array(
            array(
                'actions' => array('index','ajax_layout','blog_detail','comment_validation_rules','save_comment'),
                'users' => array('*'),
            ),
            array(
                'actions' => array(),
                'users' => array('@'),
            )
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
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Logic for language id.             
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        //render view
        $categorylist = $this->blog_model->blog_category_list($language_id);
        $data['categorylist'] = $categorylist;
        $this->theme->view($data);
    }

    function ajax_layout($language_code = '') 
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '') 
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Logic for language id            
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        $language_list = $this->languages_model->get_languages();
        //Paging parameters
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->blog_model->record_per_page = $this->record_per_page;
        $this->blog_model->offset = $offset;
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
            if (isset($data['category'])) 
            {
                $this->blog_model->category = ltrim($data['category'], ',');
            }
        }

        //Load data for blog listing
        $sort_by = 'B.created' && $sort_order = 'dsc';
        $blogpost = $this->blog_model->get_blogpost_listing($language_id);
        $this->blog_model->_record_count = true; 
        $total_records = $this->blog_model->get_blogpost_listing($language_id);
        $categorylist = $this->blog_model->blog_category_list($language_id);
        // Pass data to view file   
        $data['blogpost'] = $blogpost;
        $data['categorylist'] = $categorylist;
        $data['page_number'] = $this->page_number;
        $data['total_records'] = $total_records;
        $data['search_term'] = $this->blog_model->search_term;
        $data['category'] = $this->blog_model->category;
        $data['sort_by'] = 'created';
        $data['sort_order'] = 'desc';
        $this->theme->view($data);
    }

    function blog_detail($slug_url,$language_code = '') 
    {
        //Variable dec  
        $category_id = "";
        $category_name = "";
        $title = "";
        $status = "";
        $blog_image = "";
        $blog_text = "";
        $created = "";
        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '') 
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Logic for language id            
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];
        //logic
        $result = $this->blog_model->get_blog_detail($slug_url);
        
        if (!empty($result)) 
        {
            //Variable assignment for edit view
            $title = $result[0]['b']['title'];
            $blog_image = $result[0]['b']['blog_image'];
            $blog_text = $result[0]['b']['blog_text'];
            $status = $result[0]['b']['status'];
            $category_id = $result[0]['b']['category_id'];
            $created = $result[0]['b']['created'];
            $id=$result[0]['b']['id'];
            
        }
        $category_result = $this->blog_model->get_category_detail($category_id);
        $category_name = $category_result['title'];
        $comments = $this->blog_model->get_blog_comments($id,$language_id);
        // Pass data to view file
        $data['id']=$id;
        $data['slug_url']=$slug_url;
        $data['status'] = $status;
        $data['title'] = $title;
        $data['category_name'] = $category_name;
        $data['blog_image'] = $blog_image;
        $data['blog_text'] = $blog_text;
        $data['created'] = $created;
        $data['comments'] = $comments;
        $this->theme->view($data);
    }

    function comment_validation_rules() 
    {
        $this->form_validation->set_rules('name', lang('comment-name'), 'trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('email', lang('comment-email'), 'trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('website', lang('comment-website'), 'trim|min_length[2]|xss_clean');
        $this->form_validation->set_rules('comment_data', lang('comment'), 'trim|required|min_length[2]|xss_clean');
        $id = intval($this->input->post('id'));
        $this->form_validation->set_rules('email', lang('comment-email'), 'trim|required|valid_email|callback_check_unique_email|xss_clean');
    }

    /** *********************************
      //Function save comment save comment into blog_comment..
     * ********************************** */

    function save_comment($language_code = '') 
    {

        //Type Casting
        $language_code = strip_tags($language_code);
        //Initialize
        if ($language_code == '') 
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        //Language id get          
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];      
        $language_list = $this->languages_model->get_languages();
        //set form validation to check server side validation
        $this->load->library('form_validation');
        if ($this->input->post('mysubmit')) 
        {
            $data = $this->input->post();           
            //Type Casting 
            $slug_url= $data['slug_url'];          
            $blogpost_id=intval($data['blogpost_id']);
            //Variable Assignment   
            $name = trim(strip_tags($data['name']));
            $email = trim(strip_tags($data['email']));
            $comment_data = trim(strip_tags($data['comment_data']));
            $website = trim(strip_tags($data['website']));
            // field name, error message, validation rules
            $this->comment_validation_rules();


            if ($this->form_validation->run($this)) 
            {
                $data_array['id'] = intval('0');
                $data_array['blogpost_id'] = $blogpost_id;
                $data_array['lang_id'] = $language_id;
                $data_array['name'] = $name;
                $data_array['email'] = $email;
                $data_array['website'] = $website;
                $data_array['comment'] = $comment_data;
                $data_array['status '] = '0';
                $this->blog_model->save_comment($data_array);
                $this->theme->set_message(lang('comment-add-success'), 'success');
                redirect(base_url() . 'blog/blog_detail/' . $slug_url);
                exit;
            }
        }
    }

}

?>