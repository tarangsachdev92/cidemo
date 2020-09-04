<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Base_Front_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function Welcome() {		
        parent::__construct(); 	
	}
	 
	public function index()
	{
		echo "Front Section<br />";				
		echo "<pre />";
		echo "Master val = ".$this->master_val."<br />";
		echo "Base val = ".$this->base_val."<br />";		
		echo "Base Front val = ".$this->base_front_val."<br />";
		echo "<br /><br />";
		
		$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */