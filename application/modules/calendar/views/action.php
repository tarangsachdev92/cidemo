<?php echo add_css('validationEngine.jquery'); ?>
<?php echo add_js(array('jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>
<?php echo add_css(array('front_calendar'),'calendar','modules'); ?>
<div class="main-content">
    <div class="grid-data info-content">
        <div class="add-new">
            <?php echo anchor(site_url() . 'calendar/event_list/'.$language_code, lang('event_list'), 'title="View All events" style="text-align:center;width:100%;"'); ?>
        </div>
        <div class="profile-content-box" id="cal_form">
            <!-- Form will come here -->  
            <?php echo $content; ?>
        </div>
    </div>  
</div>
