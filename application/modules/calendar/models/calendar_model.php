<?php

/**
 *  Calendar Model
 *
 *  To perform queries related to events with calendar.
 * 
 * @package CIDemoApplication
 * @subpackage Calendar
 * @author PS/KG
 */
class Calendar_model extends Base_Model
{

    protected $_tbl_evntcal = TBL_EVENTCAL;
    protected $_tbl_language = TBL_LANGUAGES;
    protected $_tbl_users = TBL_USERS;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    public $offset = "";
    public $search_type = "";
    public $date_from = "";
    public $date_to = "";

    function __construct()
    {
        parent::__construct();
    }

    /*
     * Function insert_event to insert event details
     */
    function insert_event($event_id, $language_id, $u_id)
    {
        $event_id = intval($event_id);
        $language_id = intval($language_id);
        $u_id = intval($u_id);
        $data_array = array();
        $data_array['event_id'] = $event_id;
        $data_array['lang_id'] = $language_id;
        $data_array['user_id'] = $u_id;
        if (isset($this->event_title))
        {
            $data_array['event_title'] = $this->event_title;
        }
        if (isset($this->event_desc))
        {
            $data_array['event_desc'] = $this->event_desc;
        }
        if (isset($this->event_location))
        {
            $data_array['event_location'] = $this->event_location;
        }
        if (isset($this->event_organizer))
        {
            $data_array['event_organizer'] = $this->event_organizer;
        }
        if (isset($this->event_fees))
        {
            $data_array['event_fees'] = $this->event_fees;
        }
        if (isset($this->event_repeat))
        {
            $data_array['event_recurrence'] = $this->event_repeat;
        }
        if (isset($this->repeat_end_date))
        {
            $data_array['repeat_end_date'] = $this->repeat_end_date;
        }
        if (isset($this->repeat))
        {
            $data_array['recurrence'] = $this->repeat;
        }
        if (isset($this->is_repeat))
        {
            $data_array['repeated'] = $this->is_repeat;
        }
        if (isset($this->privacy))
        {
            $data_array['privacy'] = $this->privacy;
        }
        if (isset($this->start_date))
        {
            $data_array['start_date'] = $this->start_date;
        }
        if (isset($this->end_date))
        {
            $data_array['end_date'] = $this->end_date;
        }
        if (isset($this->start_time))
        {
            $data_array['start_time'] = $this->start_time;
        }
        if (isset($this->end_time))
        {
            $data_array['end_time'] = $this->end_time;
        }
        $data_array['created_on'] = GetCurrentDateTime();
        $data_array['created_by'] = $this->session->userdata[get_current_section($this, true)]['user_id'];
        $this->db->set($data_array);
        $this->db->insert($this->_tbl_evntcal);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }

