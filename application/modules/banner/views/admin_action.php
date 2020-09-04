
<div class="main-content">
    <div class="grid-data info-content">
        
<!--        <div class="add-new">
            <a onclick="openlink('add')" style="text-align:center;width:100%;" title="<?php echo lang('banner_list'); ?>" href="#"><?php echo lang('banner_list'); ?></a>            
        </div>-->

        
<!--        <div class="tab-nav">
            <ul class="tab-headings clearfix">
                <?php
                for ($i = 0; $i < count($languages); $i++)
                {
                    $selected = '';
                    if (($languages[$i]['l']['id']) == $language_id)
                    {
                        $selected = "selected";
                    }
                    ?><li class="<?php echo $selected; ?>"><a href="javascript:;" rel="#content_<?php echo ($languages[$i]['l']['language_code']); ?>" title="<?php echo $languages[$i]['l']['language_code']; ?>"><?php echo $languages[$i]['l']['language_name']; ?></a></li><?php
            }
                ?>
            </ul>
        </div>-->
        
        
        <div class="profile-content-box" id="banner_form">
            <!-- Form will come here -->
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
                url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_action/<?php echo $action; ?>/' + lang_code + '/<?php echo $id; ?>',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>', section_id: '<?php if (!empty($banner))
                {
                    echo $banner["section_id"];
                } ?>'},
                        success: function(msg) {
                            $("#banner_form").html(msg);
                        }
                    });
                }
                
        openlink = function(type) {
            lang_code = $(".tab-headings li.selected a").attr('title');
            location.href = "<?php echo base_url() . $this->_data['section_name']; ?>/banner/index/" + lang_code;
        }
     });

</script>