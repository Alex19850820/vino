<?php
$lib_dir = trailingslashit( str_replace( '\\', '/', dirname(__FILE__) ) );
$lib_abs = trailingslashit( str_replace( '\\', '/', ABSPATH ) );

define('POST_EXCERPT_LENGTH', 40);

if( !defined('YA_DIR') ){
	define( 'YA_DIR', $lib_dir );
}

if( !defined('YA_URL') ){
	define( 'YA_URL', site_url( str_replace( $lib_abs, '', $lib_dir ) ) );
}
if( !defined('YA_OPTIONS_URL') ){
	define( 'YA_OPTIONS_URL', trailingslashit( get_template_directory_uri() ) . 'lib/options/' ); 
}

if( !defined( 'ICL_LANGUAGE_CODE' ) && !defined('YA_THEME') ){
 define( 'YA_THEME', 'shoppystore' );
}else{
 define( 'YA_THEME', 'shoppystore' . ICL_LANGUAGE_CODE );
}

defined('YA_THEME') or die;

if (!isset($content_width)) { $content_width = 940; }

define("PRODUCT_TYPE","product");
define("PRODUCT_DETAIL_TYPE","product_detail");

require_once( get_template_directory().'/lib/options.php' );
function ya_Options_Setup(){
	global $ya_options, $options, $options_args;

	$options = array();
	$options[] = array(
			'title' => esc_html__('General', 'shoppystore'),
			'desc' => wp_kses( __('<p class="description">The theme allows to build your own styles right out of the backend without any coding knowledge. Upload new logo and favicon or get their URL.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it ya for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_019_cogwheel.png',
			//Lets leave this as a ya section, no options just some intro text set above.
			'fields' => array(	
					
					array(
						'id' => 'sitelogo',
						'type' => 'upload',
						'title' => esc_html__('Logo Image', 'shoppystore'),
						'sub_desc' => esc_html__( 'Use the Upload button to upload the new logo and get URL of the logo', 'shoppystore' ),
						'std' => get_template_directory_uri().'/assets/img/logo-default.png'
					),
					
					array(
						'id' => 'favicon',
						'type' => 'upload',
						'title' => esc_html__('Favicon', 'shoppystore'),
						'sub_desc' => esc_html__( 'Use the Upload button to upload the custom favicon', 'shoppystore' ),
						'std' => ''
					),
					
					array(
						'id' => 'tax_select',
						'type' => 'multi_select_taxonomy',
						'title' => esc_html__('Select Taxonomy', 'shoppystore'),
						'sub_desc' => esc_html__( 'Select taxonomy to show custom term metabox', 'shoppystore' ),
					),	
					
					array(
					   'id' => 'page_404',
					   'type' => 'pages_select',
					   'title' => esc_html__('404 Page Content', 'shoppystore'),
					   'sub_desc' => esc_html__('Select page 404 content', 'shoppystore'),
					   'std' => ''
					),
			)		
		);
	
	$options[] = array(
			'title' => esc_html__('Schemes', 'shoppystore'),
			'desc' => wp_kses( __('<p class="description">Custom color scheme for theme. Unlimited color that you can choose.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it ya for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a ya section, no options just some intro text set above.
			'fields' => array(		
				array(
					'id' => 'scheme',
					'type' => 'radio_img',
					'title' => esc_html__('Color Scheme', 'shoppystore'),
					'sub_desc' => '',
					'desc' => '',
					'options' => array(
							'default' => array('title' => 'Default', 'img' => get_template_directory_uri().'/assets/img/default.png'),
								'blue' => array('title' => 'Blue', 'img' => get_template_directory_uri().'/assets/img/blue.png'),
								'blue-cyan' => array('title' => 'Blue Cyan', 'img' => get_template_directory_uri().'/assets/img/blue-cyan.png'),
									'blue-red' => array('title' => 'Blue Red', 'img' => get_template_directory_uri().'/assets/img/blue-red.png'), 
								'green' => array('title' => 'Green', 'img' => get_template_directory_uri().'/assets/img/green.png'),
								'green-cyan' => array('title' => 'Green Cyan', 'img' => get_template_directory_uri().'/assets/img/green-cyan.png'),
								'orange' => array('title' => 'Orange', 'img' => get_template_directory_uri().'/assets/img/orange.png'),
								'orange-cyan' => array('title' => 'Orange Cyan', 'img' => get_template_directory_uri().'/assets/img/orange-cyan.png'),
								'orange-cyan1' => array('title' => 'Orange Cyan 1', 'img' => get_template_directory_uri().'/assets/img/orange-cyan1.png'),
								'orange-cyan2' => array('title' => 'Orange Cyan 2', 'img' => get_template_directory_uri().'/assets/img/orange-cyan2.png'),
								'pink' => array('title' => 'Pink', 'img' => get_template_directory_uri().'/assets/img/pink.png'),
								'pink1' => array('title' => 'Pink 1', 'img' => get_template_directory_uri().'/assets/img/pink1.png'),
								'violet' => array('title' => 'Violet', 'img' => get_template_directory_uri().'/assets/img/violet.png'),
								'bordeaux' => array('title' => 'Bordeaux', 'img' => get_template_directory_uri().'/assets/img/bordeaux.png'),
								'yellow-cyan' => array('title' => 'Yellow cyan', 'img' => get_template_directory_uri().'/assets/img/yellow-cyan.png'),
								'yellow-cyan1' => array('title' => 'Yellow cyan 1', 'img' => get_template_directory_uri().'/assets/img/yellow-cyan1.png'),
						), //Must provide key => value(array:title|img) pairs for radio options
					'std' => 'default'
				),
				
				array(
					'id' => 'custom_color',
					'title' => esc_html__( 'Enable Custom Color', 'shoppystore' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this field to enable custom color and when you update your theme, custom color will not lose.', 'shoppystore' ),
					'desc' => '',
					'std' => '0'
				),
					
				array(
					'id' => 'developer_mode',
					'title' => esc_html__( 'Developer Mode', 'shoppystore' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Turn on/off compile less to css and custom color', 'shoppystore' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'include_css',
					'title' => esc_html__( 'Include Css', 'shoppystore' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Include all css from other homepage', 'shoppystore' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'scheme_color',
					'type' => 'color',
					'title' => esc_html__('Color', 'shoppystore'),
					'sub_desc' => esc_html__('Select main custom color. This custom runs when developer mode is activated.', 'shoppystore'),
					'std' => ''
				),
				
				array(
					'id' => 'scheme_body',
					'type' => 'color',
					'title' => esc_html__('Body Color', 'shoppystore'),
					'sub_desc' => esc_html__('Select main body custom color. This custom runs when developer mode is activated.', 'shoppystore'),
					'std' => ''
				)
			)
	);
	
	$options[] = array(
			'title' => esc_html__('Layout', 'shoppystore'),
			'desc' => wp_kses( __('<p class="description">SmartAddons Framework comes with a layout setting that allows you to build any number of stunning layouts and apply theme to your entries.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it ya for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_319_sort.png',
			//Lets leave this as a ya section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'layout',
						'type' => 'select',
						'title' => esc_html__('Box Layout', 'shoppystore'),
						'sub_desc' => esc_html__( 'Select Layout Box or Wide', 'shoppystore' ),
						'options' => array(
							'full' => esc_html__( 'Wide', 'shoppystore' ),
							'boxed' => esc_html__( 'Boxed', 'shoppystore' )
						),
						'std' => 'wide'
					),
				
					array(
						'id' => 'bg_box_img',
						'type' => 'upload',
						'title' => esc_html__('Background Box Image', 'shoppystore'),
						'sub_desc' => '',
						'std' => ''
					),
					array(
							'id' => 'sidebar_left_expand',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Expand', 'shoppystore'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12', 
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '3',
							'sub_desc' => esc_html__( 'Select width of left sidebar.', 'shoppystore' ),
						),
					
					array(
							'id' => 'sidebar_right_expand',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Expand', 'shoppystore'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '3',
							'sub_desc' => esc_html__( 'Select width of right sidebar medium desktop.', 'shoppystore' ),
						),
						array(
							'id' => 'sidebar_left_expand_md',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Medium Desktop Expand', 'shoppystore'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of left sidebar medium desktop.', 'shoppystore' ),
						),
					array(
							'id' => 'sidebar_right_expand_md',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Medium Desktop Expand', 'shoppystore'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of right sidebar.', 'shoppystore' ),
						),
						array(
							'id' => 'sidebar_left_expand_sm',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Tablet Expand', 'shoppystore'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of left sidebar tablet.', 'shoppystore' ),
						),
					array(
							'id' => 'sidebar_right_expand_sm',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Tablet Expand', 'shoppystore'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of right sidebar tablet.', 'shoppystore' ),
						),				
				)
		);
	$options[] = array(
			'title' => esc_html__('Mobile Layout', 'shoppystore'),
			'desc' => wp_kses( __('<p class="description">SmartAddons Framework comes with a mobile setting home page layout.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it ya for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a ya section, no options just some intro text set above.
			'fields' => array(				
				array(
					'id' => 'mobile_enable',
					'type' => 'checkbox',
					'title' => esc_html__('Enable Mobile Layout', 'shoppystore'),
					'sub_desc' => '',
					'desc' => '',
					'std' => '1'// 1 = on | 0 = off
				),
				
				array(
					'id' => 'mobile_logo',
					'type' => 'upload',
					'title' => esc_html__('Logo Mobile Image', 'shoppystore'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the new mobile logo', 'shoppystore' ),
					'std' => get_template_directory_uri().'/assets/img/logo-default.png'
				),
				
				array(
					'id' => 'mobile_logo_account',
					'type' => 'upload',
					'title' => esc_html__('Logo Mobile My Account Page', 'shoppystore'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the new mobile logo in my account page', 'shoppystore' ),
					'std' => get_template_directory_uri().'/assets/img/icon-myaccount.png'
				),
				
				array(
					'id' => 'sticky_mobile',
					'type' => 'checkbox',
					'title' => esc_html__('Sticky Mobile', 'shoppystore'),
					'sub_desc' => '',
					'desc' => '',
					'std' => '0'// 1 = on | 0 = off
				),
				
				array(
					'id' => 'mobile_content',
					'type' => 'pages_select',
					'title' => esc_html__('Mobile Layout Content', 'shoppystore'),
					'sub_desc' => esc_html__('Select content index for this mobile layout', 'shoppystore'),
					'std' => ''
				),
				
				array(
					'id' => 'mobile_header_style',
					'type' => 'select',
					'title' => esc_html__('Header Mobile Style', 'shoppystore'),
					'sub_desc' => esc_html__('Select header mobile style', 'shoppystore'),
					'options' => array(
							'mstyle1'  => esc_html__( 'Style 1', 'shoppystore' ),
							'mstyle2'  => esc_html__( 'Style 2', 'shoppystore' ),
							'mstyle3'  => esc_html__( 'Style 3', 'shoppystore' ),
					),
					'std' => 'style1'
				),
				
				array(
					'id' => 'mobile_footer_style',
					'type' => 'select',
					'title' => esc_html__('Footer Mobile Style', 'shoppystore'),
					'sub_desc' => esc_html__('Select footer mobile style', 'shoppystore'),
					'options' => array(
							'mstyle1'  => esc_html__( 'Style 1', 'shoppystore' ),
							'mstyle2'  => esc_html__( 'Style 2', 'shoppystore' ),
							'mstyle3'  => esc_html__( 'Style 3', 'shoppystore' ),
					),
					'std' => 'style1'
				),
				
				array(
					'id' => 'mobile_addcart',
					'type' => 'checkbox',
					'title' => esc_html__('Enable Add To Cart Button', 'shoppystore'),
					'sub_desc' => esc_html__( 'Enable Add To Cart Button on product listing', 'shoppystore' ),
					'desc' => '',
						'std' => '0'// 1 = on | 0 = off
				),
				
				array(
					'id' => 'mobile_header_inside',
					'type' => 'checkbox',
					'title' => esc_html__('Enable Header Other Pages', 'shoppystore'),
					'sub_desc' => esc_html__( 'Enable header in other pages which are different with homepage', 'shoppystore' ),
					'desc' => '',
						'std' => '0'// 1 = on | 0 = off
				),
				
				array(
					'id' => 'mobile_jquery',
					'type' => 'checkbox',
					'title' => esc_html__('Include Jquery Revolution', 'shoppystore'),
					'sub_desc' => '',
					'desc' => '',
					'std' => '0'// 1 = on | 0 = off
				),
			)
	);
			
	$options[] = array(
		'title' => esc_html__('Header & Footer', 'shoppystore'),
			'desc' => wp_kses( __('<p class="description">SmartAddons Framework comes with a header and footer setting that allows you to build style header.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it ya for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_336_read_it_later.png',
			//Lets leave this as a ya section, no options just some intro text set above.
			'fields' => array(
				 array(
					'id' => 'header_style',
							'type' => 'select',
							'title' => esc_html__('Header Style', 'shoppystore'),
							'sub_desc' => esc_html__( 'Select Header style', 'shoppystore' ),
							'options' => array(
									'style1'  => esc_html__( 'Style 1', 'shoppystore' ),
									'style2'  => esc_html__( 'Style 2', 'shoppystore' ),
									'style3'  => esc_html__( 'Style 3', 'shoppystore' ),
									'style4'  => esc_html__( 'Style 4', 'shoppystore' ),
									'style5'  => esc_html__( 'Style 5', 'shoppystore' ),
									'style6'  => esc_html__( 'Style 6', 'shoppystore' ),
									'style7'  => esc_html__( 'Style 7', 'shoppystore' ),
									'style8'  => esc_html__( 'Style 8', 'shoppystore' ),	
									'style9'  => esc_html__( 'Style 9', 'shoppystore' ),	
									'style10'  => esc_html__( 'Style 10', 'shoppystore' ),
									'style11'  => esc_html__( 'Style 11', 'shoppystore' ),
									'style12'  => esc_html__( 'Style 12', 'shoppystore' ),
									'style13'  => esc_html__( 'Style 13', 'shoppystore' ),
									'style14'  => esc_html__( 'Style 14', 'shoppystore' ),
									'style15'  => esc_html__( 'Style 15', 'shoppystore' ),															
									),
							'std' => 'style1'
				),
				array(
					'id' => 'header_mid',
					'title' => esc_html__( 'Enable Background Header Mid', 'shoppystore' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( ' enable background hedaer mid on header', 'shoppystore' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
						'id' => 'bg_header_mid',
						'title' => esc_html__( 'Background header mid', 'shoppystore' ),
						'type' => 'upload',
						'sub_desc' => esc_html__( 'Choose header mid background image', 'shoppystore' ),
						'desc' => '',
						'std' => get_template_directory_uri().'/assets/img/popup/bg-main.jpg'
					),
				 array(
							'id' => 'phone',
							'type' => 'text',
							'title' => esc_html__('Phone number', 'shoppystore'),
							'sub_desc' => esc_html__( 'Fill here your phone number to be displayed in header.', 'shoppystore' ),
							'std' => ''
						),
				
				array(
							'id' => 'email',
							'type' => 'text',
							'title' => esc_html__('Email', 'shoppystore'),
							'sub_desc' => esc_html__( 'Fill here your email to be displayed in header.', 'shoppystore' ),
							'std' => ''
						),
				array(
							'id' => 'keywords',
							'type' => 'textarea',
							'title' => esc_html__('Keywords', 'shoppystore'),
							'sub_desc' => esc_html__( 'Your keywords to be displayed in header style 11.', 'shoppystore' ),
							'std' => ''
						),
				 array(
							'id' => 'search',
							'title' => esc_html__( 'Search form', 'shoppystore' ),
							'type' => 'checkbox',
							'sub_desc' => esc_html__( 'Hide or show search form', 'shoppystore' ),
							'desc' => '',
							'std' => '1'
						),	
					
				array(
					'id' => 'disable_cart',
					'title' => esc_html__( 'Disable Cart', 'shoppystore' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this to disable cart on header', 'shoppystore' ),
					'desc' => '',
					'std' => '0'
				),				
						
				array(
					'id' => 'footer_widget',
					'title' => esc_html__( 'Footer widget', 'shoppystore' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this to use footer widget', 'shoppystore' ),
					'desc' => '',
					'std' => '0'
				),			
				array(
				   'id' => 'footer_style',
				   'type' => 'pages_select',
				   'title' => esc_html__('Footer Style', 'shoppystore'),
				   'sub_desc' => esc_html__('Select Footer style', 'shoppystore'),
				   'std' => ''
				),
				
				array(
					'id' => 'footer_copyright',
					'type' => 'editor',
					'sub_desc' => '',
					'title' => esc_html__( 'Copyright text', 'shoppystore' )
				),
				array(						
					'id' => 'footer_payment',
					'type' => 'editor',
					'sub_desc' => esc_html__( 'Change payment image content on the footer', 'shoppystore' ),
					'title' => esc_html__( 'Footer Payment', 'shoppystore' )
				),				
				
			)
	);
	$options[] = array(
			'title' => esc_html__('Navbar Options', 'shoppystore'),
			'desc' => wp_kses( __('<p class="description">If you got a big site with a lot of sub menus we recommend using a mega menu. Just select the dropbox to display a menu as mega menu or dropdown menu.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it ya for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_157_show_lines.png',
			//Lets leave this as a ya section, no options just some intro text set above.
			'fields' => array(
				array(
						'id' => 'menu_type',
						'type' => 'select',
						'title' => esc_html__('Menu Type', 'shoppystore'),
						'options' => array( 'dropdown' => 'Dropdown Menu', 'mega' => 'Mega Menu' ),
						'std' => 'mega'
					),

				array(
						'id' => 'menu_location',
						'type' => 'menu_location_multi_select',
						'title' => esc_html__('Theme Location', 'shoppystore'),
						'sub_desc' => esc_html__( 'Select theme location to active mega menu and menu responsive.', 'shoppystore' ),
						'std' => 'primary_menu'
					),		
					
				array(
						'id' => 'sticky_menu',
						'type' => 'checkbox',
						'title' => esc_html__('Active sticky menu', 'shoppystore'),
						'sub_desc' => '',
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),		
				
			
				array(
					'id' => 'menu_number_item',
					'type' => 'text',
					'title' => esc_html__( 'Number Item Vertical', 'shoppystore' ),
					'sub_desc' => esc_html__( 'Number item vertical to show', 'shoppystore' ),
					'std' => 8
				),	
				
				array(
					'id' => 'menu_title_text',
					'type' => 'text',
					'title' => esc_html__('Vertical Title Text', 'shoppystore'),
					'sub_desc' => esc_html__( 'Change title text on vertical menu', 'shoppystore' ),
					'std' => ''
				),
				
				array(
					'id' => 'menu_more_text',
					'type' => 'text',
					'title' => esc_html__('Vertical More Text', 'shoppystore'),
					'sub_desc' => esc_html__( 'Change more text on vertical menu', 'shoppystore' ),
					'std' => ''
				),
					
				array(
					'id' => 'menu_less_text',
					'type' => 'text',
					'title' => esc_html__('Vertical Less Text', 'shoppystore'),
					'sub_desc' => esc_html__( 'Change less text on vertical menu', 'shoppystore' ),
					'std' => ''
				)	
			)
		);
	$options[] = array(
		'title' => esc_html__('Blog Options', 'shoppystore'),
		'desc' => wp_kses( __('<p class="description">Select layout in blog listing page.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it ya for default.
		'icon' => YA_URL.'/options/img/glyphicons/glyphicons_071_book.png',
		//Lets leave this as a ya section, no options just some intro text set above.
		'fields' => array(
				array(
						'id' => 'sidebar_blog',
						'type' => 'select',
						'title' => esc_html__('Sidebar Blog Layout', 'shoppystore'),
						'options' => array(
								'full' => esc_html__( 'Full Layout', 'shoppystore' ),		
								'left'	=>  esc_html__( 'Left Sidebar', 'shoppystore' ),
								'right' => esc_html__( 'Right Sidebar', 'shoppystore' ),
						),
						'std' => 'left',
						'sub_desc' => esc_html__( 'Select style sidebar blog', 'shoppystore' ),
					),
					array(
						'id' => 'blog_layout',
						'type' => 'select',
						'title' => esc_html__('Layout blog', 'shoppystore'),
						'options' => array(
								'list'	=>  esc_html__( 'List Layout', 'shoppystore' ),
								'grid' =>  esc_html__( 'Grid Layout', 'shoppystore' )								
						),
						'std' => 'list',
						'sub_desc' => esc_html__( 'Select style layout blog', 'shoppystore' ),
					),
					array(
						'id' => 'blog_column',
						'type' => 'select',
						'title' => esc_html__('Blog column', 'shoppystore'),
						'options' => array(								
								'2' => '2 columns',
								'3' => '3 columns',
								'4' => '4 columns'								
							),
						'std' => '2',
						'sub_desc' => esc_html__( 'Select style number column blog', 'shoppystore' ),
					),
			)
	);	
	$options[] = array(
		'title' => esc_html__('Product Options', 'shoppystore'),
		'desc' => wp_kses( __('<p class="description">Select layout in product listing page.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it ya for default.
		'icon' => YA_URL.'/options/img/glyphicons/glyphicons_202_shopping_cart.png',
		//Lets leave this as a ya section, no options just some intro text set above.
		'fields' => array(
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product Categories Config', 'shoppystore' ),
				'desc' => '',
				'class' => 'ya-opt-info'
				),
			
			array(
				'id' => 'product_colcat_large',
				'type' => 'select',
				'title' => esc_html__('Product Category Listing column Desktop', 'shoppystore'),
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',							
					),
				'std' => '4',
				'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'shoppystore' ),
				),

			array(
				'id' => 'product_colcat_medium',
				'type' => 'select',
				'title' => esc_html__('Product Listing Category column Medium Desktop', 'shoppystore'),
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6',
					),
				'std' => '3',
				'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'shoppystore' ),
				),

			array(
				'id' => 'product_colcat_sm',
				'type' => 'select',
				'title' => esc_html__('Product Listing Category column Tablet', 'shoppystore'),
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6'
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'shoppystore' ),
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product General Config', 'shoppystore' ),
				'desc' => '',
				'class' => 'ya-opt-info'
				),
				
			array(
				'id' => 'product_banner',
				'title' => esc_html__( 'Select Banner', 'shoppystore' ),
				'type' => 'select',
				'sub_desc' => '',
				'options' => array(
					'' => esc_html__( 'Use Banner', 'shoppystore' ),
					'listing' => esc_html__( 'Use Category Product Image', 'shoppystore' ),
					),
				'std' => '',
				),

			array(
				'id' => 'product_listing_banner',
				'type' => 'upload',
				'title' => esc_html__('Listing Banner Product', 'shoppystore'),
				'sub_desc' => esc_html__( 'Use the Upload button to upload banner product listing', 'shoppystore' ),
				'std' => get_template_directory_uri().'/assets/img/logo-default.png'
				),

			array(
				'id' => 'product_col_large',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Desktop', 'shoppystore'),
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',							
					),
				'std' => '3',
				'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'shoppystore' ),
				),

			array(
				'id' => 'product_col_medium',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Medium Desktop', 'shoppystore'),
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6',
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'shoppystore' ),
				),

			array(
				'id' => 'product_col_sm',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Tablet', 'shoppystore'),
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6'
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'shoppystore' ),
				),

			array(
				'id' => 'sidebar_product',
				'type' => 'select',
				'title' => esc_html__('Sidebar Product Layout', 'shoppystore'),
				'options' => array(
					'left'	=> esc_html__( 'Left Sidebar', 'shoppystore' ),
					'full' => esc_html__( 'Full Layout', 'shoppystore' ),		
					'right' => esc_html__( 'Right Sidebar', 'shoppystore' )
					),
				'std' => 'left',
				'sub_desc' => esc_html__( 'Select style sidebar product', 'shoppystore' ),
				),

			array(
				'id' => 'product_quickview',
				'title' => esc_html__( 'Quickview', 'shoppystore' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Quickview', 'shoppystore' ),
				'std' => '1'
				),
			
			array(
				'id' => 'product_listing_countdown',
				'title' => esc_html__( 'Enable Countdown', 'shoppystore' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Countdown on product listing', 'shoppystore' ),
				'std' => '1'
				),
			
			
			array(
				'id' => 'product_number',
				'type' => 'text',
				'title' => esc_html__('Product Listing Number', 'shoppystore'),
				'sub_desc' => esc_html__( 'Show number of product in listing product page.', 'shoppystore' ),
				'std' => 12
				),
			
			array(
				'id' => 'newproduct_time',
				'title' => esc_html__( 'New Product', 'shoppystore' ),
				'type' => 'number',
				'sub_desc' => '',
				'desc' => esc_html__( 'Set day for the new product label from the date publish product.', 'shoppystore' ),
				'std' => 0
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product Single Config', 'shoppystore' ),
				'desc' => '',
				'class' => 'ya-opt-info'
				),
			
			array(
				'id' => 'sidebar_product_detail',
				'type' => 'select',
				'title' => esc_html__('Sidebar Product Single Layout', 'shoppystore'),
				'options' => array(
					'left'	=> esc_html__( 'Left Sidebar', 'shoppystore' ),
					'full' => esc_html__( 'Full Layout', 'shoppystore' ),		
					'right' => esc_html__( 'Right Sidebar', 'shoppystore' )
					),
				'std' => 'left',
				'sub_desc' => esc_html__( 'Select style sidebar product single', 'shoppystore' ),
				),				
			
			array(
				'id' => 'product_zoom',
				'title' => esc_html__( 'Product Zoom', 'shoppystore' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off image zoom when hover on single product', 'shoppystore' ),
				'std' => '1'
				),
			
			array(
				'id' => 'product_brand',
				'title' => esc_html__( 'Enable Product Brand Image', 'shoppystore' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off product brand image show on single product.', 'shoppystore' ),
				'std' => '1'
				),

			array(
				'id' => 'product_single_countdown',
				'title' => esc_html__( 'Enable Countdown Single', 'shoppystore' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Countdown on product single', 'shoppystore' ),
				'std' => '1'
				),			
			
			array(
				'id' => 'pdetail_layout',
				'type' => 'select',
				'title' => esc_html__('Detail Product Layout', 'shoppystore'),
				'options' => array(
						'default' 	=> esc_html__( 'Full Width Default', 'shoppystore' ),
						'full1'		=> esc_html__( 'Full Width Style 1', 'shoppystore' ),
						'full2' 	=> esc_html__( 'Full Width Style 2', 'shoppystore' ),
                        'full3' 	=> esc_html__( 'Full Width Style 3', 'shoppystore' ),
				),
				'std' => 'default',
				'sub_desc' => esc_html__( 'Select style for full width detail product layout', 'shoppystore' ),
			)
		)
);		
	$options[] = array(
			'title' => esc_html__('Typography', 'shoppystore'),
			'desc' => wp_kses( __('<p class="description">Change the font style of your blog, custom with Google Font.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it ya for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_151_edit.png',
			//Lets leave this as a ya section, no options just some intro text set above.
			'fields' => array(
				array(
					'id' => 'info_typo1',
					'type' => 'info',
					'title' => esc_html( 'Global Typography', 'shoppystore' ),
					'desc' => '',
					'class' => 'ya-opt-info'
					),

				array(
					'id' => 'google_webfonts',
					'type' => 'google_webfonts',
					'title' => esc_html__('Use Google Webfont', 'shoppystore'),
					'sub_desc' => esc_html__( 'Insert font style that you actually need on your webpage.', 'shoppystore' ), 
					'std' => ''
					),

				array(
					'id' => 'webfonts_weight',
					'type' => 'multi_select',
					'sub_desc' => esc_html__( 'For weight, see Google Fonts to custom for each font style.', 'shoppystore' ),
					'title' => esc_html__('Webfont Weight', 'shoppystore'),
					'options' => array(
						'100' => '100',
						'200' => '200',
						'300' => '300',
						'400' => '400',
						'500' => '500',
						'600' => '600',
						'700' => '700',
						'800' => '800',
						'900' => '900'
						),
					'std' => ''
					),

				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Header Tag Typography', 'shoppystore' ),
					'desc' => '',
					'class' => 'ya-opt-info'
					),

				array(
					'id' => 'header_tag_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Header Tag Font', 'shoppystore'),
					'sub_desc' => esc_html__( 'Select custom font for header tag ( h1...h6 )', 'shoppystore' ), 
					'std' => ''
					),

				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Main Menu Typography', 'shoppystore' ),
					'desc' => '',
					'class' => 'ya-opt-info'
					),

				array(
					'id' => 'menu_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Main Menu Font', 'shoppystore'),
					'sub_desc' => esc_html__( 'Select custom font for main menu', 'shoppystore' ), 
					'std' => ''
					),
					
				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Custom Typography', 'shoppystore' ),
					'desc' => '',
					'class' => 'ya-opt-info'
				),

				array(
					'id' => 'custom_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Custom Font', 'shoppystore'),
					'sub_desc' => esc_html__( 'Select custom font for custom class', 'shoppystore' ), 
					'std' => ''
				),
				
				array(
					'id' => 'custom_font_class',
					'title' => esc_html__( 'Custom Font Class', 'shoppystore' ),
					'type' => 'text',
					'sub_desc' => esc_html__( 'Put custom class to this field. Each class separated by commas.', 'shoppystore' ),
					'desc' => '',
					'std' => '',
				),
				
			)
		);
	
	$options[] = array(
					'title' => __('My Social', 'shoppystore'),
					'desc' => __('<p class="description">My social link.</p>', 'shoppystore'),
					'icon' => YA_URL.'/options/img/glyphicons/glyphicons_222_share.png',
					'fields' => array(
							array(
									'id' => 'my-social-fb',
									'title' => __( 'Facebook', 'shoppystore' ),
									'type' => 'text',
									'sub_desc' => '',
									'desc' => '',
									'std' => '1',
								),
							array(
									'id' => 'my-social-tw',
									'title' => __( 'Twitter', 'shoppystore' ),
									'type' => 'text',
									'sub_desc' => '',
									'desc' => '',
									'std' => '1',
								),
							array(
									'id' => 'my-social-in',
									'title' => __( 'Linked_in', 'shoppystore' ),
									'type' => 'text',
									'sub_desc' => '',
									'desc' => '',
									'std' => '1',
								),
							array(
									'id' => 'my-social-go',
									'title' => __( 'Google+', 'shoppystore' ),
									'type' => 'text',
									'sub_desc' => '',
									'desc' => '',
									'std' => '1',
								),
							array(
									'id' => 'my-social-pi',
									'title' => __( 'Piterest', 'shoppystore' ),
									'type' => 'text',
									'sub_desc' => '',
									'desc' => '',
									'std' => '1',
								),
						)
				);
	$options[] = array(
			'title' => esc_html__('Social share', 'shoppystore'),
			'desc' => wp_kses(__('<p class="description">Social sharing is ready to use and built in. You can share your pages with just a click and your post can go to their wall and you can gain vistitors from Social Networks. Check Social Networks that you want to use.</p>', 'shoppystore'),'p'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_222_share.png',
			//Lets leave this as a blank section, no options just some intro text set above.
			'fields' => array(
					array(
							'id' => 'social-share',
							'title' => esc_html__( 'Social share', 'shoppystore' ),
							'type' => 'checkbox',
							'sub_desc' => '',
							'desc' => '',
							'std' => '0'
						),
					array(
							'id' => 'social-share-fb',
							'title' => esc_html__( 'Facebook', 'shoppystore' ),
							'type' => 'checkbox',
							'sub_desc' => '',
							'desc' => '',
							'std' => '1',
						),
					array(
							'id' => 'social-share-tw',
							'title' => esc_html__( 'Twitter', 'shoppystore' ),
							'type' => 'checkbox',
							'sub_desc' => '',
							'desc' => '',
							'std' => '1',
						),
					array(
							'id' => 'social-share-in',
							'title' => esc_html__( 'Linked_in', 'shoppystore' ),
							'type' => 'checkbox',
							'sub_desc' => '',
							'desc' => '',
							'std' => '1',
						),
					array(
							'id' => 'social-share-go',
							'title' => esc_html__( 'Google+', 'shoppystore' ),
							'type' => 'checkbox',
							'sub_desc' => '',
							'desc' => '',
							'std' => '1',
						),
				)
		);
	$options[] = array(
			'title' => esc_html__('Maintaincece Mode', 'shoppystore'),
			'desc' => wp_kses( __('<p class="description">Enable and config for Maintaincece mode.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it ya for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a ya section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'maintaince_enable',
						'title' => esc_html__( 'Enable Maintaincece Mode', 'shoppystore' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off Maintaince mode on this website', 'shoppystore' ),
						'desc' => '',
						'std' => '0'
					),
					
					array(
						'id' => 'maintaince_background',
						'title' => esc_html__( 'Maintaince Background', 'shoppystore' ),
						'type' => 'upload',
						'sub_desc' => esc_html__( 'Choose maintance background image', 'shoppystore' ),
						'desc' => '',
						'std' => get_template_directory_uri().'/assets/img/maintaince/bg-main.jpg'
					),
					
					array(
						'id' => 'maintaince_content',
						'title' => esc_html__( 'Maintaince Content', 'shoppystore' ),
						'type' => 'editor',
						'sub_desc' => esc_html__( 'Change text of maintaince mode', 'shoppystore' ),
						'desc' => '',
						'std' => ''
					),
					
					array(
						'id' => 'maintaince_date',
						'title' => esc_html__( 'Maintaince Date', 'shoppystore' ),
						'type' => 'date',
						'sub_desc' => esc_html__( 'Put date to this field to show countdown date on maintaince mode.', 'shoppystore' ),
						'desc' => '',
						'placeholder' => 'mm/dd/yy',
						'std' => ''
					),
					
					array(
						'id' => 'maintaince_form',
						'title' => esc_html__( 'Maintaince Form', 'shoppystore' ),
						'type' => 'text',
						'sub_desc' => esc_html__( 'Put shortcode form to this field and it will be shown on maintaince mode frontend.', 'shoppystore' ),
						'desc' => '',
						'std' => ''
					),
					
				)
		);
	
	$options[] = array(
			'title' => esc_html__('Popup Config', 'shoppystore'),
			'desc' => wp_kses( __('<p class="description">Enable popup and more config for Popup.</p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it ya for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a ya section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'popup_active',
						'type' => 'checkbox',
						'title' => esc_html__( 'Active Popup Subscribe', 'shoppystore' ),
						'sub_desc' => esc_html__( 'Check to active popup subscribe', 'shoppystore' ),
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),	
					
					array(
						'id' => 'popup_background',
						'title' => esc_html__( 'Popup Background', 'shoppystore' ),
						'type' => 'upload',
						'sub_desc' => esc_html__( 'Choose popup background image', 'shoppystore' ),
						'desc' => '',
						'std' => get_template_directory_uri().'/assets/img/popup/bg-main.jpg'
					),
					
					array(
						'id' => 'popup_content',
						'title' => esc_html__( 'Popup Content', 'shoppystore' ),
						'type' => 'editor',
						'sub_desc' => esc_html__( 'Change text of popup mode', 'shoppystore' ),
						'desc' => '',
						'std' => ''
					),	
					
					array(
						'id' => 'popup_form',
						'title' => esc_html__( 'Popup Form', 'shoppystore' ),
						'type' => 'text',
						'sub_desc' => esc_html__( 'Put shortcode form to this field and it will be shown on popup mode frontend.', 'shoppystore' ),
						'desc' => '',
						'std' => ''
					),
					
				)
		);
	
	$options[] = array(
			'title' => esc_html__('Advanced', 'shoppystore'),
			'desc' => wp_kses( __('<p class="description">Custom advanced with Cpanel, Widget advanced, Developer mode </p>', 'shoppystore'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it ya for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a ya section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'show_cpanel',
						'title' => esc_html__( 'Show cPanel', 'shoppystore' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off Cpanel', 'shoppystore' ),
						'desc' => '',
						'std' => ''
					),
					
					array(
						'id' => 'widget-advanced',
						'title' => esc_html__('Widget Advanced', 'shoppystore'),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off Widget Advanced', 'shoppystore' ),
						'desc' => '',
						'std' => '1'
					),					
					
					array(
						'id' => 'breadcrumb_active',
						'title' => esc_html__( 'Turn Off Breadcrumb', 'shoppystore' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn off breadcumb on all page', 'shoppystore' ),
						'desc' => '',
						'std' => '0'
					),
					
					array(
						'id' => 'back_active',
						'type' => 'checkbox',
						'title' => esc_html__('Back to top', 'shoppystore'),
						'sub_desc' => '',
						'desc' => '',
						'std' => '1'// 1 = on | 0 = off
					),	
					
					array(
							'id' => 'preload_active',
							'type' => 'checkbox',
							'title' => esc_html__('Active preload', 'shoppystore'),
							'sub_desc' => esc_html__( 'Active preloading for theme', 'shoppystore' ),
							'desc' => '',
							'std' => '0'// 1 = on | 0 = off
							),
					array(
							'id' => 'preload_active_page',
							'type' => 'pages_multi_select',
							'title' => esc_html__('Preload Active Page(s)', 'shoppystore'),
							'sub_desc' => esc_html__( 'Select page(s) to active preload.', 'shoppystore' ),
							'desc' => '',
							),	
					
					array(
						'id' => 'direction',
						'type' => 'select',
						'title' => esc_html__('Direction', 'shoppystore'),
						'options' => array( 'ltr' => 'Left to Right', 'rtl' => 'Right to Left' ),
						'std' => 'ltr'
					),
					
					
					array(
						'id' => 'advanced_css',
						'type' => 'textarea',
						'sub_desc' => esc_html__( 'Insert your own CSS into this block. This overrides all default styles located throughout the theme', 'shoppystore' ),
						'title' => esc_html__( 'Custom CSS', 'shoppystore' )
					),
					
					array(
						'id' => 'advanced_js',
						'type' => 'textarea',
						'placeholder' => esc_html__( 'Example: $("p").hide()', 'shoppystore' ),
						'sub_desc' => esc_html__( 'Insert your own JS into this block. This customizes js throughout the theme', 'shoppystore' ),
						'title' => esc_html__( 'Custom JS', 'shoppystore' )
					)
				)
		);

	$options_args = array();

	//Setup custom links in the footer for share icons
	$options_args['share_icons']['facebook'] = array(
			'link' => 'http://www.facebook.com/SmartAddons.page',
			'title' => 'Facebook',
			'img' => YA_URL.'/options/img/glyphicons/glyphicons_320_facebook.png'
	);
	$options_args['share_icons']['twitter'] = array(
			'link' => 'https://twitter.com/smartaddons',
			'title' => 'Folow me on Twitter',
			'img' => YA_URL.'/options/img/glyphicons/glyphicons_322_twitter.png'
	);
	$options_args['share_icons']['linked_in'] = array(
			'link' => 'http://www.linkedin.com/in/smartaddons',
			'title' => 'Find me on LinkedIn',
			'img' => YA_URL.'/options/img/glyphicons/glyphicons_337_linked_in.png'
	);


	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
	$options_args['opt_name'] = YA_THEME;

	$options_args['google_api_key'] = 'AIzaSyBadDZo04o9VPTM_yA8GJEkLMn3gfaY_cU'; //must be defined for use with google webfonts field type

	//Custom menu title for options page - default is "Options"
	$options_args['menu_title'] = esc_html__('Theme Options', 'shoppystore');

	//Custom Page Title for options page - default is "Options"
	$options_args['page_title'] = esc_html__('Ya Options ', 'shoppystore') . wp_get_theme()->get('Name');

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "ya_theme_options"
	$options_args['page_slug'] = 'ya_theme_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
	$options_args['page_type'] = 'submenu';

	//custom page location - default 100 - must be unique or will override other items
	$options_args['page_position'] = 27;
	$ya_options = new Ya_Options( $options, $options_args );
}
add_action( 'admin_init', 'ya_Options_Setup', 0 );
ya_Options_Setup();

add_filter( 'sw_googlefont_api_key_filter', 'ya_custom_google_api_key' );
function ya_custom_google_api_key(){
	$webfont = ( ya_options()->getCpanelValue( 'google_webfonts_api' ) != '' ) ? ya_options()->getCpanelValue( 'google_webfonts_api' ) : 'AIzaSyBadDZo04o9VPTM_yA8GJEkLMn3gfaY_cU';
	return $webfont;
}

//var_dump( $ya_options ); die( 'co vao ko?' );
function ya_widget_setup_args(){
	$widget_areas = array(
		
		array(
				'name' => esc_html__('Sidebar Left Blog', 'shoppystore'),
				'id'   => 'left-blog',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => esc_html__('Sidebar Right Blog', 'shoppystore'),
				'id'   => 'right-blog',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Top', 'shoppystore'),
				'id'   => 'top',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),	
		array(
				'name' => esc_html__('Search', 'shoppystore'),
				'id'   => 'search',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('login social', 'shoppystore'),
				'id'   => 'login-social',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => ''
		),		
		array(
				'name' => esc_html__('Top 2', 'shoppystore'),
				'id'   => 'top2',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Top Header', 'shoppystore'),
				'id'   => 'top-header',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),		
		array(
				'name' => esc_html__('Top Right', 'shoppystore'),
				'id'   => 'top-right',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Banner Product', 'shoppystore'),
				'id'   => 'banner-product',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => ''
		),
		array(
				'name' => esc_html__('Sidebar Left Detail Product', 'shoppystore'),
				'id'   => 'left-detail-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => esc_html__('Sidebar Right Detail Product', 'shoppystore'),
				'id'   => 'right-detail-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => esc_html__('Sidebar Bottom Detail Product', 'shoppystore'),
				'id'   => 'bottom-detail-product',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Sidebar Left Product', 'shoppystore'),
				'id'   => 'left-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Right Product', 'shoppystore'),
				'id'   => 'right-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => esc_html__('Sidebar Forum', 'shoppystore'),
				'id'   => 'forum-sidebar',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => esc_html__('Above Footer', 'shoppystore'),
				'id'   => 'above-footer',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Above Footer 1', 'shoppystore'),
				'id'   => 'above-footer-1',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Banner Mobile', 'shoppystore'),
				'id'   => 'banner-mobile',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => esc_html__('Bottom Detail Product Mobile', 'shoppystore'),
				'id'   => 'bottom-detail-product-mobile',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Filter Mobile', 'shoppystore'),
				'id'   => 'filter-mobile',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Footer', 'shoppystore'),
				'id'   => 'footer',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Footer 1', 'shoppystore'),
				'id'   => 'footer1',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Footer 2', 'shoppystore'),
				'id'   => 'footer2',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Floating', 'shoppystore'),
				'id'   => 'floating',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		)
	);
	return $widget_areas;
}
