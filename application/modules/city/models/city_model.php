<?php

/**
 *  City Model
 *
 *  To perform queries related to city management.
 * 
 * @package CIDemoApplication
 * @subpackage City
 * @copyright	(c) 2013
 * @author KS
 */
class City_model extends Base_Model
{
    protected $_table = TBL_CITY;
    public $search_city ="";
    public $search_state ="";
    public $search_country ="";
    public $search_status ="";
    public $sort_by ="";
    public $sort_order ="";
    public $offset ="";

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Function insert_city to insert record 
     */
    function insert_city($city_id, $lang_id)
    {
        $data_array = array();   
        $city_id = intval($city_id);
        $lang_id = intval($lang_id);                     
        $data_array['city_id'] = $city_id;
        $data_array['lang_id'] = $lang_id;
        if(isset($this->city_name) )
        {
            $data_array['city_name'] = $this->city_name;
        }
        if(isset($this->country_id) )
        {
            $data_array['country_id'] = $this->country_id;
        }
        if(isset($this->state_id) )
        {
            $data_array['state_id'] = $this->state_id;
        }
        if(isset($this->status) )
        {
            $data_array['status'] = $this->status;
        }
        $data_array['created_on'] = GetCurrentDateTime();
        $data_array['created_by'] = $this->session->userdata[get_current_section($this,true)]['user_id'];
        $this->db->set($data_array);
        $this->db->insert($this->_table);
        return $this->db->_error_number(); // return the error occurred in last query
    }

    /**
     * Function update_city to update record 
     */
    function update_city($city_id, $lang_id)
    {
        $data_array = array();
        $city_id = intval($city_id);
        $lang_id = intval($lang_id);        
        $data_array['city_id'] = $city_id;
        $data_array['lang_id'] = $lang_id;
        if(isset($this->city_name) )
        {
            $data_array['city_name'] = $this->city_name;
        }
        if(isset($this->country_id) )
        {
            $data_array['country_id'] = $this->country_id;
        }
        if(isset($this->state_id) )
        {
            $data_array['state_id'] = $this->state_id;
        }
        if(isset($this->status) )
        {
            $data_array['status'] = $this->status;
        }
        $data_array['modified_on'] = GetCurrentDateTime();
        $data_array['modified_by'] = $this->session->userdata[get_current_section($this,true)]['user_id'];        
        $this->db->where(array('city_id' => $city_id, 'lang_id' => $lang_id));
        $this->db->set($data_array);
        $this->db->update($this->_table);        
    }

    /**
     * Function get_city_detail_by_id to get city detail 
     */
    public function get_city_detail_by_id($city_id, $lang_id)
    {
        $city_id = intval($city_id);
        $lang_id = intval($lang_id);        
        $this->db->select('c.*, s.*,cnt.*')
                 ->from($this->_table . ' as c')
                 ->join(TBL_COUNTRY . ' as cnt', 'c.country_id = cnt.country_id and cnt.lang_id ='.$lang_id, 'left')
                 ->join(TBL_STATE . ' as s', 'c.state_id = s.state_id and s.lang_id = '.$lang_id, 'left')
                 ->where(array('c.city_id' => $city_id, 'c.lang_id' => $lang_id))
                 ->where('c.status !=', -1);
        $query = $this->db->get();                
        return $this->db->custom_result($query);        
    }

