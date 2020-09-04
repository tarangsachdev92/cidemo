<?php
    echo add_css('modules/gallery/image_gallery_nano/nanogallery');
    echo add_js(array('modules/gallery/image_gallery_nano_js/jquery-1.8.2.min','modules/gallery/image_gallery_nano_js/jquery-jsonp/jquery.jsonp','modules/gallery/image_gallery_nano_js/jquery.nanogallery'));
?>
<link href="js/modules/gallery/image_gallery_nano_js/fancybox/jquery.fancybox.css?v=2.1.4" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/modules/gallery/image_gallery_nano_js/fancybox/jquery.fancybox.pack.js?v=2.1.4"></script>
<link href="js/modules/gallery/image_gallery_nano_js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/modules/gallery/image_gallery_nano_js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="js/modules/gallery/image_gallery_nano_js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.5"></script>

<script type="text/javascript">
$(document).ready(function () {
    // Sample1
    var thumb_url = '<?php echo base_url()."assets/uploads/gallery_images/thumb/";?>';
    var big_url = '<?php echo base_url()."assets/uploads/gallery_images/";?>';
    jQuery("#nanoGallery1").nanoGallery({thumbnailWidth:100,thumbnailHeight:100,
    items: [

        <?php foreach ($images_name as $_images_name){?>
            {
                    src: big_url+'<?php echo $_images_name['I']['image']?>',		// image url
                    srct: thumb_url+'<?php echo $_images_name['I']['image']?>',		// thumbnail url
                    title: '<?php echo $_images_name['I']['title']?>' 			// thumbnail title
            },
        <?php }?>
            ],
            displayCaption:false
    });
});
</script>
<br />
<div id="nanoGallery4" class="nanogallery_theme_default" style="max-width: 942px;">
    <div class="nanoGalleryBreadcrumb">
        <div class="folder">
            <a href="<?php echo base_url().'gallery'?>" style="color: #CCCCCC">List of Albums</a>  >>  <?php echo $images_name[0]['G']['title'];?>
        </div>        
    </div><br />
    <div class="nanoGalleryContainerParent" style="opacity: 1;">
        <div class="nanoGalleryContainer" style="max-height: 428px; max-width: 942px;">
            <div id="nanoGallery1"></div>	
        </div>        
    </div>    
</div>        
<br />