<?php

/**
 *  Banner Model
 *
 *  To perform queries related to Banner management.
 * 
 * @package CIDemoApplication
 * @subpackage Banner
 * @author KS & HP
 */
class Banner_model extends Base_Model
{
    protected $_table = TBL_ADVERTISEMENTS;
    public $search_term = "";
    public $search_title = "";
    public $search_status = "";
    public $search_section = "";
    public $search_position = "";
    public $search_page = "";
    public $search_banner_type = "";
    public $search_country = "";
    public $search_state = "";
    public $search_city = "";
    public $sort_by = "";
    public $sort_order = "";
    public $offset = "";
    public $start_date = "";
    public $end_date = "";
    public $ad_id = '';
    public $user_id = '';
    public $ip = '';
    public $location_eng = '';
    public $lang_id = '';
    public $country_id = '';
    public $state_id = '';
    public $city_id = '';
    public $page_id = '';
    public $position = '';
    public $id = '';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Function insert_advertisement to insert record 
     */
    function insert_advertisement($ad_id, $lang_id)
    {
        $data_array = array();
        $ad_id = intval($ad_id);
        $lang_id = intval($lang_id);
        $data_array['ad_id'] = $ad_id;
        $data_array['lang_id'] = $lang_id;
        if (isset($this->title))
        {
            $data_array['title'] = $this->title;
        }
        if (isset($this->description))
        {
            $data_array['description'] = $this->description;
        }
        if (isset($this->section_id))
        {
            $data_array['section_id'] = $this->section_id;
        }
        if (isset($this->page_id))
        {
            $data_array['page_id'] = $this->page_id;
        }
        if (isset($this->position))
        {
            $data_array['position'] = $this->position;
        }
        if (isset($this->order))
        {
            $data_array['order'] = $this->order;
        }
        if (isset($this->banner_type))
        {
            $data_array['banner_type'] = $this->banner_type;
        }
        if (isset($this->link))
        {
            $data_array['link'] = $this->link;
        }
        if (isset($this->image_url))
        {
            $data_array['image_url'] = $this->image_url;
        }
        if (isset($this->embedded_code))
        {
            $data_array['embedded_code'] = $this->embedded_code;
        }
        if (isset($this->country_id))
        {
            $data_array['country_id'] = $this->country_id;
        }
        if (isset($this->state_id))
        {
            $data_array['state_id'] = $this->state_id;
        }
        if (isset($this->city_id))
        {
            $data_array['city_id'] = $this->city_id;
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
     * Function update_advertisement to update record 
     */
    function update_advertisement($ad_id, $lang_id)
    {
        $data_array = array();
        $ad_id = intval($ad_id);
        $lang_id = intval($lang_id);        
        $data_array['ad_id'] = $ad_id;
        $data_array['lang_id'] = $lang_id;
        if (isset($this->title))
        {
            $data_array['title'] = $this->title;
        }
        if (isset($this->description))
        {
            $data_array['description'] = $this->description;
        }
        if (isset($this->section_id))
        {
            $data_array['section_id'] = $this->section_id;
        }
        if (isset($this->page_id))
        {
            $data_array['page_id'] = $this->page_id;
        }
        if (isset($this->position))
        {
            $data_array['position'] = $this->position;
        }
        if (isset($this->order))
        {
            $data_array['order'] = $this->order;
        }
        if (isset($this->banner_type))
        {
            $data_array['banner_type'] = $this->banner_type;
        }
        if (isset($this->link))
        {
            $data_array['link'] = $this->link;
        }
        if (isset($this->image_url))
        {
            $data_array['image_url'] = $this->image_url;
        }
        if (isset($this->embedded_code))
        {
            $data_array['embedded_code'] = $this->embedded_code;
        }
        if (isset($this->country_id))
        {
            $data_array['country_id'] = $this->country_id;
        }
        if (isset($this->state_id))
        {
            $data_array['state_id'] = $this->state_id;
        }
        if (isset($this->city_id))
        {
            $data_array['city_id'] = $this->city_id;
        }
        if (isset($this->status))
        {
            $data_array['status'] = $this->status;
        }
        $data_array['modified_on'] = GetCurrentDateTime();
        $data_array['modified_by'] = $this->session->userdata[get_current_section($this, true)]['user_id'];
        $this->db->where(array('ad_id' => $data_array['ad_id'], 'lang_id' => $data_array['lang_id']));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_advertisement_detail_by_id to get advertise by its id
     */
    public function get_advertisement_detail_by_id($ad_id, $lang_id)
    {
        $ad_id = intval($ad_id);
        $lang_id = intval($lang_id);
        $this->db->select('ad.* , l.*, c.*, s.*,cnt.*');
        $this->db->from($this->_table . ' as ad');
        $this->db->join(TBL_LANGUAGES . ' as l', 'ad.lang_id = l.id', 'left');
        $this->db->join(TBL_COUNTRY . ' as cnt', 'ad.country_id = cnt.country_id and cnt.lang_id = l.id', 'left');
        $this->db->join(TBL_STATE . ' as s', 'ad.state_id = s.state_id and s.lang_id = l.id', 'left');
        $this->db->join(TBL_CITY . ' as c', 'c.city_id = ad.city_id and c.lang_id = l.id', 'left');
        $this->db->where(array('ad.ad_id' => $ad_id, 'ad.lang_id' => $lang_id))->where('ad.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function get_advertisement_listing to get banner/ad listing 
     */
    function get_advertisement_listing($language_id = '')
    {
        $language_id = intval($language_id);
        if ($this->search_title != "")
        {
            $this->db->like('LOWER(ad.title)', strtolower($this->search_title), 'both');
        }
        if ($this->search_status != "")
        {
            $this->db->where('ad.status', $this->search_status);
        }
        if ($this->search_section != "")
        {
            $this->db->where('ad.section_id', $this->search_section);
        }
        if ($this->search_position != "")
        {
            $this->db->where('ad.position', $this->search_position);
        }
        if ($this->search_page != "")
        {
            $this->db->where('ad.page_id', $this->search_page);
        }
        if ($this->search_banner_type != "")
        {
            $this->db->where('ad.banner_type', $this->search_banner_type);
        }
        if ($this->search_country != "")
        {
            $this->db->where('ad.country_id', $this->search_country);
        }
        if ($this->search_state != "")
        {
            $this->db->where('ad.state_id', $this->search_state);
        }
        if ($this->search_city != "")
        {
            $this->db->where('ad.city_id', $this->search_city);
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('ad.* , l.*, c.*, s.*,cnt.*');
        $this->db->from($this->_table . ' as ad');
        $this->db->join(TBL_LANGUAGES . ' as l', 'ad.lang_id = l.id', 'left');
        $this->db->join(TBL_COUNTRY . ' as cnt', 'ad.country_id = cnt.country_id and cnt.lang_id = l.id', 'left');
        $this->db->join(TBL_STATE . ' as s', 'ad.state_id = s.state_id and s.lang_id = l.id', 'left');
        $this->db->join(TBL_CITY . ' as c', 'c.city_id = ad.city_id and c.lang_id = l.id', 'left');
        if (isset($this->section_id) && $this->section_id != "")
        {
            $this->db->order_by('ad.ad_id', 'asc');
            $this->db->where('ad.section_id', $this->section_id);
        }
        else
        {
            $this->db->order_by('ad.ad_id', 'desc');
        }
        if ($language_id != '')
        {
            $this->db->where("ad.lang_id", $language_id);
        }
        $this->db->where('ad.status !=', -1);

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
     * Function delete_advertisement to delte banner record 
     */
    public function delete_advertisement($id)
    {
        $id = intval($id);
        $data_array = array('status' => '-1', 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('id', $id);
        $this->db->update($this->_table);
    }

    /**
     * Function is_advertisement_exist to check banner/ad record exist or not
     */
    public function is_advertisement_exist($ad_id, $lang_id)
    {
        $ad_id = intval($ad_id);
        $lang_id = intval($lang_id);
        $this->db->select('ad.*')
                 ->from($this->_table . ' as ad')
                 ->where(array('ad.ad_id' => $ad_id, 'ad.lang_id' => $lang_id))
                 ->where('ad.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function get_last_advertisement_id to get lasr banner/ad inserted id
     */
    function get_last_advertisement_id()
    {
        $this->db->select_max('ad_id')
                 ->from($this->_table);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['ad_id'];
        }
        else
        {
            return 0;
        }
    }

    /**
     * Function get_home_banner_listing to get Home Banner
     */
    function get_home_banner_listing($language_id = '')
    {
        $lang_id = intval($language_id);
        $this->db->select('ad.*');
        $this->db->from($this->_table . ' as ad');
        if (isset($this->section_id))
        {
            $this->db->where("ad.section_id", $this->section_id);
        }
        if ($language_id != '')
        {
            $this->db->where("ad.lang_id", $language_id);
        }
        $this->db->where('ad.status =', 1);
        $this->db->order_by('ad.order');
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function get_banner_field to get Banner Fields
     */
    function get_banner_field($fields, $ad_id, $lang_id)
    {
        $ad_id = intval($ad_id);
        $lang_id = intval($lang_id);
        $this->db->select($fields)
                 ->from($this->_table)
                 ->where(array('ad_id' => $ad_id, 'lang_id' => $lang_id))
                 ->where('status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function get_visitor_listing to get visitor listing
     */
    function get_visitor_listing($language_id = '')
    {
        //type casting
        $language_id = intval($language_id);

        //logic
        if ($this->search_term != "")
        {
            $this->db->like('v.ad_id', $this->search_term, 'both');
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('v.*,a.title');
        $this->db->from(TBL_AD_VISITORS . ' as v');
        $this->db->join(TBL_ADVERTISEMENTS . ' as a', 'v.ad_id = a.ad_id', 'left');

        if ($this->start_date != '' && $this->end_date == '')
        {

            $this->db->where('date(v.visited_date) >=', mysql_real_escape_string($this->start_date));
        }
        if ($this->end_date != '' && $this->start_date == '')
        {

            $this->db->where('date(v.visited_date) <=', mysql_real_escape_string($this->end_date));
        }
        if ($this->start_date != '' && $this->end_date != '')
        {

            $this->db->where('date(v.visited_date) >=', mysql_real_escape_string($this->start_date));
            $this->db->where('date(v.visited_date) <=', mysql_real_escape_string($this->end_date));
        }
        if ($this->ad_id != 0)
        {
            $this->db->where('v.ad_id ', $this->ad_id);
        }
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
     * Function get_advertise to get advertisements for given page randomly
     */
    function get_advertise($lang_id)
    {
        $this->db->select('a.*,c.country_id,c.country_iso,s.state_id,s.state_name,ct.city_id,ct.city_name');
        $this->db->order_by('a.ad_id', 'RANDOM');
        $this->db->from(TBL_ADVERTISEMENTS . ' as a');
        $this->db->join(TBL_COUNTRY . ' as c', 'a.country_id = c.country_id and c.lang_id =' . $lang_id, 'left');
        $this->db->join(TBL_STATE . ' as s', 'a.state_id = s.state_id and s.lang_id =' . $lang_id, 'left');
        $this->db->join(TBL_CITY . ' as ct', 'a.city_id = ct.city_id and ct.lang_id =' . $lang_id, 'left');
        $this->db->limit(1);
        $this->db->where('a.section_id', AD_BANNER);
        $this->db->where('a.status =', 1);
        if (isset($this->page_id))
        {
            $this->db->where('page_id', $this->page_id);
        }
        if (isset($this->position))
        {
            $this->db->where('position', $this->position);
        }
        $this->db->where("(a.country_id='$this->country_id' OR a.country_id='0')", NULL, FALSE);
        $this->db->where("((a.state_id='$this->state_id' OR a.state_id='0') AND (a.country_id='$this->country_id' OR a.country_id='0'))", NULL, FALSE);
        $this->db->where("((a.city_id='$this->city_id' OR a.city_id='0')AND (a.state_id='$this->state_id' OR a.state_id='0'))", NULL, FALSE);
        if (isset($this->page_id))
        {
            $this->db->where('page_id', $this->page_id);
        }
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function get_location_ip to get location from IP
     */
    function get_location_ip()
    {
        $url = 'http://www.ipaddressapi.com/l/51c8694f0972e779aee37188cb5764b1197d3373c2cd?h=' . urlencode($this->ip);
        $data = file_get_contents($url);
        $ipLocatoinArray = explode(',', str_replace('"', '', $data));
        return $ipLocatoinArray;
    }

    /**
     * Function get_location_lang to get location 
     */
    public function get_location_lang()
    {
        $this->db->select('c.country_id,s.state_id,ct.city_id,c.country_iso');
        $this->db->from(TBL_COUNTRY . ' as c');
        $this->db->join(TBL_STATE . ' as s', 's.country_id = c.country_id', 'left');
        $this->db->join(TBL_CITY . ' as ct', 'ct.state_id = s.state_id', 'left');
        if (isset($this->location_eng[2]))
        {
            $this->db->where('c.country_iso', mysql_real_escape_string($this->location_eng[2]));
        }
        if (isset($this->location_eng[5]))
        {
            $this->db->where('s.state_name', mysql_real_escape_string($this->location_eng[5]));
        }
        if (isset($this->location_eng[6]))
        {
            $this->db->where('ct.city_name', mysql_real_escape_string($this->location_eng[6]));
        }
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function valid_visitor to check if IP is not a spam
     */
    function valid_visitor($ip = '', $ad_id = '', $user_id = '')
    {
        $return = '';
        $this->db->select('ip,visited_date');
        $this->db->order_by('id', 'desc');
        $this->db->from(TBL_AD_VISITORS);
        $this->db->limit('1');
        if (isset($this->ip))
        {
            $this->db->where('ip', $this->ip);
        }
        if (isset($this->id))
        {
            $this->db->where('ad_id', $this->id);
        }
        if (isset($this->user_id))
        {
            $this->db->where('user_id', $this->user_id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        if (!empty($result))
        {
            $nextdate = date("d-m-Y H:i:s");
            $return = $result[0]['visited_date'] > date("Y-m-d h:i:s", strtotime('- 1440 minutes', strtotime($nextdate))) ? FALSE : TRUE;
        }
        else if (empty($result))
        {
            $return = TRUE;
        }
        return $return;
    }

    /**
     * Function insert_visitor to insert valid visitor
     */
    function insert_visitor($ip = '', $ad_id = '', $user_id = '')
    {
        $data = array();
        $visited_date = GetCurrentDateTime();
        $data_array = array('ip' => $this->ip, 'ad_id' => mysql_real_escape_string($this->id), 'user_id' => $this->user_id, 'visited_date' => mysql_real_escape_string($visited_date));
        $this->db->set($data_array);
        $this->db->insert(TBL_AD_VISITORS);
        return $this->db->_error_number(); // return the error occurred in last query
    }

    /**
     * Function get_ad_by_languageid to get advertisements by language id
     */
    function get_ad_by_languageid($lang_id = '')
    {
        $this->db->select('a.ad_id,a.title');
        $this->db->from(TBL_ADVERTISEMENTS . ' as a');       
        $this->db->where('a.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function check_unique_title to check duplicate banner/ad title
     * @param array $data
     */
    function check_unique_title()
    {
        if (isset($this->title))
        {
            $title = $this->title;
        }
        if (isset($this->lang_id))
        {
            $lang_id = $this->lang_id;
        }
        $this->db->select('ad_id');
        $this->db->from($this->_table);
        $this->db->where('title = ', mysql_real_escape_string($title));
        $this->db->where('lang_id = ', $lang_id);
        $this->db->where('status != ', -1);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $this->db->custom_result($query);
        return $result;
    }

    /**
     * Function inactive_records to inactive records
     * @param array $id 
     */
    public function inactive_records($id = array())
    {
        $data_array = array('status' => 0, 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where_in('id', $id);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);
        return $id;
    }

    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records()
    {
        $data_array = array('status' => 0, 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);
        return true;
    }

    /**
     * Function active_records to active records
     * @param array $id 
     */
    public function active_records($id = array())
    {
        $data_array = array('status' => 1, 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where_in('id', $id);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);
        return $id;
    }

    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records()
    {
        $data_array = array('status' => 1, 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);
        return true;
    }

    /**
     * Function delete_records to delete URL
     * @param integer $id 
     */
    public function delete_records($id = array(0))
    {
        $data_array = array('status' => '-1', 'modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']);
        $this->db->where_in('id', $id);
        $this->db->set($data_array);
        return $this->db->update($this->_table);
    }
}

?>