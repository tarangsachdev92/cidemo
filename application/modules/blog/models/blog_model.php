<?php

/*
 *  Blog Model
 *
 *  To perform queries related to user management.
 * 
 * @package CIDemoApplication
 * @subpackage Blog
 * @copyright	(c) 2013, TatvaSoft
 * @author SGNSH
 */

class Blog_model extends Base_Model 
{

    protected $_tbl_blogpost = TBL_BLOGPOST;
    protected $_tbl_categories = TBL_CATEGORIES;
    protected $_tbl_blog_comment = TBL_BLOG_COMMENT;
    protected $_tbl_blog_category = TBL_BLOG_CATEGORY;
    protected $_tbl_category_modules = TBL_CATEGORY_MODULES;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    public $category = "";
    
    public $title="";
    public $category_id="";
    public $slug_url="";
    public $view_permission="";
    public $blog_text="";
    public $status="";
    public $blog_image="";

    /**
     * Function get_related_lang_blog to check blog record exist or not
     */    
    public function get_related_lang_blog($blogpost_id, $lang_id)
    {
        $blogpost_id = intval($blogpost_id);
        $lang_id = intval($lang_id);

        $this->db->select('b.*')
                ->from($this->_tbl_blogpost . ' as b')
                ->where(array('b.blogpost_id' => $blogpost_id, 'b.lang_id' => $lang_id))
                ->where('b.status !=', -1);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }
    /**
     * Function update_blog to update record 
     */
    public function update_blog($blogpost_id, $lang_id) 
    {
        $blogpost_id = intval($blogpost_id);
        $lang_id = intval($lang_id);
                
        $data_array = array();

        if(isset($this->title) )
        {
            $data_array['title'] = $this->title;
        }
        if(isset($this->category_id) )
        {
            $data_array['category_id'] = $this->category_id;
        }
        if(isset($this->slug_url) )
        {
            $data_array['slug_url'] = $this->slug_url;
        }       
        if(isset($this->view_permission) )
        {
            $data_array['view_permission'] = $this->view_permission;
        }
        if(isset($this->blog_text) )
        {
            $data_array['blog_text'] = $this->blog_text;
        }      
        if(isset($this->status) )
        {
            $data_array['status'] = $this->status;;
        }
        if(isset($this->blog_image) )
        {
            $data_array['blog_image'] = $this->blog_image;
        }
        $data_array['modified'] = GetCurrentDateTime();       
        $this->db->where(array('blogpost_id' => $blogpost_id, 'lang_id' => $lang_id));
        $this->db->set($data_array);
        $this->db->update($this->_tbl_blogpost);   
    }
    /**
     * Function insert_blog to insert record 
     */
    function insert_blog($blogpost_id, $lang_id)
    {
        $blogpost_id = intval($blogpost_id);
        $lang_id = intval($lang_id);
                
        $data_array = array();
        
        $data_array['blogpost_id'] = $blogpost_id;
        $data_array['lang_id'] = $lang_id;
        if(isset($this->title) )
        {
            $data_array['title'] = $this->title;
        }
        if(isset($this->category_id) )
        {
            $data_array['category_id'] = $this->category_id;
        }
        if(isset($this->slug_url) )
        {
            $data_array['slug_url'] = $this->slug_url;
        }       
        if(isset($this->view_permission) )
        {
            $data_array['view_permission'] = $this->view_permission;
        }
        if(isset($this->blog_text) )
        {
            $data_array['blog_text'] = $this->blog_text;
        }      
        if(isset($this->status) )
        {
            $data_array['status'] = $this->status;;
        }
        if(isset($this->blog_image) )
        {
            $data_array['blog_image'] = $this->blog_image;
        }
        $data_array['created'] = GetCurrentDateTime();      
        $this->db->set($data_array);
        $this->db->insert($this->_tbl_blogpost);
        return $this->db->_error_number(); // return the error occurred in last query
    }
    /**
     * Function get_last_blogpost_id to get last blogpost blogpost id
     */
    public function get_last_blogpost_id() 
    {
        $this->db->select_max('blogpost_id')
                ->from($this->_tbl_blogpost);
        $query = $this->db->get();
        if ($query->num_rows() > 0) 
        {
            $result = $query->row_array();
            return $result['blogpost_id'];
        } 
        else 
        {
            return 0;
        }
    }

