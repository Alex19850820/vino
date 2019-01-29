<?php namespace Premmerce\Filter\Filter;

use Premmerce\Filter\Cache\Cache;
use Premmerce\Filter\Filter\Items\ItemFactory;
use Premmerce\Filter\Filter\Items\ItemsManager;
use Premmerce\Filter\Filter\Query\PriceQuery;
use Premmerce\Filter\Filter\Query\ProductsQuery;
use Premmerce\Filter\Filter\Query\QueryHelper;
use Premmerce\Filter\FilterPlugin;
use Premmerce\SDK\V2\FileManager\FileManager;

class Container
{
    /**
     * @var Container
     */
    private static $instance;

    /**
     * @var array
     */
    private $services = array();

    /**
     * @var array
     */
    private $options = array();

    /**
     * @return Container
     */
    public static function getInstance()
    {
        return self::$instance ?: self::$instance = new self();
    }

    /**
     * Container constructor.
     */
    private function __construct()
    {
        $this->options['items']      = get_option(FilterPlugin::OPTION_ATTRIBUTES, array());
        $this->options['colors']     = get_option(FilterPlugin::OPTION_COLORS, array());
        $this->options['settings']   = get_option('premmerce_filter_settings', array());
        $this->options['permalinks'] = get_option('premmerce_filter_permalink_settings', array());
    }

    public function getFileManager()
    {
        if (! isset($this->services['file_manager'])) {
            $this->addService('file_manager', new FileManager($this->getService('file_manager')));
        }

        return $this->getService('file_manager');
    }

    /**
     * @return mixed
     */
    public function getItemRenderer()
    {
        if (! isset($this->services['renderer'])) {
            $this->addService('renderer', new ItemRenderer($this->getFileManager()));
        }

        return $this->getService('renderer');
    }

    /**
     * @return QueryHelper
     */
    public function getQueryHelper()
    {
        if (! isset($this->services['query_helper'])) {
            $this->addService('query_helper', new QueryHelper());
        }

        return $this->getService('query_helper');
    }

    /**
     * @return ProductsQuery
     */
    public function getProductQuery()
    {
        if (! isset($this->services['product_query'])) {
            $this->addService('product_query', new ProductsQuery($this->getCache(), $this->getQueryHelper()));
        }

        return $this->getService('product_query');
    }

    /**
     * @return PriceQuery
     */
    public function getPriceQuery()
    {
        if (! isset($this->services['price_query'])) {
            $this->addService('price_query', new PriceQuery($this->getCache(), $this->getQueryHelper()));
        }

        return $this->getService('price_query');
    }

    /**
     * @return Cache
     */
    public function getCache()
    {
        if (! isset($this->services['cache'])) {
            $this->addService('cache', new Cache());
        }

        return $this->getService('cache');
    }

    /**
     * @return ItemFactory
     */
    public function getItemFactory()
    {
        if (! isset($this->services['item_factory'])) {
            $this->addService('item_factory', new ItemFactory());
        }

        return $this->getService('item_factory');
    }

    /**
     * @return ItemsManager
     */
    public function getItemsManager()
    {
        if (! isset($this->services['items_manager'])) {
            $this->addService('items_manager', new ItemsManager($this));
        }

        return $this->getService('items_manager');
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getService($key)
    {
        if (isset($this->services[$key])) {
            return $this->services[$key];
        }
    }

    /**
     * @param string $key
     * @param mixed $service
     */
    public function addService($key, $service)
    {
        $this->services[$key] = $service;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getOption($key)
    {
        return $this->options[$key];
    }

    /**
     * @param string $key
     * @param mixed $option
     */
    public function addOption($key, $option)
    {
        $this->options[$key] = $option;
    }
}
