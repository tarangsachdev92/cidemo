<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quiz_attempted_questions_model extends Base_Model
{
    protected $_table = TBL_QUIZ_ATTEMPTED_QUESTIONS;
    /*
     * to insert data into quiz_attempted_questions table
     * @param array $insert_data
     */
    function insert_attempted_question($insert_data = array())
    {
        $this->db->set($insert_data);
        return $this->db->insert($this->_table);
    }
    /*
     * to get all attempted true qustions
     * @param int $user_id,int $quiz_id
     */
    function get_total_attempted_true_questions($user_id = '', $quiz_id = '')
    {
        $user_id = intval($user_id);
        $quiz_id = intval($quiz_id);
        $this->db->select('count(is_correct_option) as total_true');
        $this->db->from($this->_table . " AS qaq");
        $this->db->where('qaq.is_correct_option', '1');
        $this->db->where('qaq.user_id', $user_id);
        $this->db->where('qaq.quiz_id', $quiz_id);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }
    /*
     * to get all attempted false qustions
     * @param int $user_id,int $quiz_id
     */
    function get_total_attempted_false_questions($user_id = '', $quiz_id = '')
    {
        $user_id = intval($user_id);
        $quiz_id = intval($quiz_id);
        $this->db->select('count(is_correct_option) as total_false');
        $this->db->from($this->_table . " AS qaq");
        $this->db->where('qaq.is_correct_option', '0');
        $this->db->where('qaq.user_id', $user_id);
        $this->db->where('qaq.quiz_id', $quiz_id);
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

}

