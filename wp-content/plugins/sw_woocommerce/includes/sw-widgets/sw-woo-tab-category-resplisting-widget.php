<?php
/**
 SW Woo Tab Category Slider Widget 
 * Description: A widget that serves as an slideshow for developing more advanced widgets.
 * Version: 1.0
 *
 * This Widget help you to show images of product as a beauty tab reponsive slideshow
 */
 if ( !class_exists('sw_woo_tab_cat_resplisting_widget') ) {
	class sw_woo_tab_cat_resplisting_widget extends WP_Widget {
		
		private $snumber = 1;
		/**
		 * Widget setup.
		 */
		function __construct() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'sw_woo_tab_cat_resplisting', 'description' => __('Sw Woo Tab Responsive Listing', 'sw_woocommerce') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_woo_tab_cat_resplisting' );

			/* Create the widget. */
			parent::__construct( 'sw_woo_tab_cat_resplisting', __('Sw Woo Tab Responsive Listing widget', 'sw_woocommerce'), $widget_ops, $control_ops );
					
			add_shortcode( 'woo_tab_cat_resplisting', array( $this, 'SC_WooTab_Resp' ) );
			
			/* Create Vc_map */
			if (class_exists('Vc_Manager')) {
				add_action( 'vc_before_init', array( $this, 'SCRP_integrateWithVC' ) );
			}
			
			if( version_compare( WC()->version, '2.4', '>=' ) ){
				add_action( 'wc_ajax_sw_ajax_tab_listing', array( $this, 'sw_ajax_tab_listing_callback' ) );
			}else{
				add_action( 'wp_ajax_sw_ajax_tab_listing', array( $this, 'sw_ajax_tab_listing_callback') );
				add_action( 'wp_ajax_nopriv_sw_ajax_tab_listing', array( $this, 'sw_ajax_tab_listing_callback') );
			}
		}
		
		public function generateID() {
			return $this->id_base . '_' . (int) $this->snumber++;
		}
		
		/**
			* Add Vc Params
		**/
		function SCRP_integrateWithVC(){
			$terms = get_terms( 'product_cat', array( 'parent' => '' ) );
			$term = array( __( 'All Category Product', 'sw_woocommerce' ) => '' );
			foreach( $terms as $cat ){
				$term[$cat->name] = $cat -> slug;
			}
			vc_map( array(
			  "name" => __( "Woocommerce Tab Category Responsive", "sw_woocommerce" ),
			  "base" => "woo_tab_cat_resplisting",
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
					"type" => "my_param",
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
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Tab Active", "sw_woocommerce" ),
					"param_name" => "tab_active",
					"value" => 1,
					"description" => __( "Select tab active", "sw_woocommerce" )
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
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Layout", "sw_woocommerce" ),
					"param_name" => "layout",
					"value" => array( 'Layout Default' => 'default' ),
					"description" => __( "Layout", "sw_woocommerce" )
				 ),
			  )
		   ) );
		}
		/**
			** Add Shortcode
		**/
		function SC_WooTab_Resp( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title1' => '',
					'title_length' => 0,
					'category' => '',
					'orderby' => '',
					'order'	=> '',
					'numberposts' => 5,
					'tab_active' => 1,
					'columns' => 4,
					'columns1' => 4,
					'columns2' => 3,
					'columns3' => 2,
					'columns4' => 1,
					'layout'  => 'default',
				), $atts )
			);
			ob_start();		
			if( $layout == 'default' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-woo-tab-category-resplisting/default.php' );
			}
			
			$content = ob_get_clean();
			
			return $content;
		}
		
		function sw_ajax_tab_listing_callback(){
			$tag_id = 'countdown_time_'.rand().time();
			$cat 			 	 = ( isset( $_POST["catid"] )   	&& $_POST["catid"] != '' ) ? $_POST["catid"] : '';		
			$layout      = ( isset( $_POST["layout"] )  	&& $_POST["layout"] != '' ) ? $_POST["layout"] : 'default';
			$target      = ( isset( $_POST["target"] )  	&& $_POST["target"] != '' ) ? str_replace( '#', '', $_POST["target"] ) : '';
			$numberposts = ( isset( $_POST["number"] )  	&& $_POST["number"] > 0 ) ? $_POST["number"] : 0;
			$columns		 = ( isset( $_POST["columns"] )   && $_POST["columns"] > 0 ) ? $_POST["columns"] : 1;
			$columns1		 = ( isset( $_POST["columns1"] )  && $_POST["columns1"] > 0 ) ? $_POST["columns1"] : 1;
			$columns2		 = ( isset( $_POST["columns2"] )  && $_POST["columns2"] > 0 ) ? $_POST["columns2"] : 1;
			$columns3		 = ( isset( $_POST["columns3"] )  && $_POST["columns3"] > 0 ) ? $_POST["columns3"] : 1;
			$columns4		 = ( isset( $_POST["columns4"] )  && $_POST["columns4"] > 0 ) ? $_POST["columns4"] : 1;
			$interval		 = ( isset( $_POST["interval"] )  && $_POST["interval"] > 0 ) ? $_POST["interval"] : 1000;
			$speed			 = ( isset( $_POST["speed"] )  	  && $_POST["speed"] > 0 ) ? $_POST["speed"] : 1000;
			$scroll			 = ( isset( $_POST["scroll"] )  	&& $_POST["scroll"] > 0 ) ? $_POST["scroll"] : 1;
			$orderby 		 = ( isset( $_POST["orderby"] ) 	&& $_POST["orderby"] != '' ) ? $_POST["orderby"] : 'ID';
			$order 		   	 = ( isset( $_POST["order"] ) 	&& $_POST["order"] != '' ) ? $_POST["order"] : 'DESC';
			$autoplay		 = ( isset( $_POST["autoplay"] )  && $_POST["autoplay"] != '' ) ? $_POST["autoplay"] : 'false';
			$title_length 	 = ( isset( $_POST["title_length"] )  	&& $_POST["title_length"] > 0 ) ? $_POST["title_length"] : 0;
			$default = array(
				'post_type'	=> 'product',
				'tax_query'	=> array(
				array(
					'taxonomy'	=> 'product_cat',
					'field'		=> 'slug',
					'terms'		=> $cat )),
				'orderby' => $orderby,
				'order' => $order,
				'post_status' => 'publish',
				'showposts' => $numberposts
			);
		$list = new WP_Query( $default );
		if( $list->have_posts() ){
			$pkey = array();
			$parray = $list->posts;
			$array_list = array();
			$count = 0;
			$first_product = 0;
			/* Get All Sales Product Price and store in a array */
			foreach( $parray as $i => $item ){
				if( intval( get_post_meta( $item->ID, '_sale_price', true ) ) > 0 ){
					$pkey[$count] = $i;
					$array_list[$count] = intval( get_post_meta( $item->ID, '_sale_price', true ) );
					$count ++;
				}
			}
			/* Check min price and show position in array ( $parray ) */
			$pmin = $array_list[0];
			$main_key = 0;
			for( $i = 0; $i < count( $array_list ); $i++ ){
				if( $array_list[$i] < $pmin ){
					$main_key = $pkey[$i];
				}
			}
			$first_product = $parray[$main_key]->ID;
			unset( $parray[$main_key] );
			$parray =  array_values( $parray );
			$product_arr = array();
			foreach( $parray as $itemkey => $arr ){
				$product_arr[$itemkey] = $arr->ID;
			}
		?>
			<div class="woocat-resp-listing">
				<!-- First Product Best Price -->
				<?php	if( $first_product != 0 ): ?>
					<div class="resp-first-product pull-left">
					<?php 
						global $product, $post;
						$product 		= new WC_Product( $first_product );
						$start_time 	= get_post_meta( $first_product, '_sale_price_dates_from', true );
						$countdown_time = get_post_meta( $first_product, '_sale_price_dates_to', true );	
						$orginal_price 	= get_post_meta( $first_product, '_regular_price', true );	
						$sale_price 	= get_post_meta( $first_product, '_sale_price', true );	
						$symboy 		= get_woocommerce_currency_symbol( get_woocommerce_currency() );
					?>
						<div class="item-img">
							<?php sw_label_sales(); ?>
							<a href="<?php echo get_the_permalink( $product->id ); ?>"><?php echo get_the_post_thumbnail($product->id, 'full' ); ?></a>
						</div>
						<div class="item-content">	
							<h4><a href="<?php echo get_the_permalink( $product->id ); ?>"><?php sw_trim_words( $product->get_title(), $title_length ); ?></a></h4>																				
							<!-- rating  -->
							<?php 
								$rating_count = $product->get_rating_count();
								$review_count = $product->get_review_count();
								$average      = $product->get_average_rating();
							?>
							<div class="reviews-content">
								<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
								<div class="item-number-rating">
									<?php echo $review_count; _e(' Review(s)', 'sw_woocommerce');?>
								</div>
							</div>	
							<!-- end rating  -->
							<?php if ( $price_html = $product->get_price_html() ){?>
							<div class="item-price">
								<span>
									<?php echo $price_html; ?>
								</span>
							</div>
							<?php } ?>
							<!-- add to cart, wishlist, compare -->
							<div class="product-countdown"  data-price="<?php echo esc_attr( $symboy.$orginal_price ); ?>" data-starttime="<?php echo esc_attr( $start_time ); ?>" data-cdtime="<?php echo esc_attr( $countdown_time ); ?>" data-id="<?php echo 'product_'.$tag_id; ?>"></div>
						</div>
					<?php wp_reset_postdata(); ?>
					</div>
				<?php endif; ?>
				<!-- End First Product Best Price -->
				
				<!-- Product Content Tab -->	
					<?php $resp_class = '' ; ?>
					<div class="resp-content-product clearfix">
					<?php 
						$query = new WP_Query( array( 'post_type' => 'product', 'post__in' => $product_arr, 'posts_per_page' => count( $product_arr ) ) );
						while( $query->have_posts() ) : $query->the_post();
						global $product;
					?>
						<div class="item pull-left">
							<div class="item-wrap">
								<div class="item-detail">										
									<div class="item-img products-thumb">											
										<?php 
										    sw_label_sales();
											echo sw_quickview();
											the_post_thumbnail('medium');
										?>
									</div>										
									<div class="item-content">
										<h4><a href="<?php echo get_the_permalink( $post->ID ); ?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>																				
										<!-- rating  -->
										<?php 
											$rating_count = $product->get_rating_count();
											$review_count = $product->get_review_count();
											$average      = $product->get_average_rating();
										?>
										<div class="reviews-content">
											<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
										</div>	
										<!-- end rating  -->
										<?php if ( $price_html = $product->get_price_html() ){?>
										<div class="item-price">
											<span>
												<?php echo $price_html; ?>
											</span>
										</div>
										<?php } ?>
										<div class="add-info">
											<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
										</div>
									</div>											
								</div>
							</div>
						</div>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
					</div>
				<!-- End Product Content Tab -->	
				</div>
	<?php 
		}else{
			echo '<div class="alert alert-warning alert-dismissible" role="alert">
				<a class="close" data-dismiss="alert">&times;</a>
				<p>'. esc_html__( 'There is not product on this tab', 'sw_woocommerce' ) .'</p>
				</div>';
		}
		
		}

		/**
		 * Display the widget on the screen.
		 */
		public function widget( $args, $instance ) {
			extract($args);
			
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			echo $before_widget;
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }

			if ( !array_key_exists('widget_template', $instance) ){
				$instance['widget_template'] = 'default';
			}
			extract($instance);
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
			$dir = plugin_dir_path(dirname(__FILE__)).'/themes/sw-woo-tab-category-slider';
			
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

			if ( array_key_exists('category', $new_instance) ){
				if ( is_array($new_instance['category']) ){
					$instance['category'] = $new_instance['category'] ;
				} else {
					$instance['category'] = strip_tags( $new_instance['category'] );
				}
			}	
			
			if ( array_key_exists('orderby', $new_instance) ){
				$instance['orderby'] = strip_tags( $new_instance['orderby'] );
			}
			if ( array_key_exists('order', $new_instance) ){
				$instance['order'] = strip_tags( $new_instance['order'] );
			}
			if ( array_key_exists('numberposts', $new_instance) ){
				$instance['numberposts'] = intval( $new_instance['numberposts'] );
			}
			if ( array_key_exists('tab_active', $new_instance) ){
				$instance['tab_active'] = intval( $new_instance['tab_active'] );
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
			$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );
			
						
			
			return $instance;
		}

		function category_select( $field_name, $opts = array(), $field_value = null ){
			$default_options = array(
					'multiple' => true,
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
					//$allow_select_all = '<option value="">All Categories</option>';
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
			$defaults 				= array();
			$instance 				= wp_parse_args( (array) $instance, $defaults ); 		
			$title1						= isset( $instance['title1'] )      ? strip_tags($instance['title1']) : '';         
			$categoryid 			= isset( $instance['category']  ) 		? $instance['category'] : null;
			$orderby    			= isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
			$order      			= isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
			$number     			= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
			$tab_active    		= isset( $instance['tab_active'] )      ? intval($instance['tab_active']) : 1;
			$columns     			= isset( $instance['columns'] )      ? intval($instance['columns']) : 1;
			$columns1     		= isset( $instance['columns1'] )      ? intval($instance['columns1']) : 1;
			$columns2     		= isset( $instance['columns2'] )      ? intval($instance['columns2']) : 1;
			$columns3     		= isset( $instance['columns3'] )      ? intval($instance['columns3']) : 1;
			$columns4    			= isset( $instance['columns'] )      ? intval($instance['columns4']) : 1;
			$widget_template 	= isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
					   
					 
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
				<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
					type="text"	value="<?php echo esc_attr($number); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('tab_active'); ?>"><?php _e('Tab active: ', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat"
					id="<?php echo $this->get_field_id('tab_active'); ?>" name="<?php echo $this->get_field_name('tab_active'); ?>" type="text" 
					value="<?php echo esc_attr($tab_active); ?>" />
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
				<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'sw_woocommerce')?></label>
				<br/>
				
				<select class="widefat"
					id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
					<option value="default" <?php if ($widget_template=='default'){?> selected="selected"
					<?php } ?>>
						<?php _e('Default', 'sw_woocommerce')?>
					</option>				
				</select>
			</p>               
		<?php
		}		
	}
 }
?>