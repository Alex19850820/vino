<?php
add_theme_support( 'woocommerce' );

/*
** WooCommerce Compare Version
*/
if( !function_exists( 'sw_woocommerce_version_check' ) ) :
	function sw_woocommerce_version_check( $version = '3.0' ) {
		global $woocommerce;
		if( version_compare( $woocommerce->version, $version, ">=" ) ) {
			return true;
		}else{
			return false;
		}
	}
endif;

/*
** Sales label
*/
if( !function_exists( 'sw_label_sales' ) ){
	function sw_label_sales(){
		global $product, $post;
		$product_type = ( sw_woocommerce_version_check( '3.0' ) ) ? $product->get_type() : $product->product_type;
		echo sw_label_new();
		if( $product_type != 'variable' ) {
			$forginal_price 	= get_post_meta( $post->ID, '_regular_price', true );	
			$fsale_price 		= get_post_meta( $post->ID, '_sale_price', true );
			if( $fsale_price > 0 && $product->is_on_sale() ){ 
				$sale_off = 100 - ( ( $fsale_price/$forginal_price ) * 100 ); 
				$html = '<div class="sale-off ' . esc_attr( ( sw_label_new() != '' ) ? 'has-newicon' : '' ) .'">';
				$html .= '-' . round( $sale_off ).'%';
				$html .= '</div>';
				echo apply_filters( 'sw_label_sales', $html );
			} 
		}else{
			echo '<div class="' . esc_attr( ( sw_label_new() != '' ) ? 'has-newicon' : '' ) .'">';
			wc_get_template( 'single-product/sale-flash.php' );
			echo '</div>';
		}
	}	
}

/*minicart via Ajax*/
$ya_header = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : ya_options()->getCpanelValue('header_style');
$filter = sw_woocommerce_version_check( $version = '3.0.3' ) ? 'woocommerce_add_to_cart_fragments' : 'add_to_cart_fragments';
if(($ya_header == 'style8')||($ya_header == 'style9')){
	add_filter($filter , 'ya_add_to_cart_fragment_style1', 101);
	function ya_add_to_cart_fragment_style1( $fragments ) {
		ob_start();
		get_template_part( 'woocommerce/minicart-ajax-style1' ); 
		$fragments['.minicart-product-style2'] = ob_get_clean();
		return $fragments;
	}
}else {
  add_filter($filter , 'ya_add_to_cart_fragment', 100);	
	function ya_add_to_cart_fragment( $fragments ) {
		ob_start();
		get_template_part( 'woocommerce/minicart-ajax' ); 
		$fragments['.minicart-product-style'] = ob_get_clean();
		return $fragments;
	}	
}


/* change position */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	
/*remove woo breadcrumb*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

/*
** add second thumbnail loop product
*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'ya_woocommerce_template_loop_product_thumbnail', 10 );
function ya_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $product, $post;
	$html = '';	
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
	if ( has_post_thumbnail( $post->ID ) ){		
		$html .= '<a href="'.get_permalink( $post->ID ).'"><div class="product-thumb-hover">';
		$html .= (get_the_post_thumbnail( $post->ID, $size )) ? get_the_post_thumbnail( $post->ID, $size ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="'. esc_html__( 'No thumb', 'shoppystore' ) .'">';
		$html .= '</div></a>';
	}else{
		$html .= '<a href="'.get_permalink( $post->ID ).'">';
		$html .= '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="'. esc_html__( 'No thumb', 'shoppystore' ) .'">';
		$html .= '</a>';		
	}
	$html .= sw_label_sales();
	return apply_filters( 'sw_custom_loop_thumbnail', $html );
}

function ya_woocommerce_template_loop_product_thumbnail(){
	echo ya_product_thumbnail();
}

/*
** filter order
*/
function ya_addURLParameter($url, $paramName, $paramValue) {
     $url_data = parse_url($url);
     if(!isset($url_data["query"]))
         $url_data["query"]="";

     $params = array();
     parse_str($url_data['query'], $params);
     $params[$paramName] = $paramValue;
     $url_data['query'] = http_build_query($params);
     return ya_build_url($url_data);
}


