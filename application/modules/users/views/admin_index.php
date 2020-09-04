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
                            'class' => 'form-control',
                            'placeholder' => 'Search by First Name',
                            'value' => set_value('search_term', urldecode($search_term))
                        );
                        echo form_input($input_data);
                        ?>
<!--                        <input type="text" class="form-control" placeholder="Search by First Name" name="website">-->
                    </div>               
                    <div class="col-lg-3 col-md-3">
                        <?php
                        $search_button = array(
                            'content' => '<i class="fa fa-search"></i> &nbsp;' . lang('btn-search'),
                            'title' => lang('btn-search'),
                            'class' => 'btn btn-primary',
                            'onclick' => "submit_search()",
                        );
                        echo form_button($search_button);
                        ?>
                        <!--                        <button class="btn btn-primary">Search</button>-->

                        <?php
                        $reset_button = array(
                            'content' => '<i class="fa fa-refresh"></i> &nbsp;' . lang('reset_button'),
                            'title' => lang('reset_button'),
                            'class' => 'btn btn-default btn-reset',
                            'onclick' => "reset_data()",
                            "type" => "reset"
                        );
                        echo form_button($reset_button);
                        ?>

                        <!--                        <button type="reset" class="btn btn-default btn-reset">Reset</button>-->
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

                <a class="add-link" href="<?php echo site_url() . $this->_data['section_name'] . '/users/action/add/' ?>">Add User</a>
            </div>
            <div class="panel table-panel">
                <div class="panel-body">
                    <?php
                    if (!empty($users)) {
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
                                <th class="t-center"><?php echo lang('no') ?></th>
                                <th>
                                    <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 'u.firstname' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>

                                    <a href="javascript:;" onclick="sort_data('u.firstname', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by First Name">First Name &nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'u.firstname') {
                                            echo $sort_image;
                                        }
                                        ?></a>
                                </th>

                                <th>
                                    <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 'u.lastname' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="sort_data('u.lastname', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Last Name">Last Name&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'u.lastname') {
                                            echo $sort_image;
                                        }
                                        ?></a>

                                </th>
                                <th>
                                    <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 'u.email' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="sort_data('u.email', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Email">Email&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'u.email') {
                                            echo $sort_image;
                                        }
                                        ?></a>
                                </th>
                                <th>
                                    <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 'r.role_name' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="sort_data('r.role_name', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Role">Role&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'r.role_name') {
                                            echo $sort_image;
                                        }
                                        ?></a>
                                </th>
                                <th class="t-center">Permission</th>
                                <th class="t-center">
                                    <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 'u.status' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="sort_data('u.status', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Status">Status&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'u.status') {
                                            echo $sort_image;
                                        }
                                        ?></a>

                                </th>
                                <th class="t-center">Actions</th>

                                </tr>

                                </thead>
                                <tbody>

                                    <?php
                                    if ($page_number > 1) {
                                        $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page'] * ($page_number - 1)) + 1;
                                    } else {
                                        $i = 1;
                                    }

                                    foreach ($users as $user) {
                                        if ($i % 2 != 0) {
                                            $class = "odd-row";
                                        } else {
                                            $class = "even-row";
                                        }
                                        $user_id = $user['u']['id'];
                                        ?>


                                        <tr>
                                            <td>
                                                <div class = "ckbox ckbox-default">

                                                    <?php if ($user_id != 1 && $user_id != $this->_ci->session->userdata[$this->_data['section_name']]['user_id']) {
                                                        ?>
                                                        <input type="checkbox" id="<?php echo $user['u']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo base64_encode($user['u']['id']); ?>">
                                                        <label for="<?php echo $user['u']['id']; ?>"></label>
                                                    <?php } ?>

                                                </div>
                                            </td>
                                            <td class="t-center"><?php echo $i; ?></td>
                                            <td><?php echo $user['u']['firstname']; ?></td>
                                            <td><?php echo $user['u']['lastname']; ?></td>
                                            <td><?php echo $user['u']['email']; ?></td>
                                            <td><?php echo $user['r']['role_name']; ?></td>
                                            <td class="t-center">
                                                <?php
                                                if ($user_id != 1) {
                                                    ?>
                                                    <?php echo anchor(site_url() . '/' . $this->_data['section_name'] . '/roles/user_permission_matrix/' . $user_id, lang('view-permission'), 'title="View Permission" '); ?>
                                                <?php } ?>
                                            </td>
                                            <td class="t-center">
                                                <?php
                                                if ($user['u']['status'] == 1) {
                                                    echo add_image(array('active.png'), '', '', array('title' => 'active', 'alt' => "active"));
                                                } else {
                                                    echo add_image(array('inactive.png'), '', '', array('title' => 'inactive', 'alt' => "inactive"));
                                                }
                                                ?>
                                            </td>

                                            <td class="t-center">

                                                <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/users/view_data/<?php echo $user_id ?>" title="View User"><i class="fa fa-eye"></i></a>

                                                <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/users/action/edit/<?php echo $user_id ?>" title="Edit User"><i class="fa fa-pencil"></i></a>

                                                <?php if ($user_id != 1 && $user_id != $this->_ci->session->userdata[$this->_data['section_name']]['user_id']) {
                                                    ?>
                                                    <?php
                                                    $encrypted_id = base64_encode($user_id);
                                                    ?>
                                                    <a class="delete-row" href="javascript:;" onclick="delete_user('<?php echo $encrypted_id; ?>')" title="Delete User"><i class="fa fa-trash-o"></i></a>
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
                    $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
                    $options = array(
                        'total_records' => $total_records,
                        'page_number' => $page_number,
                        'isAjaxRequest' => 1,
                        'base_url' => base_url() . $this->_data['section_name'] . "/users/index",
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
//remove dynamically populate error
    $("#search_term").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    function attach_error_event() {
        $('div.formError').bind('click', function() {
            $(this).fadeOut(1000, removeError);
        });
    }
    function removeError()
    {
        jQuery(this).remove();
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
                url: '<?php echo base_url() . $this->_data['section_name']; ?>/users/index',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
                success: function(data) {
//                    alert(data); return;

//for managing same state while record delete
                    if ($('.rows') && $('.rows').length > 1) {
                        pageno = "&page_number=<?php echo $page_number; ?>";
                    } else {
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                    }
                    ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/users/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/users/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active', ids: val},
            success: function(data) {
//for managing same state while record delete
                pageno = "&page_number=<?php echo $page_number; ?>";
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/users/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/users/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val},
            success: function(data) {
//for managing same state while record delete
                pageno = "&page_number=<?php echo $page_number; ?>";
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/users/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    }

    function active_all_records()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/users/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all'},
            success: function(data) {
//for managing same state while record delete
                pageno = "&page_number=<?php echo $page_number; ?>";
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/users/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    }

    function inactive_all_records()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/users/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all'},
            success: function(data) {

//for managing same state while record delete
                pageno = "&page_number=<?php echo $page_number; ?>";
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/users/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
                url: '<?php echo base_url() . $this->_data['section_name']; ?>/users/delete',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', id: id},
                success: function(data) {



//for managing same state while record delete
                    if ($('.rows') && $('.rows').length > 1) {
                        pageno = "&page_number=<?php echo $page_number; ?>";
                    } else {
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                    }
                    ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/users/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);

//set responce message
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
        // $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        /*if($('#search_term').val() == ''){
         $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
         attach_error_event(); //for remove dynamically populate popup
         return false;
         } */
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/users/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val())},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        });

    }

    function sort_data(sort_by, sort_order)
    {
        // $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/users/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val()), sort_by: sort_by, sort_order: sort_order},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        });

    }
    function reset_data()
    {
        // $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/users/index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: ""},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        });
    }
</script>