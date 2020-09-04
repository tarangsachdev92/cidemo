   <div class="contentpanel">  
      <div class="row">        
        <div class="col-md-12">
       		<div class="panel-header clearfix">
	         <span><?php echo add_image(array('active.png'), "", "", array('alt' => 'active', 'title' => "active")) . " " . lang('active') . " &nbsp;&nbsp;&nbsp; " . add_image(array('inactive.png')) . " " . lang('inactive') . ""; ?></span>
    	      </div>
    	  <div class="panel table-panel">
          	<div class="panel-body">
            <?php       
             if (!empty($blogcomment)) {
                ?>     
	      	    <div class="table-responsive">  
                        
          		<table class="table" >
                <thead>
                  <tr>
                  	
                  	<th class="t-center"><?php echo lang('no') ?></th>
                    <th> <?php
                                $field_sort_order = 'asc';
                                $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                                if ($sort_by == 'B.title' && $sort_order == 'asc') {
                                    $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                    $field_sort_order = 'desc';
                                }
                                ?>
                                  <a href="javascript:;" onclick="sort_data('B.title', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Blog Title">
                                <?php echo lang('blog-title'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'B.title') {
                                            echo $sort_image;
                                        }
                                        ?></a>
                                 </th>
                    <th>
                        <?php
                            $field_sort_order = 'asc';
                            $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                            if($sort_by == 'BC.name' && $sort_order == 'asc')
                            {
                                $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                $field_sort_order = 'desc';
                            }
                            ?>
                           <a href="javascript:;" onclick="sort_data('BC.name', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Sender Name">
                               <?php echo lang('sender'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'BC.name') {
                                            echo $sort_image;
                                        }
                                        ?>
                                 </a>
                           </th>
                        <th>  
                            <?php
                            $field_sort_order = 'asc';
                            $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                            if($sort_by == 'BC.email' && $sort_order == 'asc')
                            {
                                $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                $field_sort_order = 'desc';
                            }
                            ?>
                           <a href="javascript:;" onclick="sort_data('BC.email', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Sender Email">
                               <?php echo lang('sender-email'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'BC.email') {
                                            echo $sort_image;
                                        }
                                        ?>
                                 </a>
                        </th>
                    <th class="t-center"> 
                <?php
                            $field_sort_order = 'asc';
                            $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                            if($sort_by == 'BC.created' && $sort_order == 'asc')
                            {
                                $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                $field_sort_order = 'desc';
                            }
                            ?>
                           <a href="javascript:;" onclick="sort_data('BC.created', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Created Date">
                                 <?php echo lang('posted-on'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'BC.created') {
                                            echo $sort_image;
                                        }
                                        ?>
                           </a>
                    </th>
                    
                    <th> 
                <?php
                            $field_sort_order = 'asc';
                            $sort_image = '<i class="fa fa-chevron-down" style="color: #FFF"></i>';
                            if($sort_by == 'BC.comment' && $sort_order == 'asc')
                            {
                                $sort_image = '<i class="fa fa-chevron-up" style="color: #FFF"></i>';
                                $field_sort_order = 'desc';
                            }
                            ?>
                           <a href="javascript:;" onclick="sort_data('BC.comment', '<?php echo $field_sort_order; ?>');" class="wht-fnt" title="Sort by Comment">
                               <?php echo lang('sender-comment'); ?>&nbsp;&nbsp;&nbsp;<?php
                                        if ($sort_by == 'BC.comment') {
                                            echo $sort_image;
                                        }
                                        ?>
                           </a>
                    </th>
                  <th class="t-center"><?php echo lang('status') ?></th>
                                <th><?php echo lang('actions') ?></th>
                  </tr>
                </thead>
                <tbody>
                      <?php
                                        if ($page_number > 1) {
                                            $i = ($this->_ci->session->userdata[$this->_data['section_name']]['record_per_page']*($page_number-1)) +1;
                                        } else {
                                            $i = 1;
                                        }
                                        //pre($blogcomment);
                                        foreach ($blogcomment as $_blogcomment) {

                                            if ($i % 2 != 0) {
                                                $class = "odd-row";
                                            } else {
                                                $class = "even-row";
                                            }
                                            ?>
                  <tr>
                  	
                    <td class="t-center"><?php echo $i; ?></td>
                                    <td><?php echo $_blogcomment['B']['title']; ?></td>
                                    <td><?php echo $_blogcomment['BC']['name']; ?></td>
                                    <td><?php echo $_blogcomment['BC']['email']; ?></td>
                                    <td class="t-center"><?php echo $_blogcomment['BC']['created']; ?></td>
                                    <td><?php echo $_blogcomment['BC']['comment']; ?></td>
                                <?php
                                $comment_id = $_blogcomment['BC']['id'];
                                ?>
                                    <td class="t-center"><?php
                        if ($_blogcomment['BC']['status'] == 1) {
                            echo add_image(array('active.png'));
                        } else {
                            echo add_image(array('inactive.png'));
                        }
                                ?></td>
                   
                    <td class="t-center"> 
                        <a class="mr5" href="<?php echo site_url().$this->_data['section_name']; ?>/blog/comment_action/edit/<?php echo $comment_id ?>" title="<?php echo lang('edit') ?>"><i class="fa fa-pencil"></i></a>
                         <?php $deletelink = "<a href='javascript:;' title='Delete' onclick='delete_comment(" . $comment_id . ")' title='<?php echo lang('delete') ?> " . "<i class='fa fa-trash-o'></i>" . "</a>"; ?>
                                         <?php echo $deletelink ?>
                                                
              </td>
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

              $querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '';
$options = array(
    'total_records' => $total_records,
    'page_number' => $page_number,
    'isAjaxRequest' => 1,
    'base_url' => base_url().$this->_data['section_name']. "/blog/comment",
    'params' => $querystr,
    'element' => 'ajax_table'
);

widget('custom_pagination', $options);
            ?>
          	
          	</div>
          </div>
        </div><!-- col-md-6 -->
      </div>
      
    
    </div><!-- contentpanel -->
   <script type="text/javascript">	    
    //remove dynamically populate error
    function attach_error_event(){
        $('div.formError').bind('click',function(){
            $(this).fadeOut(1000, removeError); 
        });
    }    
    function removeError() 
    {
        jQuery(this).remove();
    }
    
    function delete_comment(id){        
        res = confirm('<?php echo lang('delete-comment-alert') ?>');    
        if(res){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url().$this->_data['section_name']; ?>/blog/comment_delete',
                data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',id:id},
                success: function(data) {
                    //for managing same state while record delete
                    if($('.rows') && $('.rows').length > 1){
                        pageno = "&page_number=<?php echo $page_number; ?>";                        
                    }else{
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";                        
                    }                    
                    ajaxLink('<?php echo base_url().$this->_data['section_name']?>/blog/comment','ajax_table','<?php echo $querystr; ?>'+pageno);
                   
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
        if($('#search_term').val().trim() == ''){
            $('#search_term').validationEngine('showPrompt', '<?php echo lang('msg-search-req'); ?>', 'error');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }        
        blockUI();
        $.ajax({
            type:'POST',
            url:'<?php echo base_url().$this->_data['section_name']; ?>/blog/index',
            data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',search_term:$('#search_term').val()},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        }); 
        unblockUI();        
    }
    
    function sort_data(sort_by,sort_order)
    {
        blockUI();
        $.ajax({
            type:'POST',
            url:'<?php echo base_url().$this->_data['section_name']; ?>/blog/comment',
            data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',sort_by:sort_by,sort_order:sort_order},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        }); 
        unblockUI();
    }
    function reset_data()
    {
        blockUI();
        $.ajax({
            type:'POST',
            url:'<?php echo base_url().$this->_data['section_name']; ?>/blog/index',
            data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',search_term:""},
            success: function(data) {
                $("#ajax_table").html(data);
            }
        }); 
        unblockUI();
    }
    
</script>