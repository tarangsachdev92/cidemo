<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Sample Admin Controller
 *
 *  An example class with few methods to show how controller can be created
 * 
 * @package CIDemoApplication
 * @subpackage Sample
 * @copyright	(c) 2013, TatvaSoft
 * @author Amit Patel <amit.patel@sparsh.com>
 */
class sample_admin extends Base_Admin_Controller
{
    /**
     * 	Create an instance
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('default_model');
        $this->lang->load('sample');
        
        // Login check for admin
        $this->access_control($this->access_rules());
    }
    
    /**
     * function accessRules to check page access     
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('index', 'test', 'default_pagination', 'get_pagination', 'ajax_pagination', 'jqgrid', 'jqgrid_show'),
                'users' => array('@'),
            )
        );
    }

    /**
     * Default Method: index
     * Displays a list of data.
     */
    public function index()
    {
        // Initialise variables
        $data = array();
        $data['section_name'] = $this->section_name;
        $data['base_val'] = $this->base_val;
        //$data['base_admin_val'] = $this->base_admin_val;

        $this->sample_model->id = 1;
        $records = $this->sample_model->get_sample_detail_by_id();
        $data['records'] = $records;

        $records_default = $this->default_model->default_test("1");
        $data['records_default'] = $records_default;

        $records_test = $this->sample_model->sample_test_by_id('2');
        $data['records_test'] = $records_test;
        $data['random'] = rand();
        $data['customscript'] = "<script>window.alert('this is a test message');</script>";
        //load view and pass data array to view file
        $this->theme->view($data, 'sample_admin_content');
    }

    /*
     * Method: test
     * 
     * @param string $val argument for $val
     * @param string $val2 argument for $val2
     * @param string $val3 argument for $val3
     * 
     */
    public function test($val = null, $val2 = null, $val3 = null)
    {

        $data = array();

        $data['base_val'] = $this->base_val;
        $data['base_admin_val'] = $this->base_admin_val;

        $records = $this->sample_model->get_sample_detail_by_id("1");
        $data['records'] = $records;

        $records_default = $this->default_model->default_test("1");
        $data['records_default'] = $records_default;

        $records_test = $this->sample_model->sample_test_by_id("2");
        $data['records_test'] = $records_test;

        $data['random'] = rand();
        $data['records'] = 'this is a test <pre>' . print_r($val, true) . "<br />" . print_r($val2, true) . "<br />" . print_r($val3, true) . "</pre>";
        $this->theme->view('sample_admin_content', $data);
    }

    public function default_pagination($page_number = 1)
    {
        $offset = get_offset($page_number, $this->record_per_page);

        $this->sample_model->record_per_page = $this->record_per_page;
        $this->sample_model->offset = $offset;
        $sample = $this->sample_model->get_all_data();
        $this->sample_model->_record_count = true;
        $data = array(
            'sample' => $sample,
            'page_number' => $page_number,
            'total_records' => $this->sample_model->get_all_data()
        );
        $this->theme->set('page_title', lang('sample-management'));
        $this->theme->view($data, 'default_pagination');
    }

    public function get_pagination()
    {

        $offset = get_offset($this->page_number, $this->record_per_page);

        $this->sample_model->record_per_page = $this->record_per_page;
        $this->sample_model->offset = $offset;
        $results = $this->sample_model->get_all_data();
        $this->sample_model->_record_count = true;
        // $urls = $results->result_array();
        // Pass data to view file     
        $data = array(
            'sample' => $results,
            'page_number' => $this->page_number,
            'total_records' => $this->sample_model->get_all_data()
        );

        //Create page-title
        $this->theme->set('page_title', lang('sample-management'));

        //Render view
        $this->theme->view($data, 'get_pagination');
    }

    public function ajax_pagination()
    {
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->sample_model->record_per_page = $this->record_per_page;
        $this->sample_model->offset = $offset;



        //get url listing records
        $sample = $this->sample_model->get_all_data();
        $this->sample_model->_record_count = true;
        // Pass data to view file     
        $data = array(
            'sample' => $sample,
            'page_number' => $this->page_number,
            'total_records' => $this->sample_model->get_all_data()
        );

        //Create page-title
        $this->theme->set('page_title', lang('sample-management'));

        //Render view
        $this->theme->view($data, 'ajax_pagiantion');
    }

    public function jqgrid()
    {        
        $data = array();
        $this->theme->view($data);
        
    }
    
    public function jqgrid_show()
    {        
        try
        {            
            $response = $this->sample_model->get_grid_data($_REQUEST);            
            header('Content-type: application/json');
            echo json_encode($response);
        }
        catch (Exception $e)
        {
            $this->handle_controller_exception($e);
        }
    }

}

?>