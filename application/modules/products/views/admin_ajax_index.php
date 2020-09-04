<div id="contentpanel">
    <div class="contentpanel">
        <div class="panel panel-default form-panel">

            <div class="panel-body">
                <form>           

                    <div class="row row-pad-5">

                        <div class="col-lg-3 col-md-3">
                            <?php
                            $search_options = array(
                                'select' => lang('please_select'),
                                'category' => lang('category'),
                                'name' => lang('name'),
                                'slug' => lang('slug'),
                                'status' => lang('status'),
                                'price' => lang('price')
                            );
                            echo form_dropdown('search', $search_options, urldecode($search), 'id=search onchange = change_search(this.value); class=form-control ');
                            ?> 
                        </div>

                        <div class="col-lg-3 col-md-3" id='search_options'>
                            <?php
                            $name = array(
                                'name' => 'search_name',
                                'id' => 'search_name',
                                'class' => 'form-control',
                                'placeholder' => lang('name'),
                                'value' => set_value('search_name', urldecode($search_name))
                            );
                            $status = array(
                                '' => '---All Status---',
                                '1' => lang('active'),
                                '0' => lang('inactive')
                            );
                            $slug = array(
                                'name' => 'search_slug',
                                'id' => 'search_slug',
                                'class' => 'form-control',
                                'placeholder' => lang('slug'),
                                'value' => set_value('search_slug', urldecode($search_slug))
                            );

                            $category = array(
                                'name' => 'search_category',
                                'id' => 'search_category',
                                'module_id' => 5,
                                'value' => (isset($search_category)) ? $search_category : '',
                                'language_id' => $language_id,
                                'first_option' => '--All Categories--'
                            );

                            $from = array(
                                'name' => 'search_from',
                                'id' => 'search_from',
                                'class' => 'form-control',
                                'maxlength' => '10',
                                'placeholder' => isset($search_from) ? $search_from : lang('from'),
                                'value' => set_value('search_from', $search_from),
                            );
                            $to = array(
                                'name' => 'search_to',
                                'id' => 'search_to',
                                'class' => 'form-control',
                                'maxlength' => '10',
                                'placeholder' => isset($search_to) ? $search_to : lang('to'),
                                'value' => set_value('search_to', $search_to),
                            );
                            ?> 

                            <div id='name'> <?php echo form_input($name) . "  "; ?> </div>
                            <div id="slug"><?php echo form_input($slug) . "  "; ?> </div>
                            <div id='div_status'> <?php echo form_dropdown('search_status', $status, urldecode($search_status), 'id=search_status class=form-control') . "  "; ?> </div>
                            <div id='category'><?php widget('category_dropdown', $category); ?></div>
