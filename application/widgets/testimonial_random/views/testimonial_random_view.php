<?php echo add_css(array('front_testimonial'),'testimonial','modules'); ?>
<script src="js/modules/testimonial/jquery.cycle.all.js" type="text/javascript"></script> 
<?php
function limit_words1($string, $word_limit,$line_limit) {
//    $words = explode(" ", $string);
//    return implode(" ", array_splice($words, 0, $word_limit));
    $words = explode(" ", $string);
    $limit_w=implode(" ", array_splice($words, 0, $word_limit));
    $lines = explode("\n",$limit_w);
   return implode("\n", array_splice($lines, 0, $line_limit));
}   
echo form_open();
?>
<div id='slider'>
   <?php
           foreach($records_rand as $record_r)
           {
                   ?><div id='slidercontent'>
                       <div id="sliderinner">
                       <div id ='img'>
                           <?php
                            if (!empty($record_r['R']['logo']) && file_exists(FCPATH.$record_r['R']['logo']))
                                {                                            
                                    $logo_image  = $record_r['R']['logo'];
                            ?>                                                                                     
                            <img src="<?php echo base_url(); ?><?php echo $logo_image; ?>" height ="50px"/>                                               
                           <?php }  
                                else
                                {
                                ?>                                               
                            <?php
                                    $logo = 'logo.jpg';  
                                      $styles = array(
                                         'width' => 100,
                                          'height' =>100,
                                       );
                                    echo add_image(array($logo),'testimonial','modules',$styles);                               
                                }
                                ?>
                       </div>
                           <div id='title' style="margin-top: 10px;" >
                           <div class="title_font" style="text-align: center"><a href="<?php echo base_url(); ?>testimonial/testimonial_detail/<?php echo $record_r['R']['testimonial_slug'];?>/<?php echo $language_code; ?>"><?php echo $record_r['R']['testimonial_name']; ?></a></div>
                           <br/> by <span class="title_font"><?php echo $record_r['U']['firstname']." ".$record_r['U']['lastname']; ?></span> in <span class="title_font"><?php echo $record_r['C']['title']; ?></span>
                           <br/><span class="description" style="padding-right: 10px;"> <?php echo limit_words1($record_r['R']['testimonial_description'],20,4);?></span><a href="<?php echo base_url(); ?>testimonial/testimonial_detail/<?php echo $record_r['R']['testimonial_slug'];?>/<?php echo $language_code; ?>" style="color: #000; text-decoration: underline;"><b><?php echo lang('read_more');?></b></a>
                           <br/>Posted On: <?php echo $record_r['R']['created_on']; ?>
                        </div> 
                           </div>
                   </div><?php       
           }
       ?>
</div>
   <?php
   if(isset($total_records) && $total_records>1)
   {
?>
   <div style="clear: left;">
       <a id="prev2" href="#"><img src='<?php echo base_url(); ?>themes/front/images/modules/testimonial/prev.png' alt="prev" width='20px' height="20px"/></a>
        <a id="next2" href="#"><img src='<?php echo base_url(); ?>themes/front/images/modules/testimonial/next.png' alt="next" width='20px' height="20px"/></a>
   </div>
    <?php
   }
?> 
 <?php echo form_close(); ?>

<script class="secret-source">
        jQuery(document).ready(function($) {
          $('#slider').cycle({
                fx:     'scrollHorz',
                speed:  'slow',
                timeout: 3000,
//                pager:  '#nav',
                next:   '#next2', 
                prev:   '#prev2',
                rev: true 
            });
        });
</script>