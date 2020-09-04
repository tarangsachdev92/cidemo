<?php
/**
 *  NewsLetter Model (actual table -  subscribers)
 *
 *  To perform queries related to  subscribers management.
 * 
 * @package CIDemoApplication
 * @subpackage Newsletter
 * @copyright	(c) 2013, TatvaSoft
 * @author NIPT
 */
class Newsletter_model extends Base_Model
{
    protected $_tbl_subscribers = TBL_SUBSCRIBERS;
    protected $_tbl_category_newsletter = TBL_CATEGORIES;
    protected $_tbl_content_newsletter = TBL_CONTENT_NEWSLETTERS;
    protected $_tbl_newsletter = TBL_NEWSLETTERS;
    protected $_tbl_templates_newsletter = TBL_TEMPLATES_NEWSLETTERS;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";

    /*
     * to get all the subcribers
     */

    public function get_all_subscribers ()
    {
        if ($this->search_term != "") {
            $this->db->like ("LOWER(s.firstname)", strtolower ($this->search_term));
        }
        if ($this->sort_by != "" && $this->sort_order != "") {
            $this->db->order_by ($this->sort_by, $this->sort_order);
        }
        if (isset ($this->record_per_page) && isset ($this->offset) && !isset ($this->_record_count) && $this->_record_count != true) {
            $this->db->limit ($this->record_per_page, $this->offset);
        }
        $this->db->select ('s.*');
        $this->db->from ($this->_tbl_subscribers . ' AS s');
        $this->db->where ('s.status != ', 'deleted');
        $query = $this->db->get ();
        if (isset ($this->_record_count) && $this->_record_count == true) {
            return count ($this->db->custom_result ($query));
        } else {
            return $this->db->custom_result ($query);
        }
    }

    /**
     * Function get_user_detail to return user array of particular id
     * @param integer $id 
     */
    function get_user_detail ($id)
    {
        //Type Casting 
        $id = intval ($id);

        $this->db->where ("id", $id);
        $tableusers = $this->db->get ($this->_tbl_subscribers);
        $userArray = $tableusers->row_array ();
        return $userArray;
    }

    /**
     * Function delete_user to delete user
     * @param integer $id
     */
    public function delete_user ($id)
    {
        //Type Casting 
        $id = intval ($id);

        $this->db->where ('id', $id);
        $this->db->set ('status', 'deleted');
        return $this->db->update ($this->_tbl_subscribers);
    }
    /*
     * save the subscribers
     * @param array $data
     */

    public function save_subscribers ($data)
    {
        $this->db->set ('created_date', 'NOW()', FALSE);
        return $this->db->insert ($this->_tbl_subscribers, $data);
    }
    /*
     * update the subscribers
     * @param int $id - subscriber id, array $data
     */

    public function update_subscribers ($id, $data)
    {
        $this->db->set ('firstname', $data['firstname']);
        $this->db->set ('lastname', $data['lastname']);
        $this->db->set ('status', $data['status']);
        $this->db->set ('updated_date', 'NOW()', FALSE);
        $this->db->where ('id', $id);
        return $this->db->update ($this->_tbl_subscribers, $data);
    }
    /*
     * check the user is already exists or not
     * @param array $data
     */

    function check_unique_mail ($data)
    {
        $email = trim (strip_tags ($data['email']));
        $this->db->select ('id,email');
        $this->db->from ($this->_tbl_subscribers);
        $this->db->where ('email ', $email);
        $this->db->where ('status != ', 'deleted');
        $this->db->limit (1);
        $result = $this->db->get ()->num_rows ();
        return $result;
    }
    /*
     * check the user is already exists and status is deleted or not
     * @param array $data
     */

    function check_user_deleted ($email)
    {
        $email = trim (strip_tags ($email));
        $this->db->select ('id,email');
        $this->db->from ($this->_tbl_subscribers);
        $this->db->where ('email ', $email);
        $this->db->where ('status ', 'deleted');
        $query = $this->db->get ();
        $result = $this->db->custom_result ($query);
        return $result;
    }
    /*
     * check the user is already exists and status is deleted or not
     * @param array $data
     */

    function subscribers_user_again ($email)
    {
        $email = trim (strip_tags ($email));
        $this->db->set ('status', 'active');
        $this->db->where ('email', $email);
        $this->db->where ('created_date', 'NOW()');
        $this->db->update ($this->_tbl_subscribers);
        return true;
    }
    /*
     * send Email to subscriber
     * @params array $data
     */

