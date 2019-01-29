<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Rev_addon_gal
 * @subpackage Rev_addon_gal/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rev_addon_gal
 * @subpackage Rev_addon_gal/admin
 * @author     ThemePunch <info@themepunch.com>
 */
class Rev_addon_gal_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rev_addon_gal_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rev_addon_gal_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rev_addon_gal_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rev_addon_gal_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if(isset($_GET["page"]) && $_GET["page"]=="rev_addon"){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rev_addon_gal-admin.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( $this->plugin_name, 'rev_slider_addon_gal', array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
			));
		}
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'partials/rev_addon_gal-admin-display.php' );
	}

	/**
	 * Saves Values for this Add-On
	 *
	 * @since    1.0.0
	 */
	public function save_gal() {
		// Verify that the incoming request is coming with the security nonce
		if( wp_verify_nonce( $_REQUEST['nonce'], 'ajax_rev_slider_addon_gal_nonce' ) ) {
			if(isset($_REQUEST['default_gallery'])){
				update_option( "rev_slider_addon_gal_default", sanitize_text_field($_REQUEST['default_gallery']) );
				die( '1' );
			}
			else{
				die( '0' );
			}
		} 
		else {
			die( '-1' );
		}
	}


	/**
	 * Shortcode to wrap around the original gallery shortcode
	 *
	 * @since    1.0.0
	 */
	public function rev_addon_media_form(){
		$slider = new RevSlider();
		$arrSliders = $slider->getArrSliders();
		$defSlider = get_option( 'rev_slider_addon_gal_default' );
	?>
		<script type="text/html" id="tmpl-rev-addon-gallery-setting">
		    <h3 style="z-index: -1;">___________________________________________________________________________________________</h3>
		    <h3><?php _e("Gallery Slider Revolution (above settings are off)","rev_slider_addon_gal"); ?></h3>

		    <label class="setting">
		      <span><?php _e('Select'); ?></span>
		      <select class="specific_post_select" data-setting="rev_addon_gal_slider">
		        <?php
		        	foreach($arrSliders as $sliderony){
		        		if($sliderony->getParam('source_type')=="specific_posts"){
							echo '<option value="'.$sliderony->getAlias().'" '.selected( $defSlider, $sliderony->getAlias(), true ).'>'. $sliderony->getTitle() . '</option>';
						}
					}
		        ?>
		      </select>
		    </label>
		</script>

		<script>
		    jQuery(document).ready(function(){

		        _.extend(wp.media.gallery.defaults, {
		        	rev_addon_gal_slider: '<?php echo $defSlider; ?>'
		        });

		        wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
			        template: function(view){
			          return wp.media.template('gallery-settings')(view)
			               + wp.media.template('rev-addon-gallery-setting')(view);
			        }
		        });

		    });

		</script>
		<?php

		}

	/**
	 * Adds new Tab header to the layer meta selection
	 *
	 * @since    1.0.0
	 */
	public function rev_addon_meta_tabs($args){
		//only for specific posts
		if($args['slider_type']!="specific_posts") return false;
		
		//insert meta tab header
		echo str_replace(
		    array("INSERT_TAB_SLUG","INSERT_ICON_CLASS","INSERT_TAB_NAME"),
		    array("gallery", "eg-icon-picture",__("Gallery Image",'rev_slider_addon_gal') ),
		    $args["dummy"]
		);
	}

	/**
	 * Adds new meta table to the new tabs headers
	 *
	 * @since    1.0.0
	 */
	public function rev_addon_meta_tab_content($args){
		//only for specific posts
		if($args['slider_type']!="specific_posts") return false;

		//build meta table
		echo str_replace("INSERT_TAB_SLUG", 'gallery', $args["tab_head"]);
		$rows = array(
			array("slug"=>"title","name"=>__("Title",'rev_slider_addon_gal') ),
			array("slug"=>"caption","name"=>__("Caption",'rev_slider_addon_gal') ),
			array("slug"=>"description","name"=>__("Description",'rev_slider_addon_gal') ),
			array("slug"=>"link","name"=>__("Post Link",'rev_slider_addon_gal') ),
			array("slug"=>"uploaded","name"=>__("Uploaded",'rev_slider_addon_gal') )
		);

		$avail_image_sizes = get_intermediate_image_sizes();
		array_unshift($avail_image_sizes, "full");
		foreach ($avail_image_sizes as $size) {
			$rows[]=array("slug"=>"image_".$size."_url","name"=>__("Image ".ucwords(str_replace("_"," ",$size))." URL",'rev_slider_addon_gal') );
			$rows[]=array("slug"=>"image_".$size."_html","name"=>__("Image ".ucwords(str_replace("_"," ",$size))." HTML",'rev_slider_addon_gal') );
		}
		    
		foreach($rows as $row)
			echo str_replace(
			    array("INSERT_META_SLUG","INSERT_META_NAME"),
			    array($row['slug'], $row['name'] ),
			    $args["tab_row"]
			);
		echo $args["tab_foot"];
	}

}
