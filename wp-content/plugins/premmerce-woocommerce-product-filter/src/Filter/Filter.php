<?php

namespace Premmerce\Filter\Filter;

use  Premmerce\Filter\Ajax\Strategy\ProductArchiveStrategy ;
use  Premmerce\Filter\Ajax\Strategy\SaleszoneStrategy ;
use  Premmerce\Filter\Ajax\Strategy\WoocommerceStrategy ;
use  Premmerce\Filter\Permalinks\PermalinksManager ;
use  Premmerce\Filter\Seo\SeoListener ;
use  Premmerce\Filter\Widget\ActiveFilterWidget ;
use  Premmerce\Filter\Widget\FilterWidget ;
use  Premmerce\SDK\V2\FileManager\FileManager ;
use  WP_Term ;
class Filter
{
    public static  $taxonomies = array() ;
    /**
     * @var FileManager
     */
    private  $fileManager ;
    /**
     * @var Container
     */
    private  $container ;
    public function __construct( Container $container )
    {
        $this->container = $container;
        $this->fileManager = $this->container->getFileManager();
        add_action( 'init', array( $this, 'init' ) );
        add_filter( 'premmerce_filter_ajax_current_strategy', array( $this, 'getCurrentStrategy' ) );
        add_filter( 'premmerce_filter_ajax_theme_strategies', array( $this, 'getThemeStrategies' ) );
        add_filter( 'premmerce_filter_ajax_configurable_strategies', array( $this, 'getConfigurableStrategies' ) );
        add_filter( 'premmerce_filter_taxonomies', array( $this, 'getFilterTaxonomies' ) );
        add_action( 'widgets_init', array( $this, 'initWidgets' ) );
        $this->registerActions();
        $this->registerRenderActions();
    }
    
    /**
     * Init filter
     */
    public function init()
    {
        self::$taxonomies = apply_filters( 'premmerce_filter_taxonomies', array() );
        self::$taxonomies = array_unique( self::$taxonomies );
        
        if ( !is_admin() ) {
            /**
             * Init services
             */
            $this->container->getItemRenderer();
            $this->container->getItemsManager();
        }
    
    }
    
    /**
     * Register widgets
     */
    public function initWidgets()
    {
        register_widget( FilterWidget::class );
        register_widget( ActiveFilterWidget::class );
    }
    
    /**
     * Get filte taxonomies
     *
     * @param $tax
     *
     * @return array
     */
    public function getFilterTaxonomies( $tax )
    {
        $settings = $this->container->getOption( 'settings' );
        $taxonomies = ( isset( $settings['taxonomies'] ) ? $settings['taxonomies'] : array() );
        foreach ( $taxonomies as $taxonomy ) {
            if ( taxonomy_exists( $taxonomy ) ) {
                $tax[] = $taxonomy;
            }
        }
        return $tax;
    }
    
    /**
     * Ajax Strategies for specific themes
     *
     * @param $strategies
     *
     * @return mixed
     */
    public function getThemeStrategies( $strategies )
    {
        $strategies['saleszone'] = SaleszoneStrategy::class;
        $strategies['saleszone-premium'] = SaleszoneStrategy::class;
        return $strategies;
    }
    
    /**
     * Configured ajax strategies
     *
     * @param $strategies
     *
     * @return mixed
     */
    public function getConfigurableStrategies( $strategies )
    {
        $strategies['woocommerce_content'] = WoocommerceStrategy::class;
        $strategies['product_archive'] = ProductArchiveStrategy::class;
        return $strategies;
    }
    
    /**
     *  Cache clear and warm up actions
     */
    private function registerActions()
    {
        add_action( 'woocommerce_update_product', array( $this, 'clearCache' ) );
        add_action( 'woocommerce_update_product_variation', array( $this, 'clearCache' ) );
        add_action( 'update_option', function ( $option ) {
            if ( false !== strpos( $option, 'premmerce_filter' ) ) {
                $this->clearCache();
            }
        } );
        add_filter( 'premmerce_product_filter_active', array( $this, 'isProductFilterActive' ) );
        add_filter(
            'premmerce_product_filter_slider_include_fields',
            array( $this, 'filterSliderFormFields' ),
            10,
            2
        );
        add_filter(
            'premmerce_product_filter_form_action',
            array( $this, 'filterFormAction' ),
            10,
            2
        );
    }
    
