<style>
    .last_five_title {
        color: #1D5283;
        float: left;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }
</style>
<span style="float: left;"><?php echo add_image (array ('active.png')) . " " . 'Active' . "  " . add_image (array ('inactive.png')) . " " . 'Inactive' . ""; ?></span>
<br>
<div id="ajax_table_subscribers">
    <div class="main-container">
        <?php if (!empty ($users)) { ?>
            <div class="grid-data grid-data-table">
                <div class="add-new">
                    <span style="float: left;" class="last_five_title"><?php echo lang ('last_five_subscribers'); ?></span>
                    <span style="float: right;margin-top: 9px" class="last_five_title"><?php echo anchor (site_url () . $this->_data['section_name'] . '/newsletter/subscribers_actions/add/en', lang ('add_subscriber')); ?></span>
                    <span style="float: right;margin-right: 10px;margin-top: 9px" class="last_five_title"><?php echo anchor (site_url () . $this->_data['section_name'] . '/newsletter/all_subscribers', "View All"); ?></span>
                </div>
                <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
                    <?php echo form_open (); ?>
                    <tbody bgcolor="#fff">
                        <tr>
                            <th><?php echo lang('no'); ?></th>
                            <th><?php echo lang ('first-name'); ?></th>
                            <th><?php echo lang ('last-name'); ?></th>
                            <th><?php echo lang ('email'); ?></th>
                            <th><?php echo lang ('status'); ?></th>
                            <th><?php echo lang ('action-title'); ?></th>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($users as $user) {
                            if ($i % 2 != 0) {
                                $class = "odd-row";
                            } else {
                                $class = "even-row";
                            }
                        ?>
                        <tr class="<?php echo $class; ?> rows" >
                            <td><?php echo $i; ?></td>
                            <td><?php echo $user['s']['firstname']; ?></td>
                            <td><?php echo $user['s']['lastname']; ?></td>
                            <td><?php echo $user['s']['email']; ?></td>
                            <td>
                                <?php
                                if ($user['s']['status'] == 'active') {
                                    echo add_image (array ('active.png'));
                                } else {
                                    echo add_image (array ('inactive.png'));
                                }
                                $user_id = $user['s']['id'];
                                ?>
                            </td>
                            <td>
                                <div class="action">
                                    <div class="edit"><a href="<?php echo site_url () . $this->_data['section_name']; ?>/newsletter/subscribers_actions/edit/en/<?php echo $user_id ?>" title="<?php echo lang ('edit') ?>"><?php echo add_image (array ('edit.png')); ?></a></div>
                                    <?php $deletelink = "<a href='javascript:;' title='Delete' onclick='delete_user($user_id)'>" . add_image (array ('delete.png')) . "</a>"; ?>
                                    <div class="delete"><?php echo $deletelink ?></div>
                                </div>    
                            </td>
                        </tr>
                        <?php $i++; }
                        echo form_hidden ('search_text', (isset ($search_text)) ? $search_text : '' );
                        echo form_hidden ('page_number', "", "page_number");
                        echo form_hidden ('per_page_result', "", "per_page_result");
                        ?>
                </tbody>
                <?php echo form_close (); ?>
            </table>
        </div>
        <?php } else { ?>
            <table>
                <tr>
                    <td><?php echo lang ('no-records'); ?></td>
                </tr>
            </table>
            <?php } ?>
    </div>
