<?php $id = ((isset($id)) ? $id : 0); ?>  
<div class="contentpanel">
    <div class="panel-header clearfix">
        <a title="<?php echo lang('testimonial_list'); ?>" href="<?php echo site_url($this->section_name . '/testimonial') ?>" class="add-link"><?php echo lang('testimonial_list'); ?></a>

    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><?php echo lang('add-edit-record') ?> - <?php echo $language_name; ?></h4>
        </div>
        <?php echo form_open_multipart($this->section_name . '/testimonial/save/' . $language_code, array('id' => 'saveform', 'class' => 'form-horizontal form-bordered', 'name' => 'saveform')); ?>
        <div class="panel-body panel-body-nopadding">




            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('category'), 'parent_id'); ?><span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php
                    $options = array(
                        'name' => 'category_id',
                        'id' => 'category_id',
                        'class' => 'form-control',
                        'module_id' => TESTIMONIAL_MODULE_NO,
                        'value' => (isset($category_id)) ? $category_id : '',
                        'language_id' => $language_id
//                                                'first_option' => '--Select--'
                    );
                    ?>
                    <?php widget('category_dropdown', $options); ?> <span class="warning-msg"><?php echo form_error('parent_id'); ?></span>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('testimonial_name'), 'testimonial_name'); ?><span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <?php
                    $testimonial_name_data = array(
                        'name' => 'testimonial_name',
                        'id' => 'testimonial_name',
                        'value' => set_value('testimonial_name', ((isset($testimonial_name)) ? $testimonial_name : '')),
                        'class' => 'form-control'
                    );
                    ?>
                    <?php echo form_input($testimonial_name_data); ?><span class="warning-msg"><?php echo form_error('testimonial_name'); ?></span>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('slug'), 'testimonial_slug'); ?>
  <!--                  <span class="asterisk">*</span>-->
                </label>
                <div class="col-sm-6">
                    <?php
                    $testimonial_slug_data = array(
                        'name' => 'testimonial_slug',
                        'id' => 'testimonial_slug',
                        'value' => set_value('testimonial_slug', ((isset($testimonial_slug)) ? $testimonial_slug : '')),
                        'class' => 'form-control'
                    );
                    ?>
                    <?php echo form_input($testimonial_slug_data); ?><span class="warning-msg"><?php echo form_error('testimonial_slug'); ?></span>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('description'), 'testimonial_description'); ?>
<!--                    <span class="asterisk">*</span>-->
                </label>
                <div class="col-sm-9">
                    <?php
                    $testimonial_description_data = array(
                        'name' => 'testimonial_description',
                        'id' => 'wysiwyg',
                        'value' => set_value('testimonial_description', ((isset($testimonial_description)) ? $testimonial_description : '')),
                        'class' => 'form-control'
                    );
                    ?>
                    <?php echo form_textarea($testimonial_description_data); ?>
                    <br/><span class="warning-msg"><?php echo form_error('testimonial_description'); ?></span> 
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('logo'), 'logo'); ?>
<!--                    <span class="asterisk">*</span>-->
                </label>
                <div class="col-sm-6">
                    <?php
                    $logo_data = array(
                        'name' => 'logo',
                        'id' => 'logo',
                        'value' => set_value('logo', ((isset($logo)) ? $logo : '')),
                        'class' => 'form-control',
                        'maxlength' => '255'
                    );
                    ?>
                    <?php echo form_upload($logo_data); ?>

                    <p class="text-primary"><?php echo lang('img_limit'); ?></p>
                    <span class="warning-msg"><?php echo form_error('logo'); ?></span>

                    <?php
                    if ($action == 'edit' && !empty($logo)) {
                        if (file_exists(FCPATH . $logo)) {
                            $logo_image = $logo;
                            ?>
                            <img src="<?php echo base_url(); ?><?php echo $logo_image; ?>" height ="50px"/>
                        <?php
                        } else {

                            $logo = 'logo.jpg';
                            $styles = array(
                                'width' => 100,
                                'height' => 100,
                            );
                            echo add_image(array($logo), 'testimonial', 'modules', $styles);
                            ?>                                    
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('company_name'), 'company_name'); ?>
<!--                    <span class="asterisk">*</span>-->
                </label>
                <div class="col-sm-6">
<?php
$company_name_data = array(
    'name' => 'company_name',
    'id' => 'company_name',
    'value' => set_value('company_name', ((isset($company_name)) ? $company_name : '')),
    'class' => 'form-control',
);
?>
                    <?php echo form_input($company_name_data); ?><span class="warning-msg"><?php echo form_error('company_name'); ?></span>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('website'), 'website'); ?>
