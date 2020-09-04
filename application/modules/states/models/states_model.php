<?php
/**
 *  States Model
 *
 *  To perform queries related to State management.
 *
 * @package CIDemoApplication
 * @subpackage states
 * @author  HP
 */
class states_model extends Base_Model
{
    protected $_table = TBL_STATE;
    public $sort_by = "";
    public $sort_order = "";
    public $state_name='';
    public $country_id='';
    public $status='';
    public $lang_id='';
    public $search_state='';
    public $search_country='';
    public $search_status='';
    public $search='';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Function get_state_listing to get state listing
     */
    function get_state_listing($language_id)
    {
        $language_id = intval($language_id);
        if($this->search_state != "")
        {
            $this->db->like('LOWER(s.state_name)', strtolower($this->search_state), 'both');
        }
        if($this->search_country != "")
        {
            $this->db->like('LOWER(c.country_name)', strtolower($this->search_country), 'both');
        }
        if($this->search_status != "")
        {
            $this->db->like('LOWER(s.status)', strtolower($this->search_status), 'both');
        }
        if($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('s.* , l.language_code,l.language_name,l.id as langid,c.country_id,c.lang_id,c.country_name');
        $this->db->order_by('s.id','DESC');
        $this->db->from(TBL_STATE. ' as s');
        $this->db->join(TBL_LANGUAGES . ' as l', 's.lang_id = l.id', 'left');
        $this->db->join(TBL_COUNTRY . ' as c', 's.country_id = c.country_id and c.lang_id ='.$language_id, 'left');                        
        if ($language_id != '')
        {
            $this->db->where("s.lang_id", $language_id);
        }
        $this->db->where('s.status !=', -1);
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
     * Function is_state_exist to check if given state already exists
     */
    public function is_state_exist($state_id, $lang_id)
    {
        $state_id = intval($state_id);
        $lang_id = intval($lang_id);
        $this->db->select('c.*')
                 ->from(TBL_STATE. ' as c')
                 ->where(array('c.state_id' => $state_id, 'c.lang_id' =>$lang_id))
                 ->where('c.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function update_state to update record
     */
    function update_state($state_id, $lang_id,$country_id)
    {
        $state_id = intval($state_id);
        $lang_id = intval($lang_id);
        $country_id=intval($country_id);
        $state_name = trim(strip_tags($this->input->post('state_name')));
        $status = trim(strip_tags($this->input->post('status')));
        $data_array = array(
            'state_name' => $state_name,
            'country_id' => $country_id,
            'status' => $status,
            'modified_on' => GetCurrentDateTime(),
            'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id'],
       );
        $this->db->where(array('state_id' => $state_id, 'lang_id' => $lang_id));
        $this->db->set($data_array);
        $this->db->update(TBL_STATE);
    }

    /**
     * Function insert_state to insert record
     */
    function insert_state($state_id, $lang_id)
    {
        $state_id = intval($state_id);
        $lang_id = intval($lang_id);
        $data_array['state_id'] = $state_id;
        $data_array['lang_id'] = $lang_id;
        if(isset($this->state_name) )
        {
            $data_array['state_name'] = mysql_real_escape_string($this->state_name);
        }
        if(isset($this->country_id) )
        {
            $data_array['country_id'] = mysql_real_escape_string($this->country_id);
        }
        if(isset($this->status) )
        {
            $data_array['status'] = $this->status;
        }
        $data_array['created_on'] = GetCurrentDateTime();
        $data_array['created_by'] = $this->session->userdata[get_current_section($this,true)]['user_id'];       
        $this->db->set($data_array);
        $this->db->insert(TBL_STATE);
        return $this->db->_error_number(); // return the error occurred in last query
    }

    /**
     * Function get_last_state_id to get last state inserted id
     */
    function get_last_state_id()
    {
        $this->db->select_max('state_id')
                 ->from(TBL_STATE);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['state_id'];
        } else
        {
            return 0;
        }
    }

     /**
     * Function get_state_detail_by_id to get state detail
     */
    public function get_state_detail_by_id($state_id, $lang_id)
    {
        $state_id = intval($state_id);
        $lang_id = intval($lang_id);        
        $this->db->select('s.*,c.country_name,c.country_id as countryid')
                 ->from(TBL_STATE . ' as s')
                 ->join(TBL_COUNTRY . ' as c', 's.country_id = c.country_id AND s.lang_id = c.lang_id', 'left')
                 ->where(array('s.state_id' => $state_id, 's.lang_id' => $lang_id))
                 ->where('s.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * 
     * Function delete_state to delete states
     */
    public function delete_state($id,$name)
    {
        $id = intval($id);
        $data_array = array('status' => '-1','modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->where('state_id', $id);
        $this->db->where('state_name', mysql_real_escape_string($name));
        $this->db->set($data_array);
        $this->db->update(TBL_STATE);
        $this->db->where('state_id',$id);
        $this->db->set($data_array);
        $this->db->update(TBL_CITY);
    }

        /**
        * Function get_country_listing to get country listing
        */
    function get_country_listing($language_id)
    {
        $language_id = intval($language_id);
        $this->db->select('c.* , l.language_code,l.language_name,l.id as langid');
        $this->db->from(TBL_COUNTRY. ' as c');
        $this->db->join(TBL_LANGUAGES . ' as l', 'c.lang_id = l.id', 'left');

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
        * Function get_state_listing_by_country to get states by country
        */
    function get_state_listing_by_country($language_id,$country_id)
    {
        $language_id = intval($language_id);
        $country_id = intval($country_id);
        $this->db->select('s.* , l.*');
        $this->db->from(TBL_STATE. ' as s');
        $this->db->join(TBL_LANGUAGES . ' as l', 's.lang_id = l.id', 'left')->where('s.country_id',$country_id);
        if ($language_id != '')
        {
            $this->db->where("s.lang_id", $language_id);
        }
        $this->db->where('s.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function check_unique_statename to check unique Statename
     */
    function check_unique_statename()
    {
        $this->db->select('state_id,state_name');
        $this->db->from(TBL_STATE);
        if(isset($this->state_name) )
        {
            $this->db->where('state_name', mysql_real_escape_string($this->state_name));
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
        $data_array = array('status' => '0','modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
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
        //inactivate  states
        $data_array = array('s.status' => '0','s.modified_on' => GetCurrentDateTime(), 's.modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('s.status !=',-1);
        $this->db->update(TBL_STATE.' as s');      
    }

    /**
     * Function active_records to active records
     * @param array $id
     */
    public function active_records($id = array())
    {
        $data_array = array('status' => '1','modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
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
        $data_array = array('s.status' => '1','s.modified_on' => GetCurrentDateTime(), 's.modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('s.status !=', -1);
        $this->db->update(TBL_STATE.' as s');
    }

   
     /**
     * Function get_id_to_delete to get ids of states to be deleted
     * @param integer $id
     */
    public function get_id_to_delete($id = array())
    {
        $this->db->select('s.state_id,s.lang_id');
        $this->db->where_in('s.id',$id);
        $this->db->from(TBL_STATE.' as s');
        $query=$this->db->get();
        return $this->db->custom_result($query);
    }

     /**
     * Function delete_state_city to delete state,city and ads
     * @param integer $id
     */
    function delete_state_city($state_id,$lang_id)
    {        
        //delete corresponding advertise
        $data_array = array('a.status' => '-1','a.modified_on' => GetCurrentDateTime(), 'a.modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('a.state_id',$state_id);     
        $this->db->update(TBL_ADVERTISEMENTS.' as a');
        
        //delete corresponding city       
        $data_array = array('ct.status' => '-1','ct.modified_on' => GetCurrentDateTime(), 'ct.modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('ct.state_id',$state_id);     
        $this->db->update(TBL_CITY.' as ct');

       //delete corresponding states   
        $data_array = array('s.status' => '-1','s.modified_on' => GetCurrentDateTime(), 's.modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('s.state_id',$state_id);      
        $this->db->update(TBL_STATE.' as s');
    }
}
?>
