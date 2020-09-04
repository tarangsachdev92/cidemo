<?php

/**
 *  Users Model
 *
 *  To perform queries related to user management.
 *
 * @package CIDemoApplication
 * @subpackage Users
 * @copyright	(c) 2013, TatvaSoft
 * @author panks
 */
class Users_model extends Base_Model
{

    protected $_tbl_users = TBL_USERS;
    protected $_tbl_roles = TBL_ROLES;
    protected $_tbl_user_profile = TBL_USER_PROFILE;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    public $_record_count;
    /**
     * Function save_user to add/update user
     * @param array $data for user table
     * @param array $data_profile for user_profile table
     */
    public function save_user($data, $data_profile)
    {

        if(isset($data['id']))
        {
            $user_data ['id'] = $data['id'];
        }
        if(isset($data['role_id']))
        {
            $user_data ['role_id'] = $data['role_id'];
        }
        if(isset($data['firstname']))
        {
            $user_data ['firstname'] = $data['firstname'];
        }
        if(isset($data['lastname']))
        {
            $user_data['lastname'] = $data['lastname'];
        }
        if(isset($data['email']))
        {
            $user_data ['email'] = $data['email'];
        }
        if(isset($data['password']))
        {
            $user_data ['password'] = $data['password'];
        }
        if(isset($data['activation_code']))
        {
            $user_data ['activation_code'] = $data['activation_code'];
        }
        if(isset($data['activation_expiry']))
        {
            $user_data ['activation_expiry'] = $data['activation_expiry'];
        }
        if(isset($data['last_login']))
        {
            $user_data ['last_login'] = $data['last_login'];
        }
        if(isset($data['status']))
        {
            $user_data ['status'] = $data['status'];
        }
        if(isset($data['created']))
        {
            $user_data ['created'] = $data['created'];
        }
        if(isset($data['modified']))
        {
            $user_data ['modified'] = $data['modified'];
        }
        if(isset($data['is_locked']))
        {
            $user_data ['is_locked'] = $data['is_locked'];
        }
        if(isset($data['lock_datetime']))
        {
            $user_data ['lock_datetime'] = $data['lock_datetime'];
        }
        if(isset($data['lock_user_id']))
        {
            $user_data ['lock_user_id'] = $data['lock_user_id'];
        }

        if(isset($user_data['id']) &&  $user_data['id']!= 0 && $user_data['id'] != "")
        {
            $this->db->where('id', $user_data['id']);
            $this->db->update($this->_tbl_users, $user_data);
            $id = $user_data['id'];
            $this->users_profile_model->id =$id;
            $this->users_profile_model->save_user($data_profile);
            unlock_record($this,TBL_USERS,$id);
        }
        else
        {

            $this->db->set('created', 'NOW()', FALSE);
            if($this->db->insert($this->_tbl_users, $data))
            {
                $id = $this->db->insert_id();
                $data_profile['user_id'] = $id;
                $this->users_profile_model->save_user($data_profile);
            }
        }
        return $id;
    }

    public function save_profile($data, $data_profile)
    {

        if(isset($data['id']))
        {
            $user_data ['id'] = $data['id'];
        }
        if(isset($data['role_id']))
        {
            $user_data ['role_id'] = $data['role_id'];
        }
        if(isset($data['firstname']))
        {
            $user_data ['firstname'] = $data['firstname'];
        }
        if(isset($data['lastname']))
        {
            $user_data['lastname'] = $data['lastname'];
        }
        if(isset($data['email']))
        {
            $user_data ['email'] = $data['email'];
        }


        if(isset($data['status']))
        {
            $user_data ['status'] = $data['status'];
        }

        if(isset($data['is_locked']))
        {
            $user_data ['is_locked'] = $data['is_locked'];
        }
        if(isset($data['lock_datetime']))
        {
            $user_data ['lock_datetime'] = $data['lock_datetime'];
        }
        if(isset($data['lock_user_id']))
        {
            $user_data ['lock_user_id'] = $data['lock_user_id'];
        }

        if(isset($user_data['id']) &&  $user_data['id']!= 0 && $user_data['id'] != "")
        {
            $this->db->where('id', $user_data['id']);
            $this->db->update($this->_tbl_users, $user_data);
            $id = $user_data['id'];
            $this->users_profile_model->id =$id;
            $this->users_profile_model->save_user($data_profile);
            //echo $this->db->last_query();exit;
            unlock_record($this,TBL_USERS,$id);
        }
        else
        {

            $this->db->set('created', 'NOW()', FALSE);
            if($this->db->insert($this->_tbl_users, $data))
            {
                $id = $this->db->insert_id();
                $data_profile['user_id'] = $id;
                $this->users_profile_model->save_user($data_profile);
            }
        }
        return $id;
    }

