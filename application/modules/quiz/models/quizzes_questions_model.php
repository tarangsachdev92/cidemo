<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Quizzes_questions_model extends Base_Model
{
    protected $_table		= TBL_QUIZZES_QUESTIONS;
    /*
     * to insert data into quizzes_questions table
     * @param array $data_array
     */
    public function insert($data_array = 0)
    {
        $this->db->set($data_array);
        $this->db->insert($this->_table);
        return $this->db->insert_id();
    }
    /*
     * to get total qustions by quiz id
     * @param int $quiz_id
     */
    public function get_total_questions_by_id($quiz_id = 0)
    {
        $quiz_id = intval($quiz_id);
        $this->db->select('qq.quiz_id, count(qq.question_id) as total_questions');
        $this->db->from($this->_table . " AS qq");
        $this->db->where('qq.quiz_id', $quiz_id);
        $this->db->group_by('qq.quiz_id');
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

}