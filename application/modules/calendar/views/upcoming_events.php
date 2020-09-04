<?php ?>
<script type="text/javascript">
    $( "#accordion1" ).accordion({
        active: false,
        autoHeight: false,
        navigation: false,
        collapsible: true,
        clearStyle: true,
        overrelay: false
    });
</script>
<div id= "accordion1" style="width: 280px;">
    <?php
    /* Logic to display this month event */
    $month = Date('m');
    $day = Date('d');
    foreach ($data['event_list'] as $result)
    {
        $past_month = explode("-", $result['start_date']);
        if ($past_month[1] == $month && $day <= $past_month[2])
        {
            ?>
            <!--listing of  upcoming event-->
            <h3><?php echo $result['event_title']; ?><br />
        <?php echo $result['start_date']; ?> <?php echo lang('to'); ?> <?php echo $result['end_date']; ?>
            </h3>
            <div>
                <b><?php echo lang('event_time'); ?></b>:<?php echo $result['start_time']; ?> To <?php echo $result['end_time']; ?><br /></br>
                <b><?php echo lang('event_desc'); ?></b>:<?php echo $result['event_desc'] ?><br /></br>
                <b><?php echo lang('event_loc'); ?></b>:<?php echo $result['event_location'] ?><br /></br>
                <b><?php echo lang('event_fees'); ?></b>:<?php echo $result['event_fees'] ?><br /></br>
                <b><?php echo lang('event_org'); ?></b>:<?php echo $result['event_organizer'] ?><br /></br>
            </div>
            <?php
        }
    }
    ?>
</div>