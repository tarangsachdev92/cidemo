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

    $(document).ready(function() {


        openlink = function(type) {
            //lang_code = $(".demourl").attr('title');alert();exit;
            lang_code = $("a.btn-primary").attr('title');
            location.href = "<?php echo base_url() . $this->_data['section_name']; ?>/categories/action/add/"+lang_code;
        };

        delete_category = function(id, slug_url)
        {
            res = confirm('<?php echo lang('delete_confirm') ?>');

            if (res) {
                blockUI();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . $this->_data['section_name']; ?>/categories/delete',
                    data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>', id: id, slug_url: slug_url},
                    success: function(data) {
                        
                        lang_code = $("a.btn-primary").attr('title');

                        load_ajax_index(lang_code);
                        // show success message
                        unblockUI();
                        $("#messages").show();
                        $("#messages").html(data);
                    }
                });

            } else {
                return false;
            }
        };

        load_ajax_index = function(lang_code) {

            $('a.btn').attr('class', 'btn btn-default');
            $('#btn-' + lang_code).attr('class', 'btn btn-primary');


            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $this->_data['section_name']; ?>/categories/ajax_index/' + lang_code,
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
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

        };
        load_ajax_index('<?php echo $language_code; ?>');
    });
    
     $(document).ajaxComplete(function() {
        // Chosen Select
        jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
    });
</script><!--Accordion Jquery -->
<?php