    /**
     * Function update_last_login to update last_login field
     * @param integer $id
     */
    public function update_last_login($id = 0)
    {
        //Type Casting
        $id = intval($id);

        $this->db->set('last_login', 'NOW()', FALSE);
        $this->db->where('id', $id);
        $this->db->update($this->_tbl_users);

        return $id;
    }

    /**
     * Function login to do login
     */
    function login()
    {
        // grab user input
        /*$email = $this->security->xss_clean($this->email);
        $password = $this->security->xss_clean($this->password);
        $this->db->where("email", $email);
        $this->db->where("status != ", '-1');
        $this->db->where("role_id ", '1');
        $this->db->where("password", encriptsha1($password));
        $query = $this->db->get($this->_tbl_users);

        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        return false;*/

        $email = $this->security->xss_clean($this->email);
        $password = $this->security->xss_clean($this->password);
        $this->db->join($this->_tbl_roles . ' as r', ('u.role_id = r.id OR u.id = 1'), 'left');
        $this->db->where("u.email", $email);
        $this->db->where("u.status != ", '-1');
        $this->db->where("u.role_id ", '1');
        $this->db->where("r.status  ", '1');
        $this->db->where("u.password", encriptsha1($password));
        $query = $this->db->get($this->_tbl_users . ' AS u');
        if($query->num_rows() > 0)
        {
            return $this->db->custom_result($query);
        }
        return false;

    }
    /**
     * Function role_list to get listing of active roles
     */
    function role_list()
    {
        $this->db->select("id,role_name");
        $this->db->from($this->_tbl_roles);
        $this->db->where('status', 1);
        $this->db->order_by('role_name','asc');
        $result = $this->db->get();

        if($result->num_rows() > 0)
        {
            $result = $result->result_array();
            foreach ($result as $role)
            {
                $roles[$role['id']] = $role['role_name'];
            }
            return $roles;
        }
        else
        {
            return NULL;
        }
    }

    function get_default_role()
    {
        $this->db->select("id");
        $this->db->from($this->_tbl_roles);
        $this->db->where('default', 1);
        $result = $this->db->get();

        return $result->row_array();
    }

    /**
     * Function get_user_detail to return user array of particular id
     * @param integer $id
     */
    function get_user_detail($id = 0)
    {
        //Type Casting
        $id = intval($id);

        $this->db->where("id", $id);
        $this->db->where_in("status", array(1,0));
        $tableusers = $this->db->get($this->_tbl_users);
        $userArray = $tableusers->row_array();

        if(!empty($userArray))
        {
            $this->db->where("user_id", $id);
            $tableuserprofile = $this->db->get($this->_tbl_user_profile);
               
            return $userArray+=$tableuserprofile->row_array();
        }
        else
        {
            return '';
        }

    }

    /**
     * Function changepassword to change user password
     * @param integer $user_id default = 0
     */
    function changepassword($user_id = 0, $password = NULL)
    {
        
        //Type Casting
        $user_id = intval($user_id);
        $password = trim(strip_tags($password));

        if($user_id != 0 && $user_id)
        {
            $data['password'] = encriptsha1($password);

            $this->db->where('id', $user_id);
            $this->db->update($this->_tbl_users, $data);
        }
    }

