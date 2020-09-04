<?php

/**
 * Description of shoppingcart_categories widget for display all category in any page
 *
 * @author Hitesh Dodiya <dipak.patel@sparsh.com>

 */
class shoppingcart_categories extends widgets
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shoppingcart/shoppingcart_categories_model');
    }

    function run($options = array())
    {

        $category_list = '';
        $section_name = !empty($options) ? $options['section_name'] : '';
        $language_id = !empty($options) ? $options['language_id'] : '';

        $category_list = $this->get_n_categories(0, $language_id);

        $this->session->set_userdata(array('category_list' => $category_list));

        return $this->build('index');
    }

    /**
     * Displays a list of categories and sub categories data
     * @params string $parent : category id
     * @params string $language_id : language id
     */
    private function get_n_categories($parent = 0, $language_id)
    {
        $image_path = site_base_url() . 'assets/uploads/shoppingcart/categories/';
        $html = '';
        $this->shoppingcart_categories_model->_record_count_front = false;
        $categories = $this->shoppingcart_categories_model->getallcategories($language_id, $parent);

        if (count($categories) > 0)
        {
            $html .= '<ul class="home-category">';

            foreach ($categories as $category)
            {
                $current_id = $category['scc']['category_id'];
                $category_image = 'category_bullet.gif';
                $html .= '<li> <a href="' . site_url() . 'shoppingcart/categories/' . $category['scc']['slug_url'] . '">';

                if ($category['scc']['category_image'] != '')
                {
                    if (file_exists(FCPATH . 'assets/uploads/shoppingcart/categories/thumbs/' . $category['scc']['category_image']))
                    {
                        $category_image = $category['scc']['category_image'];
                    }
                }

                $html .= '<img width="16" height="16" alt="' . $category['scc']['title'] . '" src="' . $image_path . 'thumbs/' . $category_image . '">';
                $html .= ucfirst($category['scc']['title']) . ' (' . $this->shoppingcart_model->get_category_total_product($current_id, $language_id) . ')';

                if (count($this->shoppingcart_categories_model->getallcategories($language_id, $current_id)) > 0)
                {
                    $html .= $this->get_n_categories($current_id, $language_id);
                }

                $html .= '</a></li>';
            }

            $html .= '</ul>';
        }
        return $html;
    }

}