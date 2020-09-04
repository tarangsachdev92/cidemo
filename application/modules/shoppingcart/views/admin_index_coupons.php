<div class="main-container">
    <div class="grid-data grid-data-table">        
        <div class="add-new">
            <span style="float: left;"><?php echo add_image(array('active.png')) . ' ' . lang('active') . ' ' . add_image(array('inactive.png')) . ' ' . lang('inactive'); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <a onclick="openlink('add')" style="text-align:center;width:100%;" title="<?php echo lang('add_coupon'); ?>" href="#"><?php echo lang('add_coupon'); ?></a>
        </div>        
        <div class="menu-content-box">
            <!-- load your ajax content here -->
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
        load_ajax_index(lang_code);
    });

    openlink = function(type) {
        lang_code = $(".tab-headings li.selected a").attr('title');
        location.href = "<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/action_coupon/add";
    }

    delete_coupon = function(id)
    {
        res = confirm('<?php echo lang('delete_alert') ?>');
        if (res) {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/delete_coupon',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>', id: id},
                error: function() {
                    alert("Server problem. Please try again.");
                    return false;
                },
                complete: function() {
                    unblockUI();
                },
                success: function(data) {
                    lang_code = $(".tab-headings li.selected a").attr('title');
                    load_ajax_coupons();
                    // show success message
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

    load_ajax_coupons = function() {
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/shoppingcart/ajax_coupons/',
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

    load_ajax_coupons();
});
</script>