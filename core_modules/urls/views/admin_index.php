<div class="contentpanel">
    <div class="panel panel-default form-panel">
        <div class="panel-body">
            <form>           
                <div class="row row-pad-5">
                    <div class="col-lg-3 col-md-3">
                        <?php
                        $search_options = array('slug_url' => lang('slug-url'), 'module_name' => lang('module-name'));
                        echo form_dropdown('search', $search_options, $search, 'id=search class="form-control" onchange=search_change(this.value)');
                        ?>
                    </div>

                    <div class="col-lg-3 col-md-3" id="slug_url_id">
                        <?php
                        $input_data = array(
                            'name' => 'search_term',
                            'id' => 'search_term',
                            'title' => 'search',
                            'class' => 'form-control',
                            'value' => set_value('search_term', urldecode($search_term))
                        );
                        echo form_input($input_data);
                        ?>
                    </div>

                    <div class="col-lg-3 col-md-3" id="module_list_id">
                        <?php
                        echo form_dropdown('module_name', $modules_list, $module, 'id=module_name class="form-control"');
                        ?>
                    </div>

                </div>

                <div class="row row-pad-5">


                    <div class="col-lg-3 col-md-3" >
                        <?php
                        $search_button = array(
                            'content' => '<i class="fa fa-search"></i> &nbsp; ' . lang('btn-search'),
                            'title' => lang('btn-search'),
                            'class' => 'btn btn-primary',
                            'onclick' => "submit_search()",
                            'id' => 'search_button'
                        );
                        echo form_button($search_button);
                        ?>
                        <?php
                        $reset_button = array(
                            'content' => '<i class="fa fa-refresh"></i> &nbsp; ' . lang('btn-reset'),
                            'title' => lang('btn-reset'),
                            'class' => 'btn btn-default btn-reset',
                            'onclick' => "reset_data()",
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
                <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>
                <a href="<?php echo site_url() . get_current_section($this) . '/urls/action/add' ?>" class="add-link"><?php echo lang('add-url') ?></a>
            </div>
            <div class="panel table-panel">
                <div class="panel-body">

                    <?php
                    if (!empty($urls)) {
                        ?>
                        <div class="table-responsive">  

                            <table class="table" >
                                <thead>
                                    <tr>
                                        <th>
                                <div class="ckbox ckbox-default">
                                    <input type="checkbox" name="check_all" id="check_all" value="0" />
                                    <label for="check_all"></label>
                                </div>
                                </th>
                                <th class="t-center"><?php echo lang('no') ?></th>
                                <th> <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 'u.slug_url' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="sort_data('u.slug_url', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Slug URL">
                                        <?php echo lang('slug-url'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'u.slug_url') {
                                            echo $sort_image;
                                        }
                                        ?></a>
                                </th>
                                <th>
                                    <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 'u.module_name' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="sort_data('u.module_name', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Module Name">
                                        <?php echo lang('module-name'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'u.module_name') {
                                            echo $sort_image;
                                        }
                                        ?>
                                    </a>
                                </th>
                                <th>  
                                    <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 'u.core_url' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="sort_data('u.core_url', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Core URL">
                                    <?php echo lang('core-url'); ?>&nbsp;&nbsp;&nbsp;<?php
                                if ($sort_by == 'u.core_url') {
                                    echo $sort_image;
                                }
                                    ?>
                                    </a>
                                </th>
                                <th class="t-center"> 
    <?php
    $field_sort_order = 'asc';
    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
    if ($sort_by == 'u.status' && $sort_order == 'asc') {
        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
        $field_sort_order = 'desc';
    }
    ?>
                                    <a href="javascript:;" onclick="sort_data('u.status', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Status">
                                    <?php echo lang('status'); ?>&nbsp;&nbsp;&nbsp;<?php
                                    if ($sort_by == 'u.status') {
                                        echo $sort_image;
                                    }
                                    ?>
                                    </a>
                                </th>
                                <th class="t-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
    <?php
    if ($page_number > 1) {
        $i = ($this->session->userdata[get_current_section($this)]['record_per_page'] * ($page_number - 1)) + 1;
    } else {
        $i = 1;
    }
    // echo '<pre>'; print_r($urls); echo '</pre>'; die();
    foreach ($urls as $url) {
        if ($i % 2 != 0) {
            $class = "odd-row";
        } else {
            $class = "even-row";
        }
        $url_id = $url['u']['id'];
        ?>
                                        <tr>
                                            <td>
                                                <div class = "ckbox ckbox-default">


                                                    <input type="checkbox" id="<?php echo $url['u']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $url['u']['id']; ?>">
                                                    <label for="<?php echo $url['u']['id']; ?>"></label>


                                                </div>

                                            </td>
                                            <td class="t-center"><?php echo $i; ?></td>
                                            <td><?php echo $url['u']['slug_url']; ?></td>
                                            <td><?php echo $url['u']['module_name']; ?></td>
                                            <td><?php echo $url['u']['core_url']; ?></td>
                                            <td class="t-center"> <?php
                                if ($url['u']['status'] == 1) {
                                    echo add_image(array('active.png'), '', '', array('title' => 'active', 'alt' => "active"));
                                } else {
                                    echo add_image(array('inactive.png'), '', '', array('title' => 'inactive', 'alt' => "inactive"));
                                }
        ?></td>

                                            <td class="t-center"> 
                                                <a class="mr5" href="<?php echo site_url() . get_current_section($this); ?>/urls/view_data/<?php echo $url_id; ?>" title="<?php echo lang('view'); ?>"><i class="fa fa-eye"></i></a>

                                                <a class="mr5" href="<?php echo site_url() . get_current_section($this); ?>/urls/action/edit/<?php echo $url_id; ?>" title="<?php echo lang('edit'); ?>"><i class="fa fa-pencil"></i></a>


                                                <a class="delete-row" href="javascript:;" onclick="delete_url('<?php echo $url_id; ?>')" title="<?php echo lang('delete'); ?>"><i class="fa fa-trash-o"></i></a>

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
                            <button class="btn btn-labeled btn-danger" onclick="delete_records()"><span class="btn-label"><i class="fa fa-trash-o"></i></span>Delete</button>
                            <button class="btn btn-labeled btn-info" onclick="active_records()"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active</button>
                            <button class="btn btn-labeled btn-danger" onclick="inactive_records()"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>In Active</button>
                            <button class="btn btn-labeled btn-info" onclick="active_all_records()"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active All</button>
                            <button class="btn btn-labeled btn-danger" onclick="inactive_all_records()"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>Inactive All</button>
                        </div>
    <?php
} else {
    echo 'No Record(s) Found';
}
?>

                    <?php
                    $querystr = $this->theme->ci()->security->get_csrf_token_name() . '=' . urlencode($this->theme->ci()->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '&search=' . $search . '&module=' . $module . '';
                    $options = array(
                        'total_records' => $total_records,
                        'page_number' => $page_number,
                        'isAjaxRequest' => 1,
                        'base_url' => base_url() . get_current_section($this) . "/urls/index",
                        'params' => $querystr,
                        'element' => 'ajax_table'
                    );
                    widget('custom_pagination', $options);
                    ?>

                </div>
            </div>
        </div><!-- col-md-6 -->
    </div>


</div><!-- contentpanel -->
<script type="text/javascript">
    $("#search_term").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
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
        res = confirm('<?php echo lang('delete-alert') ?>');
        if (res) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . get_current_section($this); ?>/urls/index',
                data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
                success: function(data) {
                    //for managing same state while record delete
                    if ($('.rows') && $('.rows').length > 1) {
                        pageno = "&page_number=<?php echo $page_number; ?>";
                    } else {
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                    }
                    ajaxLink('<?php echo base_url() . get_current_section($this); ?>/urls/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                    $("#messages").show();
                    $("#messages").html(data);
                }
            });
        } else
        {
            return false;
        }
    }

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
            url: '<?php echo base_url() . get_current_section($this); ?>/urls/index',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', type: 'active', ids: val},
            success: function(data) {
                //for managing same state while record delete
                pageno = "&page_number=<?php echo $page_number; ?>";
                ajaxLink('<?php echo base_url() . get_current_section($this); ?>/urls/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
            url: '<?php echo base_url() . get_current_section($this); ?>/urls/index',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', type: 'inactive', ids: val},
            success: function(data) {
                //for managing same state while record delete
                pageno = "&page_number=<?php echo $page_number; ?>";
                ajaxLink('<?php echo base_url() . get_current_section($this); ?>/urls/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    }

    function active_all_records()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . get_current_section($this); ?>/urls/index',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', type: 'active_all'},
            success: function(data) {
                //for managing same state while record delete
                pageno = "&page_number=<?php echo $page_number; ?>";
                ajaxLink('<?php echo base_url() . get_current_section($this); ?>/urls/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    }

    function inactive_all_records()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . get_current_section($this); ?>/urls/index',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', type: 'inactive_all'},
            success: function(data) {
                //for managing same state while record delete
                pageno = "&page_number=<?php echo $page_number; ?>";
                ajaxLink('<?php echo base_url() . get_current_section($this); ?>/urls/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    }

    function delete_url(id) {
        res = confirm('<?php echo lang('delete-alert') ?>');
        if (res) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . get_current_section($this); ?>/urls/delete',
                data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', id: id},
                success: function(data) {
                    //for managing same state while record delete
                    if ($('.rows') && $('.rows').length > 1) {
                        pageno = "&page_number=<?php echo $page_number; ?>";
                    } else {
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                    }
                    ajaxLink('<?php echo base_url() . get_current_section($this); ?>/urls/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);

                    $("#messages").show();
                    $("#messages").html(data);
                }
            });
        } else {
            return false;
        }
    }
    function submit_search()
    {
        $('#error_msg').fadeOut(1000);
        /*if($('#search_term').val() == ''){
         $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
         attach_error_event(); //for remove dynamically populate popup
         return false;
         }   */
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . get_current_section($this); ?>/urls/index',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val()), search: encodeURIComponent($('#search').val()), module: encodeURIComponent($('#module_name').val())},
            success: function(data) {

                $("#ajax_table").html(data);
                unblockUI();
            }
        });

    }
    function sort_data(sort_by, sort_order)
    {
        blockUI('removeError');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . get_current_section($this); ?>/urls/index',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val()), sort_by: sort_by, sort_order: sort_order},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        });

    }
    function reset_data()
    {
        blockUI('removeError');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . get_current_section($this); ?>/urls/index',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>', search_term: ""},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        });
    }
    function search_change(val)
    {
        if (val === 'slug_url')
        {
            // $("#module_list_id").hide("slow", function() {});
            $("#module_list_id").hide();
            $("#slug_url_id").show();
        }

        if (val === 'module_name')
        {
            // $("#slug_url_id").hide("slow", function() {});
            $("#slug_url_id").hide();
            $("#module_list_id").show();
        }
    }

    $(document).ready(function() {
        search_change($("#search").val());
    });
    $(document).ajaxComplete(function() {
        // Chosen Select
        jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
    });
</script>