<div class="contentpanel">
    <div class="panel-header clearfix">
        <a class="add-link" title="<?php echo lang('cms_list'); ?>" href="<?php echo site_url(get_current_section($this) . '/banner/index/' . $language_code) ?>"><?php echo lang('banner_list'); ?></a>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><?php echo lang('add_form_fields'); ?> - <?php echo $language_name; ?></h4>
        </div>

        <?php
        $attributes = array('class' => 'form-horizontal form-bordered', 'id' => 'banneradd', 'name' => 'banneradd');

        echo form_open_multipart($this->controller->section_name . '/banner/action/' . $action . "/" . $language_code . "/" . $id, $attributes);

        $hdn = array(
            'type' => 'hidden',
            'value' => (isset($banner['image_url'])) ? $banner['image_url'] : ''
        );
        echo form_hidden('hdnphoto', (isset($banner['image_url'])) ? $banner['image_url'] : '');
        ?>

        <div class="panel-body panel-body-nopadding">
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('section'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    if ($action == 'edit' && isset($banner['section_id'])) {
                        echo form_dropdown('section_id', $banner_data['sections'], $banner['section_id'], 'disabled="disabled" id=section onchange = load_section_related_fields(this.value); class="form-control" ');
                        echo form_hidden('section_id', $banner['section_id']);
                    } else {
                        echo form_dropdown('section_id', $banner_data['sections'], '', 'id=section onchange = load_section_related_fields(this.value); class="form-control" ');
                    }
                    ?>

                </div>
            </div>

            <div class="form-group not_home" id="page_tr">
                <label class="col-sm-3 control-label"><?php echo lang('page'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    echo form_dropdown('page_id', $banner_data['pages'], (isset($banner['page_id'])) ? $banner['page_id'] : '', 'class="form-control"');
                    ?>
                </div>
            </div>


            <div class="form-group" id="title_tr">
                <label class="col-sm-3 control-label"><?php echo lang('title'); ?>
                    <span class="asterisk">*</span>
                </label>
                <div class="col-sm-6">
                    <?php
                    $title_data = array(
                        'name' => 'title',
                        'id' => 'title',
                        'size' => '50',
                        'maxlength' => '100',
                        'class' => 'form-control',
                        'value' => set_value('title', ((isset($banner['title'])) ? $banner['title'] : ''))
                    );
                    echo form_input($title_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('title'); ?></span>
                </div>
            </div>

            <div class="form-group" id="desc_tr">
                <label class="col-sm-3 control-label"><?php echo lang('description'); ?></label>
                <div class="col-sm-6">
                    <?php
                    $desc_data = array(
                        'name' => 'description',
                        'id' => 'description',
                        'size' => '50',
                        'class' => 'form-control',
                        'rows' => 5,
                        'value' => set_value('description', ((isset($banner['description'])) ? $banner['description'] : ''))
                    );
                    echo form_textarea($desc_data);
                    ?>
                </div>
            </div>


            <div class="form-group not_home" id="position_tr">
                <label class="col-sm-3 control-label"><?php echo lang('position'); ?></label>
                <div class="col-sm-6">
                    <?php
                    echo form_dropdown('position', $banner_data['positions'], (isset($banner['position'])) ? $banner['position'] : '', 'class=form-control');
                    ?>
                </div>
            </div>

            <div class="form-group not_home" id="type_tr">
                <label class="col-sm-3 control-label"><?php echo lang('type'); ?></label>
                <div class="col-sm-6">

                    <?php
                    echo form_dropdown('type', $banner_data['types'], (isset($banner['banner_type'])) ? $banner['banner_type'] : '', 'id=type onchange = load_type_related_fields(this.value); class=form-control');
                    ?>
                </div>
            </div>

            <div class="form-group not_code" id="image_tr">
                <label class="col-sm-3 control-label">
                    <?php echo lang('image'); ?>
                    <span class="asterisk">*</span>
                </label>
                <div class="col-sm-6">
                    <?php
                    $class = (empty($banner['image_url'])) ? 'validate[required]' : '';
                    $image_data = array(
                        'name' => 'image',
                        'id' => 'image',
                        'value' => '',
                        'size' => '50',
                        'class' => $class . " form-control",
                        'maxlength' => '255',
                        'value' => set_value('image', ((isset($banner['image_url'])) ? $banner['image_url'] : ''))
                    );
                    echo form_upload($image_data);
                    echo (isset($banner['image_url']) && isset($id) && $id != 0) ? "<p><img src=" . base_url() . "assets/uploads/banner_ad_images/main/" . $banner['image_url'] . " class = 'img-responsive' style = 'padding-top: 15px' /></p>" : ''
                    ?>
                    <span class="warning-msg"><?php echo form_error('image'); ?></span>
                </div>
            </div>

            <div class="form-group not_code" id="link_tr">
                <label class="col-sm-3 control-label"><?php echo lang('link'); ?></label>
                <div class="col-sm-6">
                    <?php
                    $link_data = array(
                        'name' => 'link',
                        'id' => 'link',
                        'value' => '',
                        'size' => '50',
                        'maxlength' => '255',
                        'class' => 'form-control',
                        'value' => set_value('link', ((isset($banner['link'])) ? $banner['link'] : ''))
                    );
                    echo form_input($link_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('link'); ?></span>
                </div>
            </div>

            <div class="form-group not_home not_image" id="code_tr">
                <label class="col-sm-3 control-label"><?php echo lang('code'); ?></label>
                <div class="col-sm-6">
                    <?php
                    $embedded_code = array(
                        'name' => 'code',
                        'id' => 'code',
                        'value' => '',
                        'size' => '50',
                        'class' => 'form-control',
                        'value' => set_value('code', ((isset($banner['embedded_code'])) ? html_entity_decode($banner['embedded_code']) : ''))
                    );
                    echo form_textarea($embedded_code);
                    ?>
                    <span class="warning-msg"><?php echo form_error('code'); ?></span>
                </div>
            </div>

            <div class="form-group" id="order_tr">
                <label class="col-sm-3 control-label"><?php echo lang('order'); ?></label>
                <div class="col-sm-6">
                    <?php
                    $order = array(
                        'name' => 'order',
                        'id' => 'order',
                        'value' => '',
                        'size' => '50',
                        'maxlength' => '2',
                        'class' => 'form-control',
                        'value' => set_value('order', ((isset($banner['order'])) ? $banner['order'] : ''))
                    );
                    echo form_input($order);
                    ?>
                    <span class="warning-msg"><?php echo form_error('order'); ?></span>
                </div>
            </div>

            <div class="form-group not_home" id="country_tr">
                <label class="col-sm-3 control-label"><?php echo lang('country'); ?></label>
                <div class="col-sm-6">

                    <?php
                    echo form_dropdown('country_id', $country_list, (isset($banner['country_id'])) ? $banner['country_id'] : 0, 'onchange = load_state(this.value); class=form-control');
                    ?>
                    <span class="warning-msg"><?php echo form_error('country_id'); ?></span>
                </div>
            </div>

            <div class="form-group not_home" id="state_tr">
                <label class="col-sm-3 control-label"><?php echo lang('state'); ?></label>
                <div class="col-sm-6" id="related_state">
                    <?php
                    echo form_dropdown('state_id', $state_list, (isset($banner['state_id'])) ? $banner['state_id'] : '', 'onchange = load_city(this.value); class=form-control');
                    ?>
                    <span class="warning-msg"><?php echo form_error('state_id'); ?></span>
                </div>
            </div>

            <div class="form-group not_home" id="city_tr">
                <label class="col-sm-3 control-label"><?php echo lang('city'); ?></label>
                <div class="col-sm-6" id="related_city">
                    <?php
                    echo form_dropdown('city_id', $city_list, (isset($banner['city_id'])) ? $banner['city_id'] : '', 'class = "form-control" ');
                    ?>
                    <span class="warning-msg"><?php echo form_error('city_id'); ?></span>
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-3 control-label"><label><?php echo lang('status'); ?></label></label>
                <div class="col-sm-6">
                    <?php
                    $options = array(
                        '1' => lang('active'),
                        '0' => lang('inactive')
                    );
                    echo form_dropdown('status', $options, (isset($banner['status'])) ? $banner['status'] : '', 'class = "form-control" ');
                    ?>
                </div>
            </div>
        </div><!-- panel-body -->

        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">

                    <?php
                    $submit_button = array(
                        'name' => 'bannersubmit',
                        'id' => 'bannersubmit',
                        'value' => lang('save'),
                        'title' => lang('save'),
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp; ' . lang('save')
                    );
                    echo form_button($submit_button);


                    $cancel_button = array(
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; ' . lang('cancel'),
                        'title' => lang('cancel'),
                        'class' => 'btn btn-default',
                        'onclick' => "location.href='" . site_url(get_current_section($this) . '/banner/index/' . $language_code) . "'",
                    );
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo form_button($cancel_button);
                    ?>  
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {


        $('#banneradd').bootstrapValidator({
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: 'The Title field is required.'
                        }
                    }
                },
                image: {
                    <?php if(!empty($banner['image_url'])){ ?>
                    enabled: false,
                    <?php } else {?>
                        enabled: true,
                    <?php }?>    
                    validators: {
                        notEmpty: {
                            message: 'The Image field is required.'
                        }
                    }
                }
            }
        });

        $("input:visible:first").focus();
    });

    load_section_related_fields($('#section').val());

    function load_section_related_fields(val)
    {
        if (val == <?php echo HOME_BANNER; ?>)
        {
            $('.not_home').hide();
            $('.not_image').hide();
            $('#order').addClass('validate[custom[integer]]');
            $('#order_tr').show();
            $('.not_code').show();
            $('#type').val(<?php echo AD_IMAGE; ?>);
        }
        else if (val == <?php echo AD_BANNER; ?>)
        {
            $('.not_home').show();
            $('#order_tr').hide();
        }
        load_type_related_fields($('#type').val());

    }
