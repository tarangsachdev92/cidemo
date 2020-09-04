<?php echo add_css('validationEngine.jquery'); ?>
<?php echo add_js(array('jquery-1.9.1.min', 'jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<?php echo add_js('jquery.slugify'); ?>
<div class="main-content">
    <div class="grid-data info-content">
       
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
            url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_action/<?php echo $action; ?>/<?php echo $product_id ?>/<?php echo $id; ?>',
            data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},

            success: function(msg) {
                $("#form").html(msg);
            }
        });
        }

    });

</script><!--Accordion Jquery -->