<div class="main-container">
    <div id="moduleMiddle" class="grid-data">
        <div class="add-new">
            <?php echo anchor($this->_data['section_name'].'/quiz/questions', lang('view_all_questions'), 'title="'.lang('view_all_questions').'" style="text-align:center;width:100%;"'); ?>
        </div>
        <div class="tab-nav">
            <ul class="tab-headings clearfix">
                <?php
                for ($i = 0; $i < count($languages_list); $i++)
                {
                    $selected = '';
                    if (($languages_list[$i]['l']['id']) == $language_id)
                    {
                        $selected = "selected";
                    }
                    ?>
                    <li class="<?php echo $selected; ?>">
                        <a href="javascript:;"  rel="#content_<?php echo ($languages_list[$i]['l']['language_code']); ?>" title="<?php echo ($languages_list[$i]['l']['language_code']); ?>"><?php echo $languages_list[$i]['l']['language_name']; ?></a>
                    </li><?php
                }
                ?>
            </ul>
        </div>

        <?php
        $attributes = array('class' => '', 'id' => 'form', 'name' => 'form');
        echo form_open($this->_data['section_name'].'/quiz/question_action/' . $action . "/" . $language_code . "/" . $id, $attributes);
        ?>
        <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
            <tbody bgcolor="#fff">
                <!--<tr>
                    <th><?php echo lang(''); ?></th>
                </tr>-->
                <tr>
                    <td class="add-user-form-box">

                        <table cellspacing="1" cellpadding="5" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td align="right">
                                        <span class="star">*&nbsp;</span>
                                        <label for="title"><?php echo lang('question'); ?></label>:
                                    </td>

                                    <td>
                                        <?php
                                        $inputData = array(
                                            'name' => 'question',
                                            'id' => 'question',
                                            'value' => set_value('question', $details['question']),
                                            'style' => 'width:198px',
                                            'class' => "validate[required]",
                                            'cols' => "",
                                            'rows' => "3",
                                        );
                                        //echo form_input($inputData);
                                        echo form_textarea($inputData);
                                        ?>
                                        <br/><span class="warning-msg"><?php echo form_error('question'); ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="right">
                                        <span class="star">*&nbsp;</span>
                                        <label for="subject_id"><?php echo lang('subject_name'); ?></label>:
                                    </td>

                                    <td>
                                        <?php
                                        $options = array('' => 'Select');

                                        foreach ($subjects_list as $key => $val)
                                        {
                                            $options[$val['s']['subject_id']] = $val['s']['subject_name'];
                                        }

                                        echo form_dropdown('subject_id', $options, $details['subject_id'], 'id="subject_id" class="validate[required]" onchange="javascript:get_subject_chapters('.$language_id.', this.value, &apos;chapter_id&apos;)"') . '&nbsp;&nbsp;';
                                        ?>
                                        <br><span class="warning-msg"><?php echo form_error('subject_id'); ?></span>
                                    </td>

                                </tr>

                                <tr>
                                    <td align="right">
                                        <span class="star">*&nbsp;</span>
                                        <label for="chapter_id"><?php echo lang('chapter_name'); ?></label>:
                                    </td>

                                    <td>
                                        <?php
                                        $options = array('' => 'Select');

                                        echo form_dropdown('chapter_id', $options, $details['chapter_id'], 'id="chapter_id" class="validate[required]"') . '&nbsp;&nbsp;';
                                        ?>
                                        <br><span class="warning-msg"><?php echo form_error('chapter_id'); ?></span>
                                    </td>

                                </tr>

                                <tr>
                                    <td></td>
                                    <td colspan="7">
                                        <table>
                                            <tr>
                                                <td>
                                                    <b>Select correct answer</b>
                                                    <br/><span class="warning-msg"><?php echo form_error('is_correct_answer'); ?></span>
                                                </td>
                                                <td>
                                                    <b>Option</b>
                                                    <br/><span class="warning-msg"><?php echo form_error('option[]'); ?></span>
                                                </td>
                                            </tr>
                                            <?php
                                            if ($action == "add")
                                            {
                                                for ($i = 0; $i < 4; $i++)
                                                {
                                                    echo '<tr>';
                                                    echo '<td>';
                                                    if ($details['is_correct_answer'] != '' && $details['is_correct_answer'] == $i)
                                                    {
                                                        $chkd = TRUE;
                                                    }
                                                    else
                                                    {
                                                        $chkd = FALSE;
                                                    }
                                                    $inputData = array(
                                                        'name' => 'is_correct_answer',
                                                        'id' => 'opt_'.($i+1),
                                                        'value' => $i,
                                                        'checked' => $chkd,
                                                        'class' => "validate[required]",
                                                    );
                                                    echo form_radio($inputData);

                                                    echo '</td>';

                                                    echo '<td>';
                                                    if (!empty($details['option']))
                                                    {
                                                        $optn_val = $details['option'][$i];
                                                    }
                                                    else
                                                    {
                                                        $optn_val = "";
                                                    }
                                                    $inputData = array(
                                                        'name' => 'option[]',
                                                        'id' => 'option_'.($i+1),
                                                        'value' => set_value('option[]', $optn_val),
                                                        'style' => 'width:198px',
                                                        'class' => "validate[required]",
                                                    );
                                                    echo form_input($inputData);
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                            else if ($action == "edit")
                                            {
                                                for ($i = 0; $i < count($details['old_option']); $i++)
                                                {
                                                    echo '<tr>';
                                                    echo '<td>';
                                                    if ($details['is_correct_answer'] == $i)
                                                    {
                                                        $chkd = TRUE;//echo $details['is_correct_answer'].' correct '.$i;
                                                    }
                                                    else
                                                    {
                                                        $chkd = FALSE;//echo $details['is_correct_answer'].' not correct '.$i;
                                                    }
                                                    $inputData = array(
                                                        'name' => 'is_correct_answer',
                                                        'id' => 'opt_'.($i+1),
                                                        'value' => $i,
                                                        'checked' => $chkd,
                                                        'class' => "validate[required]",
                                                    );
                                                    echo form_radio($inputData);

                                                    echo '</td>';

                                                    echo '<td>';

                                                    $inputData = array(
                                                        'name' => 'option[]',
                                                        'id' => 'option_' . ($i + 1),
                                                        'value' => set_value('option[]', $details['option'][$i]),
                                                        'style' => 'width:198px',
                                                        'class' => "validate[required]",
                                                    );
                                                    echo form_input($inputData);

                                                    echo form_hidden('old_option[]', $details['old_option'][$i]);
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                            ?>

                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="right"><label for="status">Status</label>:</td>
                                    <td>
                                        <?php
                                        $statuslist = array('1' => lang('active'), '0' => lang('inactive'));
                                        echo form_dropdown('status', $statuslist, $details['status'], '');
                                        ?>
                                    </td>
                                </tr>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>
        <div class="submit-btns clearfix">
            <input type="hidden" id="lang_id" name="lang_id" value ="<?php echo (isset($lang_id)) ? $lang_id : '1'; ?>" />
            <input type="hidden" id="language_name" name="language_name" value ="<?php echo (isset($language_name)) ? strtolower($language_name) : 'en'; ?>" />
            <!--<input type="hidden" id="id" name="id" value ="<?php echo (isset($id)) ? $id : '0'; ?>" />-->
            <?php
            $submit_button = array(
                'name' => 'save',
                'id' => 'save',
                'value' => lang('btn_save_question'),
                'title' => 'Save',
                'class' => 'inputbutton',
            );
            echo form_submit($submit_button);

            $langname = (isset($language_name)) ? strtolower($language_name) : 'en';
            $siteurl = base_url($this->_data['section_name'].'/quiz/questions') . '/' . $language_code;

            $cancel_button = array(
                'name' => 'button',
                'title' => lang('btn_cancel'),
                'class' => 'inputbutton',
                'onclick' => "location.href='" . $siteurl . "'"
            );
            echo "&nbsp;";
            echo form_button($cancel_button, lang('btn_cancel'));
            ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        jQuery("#form").validationEngine();
        <?php
        if($details['subject_id'] != '')
        {
        ?>
            get_subject_chapters(<?php echo $language_id; ?>, <?php echo $details['subject_id'];?>, 'chapter_id');
        <?php
        }
        ?>
    });


    $(document).ready(function(){
        $(".tab-headings li a").click(function(){
            var thisId = $(this).attr("rel");
            $(".tab-headings li").removeClass("selected");
            $(this).parent('li').addClass("selected");
            $(".profile-content").hide();
            $(".add-comment-box").hide();
            var lang_code = thisId.replace("#content_", "");
            window.location = '<?php echo base_url().$this->_data['section_name']; ?>/quiz/question_action/<?php echo $action; ?>/' + lang_code + '/<?php echo $id; ?>';
        });
    });

    function get_subject_chapters(language_id, subject_id, obj_id_chapters)
    {
        <?php
        if($details['chapter_id'] != '')
        {
        ?>
            var chapter_id = <?php echo $details['chapter_id'];?>;
        <?php
        }
        else
        {
        ?>
            var chapter_id = -1;
        <?php
        }
        ?>

        if(subject_id != "")
        {
            $.ajax
            ({
                type: "POST",
                url: "<?php echo base_url().$this->_data['section_name']; ?>/quiz/select_chapters_from_subjects",
                data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>',"subject_id":subject_id,"language_id":language_id,"select_chapters_from_subjects":"select_chapters_from_subjects","return_data_mode":"json"},
                success: function(data)
                {
                    var response = jQuery.parseJSON(data);
                    //alert(response.has_records);
                    var new_options = '<option value="">--Select--</option>';
                    if(response.has_records == 'TRUE')//if data exists
                    {
                        //alert('in success');
                        for(var i=0; i<response.result_data.length; i++)
                        {
                            //alert('in loop');
                            //alert(response.result_data[i]['ch'].chapter_id +' '+ response.result_data[i]['ch'].chapter_name);
                            if(response.result_data[i]['ch'].chapter_id == chapter_id)
                            {
                                new_options+='<option value="'+response.result_data[i]['ch'].chapter_id+'" selected>'+response.result_data[i]['ch'].chapter_name+'</option>';
                            }
                            else
                            {
                                new_options+='<option value="'+response.result_data[i]['ch'].chapter_id+'">'+response.result_data[i]['ch'].chapter_name+'</option>';
                            }
                        }
                        $("#"+obj_id_chapters).html(new_options);
                    }
                    else
                    {
                        $("#"+obj_id_chapters).html(new_options);
                    }
                    //alert('new_options= '+new_options);
                }
            });
        }
        else
        {
            var new_options = '<option value="">--Select--</option>';
            $("#"+obj_id_chapters).html(new_options);
        }
    }

</script>