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

                <a class="add-link"  href="<?php echo site_url () . $this->_data['section_name'] . '/newsletter/newsletters_actions/add/' . $language_code; ?>"><?php echo lang('add-newsletter');?></a>
            </div>
                
                
                <div class="panel table-panel">
                    <div class="panel-body">
            <?php if (!empty ($all_newletters)) { ?>

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
                                        if ($sort_by == 'n.subject' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('c.title', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Subject"><?php echo lang('subject'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'n.subject') {
                                                echo $sort_image;
                                            }
                                            ?></a>

                                    </th>

                                    <th>
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'nc.title' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('nc.title', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Slug Category"><?php echo lang('category'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'nc.title') {
                                                echo $sort_image;
                                            }
                                            ?></a>
                                    </th>

                                    <th>
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'n.schedule_time' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('n.schedule_time', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Slug URL"><?php echo lang('schedule'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'n.schedule_time') {
                                                echo $sort_image;
                                            }
                                            ?></a>
                                    </th>
                                    <th>
                    <?php echo lang ('templates'); ?>
                </th>
                <th class="t-center"><?php echo lang ('status'); ?></th>
                <th class="t-center"><?php echo lang ('sent'); ?></th>
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
            foreach ($all_newletters as $newsletter) {
                if ($i % 2 != 0) {
                    $class = "odd-row";
                } else {
                    $class = "even-row";
                }
            ?>
                                            <tr>
                                                <td>
                                                    <div class="ckbox ckbox-default">
                                                        <input type="checkbox" id="<?php echo $newsletter['n']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $newsletter['n']['id']; ?>">
                                                          <label for="<?php echo $newsletter['n']['id'] ?>"></label>

                                                    </div>
                                                </td>
                                                <td class="t-center"><?php echo $i; ?></td>
                                                <td><?php echo $newsletter['n']['subject']; ?></td>
                    <td><?php echo $newsletter['nc']['category_name']; ?></td>
                    <td><?php echo $newsletter['n']['schedule_time']; ?></td>
                    <td><?php echo $newsletter['t']['template_title']; ?></td>
                    <td class="t-center">
                        <?php
                        if ($newsletter['n']['status'] == 'active') {
                            echo add_image (array ('active.png'));
                        } else {
                            echo add_image (array ('inactive.png'));
                        }
                        ?>
                    </td>
                    <td class="t-center">
                        <?php
                        if ($newsletter['n']['sent'] == 'yes') {
                            echo add_image (array ('mail_sent.png'));
                        } else {
                            echo add_image (array ('mail_not_sent.png'));
                        }
                        ?>
                    </td>
                    <td class="t-center">
                        <?php
                        $newsletter_id = $newsletter['n']['newsletter_id'];
                        ?>
                        
                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/newsletter/view_newsletter/<?php echo $newsletter_id ?>/<?php echo $language_code; ?>" title="<?php echo lang ('view') ?>"><i class="fa fa-eye"></i></a>

                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/newsletter/newsletters_actions/edit/<?php echo $language_code ?>/<?php echo $newsletter_id ?>" title="<?php echo lang ('edit') ?>"><i class="fa fa-pencil"></i></a>

                                                    <?php $deletelink = "<a href='javascript:;' title='Delete' onclick='delete_newsletter($newsletter_id,$language_id)'><i class='fa fa-trash-o'></i></a>"; ?>
                                                    <?php echo $deletelink ?>
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
                       $querystr = $this->_ci->security->get_csrf_token_name () . '=' . urlencode ($this->_ci->security->get_csrf_hash ()) . '&search_term=' . $search_term . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
$options = array (
    'total_records' => $total_records,
    'page_number' => $page_number,
    'isAjaxRequest' => 1,
    'base_url' => base_url () . $this->_data['section_name'] . "/newsletter/ajax_index/" . $language_code,
    'params' => $querystr,
    'element' => 'contentpanel'
);
widget ('custom_pagination', $options);
                        ?>
                    </div>
                </div>
            </div><!-- col-md-6 -->
        </div>
    </div>
</div>
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
        alert('Please select atleast one record for delete');
        return false;
    }
    res = confirm('<?php echo lang ('delete-alert') ?>');
    if (res) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', type: 'delete', ids: val},
            success: function(data) {
                //for managing same state while record delete
                if ($('.rows') && $('.rows').length > 1) {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                } else {
                    pageno = "&page_number=<?php echo $page_number - 1; ?>";
                }
                ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index', 'menu-content-box', '<?php echo $querystr; ?>' + pageno);
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
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', type: 'active', ids: val},
        success: function(data) {
            //for managing same state while record delete
            if ($('.rows') && $('.rows').length > 1) {
                pageno = "&page_number=<?php echo $page_number; ?>";
            } else {
                pageno = "&page_number=<?php echo $page_number - 1; ?>";
            }
            ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index', 'menu-content-box', '<?php echo $querystr; ?>' + pageno);
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
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', type: 'inactive', ids: val},
        success: function(data) {
            //for managing same state while record delete
            if ($('.rows') && $('.rows').length > 1) {
                pageno = "&page_number=<?php echo $page_number; ?>";
            } else {
                pageno = "&page_number=<?php echo $page_number - 1; ?>";
            }
            ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index', 'menu-content-box', '<?php echo $querystr; ?>' + pageno);
            $("#messages").show();
            $("#messages").html(data);
        }
    });
}
function active_all_records()
{
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', type: 'active_all'},
        success: function(data) {
            //for managing same state while record delete
            if ($('.rows') && $('.rows').length > 1) {
                pageno = "&page_number=<?php echo $page_number; ?>";
            } else {
                pageno = "&page_number=<?php echo $page_number - 1; ?>";
            }
            ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
            $("#messages").show();
            $("#messages").html(data);
        }
    });
}
function inactive_all_records()
{
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', type: 'inactive_all'},
        success: function(data) {
            //for managing same state while record delete
            if ($('.rows') && $('.rows').length > 1) {
                pageno = "&page_number=<?php echo $page_number; ?>";
            } else {
                pageno = "&page_number=<?php echo $page_number - 1; ?>";
            }
            ajaxLink('<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
            $("#messages").show();
            $("#messages").html(data);
        }
    });
}
function submit_search()
{
    if ($('#search_term').val() == '') {
        $('#search_term').validationEngine('showPrompt', '<?php echo lang ('subject_required'); ?>', 'error');
        attach_error_event(); //for remove dynamically populate popup
        return false;
    }
    blockUI();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index/<?php echo $language_code; ?>',
        data: {<?php echo $this->ci ()->security->get_csrf_token_name (); ?>: '<?php echo $this->ci ()->security->get_csrf_hash (); ?>', search_term: $('#search_term').val()},
        success: function(data) {
            $(".menu-content-box").html(data);
        }
    });
    unblockUI();
}
function sort_data(sort_by, sort_order)
{
    blockUI();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index/<?php echo $language_code; ?>',
        data: {<?php echo $this->ci ()->security->get_csrf_token_name (); ?>: '<?php echo $this->ci ()->security->get_csrf_hash (); ?>', search_term: $('#search_term').val(), sort_by: sort_by, sort_order: sort_order},
        success: function(data) {
            $(".menu-content-box").html(data);
        }
    });
    unblockUI();
}
function reset_data()
{
    blockUI();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/ajax_index/<?php echo $language_code; ?>',
        data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', search_term: ""},
        success: function(data) {
            $(".menu-content-box").html(data);
        }
    });
    unblockUI();
}
</script>