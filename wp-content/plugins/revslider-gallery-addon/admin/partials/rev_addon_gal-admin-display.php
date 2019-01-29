<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Rev_addon_gal
 * @subpackage Rev_addon_gal/admin/partials
 */
?>
<div id="rev_addon_gal_settings_slideout" class="rs-sbs-slideout-wrapper" style="display:none">
	<div class="rs-sbs-header">
		<div class="rs-sbs-step"><i class="eg-icon-cog"></i></div>
		<div class="rs-sbs-title"><?php _e('Standard WP Gallery', 'rev_addon_gal'); ?></div>
		<div class="rs-sbs-close"><i class="eg-icon-cancel"></i></div>
	</div>
	<div class="tp-clearfix"></div>
	<div class="rs-sbs-slideout-inner">

	<!-- Start Settings -->
		<div class="rs-dash-content-with-icon">
			<div class="rs-dash-strong-content"><?php _e('Set Default Gallery Slider','rev_addon_gal'); ?></div>
			<div><?php _e('Select a default slider for WP media galleries, Slider must be of the <strong>"Specific Posts" source type</strong>:','rev_addon_gal'); ?></div>				
		</div>
		<div class="rs-dash-content-space"></div>
			<?php
				$slider = new RevSlider();
				$arrSliders = $slider->getArrSliders();
				$defSlider = get_option( 'rev_slider_addon_gal_default' );
			?>	
			<select id="rs-addon-gal-slider" name="rs-addon-gal-slider" style="width:100%" data-setting="rev_addon_gal_slider">
		        <?php
					foreach($arrSliders as $sliderony){
						if($sliderony->getParam('source_type')=="specific_posts"){
							echo '<option value="'.$sliderony->getAlias().'" '.selected( $defSlider, $sliderony->getAlias(), true ).'>'. $sliderony->getTitle() . '</option>';	
						}
					}
		        ?>
		    </select>
		    <span id="ajax_rev_slider_addon_gal_nonce" class="hidden"><?php echo wp_create_nonce( 'ajax_rev_slider_addon_gal_nonce' ) ?></span>
			<div class="rs-dash-content-space"></div>
			<div><?php _e('You can select a different slider inside the WP gallery window. Find details in the <a target="_blank" href="https://www.themepunch.com/revslider-doc/add-wp-standard-gallery/#individual">documentation</a>.','rev_addon_gal'); ?></div>	
			<div class="rs-dash-bottom-wrapper">
				<span style="display:none" id="rs_addon-gal-wait" class="loader_round">Please Wait...</span>					
				<a href="javascript:void(0);" id="rs-addon-gal-save" class="rs-dash-button">Save</a>
			</div>					
		</div>		
	<!-- End Settings -->
</div>