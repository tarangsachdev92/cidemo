<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="js/modules/banner/jquery.cycle.all.js" type="text/javascript"></script>
<link href="css/modules/banner/banner.css" rel="stylesheet" type="text/css">
<tr class="content">
    <td>
        <div id='banner'>
        <?php
            if(isset($total_records) && $total_records>1)
            {
        ?>
            <a id="prev2" href="#"><img src='<?php echo base_url(); ?>themes/front/images/banner/prev.png' alt="prev" width='20px' height="20px"/></a><div id="nav"></div><a id="next2" href="#"><img src='<?php echo base_url(); ?>themes/front/images/banner/next.png' alt="next" width='20px' height="20px"/></a>
        <?php
            }
        ?>
        <div id='slider'>
        <?php
                    foreach($banner_list as $banner)
                    {
                        if(isset($banner['ad']['image_url']) && $banner['ad']['image_url'] != '')
                        {
                            ?><div id='slidercontent'>
                                <div id ='img'><a href='<?php  echo  (isset($banner['ad']['link']) && $banner['ad']['link']!='') ? $banner['ad']['link'] : ""; ?>' ><img src="<?php echo base_url().'assets/uploads/banner_ad_images/main/'.$banner['ad']['image_url']; ?>" alt="Banner image" width="<?php echo HOME_BANNER_WIDTH ?>" height='<?php echo HOME_BANNER_HEIGHT ?>' /></a></div>
                                <div id ='title'>
                                    <h3><?php echo $banner['ad']['title']; ?></h3>
                                    <p><?php echo $banner['ad']['description']; ?></p>
                                </div>
                            </div><?php
                        }
                    }
                ?>                                
        </div>                    
        </div>
        <div class="ad_top"> <?php
                    $array=array('language_id'=>$language_id,
                                 'page_id'=>$page_id,
                                  'position'=>TOP );
                    widget('advertisement',$array);
                    ?></div>
         <div class="ad_bottom"> <?php
                    $array=array('language_id'=>$language_id,
                                 'page_id'=>$page_id,
                                  'position'=>BOTTOM);
                    widget('advertisement',$array);
                    ?></div>
         <div class="ad_left"> <?php
                    $array=array('language_id'=>$language_id,
                                 'page_id'=>$page_id,
                                  'position'=>LEFT);
                    widget('advertisement',$array);
                    ?></div>
    </td>
</tr>
<script class="secret-source">
     jQuery(document).ready(function($) {          
          $('#slider').cycle({
                fx:     'fade,scrollLeft',
                speed:  'slow',
                timeout: <?php echo TIMEOUT; ?> * 1000,
                pager:  '#nav',
                next:   '#next2', 
                prev:   '#prev2'
            });
        });
</script>

