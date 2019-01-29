<?php
/** @backend */
if( is_admin() ){
	/**
	 * Add Admin Page
	 */
	function twi_woo_admin_page(){
		add_submenu_page(
	        'edit.php?post_type=twi_woo_g_car',
	        __('Products Image Re-builder', 'twi_awesome_woo_slider_carousel') ,
	        __('Products Image', 'twi_awesome_woo_slider_carousel') ,
	        'manage_options',
	        'twi_woo_images_regenerator',
	        'twi_woo_display_view' 
        );
	}
	function twi_woo_display_view() {

		// Fetching
		$query_images_args = array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'post_status' => 'inherit',
			'posts_per_page' => -1,
		);

		$output = '';
		$query_images = new WP_Query( $query_images_args );
		foreach ( $query_images->posts as $tmpimage ) {
			$output .= "'".$tmpimage->ID."',";
		}

		?>
		<div id="twi_woo_page" class="wrap" >

			<h1><?php _e('TWI Woocommerce Products Images Regenerator','twi_awesome_woo_slider_carousel'); ?></h1>

			<br>

			<button id="twi_woo_start" class="button button-primary">
				<?php _e('Regenerate Now','twi_awesome_woo_slider_carousel');?>
			</button>

			<div style="display: none;">
				<h3><?php _e('Done', 'twi_awesome_woo_slider_carousel'); ?> ( <span>0</span> / <?php echo count( $query_images->get_posts() ); ?> )</h3>
				<p><?php _e('Dont close the browser','twi_awesome_woo_slider_carousel'); ?></p>
			</div>

			<script type="text/javascript">
				twi_woo_images = [ <?php echo $output; ?> ];
			</script>

		</div><!-- /.wrap -->
		<?php
	}
	add_action( 'admin_menu', 'twi_woo_admin_page' );


	/**
	 * Load CSS/JS To Admin
	 */
	function twi_woo_load_assets( $hook ) {
			wp_enqueue_script( 'dda_images_reg', plugins_url( 'js/admin.js' , __FILE__ ) , false, true, 5.0 );
	}
	add_action( 'admin_enqueue_scripts', 'twi_woo_load_assets', 9 );


	/**
	 * Ajax :: Regenerate Image
	 */
	function twi_woo_image_regenerate(){

		global $_wp_additional_image_sizes;

		$imgID = intval( $_POST['id'] );
		$imgMetadata = wp_get_attachment_metadata( $imgID );

		// Not a file
		if( ! array_key_exists( 'file', $imgMetadata ) ) die($imgID);

		// Image Info
		$imgInfo = pathinfo( $imgMetadata['file'] );
		$imgType = wp_check_filetype( $imgMetadata['file'] );

		// Upload Dir
		$up_dir = wp_upload_dir();
		$base_dir = $up_dir['basedir'] . '/' . $imgInfo['dirname'] . '/';

		// Each Theme / Plugins Available Size
		foreach ( $_wp_additional_image_sizes as $tmpkey => $tmpsize ){

			if( ! file_exists( $base_dir . $imgInfo['filename'] . '-' . $tmpsize['width'] . 'x' .$tmpsize['height'] . '.' . $imgInfo['extension'] ) ) {

				// Image Editor Object
				$imgObject = wp_get_image_editor(get_attached_file($imgID));
				if (is_wp_error($imgObject)) die($imgID);

				// Regular
				$filename = $imgObject->generate_filename($tmpsize['width'] . 'x' . $tmpsize['height']);
				$imgObject->resize($tmpsize['width'], $tmpsize['height'], true);
				$imgObject->save($filename);
			}

			// Update Metadata
			$imgMetadata['sizes'][$tmpkey] = array(
				'file' => $imgInfo['filename'] . '-' . $tmpsize['width'] . 'x' . $tmpsize['height'] . '.' . $imgInfo['extension'],
				'width' => $tmpsize['width'],
				'height' => $tmpsize['height'],
				'mime-type' => $imgType['type']
			);

			wp_update_attachment_metadata( $imgID, $imgMetadata );
		}

		echo $imgID;
		die;
	}
	add_action( 'wp_ajax_twi_woo_image_regenerate', 'twi_woo_image_regenerate' );

}