function ya_build_url($url_data) {
 $url="";
 if(isset($url_data['host']))
 {
	 $url .= $url_data['scheme'] . '://';
	 if (isset($url_data['user'])) {
		 $url .= $url_data['user'];
			 if (isset($url_data['pass'])) {
				 $url .= ':' . $url_data['pass'];
			 }
		 $url .= '@';
	 }
	 $url .= $url_data['host'];
	 if (isset($url_data['port'])) {
		 $url .= ':' . $url_data['port'];
	 }
 }
 if (isset($url_data['path'])) {
	$url .= $url_data['path'];
 }
 if (isset($url_data['query'])) {
	 $url .= '?' . $url_data['query'];
 }
 if (isset($url_data['fragment'])) {
	 $url .= '#' . $url_data['fragment'];
 }
 return $url;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );

add_filter( 'ya_custom_category', 'woocommerce_maybe_show_product_subcategories' );
add_filter( 'woocommerce_pagination_args', 'ya_custom_pagination_args' );
add_action('woocommerce_message','wc_print_notices', 10);
add_action( 'woocommerce_before_main_content', 'ya_banner_listing', 10 );
add_action('woocommerce_before_shop_loop', 'ya_woocommerce_catalog_ordering', 30);
add_action('woocommerce_before_shop_loop', 'woocommerce_pagination', 35);
add_action('woocommerce_after_shop_loop', 'ya_woocommerce_catalog_ordering', 8);
add_action('woocommerce_before_shop_loop','ya_woommerce_view_mode_wrap',15);
add_action( 'woocommerce_after_shop_loop', 'ya_woommerce_view_mode_wrap', 5 );
add_action( 'woocommerce_before_shop_loop_mobile', 'ya_viewmode_wrapper_start_mobile', 5 );
add_action( 'woocommerce_before_shop_loop_mobile', 'ya_viewmode_wrapper_end_mobile', 50 );
add_action( 'woocommerce_before_shop_loop_mobile', 'ya_woocommerce_catalog_ordering_mobile', 30 );
add_action( 'woocommerce_before_shop_loop_mobile','ya_woommerce_view_mode_wrap_mobile',15 );
if( ya_options()->getCpanelValue( 'product_listing_countdown' ) && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_post_type_archive( 'product' ) ) ){
	add_action( 'woocommerce_after_shop_loop_item_title', 'ya_product_deal', 20 );
}

/*
** Pagination Size to Show
*/
function ya_custom_pagination_args( $args = array() ){
	$args['end_size'] = 2;
	$args['mid_size'] = 1;
	return $args;	
}

function ya_banner_listing(){	
	// Check Vendor page of WC MarketPlace
	global $WCMp;
	if ( class_exists( 'WCMp' ) && is_tax($WCMp->taxonomy->taxonomy_name) ) {
		return;
	}
	
	$banner_enable  = ya_options()->getCpanelValue( 'product_banner' );
	$banner_listing = ya_options()->getCpanelValue( 'product_listing_banner' );
	$html = '<div class="image-category">';
	if( '' === $banner_enable ){
		$html .= '<img src="'. esc_url( $banner_listing ) .'" alt=""/>';
	}else{
		global $wp_query;
		$cat = $wp_query->get_queried_object();
		if( !is_shop() ) {
			$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
			$image = wp_get_attachment_url( $thumbnail_id );
			if( $image ) {
				$html .= '<img src="'. esc_url( $image ) .'" alt=""/>';
			}else{
				$html .= '<img src="'. esc_url( $banner_listing ) .'" alt=""/>';
			}
		}else{
			$html .= '<img src="'. esc_url( $banner_listing ) .'" alt=""/>';
		}
	}
	$html .= '</div>';
	if( !is_singular( 'product' ) ){
		echo $html;
	}
}

