<div id="ajax_table">
    <div class="main-container">
        <div class="search-box">
            <table cellspacing="2" cellpadding="4" border="0">
                <tbody>
                    <tr>
                        <td align="left" >
                        </td>  
                    </tr>
                    <tr>
                        <?php
                        $start_date1 = array(
                            'name' => 'start_date',
                            'id' => 'start_date',
                            'value' => set_value('start_date', urldecode($start_date))
                        );
                        $end_date1 = array(
                            'name' => 'end_date',
                            'id' => 'end_date',
                            'value' => set_value('end_date', urldecode($end_date))
                        );
                        $user_id1 = array(
                            'name' => 'user_id',
                            'id' => 'user_id',
                            'value' => set_value('user_id', urldecode($user_id))
                        );
                        ?>
                        <td align="left" colspan="2">
                            <table>
                                <tr>
                                    <td><?php echo lang('start-date') ?>:</td>                   
                                    <td><?php echo form_input($start_date1); ?></td>
                                    <td><?php echo lang('end-date') ?>:</td>
                                    <td><?php echo form_input($end_date1); ?></td>
                                    <td><?php echo lang('ad-id') ?>:</td>
                                    <td><?php
                                            $ad_id1 = array(
                                                'name' => 'ad_id_h',
                                                'id' => 'ad_id_h',
                                            );
                                        echo form_dropdown('ad_id', $ad_list, $ad_id != 0 ? urldecode($ad_id) : 0, 'id=ad_id');
                                        echo form_hidden($ad_id1);
                                        ?>
                                    </td>
                                    <script type="text/javascript">
                                        $('#start_date').datepicker({
                                            dateFormat: 'yy-mm-dd'
                                        });
                                        $('#end_date').datepicker({
                                            dateFormat: 'yy-mm-dd'
                                        });
                                    </script>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <?php
                            $apply_filter = array(
                                'content' => lang('apply-filter'),
                                'title' => lang('apply-filter'),
                                'class' => 'inputbutton',
                                'onclick' => "apply_filter()",
                            );
                            echo form_button($apply_filter);
                            ?>
                        </td>
                        <td>
                            <?php
                            $reset_filter = array(
                                'content' => lang('reset-filter'),
                                'title' => lang('reset-filter'),
                                'class' => 'inputbutton',
                                'onclick' => "reset_filter()",
                            );
                            echo form_button($reset_filter);
                            ?>
                        </td>
                    </tr>
            </tbody>
        </table>
   </div>
        <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
            <tbody bgcolor="#fff">
                <tr>
                    <th height="25"><?php echo lang('sr_no'); ?></th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';
                        if ($sort_by == 'title' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('title', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('ad-title'); ?>
                            <?php
                            if ($sort_by == 'title')
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
                        <?php echo lang('user-id'); ?>
                    </th>
                    <th>    <?php echo lang('ip'); ?> </th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = 'srt_down.png';
                        if ($sort_by == 'v.visited_date' && $sort_order == 'asc')
                        {
                            $sort_image = 'srt_up.png';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('v.visited_date', '<?php echo $field_sort_order; ?>');" >
                            <?php echo lang('visited-date'); ?>
                            <?php
                            if ($sort_by == 'v.visited_date')
                            {
                                ?>
                                <div class="sorting">
                                <?php echo add_image(array($sort_image)); ?>
                                </div>
                                <?php }
                            ?>
                        </a>
                    </th>
                </tr>
                <?php
                if (count($visitor_list) > 0)
                {                  
                    if ($page_number > 1)
                    {
                        $i = ($this->_ci->session->userdata[get_current_section($this->_ci)]['record_per_page'] * ($page_number - 1)) + 1;
                    }
                    else
                    {
                        $i = 1;
                    }
                    foreach ($visitor_list as $visitor)
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
                            <td><?php echo $i; ?></td>
                            <td><?php echo $visitor['a']['title']; ?></td>

                            <td><?php echo $visitor['v']['user_id']; ?></td>
                            <td>
                                <?php echo $visitor['v']['ip']; ?>
                            </td>
                            <td>
                                 <?php echo $visitor['v']['visited_date']; ?>
                            </td>

                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <?php
            $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url() . $this->_data['section_name'] . "/banner/visitor_ajax_index/" . $language_code,
                'params' => $this->ci()->security->get_csrf_token_name() . '=' . urlencode($this->ci()->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&ad_id=' . urlencode($ad_id) . '&start_date=' . urlencode($start_date) . '&end_date=' . urlencode($end_date) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '',
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
        <div class="ad_top"></div>
    </div>
</div>
<script>
    $("#search_term").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    function sort_data(sort_by, sort_order)
    {
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/visitor_ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val()), sort_by: sort_by, sort_order: sort_order},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        });
        unblockUI();
    }
    function apply_filter()
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
         if (($('#end_date').val() != '' && $('#start_date').val() != '' && $('#end_date').val() < $('#start_date').val()))
        {
            $('#end_date').validationEngine('showPrompt', '<?php echo lang('msg-wrong-date-req'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/visitor_ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', start_date: encodeURIComponent($('#start_date').val()), end_date: encodeURIComponent($('#end_date').val()), ad_id: encodeURIComponent($('#ad_id').val())},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        });
        unblockUI();
    }
    function reset_filter()
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . $this->_data['section_name']; ?>/banner/visitor_ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', start_date: '', end_date: '', user_id: '', ad_id: ''},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        });
    }
</script>