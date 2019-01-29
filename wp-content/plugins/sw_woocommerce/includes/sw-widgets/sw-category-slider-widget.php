<?php
/**
	* SW Woocommerce Categories Slider
	* Register Widget Woocommerce Categories Slider
	* @author 		SmartAddons
	* @version     1.0.0
**/
if ( !class_exists('sw_woo_cat_slider_widget') ) {
	class sw_woo_cat_slider_widget extends WP_Widget { 
	
		private $snumber = 1;
		
		/**
		 * Widget setup.
		 */
		function __construct(){
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'sw_woo_cat_slider_widget', 'description' => __('Sw Woo Categories Slider', 'sw_woocommerce') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_woo_cat_slider_widget' );

			/* Create the widget. */
			parent::__construct( 'sw_woo_cat_slider_widget', __('Sw Woo Categories Slider widget', 'sw_woocommerce'), $widget_ops, $control_ops );
					
			/* Create Shortcode */
			add_shortcode( 'woocat_slide', array( $this, 'WSC_Shortcode' ) );
			
			/* Create Vc_map */
			if ( class_exists('Vc_Manager') ) {
				add_action( 'vc_before_init', array( $this, 'WSC_integrateWithVC' ), 10 );
			}
			/* Add Custom field to category product */
			add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ), 100 );
			add_action( 'product_cat_edit_form_fields', array( $this, 'edit_category_fields' ), 100 );
			add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
			add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );
			
			/* Ajax Call */
			
			if( version_compare( WC()->version, '2.4', '>=' ) ){
				add_action( 'wc_ajax_sw_category_callback', array( $this, 'sw_category_callback' ) );
				add_action( 'wc_ajax_sw_category_ajax_listing', array( $this, 'sw_category_ajax_listing' ) );
				add_action( 'wc_ajax_sw_category_mobile_callback', array( $this, 'sw_category_mobile_callback') );
			}else{
				add_action( 'wp_ajax_sw_category_callback', array( $this, 'sw_category_callback') );
				add_action( 'wp_ajax_nopriv_sw_category_callback', array( $this, 'sw_category_callback') );
				add_action( 'wp_ajax_sw_category_ajax_listing', array( $this, 'sw_category_ajax_listing') );
				add_action( 'wp_ajax_nopriv_sw_category_ajax_listing', array( $this, 'sw_category_ajax_listing') );
				/* Ajax Call Mobile */
				add_action( 'wp_ajax_sw_category_mobile_callback', array( $this, 'sw_category_mobile_callback') );
				add_action( 'wp_ajax_nopriv_sw_category_mobile_callback', array( $this, 'sw_category_mobile_callback') );
			}			
		}
		
		/*
		** Generate ID
		*/
		public function generateID() {
			return $this->id_base . '_' . (int) $this->snumber++;
		}
		
		/*
		** Get Count category level 1
		*/
		function sw_count_category( $number = 1 ){
			global $wpdb;
			$values = 1;
			$count = $wpdb->get_var($wpdb->prepare( "SELECT count(`term_id`) FROM `$wpdb->term_taxonomy` WHERE `taxonomy`='%s' AND `parent` = 0", 'product_cat' ) );
			if( $number > 0 && $count > $number ) {
				$values = ceil($count/$number);
			}
			return $values;
		}
		/**
		* Add Vc Params
		**/
		function WSC_integrateWithVC(){
			$terms = get_terms( 'product_cat', array( 'parent' => 0, 'hide_emty' => false ) );
			if( count( $terms ) == 0 ){
				return ;
			}
			$term = array( __( 'Select Categories', 'sw_woocommerce' ) => '' );
			foreach( $terms as $cat ){
				$term[$cat->name] = $cat -> slug;
			}
			vc_map( array(
			  "name" => __( "YA Woo Categories Slider", "sw_woocommerce" ),
			  "base" => "woocat_slide",
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
					"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'layout2', 'layout3', 'layout4' ) ,
					),
				),
				  array(
					"type" => "my_param",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Categories", "sw_woocommerce" ),
					"param_name" => "category",
					"value" => $term,
					"description" => __( "Select Categories", "sw_woocommerce" )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number Of Post", "sw_woocommerce" ),
					"param_name" => "numberposts",
					"value" => 5,
					"description" => __( "Number of post for layout 2", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Order By", "sw_woocommerce" ),
					"param_name" => "orderby",
					"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Title' => 'title', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
					"description" => __( "Order by for layout 2", "sw_woocommerce" )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number row per column", "sw_woocommerce" ),
					"param_name" => "item_row",
					"value" =>array(1,2,3),
					"description" => __( "Number row per column", "sw_woocommerce" ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'layout2', 'layout1' ) ,
					),
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
					"heading" => __( "Tab Active", "sw_woocommerce" ),
					"param_name" => "tab_active",
					"value" => 1,
					"description" => __( "Select tab active", "sw_woocommerce" )
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
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Layout", "sw_woocommerce" ),
					"param_name" => "layout",
					"value" => array( 'Layout Default' => 'layout1', 'Layout Category Ajax' => 'layout2','Layout Popular' =>'layout3','Layout Mobile Ajax' => 'layout4','Layout Listting Ajax' => 'layout5' ),
					"description" => __( "Layout", "sw_woocommerce" )
				 ),
				array(
					'type' => 'textfield',
					'heading' => __( 'Link View All', 'sw_woocommerce' ),
					'param_name' => 'viewall',
					'value' =>'',
					'description' => __( 'Link View All', 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => 'layout4',
					 )
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
		function WSC_Shortcode( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title1' => '',
					'title_length' => 0,
					'orderby' => '',
					'category' => '',
					'item_row'	=> 1,
					'viewall' => '',
					'numberposts' => 5,
					'columns' => 4,
					'columns1' => 4,
					'columns2' => 3,
					'columns3' => 2,
					'columns4' => 1,
					'speed' => 1000,
					'tab_active' => 1,
					'autoplay' => 'true',
					'interval' => 5000,
					'layout'  => 'layout1',
					'scroll' => 1
				), $atts )
			);
			ob_start();		
			if( $layout == 'layout1' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/category-slider/default.php' );			
			}elseif( $layout == 'layout2' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/category-slider/category_ajax.php' );			
			}elseif( $layout == 'layout3' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/category-slider/popular.php' );			
			}
			elseif( $layout == 'layout4' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/category-slider/category_mobile_ajax.php' );	
			}
			elseif( $layout == 'layout5' ){
				include( plugin_dir_path(dirname(__FILE__)).'/themes/category-slider/category_listing_ajax.php' );	
			}
			$content = ob_get_clean();
			
			return $content;
		}
		
		/**
		*	Add Custom field on category product
		**/
		public function add_category_fields() { 
	?>
			<div class="form-field">
				<label><?php _e( 'Thumbnail 1', 'woocommerce' ); ?></label>
				<div id="product_cat_thumbnail1" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_cat_thumbnail_id1" name="product_cat_thumbnail_id1" />
					<button type="button" class="upload_image_button1 button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" class="remove_image_button1 button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( ! jQuery( '#product_cat_thumbnail_id1' ).val() ) {
						jQuery( '.remove_image_button1' ).hide();
					}

					// Uploading files
					var file_frame1;

					jQuery( document ).on( 'click', '.upload_image_button1', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame1 ) {
							file_frame1.open();
							return;
						}

						// Create the media frame.
						file_frame1 = wp.media.frames.downloadable_file = wp.media({
							title: '<?php _e( "Choose an image", "woocommerce" ); ?>',
							button: {
								text: '<?php _e( "Use image", "woocommerce" ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame1.on( 'select', function() {
							var attachment = file_frame1.state().get( 'selection' ).first().toJSON();
							
							jQuery( '#product_cat_thumbnail_id1' ).val( attachment.id );
							jQuery( '#product_cat_thumbnail1 > img' ).attr( 'src', attachment.sizes.thumbnail.url );
							jQuery( '.remove_image_button1' ).show();
						});

						// Finally, open the modal.
						file_frame1.open();
					});

					jQuery( document ).on( 'click', '.remove_image_button1', function() {
						jQuery( '#product_cat_thumbnail1 img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#product_cat_thumbnail_id1' ).val( '' );
						jQuery( '.remove_image_button1' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</div>
			<?php
		}
		
		public function edit_category_fields( $term ) {

			$thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id1', true ) );

			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = wc_placeholder_img_src();
			}
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label><?php _e( 'Thumbnail 1', 'woocommerce' ); ?></label></th>
				<td>
					<div id="product_cat_thumbnail1" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
					<div style="line-height: 60px;">
						<input type="hidden" id="product_cat_thumbnail_id1" name="product_cat_thumbnail_id1" value="<?php echo $thumbnail_id; ?>" />
						<button type="button" class="upload_image_button1 button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
						<button type="button" class="remove_image_button1 button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
					</div>
					<script type="text/javascript">

						// Only show the "remove image" button when needed
						if ( '0' === jQuery( '#product_cat_thumbnail_id1' ).val() ) {
							jQuery( '.remove_image_button1' ).hide();
						}

						// Uploading files
						var file_frame1;

						jQuery( document ).on( 'click', '.upload_image_button1', function( event ) {

							event.preventDefault();

							// If the media frame already exists, reopen it.
							if ( file_frame1 ) {
								file_frame1.open();
								return;
							}

							// Create the media frame.
							file_frame1 = wp.media.frames.downloadable_file = wp.media({
								title: '<?php _e( "Choose an image", "woocommerce" ); ?>',
								button: {
									text: '<?php _e( "Use image", "woocommerce" ); ?>'
								},
								multiple: false
							});

							// When an image is selected, run a callback.
							file_frame1.on( 'select', function() {
								var attachment = file_frame1.state().get( 'selection' ).first().toJSON();

								jQuery( '#product_cat_thumbnail_id1' ).val( attachment.id );
								jQuery( '#product_cat_thumbnail1 img' ).attr( 'src', attachment.sizes.thumbnail.url );
								jQuery( '.remove_image_button1' ).show();
							});

							// Finally, open the modal.
							file_frame1.open();
						});

						jQuery( document ).on( 'click', '.remove_image_button1', function() {
							jQuery( '#product_cat_thumbnail1 img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
							jQuery( '#product_cat_thumbnail_id1' ).val( '' );
							jQuery( '.remove_image_button1' ).hide();
							return false;
						});

					</script>
					<div class="clear"></div>
				</td>
			</tr>
			<?php
		}
		public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
			if ( isset( $_POST['product_cat_thumbnail_id1'] ) && 'product_cat' === $taxonomy ) {
				update_woocommerce_term_meta( $term_id, 'thumbnail_id1', absint( $_POST['product_cat_thumbnail_id1'] ) );
			}
		}
		/**
		* Ajax Callback
		**/
		function sw_category_callback(){
			$catid 			= ( isset( $_POST["catid"] )   	 && $_POST["catid"] != '' ) ? intval( $_POST["catid"] ) : 0;
			$numberposts	= ( isset( $_POST["number"] )  && $_POST["number"] > 0 ) ? $_POST["number"] : 0;
			$layout     	= ( isset( $_POST["layout"] )  	&& $_POST["layout"] != '' ) ? $_POST["layout"] : 'layout1';
			$item_row    	= ( isset( $_POST["item_row"] )  && $_POST["item_row"] > 0 ) ? $_POST["item_row"] : 1;
			$orderby 		= ( isset( $_POST["orderby"] ) 	 && $_POST["orderby"] != '' ) ? $_POST["orderby"] : 'ID';
			$columns		= ( isset( $_POST["columns"] )   && $_POST["columns"] > 0 ) ? $_POST["columns"] : 1;
			$columns1		= ( isset( $_POST["columns1"] )  && $_POST["columns1"] > 0 ) ? $_POST["columns1"] : 1;
			$columns2		= ( isset( $_POST["columns2"] )  && $_POST["columns2"] > 0 ) ? $_POST["columns2"] : 1;
			$columns3		= ( isset( $_POST["columns3"] )  && $_POST["columns3"] > 0 ) ? $_POST["columns3"] : 1;
			$columns4		= ( isset( $_POST["columns4"] )  && $_POST["columns4"] > 0 ) ? $_POST["columns4"] : 1;
			$interval		= ( isset( $_POST["interval"] )  && $_POST["interval"] > 0 ) ? $_POST["interval"] : 1000;
			$speed			= ( isset( $_POST["speed"] )  	 && $_POST["speed"] > 0 ) ? $_POST["speed"] : 1000;
			$scroll			= ( isset( $_POST["scrollx"] )   && $_POST["scrollx"] !='' ) ? $_POST["scrollx"] : 'true';
			$rtl			= ( isset( $_POST["rtl"] )  && $_POST["number"] !='' ) ? $_POST["rtl"] : 'false';
			$autoplay		= ( isset( $_POST["autoplay"] )  && $_POST["autoplay"] != '' ) ? $_POST["autoplay"] : 'false';
			$title_length 	= ( isset( $_POST["title_length"] )  	&& $_POST["title_length"] > 0 ) ? $_POST["title_length"] : 0;
			if( $layout == 'layout3' ){
				if( $catid != '' ){
					$default = array(
						'post_type'				=> 'product',
						'post_status' 			=> 'publish',
						'tax_query'	=> array(
							array(
								'taxonomy'	=> 'product_cat',
								'field'		=> 'term_id',
								'terms'		=> $catid)),
						'ignore_sticky_posts'	=> 1,
						'posts_per_page' 		=> $numberposts,
						'orderby' 				=> $orderby,
					);
					if( sw_woocommerce_version_check( '3.0' ) ){	
						$default['tax_query'][] = array(						
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'featured',
							'operator' => 'IN',	
						);
					}else{
						$default['meta_query'] = array(
							array(
								'key' 		=> '_featured',
								'value' 	=> 'yes'
							)					
						);				
					}
				}else{
					$default = array(
						'post_type'				=> 'product',
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'	=> 1,
						'posts_per_page' 		=> $numberposts,
						'orderby' 				=> $orderby,
					);
					if( sw_woocommerce_version_check( '3.0' ) ){	
						$default['tax_query'][] = array(						
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'featured',
							'operator' => 'IN',	
						);
					}else{
						$default['meta_query'] = array(
							array(
								'key' 		=> '_featured',
								'value' 	=> 'yes'
							)					
						);				
					}
				}
				$list = new WP_Query( $default );
				$column = 12/$columns;
				$column1 = 12/$columns1;
				$column2 = 12/$columns2;
				$column3 = 12/$columns3;
				$column4 = 12/$columns4;
 				if ( $list -> have_posts() ){
				?>
					<div id="<?php echo 'category_ajax_slider_'.$catid; ?>" class="sw-woo-container-slider  popular-product clearfix">
						<div class="resp-slider-container">
							
							<div class=" row">			
							<?php
								while($list->have_posts()): $list->the_post();global $product, $post;
							?>
								<div class="item pull-left col-lg-<?php echo $column ?> col-md-<?php echo $column1 ?> col-sm-<?php echo $column2 ?> co-xs-<?php echo $column3 ?>">
									<div class="item-wrap">
										<div class="item-detail">										
											<div class="item-img products-thumb">											
												<?php
												    sw_label_sales();
													echo sw_quickview();
													the_post_thumbnail('full');
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
							<?php  endwhile; wp_reset_postdata();?>
							</div>
						</div>					
					</div>
				<?php
				}	
			}else{
				$default = array(
					'post_type' => 'product',
					'tax_query' => array(
					array(
						'taxonomy'  => 'product_cat',
						'field'     => 'term_id',
						'terms'     => $catid ) ),
					'orderby' => $orderby,
					'post_status' => 'publish',
					'showposts' => $numberposts
				);		
				$thumbnail_id 	= absint( get_woocommerce_term_meta( $catid, 'thumbnail_id1', true ));
				$thumb = wp_get_attachment_image( $thumbnail_id, 'full', 0, array( 'class' => 'category-image pull-left' ) );
				$list = new WP_Query( $default );			
				if ( $list -> have_posts() ){ ?>
					<div id="<?php echo 'category_ajax_slider_'.$catid; ?>" class="sw-woo-container-slider responsive-slider woo-slider-default" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">       
						<div class="slider-wrapper clearfix">
						<div class="row">
							<div class="imgleft  img-effect col-lg-3 col-md-0">
								<a class="img-class" href="<?php echo get_term_link ($catid, 'product_cat'); ?>">	<?php echo $thumb; ?></a>
							</div>		
							<div class="resp-slider-container col-lg-9 col-md-12 col-sm-12">
							<div class="rw-margin">
								<div class="slider responsive">	
								<?php
									$count_items 	= 0;
									$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
									$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
									$i 				= 0;
									$j				= 0;
									while($list->have_posts()): $list->the_post();global $product, $post; 
									if( $i % $item_row == 0 ){
								?>
									<div class="item">
								<?php } ?>
										<div class="item-wrap">
											<div class="item-detail">										
												<div class="item-img products-thumb">											
													<!-- quickview & thumbnail  -->		
													<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
													<?php echo sw_quickview() ?>
												</div>										
												<div class="item-content">																							
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
													<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>								
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
									<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
								<?php endwhile; wp_reset_postdata();?>
								</div>
							</div>
							</div>
							</div>
						</div>
					</div>
			<?php
				}
			}
			exit();
		}		
		/**
		* Ajax Callback Mobile
		**/
		function sw_category_mobile_callback(){
			$catid 			= ( isset( $_POST["catid"] )   	 && $_POST["catid"] != '' ) ? intval( $_POST["catid"] ) : 0;
			$numberposts	= ( isset( $_POST["number"] )  && $_POST["number"] > 0 ) ? $_POST["number"] : 0;
			$orderby 		= ( isset( $_POST["orderby"] ) 	 && $_POST["orderby"] != '' ) ? $_POST["orderby"] : 'ID';
			$rtl			= ( isset( $_POST["rtl"] )  && $_POST["number"] !='' ) ? $_POST["rtl"] : 'false';
			$title_length 	= ( isset( $_POST["title_length"] )  	&& $_POST["title_length"] > 0 ) ? $_POST["title_length"] : 0;
			$default = array(
				'post_type' => 'product',
				'tax_query' => array(
				array(
					'taxonomy'  => 'product_cat',
					'field'     => 'term_id',
					'terms'     => $catid ) ),
				'orderby' => $orderby,
				'post_status' => 'publish',
				'showposts' => $numberposts
			);		
			$thumbnail_id 	= absint( get_woocommerce_term_meta( $catid, 'thumbnail_id1', true ));
			$thumb = wp_get_attachment_image( $thumbnail_id, 'full', 0, array( 'class' => 'category-image pull-left' ) );
			$list = new WP_Query( $default );			
			if ( $list -> have_posts() ){ ?>
				<div id="<?php echo 'category_ajax_slider_'.$catid; ?>" class="sw-woo-container-slider woo-slider-default">       
					<div class="slider-wrapper clearfix">
						<div class="resp-slider-container">
						    <div class="items-wrapper">
							<?php while($list->have_posts()): $list->the_post();global $product, $post; ?>
								<div class="item">
									<div class="item-wrap">
										<div class="item-detail">										
											<div class="item-img products-thumb">											
												<!-- quickview & thumbnail  -->												
												<?php echo ya_product_thumbnail('shop_catalog'); ?>
											</div>										
											<div class="item-content">																							
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
												<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>								
												<?php if ( $price_html = $product->get_price_html() ){?>
												<div class="item-price">
													<span>
														<?php echo $price_html; ?>
													</span>
												</div>
												<?php } ?>
											</div>											
										</div>
									</div>
								</div>
							<?php endwhile; wp_reset_postdata();?>
						
						</div>	
						</div>
					</div>
				</div>
			<?php
			}
			exit();
		}		
		function sw_category_ajax_listing(){
			$number	= ( isset( $_POST["number"] )  	&& $_POST["number"] > 0 ) ? $_POST["number"] : 0;
			$page 	= ( isset( $_POST["page"]) ) ? $_POST["page"] : 1;
			$terms = get_terms( 'product_cat', array( 'parent' => 0, 'hide_empty' => false, 'number' => $number, 'offset' => $number*$page ) );
			foreach( $terms as $term ){
			if( $term ) :
				$thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ));
				$thumb = wp_get_attachment_image( $thumbnail_id, array(350, 230) );
				$thubnail = ( $thumb != '' ) ? $thumb : '<img src="'.esc_url( 'http://placehold.it/210x270' ) .'" alt=""/>';
		?>
		    <div class="item item-product-cat">					
				<div class="item-image">
					<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo $thubnail; ?></a>
					<div class="item-content">
						<h3><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo esc_html( $term->name ); ?></a></h3>
					</div>
				</div>
			
			</div>
			<?php endif; ?>
		<?php } 
			exit();
		}
		/**
		 * Display the widget on the screen.
		 */
		 
		public function widget( $args, $instance ) {
			wp_reset_postdata();
			extract($args);
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$description1 = apply_filters( 'widget_description', empty( $instance['description1'] ) ? '' : $instance['description1'], $instance, $this->id_base );
			echo $before_widget;
			if ( !empty( $title ) && !empty( $description1 ) ) { echo $before_title . $title . $after_title . '<h5 class="category_description clearfix">' . $description1 . '</h5>'; }
			else if (!empty( $title ) && $description1==NULL ){ echo $before_title . $title . $after_title; }
			
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
			$dir =	plugin_dir_path(dirname(__FILE__)).'/themes/category-slider';
			
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
					$instance['category'] = array_map( 'intval', $new_instance['category'] );
				} else {
					$instance['category'] = intval($new_instance['category']);
				}
			}		
			if ( array_key_exists('numberposts', $new_instance) ){
				$instance['numberposts'] = intval( $new_instance['numberposts'] );
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
					$allow_select_all = '<option value="0">All Categories</option>';
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
			
			$categories = get_terms('product_cat');
			
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
					 
			$title1 			= isset( $instance['title1'] )    		? 	strip_tags($instance['title1']) : '';
			$description1 		= isset( $instance['description1'] )    ? 	strip_tags($instance['description1']) : '';
			$categoryid 		= ( isset( $instance['category'] )  &&  is_array( $instance['category'] ) ) ? $instance['category'] : array();
			$number     		= isset( $instance['numberposts'] ) 	? intval($instance['numberposts']) : 5;
			$orderby    		= isset( $instance['orderby'] )     	? strip_tags($instance['orderby']) : 'ID';
			$item_row     		= isset( $instance['item_row'] )      	? intval($instance['item_row']) : 1;
			$columns     		= isset( $instance['columns'] )      	? intval($instance['columns']) : 1;
			$columns1     		= isset( $instance['columns1'] )     	? intval($instance['columns1']) : 1;
			$columns2     		= isset( $instance['columns2'] )      	? intval($instance['columns2']) : 1;
			$columns3     		= isset( $instance['columns3'] )      	? intval($instance['columns3']) : 1;
			$columns4     		= isset( $instance['columns'] )      	? intval($instance['columns4']) : 1;
			$autoplay     		= isset( $instance['autoplay'] )      	? strip_tags($instance['autoplay']) : 'true';
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
				<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
					type="text"	value="<?php echo esc_attr($number); ?>" />
			</p>
			
			<?php $number_row = array('1' => 1, '2' => 2, '3' => 3); ?>
			<p>
				<label for="<?php echo $this->get_field_id('item_row'); ?>"><?php _e('Number row per column', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('item_row'); ?>"
					name="<?php echo $this->get_field_name('item_row'); ?>">
					<?php
					$option ='';
					foreach ($number_row as $key => $value) :
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
				
				<?php $select = array( esc_html__( 'Layout Default', 'sw_woocommerce') => 'layout1', esc_html__( 'Layout Category Ajax', 'sw_woocommerce') => 'layout2',esc_html__( 'Layout Popular', 'sw_woocommerce') =>'layout3', esc_html__( 'Layout Mobile Ajax', 'sw_woocommerce') => 'layout4', esc_html__( 'Layout Listting Ajax', 'sw_woocommerce') => 'layout5' ); ?>
				<select class="widefat"
					id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
					<?php foreach( $select as $name => $key ) { ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $widget_template, $key, true ); ?>>
							<?php echo $name; ?>		
						</option>			
					<?php } ?>
				</select>
			</p>  
		<?php
		}	
	}
}
?>