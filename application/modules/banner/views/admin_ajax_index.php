

<div id="contentpanel">
    <div class="contentpanel"> 
        <div class="panel panel-default form-panel">
            <div class="panel-body">
                <div class="row row-pad-5"> 
                    <div class="col-lg-3 col-md-3">
                        <?php
                        $search_options = array(
                            '' => lang('search-by'),
                            'title' => lang('title'),
                            'section' => lang('section'),
                            'status' => lang('status'),
                        );
                        echo form_dropdown('search', $search_options, urldecode($search), 'id=search onchange = change_search(this.value); class=form-control');
                        ?>
                    </div> 


                    <div class="col-lg-3 col-md-3" id='search_options' style="display: none">
                        <?php
                        $title = array(
                            'name' => 'search_title',
                            'id' => 'search_title',
                            'class' => 'form-control',
                            'placeholder' => 'Input Title to Search',
                            'value' => set_value('search_title', urldecode($search_title))
                        );

                        $status = array(
                            '' => '--- Select Status to Search ---',
                            '1' => lang('active'),
                            '0' => lang('inactive')
                        );

                        $section[''] = '--- Select Section to Search ---';
                        $i = 1;
                        foreach ($banner_data['sections'] as $sec) {
                            $section[$i] = $sec;
                            $i++;
                        }
                        ?>                            
                        <div id='title'> 
                            <?php echo form_input($title) . "  "; ?> 
                        </div>

                        <div id='div_status'> 
                            <?php echo form_dropdown('search_status', $status, urldecode($search_status), 'id=search_status class = form-control') . "  "; ?> 
                        </div>

                        <div id='section'> 
                            <?php echo form_dropdown('search_section', $section, urldecode($search_section), 'id=search_section class=form-control') . "  "; ?> 
                        </div>
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

                        $reset_button = array(
                            'content' => '<i class="fa fa-refresh"></i> &nbsp;' . lang('reset_button'),
                            'title' => lang('reset_button'),
                            'class' => 'btn btn-default btn-reset',
                            'onclick' => "reset_data()",
                            "type" => "reset"
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

                    <a onclick="openlink('add')" class="add-link" title="<?php echo lang('add_banner'); ?>" href="javascript:;"><?php echo lang('add_banner'); ?></a>
                </div>


                <div class="panel table-panel">
                    <div class="panel-body">
                        <?php
                        $querystr = $this->ci()->security->get_csrf_token_name() . '=' . urlencode($this->ci()->security->get_csrf_hash()) . '&search=' . urlencode($search) . '&search_title=' . urlencode($search_title) . '&search_status=' . urlencode($search_status) . '&search_section=' . urlencode($search_section) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';

                        if (count($banner_list) > 0) {
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

                                    <th class="t-center"><?php echo lang('sr_no') ?></th>

                                    <th>
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'ad.title' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('ad.title', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Title"><?php echo lang('title'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'ad.title') {
                                                echo $sort_image;
                                            }
                                            ?></a>

                                    </th>

                                    <th>
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'ad.section_id' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('ad.section_id', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Section"><?php echo lang('section'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'ad.section_id') {
                                                echo $sort_image;
                                            }
                                            ?></a>
                                    </th>

                                    <th class="t-center">
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'ad.status' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('ad.status', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Status"><?php echo lang('status'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'ad.status') {
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
                                            $i = ($this->_ci->session->userdata[get_current_section($this->_ci)]['record_per_page'] * ($page_number - 1)) + 1;
                                        } else {
                                            $i = 1;
                                        }
                                        foreach ($banner_list as $banner_page) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="ckbox ckbox-default">
                                                        <input type="checkbox" id="<?php echo $banner_page['ad']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $banner_page['ad']['id']; ?>">
                                                        <label for="<?php echo $banner_page['ad']['id']; ?>"></label>
                                                    </div>
                                                </td>
                                                <td class="t-center"><?php echo $i; ?></td>
                                                <td><?php echo $banner_page['ad']['title']; ?></td>
                                                <td>
                                                    <?php
                                                    if (array_key_exists($banner_page['ad']['section_id'], $banner_data['sections']))
                                                        echo $banner_data['sections'][$banner_page['ad']['section_id']];
                                                    ?>
                                                </td>
                                                <td class="t-center">
                                                    <?php
                                                    if ($banner_page['ad']['status'] == '1') {
                                                        ?>
                                                        <?php echo add_image(array('active.png')); ?>
                                                        <?php
                                                    } elseif ($banner_page['ad']['status'] == '0') {
                                                        ?> 
                                                        <?php echo add_image(array('inactive.png')); ?>
                                                    <?php } ?>
                                                </td>
                                                <td class="t-center">
                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/banner/view_data/<?php echo $banner_page['l']['language_code'] . "/" . $banner_page['ad']['ad_id']; ?>" title="View Banner"><i class="fa fa-eye"></i></a>

                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/banner/action/edit/<?php echo $banner_page['l']['language_code'] . "/" . $banner_page['ad']['ad_id']; ?>" title="Edit Banner"><i class="fa fa-pencil"></i></a>

                                                    <a class="delete-row" href="javascript:;" onclick="delete_banner('<?php echo $banner_page['ad']['id']; ?>')"><i class="fa fa-trash-o" title="Delete Banner"></i></a>
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
                            'base_url' => base_url() . $this->_data['section_name'] . "/banner/ajax_index/" . $language_code,
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
    function change_search(id)
    {
        if (id == '')
        {
            $("#search_options").hide();
        }
        else
        {
            $("#search_options").show();
        }
        $("#search_options div").hide();

        var value = $("#search_" + id).val();

        $("#search_options .search").val("");
        $("#search_" + id).val(value);

        if (id === 'status') {
            $("#div_status").css('display', '');
        }

        $("#" + id).show();
    }

    function set_session()
    {
        blockUI();
        var search = $("#search").val();
        var searchval = $("#search_" + search).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/set_session/<?php echo $language_code; ?>',
                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: search, searchval: searchval}
                    });
                    unblockUI();
                }


                change_search($("#search").val());

                $(".search").keypress(function(event) {
                    if (event.which == 13) {
                        event.preventDefault();
                        submit_search();
                    }
                });

                function submit_search()
                {
                    $('#error_msg').fadeOut(1000);
                    var search_option = $("#search").val();
                    if (search_option === '')
                    {
                        $('#search').validationEngine('showPrompt', '<?php echo lang('msg-search-sel-req'); ?>', 'error');
                        attach_error_event(); //for remove dynamically populate popup
                        return false;
                    }
                    if (search_option == 'title' && $("#search_title").val() == "")
                    {
                        $('#search_title').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
                        attach_error_event(); //for remove dynamically populate popup
                        return false;
                    }
                    set_session();
                    blockUI();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: encodeURIComponent($('#search').val()), search_title: encodeURIComponent($('#search_title').val()), search_status: encodeURIComponent($('#search_status').val()), search_section: encodeURIComponent($('#search_section').val())},
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
                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>',
                                                data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_title: encodeURIComponent($('#search_title').val()), sort_by: sort_by, sort_order: sort_order},
                                                success: function(data) {
                                                    $("#contentpanel").html(data);
                                                }
                                            });
                                            unblockUI();
                                        }

                                        function reset_data()
                                        {
                                            $("#search_" + $("#search").val()).val("");
                                            $("#search").val("");
                                            set_session();
                                            $('#error_msg').fadeOut(1000); //hide error message it shown up while search
                                            blockUI();
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>',
                                                            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: "", search_title: "", search_status: "", search_section: ""},
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
                                                            if ($(".check_box").length == $(".check_box:checked").length)
                                                            {
                                                                $("#check_all").prop("checked", true);
                                                                $(".check_box").attr("checked", "checked");
                                                            }
                                                            else
                                                            {
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
                                                            alert('Please select atleast one record for active');
                                                            return false;
                                                        }
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>',
                                                                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', type: 'active', ids: val},
                                                                        success: function(data) {
                                                                            //for managing same state while record delete
                                                                            if ($('.rows') && $('.rows').length > 1) {
                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                            } else {
                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                            }
                                                                            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
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
                                                                                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>',
                                                                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val},
                                                                                        success: function(data) {
                                                                                            //for managing same state while record delete
                                                                                            if ($('.rows') && $('.rows').length > 1) {
                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                            } else {
                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                            }
                                                                                            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                            $("#messages").show();
                                                                                                            $("#messages").html(data);
                                                                                                        }
                                                                                                    });
                                                                                                }
                                                                                                function active_all_records()
                                                                                                {
                                                                                                    $.ajax({
                                                                                                        type: 'POST',
                                                                                                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>',
                                                                                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all'},
                                                                                                        success: function(data) {
                                                                                                            //for managing same state while record delete
                                                                                                            if ($('.rows') && $('.rows').length > 1) {
                                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                            } else {
                                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                            }
                                                                                                            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                            $("#messages").show();
                                                                                                                            $("#messages").html(data);
                                                                                                                        }
                                                                                                                    });
                                                                                                                }

                                                                                                                function inactive_all_records()
                                                                                                                {
                                                                                                                    $.ajax({
                                                                                                                        type: 'POST',
                                                                                                                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>',
                                                                                                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all'},
                                                                                                                        success: function(data) {
                                                                                                                            //for managing same state while record delete
                                                                                                                            if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                            } else {
                                                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                            }
                                                                                                                            ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                            $("#messages").show();
                                                                                                                                            $("#messages").html(data);
                                                                                                                                        }
                                                                                                                                    });
                                                                                                                                }

                                                                                                                                function delete_records() {
                                                                                                                                    var val = [];
                                                                                                                                    $(':checkbox:checked').each(function(i) {
                                                                                                                                        val[i] = $(this).val();
                                                                                                                                    });
                                                                                                                                    if (val == "") {
                                                                                                                                        alert('Please select atleast one record for delete');
                                                                                                                                        return false;
                                                                                                                                    }
                                                                                                                                    else {
                                                                                                                                        res = confirm('<?php echo lang('delete_confirm') ?>');
                                                                                                                                        if (res)
                                                                                                                                        {
                                                                                                                                            $.ajax({
                                                                                                                                                type: 'POST',
                                                                                                                                                url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>',
                                                                                                                                                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
                                                                                                                                                success: function(data) {
                                                                                                                                                    //for managing same state while record delete
                                                                                                                                                    if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                                        pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                                    } else {
                                                                                                                                                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                                    }
                                                                                                                                                    ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/banner/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                                                            $("#messages").show();
                                                                                                                                                                            $("#messages").html(data);
                                                                                                                                                                        }
                                                                                                                                                                    });
                                                                                                                                                                }
                                                                                                                                                            }
                                                                                                                                                        }
</script>