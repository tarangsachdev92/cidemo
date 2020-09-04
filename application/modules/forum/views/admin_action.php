<?php
if (!isset($category_id)) {
    $category_id = "";
}
?>

<?php if ($action != "edit") {?>

<!--Language Button Div-->
<!--        <div class="contentpanel">
            <div class="panel panel-default form-panel">
                <div class="panel-body">
                    <div class="row row-pad-5"> 
                        <div class="col-lg-12 col-md-12">
                            <?php
                            for ($i = 0; $i < count($languages); $i++) {
                                $selected = 'class="btn btn-default"';
                                if (($languages[$i]['l']['id']) == $language_id) {
                                    $selected = 'class="btn btn-primary"';
                                }
                                ?>
                                <a <?php echo $selected; ?> href="javascript:;" id="btn-<?php echo $languages[$i]['l']['language_code'] ?>"  title="<?php echo ($languages[$i]['l']['language_code']); ?>" onclick="load_form('<?php echo ($languages[$i]['l']['language_code']); ?>')"><i class="fa fa-comments"></i> &nbsp; <?php echo $languages[$i]['l']['language_name']; ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>-->
        <!--Language Button Div-->

<?php } ?>

<div class="contentpanel">
    <div class="panel-header clearfix">
        <?php echo anchor(site_url() . $this->_data["section_name"] . '/forum/index/' . $language_code, lang('back-to-category'), 'title="' . lang('back-to-category') . '" class="add-link" '); ?>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Input Fields</h4>
        </div>

        <?php
        $attributes = array('name' => 'add_forum_form', 'id' => 'add_forum_form', "class" => 'form-horizontal form-bordered');
        echo form_open('', $attributes);
        ?>

        <div class="panel-body panel-body-nopadding">

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('forum_title'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $title_data = array(
                        'name' => 'forum_title',
                        'id' => 'forum_title',
                        'value' => set_value('forum_title', ((isset($forum_name)) ? $forum_name : '')),
                        'class' => "form-control"
                    );
                    echo form_input($title_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('forum_title'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('slug_url'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $slug_url_data = array(
                        'name' => 'slug_url',
                        'id' => 'slug_url',
                        'value' => set_value('slug_url', ((isset($slug_url)) ? $slug_url : '')),
                        'class' => "form-control"
                    );
                    echo form_input($slug_url_data);
                    ?>
                    <span class="warning-msg"><?php echo form_error('slug_url'); ?></span>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('forum_description'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-9">
                    <?php
                    $description_data = array(
                        'name' => 'forum_description',
                        'id' => 'forum_description',
                        'value' => set_value('forum_description', ((isset($forum_description)) ? html_entity_decode($forum_description) : '')),
                        'class' => 'form-control'
                    );
                    echo form_textarea($description_data);
                    ?>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('category'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    $statuslist = array();
                    $statuslist_value = array();

                    foreach ($categories as $category) {
                        $statuslist_cat[$category["categories"]["category_id"]] = $category["categories"]["title"];
                        $statuslist_cat_value = $category["categories"]["category_id"];
                    }

                    if (!isset($forum_category)) {
                        $forum_category = "";
                    }

                    echo form_dropdown('forum_category', $statuslist_cat, $forum_category, set_value($statuslist_cat_value) . ' class = "form-control" ');
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo lang('is_private'); ?>
                    <span class="asterisk">*</span>
                </label>

                <div class="col-sm-6">
                    <?php
                    if (isset($is_private) && $is_private == 1) {
                        $yes = TRUE;
                        $no = "";
                    } else {
                        $no = TRUE;
                        $yes = "";
                    }
                    ?>

                    <div class="radio">
                        <label>
                            <?php echo form_radio('is_private', '1', $yes); ?> Yes
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <?php echo form_radio('is_private', '0', $no); ?> No
                        </label>
                    </div>
                </div>
            </div>

            <?php
            if (isset($id) && $id != "" && $id != 0) {
                $statuslist = array('2' => 'Inactive', '1' => 'Active');
                ?>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo lang('status'); ?>
                        <span class="asterisk">*</span>
                    </label>

                    <div class="col-sm-6">
                        <?php
                        echo form_dropdown('status', $statuslist, $status, 'class = "form-control" ');
                        ?>

                    </div>
                </div>

            <?php } ?>

        </div>

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
                        'name' => 'cancel',
                        'value' => lang('btn-cancel'),
                        'title' => lang('btn-cancel'),
                        'class' => 'btn btn-default',
                        'content' => '<i class="fa fa-hand-o-left"></i> &nbsp; ' . lang('btn-cancel'),
                        'onclick' => "location.href='" . site_url($this->_data["section_name"] . '/forum') . "'",
                    );
                    echo "&nbsp;&nbsp;";
                    echo form_button($cancel_button);

                    echo form_hidden('id', (isset($id)) ? $id : '0' );
                    ?>
                </div>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<?php
echo add_css(array('bootstrap-wysihtml5'));
echo add_js(array('wysihtml5-0.3.0.min', 'bootstrap-wysihtml5',));
?>
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>

<script>
    jQuery(document).ready(function() {
        
        load_form = function(lang_code) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url().$this->_data["section_name"]; ?>/forum/action/<?php echo $action; ?>/0/'+lang_code+'/<?php
            if (isset($id)) {
                echo $id;
            } else {
                echo "0";
            }
            ?>',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
                success: function(msg) {
                    $("#ajax_table").html(msg);
                }
            });
        };
        
        
        jQuery('#forum_description').wysihtml5({color: true, html: true});
        $('#slug_url').slugify('#forum_title');

        $('#add_forum_form').bootstrapValidator({
            fields: {
                forum_title: {
                    validators: {
                        notEmpty: {
                            message: 'The Forum Title field is required.'
                        }
                    }
                },
                slug_url: {
                    validators: {
                        notEmpty: {
                            message: 'The Slug URL field is required.'
                        }
                    }
                }
            }
        });
    });

    function attach_error_event() {
        $('div.formError').bind('click', function() {
            $(this).fadeOut(1000, removeError);
        });
    }
    function removeError() {
        jQuery(this).remove();
    }
</script>
