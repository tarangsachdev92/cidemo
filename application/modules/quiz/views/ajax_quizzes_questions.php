<?php
if (!empty($questions))
        {
            ?>
            <div class="grid-data grid-data-table">
                <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
                    <tbody bgcolor="#fff">
                        <tr>
                            <th width="30px"><input type="checkbox" name="check_all" id="check_all" value="0"></th>
                            <th width="30px"><?php echo lang('no') ?></th>
                            <th><?php echo lang('questions'); ?></th>
                            <th><?php echo lang('chapter'); ?></th>
                            <th><?php echo lang('subject'); ?></th>
                            <th><?php echo lang('category'); ?></th>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($questions as $question)
                        {
                            
                            if ($i % 2 != 0)
                            {
                                $class = "odd-row";
                            }
                            else
                            {
                                $class = "even-row";
                            }
                            ?>
                            <tr class="<?php echo $class; ?> rows" >
                                <td><input type="checkbox" id="<?php echo $question['question_id']; ?>" name="questions_array[]" class="check_box" value="<?php echo $question['question_id']; ?>"></td>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $question['question']; ?></td>
                                <td><?php echo $question['chapter_name']; ?></td>
                                <td><?php echo $question['subject_name']; ?></td>
                                <td><?php echo $question['category_title']; ?></td>
                            </tr>
                            <?php
                            $i++;
                        }?>
                            
                            <?php
                        echo form_hidden('search_text', (isset($search_text)) ? $search_text : '' );
                        echo form_hidden('page_number', "", "page_number");
                        echo form_hidden('per_page_result', "", "per_page_result");
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        else
        {
            ?>
            <table>
                <tr>
                    <td><?php echo lang('no-records') ?></td>
                </tr>
            </table>
            <?php
        }
?>
<script>
    $(document).ready(function(){
        $("#check_all").click(function () {
            if ($("#check_all").is(':checked')) {
                $(".check_box").prop("checked", true);
            } else {
                $(".check_box").prop("checked", false);
            }
        });
    });
</script>