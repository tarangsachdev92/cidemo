<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quiz extends Base_Front_Controller
{

    /**
     * 	Create an instance
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->access_control($this->access_rules());
        // load required models
        $this->load->model('quizzes_model');
        $this->load->model('quiz_attempted_questions_model');
        $this->load->model('quiz_questions_model');
        $this->load->model('quiz_question_options_model');
        $this->load->model('quizzes_questions_model');

        // load quiz module language file for labels translation
        $this->lang->load('quiz');

        //Load the configuaration file of the quiz module ie. config.php, for more details regarding config class refer the link : http://ellislab.com/codeigniter/user-guide/libraries/config.html

        $this->config->load('config');

        $all_configurations_array = $this->config->config;
        //pre($all_configurations_array);
        // Retrieve a config item named quiz_configuartions
        $quiz_configuartions = $this->config->item('quiz_configuartions');
        $quiz_module_id = $quiz_configuartions['module_id'];

        //set the quiz module id in the global configuratoins so that its value can be retrieved in all models
        $this->config->set_item('quiz_module_id', $quiz_module_id);
        //pre($this->config);
    }

    /**
     * function accessRules to check page access
     * @param string
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array(''),
                'users' => array('@'),
            ),
            array(
                'actions' => array('index', 'ajax_index','quiz_actions'),
                'users' => array('*'),
            )
        );
    }

    /**
     * Default Method: index
     * Displays a list of quizzes.
     */
    public function index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        
        //Initialize
        if ($language_code == '')
        {
            $language_code = $this->session->userdata[$this->section_name]['site_lang_code'];
        }
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        $language_list = $this->languages_model->get_languages();

        $quizzes['language_code'] = $language_detail[0]['l']['language_code'];
        $quizzes['language_id'] = $language_id;
        $quizzes['languages_list'] = $language_list;
        $quizzes['csrf_token'] = $this->security->get_csrf_token_name();
        $quizzes['csrf_hash'] = $this->security->get_csrf_hash();
        $this->theme->view($quizzes);
    }

    /**
     * to load quizzes by ajax method on index page
     */
    public function ajax_index($language_code = '')
    {
        //Type Casting
        $language_code = strip_tags($language_code);
        $language_detail = $this->languages_model->get_languages_by_code($language_code);
        $language_id = $language_detail[0]['l']['id'];

        $quizzes['quizzes'] = $this->quizzes_model->get_all_quizzes_details_for_front($language_id);
        $this->theme->view($quizzes);
    }
    /*
     * for start quiz, get quiz questions, options etc
     */

    public function quiz_actions($language_id, $quiz_id = '', $action = '')
    {
        //Type Casting
        $quiz_id = intval(strip_tags($quiz_id));
        $action = strip_tags($action);
        $user_id = $this->session->userdata[$this->section_name]['user_id'];

        if (empty($action))
        {
            $question = $this->quiz_questions_model->get_unattempted_questions($language_id, $quiz_id, $user_id);
            //pr($question);
            if (count($question) > 0)
            {
                foreach ($question as $key => $value)
                {
                    $options = $this->quiz_questions_model->get_question_options($language_id, $value['qq']['question_id']);
                    $question[$key]['options'] = $options;
                }
                
            } else
            {
                $total_questions = $this->quizzes_questions_model->get_total_questions_by_id($quiz_id);
                $total_true_questions = $this->quiz_attempted_questions_model->get_total_attempted_true_questions($user_id, $quiz_id);
                $total_false_questions = $this->quiz_attempted_questions_model->get_total_attempted_false_questions($user_id, $quiz_id);
            }
            $quizzes = $this->quizzes_model->get_quizze_details_by_id($quiz_id);
            $questions['question'] = $question;
            $questions['quiz_id'] = $quiz_id;
            $questions['quizzes'] = $quizzes;
            $questions['total_questions'] = $total_questions[0]['custom']['total_questions'];
            $questions['total_true_questions'] = $total_true_questions[0]['custom']['total_true'];
            $questions['total_false_questions'] = $total_false_questions[0]['custom']['total_false'];
            $questions['total_attempted_questions'] = $questions['total_true_questions'] + $questions['total_false_questions'];
            $this->theme->view($questions, 'start_quiz');
        }
        elseif (!empty($action) && $action == 'check_answer')
        {
            $option_id = intval($this->input->post('answer'));
            $question_id = intval($this->input->post('question'));

            if (!empty($option_id) && !empty($question_id))
            {
                $result = $this->quiz_question_options_model->check_answer($language_id, $option_id, $question_id);

                $option_data['option'] = $this->quiz_question_options_model->get_selected_option($language_id, $option_id, $question_id);
                if ($result > 0)
                {
                    echo $this->theme->message(lang('msg_correct_answer'), 'success');
                }
                else
                {
                    echo $this->theme->message(lang('msg_wrong_answer'), 'error');
                }
                $this->theme->view($option_data, 'ajax_check_answer');
            } else
            {
                echo $this->theme->message(lang('msg_select_atleast_one_option'), 'error');
            }
        }
        elseif (!empty($action) && $action == 'next_question')
        {
            $option_id = intval($this->input->post('answer'));
            $question_id = intval($this->input->post('question'));

            if (!empty($option_id) && !empty($question_id))
            {
                $result = $this->quiz_question_options_model->check_answer($language_id, $option_id, $question_id);
                $insert_data = array(
                    'user_id' => $user_id,
                    'quiz_id' => $quiz_id,
                    'attempted_question_id' => $question_id,
                    'attempted_option_id' => $option_id,
                    'is_correct_option' => $result
                );
                if ($this->quiz_attempted_questions_model->insert_attempted_question($insert_data))
                {
                    $question = $this->quiz_questions_model->get_unattempted_questions($language_id, $quiz_id, $user_id);
                    if (count($question) > 0)
                    {
                        foreach ($question as $key => $value)
                        {
                            $options = $this->quiz_questions_model->get_question_options($language_id, $value['qq']['question_id']);
                            $question[$key]['options'] = $options;
                        }
                    } else
                    {
                        $total_questions = $this->quizzes_questions_model->get_total_questions_by_id($quiz_id);
                        $total_true_questions = $this->quiz_attempted_questions_model->get_total_attempted_true_questions($user_id, $quiz_id);
                        $total_false_questions = $this->quiz_attempted_questions_model->get_total_attempted_false_questions($user_id, $quiz_id);
                    }
                    $quizzes = $this->quizzes_model->get_quizze_details_by_id($language_id, $quiz_id);
                    $questions['question'] = $question;
                    $questions['quiz_id'] = $quiz_id;
                    $questions['quizzes'] = $quizzes;
                    $questions['total_questions'] = $total_questions[0]['custom']['total_questions'];
                    $questions['total_true_questions'] = $total_true_questions[0]['custom']['total_true'];
                    $questions['total_false_questions'] = $total_false_questions[0]['custom']['total_false'];
                    $questions['total_attempted_questions'] = $questions['total_true_questions'] + $questions['total_false_questions'];
                    $this->theme->view($questions, 'start_quiz');
                }
            }
            else
            {
                   echo $this->theme->message(lang('msg_select_atleast_one_option'), 'error');
            }
        }
    }

}

?>