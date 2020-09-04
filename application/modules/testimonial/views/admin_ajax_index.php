<div id="contentpanel">
    <div class="contentpanel">
        <div class="panel panel-default form-panel">
            <div class="panel-body">

                <div class="row row-pad-5">
                    <div class="col-lg-3 col-md-3">
                        <?php
                        $search_type = array(
                            'select' => '--Select--',
                            'testimonial_name' => lang('testimonial_name'),
                            'testimonial_slug' => lang('slug'),
                            'person_name' => lang('person_name'),
                            'company_name' => lang('company_name'),
                            'created_on' => lang('date')
                        );

                        echo form_dropdown('search_type', $search_type, ((isset($search_type_cont)) ? $search_type_cont : 'select'), 'id="search_type" class="form-control" onchange = change_search(this.value);');
                        ?>

                    </div>
                    <?php if ($search_type_cont != 'select' && $search_type_cont != 'created_on') {
                        ?>
                        <div class="col-lg-3 col-md-3 textfield" style="display: none;">
                            <?php
                        } else {
                            ?>

                            <div class="col-lg-3 col-md-3 textfield">
                                <?php
                            }

                            $search = array(
                                'name' => 'search_term',
                                'id' => 'search_term',
                                'class' => 'search form-control',
                                'placeholder' => lang('msg-search-req'),
                                'value' => set_value('search_term', (isset($search_term)) ? $search_term : '')
                            );
                            echo form_input($search);
                            ?>
                        </div>
                        <?php if ($search_type_cont != 'created_on') {
                            ?>
                            <div class="col-lg-3 col-md-3 datefield" style="display: none;">
                                <?php
                            } else {
                                ?>

                                <div class="col-lg-3 col-md-3 datefield">
                                    <?php
                                }

                                $search_date_from = array(
                                    'name' => 'date_from',
                                    'id' => 'date_from',
                                    'class' => 'search form-control',
                                    'placeholder' => lang('from'),
                                    'value' => set_value('date_from', $date_from)
                                );
                                echo form_input($search_date_from) . "";
                                ?>
                            </div>
                            <div class="col-lg-3 col-md-3 datefield">
                                <?php
                                $search_date_to = array(
                                    'name' => 'date_to',
                                    'id' => 'date_to',
                                    'class' => 'search form-control',
                                    'placeholder' => lang('to'),
                                    'value' => set_value('date_to', $date_to)
                                );
                                echo form_input($search_date_to);
                                ?>
                            </div>
                            <div class="col-lg-3 col-md-3">

                                <?php
                                $options = array(
                                    'name' => 'category_id',
                                    'id' => 'category_id',
                                    'class' => 'form-control',
                                    'module_id' => TESTIMONIAL_MODULE_NO,
                                    'value' => (isset($search_category)) ? $search_category : '',
                                    'language_id' => $language_id,
                                    'first_option' => '--All Categories--'
                                );


                                widget('category_dropdown', $options);
                                ?>  <br/><span class="warning-msg"><?php echo form_error('parent_id'); ?></span>
                            </div>

                        </div>
                        <div class="row row-pad-5">

                            <div class="col-lg-3 col-md-3">
                                <?php
                                $status = array(
                                    '' => '---All Status---',
                                    '1' => lang('publish'),
                                    '0' => lang('unpublish')
                                );
                                ?>
                                <?php echo form_dropdown('search_status', $status, isset($search_status) ? $search_status : ' ', 'id=search_status class="search form-control"') . "  "; ?> </span>

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
                                    'content' => '<i class="fa fa-refresh"></i> &nbsp;' . lang('btn-reset'),
                                    'title' => lang('btn-reset'),
                                    'class' => 'btn btn-default',
                                    'onclick' => "reset_data()",
                                    "type" => "reset"
                                );
                                echo "&nbsp;&nbsp;&nbsp;";
                                echo form_button($reset_button);
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">

                        <div class="panel-header clearfix">

                            <!--                <h3 class="mb15">Table With Actions</h3>-->

                            <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>

                            <a class="add-link" href="<?php echo site_url() . $section_name . '/testimonial/action/add/' . $language_code ?>" title="<?php echo lang('add-testimonial'); ?>"><?php echo lang('add-testimonial'); ?></a>
                        </div>


                        <div class="panel table-panel">
                            <div class="panel-body">

                                <?php
                                $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '&date_from=' . $date_from . '&date_to=' . $date_to . '';

                                if (!empty($records)) {
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
                                                if ($sort_by == 'category_name' && $sort_order == 'asc') {
                                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                                    $field_sort_order = 'desc';
                                                }
                                                ?>

                                                <a href="javascript:;" onclick="sort_data('category_name', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Category"><?php echo lang('category'); ?>&nbsp;&nbsp;&nbsp;<?php
                                                    if ($sort_by == 'category_name') {
                                                        echo $sort_image;
                                                    }
                                                    ?></a>

                                            </th>

                                            <th>
                                                <?php
                                                $field_sort_order = 'asc';
                                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                                if ($sort_by == 'testimonial_name' && $sort_order == 'asc') {
                                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                                    $field_sort_order = 'desc';
                                                }
                                                ?>

                                                <a href="javascript:;" onclick="sort_data('testimonial_name', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Testimonial Name">  <?php echo lang('testimonial_name'); ?>&nbsp;&nbsp;&nbsp;<?php
                                                    if ($sort_by == 'testimonial_name') {
                                                        echo $sort_image;
                                                    }
                                                    ?></a>
                                            </th>

                                            <th>
                                                <?php
                                                $field_sort_order = 'asc';
                                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                                if ($sort_by == 'testimonial_slug' && $sort_order == 'asc') {
                                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                                    $field_sort_order = 'desc';
                                                }
                                                ?>

                                                <a href="javascript:;" onclick="sort_data('testimonial_slug', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Slug"> <?php echo lang('slug'); ?>&nbsp;&nbsp;&nbsp;<?php
                                                    if ($sort_by == 'testimonial_slug') {
                                                        echo $sort_image;
                                                    }
                                                    ?></a>
                                            </th>
                                            <th>
                                                <?php
                                                $field_sort_order = 'asc';
                                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                                if ($sort_by == 'created_on' && $sort_order == 'asc') {
                                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                                    $field_sort_order = 'desc';
                                                }
                                                ?>

                                                <a href="javascript:;" onclick="sort_data('created_on', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Date"><?php echo lang('date'); ?>&nbsp;&nbsp;&nbsp;<?php
                                                    if ($sort_by == 'created_on') {
                                                        echo $sort_image;
                                                    }
                                                    ?></a>

                                            </th>

                                            <th>
                                                <?php
                                                $field_sort_order = 'asc';
                                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                                if ($sort_by == 'firstname' && $sort_order == 'asc') {
                                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                                    $field_sort_order = 'desc';
                                                }
                                                ?>

                                                <a href="javascript:;" onclick="sort_data('firstname', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Person Name"><?php echo lang('person_name'); ?>&nbsp;&nbsp;&nbsp;<?php
                                                    if ($sort_by == 'firstname') {
                                                        echo $sort_image;
                                                    }
                                                    ?></a>

                                            </th>

                                            <th>
                                                <?php
                                                $field_sort_order = 'asc';
                                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                                if ($sort_by == 'company_name' && $sort_order == 'asc') {
                                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                                    $field_sort_order = 'desc';
                                                }
                                                ?>

                                                <a href="javascript:;" onclick="sort_data('company_name', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Company Name"><?php echo lang('company_name'); ?>&nbsp;&nbsp;&nbsp;<?php
                                                    if ($sort_by == 'company_name') {
                                                        echo $sort_image;
                                                    }
                                                    ?></a>

                                            </th>

                                            <th class="t-center">
                                                <?php
                                                $field_sort_order = 'asc';
                                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                                if ($sort_by == 'is_published' && $sort_order == 'asc') {
                                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                                    $field_sort_order = 'desc';
                                                }
                                                ?>

                                                <a href="javascript:;" onclick="sort_data('is_published', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Status">  <?php echo lang('status'); ?>&nbsp;&nbsp;&nbsp;<?php
                                                    if ($sort_by == 'is_published') {
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

                                                foreach ($records as $record) {
                                                    if ($i % 2 != 0) {
                                                        $class = "odd-row";
                                                    } else {
                                                        $class = "even-row";
                                                    }
                                                    ?>
                                                    <?php $testimonial_date = explode(" ", $record['R']['created_on']); ?>
                                                    <tr>
                                                        <td>
                                                            <div class="ckbox ckbox-default">
                                                                <input type="checkbox" id="<?php echo $record['R']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $record['R']['id']; ?>">
                                                                <label for="<?php echo $record['R']['id']; ?>"></label>

                                                            </div>
                                                        </td>
                                                        <td class="t-center"><?php echo $i; ?></td>
                                                        <td><?php echo $record['C']['title']; ?></td>
                                                        <td><?php echo $record['R']['testimonial_name']; ?></td>
                                                        <td><?php echo $record['R']['testimonial_slug']; ?></td>
                                                        <td><?php echo $testimonial_date[0]; ?> </td>
                        <!--                            <td><img src="<?php echo base_url(); ?>/<?php echo $record['R']['logo']; ?>" height="50px" /></td>-->
                                                        <td><?php echo $record['U']['firstname']; ?>  <?php echo $record['U']['lastname']; ?></td>
                                                        <td>
                                                            <?php
                                                            echo (!empty($record['R']['company_name'])) ? $record['R']['company_name'] : '---';
                                                            ?>
                                                        </td>
                                                        <td class="t-center">
                                                            <?php
                                                            if ($record['R']['is_published'] == PUBLISH) {
                                                                echo add_image(array('active.png'), "", "", array('alt' => 'Publish', 'title' => "Publish"));
                                                            } else {
                                                                echo add_image(array('inactive.png'), "", "", array('alt' => 'Unpublish', 'title' => "Unpublish"));
                                                            }
                                                            ?></td>
                                                        <td class="t-center">
                                                            <?php $record_id = $record['R']['id']; ?>
                                                            <a class="mr5" href="<?php echo site_url(); ?><?php echo $section_name; ?>/testimonial/testimonial_detail/<?php echo $language_code; ?>/<?php echo $record['R']['testimonial_slug']; ?>"><i class="fa fa-eye"></i></a>

                                                            <a class="mr5" href="<?php echo site_url(); ?><?php echo $section_name; ?>/testimonial/action/edit/<?php echo $language_code; ?>/<?php echo $record['R']['testimonial_id']; ?>"><i class="fa fa-pencil"></i></a>

                                                            <a class="delete-row" href="javascript:;" onclick="delete_record('<?php echo $record_id ?>')"><i class="fa fa-trash-o"></i></a>

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
                                        <button onclick="active_records()" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Publish</button>
                                        <button onclick="inactive_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>Unpublish</button>
                                        <button onclick="active_all_records()" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Publish All</button>
                                        <button onclick="inactive_all_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>Unpublish All</button>
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
                                    'base_url' => base_url() . $this->_data['section_name'] . "/testimonial/ajax_index/" . $language_code,
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
    </div>
</div>

<script type="text/javascript">
    var startDate = $('#date_from');
    var endDate = $('#date_to');
    startDate.datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        onClose: function() {
            if (endDate.val() !== '') {
                var testStartDate = startDate.datepicker('getDate');
                var testEndDate = endDate.datepicker('getDate');
                if (testStartDate > testEndDate) {
                    endDate.datepicker('setDate', testStartDate);
                }
            }
        },
        onSelect: function() {
            endDate.datepicker('option', 'minDate', startDate.datepicker('getDate'));
        }
    });
    endDate.datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        onClose: function() {
            if (startDate.val() !== '') {
                var testStartDate = startDate.datepicker('getDate');
                var testEndDate = endDate.datepicker('getDate');
                if (testStartDate > testEndDate) {
                    startDate.datepicker('setDate', testEndDate);
                }
            }
        },
        onSelect: function() {
            startDate.datepicker('option', 'maxDate', endDate.datepicker('getDate'));
        }
    });


    function change_search(id)
    {
        if (id == 'created_on')
        {
            $(".textfield").hide();
            $(".datefield").show();
        }
        else if (id == 'testimonial_name' || id == 'company_name' || id == 'person_name' || id == 'testimonial_slug') {
            $(".textfield").show();
            $(".datefield").hide();
        }
        else {
            $(".textfield").hide();
            $(".datefield").hide();
        }
    }
    change_search($("#search_type").val());

    $("#search_term").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    $("#category_id").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    $("#date_from").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    $("#date_to").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
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
            url: '<?php echo base_url() ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>',
                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', type: 'active', ids: val},
                        success: function(data) {
                            //for managing same state while record delete
                            if ($('.rows') && $('.rows').length > 1) {
                                pageno = "&page_number=<?php echo $page_number; ?>";
                            } else {
                                pageno = "&page_number=<?php echo $page_number; ?>";
                            }
                            ajaxLink('<?php echo base_url() ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
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
                                        url: '<?php echo base_url() ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>',
                                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val},
                                                    success: function(data) {
                                                        //for managing same state while record delete
                                                        if ($('.rows') && $('.rows').length > 1) {
                                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                                        } else {
                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                                        }
                                                        ajaxLink('<?php echo base_url() ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                        $("#messages").show();
                                                                        $("#messages").html(data);



                                                                    }
                                                                });
                                                            }
                                                            function active_all_records()
                                                            {
//                                                                            alert('Are you sure You want to Publish all Records');
                                                                $.ajax({
                                                                    type: 'POST',
                                                                    url: '<?php echo base_url() ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>',
                                                                                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all'},
                                                                                success: function(data) {

                                                                                    if ($('.rows') && $('.rows').length > 1) {
                                                                                        pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                    } else {
                                                                                        pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                    }
                                                                                    ajaxLink('<?php echo base_url() ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                    $("#messages").show();
                                                                                                    $("#messages").html(data);
                                                                                                }
                                                                                            });
                                                                                        }

                                                                                        function inactive_all_records()
                                                                                        {
//                                                                                                        alert('Are you sure You want to UnPublish all Records');
                                                                                            $.ajax({
                                                                                                type: 'POST',
                                                                                                url: '<?php echo base_url() ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>',
                                                                                                            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all'},
                                                                                                            success: function(data) {
                                                                                                                //for managing same state while record delete
                                                                                                                if ($('.rows') && $('.rows').length > 1) {
                                                                                                                    pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                } else {
                                                                                                                    pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                }
                                                                                                                ajaxLink('<?php echo base_url() ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
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
                                                                                                                        if (val == "")
                                                                                                                        {
                                                                                                                            alert('Please select atleast one record for delete');
                                                                                                                            return false;
                                                                                                                        }
                                                                                                                        else
                                                                                                                        {
                                                                                                                            res = confirm('<?php echo lang('delete-alert') ?>');
                                                                                                                            if (res) {

                                                                                                                                $.ajax({
                                                                                                                                    type: 'POST',
                                                                                                                                    url: '<?php echo base_url() ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>',
                                                                                                                                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
                                                                                                                                                        success: function(data) {
                                                                                                                                                            //for managing same state while record delete
                                                                                                                                                            if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                                                pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                                            } else {
                                                                                                                                                                pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                                            }
                                                                                                                                                            ajaxLink('<?php echo base_url(); ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);

                                                                                                                                                                                    //set responce message
                                                                                                                                                                                    $("#messages").show();
                                                                                                                                                                                    $("#messages").html(data);
                                                                                                                                                                                }
                                                                                                                                                                            });

                                                                                                                                                                        } else {
                                                                                                                                                                            return false;
                                                                                                                                                                        }
                                                                                                                                                                    }
                                                                                                                                                                }

                                                                                                                                                                function submit_search()
                                                                                                                                                                {
                                                                                                                                                                    session_set();
                                                                                                                                                                    blockUI();
                                                                                                                                                                    $.ajax({
                                                                                                                                                                        type: 'POST',
                                                                                                                                                                        url: '<?php echo base_url(); ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>',
                                                                                                                                                                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_type: encodeURIComponent($('#search_type').val()), search_term: $('#search_term').val(), search_category: $('#category_id').val(), search_status: $('#search_status').val(), date_from: $('#date_from').val(), date_to: $('#date_to').val()},
                                                                                                                                                                                    success: function(data) {
                                                                                                                                                                                        $("#contentpanel").html(data);

                                                                                                                                                                                    }
                                                                                                                                                                                });
                                                                                                                                                                                unblockUI();
                                                                                                                                                                            }

                                                                                                                                                                            function session_set()
                                                                                                                                                                            {
                                                                                                                                                                                $.ajax(
                                                                                                                                                                                        {
                                                                                                                                                                                            type: 'POST',
                                                                                                                                                                                            url: '<?php echo base_url(); ?><?php echo $section_name; ?>/testimonial/session_set/<?php echo $language_code; ?>',
                                                                                                                                                                                                                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_type: $('#search_type').val(), search_term: $('#search_term').val(), search_category: $('#category_id').val(), search_status: $('#search_status').val(), date_from: $('#date_from').val(), date_to: $('#date_to').val()}
                                                                                                                                                                                                            }
                                                                                                                                                                                                    );
                                                                                                                                                                                                }
                                                                                                                                                                                                function sort_data(sort_by, sort_order)
                                                                                                                                                                                                {
                                                                                                                                                                                                    $('#error_msg').fadeOut(1000); //hide error message it shown up while search
                                                                                                                                                                                                    blockUI();
                                                                                                                                                                                                    $.ajax({
                                                                                                                                                                                                        type: 'POST',
                                                                                                                                                                                                        url: '<?php echo base_url(); ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index',
                                                                                                                                                                                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val()), sort_by: sort_by, sort_order: sort_order},
                                                                                                                                                                                                        success: function(data) {
                                                                                                                                                                                                            $("#contentpanel").html(data);
                                                                                                                                                                                                            unblockUI();
                                                                                                                                                                                                        }
                                                                                                                                                                                                    });
                                                                                                                                                                                                }
                                                                                                                                                                                                function reset_data()
                                                                                                                                                                                                {
                                                                                                                                                                                                    $("#search_type").val("select");
                                                                                                                                                                                                    $("#search_term").val(" ");
                                                                                                                                                                                                    $("#date_from").val(" ");
                                                                                                                                                                                                    $("#date_to").val(" ");
                                                                                                                                                                                                    $("#search_status").val(" ");
                                                                                                                                                                                                    $("#serach_category").val("0");
                                                                                                                                                                                                    session_set();
                                                                                                                                                                                                    $('#error_msg').fadeOut(1000); //hide error message it shown up while search
                                                                                                                                                                                                    blockUI();
                                                                                                                                                                                                    $.ajax({
                                                                                                                                                                                                        type: 'POST',
                                                                                                                                                                                                        url: '<?php echo base_url(); ?><?php echo $this->_data['section_name']; ?>/testimonial/ajax_index/<?php echo $language_code; ?>',
                                                                                                                                                                                                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: "", date_from: "", date_to: "", search_status: "", search_category: "", search_type: "select"},
                                                                                                                                                                                                                    success: function(data) {

                                                                                                                                                                                                                        $("#contentpanel").html(data);
                                                                                                                                                                                                                        unblockUI();
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                });
                                                                                                                                                                                                            }
</script>