    function send_email ($data)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => SMTP_HOST,
            'smtp_port' => SMTP_PORT,
            'smtp_user' => SMTP_USERNAME,
            'smtp_pass' => SMTP_PASSWORD,
            'mailtype' => "html",
            'smtp_auth' => TRUE
        );
        //load config data to email
        $this->email->initialize ($config);

        // send email to user
        $this->email->from (NEWSLETTER_FROM_EMAIL, "NewsLetter Subscription");
        $this->email->to ($data["email"]);
        $this->email->subject ('Subscribing confirmation');
        $this->email->message ($this->load->view ("email_template", $data, true));
        $this->email->send ();
    }
    /*
     * Add content on newsletter
     * @params int $newsletter_id ,int $language_id
     */

    public function save_content ($newsletter_id, $language_id)
    {
        $newsletter_id = intval ($newsletter_id);
        $language_id = intval ($language_id);

        $data_array = array ();
        $data_array['newsletter_id'] = $newsletter_id;
        $data_array['lang_id'] = $language_id;
        if (isset ($this->title)) {
            $data_array['title'] = $this->title;
        }
        if (isset ($this->content)) {
            $data_array['text'] = $this->content;
        }
        $this->db->set ($data_array);
        $this->db->insert ($this->_tbl_content_newsletter);
        return $this->db->_error_number (); // return the error occurred in last query
    }
    /*
     * update content on newsletter
     * @params int $newsletter_id ,int $language_id
     */

    public function update_content ($newsletter_id, $language_id)
    {
        $newsletter_id = intval ($newsletter_id);
        $language_id = intval ($language_id);

        $data_array = array ();
        if (isset ($this->title)) {
            $data_array['title'] = $this->title;
        }
        if (isset ($this->content)) {
            $data_array['text'] = $this->content;
        }
        $this->db->where (array ('newsletter_id' => $newsletter_id, 'lang_id' => $language_id));
        $this->db->set ($data_array);
        $this->db->update ($this->_tbl_content_newsletter);
    }
    /*
     * Add Newsletter
     * @params int $id ,int $language_id
     */

    public function add_newsletter ($id, $language_id)
    {
        $newsletter_id = intval ($id);
        $language_id = intval ($language_id);

        $data_array = array ();
        $data_array['newsletter_id'] = $newsletter_id;
        $data_array['lang_id'] = $language_id;
        if (isset ($this->subject)) {
            $data_array['subject'] = $this->subject;
        }
        if (isset ($this->category)) {
            $data_array['category_id'] = $this->category;
        }
        if (isset ($this->template)) {
            $data_array['template_id'] = $this->template;
        }
        if (isset ($this->schedule)) {
            $data_array['schedule_time'] = $this->schedule;
        }
        if (isset ($this->status)) {
            $data_array['status'] = $this->status;
        }

        $data_array['sent'] = 'no';
        $data_array['created_date'] = GetCurrentDateTime ();
        $this->db->set ($data_array);
        $this->db->insert ($this->_tbl_newsletter);
        return $this->db->_error_number (); // return the error occurred in last query
    }
    /*
     * Get all newsletters
     * @params int $language_id
     */

    public function get_all_newletters ($language_id)
    {
        if ($this->search_term != "") {
            $this->db->like ("LOWER(n.subject)", strtolower ($this->search_term));
        }
        if ($this->sort_by != "" && $this->sort_order != "") {
            $this->db->order_by ($this->sort_by, $this->sort_order);
        }
        if (isset ($this->record_per_page) && isset ($this->offset) && !isset ($this->_record_count) && $this->_record_count != true) {
            $this->db->limit ($this->record_per_page, $this->offset);
        }
        $this->db->select ('n.*,nc.*,nc.title as category_name,t.*');
        $this->db->from ($this->_tbl_newsletter . ' AS n');
        $this->db->join ($this->_tbl_category_newsletter . ' AS nc', 'n.category_id = nc.category_id', 'left');
        $this->db->join ($this->_tbl_templates_newsletter . ' as t', 'n.template_id = t.id', 'left');
        if ($language_id != '') {
            $this->db->where ("n.lang_id", $language_id);
        }
        $this->db->where ("n.status !=", 'deleted');
        $query = $this->db->get ();
        if (isset ($this->_record_count) && $this->_record_count == true) {
            return count ($this->db->custom_result ($query));
        } else {
            return $this->db->custom_result ($query);
        }
    }
    /*
     * get related language newsletter
     * @params int $newsletter_id, int $language_id
     */

    public function get_related_lang_newsletter ($newsletter_id, $language_id)
    {
        $newsletter_id = intval ($newsletter_id);
        $language_id = intval ($language_id);

        $this->db->select ('n.*');
        $this->db->from ($this->_tbl_newsletter . ' AS n');
        $this->db->where ('n.newsletter_id', $newsletter_id);
        $this->db->where ('n.lang_id', $language_id);
        $query = $this->db->get ();
        return $this->db->custom_result ($query);
    }

    /**
     * Function to get lasr newsletter inserted id
     */
    function get_last_newsletter_id ()
    {
        $this->db->select_max ('newsletter_id')
                ->from ($this->_tbl_newsletter);
        $query = $this->db->get ();
        if ($query->num_rows () > 0) {
            $result = $query->row_array ();
            return $result['newsletter_id'];
        } else {
            return 0;
        }
    }

    /**
     * Function delete_newsletter to delete newsletter
     * @param integer $id
     */
    public function delete_newsletter ($id, $lang_id)
    {
        //Type Casting 
        $id = intval ($id);
        $lang_id = intval ($lang_id);

        $this->db->where ('newsletter_id', $id);
        $this->db->where ('lang_id', $lang_id);
        $this->db->set ('status', 'deleted');
        $result = $this->db->update ($this->_tbl_newsletter);
        return $result;
    }

    /**
     * Function get_newsletter_detail to return newsletter array of particular id
     * @param integer $id , int $language_id
     */
    public function get_newsletter_detail ($id, $language_id)
    {
        //Type Casting 
        $id = intval ($id);

        $this->db->select ('n.*,c.*,nc.*,t.*');
        $this->db->from ($this->_tbl_newsletter . ' AS n');
        $this->db->join ($this->_tbl_content_newsletter . ' AS nc', 'n.newsletter_id = nc.newsletter_id', 'left');
        $this->db->join ($this->_tbl_category_newsletter . ' AS c', 'n.category_id = c.id', 'left');
        $this->db->join ($this->_tbl_templates_newsletter . ' AS t', 'n.template_id = t.template_id', 'left');
        $this->db->where ("n.newsletter_id", $id);
        $this->db->where ("n.lang_id", $language_id);
        $this->db->where ("nc.lang_id", $language_id);
        $query = $this->db->get ();
        return $this->db->custom_result ($query);
    }
    /*
     * Update Newsletter
     * @params int $id, int $language_id
     */

    public function update_newsletter ($id, $language_id)
    {
        $newsletter_id = intval ($id);
        $language_id = intval ($language_id);

        $data_array = array ();

        if (isset ($this->subject)) {
            $data_array['subject'] = $this->subject;
        }
        if (isset ($this->category)) {
            $data_array['category_id'] = $this->category;
        }
        if (isset ($this->template)) {
            $data_array['template_id'] = $this->template;
        }
        if (isset ($this->schedule)) {
            $data_array['schedule_time'] = $this->schedule;
        }
        if (isset ($this->status)) {
            $data_array['status'] = $this->status;
        }
       
        //$data_array['sent'] = 'no';
        $data_array['updated_date'] = GetCurrentDateTime ();
        $this->db->where (array ('newsletter_id' => $newsletter_id, 'lang_id' => $language_id));
        $this->db->set ($data_array);
        $this->db->update ($this->_tbl_newsletter);
    }
    /*
     * Get all newsletters
     */

    public function get_all_active_newsletters ()
    {
        $this->db->select ('n.*,nc.*,c.*,t.*');
        $this->db->from ($this->_tbl_newsletter . ' AS n');
        $this->db->join ($this->_tbl_category_newsletter . ' AS nc', 'n.category_id = nc.id', 'inner');
        $this->db->join ($this->_tbl_content_newsletter . ' AS c', 'n.newsletter_id = c.newsletter_id AND n.lang_id = c.lang_id', 'inner');
        $this->db->join ($this->_tbl_templates_newsletter . ' AS t', 'n.template_id = t.id', 'inner');
        $this->db->where ('n.status', 'active');
        $this->db->where ('n.schedule_time ', date ('Y-m-d'));
        $this->db->group_by ('n.id');
        $query = $this->db->get ();
        $result = $this->db->custom_result ($query);
        return $result;
    }
    /*
     * to get all active subcribers
     */

    public function get_all_active_subscribers ()
    {
        $this->db->select ('s.*');
        $this->db->from ($this->_tbl_subscribers . ' AS s');
        $this->db->where ('s.status', 'active');
        $query = $this->db->get ();
        $result = $this->db->custom_result ($query);
        return $result;
    }
    /*
     * update newsletter sent status
     * @params int $id
     */

    public function update_newsletter_sent_status ($id)
    {
        
        $data = array ('sent' => 'yes');
        $this->db->where ('newsletter_id', $id);
        $this->db->update ($this->_tbl_newsletter, $data);
    }
    /*
     * send Email to newsletters
     * @params array $data
     */

    public function send_newsletter ($data)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => SMTP_HOST,
            'smtp_port' => SMTP_PORT,
            'smtp_user' => SMTP_USERNAME,
            'smtp_pass' => SMTP_PASSWORD,
            'mailtype' => "html",
            'smtp_auth' => TRUE
        );
        $this->email->initialize ($config);
        $this->email->from (NEWSLETTER_FROM_EMAIL, $data['subject']);
        $this->email->to ($data['to']);
        $this->email->subject ($data['subject']);
        if (empty ($data['template'])) {
            $template = $this->get_template_detail ($data['template_id'], $data['language_id']);
            $this->email->message ($this->load->view ($template[0]['tn']['template_view_file'], $data, true));
        } else {
            $this->email->message ($this->load->view ($data['template'], $data, true));
        }
        $sent = $this->email->send ();
        if ($sent) {
            return $this->update_newsletter_sent_status ($data['id']);
        } else {
            return false;
        }
    }
    /*
     * unsubscribe users
     * @params int $id
     */

    public function unsubscribe_user ($id)
    {
        if (!empty ($id)) {
            //Type Casting 
            $id = intval ($id);

            $data = array ('status' => 'inactive', 'updated_date' => 'NOW()');
            $this->db->where ('id', $id);
            if ($this->db->update ($this->_tbl_subscribers, $data)) {
                return true;
            }
        } else {
            return false;
        }
    }
    /*
     * add newsletter templates
     * @params int $template_id,int $language_id
     */

    public function add_newsletter_template ($template_id, $language_id)
    {
        $template_id = intval ($template_id);
        $language_id = intval ($language_id);

        $data_array = array ();

        $data_array['template_id'] = $template_id;
        $data_array['lang_id'] = $language_id;
        if (isset ($this->template_title)) {
            $data_array['template_title'] = $this->template_title;
        }
        if (isset ($this->template_view_file)) {
            $data_array['template_view_file'] = $this->template_view_file;
        }
        $data_array['created_date'] = GetCurrentDateTime ();

        $this->db->set ($data_array);
        $this->db->insert ($this->_tbl_templates_newsletter);
        return $this->db->_error_number (); // return the error occurred in last query
    }
    /*
     * get related language template
     * @params int $template_id,int $language_id
     */

    public function get_related_lang_template ($template_id, $language_id)
    {
        $template_id = intval ($template_id);
        $language_id = intval ($language_id);

        $this->db->select ('tn.*');
        $this->db->from ($this->_tbl_templates_newsletter . ' AS tn');
        $this->db->where ('tn.template_id', $template_id);
        $this->db->where ('tn.lang_id', $language_id);
        $query = $this->db->get ();
        return $this->db->custom_result ($query);
    }

    /**
     * Function to get last template inserted id
     */
    function get_last_template_id ()
    {
        $this->db->select_max ('template_id')
                ->from ($this->_tbl_templates_newsletter);
        $query = $this->db->get ();
        if ($query->num_rows () > 0) {
            $result = $query->row_array ();
            return $result['template_id'];
        } else {
            return 0;
        }
    }
    /*
     * to get all the templates
     * @params int $language_id
     */

    public function get_all_templates ($language_id)
    {

        if ($this->search_term != "") {
            $this->db->like ("LOWER(t.template_title)", strtolower ($this->search_term));
        }
        if ($this->sort_by != "" && $this->sort_order != "") {
            $this->db->order_by ($this->sort_by, $this->sort_order);
        }

        if (isset ($this->record_per_page) && isset ($this->offset) && !isset ($this->_record_count) && $this->_record_count != true) {
            $this->db->limit ($this->record_per_page, $this->offset);
        }
        $this->db->select ('t.*');
        $this->db->from ($this->_tbl_templates_newsletter . ' AS t');
        if ($language_id != '') {
            $this->db->where ("t.lang_id", $language_id);
        }
        $query = $this->db->get ();
        if (isset ($this->_record_count) && $this->_record_count == true) {
            return count ($this->db->custom_result ($query));
        } else {
            return $this->db->custom_result ($query);
        }
    }

    /**
     * Function get_template_detail to return template array of particular id
     * @param integer $id ,int $language_id
     */
    function get_template_detail ($id, $language_id)
    {
        $template_id = intval ($id);
        $lang_id = intval ($language_id);

        $this->db->select ('tn.*');
        $this->db->from ($this->_tbl_templates_newsletter . ' AS tn');
        $this->db->where (array ('tn.template_id' => $template_id, 'tn.lang_id' => $lang_id));
        $query = $this->db->get ();
        return $this->db->custom_result ($query);
    }
    /*
     * Update template details
     * @params int $id, int $language_id
     */

    function update_templates ($id, $language_id)
    {
        $template_id = intval ($id);
        $language_id = intval ($language_id);

        $data_array = array ();

        if (isset ($this->template_title)) {
            $data_array['template_title'] = $this->template_title;
        }
        if (isset ($this->template_view_file)) {
            $data_array['template_view_file'] = $this->template_view_file;
        }
        $data_array['updated_date'] = GetCurrentDateTime ();

        $this->db->where (array ('template_id' => $template_id, 'lang_id' => $language_id));
        $this->db->set ($data_array);
        $this->db->update ($this->_tbl_templates_newsletter);
    }
    /*
     * delete template
     * @params int $id - template id
     */

    function delete_template ($id, $language_id)
    {
        //Type Casting 
        $id = intval ($id);
        $language_id = intval ($language_id);

        $this->db->where ('template_id', $id);
        $this->db->where ('lang_id', $language_id);
        return $this->db->delete ($this->_tbl_templates_newsletter);
    }
    /*
     * get all category
     */

    public function get_all_category ()
    {

        $this->db->select ('cn.*,cn.title as category_name');
        $this->db->from ($this->_tbl_category_newsletter . ' AS cn');
        $this->db->where ('cn.module_id', '2');
        $query = $this->db->get ();
        $result = $this->db->custom_result ($query);

        return $result;
    }

    /**
     * Function inactive_records to inactive records
     * @param array $id 
     */
    public function inactive_records_subscribers ($id = array ())
    {
        $this->db->set ('status', 'inactive');
        $this->db->where_in ('id', $id);
        $this->db->update ($this->_tbl_subscribers);

        return $id;
    }

    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records_subscribers ()
    {
        $this->db->set ('status', 'inactive');
        $this->db->where ('status !=', 'deleted');
        $this->db->where ('id !=', 'active');
        $this->db->update ($this->_tbl_subscribers);

        return true;
    }

    /**
     * Function active_records to active records
     * @param array $id 
     */
    public function active_records_subscribers ($id = array ())
    {
        $this->db->set ('status', 'active');
        $this->db->where_in ('id', $id);
        $this->db->update ($this->_tbl_subscribers);

        return $id;
    }

    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records_subscribers ()
    {
        $this->db->set ('status', 'active');
        $this->db->where ('status !=', 'deleted');
        $this->db->where ('id !=', 'active');
        $this->db->update ($this->_tbl_subscribers);

        return true;
    }

    /**
     * Function delete_records to delete URL
     * @param integer $id 
     */
    public function delete_records_subscribers ($id = array ())
    {
        $this->db->where_in ('id', $id);
        $this->db->set ('status', 'deleted');
        return $this->db->update ($this->_tbl_subscribers);
    }

    /**
     * Function inactive_records to inactive records
     * @param array $id 
     */
    public function inactive_records_newsletters ($id = array ())
    {
        $this->db->set ('status', 'inactive');
        $this->db->where_in ('id', $id);
        $this->db->update ($this->_tbl_newsletter);

        return $id;
    }

    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records_newsletters ()
    {
        $this->db->set ('status', 'inactive');
        $this->db->where ('status !=', 'deleted');
        $this->db->where ('id !=', 'active');
        $this->db->update ($this->_tbl_newsletter);

        return true;
    }

    /**
     * Function active_records to active records
     * @param array $id 
     */
    public function active_records_newsletters ($id = array ())
    {
        $this->db->set ('status', 'active');
        $this->db->where_in ('id', $id);
        $this->db->update ($this->_tbl_newsletter);

        return $id;
    }

    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records_newsletters ()
    {
        $this->db->set ('status', 'active');
        $this->db->where ('status !=', 'deleted');
        $this->db->where ('id !=', 'active');
        $this->db->update ($this->_tbl_newsletter);

        return true;
    }

    /**
     * Function delete_records to delete URL
     * @param integer $id 
     */
    public function delete_records_newsletters ($id = array ())
    {
        $this->db->where_in ('id', $id);
        $this->db->set ('status', 'deleted');
        return $this->db->update ($this->_tbl_newsletter);
    }
}

?>