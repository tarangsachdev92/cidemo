<div class="main-container">

    <div>
        <!--Language Button Div-->
        <div class="contentpanel">
            <div class="panel panel-default form-panel mb-none">
                <div class="panel-body">
                    <div class="row row-pad-5"> 
                        <div class="col-lg-12 col-md-12 langbtn">
                            <?php
                            for ($i = 0; $i < count($languages_list); $i++) {
                                $selected = 'class="btn btn-default demourl11"';
                                if (($languages_list[$i]['l']['id']) == $language_id) {
                                    $selected = 'class="btn btn-primary demourl"';
                                }
                                ?>
                                <a <?php echo $selected; ?> href="javascript:;" id="btn-<?php echo $languages_list[$i]['l']['language_code'] ?>"  title="<?php echo ($languages_list[$i]['l']['language_code']); ?>" onclick="load_ajax_index('<?php echo ($languages_list[$i]['l']['language_code']); ?>')"><i class="fa fa-comments"></i> <?php echo $languages_list[$i]['l']['language_name']; ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <!--Language Button Div-->
        
        
        
    </div>

    <div class="menu-content-box">
        <!-- load your ajax content here -->
    </div>

</div>

<script type="text/javascript">
<?php
        if(isset($this->_ci->session->userdata[$this->_data['section_name']]["search"])){                    
        $search = $this->_ci->session->userdata[$this->_data['section_name']]["search"]; 
        }
        if(isset($this->_ci->session->userdata[$this->_data['section_name']]["search_name"])){
            $search_name = $this->_ci->session->userdata[$this->_data['section_name']]["search_name"];
        }
        if(isset($this->_ci->session->userdata[$this->_data['section_name']]["search_slug"])){
            $search_slug= $this->_ci->session->userdata[$this->_data['section_name']]["search_slug"];
        }
        if(isset($this->_ci->session->userdata[$this->_data['section_name']]["search_status"])){
            $search_status=$this->_ci->session->userdata[$this->_data['section_name']]["search_status"];  
        }
        if(isset($this->_ci->session->userdata[$this->_data['section_name']]["search_category"]))
        {
            $search_category=$this->_ci->session->userdata[$this->_data['section_name']]["search_category"];  
        }
        if(isset($this->_ci->session->userdata[$this->_data['section_name']]["search_from"]))
        {
            $search_from=$this->_ci->session->userdata[$this->_data['section_name']]["search_from"];  
        }
        if(isset($this->_ci->session->userdata[$this->_data['section_name']]["search_to"]))
        {
            $search_to=$this->_ci->session->userdata[$this->_data['section_name']]["search_to"];  
        }
?>
       
    $(document).ready(function() {           
       

        openlink = function(type){
            
            lang_code = $("a.btn-primary").attr('title');
            location.href= "<?php echo base_url().$this->_data['section_name'];?>/products/action/add/";
        }

        delete_product = function(id,slug_url)
        {
            res = confirm('<?php echo lang('delete_confirm') ?>');

            if(res){
                blockUI();
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url().$this->_data['section_name']; ?>/products/delete_product',
                    data:{<?php echo $csrf_token; ?>:'<?php echo $csrf_hash; ?>',id:id,slug_url:slug_url},
                    success: function(data) {
                         lang_code = $("a.btn-primary").attr('title');
                        load_ajax_index(lang_code);
                        // show success message
                        unblockUI();
                        $("#messages").show();
                        $("#messages").html(data);
                    }
                });

            }else{
                return false;
            }
        }

        load_ajax_index = function(lang_code) {
            $('a.btn').attr('class', 'btn btn-default');
            $('#btn-' + lang_code).attr('class', 'btn btn-primary');
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url().$this->_data['section_name']; ?>/products/ajax_index/' + lang_code,
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>',search:'<?php echo isset($search)?$search:'select'; ?>',search_name:'<?php echo isset($search_name)?$search_name:''; ?>',search_slug:'<?php echo isset($search_slug)?$search_slug:''; ?>',search_status:'<?php echo isset($search_status)?$search_status:''; ?>',search_category:'<?php echo isset($search_category)?$search_category:'0';?>',search_from:'<?php echo isset($search_from)?$search_from:""?>',search_to:'<?php echo isset($search_to)?$search_to:""?>'},
                success: function(data) {                   
                    if (data == '') {
                        $(".menu-content-box").hide();
                    } else {
                        $(".menu-content-box").html(data);
                        $(".menu-content-box").show();
                    }
                    unblockUI();
                }
            });

        }
        load_ajax_index('<?php echo $language_code; ?>');
    });
</script><!--Accordion Jquery -->
