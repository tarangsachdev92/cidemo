<div class="main-container">
    <div class="grid-data grid-data-table">
        <div class="add-new">
            <span style="float: left;"><?php echo add_image(array('active.png')) . ' ' . lang('active') . ' ' . add_image(array('inactive.png')) . ' ' . lang('inactive'); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <a onclick="openlink('add')" style="text-align:center;width:100%;" title="<?php echo lang('add_product_image'); ?>" href="#"><?php echo lang('add_product_image'); ?></a> | <a href="<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/products" ><?php echo lang('back'); ?></a>
        </div>
        <div class="menu-content-box">
            <!-- load your ajax content here -->
        </div>
    </div>
</div>

<script type="text/javascript">

                $(document).ready(function()
                {
                    openlink = function(type) {
                        location.href = "<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/action_image/add/<?php echo $product_id ?>";
                    }

                    delete_product_image = function(id)
                    {
                        res = confirm('<?php echo lang('delete_confirm') ?>');
                        if (res)
                        {
                            blockUI();
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/delete_product_image',
                                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>', id: id},
                                error: function() {
                                    alert("Server problem. Please try again.");
                                    return false;
                                },
                                complete: function() {
                                    unblockUI();
                                },
                                success: function(data) {
                                    load_ajax_index(<?php echo $product_id; ?>);
                                    // show success message
                                    //unblockUI();
                                    $("#messages").show();
                                    $("#messages").html(data);
                                }
                            });
                        }
                        else
                        {
                            return false;
                        }
                    }

                    load_ajax_index = function()
                    {
                        blockUI();
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_images/<?php echo $product_id; ?>',
                            data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
                            error: function() {
                                alert("Server problem. Please try again.");
                                return false;
                            },
                            complete: function() {
                                unblockUI();
                            },
                            success: function(data) {
                                if (data == '') {
                                    $(".menu-content-box").hide();
                                } else {
                                    $(".menu-content-box").html(data);
                                    $(".menu-content-box").show();
                                }

                            }
                        });
                    }
                    load_ajax_index();
                });
</script>