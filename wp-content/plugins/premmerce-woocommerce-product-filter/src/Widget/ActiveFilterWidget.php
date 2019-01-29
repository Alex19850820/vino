<?php namespace Premmerce\Filter\Widget;

use Premmerce\Filter\Filter\Container;
use WP_Widget;

class ActiveFilterWidget extends WP_Widget
{
    /**
     * FilterWidget constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'premmerce_filter_active_filters_widget',
            __('Premmerce active filters', 'premmerce-filter'),
            array(
                'description' => __('Product attributes active filters', 'premmerce-filter'),
            )
        );
        $this->widget_options['classname'] .= ' premmerce-active-filters-widget-wrapper';
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        if (apply_filters('premmerce_product_filter_active', false)) {
            global $wp;

            $url = $_SERVER['REQUEST_URI'];

            $items = Container::getInstance()->getItemsManager()->getActiveFilters();
            $items = apply_filters('premmerce_product_filter_active_items', $items);

            $settings = get_option('premmerce_filter_settings', array());


            $ratings = $this->getRatingFilters();


            if (count($items) || count($ratings)) {
                $ratingTitle = __('Rated %s out of 5', 'woocommerce');
                foreach ($ratings as $rating) {
                    $link_ratings = implode(',', array_diff($ratings, array($rating)));
                    $link         = $link_ratings ? add_query_arg(
                        'rating_filter',
                        $link_ratings
                    ) : remove_query_arg('rating_filter', $url);

                    $items['rating_filter_' . $rating] = array(
                        'title' => sprintf($ratingTitle, $rating),
                        'link'  => $link,
                    );
                }
            }

            do_action('premmerce_product_active_filters_render', array(
                'activeFilters'   => $items,
                'resetFilter'     => home_url($wp->request),
                'showResetFilter' => ! empty($settings['show_reset_filter']),
                'args'            => $args,
                'instance'        => $instance
            ));
        }
    }

    /**
     * @return array
     */
    private function getRatingFilters()
    {
        $ratings = isset($_GET['rating_filter']) ? array_filter(array_map(
            'absint',
            explode(',', $_GET['rating_filter'])
        )) : array();

        return $ratings;
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        $instance          = array();
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    /**
     * @param array $instance
     *
     * @return string|void
     */
    public function form($instance)
    {
        do_action('premmerce_product_filter_widget_form_render', array(
            'title'  => isset($instance['title']) ? $instance['title'] : '',
            'widget' => $this,
        ));
    }
}
