<?php defined( 'ABSPATH' ) OR exit;
/*
Plugin Name: Yml for Yandex Market Pro
Description: Расширение для плагина Yml for Yandex Market!
Tags: yml, importer, data, yandex, market, export, woocommerce, yandex market
Author: Maxim Glazunov
Author URI: https://icopydoc.ru
License: GPLv2
Version: 1.0.7
Text Domain: yml-for-yandex-market-pro
Domain Path: /languages/
*/
/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : djdiplomat@yandex.ru)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
register_activation_hook(__FILE__, array('YmlforYandexMarketPro', 'on_activation'));
register_deactivation_hook(__FILE__, array('YmlforYandexMarketPro', 'on_deactivation'));
register_uninstall_hook(__FILE__, array('YmlforYandexMarketPro', 'on_uninstall'));
add_action('plugins_loaded', array('YmlforYandexMarketPro', 'init'));
add_action('plugins_loaded', 'yfymp_load_plugin_textdomain'); // load translation
function yfymp_load_plugin_textdomain() {
 load_plugin_textdomain('yfymp', false, dirname(plugin_basename(__FILE__)).'/languages/');
}
class YmlforYandexMarketPro {
 protected static $instance;
 public static function init() {
	is_null( self::$instance ) AND self::$instance = new self;
	return self::$instance;
 }
	
 public function __construct() {
	// yfymp_DIR contains /home/p135/www/site.ru/wp-content/plugins/myplagin/
	define('yfymp_DIR', plugin_dir_path(__FILE__)); 
	// yfymp_URL contains http://site.ru/wp-content/plugins/myplagin/
	define('yfymp_URL', plugin_dir_url(__FILE__));	
	add_action('admin_notices', array($this, 'yfymp_admin_notices_function'));
	
	add_action('yfym_step_export_option', array($this, 'yfymp_function_step_export'));
	add_action('yfym_after_step_export', array($this, 'yfymp_function_after_step_export'));
	add_action('yfym_after_manufacturer_warranty', array($this, 'yfymp_after_manufacturer_warranty'));	
	add_action('yfym_prepend_submit_action', array($this, 'yfymp_prepend_submit_action'));
	
	add_filter('yfym_query_arg_filter', array($this,'yfymp_query_arg_filter_func'), 10, 1);
	add_filter('yfym_append_simple_offer_filter', array($this,'yfymp_append_simple_offer_filter_func'), 10, 2);
	add_filter('yfym_append_variable_offer_filter', array($this,'yfymp_append_variable_offer_filter_func'), 10, 3);	
	
	add_filter('yfym_pic_simple_offer_filter', array($this,'yfymp_pic_simple_offer_filter_func'), 10, 2);
	add_filter('yfym_pic_variable_offer_filter', array($this,'yfymp_pic_simple_offer_filter_func'), 10, 2);
	
	add_filter('yfym_append_categories_filter', array($this,'yfymp_append_categories_filter_func'), 10, 1);	
	add_filter('yfym_after_cat_filter', array($this,'yfymp_after_cat_filter_func'), 10, 2);
 }
 
 // Срабатывает при активации плагина (вызывается единожды)
 public static function on_activation() {  	
	global $wpdb;
	if (is_multisite()) {
		add_blog_option(get_current_blog_id(), 'yfymp_version', '1.0.7');
		add_blog_option(get_current_blog_id(), 'yfymp_min_version_yfym', '1.2.7');
		add_blog_option(get_current_blog_id(), 'yfymp_exclude_cat_arr', '');
		add_blog_option(get_current_blog_id(), 'yfymp_tags_as_cat', '');
		add_blog_option(get_current_blog_id(), 'yfymp_num_pic', '3');
		add_blog_option(get_current_blog_id(), 'yfymp_excl_thumb', 'no');		
		add_blog_option(get_current_blog_id(), 'yfymp_sizes', 'off');
		add_blog_option(get_current_blog_id(), 'yfymp_size_chart', 'RU');
		add_blog_option(get_current_blog_id(), 'yfymp_size_chart_from', '');
		add_blog_option(get_current_blog_id(), 'yfymp_sizes2', 'off');
		add_blog_option(get_current_blog_id(), 'yfymp_size_chart2', 'RU');
		add_blog_option(get_current_blog_id(), 'yfymp_size_chart_from2', '');
		add_blog_option(get_current_blog_id(), 'yfymp_do', 'exclude');
	} else {
		add_option('yfymp_version', '1.0.7');
		add_option('yfymp_min_version_yfym', '1.2.7');
		add_option('yfymp_exclude_cat_arr', '');
		add_option('yfymp_tags_as_cat', '');
		add_option('yfymp_num_pic', '3');
		add_option('yfymp_excl_thumb', 'no');
		add_option('yfymp_sizes', 'off');
		add_option('yfymp_size_chart', 'RU');
		add_option('yfymp_size_chart_from', '');
		add_option('yfymp_sizes2', 'off');
		add_option('yfymp_size_chart2', 'RU');
		add_option('yfymp_size_chart_from2', '');
		add_option('yfymp_do', 'exclude');
	}
 }
 
