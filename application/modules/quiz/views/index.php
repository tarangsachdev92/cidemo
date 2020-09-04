<style>
    .quizListDiv{
        background-color: #FFEFC6;
        border: 2px dotted #BBB25A;
        margin: 5px auto;
        padding: 5px;
        width: 900px;
    }
    .quizTitle{
        font-weight: bold;
        color: rgb(24,83,151);
        width: 100%;
        display: inline-block;
        cursor: pointer;
    }
    .quizCategoryDiv{
        margin: 5px 0px;
    }
    .quizCategoryTitle{
        background-color: rgb(19,71,130);
        margin: 0 5px;
        padding: 3px 5px;
        color: #fff;
    }
    .quizSubjectTitle{
        background-color: rgb(50,100,175);
        margin: 0 5px;
        padding: 3px 5px;
        color: #fff;
    }
    .quizChapterTitle{
        background-color: rgb(75,150,175);
        margin: 0 5px;
        padding: 3px 5px;
        color: #fff;
    }
    .quizDescription{
        margin: 5px 0px;
        width: 100%;
        color: #000;
    }
    .tab-headings{ width:100%; border-bottom:4px solid #1D5283; margin-bottom:20px;list-style-type: none;display: inline-block}
    .tab-headings li{ float:left; margin-right:3px; background:#f2f2f2; height:30px;}
    .tab-headings li.selected{ background:#1D5283;}
    .tab-headings li a{ font-size:13px; line-height:30px; color:#414141; padding:0 18px; display:block; font-weight:600;text-decoration: none;}
    .tab-headings li:hover{ background:#1D5283;}
    .tab-headings li:hover a{ text-decoration:none; color:#fff;}
    .tab-headings li.selected a{ color:#fff;}
    .question_title{
        font-size: 20px;
        margin: 5px 0;
    }
    .option_div {
        height: 200px;
    }
    .option_div span{
        width: 100%;
        display: inline-block;
        padding: 5px 0px;
    }
    .result_black_bold
    {
        font-size: 15px;
        font-weight: bold;
    }
    .result_green_bold
    {
        font-size: 15px;
        font-weight: bold;
        color: green;
    }
    .result_red_bold
    {
        font-size: 15px;
        font-weight: bold;
        color: red;
    }
    .result_div tr
    {
        background-color: #D1D3E5;
        text-align: center;
    }
</style>

<div class="container">
    <h2>Quizzes</h2>
    <div class="quizList">

    </div>
    
</div>
<script type="text/javascript">
    $(document).ready(function() {
        load_ajax_index = function(lang_code) {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>quiz/ajax_index/' + lang_code,
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
                success: function(data) {
                    if (data == '') {
                        $(".quizList").hide();
                    } else {
                        $(".quizList").html(data);
                        $(".quizList").show();
                    }
                }
            });
            unblockUI();
        }
        load_ajax_index('<?php echo $language_code; ?>');
    });
    function start_quiz(quiz_id)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>quiz/quiz_actions/<?php echo $language_id;?>/' + quiz_id,
            data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
            success: function(data) {
                if (data == '') {
                    $(".container").hide();
                } else {
                    $(".container").html(data);
                    $(".container").show();
                }
            }
        });
    }
    function check_answer()
    {
        if ($("input[name='answer']:checked").length <= 0)
        {
            alert("<?php echo lang('msg_select_atleast_one_option');?>");
        }
        else
        {
            var answer_id = $("input[name='answer']:checked").val();
            var question_id = $("#hdn_question_id").val();
            var quiz_id = $("#hdn_quiz_id").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>quiz/quiz_actions/<?php echo $language_id;?>/' + quiz_id + '/check_answer',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>', answer: answer_id, question: question_id},
                success: function(data) {
                    $(".option_div").html(data).fadeTo(1000);
                }
            });
        }

    }
    function next_question()
    {
        if ($("input[name='answer']:checked").length <= 0)
        {
            alert("<?php echo lang('msg_select_atleast_one_option');?>");
        }
        else
        {
            var answer_id = $("input[name='answer']:checked").val();
            var question_id = $("#hdn_question_id").val();
            var quiz_id = $("#hdn_quiz_id").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>quiz/quiz_actions/<?php echo $language_id;?>/' + quiz_id + '/next_question',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>', answer: answer_id, question: question_id},
                success: function(data) {
                    if (data == '') {
                        $(".container").hide();
                    } else {
                        $(".container").html(data);
                        $(".container").show();
                    }
                }
            });
        }
    }
</script><!--Accordion Jquery -->