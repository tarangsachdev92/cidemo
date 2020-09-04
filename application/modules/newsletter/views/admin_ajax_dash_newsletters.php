<div class="main-container">
    <?php if (!empty ($all_newletters)) { ?>
        <div class="grid-data grid-data-table">
            <div class="add-new">
                <span style="float: left;" class="last_five_title"><?php echo lang ('last_five_newsletters'); ?></span>
                <span style="float: right;margin-top: 9px" class="last_five_title"><?php echo anchor (site_url () . $this->_data['section_name'] . '/newsletter/add_newsletters', lang ('add-newsletter'), 'style="text-align:center;width:100%;"'); ?></span>
                <span style="float: right;margin-right: 10px;margin-top: 9px" class="last_five_title"><?php echo anchor (site_url () . $this->_data['section_name'] . '/newsletter/all_newsletters', "View All"); ?></span>
            </div>
            <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
                <?php echo form_open (); ?>
                <tbody bgcolor="#fff">
                    <tr>
                        <th><?php echo "No"; ?></th>
                        <th>
                            <?php echo lang ('subject'); ?>
                        </th>
                        <th>
                            <?php echo lang ('category'); ?>
                        </th>
                        <th>
                            <?php echo lang ('schedule'); ?>
                        </th>
                        <th>
                            <?php echo lang ('templates'); ?>
                        </th>
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
                                echo add_image (array ('mail_sent.png'));
                            } else {
                                echo add_image (array ('mail_not_sent.png'));
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $newsletter_id = $user['n']['newsletter_id'];
                            ?>
                            <div class="action">
                                <div class="edit"><a href="<?php echo site_url () . $this->_data['section_name']; ?>/newsletter/view_newsletter/<?php echo $newsletter_id ?>/<?php echo $language_code; ?>" title="<?php echo lang ('view') ?>"><?php echo add_image (array ('viewIcon.png')); ?></a></div>
                                <div class="edit"><a href="<?php echo site_url () . $this->_data['section_name']; ?>/newsletter/edit_newsletter/edit/<?php echo $language_code ?>/<?php echo $newsletter_id ?>" title="<?php echo lang ('edit') ?>"><?php echo add_image (array ('edit.png')); ?></a></div>
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