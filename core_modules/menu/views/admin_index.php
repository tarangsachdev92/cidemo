<div id="menu-grid">
    <div class="contentpanel">
        <!--language list div-->
        <div class="panel panel-default form-panel">
            <div class="panel-body">
                <div class="row row-pad-5"> 
                    <div class="col-lg-12 col-md-12 langbtn">
                        <?php
                        if (!empty($languages)) {
                            ?>
                            <?php
                            foreach ($languages as $key => $langval):
                                $alias = end(array_keys($langval));
                                ?>
                                <a href="javascript:;" class="btn <?php echo($lang_id == $langval[$alias]['id']) ? 'btn-primary' : 'btn-default'; ?>" id="<?php echo $langval[$alias]['id']; ?>" onclick="loadmenulist('<?php echo $langval[$alias]['id']; ?>')" title="<?php echo strtolower($langval[$alias]['language_code']); ?>"><i class="fa fa-comments"></i> &nbsp; <?php echo $langval[$alias]['language_name']; ?></a>

                            <?php endforeach; ?>
                        <?php } ?>

                    </div>
                </div>  
            </div>
        </div>
        <!--language list div-->





        <div class="row">        
            <div class="col-md-12">
                <div class="panel-header clearfix">
                    <span style="float: left;">
                        <?php echo add_image(array('active.png')) . lang('menu-active') . '&nbsp;&nbsp;&nbsp;' . add_image(array('inactive.png')) . " " . lang('menu-inactive'); ?>
                    </span>

                    <a class="add-link" onclick="openlink('add')" title="Add Menu" href="javascript:;">Add Menu</a>
                </div>


                <div class="panel table-panel">
                    <div class="panel-body">

                        <?php
                        if (count($languages) > 0) {

                            foreach ($languages as $key => $langval) {
                                $alias = end(array_keys($langval));
                                ?> 
                                <div id="<?php echo $langval[$alias]['language_code']; ?>" style="display:<?php echo($lang_id == $langval[$alias]['id']) ? 'block' : 'none'; ?>">   
                                    <?php foreach ($menu as $menuname => $menuitem) { ?>
                                        <h4><?php echo $menuname; ?></h4>
                                        <div class="table-responsive"> 
                                            <table class="table table-hover gradienttable">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo lang("menu-title"); ?></th>
                                                        <th><?php echo lang("menu-slug"); ?></th>
                                                        <th class="t-center"><?php echo lang("menu-status"); ?></th>
                                                        <th class="t-center"><?php echo lang("menu-action"); ?></th>
                                                    </tr>

                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $i = 1;

                                                    foreach ($menuitem as $key => $val) {

                                                        $id = $val['id'];
                                                        $statuslink = ($val['status'] == 1) ? add_image(array('active.png'), '', '', array('title' => 'active', 'alt' => "active")) : add_image(array('inactive.png'), '', '', array('title' => 'inactive', 'alt' => "inactive"));
                                                        $language_name = strtolower($val['language_code']);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $val['title']; ?></td>
                                                            <td>
                                                                <?php
                                                                $menulink = ($val['link'] == '/') ? '' : $val['link'];
                                                                echo site_url() . $menulink;
                                                                ?>
                                                            </td>
                                                            <td class="t-center">
                                                                <?php
                                                                if ($val['status'] == '1') {
                                                                    echo add_image(array('active.png'), '', '', array('title' => 'active', 'alt' => "active"));
                                                                } else {
                                                                    echo add_image(array('inactive.png'), '', '', array('title' => 'inactive', 'alt' => "inactive"));
                                                                }
                                                                ?>
                                                            </td>

                                                            <td class="t-center">
                                                                <a class="mr5" href="<?php echo site_url() . get_current_section($this); ?>/menu/action/edit/<?php echo $language_name . "/" . $id; ?>" title="Edit Menu"><i class="fa fa-pencil"></i></a>

                                                                <a class="delete-row" href="javascript:;" onclick="deletemenu('<?php echo $id; ?>')" title="Delete Menu"><i class="fa fa-trash-o"></i></a>

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
                                    }
                                    ?>
                                </div>    
                                <?php
                            }
                        } else {
                            echo 'No Record(s) Found';
                        }
                        ?>
                    </div>
                </div>
            </div><!-- col-md-6 -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

//        $(".tab-headings li a").on('click', function()
//        {
//            var thisId = $(this).attr("rel");
//            var langid = $(this).attr('id');
//            $(".tab-headings li").removeClass("selected");
//            $(this).parent('li').addClass("selected");
//            $(".profile-content").hide();
//            $(thisId).show();
//            loadmenulist(langid);
//        });

    });

    function openlink(type) {
        //alert($(".tab-headings li.selected a").attr('rel'));
        lang_name = $(".btn-primary").attr('title');
        // lang_name = (lang_name != '') ? lang_name.replace("#", "") : '';
        location.href = "<?php echo base_url() . get_current_section($this->theme->ci()); ?>/menu/action/add/" + lang_name;
    }

    function deletemenu(id) {
        res = confirm('<?php echo lang('confirm-menu-delete-msg'); ?>');
        lang_id = $(".btn-primary").attr('id');
        if (res) {
            //succflag = false;
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . get_current_section($this); ?>/menu/delete',
                data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',
                    id: id,
                    lang_id: lang_id
                },
                success: function(data) {

                    $("#messages").show();
                    $("#messages").html(data);
                    $("#menu" + id).remove();
                    loadmenulist(lang_id); //reload menu items
                    $("html, body").animate({scrollTop: 0}, "slow");
                    //location.reload();
                }
            });

        } else {
            return false;
        }
    }

    function loadmenulist(lang_id) {

        $('a.btn').attr('class', 'btn btn-default');
        $('#' + lang_id).attr('class', 'btn btn-primary');

        blockUI();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . get_current_section($this->theme->ci()); ?>/menu/index',
            data: {<?php echo $this->theme->ci()->security->get_csrf_token_name(); ?>: '<?php echo $this->theme->ci()->security->get_csrf_hash(); ?>',
                lang_id: lang_id
            },
            success: function(data) {
                
                $("#menu-grid").html('');
                if (data == '') {
                    $("#menu-grid").hide();
                } else {
                    $("#menu-grid").html(data);
                    $("#menu-grid").show();
                }
                unblockUI();
            }
        });

    }
</script>

