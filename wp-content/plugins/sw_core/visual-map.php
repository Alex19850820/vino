<?php 
add_action( 'vc_before_init', 'my_shortcodeVC' );

function my_shortcodeVC(){
$target_arr = array(
	__( 'Same window', 'sw_core' ) => '_self',
	__( 'New window', 'sw_core' ) => "_blank"
);
$ya_link_category = array( __( 'All Categories', 'sw_core' ) => '' );
$ya_link_cats     = get_categories();
if ( is_array( $ya_link_cats ) ) {
	foreach ( $ya_link_cats as $link_cat ) {
		$ya_link_category[ $link_cat->name ] = $link_cat->slug;
	}
}		

$menu_locations_array = array( __( 'Select A Menu', 'sw_core' ) => '' );
$menu_locations = wp_get_nav_menus();	
foreach ($menu_locations as $menu_location){
	$menu_locations_array[$menu_location->name] = $menu_location -> slug;
}

/* YTC VC */
//YTC post
vc_map( array(
	'name' => 'Ya_' . __( 'POSTS', 'sw_core' ),
	'base' => 'ya_post',
    'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'sw_core' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display posts-seclect category', 'sw_core' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'sw_core' ),
			'param_name' => 'title',
			'description' => __( 'Select style for widget title. Leave blank to use default widget title.', 'sw_core' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Layout post style', 'sw_core' ),
			'param_name' => 'type',
			'value' => array(
				'Select type',
				__( 'The blog', 'sw_core' ) => 'the_blog',
				__( 'Latest Blog', 'sw_core' ) => 'latest_blog',
				__('Indicators','sw_core')  =>'indicators',
				__( '2 column', 'sw_core' ) => '2_column',
				__( 'Slideshow', 'sw_core' ) => 'slide_show',
				__( 'Middle right', 'sw_core' ) => 'middle_right',
				__( 'Blog style 2', 'sw_core' ) => 'blog_style2',
			),
			'description' => sprintf( __( 'Select different style posts.', 'sw_core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'param_name'    => 'category_id',
			'type'          => 'dropdown',
			'value'         => $ya_link_category, // here I'm stuck
			'heading'       => __('Category filter:', 'overmax'),
			'description'   => '',
			'holder'        => 'div',
			'class'         => ''
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'sw_core' ),
			'param_name' => 'number',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Excerpt length (in words)', 'sw_core' ),
			'param_name' => 'length',
			'description' => __( 'Excerpt length (in words).', 'sw_core' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_core' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_core' )
		),
			

		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'sw_core' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'sw_core' ) => 'DESC',
				__( 'Ascending', 'sw_core' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'sw_core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'sw_core' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'sw_core' ) => 'date',
				__( 'ID', 'sw_core' ) => 'ID',
				__( 'Author', 'sw_core' ) => 'author',
				__( 'Title', 'sw_core' ) => 'title',
				__( 'Modified', 'sw_core' ) => 'modified',
				__( 'Random', 'sw_core' ) => 'rand',
				__( 'Comment count', 'sw_core' ) => 'comment_count',
				__( 'Menu order', 'sw_core' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'sw_core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
			
	)
) );

// ytc tesminial

vc_map( array(
	'name' => 'Ya_ ' . __( 'Testimonial Slide', 'sw_core' ),
	'base' => 'testimonial_slide',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'sw_core' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'The tesminial on your site', 'sw_core' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'sw_core' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_core' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'sw_core' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Excerpt length (in words)', 'sw_core' ),
			'param_name' => 'length',
			'description' => __( 'Excerpt length (in words).', 'sw_core' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'sw_core' ),
			'param_name' => 'type',
			'value' => array(
			    __('Indicators Up','sw_core') => 'indicators_up',
				__( 'indicators', 'sw_core' ) => 'indicators',
				__( 'Slide Style 1', 'sw_core' ) => 'style1',
				__('Slide Style 2','sw_core') => 'style2',
			),
			'description' => sprintf( __( 'Chose template for testimonial', 'sw_core' ) )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'sw_core' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'sw_core' ) => 'DESC',
				__( 'Ascending', 'sw_core' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'sw_core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'sw_core' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'sw_core' ) => 'date',
				__( 'ID', 'sw_core' ) => 'ID',
				__( 'Author', 'sw_core' ) => 'author',
				__( 'Title', 'sw_core' ) => 'title',
				__( 'Modified', 'sw_core' ) => 'modified',
				__( 'Random', 'sw_core' ) => 'rand',
				__( 'Comment count', 'sw_core' ) => 'comment_count',
				__( 'Menu order', 'sw_core' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'sw_core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns >1200px: ", 'sw_core' ),
				"param_name" => "columns",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns >1200px:", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 992px to 1199px:", 'sw_core' ),
				"param_name" => "columns1",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 992px to 1199px:", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 768px to 991px:", 'sw_core' ),
				"param_name" => "columns2",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 768px to 991px:", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 480px to 767px:", 'sw_core' ),
				"param_name" => "columns3",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 480px to 767px:", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns in 480px or less than:", 'sw_core' ),
				"param_name" => "columns4",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns in 480px or less than:", 'sw_core' )
			 ),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_core' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_core' )
		)
	)
) );

//// vertical mega menu
vc_map( array(
	'name' => 'Ya' . __( 'vertical mega menu', 'sw_core' ),
	'base' => 'ya_mega_menu',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'sw_core' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display vertical mega menu', 'sw_core' ),
	'params' => array(
	    array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'sw_core' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_core' )
		),
	    array(
			'param_name'    => 'menu_locate',
			'type'          => 'dropdown',
			'value'         => $menu_locations_array, // here I'm stuck
			'heading'       => __('Category menu:', 'overmax'),
			'description'   => '',
			'holder'        => 'div',
			'class'         => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Theme shortcode want display', 'sw_core' ),
			'param_name' => 'widget_template',
			'value' => array(
				__( 'default', 'sw_core' ) => 'default',
			),
			'description' => sprintf( __( 'Select different style menu.', 'sw_core' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_core' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_core' )
		),			
	)
));

}
?>