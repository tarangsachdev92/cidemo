<div class="main-content">
    <div class="grid-data info-content">


        <!--Language Button Div-->
<!--        <div class="contentpanel">
            <div class="panel panel-default form-panel mb-none">
                <div class="panel-body">
                    <div class="row row-pad-5"> 
                        <div class="col-lg-12 col-md-12 langbtn">
                            <?php
                            for ($i = 0; $i < count($languages_list); $i++) {
                                $selected = 'class="btn btn-default"';
                                if (($languages_list[$i]['l']['id']) == $language_id) {
                                    $selected = 'class="btn btn-primary"';
                                }
                                ?>
                                <a <?php echo $selected; ?> href="javascript:;" id="btn-<?php echo $languages_list[$i]['l']['language_code'] ?>"  title="<?php echo ($languages_list[$i]['l']['language_code']); ?>" onclick="load_ajax_index('<?php echo ($languages_list[$i]['l']['language_code']); ?>')"><i class="fa fa-comments"></i> &nbsp; <?php echo $languages_list[$i]['l']['language_name']; ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>-->
        <!--Language Button Div-->



        <div id="ajax_form">
            <!-- Form will come here -->
            
        </div>	
    </div>  
</div>

<script type="text/javascript">
    $(document).ready(function() {
            load_ajax_index = function(lang_code) {
            $('a.btn').attr('class', 'btn btn-default');
            $('#btn-' + lang_code).attr('class', 'btn btn-primary');
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_newsletters_actions/<?php echo $action; ?>/' + lang_code + '/<?php echo $id; ?>',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
                success: function(data) {
                    $("#ajax_form").html(data);
                }
            });
            unblockUI();
        }
        load_ajax_index('<?php echo $language_code; ?>');
        
         
    });
</script><!--Accordion Jquery -->
<?php
echo add_css(array('bootstrap-wysihtml5'));
echo add_js(array('wysihtml5-0.3.0.min', 'bootstrap-wysihtml5',));
?>
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript">
    
    $(document).ajaxComplete(function() {
         jQuery("#subject").focus();
         $('#schedule').datepicker({
                 dateFormat: 'yy-mm-dd'
            
        });
        jQuery('#wysiwyg').wysihtml5({color: true, html: true});
        
        $('#newsletters_actions').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                
                subject: {
                    message: 'The Subject field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Subject field is required.'
                        }
                    }
                },
                
                category : {
                    message: 'The Category field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Category field is required.'
                        }
                    }
                },
                title : {
                    message: 'The Title field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Title field is required.'
                        }
                    }
                },
                
                content : {
                    message: 'The Content field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Content field is required.'
                        }
                    }
                },
                templates : {
                    message: 'The Templates field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Templates field is required.'
                        }
                    }
                },
                
                schedule : {
                    message: 'The Schedule Date field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Schedule Date field is required.'
                        }
                    }
                },
                
                status: {
                    message: 'The Status field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Status field is required.'
                        }
                    }
                }
            }
        });
        
    });
    
</script>
<script type="text/javascript">

    $(document).ready(function() {
      
        $('#newsletters_actions').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                
                subject: {
                    message: 'The Subject field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Subject field is required.'
                        }
                    }
                },
                
                category : {
                    message: 'The Category field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Category field is required.'
                        }
                    }
                },
                title : {
                    message: 'The Title field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Title field is required.'
                        }
                    }
                },
                
                content : {
                    message: 'The Content field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Content field is required.'
                        }
                    }
                },
                templates : {
                    message: 'The Templates field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Templates field is required.'
                        }
                    }
                },
                
                schedule : {
                    message: 'The Schedule Date field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Schedule Date field is required.'
                        }
                    }
                },
                
                status: {
                    message: 'The Status field is required.',
                    validators: {
                        notEmpty: {
                            message: 'The Status field is required.'
                        }
                    }
                }
            }
        });
       
    });


  
</script>
<script type="text/javascript">
function schedule_setting(val) {
    if (val == "yes")
    {
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var output = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
        jQuery("#schedule").val(output);
        jQuery("#schedule_time_tr").hide();
        jQuery("#status").val('active');
        jQuery("#status option[value=inactive]").attr('disabled', true);

    }
    else
    {
        jQuery("#schedule").val("");
        jQuery("#schedule_time_tr").show();
        jQuery("#status").val('active');
        jQuery("#status option[value=inactive]").attr('disabled', false);
    }
} 
</script>