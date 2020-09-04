<?php

/**
 * Description of shoppingcart_best_seller_products dropdown
 *
 * @author Hitesh Dodiya <dipak.patel@sparsh.com>

 */
class shoppingcart_best_seller_products extends widgets
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shoppingcart/shoppingcart_orders_model');
    }

    function run($options = array())
    {
        $language_id = !empty($options) ? $options['language_id'] : 0;

        $best_seller_items = $this->shoppingcart_orders_model->get_best_seller_items($language_id);

        $data['best_seller_items'] = $best_seller_items;
        return $this->build('index', $data);
    }

}