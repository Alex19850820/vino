<?php
/**
 * Name: SW Partner
 * Description: A widget that serves as an slider for developing more advanced widgets.
 */

if( !class_exists('sw_partner_slider_widget') ) :
	add_action( 'widgets_init', 'sw_partner_register' );
	function sw_partner_register(){
			register_widget( 'sw_partner_slider_widget' );
	}

	class sw_partner_slider_widget extends WP_Widget {

		/**
		 * Widget setup.
		 */
		function __construct(){
				/* Add Taxonomy and Post type */
			add_action( 'init', array( $this, 'partner_register' ), 5 );
			add_action( 'admin_init', array( $this, 'partner_init' ) );
			add_action( 'save_post', array( $this, 'partner_save_meta' ), 10, 1 );
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'sw_partner_slider', 'description' => __('Sw Partner Slider', 'sw_core') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_partner_slider' );

			/* Create the widget. */
			parent::__construct( 'sw_partner_slider', __('Sw Partner Slider widget', 'sw_core'), $widget_ops, $control_ops );
			
			/* Create Shortcode */
			add_shortcode( 'partner_slide', array( $this, 'PN_Shortcode' ) );
			
			/* Create Vc_map */
			if (class_exists('Vc_Manager')) {
				add_action( 'vc_before_init', array( $this, 'PN_integrateWithVC' ) );
			}
		}
		
		function partner_register() {
			$labels = array(
				'name' => __('Partner', 'sw_core'),
				'singular_name' => __('Partner Item', 'sw_core'),
				'add_new' => __('Add New', 'sw_core'),
				'add_new_item' => __('Add New Partner Item', 'sw_core'),
				'edit_item' => __('Edit Partner Item', 'sw_core'),
				'new_item' => __('New Partner Item', 'sw_core'),
				'view_item' => __('View Partner Item', 'sw_core'),
				'search_items' => __('Search Partner', 'sw_core'),
				'not_found' =>  __('Nothing found', 'sw_core'),
				'not_found_in_trash' => __('Nothing found in Trash', 'sw_core'),
				'parent_item_colon' => ''
			);

			$args = array(
				'labels' => $labels,
				'public' => true,
				'has_archive' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => 'dashicons-groups',
				'rewrite' =>  true,
				'capability_type' => 'post',
				'hierarchical' => true,
				'menu_position' => 4,
				'supports' => array('title','thumbnail','author','revisions')
				);

			register_post_type( 'partner' , $args );

			register_taxonomy("partners", array("partner"), array("hierarchical" => true, "label" => esc_html__( 'Categories Partner', 'sw_core' ), "singular_label" => "partner", 'rewrite' => true));
		}
		
		function partner_init(){
			add_meta_box( __( 'Partner Detail', 'sw_core' ), __( 'Partner Detail', 'sw_core' ), array( $this, 'partner_detail' ), 'partner', 'normal', 'low' );
		}
		
		function partner_detail(){
			wp_nonce_field( 'partner_save_meta', 'partner_plugin_nonce' );
			global $post;
			$link = get_post_meta( $post->ID, 'link', true );
			$target = get_post_meta( $post->ID, 'target', true );
			$description = get_post_meta( $post->ID, 'description', true );
			$tg_link = array( '_blank' => __( 'Blank', 'sw_core' ), '_self' => __( 'Self', 'sw_core' ), '_parent' => __('Parent', 'sw_core'), '_top' => __('Top', 'sw_core') );
		?>	
			<p><label><b><?php _e('Partner Link', 'sw_core'); ?>:</b></label><br/>
				<input type ="text" name = "link" value ="<?php echo esc_url( $link ); ?>" size="100%" /></p>
			<p><label><b><?php _e('Partner Link Target', 'sw_core'); ?>:</b></label><br/>
				<select name="target">
					<?php
						$option ='';
						foreach ($tg_link as $value => $key) :
							$option .= '<option value="' . esc_attr( $value ) . '" ';
							if ($value == $target){
								$option .= 'selected="selected"';
							}
							$option .=  '>'.$key.'</option>';
						endforeach;
						echo $option;
						?>
				</select>
			</p>
			
			<p><label><b><?php _e('Partner Description', 'sw_core'); ?>:</b></label><br/>
				<textarea type ="text" name = "description"rows="2" cols="100" /> <?php echo $description;?></textarea>
			</p>
			
		<?php }
		function partner_save_meta(){
			global $post;
			if ( ! isset( $_POST['partner_plugin_nonce'] ) ) {
				return;
			}
			if ( ! wp_verify_nonce( $_POST['partner_plugin_nonce'], 'partner_save_meta' ) ) {
				return;
			}
			$list_meta = array('link', 'target', 'description');
			foreach( $list_meta as $meta ){
				if( isset( $_POST[$meta] ) ){
					if( $_POST[$meta] == 'link' ) :
						$_POST[$meta] = esc_url( $_POST[$meta] );
					else: 
						$_POST[$meta] = sanitize_text_field( $_POST[$meta] );
					endif;
					$_POST[$meta] ;
					update_post_meta( $post->ID, $meta, $_POST[$meta] );
				}
			}
		}
		
		/**
		* Add Vc Params
		**/
		function PN_integrateWithVC(){
			$terms = get_terms( 'partners', array( 'parent' => 0, 'hide_emty' => 0 ) );
				if( count( $terms ) == 0 ){
					return ;
				}
				$term = array( __( 'All Categories Partner', 'sw_core' ) => '' );
				foreach( $terms as $cat ){
						 $term[$cat->name] = $cat -> term_id;
				}
			vc_map( array(
				"name" => __( "YA Partner Slider", 'sw_core' ),
				"base" => "partner_slide",
				"icon" => "icon-wpb-ytc",
				"class" => "",
				"category" => __( "My shortcodes", 'sw_core'),
				"params" => array(
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Title", 'sw_core' ),
					"param_name" => "title",
					"value" => "",
					"description" => __( "Title", 'sw_core' )
				 ),
				 array(
						"type" => "dropdown",
						"holder" => "div",
						"class" => "",
						"heading" => __( "Category Partner", 'sw_core' ),
						"param_name" => "partner_id",
						"value" => $term,
						"description" => __( "Select Categories ", 'sw_core' )
					 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Order By", 'sw_core' ),
					"param_name" => "orderby",
					"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Title' => 'title', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
					"description" => __( "Order By", 'sw_core' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Order", 'sw_core' ),
					"param_name" => "order",
					"value" => array('Descending' => 'DESC', 'Ascending' => 'ASC'),
					"description" => __( "Order", 'sw_core' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number Of Post", 'sw_core' ),
					"param_name" => "numberposts",
					"value" => 5,
					"description" => __( "Number Of Post", 'sw_core' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number row per column", 'sw_core' ),
					"param_name" => "item_row",
					"value" =>array(1,2,3),
					"description" => __( "Number row per column", 'sw_core' )
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
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Speed", 'sw_core' ),
					"param_name" => "speed",
					"value" => 1000,
					"description" => __( "Speed Of Slide", 'sw_core' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Auto Play", 'sw_core' ),
					"param_name" => "autoplay",
					"value" => array( 'True' => 'true', 'False' => 'false' ),
					"description" => __( "Auto Play", 'sw_core' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Interval", 'sw_core' ),
					"param_name" => "interval",
					"value" => 5000,
					"description" => __( "Interval", 'sw_core' )
				 ),
					array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Layout", 'sw_core' ),
					"param_name" => "layout",
					"value" => array( 'Layout Default' => '1', 'Layout 1' => 'layout1' ),
					"description" => __( "Layout", 'sw_core' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Total Items Slided", 'sw_core' ),
					"param_name" => "scroll",
					"value" => 1,
					"description" => __( "Total Items Slided", 'sw_core' )
				 ),
				 array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'sw_core' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_core' )
					),
				)
			 ) );
		}
		/**
			** Add Shortcode
		**/
		function PN_Shortcode( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title' => '',
					'header_style' => '',
					'partner_id'  => '',
					'style' => '',
					'orderby' => '',
					'order'	=> '',
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
					'layout'  => 1,
					'scroll' => 1,
					'el_class' => 'el class',
				), $atts )
			);
			ob_start();		
			if( $layout == 1 ){
				include( 'themes/default.php' );
			}
			
			$content = ob_get_clean();
			
			return $content;
		}
		
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
			extract($args);
			
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			echo $before_widget;
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
			
			if (!isset($instance['partner_id'])){
				$instance['partner_id'] = 0;
			}
			
			extract($instance);

			if ( !array_key_exists('widget_template', $instance) ){
				$instance['widget_template'] = 'default';
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
			$dir =realpath(dirname(__FILE__)).'/themes';
			
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

	
			$instance['title'] = strip_tags( $new_instance['title'] );

	
			if ( array_key_exists('partner_id', $new_instance) ){
				if ( is_array($new_instance['partner_id']) ){
					$instance['partner_id'] = array_map( 'intval', $new_instance['partner_id'] );
				} else {
					$instance['partner_id'] = intval($new_instance['partner_id']);
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
			if ( array_key_exists('scroll', $new_instance) ){
				$instance['scroll'] = intval( $new_instance['scroll'] );
			}
			if ( array_key_exists('effect', $new_instance) ){
				$instance['effect'] = strip_tags( $new_instance['effect'] );
			}
			if ( array_key_exists('el_class', $new_instance) ){
				$instance['el_class'] = strip_tags( $new_instance['el_class'] );
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
			} else {
			
				unset($opts['multiple']);
				unset($opts['size']);
				if (is_array($field_value)){
					$field_value = array_shift($field_value);
				}
				if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
					unset($opts['allow_select_all']);
					$allow_select_all = '<option value="0">All Categories</option>';
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
			
			$categories = get_terms('partners');
			
			$all_category_ids = array();
			foreach ($categories as $cat) $all_category_ids[] = (int)$cat->term_id;
			
			$is_valid_field_value = is_numeric($field_value) && in_array($field_value, $all_category_ids);
			if (!$is_valid_field_value && is_array($field_value)){
				$intersect_values = array_intersect($field_value, $all_category_ids);
				$is_valid_field_value = count($intersect_values) > 0;
			}
			if (!$is_valid_field_value){
				$field_value = '0';
			}
		
			$select_html = '<select ' . $select_attributes . '>';
			if (isset($allow_select_all)) $select_html .= $allow_select_all;
			foreach ($categories as $cat){
				$select_html .= '<option value="' . $cat->term_id . '"';
				if ($cat->term_id == $field_value || (is_array($field_value)&&in_array($cat->term_id, $field_value))){ $select_html .= ' selected="selected"';}
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
			$title    = isset( $instance['title'] )     ? strip_tags($instance['title']) : '';      
			$partner_id = isset( $instance['partner_id'] )    ? $instance['partner_id'] : 0;
			$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
			$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
			$number     = isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
					$length     = isset( $instance['length'] )      ? intval($instance['length']) : 25;
			$item_row     = isset( $instance['item_row'] )      ? intval($instance['item_row']) : 1;
			$columns     = isset( $instance['columns'] )      ? intval($instance['columns']) : '';
			$columns1     = isset( $instance['columns1'] )      ? intval($instance['columns1']) : '';
			$columns2     = isset( $instance['columns2'] )      ? intval($instance['columns2']) : '';
			$columns3     = isset( $instance['columns3'] )      ? intval($instance['columns3']) : '';
			$columns4     = isset( $instance['columns'] )      ? intval($instance['columns4']) : '';
			$interval     = isset( $instance['interval'] )      ? intval($instance['interval']) : 5000;
			$autoplay     = isset( $instance['autoplay'] )      ? strip_tags($instance['autoplay']) : 'true';
			$speed     = isset( $instance['speed'] )      ? intval($instance['speed']) : 1000;
			$scroll     = isset( $instance['scroll'] )      ? intval($instance['scroll']) : 1;
			$effect     = isset( $instance['effect'] )      ? strip_tags($instance['effect']) : 'slide';
			$el_class     = isset( $instance['el_class'] )      ? strip_tags($instance['el_class']) : '';
			$widget_template   = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
										 
									 
			?>
					</p> 
						<div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
					</p>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sw_core')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
					type="text"	value="<?php echo esc_attr($title); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('partner_id'); ?>"><?php _e('Category ID', 'sw_core')?></label>
				<br />
				<?php echo $this->category_select('partner_id', array('allow_select_all' => true), $partner_id); ?>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', 'sw_core')?></label>
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
				<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'sw_core')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
					<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
					<?php } ?>>
						<?php _e('Descending', 'sw_core')?>
					</option>
					<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"	<?php } ?>>
						<?php _e('Ascending', 'sw_core')?>
					</option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'sw_core')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
					type="text"	value="<?php echo esc_attr($number); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'sw_core')?></label>
				<br />
				<input class="widefat"
					id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" 
					value="<?php echo esc_attr($length); ?>" />
			</p>
		<?php $row_number = array('1' => 1, '2' => 2, '3' => 3); ?>
			<p>
				<label for="<?php echo $this->get_field_id('item_row'); ?>"><?php _e('Number row per column:  ', 'sw_core')?></label>
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
			
			<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' =>  7, '8' => 8); ?>
			<p>
				<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', 'sw_core')?></label>
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
				<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php _e('Number of Columns on 992px to 1199px: ', 'sw_core')?></label>
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
				<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php _e('Number of Columns on 768px to 991px: ', 'sw_core')?></label>
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
				<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php _e('Number of Columns on 480px to 767px: ', 'sw_core')?></label>
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
				<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php _e('Number of Columns in 480px or less than: ', 'sw_core')?></label>
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
				<label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play', 'sw_core')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
					<option value="false" <?php if ($autoplay=='false'){?> selected="selected"
					<?php } ?>>
						<?php _e('False', 'sw_core')?>
					</option>
					<option value="true" <?php if ($autoplay=='true'){?> selected="selected"	<?php } ?>>
						<?php _e('True', 'sw_core')?>
					</option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'sw_core')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>"
					type="text"	value="<?php echo esc_attr($interval); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Speed', 'sw_core')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>"
					type="text"	value="<?php echo esc_attr($speed); ?>" />
			</p>
			
			
			<p>
				<label for="<?php echo $this->get_field_id('scroll'); ?>"><?php _e('Total Items Slided', 'sw_core')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>"
					type="text"	value="<?php echo esc_attr($scroll); ?>" />
			</p>	
			
			<p>
				<label for="<?php echo $this->get_field_id('el_class'); ?>"><?php _e('Extra Class', 'sw_core')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('el_class'); ?>" name="<?php echo $this->get_field_name('el_class'); ?>"
					type="text"	value="<?php echo esc_attr($el_class); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'sw_core')?></label>
				<br/>
				
				<select class="widefat"
					id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
					<option value="default" <?php if ($widget_template=='default'){?> selected="selected"
					<?php } ?>>
						<?php _e('Default', 'sw_core')?>
					</option>				
				</select>
			</p>               
		<?php
		}	
	}
	
endif;
?>