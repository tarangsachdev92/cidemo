<?php echo add_css('validationEngine.jquery'); ?>
<?php echo add_js(array('jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<?php echo add_css(array('front_calendar'), 'calendar', 'modules'); ?>
<?php echo add_css(array('jquery-ui', 'front_calendar'), 'calendar', 'modules'); ?>
<?php echo add_js(array('jquery-ui'), 'calendar', 'modules'); ?>
<div class="main-container">
    <div class="grid-data grid-data-table">
        <?php if ($type == "private")
        { ?>
            <div class="add-new">
                <a href='javascript:;'  onclick="add_event()" title="<?php echo lang('add_events'); ?>" ><?php echo lang('add_events'); ?></a>
            </div>
<?php } ?>
        <div class="menu-content-box">          
        </div>
    </div>
</div>
<script type="text/javascript">
<?php
$search_type_cont = $this->_ci->session->userdata("search_type");
$search_term = $this->_ci->session->userdata("search_term");
$date_from = $this->_ci->session->userdata("date_from");
$date_to = $this->_ci->session->userdata("date_to");
?>
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
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>calendar/event_list/' + lang_code + '/<?php echo $type; ?>/1',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>',search_type:'<?php echo isset($search_type_cont) ? $search_type_cont : 'select' ?>',search_term:'<?php echo isset($search_term) ? $search_term : '' ?>',date_from:'<?php echo isset($date_from) ? $date_from : ''; ?>',date_to:'<?php echo isset($date_to) ? $date_to : ''; ?>'},
                success: function(data) {
                    if (data == '')
                    {
                        $(".menu-content-box").hide();
                    } else
                    {
                        $(".menu-content-box").html(data);
                        $(".menu-content-box").show();
                    }
                }
            });
        }
        load_ajax_index('<?php echo $language_code; ?>');
    });
</script>


