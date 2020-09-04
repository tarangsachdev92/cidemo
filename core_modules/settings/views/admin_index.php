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
                                    'value' => set_value('search_term',urldecode($search_term)),
                                    'class' => 'form-control',
                                    'placeholder' => 'Search by Setting Title',
                                );
                                echo form_input($input_data);
                                ?>
                </div>
                        
                <div class="col-lg-3 col-md-3">
                	<?php
                        $search_button = array(
                            'content' => '<i class="fa fa-search"></i> &nbsp; '.lang('btn-search'),
                            'title' => lang('btn-search'),
                            'class' => 'btn btn-primary',
                            'onclick' => "submit_search()",
                        );
                        echo form_button($search_button);
                        ?>
                        <!--                        <button class="btn btn-primary">Search</button>-->

                        <?php
                        $reset_button = array(
                            'content' => '<i class="fa fa-refresh"></i> &nbsp; '.lang('reset_button'),
                            'title' => lang('reset_button'),
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
	        <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>

    	      <a href="<?php echo site_url() . get_current_section($this).'/settings/action/add' ?>" class="add-link"><?php echo lang('settings-add'); ?></a>
           	</div>
            <?php
            if(!empty($settings))
            {
                ?>
    	  <div class="panel table-panel">
          	<div class="panel-body">
	      	    <div class="table-responsive">          		
          		<table class="table" >
                <thead>
                  <tr>
                  	
                      <th class="t-center"><?php echo lang('setting-id');?></th>
                    <th>
                        <?php
                        $field_sort_order = 'asc';
                        $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                        if($sort_by == 's.setting_title' && $sort_order == 'asc')
                        {
                            $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                            $field_sort_order = 'desc';
                        }
                        ?>
                        <a href="javascript:;" onclick="sort_data('s.setting_title', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Setting Title"><?php echo lang('setting-title');?>&nbsp;&nbsp;&nbsp;
                                        
                            <?php
                            if($sort_by == 's.setting_title')
                            {
                                echo $sort_image; }
                            ?>
                        </a>
                    </th>
                    
                    <th><?php echo lang('setting-label');?></th>
                    <th><?php echo lang('setting-value');?></th>
                    <th><?php echo lang('setting-comment');?></th>
                    <th class="t-center"><?php echo lang('setting-action');?></th>
                  </tr>
                </thead>
                <tbody>
            <?php
                    if($page_number > 1)
                    {
                        $i = ($this->session->userdata[get_current_section($this)]['record_per_page']*($page_number-1)) +1;
                    }
                    else
                    {
                        $i = 1;
                    }
                    foreach ($settings as $data)
                    {
                        //take alias from an array
                        $alias = end(array_keys($data));
                        if($i % 2 != 0)
                        {
                            $class = "odd-row";
                        }
                        else
                        {
                            $class = "even-row";
                        }
                        ?>
                  
                   <tr>
                    <td class="t-center" style="width: 60px"><?php echo $i; ?></td> 
                    <td><?php echo $data[$alias]['setting_title'];?></td>
                    <td><?php echo $data[$alias]['setting_label'];?></td>
                    <td><?php echo $data[$alias]['setting_value'];?></td>
                    <td><?php echo $data[$alias]['comment'];?></td>
                    <td class="t-center" style="width: 100px">
                   <a class="mr5" href="<?php echo site_url().get_current_section($this);?>/settings/view_data/<?php echo $data[$alias]['id']; ?>" title="<?php echo lang('view'); ?>"><i class="fa fa-eye"></i></a>
                    <?php
                                                    $setting_id = $data[$alias]['id'];
                                                    ?>
                  <a href="<?php echo base_url().get_current_section($this).'/settings/action/edit/' . $data[$alias]['id'];?>" class="mr5" title="<?php echo lang('edit'); ?>"><i class="fa fa-pencil"></i></a>
                <a class="delete-row" href="javascript:;" onclick="delete_settings('<?php echo $setting_id; ?>')" title="<?php echo lang('delete'); ?>"><i class="fa fa-trash-o"></i></a>
                  </tr>
                   <?php
                        $i++;
                    }
                    ?>  
                  
            
                </tbody>
              </table>
              
          </div>
          	
                    <?php
                    } else {
                        echo 'No Record(s) Found';
                    }
                    ?>

                   <?php
          
            $querystr = $this->theme->ci()->security->get_csrf_token_name() . '=' . urlencode($this->theme->ci()->security->get_csrf_hash()) . '&search_term=' . $search_term . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
            $options = array(
                'total_records' => $total_records,
                'page_number' => $page_number,
                'isAjaxRequest' => 1,
                'base_url' => base_url().get_current_section($this)."/settings/index",
                'params' => $querystr,
                'element' => 'ajax_table'
            );
            widget('custom_pagination',$options);
            ?>
          	</div>
          </div>
        </div><!-- col-md-6 -->
      </div>
      
    
    </div><!-- contentpanel -->
   
     <script type="text/javascript">	
        $("#search_term").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                submit_search();
            }
        });
        function delete_settings(id){        
            res = confirm('<?php echo lang('confirm-delete-msg');?>');    
            if(res){
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url().get_current_section($this);?>/settings/delete',
                    data:{<?php echo $this->theme->ci()->security->get_csrf_token_name();?>:'<?php echo $this->theme->ci()->security->get_csrf_hash();?>',id:id},
                    success: function(data) {                        
                        //for managing same state while record delete
                        if($('.rows') && $('.rows').length > 1){
                            pageno = "&page_number=<?php echo $page_number;?>";                        
                        }else{
                            pageno = "&page_number=<?php echo $page_number - 1;?>";                        
                        }                    
                        ajaxLink('<?php echo base_url().get_current_section($this);?>/settings/index','ajax_table','<?php echo $querystr;?>'+pageno);
                    
                        //set responce message                    
                        $("#messages").show();
                        $("#messages").html(data);                                                                    
                    }
                });                 
            }else{
                return false;
            }
        }
    
        function submit_search()
        {
            $('#error_msg').fadeOut(1000);
            /*if($('#search_term').val().trim() == ''){
                $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg-search-req');?>', 'error');
                attach_error_event(); //for remove dynamically populate popup
                return false;
            }*/
            blockUI();
            $.ajax({
                type:'POST',
                url:'<?php echo base_url().get_current_section($this);?>/settings/index',
                data:{<?php echo $this->theme->ci()->security->get_csrf_token_name();?>:'<?php echo $this->theme->ci()->security->get_csrf_hash();?>',search_term:$('#search_term').val()},
                success: function(data) {
                    $("#ajax_table").html(data);
                    unblockUI();
                }
            });             
        }
    
        function sort_data(sort_by,sort_order)
        {           
            blockUI('removeError');
            $.ajax({
                type:'POST',
                url:'<?php echo base_url().get_current_section($this);?>/settings/index',
                data:{<?php echo $this->theme->ci()->security->get_csrf_token_name();?>:'<?php echo $this->theme->ci()->security->get_csrf_hash();?>',search_term:$('#search_term').val(),sort_by:sort_by,sort_order:sort_order},
                success: function(data) {                    
                    $("#ajax_table").html(data);                    
                    unblockUI();
                }
            });             
        }
        
        function reset_data()
        {           
            blockUI('removeError');
            $.ajax({
                type:'POST',
                url:'<?php echo base_url().get_current_section($this);?>/settings/index',
                data:{<?php echo $this->theme->ci()->security->get_csrf_token_name();?>:'<?php echo $this->theme->ci()->security->get_csrf_hash();?>',search_term:""},
                success: function(data) {
                    $("#ajax_table").html(data);
                    unblockUI();
                }
            });         
        }
        
       

    </script>