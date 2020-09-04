<div class="panel-footer table-footer">

    <?php if (!empty($paging_data) && $paging_data['TOTAL_RECORDS'] > 0) { ?>

        <ul class="pagination pagination-split">
            <?php
            if ($paging_data['PREVIOUS_PAGE_URL']) {
                ?>
                <li><a href="<?php echo $paging_data['PREVIOUS_PAGE_URL'] ?>" onclick="<?php echo $paging_data['PREVIOUS_PAGE_ONCLICK']; ?>" title="Previous"><i class="fa fa-angle-left"></i></a></li>
                <?php
            }

            if (!$paging_data['FIRST_PAGE_LINK']['link'] && $paging_data['FIRST_PAGE_LINK']['label'] != "") {
                ?>
                <li class="active"><a href="#"><?php echo $paging_data['FIRST_PAGE_LINK']['label']; ?></a></li>   
                <?php
            } else if ($paging_data['FIRST_PAGE_LINK']['link']) {
                ?>
                <li><a href="<?php echo $paging_data['FIRST_PAGE_LINK']['link']; ?>" onclick="<?php echo $paging_data['FIRST_PAGE_LINK']['onclick']; ?>"><?php echo $paging_data['FIRST_PAGE_LINK']['label']; ?></a></li>
                <?php
            }

            if ($paging_data['PREV_DOTTED_LINK'] == 1) {
                ?>
                    <li>...</li>
                    <?php
                }
                if (isset($paging_data['PAGING_LINKS']) && !empty($paging_data['PAGING_LINKS'])) {
                    foreach ($paging_data['PAGING_LINKS'] as $page_number => $page_number_link_array) {
                        if (empty($page_number_link_array['link']) && empty($page_number_link_array['onclick'])) {
                            ?>
                        <li class="active"><a href="#"><?php echo $page_number; ?></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="<?php echo $page_number_link_array['link']; ?>" onclick="<?php echo $page_number_link_array['onclick']; ?>"><?php echo $page_number; ?></a></li> 
                        <?php
                    }
                }
            }

            if ($paging_data['NEXT_DOTTED_LINK'] == 1) {
                ?>
                        <li>...</li>
                            <?php
                }

                if (!$paging_data['LAST_PAGE_LINK']['link'] && $paging_data['LAST_PAGE_LINK']['label'] != "") {
                    ?>
                <li class="active"><a href="#"><?php echo $paging_data['LAST_PAGE_LINK']['label']; ?></a></li>               
                <?php
            } else if ($paging_data['LAST_PAGE_LINK']['link']) {
                ?>
                <li><a href="<?php echo $paging_data['LAST_PAGE_LINK']['link']; ?>" onclick="<?php echo $paging_data['LAST_PAGE_LINK']['onclick']; ?>"><?php echo $paging_data['LAST_PAGE_LINK']['label']; ?></a></li>
                <?php
            }

            if ($paging_data['NEXT_PAGE_URL']) {
                ?>
                <li><a href="<?php echo $paging_data['NEXT_PAGE_URL'] ?>" onclick="<?php echo $paging_data['NEXT_PAGE_ONCLICK'] ?>" title="Next"><i class="fa fa-angle-right"></i></a></li>
                <?php
            }
            ?>
        </ul>

        <div class="">

            <div class="dataTables_length pull-right">              		
                <select style="display: none;" class="chosen-select" aria-controls="table1" size="1" name="table1_length" id="paging_per_page_records_<?php if(isset($paging_data['PAGING_INDEX'])) { echo $paging_data['PAGING_INDEX']; } ?>">
                    <option value="5" <?php echo ($paging_data['PAGING_PER_PAGE_RESULTS'] == 5)?'selected="selected"':''; ?>>5</option>
                    <option value="10" <?php echo ($paging_data['PAGING_PER_PAGE_RESULTS'] == 10)?'selected="selected"':''; ?>>10</option>
                    <option value="15" <?php echo ($paging_data['PAGING_PER_PAGE_RESULTS'] == 15)?'selected="selected"':''; ?>>15</option>
                </select>                
            </div>


            <?php
            if (isset($paging_data['START'])) {
                ?>

                    <div id="table2_info" class="dataTables_info">
                    Showing <?php
                    if (isset($paging_data['START'])) {
                        echo $paging_data['START'];
                    }
                    ?> to <?php
                    if (isset($paging_data['END'])) {
                        echo $paging_data['END'];
                    }
                    ?> of <?php
                    if (isset($paging_data['END'])) {
                        echo $paging_data['TOTAL_RECORDS'];
                    }
                    ?> entries
                </div>
                <?php
            }
            ?>


        </div>
    <?php } ?>
</div>