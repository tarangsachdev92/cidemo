 <?php
 
 
 
 echo anchor(site_url().$this->_data['section_name'].'/sample/default_pagination', lang('default-pagination'), 'title="Add URLs" style="text-align:center;width:100%;"'); ?> |
<?php echo anchor(site_url().$this->_data['section_name'].'/sample/get_pagination', lang('post-pagination'), 'title="Add URLs" style="text-align:center;width:100%;"'); ?> |
<?php echo anchor(site_url().$this->_data['section_name'].'/sample/ajax_pagination', lang('ajax-pagination'), 'title="Add URLs" style="text-align:center;width:100%;"'); ?> 
<br/><br/><br/>

<?	
    echo "Section name : ".$section_name."<br />";
    echo $base_val."<br />";		
    //echo $base_admin_val."<br />";
    echo "<br />-------------------------------------------------------------------<br /><br />";

    echo $customscript;
    echo "<br />-------------------------------------------------------------------<br /><br />";
    
    echo "Sample load from module's model<br />";
    echo "Model name : sample_model.php (module/models)<br />";		
    echo "Function name : get_sample_detail_by_id<br />";		
    print_r($records);

    echo "<br />-------------------------------------------------------------------<br /><br />";	
    echo "Sample load from application's model<br />";
    echo "Model name : default_model.php (application/models)<br />";		
    echo "Function name : default_test<br />";		
    print_r($records_default);

    echo "<br />-------------------------------------------------------------------<br /><br />";
    echo "Sample load from base model's function<br />";
    echo "Model name : base_model.php (core/Base_Model.php)<br />";
    echo "Model name : sample_test_by_id<br />";		
    print_r($records_test);

    echo "<br />-------------------------------------------------------------------<br /><br />";
    echo "Sample language variable load<br />";
    echo lang("sample_label")."<br />";
    echo lang("sample_label1");

    echo "<br />-------------------------------------------------------------------<br /><br />";
    echo "Below Text loaded from view : sample_admin_content.php file<br />";	
    
?>
Sample admin view content
<br />

Dynamic data value passed from controller is : <?php echo $random;?>