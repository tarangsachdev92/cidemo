<?php if($is_search != 1){ ?>
<?php echo add_css(array('jquery-ui','front_calendar'), 'calendar', 'modules'); ?>
<?php echo add_js(array('jquery-ui'), 'calendar', 'modules'); ?>
<?php } ?>
<?php if($type=="public"){
    echo add_js(array('jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); 
    echo add_css('validationEngine.jquery');
}?>
      <div id="ajax_table">
            <div class="main-container">
                  <div class="search-box">
                        <?php
                          echo form_open('', array("id" => "search_form", "name" => "search_form"));
                          echo form_hidden("sort_by", $sort_by, 'sort_by');
                          echo form_hidden("sort_order", $sort_order, 'sort_order');
                        ?>
                        <table cellspacing="2" cellpadding="4" border="0">
                              <tbody>
                                    <tr>
                                        <td align="right"><?php echo lang('search-by') ?> :</td>
                                          <?php
                                            $search_type = array(
                                                'select' => '--Select--',
                                                'event_title' => lang('event_title'),
                                                'event_description' => lang('event_desc'),
                                                'event_location' => lang('event_loc'),
                                                'event_organizer' => lang('event_org'),
                                                'event_fees'    => lang('event_fees'),
                                                'start_date'    => lang('start_date'),
                                                'end_date'  => lang('end_date')
                                            );
                                          ?>
                                          <td align="left" colspan="2">
                                                <?php
                                                  echo form_dropdown('search_type', $search_type, ((isset($search_type_cont)) ? $search_type_cont : 'select'), 'id=search_type onchange = change_type(this.value)');
                                                ?>
                                          </td>
                                          
                                        <td class="textfield" style="display: none;">
                                        <span><?php echo lang('search-text') ?> :</span>
                                            <?php
                                            $search = array(
                                                'name' => 'search_term',
                                                'id' => 'search_term',
                                                'class' => 'search',
                                                'placeholder' => lang('msg-search-req'),
                                                'value' => set_value('search_term', (isset($search_term)) ? $search_term : '')
                                            );
                                            echo form_input($search);
                                            ?>
                                        </td>
                                        <td class="datefield" style="display: none;">
                                        <span><?php echo lang('date') ?> :</span>
                                        <?php
                                        $date_from = array(
                                            'name' => 'date_from',
                                            'id' => 'date_from',
                                            'class' => 'search',
                                            'placeholder' => lang('from'),
                                            'value' => set_value('date_from', $date_from)
                                        );
                                        ?>
                                        <span>
                                            <?php
                                            echo form_input($date_from);
                                            ?>
                                        </span>
                                        <span>
                                            <?php
                                            $date_to = array(
                                                'name' => 'date_to',
                                                'id' => 'date_to',
                                                'class' => 'search',
                                                'placeholder' => lang('to'),
                                                'value' => set_value('date_to', $date_to)
                                            );
                                            echo form_input($date_to);
                                            ?>
                                        </span>
                                        </td>
                                          <td align="left" colspan="2">
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
                                    <th><?php echo lang('sr_no'); ?></th>
                                    <th>
                                          <?php
                                            $field_sort_order = 'asc';
                                            $sort_image = 'calendar/srt_down.png';
                                            if ($sort_by == 'event_title' && $sort_order == 'asc')
                                            {
                                                  $sort_image = 'calendar/srt_up.png';
                                                  $field_sort_order = 'desc';
                                            }
                                          ?>
                                          <a href="#" onclick="sort_data('event_title', '<?php echo $field_sort_order; ?>');" >
                                                <?php echo lang('event_title'); ?>
                                                <?php
                                                  if ($sort_by == 'event_title')
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
                                            $sort_image = 'calendar/srt_down.png';
                                            if ($sort_by == 'event_desc' && $sort_order == 'asc')
                                            {
                                                  $sort_image = 'calendar/srt_up.png';
                                                  $field_sort_order = 'desc';
                                            }
                                          ?>
                                          <a href="#" onclick="sort_data('event_desc', '<?php echo $field_sort_order; ?>');" >
                                                <?php echo lang('event_desc'); ?>
                                                <?php
                                                  if ($sort_by == 'event_desc')
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
                                            $sort_image = 'calendar/srt_down.png';
                                            if ($sort_by == 'event_location' && $sort_order == 'asc')
                                            {
                                                  $sort_image = 'calendar/srt_up.png';
                                                  $field_sort_order = 'desc';
                                            }
                                          ?>
                                          <a href="#" onclick="sort_data('event_location', '<?php echo $field_sort_order; ?>');" >
                                                <?php echo lang('event_loc'); ?>
                                                <?php
                                                  if ($sort_by == 'event_location')
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
                                            $sort_image = 'calendar/srt_down.png';
                                            if ($sort_by == 'event_organizer' && $sort_order == 'asc')
                                            {
                                                  $sort_image = 'calendar/srt_up.png';
                                                  $field_sort_order = 'desc';
                                            }
                                          ?>
                                          <a href="#" onclick="sort_data('event_organizer', '<?php echo $field_sort_order; ?>');" >
                                                <?php echo lang('event_org'); ?>
                                                <?php
                                                  if ($sort_by == 'event_organizer')
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
                                            if ($sort_by == 'event_fees' && $sort_order == 'asc')
                                            {
                                                  $sort_image = 'srt_up.png';
                                                  $field_sort_order = 'desc';
                                            }
                                          ?>
                                          <a href="#" onclick="sort_data('event_fees', '<?php echo $field_sort_order; ?>');" >
                                                <?php echo lang('event_fees'); ?>
                                                <?php
                                                  if ($sort_by == 'event_fees')
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
                                            $sort_image = 'srt_down.png';
                                            if ($sort_by == 'start_date' && $sort_order == 'asc')
                                            {
                                                  $sort_image = 'srt_up.png';
                                                  $field_sort_order = 'desc';
                                            }
                                          ?>
                                          <a href="#" onclick="sort_data('start_date', '<?php echo $field_sort_order; ?>');" >
                                                <?php echo lang('start_date'); ?>
                                                <?php
                                                  if ($sort_by == 'start_date')
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
                                            $sort_image = 'srt_down.png';
                                            if ($sort_by == 'end_date' && $sort_order == 'asc')
                                            {
                                                  $sort_image = 'srt_up.png';
                                                  $field_sort_order = 'desc';
                                            }
                                          ?>
                                          <a href="#" onclick="sort_data('end_date', '<?php echo $field_sort_order; ?>');" >
                                                <?php echo lang('end_date'); ?>
                                                <?php
                                                  if ($sort_by == 'end_date')
                                                  {
                                                        ?>
                                                        <div class="sorting">
                                                              <?php echo add_image(array($sort_image)); ?>
                                                        </div>
                                                  <?php } ?>
                                          </a>
                                    </th>
                                    <th><?php echo lang('start_time'); ?></th>
                                    <th><?php echo lang('end_time'); ?></th>
                                    <th><?php echo lang('actions'); ?></th>

                              </tr>
                              <?php
                                if (count($event_list) > 0)
                                {
                                      if ($page_number > 1)
                                      {
                                            $i = ($this->_ci->session->userdata['front']['record_per_page'] * ($page_number - 1)) + 1;
                                      }
                                      else
                                      {
                                            $i = 1;
                                      }
                                      foreach ($event_list as $eve_page)
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
                                                  <td><?php echo $eve_page['event_title']; ?></td>
                                                  <td><?php echo $eve_page['event_desc']; ?></td>
                                                  <td><?php echo $eve_page['event_location']; ?></td>
                                                  <td><?php echo $eve_page['event_organizer']; ?></td>
                                                  <td><?php echo $eve_page['event_fees']; ?></td>
                                                  <td><?php echo $eve_page['start_date']; ?></td>
                                                  <td><?php echo $eve_page['end_date']; ?></td>
                                                  <td><?php echo $eve_page['start_time']; ?></td>
                                                  <td><?php echo $eve_page['end_time']; ?></td>
                                                  <?php
                                                  if ($type == 'private')
                                                  {
                                                        ?>
                                                        <td>
                                                              <div class="action">

                                                                    <div class="edit"><a href="<?php echo site_url(); ?>calendar/action/edit/list/<?php echo $language_code . "/" . $eve_page['event_id']; ?>" title="<?php echo lang('edit'); ?>"><?php echo add_image(array('calendar/edit.png')); ?></a></div>
                                                                    <div class="delete" ><a href='javascript:;' title='<?php echo lang('delete'); ?>' onclick="delete_event('<?php echo $eve_page['event_id']; ?>')"><?php echo add_image(array('calendar/delete.png')); ?></a>&nbsp;&nbsp;</div>
                                                                    <div class="share" ><a href='javascript:;' title='<?php echo lang('share'); ?>' onclick="share_event('<?php echo $eve_page['event_id']; ?>')"><?php echo add_image(array('calendar/mail_sent.png')); ?></a></div>

                                                              </div>
                                                        </td>
                                                        <?php
                                                  }
                                                  else
                                                  {
                                                        ?>
                                                        <td>
                                                              <div class="action">
                                                                    <div class="share" ><a href='javascript:;' title='<?php echo lang('share'); ?>' onclick="share_event('<?php echo $eve_page['event_id']; ?>')"><?php echo add_image(array('calendar/mail_sent.png')); ?></a></div>
                                                              </div>
                                                        </td>
                                                  <?php } ?>
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
                              'base_url' => base_url() . "/calendar/event_list/" . $language_code."/".$type."/1",
                              'params' => $csrf_token . '=' . $csrf_hash . '&search_type=' . $search_type . '&search_term=' . $search_term . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order,
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
<div id= "share_events" style="display: none" >
</div>
<script type="text/javascript">
    function add_event()
    {
        var date = new Date();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var hour = date.getHours();
        var min = date.getMinutes();
        var sec = date.getSeconds();
        var month = (month < 10? ('0' + month): month);
        var day = (day < 10? ('0' + day): day);
        var hour = (hour < 10? ('0' + hour): hour);
        var min = (min < 10? ('0' + day): min);
        var sec = (min < 10? ('0' + sec): sec);
        //var end=(hour>12?'PM':'AM');
        var startdate = date.getFullYear() + "-" + month + "-" + day;
        var starttime = hour + ":" + min + ":" + sec;
        var endtime = hour + ":" + min + ":" + sec;
        var $dialog = $('<div> </div>').load('<?php echo site_url(); ?>calendar/open_dialog/add/list/<?php echo $language_code; ?>/' + startdate + '/' + starttime + '/' + endtime);
        $($dialog).dialog(
                        {
                        modal: true,
                        height: 'auto',
                        width: 600,
                        resizable: false,
                        title: '<?php echo lang('add-event'); ?>',
                        close: function(event, ui) { location.href = '<?php echo site_url(); ?>calendar/event_list/<?php echo $language_code; ?>/<?php echo $type; ?>' }
                        }
        );

    }
    function submit_search()
    {
        var search_term = $("#search_term").val();
        var date_from = $("#date_from").val();
        var date_to = $("#date_to").val();
        var search_type = $("#search_type").val();
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        if(search_type == 'start_date' || search_type == 'end_date')
        {
             if(date_from =='' && date_to =='')
             {

                $('#date_from').validationEngine('showPrompt', '<?php echo lang('msg-date-req'); ?>', 'error');
                $('#date_to').validationEngine('showPrompt', '<?php echo lang('msg-date-req'); ?>', 'error');
                attach_error_event(); //for remove dynamically populate popup
                return false;
            }

        }
        if(search_type != 'start_date' || search_type != 'end_date')
        {
            if(search_term == '') {

                $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
                attach_error_event(); //for remove dynamically populate popup
                return false;
            }
        }
        session_set();
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>calendar/event_list/<?php echo $language_code; ?>/<?php echo $type; ?>/1',
            data: $("#search_form").serialize(),
            success: function(data) {
                $("#ajax_table").html(data);
            }
        });
        unblockUI();
    }
    function session_set()
    {
        blockUI();
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>calendar/session_set',
                data: $("#search_form").serialize()
              });
        unblockUI();
    }
    function sort_data(sort_by, sort_order)
    {
        blockUI();
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>calendar/event_list/<?php echo $language_code; ?>/<?php echo $type; ?>/1',
                data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: encodeURIComponent($('#search_term').val()), search_type: encodeURIComponent($('#search_type').val()), date_from: $('#date_from').val(), date_to: $('#date_to').val(), sort_by: sort_by, sort_order: sort_order},
                success: function(data) {
                                                $("#ajax_table").html(data);
                                }
              });
        unblockUI();
    }
    function reset_data()
    {
        $("#search_type").val("select");
        $("#search_term").val("");
        $("#date_from").val("");
        $("#date_to").val("");
        session_set();
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>calendar/event_list/<?php echo $language_code; ?>/<?php echo $type ?>/1',
                    data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_type: "--Select--", search_term: "", date_from: "", date_to: ""},
                    success: function(data) {
                                                    $("#ajax_table").html(data);
                                                    unblockUI();
                                    }
               });
    }
    function change_type(id)
        {   
            if(id == 'start_date' || id =='end_date')
            {
                $(".datefield").show();
                $(".textfield").hide();
            }
            if(id == 'event_title' || id == 'event_description' || id == 'event_location' || id == 'event_organizer' || id == 'event_fees'){
                $(".textfield").show();
                $(".datefield").hide();
            }
            if(id == 'select')
            {
                $(".textfield").hide();
                $(".datefield").hide();
            }
    }