<!--                            <div id='price'><?php echo form_input($from) . " " . form_input($to); ?></div>-->


                        </div> 


                        <div class="col-lg-3 col-md-3" id="divpricefrom">
                            <?php echo form_input($from); ?>
                        </div>
                        <div class="col-lg-3 col-md-3" id="divpriceto">
                            <?php echo form_input($to); ?>
                        </div>


                        <div class="col-lg-3 col-md-3">

                            <?php
                            $search_button = array(
                                'content' => '<i class="fa fa-search"></i> &nbsp;&nbsp;' . lang('btn-search'),
                                'title' => lang('btn-search'),
                                'class' => 'btn btn-primary',
                                'onclick' => "submit_search()",
                            );
                            echo form_button($search_button) . " ";

                            $reset_button = array(
                                'content' => '<i class="fa fa-refresh"></i>  &nbsp;&nbsp;' . lang('reset_button'),
                                'title' => lang('reset_button'),
                                'class' => 'btn btn-default',
                                'onclick' => "reset_data()",
                            );
                            echo "&nbsp;&nbsp;&nbsp;";
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

                    <a class="add-link" href="javascript:;" onclick="openlink('add')" title="<?php echo lang('add_Product'); ?>"><?php echo lang('add_Product'); ?></a>
                </div>

                <div class="panel table-panel">
                    <div class="panel-body">

                        <?php
                        if (count($list) > 0) {
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
                                        if ($sort_by == 'p.name' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>
                                        <a href="#" onclick="sort_data('p.name', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Product Name">
                                            <?php echo lang('name'); ?>
                                            <?php
                                            if ($sort_by == 'p.name') {
                                                echo $sort_image;
                                            }
                                            ?>
                                        </a>
                                    </th>

                                    <th>
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'c.title' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('c.title', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Category Name"> <?php echo lang('category'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'c.title') {
                                                echo $sort_image;
                                            }
                                            ?></a>
                                    </th>


                                    <th>
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'p.slug' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>
                                        <a href="#" onclick="sort_data('p.slug', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Module Name">
                                            <?php echo lang('slug'); ?>
                                            <?php
                                            if ($sort_by == 'p.slug') {
                                                echo $sort_image;
                                            }
                                            ?>
                                        </a>
                                    </th>
                                    <th class="t-center">
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'p.status' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('p.status', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Status"><?php echo lang('status'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'p.status') {
                                                echo $sort_image;
                                            }
                                            ?></a> 
                                    </th>

                                    <th>
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'p.price' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('p.price', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Price"> <?php echo lang('price'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'p.price') {
                                                echo $sort_image;
                                            }
                                            ?></a> 
                                    </th>

                                    <th class="t-center">
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'p.modified_on' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('p.modified_on', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Modified Date"><?php echo lang('last_modified'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'p.modified_on') {
                                                echo $sort_image;
                                            }
                                            ?></a> 
                                    </th>
                                    <th class="t-center"><?php echo lang('product_image'); ?></th>
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
                                        foreach ($list as $page) {
                                            if ($i % 2 != 0) {
                                                $class = "odd-row";
                                            } else {
                                                $class = "even-row";
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="ckbox ckbox-default">
                                                        <input type="checkbox" id="<?php echo $page['p']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $page['p']['id']; ?>" >
                                                        <label for="<?php echo $page['p']['id']; ?>"></label>

                                                    </div>
                                                </td>
                                                <td class="t-center"><?php echo $i; ?></td>
                                                <td><?php echo $page['p']['name']; ?></td>
                                                <td><?php echo $page['c']['title']; ?></td>
                                                <td><?php echo $page['p']['slug']; ?></td>
                                                <td class="t-center">
                                                    <?php
                                                    if ($page['p']['status'] == '1') {
                                                        ?>
                                                        <?php echo add_image(array('active.png')); ?>
                                                        <?php
                                                    } elseif ($page['p']['status'] == '0') {
                                                        ?>
                                                        <?php echo add_image(array('inactive.png')); ?>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $page['p']['price']; ?></td>
                                                <td class="t-center"><?php echo $page['p']['modified_on']; ?></td>

                                                <td class="t-center">
                                                    <a href="<?php echo site_url() . $this->_data['section_name']; ?>/products/image_index/<?php echo $page['p']['product_id']; ?>" title="<?php echo lang('view_product_image'); ?>" ><?php echo lang('view_product_image'); ?></a></div>
                                                </td>

                                                <td>

                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/products/view/<?php echo $page['l']['language_code'] . "/" . $page['p']['product_id']; ?>"><i class="fa fa-eye"></i></a>

                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/products/action/edit/<?php echo $page['l']['language_code'] . "/" . $page['p']['product_id']; ?>" title="<?php echo lang('edit'); ?>"><i class="fa fa-pencil"></i></a>

                                                    <a class="delete-row" href="javascript:;" onclick="delete_product('<?php echo $page['p']['id']; ?>', '<?php echo $page['p']['slug']; ?>')"><i class="fa fa-trash-o"></i></a>

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

                        $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_name=' . urlencode($search_name) . '&search_slug=' . ($search_slug) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '&search=' . $search . '&search_status=' . $search_status . '&search_category=' . $search_category . '&search_from=' . $search_from . '&search_to=' . $search_to;

                        $options = array(
                            'total_records' => $total_records,
                            'page_number' => $page_number,
                            'isAjaxRequest' => 1,
                            'base_url' => base_url() . $this->_data['section_name'] . "/products/ajax_index/" . $language_code,
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
    function submit_search()
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        if ($('#search').val() == 'select') {
            $('#search').validationEngine('showPrompt', '<?php echo lang('msg-search-req-type'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        session_set();

        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>',
                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_name: encodeURIComponent($('#search_name').val()), search_slug: ($('#search_slug').val()), search: $('#search').val(), search_status: encodeURIComponent($('#search_status').val()), search_category: $('#search_category').val(), search_from: $('#search_from').val(), search_to: $('#search_to').val()},
                        success: function(data) {
                            //alert(data);
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
                                url: '<?php echo base_url() . $this->_data['section_name']; ?>/products/session_set/<?php echo $language_code; ?>',
                                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search: $('#search').val(), search_name: $('#search_name').val(), search_slug: $('#search_slug').val(), search_status: $('#search_status').val(), search_category: $('#search_category').val(), search_from: $('#search_from').val(), search_to: $('#search_to').val()}

                                                }
                                        );
                                    }
                                    function sort_data(sort_by, sort_order)
                                    {
                                        blockUI();
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>',
                                                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_name: encodeURIComponent($('#search_name').val()), search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val()), sort_by: sort_by, sort_order: sort_order},
                                                        success: function(data) {
                                                            $("#contentpanel").html(data);
                                                        }
                                                    });
                                                    unblockUI();
                                                }
                                                function reset_data()
                                                {
                                                    $("#search").val("select");
                                                    $("#search_name").val("");
                                                    $("#search_slug").val("");
                                                    $("#search_status").val("");
                                                    $("#search_category").val("0");
                                                    session_set();
                                                    $('#error_msg').fadeOut(1000); //hide error message it shown up while search
                                                    blockUI();
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>',
                                                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_name: "", search: "select", search_status: "", search_category: "0", search_slug: ""},
                                                                    success: function(data) {
                                                                        $("#contentpanel").html(data);
                                                                        unblockUI();
                                                                    }
                                                                });
                                                            }

                                                            function change_search(id)
                                                            {
                                                                if (id != 'select') {
                                                                    $('#search_options').css('display', '');

                                                                }
                                                                else {
                                                                    $('#search_options').css('display', 'none');
                                                                }

                                                                $("#search_options div").hide();
                                                                $('#divpricefrom').css('display', 'none');
                                                                $('#divpriceto').css('display', 'none');


                                                                var value = $("#search_" + id).val();
                                                                $("#search_options .search").val("");
                                                                $("#search_" + id).val(value);

                                                                if (id == 'status') {

                                                                    $("#div_status").show();
                                                                }
                                                                else if (id == 'price') {
                                                                    $("#search_options").hide();
                                                                    $('#divpricefrom').css('display', '');
                                                                $('#divpriceto').css('display', '');
                                                                    
                                                                }
                                                                else {
                                                                    $("#" + id).show();
                                                                }


                                                            }
                                                            change_search($("#search").val());
                                                            $(".search").keypress(function(event) {
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
                                                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>',
                                                                                data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', type: 'active', ids: val, search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                                                                success: function(data) {
                                                                                    //for managing same state while record delete
                                                                                    if ($('.rows') && $('.rows').length > 1) {
                                                                                        pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                    } else {
                                                                                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                    }
                                                                                    ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
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
                                                                                                url: '<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>',
                                                                                                            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val, search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                                                                                            success: function(data) {
                                                                                                                //for managing same state while record delete
                                                                                                                if ($('.rows') && $('.rows').length > 1) {
                                                                                                                    pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                } else {
                                                                                                                    pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                }
                                                                                                                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                $("#messages").show();
                                                                                                                                $("#messages").html(data);
                                                                                                                            }
                                                                                                                        });
                                                                                                                    }


                                                                                                                    function active_all_records()
                                                                                                                    {
                                                                                                                        res = confirm('<?php echo lang('active_all_confirm') ?>');
                                                                                                                        if (res)
                                                                                                                        {
                                                                                                                            $.ajax({
                                                                                                                                type: 'POST',
                                                                                                                                url: '<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>',
                                                                                                                                                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all', search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                                                                                                                                success: function(data) {
                                                                                                                                                    //for managing same state while record delete
                                                                                                                                                    if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                                        pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                                    } else {
                                                                                                                                                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                                    }
                                                                                                                                                    ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                                                        $("#messages").show();
                                                                                                                                                                        $("#messages").html(data);
                                                                                                                                                                    }
                                                                                                                                                                });
                                                                                                                                                            }
                                                                                                                                                            else
                                                                                                                                                            {
                                                                                                                                                                return false;
                                                                                                                                                            }
                                                                                                                                                        }

                                                                                                                                                        function inactive_all_records()
                                                                                                                                                        {
                                                                                                                                                            res = confirm('<?php echo lang('inactive_all_confirm') ?>');
                                                                                                                                                            if (res)
                                                                                                                                                            {
                                                                                                                                                                $.ajax({
                                                                                                                                                                    type: 'POST',
                                                                                                                                                                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>',
                                                                                                                                                                                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all', search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                                                                                                                                                                    success: function(data) {
                                                                                                                                                                                        //for managing same state while record delete
                                                                                                                                                                                        if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                                                                            pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                                                                        } else {
                                                                                                                                                                                            pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                                                                        }
                                                                                                                                                                                        ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index/<?php echo $language_code; ?>', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                                                                                            $("#messages").show();
                                                                                                                                                                                                            $("#messages").html(data);
                                                                                                                                                                                                        }
                                                                                                                                                                                                    });
                                                                                                                                                                                                }
                                                                                                                                                                                                else
                                                                                                                                                                                                {
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
                                                                                                                                                                                                    alert('Please select atleast one record for delete');
                                                                                                                                                                                                    return false;
                                                                                                                                                                                                }
                                                                                                                                                                                                else {
                                                                                                                                                                                                    res = confirm('<?php echo lang('delete_confirm') ?>');
                                                                                                                                                                                                    if (res)
                                                                                                                                                                                                    {
                                                                                                                                                                                                        $.ajax({
                                                                                                                                                                                                            type: 'POST',
                                                                                                                                                                                                            url: '<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index',
                                                                                                                                                                                                            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val, search: encodeURIComponent($('#search').val()), search_status: encodeURIComponent($('#search_status').val())},
                                                                                                                                                                                                            success: function(data) {

                                                                                                                                                                                                                //for managing same state while record delete
                                                                                                                                                                                                                if ($('.rows') && $('.rows').length > 1) {
                                                                                                                                                                                                                    pageno = "&page_number=<?php echo $page_number; ?>";
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                    pageno = "&page_number=<?php echo $page_number - 1; ?>";
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/products/ajax_index', 'contentpanel', '<?php echo $querystr; ?>' + pageno);
                                                                                                                                                                                                                $("#messages").show();
                                                                                                                                                                                                                $("#messages").html(data);
                                                                                                                                                                                                            }
                                                                                                                                                                                                        });
                                                                                                                                                                                                    }
                                                                                                                                                                                                    else
                                                                                                                                                                                                    {
                                                                                                                                                                                                        return false;
                                                                                                                                                                                                    }
                                                                                                                                                                                                }
                                                                                                                                                                                            }
</script>