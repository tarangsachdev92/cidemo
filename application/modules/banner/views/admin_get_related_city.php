<?php
$dropdown['']="---Select City---";
if (!empty($pages))
{  
    foreach ($pages as &$val)
    {
        $dropdown[$val['c']['city_id']] = $val['c']['city_name'];
    } 
}
echo form_dropdown('city_id', $dropdown, '', 'id=city_id class=form-control');
?>