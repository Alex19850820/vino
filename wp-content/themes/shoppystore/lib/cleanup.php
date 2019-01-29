<?php
/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag and change ''s to "'s on rel_canonical()
 */

function ya_rel_canonical() {
	global $wp_the_query;

	if (!is_singular()) {
    	return;
	}

	if (!$id = $wp_the_query->get_queried_object_id()) {
		return;
	}

	$link = get_permalink($id);
	echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}

/**
 * Clean up language_attributes() used in <html> tag
 *
 * Change lang="en-US" to lang="en"
 * Remove dir="ltr"
 */
function ya_language_attributes() {
	$attributes = array();
	$output = '';

	if ( function_exists('is_rtl') && is_rtl() ) {
		$attributes[] = 'dir="rtl"';
	}

	$lang = get_bloginfo('language');

	if ($lang && $lang !== 'en-US') {
		$attributes[] = "lang=\"$lang\"";
	} else {
		$attributes[] = 'lang="en"';
	}

	$output = implode(' ', $attributes);
	$output = apply_filters('ya_language_attributes', $output);

	return $output;
}
add_filter('language_attributes', 'ya_language_attributes');

/**
 * Clean up output of stylesheet <link> tags
 */
function ya_clean_style_tag($input) {
	preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
	// Only display media if it's print
	$media = $matches[3][0] === 'print' ? ' media="print"' : '';
	return '<link rel="stylesheet" href="' . esc_url( $matches[2][0] ) . '"' . $media . '>' . "\n";
}
add_filter('style_loader_tag', 'ya_clean_style_tag');

/**
 * Add and remove body_class() classes
 */
function ya_body_class($classes) {
	$page_metabox_hometemp = get_post_meta( get_the_ID(), 'page_home_template', true );
	$ya_direction 	= ya_options()->getCpanelValue('direction');
	$ya_box_layout 	= ya_options()->getCpanelValue('layout');
	if( $ya_direction == 'rtl' ){
		$classes[] = 'rtl';
	}
	if( ya_mobile_check()  ){
		$classes[] = 'mobile-layout';
	}
	if( $page_metabox_hometemp != '' ){
		$classes[] = 'page-template-' . $page_metabox_hometemp;
	}
	if( $ya_box_layout == 'boxed' ){
		$classes[] = 'box-layout';
	}
	// Add post/page slug
	if (is_single() || is_page() && !is_front_page()) {
		$classes[] = basename(get_permalink());
	}
	
	// Remove unnecessary classes
	$home_id_class = 'page-id-' . get_option('page_on_front');
	$remove_classes = array(
			'page-template-default',
			$home_id_class
	);
	$classes = array_diff($classes, $remove_classes);
	return $classes;
}
add_filter('body_class', 'ya_body_class');

/**
 * Root relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in config.php:
 * current_theme_supports('root-relative-urls');
 *
 * @author Scott Walkinshaw <scott.walkinshaw@gmail.com>
 */
function ya_root_relative_url($input) {
	$output = preg_replace_callback(
			'!(https?://[^/|"]+)([^"]+)?!',
			create_function(
					'$matches',
					// If full URL is home_url("/") and this isn't a subdir install, return a slash for relative root
					'if (isset($matches[0]) && $matches[0] === home_url("/") && str_replace("http://", "", home_url("/", "http"))==$_SERVER["HTTP_HOST"]) { return "/";' .
					// If domain is equal to home_url("/"), then make URL relative
					'} elseif (isset($matches[0]) && strpos($matches[0], home_url("/")) !== false) { return $matches[2];' .
					// If domain is not equal to home_url("/"), do not make external link relative
					'} else { return $matches[0]; };'
			),
			$input
	);

	return $output;
}

/**
 * Terrible workaround to remove the duplicate subfolder in the src of <script> and <link> tags
 * Example: /subfolder/subfolder/css/style.css
 */
function ya_fix_duplicate_subfolder_urls($input) {
	$output = ya_root_relative_url($input);
	preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);

	if (isset($matches[1][0]) && isset($matches[2][0])) {
		if ($matches[1][0] === $matches[2][0]) {
			$output = substr($output, strlen($matches[1][0]) + 1);
		}
	}

	return $output;
}

function ya_enable_root_relative_urls() {
	return !(is_admin() && in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) && current_theme_supports('root-relative-urls');
}

