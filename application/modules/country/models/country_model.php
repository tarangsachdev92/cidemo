<?php

/**
 *  Country Model
 *
 *  To perform queries related to country management.
 * 
 * @package CIDemoApplication
 * @author HP
 */
class Country_model extends Base_Model
{
    protected $_table = TBL_COUNTRY;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    public $offset = "";
    public $country_name = '';
    public $country_iso = '';
    public $status = '';
    public $lang_id = '';
    public $search_country_name = '';
    public $search_country_iso = '';
    public $search_status = '';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Function insert_country to insert record
     */
    function insert_country($country_id, $lang_id)
    {
        $country_id = intval($country_id);
        $lang_id = intval($lang_id);
        $data_array['country_id'] = $country_id;
        $data_array['lang_id'] = $lang_id;
        $data_array['country_iso'] = $country_iso;
        if (isset($this->country_name))
        {
            $data_array['country_name'] = $this->country_name;
        }
        if (isset($this->country_iso))
        {
            $data_array['country_iso'] = $this->country_iso;
        }
        if (isset($this->status))
        {
            $data_array['status'] = $this->status;
        }
        $data_array['created_on'] = GetCurrentDateTime();
        $data_array['created_by'] = $this->session->userdata[get_current_section($this, true)]['user_id'];
        $this->db->set($data_array);
        $this->db->insert($this->_table);
        return $this->db->_error_number(); // return the error occurred in last query
    }

