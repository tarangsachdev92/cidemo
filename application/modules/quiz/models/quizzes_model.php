<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Quizzes_model extends Base_Model
{
    protected $_table = TBL_QUIZZES;
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = "";
    /*
     * get quiz detail for the front side
     * @param int $language_id
     */

    public function get_all_quizzes_details_for_front($language_id = '')
    {
        $language_id = intval($language_id);
        $this->db->select("qz.*,qch.*,qs.*,qc.*,qc.title as category_title");
        $this->db->from($this->_table . ' as qz');
        $this->db->join(TBL_QUIZZES_QUESTIONS . ' as qzq', 'qzq.quiz_id = qz.quiz_id', 'left');
        $this->db->join(TBL_QUIZ_QUESTIONS . ' as qq', 'qq.question_id = qzq.question_id', 'left');
        $this->db->join(TBL_QUIZ_CHAPTERS . ' as qch', 'qch.chapter_id = qq.chapter_id', 'left');
        $this->db->join(TBL_QUIZ_SUBJECTS . ' as qs', 'qs.subject_id = qch.subject_id', 'left');
        $this->db->join(TBL_CATEGORIES . ' as qc', 'qc.category_id = qs.category_id', 'left');
        $this->db->where('qz.lang_id', $language_id);
        $this->db->group_by("qz.quiz_id");
        $this->db->order_by("qz.quiz_id", "desc");
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }

    /*
     * to get single quiz detail by id
     * @param int $quiz_id
     */

    public function get_quizze_details_by_id($language_id, $quiz_id = '')
    {
        $quiz_id = intval($quiz_id);
        $this->db->select("qz.*,qch.*,qs.*,qc.*");
        $this->db->from($this->_table . ' as qz');
        $this->db->join(TBL_QUIZZES_QUESTIONS . ' as qzq', 'qzq.quiz_id = qz.quiz_id', 'left');
        $this->db->join(TBL_QUIZ_QUESTIONS . ' as qq', 'qq.question_id = qzq.question_id', 'left');
        $this->db->join(TBL_QUIZ_CHAPTERS . ' as qch', 'qch.chapter_id = qq.chapter_id', 'left');
        $this->db->join(TBL_QUIZ_SUBJECTS . ' as qs', 'qs.subject_id = qch.subject_id', 'left');
        $this->db->join(TBL_CATEGORIES . ' as qc', 'qc.category_id = qs.category_id', 'left');
        $this->db->where('qz.quiz_id', $quiz_id);
        $this->db->where('qq.lang_id', $language_id);
        $this->db->where('qch.lang_id', $language_id);
        $this->db->where('qs.lang_id', $language_id);
        $this->db->where('qc.lang_id', $language_id);
        $this->db->where('qc.module_id', $this->config->item("quiz_module_id"));
        $this->db->group_by("qz.quiz_id");
        $query = $this->db->get();
        return $this->db->custom_result($query);
    }
    /*
     * to get questions by category id
     * @param $category_id
     */

    public function get_questions_by_categories($language_id, $category_id = "")
    {
        $query = "SELECT
                    qq . * , 
                    qch.chapter_name AS chapter_name, 
                    qs.subject_name AS subject_name, 
                    qc.title AS category_title
                    FROM ".TBL_QUIZ_QUESTIONS." qq
                    LEFT JOIN ".TBL_QUIZ_CHAPTERS." qch ON qch.chapter_id = qq.chapter_id
                    LEFT JOIN ".TBL_QUIZ_SUBJECTS." qs ON qs.subject_id = qch.subject_id
                    LEFT JOIN " . TBL_CATEGORIES . " qc ON qc.category_id = qs.category_id
                    WHERE (qc.parent_id IN ($category_id) OR (qc.parent_id = 0 AND qc.category_id IN ($category_id)))
                    AND qc.module_id = '".$this->config->item("quiz_module_id")."'
                    AND qq.lang_id = '".$language_id."' AND qch.lang_id = '".$language_id."'
                    AND qs.lang_id = '".$language_id."' AND qc.lang_id = '".$language_id."'";

        $result =  $this->db->query($query)->result_array();
        //exit($this->db->last_query());
        return $result;
    }
    /*
     * to get questions by perticular quiz id 
     * @param $quiz_id
     */

    public function get_questions_by_quiz($language_id, $quiz_id = "")
    {
        $query = "SELECT 
                    qq.*,
                    qch.chapter_name AS chapter_name,
                    qs.subject_name AS subject_name, 
                    qc.title AS category_title
                FROM ".TBL_QUIZZES_QUESTIONS." as qzq
                LEFT JOIN ".TBL_QUIZ_QUESTIONS." as qq ON qq.question_id = qzq.question_id
                LEFT JOIN ".TBL_QUIZ_CHAPTERS." qch ON qch.chapter_id = qq.chapter_id
                LEFT JOIN ".TBL_QUIZ_SUBJECTS." qs ON qs.subject_id = qch.subject_id
                LEFT JOIN " . TBL_CATEGORIES . " qc ON qc.category_id = qs.category_id
                WHERE quiz_id = '".$quiz_id."'
                AND qc.module_id = '".$this->config->item("quiz_module_id")."'
                AND qq.lang_id = '".$language_id."' AND qch.lang_id = '".$language_id."'
                AND qs.lang_id = '".$language_id."' AND qc.lang_id = '".$language_id."'";

        $result =  $this->db->query($query)->result_array();
        return $result;
    }
    /*
     * to insert data into quizzes table
     * @param array $data_array
     */

    public function insert($data_array = array())
    {
        $this->db->set($data_array);
        $this->db->set('created_datetime', 'NOW()', FALSE);
        $this->db->insert($this->_table);
        return $this->db->insert_id();
    }
    /*
     * to update data into quizzes table
     * @param int quiz id as $id , array $data_array
     */
    function update($language_id, $id, $data_array = array())
    {
        $id = intval($id);
        $this->db->set('updated_datetime', 'NOW()', FALSE);
        $this->db->set($data_array);
        $this->db->where(array('quiz_id' => $id));
        $this->db->where('lang_id', $language_id);
        $this->db->update($this->_table);
    }
    /*
     * to delete data into quizzes table
     * @param int quiz id as $id
     */
    function delete($id = "")
    {
        $id = intval($id);
        $this->db->set('updated_datetime', 'NOW()', FALSE);
        $this->db->set('status','0',FALSE);
        $this->db->where(array('quiz_id' => $id));
        echo $this->db->last_query(); 
        return $this->db->update($this->_table);
    }
    /*
     * to delete questions by quiz id
     * @param $quiz_id
     */
    function delete_quizzes_questions($quiz_id = "")
    {
        $this->db->where(array('quiz_id' => $quiz_id));
        $this->db->delete(TBL_QUIZZES_QUESTIONS);
    }

    /*
     * to get listing of quizzes
     * @param int $language_id
     */

    public function get_quizzes_listing($language_id = '')
    {
        $language_id = intval($language_id);

        if($this->search_term != "")
        {
            $this->db->like('q.quiz_title', $this->search_term, 'both');
        }
        if($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select('q.*');
        $this->db->from($this->_table . ' as q');
        $this->db->where('q.lang_id', $language_id);

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
     * to get details of multiple quiz by ids
     * @param array $id_array
     */
    function get_details_by_ids($language_id, $id_array = array(), $selectparam = "*")
    {
        $this->db->select($selectparam)
                ->from($this->_table.' AS q')
                ->where('lang_id', $language_id)
                ->where_in('quiz_id', $id_array);

        $query = $this->db->get();
        return $this->db->custom_result($query);
    }
    /*
     * to get quizz category by quiz id
     * @param int $quiz_id
     */
    function get_category_by_quizzes($language_id, $id = 0)
    {
        $query = "SELECT qc . category_id 
                FROM ".$this->_table." as qz
                LEFT JOIN ".TBL_QUIZZES_QUESTIONS." as qzq ON qzq.quiz_id = qz.quiz_id
                LEFT JOIN ".TBL_QUIZ_QUESTIONS." as qq ON qq.question_id = qzq.question_id
                LEFT JOIN ".TBL_QUIZ_CHAPTERS." as qch ON qch.chapter_id = qq.chapter_id
                LEFT JOIN ".TBL_QUIZ_SUBJECTS." as qs ON qs.subject_id = qch.subject_id
                LEFT JOIN ".TBL_CATEGORIES." as qc ON qc.category_id = qs.category_id
                WHERE qz.quiz_id = '".$id."' AND qz.lang_id = '".$language_id."'
                AND qc.module_id = '".$this->config->item("quiz_module_id")."'
                AND qq.lang_id = '".$language_id."' AND qch.lang_id = '".$language_id."'
                AND qs.lang_id = '".$language_id."' AND qc.lang_id = '".$language_id."'
                GROUP BY qc.category_id";
        
        $result =  $this->db->query($query)->result_array();
        //exit($this->db->last_query());
        return $result;
    }
    /*
     * to get over all report of quiz about who has played last quizzes
     * $param $language_id
     */
    function get_quizzes_report_dashboard($language_id = "")
    {
        if ($this->search_term != "")
        {
            $this->db->like('q.quiz_title', $this->search_term, 'both');
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        if (isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
            $this->db->limit($this->record_per_page, $this->offset);
        }
        $this->db->select("q.quiz_title, 
            CONCAT(u.firstname,' ' ,u.lastname) AS username,
            CONCAT(SUM(qaq.is_correct_option),'/',COUNT(qaq.attempted_question_id)) AS result", FALSE);
        $this->db->from(TBL_QUIZ_ATTEMPTED_QUESTIONS . " AS qaq ");
        $this->db->join(TBL_QUIZZES . " AS q ", " q.quiz_id = qaq.quiz_id ", " left ");
        $this->db->join(TBL_USERS . " AS u ", " u.id = qaq.user_id ", " left ");
        $this->db->where("q.lang_id", $language_id);
        $this->db->group_by("qaq.quiz_id");
        $this->db->order_by("q.quiz_id", "DESC");
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
     * record count for get_quizzes_report_dashboard
     * @param int $language_id
     */
    function record_count_quizzes_report_dashboard($language_id)
    {
        if ($this->search_term != "")
        {
            $this->db->like('q.quiz_title', $this->search_term, 'both');
        }
        if ($this->sort_by != "" && $this->sort_order != "")
        {
            $this->db->order_by($this->sort_by, $this->sort_order);
        }
        $this->db->select("q.quiz_title,
            CONCAT(u.firstname,' ' ,u.lastname) AS username,
            CONCAT(SUM(qaq.is_correct_option),'/',COUNT(qaq.attempted_question_id)) AS result", FALSE);
        $this->db->from(TBL_QUIZ_ATTEMPTED_QUESTIONS . " AS qaq ");
        $this->db->join(TBL_QUIZZES . " AS q ", " q.quiz_id = qaq.quiz_id ", " left ");
        $this->db->join(TBL_USERS . " AS u ", " u.id = qaq.user_id ", " left ");
        $this->db->where("q.lang_id", $language_id);
        $this->db->group_by("qaq.quiz_id");
        $this->db->order_by("q.quiz_id", "DESC");
        $count = $this->db->get()->num_rows();
        return $count;
    }

    /*
     * to check whether the quiz_id with such a language_id exists or not
     * @param $language_id, $id
     */
    function check_existence($language_id, $id)
    {
        $this->db->select('*')
                ->from($this->_table . ' AS q')
                ->where('lang_id', $language_id)
                ->where('quiz_id', $id);

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
        $this->db->select_max('quiz_id')
                ->from($this->_table);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['quiz_id'];
        }
        else
        {
            return 0;
        }
    }
}