<?php $pterm_name = (int)$pterm->term_id; ?>
		<?php if($ho2_over_eff_ho == '6'){ ?>
		<style>#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect6::before,#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect6::after{ background: <?php echo $ho2_ho_cap_bg; ?>!important; }</style>
		<?php } ?>
		<?php if($ho2_over_eff_ho == '3'){ ?>
		<style>#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect3::before,#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect3::after{ background: <?php echo $ho2_ho_cap_bg; ?>!important; }</style>
		<?php } ?>
		<?php if($ho2_over_eff_ho == '4'){ ?>
		<style>#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect4::before,#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect4::after{ background: <?php echo $ho2_ho_cap_bg; ?>!important; }</style>
		<?php } ?>
		<?php if($ho2_over_eff_ho == '7'){ ?>
		<style>#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect7::before,#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect7::after{ background: <?php echo $ho2_ho_cap_bg; ?>!important; }</style>
		<?php } ?>
		<div class="twi-hover-wrap twi_img_effect<?php echo $ho2_ho_img_eff; ?>">
		        <?php 
			        $thumbnail_id = get_woocommerce_term_meta($pterm->term_id, 'thumbnail_id', true);
                    // get the image URL for parent category
                    $image = wp_get_attachment_image_src($thumbnail_id , $woo_img_sizes);
			    ?>
			        <img src="<?php echo $image[0]; ?>" alt="<?php echo $pterm->name; ?>">
			        <?php if($ho2_over_eff_ho != '18'){ ?>
	                <div class="twi_hover_effect<?php echo $ho2_over_eff_ho; ?>"></div>
		            <?php }else{ ?>
		                <style>#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect_a_18::before,#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect_a_18::after,#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect_b_18::before,#twi-woo-hover2-wrap-<?php echo $twi_i; ?> .twi_hover_effect_b_18::after{ background: <?php echo $ho2_ho_cap_bg; ?>!important; }</style>
			            <div class="twi_hover_effect_a_<?php echo $ho2_over_eff_ho; ?>"></div>
			            <div class="twi_hover_effect_b_<?php echo $ho2_over_eff_ho; ?>"></div>
		            <?php } ?>

		     <div class="twi_woo_hover2_con" data-cart="animated <?php echo $ho2_cart_an; ?>" data-title="animated <?php echo $ho2_title_an; ?>" data-price="animated <?php echo $ho2_price_an; ?>" data-rating="animated <?php echo $ho2_rating_an; ?>" data-des="animated <?php echo $ho2_des_an; ?>">
			    <div class="twi-details twi-overlay-panel twi-flex twi-flex-center twi-flex-middle twi-text-center twi-flex-column">
				    <?php if( $ti_hide == 'yes' || $ti_hide == NULL ) { ?>
					    <h3 class="twi_pro_title">
							<a href="<?php echo get_term_link($pterm_name, $taxonomyName); ?>">
								<?php if( $ti_hide == 'yes' || $ti_hide == NULL ) { ?><?php echo $pterm->name; ?><?php } ?><?php if( $pr_hide == 'yes' || $pr_hide == NULL ) { ?> (<?php echo $pterm->count; ?>)<?php } ?>
							</a>
						</h3>
					<?php } ?>
					<?php if( $woo_des == 'yes' ){ ?>
						<div class="twi-pro-des twi_des">
						    <p><?php echo $pterm->description; ?></p>
						</div>
					<?php } ?>
			   </div>
			</div>
		</div>