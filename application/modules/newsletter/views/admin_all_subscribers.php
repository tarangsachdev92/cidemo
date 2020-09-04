<div class="contentpanel" id="ajax_table">
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
                            'content' => '<i class="fa fa-search"></i> &nbsp;'.lang('btn-search'),
                            'title' => lang('btn-search'),
                            'class' => 'btn btn-primary',
                            'onclick' => "submit_search()",
                        );
                        echo form_button($search_button);
                        ?>
                        <!--                        <button class="btn btn-primary">Search</button>-->

                        <?php
                        $reset_button = array(
                            'content' => '<i class="fa fa-refresh"></i> &nbsp;'.lang('reset_button'),
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

                <a class="add-link" href="<?php echo site_url() . $this->_data['section_name'] . '/newsletter/subscribers_actions/add/en' ?>"><?php echo lang ('add_subscriber'); ?></a>
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
                                    if ($sort_by == 's.firstname' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>

                                    <a href="javascript:;" onclick="sort_data('s.firstname', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by First Name"><?php echo lang ('first-name'); ?> &nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 's.firstname') {
                                            echo $sort_image;
                                        }
                                        ?></a>
                                </th>

                                <th>
                                    <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 's.lastname' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="sort_data('s.lastname', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Last Name"><?php echo lang ('last-name'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 's.lastname') {
                                            echo $sort_image;
                                        }
                                        ?></a>

                                </th>
                                <th>
                                    <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 's.email' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="sort_data('s.email', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Email"><?php echo lang ('email'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 's.email') {
                                            echo $sort_image;
                                        }
                                        ?></a>
                                </th>
                              
                                <th class="t-center">
                                    <?php
                                    $field_sort_order = 'asc';
                                    $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                    if ($sort_by == 's.status' && $sort_order == 'asc') {
                                        $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                        $field_sort_order = 'desc';
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="sort_data('s.status', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Status"><?php echo lang ('status'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 's.status') {
                                            echo $sort_image;
                                        }
                                        ?></a>

                                </th>
                                <th class="t-center"><?php echo lang ('action-title'); ?></th>

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
                        ?>


                                        <tr>
                                            <td>
                                                <div class = "ckbox ckbox-default">

                                                   
                                                        <input type="checkbox" id="<?php echo $user['s']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $user['s']['id']; ?>">
                                                          <label for="<?php echo $user['s']['id']; ?>"></label>
                                                

                                                </div>
                                            </td>
                                            <td class="t-center"><?php echo $i; ?></td>
                                            <td><?php echo $user['s']['firstname']; ?></td>
                                            <td><?php echo $user['s']['lastname']; ?></td>
                                            <td><?php echo $user['s']['email']; ?></td>
                                          
                                          
                                            <td class="t-center">
                                                <?php
                                                if ($user['s']['status'] == 'active') {
                                                    echo add_image(array('active.png'), '', '', array('title' => 'active', 'alt' => "active"));
                                                } else {
                                                    echo add_image(array('inactive.png'), '', '', array('title' => 'inactive', 'alt' => "inactive"));
                                                }
                                                $user_id = $user['s']['id'];
                                                ?>
                                            </td>

                                            <td class="t-center">

                                                 <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/newsletter/subscribers_actions/edit/en/<?php echo $user_id ?>" title="<?php echo lang('edit'); ?>"><i class="fa fa-pencil"></i></a>

                                             
                                                    <a class="delete-row" href="javascript:;" onclick="delete_user('<?php echo $user_id; ?>')"><i class="fa fa-trash-o" title="<?php echo lang('delete'); ?>"></i></a>
                                                
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>

                                </tbody>
                            </table>

                        </div>
                       <?php } else 
             echo lang ('no-records'); ?>
                   
                   
         
    
                        <div class="btn-panel mb15">
                            <button class="btn btn-labeled btn-danger" onclick="delete_records()"><span class="btn-label"><i class="fa fa-trash-o"></i></span>Delete</button>
                            <button class="btn btn-labeled btn-info" onclick="active_records()"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active</button>
                            <button class="btn btn-labeled btn-danger" onclick="inactive_records()"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>In Active</button>
                            <button class="btn btn-labeled btn-info" onclick="active_all_records()"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active All</button>
                            <button class="btn btn-labeled btn-danger" onclick="inactive_all_records()"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>Inactive All</button>
                        </div>

                        

                    <?php
                    $querystr = $this->_ci->security->get_csrf_token_name () . '=' . urlencode ($this->_ci->security->get_csrf_hash ()) . '&search_term=' . $search_term . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
          $options = array (
        'total_records' => $total_records,
        'page_number' => $page_number,
        'isAjaxRequest' => 1,
        'base_url' => base_url () . $this->_data['section_name'] . "/newsletter/all_subscribers",
        'params' => $querystr,
        'element' => 'ajax_table'
    );
    widget ('custom_pagination', $options);
                    ?>

                </div>
            </div>
        </div><!-- col-md-6 -->
    </div>
</div>

<script type="text/javascript">
//remove dynamically populate error
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
        alert('Please select atleast one record for delete');
        return false;
    }
    res = confirm('<?php echo lang ('delete-alert') ?>');
    if (res) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers',
            data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', type: 'delete', ids: val},
            success: function(data) {
                //for managing same state while record delete
                if ($('.rows') && $('.rows').length > 1) {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                } else {
                    pageno = "&page_number=<?php echo $page_number - 1; ?>";
                }
                ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
        alert('Please select atleast one record for active');
        return false;
    }
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', type: 'active', ids: val},
        success: function(data) {
            //for managing same state while record delete
            if ($('.rows') && $('.rows').length > 1) {
                pageno = "&page_number=<?php echo $page_number; ?>";
            } else {
                pageno = "&page_number=<?php echo $page_number - 1; ?>";
            }
            ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
        alert('Please select atleast one record for inactive');
        return false;
    }
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', type: 'inactive', ids: val},
        success: function(data) {
            //for managing same state while record delete
            if ($('.rows') && $('.rows').length > 1) {
                pageno = "&page_number=<?php echo $page_number; ?>";
            } else {
                pageno = "&page_number=<?php echo $page_number - 1; ?>";
            }
            ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
            $("#messages").show();
            $("#messages").html(data);
        }
    });
}
function active_all_records()
{
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', type: 'active_all'},
        success: function(data) {
            //for managing same state while record delete
            if ($('.rows') && $('.rows').length > 1) {
                pageno = "&page_number=<?php echo $page_number; ?>";
            } else {
                pageno = "&page_number=<?php echo $page_number - 1; ?>";
            }
            ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
            $("#messages").show();
            $("#messages").html(data);
        }
    });
}
function inactive_all_records()
{
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', type: 'inactive_all'},
        success: function(data) {
            //for managing same state while record delete
            if ($('.rows') && $('.rows').length > 1) {
                pageno = "&page_number=<?php echo $page_number; ?>";
            } else {
                pageno = "&page_number=<?php echo $page_number - 1; ?>";
            }
            ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
            $("#messages").show();
            $("#messages").html(data);
        }
    });
}
function delete_user(id) {
    res = confirm('<?php echo lang ('delete-alert') ?>');
    if (res) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/delete',
            data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', id: id},
            success: function(data) {
                //for managing same state while record delete
                if ($('.rows') && $('.rows').length > 1) {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                } else {
                    pageno = "&page_number=<?php echo $page_number - 1; ?>";
                }
                ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });

    } else {
        return false;
    }
}
$("#search_term").keypress(function(event) {
    if (event.which == 13) {
        event.preventDefault();
        submit_search();
    }
});
function submit_search()
{
    if ($('#search_term').val().trim() == '') {
        $('#search_term').validationEngine('showPrompt', '<?php echo lang ('subject_required'); ?>', 'error');
        attach_error_event(); //for remove dynamically populate popup
        return false;
    }
    blockUI();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', search_term: $('#search_term').val()},
        success: function(data) {
            $("#ajax_table").html(data);
        }
    });
    unblockUI();
}
function sort_data(sort_by, sort_order)
{
    blockUI();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', search_term: $('#search_term').val(), sort_by: sort_by, sort_order: sort_order},
        success: function(data) {
            $("#ajax_table").html(data);
        }
    });
    unblockUI();
}
function reset_data()
{
    blockUI();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_subscribers',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', search_term: ""},
        success: function(data) {
            $("#ajax_table").html(data);
        }
    });
    unblockUI();
}
</script>


