<div id="one" class="grid-data">
    <div class="menu-content-box" id="menu-content-box">
        <div class="add-new">
            <?php echo anchor($this->_data['section_name'].'/quiz/quizzes', lang('view_all_quizzes'), 'title="' . lang('view_all_quizzes') . '" style="text-align:center;width:100%;"'); ?>
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
        echo form_open($this->_data['section_name'].'/quiz/quizzes_action/' . $action . "/" . $language_code . "/" . $id, $attributes);
        ?>
        <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
            <tbody bgcolor="#fff">
                <tr>
                    <td class="add-user-form-box">

                        <table cellspacing="1" cellpadding="5" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td align="right">
                                        <span class="star">*&nbsp;</span>
                                        <label for="subject_name"><?php echo lang('quiz_title'); ?></label>:
                                    </td>

                                    <td>
                                        <?php
                                        $inputData = array(
                                            'name' => 'quiz_title',
                                            'id' => 'quiz_title',
                                            'value' => set_value('quiz_title', $details['quiz_title']),
                                            'maxlength' => '1000',
                                            'style' => 'width:198px',
                                            'class' => "validate[required,maxSize[1000]]"
                                        );
                                        echo form_input($inputData);
                                        ?>
                                        <br/><span class="warning-msg"><?php echo form_error('quiz_title'); ?></span>
                                    </td>
                                </tr>


                                <tr>
                                    <td align="right">
                                        <label for="subject_name"><?php echo lang('quiz_description'); ?></label>:
                                    </td>

                                    <td>
                                        <?php
                                        $inputData = array(
                                            'name' => 'description',
                                            'id' => 'description',
                                            'value' => set_value('description', $details['description']),
                                            'rows' => '5',
                                            'style' => 'width:198px',
                                                //'class' => "validate[required]"
                                        );
                                        echo form_textarea($inputData);
                                        ?>
                                        <br/><span class="warning-msg"><?php echo form_error('description'); ?></span>
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

                                <tr>
                                    <td align="right">
                                        <span class="star">*&nbsp;</span>
                                        <label for="category_id"><?php echo lang('quiz_categories'); ?></label>:
                                    </td>

                                    <td>
                                        <?php
                                        $options = array('' => 'Select');
                                        foreach ($categories_list as $key => $val)
                                        {
                                            $options[$val['c']['category_id']] = $val['c']['title'];
                                        }
                                        if (!empty($details['categories']))
                                        {

                                            foreach ($details['categories'] as $key1 => $val1)
                                            {
                                                $categories[$val1['category_id']] = $val1['category_id'];
                                            }
                                        }
                                        echo form_multiselect('categories[]', $options, $categories, 'id="categories" class="validate[required]"') . '&nbsp;&nbsp;';

                                        $button = array(
                                            'name' => 'show_questions',
                                            'id' => 'show_questions',
                                            'title' => lang('btn_show_questions'),
                                            'class' => 'inputbutton',
                                            'onclick' => "javascript:generate_questions()"
                                        );
                                        echo "&nbsp;";
                                        echo form_button($button, lang('btn_show_questions'));
                                        ?>

                                        <br><span class="warning-msg"><?php echo form_error('categories'); ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td colspan="7">
                                        <div id="question_list">

                                        </div>
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
                'value' => lang('btn_save_subject'),
                'title' => 'Save',
                'class' => 'inputbutton',
            );
            echo form_submit($submit_button);

            $langname = (isset($language_name)) ? strtolower($language_name) : 'en';
            $siteurl = base_url($this->_data['section_name'].'/quiz/quizzes') . '/' . $language_code;

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
    $(document).ready(function() {
        jQuery("#form").validationEngine();
    });

    $(document).ready(function() {
        $(".tab-headings li a").click(function(){
            var thisId = $(this).attr("rel");
            $(".tab-headings li").removeClass("selected");
            $(this).parent('li').addClass("selected");
            $(".profile-content").hide();
            $(".add-comment-box").hide();
            var lang_code = thisId.replace("#content_", "");
            window.location = '<?php echo base_url().$this->_data['section_name']; ?>/quiz/quizzes_action/<?php echo $action; ?>/' + lang_code + '/<?php echo $id; ?>';
        });
    });

    function generate_questions()
    {
        var category_id = encodeURIComponent($('select#categories').val());
       

        if (category_id != "")
        {
            var page = "select_questions_from_categories/<?php echo $language_id; ?>/" + category_id + "/json";
            $.ajax
            ({
                type: "POST",
                url: "<?php echo base_url().$this->_data['section_name']; ?>/quiz/" + page,
                data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>'},
                success: function(data)
                {
                    $("#question_list").html(data);
                }
            });
        }
        else
        {
            var new_options = '<option value="">--Select--</option>';
            $("#" + obj_id_chapters).html(new_options);
        }
    }
    <?php
    if (!empty($categories))
    {
    ?>
        generate_selected_questions();
        function generate_selected_questions()
        {
            var page = "select_quizzes_questions_from_categories/<?php echo $language_id; ?>/<?php echo $id; ?>";
            $.ajax
            ({
                type: "POST",
                url: "<?php echo base_url().$this->_data['section_name']; ?>/quiz/" + page,
                data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>'},
                success: function(data)
                {
                    $("#question_list").html(data);
                    $(".check_box").prop("checked", true);
                    $("#check_all").prop("checked", true);
                }
            });
        }
    <?php
    }
    ?>

</script>