<?php
/*
  Module name :Events With Calendar
  File Name :Share Event
  Use to share in social networking sites and through multiple emails
 */
?>
<?php echo add_css('validationEngine.jquery'); ?>
<?php echo add_js(array('jqvalidation/languages/jquery.validationEngine-en', 'jqvalidation/jquery.validationEngine')); ?>


<!--Sharing via social networking sites-->
<?php if ($section_name == 'front')
{
    if ($type != 'private')
    { ?>
        <div id = "social">
            <table>
                <br />
                <tr>
                <h3><?php echo lang('social'); ?>:</h3>
                </tr>
                <tr>
                    <td> <div><a href="http://www.linkedin.com/shareArticle?mini=true&url=http://122.170.114.165/cidemo/" target="_blank" alt="LinkedIn" title="<?php echo lang('linked_in'); ?>"><?php echo add_image(array('calendar/linkedin.png')); ?></a></div></td>
                    <td> <div><a href="http://www.facebook.com/sharer.php?u=http://122.170.114.165/cidemo/"  target="_blank" alt="FaceBook" title="<?php echo lang('facebook'); ?>"><?php echo add_image(array('calendar/facebook.png')); ?></a></div></td>
                    <td> <div><a href="http://twitter.com/share?url=http://122.170.114.165/cidemo/&text=Event Details" target="_blank" alt="Twitter"  title="<?php echo lang('twitter'); ?>"><?php echo add_image(array('calendar/twitter.png')); ?></a></div></td>
                </tr>
                <br />
            </table>
        </div>
        <?php
    }
}
?>

<br />
<!--    Sharing via Emails-->


<div id = "email">
    <h3><?php echo lang('email'); ?>:</h3><br />
    <?php
    if ($data['section_name'] == 'tatvasoft')
        echo form_open($data['section_name'] . '/calendar/share_event/' . $language_code . '/' . $event_id, array('id' => 'share', 'name' => 'share'));
    else
        echo form_open('calendar/share_event/' . $language_code . '/' . $type . '/' . $event_id, array('id' => 'share', 'name' => 'share'));
    ?>
    <table>
        <tr>  
            <td>
                <div>
                    <a style="padding: 3px; text-decoration: none" href='javascript:;' title='<?php echo lang('add_person'); ?>' onclick="addRow('dataTable')"><?php echo lang('add_person'); ?></a>
                    &nbsp;&nbsp;<a href='javascript:;' title='<?php echo lang('delete'); ?>' onclick="deleteRow('dataTable')"><?php echo add_image(array('calendar/delete.png')); ?></a>
                </div>
            </td> 
        </tr>
        <tr>            
        <table id="dataTable" width="350px">          
        </table> <br />
        </tr>
        <tr>
            <td>
                <?php
                $share_button = array(
                    'name' => 'share_event',
                    'id' => 'share_event',
                    'value' => lang('share'),
                    'title' => lang('share'),
                    'class' => 'inputbutton',);
                echo form_submit($share_button);
                ?>
            </td>
            <td>
                <?php
                if ($data['section_name'] == 'tatvasoft')
                    $cancel_button = array(
                        'name' => 'cancel',
                        'content' => lang('btn-cancel'),
                        'title' => lang('btn-cancel'),
                        'class' => 'inputbutton',
                        'onclick' => "location.href='" . site_url($data['section_name'] . '/calendar/event_list/' . $language_code) . "'",);
                else
                    $cancel_button = array(
                        'name' => 'cancel',
                        'content' => lang('btn-cancel'),
                        'title' => lang('btn-cancel'),
                        'class' => 'inputbutton',
                        'onclick' => "location.href='" . site_url('calendar/event_list/' . $language_code) . "'",);
                echo "&nbsp;";
                echo form_button($cancel_button);
                ?>
            </td>
        </tr>
    </table>
<?php echo form_close(); ?>
</div>
<script type="text/javascript">
    function addRow(tableID) {
        //$("#dataTable").css('display', '');
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);
        var cell1 = row.insertCell(0);
        var element1 = document.createElement("input");      
        element1.type = "checkbox";
        element1.name="chkbox[]";      
        cell1.appendChild(element1);
        var cell2 = row.insertCell(1);        
        var cell3 = row.insertCell(2);
        var element2 = document.createElement("input");
        element2.type = "text";
        element2.name = "txtbox[]";
        element2.id = "email";
        element2.length = "100";
        element2.className = "validate[required,custom[email]]";      
        cell3.appendChild(element2);
    }
    function deleteRow(tableID) {       
        try
        {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var val = [];
            $(':checkbox:checked').each(function(i){
                val[i] = $(this).val();
            });
            if(val=="")
            {
                alert('Please select atleast one record for delete');
                return false;
            }
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];  
                if(null != chkbox && true == chkbox.checked) {
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
            }
        }
        catch(e)
        {
            alert(e);
        }
    }
    $(document).ready(function()
    {
        $("#share").validationEngine(
        {promptPosition: '<?php echo VALIDATION_ERROR_POSITION; ?>', validationEventTrigger: "submit"                                       
        }
    );
    });
</script>