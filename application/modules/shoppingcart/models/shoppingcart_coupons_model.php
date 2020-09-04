<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Shoppingcart Coupon Model
 *
 *  To perform queries related to Coupon management.
 *
 * @package CIDemoApplication
 * @subpackage Shoppingcart
 * @copyright	(c) 2013, TatvaSoft
 * @author Bhavesh Patel <bhavesh.patel@sparsh.com>
 */
class Shoppingcart_coupons_model extends Base_Model
{

    protected $_table = TBL_SHOPPINGCART_COUPONS;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    public $offset = "";
    public $module = "";

    /**
     * List get_all_coupons all coupons 
     */
    public function get_all_coupons()
    {
        if ($this->search_term != "")
        {
            $this->db->like('LOWER(sccp.coupon_name)', strtolower($this->search_term), 'both');
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count))
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('sccp.*');
        $this->db->from($this->_table . ' AS sccp');
        $this->db->where('sccp.status !=', -1);
        $que_coupon = $this->db->get();

        if (isset($this->_record_count) && $this->_record_count == true)
        {
            $result_coupon = count($this->db->custom_result($que_coupon));
        }
        else
        {
            $result_coupon = $this->db->custom_result($que_coupon);
        }
        return $result_coupon;
    }

    /**
     * Function delete_coupon for delete coupon
     * @param integer $id 
     */
    public function delete_coupon($id)
    {
        $id = intval($id);
        
        $data_array = array('status' => '-1');
        $this->db->where('id', intval($id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function is_coupon_exist to check if coupon is exists or not
     * @param integer $coupon_id 
     */
    public function is_coupon_exist($coupon_id)
    {
        $coupon_id = intval($coupon_id);

        $this->db->select('sccp.id')
                ->from($this->_table . ' as sccp')
                ->where(array('sccp.id' => $coupon_id))
                ->where('sccp.status !=', -1);
        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function update_coupon to update coupon
     * @param integer $coupon_id
     * @param array $coupon_ins_update_data
     */
    function update_coupon($coupon_id, $coupon_ins_update_data)
    {
        $coupon_id = intval($coupon_id);
        $this->db->where(array('id' => $coupon_id));
        $this->db->set($coupon_ins_update_data);
        $this->db->update($this->_table);
    }

    /**
     * Function insert_coupon to insert coupon
     * @param array $coupon_ins_update_data
     */
    function insert_coupon($coupon_ins_update_data)
    {
        $this->db->set($coupon_ins_update_data);
        $this->db->insert($this->_table);
        return $this->db->_error_number(); // return the error occurred in last query
    }

    /**
     * Function get_coupon_detail_by_id to get coupon detail
     * @param integer $coupon_id
     */
    public function get_coupon_detail_by_id($coupon_id)
    {
        $coupon_id = intval($coupon_id);
        $this->db->select('sccp.*')
                ->from($this->_table . ' as sccp')
                ->where(array('sccp.id' => $coupon_id))
                ->where('sccp.status !=', -1);
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

}