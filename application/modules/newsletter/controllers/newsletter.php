<?php
if (!defined ('BASEPATH')) exit ('No direct script access allowed');
/**
 *  NEWSLETTER Controller
 *
 *   
 * @package CIDemoApplication
 *  
 * @copyright	(c) 2013, TatvaSoft
 * @author NIPT
 */
class Newsletter extends Base_Front_Controller
{
    /*
     * Create a Instance
     */
    function __construct ()
    {
        parent::__construct ();
        //load helpers
        $this->load->helper (array ('url'));
        $this->load->library ('form_validation');
        $this->load->library ('email');
        $this->access_control ($this->access_rules ());
    }
    /*
     * access_rules() - this function is used for access control
     * based on login
     * * - all can access ['users' => array('*')]
     * @ - logged person can access ['users' => array('@')]
     */

    private function access_rules ()
    {
        return array (
            array (
                'actions' => array ('index', 'check_unique_email', 'ajax_check_unique_email', 'unsubscribe'),
                'users' => array ('*')
            )
        );
    }
    /*
     * Function Index  for newsletter index page in front side
     */

    public function index ()
    {
        $result = "";
        if ($this->input->post ("newsletterSubmit")) {
            $data = array (
                "firstname" => $this->input->post ("firstname"),
                "lastname" => $this->input->post ("lastname"),
                "email" => $this->input->post ("email")
            );
            $this->form_validation->set_rules ('firstname', 'First Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules ('lastname', 'Last Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules ('email', 'Email', 'trim|required|valid_email|callback_check_unique_email|xss_clean');
            if ($this->form_validation->run ($this) == TRUE) {
                $user_exist = $this->newsletter_model->check_user_deleted ($data['email']);
                if (empty ($user_exist)) {
                    $result = $this->newsletter_model->save_subscribers ($data);
                    $this->newsletter_model->send_email ($data);
                    $this->theme->set_message (lang ('thank_you_for_subscribing'), 'success');
                } else {
                    $result = $this->newsletter_model->subscribers_user_again ($data['email']);
                    $this->newsletter_model->send_email ($data);
                    $this->theme->set_message (lang ('thank_you_for_subscribing'), 'success');
                }
            }
        } else {
            $data = array (
                "firstname" => "",
                "lastname" => "",
                "email" => ""
            );
        }
        $this->theme->view ($data, "index");
    }
    /*
     * function for check unique email
     */

    public function check_unique_email ()
    {
        $data = $this->input->post ();
        $result = $this->newsletter_model->check_unique_mail ($data);
        if ($result > 0) {
            $this->form_validation->set_message ('check_unique_email', lang ('user_already_exists'));
            return false;
        } else {
            return true;
        }
    }
    /*
     * function for check unique email
     */

    public function ajax_check_unique_email ()
    {
        $data = $this->input->post ();
        $result = $this->newsletter_model->check_unique_mail ($data);
        if ($result > 0) {
            echo $this->theme->message (lang ('user_already_exists'), 'error');
        }
    }
    /*
     * Unsubscribe the user from newsletter
     */

    public function unsubscribe ()
    {
        $id = intval ($this->uri->segment (3));
        if ($this->newsletter_model->unsubscribe_user ($id)) {
            $this->theme->set_message ('you_are_successfully_unsubscribed', 'success');
            $this->theme->view ();
        } else {
            $this->theme->set_message (lang ('something_wrong'), 'error');
            $this->theme->view ();
        }
    }
}
?>