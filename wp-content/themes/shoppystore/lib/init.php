<?php
/**
 * yatheme initial setup and constants
 */
function ya_setup() {
	// Make theme available for translation
	load_theme_textdomain('shoppystore', get_template_directory() . '/lang');

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus(array(
		'leftmenu' => esc_html__('Vertical Menu', 'shoppystore'),
		'primary_menu' => esc_html__('Primary Menu', 'shoppystore'),
		'mobile_menu1' => esc_html__( 'Mobile Menu 1', 'shoppystore' ),
		'mobile_menu2' => esc_html__( 'Mobile Menu 2', 'shoppystore' ),
		'mobile_menu_rtl' => esc_html__( 'Mobile Menu RTL', 'shoppystore' ),
	));
	
	add_theme_support( 'sw_theme' );
	add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( 'wc-product-gallery-lightbox' );
	if( ya_options()->getCpanelValue( 'product_zoom' ) ) :
		add_theme_support( 'wc-product-gallery-zoom' );
	endif;
	
	add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery]
	add_theme_support('jquery-cdn');            // Enable to load jQuery from the Google CDN
	
	add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( "title-tag" );

	// Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
	add_theme_support('post-thumbnails');
	// Add post formats (http://codex.wordpress.org/Post_Formats)
	add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
	
	new YA_Menu();
}
add_action('after_setup_theme', 'ya_setup');
//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );