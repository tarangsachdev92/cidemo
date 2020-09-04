<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quiz_questions_model extends Base_Model
{
    protected $_table = TBL_QUIZ_QUESTIONS;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    /*
     * to get active questions
     */
    public function select_all($fetch_details_arr = array())
    {
        if ($fetch_details_arr['mode'] == "fetch_all_active")
        {
            $this->db->select("qq.*, ch.chapter_name, s.subject_name as subject_name, c.title as category_title, l.*");
            $this->db->from($this->_table . ' as qq');
            $this->db->join(TBL_QUIZ_CHAPTERS . ' as ch', 'ch.chapter_id = qq.chapter_id', 'left');
            $this->db->join(TBL_QUIZ_SUBJECTS . ' as s', 's.subject_id = ch.subject_id', 'left');
            $this->db->join(TBL_CATEGORIES . ' as c', 'c.category_id = s.category_id', 'left');
            $this->db->join(TBL_LANGUAGES . ' as l', 'qq.lang_id = l.id', 'left');
            $this->db->where('qq.status =', '1');

            if (isset($fetch_details_arr['language_id']) && $fetch_details_arr['language_id'] != '')
            {
                $language_id = $fetch_details_arr['language_id'];

                $this->db->where("qq.lang_id", $language_id);
                $this->db->where("ch.lang_id", $language_id);
                $this->db->where("s.lang_id", $language_id);
                $this->db->where("c.lang_id", $language_id);
            }

            $this->db->order_by("qq.question", "asc");

            $query = $this->db->get();
            return $this->db->custom_result($query);
        }
    }
    /*
     * to get all questions
     */

    function get_questions_listing($language_id = '')
    {
        $language_id = intval($language_id);

        if ($this->search_term != "")
        {
            $this->db->like('qq.question', $this->search_term, 'both');
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select("qq.*, ch.chapter_name, s.subject_name as subject_name, c.title as category_title, l.*");
        $this->db->from($this->_table . ' as qq');
        $this->db->join(TBL_QUIZ_CHAPTERS . ' as ch', 'ch.chapter_id = qq.chapter_id', 'left');
        $this->db->join(TBL_QUIZ_SUBJECTS . ' as s', 's.subject_id = ch.subject_id', 'left');
        $this->db->join(TBL_CATEGORIES . ' as c', 'c.category_id = s.category_id', 'left');
        $this->db->join(TBL_LANGUAGES . ' as l', 'qq.lang_id = l.id', 'left');

        if ($language_id != '')
        {
            $this->db->where("qq.lang_id", $language_id);
            $this->db->where("ch.lang_id", $language_id);
            $this->db->where("s.lang_id", $language_id);
            $this->db->where("c.lang_id", $language_id);
        }
        $this->db->where('qq.status !=', '-1');

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
     * to insert data into quiz_questions table
     * @param array $data_array
     */
    function insert($data_array = array())
    {   //pre($data_array);exit;
        $this->db->set($data_array);
        $this->db->insert($this->_table);
        return $this->db->insert_id();
    }
    /*
     * to update data into quiz_questions table
     * @param array $data_array
     */
    function update($language_id, $id, $data_array = array())
    {
        $id = intval($id);

        $this->db->where(array('question_id' => $id));
        $this->db->where('lang_id', $language_id);
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }
    /*
     * to delete data from quiz_questions table
     * @param int $id
     */
    function delete($id)
    {
        $id = intval($id);

        $this->db->where(array('question_id' => $id));
        $this->db->set(array('status' => '-1'));
        $this->db->update($this->_table);
    }
    /*
     * to get details by multiple id
     * @param array $id_array
     */
    function get_details_by_ids($language_id, $id_array = array(), $selectparam = "*")
    {
        $this->db->select($selectparam)
                ->from($this->_table . ' AS qq')
                ->where('lang_id', $language_id)
                ->where_in('question_id', $id_array);

        $query = $this->db->get();
        $result = $this->db->custom_result($query);
        return $this->db->custom_result($query);
    }
    /*
     * to get unattempted question for particular user id
     * @param int $quiz_id, int $user_id
     */
    function get_unattempted_questions($language_id, $quiz_id = '', $user_id = '')
    {
        $this->db->select('qq.*, qu.*');
        $this->db->from($this->_table . ' AS qq');
        $this->db->join(TBL_QUIZZES_QUESTIONS . ' AS qu', 'qu.question_id = qq.question_id', 'left');
        $this->db->where('qu.quiz_id', $quiz_id);
        $this->db->where('qu.question_id NOT IN
                        (
                            SELECT qaq.attempted_question_id
                            FROM ' . TBL_QUIZ_ATTEMPTED_QUESTIONS . ' qaq
                            WHERE qaq.quiz_id = ' . $quiz_id . ' AND qaq.user_id = ' . $user_id . '
                        )');
        $this->db->where('qq.lang_id', $language_id);
        $this->db->limit(1);
        $query = $this->db->get();
        //pre($this->db->last_query());
        return $this->db->custom_result($query);
    }
    /*
     * to get options of question by question id
     * @param $question_id
     */
    function get_question_options($language_id, $question_id = '')
    {
        $this->db->select('qqo.*');
        $this->db->from(TBL_QUIZ_QUESTION_OPTIONS . ' AS qqo');
        $this->db->where('qqo.question_id', $question_id);
        $this->db->where('lang_id', $language_id);

        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /*
     * to check whether the question_id with such a language_id exists or not
     * @param $language_id, $id
     */
    function check_existence($language_id, $id)
    {
        $this->db->select('*')
                ->from($this->_table . ' AS qq')
                ->where('lang_id', $language_id)
                ->where('question_id', $id);

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
        $this->db->select_max('question_id')
                ->from($this->_table);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['question_id'];
        }
        else
        {
            return 0;
        }
    }
}