<?php
if ($id != '' && $id != 0 && !empty($banner['state_id']) && !empty($banner['city_id'])) {
    ?>
        load_state('<?php echo $banner['country_id']; ?>', '<?php echo $banner['state_id']; ?>');
        load_city('<?php echo $banner['state_id']; ?>', '<?php echo $banner['city_id']; ?>');
    <?php
}
?>

    function load_type_related_fields(val)
    {
        if (val == <?php echo AD_IMAGE; ?>)
        {
            $('.not_image').hide();
            $('.not_code').show();
            $('#code').removeClass('validate[required]');
            $('#link').addClass('validate[custom[url]]');

        }
        else if (val == <?php echo AD_EMBEDDED; ?>)
        {
            $('#code').addClass('validate[required]');
            $('#link').removeClass('validate[custom[url]]');
            $('.not_code').hide();
            $('.not_image').show();
        }
    }

    function load_state(country_id, state_id)
    {
        lang_id = '<?php echo $language_id ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . get_current_section($this); ?>/banner/get_related_state',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', country_id: country_id, lang_id: lang_id},
            success: function(data) {
                $("#related_state").html(data);
                $('#state_id').val(state_id);
            }
        });
        load_city(state_id, '<?php if (!empty($banner['city_id'])) echo $banner['city_id']; ?>');
    }

    function load_city(state_id, city_id)
    {
        lang_id = '<?php echo $language_id ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . get_current_section($this); ?>/banner/get_related_city',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', state_id: state_id, lang_id: lang_id},
            success: function(data) {
                $("#related_city").html(data);
                $('#city_id').val(city_id);
            }
        });
    }

</script>