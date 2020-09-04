<?php
if ($action == 'edit') {
    echo add_css(array('jquery-ui'), 'calendar', 'modules');
    echo add_js(array('jquery-ui'), 'calendar', 'modules');
}
?>
<?php
echo form_open('', array("id" => "caladd", "name" => "caladd"));
?>
<div id="one" class="grid-data">
    <table cellspacing="1" cellpadding="1" border="0" bgcolor="#e6ecf2" width="100%">
        <tr>
            <th><?php echo lang('add_form_fields'); ?> - <?php echo $language_name; ?></th>
        </tr>
        <tr>
            <td class="add-user-form-box">
                <table cellpadding="0" cellspacing="0" border="0">
                 <tr>
                    <td>
                        <div id="error"> </div>
                    </td>
                 </tr>
                 <tr>
                    <td width="100%" valign="top">
                        <table width="100%" cellpadding="4" cellspacing="1" border="0">
                            <tr>
                                <td><span class="star">*&nbsp;</span><?php echo lang('title'); ?></td>
                                <?php
                                $event_title = array(
                                    'name' => 'event_title',
                                    'id' => 'event_title',
                                    'type' => 'text',
                                    'class' => 'validate[required,,minSize[3],maxSize[100]]',
                                    'value' => set_value('event_title', ((isset($cal['event_title'])) ? $cal['event_title'] : ''))
                                );
                                ?>
                                <td colspan="2"><?php echo form_input($event_title); ?>
                                    <br/><span class="warning-msg"><?php echo form_error('event_title'); ?></span>
                                </td>
                            </tr>
                            <tr >
                                <td><span class="star">*&nbsp;</span><?php echo lang('event_desc'); ?></td>
                                <?php
                                $event_desc = array(
                                    'style' => 'resize:none',
                                    'name' => 'event_desc',
                                    'id' => 'event_desc',
                                    'type' => 'text',
                                    'cols' => 32,
                                    'rows' => 3,
                                    'class' => 'validate[required,minSize[3],maxSize[100]]',
                                    'value' => set_value('event_desc', ((isset($cal['event_desc'])) ? $cal['event_desc'] : ''))
                                );
                                ?>
                                <td colspan="2"><?php echo form_textarea($event_desc); ?>
                                    <br/><span class="warning-msg"><?php echo form_error('event_desc'); ?></span>
                                </td>
                            </tr>
                            <tr class="date">
                                <td><span class="star">*&nbsp;</span><?php echo lang('start'); ?></td>
                                <?php
                                $start_date = array(
                                    'name' => 'start_date',
                                    'id' => 'start_date',
                                    'class' => 'validate[required]',
                                    'value' => set_value('start_date', ((isset($cal['start_date'])) ? ($cal['start_date']) : ''))
                                );
                                ?>
                                <td><?php echo form_input($start_date); ?></td>
                                <?php
                                $start_time = array(
                                    '00:00:00' => '12:00AM',
                                    '00:30:00' => '12:30AM',
                                    '01:00:00' => '01:00AM',
                                    '01:30:00' => '01:30AM',
                                    '02:00:00' => '02:00AM',
                                    '02:30:00' => '02:30AM',
                                    '03:00:00' => '03:00AM',
                                    '03:30:00' => '03:30AM',
                                    '04:00:00' => '04:00AM',
                                    '04:30:00' => '04:30AM',
                                    '05:00:00' => '05:00AM',
                                    '05:30:00' => '05:30AM',
                                    '06:00:00' => '06:00AM',
                                    '06:00:00' => '06:00AM',
                                    '07:00:00' => '07:00AM',
                                    '07:30:00' => '07:30AM',
                                    '08:00:00' => '08:00AM',
                                    '08:30:00' => '08:30AM',
                                    '09:00:00' => '09:00AM',
                                    '09:30:00' => '09:30AM',
                                    '10:00:00' => '10:00AM',
                                    '10:30:00' => '10:30AM',
                                    '11:00:00' => '11:00AM',
                                    '11:30:00' => '11:30AM',
                                    '12:00:00' => '12:00PM',
                                    '12:30:00' => '12:30PM',
                                    '13:00:00' => '01:00PM',
                                    '13:30:00' => '01:30PM',
                                    '14:00:00' => '02:00PM',
                                    '14:30:00' => '02:30PM',
                                    '15:00:00' => '03:00PM',
                                    '15:30:00' => '03:30PM',
                                    '16:00:00' => '04:00PM',
                                    '16:30:00' => '04:30PM',
                                    '17:00:00' => '05:00PM',
                                    '17:30:00' => '05:30PM',
                                    '18:00:00' => '06:00PM',
                                    '18:30:00' => '06:30PM',
                                    '19:00:00' => '07:00PM',
                                    '19:30:00' => '07:30PM',
                                    '20:30:00' => '08:30PM',
                                    '21:00:00' => '09:00PM',
                                    '20:00:00' => '08:00PM',
                                    '21:30:00' => '09:30PM',
                                    '22:00:00' => '10:00PM',
                                    '22:30:00' => '10:30PM',
                                    '23:00:00' => '11:00PM',
                                    '23:30:00' => '11:30PM'
                                );
                                if (isset($cal['end_time'])) {
                                    $option_s = $cal['start_time'];
                                } else {
                                    $option_s = '00:00:00';
                                }
                                ?>
                                <td><?php echo form_dropdown('start_time', $start_time, $option_s); ?></td>
                            </tr>
                            <tr class="date">
                                <td><span class="star">*&nbsp;</span><?php echo lang('end'); ?></td>
                                <?php
                                $end_date = array(
                                    'name' => 'end_date',
                                    'id' => 'end_date',
                                    'class' => 'validate[required]',
                                    'value' => set_value('end_date', ((isset($cal['end_date'])) ? ($cal['end_date']) : ''))
                                );
                                ?>
                                <td><?php echo form_input($end_date); ?></td>
                                <?php
                                $end_time = array(
                                    '00:00:00' => '12:00AM',
                                    '00:30:00' => '12:30AM',
                                    '01:00:00' => '01:00AM',
                                    '01:30:00' => '01:30AM',
                                    '02:00:00' => '02:00AM',
                                    '02:30:00' => '02:30AM',
                                    '03:00:00' => '03:00AM',
                                    '03:30:00' => '03:30AM',
                                    '04:00:00' => '04:00AM',
                                    '04:30:00' => '04:30AM',
                                    '05:00:00' => '05:00AM',
                                    '05:30:00' => '05:30AM',
                                    '06:00:00' => '06:00AM',
                                    '06:00:00' => '06:00AM',
                                    '07:00:00' => '07:00AM',
                                    '07:30:00' => '07:30AM',
                                    '08:00:00' => '08:00AM',
                                    '08:30:00' => '08:30AM',
                                    '09:00:00' => '09:00AM',
                                    '09:30:00' => '09:30AM',
                                    '10:00:00' => '10:00AM',
                                    '10:30:00' => '10:30AM',
                                    '11:00:00' => '11:00AM',
                                    '11:30:00' => '11:30AM',
                                    '12:00:00' => '12:00PM',
                                    '12:30:00' => '12:30PM',
                                    '13:00:00' => '01:00PM',
                                    '13:30:00' => '01:30PM',
                                    '14:00:00' => '02:00PM',
                                    '14:30:00' => '02:30PM',
                                    '15:00:00' => '03:00PM',
                                    '15:30:00' => '03:30PM',
                                    '16:00:00' => '04:00PM',
                                    '16:30:00' => '04:30PM',
                                    '17:00:00' => '05:00PM',
                                    '17:30:00' => '05:30PM',
                                    '18:00:00' => '06:00PM',
                                    '18:30:00' => '06:30PM',
                                    '19:00:00' => '07:00PM',
                                    '19:30:00' => '07:30PM',
                                    '20:00:00' => '08:00PM',
                                    '20:30:00' => '08:30PM',
                                    '21:00:00' => '09:00PM',
                                    '21:30:00' => '09:30PM',
                                    '22:00:00' => '10:00PM',
                                    '22:30:00' => '10:30PM',
                                    '23:00:00' => '11:00PM',
                                    '23:30:00' => '11:30PM'
                                );
                                if (isset($cal['end_time'])) {
                                    $option_e = $cal['end_time'];
                                } else {
                                    $option_e = '00:30:00';
                                }
                                ?>
                                <td><?php echo form_dropdown('end_time', $end_time, $option_e); ?></td>
                            </tr>
                            <tr>
                                <td><span class="star">*&nbsp;</span><?php echo lang('event_loc'); ?></td>
                                <?php
                                $event_loc = array(
                                    'name'  => 'event_loc',
                                    'id'    => 'event_loc',
                                    'type'  => 'text',
                                    'class' => 'validate[required,minSize[3],maxSize[100]]',
                                    'value' => set_value('event_loc', ((isset($cal['event_location'])) ? $cal['event_location'] : ''))
                                );
                                ?>
                                <td colspan="2"><?php echo form_input($event_loc); ?></td>
                            </tr>
                            <tr>
                                <td><span class="star">*&nbsp;</span><?php echo lang('event_org'); ?></td>
                                <?php
                                $event_org = array(
                                    'name' => 'event_org',
                                    'id' => 'event_org',
                                    'type' => 'text',
                                    'class' => 'validate[required,minSize[3],maxSize[100]]',
                                    'value' => set_value('event_org', ((isset($cal['event_organizer'])) ? $cal['event_organizer'] : ''))
                                );
                                ?>
                                <td colspan="2"><?php echo form_input($event_org); ?>
                                    <br/><span class="warning-msg"><?php echo form_error('event_org'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span>&nbsp;&nbsp;&nbsp;</span><?php echo lang('event_fees'); ?></td>
                                <?php
                                $event_fees = array(
                                    'name' => 'event_fees',
                                    'id' => 'event_fees',
                                    'type' => 'text',
                                    'class' => '','maxlength'   => '10',
                                    'value' => set_value('event_fees', ((isset($cal['event_fees'])) ? $cal['event_fees'] : ''))
                                );
                                ?>
                                <td colspan="2"><?php echo form_input($event_fees); ?>
                                    <br/><span class="warning-msg"><?php echo form_error('event_fees'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span>&nbsp;&nbsp;&nbsp;</span><?php echo lang('repeat'); ?></td>
                                <?php
                                $repeat = array(
                                    REPEAT_NONE => 'None',
                                    REPEAT_WEEK => 'Weekly',
                                    REPEAT_MONTH => 'Monthly',
                                    REPEAT_YEAR => 'Yearly',
                                    REPEAT_ALL => 'All Days'
                                );
                                if (isset($cal['recurrence'])) {
                                    $option_r = $cal['recurrence'];
                                } else {
                                    $option_r = '0';
                                }
                                ?>
                                <td><?php echo form_dropdown('repeat', $repeat, $option_r,'id="repeat"'); ?></td>
                            </tr>
                        </table>
                        <table class="repeattable">
                            <tr>
                                <td><?php
                                    if (isset($cal['repeated'])) {
                                        if ($cal['repeated'] == NOT_REPEATED) {

                                            echo form_radio(array(
                                                "name" => "is_repeat", 
                                                "id" => "is_repeat",
                                                "value" => NOT_REPEATED,
                                                'checked' => set_radio('repeat', 'never', TRUE), "onclick" => "hideShowGroup()"));
                                            echo lang('never');
                                            echo form_radio(array(
                                                "name" => "is_repeat", 
                                                "id" => "is_repeat", 
                                                "value" => REPEATED, 
                                                'checked' => set_radio('repeat', 'specific_date', FALSE), "onclick" => "hideShowGroup()"));
                                            echo lang('repeat_event_end_date');
                                        } else {

                                            echo form_radio(array(
                                                "name" => "is_repeat",
                                                "id" => "is_repeat",
                                                "value" => NOT_REPEATED, 
                                                'checked' => set_radio('repeat', 'never', FALSE), "onclick" => "hideShowGroup()"));
                                            echo lang('never');
                                            echo form_radio(array(
                                                "name" => "is_repeat", 
                                                "id" => "is_repeat", 
                                                "value" => REPEATED, 
                                                'checked' => set_radio('repeat', 'specific_date', TRUE), "onclick" => "hideShowGroup()"));
                                            echo lang('repeat_event_end_date');
                                        }
                                    } else {
                                        echo form_radio(array(
                                            "name" => "is_repeat", 
                                            "id" => "is_repeat", 
                                            "value" => NOT_REPEATED, 
                                            'checked' => set_radio('repeat', 'never', TRUE), "onclick" => "hideShowGroup()"));
                                        echo lang('never');
                                        echo form_radio(array(
                                            "name" => "is_repeat", 
                                            "id" => "is_repeat", 
                                            "value" => REPEATED, 
                                            'checked' => set_radio('repeat', 'specific_date', FALSE), "onclick" => "hideShowGroup()"));
                                        echo lang('repeat_event_end_date');
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($cal['repeated'])) {
                                        if ($cal['repeated'] == REPEATED) {
                                            ?>
                                            <div id="repeat_end">
                                            <?php
                                            } else {
                                                ?>
                                                <div id="repeat_end" style="display: none">
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <div id="repeat_end" style="display: none">
                                                    <?php
                                                }
                                                ?>
                                                <table>
                                                    <tr>
                                                        <td><span>&nbsp;&nbsp;&nbsp;</span><?php echo lang('repeat_event_end_date'); ?></td>
                                                        <?php
                                                        $repeat_end_date = array(
                                                            'name' => 'repeat_end_date',
                                                            'id' => 'repeat_end_date',
                                                            'type' => 'text',
                                                            'value' => set_value('repeat_end', ((isset($cal['repeat_end_date'])) ? ($cal['repeat_end_date']) : ''))
                                                        );
                                                        ?>
                                                        <td colspan="2"><?php echo form_input($repeat_end_date); ?>
                                                            <br/><span class="warning-msg"><?php echo form_error('repeat_end'); ?></span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
           </tr>
    </table>
</div>
<div class="submit-btns clearfix">
    <?php
    $create_event = array(
        'name' => 'create_event',
        'id' => 'create_event',
        'value' => lang('save'),
        'title' => lang('save'),
        'class' => 'inputbutton'
    );
    echo form_submit($create_event);
    if($type == 'cal')
    {
    $cancel = array(
        'name' => 'cancel',
        'id' => 'cancel',
        'content' => lang('btn-cancel'),
        'title' => lang('btn-cancel'),
        'class' => 'inputbutton',
        'onclick' => "location.href='" . site_url('calendar') . "'",
    );
    }
    else
    {
      $cancel = array(
        'name' => 'cancel',
        'id' => 'cancel',
        'content' => lang('btn-cancel'),
        'title' => lang('btn-cancel'),
        'class' => 'inputbutton',
        'onclick' => "location.href='" . site_url('calendar/event_list/'.$language_code.'/private') . "'",
    );
    }
    echo "&nbsp;";
    echo form_button($cancel);
    ?>
</div>
<?php echo form_close();?>
<script type="text/javascript" >
        var startDate = $('#start_date');
        var endDate = $('#end_date');
        var repeat = $('#repeat_end_date');
        startDate.datepicker({
            dateFormat: 'yy-mm-dd',
            monthNames: ["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
            monthNamesShort: ["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
            dayNames: ["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
            dayNamesShort: ["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
            changeMonth: true,
            changeYear: true,
            onClose: function(dateText) {
                if (endDate.val() !== '') {
                    var testStartDate = startDate.datepicker('getDate');
                    var testEndDate = endDate.datepicker('getDate');
                    if (testStartDate > testEndDate)
                        endDate.datepicker('setDate', testStartDate);
                }
                else {
                    endDate.val(dateText);
                }
            },
            onSelect: function() {
                endDate.datepicker('option', 'minDate', startDate.datepicker('getDate'));
            }
    });
    endDate.datepicker({
        dateFormat: 'yy-mm-dd',
        monthNames: ["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
        monthNamesShort: ["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
        dayNames: ["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
        dayNamesShort: ["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
        changeMonth: true,
        changeYear: true,
        onClose: function(dateText) {
            if (startDate.val() !== '') {
                var testStartDate = startDate.datepicker('getDate');
                var testEndDate = endDate.datepicker('getDate');
                if (testStartDate > testEndDate)
                    startDate.datepicker('setDate', testEndDate);
            }
            else {
                startDate.val(dateText);
            }
        },
        onSelect: function() {
            startDate.datepicker('option', 'maxDate', endDate.datepicker('getDate'));
        }
    });
    repeat.datepicker({
        dateFormat: 'yy-mm-dd',
        monthNames: ["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
        monthNamesShort: ["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
        dayNames: ["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
        dayNamesShort: ["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
        changeMonth: true,
        changeYear: true,
        onSelect: function() {
            var testEndDate = endDate.datepicker('getDate');
            testEndDate.setDate(testEndDate.getDate() + 1);
            repeat.datepicker('option', 'minDate', testEndDate);
        },
        onClose: function(datetext) {
            if (endDate.val() !== '') {
                var testEndDate = endDate.datepicker('getDate');
                var repeatDate = repeat.datepicker('getDate');
                if (testEndDate >= repeatDate) {
                    testEndDate.setDate(testEndDate.getDate() + 1);
                    repeat.datepicker('setDate', testEndDate);
                }
                else {
                    repeat.val(datetext);
                }
            }
        }
    });
    $("#caladd").validationEngine({
        promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>',
        validationEventTrigger: "submit",
        onValidationComplete: function(from, status) {
            if (status !== false)
            {
                validate_field();
            }
        }
    });
</script>
<script type="text/javascript" >
    function hideShowGroup()
    {
        var selVal = $('input[name=is_repeat]:checked', '#caladd').val();
        if (selVal == 0)
        {
            $("#repeat_end").css('display', 'none');
        }
        else
        {
            $("#repeat_end").css('display', '');
        }
    }
    if ($("#repeat").val() === "0")
    {
        $(".repeattable").hide();
    }
    $("#repeat").change(function()
    {
        if ($(this).val() === "0")
            $(".repeattable").hide();
        else
            $(".repeattable").show();
    });
</script>
<?php if($type == 'cal')
{ ?>
<script type="text/javascript">
function validate_field()
{
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>calendar/validate',
        data: $("#caladd").serialize(),
        success: function(data)
        {
            if(data === '1')
            {
               $.ajax({
               type:'POST',
               url:'<?php echo base_url(); ?>calendar/action/<?php echo $action; ?>/<?php echo $type; ?>/<?php echo $language_code; ?>/<?php echo $id; ?>',
               data: $("#caladd").serialize(),
               success: function(data) {
                   location.href = "<?php echo base_url(); ?>calendar";
                 }
               });
            }
            if (data !== '1'){
                  $('#error').html(data);
            }
        }
    });
    }
 </script>
<?php
}
else
{    ?>
<script type="text/javascript">
    function validate_field()
    {
        $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>calendar/validate',
            data: $("#caladd").serialize(),
            success: function(data) {
                if(data == 1)
                {
                    $.ajax({
                      type:'POST',
                      url:'<?php echo base_url(); ?>calendar/action/<?php echo $action; ?>/<?php echo $type; ?>/<?php echo $language_code; ?>/<?php echo $id; ?>',
                      data: $("#caladd").serialize(),
                        success: function(data) {
                            location.href = "<?php echo base_url(); ?>calendar/event_list/<?php echo $language_code; ?>";
                        }
                      });
               }
               else
               {
                    $('#error').html(data);
               }
            }
        });
    }
 </script>
<?php
}
?>
