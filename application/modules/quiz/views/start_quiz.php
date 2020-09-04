<div class="quizListDiv">
    <span class="quizTitle" onclick="start_quiz('<?php echo $quizzes[0]['qz']['quiz_id']; ?>')">
        <?php echo $quizzes[0]['qz']['quiz_title']; ?>
    </span>
    <span class="quizDescription">
        <?php echo $quizzes[0]['qz']['description']; ?>
    </span>
    <div class="quizCategoryDiv">
        <span class="quizCategoryTitle"><?php echo $quizzes[0]['qc']['category_title']; ?></span>
        <span class="quizSubjectTitle"><?php echo $quizzes[0]['qs']['subject_name']; ?></span>
        <span class="quizChapterTitle"><?php echo $quizzes[0]['qch']['chapter_name']; ?></span>
    </div>
</div>
<?php
if (count($question) > 0)
{
    ?>
        <div class="question_title">
        <?php echo $question[0]['qq']['question']; ?>
    </div>
    <hr/>
    <div class="option_div">
        <?php
        foreach ($question[0]['options'] as $key => $value)
        {
            ?>
        <span><input type="radio" value="<?= $value['qqo']['option_id'] ?>" name="answer" ><?php echo $value['qqo']['option'] ?></span>
                <?php
            }
            ?>
        </div>
        <hr/>
        <div>
            <input type="button" name="check_ans" value="check" onclick="check_answer()">
            <input type="button" name="next_question" value="Next" onclick="next_question()">
            <input type="hidden" name="hdn_question_id" id="hdn_question_id" value="<?php echo $question[0]['qq']['question_id']; ?>">
            <input type="hidden" name="hdn_quiz_id" id="hdn_quiz_id" value="<?php echo $quiz_id; ?>">
        </div>
        <?php
    } else
    {
    ?>
        <div class="quizListDiv">
        <h2>Quiz results</h2>
        <table class="result_div">
            <tr>
                <td class="result_black_bold">Total questions</td>
                <td class="result_black_bold">Attempted questions</td>
                <td class="result_green_bold">No. of true questions</td>
                <td class="result_red_bold">No. of false questions</td>
            </tr>
            <tr>
                <td class="result_black_bold"><?php echo $total_questions; ?></td>
                <td class="result_black_bold"><?php echo $total_attempted_questions; ?></td>
                <td class="result_green_bold"><?php echo $total_true_questions; ?></td>
                <td class="result_red_bold"><?php echo $total_false_questions; ?></td>
            </tr>
        </table>
        </div>
    <?php
    }
    ?>