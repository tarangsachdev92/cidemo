
<?php

/**
 * Description of maps
 * Testimonial widget to get random testimonials
 * @author P 
 */
class testimonial_random extends widgets {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('testimonial/testimonial_model');
    }

    function run($data_input = array()) {      
        // get testimonials
        $data['language_code'] = $data_input['language_code'];
        $data['records_rand']=$this->testimonial_model->get_random_record_listing($data_input['language_id']); 
        return $this->build('testimonial_random_view', $data);
        
    }

}