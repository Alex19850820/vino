<?php
/**
 * Plugin Name: Wordpress Less
 * Plugin URI: http://smartaddons.com
 * Description: Compile css from admin
 * Version: 4.0.0
 * Author: smartaddons.com
 * Author URI: http://smartaddons.com
 *
*/

/**
 * Wordpress Less
*/

if($wp_config = @file_get_contents(ABSPATH."wp-config.php") ){
	if( !preg_match_all("/WP_MEMORY_LIMIT/", $wp_config, $output_array) ) {
		$wp_config = str_replace("\$table_prefix", "define('WP_MEMORY_LIMIT', '256M');\n\$table_prefix", $wp_config);
		@file_put_contents(ABSPATH."wp-config.php", $wp_config);
	}
}

function recurse_copy($src,$dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while(false !== ( $file = readdir($dir)) ) {
		if (( $file != '.' ) && ( $file != '..' )) {
			if ( is_dir($src . '/' . $file) ) {
				recurse_copy($src . '/' . $file,$dst . '/' . $file);
			}
			else {
				copy($src . '/' . $file,$dst . '/' . $file);
			}
		}
	}
	closedir($dir);
}

add_action( 'wp', 'ya_lessphp', 20 );
function ya_lessphp(){
	require_once ( plugin_dir_path( __FILE__ ).'/3rdparty/lessc.inc.php' ); 

	if ( class_exists('lessc') && function_exists( 'ya_options' ) ){
		
		$custom_color =  ya_options()->getCpanelValue('custom_color');
		$color 		 =  ya_options()->getCpanelValue('scheme_color');
		$bd_color 	 =  ya_options()->getCpanelValue('scheme_body');
		$bdr_color 	 =  ya_options()->getCpanelValue('scheme_border');
		$include_css =  ya_options()->getCpanelValue('include_css');
		
		$path = get_template_directory().'/css';
		if( $custom_color ){
			$sw_dirname = '';
			$upload_dir   = wp_upload_dir();		
			if ( ! empty( $upload_dir['basedir'] ) ) {
				$sw_dirname = $upload_dir['basedir'].'/sw_theme';
				if ( ! file_exists( $sw_dirname ) ) {
					wp_mkdir_p( $sw_dirname );
				}
				if ( ! file_exists( $sw_dirname . '/css' ) ) {
					wp_mkdir_p( $sw_dirname . '/css' );
				}
				if ( ! file_exists( $sw_dirname . '/assets/img' ) ) {
					wp_mkdir_p( $sw_dirname . '/assets/img' );
				}
				recurse_copy( get_template_directory(). '/assets/img', $sw_dirname . '/assets/img' );
			}
			if( ! empty( $upload_dir['baseurl'] ) ){
				define( 'CSS_URL', $upload_dir['baseurl'] . '/sw_theme/css' );
			}
			$path = $sw_dirname . '/css';
			add_action( 'wp_enqueue_scripts', 'sw_custom_color', 1000 );
		}
		if ( ya_options()->getCpanelValue('developer_mode') ){
			define('LESS_PATH', get_template_directory().'/assets/less');
			define('CSS__PATH', $path);
			
			$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
			$scheme = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : ya_options()->getCpanelValue('scheme');
			$page_metabox_hometemp = get_post_meta( get_the_ID(), 'page_home_template', true );

			$scheme_vars = get_template_directory().'/templates/presets/default.php';
			$output_cssf = CSS__PATH.'/app-default.css';
			if ( $scheme && file_exists(get_template_directory().'/templates/presets/'.$scheme.'.php') ){
				$scheme_vars = get_template_directory().'/templates/presets/'.$scheme.'.php';
				$output_cssf = CSS__PATH."/app-{$scheme}.css";
				$output_cssf_page = CSS__PATH."/{$page_metabox_hometemp}-{$scheme}.css";
				$output_cssf_index = CSS__PATH."/homepage-{$scheme}.css";
			}
			if ( file_exists($scheme_vars)){
				include $scheme_vars;
				if( $color != '' ){
					$less_variables['color'] = $color;
				}
				if(  $bd_color != '' ) {
					$less_variables['body-color'] = $bd_color;
				}
				if(  $bdr_color != '' ){
					$less_variables['border-color'] = $bdr_color;
				}
				
				try {
					
					$less = new lessc();
					
					
					$less->setImportDir( array(LESS_PATH.'/app/', LESS_PATH.'/bootstrap/') );
					
					$less->setVariables($less_variables);
					
					$cache = $less->cachedCompile(LESS_PATH.'/app.less');
					file_put_contents($output_cssf, $cache["compiled"]);				
					
					if( $include_css ) {
						$cache = $less->cachedCompile(LESS_PATH.'/index.less');
						file_put_contents( $output_cssf_index, $cache["compiled"] );
					}
					
					if( $page_metabox_hometemp !='' ) {
						$cache = $less->cachedCompile(LESS_PATH.'/'.$page_metabox_hometemp.'.less');
						file_put_contents($output_cssf_page, $cache["compiled"]);
					}
					
					/* RTL Language */
					$rtl_cache = $less->cachedCompile(LESS_PATH.'/app/rtl.less');
					file_put_contents(get_stylesheet_directory().'/css/rtl.css', $rtl_cache["compiled"]);
					
					$responsive_cache = $less->cachedCompile(LESS_PATH.'/app-responsive.less');
					file_put_contents(get_stylesheet_directory().'/css/app-responsive.css', $responsive_cache["compiled"]);
				} catch (Exception $e){
					var_dump($e); exit;
				}
			}
		}
	}
}

/*
** Custom color
*/
function sw_custom_color(){
	if( defined( 'CSS_URL' ) ){
		$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
		$scheme = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : ya_options()->getCpanelValue('scheme');		
		$include_css =  ya_options()->getCpanelValue('include_css');
		$page_metabox_hometemp = get_post_meta( get_the_ID(), 'page_home_template', true );
		
		$app_css 	  = CSS_URL . '/app-default.css';
		$app_css_page = CSS_URL . '/homepage-default.css';
		if ( $scheme ){
			$app_css = CSS_URL . '/app-'.$scheme.'.css';
			if( $page_metabox_hometemp && !$include_css ) {
				$app_css_page = CSS_URL . '/' . $page_metabox_hometemp.'-'.$scheme.'.css';
			}
			if( $include_css ){
				$app_css_page = CSS_URL . '/homepage-'.$scheme.'.css';
			}
		}
		if( $page_metabox_hometemp || $include_css ) {
		  wp_dequeue_style('ya_theme_page', $app_css_page, array(), null);
		}
		wp_dequeue_style( 'ya_css' );
		wp_enqueue_style('sw_css_custom', $app_css, array(), null);
		wp_enqueue_style('sw_css_custom_page', $app_css_page, array(), null);
	}
}
