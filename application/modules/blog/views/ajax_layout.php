
<?php

function limit_words($string, $word_limit) {
    $words = explode(" ", $string);
    return implode(" ", array_splice($words, 0, $word_limit));
}

echo form_open();
?>


<?php
if (!empty($blogpost)) {
    foreach ($blogpost as $blog) {
        ?>

        <div style="border: 1px solid #999999;">
            <table width="100%" style="margin: 0px;padding: 0px;">
                <tr style="margin-bottom: 15px;">
                    <td width="100%">
                        <h2 style=" font-size: 24px;margin-bottom: 8px;">
                            <a itemprop="url" title="<?php echo $blog['B']['title']; ?>" href="#" style="color: #2A72C2;text-decoration: none"><?php echo $blog['B']['title']; ?></a>
                        </h2>
                        <span class="blog-author">
                            by
                            <a itemprop="author" ><?php echo lang('admin') ?></a>
                        </span>
                        <span class="blog-category">
                            in
                            <a ><?php echo $blog['C']['title']; ?></a>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <span style="font-size: 12px;">
        <?php echo lang('posted_on') . " " ?> <?php echo $blog['B']['created']; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
        <?php
        if (isset($blog['B']['blog_image'])) {
            ?>
                    <tr>
                        <td><img src="<?php echo base_url() . $blog['B']['blog_image']; ?>" style="width:100%;height: 200px;padding:0 20 0 20px"/>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
            <?php
        }
        ?>

                <tr>
                    <td style="background-color: #FFFFFF;padding: 5px;font: 400 14px/1.55 'Open Sans','Lucida Grande',Arial,sans-serif;color: #777777">
                        <p>
        <?php echo limit_words($blog['B']['blog_text'], 50); ?>
                        </p>
                        <span class="" style="background: -moz-linear-gradient(center top , #FFFFFF 0%, #EEEEEE 100%) repeat scroll 0 0 transparent
                              ;border: 1px solid #CCCCCC;border-radius: 3px 3px 3px 3px;
                              display: inline-block;
                              font-size: 11px;
                              font-weight: bold;
                              line-height: 16px;
                              margin: 10px 0;
                              padding: 5px 10px;
                              ">
                            <a href="<?php echo base_url(); ?>blog/blog_detail/<?php echo $blog['B']['slug_url']; ?>" style="text-decoration: none ;color: #555555;">
                                <span><?php echo lang('continue_reading') ?></span>
                            </a>
                        </span>
                    </td>
                </tr>
            </table>
        </div><br />
        <?php
    }
} else {
    ?>
    <table>
        <tr>
            <td><?php echo lang('no-records') ?></td>
        </tr>
    </table>
    <?php
}
?>		   
<td width="10">&nbsp;</td>
<?php
echo form_hidden('page_number', "", "page_number");
echo form_hidden('per_page_result', "", "per_page_result");
echo form_close();
?>
<?php
$querystr = $this->_ci->security->get_csrf_token_name() . '=' . urlencode($this->_ci->security->get_csrf_hash()) . '&search_term=' . $search_term . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '&category=' . $category . '';
$options = array(
    'total_records' => $total_records,
    'page_number' => $page_number,
    'isAjaxRequest' => 1,
    'base_url' => base_url() . "blog/ajax_layout/",
    'params' => $querystr,
    'element' => 'ajax_table'
);

widget('custom_pagination', $options);
?>
                  