 // Срабатывает при отключении плагина (вызывается единожды)
 public static function on_deactivation() {
	
 } 
 
 //Срабатывает при удалении плагина (вызывается единожды)
 public static function on_uninstall() {
	if (is_multisite()) {
		delete_blog_option(get_current_blog_id(), 'yfymp_version');
		delete_blog_option(get_current_blog_id(), 'yfymp_min_version_yfym');
		delete_blog_option(get_current_blog_id(), 'yfymp_exclude_cat_arr');
		delete_blog_option(get_current_blog_id(), 'yfymp_tags_as_cat');
		delete_blog_option(get_current_blog_id(), 'yfymp_num_pic');
		delete_blog_option(get_current_blog_id(), 'yfymp_excl_thumb');
		delete_blog_option(get_current_blog_id(), 'yfymp_sizes');
		delete_blog_option(get_current_blog_id(), 'yfymp_size_chart');
		delete_blog_option(get_current_blog_id(), 'yfymp_size_chart_from');
		delete_blog_option(get_current_blog_id(), 'yfymp_sizes2');
		delete_blog_option(get_current_blog_id(), 'yfymp_size_chart2');
		delete_blog_option(get_current_blog_id(), 'yfymp_size_chart_from2');
		delete_blog_option(get_current_blog_id(), 'yfymp_do');
	} else {
		delete_option('yfymp_version');
		delete_option('yfymp_min_version_yfym');
		delete_option('yfymp_exclude_cat_arr');
		delete_option('yfymp_tags_as_cat');
		delete_option('yfymp_num_pic');
		delete_option('yfymp_excl_thumb');
		delete_option('yfymp_sizes');
		delete_option('yfymp_size_chart');
		delete_option('yfymp_size_chart_from');
		delete_option('yfymp_sizes2');
		delete_option('yfymp_size_chart2');
		delete_option('yfymp_size_chart_from2');
		delete_option('yfymp_do');
	}
 }
 
