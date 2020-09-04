<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *  Sample Front Controller
 *
 *  An example class with few methods to show how controller can be created
 * 
 * @package CIDemoApplication
 * @subpackage Sample  
 * @copyright	(c) 2013, TatvaSoft
 * @author Amit Patel <amit.patel@sparsh.com>
 */
class sample extends Base_Front_Controller {

    /**
     * 	Create an instance
     * 
     */
    public function __construct() {
	parent::__construct();
	$this->access_control($this->access_rules());
    }

    /**
     * Default Method: index
     * Displays a list of data.
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('index','ajax_pagination','default_pagination','get_pagination'),
                'users' => array('*'),
            ),
            array(
                'actions' => array(''),
                'users' => array('@'),
            )
        );
    }
    public function index() {
	// Initialise variables
	$data = array();
	$data['section_name'] = $this->section_name;
	$data['base_val'] = $this->base_val;
	$data['base_front_val'] = $this->base_front_val;
        
	$records = $this->sample_model->sample_test_by_id('1');
	$data['records'] = $records;

	//load view and pass data array to view file
	$this->theme->view($data,'sample_content');
        
	//$records = $this->sample_model->get_base_model_variable_val();		
    }

    /**
     * Check whether input is integer or not
     * @param integer $id
     */
    public function test_input_integer($id = 0) {
	$type_check = custom_filter_input('integer', $id);
	$data = array('type_check'=>$type_check);
	$this->theme->view($data,'test_input');
    }

    /**
     * Check whether input is valid ip address
     * @param string $ip
     */
    public function test_input_ip($ip) {
	$type_check = custom_filter_input('ip', $ip);
	$data = array('type_check'=>$type_check);
	$this->theme->view($data,'test_input');
    }

    /**
     * Check whether input is valid float
     * @param float $float
     */
    public function test_input_float($float) {
	$type_check = custom_filter_input('float', $float);
	$data = array('type_check'=>$type_check);
	$this->theme->view($data,'test_input');
    }
    
//    public function methods(){
//	$array = get_class_methods($this);
//	pre($array);
//    }
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
           $this->theme->view($data, 'front_ajax_pagiantion');
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
        $this->theme->view($data, 'front_default_pagination');
    }

    public function get_pagination($page_number = 1)
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
        $this->theme->view($data, 'front_get_pagination');
    }
}

?>