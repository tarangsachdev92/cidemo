
<?php

/**
 * Description of maps
 * Advertisement widget to get advertise according to pages and location
 * @author HP
 * @property Advertise 
 */
class advertisement extends widgets {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('banner/banner_model');
    }

    function run($data_input = array()) {
        //get advertisements based on params

        //initialization
        $this->banner_model->ip=$_SERVER['REMOTE_ADDR'];
//        $this->banner_model->ip='15.255.255.255';
        $this->banner_model->location_eng=$this->banner_model->get_location_ip();

        //logic
        if(!empty ($this->banner_model->location_eng))
        {
        $location=$this->banner_model->get_location_lang();
        }
       // var_dump($location);exit;
        $this->banner_model->country_id=$location[0]['c']['country_id'];
        $this->banner_model->state_id=$location[0]['s']['state_id'];
        $this->banner_model->city_id=$location[0]['ct']['city_id'];
        $this->banner_model->page_id=$data_input['page_id'];
        $this->banner_model->position=$data_input['position'];
        // get advertises
        $data['results']=$this->banner_model->get_advertise($data_input['language_id']);
        return $this->build('advertisement_view', $data);
        
    }

}