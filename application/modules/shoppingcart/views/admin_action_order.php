<?php echo add_css('validationEngine.jquery'); ?>
<?php echo add_js(array('jquery-1.9.1.min', 'jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<div class="main-content">
    <div class="grid-data info-content">
        <div class="add-new">
            <?php echo anchor(site_url() . $this->_data['section_name'] . '/shoppingcart/orders', lang('view_all_orders'), 'title="View All Orders" style="text-align:center;width:100%;"'); ?>
        </div>
        <div class="profile-content-box" id="shoppingcart_orders_form">
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
            load_form();
        });
        load_form = function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_action_order/<?php echo $action; ?>/<?php echo $id; ?>',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
                success: function(msg) {
                    $("#shoppingcart_orders_form").html(msg);
                }
            });
        }

    });
</script>