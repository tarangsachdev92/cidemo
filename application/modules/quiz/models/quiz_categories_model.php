<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Quiz_categories_model extends Base_Model
{
    protected $_table = TBL_CATEGORIES;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    /*
     * to get all active category
     */

    public function select_all($fetch_details_arr = array())
    {
        if($fetch_details_arr['mode'] == "fetch_all_active")
        {
            $this->db->select("c.* , qc.title as parent_category_title, l.*");
            $this->db->from($this->_table . ' as c');
            $this->db->join($this->_table . ' as qc', 'c.parent_id = qc.category_id', 'left');
            $this->db->join(TBL_LANGUAGES . ' as l', 'c.lang_id = l.id', 'left');
            $this->db->where('c.status =', '1');
            $this->db->where('c.module_id =', $this->config->item("quiz_module_id"));

            if (isset($fetch_details_arr['language_id']) && $fetch_details_arr['language_id'] != '')
            {
                $language_id = $fetch_details_arr['language_id'];

                $this->db->where("c.lang_id", $language_id);
                $where = "(qc.lang_id = '".$language_id."' OR qc.lang_id IS NULL)";
                $this->db->where($where);
            }

            $this->db->order_by("c.title", "asc");

            $query = $this->db->get();
            //exit($this->db->last_query());
            return $this->db->custom_result($query);
        }
    }

    /*
     * to get category listing
     */

    function get_categories_listing($language_id = '')
    {
        $language_id = intval($language_id);

        if($this->search_term != "")
        {
            $this->db->like('c.title', $this->search_term, 'both');
        }
        if($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select("c.* ,c.title as category_title, qc.title as parent_category_title, l.*");
        $this->db->from($this->_table . ' as c');
        $this->db->join($this->_table . ' as qc', 'c.parent_id = qc.category_id', 'left');
        $this->db->join(TBL_LANGUAGES . ' as l', 'c.lang_id = l.id', 'left');

        if ($language_id != '')
        {
            $this->db->where("c.lang_id", $language_id);
            $where = "(qc.lang_id = '".$language_id."' OR qc.lang_id IS NULL)";
            $this->db->where($where);
        }

        //$this->db->where("qc.lang_id", $language_id);
        //$this->db->or_where('qc.lang_id', NULL);
        $this->db->where('c.status !=', '-1');
        $this->db->where('c.module_id ', $this->config->item("quiz_module_id"));

        $query = $this->db->get();
        //echo $this->db->last_query();
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
     * Function get_last_cms_id to get lasr cms inserted id
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
    /*
     * to insert data into quiz_categories table
     * @param array $data_array
     */
    function insert($data_array = array())
    {
        $this->db->set($data_array);
        $this->db->insert($this->_table);
        return $this->db->insert_id();
    }
    /*
     * to insert data into quiz_categories table
     * @param int $id, array $data_array
     */
    function update($language_id, $id, $data_array = array())
    {
        $id = intval($id);
        if($language_id != "")
        {
            $this->db->where('lang_id', $language_id);
        }
        $this->db->where('category_id', $id);
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }
    /*
     * to delete data from quiz_categories table
     * @param int $id
     */
    function delete($id)
    {
        $id = intval($id);

        $this->db->where(array('category_id' => $id));
        $this->db->where('c.module_id', $this->config->item("quiz_module_id"));
        $this->db->set(array('status' => '-1'));
        $this->db->update($this->_table);
    }

    /*
     * to get root category by ids
     * @param array $category_ids
     */
    function get_root_categories($language_id, $category_ids = array())
    {
        $this->db->select('c.*, c.title as category_title');
        $this->db->from($this->_table . ' as c');
        $this->db->where('parent_id', '0');
        $this->db->where('c.lang_id', $language_id);
        $this->db->where('c.module_id', $this->config->item("quiz_module_id"));

        if(!empty($category_ids))
        {
            $this->db->where_not_in('category_id', $category_ids);
        }
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }
    /*
     * to get category detail by id
     * @param $id_array
     */
    function get_details_by_ids($language_id, $id_array = array(), $selectparam = "*")
    {
        $this->db->select($selectparam)
                ->from($this->_table.' AS c')
                ->where('c.module_id', $this->config->item("quiz_module_id"))
                ->where('c.lang_id', $language_id)
                ->where_in('category_id', $id_array);

        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $this->db->custom_result($query);
        return $this->db->custom_result($query);
    }
    /*
     * to check whether the category_id with such a language_id exists or not
     * @param $language_id, $id
     */
    function check_existence($language_id, $id)
    {
        $this->db->select('*')
                ->from($this->_table.' AS c')
                ->where('c.module_id', $this->config->item("quiz_module_id"))
                ->where('c.lang_id', $language_id)
                ->where('category_id', $id);

        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $this->db->custom_result($query);

        if(empty($result))
            return FALSE;
        else
            return TRUE;
    }
}