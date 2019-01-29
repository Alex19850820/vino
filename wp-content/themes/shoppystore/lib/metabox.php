<?php 
/*
	* Name: Metabox Page
	* Develope: Smartaddons
*/
require_once( get_template_directory() . '/lib/metabox-category.php' );
/*
** Build array
*/
function ya_build_array( $case ){
	$build_arr = array();
	if( $case == 'page' ) :
		$build_arr = array( '' => esc_html__( 'Select Page', 'shoppystore' ) );
		$pages = get_pages(); 
		foreach( $pages as $page ) {
			$build_arr[$page->ID] = $page->post_title;
		}
	elseif( $case == 'sidebar' ) :
		$wp_registered_sidebars = ya_widget_setup_args();
		$build_arr = array( '' => esc_html__( 'Select Sidebar', 'shoppystore' ) );
		foreach( $wp_registered_sidebars as $sidebar ) {
			$build_arr[$sidebar['id']] = $sidebar['name'];
		}
	endif;
	return $build_arr;
}

/*
** Metabox array define
*/
function ya_metabox_init(){
	$ya_metabox_pages[] = array(
		'title' 	=> esc_html__( 'General', 'shoppystore' ),
		'fields'	=> array(
			array(
				'type'	=> 'upload',
				'title'	=> esc_html__( 'Custom Logo', 'shoppystore' ),
				'id'	=> 'page_logo',
				'description' => esc_html__( 'Upload custom Logo for this page', 'shoppystore' ),
				'std' => ''
			),
			
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Home Template', 'shoppystore' ),
				'id'	=> 'page_home_template',
				'description' => esc_html__( 'Select home template', 'shoppystore' ),
				'std'	 => '',
				'values' => array( '' => esc_html__( 'Select Home Style', 'shoppystore' ), 'page-home' => esc_html__( 'Home Style1', 'shoppystore' ), 'page-home2' => esc_html__( 'Home Style2', 'shoppystore' ), 'page-home3' => esc_html__( 'Home Style3', 'shoppystore' ),
					'page-home4' => esc_html__( 'Home Style4', 'shoppystore' ), 'page-home5' => esc_html__( 'Home Style5', 'shoppystore' ), 'page-home6' => esc_html__( 'Home Style6', 'shoppystore' ), 
					'page-home7' => esc_html__( 'Home Style7', 'shoppystore' ), 'page-home8' => esc_html__( 'Home Style8', 'shoppystore' ), 'page-home9' => esc_html__( 'Home Style9', 'shoppystore' ), 'page-home10' => esc_html__( 'Home Style10', 'shoppystore' ),	
					'page-home11' => esc_html__( 'Home Style11', 'shoppystore' ),	
				    'page-home12' => esc_html__( 'Home Style12', 'shoppystore' ),
				    'page-home13' => esc_html__( 'Home Style13', 'shoppystore' ),
				    'page-home14' => esc_html__( 'Home Style14', 'shoppystore' ),
				    'page-home15' => esc_html__( 'Home Style15', 'shoppystore' ),
			     )
			),
			array(
				'type'	=> 'radio_img',
				'title'	=> esc_html__( 'Color Scheme', 'shoppystore' ),
				'id'	=> 'scheme',
				'description' => esc_html__( 'Select one color scheme for this page', 'shoppystore' ),
				'std'	 => 'none',
				'values' => array( 
					'none' => '#000000',
					'default'	=> '#df1f26',
					'blue' => '#02a8f3',
					'blue-cyan' => '#014693',
					'blue-red' => '#394673',
					'green'	=> '#8ac249',
					'green-cyan'	=> '#61c563',
					'orange'	=> '#fe5621',
					'orange-cyan' =>'#e49236',
					'orange-cyan1'	=> '#cc7242',
					'orange-cyan2'	=> '#ff6000',
					'pink'        => '#e81d62',
					'pink1'     => '#ff638b',
					'violet'    => '#aa78a6',
					'yellow-cyan' => '#d5b002',
					'yellow-cyan1'=>'#e99a2c',
					'bordeaux' => '#9f1515',
				)
			)
		)
	);

	$ya_metabox_pages[] = array(
		'title' 	=> esc_html__( 'Typography', 'shoppystore' ),
		'fields'	=> array(
			array(
				'type'	=> 'text',
				'title'	=> esc_html__( 'Google Fonts', 'shoppystore' ),
				'id'	=> 'google_webfonts',
				'description' => esc_html__( ' Insert font style that you actually need on your webpage. Each font seperate by commas', 'shoppystore' ),
				'std'	 => ''	
			),
			array(
				'type'	=> 'multiselect',
				'title'	=> esc_html__( 'Webfont Weight', 'shoppystore' ),
				'id'	=> 'webfonts_weight',
				'description' => esc_html__( 'For weight, see Google Fonts to custom for each font style.', 'shoppystore' ),
				'std'	 => '',
				'values' => array( 
					'100' => '100',
					'200' => '200',
					'300' => '300',
					'400' => '400',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900'
				)
			),
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Webfont Assign to', 'shoppystore' ),
				'id'	=> 'webfonts_assign',
				'description' => esc_html__( 'Select the place will apply the font style headers, every where or custom.', 'shoppystore' ),
				'std'	 => '',
				'values' => array( 
					'headers' => esc_html__( 'Headers',    'shoppystore' ),
					'all'     => esc_html__( 'Everywhere', 'shoppystore' ),
					'custom'  => esc_html__( 'Custom',     'shoppystore' )
				)
			),		
			array(
				'type'	=> 'text',
				'title'	=> esc_html__( 'Webfont Custom Selector', 'shoppystore' ),
				'id'	=> 'webfonts_custom',
				'description' => esc_html__( 'Insert the places will be custom here, after selected custom Webfont assign.', 'shoppystore' ),
				'std'	 => ''	
			),		
		)
	);
	$ya_metabox_pages[] = array(
		'title' 	=> esc_html__( 'Header', 'shoppystore' ),
		'fields'	=> array(
			array(
				'type'	=> 'checkbox',
				'title'	=> esc_html__( 'Hide header', 'shoppystore' ),
				'id'	=> 'page_header_hide',
				'description' => esc_html__( 'Choose to show or hide the header. ', 'shoppystore' ),
				'std' => '0'
			),
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Header Style Select', 'shoppystore' ),
				'id'	=> 'page_header_style',
				'description' => esc_html__( ' Chose to select header page content for this page. ', 'shoppystore' ),
				'std'	 => '',
				'values' => array( '' => esc_html__( 'Header Style', 'shoppystore' ), 'style1' => esc_html__( 'Header Style1', 'shoppystore' ), 'style2' => esc_html__( 'Header Style2', 'shoppystore' ), 'style3' => esc_html__( 'Header Style3', 'shoppystore' ),
							'style4' => esc_html__( 'Header Style4', 'shoppystore' ), 'style5' => esc_html__( 'Header Style5', 'shoppystore' ),'style6' => esc_html__( 'Header Style6', 'shoppystore' ),
							'style7' => esc_html__( 'Header Style7', 'shoppystore' ), 'style8' => esc_html__( 'Header Style8', 'shoppystore' ),'style9' => esc_html__( 'Header Style9', 'shoppystore' ), 'style10' => esc_html__( 'Header Style10', 'shoppystore' ),
							'style11' => esc_html__( 'Header Style11', 'shoppystore' ),'style12' => esc_html__( 'Header Style12', 'shoppystore' ),'style13' => esc_html__( 'Header Style13', 'shoppystore' ),'style14' => esc_html__( 'Header Style14', 'shoppystore' ),'style15' => esc_html__( 'Header Style15', 'shoppystore' )
				)
			)		
		)
	);

	$ya_metabox_pages[] = array(
		'title' 	=> esc_html__( 'Footer', 'shoppystore' ),
		'fields'	=> array(
			array(
				'type'	=> 'checkbox',
				'title'	=> esc_html__( 'Hide Footer', 'shoppystore' ),
				'id'	=> 'page_footer_hide',
				'description' => esc_html__( 'Choose to show or hide the footer. ', 'shoppystore' ),
				'std'	 => '0',
			),
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Footer Page Select', 'shoppystore' ),
				'id'	=> 'page_footer_style',
				'description' => esc_html__( ' Chose to select footer page content for this page. ', 'shoppystore' ),
				'std'	 => '',
				'values' => ya_build_array( 'page' )
			)
		)
	);
	
	$ya_metabox_pages[] = array(
		'title' 	=> esc_html__( 'Sidebar', 'shoppystore' ),
		'fields'	=> array(
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Sidebar Layout', 'shoppystore' ),
				'id'	=> 'page_sidebar_layout',
				'description' => esc_html__( 'Choose layout sidebar for page', 'shoppystore' ),
				'std'	 => '',
				'values' => array( '' => esc_html__( 'Select Sidebar', 'shoppystore' ), 'full' => esc_html__( 'No Sidebar', 'shoppystore' ), 'left' => esc_html__( 'Sidebar Left', 'shoppystore' ), 'right' => esc_html__( 'Sidebar Right', 'shoppystore' ) )
			),
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Sidebar ', 'shoppystore' ),
				'id'	=> 'page_sidebar_template',
				'description' => esc_html__( ' Chose sidebar to show.', 'shoppystore' ),
				'std'	 => '',
				'values' => ya_build_array( 'sidebar' )
			)		
		)
	);
	
	return $ya_metabox_pages;
}
add_action( 'init', 'ya_metabox_init' );

