<div class="main-container">
    <div class="grid-data grid-data-table">
        

        <div class="menu-content-box">
            <!-- load your ajax content here -->
        </div>

    </div>
</div>
<script type="text/javascript">
<?php
        if(isset($this->_ci->session->userdata[$this->_data['section_name']]["search"])){                    
        $search = $this->_ci->session->userdata[$this->_data['section_name']]["search"]; 
        }
       
        if(isset($this->_ci->session->userdata[$this->_data['section_name']]["search_status"])){
        $search_status=$this->_ci->session->userdata[$this->_data['section_name']]["search_status"];  
        }
?>
    $(document).ready(function() {


        openlink = function(type){
            location.href= "<?php echo base_url().$this->_data['section_name']; ?>/products/image_action/add/<?php echo $product_id ?>";
        }

        delete_product_image = function(id)
        {
            res = confirm('<?php echo lang('delete_confirm') ?>');

            if(res){
                blockUI();
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url().$this->_data['section_name']; ?>/products/delete_product_image',
                    data:{<?php echo $csrf_token; ?>:'<?php echo $csrf_hash; ?>',id:id},
                    success: function(data) {
                        load_ajax_index(<?php echo $product_id; ?>);
                        // show success message
                        //unblockUI();
                        $("#messages").show();
                        $("#messages").html(data);
                    }
                });

            }else{
                return false;
            }
        }

        load_ajax_index = function() {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id ; ?>' ,
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>',search:'<?php echo isset($search)?$search:'select'; ?>',search_status:'<?php echo isset($search_status)?$search_status:''; ?>'},
                success: function(data) {
                    if (data == '') {
                        $(".menu-content-box").hide();
                    } else {
                        $(".menu-content-box").html(data);
                        $(".menu-content-box").show();
                    }
                    unblockUI();
                }
            });

        }
        load_ajax_index();
    });
</script><!--Accordion Jquery -->