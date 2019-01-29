<?php
/**
	* SW Woocommerce Slider
	* Register Widget Woocommerce Slider
	* @author 		SmartAddons
	* @version     1.0.0
**/
if ( !class_exists('sw_woo_slider_widget') ) {
	class sw_woo_slider_widget extends WP_Widget {
		
		private $snumber = 1;
		/**
		 * Widget setup.
		 */
		function __construct(){
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'sw_woo_slider_widget', 'description' => __('Sw Woo Slider', 'sw_woocommerce') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_woo_slider_widget' );

			/* Create the widget. */
			parent::__construct( 'sw_woo_slider_widget', __('Sw Woo Slider widget', 'sw_woocommerce'), $widget_ops, $control_ops );
			
			/* Create Shortcode */
			add_shortcode( 'woo_slide', array( $this, 'WS_Shortcode' ) );
			
			/* Create Vc_map */
			if ( class_exists('Vc_Manager') ) {
				add_action( 'vc_before_init', array( $this, 'WS_integrateWithVC' ), 10 );
			}
			
		}
		
		/*
		** Generate ID
		*/
		public function generateID() {
			return $this->id_base . '_' . (int) $this->snumber++;
		}
		
		/**
		* Add Vc Params
		**/
		function WS_integrateWithVC(){
			$terms = get_terms( 'product_cat', array( 'parent' => 0, 'hide_emty' => false ) );
			if( count( $terms ) == 0 ){
				return ;
			}
			$term = array( __( 'All Categories', 'sw_woocommerce' ) => '' );
			foreach( $terms as $cat ){
				$term[$cat->name] = $cat -> slug;
			}
			vc_map( array(
			  "name" => __( "YA Woo Slider", "sw_woocommerce" ),
			  "base" => "woo_slide",
			  "icon" => "icon-wpb-ytc",
			  "class" => "",
			  "category" => __( "My shortcodes", "sw_woocommerce"),
			  "params" => array(
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Title", "sw_woocommerce" ),
					"param_name" => "title1",
					"value" => "",
					"description" => __( "Title", "sw_woocommerce" )
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
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Layout", "sw_woocommerce" ),
					"param_name" => "layout",
					"value" => array( 'Layout Default' => 'layout1', 'Layout Featured' => 'layout2', 'Layout Top Rated' => 'layout3', 'Layout Best Sales' => 'layout4','Layout On Sales'=>'layout5','Layout Daily Deals'=>'layout6', 'Layout Child Category' => 'childcat', 'Layout Child Category 2' => 'childcat2','Layout New arrival Mobile' => 'new_mobile','Best Sales Mobile' => 'bestsales-mobile','Featured Mobile' => 'featured-mobile' ),
					"description" => __( "Layout", "sw_woocommerce" )
				 ),
				 
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number Of Child Category", 'sw_woocommerce' ),
					"param_name" => "number_child",
					"admin_label" => true,
					"value" => 3,
					"description" => __( "Number child category will show.", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array('childcat, childcat1')
					),
				 ),
				 
				  array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Style Layout", "sw_woocommerce" ),
					"param_name" => "style",
					"value" => array('Style 1' => 'style1', 'Style 2' => 'style2'),
					"description" => __( "Style for layouts", "sw_woocommerce" )
				 ),
				 array(
					'type' => 'date',
					'heading' => __( 'Countdown Date', 'sw_woocommerce' ),
					'param_name' => 'date',
					'value' =>'',
					'description' => __( 'Countdown Date', 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => 'layout6',
					 )
				),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Length", "sw_woocommerce" ),
					"param_name" => "length",
					"value" => 15,
					"description" => __( "Number character to show", "sw_woocommerce" )
				 ),
				array(
					'type' => 'attach_image',
					'heading' => __( 'Image', 'sw_woocommerce' ),
					'param_name' => 'image',
					'value' => '',
					'description' => __( 'Select image from media library.', 'sw_woocommerce' ),
					 'dependency' => array(
						'element' => 'layout',
						'value' => array('childcat','childcat2'),
					 )
				),
				array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Image Category Align", "sw_woocommerce" ),
					"param_name" => "img_align",
					"value" => array('Default Left' => 'default', 'Align Right' => 'right'),
					"description" => __( "Image Category Align", "sw_woocommerce" ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array('childcat','childcat2'),
					 )
				 ),
				  array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Category", "sw_woocommerce" ),
					"param_name" => "category",
					"value" => $term,
					"description" => __( "Select Categories", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Order By", "sw_woocommerce" ),
					"param_name" => "orderby",
					"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Title' => 'title', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
					"description" => __( "Order By", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Order", "sw_woocommerce" ),
					"param_name" => "order",
					"value" => array('Descending' => 'DESC', 'Ascending' => 'ASC'),
					"description" => __( "Order", "sw_woocommerce" )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number Of Post", "sw_woocommerce" ),
					"param_name" => "numberposts",
					"value" => 5,
					"description" => __( "Number Of Post", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number row per column", "sw_woocommerce" ),
					"param_name" => "item_row",
					"value" =>array(1,2,3,4,5),
					"description" => __( "Number row per column", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns >1200px: ", "sw_woocommerce" ),
					"param_name" => "columns",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns >1200px:", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 992px to 1199px:", "sw_woocommerce" ),
					"param_name" => "columns1",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 992px to 1199px:", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 768px to 991px:", "sw_woocommerce" ),
					"param_name" => "columns2",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 768px to 991px:", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 480px to 767px:", "sw_woocommerce" ),
					"param_name" => "columns3",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 480px to 767px:", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns in 480px or less than:", "sw_woocommerce" ),
					"param_name" => "columns4",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns in 480px or less than:", "sw_woocommerce" )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Speed", "sw_woocommerce" ),
					"param_name" => "speed",
					"value" => 1000,
					"description" => __( "Speed Of Slide", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Auto Play", "sw_woocommerce" ),
					"param_name" => "autoplay",
					"value" => array( 'True' => 'true', 'False' => 'false' ),
					"description" => __( "Auto Play", "sw_woocommerce" )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Interval", "sw_woocommerce" ),
					"param_name" => "interval",
					"value" => 5000,
					"description" => __( "Interval", "sw_woocommerce" )
				 ),
				 
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Total Items Slided", "sw_woocommerce" ),
					"param_name" => "scroll",
					"value" => 1,
					"description" => __( "Total Items Slided", "sw_woocommerce" )
				 ),
			  )
		   ) );
		}
		/**
			** Add Shortcode
		**/
		function WS_Shortcode( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title1' => '',	
					'title_length' => 0,
					'orderby' => 'name',
					'order'	=> 'DESC',
					'category' => '',
					'number_child' => 3,
					'style' => 'style1',
					'image' =>'',
					'date' =>'',
					'img_align'	=> 'default',
					'numberposts' => 5,
					'length' => 25,
					'item_row'=> 1,
					'columns' => 4,
					'columns1' => 4,
					'columns2' => 3,
					'columns3' => 2,
					'columns4' => 1,
					'speed' => 1000,
					'autoplay' => 'true',
					'interval' => 5000,
					'layout'  => 'layout1',
					'scroll' => 1
				), $atts )
			);
			ob_start();		
			if( $layout == 'layout1' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/default.php' );
				
			}elseif( $layout == 'layout2' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/featured.php' );			
			}
			elseif( $layout == 'layout3' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/toprated.php' );			
			}
			elseif( $layout == 'layout4' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/bestsales.php' );			
			}
			elseif( $layout == 'layout5' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/onsales.php' );			
			}
			elseif( $layout == 'layout6' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/dailydeals.php' );			
			}
			elseif( $layout == 'childcat' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/childcat.php' );			
			}
			elseif( $layout == 'childcat1' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/childcat1.php' );			
			}
			elseif( $layout == 'childcat2' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/childcat2.php' );			
			}
			elseif( $layout == 'new_mobile' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/new_mobile.php' );			
			}
			elseif( $layout == 'bestsales-mobile' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/bestsales-mobile.php' );			
			}
			elseif( $layout == 'featured-mobile' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider/featured-mobile.php' );			
			}
			$content = ob_get_clean();
			
			return $content;
		}
		/**
			* Cut string
		**/
		public function ya_trim_words( $text, $num_words = 30, $more = null ) {
			$text = strip_shortcodes( $text);
			$text = apply_filters('the_content', $text);
			$text = str_replace(']]>', ']]&gt;', $text);
			return wp_trim_words($text, $num_words, $more);
		}
		/**
		 * Display the widget on the screen.
		 */
		public function widget( $args, $instance ) {
			wp_reset_postdata();
			extract($args);
			$title1 = apply_filters( 'widget_title', empty( $instance['title1'] ) ? '' : $instance['title1'], $instance, $this->id_base );
			$style    		   = isset( $instance['style'] )     	? strip_tags($instance['style']) : 'style1';
			$description1 = apply_filters( 'widget_description', empty( $instance['description1'] ) ? '' : $instance['description1'], $instance, $this->id_base );
			echo $before_widget;
			
			if ( !isset($instance['category']) ){
				$instance['category'] = array();
			}
			$id = $this -> number;
			extract($instance);

			if ( !array_key_exists('widget_template', $instance) ){
				$instance['widget_template'] = 'default';
			}
			if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
				_e('Please active woocommerce plugin or install woomcommerce plugin first', 'sw_woocommerce');
				return false;
			}
			if ( $tpl = $this->getTemplatePath( $instance['widget_template'] ) ){ 			
				$link_img = plugins_url('images/', __FILE__);
				$widget_id = $args['widget_id'];		
				include $tpl;
			}
					
			/* After widget (defined by themes). */
			echo $after_widget;
		}    

		protected function getTemplatePath($tpl='default', $type=''){
			$file = '/'.$tpl.$type.'.php';
			$dir =	plugin_dir_path(dirname(__FILE__)).'/themes/sw-slider';
			
			if ( file_exists( $dir.$file ) ){
				return $dir.$file;
			}
			
			return $tpl=='default' ? false : $this->getTemplatePath('default', $type);
		}
		
		
		/**
		 * Update the widget settings.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// strip tag on text field
			$instance['title1'] = strip_tags( $new_instance['title1'] );
			$instance['description1'] = strip_tags( $new_instance['description1'] );
			// int or array
			if ( array_key_exists('category', $new_instance) ){
				if ( is_array($new_instance['category']) ){
					$instance['category'] = $new_instance['category'] ;
				} else {
					$instance['category'] = strip_tags( $new_instance['category'] );
				}
			}	
			
			if ( array_key_exists('img_align', $new_instance) ){
				$instance['img_align'] = strip_tags( $new_instance['img_align'] );
			}
			
			if ( array_key_exists('orderby', $new_instance) ){
				$instance['orderby'] = strip_tags( $new_instance['orderby'] );
			}

			if ( array_key_exists('order', $new_instance) ){
				$instance['order'] = strip_tags( $new_instance['order'] );
			}
			
			if ( array_key_exists('style', $new_instance) ){
				$instance['style'] = strip_tags( $new_instance['style'] );
			}

			if ( array_key_exists('numberposts', $new_instance) ){
				$instance['numberposts'] = intval( $new_instance['numberposts'] );
			}

			if ( array_key_exists('length', $new_instance) ){
				$instance['length'] = intval( $new_instance['length'] );
			}
			
			if ( array_key_exists('item_row', $new_instance) ){
				$instance['item_row'] = intval( $new_instance['item_row'] );
			}
			
			if ( array_key_exists('columns', $new_instance) ){
				$instance['columns'] = intval( $new_instance['columns'] );
			}
			if ( array_key_exists('columns1', $new_instance) ){
				$instance['columns1'] = intval( $new_instance['columns1'] );
			}
			if ( array_key_exists('columns2', $new_instance) ){
				$instance['columns2'] = intval( $new_instance['columns2'] );
			}
			if ( array_key_exists('columns3', $new_instance) ){
				$instance['columns3'] = intval( $new_instance['columns3'] );
			}
			if ( array_key_exists('columns4', $new_instance) ){
				$instance['columns4'] = intval( $new_instance['columns4'] );
			}
			if ( array_key_exists('interval', $new_instance) ){
				$instance['interval'] = intval( $new_instance['interval'] );
			}
			if ( array_key_exists('speed', $new_instance) ){
				$instance['speed'] = intval( $new_instance['speed'] );
			}
			if ( array_key_exists('start', $new_instance) ){
				$instance['start'] = intval( $new_instance['start'] );
			}
			if ( array_key_exists('scroll', $new_instance) ){
				$instance['scroll'] = intval( $new_instance['scroll'] );
			}	
			if ( array_key_exists('autoplay', $new_instance) ){
				$instance['autoplay'] = strip_tags( $new_instance['autoplay'] );
			}
			$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );
			
						
			
			return $instance;
		}

		function category_select( $field_name, $opts = array(), $field_value = null ){
			$default_options = array(
					'multiple' => false,
					'disabled' => false,
					'size' => 5,
					'class' => 'widefat',
					'required' => false,
					'autofocus' => false,
					'form' => false,
			);
			$opts = wp_parse_args($opts, $default_options);
		
			if ( (is_string($opts['multiple']) && strtolower($opts['multiple'])=='multiple') || (is_bool($opts['multiple']) && $opts['multiple']) ){
				$opts['multiple'] = 'multiple';
				if ( !is_numeric($opts['size']) ){
					if ( intval($opts['size']) ){
						$opts['size'] = intval($opts['size']);
					} else {
						$opts['size'] = 5;
					}
				}
				if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
					unset($opts['allow_select_all']);
					
				}
			} else {
				// is not multiple
				unset($opts['multiple']);
				unset($opts['size']);
				if (is_array($field_value)){
					$field_value = array_shift($field_value);
				}
				if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
					unset($opts['allow_select_all']);
					$allow_select_all = '<option value="">All Categories</option>';
				}
			}
		
			if ( (is_string($opts['disabled']) && strtolower($opts['disabled'])=='disabled') || is_bool($opts['disabled']) && $opts['disabled'] ){
				$opts['disabled'] = 'disabled';
			} else {
				unset($opts['disabled']);
			}
		
			if ( (is_string($opts['required']) && strtolower($opts['required'])=='required') || (is_bool($opts['required']) && $opts['required']) ){
				$opts['required'] = 'required';
			} else {
				unset($opts['required']);
			}
		
			if ( !is_string($opts['form']) ) unset($opts['form']);
		
			if ( !isset($opts['autofocus']) || !$opts['autofocus'] ) unset($opts['autofocus']);
		
			$opts['id'] = $this->get_field_id($field_name);
		
			$opts['name'] = $this->get_field_name($field_name);
			if ( isset($opts['multiple']) ){
				$opts['name'] .= '[]';
			}
			$select_attributes = '';
			foreach ( $opts as $an => $av){
				$select_attributes .= "{$an}=\"{$av}\" ";
			}
			
			$categories = get_terms('product_cat');
			$all_category_ids = array();
			foreach ($categories as $cat) $all_category_ids[] = $cat->slug;
			$is_valid_field_value = in_array($field_value, $all_category_ids);
			if (!$is_valid_field_value && is_array($field_value)){
				$intersect_values = array_intersect($field_value, $all_category_ids);
				$is_valid_field_value = count($intersect_values) > 0;
			}
			if (!$is_valid_field_value){
				$field_value = '';
			}
		
			$select_html = '<select ' . $select_attributes . '>';
			if (isset($allow_select_all)) $select_html .= $allow_select_all;
			foreach ($categories as $cat){			
				$select_html .= '<option value="' . $cat->slug . '"';
				if ($cat->slug == $field_value || (is_array($field_value)&&in_array($cat->slug, $field_value))){ $select_html .= ' selected="selected"';}
				$select_html .=  '>'.$cat->name.'</option>';
			}
			$select_html .= '</select>';
			return $select_html;
		}
		

		/**
		 * Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function
		 * when creating your form elements. This handles the confusing stuff.
		 */
		public function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array();
			$instance = wp_parse_args( (array) $instance, $defaults ); 		
					 
			$title1 				 = isset( $instance['title1'] )    		? 	strip_tags($instance['title1']) : '';
			$description1 	 = isset( $instance['description1'] )    ? 	strip_tags($instance['description1']) : '';
			$categoryid 		 = isset( $instance['category']  ) 		? $instance['category'] : '';
			$orderby    		 = isset( $instance['orderby'] )     	? strip_tags($instance['orderby']) : 'ID';
			$style    		   = isset( $instance['style'] )     	? strip_tags($instance['style']) : 'style1';
			$order      		 = isset( $instance['order'] )       	? strip_tags($instance['order']) : 'ASC';
			$number     		 = isset( $instance['numberposts'] ) 	? intval($instance['numberposts']) : 5;
			$length     		 = isset( $instance['length'] )      	? intval($instance['length']) : 25;
			$item_row     	 = isset( $instance['item_row'] )      	? intval($instance['item_row']) : 1;
			$columns     		 = isset( $instance['columns'] )      	? intval($instance['columns']) : 1;
			$columns1     	 = isset( $instance['columns1'] )     	? intval($instance['columns1']) : 1;
			$columns2     	 = isset( $instance['columns2'] )      	? intval($instance['columns2']) : 1;
			$columns3     	 = isset( $instance['columns3'] )      	? intval($instance['columns3']) : 1;
			$columns4     	 = isset( $instance['columns'] )      	? intval($instance['columns4']) : 1;
			$autoplay     	 = isset( $instance['autoplay'] )      	? strip_tags($instance['autoplay']) : 'true';
			$interval     	 = isset( $instance['interval'] )      	? intval($instance['interval']) : 5000;
			$speed     			 = isset( $instance['speed'] )      		? intval($instance['speed']) : 1000;
			$scroll     		 = isset( $instance['scroll'] )      	? intval($instance['scroll']) : 1;
			$widget_template = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
					   
					 
			?>		
			</p> 
			  <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>"
					type="text"	value="<?php echo esc_attr($title1); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('description1'); ?>"><?php _e('Description', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('description1'); ?>" name="<?php echo $this->get_field_name('description1'); ?>"
					type="text"	value="<?php echo esc_attr($description1); ?>" />
			</p>
			
			<p id="wgd-<?php echo $this->get_field_id('category'); ?>">
				<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category ID', 'sw_woocommerce')?></label>
				<br />
				<?php echo $this->category_select('category', array('allow_select_all' => true), $categoryid); ?>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', 'sw_woocommerce')?></label>
				<br />
				<?php $allowed_keys = array('name' => 'Name', 'author' => 'Author', 'date' => 'Date', 'title' => 'Title', 'modified' => 'Modified', 'parent' => 'Parent', 'ID' => 'ID', 'rand' =>'Rand', 'comment_count' => 'Comment Count'); ?>
				<select class="widefat"
					id="<?php echo $this->get_field_id('orderby'); ?>"
					name="<?php echo $this->get_field_name('orderby'); ?>">
					<?php
					$option ='';
					foreach ($allowed_keys as $value => $key) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $orderby){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
					<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
					<?php } ?>>
						<?php _e('Descending', 'sw_woocommerce')?>
					</option>
					<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"	<?php } ?>>
						<?php _e('Ascending', 'sw_woocommerce')?>
					</option>
				</select>
			</p>	
			
			<p>
				<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style Layout', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
					<option value="style1" <?php if ($style=='style1'){?> selected="selected"
					<?php } ?>>
						<?php _e('Style 1', 'sw_woocommerce')?>
					</option>
					<option value="style2" <?php if ($order=='style2'){?> selected="selected"	<?php } ?>>
						<?php _e('Style 2', 'sw_woocommerce')?>
					</option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
					type="text"	value="<?php echo esc_attr($number); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat"
					id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" 
					value="<?php echo esc_attr($length); ?>" />
			</p> 
			<?php $row_number = array( '1' => 1, '2' => 2, '3' => 3 ); ?>
			<p>
				<label for="<?php echo $this->get_field_id('item_row'); ?>"><?php _e('Number row per column:  ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('item_row'); ?>"
					name="<?php echo $this->get_field_name('item_row'); ?>">
					<?php
					$option ='';
					foreach ($row_number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $item_row){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6); ?>
			<p>
				<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('columns'); ?>"
					name="<?php echo $this->get_field_name('columns'); ?>">
					<?php
					$option ='';
					foreach ($number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $columns){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<p>
				<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php _e('Number of Columns on 992px to 1199px: ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('columns1'); ?>"
					name="<?php echo $this->get_field_name('columns1'); ?>">
					<?php
					$option ='';
					foreach ($number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $columns1){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<p>
				<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php _e('Number of Columns on 768px to 991px: ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('columns2'); ?>"
					name="<?php echo $this->get_field_name('columns2'); ?>">
					<?php
					$option ='';
					foreach ($number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $columns2){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<p>
				<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php _e('Number of Columns on 480px to 767px: ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('columns3'); ?>"
					name="<?php echo $this->get_field_name('columns3'); ?>">
					<?php
					$option ='';
					foreach ($number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $columns3){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<p>
				<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php _e('Number of Columns in 480px or less than: ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('columns4'); ?>"
					name="<?php echo $this->get_field_name('columns4'); ?>">
					<?php
					$option ='';
					foreach ($number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $columns4){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<p>
				<label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
					<option value="false" <?php if ($autoplay=='false'){?> selected="selected"
					<?php } ?>>
						<?php _e('False', 'sw_woocommerce')?>
					</option>
					<option value="true" <?php if ($autoplay=='true'){?> selected="selected"	<?php } ?>>
						<?php _e('True', 'sw_woocommerce')?>
					</option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>"
					type="text"	value="<?php echo esc_attr($interval); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Speed', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>"
					type="text"	value="<?php echo esc_attr($speed); ?>" />
			</p>
			
			
			<p>
				<label for="<?php echo $this->get_field_id('scroll'); ?>"><?php _e('Total Items Slided', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>"
					type="text"	value="<?php echo esc_attr($scroll); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'sw_woocommerce')?></label>
				<br/>
				
				<select class="widefat"
					id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
					<option value="default" <?php if ($widget_template=='default'){?> selected="selected"
					<?php } ?>>
						<?php _e('Default', 'sw_woocommerce')?>		
					</option>			
					<option value="featured" <?php if ($widget_template=='featured'){?> selected="selected"
					<?php } ?>>
						<?php _e('Featured Slider', 'sw_woocommerce')?>
					</option>
					<option value="toprated" <?php if ($widget_template=='toprated'){?> selected="selected"
					<?php } ?>>
						<?php _e('Top Rated Slider', 'sw_woocommerce')?>
					</option>
					<option value="bestsales" <?php if ($widget_template=='bestsales'){?> selected="selected"
					<?php } ?>>
						<?php _e('Best Selling Slider', 'sw_woocommerce')?>
					</option>
					<option value="childcat" <?php if ($widget_template=='childcat'){?> selected="selected"
					<?php } ?>>
						<?php _e('Child Category Style 1', 'sw_woocommerce')?>
					</option>
					<option value="childcat1" <?php if ($widget_template=='childcat1'){?> selected="selected"
					<?php } ?>>
						<?php _e('Child Category Style 2', 'sw_woocommerce')?>
					</option>
				</select>
			</p>  
		<?php
		}	
	}
}
?>