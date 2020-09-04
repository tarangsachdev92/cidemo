<div id="ajax_table">
    <div class="main-container">
        <div class="search-box">
            <table cellspacing="2" cellpadding="4" border="0">
                <tbody>
                    <tr>
                        <td align="right"><?php echo lang('select_category') ?> :</td>
                        <td align="left">                       
                         <?php                        
                            $options = array(
                                'name' => 'category_id',
                                'id' => 'category_id',
                                'value' =>(isset($search_category)) ? $search_category : '',
                                'language_id' => $language_id,
                                'module_id' => PRODUCT_MODULE_NO ,
                                'first_option' => 'Please select',                              
                            );
                            widget('category_dropdown', $options);
                            ?>
                            <span style="padding-left: 10px;">
                                <?php
                                $search_button = array(
                                    'content' => lang('btn-search'),
                                    'title' => lang('btn-search'),
                                    'class' => 'inputbutton',
                                    'onclick' => "submit_search()",
                                );
                                echo form_button($search_button);
                                ?>
                            </span>
                            <span  style="padding-left: 10px;">
                                <?php
                                $reset_button = array(
                                    'content' => lang('btn-reset'),
                                    'title' => lang('btn-reset'),
                                    'class' => 'inputbutton',
                                    'onclick' => "reset_data()",
                                );
                                echo form_button($reset_button);
                                ?>
                            </span>
                        </td>
                        
                    </tr>

                </tbody>
            </table>
        </div>
        <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
            <tbody bgcolor="#fff">
            <tr>    
            <?php
            
            $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_name=' . urlencode($search_name) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order  ;
            if (count($list) > 0)
            {
                $i = 1;
                foreach ($list as $page)
                {
                    ?>
                    <td class="content" valign="top" >
                    <div class="prdimg_div" style="box-shadow:2px 0px 4px 1px #CCCCCC;">
                    <table>
                        <tr>
                            <td align="center">
                                <div class="prdimg_div" style="width:190px;height:170px;">
                            <?php 
                                $product_image  = 'no_image.jpg';
                                if($page['p']['product_image']!='') {
                                    if(file_exists(FCPATH.'assets/uploads/products/thumbs/'.$page['p']['product_image'])) { 
                                        $product_image  = $page['p']['product_image'];
                                    }
                                }
                                // echo $image_path.'shoppingcart/'.$product_image.'<br>';
                            ?>
                                    <a href="<?php echo site_url(); ?>products/view/<?php echo $page['l']['language_code'] . "/" . $page['p']['product_id']; ?>"><img src="<?php  echo base_url() . "assets/uploads/products/thumbs/".$product_image; ?>" border="0" ></a>
                               </div>         
                            </td>
                        </tr>
                        <tr><td align="center"><a href="<?php echo site_url(); ?>products/view/<?php echo $page['l']['language_code'] . "/" . $page['p']['product_id']; ?>" style="text-decoration:none;"><?php echo $page['p']['name']; ?> </a></td></tr>
                        
                        
                        
                    </table>
                    </div>    
                </td>
                <?php  if( $i % 5 == 0) {
                    echo '</tr><tr>';
                        }
                            $i++;
                    } 
                ?>
            </tr>   
                </tbody>
            </table>
            <?php
            $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url() . "products/ajax_index/" . $language_code,
                'params' => $querystr,
                'element' => 'ajax_table'
            );
            widget('custom_pagination', $options);
        }
        else
        {
            ?>
            <table>
                <tr><td colspan="6"><?php echo lang('no_record_found'); ?></td></tr>
            </table>
            <?php
        }
        ?>
    </div>
</div>
<script>
    function submit_search()
    {       
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>products/ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', category_id:$('#category_id').val()},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        });
        unblockUI();
    }
    
    function reset_data()
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        $.ajax({
            type:'POST',
            url: '<?php echo base_url(); ?>products/ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', category_id:""},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        });
    }
    
    function change_search(id)
    {
        $("#search_options div").hide();
        var value = $("#search_"+id).val();
        $("#search_options .search").val("");
        $("#search_"+id).val(value);
        $("#"+id).show();
    }
    change_search($("#search").val());
    
    
</script>