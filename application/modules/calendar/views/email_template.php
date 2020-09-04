 <h3><?php echo $event_list['event_title']; ?><br />
           <?php echo $event_list['start_date']; ?> <?php echo lang('to'); ?> <?php echo $event_list['end_date']; ?>
 </h3>
<div>
     <b><?php echo lang('event_time'); ?></b>:<?php echo $event_list['start_time']; ?> To <?php echo $event_list['end_time']; ?><br /></br>
     <b><?php echo lang('event_desc'); ?></b>:<?php echo $event_list['event_desc'] ?><br /></br>
     <b><?php echo lang('event_loc'); ?></b>:<?php echo $event_list['event_location'] ?><br /></br>
     <b><?php echo lang('event_fees'); ?></b>:<?php echo $event_list['event_fees'] ?><br /></br>
     <b><?php echo lang('event_org'); ?></b>:<?php echo $event_list['event_organizer'] ?><br /></br>   
</div>