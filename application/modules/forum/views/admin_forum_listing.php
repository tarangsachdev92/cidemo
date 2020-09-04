<?php
if (!isset($sort_order)) {
    $sort_order = "";
}
if (!isset($sort_by)) {
    $sort_by = "";
}
if (!isset($search_term)) {
    $search_term = "";
}
?>

    <div class="main-container">
<!--        <div class="add-new" style="padding-bottom: 5px">
            <span style="float: left;"><?php echo add_image(array('active.png')) . " " . lang('active') . "  " . add_image(array('inactive.png')) . " " . lang('inactive'); ?></span>
            <?php echo anchor(site_url() . 'admin/forum/add_category/add', lang('add-category'), 'title="Add Category" style="text-align:center;width:100%;"'); ?>
            <span style="float: right;"><?php echo anchor(site_url().$this->_data["section_name"] . '/forum/action', lang('add-forum'), 'title="Add Forum" '); ?></span>
            &nbsp;&nbsp;&nbsp;<span style="float: right;"><?php echo anchor(site_url() .$this->_data["section_name"]. '/forum/index/' . $language_code, lang('back-to-category'), 'title="Back to category" style="margin-right:20px;" '); ?></span>
        </div>
        <br/>-->


        

        <!--Language Button Div-->
        <div class="contentpanel">
            <div class="panel panel-default form-panel mb-none">
                <div class="panel-body">
                    <div class="row row-pad-5"> 
                        <div class="col-lg-12 col-md-12 langbtn">
                            <?php
                            for ($i = 0; $i < count($languages); $i++) {
                                $selected = 'class="btn btn-default"';
                                if (($languages[$i]['l']['id']) == $language_id) {
                                    $selected = 'class="btn btn-primary"';
                                }
                                ?>
                                <a <?php echo $selected; ?> href="javascript:;" id="btn-<?php echo $languages[$i]['l']['language_code'] ?>"  title="<?php echo ($languages[$i]['l']['language_code']); ?>" onclick="load_form('<?php echo ($languages[$i]['l']['language_code']); ?>')"><i class="fa fa-comments"></i> &nbsp; <?php echo $languages[$i]['l']['language_name']; ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <!--Language Button Div-->
        
        <div class="forum-content-box" id="listing">
            <!-- Form will come here -->

        </div>

    </div>

<script type="text/javascript">
    $(document).ready(function() {
        delete_forum = function(id)
        {
            res = confirm('<?php echo lang('delete-alert') ?>');
            lang_code = $(".btn-primary").attr('title');
            
            if(res){
                blockUI();
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url().$this->_data["section_name"]; ?>/forum/delete_forum/'+lang_code,
                    data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:'<?php echo $this->_ci->security->get_csrf_hash(); ?>',id:id,category:<?php echo $category_id ?>},
                    success: function(data) {
                         lang_code = $(".btn-primary").attr('title');
                        load_form(lang_code);
                        // show success message
                        unblockUI();
                        $("#messages").show();
                        $("#messages").html(data);
                    }
                });

            }else{
                return false;
            }
        };


        load_form = function(lang_code) {
        
            $('a.btn').attr('class', 'btn btn-default');
            $('#btn-' + lang_code).attr('class', 'btn btn-primary');
        
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url().$this->_data["section_name"]; ?>/forum/ajax_forum_listing/<?php echo $category_id; ?>/' + lang_code,
                
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},

                success: function(data) {
                    if (data === '') {
                        $(".forum-content-box").hide();
                    } else {
                        $(".forum-content-box").html(data);
                        $(".forum-content-box").show();
                    }
                    unblockUI();
                }
            });
        };
        load_form('<?php echo $language_code; ?>');
    });
</script>