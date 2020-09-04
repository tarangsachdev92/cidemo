<div class="main-content">
    <div class="grid-data info-content">
        <div class="add-new">
              <a onclick="openlink('add')" style="text-align:center;width:100%;" title="<?php echo lang('event_list');?>" href="#"><?php echo lang('event_list');?></a>
        </div>
        <div class="tab-nav">
            <ul class="tab-headings clearfix">
                <?php
                for ($i = 0; $i < count($languages); $i++) {
                    $selected = '';
                    if (($languages[$i]['l']['id']) == $language_id) {
                        $selected = "selected";
                    }
                    ?><li class="<?php echo $selected; ?>"><a href="javascript:;" rel="#content_<?php echo ($languages[$i]['l']['language_code']); ?>" title="<?php echo $languages[$i]['l']['language_code'];?>"><?php echo $languages[$i]['l']['language_name']; ?></a></li><?php
                }
                ?>
            </ul>
        </div>
       <div class="profile-content-box" id="cal_form">
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
        <?php if(isset($cal['event_id']))
        {   
         ?>
        load_form = function(lang_code) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?><?php echo $this->_data['section_name']; ?>/calendar/open_form/<?php echo $action; ?>/<?php echo $type; ?>/'+lang_code+'/<?php echo $cal['event_id']; ?>',
            data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>',start_date:'<?php echo $cal['start_date']; ?>',end_date:'<?php echo $cal['end_date']; ?>',start_time:'<?php echo $cal['start_time']; ?>',end_time:'<?php echo $cal['end_time']; ?>'},

            success: function(msg) {                        
                $("#cal_form").html(msg);                   
            }
        });
        }
         openlink = function(type){        
            lang_code = $(".tab-headings li.selected a").attr('title');                        
             location.href= "<?php echo base_url().$this->_data['section_name']; ?>/calendar/event_list/"+lang_code;
        }
        <?php }
        else{?>
            load_form = function(lang_code) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?><?php echo $this->_data['section_name']; ?>/calendar/open_form/<?php echo $action; ?>/<?php echo $type; ?>/'+lang_code,
            data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>',start_date:'<?php echo $cal['start_date']; ?>',end_date:'<?php echo $cal['end_date']; ?>',start_time:'<?php echo $cal['start_time']; ?>',end_time:'<?php echo $cal['end_time']; ?>'},

            success: function(msg) {                        
                $("#cal_form").html(msg);                   
            }
        });
        }
         openlink = function(type){        
            lang_code = $(".tab-headings li.selected a").attr('title');                        
            location.href= "<?php echo base_url().$this->_data['section_name']; ?>/calendar/event_list/"+lang_code;
        }
        <?php } ?>
       
    });   
</script><!--Accordion Jquery -->