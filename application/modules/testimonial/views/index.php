<?php echo add_css(array('jquery-ui', 'validationEngine.jquery'));
echo add_js(array('jquery-ui', 'jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine'));?>
<?php echo add_css(array('front_testimonial'), 'testimonial', 'modules'); ?>
<?php echo add_js(array('flowplayer-3.2.12.min', 'jquery.bpopup.min'), 'testimonial', 'modules'); ?>
<?php
if ($is_ajax != 1)
{
    echo add_css(array('jquery-ui', 'validationEngine.jquery'));
    echo add_js(array('jquery-ui', 'jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine'));
}
?>
<?php
function limit_words($string, $word_limit, $line_limit)
{
    $words = explode(" ", $string);
    $limit_w = implode(" ", array_splice($words, 0, $word_limit));
    $lines = explode("\n", $limit_w);
    return implode("\n", array_splice($lines, 0, $line_limit));
}
echo form_open();
?>
<div id="ajax_table">
    <div class="main-container">
        <div class="search-box">
            <table cellspacing="2" cellpadding="4" border="0">
                <tr>
                    <td align="right"><span class="star">*&nbsp;</span><?php echo lang('search-by'); ?>:</td>
                    <?php
                    $search_type = array(
                        'select' => '--Select--',
                        'testimonial_name' => lang('testimonial_name'),
                        'person_name' => lang('person_name'),
                        'company_name' => lang('company_name'),
                        'created_on' => lang('posted_date')
                    );
                    ?>
                    <td align="left">
                    <?php
                    echo form_dropdown('search_type', $search_type, ((isset($search_type_cont)) ? $search_type_cont : 'select'), 'id="search_type" onchange = change_search(this.value);');
                    ?>
                    </td>
                        <?php if ($search_type_cont != 'select' && $search_type_cont != 'created_on')
                        { ?>   
                        <td class="textfield" >
                            <?php }
                            else
                            { ?>
                        <td class="textfield" style="display: none;" >
                            <?php } ?>
                            <span>
                                <?php echo lang('search-text'); ?> :
                            </span>
                            <span id ="text">
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
                            </span>
                        </td>
                        <?php if ($search_type_cont != 'created_on')
                        { ?>   
                        <td class="datefield" style="display: none;">
                        <?php }
                        else
                        { ?>
                        <td class="datefield" >
                        <?php } ?>
                        <span><?php echo lang('posted_date') ?> :</span>
                            <?php
                            $search_date_from = array(
                                'name' => 'date_from',
                                'id' => 'date_from',
                                'class' => 'search',
                                'placeholder' => lang('from'),
                                'value' => set_value('date_from', $date_from)
                            );
                            ?>
                        <span>
                            <?php
                            echo form_input($search_date_from);
                            ?>
                        </span>
                        <span>
                            <?php
                            $search_date_to = array(
                                'name' => 'date_to',
                                'id' => 'date_to',
                                'class' => 'search',
                                'placeholder' => lang('to'),
                                'value' => set_value('date_to', $date_to)
                            );
                            echo form_input($search_date_to);
                            ?>
                        </span>
                    </td>
                    <td>
                        <?php
                        $options = array(
                            'name' => 'category_id',
                            'id' => 'category_id',
                            'class' => 'validate[required]',
                            'module_id' => TESTIMONIAL_MODULE_NO,
                            'value' => (isset($search_category)) ? $search_category : '',
                            'language_id' => $language_id,
                            'first_option' => '--All Categories--'
                        );
                        ?>
                        <?php echo lang('search-by-category'); ?> :
                    </td>    
                    <td>
                        <div id='category'>
                        <?php widget('category_dropdown', $options); ?>  <br/><span class="warning-msg"><?php echo form_error('parent_id'); ?></span>
                        </div>
                    </td>
                    <td style="padding-left: 10px;" >
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
                    <td  style="padding-left: 10px;">
                    <?php
                    $reset_button = array(
                        'content' => lang('btn-reset'),
                        'title' => lang('btn-reset'),
                        'class' => 'inputbutton',
                        'onclick' => "reset_data()",
                    );
                    echo form_button($reset_button);
                    ?>
                    </td>
                </tr>
            </table>
        </div>
        <div style="width: 100%;">
            <div class="grid-data grid-data-table" style="width: 70%;float:left;">
                <?php if (isset($user_id))
                { ?>
                    <div class="add-new">
                    <?php echo anchor(site_url() . 'testimonial/action/add/'.$language_code, lang('add-testimonial'), 'title="Add Testimonial" style="text-align:center;width:100%;"'); ?>
                    </div>
                <?php } ?>
                <?php
                $querystr = "";
                if (isset($user_id))
                {
                    $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_type=' . $search_type_cont . '&search_term=' . urlencode($search_term) . '&date_from=' . $date_from . '&date_to=' . $date_to . '&user_id=' . $user_id . '';
                }
                else
                {
                    $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_type=' . $search_type_cont . '&search_term=' . urlencode($search_term) . '&date_from=' . $date_from . '&date_to=' . $date_to . '';
                }
                if (!empty($records))
                {
                    ?>
                <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
                        <?php echo form_open(); ?>
                    <tbody bgcolor="#fff">
                        <tr>
                            <th width="30px"></th>
                            <th width="100px"><?php echo lang('testimonials') ?></th>
                            <th></th>

                        </tr>
                        <?php
                        if ($page_number > 1)
                        {
                            $i = ($this->_ci->session->userdata['front']['record_per_page'] * ($page_number - 1)) + 1;
                        }
                        else
                        {
                            $i = 1;
                        }
                        foreach ($records as $record)
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
                            <tr class="<?php echo $class; ?> rows" >
                                <td><?php if (isset($user_id) && ($record['R']['created_by'] == $user_id))
                            { ?><span valign="top"><input type="checkbox" id="<?php echo $record['R']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $record['R']['id']; ?>"></span><?php } ?>

                                </td>                                                                                    
                                <td>                                           
                                    <?php                    
										           
                                            if (!empty($record['R']['logo']) && file_exists(FCPATH.$record['R']['logo']))
                                            {                                         
                                                  $logo_image  = $record['R']['logo'];
                                                    
                                                ?>                                                                                     
                                                    <img src="<?php echo base_url(); ?><?php echo $logo_image; ?>" height ="80px"/>                                               
                                      <?php } 
                            else
                            {
                            
                                ?>
                                        <a href="<?php echo base_url(); ?>testimonial/testimonial_detail/<?php echo $record['R']['testimonial_slug']; ?>/<?php echo $language_code; ?>"><?php  $logo = 'logo.jpg';   
                                                         
                                                      echo add_image(array($logo),'testimonial','modules',array('alt' => 'Logo','title' => "Logo",'height'=>'80','width' => '80'));  ?></a>
                            <?php } ?>
                                    <br/>
                                    <br/><a href="<?php echo base_url(); ?>testimonial/testimonial_detail/<?php echo $record['R']['testimonial_slug']; ?>/<?php echo $language_code; ?>"><div class="title_font"><?php echo $record['U']['firstname'] . " " . $record['U']['lastname']; ?></div></a>
                                    <?php if ($record['R']['company_name'] != '')
                                    { ?>
                                        <br/><?php
                                        echo $record['R']['company_name'];
                                    }
                                    ?>
                                    <?php if ($record['R']['position'] != '')
                                    { ?>   
                                        <br/><?php
                                        echo $record['R']['position'];
                                    }
                                    ?>      
                                    <br/><?php echo lang('posted_on'); ?> : <?php echo $record['R']['created_on']; ?>
                                </td>
                                <td valign="top"><div class="title_font"><?php echo $record['C']['title']; ?></div>
                                    <br/><?php echo $record['R']['testimonial_name']; ?>
                                    <br/>
                                    <br/><?php echo limit_words($record['R']['testimonial_description'], 50, 3); ?>
                                    <br/>
                                    <div class="continue_reading">
                                        <a href="<?php echo base_url(); ?>testimonial/testimonial_detail/<?php echo $record['R']['testimonial_slug']; ?>/<?php echo $language_code; ?>" style="text-decoration: none ;color: #555555;">
                                            <span><?php echo lang('continue_reading') ?></span>
                                        </a>
                                    </div>
                                    <?php if ($record['R']['video_type'] == SRC && $record['R']['video_src'] != '')
                                    { ?>
                                        <br/><a href="<?php echo site_base_url() . $record['R']['video_src'] ?> "><?php echo add_image(array('video-btn.png'),"testimonial","modules",array('alt' => 'Video','class' => 'video_image'.$record['R']['id'].'','title' => "video"))." " . lang('video') . "" ; ?></a>                                        
                                        <a href="<?php echo site_base_url() . $record['R']['video_src'] ?>" id="player<?php echo $record['R']['id']; ?>"  class="player" style="width:550px;height:350px;display:none;"></a>                                              
                                        </div>
                                        <script>
                                            $('.video_image<?php echo $record['R']['id']; ?>').bind('click', function(e) {
                                                // Prevents the default action to be triggered.
                                                e.preventDefault();
                                                // Triggering bPopup when click event is fired                                               
                                                $('#player<?php echo $record['R']['id']; ?>').bPopup();
                                                $f("player<?php echo $record['R']['id']; ?>", "<?php echo site_base_url(); ?>themes/front/js/modules/testimonial/flowplayer-3.2.16.swf",
                                                        {plugins: {
                                                                controls: {
                                                                    // you do not need full path here when the plugin
                                                                    // is in the same folder as flowplayer.swf
                                                                    url: "<?php echo site_base_url(); ?>themes/front/js/modules/testimonial/flowplayer.controls-3.2.15.swf",
                                                                }
                                                            }
                                                        }
                                                );
                                            });
                                        </script>
                            <?php }
                            elseif ($record['R']['video_type'] == YOUTUBE && $record['R']['video_src'] != '')
                            {
                                ?>
                                        <br/><a href="<?php echo $record['R']['video_src']; ?>" target="_blank"><?php echo add_image(array('video-btn.png'),"testimonial","modules",array('alt' => 'Video','title' => "video"))." " . lang('video') . "" ; ?></a>
                            <?php } ?>
                                <?php if (isset($user_id) && ($record['R']['created_by'] == $user_id))
                                { ?>
                                        <div class="action" >
                                            <br/>  
                                                <?php $record_id = $record['R']['id']; ?>
                                            	<div class="edit"><a href="<?php echo site_url(); ?>testimonial/action/edit/<?php echo $language_code; ?>/<?php echo $record['R']['testimonial_id']; ?>" title="<?php echo lang('edit') ?>"><?php echo add_image(array('edit.png'),"","",array('alt' => 'Edit','title' => "Edit")); ?></a></div>
                                                <?php $deletelink = "<a href='javascript:;' title='Delete' onclick='delete_testimonial($record_id)'>" . add_image(array('delete.png'),"","",array('alt' => 'Unpublish','title' => "Unpublish")) . "</a>"; ?>
                                            <div class="delete"><?php echo $deletelink ?></div>
                                        </div>   
                                <?php }
                                ?>
                                </td>
                            </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <?php
                    echo form_hidden('search_term', (isset($search_term)) ? $search_term : '' );
                    echo form_hidden('page_number', "", "page_number");
                    echo form_hidden('per_page_result', "", "per_page_result");
                    ?>
                        </tbody>
                    <?php echo form_close(); ?>
                    </table>
                    <?php if (isset($user_id))
                    { ?>
                        <table cellspacing="1" cellpadding="4" border="0"  width="100%">
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
                                </td>
                            </tr>
                        </table>
                        <?php } ?>
                        <?php
                        $options = array(
                            'total_records' => $total_records,
                            'page_number' => $page_number,
                            'isAjaxRequest' => 1,
                            'base_url' => base_url() . "testimonial/index/" . $language_code,
                            'params' => $querystr,
                            'element' => 'ajax_table'
                        );

                        widget('custom_pagination', $options);
                    }
                    else
                    {
                        ?>
                    <table>
                        <tr>
                            <td><?php echo lang('no-records') ?></td>
                        </tr>
                    </table>
                    <?php
                    }
                    ?>
                    </div>
                    <div  class='slider_main'>
                    <?php
                    $array = array(
                        'language_id' => $language_id,
                        'language_code' => $language_code);
                    widget('testimonial_random', $array);
                    ?>
            </div>
        </div>
    </div>
