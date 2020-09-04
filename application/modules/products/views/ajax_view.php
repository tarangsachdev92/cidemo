
<?php echo add_js(array('jquery.fancybox'), 'products', 'modules'); ?>
<?php echo add_css(array('jquery.fancybox'), 'products', 'modules'); ?>
<style>
    a{text-decoration: none}
</style>
<script>
    $(".fancybox").fancybox({
    minWidth:450,
    minHeight:450
});
   function change_image(image_id)
   {
       $('#main_image').find('img').attr('src','<?php echo base_url() . "assets/uploads/products/main/";?>'+image_id);
   }

   
</script>



<div id="one" class="grid-data">
    <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
        <tbody bgcolor="#fff">
            <tr>
                <td colspan="2" align="center" bgcolor="#c0c0c0"><?php echo lang('view_product'); ?> - <?php echo $language_name; ?></td>
            </tr>
            <tr>
               <td class="add-user-form-box">
                    <table cellpadding="3" cellspacing="3" border="0">
                        <tr>
                            
                            <td colspan="<?php echo count($result_images);?>">
                                <?php
                                           $product_image  = 'no_image.jpg';
                                            if($result[0]['products']['product_image']!='') {
                                                if(file_exists(FCPATH.'assets/uploads/products/thumbs/'.$result[0]['products']['product_image'])) {
                                                    $product_image  = $result[0]['products']['product_image'];
                                                }
                                            }
                                        ?>
                                <div id="main_image">
                         <a class="fancybox" href="<?php  echo base_url() . "assets/uploads/products/main/".$product_image; ?>" data-fancybox-group="gallery">
                             <img src="<?php  echo base_url() . "assets/uploads/products/main/".$product_image; ?>" border="0" height="220" width="165" >
                             </a>
                             </div>
                            </td>
                        </tr>
                        <tr>
                            
 
                            <td>
                                <div>
                           
                           
                            <?php
                            foreach($result_images as $image)
                            {?>

                            <a  class="fancybox" href="<?php  echo base_url() . "assets/uploads/products/main/".$image['pi']['product_image']; ?>" data-fancybox-group="gallery">
                                <img  id="<?php echo 'thumb_image'.$image['pi']['id'];?>" src="<?php  echo base_url() . "assets/uploads/products/thumbs/".$image['pi']['product_image']; ?>" border="0" height="44" width="33" onmouseover="change_image('<?php echo $image['pi']['product_image'];?>')"  >
                            </a>
                               <?php }?>
 
                                </div>

                            </td>
                            
                        </tr>
                    </table>
                </td>
                <td class="add-user-form-box">                    
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="100%" valign="top">
                                <?php
                             //   var_dump($result);
                                if(count($result) > 0)
                                {
                                ?>
                                <table width="100%" cellpadding="5" cellspacing="1" border="0">
                                    <tr>
                                        <td width="300" align="right"><?php echo lang('name'); ?>:</td>
                                        <td>
                                            <?php
                                            if(isset($result[0]['products']['name'])) 
                                                echo $result[0]['products']['name'];
                                            ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right" valign="top"><?php echo lang('description'); ?>:</td>
                                        <td>
                                            <?php
                                            if(isset($result[0]['products']['description'])) 
                                                echo $result[0]['products']['description'];
                                            ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right" valign="top"><?php echo lang('price'); ?>:</td>
                                        <td>
                                            <?php
                                            if(isset($result[0]['products']['price'])) 
                                                echo $result[0]['products']['price'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><?php echo lang('product_image'); ?>:</td>
                                        <td>
                                            
                                        <?php 
                                            $product_image  = 'no_image.jpg';
                                            if($result[0]['products']['product_image']!='') {
                                                if(file_exists(FCPATH.'assets/uploads/products/thumbs/'.$result[0]['products']['product_image'])) { 
                                                    $product_image  = $result[0]['products']['product_image'];
                                                }
                                            }
                                        ?>
                                          <img src="<?php  echo base_url() . "assets/uploads/products/thumbs/".$product_image; ?>" border="0" >
                                                   
                                        </td>
                                    </tr>
                                    
                                    
                                </table> 
                                <?php
                                }
                                else
                                {
                                ?>
                                <table>
                                    <tr>
                                        <td align="right"><?php echo lang('no-product-translation');?></td>
                                    </tr>
                                </table>
                                <?
                                }
                                ?>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>    
</div>