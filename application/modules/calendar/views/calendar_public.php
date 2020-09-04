<?php echo add_css(array('fullcalendar', 'fullcalendar.print', 'jquery-ui', 'front_calendar'), 'calendar', 'modules'); ?>
<?php echo add_js(array('fullcalendar.min', 'jquery-ui'), 'calendar', 'modules'); ?>
<div>
    <?php
    $data_array = json_encode($data['event_list']);
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        // For displaying Upcoming Events
        $(function()
        {
            $("#accordion").load('calendar/upcoming_events_public/<?php echo $data['language_code']; ?>');
        }
    );
        // For displaying small calendar
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var timelineInterval = 0;
        $('#miniCalendar').datepicker(
        {
            dateFormat: 'DD, d MM, yy',
            changeMonth: true,
            changeYear: true,
            onSelect: function(dateText) {
                var date = $(this).datepicker('getDate'),
                day = date.getDate(),
                month = date.getMonth(),
                year = date.getFullYear();

                $('#calendarmain').fullCalendar('gotoDate', new Date(year, month, day));
                $('#calendarmain').fullCalendar('changeView', 'agendaDay');
            },
            onChangeMonthYear: function(year, month, inst) {
                $('#calendarmain').fullCalendar('gotoDate', new Date(year, month-1, 1));
            }
        }
    );
        // For displaying Calendar
        $('#calendarmain').fullCalendar(
        {
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: '<a href = "<?php echo base_url(); ?>calendar/event_list/<?php echo $language_code; ?>/public" style = "text-decoration: none; color: black; ">Events List</a>'
            },
            //aspectRatio: 3,
            monthNames:["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
            monthNamesShort:["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
            dayNames:["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
            dayNamesShort:["<?php echo lang('monday'); ?>", "<?php echo lang('tuesday'); ?>", "<?php echo lang('wednesday'); ?>", "<?php echo lang('thursday'); ?>", "<?php echo lang('friday'); ?>", "<?php echo lang('saturday'); ?>", "<?php echo lang('sunday'); ?>"],
            events: function(start, end, callback) {
                // When requested, dynamically generate a
                // repeatable event for every monday.
                var titles = <?php echo $data_array; ?>;
                var formattedEventData =[],
                k;
                for(var k = 0; k<<?php echo count($data['event_list']); ?>; k += 1)
                {
                    start = new Date(titles[k]['start_date'].split("-")[0], titles[k]['start_date'].split("-")[1]-1, titles[k]['start_date'].split("-")[2], titles[k]['start_time'].split(":")[0], titles[k]['start_time'].split(":")[1]);
                    end_date = new Date(titles[k]['end_date'].split("-")[0], titles[k]['end_date'].split("-")[1]-1, titles[k]['end_date'].split("-")[2], titles[k]['end_time'].split(":")[0], titles[k]['end_time'].split(":")[1]);
                    var one_day = (24 * 60 * 60 * 1000);
                    var end_loop = end_date.getTime() - one_day;
                    if(titles[k]['recurrence'] ==  <?php echo REPEAT_WEEK; ?>)
                    {
                       if (titles[k]['repeated'] == <?php echo REPEATED; ?>)
                            {
                               end1 = new Date(titles[k]['repeat_end_date'].split("-")[0], titles[k]['repeat_end_date'].split("-")[1] - 1, titles[k]['repeat_end_date'].split("-")[2], titles[k]['end_time'].split(":")[0], titles[k]['end_time'].split(":")[1]);                            
                            }
                        else
                            {
                               end1 = end;
                            }
                        for (loop = start.getTime();
                        loop <= end1.getTime();
                        loop = loop + one_day) {

                            var column_date = new Date(loop);
                            end_loop = end_loop + one_day;
                            var column_date_end = new Date(end_loop);
                            var date = new Date(titles[k]['start_date'].split("-")[0], titles[k]['start_date'].split("-")[1]-1, titles[k]['start_date'].split("-")[2], titles[k]['start_time'].split(":")[0], titles[k]['start_time'].split(":")[1])

                            if (column_date.getDay() == date.getDay()) {
                                // we're in Moday, create the event
                                formattedEventData.push(
                                {
                                    id: titles[k]['event_id'],
                                    title: titles[k]['event_title'],
                                    start: new Date(column_date.setHours(titles[k]['start_time'].split(":")[0], titles[k]['start_time'].split(":")[1])),
                                    end: new Date(column_date_end.setHours(titles[k]['end_time'].split(":")[0], titles[k]['end_time'].split(":")[1])),
                                    allDay: false
                                }
                            );
                            }
                        }
                    }
                    else if(titles[k]['recurrence'] == <?php echo REPEAT_MONTH; ?>)
                    {
                       if (titles[k]['repeated'] == <?php echo REPEATED; ?>)
                            {
                               end2 = new Date(titles[k]['repeat_end_date'].split("-")[0], titles[k]['repeat_end_date'].split("-")[1] - 1, titles[k]['repeat_end_date'].split("-")[2], titles[k]['end_time'].split(":")[0], titles[k]['end_time'].split(":")[1]);
                            }
                        else
                            {
                               end2 = end;
                            }
                        for (loop = start.getTime();
                        loop <= end2.getTime();
                        loop = loop + one_day) {

                            var column_date = new Date(loop);
                            end_loop = end_loop + one_day;
                            var column_date_end = new Date(end_loop);
                            var date = new Date(titles[k]['start_date'].split("-")[0], titles[k]['start_date'].split("-")[1]-1, titles[k]['start_date'].split("-")[2], titles[k]['start_time'].split(":")[0], titles[k]['start_time'].split(":")[1])

                            if (column_date.getDate() == date.getDate())
                            {
                                // we're in Moday, create the event
                                formattedEventData.push(
                                {
                                    id: titles[k]['event_id'],
                                    title: titles[k]['event_title'],
                                    start: new Date(column_date.setHours(titles[k]['start_time'].split(":")[0], titles[k]['start_time'].split(":")[1])),
                                    end: new Date(column_date_end.setHours(titles[k]['end_time'].split(":")[0], titles[k]['end_time'].split(":")[1])),
                                    allDay: false
                                }
                            );
                            }
                        }
                    } // for loop
                    else if(titles[k]['recurrence'] == <?php echo REPEAT_YEAR; ?>)
                    {
                       if (titles[k]['repeated'] == <?php echo REPEATED; ?>)
                        {
                            end3 = new Date(titles[k]['repeat_end_date'].split("-")[0], titles[k]['repeat_end_date'].split("-")[1] - 1, titles[k]['repeat_end_date'].split("-")[2], titles[k]['end_time'].split(":")[0], titles[k]['end_time'].split(":")[1]);
                        }
                        else
                        {
                            end3 = end;
                        }
                        for (loop = start.getTime();
                        loop <= end3.getTime();
                        loop = loop + one_day) {

                            var column_date = new Date(loop);
                            end_loop = end_loop + one_day;
                            var column_date_end = new Date(end_loop);
                            var date = new Date(titles[k]['start_date'].split("-")[0], titles[k]['start_date'].split("-")[1]-1, titles[k]['start_date'].split("-")[2], titles[k]['start_time'].split(":")[0], titles[k]['start_time'].split(":")[1])

                            if (column_date.getDate() == date.getDate() && column_date.getMonth() == date.getMonth()) {
                                // we're in Moday, create the event
                                formattedEventData.push(
                                {
                                    id: titles[k]['event_id'],
                                    title: titles[k]['event_title'],
                                    start: new Date(column_date.setHours(titles[k]['start_time'].split(":")[0], titles[k]['start_time'].split(":")[1])),
                                    end: new Date(column_date_end.setHours(titles[k]['end_time'].split(":")[0], titles[k]['end_time'].split(":")[1])),
                                    allDay: false
                                }
                            );
                            }
                        }

                    }
                    else if(titles[k]['recurrence'] == <?php echo REPEAT_ALL; ?>)
                    {
                       if (titles[k]['repeated'] == <?php echo REPEATED; ?>)
                        {
                           end4 = new Date(titles[k]['repeat_end_date'].split("-")[0], titles[k]['repeat_end_date'].split("-")[1] - 1, titles[k]['repeat_end_date'].split("-")[2], titles[k]['end_time'].split(":")[0], titles[k]['end_time'].split(":")[1]);
                        }
                        else
                        {
                           end4 = end;
                        }
                        for (loop = start.getTime();
                        loop <= end4.getTime();
                        loop = loop + one_day) {
                            var column_date = new Date(loop);
                            end_loop = end_loop + one_day;
                            var column_date_end = new Date(end_loop);
                            var date = new Date(titles[k]['start_date'].split("-")[0], titles[k]['start_date'].split("-")[1]-1, titles[k]['start_date'].split("-")[2], titles[k]['start_time'].split(":")[0], titles[k]['start_time'].split(":")[1])
                            // we're in Moday, create the event
                            formattedEventData.push(
                            {
                                id: titles[k]['event_id'],
                                title: titles[k]['event_title'],
                                start: new Date(column_date.setHours(titles[k]['start_time'].split(":")[0], titles[k]['start_time'].split(":")[1])),
                                end: new Date(column_date_end.setHours(titles[k]['end_time'].split(":")[0], titles[k]['end_time'].split(":")[1])),
                                allDay: false
                            }
                        );
                        }
                    }
                    else
                    {
                        formattedEventData.push(
                        {
                            id: titles[k]['event_id'],
                            title: titles[k]['event_title'],
                            start: new Date(titles[k]['start_date'].split("-")[0], titles[k]['start_date'].split("-")[1]-1, titles[k]['start_date'].split("-")[2], titles[k]['start_time'].split(":")[0], titles[k]['start_time'].split(":")[1]),
                            end: new Date(titles[k]['end_date'].split("-")[0], titles[k]['end_date'].split("-")[1]-1, titles[k]['end_date'].split("-")[2], titles[k]['end_time'].split(":")[0], titles[k]['end_time'].split(":")[1]),
                            allDay: false
                        }
                    );
                    }
                }
                // return events generated
                callback(formattedEventData);
            },
            eventClick: function(event) {

                $('#edit').load('<?php echo base_url(); ?>calendar/event_detail/<?php echo $language_code; ?>/public/'+event.id).dialog(
                {
                    width: 700,
                    title: '<?php echo lang('event_detail'); ?>'
                }
            );
            },
            viewDisplay: function(view) {

                window.clearInterval(timelineInterval);
                timelineInterval = window.setInterval(setTimeline, 10000);
                try {
                    setTimeline();
                } catch(err) {}
            },
            eventMouseover: function (event, jsEvent, view) {
                if (view.name === "month") {
                    $(jsEvent.target).attr('title', event.title);
                }
                //alert(event.id);
            },
            disableDragging: true,
            disableResizing: true,
            timeFormat: 'HH:mm{-HH:mm}',
            editable: true
        }
    );
        function setTimeline() {
            var curTime = new Date();
            if (curTime.getHours() === 0 && curTime.getMinutes() <= 5) // Because I am calling this function every 5 minutes
            {// the day has changed
                var todayElem = $(".fc-today");
                todayElem.removeClass("fc-today");
                todayElem.removeClass("fc-state-highlight");

                todayElem.next().addClass("fc-today");
                todayElem.next().addClass("fc-state-highlight");
            }
            var parentDiv = $(".fc-agenda-slots:visible").parent();
            var timeline = parentDiv.children(".timeline");
            if (timeline.length === 0) {//if timeline isn't there, add it
                timeline = $("<hr>").addClass("timeline");
                parentDiv.prepend(timeline);
            }
            var curCalView = $('#calendarmain').fullCalendar("getView");
            if (curCalView.visStart < curTime && curCalView.visEnd > curTime) {
                timeline.show();
            } else {
                timeline.hide();
            }
            var curSeconds = (curTime.getHours() * 60 * 60) + (curTime.getMinutes() * 60) + curTime.getSeconds();
            var percentOfDay = curSeconds / 86400; //24 * 60 * 60 = 86400, # of seconds in a day
            var topLoc = Math.floor(parentDiv.height() * percentOfDay);
            timeline.css("top", topLoc + "px");
            if (curCalView.name == "agendaWeek") {//week view, don't want the timeline to go the whole way across
                var dayCol = $(".fc-today:visible");
                if (dayCol.position() != null) {
                    var left = dayCol.position().left + 1;
                    var width = dayCol.width();
                    timeline.css(
                    {
                        left: left + "px",
                        width: width + "px"
                    }
                );
                }
            }
        }
    }
);
</script>
<br />
<div style="float: left">
    <div class="add-new">
        <?php echo anchor(base_url() . 'calendar', lang('view-my-calendar'), 'title="View My Calendar" style="text-align:center;width:100%;"'); ?>
    </div>
    <div id="miniCalendar">
        <div style="font-size: medium"><?php echo lang('jump_to_date'); ?>:</div><br />
    </div><br />
    <div style="font-size: medium"><?php echo lang('upcoming_events'); ?>:</div><br />
    <div id= "accordion" style="width: 260px;">
    </div>
</div>
<a style="text-decoration: none; "></a>
<div id="edit"></div>
<div id= "calendarmain" style="width:700px; float: right" ></div>




















