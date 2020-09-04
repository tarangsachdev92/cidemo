<?php

/**
 *  Users Admin Controller
 *
 *  To perform user management.
 *
 * @package CIDemoApplication
 * @subpackage Users
 * @copyright	(c) 2013, TatvaSoft
 * @author panks
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_admin extends Base_Admin_Controller {

    var $search_term;

    function __construct() {


        parent::__construct();

        $this->load->library('form_validation');
        $this->breadcrumb->add(lang('user-management'), base_url() . $this->section_name . '/users');
        $this->load->model('users_profile_model');
        // Login check for admin
        $this->access_control($this->access_rules());
        $this->language = $this->uri->segment(4);
        $this->load->library('unit_test');
    }

    /**
     * Function access_rules to check login
     */
    public function access_rules() {

        return array(
            array(
                'actions' => array('index', 'changepassword', 'action', 'delete', 'check_unique_email', 'save', 'view_data'),
                'users' => array('@'),
            ),
            array(
                'actions' => array('login', 'logout', 'insert_data'),
                'users' => array('*'),
            )
        );
    }

    /**
     * Function index to view listing of users
     */
    function index() {
        
        //Paging parameters
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->users_model->record_per_page = $this->record_per_page;
        $this->users_model->offset = $offset;


        //set sort/search parameters in pagging
        if ($this->input->post()) {

            $data = $this->input->post();

            // Search Term ***
            if (isset($data['search_term']) && !empty($data['search_term'])) {
                $this->users_model->search_term = trim($data['search_term']);
                $this->session->set_custom_userdata($this->section_name, "user_search_term", $this->input->post('search_term'));
            } else {
                $this->session->set_custom_userdata($this->section_name, "user_search_term", "");
            }
            // Search Term ***


            // Sort Order ***
            if (isset($data['sort_by']) && $data['sort_order']) {
                $this->users_model->sort_by = $data['sort_by'];
                $this->users_model->sort_order = $data['sort_order'];
                $this->session->set_custom_userdata($this->section_name, "user_sort_by", $this->input->post('sort_by'));
                $this->session->set_custom_userdata($this->section_name, "user_sort_order", $this->input->post('sort_order'));
            } else {
                $this->session->set_custom_userdata($this->section_name, "user_sort_by", "");
                $this->session->set_custom_userdata($this->section_name, "user_sort_order", "");
            }
            // Sort Order ***


            if (isset($data['type']) && $data['type'] == 'delete') {

                // Newly added
                $tempArr = array();
                foreach ($data['ids'] as $key => $val) {
                    $tempArr[] = base64_decode($val);
                }
                // Newly added
                //if($this->users_model->delete_records($data['ids']))
                if ($this->users_model->delete_records($tempArr)) {
                    echo $this->theme->message(lang('user-delete-success'), 'success');
                    exit;
                }
            }

            if (isset($data['type']) && $data['type'] == 'active') {
                // Newly added
                $tempArr = array();
                foreach ($data['ids'] as $key => $val) {
                    $tempArr[] = base64_decode($val);
                }
                // Newly added
                if ($this->users_model->active_records($tempArr)) {
                    echo $this->theme->message(lang('user-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive') {
                // Newly added
                $tempArr = array();
                foreach ($data['ids'] as $key => $val) {
                    $tempArr[] = base64_decode($val);
                }
                // Newly added
                if ($this->users_model->inactive_records($tempArr)) {
                    echo $this->theme->message(lang('user-inactive-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'active_all') {

                if ($this->users_model->active_all_records()) {
                    echo $this->theme->message(lang('user-active-success'), 'success');
                    exit;
                }
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all') {
                if ($this->users_model->inactive_all_records()) {
                    echo $this->theme->message(lang('user-inactive-success'), 'success');
                    exit;
                }
            }
        }





        if (!empty($this->session->userdata[$this->section_name]['user_search_term'])) {
            $this->users_model->search_term = trim($this->session->userdata[$this->section_name]['user_search_term']);
        }
        if (!empty($this->session->userdata[$this->section_name]['user_sort_by'])) {
            $this->users_model->sort_by = $this->session->userdata[$this->section_name]['user_sort_by'];
        }
        if (!empty($this->session->userdata[$this->section_name]['user_sort_order'])) {
            $this->users_model->sort_order = $this->session->userdata[$this->section_name]['user_sort_order'];
        }







        //Load data for url listing
        $users = $this->users_model->get_user_listing();
        $this->users_model->_record_count = true;
        $total_records = $this->users_model->get_user_listing();
        // Pass data to view file
        $this->search_term = $this->users_model->search_term;

        $data['users'] = $users;
        $data['page_number'] = $this->page_number;
        $data['total_records'] = $total_records;
        $data['search_term'] = $this->users_model->search_term;
        $data['sort_by'] = $this->users_model->sort_by;
        $data['sort_order'] = $this->users_model->sort_order;

        //Create page-title
        $this->theme->set('page_title', lang('user-management'));

        //Render view
        $this->theme->view($data);
    }

    /**
     * Function users_validation_rules to validate input
     */
    function users_validation_rules() {
        $this->form_validation->set_rules('firstname', lang('first-name'), 'trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('lastname', lang('last-name'), 'trim|required|min_length[2]|xss_clean');
        $id = intval($this->input->post('id'));
        $password = strip_tags($this->input->post('password'));
        $passconf = strip_tags($this->input->post('passconf'));

        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|callback_check_unique_email|xss_clean');

        if ($id == 0 || $id == "") {
            $this->form_validation->set_rules('password', lang('password'), 'trim|required|min_length[4]|max_length[50]|xss_clean');
            $this->form_validation->set_rules('passconf', lang('c-password'), 'trim|required|matches[password]|xss_clean');
        } elseif ($password != '' || $passconf != '') {
            $this->form_validation->set_rules('password', lang('password'), 'trim|required|min_length[4]|max_length[50]|xss_clean');
            $this->form_validation->set_rules('passconf', lang('c-password'), 'trim|required|matches[password]|xss_clean');
        }
    }

    /**
     * Function login to view login page
     */
    public function login() {
        //pr($this->input->get('back_url'));exit;
        $data = array();
        if ($this->input->get('back_url')) {
            $data['back_url'] = $this->input->get('back_url');
        }
        if ($this->is_login()) {
            //redirect($this->section_name.'/users/index');
            redirect($this->section_name.'/dashboard/');
            exit;
        }
        $loginuserdata = $this->session->all_userdata();
        if (isset($loginuserdata['user_id']) && $loginuserdata['user_id'] != "") {
            redirect($this->section_name . '/users');
        }
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email');
            $this->form_validation->set_rules('password', lang('password'), 'trim|required');
            $this->users_model->email = $this->input->post('email');
            $this->users_model->password = $this->input->post('password');
            $data['email'] = $this->input->post('email');
            if ($this->form_validation->run() == TRUE) {
                $result = $this->users_model->login();
                if (!empty($result)) {
                    if ($result[0]['u']['status'] == 1) {
                        //add all data to session
                        $newdata = array(
                            'user_id' => $result[0]['u']['id'],
                            'role_id' => $result[0]['u']['role_id'],
                            'email' => $result[0]['u']['email'],
                            'firstname' => $result[0]['u']['firstname'],
                            'lastname' => $result[0]['u']['lastname'],
                            'logged_in' => TRUE,
                        );
                        $this->session->set_custom_userdata($this->section_name, $newdata);

                        // Set permission in session
                        $this->allowed_permission_list($newdata['role_id']);
                        if ($result[0]['u']['id'] == '1') {
                            $this->session->set_custom_userdata($this->section_name, "super_user", "1");
                        }
                        //Update last login entry
                        $this->users_model->update_last_login($result[0]['u']['id']);
                        if ($this->input->post('back_url')) {
                            redirect($this->input->post('back_url'));
                        } else {
                            // redirect($this->section_name . '/users');
                            redirect($this->section_name . '/dashboard');
                        }
                    } else {
                        // For deleted & inactive group checking
                        $this->theme->set_message(lang('inactive-account-msg'), 'danger');

                        //redirect($this->section_name.'/users/login');
                        // exit;
                    }
                } else {
                    $this->theme->set_message(lang('invalid-email-password'), "danger");

                    //redirect($this->section_name.'/users/login');
                    //exit;
                }
            }
        }
        $this->theme->set_layout('layout');

        $this->theme->view($data);
    }

    /**
     * Function logout to do logout action
     */
    public function logout() {
        $this->session->unset_userdata($this->section_name);
        redirect($this->section_name . '/users/login');
        exit;
    }

    /**
     * Function changepassword to change password of user account
     */
    function changepassword() {
       
        $user_id = $this->session->userdata[$this->section_name]['user_id'];
        $password = trim(strip_tags($this->input->post('password')));
        if (isset($user_id) && $user_id != "" && $user_id != 0) {
            if ($this->input->post('Submit')) {
                $this->form_validation->set_rules('password', lang('password'), 'trim|required|min_length[4]|max_length[50]');
                $this->form_validation->set_rules('passconf', lang('c-password'), 'trim|required|matches[password]');
                if ($this->form_validation->run() == TRUE) {
                    $user_data = $this->users_model->get_user_detail($user_id);
                    $current_password = encriptsha1($this->input->post('current_password'));
                    if ($current_password == $user_data['password']) {
                        $this->users_model->changepassword($user_id, $password);
                        $this->theme->set_message(lang('change-password-success'), 'success');
                        redirect($this->section_name . '/users/changepassword');
                    } else {
                        $this->theme->set_message(lang('does-not-match-currentpassword'), 'danger');
                        redirect($this->section_name . '/users/changepassword');
                    }
                }
            }
        } else {
            $this->theme->set_message(lang('do-login-msg-change-password'), 'info');
            redirect($this->section_name . '/users/login');
        }

        // Breadcrumb settings
        $this->breadcrumb->add(lang('change-password'));

        $data = array();
        $data['cur_pass'] = $this->input->post('current_password');
        $this->theme->set('page_title', lang('change-password'));
        $this->theme->view($data);
    }

    /**
     * Function action to perform insert & update by action parameter
     * @param string $action default = 'add'
     * @param integer $id default = 0
     */
    function action($action = "add", $id = 0) {

        unlock_all($this, TBL_USERS);
        if ($this->check_permission()) {
            //Type Casting
            $id = intval($id);
            $action = trim(strip_tags($action));
            $type = custom_filter_input('integer', $id);

            //Variable Assignment
            $firstname = "";
            $lastname = "";
            $email = "";
            $password = "";
            $passconf = "";
            $status = "";
            $address = "";
            $gender = "";
            $hobbies = "";
            $role_id = "";

            //Logic
            switch ($action) {
                case 'add':
                    $data['user_id'] = "";
                    $role_list = $this->users_model->role_list();
                    break;
                case 'edit':
                    // Check for existing user ***
                    /*$this->db->where("id", $id);
                    $this->db->where("status", 1);
                    $user_exist = $this->db->get(TBL_USERS);

                    if (intval($user_exist->num_rows()) < 1) {
                        $this->theme->set_message(lang('user-not-exist'), 'error');
                        redirect($this->section_name . '/users');
                    } */
                    // Check for existing user ***
                    //Get user info by id
                    if ($id == 1 && $this->session->userdata[$this->section_name]['user_id'] != 1) {
                        $this->theme->set_message(lang('permission-not-allowed'), 'danger');
                        redirect($this->section_name . '/users');
                        exit;
                    }
                    $result = $this->users_model->get_user_detail($id);

                    $data['user_id'] = $result['id'];
                    if (!empty($result)) {
                        //Variable assignment for edit view
                        $firstname = $result['firstname'];
                        $lastname = $result['lastname'];
                        $email = $result['email'];
                        $password = '';
                        $passconf = '';
                        $status = isset($result['status']) ? $result['status'] : 1;
                        $address = isset($result['address']) ? $result['address'] : '';
                        $gender = isset($result['gender']) ? $result['gender'] : 'M';
                        $hobbies = isset($result['hobbies']) ? $result['hobbies'] : '';
                        $role_id = $result['role_id'];
                        $role_list = $this->users_model->role_list();

                        // lock record by passing ci object, table name and table id
                        $flag = lock_record($this, TBL_USERS, $id, $result['lock_user_id']);
                        if (!$flag) {
                            $this->theme->set_message(lang('record-already-locked'), 'danger');
                            redirect($this->section_name . '/users');
                        }
                        // end
                    } else {
                        //If user not exist then redirecting to listing page
                        $this->theme->set_message(lang('user-not-exist'), 'danger');
                        redirect($this->section_name . '/users');
                    }
                    break;
                default :
                    $this->theme->set_message(lang('action-not-allowed'), 'danger');
                    redirect($this->section_name . '/users');
                    break;
            }

            // Pass data to view file
            $data['id'] = $id;
            $data['action'] = $action;
            $data['firstname'] = $firstname;
            $data['lastname'] = $lastname;
            $data['email'] = $email;
            $data['password'] = $password;
            $data['passconf'] = $passconf;
            $data['status'] = $status;
            $data['gender'] = $gender;
            $data['hobbies'] = $hobbies;
            $data['address'] = $address;
            $data['role_id'] = $role_id;
            $data['role_list'] = $role_list;

            //create breadcrumbs & page-title
            if ($action == 'add') {
                $this->theme->set('page_title', lang('add-user'));
                $this->breadcrumb->add(lang('add-user'));
            } else {
                $this->theme->set('page_title', lang('edit-user'));
                $this->breadcrumb->add(lang('edit-user'));
            }

            //Render view
            $this->theme->view($data, 'admin_add');
        } else {
            $this->theme->set_message(lang('permission-not-allowed'), 'danger');
            redirect($this->section_name . '/users');
            exit;
        }
    }

    /**
     * Function save to insert/update user data
     */
    function save() {
        
        

        //set form validation to check server side validation
        $this->load->library('form_validation');

        if ($this->input->post('mysubmit')) {
            $data = $this->input->post();

            //Type Casting
            $id = intval($data['id']);
            
            echo $id;

            //Variable Assignment
            $hobbies = $this->input->post('hobbies');
            if (!empty($hobbies))
                $data['hobbies'] = implode(",", $hobbies);
            else
                $data['hobbies'] = "";

            $firstname = trim(strip_tags($data['firstname']));
            $lastname = trim(strip_tags($data['lastname']));
            $email = trim(strip_tags($data['email']));
            if ($id == 0) {
                $password = $data['password'];
                $passconf = $data['passconf'];
                $status = $data['status'];
            } elseif ($data['password'] != '' && $data['passconf'] != '') {
                $password = $data['password'];
                $passconf = $data['passconf'];
                $status = $data['status'];
            } else {
                $password = '';
                $passconf = '';
                $status = $data['status'];
            }
            $address = trim(strip_tags($data['address']));
            $role_id = intval($data['role_id']);

            if ($id == 1)
                $role_id = 1;

            $gender = trim(strip_tags($data['gender']));
            $hobbies = $data['hobbies'];

            // field name, error message, validation rules
            $this->users_validation_rules();


            if ($this->form_validation->run($this)) {
                $data_array['id'] = $id;
                $data_array['firstname'] = $firstname;
                $data_array['lastname'] = $lastname;
                $data_array['email'] = $email;
                if ($id == 0) {
                    $data_array['password'] = encriptsha1($password);
                } elseif ($password != '' && $passconf != '') {
                    $data_array['password'] = encriptsha1($password);
                }
                $data_array['role_id'] = $role_id;
                $data_array['status'] = $status;

                $data_profile['address'] = $address;
                $data_profile['gender'] = $gender;
                $data_profile['hobbies'] = $hobbies;

                $this->users_model->save_user($data_array, $data_profile);

                if ($id == 0) {
                    $this->theme->set_message(lang('user-add-success'), 'success');
                } else {
                    $this->theme->set_message(lang('user-edit-success'), 'success');
                }

                redirect($this->section_name . '/users');
                exit;
            }
        } else {
            $id = 0;
            $firstname = "";
            $lastname = "";
            $email = "";
            $password = "";
            $passconf = "";
            $status = "";
            $address = "";
            $gender = "";
            $hobbies = "";
            $role_id = "";
        }
        $role_list = $this->users_model->role_list();

        // Pass data to view file
        $data['id'] = $id;
        $data['firstname'] = $firstname;
        $data['lastname'] = $lastname;
        $data['email'] = $email;
        $data['password'] = $password;
        $data['passconf'] = $passconf;
        $data['status'] = $status;
        $data['gender'] = $gender;
        $data['hobbies'] = $hobbies;
        $data['address'] = $address;
        $data['role_id'] = $role_id;
        $data['role_list'] = $role_list;

        //Logic
        if ($id == 0) {
            $data['user_id'] = 0;
            $status = 1;
            //create breadcrumbs & page-title
            $this->theme->set('page_title', lang('add-user'));
            $this->breadcrumb->add(lang('add-user'));
        } else {
            $data['user_id'] = $id;
            $status = $data['status'];
            //create breadcrumbs & page-title
            $this->theme->set('page_title', lang('edit-user'));
            $this->breadcrumb->add(lang('edit-user'));
        }

        //Render view
        $this->theme->view($data, 'admin_add');
    }

    /**
     * Function delete to user Ajax-Post
     */
    function delete() {
        if ($this->check_permission()) {
            $data = $this->input->post();
            //$id = intval($data['id']);
            $id = intval(base64_decode($data['id']));

            $result = $this->users_model->get_user_detail($id);
            if ($id == 1) {
                echo $this->theme->message(lang('invalid-id-msg'), 'danger');
                exit;
            }
            if (!empty($result)) {
                $res = $this->users_model->delete_user($id);
                if ($res) {
                    echo $this->theme->message(lang('user-delete-success'), 'success');
                }
            } else {
                echo $this->theme->message(lang('invalid-id-msg'), 'danger');
            }
        } else {
            $this->theme->set_message(lang('permission-not-allowed'), 'danger');
            redirect($this->section_name . '/users');
            exit;
        }
    }

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

    public function view_data($id = 0) {
        $result = $this->users_model->get_user_detail($id);
        $role_list = $this->users_model->role_list();
        $data = array();
        $data = $result;
        $role_name = array('role_name' => $role_list[$result['role_id']]);
        $data = array_merge($role_name, $data);
        
        $this->theme->set('page_title', lang('view-user-data'));
        $this->breadcrumb->add(lang('view-user-data'));
        
        $this->theme->view($data);
    }

    public function insert_data() {

        $data = array('name' => "Pankit");
        $i = 0;
        do {
            echo $this->db->insert("temp_data", $data);
//            echo "<br>";
//            echo $i."-here";
//            echo "<br>";
            $i++;
        } while ($i < 200000);
    }

}

