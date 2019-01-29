<?php

namespace Premmerce\Filter\Admin\Tabs;

use  Premmerce\Filter\Admin\Tabs\Base\SortableListTab ;
use  Premmerce\Filter\Filter\Filter ;
use  Premmerce\Filter\FilterPlugin ;
use  Premmerce\SDK\V2\FileManager\FileManager ;
class Attributes extends SortableListTab
{
    /**
     * @var FileManager
     */
    private  $fileManager ;
    /**
     * @var array
     */
    private  $defaultAttribute = array(
        'active'       => false,
        'type'         => 'checkbox',
        'display_type' => '',
    ) ;
    /**
     * Attributes constructor.
     *
     * @param FileManager $fileManager
     */
    public function __construct( FileManager $fileManager )
    {
        parent::__construct();
        $this->fileManager = $fileManager;
    }
    
    /**
     * Register action handlers
     */
    public function init()
    {
        add_action( 'wp_ajax_premmerce_filter_bulk_action_attributes', array( $this, 'bulkActionAttributes' ) );
        add_action( 'wp_ajax_premmerce_filter_sort_attributes', array( $this, 'sortAttributes' ) );
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'attributes';
    }
    
    /**
     * @return string
     */
    public function getLabel()
    {
        return __( 'Attributes', 'premmerce-filter' );
    }
    
    /**
     * @return bool
     */
    public function valid()
    {
        return function_exists( 'wc_get_attribute_taxonomies' );
    }
    
    /**
     * Ajax update attributes ordering
     */
    public function sortAttributes()
    {
        $this->sortHandler( FilterPlugin::OPTION_ATTRIBUTES, $this->getAttributesConfig() );
    }
    
    /**
     * Ajax bulk update attributes
     */
    public function bulkActionAttributes()
    {
        $this->bulkActionsHandler( FilterPlugin::OPTION_ATTRIBUTES, $this->getAttributesConfig() );
    }
    
    public function render()
    {
        $attributesConfig = $this->getAttributesConfig();
        $attributes = array_replace( $attributesConfig, $this->getAttributes() );
        $visibility = array(
            "display" => __( 'Display', 'premmerce-filter' ),
            "hide"    => __( 'Hide', 'premmerce-filter' ),
        );
        $types = array(
            'checkbox' => __( 'Checkbox', 'premmerce-filter' ),
            'radio'    => __( 'Radio', 'premmerce-filter' ),
            'select'   => __( 'Select', 'premmerce-filter' ),
        );
        $types = apply_filters( 'premmerce_filter_item_types', $types );
        $display = array(
            'display_'                => __( 'Default', 'premmerce-filter' ),
            'display_dropdown'        => __( 'Dropdown', 'premmerce-filter' ),
            'display_scroll'          => __( 'Scroll', 'premmerce-filter' ),
            'display_scroll_dropdown' => __( 'Scroll + Dropdown', 'premmerce-filter' ),
        );
        $actions = array(
            "-1"                                   => __( 'Bulk Actions', 'premmerce-filter' ),
            __( 'Visibility', 'premmerce-filter' ) => $visibility,
            __( 'Field type', 'premmerce-filter' ) => $types,
            __( 'Display as', 'premmerce-filter' ) => $display,
        );
        $dataAction = 'premmerce_filter_bulk_action_attributes';
        $this->fileManager->includeTemplate( 'admin/tabs/attributes.php', compact(
            'attributes',
            'attributesConfig',
            'types',
            'actions',
            'dataAction',
            'display'
        ) );
    }
    
    /**
     * @param $id
     *
     * @return mixed
     */
    private function getTaxonomyById( $id )
    {
        if ( $attribute = wc_get_attribute( $id ) ) {
            return $attribute->slug;
        }
        return $id;
    }
    
    /**
     * Get attributes configuration
     *
     * @return mixed
     */
    private function getAttributesConfig()
    {
        return $this->getConfig( FilterPlugin::OPTION_ATTRIBUTES, $this->getAttributes(), $this->defaultAttribute );
    }
    
    /**
     * Woocommerce attributes id=>title array and custom taxonomies if exist
     *
     * @return array
     */
    private function getAttributes()
    {
        $wcAttributes = wc_get_attribute_taxonomies();
        $attributes = array();
        foreach ( $wcAttributes as $attribute ) {
            $attributes[$attribute->attribute_id] = $attribute->attribute_label;
        }
        foreach ( Filter::$taxonomies as $taxonomy ) {
            
            if ( taxonomy_exists( $taxonomy ) ) {
                $taxonomy = get_taxonomy( $taxonomy );
                $attributes[$taxonomy->name] = $taxonomy->labels->menu_name;
            }
        
        }
        return $attributes;
    }

}