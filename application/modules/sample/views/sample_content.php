<tr class="content">
    <td>
        <table cellspacing="0" cellpadding="0">
            <tr>
				<td class="content" valign="top">
	<?
        echo "Section name : ".$section_name."<br />";
	echo $base_val."<br />";		
	echo $base_front_val."<br />";
	echo "<br />-------------------------------------------------------------------<br /><br />";

	echo "Sample load from module's model<br />";
	echo "Model name : sample_model.php (module/models)<br />";		
	echo "Function name : get_sample_detail_by_id<br />";
	print_r($records);
	echo "<br />-------------------------------------------------------------------<br /><br />";
	
	echo "Sample language variable load<br />";
	echo lang("sample_label")."<br />";
	echo lang("sample_label1");		
	echo "<br />-------------------------------------------------------------------<br /><br />";		
	
	?>
	</td>
	</tr>
        </table>
    </td>
</tr>