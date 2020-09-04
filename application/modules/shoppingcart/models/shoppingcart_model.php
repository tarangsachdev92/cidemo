<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Shoppingcart Images Model
 *
 *  To perform queries related to Shoppingcart management.
 *
 * @package CIDemoApplication
 * @subpackage product
 * @copyright	(c) 2013, TatvaSoft
 * @author Bhavesh Patel <bhavesh.patel@sparsh.com>
 */
class Shoppingcart_model extends Base_Model
{

    protected $_table = TBL_SHOPPINGCART_PRODUCTS;
    public $carray = array();
    public $search_term = "";
    public $search_category_id = 0;
    public $sort_by = "";
    public $sort_order = "";
    public $offset = "";
    public $module = "";
    public $module_name = "shoppingcart";

    /**
     * Function get_all_productsdata to get all products
     * @params string $language_id
     */
    public function get_all_productsdata($language_id)
    {
        $language_id = intval($language_id);

        if ($this->search_term != "")
        {
            $this->db->like('LOWER(scp.name)', strtolower($this->search_term), 'both');
        }

        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }

        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('scp.name,scp.slug_url,scp.price,scp.status,scp.modified_on,scp.id,scp.product_id,scp.currency_code,scp.featured,l.language_code,scc.title,scp.stock,scp.category_id');
        $this->db->from($this->_table . ' as scp');
        $this->db->join(TBL_LANGUAGES . ' as l', 'scp.lang_id = l.id', 'inner');
        $this->db->join(TBL_SHOPPINGCART_CATEGORIES . ' as scc', 'scp.category_id = scc.category_id', 'inner');

        if ($language_id != '')
        {
            $this->db->where("scp.lang_id", $language_id);
        }

        $this->db->where('scp.status !=', -1);

        if ($this->search_category_id > 0)
        {
            $this->db->where('scp.category_id =', intval($this->search_category_id));
        }

        $this->db->group_by('scp.product_id');
        $query = $this->db->get();

