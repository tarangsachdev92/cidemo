<div class="main-content">
    <div class="grid-data info-content">
<!--        <div class="add-new">
            <a onclick="openlink('add')" style="text-align:center;width:100%;" title="<?php echo lang('banner_list');?>" href="#"><?php echo lang('banner_list');?></a>
        </div>-->

        <div class="profile-content-box" id="banner_form">            
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
                url: '<?php echo base_url().$this->_data['section_name']; ?>/banner/ajax_view/'+lang_code+'/<?php echo $id; ?>',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},            
                success: function(msg) {  
                    $("#banner_form").html(msg);                   
                }
            });
        }  
        openlink = function(type){        
            lang_code = $(".tab-headings li.selected a").attr('title');                        
            location.href= "<?php echo base_url().$this->_data['section_name']; ?>/banner/index/"+lang_code;
        };
    });
</script>