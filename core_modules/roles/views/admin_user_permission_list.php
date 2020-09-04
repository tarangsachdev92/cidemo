<div class="main-container">
  <div id="success_msg" style="display: none;" class="msg-content-box" onclick="hide_msg();">
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <?php echo lang('permission-update-success'); ?>
        </div>
    </div>
    <div class="grid-data grid-data-table">
        <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
            <?php echo form_open(); ?>
            <tbody bgcolor="#ffffff">
                <?php
                if(is_array($matrix_permissions))
                {

                ?>
                <tr>
                    <td colspan="8">
                        <?php
                        $check_button = array(
                            'content' => lang('check-all'),
                            'title' => lang('check-all'),
                            'class' => 'inputbutton',
                            'onclick' => "check_all()",
                        );
                        echo form_button($check_button);
                        ?>
                        <?php
                        $uncheck_button = array(
                            'content' => lang('uncheck-all'),
                            'title' => lang('uncheck-all'),
                            'class' => 'inputbutton',
                            'onclick' => "uncheck_all()",
                        );
                        echo form_button($uncheck_button);
                        ?>
                        <?php
                        $save_button = array(
                            'content' => lang('btn-save'),
                            'title' => lang('btn-save'),
                            'class' => 'inputbutton',
                            'onclick' => "save_records('$user_id')",
                        );
                        echo form_button($save_button);
                        ?>
                        <?php
                        $delete_button = array(
                            'content' => lang('delete-user-permission'),
                            'title' => lang('delete-user-permission'),
                            'class' => 'inputbutton',
                            'onclick' => "delete_permissions('$user_id')",
                        );
                        echo form_button($delete_button);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo lang('permissions') ?></th>
                    <th><?php echo lang('permissions') ?></th>
                </tr>
                <?php
                $j = 1;
                foreach ($matrix_permissions as $matrix_permission)
                {
                    if ($matrix_permission['parent_id'] != 0)
                    {
                        $class = "odd-row";
                    }
                    else
                    {
                        $class = "even-row";
                    }
                    ?>
                    <tr class="<?php echo $class; ?>">
                        <td><?php
                if ($matrix_permission['parent_id'] == 0)
                {
                    echo $matrix_permission['permission_title'];
                }
                else
                {
                    echo "&nbsp;&nbsp;&nbsp;" . $matrix_permission['permission_title'];
                }
                    ?></td>
                        <?php
                        $checkbox_value = $user_id . ',' . $matrix_permission['id'];
                        $checked = '';
                        if (!empty($matrix_user_permissions))
                        {
                            $checked = in_array($checkbox_value, $matrix_user_permissions) ? ' "checked"' : '';
                        }
                        if ($checked != '')
                        {
                            $delete = 1;
                        }
                        else
                        {
                            $delete = 0;
                        }
                        ?>
                        <?php
                        $permission_id = $matrix_permission['id'];
                        $check_box = array(
                            'value' => $permission_id,
                            'checked' => $checked,
                            'class' => 'check_box',
                        );
                        ?>
                        <td class="text-center">
                            <?php echo form_checkbox($check_box); ?>
                        </td>
                    </tr>
                    <?php
                    $j++;
                }
                ?>
                    <tr>
                    <td colspan="8">
                        <?php
                        $check_button = array(
                            'content' => lang('check-all'),
                            'title' => lang('check-all'),
                            'class' => 'inputbutton',
                            'onclick' => "check_all()",
                        );
                        echo form_button($check_button);
                        ?>
                        <?php
                        $uncheck_button = array(
                            'content' => lang('uncheck-all'),
                            'title' => lang('uncheck-all'),
                            'class' => 'inputbutton',
                            'onclick' => "uncheck_all()",
                        );
                        echo form_button($uncheck_button);
                        ?>
                        <?php
                        $save_button = array(
                            'content' => lang('btn-save'),
                            'title' => lang('btn-save'),
                            'class' => 'inputbutton',
                            'onclick' => "save_records('$user_id')",
                        );
                        echo form_button($save_button);
                        ?>
                        <?php
                        $delete_button = array(
                            'content' => lang('delete-user-permission'),
                            'title' => lang('delete-user-permission'),
                            'class' => 'inputbutton',
                            'onclick' => "delete_permissions('$user_id')",
                        );
                        echo form_button($delete_button);
                        ?>
                    </td>
                </tr>
                 <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td><?php echo lang('ci_model_no_data');?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <?php
            $querystr =  $this->theme->ci()->security->get_csrf_token_name() . '=' . urlencode($this->theme->ci()->security->get_csrf_hash());
            ?>
            <?php echo form_close(); ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    //Function check_all to check all checkbox
    function check_all()
    {
        $(".check_box").prop("checked", true);
    }

    //Function uncheck_all to uncheck all checkbox
    function uncheck_all()
    {
        $(".check_box").prop("checked", false);
    }

    //Function save_records to save all permissions
    function save_records(user_id)
    {
        var val = [];
        $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();
        });

        $.ajax({
            type:'POST',
            url: '<?php echo base_url().get_current_section($this); ?>/roles/update_user_permission',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>:'<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',user_id:'<?php echo $user_id; ?>',permission_id:val},
            success: function (data) {
                ajaxLink('<?php echo base_url().get_current_section($this); ?>/roles/user_permission_matrix/'+user_id,'ajax_table','<?php echo $querystr; ?>');
				$("#success_msg").show();	
            }
        });
    }

    //Function to delete userwise matrix permission
    function delete_permissions(user_id){
        blockUI();
        $.ajax({
            type:'POST',
            url:'<?php echo base_url().get_current_section($this); ?>/roles/delete_user_permission',
            data:{<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>:'<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',user_id:user_id},
            success: function(data) {
               // location.reload();
                unblockUI();
				$("#success_msg").show();
				$('input:checkbox').removeAttr('checked');
            }
        });
    }
	function hide_msg(){
        $('#success_msg').hide();
    }
</script>