    /*
     * Function get_event_list to event details
     */
    function get_event_list($language_id, $u_id)
    {
        $language_id = intval($language_id);
        if ($this->search_type == 'event_title')
        {
            if ($this->search_term != "")
            {
                $this->db->like('LOWER(e.event_title)', strtolower($this->search_term), 'both');
            }
        }
        else if ($this->search_type == 'event_description')
        {
            if ($this->search_term != "")
            {
                $this->db->like('LOWER(e.event_desc)', strtolower($this->search_term), 'both');
            }
        }
        else if ($this->search_type == 'event_location')
        {
            if ($this->search_term != "")
            {
                $this->db->like('LOWER(e.event_location)', strtolower($this->search_term), 'both');
            }
        }
        else if ($this->search_type == 'event_organizer')
        {
            if ($this->search_term != "")
            {
                $this->db->like('LOWER(e.event_organizer)', strtolower($this->search_term), 'both');
            }
        }
        else if ($this->search_type == 'event_fees')
        {
            if ($this->search_term != "")
            {
                $this->db->like('e.event_fees', $this->search_term);
            }
        }
        else if ($this->search_type == 'start_date')
        {
            if ($this->date_from != '' && $this->date_to == '')
            {
                $this->db->where('e.start_date >=', $this->date_from);
            }
            if ($this->date_from == '' && $this->date_to != '')
            {
                $this->db->where('e.start_date <=', $this->date_to);
            }
            if ($this->date_from != '' && $this->date_to != '')
            {
                $this->db->where('e.start_date >=', $this->date_from);
                $this->db->where('e.start_date <=', $this->date_to);
            }
        }
        else if ($this->search_type == 'end_date')
        {
            if ($this->date_from != '' && $this->date_to == '')
            {
                $this->db->where('e.end_date >=', $this->date_from);
            }
            if ($this->date_from == '' && $this->date_to != '')
            {
                $this->db->where('e.end_date <=', $this->date_to);
            }
            if ($this->date_from != '' && $this->date_to != '')
            {
                $this->db->where('e.end_date >=', $this->date_from);
                $this->db->where('e.end_date <=', $this->date_to);
            }
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('e.*', 'l.*');
        $this->db->from($this->_tbl_evntcal . " as e", $this->_tbl_language . " as l");
        $this->db->join($this->_tbl_language . " as l", 'e.lang_id=l.id', 'left');
        $this->db->where('e.deleted', '0');
        $this->db->where('e.user_id', $u_id);
        if ($language_id != '')
        {
            $this->db->where("e.lang_id", $language_id);
        }
        $query = $this->db->get();
        if (isset($this->_record_count) && $this->_record_count == true)
        {
            return count($query->result_array());
        }
        else
        {
            return $query->result_array();
        }
    }

    /*
     * Function update_event to update event details
     */
    function update_eve($event_id, $language_id, $u_id)
    {
        $event_id = intval($event_id);
        $language_id = intval($language_id);
        $u_id = intval($u_id);
        $data_array = array();
        if (isset($this->event_title))
        {
            $data_array['event_title'] = $this->event_title;
        }
        if (isset($this->event_desc))
        {
            $data_array['event_desc'] = $this->event_desc;
        }
        if (isset($this->event_location))
        {
            $data_array['event_location'] = $this->event_location;
        }
        if (isset($this->event_organizer))
        {
            $data_array['event_organizer'] = $this->event_organizer;
        }
        if (isset($this->event_fees))
        {
            $data_array['event_fees'] = $this->event_fees;
        }
        if (isset($this->repeat))
        {
            $data_array['recurrence'] = $this->repeat;
        }
        if (isset($this->repeat_end_date))
        {
            $data_array['repeat_end_date'] = $this->repeat_end_date;
        }
        if (isset($this->is_repeat))
        {
            $data_array['repeated'] = $this->is_repeat;
        }
        if (isset($this->privacy))
        {
            $data_array['privacy'] = $this->privacy;
        }
        if (isset($this->start_date))
        {
            $data_array['start_date'] = $this->start_date;
        }
        if (isset($this->end_date))
        {
            $data_array['end_date'] = $this->end_date;
        }
        if (isset($this->start_time))
        {
            $data_array['start_time'] = $this->start_time;
        }
        if (isset($this->end_time))
        {
            $data_array['end_time'] = $this->end_time;
        }
        $data_array['modified_on'] = GetCurrentDateTime();
        $data_array['modified_by'] = $this->session->userdata[get_current_section($this, true)]['user_id'];
        $this->db->where(array('event_id' => $event_id, 'lang_id' => $language_id));
        $this->db->set($data_array);
        $this->db->update($this->_tbl_evntcal);
    }

    /*
     * Function get_last_eve_id to get last event inserted id
     */
    function get_last_eve_id()
    {
        $this->db->select_max('event_id')
                ->from($this->_tbl_evntcal);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['event_id'];
        }
        else
        {
            return 0;
        }
    }

    /*
     * Function get_event_detail_by_id to fetch event detail by id
     */
    public function get_event_detail_by_id($event_id, $lang_id)
    {
        $event_id = intval($event_id);
        $lang_id = intval($lang_id);
        $this->db->select('e.start_date,e.end_date,e.start_time,e.end_time,e.repeat_end_date,e.repeated,e.event_id,e.recurrence,e.privacy')
                 ->where(array('e.event_id' => $event_id))
                 ->where('e.deleted', 0);
        $datetime = $this->db->get($this->_tbl_evntcal . ' as e');
        $first = $datetime->row_array();
        $this->db->select('e.event_title,e.event_desc,e.event_location,e.event_organizer,e.event_fees')
                 ->where(array('e.event_id' => $event_id, 'e.lang_id' => $lang_id))
                 ->where('e.deleted', 0);
        $alldata = $this->db->get($this->_tbl_evntcal . ' as e');
        return $first+=$alldata->row_array();
    }