function ya_viewmode_wrapper_start_mobile(){
	echo '<div class="products-nav clearfix">';
}

function ya_viewmode_wrapper_end_mobile(){
	echo '</div>';
}

function ya_woommerce_view_mode_wrap_mobile () {
	$html='<div class="view-mode-wrap pull-left clearfix">
				<div class="view-mode">
						<a href="javascript:void(0)" class="grid-view view-grid active" title="'. esc_attr__('Grid view', 'shoppystore').'"><span>'. esc_html__('Grid view', 'shoppystore').'</span></a>
						<a href="javascript:void(0)" class="list-view view-list" title="'. esc_attr__('List view', 'shoppystore') .'"><span>'.esc_html__('List view', 'shoppystore').'</span></a>
				</div>	
			</div>';
	echo $html;
}

function ya_woocommerce_catalog_ordering_mobile() { 
	
	parse_str($_SERVER['QUERY_STRING'], $params);
	$query_string 	= '?'.$_SERVER['QUERY_STRING'];
	$option_number 	=  ya_options()->getCpanelValue( 'product_number' );
	
	if( $option_number ) {
		$per_page = $option_number;
	} else {
		$per_page = 12;
	}
	
	$pob = !empty( $params['orderby'] ) ? $params['orderby'] : get_option( 'woocommerce_default_catalog_orderby' );
	$po  = !empty($params['product_order'])  ? $params['product_order'] : 'asc';
	$pc  = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	$html = '';
	$html .= '<div class="catalog-ordering">';

	$html .= '<div class="orderby-order-container clearfix">';
	$html .= '<ul class="orderby order-dropdown pull-left">';
	$html .= '<li>';
	$html .= '<span class="current-li"><span class="current-li-content"><a>'.esc_html__('Sort by Default', 'shoppystore').'</a></span></span>'; $html .= '<ul>';
	$html .= '<li class="'.( ( $pob == 'menu_order' ) ? 'current': '' ).'"><a href="'.ya_addURLParameter( $query_string, 'orderby', 'menu_order' ).'">' . esc_html__( 'Sort by Default', 'shoppystore' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'popularity' ) ? 'current': '' ).'"><a href="'.ya_addURLParameter( $query_string, 'orderby', 'popularity' ).'">' . esc_html__( 'Sort by Popularity', 'shoppystore' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'rating' ) ? 'current': '' ).'"><a href="'.ya_addURLParameter( $query_string, 'orderby', 'rating' ).'">' . esc_html__( 'Sort by Rating', 'shoppystore' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'date' ) ? 'current': '' ).'"><a href="'.ya_addURLParameter( $query_string, 'orderby', 'date' ).'">' . esc_html__( 'Sort by Date', 'shoppystore' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'price' ) ? 'current': '' ).'"><a href="'.ya_addURLParameter( $query_string, 'orderby', 'price' ).'">' . esc_html__( 'Sort by Price', 'shoppystore' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'price-desc' ) ? 'current': '' ).'"><a href="'.ya_addURLParameter( $query_string, 'orderby', 'price-desc' ).'">' . esc_html__( 'Sort by Price(Desc)', 'shoppystore' ) . '</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	if( !ya_mobile_check() ) : 
	$html .= '<ul class="order pull-left">';
	if($po == 'desc'):
	$html .= '<li class="desc"><a href="'.ya_addURLParameter($query_string, 'product_order', 'asc').'"></a></li>';
	endif;
	if($po == 'asc'):
	$html .= '<li class="asc"><a href="'.ya_addURLParameter($query_string, 'product_order', 'desc').'"></a></li>';
	endif;
	$html .= '</ul>';
	
	
	$html .= '<div class="product-number pull-left clearfix"><span class="show-product pull-left">'. esc_html__( 'Show', 'shoppystore' ) . ' </span>';
	$html .= '<ul class="sort-count order-dropdown pull-left">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a>'. $per_page .'</a></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pc == $per_page) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page).'">'.$per_page.'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*2) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page*2).'">'.($per_page*2).'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*3) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page*3).'">'.($per_page*3).'</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul></div>';
	endif;
	
	$html .= '</div>';
	$html .= '</div>';
	if( ya_mobile_check() ) : 
	$html .= '<div class="filter-product">'. esc_html__('Filter','shoppystore') .'</div>';
		endif;
	echo $html;
}
function ya_woommerce_view_mode_wrap () {
	$html  = '';
	$html .= '<ul class="view-mode-wrap">
		<li class="view-grid sel">
			<a></a>
		</li>
		<li class="view-list">
			<a></a>
		</li>
	</ul>';
	echo $html;
}