    /**
     * Function get_user_listing to fetch all records of users
     * @param integer $user_id default = 0
     */
    function get_user_listing()
    {

//        echo '<pre>';
//        print_r($this->session->all_userdata());
//        exit;


        if($this->search_term != "")
        {
            $this->db->like("LOWER(u.firstname)", strtolower($this->search_term));
        }
        if($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if(isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
           $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('u.*,r.role_name');
        $this->db->from($this->_tbl_users . ' AS u');
        $this->db->join($this->_tbl_roles . ' as r', 'u.role_id = r.id', 'left');
        $this->db->where('u.status !=', -1);

        $query = $this->db->get();

        if(isset($this->_record_count) && $this->_record_count == true)
        {
            return count($this->db->custom_result($query));
        }
        else
        {
            return $this->db->custom_result($query);
        }
    }

     /**
     * Function check front login
     */
    public function check_front_login($email, $password)
    {
        $email = trim($this->security->xss_clean($email));
        $password = ($this->security->xss_clean($password));

        $this->db->select('u.*');
        $this->db->where("u.email", $email);
        $this->db->where("u.status != ", -1);
        $this->db->where("u.password", encriptsha1($password));
        $query = $this->db->get($this->_tbl_users . " as u");

        if($query->num_rows() == 1)
        {
            return $this->db->custom_result($query);
        }
        return false;
    }

    /**
     * Function do activation
     * @params $activation_key for update activation key
     */
    function activation($activation_key)
    {


        $this->db->select("u.*");
        $this->db->where('u.activation_code', '' . $activation_key . '');

        $useres = $this->db->get($this->_tbl_users . ' as u');
        //  echo $this->db->last_query();exit;
        $user_data = $this->db->custom_result($useres);

        if(isset($user_data))
        {
            $activation_expiry = $user_data[0]['u']['activation_expiry'];
            $now_date = date("Y-m-d H:i:s");
            if(strtotime($now_date) < strtotime($activation_expiry))
            {
                $data = array(
                    'activation_code' => "",
                    'status' => 1
                );
                $this->db->where('activation_code', '' . $activation_key . '');
                $this->db->update($this->_tbl_users, $data);
               $flag = 1;
            }
            else
            {
               $flag = 2;
            }

        }
        else
        {
             $flag = 3;
        }
        return $flag;
    }

    /**
     * Function get user data by passing email id
     */
    function get_user_detail_by_email($email = NULL)
    {
        //Type casting
        $email = strip_tags($email);

        $this->db->select("u.*");
        $this->db->where("u.email", $email);
        $this->db->where("u.status", '1');
        $this->db->where("u.role_id !=", '1');

        $useres = $this->db->get($this->_tbl_users . ' as u');

        return $this->db->custom_result($useres);
    }

    /**
     * Function for set autogenerate password and send email for new password
     */
    function forgot_password($data = array())
    {
        //Type casting
        $email = strip_tags($data['email']);

        $this->db->where('email', $email);
        $this->db->where('status', '1');
        $this->db->update($this->_tbl_users, $data);
    }

    /**
     * Function delete_user to delete user
     * @param integer $id
     */
    public function delete_user($id)
    {
        //Type Casting
        $id = intval($id);

        $this->db->where('id', $id);
        $this->db->set('status', '-1');
        return $this->db->update($this->_tbl_users);
    }

    /**
     * Function check_group_status to check Role status
     * @param integer $id default = 0
     */
    function check_group_status($id = 0)
    {
        //Type Casting
        $id = intval($id);

        if($id != 0)
        {
            $this->db->select("status");
            $this->db->where("id", $id);
            $groupData = $this->db->get($this->_tbl_roles);
            $groupData = $groupData->row_array();
            return $groupData['status'];
        }
        else
        {
            return 0;
        }
    }

    /**
     * Function check_unique_mail to check duplicate emails
     * @param array $data
     */
    function check_unique_mail($data)
    {
        $email = trim(strip_tags($data['email']));
        $user_id = intval($data['id']);

        $this->db->select('id,email');
        $this->db->from($this->_tbl_users);
        if(isset($user_id) && $user_id != '' && $user_id != 0)
        {
            $this->db->where('id != ', $user_id);
        }
        $this->db->where('LOWER(email) = ',  mb_strtolower($email, 'UTF-8'));
        $this->db->where('status != ', -1);

        $this->db->limit(1);
        $result = $this->db->get()->num_rows();
        return $result;
    }

    /**
     * Function update_activation_key to update activate field in DB
     * @param string $activation_key
     */
    function update_activation_key($activation_key)
    {
        $data = array(
            'activation_code' => get_random_string(),
            'activation_expiry' => date('Y:m:d H:i:s',strtotime('+1 day', now()))
        );
        $this->db->where('activation_code', '' . $activation_key . '');
        $this->db->update($this->_tbl_users, $data);
        return $data['activation_code'];
    }

    /**
     * Function update_activation_key to update activate field in DB
     * @param string $activation_key
     */
    function get_user_data_by_activation_key($activation_key)
    {
        $this->db->select("u.*");
        $this->db->where('u.activation_code', '' . $activation_key . '');

        $useres = $this->db->get($this->_tbl_users . ' as u');

        $user_data = $this->db->custom_result($useres);
        return $user_data[0]['U'];
    }

    /**
     * Function inactive_records to inactive records
     * @param array $id
     */
    public function inactive_records($id = array())
    {
        $this->db->set('modified', 'NOW()', FALSE);
        $this->db->set('status', 0);
        $this->db->where_in('id', $id);
        $this->db->update($this->_tbl_users);

        return $id;
    }

    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records()
    {
        $this->db->set('modified', 'NOW()', FALSE);
        $this->db->set('status', 0);
        $this->db->where('status !=', -1);
        $this->db->where('id !=', 1);
        $this->db->update($this->_tbl_users);

        return true;
    }

    /**
     * Function active_records to active records
     * @param array $id
     */
    public function active_records($id = array())
    {
        $this->db->set('modified', 'NOW()', FALSE);
        $this->db->set('status', 1);
        $this->db->where_in('id', $id);
        $this->db->update($this->_tbl_users);

        return $id;
    }

    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records()
    {
        $this->db->set('modified', 'NOW()', FALSE);
        $this->db->set('status', 1);
        $this->db->where('status !=', -1);
        $this->db->where('id !=', 1);
        $this->db->update($this->_tbl_users);

        return true;
    }

    /**
     * Function delete_records to delete URL
     * @param integer $id
     */
    public function delete_records($id = array())
    {
        $this->db->set('modified', 'NOW()', FALSE);
        $this->db->where_in('id', $id);
        $this->db->set('status', '-1');
        return $this->db->update($this->_tbl_users);
    }
}
