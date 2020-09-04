<?php

/**
 *  product Model
 *
 *  To perform queries related to product management.
 *
 * @package CIDemoApplication
 * @subpackage product
 * @copyright	(c) 2013, TatvaSoft
 * @author dipesh gangani <dipesh.gangani@sparsh.com>
 */
class Products_model extends Base_Model
{

    protected $_table = TBL_PRODUCTS;    
    public $search_name = "";
    public $search_slug = "";
    public $search_status = "";
    public $sort_by = "sort_order";
    public $sort_order = "ASC";
    public $offset = "";
    public $category_id = "";
    public $search_category = "";
    public $search_from = "";
    public $search_to = "";
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Function insert is to insert record
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
        if (isset($this->slug))
        {
            $data_array['slug'] = $this->slug;
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
        if (isset($this->product_image))
        {
            $data_array['product_image'] = $this->product_image;
        }
        if (isset($this->meta_keywords))
        {
            $data_array['meta_keywords'] = $this->meta_keywords;
        }
        if (isset($this->meta_description))
        {
            $data_array['meta_description'] = $this->meta_description;
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
    function update($product_id, $lang_id)
    {

        $product_id = intval($product_id);
        $lang_id = intval($lang_id);

        $data_array = array();

        if (isset($this->name))
        {
            $data_array['name'] = $this->name;
        }
        if (isset($this->slug))
        {
            $data_array['slug'] = $this->slug;
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
        if (isset($this->product_image))
        {
            $data_array['product_image'] = $this->product_image;
        }
        if (isset($this->meta_keywords))
        {
            $data_array['meta_keywords'] = $this->meta_keywords;
        }
        if (isset($this->meta_description))
        {
            $data_array['meta_description'] = $this->meta_description;
        }

        $data_array['modified_on'] = GetCurrentDateTime();
        $data_array['modified_by'] = $this->session->userdata[get_current_section($this,true)]['user_id'];

        $this->db->where(array('product_id' => $product_id, 'lang_id' => $lang_id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_detail_by_id to get Product detail
     */
    public function get_detail_by_id($id, $lang_id)
    {
        $this->db->select('*')
                ->from($this->_table . ' as p')
                ->join(TBL_CATEGORIES . ' as c', 'p.category_id = c.category_id', 'inner')
                ->where(array('p.product_id' => intval($id), 'p.lang_id' => intval($lang_id)))
                ->where('p.status !=', -1);

        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function get_listing to get Product listing
     */
    function get_listing($language_id = '')
    {
        $language_id = intval($language_id);

        if ($this->search_status != "")
        {
            $this->db->where('p.status', $this->search_status);
        }        
        if ($this->search_category != "0" && $this->search_category != "")
        {
            $this->db->where('p.category_id', $this->search_category);
        }     
        if ($this->search_name != "")
        {
            $this->db->like('LOWER(p.name)', strtolower($this->search_name), 'both');
        }
        if($this->search_slug!= ""){
            $this->db->like('LOWER(p.slug)',strtolower($this->search_slug),'both');
        }
        if($this->search_from!="" && $this->search_to=="")
        {
            $this->db->where('p.price',$this->search_from);
        }
        if($this->search_to!="" && $this->search_from=="")
        {
            $this->db->where('p.price',$this->search_to);
        }
        if($this->search_to!="" && $this->search_from!="")
        {
//            $this->db->where('p.price>=',$this->search_from);
//            $this->db->where('p.price<=',$this->search_to);
            $this->db->where("p.price BETWEEN $this->search_from AND $this->search_to");
            
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('p.* , l.*,c.*');
        $this->db->from($this->_table . ' as p');
        $this->db->join(TBL_LANGUAGES . ' as l', 'p.lang_id = l.id', 'inner');
        $this->db->join(TBL_CATEGORIES . ' as c', 'p.category_id = c.category_id', 'inner');

        if ($language_id != '')
        {
            $this->db->where("p.lang_id", $language_id);
        }
        if(get_current_section($this) == 'front'){
            $this->db->where('p.status =', 1);
        }
        else if(get_current_section($this) == 'admin'){
           $this->db->where('p.status !=', -1);
        }
        $this->db->group_by('p.product_id');
        $query = $this->db->get();
        
        // echo $this->db->last_query(); exit;	

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
     * Function delete_product to delte product record
     */
    public function delete_product($id)
    {
        
        $data_array = array('status' => '-1','modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('id', intval($id));
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
     * Function get_product_detail_by_slug to fetch detail of records by slug
     */
    public function get_product_detail_by_slug($slug_url)
    {   
        $slug_url = trim(strip_tags($slug_url));
        
        $this->db->select('*')
                ->from($this->_table)
                ->where(array('slug' => $slug_url))
                ->where('status !=', -1);

        $query = $this->db->get();

        return $this->db->custom_result($query);
    }
    
    public function check_unique_slug($slug_url, $id ="") {                         
        //Type Casting 
        $slug_url = trim(strip_tags($slug_url));
        $id = intval($id);
        
        $this->db->select('*')
                ->from($this->_table)
                ->where('slug', $slug_url."")
                ->where('status !=', -1);
        
        if($id != '0' && $id != '')
        {
            $this->db->where('id !=', $id);
        }
        
        
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

      //  return $id;
          return;
    }

    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records($language_id)
    {
        $data_array = array('status' => '0','modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
         $this->db->where('lang_id',$language_id);
        $this->db->where('status !=', -1);
        $this->db->update($this->_table);

      //  return $id;
          return;
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

       // return $id;
          return;
        }

    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records($language_id)
    {
        $data_array = array('status' => '1','modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        $this->db->where('status !=', -1);
        $this->db->where('lang_id',$language_id);
        $this->db->update($this->_table);

     //   return $id;
        return;
    }

    /**
     * Function delete_records to delete URL
     * @param integer $id 
     */
    public function delete_records($id = array())
    {
        $data_array = array('status' => '-1','modified_on' => GetCurrentDateTime(), 'modified_by' => $this->session->userdata[get_current_section($this,true)]['user_id']);
        $this->db->set($data_array);
        
        $this->db->where_in('id', $id);
        return $this->db->update($this->_table);
    }

}

?>