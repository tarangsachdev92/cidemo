<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Quiz_question_options_model extends Base_Model
{
    protected $_table		= TBL_QUIZ_QUESTION_OPTIONS;
    /*
     * to get question options
     */
    public function select_all($fetch_details_arr = array())
    {
        //echo 'fetch_details_arr = ';pre($fetch_details_arr);exit;
        if($fetch_details_arr['mode'] == "fetch_all_from_questions")
        {
//            $question_id_string = $fetch_details_arr['question_id_string'];

            $question_id_array = array();
            $question_id_array = $fetch_details_arr['question_id_array'];

            $this->db->select("qop.* , l.*");
            $this->db->from($this->_table . ' as qop');
            $this->db->join(TBL_LANGUAGES . ' as l', 'l.id = qop.lang_id', 'left');
            $this->db->where_in('qop.question_id', $question_id_array);

            if (isset($fetch_details_arr['language_id']) && $fetch_details_arr['language_id'] != '')
            {
                $language_id = $fetch_details_arr['language_id'];

                $this->db->where("qop.lang_id", $language_id);
            }

            $query = $this->db->get();
            return $this->db->custom_result($query);
        }

        else if($fetch_details_arr['mode'] == "fetch_all_distinct_from_questions")
        {
//            $question_id_string = $fetch_details_arr['question_id_string'];

            $question_id_array = array();
            $question_id_array = $fetch_details_arr['question_id_array'];

            $this->db->select("qop.*, l.*");
            $this->db->from($this->_table . ' as qop');
            $this->db->join(TBL_LANGUAGES . ' as l', 'l.id = qop.lang_id', 'left');
            $this->db->where_in('qop.question_id', $question_id_array);

            if (isset($fetch_details_arr['language_id']) && $fetch_details_arr['language_id'] != '')
            {
                $language_id = $fetch_details_arr['language_id'];

                $this->db->where("qop.lang_id", $language_id);
            }
            $this->db->group_by("qop.option_id");

            $query = $this->db->get();
            //exit($this->db->last_query());
            return $this->db->custom_result($query);
        }
    }
    /*
     * to insert data into quiz_question_options table
     * @param array $data_array
     */

    function insert($data_array = array())
    {   //pre($data_array);exit;
        $this->db->set($data_array);
        $this->db->insert($this->_table);
        return $this->db->insert_id();
    }
    /*
     * to update data into quiz_question_options table
     * @param int $id, int $question_id,array $data_array
     */
    function update($language_id, $id, $question_id, $data_array = array())
    {
        $id = intval($id);

        $this->db->where(array('option_id' => $id, 'question_id' => $question_id));
        $this->db->where('lang_id', $language_id);
        $this->db->set($data_array);
        $this->db->update($this->_table);
    }
    /*
     * to delete data from quiz_question_options table
     * @param int $id
     */
    function delete($id)
    {
        $id = intval($id);

        $this->db->where(array('option_id' => $id));
        $this->db->delete($this->_table);
    }
    /*
     * to get detail of multiple option by ids
     * @param array $id_array
     */
    function get_details_by_ids($language_id, $id_array = array(), $selectparam = "*")
    {
        $this->db->select($selectparam)
                ->from($this->_table.' AS qop')
                ->where('lang_id', $language_id)
                ->where_in('option_id', $id_array);
                
        $query = $this->db->get();
        //$result = $this->db->custom_result($query);
        return $this->db->custom_result($query);
    }
    /*
     * to check answer is right or wrong
     * @param int $option_id, int $question_id
     */
    function check_answer($language_id, $option_id = '', $question_id = '')
    {
        $this->db->select('qqo.*');
        $this->db->from($this->_table . ' AS qqo');
        $this->db->where('qqo.option_id', $option_id);
        $this->db->where('qqo.question_id', $question_id);
        $this->db->where('qqo.is_correct_answer', '1');
        $this->db->where('qqo.lang_id', $language_id);

        $count = $this->db->get()->num_rows();
        return $count;
    }
    /*
     * to get selected option
     * @param int $option_id, int $question_id
     */
    function get_selected_option($language_id, $option_id = '', $question_id = '')
    {
        $this->db->select('qqo.*');
        $this->db->from($this->_table . ' AS qqo');
        $this->db->where('qqo.option_id', $option_id);
        $this->db->where('qqo.question_id', $question_id);
        $this->db->where('qqo.lang_id', $language_id);

        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /**
     * Function get_max_id to get max id
     */
    function get_max_id()
    {
        $this->db->select_max('option_id')
                ->from($this->_table);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['option_id'];
        }
        else
        {
            return 0;
        }
    }
}