<table align="center" border="0" cellpadding="0" cellspacing="0" width="850" style="font-family: Arial, Helvetica, sans-serif;  color: #525252;  font-size: 15px;  line-height: 22px;">  
    <tr>
        <td valign="top" style="border: 5px solid #000000;  padding: 20px 28px;  background-color: #ffff;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">           
                <tr>
                    <td colspan="2" >
                    <b>Hello <?php echo $result['firstname'] ?>,  &nbsp;<?php echo lang('congratulations'); ?></b><br>
                    </td>
                </tr>                           
                <tr>    
                    <td><?php echo lang('testimonial-publish-message') ?></td>
                </tr>
                <tr>
                    <td valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <?php                                                                                                                                                                                                                         
                            if (!empty($result['logo']) && file_exists(FCPATH.$result['logo']))
                            {                                            
                                  $logo_image  = $records['logo'];

                                ?>                                      
                                <td>
                                    <img src="<?php echo base_url(); ?><?php echo $logo_image; ?>" height ="50px"/>
                                </td>
                      <?php } 
                            else
                                {
                                ?>
                                <td>
                                    <?php
                                       $logo = 'logo.jpg';   
                                      echo add_image(array($logo),'testimonial','modules'); 
                                      ?>
                                </td>
                                <?php
                                }
                                ?>
                        </tr>  
                        <tr>
                            <td>
                            <table>
                                <tr>
                                    <td><?php echo lang('testimonial_name'); ?>: </td><td><?php if(isset($result)){ echo $result['testimonial_name'];} else{ echo $testimonial_name; }?></td> 
                                </tr>
                                <tr>
                                     <td><?php echo lang('description'); ?>: </td><td><?php if(isset($result)){ echo $result['testimonial_description'];} else{ echo $testimonial_description; } ?></td>
                                </tr>
                                <tr>
                                   <td><?php echo lang('created_on'); ?>: </td><td><?php if(isset($result)){ echo $result['created_on'];} else{ echo $created_on; }?></td>  
                                </tr>
                            </table>
                            </td>         
                        </tr>
                     </table>
                    <hr/>
                    </td>
                    <td></td>
                </tr>               
            </table>
         </td>
    </tr>
</table>
  