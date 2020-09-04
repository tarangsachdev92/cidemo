<?php
if (count($quizzes) > 0)
{
    ?>
    <div class="quizCategoryDiv" style="margin: 10px 0 0 38px">
            <span class="quizCategoryTitle">Category</span>
                <span class="quizSubjectTitle">Sub category</span>
                <span class="quizChapterTitle">Chapter</span>
            </div>
    <?php
    foreach ($quizzes as $key => $value)
    {
        ?>
        <div class="quizListDiv">
            <span class="quizTitle" onclick="start_quiz('<?php echo $value['qz']['quiz_id']; ?>')">
                <?php echo $value['qz']['quiz_title']; ?>
            </span>
            <span class="quizDescription">
                <?php echo $value['qz']['description']; ?>
            </span>
            <div class="quizCategoryDiv">
                <span class="quizCategoryTitle"><?php echo $value['qc']['category_title']; ?></span>
                <span class="quizSubjectTitle"><?php echo $value['qs']['subject_name']; ?></span>
                <span class="quizChapterTitle"><?php echo $value['qch']['chapter_name']; ?></span>
            </div>
        </div>
        <?php
    }
    ?>
        
    <?php
} else
{
    ?>
    <div class="quizListDiv">
        No record found.
    </div>
    <?php
}
?>