    /**
     * Function update_country to update record
     */
    function update_country($country_id, $lang_id)
    {
        $country_id = intval($country_id);
        $lang_id = intval($lang_id);
        $data_array['country_id'] = $country_id;
        $data_array['lang_id'] = $lang_id;
        $data_array['country_iso'] = $country_iso;
        if (isset($this->country_name))
        {
            $data_array['country_name'] = $this->country_name;
        }
        if (isset($this->country_iso))
        {
            $data_array['country_iso'] = $this->country_iso;
        }
        if (isset($this->status))
        {
            $data_array['status'] = $this->status;
        }
        $data_array['modified_on'] = GetCurrentDateTime();
        $data_array['modified_by'] = $this->session->userdata[get_current_section($this, true)]['user_id'];
        $this->db->where(array('country_id' => $country_id, 'lang_id' => $lang_id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_country_detail_by_id to get country detail by country_id
     */
    public function get_country_detail_by_id($country_id, $lang_id)
    {
        $country_id = intval($country_id);
        $lang_id = intval($lang_id);
        $this->db->select('c.*')
                 ->from($this->_table . ' as c')
                 ->where(array('c.country_id' => $country_id, 'c.lang_id' => $lang_id))
                 ->where('c.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function get_country_listing to get country listing
     */
    function get_country_listing($language_id = '')
    {
        $language_id = intval($language_id);
        if ($this->search_country_name != "")
        {
            $this->db->like('LOWER(c.country_name)', strtolower($this->search_country_name), 'both');
        }
        if ($this->search_country_iso != "")
        {
            $this->db->like('LOWER(c.country_iso)', strtolower($this->search_country_iso), 'both');
        }
        if ($this->search_status != "")
        {
            $this->db->where('c.status', $this->search_status);
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('c.* , l.*');
        $this->db->order_by('c.id', 'DESC');
        $this->db->from($this->_table . ' as c');
        $this->db->join(TBL_LANGUAGES . ' as l', 'c.lang_id = l.id', 'left');
        if ($language_id != '')
        {
            $this->db->where("c.lang_id", $language_id);
        }
        $this->db->where('c.status !=', -1);
        $query = $this->db->get();
        if (isset($this->_record_count) && $this->_record_count == true)
        {
            return count($this->db->custom_result($query));
        }
        else
        {
            return $this->db->custom_result($query);
        }
    }

    /**
     * Function delete_country to delte country record
     */
    public function delete_country($id, $country_id, $country_name)
    {
        $id = intval($id);
        $data_array = array('status' => '-1', 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('country_id', $country_id);
        $this->db->update(TBL_COUNTRY);
        $this->db->set($data_array);
        $this->db->where('country_id', $country_id);
        $this->db->update(TBL_STATE);
        $this->db->set($data_array);
        $this->db->where('country_id', $country_id);
        $this->db->update(TBL_CITY);
    }

    /**
     * Function is_country_exist to check country record exist or not
     */
    public function is_country_exist($country_id, $lang_id)
    {
        $country_id = intval($country_id);
        $lang_id = intval($lang_id);
        $this->db->select('c.*')
                 ->from($this->_table . ' as c')
                 ->where(array('c.country_id' => $country_id, 'c.lang_id' => $lang_id))
                 ->where('c.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function get_last_country_id to get last country inserted id
     */
    function get_last_country_id()
    {
        $this->db->select_max('country_id')
                 ->from($this->_table);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['country_id'];
        }
        else
        {
            return 0;
        }
    }

    /**
     * Function check_unique_countryname to check unique country name
     * @param array $id
     */
    function check_unique_countryname()
    {
        $this->db->select('country_id,country_name');
        $this->db->from(TBL_COUNTRY);
        if (isset($this->country_name))
        {
            $this->db->where('country_name', mysql_real_escape_string($this->country_name));
        }
        $this->db->where('lang_id = ', $this->lang_id);
        $this->db->where('status != ', -1);
        $this->db->limit(1);
        $result = $this->db->get();
        return $this->db->custom_result($result);
    }

    /**
     * Function check_unique_countryname to check unique country name
     * @param array $id
     */
    function check_unique_iso()
    {
        $this->db->select('country_id,country_iso');
        $this->db->from(TBL_COUNTRY);
        if (isset($this->country_iso))
        {
            $this->db->where('country_iso', mysql_real_escape_string($this->country_iso));
        }
        $this->db->where('lang_id = ', $this->lang_id);
        $this->db->where('status != ', -1);
        $this->db->limit(1);
        $result = $this->db->get();
        return $this->db->custom_result($result);
    }

    /**
     * Function inactive_records to inactive records
     * @param array $id
     */
    public function inactive_records($id = array())
    {
        $data_array = array('status' => '0', 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where_in('id', $id);
        $this->db->update($this->_table);
        return $id;
    }

    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records()
    {
        //inactivate  countries
        $data_array = array('status' => '0', 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);
    }

    /**
     * Function active_records to active records
     * @param array $id
     */
    public function active_records($id = array())
    {
        $data_array = array('status' => '1', 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where_in('id', $id);
        $this->db->update($this->_table);
        return $id;
    }

    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records()
    {
        $data_array = array('status' => '1', 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);
    }

    /**
     * Function get_id_to_deletes to get ids of countries to be deleted
     * @param integer $id
     */
    public function get_id_to_delete($id = array())
    {
        $this->db->select('c.country_id,c.lang_id');
        $this->db->where_in('c.id', $id);
        $this->db->from(TBL_COUNTRY . ' as c');
        $query = $this->db->get();        
        return $this->db->custom_result($query);
    }

    /**
     * Function delete_country_state_city to delete corresponding state,city,ads and country
     * @param integer $id
     */
    function delete_country_state_city($country_id, $lang_id)
    {
        //delete corresponding advertise
        $data_array = array('a.status' => '-1', 'a.modified_on' => GetCurrentDateTime(), 'a.modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->where('a.country_id', $country_id);
        $this->db->set($data_array);       
        $this->db->update(TBL_ADVERTISEMENTS . ' as a');

        //delete corresponding cities
        $data_array = array('ct.status' => '-1', 'ct.modified_on' => GetCurrentDateTime(), 'ct.modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->where('ct.country_id', $country_id);
        $this->db->set($data_array);        
        $this->db->update(TBL_CITY . ' as ct');

        //delete corresponding States
        $data_array = array('s.status' => '-1', 's.modified_on' => GetCurrentDateTime(), 's.modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('s.country_id', $country_id);        
        $this->db->update(TBL_STATE . ' as s');

        //delete country
        $data_array = array('c.status' => '-1', 'c.modified_on' => GetCurrentDateTime(), 'c.modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('c.country_id', $country_id);        
        $this->db->update(TBL_COUNTRY . ' as c');
    }
}
?>