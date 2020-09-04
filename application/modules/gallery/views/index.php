<?php echo add_css('modules/gallery/image_gallery_nano/nanogallery'); ?>
<script type="text/javascript">
function submitGalleryId(id){
    var url = '<?php echo base_url().'gallery/gallery_images/';?>';
    window.location.href = url+id;
}
</script>
<br>
<div id="nanoGallery4" class="nanogallery_theme_default" style="max-width: 942px;">
    <div class="nanoGalleryBreadcrumb">
        <div class="folder">List of Albums</div>        
    </div><br />
    <div class="nanoGalleryContainerParent" style="opacity: 1;">
        <div class="nanoGalleryContainer" style="max-height: 428px; max-width: 942px;">
       <?php 
            $i = 0;
            foreach ($galleries as $_galleries)
            {
                if(!empty($images_name_array))
                { 
                    ?>
                        <div class="container" style="opacity: 1;" onclick="submitGalleryId('<?php echo $_galleries['G']['slug_url'];?>');">
                    <?php 
                }
                else 
                { 
                    ?> 
                        <div class="container" style="opacity: 1;"> 
                    <?php 
                } ?>
                <div style="width: 300px; height: 200px;" class="imgContainer">
                    <?php 
                        if(!empty($images_name_array))
                        { 
                            ?>
                            <img style="max-width: 300px; max-height: 200px;" src="<?php echo base_url()."assets/uploads/gallery_images/".$images_name_array[$i]?>" class="image">
                            <?php   
                        }
                        else 
                        { 
                            echo lang('image-not-available-or-inactive'); 
                        } ?>
                </div>
                <div class="iconInfo"></div>
                <div style="width: 300px;" class="labelImage">
                    <div class="labelFolderTitle"><?php echo $_galleries['G']['title'];?></div>
                    <div class="labelDescription"></div>
                </div>                
            </div>
        <?php 
            $i++;            
            } ?>          
        </div>        
    </div>
</div>        
<br>