function ya_woocommerce_catalog_ordering() {
	global $data;

	parse_str($_SERVER['QUERY_STRING'], $params);

	$query_string = '?'.$_SERVER['QUERY_STRING'];

	$option_number 	=  ya_options()->getCpanelValue( 'product_number' );
	// replace it with theme option
	if( $option_number ) {
		$per_page = $option_number;
	} else {
		$per_page = 8;
	}

	$pob = !empty( $params['orderby'] ) ? $params['orderby'] : get_option( 'woocommerce_default_catalog_orderby' );
	$po  = !empty($params['product_order'])  ? $params['product_order'] : 'asc';
	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	$html = '';
	$html .= '<div class="catalog-ordering clearfix">';

	$html .= '<div class="orderby-order-container">';

	$html .= '<ul class="orderby order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><span class="current-li-content"><a>'.esc_html__('Sort by', 'shoppystore').'</a></span></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pob == 'menu_order') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'orderby', 'menu_order').'">'.esc_html__('Sort by ', 'shoppystore').esc_html__('Default', 'shoppystore').'</a></li>';
	$html .= '<li class="'.(($pob == 'popularity') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'orderby', 'popularity').'">'.esc_html__('Sort by ', 'shoppystore').esc_html__('Popularity', 'shoppystore').'</a></li>';
	$html .= '<li class="'.(($pob == 'rating') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'orderby', 'rating').'">'.esc_html__('Sort by ', 'shoppystore').esc_html__('Rating', 'shoppystore').'</a></li>';
	$html .= '<li class="'.(($pob == 'date') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'orderby', 'date').'">'.esc_html__('Sort by ', 'shoppystore').esc_html__('Date', 'shoppystore').'</a></li>';
	$html .= '<li class="'.(($pob == 'price') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'orderby', 'price').'">'.esc_html__('Sort by ', 'shoppystore').esc_html__('Price', 'shoppystore').'</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
    $html .= '<ul class="order">';
	if($po == 'desc'):
	$html .= '<li class="desc"><a href="'.ya_addURLParameter($query_string, 'product_order', 'asc').'"><i class="icon-arrow-up"></i></a></li>';
	endif;
	if($po == 'asc'):
	$html .= '<li class="asc"><a href="'.ya_addURLParameter($query_string, 'product_order', 'desc').'"><i class="icon-arrow-down"></i></a></li>';
	endif;
	$html .= '</ul>';
	$html .= '<ul class="sort-count order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a>'.esc_html__('8', 'shoppystore').'</a></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pc == $per_page) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page).'">'.$per_page.'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*2) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page*2).'">'.($per_page*2).'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*3) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page*3).'">'.($per_page*3).'</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	$html .= '</div>';
	$html .= '</div>';
	
	echo $html;
}


