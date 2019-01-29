<?php namespace Premmerce\Filter\Filter\Items\Types;

use Premmerce\Filter\Filter\Query\PriceQuery;

class PriceFilter extends BaseFilter
{
    /**
     * @var string
     */
    protected $slug = 'price';

    /**
     * @var array
     */
    protected $options = array('min' => 0, 'max' => 0);

    /**
     * @var PriceQuery
     */
    private $priceQuery;

    /**
     * PriceFilter constructor.
     *
     * @param PriceQuery $priceQuery
     */
    public function __construct($priceQuery)
    {
        $this->priceQuery = $priceQuery;
    }

    /**
     * Unique item identifier
     *
     * @return string
     */
    public function getId()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return __('Filter by price', 'premmerce-filter');
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * checkbox|radio|select|label|color
     * @return string
     */
    public function getType()
    {
        return 'slider';
    }

    /**
     * @return array
     */
    public function getActiveItems()
    {
        $url = $_SERVER['REQUEST_URI'];

        $values = $this->getSelectedValues();

        $activeFilters = array();

        if (key_exists('min_selected', $values)) {
            $link            = remove_query_arg('min_' . $this->getSlug(), $url);
            $title           = sprintf(__('Min %s', 'woocommerce'), wc_price($values['min_selected']));
            $activeFilters[] = array('title' => $title, 'link' => esc_url($link), 'id' => $this->getId());
        }

        if (key_exists('max_selected', $values)) {
            $link            = remove_query_arg('max_' . $this->getSlug(), $url);
            $title           = sprintf(__('Max %s', 'woocommerce'), wc_price($values['max_selected']));
            $activeFilters[] = array('title' => $title, 'link' => esc_url($link), 'id' => $this->getId());
        }

        return $activeFilters;
    }

    public function getSelectedValues()
    {
        return $this->priceQuery->getSelectedValues();
    }

    public function init()
    {
        $this->options = $this->priceQuery->getPrices();
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return boolean
     */
    public function isVisible()
    {
        $options = $this->getOptions();

        return $options['min'] !== $options['max'];
    }
}
