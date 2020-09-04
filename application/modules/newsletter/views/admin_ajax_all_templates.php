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
                                'class' => 'form-control',
                                'placeholder' => lang('search-by-template-title'),
                                'value' => set_value('search_term', urldecode($search_term))
                            );
                            echo form_input($input_data);
                            ?>
                        </div>               
                        <div class="col-lg-3 col-md-3">
                            <?php
                            $search_button = array(
                                'content' => '<i class = "fa fa-search" ></i> &nbsp; '.lang('btn-search'),
                                'title' => lang('btn-search'),
                                'class' => 'btn btn-primary',
                                'onclick' => "submit_search()",
                            );
                            echo form_button($search_button);
                            ?>
                            <!--                        <button class="btn btn-primary">Search</button>-->

                            <?php
                            $reset_button = array(
                                'content' => '<i class = "fa fa-refresh" ></i> &nbsp; '.lang('reset_button'),
                                'title' => lang('reset_button'),
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

                    <!--                <h3 class="mb15">Table With Actions</h3>-->

                    <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>



                    <?php echo anchor(site_url() . $this->_data['section_name'] . '/newsletter/templates_actions/add/' . $language_code, lang('add_templates'), ' class = "add-link" '); ?>

                </div>


                <div class="panel table-panel">
                    <div class="panel-body">
                        <?php if (!empty($templates)) { ?>
                            <div class="table-responsive">          		
                                <table class="table table-hover gradienttable">
                                    <thead>
                                        <tr>
    <!--                                            <th>
                                    <div class="ckbox ckbox-default">
                                        <input type="checkbox" name="check_all" id="check_all" value="0" />
                                        <label for="check_all"></label>
                                    </div>
                                    </th>-->
                                            <th class="t-center"><?php echo lang('no'); ?></th>
                                            <th>
                                                <?php
                                                $field_sort_order = 'asc';
                                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                                if ($sort_by == 't.template_title' && $sort_order == 'asc') {
                                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                                    $field_sort_order = 'desc';
                                                }
                                                ?>
                                                <a href="javascript:;" onclick="sort_data('t.template_title', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Title"><?php echo lang('template_title'); ?>&nbsp;&nbsp;&nbsp;<?php
                                                    if ($sort_by == 't.template_title') {
                                                        echo $sort_image;
                                                    }
                                                    ?></a>
                                            </th>
                                            <th>
                                                <?php
                                                $field_sort_order = 'asc';
                                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                                if ($sort_by == 't.template_view_file' && $sort_order == 'asc') {
                                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                                    $field_sort_order = 'desc';
                                                }
                                                ?>
                                                <a href="javascript:;" onclick="sort_data('t.template_view_file', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by View File"><?php echo lang('template_view_file'); ?>&nbsp;&nbsp;&nbsp;<?php
                                                    if ($sort_by == 't.template_view_file') {
                                                        echo $sort_image;
                                                    }
                                                    ?></a>
                                            </th>
                                            <th class="t-center"><?php echo lang('action-title'); ?></th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php
                                        if ($page_number > 1) {
                                            $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page'] * ($page_number - 1)) + 1;
                                        } else {
                                            $i = 1;
                                        }
                                        foreach ($templates as $user) {
                                            $template_id = $user['t']['template_id'];
                                            ?>
                                            <tr>
                                                <td class="t-center"><?php echo $i; ?></td>
                                                <td><?php echo $user['t']['template_title']; ?></td>
                                                <td><?php echo $user['t']['template_view_file']; ?></td>
                                                <td class="t-center">
                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/newsletter/templates_actions/edit/<?php echo $language_code; ?>/<?php echo $template_id; ?>"><i class="fa fa-pencil"></i></a>

                                                    <a class="delete-row" href="javascript:;" onclick="delete_template('<?php echo $template_id; ?>', '<?php echo $language_id; ?>')"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }

                                        echo form_hidden('search_text', (isset($search_text)) ? $search_text : '' );
                                        echo form_hidden('page_number', "", "page_number");
                                        echo form_hidden('per_page_result', "", "per_page_result");
                                        ?>
                                    </tbody>
                                </table>

                            </div>

                            <!--                            <div class="btn-panel mb15">
                                                            <button onclick="delete_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-trash-o"></i></span>Delete</button>
                                                            <button onclick="active_records()" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active</button>
                                                            <button onclick="inactive_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>In Active</button>
                                                            <button onclick="active_all_records()" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active All</button>
                                                            <button onclick="inactive_all_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>Inactive All</button>
                                                        </div>-->

                            <?php
                        } else {
                            echo 'No Record(s) Found';
                        }
                        ?>


                        <?php
                        $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . $search_term . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';

                        $options = array(
                            'total_records' => $total_records,
                            'page_number' => $page_number,
                            'isAjaxRequest' => 1,
                            'base_url' => base_url() . $this->_data['section_name'] . "/newsletter/ajax_all_templates",
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
    $("#search_term").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    function submit_search()
    {
//        if ($('#search_term').val() == '') {
//            $('#search_term').validationEngine('showPrompt', '<?php echo lang('subject_required'); ?>', 'error');
//            attach_error_event(); //for remove dynamically populate popup
//            return false;
//        }
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/newsletter/ajax_all_templates/<?php echo $language_code; ?>',
                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: $('#search_term').val()},
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
                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/newsletter/ajax_all_templates/<?php echo $language_code; ?>',
                                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: $('#search_term').val(), sort_by: sort_by, sort_order: sort_order},
                                    success: function(data) {
                                        $("#contentpanel").html(data);
                                    }
                                });
                                unblockUI();
                            }
                            function delete_template(id, lang_id) {
                                res = confirm('<?php echo lang('delete-alert') ?>');
                                if (res) {
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo base_url() . $this->_data['section_name']; ?>/newsletter/delete_template',
                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', id: id, language_id: lang_id},
                                        success: function(data) {
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url() . $this->_data['section_name']; ?>/newsletter/ajax_all_templates/<?php echo $language_code; ?>',
                                                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>'},
                                                                        success: function(data1) {
                                                                           
                                                                            $("#menu-content-box").html(data1);
//                                                                            $("#menu-content-box").show();
//                                                                            $("#menu-content-box").html(data + data1);
                                                                            
                                                                        }
                                                                       
                                                                    });
                                                                     $("#messages").show();
                                                                        $("#messages").html(data);
                                                                }
                                                            });
                                                        } else {
                                                            return false;
                                                        }
                                                    }
                                                    function reset_data()
                                                    {
                                                        blockUI();
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: '<?php echo base_url() . $this->_data['section_name']; ?>/newsletter/ajax_all_templates/<?php echo $language_code; ?>',
                                                                        data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: ""},
                                                                        success: function(data) {
                                                                            $("#menu-content-box").html(data);
                                                                        }
                                                                    });
                                                                    unblockUI();
                                                                }
</script>