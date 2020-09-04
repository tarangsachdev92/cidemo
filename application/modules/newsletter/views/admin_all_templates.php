<div id="ajax_table">
    <div class="main-container">

        <!--Language Button Div-->
        <div class="contentpanel">
            <div class="panel panel-default form-panel mb-none">
                <div class="panel-body">
                    <div class="row row-pad-5"> 
                        <div class="col-lg-12 col-md-12 langbtn">
                            <?php
                            for ($i = 0; $i < count($languages_list); $i++) {
                                $selected = 'class="btn btn-default"';
                                if (($languages_list[$i]['l']['id']) == $language_id) {
                                    $selected = 'class="btn btn-primary"';
                                }
                                ?>
                                <a <?php echo $selected; ?> href="javascript:;" id="btn-<?php echo $languages_list[$i]['l']['language_code'] ?>"  title="<?php echo ($languages_list[$i]['l']['language_code']); ?>" onclick="load_ajax_index('<?php echo ($languages_list[$i]['l']['language_code']); ?>')"><i class="fa fa-comments"></i> &nbsp; <?php echo $languages_list[$i]['l']['language_name']; ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <!--Language Button Div-->

        <div class="grid-data grid-data-table">
            <div class="menu-content-box" id="menu-content-box">
                <!-- load your ajax content here -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function attach_error_event() {
        $('div.formError').bind('click', function() {
            $(this).fadeOut(1000, removeError);
        });
    }
    function removeError()
    {
        jQuery(this).remove();
    }
    $(document).ready(function() {
        
        load_ajax_index = function(lang_code) {
            
            $('a.btn').attr('class', 'btn btn-default');
            $('#btn-' + lang_code).attr('class', 'btn btn-primary');
            
            blockUI();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $this->_data['section_name']; ?>/newsletter/ajax_all_templates/' + lang_code,
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
                success: function(data) {
                    if (data === '') {
                        $(".menu-content-box").hide();
                    } else {
                        $(".menu-content-box").html(data);
                        $(".menu-content-box").show();
                    }
                }
            });
            unblockUI();
        };
        load_ajax_index('<?php echo $language_code; ?>');
    });
</script>