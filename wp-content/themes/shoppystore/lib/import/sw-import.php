<?php 
function sw_import_files() { 
  return array(
    array(
      'import_file_name'             => 'Demo Hitech Store 01',
	  'page_title'									 => 'Hitech Store 01',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
	   'local_import_revslider'  		 => array( 
				'home1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/home1.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-1/screenshot1.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/',
    ),
	
	 array(
      'import_file_name'             => 'Demo Hitech Store 02',
	  'page_title'									 => 'Hitech Store 02',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
	   'local_import_revslider'  		 => array( 
				'homepage10' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/homepage10.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-1/screenshot2.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/',
    ),
	
	 array(
      'import_file_name'             => 'Demo Hitech Store 03',
	  'page_title'									 => 'Hitech Store 03',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
	   'local_import_revslider'  		 => array( 
				'homepage11' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/homepage11.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-1/screenshot3.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/',
    ),
	array(
      'import_file_name'             => 'Demo Fashion Store',
	  'page_title'									 => 'Fashion Store',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
	   'local_import_revslider'  		 => array( 
				'homepage6' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/homepage6.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-1/screenshot4.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/',
    ),
    array(
      'import_file_name'             => 'Demo Multi-Store',
	  'page_title'									 => 'Multi-Store',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
	   'local_import_revslider'  		 => array( 
				'homepage2' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/homepage2.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-1/screenshot5.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/',
    ),
	array(
      'import_file_name'             => 'Demo Beauty Store',
	  'page_title'									 => 'Beauty Store',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/widgets.json',
	   'local_import_revslider'  		 => array( 
				'home4' => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/home4.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-2/screenshot1.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/demo1/',
    ),
    array(
      'import_file_name'             => 'Demo Jewelry Store',
	  'page_title'									 => 'Jewelry Store',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/widgets.json',
	   'local_import_revslider'  		 => array( 
				'homepage5' => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/homepage5.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-2/screenshot2.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/demo1/',
    ),
     
    array(
      'import_file_name'             => 'Demo Sport Store 01',
	  'page_title'									 => 'Sport Store 01',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/widgets.json',
	   'local_import_revslider'  		 => array( 
				'homepage3' => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/homepage3.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-2/screenshot3.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/demo1/',
    ),
     array(
      'import_file_name'             => 'Demo Sport Store 02',
	  'page_title'									 => 'Sport Store 02',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/widgets.json',
	   'local_import_revslider'  		 => array( 
				'home8' => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/home8.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-2/screenshot4.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/demo1/',
    ),
    array(
      'import_file_name'             => 'Demo Sport Store 03',
	  'page_title'									 => 'Sport Store 03',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/widgets.json',
	   'local_import_revslider'  		 => array( 
				'home9' => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/home9.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-2/screenshot5.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/demo1/',
    ),
    
    array(
      'import_file_name'             => 'Demo Kid Shop',
	  'page_title'									 => 'Kid Shop',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/widgets.json',
	   'local_import_revslider'  		 => array( 
				'home7' => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/home7.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-3/screenshot1.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/demo2/',
    ),
    array(
      'import_file_name'             => 'Demo Cute Shop',
	  'page_title'									 => 'Cute Shop',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/widgets.json',
	   'local_import_revslider'  		 => array( 
				'homepage12' => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/homepage12.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-3/screenshot2.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/demo2/',
    ),
    array(
      'import_file_name'             => 'Demo Shoes Shop',
	  'page_title'									 => 'Shoes Shop',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/widgets.json',
	   'local_import_revslider'  		 => array( 
				'homepage13' => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/homepage13.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-3/screenshot3.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/demo2/',
    ),
    array(
      'import_file_name'             => 'Demo Furniture Store',
	  'page_title'									 => 'Furniture Store',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/widgets.json',
	   'local_import_revslider'  		 => array( 
				'homepage14' => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/homepage14.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-3/screenshot4.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/demo2/',
    ),
    array(
      'import_file_name'             => 'Demo Slider Cover',
	  'page_title'									 => 'Slider Cover',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/demo-content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/widgets.json',
	   'local_import_revslider'  		 => array( 
				'homepage15' => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/homepage15.zip' 
			),
      'local_import_options'         => array(
        array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/theme_options.txt',
				'option_name' => 'shoppystore_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'leftmenu' => 'Vertical Menu'
			),
      'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-3/screenshot5.jpg',
      'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 5-10 minutes', 'shoppystore' ),
      'preview_url'                  => 'http://demo.wpthemego.com/themes/sw_shoppy/demo2/',
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'sw_import_files' );

