<div class="main-content">
    <div class="grid-data info-content">


        <!--Language Button Div-->
        <div class="contentpanel" style="display: none;">
            <div class="panel panel-default form-panel mb-none">
                <div class="panel-body">
                    <div class="row row-pad-5"> 
                        <div class="col-lg-3 col-md-3 langbtn">
                            <?php
                            for ($i = 0; $i < count($languages); $i++) {
                                $selected = 'class="btn btn-default"';
                                if (($languages[$i]['l']['id']) == $language_id) {
                                    $selected = 'class="btn btn-primary"';
                                }
                                ?>
                                <a <?php echo $selected; ?> href="javascript:;" id="btn-<?php echo $languages[$i]['l']['language_code'] ?>"  title="<?php echo ($languages[$i]['l']['language_code']); ?>" onclick="load_form('<?php echo ($languages[$i]['l']['language_code']); ?>')"><?php echo $languages[$i]['l']['language_name']; ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <!--Language Button Div-->



        <div class="profile-content-box" id="form">
            <!-- Form will come here -->
            <?php echo $content; ?>
        </div>	
    </div>  
</div>
<script type="text/javascript">
    $(document).ready(function() {
        
        load_form = function(lang_code) {
            
            alert("Here");
            
            $('a.btn').attr('class', 'btn btn-default');
            $('#btn-' + lang_code).attr('class', 'btn btn-primary');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_action/<?php echo $action; ?>/'+lang_code+'/<?php echo $id; ?>',
            data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},

            success: function(msg) {
                $("#form").html(msg);
            }
        });
        };

    });

</script><!--Accordion Jquery -->
<?php
echo add_css(array('bootstrap-wysihtml5'));
echo add_js(array('wysihtml5-0.3.0.min', 'bootstrap-wysihtml5',));
?>


<script>
    
   $(document).ready(function() {
       
//       $('#add').bootstrapValidator({
//            fields: {
//                name: {
//                   
//                    validators: {
//                        notEmpty: {
//                            message: 'The Name field is required.'
//                        }
//                    }
//                },
////                price: {
////                  
////                    validators: {
////                        notEmpty: {
////                            message: 'The Price field is required.'
////                        }
////                    }
////                }, 
////                product_image: {
////                  
////                    validators: {
////                        notEmpty: {
////                            message: 'The Image field is required.'
////                        }
////                    }
////                }
//            }
//        });
        
        
        $('#slug').slugify('#name');
        jQuery("#name").focus();

        jQuery('#wysiwyg').wysihtml5({color: true, html: true});
        // jQuery('#ckeditor').ckeditor();

        

    });
</script>

