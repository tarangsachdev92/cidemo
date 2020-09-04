<?php

/**
 *  product image Model
 *
 *  To perform queries related to product image management.
 *
 * @package CIDemoApplication
 * @subpackage product
 * @copyright	(c) 2013, TatvaSoft
 * @author dipesh gangani <dipesh.gangani@sparsh.com>
 */
class Products_image_model extends Base_Model
{

    protected $_table = TBL_PRODUCTS_IMAGES;
    public $search_status = "";
    public $sort_by = "sort_order";
    public $sort_order = "ASC";
    public $offset = "";  
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Function insert is to insert record
     */
    function insert($product_id)
    {
        $product_id = intval($product_id);

        $data_array = array();

        $data_array['product_id'] = $product_id;

        if (isset($this->product_image))
        {
            $data_array['product_image'] = $this->product_image;
        }

        if (isset($this->status))
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
     * Function update  to update record
     */
    function update($id, $product_id)
    {

        $id = intval($id);
        $product_id = intval($product_id);

        $data_array = array();

        $data_array['product_id'] = $product_id;

        if (isset($this->product_image))
        {
            $data_array['product_image'] = $this->product_image;
        }

        if (isset($this->status))
        {
            $data_array['status'] = $this->status;
        }

        $data_array['modified_on'] = GetCurrentDateTime();
        $data_array['modified_by'] = $this->session->userdata[get_current_section($this,true)]['user_id'];

        $this->db->where(array('id' => $id, 'product_id' => $product_id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_detail_by_id to get product image detail
     */
    public function get_detail_by_id($id, $product_id)
    {   //echo $product_id;exit;
        $this->db->select('*')
                ->from($this->_table)
                ->where(array('id' => intval($id), 'product_id' => intval($product_id)))
                ->where('status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function get_listing to get product image listing
     */
    function get_listing($product_id)
    {
        if ($this->search_status != "")
        {
            $this->db->where('pi.status', $this->search_status);
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('pi.*');
        $this->db->from($this->_table . ' as pi');
        if(get_current_section($this) == 'front'){
            $this->db->where('pi.status =', 1);
        }
        else if(get_current_section($this)=='tatvasoft'){
           $this->db->where('pi.status !=', -1);
        }      
        $this->db->where('pi.product_id', intval($product_id));

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
     * Function delete_product to delte product image record
     */
    public function delete_product($id)
    {
        $data_array = array('status' => '-1');
        $this->db->where('id', intval($id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_last_id to get last inserted id
     */
    function get_last_id()
    {
        $this->db->select_max('id')
                ->from($this->_table);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['id'];
        }
        else
        {
            return 0;
        }
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

        //return $id;
         return;
        }

    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records()
    {
        $this->db->set('status', 0);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);

       // return $id;
         return;
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

        //return $id;
         return;
    }

    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records()
    {
        $this->db->set('status', 1);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);
        return;
        //return $id;
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

?>