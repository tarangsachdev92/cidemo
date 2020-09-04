<?php

$image_path = site_base_url() . 'assets/uploads/shoppingcart/';

$numbers = array(0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7);
$random_key = array_rand($numbers, 5);

echo '<b>' . lang('most_vieved_items') . '</b>';
echo '<div class="most-view-item">';

for ($i = 0; $i < 5; $i++)
{
    if(isset($product_data[$random_key[$i]]))
    {
        $category_image = 'category_bullet.gif';
        echo '<div class="most-view-item-div"><div  class="fproduct-img" style="margin:0px 5px;"><a href="' . site_url() . 'shoppingcart/products/' . $product_data[$random_key[$i]]['scp']['slug_url'] . '">';

        if ($product_data[$random_key[$i]]['scp']['product_image'] != '')
        {
            if (file_exists(FCPATH . 'assets/uploads/shoppingcart/medium/' . $product_data[$random_key[$i]]['scp']['product_image']))
            {
                $category_image = $product_data[$random_key[$i]]['scp']['product_image'];
            }
        }

        echo '<img width="150px"   height="130px"  alt="' . $product_data[$random_key[$i]]['scp']['name'] . '" src="' . $image_path . 'medium/' . $category_image . '"></div>';
        echo '<h3>' . ucfirst($product_data[$random_key[$i]]['scp']['name']) . '</h3>';
        echo '</a></div>';
    }
}
echo '</div>';