<!--                    <span class="asterisk">*</span>-->
                </label>
                <div class="col-sm-6">
<?php
$website_data = array(
    'name' => 'website',
    'id' => 'website',
    'value' => set_value('website', ((isset($website)) ? $website : '')),
    'class' => 'form-control'
);
?>
                    <?php echo form_input($website_data); ?>
                    <p class="text-primary"><?php echo lang('i.e.'); ?></p>
                    <span class="warning-msg"><?php echo form_error('website'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('position'), 'position'); ?>
<!--                    <span class="asterisk">*</span>-->
                </label>
                <div class="col-sm-6">
<?php
$position_data = array(
    'name' => 'position',
    'id' => 'position',
    'value' => set_value('position', ((isset($position)) ? $position : '')),
    'class' => 'form-control'
);
?>
                    <?php echo form_input($position_data); ?><br/><span class="warning-msg"><?php echo form_error('position'); ?></span>
                </div>
            </div>

                    <?php
                    $video_type_data = array(
                        '' => 'Select',
                        SRC => 'File',
                        YOUTUBE => 'You Tube',
                    );
                    ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('video_type'), 'video_type'); ?><span class="asterisk">*</span></label>
                <div class="col-sm-6">
            <?php
            if (isset($video_type)) {
                $video_type_val = $video_type;
            } else {
                $video_type_val = ' ';
            }
            ?>
                    <?php echo form_dropdown('video_type', $video_type_data, $video_type_val, 'id=change class=form-control onchange = change_type(this.value);'); ?><span class="warning-msg"><?php echo form_error('video_src'); ?></span>
                </div>
            </div>

                    <?php
                    if (!empty($video_src)) {

                        $video_src_data = array(
                            'name' => 'video_src',
                            'id' => 'video_src',
                            'value' => set_value('video_src', ((isset($video_src)) ? $video_src : '')),
                            'class' => 'form-control'
                        );
                    } else {

                        $video_src_data = array(
                            'name' => 'video_src',
                            'id' => 'video_src',
                            'value' => set_value('video_src', ((isset($video_src)) ? $video_src : '')),
                            'class' => 'form-control'
                        );
                    }
                    ?>
            <?php
            $video_link_data = array(
                'name' => 'video_link',
                'id' => 'video_link',
                'value' => set_value('video_link', ((isset($video_src)) ? $video_src : '')),
                'class' => 'form-control'
            );
            ?>




            <div class="form-group" id="src" style="display: none">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('file_source'), 'video_src'); ?><span class="asterisk">*</span></label>
                <div class="col-sm-6">
            <?php echo form_upload($video_src_data) ?>
                    <p class="text-primary"><?php echo lang('video_limit'); ?></p>
                </div>
            </div>

            <div class="form-group" id="youtube" style="display: none">
                <label class="col-sm-3 control-label"><?php echo form_label(lang('video_source'), 'video_link'); ?><span class="asterisk">*</span></label>
                <div class="col-sm-6">
<?php echo form_input($video_link_data) ?>
                    <p class="text-primary"><?php echo lang('i.e.'); ?></p>
                    
                    <span class="warning-msg"><?php echo form_error('video_src'); ?></span>
                </div>
            </div>
<?php if (isset($video_type) && $video_type == SRC) {
    ?>
                <div class="form-group" id="youtube" style="display: none">
                    <label class="col-sm-3 control-label"><?php echo form_label(lang('video_source'), 'video_link'); ?><span class="asterisk">*</span></label>
                    <div class="col-sm-6">
    <?php echo form_input($video_link_data) ?>
                        
                        <p class="text-primary"><?php echo lang('i.e.'); ?></p>
                        <span class="warning-msg"><?php echo form_error('video_src'); ?></span>
                    </div>
                </div>

<?php } ?>
<?php
$is_published_data = array(
    PUBLISH => 'Publish',
    UNPUBLISH => 'Unpublish',
);
?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo form_label('Status', 'approval_status'); ?>
  <!--                  <span class="asterisk">*</span>-->
                </label>
                <div class="col-sm-6">
