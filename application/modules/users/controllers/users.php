<?php

/**
 *  User Controller (Front)
 *
 *  To perform login,registration and forgot password process.
 *
 * @package CIDemoApplication
 * @subpackage Users
 * @copyright	(c) 2013, TatvaSoft
 * @author panks
 */
class Users extends Base_Front_Controller {

    function __construct() {
        parent::__construct();
        //load helpers
        $this->load->helper(array('url', 'cookie', 'captcha'));
        $this->load->library('form_validation');
        $this->access_control($this->access_rules());
        $this->load->model('users_profile_model');
    }

    /**
     * Function access_rules to check login
     */
    private function access_rules() {
        return array(
            array(
                'actions' => array('action', 'index', 'login', 'registration', 'send_email', 'user_validation_rules', 'activation', 'recaptcha', 'forgot_password', 'regenerate_activation_link', 'logout', 'profile'),
                'users' => array('*'),
            ),
            array(
                'actions' => array('change_password', 'profile'),
                'users' => array('@'),
            )
        );
    }

    /*
     *  Function index for login
     */

    function index() {
        $this->login();
    }

    /*
     *  Function login for check front login
     */

    function login() {

        if (isset($this->session->userdata[$this->section_name]['user_id'])) {
            redirect("/");
        }
        //Initializing
        $data = $this->input->post();

        if (!empty($data) && $this->input->post('Login')) {
            //form validation
            $email = trim(strip_tags($data['email_w']));
            $password = trim(strip_tags($data['password_w']));

            $this->form_validation->set_rules('email_w', lang('email'), 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('password_w', lang('password'), 'trim|required|xss_clean');

            //Variable Assignment
            //Logic
            if ($this->form_validation->run() == TRUE) {
                $result = $this->users_model->check_front_login($email, $password);
                if (!empty($result)) {
                    if ($result[0]['u']['status'] == 1) {
                        $data['user_id'] = $result[0]['u']['id'];
                        $data['role_id'] = $result[0]['u']['role_id'];
                        $data['email'] = $result[0]['u']['email'];
                        $data['firstname'] = $result[0]['u']['firstname'];
                        $data['lastname'] = $result[0]['u']['lastname'];
                        $data['logged_in'] = TRUE;

                        $this->allowed_permission_list($data['role_id']);

                        $this->session->set_custom_userdata($this->section_name, $data);

                        //Update last login entry
                        $this->users_model->update_last_login($result[0]['u']['id']);

                        redirect('/');
                    } else {
                        $this->theme->set_message(lang('inactive-account-msg'), "error");
                    }
                } else {
                    $this->theme->set_message(lang('invalid-email-password'), "error");
                }
            }
        }

        //Render view
        $this->theme->view($data, 'login');
    }

    /*
     *  Function logout to destroy all front session data
     */

    function logout() {
        $this->session->unset_userdata($this->section_name);
        redirect('/');
        exit;
    }

    /*
     *  Function registration for front registration
     */

    public function registration() {
        $CI = & get_instance();
        //Variable Assignment
        $firstname = "";
        $lastname = "";
        $email = "";
        $password = "";
        $passconf = "";
        $status = "";
        $address = "";
        $role_id = "";

        if (!$this->input->post('mysubmit'))
            $captcha = $this->my_captcha->deleteImage()->createWord()->createCaptcha();


        //If form submit
        if ($this->input->post('mysubmit')) {
            $post = $this->input->post();
            $default_role = $this->users_model->get_default_role();

            //Variable Assignment
            $id = intval($post['id']);
            $firstname = trim(strip_tags($post['firstname']));
            $lastname = trim(strip_tags($post['lastname']));
            $email = trim(strip_tags($post['email']));
            $password = trim(strip_tags($post['password']));
            $passconf = trim(strip_tags($post['passconf']));
            $address = trim(strip_tags($post['address']));
            $gender = trim(strip_tags($post['gender']));
            $address = trim(strip_tags($post['address']));
            $role_id = intval($default_role['id']);
            $status = 0;

            if (isset($post['hobbies'])) {
                $hobbies = $post['hobbies'];
                if (!empty($hobbies))
                    $data['hobbies'] = implode(",", $hobbies);
                else
                    $data['hobbies'] = "";

                $hobbies = $data['hobbies'];
            }else {
                $hobbies = "";
            }

            $data_array['id'] = $id;
            $data_array['firstname'] = $firstname;
            $data_array['lastname'] = $lastname;
            $data_array['email'] = $email;
            if ($id == 0) {
                $data_array['password'] = encriptsha1($password);
            }
            $data_array['role_id'] = $role_id;
            $data_array['activation_code'] = get_random_string();
            $data_array['status'] = $status;
            $data_array['activation_expiry'] = date('Y:m:d H:i:s', strtotime('+1 day', now()));

            $data_profile['address'] = $address;
            $data_profile['gender'] = $gender;
            $data_profile['hobbies'] = $hobbies;

            // field name, error message, validation rules
            $this->user_validation_rules();
            if ($this->form_validation->run($this) == TRUE) {
                $this->users_model->save_user($data_array, $data_profile);
                $flag = $this->send_email($data_array, 'registration_template');
				if($flag)
				{
					$this->theme->set_message(lang('registration-success-msg'), 'success');
				}
				else
				{
					$this->theme->set_message(lang('email-template-inactive'), 'info');
				}
                redirect(base_url() . "users");
            } else {
                $captcha = $this->my_captcha->deleteImage()->createWord()->createCaptcha();
            }
        }

        //Pass data to view file
        $data['firstname'] = $firstname;
        $data['lastname'] = $lastname;
        $data['email'] = $email;
        $data['password'] = $password;
        $data['passconf'] = $passconf;
        $data['role_id'] = $role_id;
        $data['address'] = $address;
        $data['status'] = $status;
        $data['captcha'] = $captcha;
        $data['ci'] = $CI;

        //echo $captcha; exit;
        //Render view
        $this->theme->view($data);
    }

    /*
     *  Function registration for edit profile in front
     */

    public function profile() {



        $CI = & get_instance();
        $id = $this->session->userdata[$this->section_name]['user_id'];

        if (!empty($id)) {

            $result = $this->users_model->get_user_detail($id);

            if(!empty($result) && $result['status'] == 1)
            {
                //Variable Assignment
                $firstname = $result['firstname'];
                $lastname = $result['lastname'];
                $email = $result['email'];
                $status = $result['status'];
                $address = isset($result['address'])?$result['address']:'';
                $role_id = $result['role_id'];
                $hobbies = isset($result['hobbies'])?$result['hobbies']:'';
                $gender = isset($result['gender'])?$result['gender']:'M';

                //echo $result['gender'];exit;
                //var_dump($result); exit;

                if (!$this->input->post('mysubmit'))
                    $captcha = $this->my_captcha->deleteImage()->createWord()->createCaptcha();


                //If form submit
                if ($this->input->post('mysubmit'))
                {
                    $post = $this->input->post();

                    //$default_role = $this->users_model->get_default_role();

                    //Variable Assignment
                    //$id = intval($post['id']);
                    $id = $this->session->userdata[$this->section_name]['user_id'];
                    $firstname = trim(strip_tags($post['firstname']));
                    $lastname = trim(strip_tags($post['lastname']));
                    $email = trim(strip_tags($post['email']));
                    $address = trim(strip_tags($post['address']));
                    $gender = trim(strip_tags($post['gender']));

                    $address = trim(strip_tags($post['address']));
                    $role_id = $post['role_id'];

                    $status = 1;

                    if (isset($post['hobbies']))
                    {
                        $hobbies = $post['hobbies'];

                        if (!empty($hobbies))
                            $data['hobbies'] = implode(",", $hobbies);
                        else
                            $data['hobbies'] = "";

                        $hobbies = $data['hobbies'];
                    }
                    else
                    {
                        $hobbies = "";
                    }

                    $data_array['id'] = $id;
                    $data_array['firstname'] = $firstname;
                    $data_array['lastname'] = $lastname;
                    $data_array['email'] = $email;
                    $data_array['role_id'] = $role_id;
                    $data_array['status'] = $status;
                    $data_profile['address'] = $address;
                    $data_profile['gender'] = $gender;
                    $data_profile['hobbies'] = $hobbies;

                    // field name, error message, validation rules
                    $this->profile_validation_rules();
                    if ($this->form_validation->run($this) == TRUE)
                    {
                        //echo "IN"; exit;
                        $this->users_model->save_profile($data_array, $data_profile);
                        $this->theme->set_message(lang('edit-profile-success'), 'success');
                        redirect(base_url() . "users/profile");
                    }
                    else
                    {
                        $captcha = $this->my_captcha->deleteImage()->createWord()->createCaptcha();
                    }
                }

                //Pass data to view file
                $data['firstname'] = $firstname;
                $data['lastname'] = $lastname;
                $data['gender'] = $gender;
                $data['email'] = $email;
                $data['role_id'] = $role_id;
                $data['address'] = $address;
                $data['status'] = $status;
                $data['hobbies'] = $hobbies;
                $data['captcha'] = $captcha;
                $data['ci'] = $CI;
                $data['id'] = $id;

                //echo $captcha; exit;
                //Render view
                $this->theme->view($data);
            }
            else
            {
                $this->session->unset_userdata($this->section_name);
                $this->theme->set_message(lang('inactive-account-msg'), "error");
                redirect(site_url().'users/login');
            }
        }
        else
        {
            $this->theme->set_message(lang('do-login-msg-edit-profile'), 'info');
            redirect(site_url().'users/login');
        }
    }

    /**
     * Function send email to user
     * @params $data for sending email
     */
    public function send_email($data = array(), $template = NULL) {

        $this->load->library('mailer');
        $this->mailer->mail->SetFrom("mehul.panchal@tatvasoft.com", SITE_NAME);
        $this->mailer->mail->IsHTML(true);

        $firstname = isset($data['firstname'])?$data['firstname']:'';
        $lastname = isset($data['lastname'])?$data['lastname']:'';
        $activation_code = isset($data['activation_code'])?$data['activation_code']:'';
        $password = isset($data['password'])?$data['password']:'';

        $mail_vars = array(
                  'USERNAME' => $data['email'],
                  'name' => $firstname. ' ' .$lastname,
                  'activation_link' => base_url() . 'users/activation/' . $activation_code,
                  'SITE_NAME' => SITE_NAME,
                  'YEAR' => date('Y'),
                  'logopath' => site_base_url() . 'themes/default/images/logo.jpg',
                  'PASSWORD' => $password
              );

        $body = get_template_body($this, $template, $mail_vars, $this->session->userdata[$this->section_name]['site_lang_id']);
        $subject = get_template_subject($this, $template);

		if(trim($body)=="")
		{
			 return false;
		}
		else
		{
			try
            {
				$this->mailer->sendmail(
						$data['email'], $data['firstname'] . " " . $data['lastname'], $subject, $body
				);
			}
            catch (phpmailerException $e)
            {
				echo $e->errorMessage();
				exit;
			}
			return true;
		}
    }

    /*
     *  Function user_validation_rules to validate user registration form
     */

    function user_validation_rules() {
        //Type casting
        $id = intval($this->input->post('id'));

        //Validation rules
        $this->form_validation->set_rules('firstname', lang('first-name'), 'trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('lastname', lang('last-name'), 'trim|required|min_length[2]|xss_clean');
        //is_unique[users.email.id.' . $id . ']
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|callback_check_unique_email|xss_clean');
        if (CAPTCHA_SETTING)
            $this->form_validation->set_rules('captcha', 'Captcha', 'required|xss_clean|validate_captcha[' . $this->input->post("captcha") . ']');
        if ($id == 0 || $id == "") {
            $this->form_validation->set_rules('password', lang('password'), 'trim|required|xss_clean|min_length[4]|max_length[40]');
            $this->form_validation->set_rules('passconf', lang('c-password'), 'trim|required|xss_clean|matches[password]');
        }
    }

    function profile_validation_rules() {
        //Type casting
        //$id = intval($this->input->post('id'));

        //$id = $this->session->userdata[$this->section_name]['user_id'];

        $id = intval($this->input->post('id'));

        //Validation rules
        $this->form_validation->set_rules('firstname', lang('first-name'), 'trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('lastname', lang('last-name'), 'trim|required|min_length[2]|xss_clean');
        //is_unique[users.email.id.' . $id . ']
//        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|is_unique[users.email.id.' . $id . ']|xss_clean');

        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|callback_check_unique_email|xss_clean');
        //if (CAPTCHA_SETTING)
           // $this->form_validation->set_rules('captcha', 'Captcha', 'required|xss_clean|validate_captcha[' . $this->input->post("captcha") . ']');
    }

    /*
     *  Function for activate user account
     */

    function activation($activation_key) {
        //Type casting
        $activation_key = strip_tags($activation_key);

        //Model function call
        $flag = $this->users_model->activation($activation_key);

        if ($flag == 1) {
            $this->theme->set_message(lang('account-activation-msg'), 'success');
        } elseif ($flag == 2) {
            $this->theme->set_message(lang('activation_expiry-msg') . '<a href="' . base_url() . 'users/regenerate_activation_link/' . $activation_key . '">' . lang('regenerate_avtivation_link') . '</a>', 'error');
        } else {
            $this->theme->set_message(lang('account-already-activated-msg'), 'error');
        }
        //Success message

        redirect(site_url().'users');
        exit;
    }

    /*
     *  Function for change password
     */

    function change_password()
    {
        //Type casting
        $user_id = intval($this->session->userdata[$this->section_name]['user_id']);

        $result = $this->users_model->get_user_detail($user_id);

        if(!empty($result) && $result['status'] == 1)
        {
            //Initializing
            $data = array();
            $current_password = "";

            $this->theme->set('current_password', $current_password);

            //Logic
            if (isset($user_id) && $user_id != "" && $user_id != 0)
            {
                if ($this->input->post('Submit'))
                {
                    //Variable assignment
                    $password = trim(strip_tags($this->input->post('password')));
                    $current_password = $this->input->post('current_password');
                    $this->theme->set('current_password', $current_password);

                    //Validation rules
                    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[40]|xss_clean');
                    $this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required|matches[password]|xss_clean');

                    if ($this->form_validation->run() == TRUE)
                    {
                        $user_data = $this->users_model->get_user_detail($user_id);
                        $current_password = encriptsha1($this->input->post('current_password'));

                        if ($current_password == $user_data['password'])
                        {
                            $this->users_model->changepassword($user_id, $password);
                            $this->theme->set_message(lang('change-password-success'), 'success');
                            redirect(site_url() . 'users/change_password');
                        }
                        else
                        {
                            $this->theme->set_message(lang('does-not-match-currentpassword'), 'error');
                            redirect(site_url() . 'users/change_password');
                        }
                    }
                }
            }
            else
            {
                $this->theme->set_message(lang('do-login-msg-change-password'), 'info');
                redirect(site_url() . 'admin/users/login');
            }

            //Create page-title
            $this->theme->set('page_title', lang('change-password'));

            //Render view
            $this->theme->view($data);
        }
        else
        {
              $this->session->unset_userdata($this->section_name);
              $this->theme->set_message(lang('inactive-account-msg'), "error");
              redirect(site_url().'users/login');
        }
    }

    /*
     *  Function for forgot password
     */

    function forgot_password() {


        //Initializing
        $data = array();

        //If form submit
        if ($this->input->post('Submit')) {
            //Set validation rules
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            //Logic
            if ($this->form_validation->run() == TRUE) {
                $data['email'] = trim(strip_tags($this->input->post("email")));
                // get userdetail
                $this->users_model->email_id = $data['email'];

                $result = $this->users_model->get_user_detail_by_email($data['email']);

                if (!empty($result)) {
                    if ($result[0]['u']['status'] == '1') {
                        $random_string = get_random_string();
                        $data['password'] = encriptsha1($random_string);

                        // send email for regerate password
                        $this->users_model->forgot_password($data);

                        $forgot_array['email'] = $data['email'];
                        $forgot_array['password'] = $random_string;
                        $this->send_email($forgot_array, 'forgot_password_email_template');

                        $this->theme->set_message(lang('forgot-success-msg'), 'success');
                        //echo "Here1"; exit;
                        redirect(site_url() . 'users/login');
                    } else {
                        // For deleted & inactive group checking
                        $this->theme->set_message(lang('inactive-account-msg'), 'error');
                        redirect(site_url() . 'users/forgot_password');
                    }
                } else {
                    $this->theme->set_message(lang('forgot-error-msg'), 'error');
                    redirect(site_url() . 'users/forgot_password');
                }
            }
        }
        //Create page-title
        $this->theme->set('page_title', lang('forgot_password'));

        //Render view
        $this->theme->view($data);
    }

    /*
     * function for regenerate captcha
     */

    function recaptcha() {

        $data['captcha'] = $this->my_captcha->deleteImage()->createWord()->createCaptcha();
        echo $data['captcha'];
        exit;
    }

    /*
     * function for check unique email
     */

    public function check_unique_email() {
        $data = $this->input->post();
        $result = $this->users_model->check_unique_mail($data);
        if ($result > 0) {
            $this->form_validation->set_message('check_unique_email', lang('msg-alvailable-email'));
            return false;
        } else {
            return true;
        }
    }

    /*
     * function for regenerate avtivation link
     */

    public function regenerate_activation_link($activation_key) {
        //echo $activation_key;exit;
        $activation_code = $this->users_model->update_activation_key($activation_key);
        $userdata = $this->users_model->get_user_data_by_activation_key($activation_code);
        $this->send_email($userdata, 'registration_template');
        $this->theme->set_message(lang('account-activation-msg'), 'success');

        redirect(site_url().'users/login');
        exit;
    }

}