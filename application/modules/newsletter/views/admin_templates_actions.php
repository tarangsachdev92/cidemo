<div id="one" class="grid-data">
<!--    <div class="tab-nav">
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
                    </li>
                <?php } ?>
            </ul>
        </div>-->
    <div class="menu-content-box" id="menu-content-box">
            <!-- Form will come here -->
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
            url: '<?php echo base_url().$this->_data['section_name']; ?>/newsletter/ajax_templates_actions/<?php echo $action; ?>/'+lang_code+'/<?php echo $id; ?>',
            data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
            success: function(data) {
                if (data === '') {
                    $(".menu-content-box").hide();
                } else {
                    $(".menu-content-box").html(data);
                    $(".menu-content-box").show();
                }
            }
        });
        unblockUI();
    };
    load_ajax_index('<?php echo $language_code; ?>');
});
</script>