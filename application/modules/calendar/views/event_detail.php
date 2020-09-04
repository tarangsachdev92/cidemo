<!-- Event Detail page at the time of editing the record-->
<h2><?php echo $event_list['event_title']; ?>  </h2>
<div>
    <b><?php echo lang('event_date'); ?></b>:<?php echo $event_list['start_date']; ?> To <?php echo $event_list['end_date']; ?><br /><br />
    <b><?php echo lang('event_time'); ?></b>:<?php echo $event_list['start_time']; ?> To <?php echo $event_list['end_time']; ?><br /><br />
    <b><?php echo lang('event_desc'); ?></b>:<?php echo $event_list['event_desc'] ?><br /><br />
    <b><?php echo lang('event_loc'); ?></b>:<?php echo $event_list['event_location'] ?><br /><br />
    <b><?php echo lang('event_fees'); ?></b>:<?php echo $event_list['event_fees'] ?><br /><br />
    <b><?php echo lang('event_org'); ?></b>:<?php echo $event_list['event_organizer'] ?><br /><br />
    <b><?php echo lang('event_repeat'); ?></b>:
    <?php
    if ($event_list['recurrence'] == NOT_REPEATED)
    {
        echo lang('none');
    }
    elseif ($event_list['recurrence'] == REPEAT_WEEK)
    {
        echo lang('weekly');
    }
    elseif ($event_list['recurrence'] == REPEAT_MONTH)
    {
        echo lang('monthly');
    }
    elseif ($event_list['recurrence'] == REPEAT_YEAR)
    {
        echo lang('yearly');
    }
    else
    {
        echo lang('all-day');
    }
    ?>
    <br /><br />
    <b><?php echo lang('event_type'); ?></b>:
<?php
if ($event_list['privacy'] == PUBLIC_EVENT)
{
    echo lang('public');
}
else
{
    echo lang('private');
}
?>
    <br /><br />
</div>
<?php if ($section_name == 'front' && $type == 'private')
{ ?>
    <div><a href = "<?php echo base_url(); ?>calendar/action/edit/cal/<?php echo $language_code; ?>/<?php echo $event_list['event_id']; ?>" style = "text-decoration: none; color:#545454; "><b><?php echo lang('edit'); ?></b></a>
        &nbsp;&nbsp;<a href='javascript:;' title='<?php echo lang('delete'); ?>' onclick="delete_event('<?php echo $event_list['event_id']; ?>')" style = "text-decoration: none; color:#545454; "><b><?php echo lang('delete'); ?></b></a>&nbsp;&nbsp;
    </div>
    <?php
}
elseif ($section_name == 'tatvasoft')
{
    ?>
    <div class="add-new"><a href = "<?php echo base_url(); ?><?php echo $section_name; ?>/calendar/action/edit/cal/<?php echo $language_code; ?>/<?php echo $event_list['event_id']; ?>" style = "text-decoration: none; color:#2766A1; " ><?php echo lang('edit'); ?></a>
        &nbsp;&nbsp;<a href='javascript:;' title='<?php echo lang('delete'); ?>' onclick="delete_event('<?php echo $event_list['event_id']; ?>')" style="text-decoration: none; color:#2766A1; "><?php echo lang('delete'); ?></a>&nbsp;&nbsp;
    </div>
<?php } ?>
<?php if ($section_name == 'tatvasoft')
{ ?>
    <script type="text/javascript">
            $(document).ready(function() {
                delete_event = function(id)
                {
                    res = confirm('<?php echo lang('delete_confirm') ?>');
                    if (res)     
                    {
                        blockUI();
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?><?php echo $section_name; ?>/calendar/delete',
                            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', id: id},
                            success: function(data) {
                                window.location.href = '<?php echo base_url(); ?><?php echo $section_name; ?>/calendar';
                                unblockUI();
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
            });
    </script>
<?php }
else
{ ?>
    <script type="text/javascript">
        $(document).ready(function() {
            delete_event = function(id)
            {
                res = confirm('<?php echo lang('delete_confirm') ?>');
                if (res) 
                {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>calendar/delete',
                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', id: id},
                        success: function(data) {
                            window.location.href = '<?php echo base_url(); ?>calendar';
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
        });
    </script>
<?php
}
?>
