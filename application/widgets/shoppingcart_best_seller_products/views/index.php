<?php

$image_path = site_base_url() . 'assets/uploads/shoppingcart/';

$numbers = array(0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7);
$random_key = array_rand($numbers, 5);

echo '<div>';

for ($i = 0; $i < 5; $i++)
{
    if(isset($best_seller_items[$random_key[$i]]))
    {
        $product_image = 'category_bullet.gif';
        echo '<div class="best-seller-item-div"><div  class="fproduct-img" style="margin:0px 5px;"><a href="' . site_url() . 'shoppingcart/products/' . $best_seller_items[$random_key[$i]]['scp']['slug_url'] . '">';

        if ($best_seller_items[$random_key[$i]]['scp']['product_image'] != '')
        {
            if (file_exists(FCPATH . 'assets/uploads/shoppingcart/medium/' . $best_seller_items[$random_key[$i]]['scp']['product_image']))
            {
                $product_image = $best_seller_items[$random_key[$i]]['scp']['product_image'];
            }
        }
//           echo add_image($image_path . 'medium/' . $product_image,"","",array('alt' => "'".$best_seller_items[$random_key[$i]]['scp']['name']."'",'title' => "active"));
        echo '<img width="135px"   height="130px"  alt="' . $best_seller_items[$random_key[$i]]['scp']['name'] . '" src="' . $image_path . 'medium/' . $product_image . '"></div>';
        echo '<b>' . ucfirst($best_seller_items[$random_key[$i]]['scp']['name']) . '</b>';
        echo '</a></div>';
    }

}
echo '</div>';