add_action('woocommerce_get_catalog_ordering_args', 'ya_woocommerce_get_catalog_ordering_args', 20);
function ya_woocommerce_get_catalog_ordering_args($args)
{
	global $woocommerce;

	parse_str($_SERVER['QUERY_STRING'], $params);

	$po = !empty($params['product_order'])  ? $params['product_order'] : 'desc';

	switch($po) {
		case 'desc':
			$order = 'desc';
		break;
		case 'asc':
			$order = 'asc';
		break;
		default:
			$order = 'asc';
		break;
	}

	$args['order'] = $order;

	return $args;
}

add_filter('loop_shop_per_page', 'ya_loop_shop_per_page');
function ya_loop_shop_per_page()
{
	global $data;

	parse_str($_SERVER['QUERY_STRING'], $params);

	$option_number 	=  ya_options()->getCpanelValue( 'product_number' );
	// replace it with theme option
	if( $option_number ) {
		$per_page = $option_number;
	} else {
		$per_page = 8;
	}

	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	return $pc;
}
/* =====================================================================================================
** Product loop content 
	 ===================================================================================================== */
	 
/*
** attribute for product listing
*/
function ya_product_attribute(){
	global $woocommerce_loop;
	
	$col_lg = ya_options()->getCpanelValue( 'product_col_large' );
	$col_md = ya_options()->getCpanelValue( 'product_col_medium' );
	$col_sm = ya_options()->getCpanelValue( 'product_col_sm' );
	$class_col= "item ";
	
	if( isset( get_queried_object()->term_id ) ) :
		$term_col_lg  = get_term_meta( get_queried_object()->term_id, 'term_col_lg', true );
		$term_col_md  = get_term_meta( get_queried_object()->term_id, 'term_col_md', true );
		$term_col_sm  = get_term_meta( get_queried_object()->term_id, 'term_col_sm', true );

		$col_lg = ( intval( $term_col_lg ) > 0 ) ? $term_col_lg : ya_options()->getCpanelValue( 'product_col_large' );
		$col_md = ( intval( $term_col_md ) > 0 ) ? $term_col_md : ya_options()->getCpanelValue( 'product_col_medium' );
		$col_sm = ( intval( $term_col_sm ) > 0 ) ? $term_col_sm : ya_options()->getCpanelValue( 'product_col_sm' );
	endif;
	
	$column1 = 12 / $col_lg;
	$column2 = 12 / $col_md;
	$column3 = 12 / $col_sm;	

	$class_col .= ' col-lg-'.$column1.' col-md-'.$column2.' col-sm-'.$column3.'';

	$class_col .= ' col-lg-'.$column1.' col-md-'.$column2.' col-sm-'.$column3.' col-xs-6';
	
	return esc_attr( $class_col );
}
/*
** Check sidebar 
*/
function ya_sidebar_product(){
	$ya_sidebar_product = ya_options() -> getCpanelValue('sidebar_product');
	if( isset( get_queried_object()->term_id ) ){
		$ya_sidebar_product = ( get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) != '' ) ? get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) : ya_options()->getCpanelValue('sidebar_product');
	}	
	if( is_singular( 'product' ) ) {
		$ya_sidebar_product = ( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : ya_options()->getCpanelValue('sidebar_product');
	}
	return $ya_sidebar_product;
}

/*
** Product Category Class
*/
add_filter( 'product_cat_class', 'ya_product_category_class', 2 );
function ya_product_category_class( $classes, $category = null ){
	global $woocommerce_loop;
	
	$col_lg = ( ya_options()->getCpanelValue( 'product_colcat_large' ) )  ? ya_options()->getCpanelValue( 'product_colcat_large' ) : 1;
	$col_md = ( ya_options()->getCpanelValue( 'product_colcat_medium' ) ) ? ya_options()->getCpanelValue( 'product_colcat_medium' ) : 1;
	$col_sm = ( ya_options()->getCpanelValue( 'product_colcat_sm' ) )	   ? ya_options()->getCpanelValue( 'product_colcat_sm' ) : 1;
	
	
	$column1 = str_replace( '.', '' , floatval( 12 / $col_lg ) );
	$column2 = str_replace( '.', '' , floatval( 12 / $col_md ) );
	$column3 = str_replace( '.', '' , floatval( 12 / $col_sm ) );

	$classes[] = ' col-lg-'.$column1.' col-md-'.$column2.' col-sm-'.$column3.' col-xs-6';
	
	return $classes;
} 


