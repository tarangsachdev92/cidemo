<div id="contentpanel">
    <div class="contentpanel">
        
        <div class="panel panel-default form-panel">
            <div class="panel-body">
                <form>           
                    <div class="row row-pad-5"> 
                        <div class="col-lg-3 col-md-3">
                            <?php
                            $input_data = array(
                                'name' => 'search_term',
                                'id' => 'search_term',
                               'title' => 'search',
                                'class' => 'form-control',
                                'placeholder' => lang('search_by_title'),
                                'value' => set_value('search_term', urldecode($search_term))
                            );
                            echo form_input($input_data);
                            ?>
                        </div>               
                        <div class="col-lg-3 col-md-3">
                            <?php
                            $search_button = array(
                                'content' =>  '<i class="fa fa-search"></i> &nbsp; '.lang('search'),
                                'title' => lang('search'),
                                'class' => 'btn btn-primary',
                                'onclick' => "submit_search()",
                            );
                            echo form_button($search_button);
                            ?>
                            <!--                        <button class="btn btn-primary">Search</button>-->

                            <?php
                            $reset_button = array(
                                'content' => '<i class="fa fa-refresh"></i> &nbsp; '.lang('reset'),
                                'title' => lang('reset'),
                                'class' => 'btn btn-default btn-reset',
                                'onclick' => "reset_data()",
                                "type" => "reset"
                            );
                            echo form_button($reset_button);
                            ?>
                        </div>
                    </div>  



                </form>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-12">
                
                <div class="panel-header clearfix">

                <!--                <h3 class="mb15">Table With Actions</h3>-->

                <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>

                <a class="add-link" href="javascript:;" onclick="openlink('add')" title="<?php echo lang('add_category');?>"><?php echo lang('add_category');?></a>
            </div>
                
                
                <div class="panel table-panel">
                    <div class="panel-body">
                        <?php
                          if (!empty($category_list))
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

                                    <th><?php echo lang('sr_no') ?></th>

                                    <th>
                                       
                                         <?php
                        $field_sort_order = 'asc';
                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                        if($sort_by == 'c.title' && $sort_order == 'asc')
                        {
                            $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('c.title', '<?php echo $field_sort_order;?>');" class="wht-fnt">
                            <?php echo lang('title'); ?>
                            <?php if($sort_by == 'c.title')
                            {
                                echo $sort_image;
                            }
                            ?>
                        </a>
                                    </th>

                                    <th>
                                        <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'c.slug_url' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('c.slug_url', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Slug URL"><?php echo lang('slug_url'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'c.slug_url') {
                                                echo $sort_image;
                                            }
                                            ?></a>
                                    </th>
                                    

                                    <th>
                                       <?php
                        $field_sort_order = 'asc';
                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                        if($sort_by == 'cm.title' && $sort_order == 'asc')
                        {
                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="#" onclick="sort_data('cm.title', '<?php echo $field_sort_order;?>');" class="wht-fnt" title="Sort by Module Name">
                            <?php echo lang('module'); ?>
                            <?php if($sort_by == 'cm.title')
                            {
                                echo $sort_image;
                            } ?>
                        </a>
                                    </th>
                                    <th>
                                       <?php
                                        $field_sort_order = 'asc';
                                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                        if ($sort_by == 'c.status' && $sort_order == 'asc') {
                                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                            $field_sort_order = 'desc';
                                        }
                                        ?>

                                        <a href="javascript:;" onclick="sort_data('c.status', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Slug URL"><?php echo lang('status'); ?>&nbsp;&nbsp;&nbsp;<?php
                                            if ($sort_by == 'c.status') {
                                                echo $sort_image;
                                            }
                                            ?></a> 
                                    </th>
                                    <th><?php echo lang('actions'); ?></th>

                                    </tr>

                                    </thead>
                                    <tbody>
                                    <?php
             
                    if ($page_number > 1) {
                        $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page'] * ($page_number - 1)) + 1;
                    } else {
                        $i = 1;
                    }
                    foreach ($category_list as $category_page)
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
                                                    <input type="checkbox" id="<?php echo $category_page['c']['id']; ?>" name="check_box[]" class="check_box" value="<?php echo $category_page['c']['id']; ?>" >
                                                        <label for="<?php echo $category_page['c']['id']; ?>"></label>

                                                    </div>
                                                </td>
                                                <td><?php echo $i; ?></td>
                                                <td> <?php
                                if(isset($category_page['c']['parent_id']) && $category_page['c']['parent_id'] != 0)
                                {
                                    echo '&nbsp;&nbsp;&nbsp; - ';
                                }
                                echo $category_page['c']['title']; ?></td>
                                                <td><?php echo $category_page['c']['slug_url']; ?></td>
                                                 <td><?php echo $category_page['cm']['title']; ?></td>
                                                <td>
                                                    <?php
                                if ($category_page['c']['status'] == 1)
                                {
                                    echo add_image(array('active.png'));
                                }
                                else
                                {
                                    echo add_image(array('inactive.png'));
                                }
                                ?>
                                                </td>

                                              


                                                <td>

                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/categories/view/<?php echo $category_page['l']['language_code'] . "/" . $category_page['c']['category_id']; ?>"><i class="fa fa-eye"></i></a>

                                                    <a class="mr5" href="<?php echo site_url() . $this->_data['section_name']; ?>/categories/action/edit/<?php echo $category_page['l']['language_code'] . "/" . $category_page['c']['category_id']; ?>" title="<?php echo lang('edit'); ?>"><i class="fa fa-pencil"></i></a>

                                                    <a class="delete-row" href="javascript:;" onclick="delete_category('<?php echo $category_page['c']['id']; ?>', '<?php echo $category_page['c']['slug_url']; ?>')"><i class="fa fa-trash-o"></i></a>

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
                       
                            


                         $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
            $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url().$this->_data["section_name"]."/categories/ajax_index/" . $language_code,
                'params' => $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . urlencode($search_term). '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '',
                'element' => 'contentpanel'
            );

            widget('custom_pagination', $options);
        ?>
                    </div>
                </div>
            </div><!-- col-md-6 -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#search_term").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                submit_search();
            }
    });
    function submit_search()
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        if($('#search_term').val() == ''){
            $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg_search_req'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }
        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url().$this->_data["section_name"]; ?>/categories/ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term:encodeURIComponent($('#search_term').val())},
            success: function(data) {
                $("#contentpanel").html(data);
            }
        });
        unblockUI();
    }

    function sort_data(sort_by, sort_order)
    {

        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url().$this->_data["section_name"]; ?>/categories/ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term:encodeURIComponent($('#search_term').val()), sort_by: sort_by, sort_order: sort_order},
            success: function(data) {
                $("#contentpanel").html(data);
            }
        });
        unblockUI();
    }

    function reset_data()
    {
        $('#error_msg').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        $.ajax({
            type:'POST',
            url: '<?php echo base_url().$this->_data["section_name"]; ?>/categories/ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>', search_term: ""},
            error: function(){
		        alert("Server problem. Please try again.");
       			return false;
	        },
       		complete: function(){
	        	unblockUI();
       		},
            success: function(data) {
                $("#contentpanel").html(data);
            }
        });
    }
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
        $.ajax({
            type:'POST',
            url: '<?php echo base_url().$this->_data['section_name']; ?>/categories/ajax_index/<?php echo $language_code; ?>',
            data: {<?php echo $this->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->ci()->security->get_csrf_hash(); ?>',type:'active',ids:val},
            success: function (data) {
                //for managing same state while record delete
                if($('.rows') && $('.rows').length > 1){
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }else{
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }
                ajaxLink('<?php echo base_url().$this->_data['section_name']; ?>/categories/ajax_index','contentpanel','<?php echo $querystr; ?>'+pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });
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
        $.ajax({
            type:'POST',
            url: '<?php echo base_url().$this->_data['section_name']; ?>/categories/ajax_index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',type:'inactive',ids:val},
            success: function (data) {
                //for managing same state while record delete
                if($('.rows') && $('.rows').length > 1){
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }else{
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }
                ajaxLink('<?php echo base_url().$this->_data['section_name']; ?>/categories/ajax_index','contentpanel','<?php echo $querystr; ?>'+pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    }
    function active_all_records()
    {
        $.ajax({
            type:'POST',
            url: '<?php echo base_url().$this->_data['section_name']; ?>/categories/ajax_index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',type:'active_all'},
            success: function (data) {
                
               
                
                //for managing same state while record delete
                if($('.rows') && $('.rows').length > 1){
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }else{
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }
                ajaxLink('<?php echo base_url().$this->_data['section_name']; ?>/categories/ajax_index','contentpanel','<?php echo $querystr; ?>'+pageno);
                $("#messages").show();
                $("#messages").html(data);
            }
        });
    }

    function inactive_all_records()
    {
        $.ajax({
            type:'POST',
            url: '<?php echo base_url().$this->_data['section_name']; ?>/categories/ajax_index',
            data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',type:'inactive_all'},
            success: function (data) {
                //for managing same state while record delete
                if($('.rows') && $('.rows').length > 1){
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }else{
                    pageno = "&page_number=<?php echo $page_number; ?>";
                }
                ajaxLink('<?php echo base_url().$this->_data['section_name']; ?>/categories/ajax_index','contentpanel','<?php echo $querystr; ?>'+pageno);
                
               
                $("#messages").show();
                $("#messages").html(data);
            }
        });
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
        res = confirm('<?php echo lang('delete_confirm') ?>');
        if(res){
            $.ajax({
                type:'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/categories/ajax_index',
                data: {<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',type:'delete',ids:val},
                success: function (data) {

                    //for managing same state while record delete
                    if($('.rows') && $('.rows').length > 1){
                        pageno = "&page_number=<?php echo $page_number; ?>";
                    }else{
                        pageno = "&page_number=<?php echo $page_number; ?>";
                    }
                    ajaxLink('<?php echo base_url().$this->_data['section_name']; ?>/categories/ajax_index','contentpanel','<?php echo $querystr; ?>'+pageno);
                    
                $("#messages").show();
                    $("#messages").html(data);
                }
            });
        }else
        {
            return false;
        }
       }
</script>