    /**
     * Function get_city_listing to get city listing 
     */
    function get_city_listing($language_id = '')
    {
        $language_id = intval($language_id);
        if($this->search_city != "")
        {             
            $this->db->like('LOWER(c.city_name)', strtolower($this->search_city), 'both'); 
        }
        if($this->search_state != "")
        {             
            $this->db->like('LOWER(s.state_name)', strtolower($this->search_state), 'both'); 
        }
        if($this->search_country != "")
        {             
            $this->db->like('LOWER(cnt.country_name)', strtolower($this->search_country), 'both'); 
        }
        if($this->search_status != "")
        {             
            $this->db->where('c.status', $this->search_status); 
        }
        if($this->sort_by != "" && $this->sort_order != "")
        {             
            $this->db->order_by($this->sort_by, $this->sort_order); 
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }        
        $this->db->select('c.* , l.*, s.*,cnt.*');
        $this->db->from($this->_table . ' as c');
        $this->db->join(TBL_LANGUAGES . ' as l', 'c.lang_id = l.id', 'left');
        $this->db->join(TBL_COUNTRY . ' as cnt', 'c.country_id = cnt.country_id and cnt.lang_id = l.id', 'left');
        $this->db->join(TBL_STATE . ' as s', 'c.state_id = s.state_id and s.lang_id = l.id', 'left');
        $this->db->order_by('c.city_id','desc');
        if ($language_id != '')
        {
            $this->db->where("c.lang_id", $language_id);
        }
        $this->db->where('c.status !=', -1);
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
     * Function delete_city to delte city record 
     */
    public function delete_city($id)
    {
        $id = intval($id);
        $data_array = array('status' => '-1','modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('city_id', $id);
        $result = $this->db->update($this->_table);        
        if($result != 0)
        {
            $data_array = array('status' => '-1','modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
            $this->db->set($data_array);
            $this->db->where('city_id', $id);
            $this->db->update(TBL_ADVERTISEMENTS);
        }        
    }
    
    /**
     * Function check_unique_cityname to check duplicate city names
     */
    function check_unique_cityname()
    {        
        if(isset($this->city_name))
        {
            $city_name = $this->city_name;
        }
        if(isset($this->lang_id))
        {
            $lang_id = $this->lang_id;
        }
        if(isset($this->country_id))
        {
            $country_id = $this->country_id;
        }
        if(isset($this->state_id))
        {
            $state_id = $this->state_id;
        }        
        $this->db->select('city_id');
        $this->db->from($this->_table);
        $this->db->where('city_name = ', $city_name);
        $this->db->where('lang_id = ', $lang_id);
        $this->db->where('country_id = ', $country_id);
        $this->db->where('state_id = ', $state_id);
        $this->db->where('status != ', -1);
        $this->db->limit(1);
        $query = $this->db->get();
        $city_id = $query->result_array();
        return $city_id;
    }    
    
    /**
     * Function is_city_exist to check city record exist or not
     */
    public function is_city_exist($city_id, $lang_id)
    {
        $city_id = intval($city_id);
        $lang_id = intval($lang_id);
        $this->db->select('c.*')
                 ->from($this->_table . ' as c')
                 ->where(array('c.city_id' => $city_id, 'c.lang_id' =>$lang_id))
                 ->where('c.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function get_last_city_id to get lasr city inserted id
     */
    function get_last_city_id()
    {
        $this->db->select_max('city_id')
                 ->from($this->_table);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['city_id'];
        } else
        {
            return 0;
        }
    }

    /**
     * Function get_city_listing_by_state to get city list for selected state
     * @param type $language_id
     * @param type $state_id
     * @return type
     */
    function get_city_listing_by_state($language_id,$state_id)
    {
        $language_id = intval($language_id);
        $state_id = intval($state_id);
        $this->db->select('c.* , l.*');
        $this->db->from(TBL_CITY. ' as c');
        $this->db->join(TBL_LANGUAGES . ' as l', 'c.lang_id = l.id', 'left')->where('c.state_id',$state_id);
        if ($language_id != '')
        {
            $this->db->where("c.lang_id", $language_id);
        }
        $this->db->where('c.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }
    
    /**
     * Function inactive_records to inactive records
     * @param $city_id 
     */
    public function inactive_records($id = array())
    {        
        $data_array = array('status' => 0,'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where_in('id', $id);
        $this->db->update($this->_table);
        return $id;
    }
    
    /**
     * Function inactive_all_records to inactive all records without deleted records
     * @param array $id 
     */
    public function inactive_all_records()
    {      
        $data_array = array('status' => 0,'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);

        return true;
    }
    
    /**
     * Function active_records to active records
     * @param array $id 
     */
    public function active_records($id)
    {        
        $data_array = array('status' => 1,'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where_in('id', $id);
        $result = $this->db->update($this->_table);        
        return $id;
    }
    
    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records()
    {        
        $data_array = array('status' => 1,'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);

        return true;
    }

    /**
     * Function delete_records to delete URL
     * @param integer $id 
     */
    public function delete_records($id)
    {
        $data_array = array('status' => '-1','modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where_in('id', $id);
        $result = $this->db->update($this->_table);       
        return $result;
    }
    
    /**
     * function get_city_id to get city by id
     * @param type $id
     * @return type
     */
    public function get_city_id($id = array())
    {
        $city_id = array();
        $this->db->select('city_id');
        $this->db->from($this->_table);
        $this->db->where_in('id', $id);
        $query = $this->db->get();
        $city_id = $query->result_array();
        return $city_id;
    }
}

?>