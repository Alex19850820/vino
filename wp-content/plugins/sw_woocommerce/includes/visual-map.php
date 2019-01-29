<?php 
add_action( 'vc_before_init', 'Sw_shortcodeVC' );
vc_add_shortcode_param( 'my_param', 'my_param_settings_field' );
function my_param_settings_field( $settings, $value ) {
    $output = '';
    $values = explode( ',', $value );
	$output .= '<select name="'
	           . $settings['param_name']
	           . '" class="wpb_vc_param_value wpb-input wpb-select '
	           . $settings['param_name']
	           . ' ' . $settings['type']
	           . '" multiple="multiple">';
	if ( is_array( $value ) ) {
		$value = isset( $value['value'] ) ? $value['value'] : array_shift( $value );
	}
	if ( ! empty( $settings['value'] ) ) {
		foreach ( $settings['value'] as $index => $data ) {
			if ( is_numeric( $index ) && ( is_string( $data ) || is_numeric( $data ) ) ) {
				$option_label = $data;
				$option_value = $data;
			} elseif ( is_numeric( $index ) && is_array( $data ) ) {
				$option_label = isset( $data['label'] ) ? $data['label'] : array_pop( $data );
				$option_value = isset( $data['value'] ) ? $data['value'] : array_pop( $data );
			} else {
				$option_value = $data;
				$option_label = $index;
			}
			$selected = '';
	 		$option_value_string = (string) $option_value;
	 		$value_string = (string) $value;
	 		$selected = (is_array($values) && in_array($option_value, $values))?' selected="selected"':'';
			$option_class = str_replace( '#', 'hash-', $option_value );
			$output .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '"' . $selected . '>'
			           . htmlspecialchars( $option_label ) . '</option>';
		}
	}
	$output .= '</select>';

	return $output;
}
vc_add_shortcode_param( 'date', 'sw_date_vc_setting' );

function sw_date_vc_setting( $settings, $value ) {
	return '<div class="vc_date_block">'
		 .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
		 esc_attr( $settings['param_name'] ) . ' ' .
		 esc_attr( $settings['type'] ) . '_field" type="date" value="' . esc_attr( $value ) . '" placeholder="dd-mm-yyyy"/>' .
		'</div>'; 
}