    /**
     * Renders pages actions
     */
    private function registerRenderActions()
    {
        add_action( 'premmerce_product_filter_render', function ( $data ) {
            $this->fileManager->includeTemplate( 'frontend/filter.php', $data );
        } );
        add_action( 'premmerce_product_active_filters_render', function ( $data ) {
            $this->fileManager->includeTemplate( 'frontend/active_filters.php', $data );
        } );
        add_action( 'premmerce_product_filter_widget_form_render', function ( $data ) {
            $this->fileManager->includeTemplate( 'admin/filter-widget.php', $data );
        } );
    }
    
    /**
     * Clear cache
     */
    public function clearCache()
    {
        $this->container->getCache()->clear();
    }
    
    /**
     * Get specific theme strategy or configured strategy
     * @return mixed|string
     */
    public function getCurrentStrategy()
    {
        $settings = $this->container->getOption( 'settings' );
        $template = wp_get_theme()->get_template();
        $themeStrategies = apply_filters( 'premmerce_filter_ajax_theme_strategies', array() );
        
        if ( array_key_exists( $template, $themeStrategies ) ) {
            $strategy = $themeStrategies[$template];
        } else {
            $strategies = apply_filters( 'premmerce_filter_ajax_configurable_strategies', array() );
            
            if ( !empty($settings['ajax_strategy']) && array_key_exists( $settings['ajax_strategy'], $strategies ) ) {
                $strategy = $strategies[$settings['ajax_strategy']];
            } else {
                $strategy = WoocommerceStrategy::class;
            }
        
        }
        
        return $strategy;
    }
    
    /**
     * @param bool $value
     *
     * @return bool
     */
    public function isProductFilterActive( $value )
    {
        $settings = $this->container->getOption( 'settings' );
        
        if ( isset( $settings['product_cat'] ) && is_tax( 'product_cat' ) ) {
            return true;
        } elseif ( isset( $settings['search'] ) && is_search() ) {
            return true;
        } elseif ( isset( $settings['tag'] ) && is_product_tag() ) {
            return true;
        } elseif ( isset( $settings['shop'] ) && is_shop() && !is_search() ) {
            return true;
        } elseif ( isset( $settings['product_brand'] ) && is_tax( 'product_brand' ) ) {
            return true;
        } elseif ( isset( $settings['attribute'] ) ) {
            $queriedObject = get_queried_object();
            if ( $queriedObject instanceof WP_Term && taxonomy_is_product_attribute( $queriedObject->taxonomy ) ) {
                return true;
            }
        }
        
        return $value;
    }
    
    /**
     * @return string
     */
    public function filterFormAction()
    {
        $path = $_SERVER['REQUEST_URI'];
        $parts = explode( '?', $path );
        $path = $parts[0];
        $url = parse_url( home_url() );
        $schemeAndHost = $url['scheme'] . '://' . $url['host'];
        $formAction = preg_replace( '%\\/page/[0-9]+%', '', $schemeAndHost . $path );
        return $formAction;
    }
    
    /**
     * Filter slider hidden form inputs from get params
     *
     * @param $params
     * @param array $current
     *
     * @return array
     */
    public function filterSliderFormFields( $params, $current )
    {
        $permalinks = $this->container->getOption( 'permalinks' );
        $permalinksOn = !empty($permalinks['permalinks_on']);
        return array_filter( $params, function ( $param ) use( $current, $permalinksOn ) {
            
            if ( $permalinksOn ) {
                if ( strrpos( $param, 'filter_' ) === 0 ) {
                    return false;
                }
                if ( strrpos( $param, 'query_type_' ) === 0 ) {
                    return false;
                }
            }
            
            if ( in_array( $param, $current ) ) {
                return false;
            }
            return true;
        }, ARRAY_FILTER_USE_KEY );
    }

}