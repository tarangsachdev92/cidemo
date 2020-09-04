<div class="contentpanel">
    <div class="panel panel-default form-panel">
       
    </div>
    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">

                <!--                <h3 class="mb15">Table With Actions</h3>-->

                <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>

                <a class="add-link" href="<?php echo site_url() .get_current_section($this) . '/languages/action/add' ?>">Add Language</a>
            </div>
            <div class="panel table-panel">
                <div class="panel-body">
                   <?php
            if (!empty($languages)) {
                ?>
                     <?php echo form_open_multipart(get_current_section($this) . '/languages/default_save', array('id' => 'default_save', 'name' => 'default_save')); ?>
                        <div class="table-responsive">          		
                            <table class="table table-hover gradienttable">
                                <thead>
                                    <tr>
                                      
                                <th class="t-center"><?php echo lang('languages-no'); ?></th>
                                <th>
                                    
                                <?php
                                $field_sort_order = 'asc';
                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                if ($sort_by == 'l.language_name' && $sort_order == 'asc') {
                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                    $field_sort_order = 'desc';
                                }
                                ?>
                                <a href="javascript:;" onclick="sort_data('l.language_name', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Language Name">
                                    <?php echo lang('languages-name'); ?>
                                    <?php
                                    if ($sort_by == 'l.language_name') {
                                         echo $sort_image;
                                    }
                                        ?></a>
                                </th>

                                <th class="t-center">
                                    <?php
                                $field_sort_order = 'asc';
                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                if ($sort_by == 'l.language_code' && $sort_order == 'asc') {
                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                    $field_sort_order = 'desc';
                                }
                                ?>
                                <a href="javascript:;" onclick="sort_data('l.language_code', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Language Code">
                                    <?php echo lang('languages-code'); ?>
                                    <?php
                                    if ($sort_by == 'l.language_code') {
                                         echo $sort_image;
                                        }
                                    ?>
                                </a>
                                </th>
                                <th class="t-center">
                                    <?php echo lang('languages-direction'); ?>
                                </th>
                                
                                <th class="t-center">Permission</th>
                                <th class="t-center">
                                      <?php
                                $field_sort_order = 'asc';
                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                if ($sort_by == 'l.status' && $sort_order == 'asc')
                                {
                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                    $field_sort_order = 'desc';
                                }
                                ?>
                                <a href="#" onclick="sort_data('l.status', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Language Status" ><?php echo lang('languages-status'); ?></a>
                                <?php
                                    if ($sort_by == 'l.status')
                                    {
                                        echo $sort_image;
                                        
                                    }
                                    ?></a>

                                </th>
                                <th class="t-center"><?php echo lang('languages-action'); ?></th>

                                </tr>
                                

                                </thead>
                                <tbody>

                                   <?php
                        if ($page_number > 1)
                        {
                            $i = ($this->session->userdata[get_current_section($this)]['record_per_page'] * ($page_number - 1)) + 1;
                        }
                        else
                        {
                            $i = 1;
                        }


                        foreach ($languages as $key => &$data) {
                            //take alias from an array
                            $alias = end(array_keys($data));

                            if ($i % 2 != 0) {
                                $class = "odd-row";
                            } else {
                                $class = "even-row";
                            }
                            ?>

                                        <tr>
                                            
                                            <td class="t-center"><?php echo $i; ?></td>
                                            <td><?php echo $data[$alias]['language_name']; ?></td>
                                            <td class="t-center"><?php echo $data[$alias]['language_code']; ?></td>
                                            <td class="t-center"><?php echo ($data[$alias]['direction'] == 'ltr') ? 'Left' : 'Right'; ?></td>
                                          
                                            <td class="t-center">
                                                <?php
                                    //echo ($data[$alias]['default'] == '1') ? 'Yes' : 'No';

                                    // Set Deault from listing starts
                                    $checked = '';
                                    $value_chkbox = $data[$alias]['id'];
                                    if ($data[$alias]['default'] == '1') {
                                        $checked = 'checked="checked"';
                                    }


                                    //echo '&nbsp;&nbsp;&nbsp;';

                                    if ($data[$alias]['status'] == 1) {
                                        //echo "IF";
                                        echo form_radio('chk_default', $value_chkbox, $checked);
                                    } else {
                                        //echo "NOHTING TO DO HERE";
                                    }

                                    // Set Deault from listing ends
                                    ?>
                                            </td>
                                            <td class="t-center">
                                                <?php
                            if ($data[$alias]['status'] == 1) {
                                echo add_image(array('active.png'), '', '', array('title' => 'active', 'alt' => "active"));
                            } else {
                                echo add_image(array('inactive.png'), '', '', array('title' => 'inactive', 'alt' => "inactive"));
                            }
                                    ?>
                                            </td>
                                           
                                            <td class="t-center">

                                                <a class="mr5" href="<?php echo site_url() . get_current_section($this); ?>/languages/view_data/<?php echo $data[$alias]['id'] ?>" title="<?php echo lang('view'); ?>" ><i class="fa fa-eye"></i></a>

                                                <a class="mr5" href="<?php echo base_url() . get_current_section($this) . '/languages/action/edit/' . $data[$alias]['id']; ?>" title="<?php echo lang('edit'); ?>"><i class="fa fa-pencil"></i></a>

                                            <?php if($data[$alias]['default'] != '1'){ ?>
                                                    <a class="delete-row" href="javascript:;" title="<?php echo lang('languages-delete') ?>" onclick=" delete_language(<?php echo $data[$alias]['id'] ?>);" title="<?php echo lang('delete'); ?>"><i class="fa fa-trash-o"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>

                                </tbody>
                            </table>

                        </div>

                        <div class="btn-panel mb15">
                            <?php
                         $submit_button = array(
                        'name' => 'mysubmit',
                        'id' => 'mysubmit',
                        'value' => 'Default',
                        'title' => lang('btn-default'),
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'content' => '<i class="fa fa-save"></i> &nbsp; Default',
                    );
                    echo form_button($submit_button);
                    ?>  </div>

                        <?php
                    } else {
                        echo 'No Record(s) Found';
                    }
                    ?>
                      <?php echo form_close();  //you can add form tag here    ?>
                    <?php
                    $querystr = $this->theme->ci()->security->get_csrf_token_name() . '=' . urlencode($this->theme->ci()->security->get_csrf_hash()) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
                    $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url() . get_current_section($this) . "/languages/index",
                'params' => $querystr,
                'element' => 'ajax_table'
            );
            widget('custom_pagination', $options);
            ?>

                </div>
            </div>
        </div><!-- col-md-6 -->
    </div>
</div>


 <script type="text/javascript">
        function delete_language(id){
            res = confirm('<?php echo lang('confirm-delete-msg'); ?>');
            if(res){
                blockUI();
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url() . get_current_section($this); ?>/languages/delete',
                    data:{<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>:'<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',id:id},
                    success: function() {
                        location.href= "<?php echo base_url() . get_current_section($this); ?>/languages/index";
                        unblockUI();
                    }
                });
            }else{
                return false;
            }
        }

        function sort_data(sort_by,sort_order)
        {
            $('#error_msg').fadeOut(1000); //hide error message it shown up while search
            blockUI('removeError');
            $.ajax({
                type:'POST',
                url:'<?php echo base_url() . get_current_section($this); ?>/languages/index',
                data:{<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>:'<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',sort_by:sort_by,sort_order:sort_order},
                success: function(data) {
                    $("#ajax_table").html(data);
                    unblockUI();
                }
            });
        }
        
        $(document).ajaxComplete(function() {
        // Chosen Select
        jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
    });

    </script>

