<?php echo add_js(array('jquery-ui')); ?>
<?php echo add_css('jquery-ui'); ?>
<div class="main-container">
    <div class="grid-data grid-data-table">
        <div class="tab-nav">
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
        </div>
        <div class="menu-content-box">
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
 
        load_ajax_index = function(lang_code) {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/banner/visitor_ajax_index/' + lang_code,
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
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