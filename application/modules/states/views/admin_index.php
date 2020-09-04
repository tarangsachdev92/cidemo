<div class="main-container">
    <div class="grid-data grid-data-table">
        <div class="add-new">
            <span style="float: left;">
                <?php echo add_image(array('active.png')) . "  Active " . add_image(array('inactive.png')) . " Inactive"; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <a onclick="openlink('add')" style="text-align:center;width:100%;" title="<?php echo lang('add_state'); ?>" href="#"><?php echo lang('add_state'); ?></a>
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
            <div class="menu-content-box">
                <!-- load your ajax content here -->
            </div>

        </div>
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

        openlink = function(type) {
            lang_code = $(".tab-headings li.selected a").attr('title');
            location.href = "<?php echo base_url() . $this->_data['section_name']; ?>/states/action/add/" + lang_code;
        }

        delete_state = function(id, name)
        {
            res = confirm('<?php echo lang('delete_confirm') ?>');
            if (res) {
                blockUI();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/states/delete',
                    data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>', id: id, name: name},
                    success: function(data) {
                        lang_code = $(".tab-headings li.selected a").attr('title');
                        load_ajax_index(lang_code);
                        // show success message
                        unblockUI();
                        $("#messages").show();
                        $("#messages").html(data);
                    }
                });
            } else {
                return false;
            }
        }

        load_ajax_index = function(lang_code) {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $this->_data['section_name']; ?>/states/ajax_index/' + lang_code,
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>', lang_code: '<?php echo $lang_code; ?>'},
                success: function(data) {
                    if (data == '') {
                        $(".menu-content-box").hide();
                    } else {
                        $(".menu-content-box").html(data);
                        $(".menu-content-box").show();
                    }
                    unblockUI();
                }
            });

        }
        load_ajax_index('<?php echo $language_code; ?>');
    });
</script><!--Accordion Jquery -->