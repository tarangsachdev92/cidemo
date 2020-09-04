<?php
$dropdown['']="---Select State---";
if (!empty($pages))
{    
    foreach ($pages as &$val)
    {
        $dropdown[$val['s']['state_id']] = $val['s']['state_name'];
    }    
}
echo form_dropdown('state_id', $dropdown, '', 'id=state_id class=validate[required]');
?>