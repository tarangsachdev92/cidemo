   <div class="contentpanel">
      <div class="panel panel-default form-panel">
        <div class="panel-body">
              <?php echo form_open(); ?>     
              <div class="row row-pad-5">
                <div class="col-lg-3 col-md-3">
                    <select name="trans_lang" id="trans_lang" class="form-control">
                        <?php foreach ($languages as $lang) : ?>
                            <option value="<?php e($lang) ?>" <?php echo isset($trans_lang) && $trans_lang == $lang ? 'selected="selected"' : '' ?>><?php e(ucfirst($lang)) ?></option>
                        <?php endforeach; ?>
                        <option value="other"><?php e(lang('tr_other')); ?></option>
                    </select><br>
                    <input type="text" name="new_lang" id="new_lang" style="display: none" value="" class="form-control"/>    
                </div>
               
                  <div class="col-lg-3 col-md-3" id="slug_url_id">
                  <input type="submit" name="select_lang" class="btn btn-small btn-primary" value="<?php e(lang('tr_select_lang')); ?>" />    
                </div>
                <?php echo form_close(); ?>
                 
        </div>
      </div>
      <div class="row">        
        <div class="col-md-12">
       		
    	  <div class="panel table-panel">
          	<div class="panel-body">
            
	      	    <div class="table-responsive">  
                        
          		<table class="table" >
                     <thead>
                          <tr>
                  	<th>
                    	<?php echo lang('tr_core') ?>
                    </th>
                    </tr>
                   
                </thead>
                
                <?php foreach ($lang_files as $file) : ?>
                <tbody>
                    
                  <tr>
                   <td>
                            <a href="<?php echo site_url('/'.get_current_section($this).'/translate/edit/' . $trans_lang . '/' . $file) ?>">
                                <?php e($file); ?>
                            </a>
                        </td>
                    
                  </tr>
                    <?php endforeach; ?>                

                    
                  
                </tbody>
          </table>
                        
          <table class="table" >
                     <thead>
                          <tr>
                  	<th>
                    	<?php echo lang('tr_modules') ?>
                    </th>
                    </tr>
                   
                </thead>
                 <?php if(isset($modules) && is_array($modules) && count($modules)) : ?>
                    <?php foreach ($modules as $file) : ?>
                <tbody>
                    
                  <tr>
                   <td>
                           <a href="<?php echo site_url('/'.get_current_section($this).'/translate/edit/' . $trans_lang . '/' . $file) ?>">
                                    <?php e($file); ?>
                            </a>
                        </td>
                    
                  </tr>
                     <?php endforeach; ?>
                <?php else : ?>
                     <tr>
                        <td>
                            <div class="alert alert-info fade in">
                                <a class="close" data-dismiss="alert">&times;</a>		
                                <?php echo lang('tr_no_modules'); ?>
                            </div>
                        </td>
                    </tr>
                     <?php endif; ?>
                  
                </tbody>
          </table> 
              
          </div>
          </div>
          </div>
        </div><!-- col-md-6 -->
      </div>
      
    
    </div><!-- contentpanel -->
 <script type="text/javascript">
        $(document).ready(function(e){

            $('#trans_lang').change(function() {
                
                var lang = $(this).find("option:selected").val();
		
                if (lang == 'other')
                {
                    $('#new_lang').show('slow');
                }
                else
                {
                    $('#new_lang').hide('slow');
                }
            });

        });
    </script>