if (ya_enable_root_relative_urls()) {
	$root_rel_filters = array(
			'bloginfo_url',
			'theme_root_uri',
			'stylesheet_directory_uri',
			'template_directory_uri',
			'plugins_url',
			'the_permalink',
			'wp_list_pages',
			'wp_list_categories',
			'wp_nav_menu',
			'the_content_more_link',
			'the_tags',
			'get_pagenum_link',
			'get_comment_link',
			'month_link',
			'day_link',
			'year_link',
			'tag_link',
			'the_author_posts_link'
	);

	add_filters($root_rel_filters, 'ya_root_relative_url');

	add_filter('script_loader_src', 'ya_fix_duplicate_subfolder_urls');
	add_filter('style_loader_src', 'ya_fix_duplicate_subfolder_urls');
}

/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function ya_embed_wrap($cache, $url, $attr = '', $post_ID = '') {
	$cache = preg_replace('/width="(.*?)?"/', 'width="100%"', $cache);
	return '<div class="entry-content-asset">' . $cache . '</div>';
}
add_filter('embed_oembed_html', 'ya_embed_wrap', 10, 4);
add_filter('embed_googlevideo', 'ya_embed_wrap', 10, 2);

/**
 * Add class="thumbnail" to attachment items
 */
function ya_attachment_link_class($html) {
	$postid = get_the_ID();
	$html = str_replace('<a', '<a class="thumbnail"', $html);
	return $html;
}
add_filter('wp_get_attachment_link', 'ya_attachment_link_class', 10, 1);
/**
 * Remove unnecessary dashboard widgets
 *
 * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 */
function ya_remove_dashboard_widgets() {
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
	remove_meta_box('dashboard_plugins',        'dashboard', 'normal');
	remove_meta_box('dashboard_primary',        'dashboard', 'normal');
	remove_meta_box('dashboard_secondary',      'dashboard', 'normal');
}
add_action('admin_init', 'ya_remove_dashboard_widgets');

/**
 * Clean up the_excerpt()
 */
function ya_excerpt_length($length) {
	return POST_EXCERPT_LENGTH;
}

function ya_excerpt_more($more) {
	//return;
	return ' &hellip; <a href="' . get_permalink() . '">' . esc_html__('Readmore', 'shoppystore') . '</a>';
}
add_filter('excerpt_length', 'ya_excerpt_length');
add_filter('excerpt_more',   'ya_excerpt_more');

/**
 * Remove unnecessary self-closing tags
 */
function ya_remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}
add_filter('get_avatar',          'ya_remove_self_closing_tags'); // <img />
add_filter('comment_id_fields',   'ya_remove_self_closing_tags'); // <input />
add_filter('post_thumbnail_html', 'ya_remove_self_closing_tags'); // <img />

/**
 * Allow more tags in TinyMCE including <iframe> and <script>
 */
function ya_change_mce_options($options) {
	$ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';

	if (isset($initArray['extended_valid_elements'])) {
		$options['extended_valid_elements'] .= ',' . $ext;
	} else {
		$options['extended_valid_elements'] = $ext;
	}

	return $options;
}
add_filter('tiny_mce_before_init', 'ya_change_mce_options');

/**
 * Add additional classes onto widgets
 *
 * @link http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
 */
function ya_widget_first_last_classes($params) {
	global $my_widget_num;

	$this_id = $params[0]['id'];
	$arr_registered_widgets = wp_get_sidebars_widgets();

	if (!$my_widget_num) {
		$my_widget_num = array();
	}

	if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {
		return $params;
	}

	if (isset($my_widget_num[$this_id])) {
		$my_widget_num[$this_id] ++;
	} else {
		$my_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . esc_attr( $my_widget_num[$this_id] ) . ' ';

	if ($my_widget_num[$this_id] == 1) {
		$class .= 'widget-first ';
	} elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) {
		$class .= 'widget-last ';
	}

	$params[0]['before_widget'] = preg_replace('/class=\"/', "$class", $params[0]['before_widget'], 1);

	return $params;
}
add_filter('dynamic_sidebar_params', 'ya_widget_first_last_classes');

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 */
function ya_nice_search_redirect() {
	global $ya_rewrite;
	if (!isset($ya_rewrite) || !is_object($ya_rewrite) || !$ya_rewrite->using_permalinks()) {
		return;
	}

	$search_base = $ya_rewrite->search_base;
	if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
		wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
		exit();
	}
}
if (current_theme_supports('nice-search')) {
	add_action('template_redirect', 'ya_nice_search_redirect');
}

