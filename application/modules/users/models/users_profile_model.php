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
class Users_Profile_model extends Base_Model
{

    protected $_tbl_user_profile = TBL_USER_PROFILE;
    
    /**
     * Function save_user to add/update user
     * @param array $data for user table 
     * @param array $data_profile for user_profile table 
     */
    public function save_user($data_profile)
    {
        
        if(isset($data_profile['user_id']))
        {
            $userprofile_data ['user_id'] = $data_profile['user_id'];
        }
        if(isset($data_profile['gender']))
        {
            $userprofile_data ['gender'] = $data_profile['gender'];
        }
        if(isset($data_profile['address']))
        {
            $userprofile_data ['address'] = $data_profile['address'];
        }
        if(isset($data_profile['hobbies']))
        {
            $userprofile_data ['hobbies'] = $data_profile['hobbies'];
        }
        if(isset($data_profile['modified']))
        {
            $userprofile_data ['modified'] = $data_profile['modified'];
        }
        
        if(isset($this->id) &&  $this->id != 0 && $this->id != "")
        {
            $this->db->where('user_id', $this->id);
            $this->db->update($this->_tbl_user_profile, $userprofile_data);
        }
        else
        {

            $this->db->insert($this->_tbl_user_profile, $userprofile_data);
        }
        return true;
    }

    /**
     * Function update_last_login to update last_login field 
     * @param integer $id 
     */
   
}

