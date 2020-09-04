<div class="main-container">
    <div class="grid-data grid-data-table">
        
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

        openlink = function(type){
            lang_code = $(".tab-headings li.selected a").attr('title');
            location.href= "<?php echo base_url(); ?>products/action/add/"+lang_code;
        }

        load_ajax_index = function(lang_code) {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>products/ajax_index/' + lang_code,
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