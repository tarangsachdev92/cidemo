<div id="contentpanel">
    <div class="contentpanel">        
        <div class="panel panel-default form-panel">
            <div class="panel-body">
                <div class="row row-pad-5"> 
                    <div class="col-lg-3 col-md-3">
                        <?php
                        $input_data = array(
                            'name' => 'search_term',
                            'id' => 'search_term',
                            'value' => set_value('search_term', urldecode($search_term)),
                            'class' => 'form-control',
                            'placeholder' => lang('search_by_category')
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

                    <?php echo anchor(site_url() . $this->_data["section_name"] . '/forum/action/', lang('add-forum'), 'title="Add Forum" class="add-link" '); ?>

                </div>

                <div class="panel table-panel">
                    <div class="panel-body">
                        <?php if (!empty($categories)) { ?>
                            <div class="table-responsive">          		
                                <table class="table table-hover gradienttable">
                                    <thead>
                                        <tr>
                                            
                                            <th class="t-center"><?php echo lang('no') ?></th>

                                            <th>
                                                <?php
                                                $field_sort_order = 'asc';
                                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                                if ($sort_by == 'title' && $sort_order == 'asc') {
                                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                                    $field_sort_order = 'desc';
                                                }
                                                ?>

                                                <a href="javascript:;" onclick="sort_data('title', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Categories"><?php echo lang('categories'); ?>&nbsp;&nbsp;&nbsp;<?php
                                                    if ($sort_by == 'title') {
                                                        echo $sort_image;
                                                    }
                                                    ?></a>

                                            </th>

                                            <th>
                                                <?php echo lang('total_forum'); ?>
                                            </th>
                                            <th class="t-center"><?php echo lang('status'); ?></th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($page_number > 1) {
                                            $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page'] * ($page_number - 1)) + 1;
                                        } else {
                                            $i = 1;
                                        }
                                        foreach ($categories as $category) {
                                            $category_id = $category['categories']['category_id'];
                                            ?>
                                            <tr>
                                                <td class="t-center"><?php echo $i; ?></td>
                                                <td>
                                                    <a href="<?php echo site_url() . $this->_data["section_name"]; ?>/forum/forum_listing/<?php echo $category_id . "/" . $language_code; ?>" title="see forums"><?php echo $category['categories']['title']; ?></a>
                                                </td>
                                                <td>
                                                    <?php echo $category['categories']['total_forum' . $category_id]; ?>
                                                </td>
                                                <td class="t-center">
                                                    <?php
                                                    if ($category['categories']['status'] == '1') {
                                                        echo add_image(array('active.png'), '', '', array('title' => 'active', 'alt' => "active"));
                                                    } else {
                                                        echo add_image(array('inactive.png'), '', '', array('title' => 'inactive', 'alt' => "inactive"));
                                                    }
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
                            <?php
                        } else {
                            echo 'No Record(s) Found';
                        }
                        
                        echo form_hidden('search_text', (isset($search_text)) ? $search_text : '' );
                        echo form_hidden('page_number', "", "page_number");
                        echo form_hidden('per_page_result', "", "per_page_result");

                        $options = array(
                            'total_records' => $total_records,
                            'page_number' => $page_number,
                            'isAjaxRequest' => 1,
                            'base_url' => base_url() . $this->_data["section_name"] . "/forum/ajax_index/" . $language_code,
                            'params' => $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '',
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
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        if ($('#search_term').val() == '') {
            $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg_search_req'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data["section_name"]; ?>/forum/ajax_index/<?php echo $language_code; ?>',
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
                        url: '<?php echo base_url() . $this->_data["section_name"]; ?>/forum/ajax_index/<?php echo $language_code; ?>',
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
                                    url: '<?php echo base_url() . $this->_data["section_name"]; ?>/forum/ajax_index/<?php echo $language_code; ?>',
                                                data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: ""},
                                                success: function(data) {
                                                    $("#contentpanel").html(data);
                                                    unblockUI();
                                                }
                                            });
                                        }
</script>