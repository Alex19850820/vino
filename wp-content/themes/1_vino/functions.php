<?php
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 225, 200 ); // размер миниатюры поста по умолчанию
}

// замена надписи кнопки добавить в корзину в каталоге
add_filter( 'add_to_cart_text', 'woo_custom_product_add_to_cart_text' );            // < 2.1
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_product_add_to_cart_text' );  // 2.1 +
  
function woo_custom_product_add_to_cart_text() {
  
    return __( 'в корзину', 'woocommerce' );
  
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'category-thumb', 300, 9999 ); // 300 в ширину и без ограничения в высоту
	add_image_size( 'homepage-thumb', 220, 180, true ); // Кадрирование изображения
	add_image_size( 'woocommerce_gallery_thumbnail', '160', '130', true ); 
	add_image_size( 'shop_thumbnail', '160', '130', true ); 
}
add_image_size( 'thumbnails_twist', '120', '120', true ); 
add_image_size( 'medium_large', '768', '0', false ); 
add_image_size( 'woocommerce_thumbnail', '252', '252', true ); 
add_image_size( 'woocommerce_single', '225', '200', false ); 

add_image_size( 'shop_catalog', '252', '252', true ); 
add_image_size( 'shop_single', '225', '200', true  ); 




add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
add_theme_support( 'woocommerce' );
};

add_theme_support( 'post-thumbnails' );

add_theme_support('menus');
register_nav_menus(array(
  'header_menu' => 'Меню в header',  
  'sidebar_menu' => 'Меню в sidebar',
  'footer_menu' => 'Меню в footer',
));

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart ', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_single_product_summary', 'WC_Structured_Data::generate_product_data()', 60);


add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20);
add_action('woocommerce_single_product_summary', 'WC_Structured_Data::generate_product_data()', 30);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 40);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 50);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart ', 60);


add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);

// выводим цену вариативного товара
 
add_filter('woocommerce_available_variation', function ($value, $object = null, $variation = null) {
 
if ($value['price_html'] == '') {
 
$value['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
 
}
 
return $value;
 
}, 10, 3);




add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
 
// Все $fields в этой функции будут пропущены через фильтр
  
function custom_override_checkout_fields( $fields ) {
  //unset($fields['billing']['billing_first_name']);// имя
  unset($fields['billing']['billing_last_name']);// фамилия
  unset($fields['billing']['billing_company']); // компания
  unset($fields['billing']['billing_address_1']);//
  unset($fields['billing']['billing_address_2']);//
  unset($fields['billing']['billing_city']);
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_country']);
  unset($fields['billing']['billing_state']);
  //unset($fields['billing']['billing_phone']);
  //unset($fields['order']['order_comments']);
  //unset($fields['billing']['billing_email']);
  //unset($fields['account']['account_username']);
  //unset($fields['account']['account_password']);
  //unset($fields['account']['account_password-2']);
 
 
  unset($fields['billing']['billing_company']);// компания
  unset($fields['billing']['billing_postcode']);// индекс 
    return $fields;
}



if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

if( function_exists('acf_set_options_page_title') ) {
    acf_set_options_page_title( __('Настройки сайта') );
}

if (function_exists('acf_set_options_page_menu')) {
    acf_set_options_page_menu('Настройки сайта');
}

/**
 * Hook in on activation
 */
/**
 * Define image sizes
 */
 function yourtheme_woocommerce_image_dimensions() {
	global $pagenow;
 
	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}
  	$catalog = array(
		'width' 	=> '252',	// px
		'height'	=> '200',	// px
		'crop'		=> true		// true
	);
	$single = array(
		'width' 	=> '225',	// px
		'height'	=> '200',	// px
		'crop'		=> true	 		// true
	);
	$thumbnail = array(
		'width' 	=> '160',	// px
		'height'	=> '130',	// px
		'crop'		=> true		// true
	);
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

add_action( 'after_switch_theme', 'yourtheme_woocommerce_image_dimensions', 1 );

if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'header',
'before_widget' => '<div class="neobhodimui-klass">',
'after_widget' => '</div>',
'before_title' => '<div class="title">',
'after_title' => '</div>',
));

