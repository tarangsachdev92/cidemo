
<?php

    if(!empty ($results))
    {

    $r = $results[0]['a'];
    
    if ($r['banner_type'] == AD_IMAGE)
    {
        echo '<a href="'.$r['link'].'" target="_blank"><img id="ad_'.$r['ad_id'].'" src="'.base_url().'assets/uploads/banner_ad_images/main/'.$r['image_url'].'"  onclick=add_visitor(this.id)></a>';
    }
    else
    {
        ?>
<div class="emb_code" id="<?php echo 'ad_'.$r['ad_id'];?>">
<?php        echo html_entity_decode($r['embedded_code']) ;?>
        </div>
   
 <?php   }
    }
?>
    
<script>
    
function add_visitor(id)
{
     var id1=id.split("_");
    var id=id1[1];
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>/banner/add_visitor',
//        data:{<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>:'<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',ip:$_SERVER['REMOTE_ADDR'],id:id},
        data:{<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>:'<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',id:id},
        success:function(data){
        }

    });
}
$(document).ready(function(){
        $('.emb_code').click(function(){
           add_visitor(this.id);
        });
    });
</script>

