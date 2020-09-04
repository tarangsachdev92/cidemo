<div id="contentpanel">
    <div class="contentpanel"> 
        <?php
        if (isset($category['categories']['title'])) {
            ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">Category: <?php echo $category['categories']['title']; ?></h4>
                </div>
            </div>
        <?php } ?>

        <div class="panel panel-default form-panel">
            <div class="panel-body">
                <div class="row row-pad-5"> 
                    <div class="col-lg-3 col-md-3">
                        <?php
                        $input_data = array(
                            'name' => 'search_term',
                            'id' => 'search_term',
                            'class' => 'form-control',
                            'value' => set_value('search_term', urldecode($search_term)),
                            'placeholder' => lang('search-title')
                        );
                        echo form_input($input_data);
                        ?>
                    </div>               
                    <div class="col-lg-3 col-md-3">

                        <?php
                        $search_button = array(
                            'content' => '<i class="fa fa-search"></i> &nbsp;' . lang('search'),
                            'title' => lang('search'),
                            'class' => 'btn btn-primary',
                            'onclick' => "submit_search()",
                        );
                        echo form_button($search_button);

                        $reset_button = array(
                            'content' => '<i class="fa fa-refresh"></i> &nbsp;' . lang('reset'),
                            'title' => lang('reset'),
                            'class' => 'btn btn-default btn-reset',
                            'onclick' => "reset_data()",
                        );
                        echo form_button($reset_button);
                        ?>
                    </div>
                </div>  
            </div>
        </div>
        <div class="row">        
            <div class="col-md-12">
                <div class="panel-header clearfix">
                    <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>



                    <?php
                    echo anchor(site_url() . 'admin/forum/action', lang('add-forum'), 'title="Add Forum" class="add-link"  ');

                    echo anchor(site_url() . $this->_data["section_name"] . '/forum/index/' . $language_code, lang('back-to-category'), 'title="Back to category" class="add-link" style="margin-right: 10px"');
                    ?>

                </div>

                <div class="panel table-panel">
                    <div class="panel-body">
                        <?php if (!empty($forums)) { ?>
                            <div class="table-responsive">          		
                                <table class="table table-hover gradienttable">
                                    <thead>
                                        <tr>
                                            <th>
                                    <div class="ckbox ckbox-default">
                                        <input type="checkbox" value="0" id="check_all" name="check_all">
                                        <label for="check_all"></label>
                                    </div>
                                    </th>        

                                    <th class="t-center"><?php echo lang('no') ?></th>

                                    <th>
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'forum_post_title' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('forum_post_title', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Forum Post Title"><?php echo lang('forum_post_title'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'forum_post_title') {
                                                echo $sort_image;
                                            }
                                            ?></a>
                                    </th>

                                    <th><?php echo lang('rly_count'); ?></th>
                                    <th class="t-center"><?php echo lang('last_update_on'); ?></th>
                                    <th class="t-center"><?php echo lang('status'); ?></th>
                                    <th class="t-center"><?php echo lang('action'); ?></th>

                                    </tr>

                                    </thead>

                                    <tbody>
                                        <?php
                                        if ($page_number > 1) {
                                            $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page'] * ($page_number - 1)) + 1;
                                        } else {
                                            $i = 1;
                                        }

                                        foreach ($forums as $forum) {
                                            ?>
                                            <tr>
                                                <td>

                                                    <div class="ckbox ckbox-default">
                                                        <input type="checkbox" value="<?php echo $forum['forum_post']['id']; ?>" class="check_box" name="check_box[]" id="<?php echo $forum['forum_post']['id']; ?>">
                                                        <label for="<?php echo $forum['forum_post']['id']; ?>"></label>
                                                    </div>


                                                </td>

                                                <td class="t-center"><?php echo $i; ?> 
                                                    <?php if ($forum['forum_post']['is_private'] == 1) echo add_image(array('imp.png')); ?>
                                                </td>

                                                <td>
                                                    <a href="<?php echo site_url() . $this->_data["section_name"]; ?>/forum/forum_post/<?php echo $language_code . "/" . $forum['forum_post']['id'] ?>"><?php echo $forum['forum_post']['forum_post_title']; ?></a>
                                                </td>
                                                <td><?php echo $forum['forum_post']['rly_count']; ?></td>

                                                <td class="t-center">
                                                    <?php
                                                    if ($forum['forum_post']['modified_on'] == "0000-00-00 00:00:00") {
                                                        $forum['forum_post']['modified_on'] = "-";
                                                    }
                                                    echo $forum['forum_post']['modified_on'];
                                                    $forum_id = $forum['forum_post']['id']
                                                    ?>
                                                </td>
                                                <td class="t-center">
                                                    <?php
                                                    if ($forum['forum_post']['status'] == 1) {
                                                        echo add_image(array('active.png'));
                                                    } else {
                                                        echo add_image(array('inactive.png'));
                                                    }
                                                    ?>
                                                </td>

                                                <td class="t-center">
                                                    <a title="View Forum" class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/forum/view_data/<?php echo $forum_id; ?>/<?php echo $language_code; ?>"><i class="fa fa-eye"></i></a>
                                                    <a title="Edit Forum" class="mr5" href="<?php echo site_url() . $this->_data["section_name"]; ?>/forum/action/edit/<?php echo $forum_id . "/" . $language_code ?>"><i class="fa fa-pencil"></i></a>
                                                    <?php
                                                    $deletelink = "<a class='delete-row' href='javascript:;' title='Delete Forum' onclick='delete_forum($forum_id)'><i class='fa fa-trash-o'></i></a>";
                                                    echo $deletelink
                                                    ?>
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

                        echo form_hidden('search_text', (isset($search_text)) ? $search_text : '' );
                        echo form_hidden('page_number', "", "page_number");
                        echo form_hidden('per_page_result', "", "per_page_result");

                        $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . $search_term . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
                        $options = array(
                            'total_records' => $total_records,
                            'page_number' => $page_number,
                            'isAjaxRequest' => 1,
                            'base_url' => base_url() . $this->_data["section_name"] . "/forum/ajax_forum_listing/" . $category_id . "/" . $language_code,
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


<script type="text/javascript">
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

    $("#search_term").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    function submit_search()
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        if ($('#search_term').val() == '') {
            $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg_search_req'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data["section_name"]; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>',
                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val())},
                        success: function(data) {
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
                        url: '<?php echo base_url() . $this->_data["section_name"]; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>',
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
                                    url: '<?php echo base_url() . $this->_data["section_name"]; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>',
                                                data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: ""},
                                                success: function(data) {
                                                    $("#contentpanel").html(data);
                                                    unblockUI();
                                                }
                                            });
                                        }
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

                                            res = confirm('<?php echo lang('delete-alert') ?>');
                                            if (res) {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>',
                                                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
                                                                    success: function(data) {

                                                                        //for managing same state while record delete
                                                                        if ($('.rows') && $('.rows').length > 1) {
                                                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                                                        } else {
                                                                            pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                        }
                                                                        ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/forum/forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
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
                                                                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>',
                                                                                                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active', ids: val},
                                                                                                success: function(data) {
                                                                                                    //for managing same state while record delete
                                                                                                    if ($('.rows') && $('.rows').length > 1) {
                                                                                                        pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                    } else {
                                                                                                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                    }
                                                                                                    ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
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
                                                                                                                url: '<?php echo base_url() . $this->_data['section_name']; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>',
                                                                                                                            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val},
                                                                                                                            success: function(data) {
                                                                                                                                //for managing same state while record delete
                                                                                                                                if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                    pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                } else {
                                                                                                                                    pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                }
                                                                                                                                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                                $("#messages").show();
                                                                                                                                                $("#messages").html(data);
                                                                                                                                            }
                                                                                                                                        });
                                                                                                                                    }

                                                                                                                                    function active_all_records()
                                                                                                                                    {
                                                                                                                                        $.ajax({
                                                                                                                                            type: 'POST',
                                                                                                                                            url: '<?php echo base_url() . $this->_data['section_name']; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>',
                                                                                                                                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all'},
                                                                                                                                                        success: function(data) {
                                                                                                                                                            //for managing same state while record delete
                                                                                                                                                            if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                                            } else {
                                                                                                                                                                pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                                            }
                                                                                                                                                            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                                                            $("#messages").show();
                                                                                                                                                                            $("#messages").html(data);
                                                                                                                                                                        }
                                                                                                                                                                    });
                                                                                                                                                                }

                                                                                                                                                                function inactive_all_records()
                                                                                                                                                                {
                                                                                                                                                                    $.ajax({
                                                                                                                                                                        type: 'POST',
                                                                                                                                                                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>',
                                                                                                                                                                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all'},
                                                                                                                                                                                    success: function(data) {
                                                                                                                                                                                        //for managing same state while record delete
                                                                                                                                                                                        if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                                                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                                                                        } else {
                                                                                                                                                                                            pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                                                                        }
                                                                                                                                                                                        ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                                                                                        $("#messages").show();
                                                                                                                                                                                                        $("#messages").html(data);
                                                                                                                                                                                                    }
                                                                                                                                                                                                });
                                                                                                                                                                                            }

</script>
