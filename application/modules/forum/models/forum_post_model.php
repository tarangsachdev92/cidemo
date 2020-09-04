<?php
/**
 *  Forum Model (actual table -  forum_post)
 *
 *  To perform queries related to  Forum management.
 *
 * @package CIDemoApplication
 * @subpackage Forum
 *
 * @author AVSH
 */

class Forum_post_model extends Base_Model
{
    protected $_tbl_forum_post = TBL_FORUM_POST;
    public $search_term ="";
    public $sort_by ="";
    public $sort_order ="";
    public $offset ="";
    /**
     * Function get_forum_listing for get forums 
     *   
     */
    public function get_forum_listing($category,$language_id)
    {

        if((isset($this->search_term) && $this->search_term != ""))
        {
            $this->db->like("LOWER(forum_post_title)", strtolower($this->search_term));
        }
        if(isset($this->search_term) && isset($this->search_term) && $this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        if(isset($this->id))
        {
            $this->db->where('id =',$this->id);
        }
        if(isset($this->front))
        {
            $this->db->where('status =', 1);
        }
        else
        {
            $this->db->where('status !=', -1);
        }

        $this->db->select('*');
        $this->db->from($this->_tbl_forum_post);
        $this->db->where('status !=', -1);
        $this->db->where('lang_id',$language_id);
        if($category!="")
        {
            $this->db->where('category_id =', intval($category));
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
     * Function forum_post_by_id for get forums by id
     *   
     */
     public function forum_post_by_id($id,$language_id) {

        $this->db->select('fp.*, u.firstname, u.lastname');
        $this->db->from($this->_tbl_forum_post." as fp");
        $this->db->where('fp.status !=', -1);
        $this->db->join(TBL_USERS . ' as u', 'u.id = fp.created_by', 'left');
        if($language_id!="")
        {
            $this->db->where('fp.lang_id',$language_id);
        }

        if($id!="")
        {
            $this->db->where('fp.id =', intval($id));
        }
        $query = $this->db->get();
        $result = $this->db->custom_result($query);
        if(!empty($result))
        {
            return $result[0];
        }
        else
        {
            return false;
        }
    }
    /**
     * Function total_forum_by_category for get count of total forum by category
     *   
     */
    public function total_forum_by_category($id,$language_id) {
        $this->db->select('*');
        $this->db->from($this->_tbl_forum_post);
        $this->db->where('status !=', -1);
        $this->db->where('lang_id',$language_id);
        $this->db->where('category_id =', $id);
        $result = $this->db->get();
        return count($result->result_array());
    }
    /**
     * Function updated_date for modify date
     *   
     */
    public function updated_date($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->set('modified_on', 'NOW()', FALSE);
        $this->db->update($this->_tbl_forum_post, $data);
    }
    /**
     * Function forum_adder for add forum
     *   
     */
    public function forum_adder($data)
    {
          if($data['id'] != 0 && $data['id'] != "")
            {
                $this->db->where('id', $data['id']);
                $this->db->set('modified_on', 'NOW()', FALSE);
                $this->db->update($this->_tbl_forum_post, $data);
                $id = $data['id'];
                return $id;
            }
            else
            {
                $this->db->set('created_on', 'NOW()', FALSE);
                $this->db->insert($this->_tbl_forum_post, $data);
            }
    }
    /**
     * Function delete_forum for delete forum
     *   
     */
    public function delete_forum($id)
    {
        //Type Casting
        $id = intval($id);

        $this->db->where('id', $id);
        $this->db->set('status', '-1');
        $this->db->set('deleted_by', $this->session->userdata[$this->theme->get('section_name')]['user_id']);
        $this->db->set('deleted_on', 'NOW()', FALSE);
        return $this->db->update($this->_tbl_forum_post);
    }
    /**
     * Function check_unique_slug for check unique slug
     *   
     */
    public function check_unique_slug($slug_url, $id)
    {
        $this->db->select('*');
        $this->db->from($this->_tbl_forum_post);
        
        if(isset($id) && $id != '' && $id != 0)
        {
            $this->db->where('id != ', $id);
        }
        
        $this->db->where('slug_url', $slug_url);
        $this->db->where('status !=', -1);
        $query = $this->db->get();
        
        // echo $this->db->last_query(); exit;	
        
        $result = $this->db->custom_result($query);
        return $result;
    }
    /**
     * Function get_id_from_slug for get id from slug
     *   
     */
    public function get_id_from_slug($slug_url)
    {
        $this->db->select('id');
        $this->db->from($this->_tbl_forum_post);
        $this->db->where('slug_url', $slug_url);
        $this->db->where('status !=', -1);
        $query = $this->db->get();
        $result = $this->db->custom_result($query);
        if(!empty($result))
        {
            return $result[0];
        }
        else
        {
            return false;
        }
    }
    /**
     * Function inactive_records to inactive records
     * @param array $id
     */
    public function inactive_records($id = array())
    {
        $this->db->set('status', 2);
        $this->db->where_in('id', $id);
        $this->db->update($this->_tbl_forum_post);

        return $id;
    }

    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records()
    {
        $this->db->set('status', 2);
        $this->db->where('status !=', -1);
        $this->db->where('id !=', 1);
        $this->db->update($this->_tbl_forum_post);

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
        $this->db->update($this->_tbl_forum_post);

        return $id;
    }

    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records()
    {
        $this->db->set('status', 1);
        $this->db->where('status !=', -1);
        $this->db->where('id !=', 1);
        $this->db->update($this->_tbl_forum_post);

        return true;
    }

    /**
     * Function delete_records to delete URL
     * @param integer $id
     */
    public function delete_records($id = array())
    {
        $this->db->where_in('id', $id);
        $this->db->set('status', '-1');
        return $this->db->update($this->_tbl_forum_post);
    }
}
?>