/**
	 * Для термина  - product_cat
	 */
	add_filter( 'request', 'change_requerst_vars_for_product_cat' );
	add_filter( 'term_link', 'term_link_filter', 10, 3 );

	/**
	 * Для типа постов - product
	 */
	add_filter( 'post_type_link', 'wpp_remove_slug', 10, 3 );
	add_action( 'pre_get_posts', 'wpp_change_request' );

	function change_requerst_vars_for_product_cat($vars) {

		global $wpdb;
		if ( ! empty( $vars[ 'pagename' ] ) || ! empty( $vars[ 'category_name' ] ) || ! empty( $vars[ 'name' ] ) || ! empty( $vars[ 'attachment' ] ) ) {
			$slug   = ! empty( $vars[ 'pagename' ] ) ? $vars[ 'pagename' ] : ( ! empty( $vars[ 'name' ] ) ? $vars[ 'name' ] : ( ! empty( $vars[ 'category_name' ] ) ? $vars[ 'category_name' ] : $vars[ 'attachment' ] ) );
			$exists = $wpdb->get_var( $wpdb->prepare( "SELECT t.term_id FROM $wpdb->terms t LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'product_cat' AND t.slug = %s", array( $slug ) ) );
			if ( $exists ) {
				$old_vars = $vars;
				$vars     = array( 'product_cat' => $slug );
				if ( ! empty( $old_vars[ 'paged' ] ) || ! empty( $old_vars[ 'page' ] ) ) {
					$vars[ 'paged' ] = ! empty( $old_vars[ 'paged' ] ) ? $old_vars[ 'paged' ] : $old_vars[ 'page' ];
				}
				if ( ! empty( $old_vars[ 'orderby' ] ) ) {
					$vars[ 'orderby' ] = $old_vars[ 'orderby' ];
				}
				if ( ! empty( $old_vars[ 'order' ] ) ) {
					$vars[ 'order' ] = $old_vars[ 'order' ];
				}
			}
		}

		return $vars;

	}
	
	function term_link_filter( $url, $term, $taxonomy ) {

		$url = str_replace( "/product-category/", "/", $url );
		return $url;

	}

	function wpp_remove_slug( $post_link, $post, $name ) {

		if ( 'product' != $post->post_type || 'publish' != $post->post_status ) {
			return $post_link;
		}
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

		return $post_link;

	}

	function wpp_change_request( $query ) {

		if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query[ 'page' ] ) ) {
			return;
		}
		if ( ! empty( $query->query[ 'name' ] ) ) {
			$query->set( 'post_type', array( 'post', 'product', 'page' ) );
		}

	}

function action_woocommerce_after_shop_loop_item() {
    global $product;
    if ($product->stock_status == 'instock') {
        echo '<div class="my_quantity">В наличии</div> ';
    } else {
        echo '<div class="my_quantity">' . 'Нет в наличии' . '</div>';
    }
};
add_action( 'woocommerce_after_shop_loop_item', 'action_woocommerce_after_shop_loop_item');

// выбор количества при добавлении простых товаров в корзину с поддержкой AJAX на страницах категорий товаров
add_action('woocommerce_before_shop_loop', 'custom_woo_before_shop_link');
function custom_woo_before_shop_link() {
    add_filter('woocommerce_loop_add_to_cart_link', 'custom_woo_loop_add_to_cart_link', 10, 2);
    add_action('woocommerce_after_shop_loop', 'custom_woo_after_shop_loop');
}

// customise Add to Cart link/button for product loop
function custom_woo_loop_add_to_cart_link($button, $product) {
    // not for variable, grouped or external products
    if (!in_array($product->product_type, array('variable', 'grouped', 'external'))) {
        // only if can be purchased
        if ($product->is_purchasable()) {
            // show qty +/- with button
            ob_start();
            woocommerce_simple_add_to_cart();
            $button = ob_get_clean();
            // modify button so that AJAX add-to-cart script finds it
            $replacement = sprintf('data-product_id="%d" data-quantity="1" $1 ajax_add_to_cart add_to_cart_button product_type_simple ', $product->id);
            $button = preg_replace('/(class="single_add_to_cart_button)/', $replacement, $button);
        }
    }
    return $button;
}
// add the required JavaScript
function custom_woo_after_shop_loop() {
    ?>

    <script>
    jQuery(function($) {
    <?php /* when product quantity changes, update quantity attribute on add-to-cart button */ ?>
    $("form.cart").on("change", "input.qty", function() {
        $(this.form).find("button[data-quantity]").data("quantity", this.value);
    });
    <?php /* remove old "view cart" text, only need latest one thanks! */ ?>
    $(document.body).on("adding_to_cart", function() {
        $("a.added_to_cart").remove();
    });
    });
    </script>

    <?php

}
//Цена вариативного товара
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
 
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );
 
function wc_wc20_variation_price_format( $price, $product ) {
 
// ???? ???
 
$prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
 
$price = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
// ?? ? ????
 
$prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
 
sort( $prices );
 
$saleprice = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
if ( $price !== $saleprice ) {
 
$price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
 
}
 
return $price;
 
}

