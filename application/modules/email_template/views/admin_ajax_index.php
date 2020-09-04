<div id="contentpanel">
    <div class="contentpanel">        
        <div class="panel panel-default form-panel">
            <div class="panel-body">
                <form>           
                    <div class="row row-pad-5"> 
                        <div class="col-lg-3 col-md-3">
                            <?php
                            $input_data = array(
                                'name' => 'search_term',
                                'id' => 'search_term',
                                'title' => 'search',
                                'class' => 'form-control',
                                'placeholder' => lang('search-by-title'),
                                'value' => set_value('search_term', urldecode($search_term))
                            );
                            echo form_input($input_data);
                            ?>
                        </div>               
                        <div class="col-lg-3 col-md-3">
                            <?php
                            $search_button = array(
                                'content' => '<i class="fa fa-search"></i> &nbsp;&nbsp;'.lang('btn-search'),
                                'title' => lang('btn-search'),
                                'class' => 'btn btn-primary',
                                'onclick' => "submit_search()",
                            );
                            echo form_button($search_button);
                            ?>
                            <!--                        <button class="btn btn-primary">Search</button>-->

                            <?php
                            $reset_button = array(
                                'content' => '<i class="fa fa-refresh"></i> &nbsp;&nbsp;'.lang('reset_button'),
                                'title' => lang('reset_button'),
                                'class' => 'btn btn-default btn-reset',
                                'onclick' => "reset_data()",
                                "type" => "reset"
                            );
                            echo form_button($reset_button);
                            ?>
                        </div>
                    </div>  
                </form>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-12">

                <div class="panel-header clearfix">

                    <!--                <h3 class="mb15">Table With Actions</h3>-->

                    <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>

                    <a onclick="openlink('add')" class="add-link" title="<?php echo lang('add_template'); ?>" href="javascript:;"><?php echo lang('add_template'); ?></a>

                </div>


                <div class="panel table-panel">
                    <div class="panel-body">

                        <?php
                        $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';

                        if (count($email_template_list) > 0) {
                            ?>

                            <div class="table-responsive">          		
                                <table class="table table-hover gradienttable">
                                    <thead>
                                        <tr>
                                            <th>
                                    <div class="ckbox ckbox-default">
                                        <input type="checkbox" name="check_all" id="check_all" value="0" />
                                        <label for="check_all"></label>
                                    </div>
                                    </th>
                                    <th class="t-center"><?php echo lang('sr_no'); ?></th>
                                    <th>

                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'c.template_name' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('c.template_name', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Template Name"><?php echo lang('template-name'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'c.template_name') {
                                                echo $sort_image;
                                            }
                                            ?></a>

                                    </th>
                                    <th class="t-center">
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'c.status' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('c.status', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Status"><?php echo lang('status'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'c.status') {
                                            echo $sort_image;
                                        }
                                        ?></a>
                                    </th>
                                    <th class="t-center">
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'c.modified' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>
                                        <a href="javascript:;" onclick="sort_data('c.modified', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Last Modified"><?php echo lang('last_modified'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'c.modified') {
                                            echo $sort_image;
                                        }
                                        ?></a>
                                    </th>
                                    <th class="t-center"><?php echo lang('actions'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($page_number > 1) {
                                            $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page'] * ($page_number - 1)) + 1;
                                        } else {
                                            $i = 1;
                                        }
                                        foreach ($email_template_list as $template) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="ckbox ckbox-default">
                                                        <input type="checkbox" id="<?php echo $template['c']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $template['c']['id']; ?>">
                                                        <label for="<?php echo $template['c']['id']; ?>"></label>

                                                    </div>
                                                </td>
                                                <td class="t-center"><?php echo $i; ?></td>
                                                <td>
                                                    <?php echo $template['c']['template_name']; ?>
                                                </td>

                                                <td class="t-center">
                                                    <?php
                                                    if ($template['c']['status'] == '1') {
                                                        ?>
            <?php echo add_image(array('active.png'), "", "", array("title" => "active")); ?>
            <?php
        } elseif ($template['c']['status'] == '0') {
            ?>
            <?php echo add_image(array('inactive.png'), "", "", array("title" => "inactive")); ?>
        <?php } ?>
                                                </td>

                                                <td class="t-center"><?php echo $template['c']['modified']; ?></td>


                                                <td class="t-center">

                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/email_template/view/<?php echo $template['l']['language_code'] . "/" . $template['c']['template_id']; ?>" title="View Email Template"><i class="fa fa-eye"></i></a>

                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/email_template/action/edit/<?php echo $template['l']['language_code'] . "/" . $template['c']['template_id']; ?>" title="Edit Email Template"><i class="fa fa-pencil"></i></a>

                                                    <a class="delete-row" href="javascript:;" onclick="delete_cms('<?php echo $template['c']['id']; ?>')" title="Delete Email Template"><i class="fa fa-trash-o"></i></a>

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
                                <button onclick="delete_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-trash-o"></i></span>Delete</button>
                                <button onclick="active_records()" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active</button>
                                <button onclick="inactive_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>In Active</button>
                                <button onclick="active_all_records()" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active All</button>
                                <button onclick="inactive_all_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>Inactive All</button>
                            </div>

                            <?php
                        } else {
                            echo 'No Record(s) Found';
                        }
                        ?>


                        <?php
                       
                        $options = array(
                            'total_records' => $total_records,
                            'page_number' => $page_number,
                            'isAjaxRequest' => 1,
                            'base_url' => base_url() . $this->_data['section_name'] . "/email_template/ajax_index/" . $language_code,
                            'params' => $querystr,
                            'element' => 'contentpanel'
                        );
                        widget('custom_pagination', $options);
                        ?>
                    </div>
                </div>
            </div><!-- col-md-6 -->
        </div>
    </div>
</div>


<script>
    $("#search_term").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    function submit_search()
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        /*if($('#search_term').val() == ''){
         $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
         attach_error_event(); //for remove dynamically populate popup
         return false;
         } */
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index/<?php echo $language_code; ?>',
                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val())},
                        success: function(data) {
                            // $("#ajax_table").html(data);
                            $("#contentpanel").html(data);
                        }
                    });
                    unblockUI();
                }
                function sort_data(sort_by, sort_order)
                {
                    blockUI();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val()), sort_by: sort_by, sort_order: sort_order},
                                    success: function(data) {
                                        $("#contentpanel").html(data);
                                    }
                                });
                                unblockUI();
                            }
                            function reset_data()
                            {
                                $('#error_msg').fadeOut(1000); //hide error message it shown up while search
                                blockUI();
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index/<?php echo $language_code; ?>',
                                                data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: ""},
                                                success: function(data) {
                                                    $("#contentpanel").html(data);
                                                    unblockUI();
                                                }
                                            });
                                        }

                                        $(function() {
                                            $("#check_all").click(function() {
                                                if ($("#check_all").is(':checked')) {
                                                    $(".check_box").prop("checked", true);
                                                } else {
                                                    $(".check_box").prop("checked", false);
                                                }
                                            });
                                            $(".check_box").click(function() {

                                                if ($(".check_box").length == $(".check_box:checked").length) {
                                                    $("#check_all").prop("checked", true);
                                                    $(".check_box").attr("checked", "checked");
                                                } else {
                                                    $("#check_all").removeAttr("checked");
                                                }

                                            });
                                        });

                                        function active_records()
                                        {

                                            var val = [];
                                            $(':checkbox:checked').each(function(i) {
                                                val[i] = $(this).val();
                                            });
                                            if (val == "")
                                            {
                                                alert('Please select at least one record for active');
                                                return false;
                                            }
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index/<?php echo $language_code; ?>',
                                                            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', type: 'active', ids: val},
                                                            success: function(data) {
                                                                //for managing same state while record delete
                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                                                                $("#messages").show();
                                                                                $("#messages").html(data);
                                                                            }
                                                                        });
                                                                    }

                                                                    function inactive_records()
                                                                    {
                                                                        var val = [];
                                                                        $(':checkbox:checked').each(function(i) {
                                                                            val[i] = $(this).val();
                                                                        });
                                                                        if (val == "")
                                                                        {
                                                                            alert('Please select at least one record for inactive');
                                                                            return false;
                                                                        }
                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: '<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index',
                                                                            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val},
                                                                            success: function(data) {
                                                                                //for managing same state while record delete
                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                $("#messages").show();
                                                                                                $("#messages").html(data);
                                                                                            }
                                                                                        });
                                                                                    }
                                                                                    function active_all_records()
                                                                                    {
                                                                                        $.ajax({
                                                                                            type: 'POST',
                                                                                            url: '<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index',
                                                                                            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all', lang: '<?php echo $language_id ?>'},
                                                                                            success: function(data) {
                                                                                                //for managing same state while record delete
                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                $("#messages").show();
                                                                                                                $("#messages").html(data);
                                                                                                            }
                                                                                                        });
                                                                                                    }

                                                                                                    function inactive_all_records()
                                                                                                    {
                                                                                                        $.ajax({
                                                                                                            type: 'POST',
                                                                                                            url: '<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index',
                                                                                                            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all', lang: '<?php echo $language_id ?>'},
                                                                                                            success: function(data) {
                                                                                                                //for managing same state while record delete
                                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                $("#messages").show();
                                                                                                                                $("#messages").html(data);
                                                                                                                            }
                                                                                                                        });
                                                                                                                    }

                                                                                                                    function delete_user(id) {
                                                                                                                        res = confirm('<?php echo lang('delete-alert') ?>');
                                                                                                                        if (res) {
                                                                                                                            $.ajax({
                                                                                                                                type: 'POST',
                                                                                                                                url: '<?php echo base_url(); ?>admin/email_template/delete',
                                                                                                                                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', id: id},
                                                                                                                                success: function(data) {
                                                                                                                                    //for managing same state while record delete
                                                                                                                                    if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                        pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                    } else {
                                                                                                                                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                    }
                                                                                                                                    ajaxLink('<?php echo base_url(); ?>admin/email_template/index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);

                                                                                                                                                        //set responce message
                                                                                                                                                        $("#messages").show();
                                                                                                                                                        $("#messages").html(data);
                                                                                                                                                    }
                                                                                                                                                });

                                                                                                                                            } else {
                                                                                                                                                return false;
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                                        function delete_records()
                                                                                                                                        {
                                                                                                                                            var val = [];
                                                                                                                                            $(':checkbox:checked').each(function(i) {
                                                                                                                                                val[i] = $(this).val();
                                                                                                                                            });
                                                                                                                                            if (val == "")
                                                                                                                                            {
                                                                                                                                                alert('Please select at least one record for delete');
                                                                                                                                                return false;
                                                                                                                                            }
                                                                                                                                            if (confirm("Are you sure you want to delete this record"))
                                                                                                                                            {
                                                                                                                                                $.ajax({
                                                                                                                                                    type: 'POST',
                                                                                                                                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index',
                                                                                                                                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
                                                                                                                                                    success: function(data) {

                                                                                                                                                        //for managing same state while record delete
                                                                                                                                                        if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                                        } else {
                                                                                                                                                            pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                                        }
                                                                                                                                                        ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/email_template/ajax_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                                                            $("#messages").show();
                                                                                                                                                                            $("#messages").html(data);
                                                                                                                                                                        }
                                                                                                                                                                    });
                                                                                                                                                                }
                                                                                                                                                            }
</script>