    /**
     * Function get_blog_detail to return blog array of particular id
     * @param integer $id 
     */
    public function get_blog_detail($slug_url = '',$id = '',$language_id = '') 
    {
       
        //Type Casting 
        $slug_url = trim(strip_tags($slug_url));
        if(isset($slug_url) && $slug_url!='')
        {
            $this->db->where("slug_url", $slug_url);
        }
         if(isset($id) && $id!='')
        {
            $this->db->where("id", $id);
        }
         if(isset($language_id) && $language_id!='')
        {
            $this->db->where("lang_id", $language_id);
        }
        $this->db->from($this->_tbl_blogpost . ' as b');
        $query = $this->db->get();
       
        if ($query->num_rows() != 0)
        {
            return $this->db->custom_result($query);
        }
    }
    /**
     * Function get_blogpost_listing to fetch all records of blogs
     */
    public function get_blogpost_listing($language_id='1') 
    {
        if ($this->search_term != "") 
        {
            $this->db->like("LOWER(B.title)", strtolower($this->search_term));
        }
        //sortin parameter set start
        if ($this->sort_by != "" && $this->sort_order != "") 
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        } 
        else 
        {
            $this->db->order_by('B.created', 'desc');
        }
        //sorting parameter end
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true) 
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('B.*,C.title,l.*');
        $this->db->from($this->_tbl_blogpost . ' AS B');
        $this->db->join($this->_tbl_categories . ' as C', 'B.category_id = C.category_id', 'left');
        $this->db->join(TBL_LANGUAGES . ' as l', 'B.lang_id = l.id', 'left');
        $this->db->where('C.module_id', '3');
        if ($language_id != '') 
        {
            $this->db->where("C.lang_id", $language_id);
            $this->db->where("B.lang_id", $language_id);
        }
        $this->db->where('B.status !=', -1);
        if ($this->category != "") 
        {
            $category = explode(",", $this->category);
            $this->db->where_in('B.category_id', $category);
        }
        $query = $this->db->get();
        if(isset($this->_record_count) && $this->_record_count == true)
        {
            return count($this->db->custom_result($query));
        }
        else
        {
            return $this->db->custom_result($query);
        }    
    }
    /**
     * Function get_blog_comment_detail to return comment array of particular id
     * @param integer $id 
     */
    public function get_blog_comment_detail($id = 0) 
    {
        //Type Casting 
        $id = intval($id);
        $this->db->where("id", $id);
        $tableblog = $this->db->get($this->_tbl_blog_comment);
        $commentArray = $tableblog->row_array();
        return $commentArray;
    }

    /**
     * Function get_blog_comments to return all comments of pericular blog
     * @param integer $id 
     */
    public function get_blog_comments($id = '',$language_id) 
    {
        $id = intval($id);
        $this->db->select('bc.*');
        $this->db->from($this->_tbl_blog_comment . ' AS bc');
        $this->db->join($this->_tbl_blogpost . ' as b', 'b.id = bc.blogpost_id', 'left');
        $this->db->where("bc.blogpost_id", $id);
        $this->db->where("bc.status", "1");
        $query = $this->db->get();
        $result = $this->db->custom_result($query);
        return $result;
    }

    


    /**
     * Function get_comment_listing to fetch all comments of blogs
     */
    public function get_comment_listing() 
    {
        //sorting parameter set start
        if ($this->sort_by != "" && $this->sort_order != "") 
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        } 
        else 
        {
            $this->db->order_by('BC.created', 'desc');
        }
        //sorting parameter end
        if (isset($this->record_per_page) && isset($this->offset)&& !isset($this->_record_count) && $this->_record_count != true) 
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('BC.*,B.title');
        $this->db->from($this->_tbl_blog_comment . ' AS BC');
        $this->db->join($this->_tbl_blogpost . ' as B', 'B.id=BC.blogpost_id', 'left');
        $this->db->where('BC.status !=', '-1');
        $query = $this->db->get();
        if(isset($this->_record_count) && $this->_record_count == true)
        {
            return count($this->db->custom_result($query));
        }
        else
        {
            return $this->db->custom_result($query);
        }
        
    }

    /**
     * Function blog_category_list to fetch list of blog module category from categories table
     */
    public function blog_category_list($language_id="") 
    {
        $this->db->select("C.*");
        $this->db->from($this->_tbl_categories . ' AS C');
        $this->db->join($this->_tbl_category_modules . ' as CM', 'C.module_id = CM.id', 'left');
        $this->db->where('C.module_id', '3');
        $this->db->where('C.lang_id', $language_id);
        $this->db->where('C.status', 1);
        $result = $this->db->get();
        if ($result->num_rows() > 0) 
        {
            $result = $result->result_array();
            //pre($result);
            return $result;
        } 
        else 
        {
            return NULL;
        }
    }

    /**
     * Function get_category_detail to fetch perticular category detail by id
     */
    public function get_category_detail($id = 0) 
    {
        //Type Casting 
        $id = intval($id);
        $this->db->where("id", $id);
        $tablecategory = $this->db->get($this->_tbl_categories);
        $categoryArray = $tablecategory->row_array();
        return $categoryArray;
    }

    /**
     * Function delete_blog to change blog status as deleted into blogpost table
     */
    public function delete_blog($id) 
    {
        //Type Casting 
        $id = intval($id);
        $this->db->where('id', $id);
        $this->db->set('status', '-1');
        return $this->db->update($this->_tbl_blogpost);
    }

    /**
     * Function delete_blog_comment to change blog comment status as deleted into blogpost_comments table
     */
    public function delete_blog_comment($id) 
    {
        //Type Casting 
        $id = intval($id);
        $this->db->where('id', $id);
        $this->db->set('status', '-1');
        return $this->db->update($this->_tbl_blog_comment);
    }

    /**
     * Function save_comment to save comment into blogposr comments
     */
    public function save_comment($data) 
    {
        $id = 0;
        if ($data['id'] != 0 && $data['id'] != "") 
        {
            $this->db->where('id', $data['id']);
            $this->db->update($this->_tbl_blog_comment, $data);
        } 
        else 
       {
            $this->db->set('created', 'NOW()', FALSE);
            if ($this->db->insert($this->_tbl_blog_comment, $data)) 
            {
                $id = $this->db->insert_id();
            }
       }
        return $id;
    }
    /*
     * check unique slug url for slug url
     */
    public function check_unique_slug($slug_url)
    {
        $this->db->select('B.*');
        $this->db->from($this->_tbl_blogpost . ' AS B');
        $this->db->where('B.slug_url', $slug_url);
        $this->db->where('B.status !=', -1);
        $query = $this->db->get();
        $result = $this->db->custom_result($query);
        return $result;	 
    }
    /**
     * Function delete_records to delete URL
     * @param integer $id 
     */
    public function delete_records($id = array())
    {
        $this->db->where_in('id', $id);
        $this->db->set('status', '-1');
        return $this->db->update($this->_tbl_blogpost);
    }
    /**
     * Function inactive_records to inactive records
     * @param array $id 
     */
    public function inactive_records($id = array())
    {        
        $this->db->set('status', 0);
        $this->db->where_in('id', $id);
        $this->db->update($this->_tbl_blogpost);

        return $id;
    }
    
    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records()
    {        
        $this->db->set('status', 0);
        $this->db->where('status !=', -1);
        $this->db->update($this->_tbl_blogpost);

        return true;
    }
    
    /**
     * Function active_records to active records
     * @param array $id 
     */
    public function active_records($id = array())
    {        
        $this->db->set('status', 1);
        $this->db->where_in('id', $id);
        $this->db->update($this->_tbl_blogpost);

        return $id;
    }
    
    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records()
    {        
        $this->db->set('status', 1);
        $this->db->where('status !=', -1);
        $this->db->update($this->_tbl_blogpost);

        return true;
    }
}
?>