/* =====================================================================================================
	Single
   ===================================================================================================== */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing',50);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action('woocommerce_single_product_summary','woocommerce_template_single_price',20);
add_action('woocommerce_single_product_summary','ya_template_single_title',5);
add_action('woocommerce_single_product_summary','ya_template_single_excerpt',10);
add_action( 'woocommerce_single_product_summary', 'ya_get_brand', 15 );
if( ya_options()->getCpanelValue( 'product_single_countdown' ) ){
	add_action( 'woocommerce_single_product_summary', 'ya_product_deal',10 );
}

function ya_template_single_title(){
?>
	<h1 itemprop="name" class="product_title"><?php the_title(); ?></h1>
<?php 
}

function ya_template_single_excerpt(){
	global $post;
	if ( ! $post->post_excerpt ) return;
?>
	<div itemprop="description" class="product-description">
		<h2 class="quick-overview"><?php esc_html_e('QUICK OVERVIEW','shoppystore') ?></h2>
		<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
	</div>
<?php 
}

/**
* Get brand on the product single
**/
function ya_get_brand(){
	global $post;
	$terms = get_the_terms( $post->ID, 'product_brand' );
	if( taxonomy_exists( 'product_brand' ) && !empty( $terms ) && sizeof( $terms ) > 0 ){
?>
		<div class="item-brand">
			<span><?php echo esc_html__( 'Product by', 'shoppystore' ) . ': '; ?></span>
			<?php 
				foreach( $terms as $key => $term ){
					$thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_bid', true ) );
					if( $thumbnail_id && ya_options()->getCpanelValue( 'product_brand' ) ){
			?>
				<a href="<?php echo get_term_link( $term->term_id, 'product_brand' ); ?>"><img src="<?php echo wp_get_attachment_thumb_url( $thumbnail_id ); ?>" alt="" title="<?php echo esc_attr( $term->name ); ?>"/></a>				
			<?php 
					}else{
			?>
				<a href="<?php echo get_term_link( $term->term_id, 'product_brand' ); ?>"><?php echo $term->name; ?></a>
				<?php echo( ( $key + 1 ) === count( $terms ) ) ? '' : ', '; ?>
			<?php 
					}					
				}
			?>
		</div>
<?php 
	}
}

/*
**	Related Product function
*/
function Ya_related_product( $number, $title ){
	ob_start();
	include( get_template_directory(). '/widgets/ya_relate_product/slide.php' );
	$content = ob_get_clean();
	echo $content;
}

add_action( 'woocommerce_before_add_to_cart_form', 'ya_before_addcart', 28);
add_action( 'woocommerce_after_add_to_cart_form', 'ya_after_addcart', 38);
function ya_before_addcart(){
			echo '<div class="product-summary-bottom clearfix">';
	
	}
	function ya_after_addcart(){
		echo '</div>';
	}