 public function yfymp_admin_notices_function() {
	if (is_plugin_active('yml-for-yandex-market/yml-for-yandex-market.php')) {
		// Плагин Yml for Yandex Market активен. Все ок.
	} else {
		print '<div class="notice error is-dismissible"><p>'. __('Yml for Yandex Market is not active', 'yfymp'). '!</p></div>';
	}
 }  
 public function yfymp_query_arg_filter_func($args) {
	if (is_multisite()) {
		$params_arr = unserialize(get_blog_option(get_current_blog_id(), 'yfymp_exclude_cat_arr'));		
		$yfymp_do = get_blog_option(get_current_blog_id(), 'yfymp_do');
	} else {	
		$params_arr = unserialize(get_option('yfymp_exclude_cat_arr'));
		$yfymp_do = get_option('yfymp_do');
	}
	if (empty($params_arr)) {return $args;}		
	if ($yfymp_do == 'include') {
	 $args['tax_query'] = array('relation' => 'OR',
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $params_arr,
			'operator' => 'IN',
		),
		array(
			'taxonomy' => 'product_tag',
			'field'    => 'id',
			'terms'    => $params_arr,
			'operator' => 'IN',
		)
	 );	
	} else {
	 $args['tax_query'] = array('relation' => 'AND',
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $params_arr,
			'operator' => 'NOT IN',
		),
		array(
			'taxonomy' => 'product_tag',
			'field'    => 'id',
			'terms'    => $params_arr,
			'operator' => 'NOT IN',
		)
	 );
	}
	return $args;
 }

 public function yfymp_append_simple_offer_filter_func($result_yml, $product) {
	if (is_multisite()) { 
	 $sizes = get_blog_option(get_current_blog_id(), 'yfymp_sizes');
	 $size_chart = get_blog_option(get_current_blog_id(), 'yfymp_size_chart');
	 $size_chart_from = get_blog_option(get_current_blog_id(), 'yfymp_size_chart_from');
	 
 	 $sizes2 = get_blog_option(get_current_blog_id(), 'yfymp_sizes2');
	 $size_chart2 = get_blog_option(get_current_blog_id(), 'yfymp_size_chart2');
	 $size_chart_from2 = get_blog_option(get_current_blog_id(), 'yfymp_size_chart_from2');

	} else {
	 $sizes = get_option('yfymp_sizes'); 
	 $size_chart = get_option('yfymp_size_chart');
	 $size_chart_from = get_option('yfymp_size_chart_from');
	 
	 $sizes2 = get_option('yfymp_sizes2'); 
	 $size_chart2 = get_option('yfymp_size_chart2');
	 $size_chart_from2 = get_option('yfymp_size_chart_from2');
	}	 
	if ($sizes !== 'off') {
	 $sizes_yml = $product->get_attribute(wc_attribute_taxonomy_name_by_id($sizes));
	 if (!empty($sizes_yml)) {	
		if ($sizes_chart_from !== 'off') {	
			$sizes_chart_yml = $product->get_attribute(wc_attribute_taxonomy_name_by_id($size_chart_from));
			if (!empty($sizes_chart_yml)) {
				$result_yml .= '<param name="Размер" unit="'.$sizes_chart_yml.'">'.$sizes_yml.'</param>'.PHP_EOL;
			} else {
				$result_yml .= '<param name="Размер" unit="'.$size_chart.'">'.$sizes_yml.'</param>'.PHP_EOL;	
			}			
		} else {
			$result_yml .= '<param name="Размер" unit="'.$size_chart.'">'.$sizes_yml.'</param>'.PHP_EOL;
		}
	 }
	}	
	
	if ($sizes2 !== 'off') {
	 $sizes_yml2 = $product->get_attribute(wc_attribute_taxonomy_name_by_id($sizes2));
	 if (!empty($sizes_yml2)) {	
		if ($sizes_chart_from2 !== 'off') {	
			$sizes_chart_yml2 = $product->get_attribute(wc_attribute_taxonomy_name_by_id($size_chart_from2));
			if (!empty($sizes_chart_yml)) {
				$result_yml .= '<param name="Размер" unit="'.$sizes_chart_yml2.'">'.$sizes_yml2.'</param>'.PHP_EOL;
			} else {
				$result_yml .= '<param name="Размер" unit="'.$size_chart2.'">'.$sizes_yml2.'</param>'.PHP_EOL;	
			}			
		} else {
			$result_yml .= '<param name="Размер" unit="'.$size_chart2.'">'.$sizes_yml2.'</param>'.PHP_EOL;
		}
	 }
	}
	
	return $result_yml;
 }
 
 public function yfymp_pic_simple_offer_filter_func($picture_yml, $product) {
	
	if (is_multisite()) { 
	 $num_pic = get_blog_option(get_current_blog_id(), 'yfymp_num_pic');
	 $excl_thumb = get_blog_option(get_current_blog_id(), 'yfymp_excl_thumb');
	} else {
	 $num_pic = get_option('yfymp_num_pic'); 
	 $excl_thumb = get_option('yfymp_excl_thumb'); 
	}
	/* если запре на выгрузку миниатюры - очистим picture_yml */
	if ($excl_thumb == 'on') {$picture_yml = '';}
	error_log('excl_thumb = '.$excl_thumb, 0);
	$attachment_ids = $product->get_gallery_attachment_ids();
	$i = 1;
	foreach($attachment_ids as $attachment_id) {
	 //if ($thumb_id == $attachment_id) {continue;}
	 $pic_gal = wp_get_attachment_image_src($attachment_id, 'full', true);
	 $pic_gal_url = $pic_gal[0]; /* урл оригинала картинки в галерее товара */			
	 $picture_yml .= '<picture>'.deleteGET($pic_gal_url).'</picture>'.PHP_EOL;
	 if ($i == $num_pic) {break;}
	 $i++; 
	}
	
	return $picture_yml; 
 }
 
 public function yfymp_append_variable_offer_filter_func($result_yml, $product, $offer) {
	if (is_multisite()) { 
	 $sizes = get_blog_option(get_current_blog_id(), 'yfymp_sizes');
	 $size_chart = get_blog_option(get_current_blog_id(), 'yfymp_size_chart');
	 $size_chart_from = get_blog_option(get_current_blog_id(), 'yfymp_size_chart_from');
	 
	 $sizes2 = get_blog_option(get_current_blog_id(), 'yfymp_sizes2');
	 $size_chart2 = get_blog_option(get_current_blog_id(), 'yfymp_size_chart2');
	 $size_chart_from2 = get_blog_option(get_current_blog_id(), 'yfymp_size_chart_from2');
	} else {
	 $sizes = get_option('yfymp_sizes'); 
	 $size_chart = get_option('yfymp_size_chart');
	 $size_chart_from = get_option('yfymp_size_chart_from');
	 
	 $sizes2 = get_option('yfymp_sizes2'); 
	 $size_chart2 = get_option('yfymp_size_chart2');
	 $size_chart_from2 = get_option('yfymp_size_chart_from2');
	}	 
	if ($sizes !== 'off') {
	 $sizes_yml = $offer->get_attribute(wc_attribute_taxonomy_name_by_id($sizes));
	 if (!empty($sizes_yml)) {	
		if ($sizes_chart_from !== 'off') {	
			$sizes_chart_yml = $product->get_attribute(wc_attribute_taxonomy_name_by_id($size_chart_from));
			if (!empty($sizes_chart_yml)) {
				$result_yml .= '<param name="Размер" unit="'.$sizes_chart_yml.'">'.$sizes_yml.'</param>'.PHP_EOL;
			} else {
				$result_yml .= '<param name="Размер" unit="'.$size_chart.'">'.$sizes_yml.'</param>'.PHP_EOL;	
			}			
		} else {
			$result_yml .= '<param name="Размер" unit="'.$size_chart.'">'.$sizes_yml.'</param>'.PHP_EOL;
		}
	 }
	}
	
	if ($sizes2 !== 'off') {
	 $sizes_yml2 = $offer->get_attribute(wc_attribute_taxonomy_name_by_id($sizes2));
	 if (!empty($sizes_yml2)) {	
		if ($sizes_chart_from2 !== 'off') {	
			$sizes_chart_yml2 = $product->get_attribute(wc_attribute_taxonomy_name_by_id($size_chart_from2));
			if (!empty($sizes_chart_yml2)) {
				$result_yml .= '<param name="Размер" unit="'.$sizes_chart_yml2.'">'.$sizes_yml2.'</param>'.PHP_EOL;
			} else {
				$result_yml .= '<param name="Размер" unit="'.$size_chart2.'">'.$sizes_yml2.'</param>'.PHP_EOL;	
			}			
		} else {
			$result_yml .= '<param name="Размер" unit="'.$size_chart2.'">'.$sizes_yml2.'</param>'.PHP_EOL;
		}
	 }
	}
	return $result_yml;
 }
 
 public function yfymp_append_categories_filter_func($result_yml) {
	if (is_multisite()) { 
	 $yfymp_tags_as_cat = get_blog_option(get_current_blog_id(), 'yfymp_tags_as_cat');
	} else {
	 $yfymp_tags_as_cat = get_option('yfymp_tags_as_cat');	 
	} 
	if ($yfymp_tags_as_cat == 'on') {
	 /* метоки в качестве категорий */
	 $args = array(
		'taxonomy' => 'product_tag',
		'hide_empty' => true, // скроем метки-таксономии без тегов
	 );
	 $terms_product_tag = get_terms($args);
	 if ($terms_product_tag && ! is_wp_error($terms_product_tag) ){	
		foreach($terms_product_tag as $term ) {
			$result_yml .= '<category id="'.$term->term_id.'"'.'>'.$term->name.'</category>'.PHP_EOL;
		}			
	 }
	}
	return $result_yml;
 }
 
 public function yfymp_after_cat_filter_func($result_yml_cat, $postId) {
	if (is_multisite()) { 
	 $yfymp_tags_as_cat = get_blog_option(get_current_blog_id(), 'yfymp_tags_as_cat');
	} else {
	 $yfymp_tags_as_cat = get_option('yfymp_tags_as_cat');	 
	} 
	if ($yfymp_tags_as_cat == 'on') {
	 // если категорий у товара нет пробуем подставить метку
	 if ($result_yml_cat == '') {
		// если категорий нет, но есть метки
		$product_tags = get_the_terms($postId, 'product_tag');
		foreach($product_tags as $termin) {
			$result_yml_cat .= '<categoryId>'.$termin->term_taxonomy_id.'</categoryId>'.PHP_EOL;
			break; // т.к. у товара может быть лишь 1 категория - выходим досрочно.
		}
	 }
	}
	return $result_yml_cat;
 }
 
 public function yfymp_function_step_export() { 
	if (is_multisite()) { 
		$yfym_step_export = get_blog_option(get_current_blog_id(), 'yfym_step_export');
	} else {
		$yfym_step_export = get_option('yfym_step_export');
	}
	?><option value="1500" <?php selected($yfym_step_export, '1500'); ?>>1500</option><?php
 }
 public function yfymp_function_after_step_export() {  
	if (is_multisite()) { 
	 $yfymp_do = get_blog_option(get_current_blog_id(), 'yfymp_do');
	 $params_arr = unserialize(get_blog_option(get_current_blog_id(), 'yfymp_exclude_cat_arr'));
	 $yfymp_tags_as_cat = get_blog_option(get_current_blog_id(), 'yfymp_tags_as_cat');
	 $yfymp_num_pic = get_blog_option(get_current_blog_id(), 'yfymp_num_pic');
	 $yfymp_excl_thumb = get_blog_option(get_current_blog_id(), 'yfymp_excl_thumb'); 
	} else {
	 $yfymp_do = get_option('yfymp_do');
	 $params_arr = unserialize(get_option('yfymp_exclude_cat_arr'));
	 $yfymp_tags_as_cat = get_option('yfymp_tags_as_cat');	
	 $yfymp_num_pic = get_option('yfymp_num_pic');
	 $yfymp_excl_thumb = get_option('yfymp_excl_thumb');
	} ?>
	 <tr>
		<th scope="row"><select name="yfymp_do"><option value="include" <?php selected($yfymp_do, 'include'); ?>><?php _e('Export only', 'yfymp'); ?></option><option value="exclude" <?php selected($yfymp_do, 'exclude'); ?>><?php _e('Exclude', 'yfymp'); ?></option></select><label for="yfymp_exclude_cat_arr"> <?php _e('products from these categories and tags', 'yfymp'); ?></th>
		<td class="overalldesc">				
		 <select style="width: 100%;" name="yfymp_exclude_cat_arr[]" size="8" multiple>
		  <optgroup label="<?php _e('Category', 'yfymp'); ?>">
		  <?php 		  
		  $args = array('taxonomy' => 'product_cat','hide_empty' => false,);
		  $terms = get_terms($args); $count = count($terms);
		  if ($count > 0) : foreach ($terms as $term) : $catid = $term->term_id; ?>
			<option value="<?php echo $catid; ?>"<?php if (!empty($params_arr)) { foreach ($params_arr as $value) {selected($value, $catid);}} ?>><?php $level = count(get_ancestors($catid, 'product_cat')); switch ($level) {case 1: echo '-'; break; case 2: echo '--'; break; case 3: echo '---'; break; case 4: echo '----'; break;} echo $term->name; ?></option>
		  <?php endforeach; endif; ?>
		  </optgroup>
		  <optgroup label="<?php _e('Tags', 'yfymp'); ?>">		  
		  <?php 		  
		  $args = array('taxonomy' => 'product_tag','hide_empty' => false,);
		  $terms = get_terms($args); $count = count($terms);
		  if ($count > 0) : foreach ($terms as $term) : $catid = $term->term_id; ?>
			<option value="<?php echo $catid; ?>"<?php if (!empty($params_arr)) { foreach ($params_arr as $value) {selected($value, $catid);}} ?>><?php echo $term->name; ?></option>
		  <?php endforeach; endif; ?>		  
		  </optgroup>
		 </select><br />
		 <span class="description"><?php /*_e('Products from these categories and tags are will not be add to the feed', 'yfymp');*/ ?></span>
		</td>
	 </tr>
	 <tr>
		<th scope="row"><label for="yfymp_tags_as_cat"><?php _e('Use tags as categories', 'yfymp'); ?></label></th>
		<td class="overalldesc">
			<input type="checkbox" name="yfymp_tags_as_cat" <?php checked($yfymp_tags_as_cat, 'on' ); ?>/><br />
			<span class="description"><?php _e('If the product does not have categories, the tags will be used as categories', 'yfymp'); ?></label>
		</td>
	 </tr>	
	 <tr>
		<th scope="row"><label for="yfymp_num_pic"><?php _e('Number of images', 'yfymp'); ?></label></th>
		<td class="overalldesc">
			<input min="0" max="9" type="number" name="yfymp_num_pic" value="<?php echo $yfymp_num_pic; ?>" /><br />
			<span class="description"><?php _e('The maximum number of images that will be displayed in the feed from the product gallery', 'yfymp'); ?> <strong><?php _e('Maximum 9', 'yfymp'); ?></strong></span>
		</td>
	 </tr>
	 <tr>
		<th scope="row"><label for="yfymp_excl_thumb"><?php _e('Do not unload the image of the main product', 'yfymp'); ?></label></th>
		<td class="overalldesc">
			<input type="checkbox" name="yfymp_excl_thumb" <?php checked($yfymp_excl_thumb, 'on' ); ?>/><br />
			<span class="description"><?php _e("The image specified as the product's main image will not be included in the feed", "yfymp"); ?></label>
		</td>
	 </tr>	 
	<?php
 } // end public function yfymp_function_after_step_export
 
 public function yfymp_after_manufacturer_warranty() {  
	if (is_multisite()) { 
	 $sizes = get_blog_option(get_current_blog_id(), 'yfymp_sizes');
	 $size_chart = get_blog_option(get_current_blog_id(), 'yfymp_size_chart');
	 $size_chart_from = get_blog_option(get_current_blog_id(), 'yfymp_size_chart_from');
	 
	 $sizes2 = get_blog_option(get_current_blog_id(), 'yfymp_sizes2');
	 $size_chart2 = get_blog_option(get_current_blog_id(), 'yfymp_size_chart2');
	 $size_chart_from2 = get_blog_option(get_current_blog_id(), 'yfymp_size_chart_from2');
	} else {
	 $sizes = get_option('yfymp_sizes'); 
	 $size_chart = get_option('yfymp_size_chart');
	 $size_chart_from = get_option('yfymp_size_chart_from');
	 
	 $sizes2 = get_option('yfymp_sizes2'); 
	 $size_chart2 = get_option('yfymp_size_chart2');
	 $size_chart_from2 = get_option('yfymp_size_chart_from2');
	} ?>
	 <tr>
		<th scope="row"><label for="yfymp_sizes"><?php _e('Sizes', 'yfymp'); ?></label></th>
		<td class="overalldesc">
		 <select name="yfymp_sizes">
		 <option value="off" <?php selected($sizes, 'none'); ?>><?php _e('None', 'yfymp'); ?></option>
		 <?php foreach (get_attributes() as $attribute) : ?>	
		 <option value="<?php echo $attribute['id']; ?>" <?php selected( $sizes, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>	
		 <?php endforeach; ?>
		 </select><br />
		 <?php _e('Required attribute', 'yfymp'); ?> <strong>unit</strong> <?php _e('substitute from', 'yfymp'); ?>:<br />
		 <select name="yfymp_size_chart_from">
		 <option value="off" <?php selected($sizes, 'none'); ?>><?php _e('None', 'yfymp'); ?></option>
		 <?php foreach (get_attributes() as $attribute) : ?>	
		 <option value="<?php echo $attribute['id']; ?>" <?php selected( $size_chart_from, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>	
		 <?php endforeach; ?>
		 </select><br />
		 <?php _e('In the absence of a substitute', 'yfymp'); ?>:<br />
		 <select name="yfymp_size_chart">
			<option value="AU" <?php selected($size_chart, 'AU'); ?>>AU</option>
			<option value="DE" <?php selected($size_chart, 'DE'); ?>>DE</option>
			<option value="EU" <?php selected($size_chart, 'EU'); ?>>EU</option>
			<option value="FR" <?php selected($size_chart, 'FR'); ?>>FR </option>
			<option value="Japan" <?php selected($size_chart, 'Japan'); ?>>Japan</option>
			<option value="INT" <?php selected($size_chart, 'INT'); ?>>INT</option>
			<option value="IT" <?php selected($size_chart, 'IT'); ?>>IT</option>
			<option value="RU" <?php selected($size_chart, 'RU'); ?>>RU</option>
			<option value="UK" <?php selected($size_chart, 'UK'); ?>>UK</option>
			<option value="US" <?php selected($size_chart, 'US'); ?>>US</option>
			<option value="INCH" <?php selected($size_chart, 'INCH'); ?>>INCH</option>
			<option value="Height" <?php selected($size_chart, 'Height'); ?>>Height</option>
			<option value="Months" <?php selected($size_chart, 'Months'); ?>>Months</option>
			<option value="Round" <?php selected($size_chart, 'Round'); ?>>Round</option>
			<option value="Years" <?php selected($size_chart, 'Years'); ?>>Years</option>
		 </select>
		 <span class="description"><?php _e('Optional element', 'yfymp'); ?> <strong>sizes</strong>. <?php _e('This element indicates the dimension grid', 'yfymp'); ?>.<br /><a href="//yandex.ru/support/partnermarket/guides/clothes.html#h4__sizes" target="_blank"><?php _e('A list of possible values', 'yfymp'); ?></a>.</span>
		</td>		
	</tr>	
	<tr>
		<th scope="row"><label for="yfymp_sizes2"><?php _e('Sizes', 'yfymp'); ?> 2</label><br />(<?php _e('In some cases you may need to specify 2 sizes for a single product', 'yfymp'); ?>) <a href="//yandex.ru/support/partnermarket/guides/clothes.html#h4__children" target="_blank"><?php _e('A list of possible values', 'yfymp'); ?></a></th>
		<td class="overalldesc">
		 <select name="yfymp_sizes2">
		 <option value="off" <?php selected($sizes2, 'none'); ?>><?php _e('None', 'yfymp'); ?></option>
		 <?php foreach (get_attributes() as $attribute) : ?>	
		 <option value="<?php echo $attribute['id']; ?>" <?php selected($sizes2, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>	
		 <?php endforeach; ?>
		 </select><br />
		 <?php _e('Required attribute', 'yfymp'); ?> <strong>unit</strong> <?php _e('substitute from', 'yfymp'); ?>:<br />
		 <select name="yfymp_size_chart_from2">
		 <option value="off" <?php selected($sizes2, 'none'); ?>><?php _e('None', 'yfymp'); ?></option>
		 <?php foreach (get_attributes() as $attribute) : ?>	
		 <option value="<?php echo $attribute['id']; ?>" <?php selected($size_chart_from2, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>	
		 <?php endforeach; ?>
		 </select><br />
		 <?php _e('In the absence of a substitute', 'yfymp'); ?>:<br />
		 <select name="yfymp_size_chart2">
			<option value="AU" <?php selected($size_chart2, 'AU'); ?>>AU</option>
			<option value="DE" <?php selected($size_chart2, 'DE'); ?>>DE</option>
			<option value="EU" <?php selected($size_chart2, 'EU'); ?>>EU</option>
			<option value="FR" <?php selected($size_chart2, 'FR'); ?>>FR </option>
			<option value="Japan" <?php selected($size_chart2, 'Japan'); ?>>Japan</option>
			<option value="INT" <?php selected($size_chart2, 'INT'); ?>>INT</option>
			<option value="IT" <?php selected($size_chart2, 'IT'); ?>>IT</option>
			<option value="RU" <?php selected($size_chart2, 'RU'); ?>>RU</option>
			<option value="UK" <?php selected($size_chart2, 'UK'); ?>>UK</option>
			<option value="US" <?php selected($size_chart2, 'US'); ?>>US</option>
			<option value="INCH" <?php selected($size_chart2, 'INCH'); ?>>INCH</option>
			<option value="Height" <?php selected($size_chart2, 'Height'); ?>>Height</option>
			<option value="Months" <?php selected($size_chart2, 'Months'); ?>>Months</option>
			<option value="Round" <?php selected($size_chart2, 'Round'); ?>>Round</option>
			<option value="Years" <?php selected($size_chart2, 'Years'); ?>>Years</option>
		 </select>
		 <span class="description"><?php _e('Optional element', 'yfymp'); ?> <strong>sizes</strong>. <?php _e('This element indicates the dimension grid', 'yfymp'); ?>.<br /><a href="//yandex.ru/support/partnermarket/guides/clothes.html#h4__sizes" target="_blank"><?php _e('A list of possible values', 'yfymp'); ?></a>.</span>
		</td>		
	</tr>
	<?php
 } // end public function yfymp_after_manufacturer_warranty 

 public function yfymp_prepend_submit_action() {
	if (is_multisite()) {
		if (isset($_POST['yfymp_do'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_do', sanitize_text_field($_POST['yfymp_do']));
		} else {
			update_blog_option(get_current_blog_id(), 'yfymp_do', 'exclude');
		}	
		if (isset($_POST['yfymp_exclude_cat_arr'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_exclude_cat_arr', serialize($_POST['yfymp_exclude_cat_arr']));
		} else {
			update_blog_option(get_current_blog_id(), 'yfymp_exclude_cat_arr', '');
		}
		if (isset($_POST['yfymp_tags_as_cat'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_tags_as_cat', $_POST['yfymp_tags_as_cat']);
		} else {
			update_blog_option(get_current_blog_id(), 'yfymp_tags_as_cat', '');
		}
		if (isset($_POST['yfymp_num_pic'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_num_pic', $_POST['yfymp_num_pic']);
		}
		if (isset($_POST['yfymp_excl_thumb'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_excl_thumb', $_POST['yfymp_excl_thumb']);
		} else {
			update_blog_option(get_current_blog_id(), 'yfymp_excl_thumb', '');
		}	 
		if (isset($_POST['yfymp_sizes'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_sizes', sanitize_text_field($_POST['yfymp_sizes']));
		} else {
			update_blog_option(get_current_blog_id(), 'yfymp_sizes', 'off');
		}
		if (isset($_POST['yfymp_size_chart'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_size_chart', sanitize_text_field($_POST['yfymp_size_chart']));
		}
		if (isset($_POST['yfymp_size_chart_from'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_size_chart_from', sanitize_text_field($_POST['yfymp_size_chart_from']));
		}	
		if (isset($_POST['yfymp_sizes2'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_sizes2', sanitize_text_field($_POST['yfymp_sizes2']));
		} else {
			update_blog_option(get_current_blog_id(), 'yfymp_sizes2', 'off');
		}
		if (isset($_POST['yfymp_size_chart2'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_size_chart2', sanitize_text_field($_POST['yfymp_size_chart2']));
		}
		if (isset($_POST['yfymp_size_chart_from2'])) {
			update_blog_option(get_current_blog_id(), 'yfymp_size_chart_from2', sanitize_text_field($_POST['yfymp_size_chart_from2']));
		}			
		
	} else {
		if (isset($_POST['yfymp_do'])) {
			update_option('yfymp_do', sanitize_text_field($_POST['yfymp_do']));
		} else {
			update_option('yfymp_do', 'exclude');
		}
		if (isset($_POST['yfymp_exclude_cat_arr'])) {
			update_option('yfymp_exclude_cat_arr', serialize($_POST['yfymp_exclude_cat_arr']));
		} else {
			update_option('yfymp_exclude_cat_arr', '');
		}
		if (isset($_POST['yfymp_tags_as_cat'])) {
			update_option('yfymp_tags_as_cat', $_POST['yfymp_tags_as_cat']);
		} else {
			update_option('yfymp_tags_as_cat', '');
		}
		if (isset($_POST['yfymp_num_pic'])) {
			update_option('yfymp_num_pic', $_POST['yfymp_num_pic']);
		}
		if (isset($_POST['yfymp_excl_thumb'])) {
			update_option('yfymp_excl_thumb', $_POST['yfymp_excl_thumb']);
		} else {
			update_option('yfymp_excl_thumb', '');
		}
		if (isset($_POST['yfymp_sizes'])) {
			update_option('yfymp_sizes', sanitize_text_field($_POST['yfymp_sizes']));
		} else {
			update_option('yfymp_sizes', 'off');
		}
		if (isset($_POST['yfymp_size_chart'])) {
			update_option('yfymp_size_chart', sanitize_text_field($_POST['yfymp_size_chart']));
		}
		if (isset($_POST['yfymp_size_chart_from'])) {
			update_option('yfymp_size_chart_from', sanitize_text_field($_POST['yfymp_size_chart_from']));
		}
		if (isset($_POST['yfymp_sizes2'])) {
			update_option('yfymp_sizes2', sanitize_text_field($_POST['yfymp_sizes2']));
		} else {
			update_option('yfymp_sizes2', 'off');
		}
		if (isset($_POST['yfymp_size_chart2'])) {
			update_option('yfymp_size_chart2', sanitize_text_field($_POST['yfymp_size_chart2']));
		}
		if (isset($_POST['yfymp_size_chart_from2'])) {
			update_option('yfymp_size_chart_from2', sanitize_text_field($_POST['yfymp_size_chart_from2']));
		}
	} 
 }
}
?>