<?php
if (isset($is_published)) {
    $is_published_val = $is_published;
} else {
    $is_published_val = '';
}
?>
            <?php echo form_dropdown('is_published', $is_published_data, $is_published_val, 'class="form-control"'); ?><span class="warning-msg"><?php echo form_error('is_published'); ?></span></td>

                </div>
            </div>



        </div><!-- panel-body -->

        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <?php
                    $submit_button = array(
                        'name' => 'mysubmit',
                        'id' => 'mysubmit',
                        'value' => lang('btn-save'),
                        'title' => lang('btn-save'),
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp; ' . lang('btn-save')
                    );
                    echo form_button($submit_button);
                    $cancel_button = array(
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; ' . lang('btn-cancel'),
                        'name' => 'cancel',
                        'value' => lang('btn-cancel'),
                        'title' => lang('btn-cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . site_url($this->section_name . '/testimonial') . "'",
                    );
                    echo "&nbsp;";
                    echo "&nbsp;";
                    echo form_button($cancel_button);
                    ?>
                </div>
            </div>
        </div><!-- panel-footer -->

    </div><!-- panel -->
                    <?php
                    if (isset($id) && $id != '') {
                        if (isset($testimonial_slug) && $testimonial_slug != '')
                            echo form_hidden('old_slug_url', $testimonial_slug);
                    }

                    echo form_hidden('id', (isset($id)) ? $id : '0' );
                    echo form_hidden('action', (isset($action)) ? $action : '0' );
                    echo form_hidden('testimonial_id', (isset($testimonial_id)) ? $testimonial_id : '0' );
                    echo form_hidden('logo', (isset($logo)) ? $logo : '0' );
                    if (isset($video_type) == SRC) {
                        echo form_hidden('video_src', (isset($video_src)) ? $video_src : '0' );
                    }
                    echo form_close();
                    ?>


</div><!-- contentpanel -->
    <?php
    echo add_css(array('bootstrap-wysihtml5'));
    echo add_js(array('wysihtml5-0.3.0.min', 'bootstrap-wysihtml5',));
    ?>
<script>
    jQuery(document).ready(function() {


        jQuery('#wysiwyg').wysihtml5({color: true, html: true});



    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#testimonial_slug').slugify('#testimonial_name');

    });
    function change_type(id)
    {
        if (id == <?php echo SRC; ?>)
        {
            $("#src").show();
            $("#youtube").hide();
        }
        if (id == <?php echo YOUTUBE; ?>)
        {
            $("#youtube").show();
            $("#src").hide();
        }
        if (id == '')
        {
            $("#src").hide();
            $("#youtube").hide();
        }
    }
    change_type($("#change").val());
    $('.video_image').bind('click', function(e) {
        // Prevents the default action to be triggered.
        e.preventDefault();
        // Triggering bPopup when click event is fired
        $('.player').bPopup();
        $f("player", "<?php echo base_url(); ?>themes/front/js/modules/testimonial/flowplayer-3.2.16.swf",
                {plugins: {
                        controls: {
                            // you do not need full path here when the plugin
                            // is in the same folder as flowplayer.swf
                            url: "<?php echo base_url(); ?>themes/front/js/modules/testimonial/flowplayer.controls-3.2.15.swf"
                        }
                    }
                }
        );
    });
</script>


<script type="text/javascript">

    $(document).ready(function() {

        $('#saveform').bootstrapValidator({
            fields: {
                testimonial_name: {
                    validators: {
                        notEmpty: {
                            message: 'The Testimonial Name field is required.'
                        }
                    }
                },
                testimonial_slug: {
                    validators: {
                        notEmpty: {
                            message: 'The Testimonial Slug field is required.'
                        }
                    }
                },
                website: {
                    validators: {
                        uri: {
                            message: 'The website address is not valid'
                        }
                    }
                },
                is_published: {
                    validators: {
                        notEmpty: {
                            message: 'The Status URL field is required.'
                        }
                    }
                }
            }
        });

    });
    $(document).ajaxComplete(function() {
        // Chosen Select
        jQuery("#testimonial_name").focus();

        jQuery('#wysiwyg').wysihtml5({color: true, html: true});
        // jQuery('#ckeditor').ckeditor();

        $('#saveform').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                testimonial_name: {
                    validators: {
                        notEmpty: {
                            message: 'The Testimonial Name field is required.'
                        }
                    }
                },
//                  testimonial_slug: {
//                    message: 'The Testimonial Slug field is required.',
//                    validators: {
//                        notEmpty: {
//                            message: 'The Testimonial Slug field is required.'
//                        }
//                    }
//                },
                website: {
                    validators: {
                        uri: {
                            message: 'The website address is not valid'
                        }
                    }
                },
                is_published: {
                    validators: {
                        notEmpty: {
                            message: 'The Status URL field is required.'
                        }
                    }
                }
            }
        });

    });


</script>