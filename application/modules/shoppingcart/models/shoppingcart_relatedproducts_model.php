<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Shoppingcart RelatedProducts Orders Model
 *
 *  To perform queries related to related products.
 *
 * @package CIDemoApplication
 * @subpackage Shoppingcart
 * @copyright	(c) 2013, TatvaSoft
 * @author Bhavesh Patel <bhavesh.patel@sparsh.com>
 */
class Shoppingcart_relatedproducts_model extends Base_Model
{

    protected $_table = TBL_SHOPPINGCART_PRODUCTS;
    public $carray = array();
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    public $offset = "";
    public $module = "";
    public $module_name = "shoppingcart";

    /**
     * Function allproductsto_related_combo to get related products
     * @params integer $language_id
     * @params integer $product_id
     * @params integer $not_prdid
     */
    public function allproductsto_related_combo($language_id, $product_id = 0, $not_prdid)
    {
        $language_id = intval($language_id);
        $product_id = intval($product_id);
        $not_prdid = intval($not_prdid);
        
        $this->db->select('scp.id,scp.product_id,scp.name');
        $this->db->from($this->_table . ' as scp');
        $this->db->join(TBL_LANGUAGES . ' as l', 'scp.lang_id = l.id', 'inner');
        // $this->db->join(TBL_CATEGORIES . ' as sc', 'scp.category_id = sc.id', 'inner');

        if ($language_id != '')
        {
            $this->db->where("scp.lang_id", $language_id);
        }

        if ($product_id != 0)
        {
            $this->db->where("scp.id !=", $product_id);
        }

        if ($not_prdid != 0)
        {
            $this->db->where("scp.id !=", $not_prdid);
        }

        $this->db->where('scp.status =', 1);
        $this->db->group_by('scp.product_id');
        $this->db->order_by('scp.name');
        $query_rprd = $this->db->get();

        $allprd_rdata = $this->db->custom_result($query_rprd);
        return $allprd_rdata;
    }

    /**
     * Function check_relatedproduct to check related product
     * @params integer $language_id
     * @params integer $product_id
     * @params integer $not_prdid
     */
    public function check_relatedproduct($language_id, $product_id, $rprd_id = 0)
    {
        $language_id = intval($language_id);
        $product_id = intval($product_id);
        $rprd_id = intval($rprd_id);
        
        $this->db->select('scpr.related_product_id');
        $this->db->from(TBL_SHOPPINGCART_PRODUCTS_RELATED . ' as scpr');
        $this->db->join(TBL_LANGUAGES . ' as l', 'scpr.lang_id = l.id', 'inner');

        if ($language_id != '')
        {
            $this->db->where("scpr.lang_id", $language_id);
        }

        if ($product_id != 0)
        {
            $this->db->where("scpr.product_id", $product_id);
        }

        if ($rprd_id != 0)
        {
            $this->db->where("scpr.id", $rprd_id);
        }

        $que_reprd = $this->db->get();

        $allprd_redata = $this->db->custom_result($que_reprd);
        return $allprd_redata;
    }

    /**
     * Function delete_relatedproduct to delete related product
     * @params integer $id
     * @params integer $prd_id
     * @params integer $related_prdid
     * @params integer $lang_id
     */
    public function delete_relatedproduct($id = 0, $prd_id, $related_prdid = 0, $lang_id)
    {
        $lang_id = intval($lang_id);
        $prd_id = intval($prd_id);
        
        $id = intval($id);
        if ($id != 0)
            $this->db->where('id', $id);
        if ($lang_id != '')
            $this->db->where('lang_id', $lang_id);
        if ($prd_id != 0)
            $this->db->where('product_id', $prd_id);

        $this->db->delete(TBL_SHOPPINGCART_PRODUCTS_RELATED);
        return $this->db->_error_number(); // return the error occurred in last query
    }

    /**
     * Function insert_relatedproducts to insert related products
     * @params integer $product_id
     * @params integer $related_product_id
     * @params integer $lang_id
     */
    public function insert_relatedproducts($product_id, $related_product_id, $lang_id)
    {
        $product_id = intval($product_id);
        $related_product_id = intval($related_product_id);
        $lang_id = intval($lang_id);
        
        $rpdata_array = array(
            'product_id' => $product_id,
            'related_product_id' => $related_product_id,
            'lang_id' => $lang_id
        );

        $this->db->set($rpdata_array);
        $this->db->insert(TBL_SHOPPINGCART_PRODUCTS_RELATED);
        return $this->db->_error_number(); // return the error occurred in last query
    }

    /**
     * Function getfront_relatedproducts to get related products
     * @params integer $language_id
     * @params integer $product_id
     */
    public function getfront_relatedproducts($language_id, $product_id)
    {
        $language_id = intval($language_id);
        $product_id = intval($product_id);
        
        $this->db->select('scp.slug_url,scp.featured,scp.product_id,scp.name,scp.product_image,scp.discount_price,scp.currency_code,scp.price');
        $this->db->from(TBL_SHOPPINGCART_PRODUCTS_RELATED . ' as scpr');
        //$this->db->join(TBL_LANGUAGES . ' as l', 'scpr.lang_id = l.id', 'inner');
        $this->db->join($this->_table . ' as scp', 'scp.product_id = scpr.related_product_id', 'inner');

        if ($language_id != '')
        {
            $this->db->where("scp.lang_id", $language_id);
        }
        
        if ($product_id != 0)
        {
            $this->db->where("scpr.product_id", $product_id);
        }

        $this->db->where("scp.status", 1);
        $this->db->order_by("scp.name",'RANDOM');
        $this->db->limit(5, 0);
        
        $que_reprd = $this->db->get();
        $allprd_redata = $this->db->custom_result($que_reprd);

        return $allprd_redata;
    }

    /**
     * Function getrelated_products_by_ids to get related products for admin
     * @params integer $language_id
     * @params integer $product_id
     */
    function getrelated_products_by_ids($language_id, $product_id, $rprd_ids = 0)
    {
        $this->db->select('scpr.*,scp.id,scp.product_id,scp.category_id,scp.lang_id,scp.name,scp.price,scp.featured,scp.slug_url,scp.stock');
        $this->db->from(TBL_SHOPPINGCART_PRODUCTS_RELATED . ' as scpr');
        $this->db->join(TBL_LANGUAGES . ' as l', 'scpr.lang_id = l.id', 'inner');
        $this->db->join($this->_table . ' as scp', 'scp.product_id = scpr.related_product_id', 'inner');
        
        if ($language_id != '')
        {
            $this->db->where("scp.lang_id", $language_id);
        }
        
        if ($product_id != 0)
        {
            $this->db->where("scpr.product_id", $product_id);
        }
        
        // $this->db->group_by('scp.product_id');
        $que_reprd = $this->db->get();
        
        $allprd_redata = $this->db->custom_result($que_reprd);
        return $allprd_redata;
    }
}