</div>
<?php
echo form_hidden('page_number', "", "page_number");
echo form_hidden('per_page_result', "", "per_page_result");
echo form_close();
if(isset($user_id))
    {
        $u_id = $user_id;
    }
    else
    {
        $u_id = '';
    }
?>
<script type="text/javascript">
    var startDate = $('#date_from');
    var endDate = $('#date_to');
    startDate.datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        onClose: function() {
            if (endDate.val() !== '') {
                var testStartDate = startDate.datepicker('getDate');
                var testEndDate = endDate.datepicker('getDate');
                if (testStartDate > testEndDate) {
                    endDate.datepicker('setDate', testStartDate);
                }
            }
        },
        onSelect: function() {
            endDate.datepicker('option', 'minDate', startDate.datepicker('getDate'));
        }
    });
    endDate.datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        onClose: function() {
            if (startDate.val() !== '') {
                var testStartDate = startDate.datepicker('getDate');
                var testEndDate = endDate.datepicker('getDate');
                if (testStartDate > testEndDate) {
                    startDate.datepicker('setDate', testEndDate);
                }
            }
        },
        onSelect: function() {
            startDate.datepicker('option', 'maxDate', endDate.datepicker('getDate'));
        }
    });
    function change_search(id)
    {
        if (id == 'created_on')
        {
            $(".textfield").hide();
            $(".datefield").show();
        }
        else if (id == 'testimonial_name' || id == 'company_name' || id == 'person_name') {
            $(".textfield").show();
            $(".datefield").hide();
        }
        else {
            $(".textfield").hide();
            $(".datefield").hide();
        }
    }
    change_search($("#search_type").val());

    $("#search_term").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    $("#category_id").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    $("#date_from").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    $("#date_to").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submit_search();
        }
    });
    //remove dynamically populate error
    function attach_error_event() {
        $('div.formError').bind('click', function() {
            $(this).fadeOut(1000, removeError);
        });
    }
    function removeError()
    {
        jQuery(this).remove();
    }
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
    function delete_records() {
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
            res = confirm('<?php echo lang('delete-alert') ?>');
            if (res) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>testimonial/index/<?php echo $language_code; ?>',
                    data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', type: 'delete', ids: val},
                    success: function(data) {
                        //for managing same state while record delete
                        if ($('.rows') && $('.rows').length > 1) {
                            pageno = "&page_number=<?php echo $page_number; ?>";
                        } else {
                            pageno = "&page_number=<?php echo $page_number - 1; ?>";
                        }
                        ajaxLink('<?php echo base_url(); ?>testimonial/index', 'ajax_table', '<?php echo $querystr; ?>' + pageno);

                        //set responce message                    
                        $("#messages").show();
                        $("#messages").html(data);
                    }
                });
            } else {
                return false;
            }
        }
    }
    delete_testimonial = function(id)
    {
        res = confirm('<?php echo lang('delete-alert') ?>');
        if (res) {
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>testimonial/delete',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', id: id},
                success: function(data) {
                    //for managing same state while record delete

                    if ($('.rows') && $('.rows').length > 1) {
                        pageno = "&page_number=<?php echo $page_number; ?>";
                    } else {
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";
                    }
                    ajaxLink('<?php echo base_url(); ?>/testimonial/index/<?php echo $language_code; ?>', 'ajax_table', '<?php echo $querystr; ?>' + pageno);

                    //set responce message                    
                    $("#messages").show();
                    $("#messages").html(data);
                }
            });
        } else {
            return false;
        }
    }
    function submit_search()
    {

        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        if ($('#search_type').val() != 'created_on' && $('#search_term').val() == '' && $('#category_id').val() == '0') {
            $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        session_set();
        blockUI();      
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>testimonial/index/<?php echo $language_code; ?>',
                 data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',search_type:encodeURIComponent($('#search_type').val()),search_term:$('#search_term').val(),search_category:$('#category_id').val(),search_status:$('#search_status').val(),date_from:$('#date_from').val(),date_to:$('#date_to').val(), user_id: '<?php echo $u_id; ?>'},
                success: function(data) {
                    $("#ajax_table").html(data);
                    unblockUI();
                }
            });
                 
    }
    function session_set()
    {             
        blockUI();
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>testimonial/session_set/<?php echo $language_code; ?>',
                 data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_type: $('#search_type').val(), search_term: encodeURIComponent($('#search_term').val()), search_category: $('#category_id').val(), date_from: $('#date_from').val(), date_to: $('#date_to').val()}
              });
        unblockUI();
    }
    function reset_data()
    {
        $("#search_type").val("select");
        $("#search_term").val("");
        $("#date_from").val("");
        $("#date_to").val("");  
      //  $("#category_id").val("0");
        session_set();
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        <?php if (isset($user_id))
        { ?>
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>testimonial/index/<?php echo $language_code; ?>',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>',category_id:"--All Categories--", search_type:"--Select--",search_term: "", date_from: "", date_to: "", user_id: '<?php echo $u_id; ?>'},
                success: function(data) {
                    $("#ajax_table").html(data);
                    unblockUI();
                }
            });
        <?php }
        else
        { ?>
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>testimonial/index/<?php echo $language_code; ?>',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>: '<?php echo $this->_ci->security->get_csrf_hash(); ?>', search_term: "", date_from: "", date_to: ""},
                success: function(data) {
                    $("#ajax_table").html(data);
                    unblockUI();
                }
            });
        <?php } ?>
    }     
	
</script>
