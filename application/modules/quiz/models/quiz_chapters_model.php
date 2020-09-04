<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quiz_chapters_model extends Base_Model
{

    protected $_table = TBL_QUIZ_CHAPTERS;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    /*
     * to get all active chapters
     */
    public function select_all($fetch_details_arr = array())
    {
        if ($fetch_details_arr['mode'] == "fetch_all_active")
        {
            $this->db->select("ch.* , s.subject_name as subject_name, c.title as category_title, l.*");
            $this->db->from($this->_table . ' as ch');
            $this->db->join(TBL_QUIZ_SUBJECTS . ' as s', 's.subject_id = ch.subject_id', 'left');
            $this->db->join(TBL_CATEGORIES . ' as c', 'c.category_id = s.category_id', 'left');
            $this->db->join(TBL_LANGUAGES . ' as l', 'ch.lang_id = l.id', 'left');
            $this->db->where('ch.status =', '1');

            if (isset($fetch_details_arr['language_id']) && $fetch_details_arr['language_id'] != '')
            {
                $language_id = $fetch_details_arr['language_id'];

                $this->db->where("ch.lang_id", $language_id);
                $this->db->where("s.lang_id", $language_id);
                $this->db->where("c.lang_id", $language_id);
            }

            $this->db->order_by("ch.chapter_name", "asc");

            $query = $this->db->get();
            return $this->db->custom_result($query);
        }
        else if ($fetch_details_arr['mode'] == "fetch_all_from_subjects")
        {
            $subject_id_string = $fetch_details_arr['subject_id_string'];
            $subject_id_array = array();
            $subject_id_array = explode(",", $subject_id_string);

            $this->db->select("ch.* , s.subject_name as subject_name, c.title as category_title, l.*");
            $this->db->from($this->_table . ' as ch');
            $this->db->join(TBL_QUIZ_SUBJECTS . ' as s', 's.subject_id = ch.subject_id', 'left');
            $this->db->join(TBL_CATEGORIES . ' as c', 'c.category_id = s.category_id', 'left');
            $this->db->join(TBL_LANGUAGES . ' as l', 'ch.lang_id = l.id', 'left');
            $this->db->where_in('ch.subject_id', $subject_id_array);
            $this->db->where('ch.status =', '1');

            if (isset($fetch_details_arr['language_id']) && $fetch_details_arr['language_id'] != '')
            {
                $language_id = $fetch_details_arr['language_id'];

                $this->db->where("ch.lang_id", $language_id);
                $this->db->where("s.lang_id", $language_id);
                $this->db->where("c.lang_id", $language_id);
            }

            $this->db->order_by("ch.chapter_name", "asc");

            $query = $this->db->get();
            //echo $this->db->last_query();
            return $this->db->custom_result($query);
        }
    }
    /*
     * to get chapter listing
     */
    function get_chapters_listing($language_id = '')
    {
        $language_id = intval($language_id);

        if ($this->search_term != "")
        {
            $this->db->like('ch.chapter_name', $this->search_term, 'both');
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        //exit('sort by = '.$this->sort_by);

        $this->db->select("ch.* , s.subject_name as subject_name, c.title as category_title, l.*");
        $this->db->from($this->_table . ' as ch');
        $this->db->join(TBL_QUIZ_SUBJECTS . ' as s', 's.subject_id = ch.subject_id', 'left');
        $this->db->join(TBL_CATEGORIES . ' as c', 'c.category_id = s.category_id', 'left');
        $this->db->join(TBL_LANGUAGES . ' as l', 'ch.lang_id = l.id', 'left');

        if ($language_id != '')
        {
            $this->db->where("ch.lang_id", $language_id);
            $this->db->where("s.lang_id", $language_id);
            $this->db->where("c.lang_id", $language_id);
        }
        $this->db->where('ch.status !=', '-1');

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
    /*
     * to insert data into quiz_chapters table
     * @param array $data_array
     */
    function insert($data_array = array())
    {   //pre($data_array);exit;
        $this->db->set($data_array);
        $this->db->insert($this->_table);
        return $this->db->insert_id();
    }
    /*
     * to update data into quiz_chapters table
     * @param int $id , array $data_array
     */
    function update($language_id, $id, $data_array = array())
    {
        $id = intval($id);

        $this->db->where('chapter_id', $id);
        $this->db->where('lang_id', $language_id);
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }
    /*
     * to delete data from quiz_chapters table
     * @param int $id
     */
    function delete($id)
    {
        $id = intval($id);

        $this->db->where(array('chapter_id' => $id));
        $this->db->set(array('status' => '-1'));
        $this->db->update($this->_table);
    }
    /*
     * get chapter details by ids
     * @param array $id_array
     */
    function get_details_by_ids($language_id, $id_array = array(), $selectparam = "*")
    {
        $this->db->select($selectparam)
                ->from($this->_table . ' AS ch')
                ->where('lang_id', $language_id)
                ->where_in('chapter_id', $id_array);

        $query = $this->db->get();
        $result = $this->db->custom_result($query);
        return $this->db->custom_result($query);
        //return $query->result();
    }

    /*
     * to check whether the chapter_id with such a language_id exists or not
     * @param $language_id, $id
     */
    function check_existence($language_id, $id)
    {
        $this->db->select('*')
                ->from($this->_table . ' AS ch')
                ->where('lang_id', $language_id)
                ->where('chapter_id', $id);

        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $this->db->custom_result($query);

        if(empty($result))
            return FALSE;
        else
            return TRUE;
    }
    /**
     * Function get_max_id to get max id
     */
    function get_max_id()
    {
        $this->db->select_max('chapter_id')
                ->from($this->_table);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['chapter_id'];
        }
        else
        {
            return 0;
        }
    }
}

