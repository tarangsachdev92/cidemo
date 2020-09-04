  <div id="contentpanel">
<div class="contentpanel">
      <div class="panel panel-default form-panel">
        <div class="panel-body">
          	      
              <div class="row row-pad-5">
            
               
                  <div class="col-lg-3 col-md-3">
                  <?php
                        $search_options = array(
                            'select' => lang('please_select'),
                            'status' => lang('status')
                        );
                        echo form_dropdown('search', $search_options , urldecode($search), 'id=search class="form-control" onchange = change_search(this.value);');
                        ?>
                </div>
                  
                <div class="col-lg-3 col-md-3" id='search_options' style="display: none">
                   <?php
                                
                                $status = array(
                                    '' => '---All Status---',
                                    '1' => lang('active'),
                                    '0' => lang('inactive')
                                );
                            ?>
                           <?php echo form_dropdown('search_status', $status, urldecode($search_status), 'id=search_status class="search form-control"') . "  "; ?> 
                       
                </div>
                
               
                <div class="row row-pad-5" >
              
                       
                <div class="col-lg-3 col-md-3" >
                	 <?php
                    $search_button = array(
                        'content' => '<i class="fa fa-search"></i> &nbsp; '.lang('btn-search'),
                        'title' => lang('btn-search'),
                        'class' => 'btn btn-primary',
                        'onclick' => "submit_search()",
                        'id' => 'search_button'
                    );
                    echo form_button($search_button);
                    ?>
                     <?php
                    $reset_button = array(
                        'content' => '<i class="fa fa-refresh"></i> &nbsp; '.lang('btn-reset'),
                        'title' => lang('btn-reset'),
                        'class' => 'btn btn-default btn-reset',
                        'onclick' => "reset_data()",
                    );
                    echo form_button($reset_button);
                    ?>
                </div>
              </div>    
           </div>
                      
           
            
        </div>
      </div>

          <div class="row">        
            <div class="col-md-12">
                
                <div class="panel-header clearfix">

                <!--                <h3 class="mb15">Table With Actions</h3>-->

                <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>

                <a class="add-link" href="javascript:;" onclick="openlink('add')" title="<?php echo lang('add_Product_image');?>"><?php echo lang('add_product_image');?></a>
                <?php echo anchor(site_url() . $this->_data['section_name'].'/products', lang('Product_list'), 'title="View All Products" style="margin-right: 10px;" class="add-link"'); ?>
          </div>
               
                    <div class="panel table-panel">
                    <div class="panel-body">
                       
                         <?php
                    
                if (count($list) > 0)
            {
                ?>
                            <div class="table-responsive">          		
                                <table class="table table-hover gradienttable">
                                    <thead>
                                        <tr>
                                            <th>
                                    <div class="ckbox ckbox-default">
                                        <input type="checkbox" name="check_all" id="check_all" value="0" />
                                        <label for="check_all"></label>
                                    </div>
                                    </th>

                                    <th class="t-center"><?php echo lang('sr_no') ?></th>

                                    <th class="t-center">
                                        <?php echo lang('product_image')?>
                                    </th>

                                    <th class="t-center">
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'pi.status' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('pi.status', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Product Status">   <?php echo lang('status'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'pi.status') {
                                                echo $sort_image;
                                            }
                                            ?></a>
                                    </th>
                   <th class="t-center"><?php echo lang('last_modified'); ?></th>
                    <th class="t-center"><?php echo lang('actions'); ?></th>

                                    
                                    </tr>

                                    </thead>
                                    <tbody>
                                     <?php
            
            
                if ($page_number > 1) {
                        $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page']*($page_number-1)) +1;
                } else {
                    $i = 1;
                }
                foreach ($list as $page)
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
                                            <tr>
                                                <td>
                                                    <div class="ckbox ckbox-default">
                                                    <input type="checkbox" id="<?php echo $page['pi']['id']; ; ?>" name="check_box[]" class="check_box" value="<?php echo $page['pi']['id']; ?>" >
                                                        <label for="<?php echo $page['pi']['id'];  ?>"></label>

                                                    </div>
                                                </td>
                                                <td class="t-center"><?php echo $i; ?></td>
                        <td class="t-center"><?php                            
                            if(!empty($page['pi']['product_image']) && file_exists(FCPATH."assets/uploads/products/thumbs/".$page['pi']['product_image']))
                            { ?>
                            <img src="<?php echo base_url()."assets/uploads/products/thumbs/".$page['pi']['product_image'] ?>" height="50" width="50"/>
                            <?php } ?></td>
                        <td class="t-center">
                            <?php
                            if ($page['pi']['status'] == '1')
                            {
                                ?>
                                <?php echo add_image(array('active.png')); ?>
                                <?php
                            }
                            elseif ($page['pi']['status'] == '0')
                            {
                                ?>
                                <?php echo add_image(array('inactive.png')); ?>
                            <?php } ?>
                        </td>
                        <td class="t-center"><?php echo $page['pi']['modified_on']; ?></td>
                        
                      
                                                <td class="t-center"> 

                                                    <a class="mr5" href="<?php echo site_url().$this->_data['section_name']; ?>/products/image_action/edit/<?php echo $product_id . "/" . $page['pi']['id']; ?>" title="<?php echo lang('edit'); ?>"><i class="fa fa-pencil"></i></a>

                                                    
                                                    <a class="delete-row" href="javascript:;" title='<?php echo lang('delete'); ?>' onclick="delete_product_image('<?php echo $page['pi']['id']; ?>')"><i class="fa fa-trash-o"></i></a>

                                                </td>


                                            </tr>

                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="btn-panel mb15">
                                <button onclick="delete_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-trash-o"></i></span>Delete</button>
                                <button onclick="active_records()" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active</button>
                                <button onclick="inactive_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>In Active</button>
                                <button onclick="active_all_records()" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Active All</button>
                                <button onclick="inactive_all_records()" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-minus-square-o"></i></span>Inactive All</button>
                            </div>
                            <?php
                       } else {
                            echo 'No Record(s) Found';
                        }
                       
            $querystr = $this->ci()->security->get_csrf_token_name() . '=' . urlencode($this->ci()->security->get_csrf_hash()) . '&search='.urlencode($search).'&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
           
                     $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url() .$this->_data['section_name']. "/products/ajax_image_index/" . $product_id,
                'params' => $querystr,
                'element' => 'contentpanel'
            );
            widget('custom_pagination', $options);
        ?>
                    </div>
                </div>
            </div><!-- col-md-6 -->
        </div>
    </div>
    </div><!-- contentpanel -->
    <script>
        
        function submit_search()
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        if($('#search').val() == 'select'){
            $('#search').validationEngine('showPrompt', '<?php echo lang('msg-search-req-type'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        session_set();
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search:encodeURIComponent($('#search').val()) , search_status:encodeURIComponent($('#search_status').val()) },
            success: function(data) {
                $("#contentpanel").html(data);
            }
        });
        unblockUI();
    }
    function session_set()
    {             
        $.ajax(
        {
            type: 'POST',
            url: '<?php echo base_url().$this->_data['section_name']; ?>/products/session_set',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',search:$('#search').val(),search_status:$('#search_status').val()}            
        }
    );       
    }
    function sort_data(sort_by, sort_order)
    {
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search:encodeURIComponent($('#search').val()),  search_status:encodeURIComponent($('#search_status').val()) ,sort_by: sort_by, sort_order: sort_order},
            success: function(data) {
                $("#contentpanel").html(data);
            }
        });
        unblockUI();
    }
    function reset_data()
    {
        $("#search").val("select");       
        $("#search_status").val("");       
        session_set();
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        $.ajax({
            type:'POST',
            url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search: "select" , search_status:""},
            success: function(data) {
                $("#contentpanel").html(data);
                unblockUI();
            }
        });
    }
    
        
        function change_search(id)
    {
        if(id != 'select'){
            $('#search_options').css('display', '');
        }
        else{
            $('#search_options').css('display', 'none');
        }
        
        $("#search_options div").hide();
        var value = $("#search_"+id).val();
        $("#search_options .search").val("");
        $("#search_"+id).val(value);
        $("#"+id).show();
    }
    change_search($("#search").val());
     $(".search").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                submit_search();
            }
    });
    
    $(function () {
        $("#check_all").click(function () {
            if ($("#check_all").is(':checked')) {
                $(".check_box").prop("checked", true);
            } else {
                $(".check_box").prop("checked", false);
            }
        });
        
        $(".check_box").click(function(){

            if($(".check_box").length == $(".check_box:checked").length) {
                $("#check_all").prop("checked", true);
                $(".check_box").attr("checked", "checked");
            } else {
                $("#check_all").removeAttr("checked");
            }

        });
    });
    
    function active_records()
    {   
        
        var val = [];
            $(':checkbox:checked').each(function(i){
                val[i] = $(this).val();
            });
             if(val=="")
            {
            alert('Please select atleast one record for active');
            return false;
            }
            else{
         res = confirm('<?php echo lang('active_confirm') ?>');
        if(res)
        {            
            $.ajax({
                type:'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>',
                data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>',type:'active',ids:val , search:encodeURIComponent($('#search').val()) , search_status:encodeURIComponent($('#search_status').val())},
                success: function (data) { 
                    //for managing same state while record delete
                    if($('.rows') && $('.rows').length > 1){
                        pageno = "&page_number=<?php echo $page_number; ?>";                        
                    }else{
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";                        
                    }                    
                    ajaxLink('<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>','contentpanel','<?php echo $querystr; ?>'+pageno);
                    $("#messages").show();
                    $("#messages").html(data);
                }
            });
        }
        else
        {
            return false;
        }
        }
    }
    
    function inactive_records()
    {   
        var val = [];
            $(':checkbox:checked').each(function(i){
                val[i] = $(this).val();
            });
             if(val=="")
            {
            alert('Please select atleast one record for inactive');
            return false;
            }
            else{
         res = confirm('<?php echo lang('inactive_confirm') ?>');
        if(res)
        {    
            $.ajax({
                type:'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',type:'inactive',ids:val , search:encodeURIComponent($('#search').val()) , search_status:encodeURIComponent($('#search_status').val())},
                success: function (data) { 
                    //for managing same state while record delete
                    if($('.rows') && $('.rows').length > 1){
                        pageno = "&page_number=<?php echo $page_number; ?>";                        
                    }else{
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";                        
                    }                    
                    ajaxLink('<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>','contentpanel','<?php echo $querystr; ?>'+pageno);
                    $("#messages").show();
                    $("#messages").html(data);
                }
            });
        }
        else
        {
            return false;
        }
    }
    }
    function active_all_records()
    {
        
         res = confirm('<?php echo lang('active_all_confirm') ?>');
        if(res)
        {    
            $.ajax({
                type:'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',type:'active_all' , search:encodeURIComponent($('#search').val()) , search_status:encodeURIComponent($('#search_status').val())},
                success: function (data) { 
                    //for managing same state while record delete
                    if($('.rows') && $('.rows').length > 1){
                        pageno = "&page_number=<?php echo $page_number; ?>";                        
                    }else{
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";                        
                    }                    
                    ajaxLink('<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>','contentpanel','<?php echo $querystr; ?>'+pageno);
                    $("#messages").show();
                    $("#messages").html(data);
                }
            });
        }
        else
        {
            return false;
        }
       
    }
    
    function inactive_all_records()
    {   
       
         res = confirm('<?php echo lang('inactive_all_confirm') ?>');
        if(res)
        {    
            $.ajax({
                type:'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',type:'inactive_all' ,search:encodeURIComponent($('#search').val()) , search_status:encodeURIComponent($('#search_status').val())},
                success: function (data) { 
                    //for managing same state while record delete
                    if($('.rows') && $('.rows').length > 1){
                        pageno = "&page_number=<?php echo $page_number; ?>";                        
                    }else{
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";                        
                    }                    
                    ajaxLink('<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>','contentpanel','<?php echo $querystr; ?>'+pageno);
                    $("#messages").show();
                    $("#messages").html(data);
                }
            });
        }
        else
        {
            return false;
        }
        
    }
    function delete_records()
    {           
            var val = [];
            $(':checkbox:checked').each(function(i){
                val[i] = $(this).val();
            });
            if(val=="")
            {
            alert('Please select atleast one record for delete');
            return false;
            }
            else{
            res = confirm('<?php echo lang('delete_confirm') ?>');
            if(res)
            {
            $.ajax({
                type:'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',type:'delete',ids:val ,search:encodeURIComponent($('#search').val()) , search_status:encodeURIComponent($('#search_status').val())},
                success: function (data) { 

                    //for managing same state while record delete
                    if($('.rows') && $('.rows').length > 1){
                        pageno = "&page_number=<?php echo $page_number; ?>";                        
                    }else{
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";                        
                    }                    
                    ajaxLink('<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_image_index/<?php echo $product_id; ?>','contentpanel','<?php echo $querystr; ?>'+pageno);
                    $("#messages").show();
                    $("#messages").html(data);
                }
            });
        }
        else
        {
            return false;
        }
        }
    }
    </script>