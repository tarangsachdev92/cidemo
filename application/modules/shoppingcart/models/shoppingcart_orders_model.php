<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Shoppingcart Orders Model
 *
 *  To perform queries related to Order management.
 *
 * @package CIDemoApplication
 * @subpackage Shoppingcart
 * @copyright	(c) 2013, TatvaSoft
 * @author Bhavesh Patel <bhavesh.patel@sparsh.com>
 */
class Shoppingcart_orders_model extends Base_Model
{

    protected $_table = TBL_SHOPPINGCART_ORDERS;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    public $offset = "";
    public $module = "";

    /**
     * Function get_all_orders to get orders
     */
    function get_all_orders()
    {
        if ($this->search_term != "")
        {
            $this->db->like('LOWER(u.firstname)', strtolower($this->search_term), 'both');
        }

        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }

        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count))
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('sco.*,u.*');
        $this->db->from($this->_table . ' AS sco');
        $this->db->join(TBL_USERS . ' AS u ', 'sco.user_id = u.id', 'left');
        $this->db->where('u.status !=', -1);
        $que_order = $this->db->get();

        if (isset($this->_record_count) && $this->_record_count == true)
        {
            $result_order = count($this->db->custom_result($que_order));
        }
        else
        {
            $result_order = $this->db->custom_result($que_order);
        }

        return $result_order;
    }

    /**
     * Function is_order_exist to check for order
     * @params integer $order_id
     */
    function is_order_exist($order_id)
    {
        $order_id = intval($order_id);
        $this->db->select('sco.*,u.*');
        $this->db->from($this->_table . ' AS sco');
        $this->db->join(TBL_USERS . ' AS u ', 'sco.user_id = u.id', 'left');
        $this->db->where('u.status !=', -1);
        $this->db->where('sco.id =', $order_id);
        $que_oneorder = $this->db->get();
        $result_oneorder = $this->db->custom_result($que_oneorder);
        return $result_oneorder;
    }

    /**
     * Function update_order to update order record
     * @params integer $order_id
     * @params array $data_array
     */
    function update_order($order_id, $data_array)
    {
        $order_id = intval($order_id);
        $this->db->where(array('id' => $order_id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_order_detail_by_id to get order detail
     * @params integer $order_id
     */
    function get_order_detail_by_id($order_id)
    {
        $order_id = intval($order_id);
        $this->db->select('sco.*,u.*');
        $this->db->from($this->_table . ' AS sco');
        $this->db->join(TBL_USERS . ' AS u ', 'sco.user_id = u.id', 'left');
        $this->db->where('u.status !=', -1);
        $this->db->where('sco.id =', $order_id);
        $que_odetail = $this->db->get();
        $result_odetail = $this->db->custom_result($que_odetail);
        return $result_odetail;
    }

    /**
     * Function get_billaddress_detail_by_id to get billing address detail
     * @params integer $bill_id
     */
    function get_billaddress_detail_by_id($bill_id)
    {
        $bill_id = intval($bill_id);
        $this->db->select('scba.*');
        $this->db->from(TBL_SHOPPINGCART_BILLING_ADDRESS . ' AS scba');
        $this->db->where('scba.id =', $bill_id);
        $que_bill = $this->db->get();
        $result_bill = $this->db->custom_result($que_bill);
        return $result_bill;
    }

    /**
     * Function get_shipaddress_detail_by_id to get shipping address detail
     * @params integer $ship_id
     */
    function get_shipaddress_detail_by_id($ship_id)
    {
        $ship_id = intval($ship_id);
        $this->db->select('scsa.*');
        $this->db->from(TBL_SHOPPINGCART_SHIPPING_ADDRESS . ' AS scsa');
        $this->db->where('scsa.id =', $ship_id);
        $que_ship = $this->db->get();
        $result_ship = $this->db->custom_result($que_ship);
        return $result_ship;
    }

    /**
     * Function get_order_items to get order items
     * @params integer $order_id
     */
    function get_order_items($order_id)
    {
        $order_id = intval($order_id);
        $this->db->select('sco.*,scoi.*');
        $this->db->from(TBL_SHOPPINGCART_ORDER_ITEMS . ' AS scoi');
        $this->db->join($this->_table . ' AS sco ', 'sco.id = scoi.order_id', 'inner');
        $this->db->where('sco.id =', $order_id);
        $this->db->where('scoi.order_id =', $order_id);
        $que_oidetail = $this->db->get();
        $result_oidetail = $this->db->custom_result($que_oidetail);
        return $result_oidetail;
    }

    /**
     * Function get_best_seller_items to get best/most seller items
     * @params integer $order_id
     */
    function get_best_seller_items($language_id,$is_admin=0)
    {
        $language_id = intval($language_id);
        $is_admin = intval($is_admin);

        if($is_admin == 1)
        {
            $this->db->select('count(scoi.product_id) as c,scp.id,scp.product_id,scp.name,scp.price,scp.slug_url,scp.product_image,scp.currency_code,scp.stock,scp.discount_price,scp.status');
            $this->db->from(TBL_SHOPPINGCART_ORDER_ITEMS . ' AS scoi');
            $this->db->join(TBL_SHOPPINGCART_ORDERS . ' AS sco ', 'sco.id = scoi.order_id', 'left');
            $this->db->join(TBL_SHOPPINGCART_PRODUCTS . ' AS scp ', 'scp.product_id = scoi.product_id', 'left');
            $this->db->where('scoi.lang_id =', $language_id);
            $this->db->where('sco.order_status !=', 1);
        }
        else
        {
            $this->db->select('count(scoi.product_id) as c,scp.id,scp.product_id,scp.name,scp.price,scp.slug_url,scp.product_image,scp.currency_code,scp.stock,scp.discount_price,scp.status');
            $this->db->from(TBL_SHOPPINGCART_ORDER_ITEMS . ' AS scoi');
            $this->db->join(TBL_SHOPPINGCART_PRODUCTS . ' AS scp ', 'scp.product_id = scoi.product_id', 'left');
            $this->db->where('scoi.lang_id =', $language_id);
            $this->db->where('scp.status =', 1);
        }

        $this->db->group_by('scoi.product_id');
        $this->db->order_by('c','DESC');
        $this->db->limit(10);
        $que_oidetail = $this->db->get();

        $result_oidetail = $this->db->custom_result($que_oidetail);
        return $result_oidetail;
    }

    /**
     * Function get_current_month_order_details to get today/this week and this month order details and status
     * @params integer $language_id
     * @params integer $status
     * @params string $type
     */
    function get_current_month_order_details($language_id,$type,$status)
    {
        $language_id = intval($language_id);
        $status = intval($status);
        $type = trim($type);

        $this->db->select("count(scoi.id) as cnt");
        $this->db->from($this->_table . ' AS scoi');
        $this->db->where('scoi.lang_id =', $language_id);

        if($type== 'month')
        {
             $this->db->where('scoi.order_date <=',date('Y-m-d'));
             $this->db->where('scoi.order_date >=',date('Y-m-01'));
        }
        else if($type == 'today')
        {
            $this->db->where('scoi.order_date =',date('Y-m-d'));
        }
        elseif($type== 'week')
        {
             $this->db->where('scoi.order_date <=',date('Y-m-d'));
             $this->db->where('scoi.order_date >=',date('Y-m-d', strtotime('previous monday')));
        }

        $this->db->where('scoi.order_status',$status);
        $que_oidetail = $this->db->get();
        $result_oidetail = $this->db->custom_result($que_oidetail);
        return $result_oidetail;
    }

    /**
     * Function get_current_month_order_total_details to get gross price for today/this week and this month order details and status
     * @params integer $language_id
     * @params integer $status
     * @params string $type
     */
    function get_current_month_order_total_details($language_id,$type,$status)
    {
        $language_id = intval($language_id);
        $status = intval($status);
        $type = trim($type);

        $this->db->select("sum(scoi.total_amount) as gross_total");
        $this->db->from($this->_table . ' AS scoi');
        $this->db->where('scoi.lang_id =', $language_id);

        if($type== 'month')
        {
             $this->db->where('scoi.order_date <=',date('Y-m-d'));
             $this->db->where('scoi.order_date >=',date('Y-m-01'));
        }
        else if($type == 'today')
        {
            $this->db->where('scoi.order_date =',date('Y-m-d'));
        }
        elseif($type== 'week')
        {
             $this->db->where('scoi.order_date <=',date('Y-m-d'));
             $this->db->where('scoi.order_date >=',date('Y-m-d', strtotime('previous monday')));
        }

        $que_oidetail = $this->db->get();
        $result_oidetail = $this->db->custom_result($que_oidetail);
        return $result_oidetail;
    }

    /**
     * Function get_user_all_orders to get user order history
     */
    function get_user_all_orders()
    {
        $this->db->select('sco.id,sco.total_amount,sco.order_date,sco.order_status,sco.currency_code');
        $this->db->from($this->_table . ' AS sco');
        $this->db->where('sco.user_id =', $this->session->userdata['front']['user_id']);
        $this->db->order_by('sco.order_date','DESC');

        $que_oidetail = $this->db->get();
        $result_oidetail = $this->db->custom_result($que_oidetail);
        return $result_oidetail;
    }

    /**
     * Function get_user_order_detail_by_id to get user order by id
     * @params integer $order_id
     */
    function get_user_order_detail_by_id($order_id)
    {
        $order_id = intval($order_id);

        $this->db->select('sco.*,scoi.*,scp.*,l.*');
        $this->db->from($this->_table . ' AS sco');
        $this->db->join(TBL_SHOPPINGCART_ORDER_ITEMS . ' AS scoi',  'sco.id = scoi.order_id', 'left');
        $this->db->join(TBL_SHOPPINGCART_PRODUCTS . ' AS scp ', 'scp.product_id = scoi.product_id', 'left');
        $this->db->join(TBL_LANGUAGES . ' as l', 'sco.lang_id = l.id', 'inner');
        // $this->db->where('scoi.lang_id =', $language_id);
        // $this->db->where('sco.order_status !=', 1);
        $this->db->where('sco.user_id =', $this->session->userdata['front']['user_id']);
        $this->db->where('sco.id =', $order_id);
         $this->db->group_by('scoi.product_id');
        $this->db->order_by('sco.order_date','DESC');

        //$this->db->limit(10);
        $que_oidetail = $this->db->get();
        //echo $this->db->last_query();die;
        $result_oidetail = $this->db->custom_result($que_oidetail);
        return $result_oidetail;
    }
}