    /*
     * Function delete_event to delete event
     */
    function delete_event($id)
    {
        $id = intval($id);
        $data_array = array('e.deleted' => '1');
        $this->db->where('e.event_id', $id);
        $this->db->set($data_array);
        $this->db->update($this->_tbl_evntcal . ' as e');
    }

    /*
     * Function is_event_exist to check for event exist or not
     */
    public function is_event_exist($event_id, $lang_id)
    {
        $event_id = intval($event_id);
        $lang_id = intval($lang_id);
        $this->db->select('e.*')
                 ->from($this->_tbl_evntcal . ' as e')
                 ->where(array('e.event_id' => $event_id, 'e.lang_id' => $lang_id))
                 ->where('e.deleted', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * Function send_mail to send email
     */
    public function send_email($data)
    {
        $this->load->library('email');
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => SMTP_HOST_EVENT,
            'smtp_port' => SMTP_PORT_EVENT,
            'smtp_user' => SMTP_USERNAME_EVENT,
            'smtp_pass' => SMTP_PASSWORD_EVENT,
            'mailtype' => "html"
        );
        if (isset($data['post']['txtbox']))
        {
            $count = count($data['post']['txtbox']);
            $data['post']['txtbox'][$count] = $data['post']['email'];
        }
        else
        {
            $data['post']['txtbox'] = $data['post']['email'];
        }
        if ($data['section_name'] == 'front' && $data['type'] == 'private')
        {
            $this->email->initialize($config);
            $this->email->from($this->session->userdata['front']['email'], $this->session->userdata['front']['firstname']);
        }
        elseif ($data['section_name'] == 'admin')
        {
            $this->email->initialize($config);
            $this->email->from($this->session->userdata['admin']['email'], $this->session->userdata['admin']['firstname']);
        }
        else
        {
            $this->email->initialize($config);
            $this->email->from(SITE_FROM_EMAIL, SITE_NAME);
        }
        $this->email->to($data['post']['txtbox']);
        $this->email->subject('Events Details');
        $this->email->message($this->load->view("email_template", $data, true));
        $this->email->send();
        return true;
    }

    /*
     * Function to get admin id
     */
    function get_all_admin_id()
    {
        $this->db->select('u.id')
                 ->from($this->_tbl_users . ' as u')
                 ->where('u.role_id', '1');
        $query = $this->db->get();
        return($query->result_array());
    }

    /*
     * Function to get admin events
     */
    function get_admin_events($lang_id)
    {
        $language_id = intval($lang_id);
        $a = array();
        $a = $this->get_all_admin_id();
        if ($this->search_type == 'event_title')
        {
            if ($this->search_term != "")
            {
                $this->db->like('LOWER(e.event_title)', strtolower($this->search_term), 'both');
            }
        }
        else if ($this->search_type == 'event_description')
        {
            if ($this->search_term != "")
            {
                $this->db->like('LOWER(e.event_desc)', strtolower($this->search_term), 'both');
            }
        }
        else if ($this->search_type == 'event_location')
        {
            if ($this->search_term != "")
            {
                $this->db->like('LOWER(e.event_location)', strtolower($this->search_term), 'both');
            }
        }
        else if ($this->search_type == 'event_organizer')
        {
            if ($this->search_term != "")
            {
                $this->db->like('LOWER(e.event_organizer)', strtolower($this->search_term), 'both');
            }
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('e.*');
        for ($i = 1; $i < count($a); $i++)
        {
            $data[] = $a[$i]['id'];
        }
        $this->db->or_where_in('user_id', $data);
        $this->db->where('e.deleted', 0);
        $this->db->where('e.lang_id', $language_id);
        $this->db->where('e.privacy', 0);
        if ($this->date_from != '' && $this->date_from != '0000-00-00' && $this->date_to == '')
        {
            $this->db->where('e.start_date', $this->date_from);
        }
        if ($this->date_to != '' && $this->date_to != '0000-00-00' && $this->date_from == '')
        {
            $this->db->where('e.end_date', $this->date_to);
        }
        if ($this->date_from != '' && $this->date_to != '')
        {
            $this->db->where('e.start_date >=', $this->date_from);
            $this->db->where('e.end_date <=', $this->date_to);
        }
        $datetime = $this->db->get($this->_tbl_evntcal . ' as e');
        if (isset($this->_record_count) && $this->_record_count == true)
        {
            return count($datetime->result_array());
        }
        else
        {
            return($datetime->result_array());
        }
    }
}

?>