/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function ya_request_filter($query_vars) {
  if (isset($_GET['s']) && empty($_GET['s'])) {
    $query_vars['s'] = ' ';
  }

  return $query_vars;
}
add_filter('request', 'ya_request_filter');

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function ya_get_search_form($argument) {
	if ($argument === '') {
		locate_template('/templates/searchform.php', true, false);
	}
}
add_filter('get_search_form', 'ya_get_search_form');

function ya_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( _n( 'Page %s', 'Page %s', max( $paged, $page ), 'shoppystore' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'ya_wp_title', 10, 2 );


/**
 * Widget text do_shortcode();
 */
add_filter('widget_text', 'do_shortcode');


add_filter('wp_link_pages_args','add_next_and_number');

function add_next_and_number($args){
    if($args['next_or_number'] == 'next_and_number'){
        global $page, $numpages, $multipage, $more, $pagenow;
        $args['next_or_number'] = 'number';
        $prev = '';
        $next = '';
        if ( $multipage ) {
            if ( $more ) {
                $i = $page - 1;
                if ( $i && $more ) {
					$prev .='<p>';
                    $prev .= _wp_link_page($i);
                    $prev .= $args['link_before'].$args['previouspagelink'] . $args['link_after'] . '</a></p>';
                }
                $i = $page + 1;
                if ( $i <= $numpages && $more ) {
					$next .='<p>';
                    $next .= _wp_link_page($i);
                    $next .= $args['link_before']. $args['nextpagelink'] . $args['link_after'] . '</a></p>';
                }
            }
        }
        $args['before'] = $args['before'].$prev;
        $args['after'] = $next.$args['after'];    
    }
    return $args;
}
/* Menu Sticky */
function ya_sticky_menu(){
	$ya_popup	 		= ya_options()->getCpanelValue( 'popup_active' );
	$sticky_menu 		= ya_options()->getCpanelValue( 'sticky_menu' );	
	$ya_header_style 	= ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : ya_options()->getCpanelValue('header_style');
	$output = '';
	$output_css = '';
	$output .= '(function($) {';
if( !ya_mobile_check() ) {
	$header_mid = ya_options()->getCpanelValue('header_mid');
	$bg_header_mid = ya_options()->getCpanelValue('bg_header_mid');	
	if( $sticky_menu && $ya_header_style != 'style9' && $ya_header_style != 'style13' && $ya_header_style != 'style15'  ){
		if( $ya_header_style == 'style1' ||  $ya_header_style == 'style2' || $ya_header_style == 'style6' || $ya_header_style == 'style8' || $ya_header_style == 'style10' || $ya_header_style == 'style12' ){
		
			$output .= 'var sticky_navigation_offset = $(".yt-header-middle").offset();';
			$output .= 'if( typeof sticky_navigation_offset != "undefined" ) {';
			$output .= 'var sticky_navigation_offset_top = sticky_navigation_offset.top;';
			$output .= 'var sticky_navigation = function(){';
			$output .= 'var scroll_top = $(window).scrollTop();';
			$output .= 'if (scroll_top > sticky_navigation_offset_top) {';
			$output .= '$(".yt-header-middle").addClass("sticky-menu");';
			$output .= '$(".yt-header-middle").css({ "position": "fixed", "top":0, "left":0, "right" : 0, "z-index": 800 });';
			$output .= '} else {';
			$output .= '$(".yt-header-middle").removeClass("sticky-menu");';
			$output .= '$(".yt-header-middle").css({ "position": "relative","z-index": 30 });';
			$output .= '}';
			$output .= '};';
			$output .= 'sticky_navigation();';
			$output .= '$(window).scroll(function() {';
			$output .= 'sticky_navigation();';
			$output .= '}); }';
			
		}else {
			
			$output .= 'var sticky_navigation_offset = $(".yt-header-under-2").offset();';
			$output .= 'if( typeof sticky_navigation_offset != "undefined" ) {';
			$output .= 'var sticky_navigation_offset_top = sticky_navigation_offset.top;';
			$output .= 'var sticky_navigation = function(){';
			$output .= 'var scroll_top = $(window).scrollTop();';
			$output .= 'if (scroll_top > sticky_navigation_offset_top) {';
			$output .= '$(".yt-header-under-2").addClass("sticky-menu");';
			$output .= '$(".yt-header-under-2").css({ "top":0, "left":0, "right" : 0 });';
			$output .= '} else {';
			$output .= '$(".yt-header-under-2").removeClass("sticky-menu");';
			$output .= '}';
			$output .= '};';
			$output .= 'sticky_navigation();';
			$output .= '$(window).scroll(function() {';
			$output .= 'sticky_navigation();';
			$output .= '}); }';
			
		}
	}
    /*
		** Add background header mid
		*/
		
		if( $header_mid ){
			$output_css .= '#header .header-mid{';		
			$output_css .= ( $bg_header_mid != '' ) ? 'background-image: url('.esc_attr( $bg_header_mid ).');
				background-position: top center; 
				background-attachment: fixed;' : '';
			$output_css .= '}';
			wp_enqueue_style(	'ya_custom_css',	get_template_directory_uri() . '/css/custom_css.css' );
			wp_add_inline_style( 'ya_custom_css', $output_css );
		}
    /*
	** Popup Newsletter
	*/
			if( $ya_popup ){
				$output .= '$(document).ready(function() {
						var check_cookie = $.cookie("subscribe_popup");
						if(check_cookie == null || check_cookie == "shown") {
							 popupNewsletter();
						 }
						$("#subscribe_popup input#popup_check").on("click", function(){
							if($(this).parent().find("input:checked").length){        
								var check_cookie = $.cookie("subscribe_popup");
								 if(check_cookie == null || check_cookie == "shown") {
									$.cookie("subscribe_popup","dontshowitagain");            
								}
								else
								{
									$.cookie("subscribe_popup","shown");
									popupNewsletter();
								}
							} else {
								$.cookie("subscribe_popup","shown");
							}
						}); 
					});

					function popupNewsletter() {
						jQuery.fancybox({
							href: "#subscribe_popup",
							autoResize: true
						});
						jQuery("#subscribe_popup").trigger("click");
						jQuery("#subscribe_popup").parents(".fancybox-overlay").addClass("popup-fancy");
					};';
			}	
 }elseif(  ya_mobile_check() ) {
	if( ya_options()->getCpanelValue( 'sticky_mobile' ) ) {
		$output .= 'var sticky_navigation_offset = $(".mobile-layout .header").offset();';
		$output .= 'if( typeof sticky_navigation_offset != "undefined" ) {';
		$output .= 'var sticky_navigation_offset_top = sticky_navigation_offset.top;';
		$output .= 'var sticky_navigation = function(){';
		$output .= 'var scroll_top = $(window).scrollTop();';
		$output .= 'if (scroll_top > sticky_navigation_offset_top) {';
		$output .= '$(".mobile-layout .header").addClass("sticky-menu");';
		$output .= '$(".mobile-layout .header").css({ "top":0, "left":0, "right" : 0 });';
		$output .= '} else {';
		$output .= '$(".mobile-layout .header").removeClass("sticky-menu");';
		$output .= '}';
		$output .= '};';
		$output .= 'sticky_navigation();';
		$output .= '$(window).scroll(function() {';
		$output .= 'sticky_navigation();';
		$output .= '}); }';
	}
 }
 	
	 $output .= '}(jQuery));';
	 $translation_text = array(
		'cart_text' 		 => esc_html__( 'Add To Cart', 'shoppystore' ),
		'compare_text' 	 => esc_html__( 'Compare', 'shoppystore' ),
		'wishlist_text'  => esc_html__( 'WishList', 'shoppystore' ),
		'quickview_text' => esc_html__( 'QuickView', 'shoppystore' ),
		'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ), 
		'redirect' => get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ),
		'message' => esc_html__( 'Please enter your usename and password', 'shoppystore' ),
	);

	wp_localize_script( 'ya_theme_js', 'custom_text', $translation_text ); 
	wp_enqueue_script( 'ya_theme_js', get_template_directory_uri() . '/js/main.js', array(), null, true );
	wp_add_inline_script( 'ya_theme_js', $output );
}
add_action( 'wp_enqueue_scripts', 'ya_sticky_menu', 101);
if( ya_options()->getCpanelValue('back_active') == '1' ) {
	add_action( 'wp_footer', 'ya_backtotop', 101 );
	function ya_backtotop(){
		echo '<a id="ya-totop" href="#" ></a>';
	}
}