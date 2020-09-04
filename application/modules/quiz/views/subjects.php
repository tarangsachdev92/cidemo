<div class="main-container">
    <?php
    if($msg_no_subject_records != '')
    {
        echo $msg_no_subject_records;
        echo "<br>".anchor(base_url().$this->_data['section_name']."/quiz/subject_action/add", lang('add_new_subject'));
    }
    else
    {
    ?>
    <div class="grid-data grid-data-table">
        <div class="add-new">
            <span style="float: left;"><?php echo add_image(array('active.png'))."  Active ".add_image(array('inactive.png'))." Inactive";?></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo anchor(base_url().$this->_data['section_name']."/quiz/subject_action/add/".$language_code, lang('add_new_subject')); ?>
        </div>
        <div class="tab-nav">
            <ul class="tab-headings clearfix">
                <?php
                for ($i = 0; $i < count($languages_list); $i++) {
                    $selected = '';
                    if (($languages_list[$i]['l']['id']) == $language_id) {
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
        <div class="menu-content-box">
            <!-- load your ajax content here -->
        </div>

    </div>
    <?php
    }
    ?>
</div>
<script type="text/javascript">

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


        delete_record = function(id)
        {
            res = confirm('<?php echo lang('msg_confirm_delete_subject') ?>');

            if(res)
            {
                blockUI();
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url().$this->_data['section_name']; ?>/quiz/delete_subject',
                    data:{<?php echo $csrf_token; ?>:'<?php echo $csrf_hash; ?>',id:id},
                    success: function(response) {
                        unblockUI();
                        // show success message
                        alert('<?php echo lang('msg_success_delete_subject') ?>');
                        var response = jQuery.parseJSON(response);

                        if(response.no_records == "TRUE")
                        {
                            window.location.href = '<?php echo base_url().$this->_data['section_name']; ?>/quiz/subjects';
                        }
                        else
                        {
                            lang_code = $(".tab-headings li.selected a").attr('title');
                            load_ajax_index(lang_code);
                        }
                    }
                });

            }
            else
            {
                return false;
            }
        }

        load_ajax_index = function(lang_code) {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/quiz/ajax_subjects_list/' + lang_code,
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
</script><!--Accordion Jquery -->