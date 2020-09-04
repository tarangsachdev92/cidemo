<?php echo add_css('validationEngine.jquery'); ?>
<?php echo add_js(array('jquery-1.9.1.min', 'jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<?php echo add_js('jquery.slugify'); ?>
<div class="main-content">
    <div class="grid-data info-content">
        <div class="add-new">
            <?php echo anchor(site_url() . $this->_data['section_name'] . '/shoppingcart/images/' . $product_id, lang('product_images'), 'title="View All Product Images" style="text-align:center;width:100%;"'); ?>
        </div>
        <div class="profile-content-box" id="form">
            <!-- Form will come here -->
            <?php echo $content; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        load_form = function(lang_code) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_action_image/<?php echo $action; ?>/<?php echo $product_id ?>/<?php echo $id; ?>',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
                success: function(msg) {
                    $("#form").html(msg);
                }
            });
        }

    });
</script>