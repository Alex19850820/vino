<?php

namespace Premmerce\Filter\Admin;

use  Premmerce\Filter\Admin\Tabs\Attributes ;
use  Premmerce\Filter\Admin\Tabs\Cache ;
use  Premmerce\Filter\Admin\Tabs\PermalinkSettings ;
use  Premmerce\Filter\Admin\Tabs\SeoRules ;
use  Premmerce\Filter\Admin\Tabs\SeoSettings ;
use  Premmerce\Filter\Admin\Tabs\Settings ;
use  Premmerce\Filter\Admin\Tabs\SimpleTab ;
use  Premmerce\Filter\Admin\Tabs\TabRenderer ;
use  Premmerce\Filter\Admin\Tabs\Taxonomy ;
use  Premmerce\SDK\V2\FileManager\FileManager ;
use  Premmerce\SDK\V2\Notifications\AdminNotifier ;
/**
 * Class Admin
 *
 * @package Premmerce\Filter\Admin
 */
class Admin
{
    /**
     * @var FileManager
     */
    private  $fileManager ;
    /**
     * @var string
     */
    private  $settingsPage ;
    /**
     * @var TabRenderer
     */
    private  $tabRenderer ;
    /**
     * @var AdminNotifier
     */
    private  $notifier ;
    /**
     * Admin constructor.
     *
     * Register menu items and handlers
     *
     * @param FileManager $fileManager
     */
    public function __construct( FileManager $fileManager )
    {
        $this->fileManager = $fileManager;
        $this->notifier = new AdminNotifier();
        $this->tabRenderer = new TabRenderer( $this->fileManager );
        add_action( 'init', function () {
            $this->initTabs();
            $this->checkPermalinks();
        } );
        $this->settingsPage = 'premmerce-filter-admin';
        add_action( 'admin_enqueue_scripts', array( $this, 'registerAssets' ), 11 );
        add_action( 'admin_menu', array( $this, 'addMenuPage' ) );
    }
    
    /**
     * Options page
     */
    public function options()
    {
        $this->fileManager->includeTemplate( 'admin/macros.php' );
        $this->tabRenderer->render();
    }
    
    /**
     * Check permalinks for seo tab
     */
    private function checkPermalinks()
    {
        $current = $this->tabRenderer->current();
        
        if ( in_array( $current, array( 'seo', 'seo_settings' ) ) ) {
            $permalinkOptions = get_option( 'premmerce_filter_permalink_settings' );
            $permalinksOff = empty($permalinkOptions['permalinks_on']);
            if ( $permalinksOff ) {
                $this->notifier->push( __( 'Please enable permalinks to use SEO rules', 'premmerce-filter' ), AdminNotifier::WARNING );
            }
        }
    
    }
    
    /**
     * Add submenu to premmerce menu page
     */
    public function addMenuPage()
    {
        global  $admin_page_hooks ;
        $premmerceMenuExists = isset( $admin_page_hooks['premmerce'] );
        
        if ( !$premmerceMenuExists ) {
            $svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="20" height="16" style="fill:#82878c" viewBox="0 0 20 16"><g id="Rectangle_7"> <path d="M17.8,4l-0.5,1C15.8,7.3,14.4,8,14,8c0,0,0,0,0,0H8h0V4.3C8,4.1,8.1,4,8.3,4H17.8 M4,0H1C0.4,0,0,0.4,0,1c0,0.6,0.4,1,1,1 h1.7C2.9,2,3,2.1,3,2.3V12c0,0.6,0.4,1,1,1c0.6,0,1-0.4,1-1V1C5,0.4,4.6,0,4,0L4,0z M18,2H7.3C6.6,2,6,2.6,6,3.3V12 c0,0.6,0.4,1,1,1c0.6,0,1-0.4,1-1v-1.7C8,10.1,8.1,10,8.3,10H14c1.1,0,3.2-1.1,5-4l0.7-1.4C20,4,20,3.2,19.5,2.6 C19.1,2.2,18.6,2,18,2L18,2z M14,11h-4c-0.6,0-1,0.4-1,1c0,0.6,0.4,1,1,1h4c0.6,0,1-0.4,1-1C15,11.4,14.6,11,14,11L14,11z M14,14 c-0.6,0-1,0.4-1,1c0,0.6,0.4,1,1,1c0.6,0,1-0.4,1-1C15,14.4,14.6,14,14,14L14,14z M4,14c-0.6,0-1,0.4-1,1c0,0.6,0.4,1,1,1 c0.6,0,1-0.4,1-1C5,14.4,4.6,14,4,14L4,14z"/></g></svg>';
            $svg = 'data:image/svg+xml;base64,' . base64_encode( $svg );
            add_menu_page(
                'Premmerce',
                'Premmerce',
                'manage_options',
                'premmerce',
                '',
                $svg
            );
        }
        
        add_submenu_page(
            'premmerce',
            __( 'Product filter', 'premmerce-filter' ),
            __( 'Product filter', 'premmerce-filter' ),
            'manage_options',
            $this->settingsPage,
            array( $this, 'options' )
        );
        
        if ( !$premmerceMenuExists ) {
            global  $submenu ;
            unset( $submenu['premmerce'][0] );
        }
    
    }
    
    /**
     * Register admin css and js
     *
     * @param $page
     */
    public function registerAssets( $page )
    {
        
        if ( $page == 'premmerce_page_premmerce-filter-admin' ) {
            wp_enqueue_script( 'wc-enhanced-select' );
            wp_enqueue_style( 'woocommerce_admin_styles' );
            wp_enqueue_style( 'premmerce_filter_admin_style', $this->fileManager->locateAsset( 'admin/css/style.css' ) );
            wp_enqueue_style( 'premmerce_filter_admin_style_seo', $this->fileManager->locateAsset( 'admin/css/seo.css' ) );
            wp_enqueue_script( 'premmerce_filter_admin_seo', $this->fileManager->locateAsset( 'admin/js/seo.js' ), array( 'select2', 'jquery-ui-dialog', 'jquery-ui-progressbar' ) );
            wp_enqueue_script( 'premmerce_filter_admin_script', $this->fileManager->locateAsset( 'admin/js/script.js' ), array( 'jquery-ui-sortable', 'jquery-ui-dialog', 'wp-color-picker' ) );
        }
    
    }
    
    /**
     * Register tabs and init tab renderer
     */
    private function initTabs()
    {
        $this->tabRenderer->register( new Attributes( $this->fileManager ) );
        foreach ( apply_filters( 'premmerce_filter_taxonomies', array() ) as $taxonomy_name ) {
            $this->tabRenderer->register( new Taxonomy( $this->fileManager, $taxonomy_name ) );
        }
        $this->tabRenderer->register( new Settings() );
        $this->tabRenderer->register( new Cache( $this->fileManager ) );
        $this->tabRenderer->register( new SimpleTab(
            'account',
            __( 'Account', 'premmerce-filter' ),
            function () {
            premmerce_pwpf_fs()->add_filter( 'hide_account_tabs', '__return_true' );
            premmerce_pwpf_fs()->_account_page_load();
            premmerce_pwpf_fs()->_account_page_render();
        },
            function () {
            return premmerce_pwpf_fs()->is_registered();
        }
        ) );
        $this->tabRenderer->register( new SimpleTab( 'contact', __( 'Contact Us', 'premmerce-filter' ), function () {
            premmerce_pwpf_fs()->_contact_page_render();
        } ) );
        $this->tabRenderer->init();
    }

}