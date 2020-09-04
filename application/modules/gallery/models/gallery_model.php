<?php

/**
 *  Gallery Model
 *
 *  To perform queries related to user management.
 *
 * @package CIDemoApplication
 * @subpackage Gallery
 * @copyright	(c) 2013, TatvaSoft
 * @author Pankit Shah <pankit.shah@sparsh.com>
 */
class Gallery_model extends Base_Model
{

    protected $_tbl_gallery = TBL_CATEGORIES;
    protected $_tbl_images = TBL_IMAGES;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";

    /**
     * Function get_user_listing to fetch all records of users
     * @param integer $user_id default = 0
     */
    function get_gallery_listing()
    {
        if($this->search_term != "")
        {
            //$this->db->like("LOWER(title)", strtolower($this->search_term));
        }
        if($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if(isset($this->record_per_page) && isset($this->offset))
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('G.*');
        $this->db->from($this->_tbl_gallery . ' AS G');
        
        $this->db->where('lang_id','1');
        $this->db->where('module_id =',6);
        
//        $this->db->join($this->_tbl_roles . ' as R', 'U.role_id = R.id', 'left');
//        $this->db->where('U.status !=', -1);
        $query = $this->db->get();
        $result = $this->db->custom_result($query);

        return $result;
    }


    /**
     * Function get_images_listing to fetch all records of users
     * @param integer $user_id default = 0
     */
    function get_images_listing()
    {                                                  //echo $this->sort_by."##".$this->sort_order;die;
        if($this->search_term != "")
        {
            $this->db->like("LOWER(I.title)", strtolower($this->search_term));
        }
        if($this->sort_by != "" && $this->sort_order != "")
        {                                              
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if(isset($this->record_per_page) && isset($this->offset))
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('I.*,G.title,G.slug_url');
        $this->db->from($this->_tbl_images . ' AS I');
        $this->db->join($this->_tbl_gallery . ' as G', 'I.gallery_id = G.category_id', 'left');
        $this->db->where('I.status !=', -1);
        $this->db->where('G.lang_id','1');
        $this->db->where('G.module_id =',6);
//        $this->db->or_where('I.status =', 0);
        $query = $this->db->get();
        $result = $this->db->custom_result($query);

        return $result;
    }

    /**
     * Function get_images_listing to fetch all records of users
     * @param integer $user_id default = 0
     */
    function get_images_listing_by_id($id)
    {                                                  //echo $this->sort_by."##".$this->sort_order;die;
        if($this->search_term != "")
        {
            $this->db->like("LOWER(I.title)", strtolower($this->search_term));
        }
        if($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if(isset($this->record_per_page) && isset($this->offset))
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('I.*,G.title,G.slug_url');
        $this->db->from($this->_tbl_images . ' AS I');
        $this->db->join($this->_tbl_gallery . ' as G', 'I.gallery_id = G.category_id', 'left');
        //$this->db->where('I.status =', 1);
        $this->db->where('I.id =', $id);
        $this->db->where('G.lang_id','1');
        $this->db->where('G.module_id =',6);
        $query = $this->db->get();
        $result = $this->db->custom_result($query);
        
       
        return $result[0];
        
       // return true;
    }

        /**
     * Function get_images_listing to fetch all records of users
     * @param integer $user_id default = 0
     */
    function get_images_listing_by_gallery_id($id)
    {                                                  //echo $this->sort_by."##".$this->sort_order;die;
        if($this->search_term != "")
        {
            $this->db->like("LOWER(I.title)", strtolower($this->search_term));
        }
        $this->db->order_by('id', 'desc');
        if($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if(isset($this->record_per_page) && isset($this->offset))
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('I.*,G.title,G.slug_url');
        $this->db->from($this->_tbl_images . ' AS I');
        $this->db->join($this->_tbl_gallery . ' as G', 'I.gallery_id = G.category_id', 'left');
        $this->db->where('I.status =', 1);
        $this->db->where('G.category_id =', $id);
        $query = $this->db->get();
        $result = $this->db->custom_result($query);

        return $result;
    }
    
    /**
     * Function save_user to add/update user
     * @param array $data for user table
     * @param array $data_profile for user_profile table
     */
    public function save_image($data)
    {
        if($data['id'] != 0 && $data['id'] != "")
        {
//            $this->db->where('id', $data['id']);
//            $this->db->update($this->_tbl_users, $data);
            $id = $data['id'];
            $this->db->where('id', $id);
            $this->db->update($this->_tbl_images, $data);
        }
        else
        {

            $this->db->set('created', 'NOW()', FALSE);
            if($this->db->insert($this->_tbl_images, $data))
            {
                $id = $this->db->insert_id();
                //$data_profile['user_id'] = $id;
                //$this->db->insert($this->_tbl_user_profile, $data_profile);
            }
        }
        return $id;
    }

    /**
     * Function get_image_detail to return user array of particular id
     * @param integer $id
     */
    function get_image_detail($id = 0)
    {
        //Type Casting
        $id = intval($id);

        $this->db->where("id", $id);
        $tableusers = $this->db->get($this->_tbl_images);

        return $tableusers;
    }

    /**
     * Function delete_user to delete user
     * @param integer $id
     */
    public function delete_image($id)
    {
        //Type Casting
        $this->db->where_in('id', $id);
        $this->db->set('status', '-1');
        return $this->db->update($this->_tbl_images);
        
        
    }
    
    public function record_count()
    {
        if($this->search_term)
        {
            $this->db->like("LOWER(title)", strtolower($this->search_term));
        }
        $this->db->select('*');
        $this->db->from($this->_tbl_images);
        $this->db->where('status !=', -1);
        $result = $this->db->get();

        return count($result->result_array());
    }
    
    function get_category_id_from_slug_url($slug_url)
    {
        
        $this->db->select('*');
        $this->db->from($this->_tbl_gallery . ' as G');        
        $this->db->where("slug_url", $slug_url);
        $query = $this->db->get();
        $result = $this->db->custom_result($query);
        //echo "<pre>";print_r($result);die;
        $category_id = $result[0]['G']['category_id'];

        return $category_id;
    }
    
    /**
     * Function active_records to active records
     * @param array $id 
     */
    public function active_records($id = array())
    {        
        $this->db->set('status', 1);
        $this->db->where_in('id', $id);
        $this->db->update($this->_tbl_images);

      //  return $id;
        return ;
    }    
    /**
     * Function inactive_records to inactive records
     * @param array $id 
     */
    public function inactive_records($id = array())
    {        
        $this->db->set('status', 0);
        $this->db->where_in('id', $id);
        $this->db->update($this->_tbl_images);
//        echo $id."ssss";die;
//        return $id;
        return ;
    }
            
    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records()
    {        
        $this->db->set('status', 1);
        $this->db->where('status !=', -1);
        $this->db->update($this->_tbl_images);

        return ;
    }
    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records()
    {        
        $this->db->set('status', 0);
        $this->db->where('status !=', -1);
        $this->db->update($this->_tbl_images);

          return ;
    }

    /**
     * Function delete_records to delete URL
     * @param integer $id 
     */
    public function delete_records($id = array())
    {
        $this->db->where_in('id', $id);
        $this->db->set('status', '-1');
        return $this->db->update($this->_tbl_images);
    }   
}