/*YITH wishlist*/
	if ( class_exists( 'YITH_WOOCOMPARE' ) || class_exists( 'YITH_WCWL' ) ) {
	add_action( 'woocommerce_after_single_variation', 'ya_add_wishlist_variation', 10 );
	add_action('woocommerce_after_shop_loop_item','ya_add_loop_compare_link', 20);
	add_action( 'woocommerce_after_shop_loop_item', 'ya_add_loop_wishlist_link',8 );
	add_action( 'woocommerce_after_add_to_cart_button', 'ya_add_social', 30 );
	add_action( 'woocommerce_after_add_to_cart_button', 'ya_add_wishlist_link', 10);
	function ya_add_loop_compare_link(){ 
		global $product, $post;
		$product_id = $post->ID;
		if ( class_exists( 'YITH_WOOCOMPARE' ) && !ya_mobile_check() ){	
			echo '<div class="woocommerce product compare-button"><a href="javascript:void(0)" class="compare button" data-product_id="'. $product_id .'" rel="nofollow">'. esc_html__( 'Compare', 'shoppystore' ) .'</a></div>';
    }		
	}
	function ya_add_loop_wishlist_link(){
		
		if ( class_exists( 'YITH_WCWL' ) && !ya_mobile_check() ){
			echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
		}
	}
	function ya_add_wishlist_link(){
		global $product, $post;
		$product_id = $post->ID;
		$product_type = ( sw_woocommerce_version_check( '3.0' ) ) ? $product->get_type() : $product->product_type;
		if( $product_type != 'variable' && !ya_mobile_check() ){
			
			if ( class_exists( 'YITH_WOOCOMPARE' ) ){	
				echo '<div class="woocommerce product compare-button"><a href="javascript:void(0)" class="compare button" data-product_id="'. $product_id .'" rel="nofollow">'. esc_html__( 'Compare', 'shoppystore' ) .'</a></div>';
			}				
			if ( class_exists( 'YITH_WCWL' ) ){
				echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
			}
			
		}else{
			return ;
		}
	}
	function ya_add_wishlist_variation(){	
		global $product, $post;
		$product_id = $post->ID;
		if( !ya_mobile_check() ){
			if ( class_exists( 'YITH_WOOCOMPARE' ) ){	
				echo '<div class="woocommerce product compare-button"><a href="javascript:void(0)" class="compare button" data-product_id="'. $product_id .'" rel="nofollow">'. esc_html__( 'Compare', 'shoppystore' ) .'</a></div>';
			}	
			
			if ( class_exists( 'YITH_WCWL' ) ){
				echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
			}
		}
	}
	function ya_add_social() {
	    echo '<div class="social-icon">
		<div class="social-icon-button"></div>';
		 echo do_action( 'woocommerce_share' );
		 echo get_social();
		echo '</div>';
	}
}

/*
**Hook into review for rick snippet
*/
add_action( 'woocommerce_review_before_comment_meta', 'ya_title_ricksnippet', 10 ) ;
function ya_title_ricksnippet(){
	global $post;
	echo '<span class="hidden" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">
    <span itemprop="name">'. $post->post_title .'</span>
  </span>';
}

/*
** Add page deal to listing
*/
function ya_product_deal(){
	global $product;
	$start_time 	= get_post_meta( $product->get_id(), '_sale_price_dates_from', true );
	$countdown_time = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );	
	$orginal_price  = get_post_meta( $product->get_id(), '_regular_price', true );	
	$symboy 		= get_woocommerce_currency_symbol( get_woocommerce_currency() );
	
	if( !empty ($countdown_time ) && $countdown_time > $start_time ) :
		$offset = sw_timezone_offset( $countdown_time );
?>
	<div class="product-countdown" data-date="<?php echo esc_attr( $offset ); ?>" data-price="<?php echo esc_attr( $symboy.$orginal_price ); ?>" data-starttime="<?php echo esc_attr( $start_time ); ?>" data-cdtime="<?php echo esc_attr( $countdown_time ); ?>" data-id="<?php echo esc_attr( 'product_' . $product->get_id() ); ?>"></div>
<?php 
	endif;
}

/*
** Quickview 
*/

add_action("wp_ajax_ya_quickviewproduct", "ya_quickviewproduct");
add_action("wp_ajax_nopriv_ya_quickviewproduct", "ya_quickviewproduct");
function ya_quickviewproduct(){
	
	$productid = (isset($_REQUEST["post_id"]) && $_REQUEST["post_id"]>0) ? $_REQUEST["post_id"] : 0;
	
	$query_args = array(
		'post_type'	=> 'product',
		'p'			=> $productid
	);
	$outputraw = $output = '';
	$r = new WP_Query($query_args);
	if($r->have_posts()){ 

		while ($r->have_posts()){ $r->the_post(); setup_postdata($r->post);
			global $product;
			ob_start();
			wc_get_template_part( 'content', 'quickview-product' );
			$outputraw = ob_get_contents();
			ob_end_clean();
		}
	}
	$output = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw);
	echo $output;exit();
}

