<?php

/**
 * Description of shoppingcart_most_viewed_products :  display most viewed products
 *
 * @author Hitesh Dodiya <dipak.patel@sparsh.com>

 */
class shoppingcart_most_viewed_products extends widgets
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shoppingcart/shoppingcart_model');
    }

    function run($options = array())
    {
        $language_id = !empty($options) ? intval($options['language_id']) : 0;

        $product_data = $this->shoppingcart_model->get_most_viewed_products($language_id);

        $data['product_data'] = $product_data;

        return $this->build('index', $data);
    }

}