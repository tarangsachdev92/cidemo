<?php  //pr($paging_data); ?>
<div class="paging clearfix">
    <div class="pagination">
        
        <?php
            if(!empty($paging_data))
            {
                    if($paging_data['PREVIOUS_PAGE_URL'])
                    {
                        ?>
                        <a href="<?php echo $paging_data['PREVIOUS_PAGE_URL']?>" onclick="<?php echo $paging_data['PREVIOUS_PAGE_ONCLICK']; ?>" title="Prev"><img src="images/prev.png" alt="Prev" /></a>
                        <?php

                    }

                    if(!$paging_data['FIRST_PAGE_LINK']['link'] && $paging_data['FIRST_PAGE_LINK']['label']!="")
                    {
                        ?>
                        <span class="current"><?php echo $paging_data['FIRST_PAGE_LINK']['label']; ?></span>    
                        <?php
                    }
                    else if($paging_data['FIRST_PAGE_LINK']['link'])
                    {
                        ?>
                        <a href="<?php echo $paging_data['FIRST_PAGE_LINK']['link'];?>" onclick="<?php echo $paging_data['FIRST_PAGE_LINK']['onclick']; ?>"><?php echo $paging_data['FIRST_PAGE_LINK']['label']; ?></a>
                        <?php
                    }

                    if($paging_data['PREV_DOTTED_LINK']==1)
                    {
                        ?>...<?php
                    }
                    if(isset($paging_data['PAGING_LINKS']) && !empty($paging_data['PAGING_LINKS']))    
                    {
                        foreach($paging_data['PAGING_LINKS'] as $page_number=>$page_number_link_array)
                        {
                            if(empty($page_number_link_array['link']) && empty($page_number_link_array['onclick']))
                            {
                                ?>
                                <span class="current"><?php echo $page_number; ?></span>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="<?php echo $page_number_link_array['link'];?>" onclick="<?php echo $page_number_link_array['onclick']; ?>"><?php echo $page_number; ?></a> 
                                <?php 
                            }
                        }
                        
                    }
                    
                    if($paging_data['NEXT_DOTTED_LINK']==1)
                    {
                        ?>...<?php
                    }

                    if(!$paging_data['LAST_PAGE_LINK']['link'] && $paging_data['LAST_PAGE_LINK']['label']!="")
                    {
                        ?>
                        <span class="current"><?php echo $paging_data['LAST_PAGE_LINK']['label']; ?></span>    
                        <?php
                    }
                    else if($paging_data['LAST_PAGE_LINK']['link'])
                    {
                        ?>
                        <a href="<?php echo $paging_data['LAST_PAGE_LINK']['link'];?>" onclick="<?php echo $paging_data['LAST_PAGE_LINK']['onclick']; ?>"><?php echo $paging_data['LAST_PAGE_LINK']['label']; ?></a>
                        <?php 
                    }

                    if($paging_data['NEXT_PAGE_URL'])
                    {
                        ?>
                        <a href="<?php echo $paging_data['NEXT_PAGE_URL']?>" onclick="<?php echo $paging_data['NEXT_PAGE_ONCLICK']?>" title="Prev"><img src="images/next.png" alt="Next" /></a>
                       <?php
                    }
            }
        
        ?>
    </div>

    <div class="pagination-info">
            <div class="page-size">
                Page Size:
                <select style="wi" id="paging_per_page_records_<?php if(isset($paging_data['PAGING_INDEX'])) { echo $paging_data['PAGING_INDEX']; } ?>">
                    <option value="5" <?php echo ($paging_data['PAGING_PER_PAGE_RESULTS'] == 5)?'selected="selected"':''; ?>>5</option>
                    <option value="10" <?php echo ($paging_data['PAGING_PER_PAGE_RESULTS'] == 10)?'selected="selected"':''; ?>>10</option>
                    <option value="15" <?php echo ($paging_data['PAGING_PER_PAGE_RESULTS'] == 15)?'selected="selected"':''; ?>>15</option>
                </select>
            </div>
     <?php 
         if(isset($paging_data['START']))
         {
             ?>
             <div class="items-info">Displaying items <?php if(isset($paging_data['START'])){ echo $paging_data['START']; } ?> to <?php if(isset($paging_data['END'])){ echo $paging_data['END']; } ?> of <?php if(isset($paging_data['END'])){ echo $paging_data['TOTAL_RECORDS']; } ?></div>
             <?php
             
         }        
     
     ?>
    </div>
</div>