/*
** Custom Login ajax
*/
add_action('wp_ajax_ya_custom_login_user', 'ya_custom_login_user_callback' );
add_action('wp_ajax_nopriv_ya_custom_login_user', 'ya_custom_login_user_callback' );
function ya_custom_login_user_callback(){
	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'woocommerce-login', 'security' );

	// Nonce is checked, get the POST data and sign user on
	$info = array();
	$info['user_login'] = $_POST['username'];
	$info['user_password'] = $_POST['password'];
	$info['remember'] = true;

	$user_signon = wp_signon( $info, false );
	if ( is_wp_error($user_signon) ){
		echo json_encode(array('loggedin'=>false, 'message'=> $user_signon->get_error_message()));
	} else {
		$redirect_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		$user 		  = get_user_by( 'login', $info['user_login'] );
		$user_role 	  = ( is_array( $user->roles ) ) ? $user->roles : array() ;
		if( in_array( 'vendor', $user_role ) ){
			$vendor_option = get_option( 'wc_prd_vendor_options' );
			$vendor_page   = ( array_key_exists( 'vendor_dashboard_page', $vendor_option ) ) ? $vendor_option['vendor_dashboard_page'] : get_option( 'woocommerce_myaccount_page_id' );
			$redirect_url = get_permalink( $vendor_page );
		}
		elseif( in_array( 'seller', $user_role ) ){
			$vendor_option = get_option( 'dokan_pages' );
			$vendor_page   = ( array_key_exists( 'dashboard', $vendor_option ) ) ? $vendor_option['dashboard'] : get_option( 'woocommerce_myaccount_page_id' );
			$redirect_url = get_permalink( $vendor_page );
		}
		elseif( in_array( 'dc_vendor', $user_role ) ){
			$vendor_option = get_option( 'wcmp_vendor_general_settings_name' );
			$vendor_page   = ( array_key_exists( 'wcmp_vendor', $vendor_option ) ) ? $vendor_option['wcmp_vendor'] : get_option( 'woocommerce_myaccount_page_id' );
			$redirect_url = get_permalink( $vendor_page );
		}
		echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('Login Successful, redirecting...', 'shoppystore'), 'redirect' => esc_url( $redirect_url ) ));
	}

	die();
}

/*
** Add Label New and SoldOut
*/
if( !function_exists( 'sw_label_new' ) ){
	function sw_label_new(){
		global $product;
		$html = '';
		$newtime = ( get_post_meta( $product->get_id(), 'newproduct', true ) != '' && get_post_meta( $product->get_id(), 'newproduct', true ) ) ? get_post_meta( $product->get_id(), 'newproduct', true ) : ya_options()->getCpanelValue( 'newproduct_time' );
		$product_date = get_the_date( 'Y-m-d', $product->get_id() );
		$newdate = strtotime( $product_date ) + intval( $newtime ) * 24 * 3600;
		if( ! $product->is_in_stock() ) :
			$html .= '<span class="sw-outstock">'. esc_html__( 'Нет в наличии', 'shoppystore' ) .'</span>';		
		else:
			if( $newtime != '' && $newdate > time() ) :
				$html .= '<span class="sw-newlabel">'. esc_html__( 'Новое', 'shoppystore' ) .'</span>';			
			endif;
		endif;
		return apply_filters( 'sw_label_new', $html );
	}
}

/*
** Check for mobile layout
*/
//if( ya_mobile_check() ){
//	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 35 );
//}