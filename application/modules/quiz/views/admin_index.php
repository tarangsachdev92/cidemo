<div class="main-container">
    <div class="grid-data grid-data-table">
        <div class="add-new">
            <span style="float: left;"><?php echo add_image(array('active.png')) . " " . lang('active') . "  " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>
            <?php echo anchor($this->_data['section_name']."/quiz/categories", lang('manage_categories')); ?> |
            <?php echo anchor($this->_data['section_name']."/quiz/subjects", lang('manage_subjects')); ?> |
            <?php echo anchor($this->_data['section_name']."/quiz/chapters", lang('manage_chapters')); ?> |
            <?php echo anchor($this->_data['section_name']."/quiz/questions", lang('manage_questions')); ?> |
            <?php echo anchor($this->_data['section_name']."/quiz/quizzes", lang('manage_quizzes')); ?>
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
        <div class="menu-content-box" id="menu-content-box">
            <!-- load your ajax content here -->
        </div>
    </div>
    
    
</div>

<script>
    $(document).ready(function() {
        $(".tab-headings li a").click(function()
        {
            var thisId = $(this).attr("rel");
            $(".tab-headings li").removeClass("selected");
            $(this).parent('li').addClass("selected");
            $(".profile-content").hide();
            $(".add-comment-box").hide();
            var lang_code = thisId.replace("#content_", "");
            load_ajax_index(lang_code);
        });

        load_ajax_index = function(lang_code) {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/quiz/admin_ajax_index/' + lang_code,
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
                success: function(data) {
                    if (data == '') {
                        $(".menu-content-box").hide();
                    } else {
                        $(".menu-content-box").html(data);
                        $(".menu-content-box").show();
                    }
                }
            });
            unblockUI();
        }
        load_ajax_index('<?php echo $language_code; ?>');
    });
</script>