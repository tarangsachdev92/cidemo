<?php echo add_js(array('jquery-1.9.1.min', 'jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<div class="main-content">
    <div class="grid-data info-content">
        <div class="add-new">
            <?php echo anchor(site_url() . 'products', lang('Product_list'), 'title="'.lang('Product_list').'" style="text-align:center;width:100%;"'); ?>
        </div>
        
        <div class="profile-content-box" id="form">            
            <?php echo $content; ?>
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
            load_form(lang_code);
        });
        load_form = function(lang_code) {            
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>products/ajax_view/'+lang_code+'/<?php echo $id; ?>',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},            
                success: function(msg) {                        
                    $("#form").html(msg);                   
                }
            });
        }        
    });
</script>