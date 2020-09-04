<div id="ajax_table">
    <div class="main-container">
        <?php
        if (count($listing_data) > 0)
        {
        ?>
        <div class="search-box">
            <table cellspacing="2" cellpadding="4" border="0">
                <tbody>
                    <tr>
                        <td align="right"><?php echo lang('search_by_quiz_title') ?> :</td>
                        <?php
                        $input_data = array(
                            'name' => 'search_term',
                            'id' => 'search_term',
                            'value' => set_value('search_term', urldecode($search_term))
                        );
                        ?>

                        <td align="left">
                            <?php echo form_input($input_data); ?>
                        </td>

                        <td>
                            <?php
                            $search_button = array(
                                'content' => lang('txt_btn_search'),
                                'title' => lang('txt_btn_search'),
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
                    <th><?php echo lang('sr_no'); ?></th>
                    <th>
                        <?php                            
                            $field_sort_order = 'asc';
                            $sort_image = 'srt_down.png';
                            if($sort_by == 'q.quiz_title' && $sort_order == 'asc')
                            {   
                                $sort_image = 'srt_up.png';
                                $field_sort_order = 'desc';
                            }
                        ?>
                        <a href="javascript:void(0)" onclick="sort_data('q.quiz_title', '<?php echo $field_sort_order;?>');" >
                            <?php echo lang('quiz_title'); ?>
                            <?php if($sort_by == 'q.quiz_title')
                            {
                                ?>
                                <div class="sorting">
                                    <?php echo add_image(array($sort_image)); ?>
                                </div>
                                <?php
                            } ?>
                        </a>
                    </th>

                    <th>
                        <?php
                            $field_sort_order = 'asc';
                            $sort_image = 'srt_down.png';
                            if($sort_by == 'q.description' && $sort_order == 'asc')
                            {
                                $sort_image = 'srt_up.png';
                                $field_sort_order = 'desc';
                            }
                        ?>
                        <a href="javascript:void(0)" onclick="sort_data('q.description', '<?php echo $field_sort_order;?>');" >
                            <?php echo lang('description'); ?>
                            <?php if($sort_by == 'q.description')
                            {
                                ?>
                                <div class="sorting">
                                    <?php echo add_image(array($sort_image)); ?>
                                </div>
                                <?php
                            } ?>
                        </a>
                    </th>

                    <th><?php echo lang('status'); ?></th>
                    <th><?php echo lang('action'); ?></th>
                    </tr>
            <?php
            
                $i = 1;
                foreach ($listing_data as $details)
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
                        <td><?php echo $details['q']['quiz_title']; ?></td>
                        <td><?php echo $details['q']['description'] == '' ? 'None' : $details['q']['description']; ?></td>
                        <td>
                            <?php
                            if ($details['q']['status'] == '1')
                            {
                                ?>
                                <?php echo add_image(array('active.png')); ?>
                                <?php
                            }
                            elseif ($details['q']['status'] == '0')
                            {
                                ?> 
                                <?php echo add_image(array('inactive.png')); ?>
                            <?php } ?>
                        </td>

                        <td>
                            <div class="action">
                                <div class="edit">
                                    <a href="<?php echo base_url().$this->_data['section_name']; ?>/quiz/quizzes_action/edit/<?php echo $language_code . "/" . $details['q']['quiz_id']; ?>" title="<?php echo lang('edit'); ?>">
                                        <?php echo add_image(array('edit.png')); ?>
                                    </a>
                                </div>

                                <div class="delete">
                                    <a href='javascript:;' title='<?php echo lang('delete'); ?>' onclick="delete_record('<?php echo $details['q']['quiz_id']; ?>')">
                                        <?php echo add_image(array('delete.png')); ?>
                                    </a>
                                </div>
                            </div>    
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
                'base_url' => base_url().$this->_data['section_name']."/quiz/ajax_quizzes_list/" . $language_code,
                'params' => $this->ci()->security->get_csrf_token_name() . '=' . urlencode($this->ci()->security->get_csrf_hash()) . '&search_term=' . $search_term . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '',
                'element' => 'ajax_table'
            );
            widget('custom_pagination', $options);
        }
        else
        {
            ?>
            <div class="search-box">
            <table>
                <tr><td colspan="6"><?php echo lang('no_record_found'); ?></td></tr>
                    </table>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<script>
    function submit_search()
    {
        if ($('#search_term').val() == '') {
        $('#search_term').validationEngine('showPrompt', '<?php echo lang('quiz_title_required'); ?>', 'error');
        attach_error_event(); //for remove dynamically populate popup
        return false;
        }
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url().$this->_data['section_name']; ?>/quiz/ajax_quizzes_list/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: $('#search_term').val()},
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
            url: '<?php echo base_url().$this->_data['section_name']; ?>/quiz/ajax_quizzes_list/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: $('#search_term').val(), sort_by: sort_by, sort_order: sort_order},
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
            type:'POST',
            url:'<?php echo base_url().$this->_data['section_name']; ?>/quiz/ajax_quizzes_list/<?php echo $language_code; ?>',
            data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',search_term:""},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        });
        unblockUI();
    }
</script>