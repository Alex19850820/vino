<?php $pterm_name = (int)$pterm->term_id; ?>
		<div class="pic-twi twi-overlay-hover">
		    <div class="twi-panel-teaser">
			        <?php 
			           $thumbnail_id = get_woocommerce_term_meta($pterm->term_id, 'thumbnail_id', true);
                       // get the image URL for parent category
                       $image = wp_get_attachment_image_src($thumbnail_id , $woo_img_sizes);
			        ?>
			        <img src="<?php echo $image[0]; ?>" alt="<?php echo $pterm->name; ?>">
		    </div>
		    <div class="pic-twi-caption twi_ho_anima <?php echo $over_eff_ho; ?>" data-cart="animated <?php echo $cart_an; ?>" data-title="animated <?php echo $title_an; ?>" data-price="animated <?php echo $price_an; ?>" data-rating="animated <?php echo $rating_an; ?>" data-des="animated <?php echo $des_an; ?>">
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