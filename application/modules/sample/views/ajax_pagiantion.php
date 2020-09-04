
<div id="ajax_table">
 <?php echo anchor(site_url().$this->_data['section_name'].'/sample/default_pagination', lang('default-pagination'), 'title="Add URLs" style="text-align:center;width:100%;"'); ?> |
<?php echo anchor(site_url().$this->_data['section_name'].'/sample/get_pagination', lang('post-pagination'), 'title="Add URLs" style="text-align:center;width:100%;"'); ?> |
<?php echo anchor(site_url().$this->_data['section_name'].'/sample/ajax_pagination', lang('ajax-pagination'), 'title="Add URLs" style="text-align:center;width:100%;"'); ?> 
<br/><br/><br/>
    <div class="main-container">
       
        <?php
        
        if (!empty($sample))
        {
            ?>
            <div class="grid-data grid-data-table">
                <div class="add-new">
                    <span style="float: left;"><?php echo add_image(array('active.png')) . " " . lang('active') . "  " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>
                    
                </div>
                <table cellspacing="1" cellpadding="4" border="0" bgcolor="#e6ecf2" width="100%">
                    <?php 
                    $attributes=array('name' => 'sample_management');
                    echo form_open("",$attributes); ?>
                    <tbody bgcolor="#fff">
                        <tr>
                            <th><?php echo lang('no') ?></th>
                            <th><?php echo lang('title'); ?></th>
                        </tr>
                        <?php
                        if($page_number > 1)
                        {
                            $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page']*($page_number-1)) +1;
                        }
                        else
                        {
                            $i = 1;
                        }
                        foreach ($sample as $user)
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
                                <td><?php echo $i; ?></td>
                                <td><?php echo $user['u']['title']; ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        echo form_hidden('search_text', (isset($search_text)) ? $search_text : '' );
                        echo form_hidden('page_number', "", "page_number");
                        echo form_hidden('per_page_result', "", "per_page_result");
                        ?>
                    </tbody>
                    <?php echo form_close(); ?>
                </table>
            </div>
            <?php
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
     $querystr =  $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash());        
     $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url().$this->_data['section_name']."/sample/ajax_pagination",
                'params' => $querystr,
                'element' => 'ajax_table'
            );
        widget('custom_pagination', $options);
        ?>

    </div>
</div>