//Горгода и области России для доставки
add_filter( 'woocommerce_states', 'new_rus_woocommerce_states' );
function new_rus_woocommerce_states( $states ) {
$states['RU'] = array(
'MSK' => 'Москва',
'SPB' => 'Санкт-Петербург',
'NOV' => 'Новосибирск',
'EKB' => 'Екатеринбург',
'NN' => 'Нижний Новгород',
'KZN' => 'Казань',
'CHL' => 'Челябинск',
'OMSK' => 'Омск',
'SMR' => 'Самара',
'RND' => 'Ростов-на-Дону',
'UFA' => 'Уфа',
'PRM' => 'Пермь',
'KRN' => 'Красноярск',
'VRZH' => 'Воронеж',
'VLG' => 'Волгоград',
'SIMF' => 'Симферополь',
'ABAO' => 'Агинский Бурятский авт.окр.',
'AR' => 'Адыгея Республика',
'ALR' => 'Алтай Республика',
'AK' => 'Алтайский край',
'AMO' => 'Амурская область',
'ARO' => 'Архангельская область',
'ACO' => 'Астраханская область',
'BR' => 'Башкортостан республика',
'BEO' => 'Белгородская область',
'BRO' => 'Брянская область',
'BUR' => 'Бурятия республика',
'VLO' => 'Владимирская область',
'VOO' => 'Волгоградская область',
'VOLGO' => 'Вологодская область',
'VORO' => 'Воронежская область',
'DR' => 'Дагестан республика',
'EVRAO' => 'Еврейская авт. область',
'IO' => 'Ивановская область',
'IR' => 'Ингушетия республика',
'IRO' => 'Иркутская область',
'KBR' => 'Кабардино-Балкарская республика',
'KNO' => 'Калининградская область',
'KMR' => 'Калмыкия республика',
'KLO' => 'Калужская область',
'KMO' => 'Камчатская область',
'KCHR' => 'Карачаево-Черкесская республика',
'KR' => 'Карелия республика',
'KEMO' => 'Кемеровская область',
'KIRO' => 'Кировская область',
'KOMI' => 'Коми республика',
'KPAO' => 'Коми-Пермяцкий авт. окр.',
'KRAO' => 'Корякский авт.окр.',
'KOSO' => 'Костромская область',
'KRSO' => 'Краснодарский край',
'KRNO' => 'Красноярский край',
'KRYM' => 'Крым Республика',
'KURGO' => 'Курганская область',
'KURO' => 'Курская область',
'LENO' => 'Ленинградская область',
'LPO' => 'Липецкая область',
'MAGO' => 'Магаданская область',
'MER' => 'Марий Эл республика',
'MOR' => 'Мордовия республика',
'MSKO' => 'Московская область',
'MURO' => 'Мурманская область',
'NAO' => 'Ненецкий авт.окр.',
'NZHO' => 'Нижегородская область',
'NVGO' => 'Новгородская область',
'NVO' => 'Новосибирская область',
'OMO' => 'Омская область',
'OPENO' => 'Оренбургская область',
'OPLO' => 'Орловская область',
'PENO' => 'Пензенская область',
'PERO' => 'Пермский край',
'PRO' => 'Приморский край',
'PSO' => 'Псковская область',
'RSO' => 'Ростовская область',
'RZO' => 'Рязанская область',
'SMRO' => 'Самарская область',
'SRP' => 'Саратовская область',
'SYAR' => 'Саха(Якутия) республика',
'SKHO' => 'Сахалинская область',
'SVO' => 'Свердловская область',
'SOAR' => 'Северная Осетия - Алания республика',
'SMO' => 'Смоленская область',
'STK' => 'Ставропольский край',
'TRAO' => 'Таймырский (Долгано-Ненецкий) авт. окр.',
'TMBO' => 'Тамбовская область',
'TTR' => 'Татарстан республика',
'TVO' => 'Тверская область',
'TMO' => 'Томская область',
'TVR' => 'Тыва республика',
'TULO' => 'Тульская область',
'TUMO' => 'Тюменская область',
'UDO' => 'Удмуртская республика',
'ULO' => 'Ульяновская область',
'UOBAO' => 'Усть-Ордынский Бурятский авт.окр.',
'KHBK' => 'Хабаровский край',
'KHKR' => 'Хакасия республика',
'KHMAO' => 'Ханты-Мансийский авт.окр.',
'CHLO' => 'Челябинская область',
'CHCHR' => 'Чеченская республика',
'CHTO' => 'Читинская область',
'CHVR' => 'Чувашская республика',
'CHKAO' => 'Чукотский авт.окр.',
'EVAO' => 'Эвенкийский авт.окр.',
'YANO' => 'Ямало-Ненецкий авт.окр.',
'YAO' => 'Ярославская область'

);

return $states;
}