add_action( 'admin_init', 'ya_page_init' );
function ya_page_init(){
	add_meta_box( 'ya_page_meta', esc_html__( 'Page Metabox', 'shoppystore' ), 'ya_page_meta', array( 'page', 'post', 'product' ), 'normal', 'low' );
	add_action( 'save_post', 'ya_page_save_meta', 10, 1 );
}	

/*
** Metabox HTML
*/
function ya_page_meta(){
global $post;
	$ya_metabox_pages = ya_metabox_init();
	$except_args = array( 'General', 'Typography' );
	$current_screen =  get_current_screen()->post_type;
	wp_nonce_field( 'ya_page_save_meta', 'ya_metabox_plugin_nonce' );
	if( in_array( $current_screen, array( 'post', 'page', 'product' ) ) ) : 
		wp_enqueue_style( 'metabox_style', get_template_directory_uri() . '/lib/admin/css/metabox.css', array(), null );
		wp_enqueue_script( 'tab_script', get_template_directory_uri() . '/lib/admin/js/tab.js', array(), null, true );
		wp_enqueue_script( 'ya-opts-field-radio_img-js',	YA_URL.'/options/fields/radio_img/field_radio_img.js',	array('jquery'), time(), true	);
	endif; 
?>
	<div class="ya-metabox" id="ya_metabox">
		<div class="ya-metabox-content">
			<ul class="nav nav-tabs">
			<?php 
				$i = 0;
				foreach( $ya_metabox_pages as $metabox ){ 
					if( ( $current_screen == 'post' || $current_screen == 'product' ) && ( in_array( $metabox['title'], $except_args ) ) ){
						continue;
					}
					$active = ( $i == 0 ) ? 'active' : '';
					echo '<li class="' . esc_attr( $active ) . '"><a href="#ya_'. strtolower( $metabox['title'] ) .'" data-toggle="tab">' . $metabox['title'] . '</a></li>';
					$i ++;
				} 
			?>
			</ul>
			<div class="tab-content">
			<?php 
				$i = 0;
				foreach( $ya_metabox_pages as $metabox ){ 
					$active = ( $i == 0 ) ? 'active' : '';	
					if( ( $current_screen == 'post' || $current_screen == 'product' ) && ( in_array( $metabox['title'], $except_args ) ) ){
						continue;
					}
			?>
				<div class="tab-pane <?php echo esc_attr( $active ); ?>" id="ya_<?php echo strtolower( $metabox['title'] ) ; ?>">
					<?php if( isset( $metabox['fields'] ) && count( $metabox['fields'] ) > 0 ) {?>
						<?php 
							foreach( $metabox['fields'] as $meta_field ) { 
							$values = isset( $meta_field['values'] ) ? $meta_field['values'] : '';
						?>
							<div class="tab-inner clearfix">
								<div class="flytab-description pull-left">
								
									<!-- Title meta field -->
									<?php if( $meta_field['title'] != '' ) { ?>
									<div class="flytab-item-title">
										<?php echo $meta_field['title']; ?>
									</div>
									<?php } ?>
									
									<!-- Description -->
									<?php if( $meta_field['description'] != '' ) { ?>
									<div class="flytab-item-shortdes">
										<?php echo $meta_field['description']; ?>
									</div>
									<?php } ?>
								</div>
								<!-- Meta content -->
								<div class="flytab-content">
									<?php ya_render_html( $meta_field['id'], $meta_field['type'], $values, $meta_field['std'] ); ?>									
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			<?php $i ++; } ?>
			</div>
		</div>
	</div>
<?php 
}

/*
** Function Render HTML
*/
function ya_render_html( $id, $type, $values, $std ){
	global $post;
	$meta_value = '';
	if( get_post_meta( $post->ID, $id, true ) != '' ){
			$meta_value = get_post_meta( $post->ID, $id, true );
	}else if( isset( $std ) && $std != '' ){
		$meta_value = $std;
	}
	$html = '';
	switch( $type ) {
		case 'text' :
			$html .= '<input type="text" value="'. esc_attr( $meta_value ) .'" id="'. esc_attr( $id ) .'" name="'. esc_attr( $id ) .'"/>';
		break;
		
		case 'textarea' :
			$html .= '<texarea id="'. esc_attr( $id ) .'" name="'. esc_attr( $id ) .'"/>'. esc_attr( $meta_value ) .'</texarea>';
		break;
		
		case 'editor' :
			wp_editor( $meta_value, $id, array() );
		break;
		
		case 'select' :
			$html .= '<select id="'. esc_attr( $id ) .'" name="'. esc_attr( $id ) .'">';
				foreach( $values as $key => $value ) {
					$html .= '<option value="'. esc_attr( $key ) .'" '. selected( $meta_value, $key, false ) .'>'. $value .'</option>';
				}
			$html .= '</select>';
		break;
		
		case 'multiselect' :
			$multi_value = array();
			if( is_array( $meta_value ) ){
				$multi_value = $meta_value;
			}else{
				$multi_value[] = $meta_value;
			}
			$select_value = $multi_value;
			$html .= '<select id="'. esc_attr( $id ) .'" name="'. esc_attr( $id ) .'[]" multiple>';
				foreach( $values as $key => $value ) {
					$check = ( in_array( $key, $select_value ) ) ? 'selected="selected"' : '';
					$html .= '<option value="'. esc_attr( $key ) .'" '. $check .'>'. $value .'</option>';
				}
			$html .= '</select>';
		break;
		
		case 'checkbox' :
			$html .= '<input type="checkbox" name="'. esc_attr( $id ) .'" value="1" '. checked( $meta_value, 1, false ) .'/>';
		break;
		
		case 'radio_img' :
			$i = 0;
			$html .= '<div class="page-metabox-radio-img">';
			foreach( $values as $key => $value ) {
				$key_val = ( $key == 'none' ) ? esc_html__( 'No Select', 'shoppystore' ) : $key; 
				$selected = ( checked( $meta_value, $key, false ) != '' ) ? ' ya-radio-img-selected' : '';
				$html .= '<label class="radio-label ya-radio-img'.$selected.' ya-radio-img-'. esc_attr( $id ) .'" for="'. esc_attr( $id ) .'_'. $i .'">';
				$html .= '<input type="radio" id="'. esc_attr( $id ) .'_'. $i .'" name="'. esc_attr( $id ) .'" value="'. esc_attr( $key ) .'" '.checked($meta_value, $key, false).'/>';
				$html .= '<div class="page-radio-color" style="background: '. esc_attr( $value ) .'" onclick="jQuery:ya_radio_img_select(\''. esc_attr( $id ) .'_'. $i .'\', \''. esc_attr( $id ) .'\');"></div>';
				$html .= '<br/><span>'. esc_attr( $key_val ) .'</span>';
				$html .= '</label>';
				$i ++;
			}
			$html .= '</div>';
		break;
		
		case 'radio' :
			$i = 0;
			$html .= '<div class="page-metabox-radio">';
			foreach( $values as $key => $value ) {
				$html .= '<label class="radio-label '. esc_attr( $id ) .'" for="'. esc_attr( $id ) .'_'. $i .'">';
				$html .= '<input type="radio" id="'. esc_attr( $id ) .'_'. $i .'" name="'. esc_attr( $id ) .'" value="'. esc_attr( $key ) .'" '.checked($meta_value, $key, false).'/>';
				$html .= '';
				$html .= '<br/><span>'. esc_attr( $value ) .'</span>';
				$html .= '</label>';
				$i ++;
			}
			$html .= '</div>';
		break;
		
		case 'multicheckbox' :
			$multi_value = array();
			if( is_array( $meta_value ) ){
				$multi_value = $meta_value;
			}else{
				$multi_value[] = $meta_value;
			}
			$checkbox_value = $multi_value;
			foreach( $values as $key => $value ) {
				$check = ( in_array( $key, $checkbox_value ) ) ? 'checked' : '';
				$html .= '<div class="metabox-multicheck pull-left"><input type="checkbox" name="'. esc_attr( $id ) .'[]" value="'. esc_attr( $key ) .'" '. $check .'/>';
				$html .= '<br/><label>'. $value .'</label></div>';
			}
		break;
		
		case 'upload' :
			$upload_img = wp_get_attachment_image_url( $meta_value, 'thumbnail' ) ? wp_get_attachment_image_url( intval($meta_value), 'thumbnail' ) : '';
			ob_start();
		?>
			<div class="upload-formfield">
				<div id="metabox_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $upload_img ); ?>" alt="" width="30" height="30" /></div>
				<div class="metabox-thumbnail-wrapper">
					<input type="hidden" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" value="<?php echo esc_attr( $meta_value ) ?>"/>
					<button type="button" class="upload_image_button button"><?php echo esc_html__( 'Upload/Add image', 'shoppystore' ) ?></button>
					<button type="button" class="remove_image_button button"><?php echo esc_html__( 'Remove image', 'shoppystore' ) ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( ! jQuery( '#<?php echo esc_js( $id ); ?>' ).val() ) {
						jQuery( '.remove_image_button' ).hide();
					}

					// Uploading files
					var file_frame;

					jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;
						}

						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( "Choose an image", 'shoppystore' ); ?>',
							button: {
								text: '<?php esc_html_e( "Use image", 'shoppystore' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							var attachment = file_frame.state().get( 'selection' ).first().toJSON();
							
							jQuery( '#<?php echo esc_js( $id ); ?>' ).val( attachment.id );
							jQuery( '#metabox_thumbnail > img' ).attr( 'src', attachment.sizes.thumbnail.url );
							jQuery( '.remove_image_button' ).show();
						});

						// Finally, open the modal.
						file_frame.open();
					});

					jQuery( document ).on( 'click', '.remove_image_button', function() {
						jQuery( '#metabox_thumbnail > img' ).attr( 'src', 'http://placehold.it/30x30' );
						jQuery( '#<?php echo esc_js( $id ); ?>' ).val( '' );
						jQuery( '.remove_image_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</div>
	<?php
			$html .= ob_get_clean();
		break;
		
		case 'color' :
			$color_value = isset( $meta_value ) ? $meta_value : $std;			
			$html .= '<input type="text" id="'.esc_attr( $id ).'" name="'. esc_attr( $id ) .'" value="'.esc_attr( $color_value ).'" class="ya-popup-colorpicker" style="width:70px;"/>';
		break;
	}
	echo $html;
}

function ya_page_save_meta( $post_id ){
	if( !is_admin() ){
		return;
	}
	global $post;
	$ya_metabox_pages = ya_metabox_init(); 
	$except_args = array( 'General', 'Typography' );
	$current_screen =  isset( get_current_screen()->post_type ) ? get_current_screen()->post_type : '';
	if ( ! isset( $_POST['ya_metabox_plugin_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['ya_metabox_plugin_nonce'], 'ya_page_save_meta' ) ) {
		return;
	}
	foreach( $ya_metabox_pages as $key => $metabox ){ 
		if( ( $current_screen == 'post' || $current_screen == 'product' ) && ( in_array( $metabox['title'], $except_args ) ) ){
			continue;
		}
		foreach( $metabox['fields'] as $meta_field ) { 
			$checkbox_val = isset( $_POST[$meta_field['id']] ) ? $_POST[$meta_field['id']] : 0;
			update_post_meta( $post_id, $meta_field['id'], $checkbox_val );
			if( isset( $_POST[$meta_field['id']] ) ){
				$data = $_POST[$meta_field['id']];
				switch( $meta_field['type'] ) {
					case 'text' :
						$data = sanitize_text_field( $_POST[$meta_field['id']] );
					break;
					
					case 'email' :
						$data = sanitize_email( $_POST[$meta_field['id']] );
					break;
					
					case 'number' :
						$data = intval( $_POST[$meta_field['id']] );
					break;
					
					case 'upload' :
						$data = intval( $_POST[$meta_field['id']] );
					break;
					
					case 'radio_img' :
						$data = $_POST[$meta_field['id']];
					break;

				}
				if( strlen( trim( $data ) ) > 0 ) :
					update_post_meta( $post_id, $meta_field['id'], $data );
				else: 
					delete_post_meta( $post_id, $meta_field['id'] );
				endif;
			}
			else{
				if( $meta_field['std'] != '' ){
					update_post_meta( $post_id, $meta_field['id'], $meta_field['std'] );
				}else{
					delete_post_meta( $post_id, $meta_field['id'] );
				}
			}
		}
	}
}