</div>
<br/>
<div id="ajax_table_newsletters">
    <div class="main-container">
        <?php if (!empty ($all_newletters)) { ?>
            <div class="grid-data grid-data-table">
                <div class="add-new">
                    <span style="float: left;" class="last_five_title"><?php echo lang ('last_five_newsletters'); ?></span>
                    <span style="float: right;margin-top: 9px" class="last_five_title"><?php echo anchor (site_url () . $this->_data['section_name'] . '/newsletter/newsletters_actions/add/en', lang ('add-newsletter'), 'style="text-align:center;width:100%;"'); ?></span>
                    <span style="float: right;margin-right: 10px;margin-top: 9px" class="last_five_title"><?php echo anchor (site_url () . $this->_data['section_name'] . '/newsletter/all_newsletters', "View All"); ?></span>
                </div>
                <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
            <?php echo form_open (); ?>
                    <tbody bgcolor="#fff">
                        <tr>
                            <th><?php echo "No"; ?></th>
                            <th><?php echo lang ('subject'); ?></th>
                            <th><?php echo lang ('category'); ?></th>
                            <th><?php echo lang ('schedule'); ?></th>
                            <th><?php echo lang ('templates'); ?></th>
                            <th><?php echo lang ('status'); ?></th>
                            <th><?php echo lang ('sent'); ?></th>
                            <th><?php echo lang ('action-title'); ?></th>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($all_newletters as $user) {
                            if ($i % 2 != 0) {
                                $class = "odd-row";
                            } else {
                                $class = "even-row";
                            }
                        ?>
                        <tr class="<?php echo $class; ?> rows" >
                            <td><?php echo $i; ?></td>
                            <td><?php echo $user['n']['subject']; ?></td>
                            <td><?php echo $user['nc']['category_name']; ?></td>
                            <td><?php echo $user['n']['schedule_time']; ?></td>
                            <td><?php echo $user['t']['template_title']; ?></td>
                            <td>
                                <?php
                                if ($user['n']['status'] == 'active') {
                                    echo add_image (array ('active.png'));
                                } else {
                                    echo add_image (array ('inactive.png'));
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($user['n']['sent'] == 'yes') {
                                    echo img (array ("alt" => "Newsletter sent", "src" => 'themes/default/images/mail_sent.png', "title" => "Newsletter sent"));
                                } else {
                                    echo img (array ("alt" => "Newsletter not sent", "src" => 'themes/default/images/mail_not_sent.png', "title" => "Newsletter not sent"));
                                }
                                ?>
                            </td>
                            <td><?php $newsletter_id = $user['n']['newsletter_id']; ?>
                                <div class="action">
                                    <div class="edit"><a href="<?php echo site_url () . $this->_data['section_name']; ?>/newsletter/view_newsletter/<?php echo $newsletter_id ?>/<?php echo $language_code; ?>" title="<?php echo lang ('view') ?>"><?php echo add_image (array ('viewIcon.png')); ?></a></div>
                                    <div class="edit"><a href="<?php echo site_url () . $this->_data['section_name']; ?>/newsletter/newsletters_actions/edit/<?php echo $language_code; ?>/<?php echo $newsletter_id ?>" title="<?php echo lang ('edit') ?>"><?php echo add_image (array ('edit.png')); ?></a></div>
                                    <?php $deletelink = "<a href='javascript:;' title='Delete' onclick='delete_newsletter($newsletter_id,$language_id)'>" . add_image (array ('delete.png')) . "</a>"; ?>
                                    <div class="delete"><?php echo $deletelink ?></div>
                                </div>    
                            </td>
                        </tr>
                        <?php $i++; }
                        echo form_hidden ('search_text', (isset ($search_text)) ? $search_text : '' );
                        echo form_hidden ('page_number', "", "page_number");
                        echo form_hidden ('per_page_result', "", "per_page_result");
                        ?>
                </tbody>
                <?php echo form_close (); ?>
            </table>
        </div>
    <?php } else { ?>
        <table>
            <tr>
                <td><?php echo lang ('no-records'); ?></td>
            </tr>
        </table>
    <?php } ?>
    </div>
</div>
<br/>
<script type="text/javascript">
function delete_user(id) {
    res = confirm('<?php echo lang ('delete-alert') ?>');
    if (res) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/delete',
            data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', id: id},
            success: function(data) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_dashboard_subscribers/',
                    data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>'},
                    success: function(data1) {
                        //set responce message                    
                        $("#ajax_table_subscribers").html(data1);
                    }
                });
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    } else {
        return false;
    }
}
function delete_newsletter(id, lang_id) {
    res = confirm('<?php echo lang ('delete-alert') ?>');
    if (res) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/delete_newsletter',
            data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>', id: id, language_id: lang_id},
            success: function(data) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url () . $this->_data['section_name']; ?>/newsletter/all_dashboard_newsletter/',
                    data: {<?php echo $this->_ci->security->get_csrf_token_name (); ?>: '<?php echo $this->_ci->security->get_csrf_hash (); ?>'},
                    success: function(data1) {
                        //set responce message                    
                        $("#ajax_table_newsletters").html(data1);
                    }
                });
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    } else {
        return false;
    }
}
</script>