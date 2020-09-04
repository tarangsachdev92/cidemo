<div class="main-content">
    <div class="grid-data info-content">


        <!--Language Button Div-->
        <div class="contentpanel" style="display: none;">
            <div class="panel panel-default form-panel mb-none">
                <div class="panel-body">
                    <div class="row row-pad-5"> 
                        <div class="col-lg-12 col-md-12 langbtn">
                            <?php
                            for ($i = 0; $i < count($languages); $i++) {
                                $selected = 'class="btn btn-default"';
                                if (($languages[$i]['l']['id']) == $language_id) {
                                    $selected = 'class="btn btn-primary"';
                                }
                                ?>
                                <a <?php echo $selected; ?> href="javascript:;" id="btn-<?php echo $languages[$i]['l']['language_code'] ?>"  title="<?php echo ($languages[$i]['l']['language_code']); ?>" onclick="load_form('<?php echo ($languages[$i]['l']['language_code']); ?>')"><i class="fa fa-comments"></i> <?php echo $languages[$i]['l']['language_name']; ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <!--Language Button Div-->



        <div class="profile-content-box" id="category_form">
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
            $('a.btn').attr('class', 'btn btn-default');
            $('#btn-' + lang_code).attr('class', 'btn btn-primary');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url().$this->_data["section_name"]; ?>/categories/ajax_action/<?php echo $action; ?>/'+lang_code+'/<?php echo $id; ?>',
            data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
            error: function(){
		        alert("Server problem. Please try again.");
       			return false;
	        },
       		complete: function(){
       		},
            success: function(msg) {
                $("#category_form").html(msg);
            }
        });
        }
        
         openlink = function(type) {
            // lang_code = $(".tab-headings li.selected a").attr('title');
            lang_code = $(".btn-primary").attr('title');
            location.href = "<?php echo base_url() . $this->_data['section_name']; ?>/categories/index/"+lang_code;
        };

       });
    
</script><!--Accordion Jquery -->
<?php
echo add_css(array('bootstrap-wysihtml5'));
echo add_js(array('wysihtml5-0.3.0.min', 'bootstrap-wysihtml5',));
?>
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>
<script>
    jQuery(document).ready(function() {

        // $('#slug_url').slugify('#title');
        
        jQuery('#wysiwyg').wysihtml5({color: true, html: true});
        // jQuery('#ckeditor').ckeditor();

        $('#slug_url').slugify('#title');
    });
</script>

<script type="text/javascript">

    $(document).ready(function() {
      
        $('#categoryadd').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                title: {
                    message: 'The Title field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Title field is required.'
                        }
                    }
                }
               
            }
        });
        $(document).ajaxComplete(function() {
            // Chosen Select
        jQuery("#title").focus();

        jQuery('#wysiwyg').wysihtml5({color: true, html: true});
        // jQuery('#ckeditor').ckeditor();

        $('#categoryadd').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                title: {
                    message: 'The Title field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Title field is required.'
                        }
                    }
                }
                
            }
        });

    });
    });


  
</script>
