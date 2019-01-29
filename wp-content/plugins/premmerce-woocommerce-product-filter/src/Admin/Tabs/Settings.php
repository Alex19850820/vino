<?php

namespace Premmerce\Filter\Admin\Tabs;

use  Premmerce\Filter\Admin\Tabs\Base\BaseSettings ;
use  Premmerce\Filter\FilterPlugin ;
class Settings extends BaseSettings
{
    /**
     * @var string
     */
    protected  $page = 'premmerce-filter-admin-settings' ;
    /**
     * @var string
     */
    protected  $group = 'premmerce_filter' ;
    /**
     * @var string
     */
    protected  $optionName = 'premmerce_filter_settings' ;
    /**
     * Register hooks
     */
    public function init()
    {
        add_action( 'admin_init', array( $this, 'initSettings' ) );
    }
    
    /**
     * Init settings
     */
    public function initSettings()
    {
        register_setting( $this->group, $this->optionName );
        $taxonomies = FilterPlugin::DEFAULT_TAXONOMIES;
        $taxonomyOptions = array();
        foreach ( $taxonomies as $taxonomy ) {
            if ( !taxonomy_is_product_attribute( $taxonomy ) && taxonomy_exists( $taxonomy ) ) {
                $taxonomyOptions[$taxonomy] = get_taxonomy( $taxonomy )->labels->singular_name;
            }
        }
        $settings = array(
            'behavior'      => array(
            'label'  => __( 'Behavior', 'premmerce-filter' ),
            'fields' => array(
            'hide_empty'        => array(
            'type'  => 'checkbox',
            'label' => __( 'Hide empty terms', 'premmerce-filter' ),
        ),
            'show_price_filter' => array(
            'type'  => 'checkbox',
            'label' => __( 'Show price filter', 'premmerce-filter' ),
        ),
            'show_reset_filter' => array(
            'type'  => 'checkbox',
            'label' => sprintf( __( 'Show "%s" button', 'premmerce-filter' ), __( 'Reset filter', 'premmerce-filter' ) ),
        ),
        ),
        ),
            'show_on_pages' => array(
            'label'  => __( 'Show filter on pages', 'premmerce-filter' ),
            'fields' => array(
            'product_cat'   => array(
            'type'  => 'checkbox',
            'label' => __( 'Product category', 'premmerce-filter' ),
        ),
            'tag'           => array(
            'type'  => 'checkbox',
            'label' => __( 'Tag', 'premmerce-filter' ),
        ),
            'product_brand' => array(
            'type'  => 'checkbox',
            'label' => __( 'Brand', 'premmerce-filter' ),
        ),
            'search'        => array(
            'type'  => 'checkbox',
            'label' => __( 'Search', 'premmerce-filter' ),
        ),
            'shop'          => array(
            'type'  => 'checkbox',
            'label' => __( 'Store', 'premmerce-filter' ),
        ),
            'attribute'     => array(
            'type'  => 'checkbox',
            'label' => __( 'Attribute', 'premmerce-filter' ),
        ),
        ),
        ),
            'taxonomies'    => array(
            'label'  => __( 'Taxonomies', 'premmerce-filter' ),
            'fields' => array(
            'taxonomies' => array(
            'title'    => __( 'Use taxonomies', 'premmerce-filter' ),
            'type'     => 'select',
            'options'  => $taxonomyOptions,
            'multiple' => true,
            'help'     => __( 'Choose taxonomies used by filter.', 'premmerce-filter' ),
        ),
        ),
        ),
            'ajax'          => array(
            'label'  => __( 'AJAX', 'premmerce-filter' ),
            'fields' => array(
            'load_deferred' => array(
            'type'  => 'checkbox',
            'label' => __( 'Load deferred', 'premmerce-filter' ),
        ),
        ),
        ),
            'styles'        => array(
            'label'  => __( 'Styles', 'premmerce-filter' ),
            'fields' => array(
            'style' => array(
            'title'   => __( 'Filter style', 'premmerce-filter' ),
            'type'    => 'select',
            'options' => array(
            'default'   => __( 'Default', 'premmerce-filter' ),
            'premmerce' => 'Premmerce',
        ),
        ),
        ),
        ),
        );
        $settings['ajax']['fields']['use_ajax'] = array(
            'type'  => 'checkbox',
            'label' => __( 'Use ajax', 'premmerce-filter' ),
        );
        $strategies = array(
            'woocommerce_content' => __( 'Woocommerce content', 'premmerce-filter' ),
            'product_archive'     => __( 'Product archive', 'premmerce-filter' ),
        );
        $currentStrategy = apply_filters( 'premmerce_filter_ajax_current_strategy', null );
        $configurableStrategies = apply_filters( 'premmerce_filter_ajax_configurable_strategies', array() );
        if ( in_array( $currentStrategy, $configurableStrategies ) ) {
            $settings['ajax']['fields']['ajax_strategy'] = array(
                'type'    => 'select',
                'title'   => __( 'Ajax Strategy', 'premmerce-filter' ),
                'help'    => __( 'Choose the strategy for replacing content during ajax product filtering.', 'premmerce-filter' ) . '<br>' . __( '<b>Woocommerce content</b> strategy - has better performance and supported most of woocommerce themes, where archive page has default woocommerce layout.', 'premmerce-filter' ) . '<br>' . __( '<b>Product archive</b> strategy - replaces all content placed in product archive template except footer and header.', 'premmerce-filter' ),
                'options' => $strategies,
            );
        }
        $this->registerSettings( $settings, $this->page, $this->optionName );
    }
    
    /**
     * @return string
     */
    public function getLabel()
    {
        return __( 'Settings', 'premmerce-filter' );
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'settings';
    }
    
    /**
     * @return bool
     */
    public function valid()
    {
        return true;
    }

}