change_type($("#search_type").val());

var startDate = $('#date_from');
var endDate = $('#date_to');

startDate.datepicker(
    {
    dateFormat: 'yy-mm-dd',
    monthNames:["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
    monthNamesShort:["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
    dayNames:["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
    dayNamesShort:["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
    changeMonth: true,
    changeYear: true,
    onClose: function() {
                            if (endDate.val() !== '') {
                                var testStartDate = startDate.datepicker('getDate');
                                var testEndDate = endDate.datepicker('getDate');
                                if (testStartDate > testEndDate)
                                                endDate.datepicker('setDate', testStartDate);
                            }
                    },
    onSelect: function() {
                            endDate.datepicker('option', 'minDate', startDate.datepicker('getDate'));
                    }
    }
);

endDate.datepicker(
    {
    dateFormat: 'yy-mm-dd',
    monthNames:["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
    monthNamesShort:["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
    dayNames:["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
    dayNamesShort:["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
    changeMonth: true,
    changeYear: true,
    onClose: function() {
                            if (startDate.val() !== '') {
                                            var testStartDate = startDate.datepicker('getDate');
                                            var testEndDate = endDate.datepicker('getDate');
                                            if (testStartDate > testEndDate)
                                                            startDate.datepicker('setDate', testEndDate);
                            }
                    },
    onSelect: function() {
                            startDate.datepicker('option', 'maxDate', endDate.datepicker('getDate'));
                    }

    }
);

$(".search").keypress(function(event)
    {
        if (event.which === 13) {
            event.preventDefault();
            submit_search();
        }
    }
);

    delete_event = function(id)
    {
        res = confirm('<?php echo lang('delete_confirm') ?>');

        if (res) {
                        blockUI();
                        $.ajax(
                                        {
                                        type: 'POST',
                                        url: '<?php echo base_url(); ?>calendar/delete',
                                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', id: id},
                                        success: function(data) {

                                                                        lang_code = '<?php echo $language_code; ?>';
                                                                        //                        alert(lang_code);
                                                                        load_event_list(lang_code);
                                                                        // show success message
                                                                        unblockUI();
                                                                        $("#messages").show();
                                                                        $("#messages").html(data);

                                                        }
                                        }
                        );

        } else {
                        return false;
        }

        load_event_list = function(lang_code) {
                        blockUI();
                        $.ajax(
                                        {
                                        type: 'POST',
                                        url: '<?php echo base_url(); ?>calendar/event_list/' + lang_code,
                                        data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>'},
                                        success: function(data) {
                                                                        $("#ajax_table").html(data);
                                                                        unblockUI();
                                                        }
                                        }
                        );

        }

    }
    share_event = function(id) {
        $("#share_events").load('<?php echo site_url(); ?>calendar/share_event/<?php echo $language_code; ?>/<?php echo $type; ?>/' + id).dialog(
            {
                modal: true,
                width: 450,
                title: '<?php echo lang('share-event'); ?>',
                resizable: false,
                draggable: true,
                close: function(event, ui) { location.href = '<?php echo site_url(); ?>calendar/event_list/<?php echo $language_code; ?>/<?php echo $type; ?>'}
            }
        );
    }
</script>

