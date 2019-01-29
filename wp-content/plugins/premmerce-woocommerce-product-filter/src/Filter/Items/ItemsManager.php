<?php namespace Premmerce\Filter\Filter\Items;

use Premmerce\Filter\Filter\Container;
use Premmerce\Filter\Filter\Items\Types\FilterInterface;
use Premmerce\Filter\Filter\Items\Types\PriceFilter;
use Premmerce\Filter\Filter\Items\Types\TaxonomyFilter;

class ItemsManager
{
    /**
     * @var FilterInterface[]
     */
    private $items = array();

    /**
     * @var null|array
     */
    private $activeFilters;

    /**
     * @var bool
     */
    private $prepared = false;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var bool
     */
    private $load = true;

    /**
     * ItemsManager constructor.
     *
     * @param Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;

        $settings = $this->container->getOption('settings');

        $this->load = empty($settings['load_deferred']) || ! empty($_REQUEST['premmerce_filter_ajax_action']);

        $this->loadItems();

        add_filter('woocommerce_is_filtered', array($this, 'isFiltered'));

        add_filter('posts_search', array($this, 'onPostsSearch'), 100, 2);
    }

    /**
     * @param $searchQuery
     * @param $wpQuery
     *
     * @return mixed
     */
    public function onPostsSearch($searchQuery, $wpQuery)
    {
        if ($wpQuery->is_search) {
            $this->container->getQueryHelper()->setSearchQuery($searchQuery);
        }

        return $searchQuery;
    }

    /**
     * @param $filtered
     *
     * @return bool
     */
    public function isFiltered($filtered)
    {
        foreach ($this->getItems() as $item) {
            if ($item->isActive()) {
                return true;
            }
        }

        return $filtered;
    }

    /**
     * Get active items for 'Active filters widget'
     *
     * @return array
     */
    public function getActiveFilters()
    {
        if (! $this->load) {
            return array();
        }

        if (is_null($this->activeFilters)) {
            $this->activeFilters = array();

            foreach ($this->getItems() as $item) {
                $this->activeFilters = array_merge($this->activeFilters, $item->getActiveItems());
            }
        }

        return $this->activeFilters;
    }

    /**
     * Get filter items for 'Filter widget'
     *
     * @return array
     */
    public function getFilters()
    {
        if (! $this->load) {
            return array();
        }

        $filters = array();

        foreach ($this->getItems() as $item) {
            if ($item->isVisible()) {
                $filters[] = $item;
            }
        }

        return $filters;
    }

    /**
     * @param object $term
     * @param array $queriedProducts - products by main query
     *
     * @param array $queriedTaxonomyProducts - products by selected taxonomy terms
     *
     * @return int
     *
     */
    private function getTermCount($term, $queriedProducts, $queriedTaxonomyProducts)
    {
        if (empty($term->products) || empty($queriedProducts)) {
            return 0;
        }

        $products = array_intersect_key($term->products, $queriedProducts);

        if (empty($products)) {
            return 0;
        }

        if (empty($queriedTaxonomyProducts)) {
            return count($products);
        }

        foreach ($queriedTaxonomyProducts as $taxonomy => $taxonomyProducts) {
            if ($taxonomy !== $term->taxonomy) {
                $products = array_intersect_key($products, $taxonomyProducts);
            }
        }

        return count($products);
    }

    /**
     * Init filter items
     */
    private function loadItems()
    {
        $factory = $this->container->getItemFactory();

        $options = $this->container->getOption('items');

        $settings = $this->container->getOption('settings');

        $hideEmpty = ! empty($settings['hide_empty']);

        $items = array();
        foreach ($options as $key => $option) {
            if ($option['active']) {
                $option['hide_empty'] = $hideEmpty;
                $items[]              = $factory->createItem($key, $option);
            }
        }

        if (! empty($settings['show_price_filter'])) {
            array_unshift($items, new PriceFilter($this->container->getPriceQuery()));
        }

        $items = apply_filters('premmerce_filters_register_items', $items);

        foreach ($items as $item) {
            if ($item instanceof FilterInterface) {
                $this->items[$item->getId()] = $item;
            }
        }
    }

    /**
     * @return FilterInterface[]
     */
    public function getItems()
    {
        if (! $this->prepared) {
            $this->prepared = true;

            if ($this->load) {
                $this->calculate();
            }
        }

        return $this->items;
    }

    /**
     * Prepare filter items
     */
    private function calculate()
    {
        $taxonomyItems = array();

        foreach ($this->items as $item) {
            $item->init();

            if ($item instanceof TaxonomyFilter) {
                $taxonomyItems[$item->getId()] = $item;
            }
        }

        $termTaxonomyIds = array();

        $productQuery = $this->container->getProductQuery();

        foreach ($taxonomyItems as $item) {
            foreach ($item->getTerms() as $term) {
                $termTaxonomyIds[] = $term->term_taxonomy_id;
            }
        }

        $allProducts  = $productQuery->getProductIdsByMainQuery(array_keys($taxonomyItems));
        $termProducts = $productQuery->getTermTaxonomyProductIds($termTaxonomyIds);


        foreach ($taxonomyItems as $item) {
            foreach ($item->getTerms() as $term) {
                if (isset($termProducts[$term->term_taxonomy_id])) {
                    $term->products = $termProducts[$term->term_taxonomy_id];
                }
            }
        }

        $taxonomyProducts = array();

        foreach ($taxonomyItems as $item) {
            if ($item->isActive()) {
                $taxonomyProducts[$item->getId()] = $item->getActiveProducts();
            }
        }

        foreach ($taxonomyItems as $itemKey => $item) {
            foreach ($item->getTerms() as $termKey => $term) {
                $term->count = $this->getTermCount($term, $allProducts, $taxonomyProducts);
            }
        }
    }
}