        //echo $this->db->last_query();die;
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
     * Function delete_product to delete product
     * @params integer $id
     */
    public function delete_product($id)
    {
        $data_array = array('status' => '-1');
        $this->db->where('product_id', intval($id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function is_exist to check for product
     * @params integer $product_id
     * @params integer $lang_id
     */
    public function is_exist($product_id, $lang_id)
    {
        $lang_id = intval($lang_id);
        $this->db->select('id')
                ->from($this->_table)
                ->where(array('id' => $product_id, 'lang_id' => $lang_id))
                ->where('status !=', -1);
        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function is_exist_product to check for product
     * @params integer $product_id
     * @params integer $lang_id
     */
    public function is_exist_product($product_id, $lang_id)
    {
        $lang_id = intval($lang_id);
        $this->db->select('id')
                ->from($this->_table)
                ->where(array('product_id' => $product_id, 'lang_id' => $lang_id))
                ->where('status !=', -1);
        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function get_last_id to get last product_id
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
     * Function update_slug to update slug url
     * @params integer $id
     * @params srting $slug_url
     */
    function update_slug($id, $slug_url)
    {
        $id = intval($id);
        $slug_url = trim(strip_tags($slug_url));
        $data_array = array(
            'slug_url' => $slug_url,
            'modified' => GetCurrentDateTime(),
            'modified_by' => ''
        );

        $this->db->where('id', $id);
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function insert to insert product
     * @params integer $product_id
     * @params integer $lang_id
     */
    function insert($product_id, $lang_id)
    {
        $product_id = intval($product_id);
        $lang_id = intval($lang_id);
        $data_array = array();
        $data_array['product_id'] = $product_id;
        $data_array['lang_id'] = $lang_id;

        if (isset($this->name))
        {
            $data_array['name'] = $this->name;
        }
        if (isset($this->slug_url))
        {
            $data_array['slug_url'] = $this->slug_url;
        }
        if (isset($this->description))
        {
            $data_array['description'] = $this->description;
        }
        if (isset($this->category_id))
        {
            $data_array['category_id'] = $this->category_id;
        }
        if (isset($this->status))
        {
            $data_array['status'] = $this->status;
        }
        if (isset($this->featured))
        {
            $data_array['featured'] = $this->featured;
        }
        if (isset($this->price))
        {
            $data_array['price'] = $this->price;
        }
        if (isset($this->meta_keywords))
        {
            $data_array['meta_keywords'] = $this->meta_keywords;
        }
        if (isset($this->meta_description))
        {
            $data_array['meta_description'] = $this->meta_description;
        }
        if (isset($this->product_image))
        {
            $data_array['product_image'] = $this->product_image;
        }
        if (isset($this->discount_price))
        {
            $data_array['discount_price'] = $this->discount_price;
        }
        if (isset($this->currency_code))
        {
            $data_array['currency_code'] = $this->currency_code;
        }
        if (isset($this->stock))
        {
            $data_array['stock'] = $this->stock;
        }

        $data_array['created_on'] = GetCurrentDateTime();
        $data_array['created_by'] = $this->session->userdata[get_current_section($this)]['user_id'];

        $this->db->set($data_array);
        $this->db->insert($this->_table);

        return $this->db->_error_number(); // return the error occurred in last query
    }

    /**
     * Function update  to update product record
     */
    function update($product_id, $lang_id)
    {
        $product_id = intval($product_id);
        $lang_id = intval($lang_id);
        $data_array = array();

        if (isset($this->name))
        {
            $data_array['name'] = $this->name;
        }
        if (isset($this->slug_url))
        {
            $data_array['slug_url'] = $this->slug_url;
        }
        if (isset($this->description))
        {
            $data_array['description'] = $this->description;
        }
        if (isset($this->status))
        {
            $data_array['status'] = $this->status;
        }
        if (isset($this->category_id))
        {
            $data_array['category_id'] = $this->category_id;
        }
        if (isset($this->featured))
        {
            $data_array['featured'] = $this->featured;
        }
        if (isset($this->price))
        {
            $data_array['price'] = $this->price;
        }
        if (isset($this->meta_keywords))
        {
            $data_array['meta_keywords'] = $this->meta_keywords;
        }
        if (isset($this->meta_description))
        {
            $data_array['meta_description'] = $this->meta_description;
        }
        if (isset($this->product_image))
        {
            $data_array['product_image'] = $this->product_image;
        }
        if (isset($this->discount_price))
        {
            $data_array['discount_price'] = $this->discount_price;
        }
        if (isset($this->currency_code))
        {
            $data_array['currency_code'] = $this->currency_code;
        }

        $data_array['modified_on'] = GetCurrentDateTime();
        $data_array['modified_by'] = $this->session->userdata[get_current_section($this)]['user_id'];
        $this->db->where(array('product_id' => $product_id, 'lang_id' => $lang_id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_detail_by_id to get product detail
     * @params integer $product_id
     * @params integer $lang_id
     */
    public function get_detail_by_id($id, $lang_id)
    {
        $this->db->select('products.*,c.*')
                ->from($this->_table . ' as products')
                ->join(TBL_SHOPPINGCART_CATEGORIES . ' as c', 'products.category_id = c.id AND products.lang_id = c.lang_id', 'left')
                ->where(array('products.product_id' => intval($id), 'products.lang_id' => intval($lang_id)))
                ->where('products.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function getallproducts to get products list
     * @params integer $category_id
     */
    public function getallproducts($language_id, $category_id = 0)
    {
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count_front))
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('scp.slug_url,scp.featured,scp.product_id,scp.name,scp.product_image,scp.discount_price,scp.currency_code,scp.id,scp.category_id,scp.price,scp.stock');
        $this->db->from($this->_table . ' as scp');
        $this->db->join(TBL_LANGUAGES . ' as l', 'scp.lang_id = l.id', 'inner');
        $this->db->join(TBL_SHOPPINGCART_CATEGORIES . ' as scc', 'scp.category_id = scc.category_id', 'inner');

        if ($language_id != '')
        {
            $this->db->where("scp.lang_id", $language_id);
        }

        if ($category_id != '')
        {
            $this->db->where("scp.category_id", $category_id);
            $this->db->where('scc.status =', 1);
        }

        $this->db->where('scp.status =', 1);
        $this->db->group_by('scp.product_id');
        $query_prd = $this->db->get();

        if (isset($this->_record_count_front) && $this->_record_count_front == true)
        {
            $allprd_data = count($this->db->custom_result($query_prd));
        }
        else
        {
            $allprd_data = $this->db->custom_result($query_prd);
        }

        return $allprd_data;
    }

    /**
     * Function get_product to fetch product
     * @params integer $language_id
     * @params integer $id
     * @params integer $product_id
     * @params string $slug_url
     */
    public function get_product($language_id, $id = 0, $product_id = 0, $slug_url = '')
    {
        $language_id = intval($language_id);
        $id = intval($id);
        $product_id = intval($product_id);
        $slug_url = trim($slug_url);

        $this->db->select('scp.slug_url,scp.featured,scp.product_id,scp.name,scp.product_image,scp.discount_price,scp.currency_code,scp.id,scp.category_id,scp.price,scp.visiters,scp.stock,scp.description');
        $this->db->from($this->_table . ' as scp');
        $this->db->join(TBL_LANGUAGES . ' as l', 'scp.lang_id = l.id', 'inner');
        $this->db->join(TBL_SHOPPINGCART_CATEGORIES . ' as scc', 'scp.category_id = scc.category_id', 'inner');

        if ($language_id != '')
        {
            $this->db->where("scp.lang_id", $language_id);
        }

        if ($id != 0)
        {
            $this->db->where("scp.id", $id);
        }

        if ($product_id != 0)
        {
            $this->db->where("scp.product_id", $product_id);
        }

        if ($slug_url != '')
        {
            $slug_url = strip_tags($slug_url);
            $this->db->where("scp.slug_url", $slug_url);
        }

        $this->db->where('scp.status =', 1);
        $this->db->group_by('scp.id');
        $query_prd = $this->db->get();
        $prd_data = $this->db->custom_result($query_prd);

        return $prd_data;
    }

    /**
     * Function inactive_records to inactive records
     * @param array $id
     */
    public function inactive_records($id = array())
    {
        $this->db->set('status', 0);
        $this->db->where_in('product_id', $id);
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
        $this->db->where_in('product_id', $id);
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
        $this->db->where_in('product_id', $id);
        $this->db->set('status', '-1');
        return $this->db->update($this->_table);
    }

    /**
     * Function get_total_product to get all active product total
     */
    function get_total_product($language_id)
    {
        $language_id = intval($language_id);

        $this->db->select('scp.*');
        $this->db->from($this->_table . ' AS scp');
        $this->db->where('scp.status !=', -1);
        $this->db->where('scp.lang_id =', $language_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Function get_category_total_product to get all product total based on category
     */
    function get_category_total_product($category_id, $language_id = 0)
    {
        $category_id = intval($category_id);
        $language_id = intval($language_id);

        $this->db->select('scp.id');
        $this->db->from($this->_table . ' AS scp');
        $this->db->where('scp.status =', 1);
        $this->db->where('scp.category_id =', $category_id);
        $this->db->where('scp.lang_id =', $language_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Function get_all_featured_products to get all featured products
     */
    function get_all_featured_products($language_id)
    {
        $language_id = intval($language_id);

        $this->db->select('scp.id,scp.product_id,scp.category_id,scp.lang_id,scp.name,scp.price,scp.slug_url,scp.product_image,scp.currency_code,scp.stock,scp.discount_price');
        $this->db->from($this->_table . ' as scp');
        //$this->db->join(TBL_LANGUAGES . ' as l', 'scp.lang_id = l.id', 'inner');

        if ($language_id != '')
        {
            $this->db->where("scp.lang_id", $language_id);
        }

        $this->db->where('scp.status !=', -1);
        $this->db->where('scp.status !=', 0);
        $this->db->where('scp.featured =', 1);
        $this->db->group_by('scp.product_id');
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
     * Function get_category_all_product to fetch all products from selected category
     * @params integer $language_id
     * @params integer $category_id
     */
    public function get_category_all_product($language_id = 0, $category_id = 0, $slug_url = '')
    {
        $language_id = intval($language_id);
        $category_id = intval($category_id);
        $slug_url = trim($slug_url);

        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count_front))
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('scp.id,scp.slug_url,scp.product_id,scp.name,scp.product_image,scp.discount_price,scp.price,scp.currency_code,scp.featured,scp.stock');
        $this->db->from($this->_table . ' as scp');
        $this->db->join(TBL_SHOPPINGCART_CATEGORIES . ' as scc', 'scp.category_id = scc.category_id', 'inner');

        if ($language_id != '')
        {
            $this->db->where("scp.lang_id", $language_id);
        }

        if ($category_id != 0)
        {
            $this->db->where("scp.category_id", $category_id);
        }

        if ($slug_url != '')
        {
            $slug_url = strip_tags($slug_url);
            $this->db->where("scc.slug_url", $slug_url);
        }

        $this->db->where('scp.status =', 1);
        $this->db->group_by('scp.product_id');
        $query_prd = $this->db->get();

        if (isset($this->_record_count_front) && $this->_record_count_front == true)
        {
            $prd_data = count($this->db->custom_result($query_prd));
        }
        else
        {
            $prd_data = $this->db->custom_result($query_prd);
        }

        return $prd_data;
    }

    /**
     * Function inactive_all_child_category to inactive all child category
     */
    function inactive_all_category_products($category_ids = array(), $lang_id)
    {
        $data_array = array(
            'status' => 0,
            'modified_on' => GetCurrentDateTime(),
            'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']
        );

        $this->db->where_in('category_id', $category_ids);
        $this->db->where('lang_id', $lang_id);
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function delete_all_category_products to delete all child category productd
     */
    function delete_all_category_products($category_ids = array(), $lang_id = 0)
    {
        $lang_id = intval($lang_id);

        $data_array = array(
            'status' => -1,
            'modified_on' => GetCurrentDateTime(),
            'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']
        );

        $this->db->where_in('category_id', $category_ids);

        if ($lang_id != 0)
        {
            $this->db->where('lang_id', $lang_id);
        }

        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function add_product_visitor to add product visitor count
     */
    function add_product_visitor($id, $visiters)
    {
        $id = intval($id);
        $visiters = intval($visiters);
        $visiters++;

        $data_array = array(
            'visiters' => $visiters
        );

        $this->db->where('id', $id);
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_most_viewed_products to get most viewed products
     */
    function get_most_viewed_products($language_id)
    {
        $language_id = intval($language_id);

        $this->db->select('scp.id,scp.product_id,scp.category_id,scp.lang_id,scp.name,scp.price,scp.slug_url,scp.product_image,scp.currency_code,scp.stock,scp.discount_price,scp.visiters,scp.status');
        $this->db->from($this->_table . ' AS scp');
        $this->db->where_not_in('scp.status', array(-1, 0));
        $this->db->where('scp.lang_id =', $language_id);
        $this->db->order_by("scp.visiters", 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function get_billaddresses to fetch billing address data
     * @params integer $user_id
     * @params integer $bill_id
     */
    public function get_billaddresses($user_id, $bill_id)
    {
        $this->db->select('scba.*');
        $this->db->from(TBL_SHOPPINGCART_BILLING_ADDRESS . ' AS scba');
        $this->db->where('scba.user_id =', $user_id);

        if ($bill_id != 0)
        {
            $this->db->where('scba.id =', $bill_id);
        }

        $que_bill = $this->db->get();
        $result_bill = $que_bill->result_array();
        return $result_bill;
    }

    /**
     * Function get_shipaddresses to fetch shipping address data
     * @params integer $user_id
     * @params integer $ship_id
     */
    public function get_shipaddresses($user_id, $ship_id)
    {
        $this->db->select('scsa.*');
        $this->db->from(TBL_SHOPPINGCART_SHIPPING_ADDRESS . ' AS scsa');
        $this->db->where('scsa.user_id =', $user_id);

        if ($ship_id)
        {
            $this->db->where('scsa.id =', $ship_id);
        }

        $que_ship = $this->db->get();
        //echo $this->db->last_query();
        $result_ship = $que_ship->result_array();
        return $result_ship;
    }

    /**
     * Function insert_billaddress to insert billing address
     * @params array $ins_bill_data
     */
    public function insert_billaddress($ins_bill_data)
    {
        $this->db->set($ins_bill_data);
        $this->db->insert(TBL_SHOPPINGCART_BILLING_ADDRESS);
        return $this->db->_error_number(); // return the error occurred in last query
    }

    /**
     * Function insert_shipaddress to insert shipping address
     * @params array $ins_bill_data
     */
    public function insert_shipaddress($ins_ship_data)
    {
        $this->db->set($ins_ship_data);
        $this->db->insert(TBL_SHOPPINGCART_SHIPPING_ADDRESS);
        return $this->db->_error_number(); // return the error occurred in last query
    }

    /**
     * Function get_order_detail_by_id to fetch order data
     * @params integer $order_id
     */
    public function get_order_detail_by_id($order_id)
    {
        $this->db->select('*');
        $this->db->from(TBL_SHOPPINGCART_ORDERS);
        $this->db->where('id =', $order_id);
        $que_oi = $this->db->get();
        //echo $this->db->last_query();
        $result_oi = $que_oi->row_array();
        return $result_oi;
    }

    /**
     * Function update_order_record to update order record
     * @params array $data
     * @params integer $order_id
     */
    public function update_order_record($data, $order_id)
    {
        $order_id = intval($order_id);
        $this->db->where('id', $order_id);
        $this->db->update(TBL_SHOPPINGCART_ORDERS, $data);
    }

    /**
     * Function delete_order_record to delete order record
     * @params integer $id
     */
    public function delete_order_record($id)
    {
        $id = intval($id);
        $this->delete_order_items($id);
        $this->db->where('id ', $id);

        return $this->db->delete(TBL_SHOPPINGCART_ORDERS);
    }

    /**
     * Function delete_order_items to delete order items
     * @params integer $id
     * @params integer $order_id
     */
    public function delete_order_items($id, $order_id)
    {
        $order_id = intval($order_id);
        $id = intval($id);

        if ($id != 0)
        {
            $this->db->where('id ', $id);
        }

        if ($order_id != 0)
        {
            $this->db->where('order_id ', $order_id);
        }

        return $this->db->delete(TBL_SHOPPINGCART_ORDER_ITEMS);
    }

    /**
     * Function get_order_items_by_order_id to get order items
     * @params integer $order_id
     */
    public function get_order_items_by_order_id($order_id)
    {
        $this->db->select('*');
        $this->db->from(TBL_SHOPPINGCART_ORDER_ITEMS);
        $this->db->where('order_id =', $order_id);
        $que_order = $this->db->get();
        $result_order = $que_order->result_array();

        return $result_order;
    }

    /**
     * Function insert_orders to insert order
     * @params array $ins_order_data
     */
    public function insert_orders($ins_order_data)
    {
        if ($ins_order_data['coupon_code'] != '')
        {
            $this->update_coupon_maxuse($ins_order_data['coupon_code'], $add = 0);
        }

        $this->db->set($ins_order_data);
        $this->db->insert(TBL_SHOPPINGCART_ORDERS);

        return $this->db->insert_id();
    }

    /**
     * Function insert_order_items to insert order items
     * @params integer $order_id
     */
    public function insert_order_items($order_id)
    {
        $cart_data = $this->cart->contents();
        foreach ($cart_data as $items)
        {
            $order_id = intval($order_id);
            $product_id = intval($items['id']);
            $product_name = $items['name'];
            $product_qty = intval($items['qty']);
            $product_price = $items['subtotal'];
            $order_date = date('Y-m-d');
            $orderitem_data_array = array(
                'order_id' => $order_id,
                'product_id' => $product_id,
                'product_name' => $product_name,
                'product_qty' => $product_qty,
                'product_price' => $product_price,
                'order_date' => $order_date
            );
            $this->db->set($orderitem_data_array);
            $this->db->insert(TBL_SHOPPINGCART_ORDER_ITEMS);
            // # Update Stock of product table
            $this->update_product_stock($product_id, $product_qty, $add = 0);
            // # EOF Update Stock of product table
        }
    }

    /**
     * Function checkcouponcode to check coupon code
     * @params string $coupon_code
     * @params integer $expired
     */
    public function checkcouponcode($coupon_code, $expired = 0)
    {
        $coupon_code = strip_tags($coupon_code);
        $coupon_code = strtoupper($coupon_code);

        $this->db->select('sccp.id,sccp.coupon_name,sccp.coupon_code,sccp.coupon_price,sccp.coupon_percentage,sccp.coupon_maxuse');
        $this->db->from(TBL_SHOPPINGCART_COUPONS . ' AS sccp');
        $this->db->where('sccp.coupon_code =', $coupon_code);
        $this->db->where('sccp.status =', 1);

        if ($expired != 0)
        {
            $this->db->where('( sccp.coupon_sdate <=DATE(NOW()) AND sccp.coupon_edate >= DATE(NOW()) ) ');
        }
        $que_coupon = $this->db->get();

        return $que_coupon->row_array();
    }

    /**
     * Function checkproduct_stock to check product stock
     */
    public function checkproduct_stock()
    {
        $stock_notavail = 0;
        $cart_content = $this->cart->contents();

        if ($this->cart->total_items() != 0)
        {
            foreach ($cart_content as $items)
            {
                $prd_data = $this->get_product($language_id = '', $items['id'], $product_id = 0, $slug_url = '');
                if (count($prd_data))
                {
                    if ($items['qty'] > $prd_data['0']['scp']['stock'])
                    {
                        $stock_notavail = 1;
                    }
                }
            }
        }

        return $stock_notavail;
    }

    /**
     * Function update_product_stock to update product stock
     * @params integer $product_id
     * @params integer $stock
     * @params integer $add
     */
    public function update_product_stock($product_id, $stock, $add = 0)
    {
        //Type Casting 
        $stock = intval($stock);
        $prd_data = $this->get_product($language_id = '', $product_id, 0, $slug_url = '');

        if ($add == 0)
        {
            $newstock = $prd_data['0']['scp']['stock'] - $stock;
        }
        else
        {
            $newstock = $prd_data['0']['scp']['stock'] + $stock;
        }

        $product_id = intval($product_id);
        $prdstock_array = array('stock ' => $newstock);
        $this->db->where('id', $product_id);
        $this->db->update($this->_table, $prdstock_array);
    }

    /**
     * Function update_coupon_maxuse to update coupon maximum use
     * @params string $coupon_code
     * @params integer $add
     */
    public function update_coupon_maxuse($coupon_code, $add = 0)
    {
        $coupon_code = strip_tags($coupon_code);
        $coupon_data = $this->checkcouponcode($coupon_code, $expiredate = 0);

        if ($add == 0)
        {
            $maxuseval = $coupon_data['coupon_maxuse'] - 1;
        }
        else
        {
            $maxuseval = $coupon_data['coupon_maxuse'] + 1;
        }

        $coupon_array = array('coupon_maxuse ' => $maxuseval);
        $this->db->where('coupon_code', $coupon_code);
        $this->db->update(TBL_SHOPPINGCART_COUPONS, $coupon_array);
    }

    /**
     * Function check_ship_bill_address to check shipping or billing address
     * @params integer $user_id
     * @params integer $id
     * @params string $address_type
     */
    public function check_ship_bill_address($user_id, $id, $address_type)
    {
        $id = intval($id);
        $user_id = intval($user_id);
        $address_type = strip_tags($address_type);

        if ($address_type == 'billaddress')
        {
            $address_table = TBL_SHOPPINGCART_BILLING_ADDRESS;
        }
        if ($address_type == 'shipaddress')
        {
            $address_table = TBL_SHOPPINGCART_SHIPPING_ADDRESS;
        }

        $this->db->select('*');
        $this->db->from($address_table);
        $this->db->where('user_id =', $user_id);
        $this->db->where('id =', $id);
        $que_ship_bill = $this->db->get();
        // echo $this->db->last_query(); exit;
        $result_ship_bill = $que_ship_bill->row_array();

        return $result_ship_bill;
    }

    /**
     * Function update_ship_bill_address to update shipping and billing address
     * @params integer $user_id
     * @params integer $id
     * @params string $address_type
     * @params array $update_ship_bill_data
     */
    public function update_ship_bill_address($user_id, $id, $address_type, $update_ship_bill_data)
    {
        $id = intval($id);
        $user_id = intval($user_id);
        $address_type = strip_tags($address_type);

        if ($address_type == 'billaddress')
        {
            $address_table = TBL_SHOPPINGCART_BILLING_ADDRESS;
            $address_data_array = array(
                'bill_fname' => $update_ship_bill_data['fname'],
                'bill_lname' => $update_ship_bill_data['lname'],
                'bill_address' => $update_ship_bill_data['address'],
                'bill_street' => $update_ship_bill_data['street'],
                'bill_country' => $update_ship_bill_data['country'],
                'bill_state' => $update_ship_bill_data['state'],
                'bill_city' => $update_ship_bill_data['city'],
                'bill_postcode' => $update_ship_bill_data['postcode']
            );
        }

        if ($address_type == 'shipaddress')
        {
            $address_table = TBL_SHOPPINGCART_SHIPPING_ADDRESS;
            $address_data_array = array(
                'ship_fname' => $update_ship_bill_data['fname'],
                'ship_lname' => $update_ship_bill_data['lname'],
                'ship_address' => $update_ship_bill_data['address'],
                'ship_street' => $update_ship_bill_data['street'],
                'ship_country' => $update_ship_bill_data['country'],
                'ship_state' => $update_ship_bill_data['state'],
                'ship_city' => $update_ship_bill_data['city'],
                'ship_postcode' => $update_ship_bill_data['postcode']
            );
        }

        $this->db->where('user_id =', $user_id);
        $this->db->where('id =', $id);
        $this->db->update($address_table, $address_data_array);
    }

    /**
     * Function update_product_image to update product image common image for same product in use of multi lang
     */
    function update_product_image($product_id, $lang_id)
    {
        $product_id = intval($product_id);
        $lang_id = intval($lang_id);

        $data_array = array();

        if (isset($this->product_image))
        {
            $data_array['product_image'] = $this->product_image;
        }

        $data_array['modified_on'] = GetCurrentDateTime();
        $data_array['modified_by'] = $this->session->userdata[get_current_section($this, true)]['user_id'];

        $this->db->where(array('product_id' => $product_id, 'lang_id' => $lang_id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function active_inactive_product_for_all_lang to inactive/active product on all lang
     */
    function active_inactive_product_for_all_lang($product_id, $lang_id = 0, $status)
    {
        $lang_id = intval($lang_id);
        $status = intval($status);

        $data_array = array(
            'status' => $status,
            'modified_on' => GetCurrentDateTime(),
            'modified_by' => $this->session->userdata[get_current_section($this, true)]['user_id']
        );

        $this->db->where_in('product_id', $product_id);

        if ($lang_id != 0)
        {
            $this->db->where('lang_id', $lang_id);
        }

        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

}