<?php

/**
 *  Gallery Admin Controller
 *
 *  To perform gallery management.
 *
 * @package CIDemoApplication
 * @subpackage Gallery
 * @copyright	(c) 2013, TatvaSoft
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gallery_admin extends Base_Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->breadcrumb->add(lang('gallery-management'), base_url() . $this->section_name . '/gallery');
        // Login check for admin
        $this->access_control($this->access_rules());
    }

    /**
     * Function access_rules to check login
     */
    public function access_rules() {
        return array(
            array(
                'actions' => array('index', 'add_image', 'edit_image', 'save', 'delete', 'view_details'),
                'users' => array('@'),
            ),
            array(
                'actions' => array('login', 'signin', 'logout'),
                'users' => array('*'),
            )
        );
    }

    /**
     * Function index to view listing of gallery
     */
    function index() {
        //Paging parameters
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->gallery_model->record_per_page = $this->record_per_page;
        $this->gallery_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post()) {
            $data = $this->input->post();
            if (isset($data['search_term'])) {
                $this->gallery_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order']) {
                $this->gallery_model->sort_by = $data['sort_by'];
                $this->gallery_model->sort_order = $data['sort_order'];
            }
            if (isset($data['type']) && $data['type'] == 'delete') {
                $this->gallery_model->delete_records($data['ids']);
                 echo $this->theme->message(lang('image-delete-success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'active') {
                $this->gallery_model->active_records($data['ids']);
                 echo $this->theme->message(lang('image-active-success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'inactive') {
                $this->gallery_model->inactive_records($data['ids']);
                 echo $this->theme->message(lang('image-inactive-success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'active_all') {
                $this->gallery_model->active_all_records();
                 echo $this->theme->message(lang('image-active-success'), 'success');
                    exit;
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all') {
                $this->gallery_model->inactive_all_records();
                echo $this->theme->message(lang('image-inactive-success'), 'success');
                exit;
            }
        }

        //Load data for url listing
        $images = $this->gallery_model->get_images_listing();

        // Pass data to view file
        $data['images'] = $images;
        $data['page_number'] = $this->page_number;
        $data['total_records'] = $this->gallery_model->record_count();
        $data['search_term'] = $this->gallery_model->search_term;
        $data['sort_by'] = $this->gallery_model->sort_by;
        $data['sort_order'] = $this->gallery_model->sort_order;

        //Create page-title
        $this->theme->set('page_title', lang('gallery-management'));

        //Render view
        $this->theme->view($data);
    }

    /**
     * Function to perform add/edit image
     */
    function edit_image($id = '') {
        //Initialization
        $galleries = array();

        //Logic
        $galleries = $this->gallery_model->get_gallery_listing();

        if ($id != '') {
            $imageDetail = $this->gallery_model->get_images_listing_by_id($id);
            $data['imageDetail'] = $imageDetail;
            $this->breadcrumb->add(lang('edit-image'));
        } else {
            $this->breadcrumb->add(lang('add-image'));
        }

        // Pass data to view file
        $data['galleries'] = $galleries;

        //Create page-title
        $this->theme->set('page_title', lang('gallery-management'));

        //Render view
        $this->theme->view($data);
    }

    /**
     * Function save to update image to galery
     *  and related information
     */
    function save() {
        //set form validation to check server side validation
        $this->load->library('form_validation');
        
        //Logic
        if ($this->input->post('mysubmit')) {
            $data = $this->input->post();

            //Variable Assignment
            $id = intval($data['id']);
            $title = trim(strip_tags($data['title']));
            $tag = trim(strip_tags($data['tag']));
            $gallery_id = trim(strip_tags($data['gallery_id']));
            $status = trim(strip_tags($data['status']));
            $old_image = trim(strip_tags($data['old_image']));

            //file uploading code........
            $config['upload_path'] = FCPATH . "assets/uploads/gallery_images/";
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
                if (!$this->upload->do_upload('image')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->theme->set_message($error['error'], 'error');
                    redirect($this->section_name . '/gallery');
                } else {
                    $uploaded_file_details = $this->upload->data();
                    $data_array['image'] = $uploaded_file_details['file_name'];

                    //-------- Start: create thumb code -------//
                    $this->load->library('image_lib');
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $config['upload_path'] . $data_array['image'];
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 100;
                    $config['height'] = 100;
                    $config['new_image'] = $config['upload_path'] . 'thumb/' . $data_array['image'];

                    $this->image_lib->initialize($config);

                    if (!$this->image_lib->resize()) {
                        echo $this->image_lib->display_errors();
                    }
                    //-------- End: create thumb code -------//
                    if (file_exists("assets/uploads/gallery_images/" . $old_image)) {
                        unlink("assets/uploads/gallery_images/" . $old_image);
                    }
                    if (file_exists("assets/uploads/gallery_images/thumb/" . $old_image)) {
                        unlink("assets/uploads/gallery_images/thumb/" . $old_image);
                    }
                }
            }
            // field name, error message, validation rules
            $this->form_validation->set_rules('title', lang('image-title'), 'trim|required|min_length[2]|xss_clean');
            $this->form_validation->set_rules('tag', lang('tag-title'), 'trim|required|min_length[2]|xss_clean');

            if ($this->form_validation->run($this)) {
                $data_array['id'] = $id;
                $data_array['title'] = $title;
                $data_array['tag'] = $tag;
                $data_array['gallery_id'] = $gallery_id;
                $data_array['status'] = $status;

                $this->gallery_model->save_image($data_array);

                if ($id == 0 || $id != '') {
                    $this->theme->set_message(lang('image-add-success'), 'success');
                } else {
                    $this->theme->set_message(lang('image-edit-success'), 'success');
                }
                redirect($this->section_name . '/gallery');
                exit;
            }
        }

        //Render view
//        $this->theme->view($data, 'admin_add');
        //Initialization
        $galleries = array();

        //Logic
        $galleries = $this->gallery_model->get_gallery_listing();
         $data['galleries'] = $galleries;
        $this->theme->view($data, 'admin_edit_image');
    }

    /*
     * Function view_details to vie image and related details
     */

    function view_details($id = '') {
        //Initialization
        $data = array();

        //Logic
        if ($id == '') {
            redirect($this->section_name . '/gallery');
        } else {
            $id = intval($id);
            
            $data = $this->gallery_model->get_images_listing_by_id($id);
          
        }

        //Create Breadcrum
        $this->breadcrumb->add(lang('image-view-bredcrum'));
        //Create page-title
        $this->theme->set('page_title', lang('image-view-bredcrum'));
       
        //Render view
        $this->theme->view($data);
    }

    /**
     * Function delete to delete image and related information
     * Call type : Ajax(POST)
     */
    function delete() {
        //Initialization
        $data = array();
        $result = array();
       

        //Logic
        $data = $this->input->post();
        $id = intval($data['id']);
        $result = $this->gallery_model->get_image_detail($id);
        if (!empty($result)) {
            // $imageDetail = $this->gallery_model->get_images_listing_by_id($id);
            //$image_path = $imageDetail['I']['image'];
            $res = $this->gallery_model->delete_image($id);
//            if ($res) {
//                if (file_exists("assets/uploads/gallery_images/" . $image_path)) {
//                   // unlink("assets/uploads/gallery_images/" . $image_path);
//                }
//                if (file_exists("assets/uploads/gallery_images/thumb/" . $image_path)) {
//                  //  unlink("assets/uploads/gallery_images/thumb/" . $image_path);
//                }
             echo $this->theme->message(lang('image-delete-success'), 'success');
//            }
        } else {
            echo $this->theme->message(lang('invalid-id-msg'), 'error');
        }
    }

}
