<tr class="content">
    <td><?php //pr($cms);     ?>
        <table cellspacing="0" cellpadding="0">
            <td class="content-left" valign="top" style="width: 705px;" id="ajax_table"></td>
            <td width="10">&nbsp;</td>
            <td class="content-right" valign="top">
                <table>
                    <tr>
                        <td>
                            <h2 style=" font-size: 24px;margin-bottom: 8px;">Category
                            </h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #999999;">
                            <?php
                            //pre($categorylist);
                            foreach ($categorylist as $category) {
                                ?>
                                <input type="checkbox" class="category" name="category" value="<?php echo $category['category_id']; ?>" /><span><?php echo $category['title']; ?></span><br />
                                <?php
                            }
                            ?>
                        </td>											
                    </tr>
                </table>
                <br />
                <br />
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </td>		
        </table>
    </td>
</tr>

<script type="text/javascript">
    //remove dynamically populate error
    function attach_error_event(){
        $('div.formError').bind('click',function(){
            $(this).fadeOut(1000, removeError); 
        });
    }    
    function removeError() 
    {
        jQuery(this).remove();
    }

    function sort_data(sort_by,sort_order,category)
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>blog/ajax_layout/',
            data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',sort_by:sort_by,sort_order:sort_order,category:category},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        });    
    }
	
</script>
<script type="text/javascript">
    $(document).ready(function(){
        sort_data()	;

        $(function(){
            $('.category').click(function(){
                var val ="";
                $('.category:checkbox:checked').each(function(i){
                    val= val+','+$(this).val();
			  
                });
                sort_data("","",val);
			   
            });
        });

		

    });
</script>