function Sw_shortcodeVC(){
	
	$args = array(
		'type' => 'post',
		'child_of' => 0,
		'parent' => 0,
		'orderby' => 'name',
		'order' => 'ASC',
		'hide_empty' => false,
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'number' => '',
		'taxonomy' => 'product_cat',
		'pad_counts' => false,

	);

	$product_categories_dropdown = array( __( 'Select Categories Products', 'sw_woocommerce' ) => '' );
	$categories = get_categories( $args );
	foreach($categories as $category){
		$product_categories_dropdown[$category->name] = $category -> slug;
	}

	$product_categories_dropdown_id = array( __( 'Select Categories Products', 'sw_woocommerce' ) => '' );
	$categories_id = get_categories( $args );
	foreach($categories_id as $category_id){
		$product_categories_dropdown_id[$category_id->name] = $category_id -> term_id;
	}

/***********************************
*Accordion Recommend Product
************************************/
vc_map( array(
	'name' => __( 'Accordion Recommend Product', 'sw_woocommerce' ),
	'base' => 'accordion_recommend_product',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'sw_woocommerce' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display accordion recommend product', 'sw_woocommerce' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'sw_woocommerce' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_woocommerce' )
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Product Title Length", 'sw_woocommerce' ),
			"param_name" => "title_length",
			"admin_label" => true,
			"value" => 0,
			"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of product to show', 'sw_woocommerce' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'sw_woocommerce' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'sw_woocommerce' ) => 'DESC',
				__( 'Ascending', 'sw_woocommerce' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'sw_woocommerce' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'sw_woocommerce' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'sw_woocommerce' ) => 'date',
				__( 'ID', 'sw_woocommerce' ) => 'ID',
				__( 'Author', 'sw_woocommerce' ) => 'author',
				__( 'Title', 'sw_woocommerce' ) => 'title',
				__( 'Modified', 'sw_woocommerce' ) => 'modified',
				__( 'Random', 'sw_woocommerce' ) => 'rand',
				__( 'Comment count', 'sw_woocommerce' ) => 'comment_count',
				__( 'Menu order', 'sw_woocommerce' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'sw_woocommerce' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_woocommerce' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
		),	
	)
) );
/***********************************
*Recommend Product
************************************/
vc_map( array(
	'name' => __( 'Recommend Product', 'sw_woocommerce' ),
	'base' => 'recommend_products',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'sw_woocommerce' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display recommend product', 'sw_woocommerce' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'sw_woocommerce' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_woocommerce' )
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Product Title Length", 'sw_woocommerce' ),
			"param_name" => "title_length",
			"admin_label" => true,
			"value" => 0,
			"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' )
		),
		array(
			'param_name'    => 'category_id',
			'type'          => 'dropdown',
			'value'         => $product_categories_dropdown, // here I'm stuck
			'heading'       => __('Category filter:', 'overmax'),
			'description'   => '',
			'holder'        => 'div',
			'class'         => ''
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of product to show', 'sw_woocommerce' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of colums to show', 'sw_woocommerce' ),
			'param_name' => 'columns',
			'admin_label' => true
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'sw_woocommerce' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'sw_woocommerce' ) => 'DESC',
				__( 'Ascending', 'sw_woocommerce' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'sw_woocommerce' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'sw_woocommerce' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'sw_woocommerce' ) => 'date',
				__( 'ID', 'sw_woocommerce' ) => 'ID',
				__( 'Author', 'sw_woocommerce' ) => 'author',
				__( 'Title', 'sw_woocommerce' ) => 'title',
				__( 'Modified', 'sw_woocommerce' ) => 'modified',
				__( 'Random', 'sw_woocommerce' ) => 'rand',
				__( 'Comment count', 'sw_woocommerce' ) => 'comment_count',
				__( 'Menu order', 'sw_woocommerce' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'sw_woocommerce' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_woocommerce' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
		),	
	)
) );
/***********************************
*Product Tags
************************************/
vc_map( array(
    'name' => 'WooCommerce product tags',
	'base' => 'vc_woo_tags',
	'icon' => 'icon-wpb-woocommerce',
	'category' => __( 'WooCommerce', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Your most used product tags in cloud format.', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' ),
			'value' => '',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
		),
	),
    )
);
/***********************************
*Toprate Product
************************************/
vc_map( array(
	'name' => __( 'Toprate Product', 'sw_woocommerce' ),
	'base' => 'toprate',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'sw_woocommerce' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display toprate product', 'sw_woocommerce' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'sw_woocommerce' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_woocommerce' )
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Product Title Length", 'sw_woocommerce' ),
			"param_name" => "title_length",
			"admin_label" => true,
			"value" => 0,
			"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' )
		),
		array(
			'param_name'    => 'category_id',
			'type'          => 'dropdown',
			'value'         => $product_categories_dropdown, // here I'm stuck
			'heading'       => __('Category filter:', 'overmax'),
			'description'   => '',
			'holder'        => 'div',
			'class'         => ''
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of product to show', 'sw_woocommerce' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of colums to show', 'sw_woocommerce' ),
			'param_name' => 'columns',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_woocommerce' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
		),	
	)
) );
/***********************************
*  Pages Categories
************************************/
vc_map( array(
	'name' => __( 'Pages Categories', 'sw_woocommerce' ),
	'base' => 'page-cate',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'sw_woocommerce' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display Pages Categories', 'sw_woocommerce' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'sw_woocommerce' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_woocommerce' )
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Category", "sw_woocommerce" ),
			"param_name" => "categories_id",
			"value" => $product_categories_dropdown_id,
			"description" => __( "Select Categories", "sw_woocommerce" )
		 ),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_woocommerce' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
		),	
	)
) );
vc_map( array(
	'name' => __( 'Sw Banner Countdown', 'sw_woocommerce' ),
	'base' => 'banner_countdown',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'My shortcodes', 'sw_woocommerce' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display Banner Countdown', 'sw_woocommerce' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'sw_woocommerce' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_woocommerce' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_woocommerce' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
		),
		array(
			'type' => 'textarea',
			'heading' => __( 'Description', 'sw_woocommerce' ),
			'param_name' => 'description',
			'description' => __( 'Description', 'sw_woocommerce' )
		),
		array(
			'type' => 'attach_images',
			'heading' => __( 'Banner Images', 'sw_woocommerce' ),
			'param_name' => 'images',
			'description' => __( 'Select images', 'sw_woocommerce' )
		),
		array(
			'type' => 'date',
			'heading' => __( 'Countdown Date', 'sw_woocommerce' ),
			'param_name' => 'date',
			'description' => __( 'Countdown Date', 'sw_woocommerce' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Link for banner', 'sw_woocommerce' ),
			'param_name' => 'url',
			'description' => __( 'Each URL separated by commas', 'sw_woocommerce' )
		),
	)
) );
}
?>