<?php
	add_action('init', 'twi_woo_g_car'); 
    function twi_woo_g_car() { 
         $labels = array(
             'name'               => __('Grid/Carousel/Slider Shortcode Builder', 'Grid/Carousel Builder', 'twi_awesome_woo_slider_carousel'),
             'singular_name'      => __('Grid/Carousel/Slider Shortcode Builder', 'Grid/Carousel Builder Singular', 'twi_awesome_woo_slider_carousel'),
             'menu_name'          => __( 'TWI Grid-Carousel-Slider', 'twi_awesome_woo_slider_carousel' ),
             'all_items'          => __( 'All Shortcodes', 'twi_awesome_woo_slider_carousel' ),
             'add_new'            => __('Add Shortcode', 'Add New Grid/Carousel', 'twi_awesome_woo_slider_carousel'),
             'add_new_item'       => __('Add New Shortcode', 'twi_awesome_woo_slider_carousel'),
             'edit_item'          => __('Edit Shortcode', 'twi_awesome_woo_slider_carousel'),
             'new_item'           => __('New Shortcode', 'twi_awesome_woo_slider_carousel'),
             'view_item'          => __('View Shortcode', 'twi_awesome_woo_slider_carousel'),
             'search_items'       => __('Search Shortcode', 'twi_awesome_woo_slider_carousel'),
             'not_found'          => __('Nothing found', 'twi_awesome_woo_slider_carousel'),
             'not_found_in_trash' => __('Nothing found in Trash', 'twi_awesome_woo_slider_carousel'),
             'parent_item_colon'  => ''
         );

         $args = array(
             'labels'             => $labels,
             'public'             => true,
             'has_archive'        => false,
             'publicly_queryable' => true,
             'show_ui'            => true,
             'query_var'          => true,
             'rewrite'            => array("slug" => 'twi_woo_g_car_builder'),
             'capability_type'    => 'post',
             'menu_icon'          => 'dashicons-cart',
             'hierarchical'       => false,
             'supports'           => array('title')
         ); 

         register_post_type('twi_woo_g_car' , $args);       
         flush_rewrite_rules();
     }

?>