<div class="main-content">
    <div class="grid-data info-content">

        <!--Language Button Div-->
        <div class="contentpanel">
            <div class="panel panel-default form-panel mb-none" style="display: none;">
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
                                <a href="javascript:;" id="btn-<?php echo $languages[$i]['l']['language_code'] ?>" onclick="load_form('<?php echo ($languages[$i]['l']['language_code']); ?>')" <?php echo $selected; ?> title="<?php echo $languages[$i]['l']['language_code']; ?>"><i class="fa fa-comments"></i> &nbsp; <?php echo $languages[$i]['l']['language_name']; ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <!--Language Button Div-->





        <div class="profile-content-box" id="categories_form">            
            <?php echo $content; ?>
        </div>	
    </div>  
</div>
<script type="text/javascript">
    $(document).ready(function() {

        load_form = function(lang_code) {

            $('a.btn').attr('class', 'btn btn-default');
            $('#btn-' + lang_code).attr('class', 'btn btn-primary');

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $this->_data['section_name']; ?>/categories/ajax_view/' + lang_code + '/<?php echo $id; ?>',
                data: {<?php echo $csrf_token; ?>: '<?php echo $csrf_hash; ?>'},
                success: function(msg) {
                    $("#categories_form").html(msg);
                }
            });
        }
    });
</script>