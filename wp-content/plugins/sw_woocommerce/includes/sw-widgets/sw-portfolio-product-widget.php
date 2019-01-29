<?php
/**
	* SW Woocommerce Portfolio Product
	* Register Widget Woocommerce Slider
	* @author 		Smartaddons
	* @version     1.0.0
**/
if ( !class_exists('sw_portfolio_product_widget') ) {
	class sw_portfolio_product_widget extends WP_Widget {
		/**
		 * Widget setup.
		 */
		function __construct(){
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'sw_portfolio_product_widget', 'description' => __('Sw Portfolio Product', 'sw_woocommerce') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_portfolio_product_widget' );

			/* Create the widget. */
			parent::__construct( 'sw_portfolio_product_widget', __('Sw Portfolio Product widget', 'sw_woocommerce'), $widget_ops, $control_ops );
			
			/* Create Shortcode */
			add_shortcode( 'product_listing', array( $this, 'PL_Shortcode' ) );
			
			/* Create Vc_map */
			if ( class_exists('Vc_Manager') ) {
				add_action( 'vc_before_init', array( $this, 'PL_integrateWithVC' ), 20 );
			}
			
			add_action( 'admin_init', array( $this, 'PL_init') );
			add_action( 'save_post', array( $this, 'PL_save_meta' ), 10, 1 );
			
			/* Add ajax */
			add_action( 'wp_ajax_sw_portfolio_product_ajax', array( $this, 'sw_portfolio_product_ajax') );
			add_action( 'wp_ajax_nopriv_sw_portfolio_product_ajax', array( $this, 'sw_portfolio_product_ajax') );
		}
		
		public function PL_init(){
		add_meta_box( __( 'Product Meta', 'sw_woocommerce' ), __( 'Product Meta', 'sw_woocommerce' ), array( $this, 'PL_detail' ), 'product', 'normal', 'low' );
	}
	
	public function PL_detail(){
		global $post;
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'PL_save_meta', 'PL_plugin_nonce' );
		
		$short_title 		= get_post_meta( $post->ID, 'short_title', true );	
		$short_desc 		= get_post_meta( $post->ID, 'short_desc', true );	
		$demo_url 			= get_post_meta( $post->ID, 'demo_url', true );	
		$buy_now	 		= get_post_meta( $post->ID, 'buy_now', true );
		$update	 			= get_post_meta( $post->ID, 'update', true );
		$version	 		= get_post_meta( $post->ID, 'version', true );
		$compatibility 		= get_post_meta( $post->ID, 'compatibility', true );
		$document 			= get_post_meta( $post->ID, 'document', true );
		$discussion 		= get_post_meta( $post->ID, 'discussion', true );
		$help 				= get_post_meta( $post->ID, 'help', true );
		$path_img       	= get_post_meta( $post->ID, 'path_img', true );
		$main_featured      = get_post_meta( $post->ID, 'main_featured', true );

	?>	
		<div>
			<p><label><b><?php _e('Short Title', 'sw_woocommerce'); ?>:</b></label><br/>
				<input type ="text" name = "short_title" value ="<?php echo esc_attr( $short_title );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Short Description', 'sw_woocommerce'); ?>:</b></label><br/>
				<textarea type ="text" name = "short_desc" rows="4" cols="70"/><?php echo $short_desc ;?></textarea>
			</p>
			<p><label><b><?php _e('Demo Link', 'sw_woocommerce'); ?>:</b></label><br/>
				<input type ="text" name = "demo_url" value ="<?php echo esc_attr( $demo_url );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Buy Now Link', 'sw_woocommerce'); ?>:</b></label><br/>
				<input type ="text" name = "buy_now" value ="<?php echo esc_attr( $buy_now );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Update', 'sw_woocommerce'); ?>:</b></label><br/>
				<input type ="text" name = "update" value ="<?php echo esc_attr( $update );?>" size="40" />
			</p>
			<p><label><b><?php _e('Version', 'sw_woocommerce'); ?>:</b></label><br/>
				<input type ="text" name = "version" value ="<?php echo esc_attr( $version );?>" size="40" />
			</p>
			<p><label><b><?php _e('Compatibility', 'sw_woocommerce'); ?>:</b></label><br/>
				<input type ="text" name = "compatibility" value ="<?php echo esc_attr( $compatibility );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Document Link', 'sw_woocommerce'); ?>:</b></label><br/>
				<input type ="text" name = "document" value ="<?php echo esc_attr( $document );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Discussion Link', 'sw_woocommerce'); ?>:</b></label><br/>
				<input type ="text" name = "discussion" value ="<?php echo esc_attr( $discussion );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Help Link', 'sw_woocommerce'); ?>:</b></label><br/>
				<input type ="text" name = "help" value ="<?php echo esc_attr( $help );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Path folder image', 'sw_woocommerce'); ?>:</b></label><br/>
				<input type ="text" name = "path_img" value ="<?php echo esc_attr( $path_img );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Main Featured', 'sw_woocommerce'); ?>:</b></label><br/>
				<?php wp_editor( $main_featured, 'main_featured', $settings = array() ); ?> 				
			</p>
		</div>		
	<?php 
	}
	
	function PL_save_meta( $post ){
		global $post;
		if ( ! isset( $_POST['PL_plugin_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['PL_plugin_nonce'], 'PL_save_meta' ) ) {
			return;
		}
		$list_meta = array( 'short_title', 'short_desc', 'buy_now', 'demo_url', 'update', 'version', 'compatibility', 'document', 'discussion', 'help', 'path_img', 'main_featured' );
		foreach( $list_meta as $meta ){
			if( isset( $_POST[$meta] ) ){
				update_post_meta( $post->ID, $meta, $_POST[$meta] );
			}else{
				delete_post_meta($post->ID, $meta);
			}
		}
	}
		/**
		* Add Vc Params
		**/
		function PL_integrateWithVC(){
			$terms = get_terms( 'product_cat', array( 'parent' => '', 'hide_emty' => false ) );
			if( count( $terms ) == 0 ){
				return ;
			}
			$term = array( __( 'Select Categories', 'sw_woocommerce' ) => '' );
			foreach( $terms as $cat ){
				$term[$cat->name] = $cat -> slug;
			}
			vc_map( array(
			  "name" => __( "SW Woocommerce Portfolio", "sw_woocommerce" ),
			  "base" => "product_listing",
			  "icon" => "icon-wpb-ytc",
			  "class" => "",
			  "category" => __( "SW Shortcodes", "sw_woocommerce"),
			  "params" => array(
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Title", "sw_woocommerce" ),
					"param_name" => "title",
					"value" => '',
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
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Description", "sw_woocommerce" ),
					"param_name" => "description",
					"value" => '',
					"description" => __( "Description", "sw_woocommerce" )
				 ),	
				  array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Header Style", "sw_woocommerce" ),
					"param_name" => "style",
					"value" => array( 'Style 1' => 'style1', 'Style 2' => 'style2' ),
					"description" => __( "Header Style", "sw_woocommerce" )
				 ),
				  array(
					"type" => "checkbox",
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
					"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
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
					"heading" => __( "Interval", "sw_woocommerce" ),
					"param_name" => "interval",
					"value" => 5000,
					"description" => __( "Interval", "sw_woocommerce" )
				 ),array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Layout", "sw_woocommerce" ),
					"param_name" => "layout",
					"value" => array( 'Layout Default' => 'default' ),
					"description" => __( "Layout", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Button More", "sw_woocommerce" ),
					"param_name" => "btmore",
					"value" => array( 'Link' => 'default', 'Ajax Load' => 'ajax' ),
					"description" => __( "Select type of button see more product", "sw_woocommerce" )
				 ),		
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Enable Search", "sw_woocommerce" ),
					"param_name" => "search_anable",
					"value" => array( 'No' => 'no', 'Yes' => 'yes' ),
					"description" => __( "Enable search box.", "sw_woocommerce" )
				 ),				 
			  )
		   ) );
		}
		/**
			** Add Shortcode
		**/
		function PL_Shortcode( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title' => '',	
					'title_length' => 0,
					'description' => '',
					'style' => 'style1',
					'orderby' => 'name',
					'order'	=> 'DESC',
					'category' => '',
					'numberposts' => 5,
					'length' => 25,
					'columns' => 4,
					'columns1' => 4,
					'columns2' => 3,
					'columns3' => 2,
					'columns4' => 1,
					'layout'  => 'default',
					'btmore'  => 'default',
					'search_anable'  => 'no',
				), $atts )
			);
			ob_start();	
			
			if( $layout == 'default' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-portfolio-product/default.php' );
			} 		
			
			$content = ob_get_clean();			
			return $content;
		}
		
		/*
		** Ajax Callback
		*/
		public function sw_portfolio_product_ajax(){
			$catid 			= ( isset( $_POST["catid"] )   		&& $_POST["catid"] != '' ) ? $_POST["catid"] : '';
			$page 			= ( isset( $_POST["page"]) ) 	? $_POST["page"] : 1;
			$attributes 	= ( isset( $_POST["attributes"] )  && $_POST["attributes"] != '' ) ? $_POST["attributes"] : '';
			$number 		= ( isset( $_POST["numb"] ) ) ? $_POST["numb"] : 0;
			$orderby 		= ( isset( $_POST["orderby"] ) 		&& $_POST["orderby"] != '' ) ? $_POST["orderby"] : '';
			$order 			= ( isset( $_POST["order"] ) 			&& $_POST["order"] != '' ) ? $_POST["order"] : '';
			$paged 			= ( get_query_var('paged') ) ? get_query_var('paged') : 1;
			$title_length 	= ( isset( $_POST["title_length"] )  	&& $_POST["title_length"] > 0 ) ? $_POST["title_length"] : 0;
			$category 	= explode( ',', $catid );
				
			$default = array(
				'post_type'	=> 'product',
				'tax_query'	=> array(
					array(
						'taxonomy'	=> 'product_cat',
						'field'		=> 'slug',
						'terms'		=> $category
					) 
				),
				'orderby' => $orderby,
				'order' => $order,
				'post_status' => 'publish',
				'showposts' => $number,
				'offset' => $number*$page
			);
			$list = new WP_Query( $default );
			while( $list->have_posts() ) : $list->the_post();
			global $product, $post;
			$pterms	= get_the_terms( $post->ID, 'product_cat' );
			$term_str = '';
			if( count($pterms) > 0 ){
				foreach( $pterms as $key => $term ){
					$term_str .= $term -> slug . ' ';
				}
			}
		?>
			<li class="portfolio-product-item <?php echo esc_attr( $term_str . $attributes ); ?>" >
				<div class="item-wrap">
					<div class="item-img products-thumb">			
							<?php echo ya_product_thumbnail('full') ?>
							<div class="add-info">
							<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
							<!-- quickview & thumbnail  -->
							<?php echo sw_quickview() ?>
							<!-- end quickview & thumbnail  -->
							</div>
					
					</div>	
				    <div class="item-content">	
							<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>															
							<!-- price -->
							<?php if ( $price_html = $product->get_price_html() ){?>
								<div class="item-price">
									<span>
										<?php echo $price_html; ?>
									</span>
								</div>
							<?php } ?>	
					</div>					
				</div>
			</li>
		<?php 
			endwhile; wp_reset_postdata();
			exit();
		}
		public static function addOtherItem($arr, $str, $_index, &$output)  {
	        $output = array_merge(array_slice($arr, 0, $_index), $str, array_slice($arr, $_index));
	        $_index = $_index + 5;
	        if ($_index < count($output) - 1) {
	            $_index++;
	            self::addOtherItem($output, $str, $_index, $output);
	        }
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
			echo $before_widget;			
			if ( !isset($instance['category']) ){
				$instance['category'] = array();
			}
			$id = $this -> number;
			extract($instance);

			if ( !array_key_exists('widget_template', $instance) ){
				$instance['widget_template'] = 'default';
			}
			if ( !class_exists( 'WooCommerce' ) ) { 
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
			$dir =	plugin_dir_path(dirname(__FILE__)).'/themes/sw-portfolio-product';
			
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
			$instance['description'] = strip_tags( $new_instance['description'] );
			// int or array
			if ( array_key_exists('category', $new_instance) ){
				if ( is_array($new_instance['category']) ){
					$instance['category'] = $new_instance['category'];
				} else {
					$instance['category'] = $new_instance['category'];
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
					$allow_select_all = '<option value="">All Categories</option>';
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
					 
			$title1 			= isset( $instance['title1'] )    		? 	strip_tags($instance['title1']) : '';
			$description 		= isset( $instance['description'] )    	? 	strip_tags($instance['description']) : '';
			$categoryid 		= isset( $instance['category'] )  		? $instance['category'] : '';
			$orderby    		= isset( $instance['orderby'] )     	? strip_tags($instance['orderby']) : 'ID';
			$order      		= isset( $instance['order'] )       	? strip_tags($instance['order']) : 'ASC';
			$number     		= isset( $instance['numberposts'] ) 	? intval($instance['numberposts']) : 5;
			$length     		= isset( $instance['length'] )      	? intval($instance['length']) : 25;
			$item_row     		= isset( $instance['item_row'] )      	? intval($instance['item_row']) : 1;
			$columns     		= isset( $instance['columns'] )      	? intval($instance['columns']) : 1;
			$columns1     		= isset( $instance['columns1'] )     	? intval($instance['columns1']) : 1;
			$columns2     		= isset( $instance['columns2'] )      	? intval($instance['columns2']) : 1;
			$columns3     		= isset( $instance['columns3'] )      	? intval($instance['columns3']) : 1;
			$columns4     		= isset( $instance['columns'] )      	? intval($instance['columns4']) : 1;
			$autoplay     		= isset( $instance['autoplay'] )      	? strip_tags($instance['autoplay']) : 'false';
			$interval     		= isset( $instance['interval'] )      	? intval($instance['interval']) : 5000;
			$speed     			= isset( $instance['speed'] )      		? intval($instance['speed']) : 1000;
			$scroll     		= isset( $instance['scroll'] )      	? intval($instance['scroll']) : 1;
			$widget_template   	= isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
					   
					 
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
				<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"
					type="text"	value="<?php echo esc_attr($description); ?>" />
			</p>
			
			<p id="wgd-<?php echo $this->get_field_id('category'); ?>">
				<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category', 'sw_woocommerce')?></label>
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