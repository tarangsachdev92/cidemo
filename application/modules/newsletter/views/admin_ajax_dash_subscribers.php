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
                                <div class="edit"><a href="<?php echo site_url () . $this->_data['section_name']; ?>admin/newsletter/subscribers_actions/edit/en<?php echo $user_id ?>" title="<?php echo lang ('edit') ?>"><?php echo add_image (array ('edit.png')); ?></a></div>
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