<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Shoppingcart Payment Model
 *
 *  To perform queries related to Payment management.
 *
 * @package CIDemoApplication
 * @subpackage Shoppingcart
 * @copyright	(c) 2013, TatvaSoft
 * @author Dipak Patel <dipak.patel@sparsh.com>
 */
class Shoppingcart_payments_model extends Base_Model
{

    protected $_table = TBL_SHOPPINGCART_PAYMENT_MODULE;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    public $offset = "";
    public $module = "";

    /**
     * Function get_all_payment_module to get payment listing
     */
    function get_all_payment_module($status = -1)
    {
        if ($this->search_term != "")
        {
            $this->db->like('LOWER(scpm.title)', strtolower($this->search_term), 'both');
        }

        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }

        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('scpm.id,scpm.title,scpm.mode,scpm.status');
        $this->db->from($this->_table . ' as scpm');
        $this->db->where_not_in('scpm.status', $status);

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
     * Function insert to insert record
     */
    function insert()
    {
        $data_array = array();

        if (isset($this->title))
        {
            $data_array['title'] = $this->title;
        }

        if (isset($this->username))
        {
            $data_array['username'] = $this->username;
        }

        if (isset($this->password))
        {
            $data_array['password'] = $this->password;
        }

        if (isset($this->key))
        {
            $data_array['key'] = $this->key;
        }

        if (isset($this->mode))
        {
            $data_array['mode'] = $this->mode;
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
     * Function update to update record
     */
    function update($id)
    {
        $id = intval($id);
        $lang_id = intval($lang_id);

        $data_array = array();

        if (isset($this->title))
        {
            $data_array['title'] = $this->title;
        }

        if (isset($this->username))
        {
            $data_array['username'] = $this->username;
        }

        if (isset($this->password))
        {
            $data_array['password'] = $this->password;
        }

        if (isset($this->key))
        {
            $data_array['key'] = $this->key;
        }

        if (isset($this->mode))
        {
            $data_array['mode'] = $this->mode;
        }

        if (isset($this->status))
        {
            $data_array['status'] = $this->status;
        }

        $data_array['modify_on'] = GetCurrentDateTime();
        $data_array['modify_by'] = $this->session->userdata[get_current_section($this, true)]['user_id'];

        $this->db->where(array('id' => $id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function is_exist_payment to check for payment
     * @params integer $product_id
     * @params integer $lang_id
     */
    public function is_exist_payment($id)
    {
        $this->db->select('id')
                ->from($this->_table)
                ->where(array('id' => $id))
                ->where('status !=', -1);
        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function inactive_records to inactive records
     * @param array $id
     */
    public function inactive_records($id = array())
    {
        $this->db->set('status', 0);
        $this->db->where_in('id', $id);
        $this->db->update($this->_table);
        return $id;
    }

    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records()
    {
        $this->db->set('status', 0);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);
        return $id;
    }

    /**
     * Function active_records to active records
     * @param array $id
     */
    public function active_records($id = array())
    {
        $this->db->set('status', 1);
        $this->db->where_in('id', $id);
        $this->db->update($this->_table);
        return $id;
    }

    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records()
    {
        $this->db->set('status', 1);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);
        return $id;
    }

    /**
     * Function delete_records to delete URL
     * @param integer $id
     */
    public function delete_records($id = array())
    {
        $this->db->where_in('id', $id);
        $this->db->set('status', '-1');
        return $this->db->update($this->_table);
    }

    /**
     * Function get_payment_detail_by_id to get payment detail
     */
    public function get_payment_detail_by_id($id)
    {
        $id = intval($id);

        $this->db->select('scpm.*')
                ->from($this->_table . ' as scpm')
                ->where(array('scpm.id' => $id))
                ->where('scpm.status !=', -1);
        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function get_payment_detail_by_id to get payment detail
     */
    public function get_paypal_login_details($mode = 0, $method)
    {
        $mode = intval($mode);
        $method = trim($method);

        $this->db->select('scpm.*')
                ->from($this->_table . ' as scpm')
                ->where('scpm.status =', 1)
                ->where('scpm.method =', $method)
                ->where('scpm.mode =', $mode);
        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

}