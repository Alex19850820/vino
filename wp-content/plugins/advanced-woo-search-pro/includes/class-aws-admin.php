<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


if ( ! class_exists( 'AWS_Admin' ) ) :

/**
 * Class for plugin admin panel
 */
class AWS_Admin {

    /*
     * Name of the plugin settings page
     */
    var $page_name = 'aws-options';

    /**
     * @var AWS_Admin The single instance of the class
     */
    protected static $_instance = null;

    /**
     * Main AWS_Admin Instance
     *
     * Ensures only one instance of AWS_Admin is loaded or can be loaded.
     *
     * @static
     * @return AWS_Admin - Main instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /*
    * Constructor
    */
    public function __construct() {
        add_action( 'admin_menu', array( &$this, 'add_admin_page' ) );
        add_action( 'admin_init', array( &$this, 'register_settings' ) );

        if ( ! get_option( 'aws_pro_settings' ) ) {
            $this->initialize_settings();
        }

        if ( ! get_option( 'aws_instances' ) ) {
            add_option( 'aws_instances', '1' );
        }

        add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );

    }

    /*
     * Add options page
     */
    public function add_admin_page() {
        add_menu_page( __( 'Adv. Woo Search', 'aws' ), __( 'Adv. Woo Search', 'aws' ), 'manage_options', 'aws-options', array( &$this, 'display_admin_page' ), 'dashicons-search' );
    }

    /**
     * Generate and display options page
     */
    public function display_admin_page() {

        $options = $this->options_array();

        $instance_id = isset( $_GET['aws_id'] ) ? $_GET['aws_id'] : 0;
        $filter_id   = isset( $_GET['filter'] ) ? $_GET['filter'] : 1;

        $settings = $this->get_settings();

        $tabs = array(
            'general' => __( 'General', 'aws' ),
            'form'   => __( 'Search Form', 'aws' ),
            'results'    => __( 'Search Results', 'aws' )
        );

        $current_tab = empty( $_GET['tab'] ) ? 'general' : sanitize_title( $_GET['tab'] );

        $tabs_html = '';

        foreach ( $tabs as $name => $label ) {
            $tabs_html .= '<a href="' . admin_url( 'admin.php?page=aws-options&tab=' . $name . '&aws_id=' . $instance_id ) . '" class="nav-tab ' . ( $current_tab == $name ? 'nav-tab-active' : '' ) . '">' . $label . '</a>';
        }

        $tabs_html = '<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">'.$tabs_html.'</h2>';



        echo '<div class="wrap">';

            echo '<h1></h1>';

            if ( ! $instance_id ) {

                if ( isset( $_POST["stopwords"] ) ) {
                    update_option( 'aws_pro_stopwords', $_POST["stopwords"] );
                }

                $this->display_instances_table();

                $this->update_table();

            } else {

                $instance_settings = $settings[$instance_id];
                $instance_name = $instance_settings['search_instance'];

                if ( empty( $instance_settings ) ) {
                    echo 'No such instance!';
                    return;
                }

                if ( isset( $_POST["Submit"] ) ) {

                    foreach ( $options[$current_tab] as $values ) {

                        if ( $values['type'] === 'heading' || $values['type'] === 'table' ) {
                            continue;
                        }

                        if ( $values['type'] === 'checkbox' ) {

                            $checkbox_array = array();

                            foreach ( $values['choices'] as $key => $value ) {
                                $new_value = isset( $_POST[ $values['id'] ][$key] ) ? '1' : '0';
                                $checkbox_array[$key] = $new_value;
                            }

                            if ( $current_tab === 'results' ) {
                                $instance_settings['filters'][$filter_id][$values['id']] = $checkbox_array;
                            } else {
                                $instance_settings[ $values['id'] ] = $checkbox_array;
                            }

                            continue;
                        }

                        $new_value = isset( $_POST[ $values['id'] ] ) ? $_POST[ $values['id'] ] : '';

                        if ( $current_tab === 'results' ) {
                            $instance_settings['filters'][$filter_id][$values['id']] = $new_value;
                            continue;
                        }

                        $instance_settings[ $values['id'] ] = $new_value;

                        if ( isset( $values['sub_option'] ) ) {
                            $new_value = isset( $_POST[ $values['sub_option']['id'] ] ) ? $_POST[ $values['sub_option']['id'] ] : '';
                            $instance_settings[ $values['sub_option']['id'] ] = $new_value;
                        }

                    }

                    $settings[$instance_id] = $instance_settings;

                    update_option( 'aws_pro_settings', $settings );

                    do_action( 'aws_settings_saved', $settings );
                    
                    do_action( 'aws_cache_clear' );

                }


                $plugin_options = get_option( 'aws_pro_settings' );
                $plugin_options = $plugin_options[$instance_id];


                echo '<a class="button aws-back" href="' . admin_url( 'admin.php?page=aws-options' ) . '" title="' . __( 'Back', 'aws' ) . '">' . __( 'Back', 'aws' ) . '</a>';

                echo '<h1 data-id="' . $instance_id . '" class="aws-instance-name">' . $instance_name . '</h1>';

                if ( $current_tab === 'results' && $filter_id ) {
                    $filters = $plugin_options['filters'];
                    echo '<h2 class="aws-instance-filter">"' . $filters[$filter_id]['filter_name'] . '" filter</h2>';
                }

                echo '<div class="aws-instance-shortcode">[aws_search_form id="' . $instance_id . '"]</div>';

                echo $tabs_html;

                echo '<form action="" name="aws_form" id="aws_form" method="post">';

                echo '<input type="hidden" name="aws_instance" value="' . $instance_id . '" />';


                switch ($current_tab) {
                    case('results'):
                        $this->filters_tabs( $plugin_options['filters'] );
                        new AWS_Admin_Fields( $options['results'], $plugin_options['filters'][$filter_id] );
                        break;
                    case('form'):
                        new AWS_Admin_Fields( $options['form'], $plugin_options );
                        break;
                    default:
                        new AWS_Admin_Fields( $options['general'], $plugin_options );
                }

                echo '</form>';

            }


        echo '</div>';

    }

    /*
     * Generate and display table of instances
     */
    private function display_instances_table() {

        $plugin_options = get_option( 'aws_pro_settings' );

        echo '<h1>Advanced Woo Search</h1>';

        echo '<table class="aws-table aws-form-instances widefat" cellspacing="0">';


        echo '<thead>';

        echo '<tr>';
        echo '<th class="aws-name">' . __( 'Form Name', 'aws' ) . '</th>';
        echo '<th class="aws-shortcode">' . __( 'Shortcode', 'aws' ) . '</th>';
        echo '<th class="aws-actions"></th>';
        echo '</tr>';

        echo '</thead>';


        echo '<tbody>';

        foreach ( $plugin_options as $instance => $instance_options ) {

            $instance_page = admin_url( 'admin.php?page=aws-options&aws_id=' . $instance );

            echo '<tr>';

            echo '<td class="aws-name">';
            echo '<a href="' . $instance_page . '">' . $instance_options['search_instance'] . '</a>';
            echo '</td>';

            echo '<td class="aws-shortcode">';
            echo '[aws_search_form id="' . $instance . '"]';
            echo '</td>';

            echo '<td class="aws-actions">';
            echo '<a class="button alignright tips delete" title="Delete" data-id="' . $instance . '" href="#">' . __( 'Delete', 'aws' ) . '</a>';
            echo '<a class="button alignright tips copy" title="Copy" data-id="' . $instance . '" href="#">' . __( 'Copy', 'aws' ) . '</a>';
            echo '<a class="button alignright tips edit" title="Edit" href="' . $instance_page . '">' . __( 'Edit', 'aws' ) . '</a>';
            echo '</td>';

            echo '</tr>';

        }

        echo '</tbody>';


        echo '</table>';


        echo '<div class="aws-insert-instance">';
        echo '<button class="button aws-insert-instance">' . __( 'Add New Form', 'aws' ) . '</button>';
        echo '</div>';

    }

    /*
     * Reindex table
     */
    private function update_table() {

        echo '<table class="form-table">';

        echo '<tbody>';


        echo '<tr>';

        echo '<th>Reindex table</th>';
            echo '<td>';

                echo '<div id="aws-reindex"><input class="button" type="button" value="' . __( 'Reindex table', 'aws' ) . '"><span class="loader"></span><span class="reindex-progress">0%</span></div><br><br>';
                echo '<span class="description">' .
                    sprintf( __( 'This action only need for %s one time %s - after you activate this plugin. After this all products changes will be re-indexed automatically.', 'aws' ), '<strong>', '</strong>' ) . '<br>' .
                    __( 'Update all data in plugins index table. Index table - table with products data where plugin is searching all typed terms.<br>Use this button if you think that plugin not shows last actual data in its search results.<br><strong>CAUTION:</strong> this can take large amount of time.', 'aws' ) . '<br><br>' .
                    __( 'Products in index:', 'aws' ) . '<span id="aws-reindex-count"> <strong>' . AWS_Helpers::get_indexed_products_count() . '</strong></span>';
                echo '</span>';

            echo '</td>';

        echo '</tr>';


        echo '<tr>';

        echo '<th>Clear cache</th>';
            echo '<td>';
                echo '<div id="aws-clear-cache"><input class="button" type="button" value="' . __( 'Clear cache', 'aws' ) . '"><span class="loader"></span></div><br>';
                echo '<span class="description">' . __( 'Clear cache for all search results.', 'aws' ) . '</span>';
            echo '</td>';

        echo '</tr>';


        echo '<tr>';

            echo '<form action="" name="aws_form" id="aws_form" method="post">';

                echo '<th>' . __( 'Stop words list' ) . '</th>';

                echo '<td>';
                    $stopwords = get_option( 'aws_pro_stopwords' ) ? get_option( 'aws_pro_stopwords' ) : '';
                    echo '<textarea id="stopwords" name="stopwords" cols="75" rows="3">' . $stopwords . '</textarea>';
                    echo '<br><span class="description">' . __( 'Comma separated list of words that will be excluded from search.', 'aws' ) . '<br>' . __( 'Re-index required on change.', 'aws' ) . '</span>';
                    echo '<p class="submit"><input name="Submit" type="submit" class="button-primary" value="' . __( 'Save Changes', 'aws' ) . '" /></p>';
                echo '</td>';

            echo '</form>';

        echo '</tr>';


        echo '</tbody>';

        echo '</table>';

    }

    /*
     * Generate filters tabs html
     */
    private function filters_tabs( $filters ) {

        if ( isset( $_GET['section'] ) ) {
            return;
        }

        $instance_id       = isset( $_GET['aws_id'] ) ? $_GET['aws_id'] : 0;
        $current_filter_id = isset( $_GET['filter'] ) ? $_GET['filter'] : 1;

        echo '<table class="aws-table aws-form-filters widefat" cellspacing="0">';

            echo '<thead>';

                echo '<tr>';
                    echo '<th class="aws-sort">&nbsp;</th>';
                    echo '<th class="aws-name">' . __( 'Filter Name', 'aws' ) . '</th>';
                    echo '<th class="aws-actions"></th>';
                echo '</tr>';

            echo '</thead>';

            echo '<tbody>';

            foreach ( $filters as $filter_id => $filter_opts ) {

                $instance_page = admin_url( 'admin.php?page=aws-options&tab=results&aws_id=' . $instance_id . '&filter=' . $filter_id );

                echo '<tr class="aws-filter-item ' . ( 1 == $filter_id ? 'disabled' : '' ) . '" data-instance="' . $instance_id . '" data-id="' . $filter_id . '">';

                    if ( $filter_id != 1 ) {
                        echo '<td class="aws-sort"></td>';
                        //echo '<input type="hidden" name="filter_order[]" value="' . $filter_id . '">';
                    } else {
                        echo '<td></td>';
                        //echo '<input type="hidden" name="filter_order[]" value="1">';
                    }

                    echo '<td class="aws-name">';
                        echo '<a href="' . $instance_page . '" class="' . ( $current_filter_id == $filter_id ? 'active' : '' ) . '">' . $filter_opts['filter_name'] . '</a>';
                    echo '</td>';

                    echo '<td class="aws-actions">';

                        if ( $filter_id != 1 ) {
                            echo '<a class="button alignright tips delete" title="Delete" data-instance="' . $instance_id . '" data-id="' . $filter_id . '" href="#">' . __('Delete', 'aws') . '</a>';
                        }

                        echo '<a class="button alignright tips copy" title="Copy" data-instance="' . $instance_id . '" data-id="' . $filter_id . '" href="#">' . __( 'Copy', 'aws' ) . '</a>';

                    echo '</td>';

                echo '</tr>';

            }

            echo '</tbody>';

        echo '</table>';

        echo '<div class="aws-insert-filter-box">';
            echo '<button class="button aws-insert-filter" data-instance="' . $instance_id . '">' . __( 'Add New Filter', 'aws' ) . '</button>';
        echo '</div>';

    }

    /*
	 * Options array that generate settings page
	 */
    public function options_array() {
        return AWS_Helpers::options_array();
    }

    /*
	 * Register plugin settings
	 */
    public function register_settings() {
        register_setting( 'aws_pro_settings', 'aws_pro_settings' );
    }

    /*
	 * Get plugin settings
	 */
    public function get_settings() {
        $plugin_options = get_option( 'aws_pro_settings' );
        return $plugin_options;
    }

    /**
     * Initialize settings to their default values
     */
    public function initialize_settings() {
        $options = $this->options_array();
        $default_settings = array();

        foreach ( $options as $section_name => $section ) {
            foreach ($section as $values) {

                if ( isset( $values['type'] ) && $values['type'] === 'heading' ) {
                    continue;
                }

                if ( isset( $values['type'] ) && ( $values['type'] === 'checkbox' || $values['type'] === 'table' ) ) {
                    foreach ( $values['choices'] as $key => $val ) {

                        if ( $section_name === 'results' ) {
                            $default_settings['filters']['1'][$values['id']][$key] = $values['value'][$key];
                        } else {
                            $default_settings[$values['id']][$key] = $values['value'][$key];
                        }

                    }
                    continue;
                }

                if ( $section_name === 'results' ) {
                    $default_settings['filters']['1'][$values['id']] = $values['value'];
                    continue;
                }

                $default_settings[$values['id']] = $values['value'];

                if (isset( $values['sub_option'])) {
                    $default_settings[$values['sub_option']['id']] = $values['sub_option']['value'];
                }

            }
        }

        update_option( 'aws_pro_settings', array( '1' => $default_settings ) );
    }

    /*
     * Enqueue admin scripts and styles
     */
    public function admin_enqueue_scripts() {

        if ( isset( $_GET['page'] ) && $_GET['page'] == 'aws-options' ) {

            $instance_id = isset( $_GET['aws_id'] ) ? $_GET['aws_id'] : 0;
            $filter_id   = isset( $_GET['filter'] ) ? $_GET['filter'] : 1;

            wp_enqueue_style( 'plugin-admin-style', AWS_PRO_URL . '/assets/css/admin.css' );
            wp_enqueue_style( 'aws-admin-chosen', AWS_PRO_URL . '/assets/chosen/chosen.min.css' );

            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_media();

            wp_enqueue_script( 'aws-admin-chosen', AWS_PRO_URL . '/assets/chosen/chosen.jquery.min.js', array('jquery') );
            wp_enqueue_script( 'aws-admin', AWS_PRO_URL . '/assets/js/admin.js', array('jquery') );

            wp_localize_script( 'aws-admin', 'aws_vars', array(
                'ajaxurl'  => admin_url('admin-ajax.php' ),
                'instance' => $instance_id,
                'filter'   => $filter_id
            ) );

        }

    }

}

endif;


add_action( 'init', 'AWS_Admin::instance' );