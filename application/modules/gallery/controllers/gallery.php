<?php

/**
 *  User Controller (Front)
 *
 *  To perform login,registration and forgot password process.
 * 
 * @package CIDemoApplication
 * @subpackage Gallery
 * @copyright	(c) 2013, TatvaSoft
 */
class Gallery extends Base_Front_Controller
{
    function __construct()
    {
        parent::__construct();
        //load helpers
        $this->load->helper(array('url', 'cookie'));
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->access_control($this->access_rules());
    }

    /**
     * Function access_rules to check login
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('action', 'index', 'index1', 'index2', 'gallery_images' ),
                'users' => array('*'),
            ),
            array(
                'actions' => array('logout', 'change_password'),
                'users' => array('@'),
            )
        );
    }

    /*
     *  Function index for main gallery listing
     */
    function index()
    {
        //Initialization
        $images_name_array = array();
        $images_name = array();
        
        //Load data for url listing
        $galleries = $this->gallery_model->get_gallery_listing();
        $images = $this->gallery_model->get_images_listing();
        
        //Logic
        if(!empty($galleries)){
            foreach ($galleries as $_galleries){
                $images_name = $this->gallery_model->get_images_listing_by_gallery_id($_galleries['G']['category_id']);
                if(!empty($images_name)){
                    $images_name_array[] = $images_name[0]['I']['image'];
                }
            }        
        }

        // Pass data to view file
        $data['galleries']              = $galleries;
        $data['images']                 = $images;
        $data['images_name_array']      = $images_name_array;

        //Render view
        $this->theme->view($data);

    }

    /*
     *  Function gallery_images to get images which are in particular gallery
     */
    function gallery_images($slug_url)
    {
        //Initialization
        $images_name = array();
        
        //Logic
        $category_id = $this->gallery_model->get_category_id_from_slug_url($slug_url);
        $images_name = $this->gallery_model->get_images_listing_by_gallery_id($category_id);
        
        //Pass data to view file        
        $data['images_name']      = $images_name;

        //Render view
        $this->theme->view($data);
    }
}