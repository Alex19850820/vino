<?php namespace Premmerce\MetaFilter\Filter;

use Premmerce\Filter\Filter\Items\Types\BaseFilter;
use Premmerce\Filter\Filter\Query\QueryHelper;

class MetaValueFilter extends BaseFilter
{
    protected $prefix = 'meta_';

    protected $key = '_stock_status';

    private $items = array();

    /**
     * @var QueryHelper
     */
    private $queryHelper;

    public function __construct(QueryHelper $queryHelper)
    {
        add_filter('woocommerce_product_query_meta_query', array($this, 'extendMetaQuery'));
        $this->queryHelper = $queryHelper;
    }

    public function extendMetaQuery($metaQuery)
    {
        $values = $this->getSelectedValues();

        if (! empty($values)) {
            $metaQuery[$this->key] = array(
                'key'     => $this->key,
                'value'   => $values,
                'compare' => 'IN'

            );
        }

        return $metaQuery;
    }

    /**
     * Unique item identifier
     *
     * @return string
     */
    public function getId()
    {
        return '_stock';
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Stock';
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return 'stock';
    }

    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getActiveItems()
    {
        $items = $this->getItems();

        $active = array();
        foreach ($items as $item) {
            if ($item->checked) {
                $active[] = array('title' => $item->name, 'link' => $item->link,);
            }
        }

        return $active;
    }

    /**
     * @return array
     */
    public function getActiveProducts()
    {
        return array();
    }

    /**
     * @return boolean
     */
    public function isVisible()
    {
        return count($this->getItems());
    }

    /**
     * @return void
     */
    public function init()
    {
        $active = $this->getSelectedValues();

        $items = $this->loadItems();

        foreach ($items as $item) {
            $item->slug    = strtolower($item->slug);
            $item->checked = in_array($item->slug, $active);
            $item->link    = $this->getValueLink($item->slug);
        }


        $this->items = $items;
    }

    private function loadItems()
    {
        global $wpdb;

        $metaQuery = $this->queryHelper->getMetaQuerySql(array($this->key));
        $taxQuery  = $this->queryHelper->getTaxQuerySql();

        $sql[] = "SELECT count(stock_meta.post_id) as count, stock_meta.meta_id as term_id,stock_meta.meta_value as name, stock_meta.meta_value as slug";
        $sql[] = "FROM {$wpdb->posts}";
        $sql[] = "LEFT JOIN {$wpdb->postmeta} as stock_meta ON {$wpdb->posts}.ID = stock_meta.post_id AND stock_meta.meta_key = '{$this->key}'";
        $sql[] = $taxQuery['join'];
        $sql[] = $metaQuery['join'];
        $sql[] = $this->queryHelper->getPostWhereQuery();
        $sql[] = $taxQuery['where'];
        $sql[] = $metaQuery['where'];
        $sql[] = $this->queryHelper->getSearchQuery();
        $sql[] = 'GROUP BY stock_meta.meta_value';
        $sql   = implode(' ', $sql);

        return $wpdb->get_results($sql) ?: array();
    }
}
