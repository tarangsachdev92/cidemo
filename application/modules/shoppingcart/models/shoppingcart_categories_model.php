<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Shoppingcart Categories Model
 *
 *  To perform queries related to Categories management.
 *
 * @package CIDemoApplication
 * @subpackage Shoppingcart
 * @copyright	(c) 2013, TatvaSoft
 * @author Dipak Patel <dipak.patel@sparsh.com>
 */
class Shoppingcart_categories_model extends Base_Model
{

    protected $_table = TBL_SHOPPINGCART_CATEGORIES;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    public $offset = "";
    public $module = "";

    /**
     * Function get_total_categories to get all active categories total
     */
    function get_total_categories($language_id)
    {
        $language_id = intval($language_id);

        $this->db->select('scc.id');
        $this->db->from($this->_table . ' AS scc');
        $this->db->where('scc.status !=', -1);
        $this->db->where('scc.status !=', 0);
        $this->db->where('scc.lang_id =', $language_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Function get_category_listing to get category listing
     */
    function get_category_listing($language_id = '', $status = -1)
    {
        $language_id = intval($language_id);

        if ($this->search_term != "")
        {
            $this->db->like('LOWER(scc.title)', strtolower($this->search_term), 'both');
        }

        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }

        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }

        $this->db->select('scc.title,scc.slug_url,scc.status,scc.category_id,scc.id,l.language_code');
        $this->db->from($this->_table . ' as scc');
        $this->db->join(TBL_LANGUAGES . ' as l', 'scc.lang_id = l.id', 'left');

        if ($language_id != '')
        {
            $this->db->where("scc.lang_id", $language_id);
        }

        $this->db->where_not_in('scc.status ', $status);

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
     * Function get_category_child_listing to get all child category listing
     */
    function get_category_child($category_id, $language_id = '')
    {
        $category_id = intval($category_id);
        $language_id = intval($language_id);

        $this->db->select('scc.id');
        $this->db->from($this->_table . ' AS scc');
        $this->db->where("scc.parent_id", $category_id);
        $this->db->where("scc.lang_id", $language_id);
        $this->db->where('scc.status =', 1);

        $query = $this->db->get();

        return $query->num_rows();
    }

    /**
     * Function get_category_detail_by_id to get category detail
     */
    public function get_category_detail_by_id($category_id, $lang_id = '')
    {
        $category_id = intval($category_id);
        $lang_id = intval($lang_id);

        if ($lang_id == 0)
        {
            $this->db->select('scc.title,scc.slug_url,scc.status,scc.category_id,scc.id,scc.meta_description,scc.meta_keywords,scc.category_image,scc.description')
                    ->from($this->_table . ' as scc')
                    ->where(array('scc.category_id' => $category_id))
                    ->where('scc.status !=', -1);
        }
        else
        {
            $this->db->select('scc.title,scc.slug_url,scc.status,scc.category_id,scc.id,scc.meta_description,scc.meta_keywords,scc.category_image,scc.description')
                    ->from($this->_table . ' as scc')
                    ->where(array('scc.category_id' => $category_id, 'scc.lang_id' => $lang_id))
                    ->where('scc.status !=', -1);
        }
        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function get_related_lang_category to check category record exist or not
     */
    public function get_related_lang_category($category_id, $lang_id)
    {
        $category_id = intval($category_id);
        $lang_id = intval($lang_id);

        $this->db->select('scc.id')
                ->from($this->_table . ' as scc')
                ->where(array('scc.category_id' => $category_id, 'scc.lang_id' => $lang_id))
                ->where('scc.status !=', -1);

        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function inactive_all_child_category to inactive all child category
     */
    function active_inactive_all_child_category($parent_category_id = array(), $lang_id = 0, $status)
    {
        $lang_id = intval($lang_id);
        $status = intval($status);

        $data_array = array(
            'status' => $status,
            'modify_on' => GetCurrentDateTime(),
            'modify_by' => $this->session->userdata[get_current_section($this, true)]['user_id']
        );

        $this->db->where_in('category_id', $parent_category_id);

        if ($lang_id != 0)
        {
            $this->db->where('lang_id', $lang_id);
        }

        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_last_category_id to get last category inserted id
     */
    function get_last_category_id()
    {
        $this->db->select_max('category_id')
                ->from($this->_table);

        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['category_id'];
        }
        else
        {
            return 0;
        }
    }

    /**
     * Function insert_category to insert record
     */
    function insert_category($category_id, $lang_id)
    {
        $category_id = intval($category_id);
        $lang_id = intval($lang_id);

        $data_array = array();

        $data_array['category_id'] = $category_id;
        $data_array['lang_id'] = $lang_id;

        if (isset($this->parent_id))
        {
            $data_array['parent_id'] = $this->parent_id;
        }

        if (isset($this->title))
        {
            $data_array['title'] = $this->title;
        }

        if (isset($this->slug_url))
        {
            $data_array['slug_url'] = $this->slug_url;
        }

        if (isset($this->description))
        {
            $data_array['description'] = $this->description;
        }

        if (isset($this->category_image))
        {
            $data_array['category_image'] = $this->category_image;
        }

        if (isset($this->meta_keywords))
        {
            $data_array['meta_keywords'] = $this->meta_keywords;
        }

        if (isset($this->meta_description))
        {
            $data_array['meta_description'] = $this->meta_description;
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
     * Function update_category to update record
     */
    function update_category($category_id, $lang_id)
    {
        $category_id = intval($category_id);
        $lang_id = intval($lang_id);

        $data_array = array();

        if (isset($this->parent_id))
        {
            $data_array['parent_id'] = $this->parent_id;
        }

        if (isset($this->title))
        {
            $data_array['title'] = $this->title;
        }

        if (isset($this->slug_url))
        {
            $data_array['slug_url'] = $this->slug_url;
        }

        if (isset($this->description))
        {
            $data_array['description'] = $this->description;
        }
        if (isset($this->category_image))
        {
            $data_array['category_image'] = $this->category_image;
        }

        if (isset($this->meta_keywords))
        {
            $data_array['meta_keywords'] = $this->meta_keywords;
        }

        if (isset($this->meta_description))
        {
            $data_array['meta_description'] = $this->meta_description;
        }

        if (isset($this->status))
        {
            $data_array['status'] = $this->status;
        }

        $data_array['modify_on'] = GetCurrentDateTime();
        $data_array['modify_by'] = $this->session->userdata[get_current_section($this, true)]['user_id'];

        $this->db->where(array('category_id' => $category_id, 'lang_id' => $lang_id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function getallcategories to get categories list
     * @params integer $category_id
     */
    public function getallcategories($language_id = 0, $parent_id = 0, $categories_child = '')
    {
        $language_id = intval($language_id);
        $parent_id = intval($parent_id);

        if ($categories_child != '')
        {
            $ts = array_unique(array_merge(array_filter(explode("|", $categories_child))));
            $this->db->where_not_in('scc.category_id ', $ts);
        }

        $this->db->select('scc.id, scc.category_id, scc.parent_id, scc.lang_id, scc.title, scc.slug_url, scc.category_image, scc.description, scc.meta_keywords, scc.meta_description,scc.status');
        $this->db->from($this->_table . ' as scc');

        if ($language_id != 0)
        {
            $this->db->join(TBL_LANGUAGES . ' as l', 'scc.lang_id = l.id', 'inner');
        }

        $this->db->where('scc.status !=', -1);
        $this->db->where('scc.status !=', 0);

        if ($language_id != 0)
        {
            $this->db->where('scc.lang_id =', $language_id);
        }

        $this->db->where('scc.parent_id =', $parent_id);

        $this->db->order_by('scc.title', 'ASC');

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
     * Function delete_category for delete category
     * @param integer $id
     */
    public function delete_category($id)
    {
        $id = intval($id);
        $data_array = array('status' => '-1');
        $this->db->where('id', intval($id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_category_detail_by_slugurl to get category detail
     */
    public function get_category_detail_by_slugurl($language_id, $slug_url = '')
    {
        $language_id = intval($language_id);
        $slug_url = trim(strip_tags($slug_url));

        $this->db->select('scc.id,scc.category_id,scc.parent_id,scc.title,scc.slug_url,scc.category_image,scc.description,scc.meta_keywords,scc.meta_description');
        $this->db->from($this->_table . ' as scc');
        $this->db->where('scc.slug_url =', $slug_url);
        $this->db->where('scc.lang_id =', $language_id);
        $this->db->where('scc.status =', 1);
        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function update_category_inactive_all_lang for inactive other lang for same category
     * @param integer $id category id
     */
    public function update_category_inactive_all_lang($id)
    {
        $id = intval($id);
        $data_array = array('status' => '0');
        $this->db->where('category_id', intval($id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function get_category_by_id to get category detail by primary id
     */
    public function get_category_by_id($id, $lang_id = '')
    {
        $id = intval($id);
        $lang_id = intval($lang_id);

        if ($lang_id == 0)
        {
            $this->db->select('scc.category_id')
                    ->from($this->_table . ' as scc')
                    ->where(array('scc.id' => $id))
                    ->where('scc.status !=', -1);
        }
        else
        {
            $this->db->select('scc.category_id')
                    ->from($this->_table . ' as scc')
                    ->where(array('scc.id' => $id, 'scc.lang_id' => $lang_id))
                    ->where('scc.status !=', -1);
        }
        $query = $this->db->get();

        return $this->db->custom_result($query);
    }

    /**
     * Function delete_all_child_category to delete all child category
     */
    function delete_all_child_category($parent_category_id = array(), $lang_id = 0)
    {
        $lang_id = intval($lang_id);

        $data_array = array(
            'status' => -1,
            'modify_on' => GetCurrentDateTime(),
            'modify_by' => $this->session->userdata[get_current_section($this, true)]['user_id']
        );

        $this->db->where_in('category_id', $parent_category_id);

        if ($lang_id != 0)
        {
            $this->db->where('lang_id', $lang_id);
        }

        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

    /**
     * Function update_category_image to update category image common image for same category in use of multi lang
     */
    function update_category_image($category_id, $lang_id)
    {
        $category_id = intval($category_id);
        $lang_id = intval($lang_id);

        $data_array = array();

        if (isset($this->category_image))
        {
            $data_array['category_image'] = $this->category_image;
        }

        $data_array['modify_on'] = GetCurrentDateTime();
        $data_array['modify_by'] = $this->session->userdata[get_current_section($this, true)]['user_id'];

        $this->db->where(array('category_id' => $category_id, 'lang_id' => $lang_id));
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }

}