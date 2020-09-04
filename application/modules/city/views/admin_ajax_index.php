<div id="ajax_table">
    <div class="main-container">
        <div class="search-box">
            <table cellspacing="2" cellpadding="4" border="0">
                <tbody>
                    <tr>                        
                        <td align="right"><?php echo lang('search-by') ?> :</td>  
                        <td align="left">
                            <?php
                            $search_options = array(
                                'city' => lang('city_name'),
                                'state' => lang('state'),
                                'country' => lang('country'),
                                'status' => lang('status'),
                            );
                            echo form_dropdown('search', $search_options, urldecode($search), 'id=search onchange = change_search(this.value);');
                            ?>
                        </td>
                        <td id='search_options'>
                            <?php
                            $city = array(
                                'name' => 'search_city',
                                'id' => 'search_city',
                                'class' => 'search',
                                'value' => set_value('search_city', urldecode($search_city))
                            );
                            $state = array(
                                'name' => 'search_state',
                                'id' => 'search_state',
                                'class' => 'search',
                                'value' => set_value('search_state', urldecode($search_state))
                            );
                            $country = array(
                                'name' => 'search_country',
                                'id' => 'search_country',
                                'class' => 'search',
                                'value' => set_value('search_country', urldecode($search_country))
                            );

                            $status = array(
                                '' => '---All Status---',
                                '1' => lang('active'),
                                '0' => lang('inactive')
                            );
                            ?>
                            <div id='city'> <?php echo lang('city_name') . " : " . form_input($city) . "  "; ?> </div>
                            <div id='state'> <?php echo lang('state') . " : " . form_input($state) . "  "; ?> </div>
                            <div id='country'> <?php echo lang('country') . " : " . form_input($country) . "  "; ?> </div>
                            <div id='status'> <?php echo lang('status') . " : " . form_dropdown('search_status', $status, urldecode($search_status), 'id=search_status class=search') . "  "; ?> </div>
                        </td>
                        <td>
                            <?php
                            $search_button = array(
                                'content' => lang('btn-search'),
                                'title' => lang('btn-search'),
                                'class' => 'inputbutton',
                                'onclick' => "submit_search()",
                            );
                            echo form_button($search_button);
                            ?>
                        </td>
                        <td>
                            <?php
                            $reset_button = array(
                                'content' => lang('reset_button'),
                                'title' => lang('reset_button'),
                                'class' => 'inputbutton',
                                'onclick' => "reset_data()",
                            );
                            echo form_button($reset_button);
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>            
        </div>
        <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
            <tbody bgcolor="#fff">
                <tr>
                    <th width="30px"><input type="checkbox" name="check_all" id="check_all" value="0"></th>
                    <th><?php echo lang('sr_no'); ?></th>
                    <th>                        
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';
                        if ($sort_by == 'c.city_name' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('c.city_name', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('city_name'); ?>
                            <?php
                            if ($sort_by == 'c.city_name')
                            {
                                ?>
                                <div class="sorting">
                                    <?php echo add_image(array($sort_image)); ?>
                                </div>
                            <?php }
                            ?>
                        </a>                                 
                    </th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';
                        if ($sort_by == 's.state_name' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('s.state_name', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('state'); ?>
                            <?php
                            if ($sort_by == 's.state_name')
                            {
                                ?>
                                <div class="sorting">
                                    <?php echo add_image(array($sort_image)); ?>
                                </div>
                            <?php }
                            ?>
                        </a>  
                    </th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        if ($sort_by == 'cnt.country_name' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('cnt.country_name', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('country'); ?>
                            <?php if ($sort_by == 'cnt.country_name')
                            {
                                ?>
                                <div class="sorting">
                                <?php echo add_image(array($sort_image)); ?>
                                </div>
                            <?php } ?>
                        </a>
                    </th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        if ($sort_by == 'c.status' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('c.status', '<?php echo $field_sort_order; ?>');" ><?php echo lang('status'); ?></a>
                        <?php if ($sort_by == 'c.status')
                        {
                            ?>
                <div class="sorting">
                <?php echo add_image(array($sort_image)); ?>
                </div>
                <?php } ?>
            </th>
            <th><?php echo lang('actions'); ?></th>
            </tr>
            <?php
            $querystr = $this->ci()->security->get_csrf_token_name() . '=' . urlencode($this->ci()->security->get_csrf_hash()) . '&search=' . urlencode($search) . '&search_city=' . urlencode($search_city) . '&search_state=' . urlencode($search_state) . '&search_country=' . urlencode($search_country) . '&search_status=' . urlencode($search_status) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
            if (count($city_list) > 0)
            {
                if ($page_number > 1)
                {
                    $i = ($this->_ci->session->userdata[get_current_section($this->_ci)]['record_per_page'] * ($page_number - 1)) + 1;
                }
                else
                {
                    $i = 1;
                }
                foreach ($city_list as $city_page)
                {
                    if ($i % 2 != 0)
                    {
                        $class = "odd-row";
                    }
                    else
                    {
                        $class = "even-row";
                    }
                    ?>
                    <tr class="<?php echo $class; ?>">
                        <td><input type="checkbox" id="<?php echo $city_page['c']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $city_page['c']['id']; ?>"></td>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $city_page['c']['city_name']; ?></td>
                        <td><?php echo $city_page['s']['state_name']; ?></td>
                        <td><?php echo $city_page['cnt']['country_name']; ?></td>
                        <td>
                            <?php
                            if ($city_page['c']['status'] == '1')
                            {
                                ?>
                                <?php echo add_image(array('active.png')); ?>
                                <?php
                            }
                            elseif ($city_page['c']['status'] == '0')
                            {
                                ?> 
                            <?php echo add_image(array('inactive.png')); ?>
                        <?php } ?>
                        </td>
                        <td>
                            <div class="action">
                                <div class="edit">
                                    <a href="<?php echo site_url() . $this->_data['section_name']; ?>/city/view_data/<?php echo $city_page['l']['language_code'] . "/" . $city_page['c']['city_id']; ?>"><?php echo add_image(array('viewIcon.png')); ?></a>
                                </div>
                                <div class="edit">
                                    <a href="<?php echo site_url() . $this->_data['section_name']; ?>/city/action/edit/<?php echo $city_page['l']['language_code'] . "/" . $city_page['c']['city_id']; ?>" title="<?php echo lang('edit'); ?>"><?php echo add_image(array('edit.png')); ?></a>
                                </div>
                                <div class="delete"><a href='javascript:;' title='<?php echo lang('delete'); ?>' onclick="delete_city('<?php echo $city_page['c']['city_id']; ?>')" ><?php echo add_image(array('delete.png')); ?></a></div>
                            </div>    
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td colspan="9">
                        <?php
                        $reset_button = array(
                            'content' => lang('delete'),
                            'title' => lang('delete'),
                            'class' => 'inputbutton',
                            'onclick' => "delete_records()",
                        );
                        echo form_button($reset_button);
                        ?>
                        <?php
                        $reset_button = array(
                            'content' => lang('active'),
                            'title' => lang('active'),
                            'class' => 'inputbutton',
                            'onclick' => "active_records()",
                        );
                        echo form_button($reset_button);
                        ?>
                        <?php
                        $reset_button = array(
                            'content' => lang('inactive'),
                            'title' => lang('inactive'),
                            'class' => 'inputbutton',
                            'onclick' => "inactive_records()",
                        );
                        echo form_button($reset_button);
                        ?>
                        <?php
                        $reset_button = array(
                            'content' => lang('active-all'),
                            'title' => lang('active-all'),
                            'class' => 'inputbutton',
                            'onclick' => "active_all_records()",
                        );
                        echo form_button($reset_button);
                        ?>
                        <?php
                        $reset_button = array(
                            'content' => lang('inactive-all'),
                            'title' => lang('inactive-all'),
                            'class' => 'inputbutton',
                            'onclick' => "inactive_all_records()",
                        );
                        echo form_button($reset_button);
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php
            $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url() . $this->_data['section_name'] . "/city/ajax_index/" . $language_code,
                'params' => $querystr,
                'element' => 'ajax_table'
            );
            widget('custom_pagination', $options);
        }
        else
        {
            ?>
            <table>
                <tr><td colspan="6"><?php echo lang('no_record_found'); ?></td></tr>
            </table>    
            <?php
        }
        ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("input:visible:first").focus();
    });
    $(".search").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });

    function submit_search()
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        var search_option = $("#search").val();
        if (search_option == 'city' && $("#search_city").val() == "")
        {
            $('#search_city').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        if (search_option == 'state' && $("#search_state").val() == "")
        {
            $('#search_state').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        if (search_option == 'country' && $("#search_country").val() == "")
        {
            $('#search_country').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        set_session();
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: encodeURIComponent($('#search').val()), search_city: encodeURIComponent($('#search_city').val()), search_state: encodeURIComponent($('#search_state').val()), search_country: encodeURIComponent($('#search_country').val()), search_status: encodeURIComponent($('#search_status').val())},
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
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: encodeURIComponent($('#search').val()), search_city: encodeURIComponent($('#search_city').val()), search_state: encodeURIComponent($('#search_state').val()), search_country: encodeURIComponent($('#search_country').val()), search_status: encodeURIComponent($('#search_status').val()), sort_by: sort_by, sort_order: sort_order},
            success: function(data) {
                $("#ajax_table").html(data);
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
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: "", search_city: "", search_state: "", search_country: ""},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        });
    }
    function set_session()
    {
        blockUI();
        var search = $("#search").val();
        var searchval = $("#search_" + search).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/city/set_session/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: search, searchval: searchval}
        });
        unblockUI();
    }
    function change_search(id)
    {
        $("#search_options div").hide();
        var value = $("#search_" + id).val();
        $("#search_options .search").val("");
        $("#search_" + id).val(value);
        $("#" + id).show();
    }
    change_search($("#search").val());

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
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', type: 'active', ids: val},
            success: function(data) {
                //for managing same state while record delete
                if ($('.rows') && $('.rows').length > 1) {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                } else {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
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
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive', ids: val},
            success: function(data) {
                //for managing same state while record delete
                if ($('.rows') && $('.rows').length > 1) {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                } else {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    }
    function active_all_records()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'active_all'},
            success: function(data) {
                //for managing same state while record delete
                if ($('.rows') && $('.rows').length > 1) {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                } else {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    }
    function inactive_all_records()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'inactive_all'},
            success: function(data) {
                //for managing same state while record delete
                if ($('.rows') && $('.rows').length > 1) {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                } else {
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }
                ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                $("#messages").show();
                $("#messages").html(data);
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
        else
        {
            res = confirm('<?php echo lang('delete_confirm') ?>');
            if (res)
            {

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index',
                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
                    success: function(data) {

                        //for managing same state while record delete
                        if ($('.rows') && $('.rows').length > 1) {
                            pageno = "&page_number=<?php echo $page_number; ?>";
                        } else {
                            pageno = "&page_number=<?php echo $page_number - 1; ?>";
                        }
                        ajaxLink('<?php echo base_url() . $this->_data['section_name']; ?>/city/ajax_index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);
                        $("#messages").show();
                        $("#messages").html(data);
                    }
                });
            }
        }
    }
</script>