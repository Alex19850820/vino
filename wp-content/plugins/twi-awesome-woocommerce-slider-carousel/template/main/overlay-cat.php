<?php $pterm_name = (int)$pterm->term_id; ?>
     <div class="twi_woo_over">
        <div class="twi-overlay">
        	
		<div class="twi-panel-teaser">
                <a href="<?php echo get_term_link($pterm_name, $taxonomyName); ?>">
			        <?php 
			           $thumbnail_id = get_woocommerce_term_meta($pterm->term_id, 'thumbnail_id', true);
                       // get the image URL for parent category
                       $image = wp_get_attachment_image_src($thumbnail_id , $woo_img_sizes);
			        ?>
			        <img src="<?php echo $image[0]; ?>" alt="<?php echo $pterm->name; ?>">
			    </a>
		</div>
                <div class="twi-overlay-panel twi-overlay-background twi-flex twi-flex-center twi-flex-middle twi-text-center">
                    <div class="twi_pro_detail">
                        <?php if( $ti_hide == 'yes' || $ti_hide == NULL ) { ?>
						    <h3 class="twi_pro_title">
								<a href="<?php echo get_term_link($pterm_name, $taxonomyName); ?>">
									<?php if( $ti_hide == 'yes' || $ti_hide == NULL ) { ?><?php echo $pterm->name; ?><?php } ?><?php if( $pr_hide == 'yes' || $pr_hide == NULL ) { ?> (<?php echo $pterm->count; ?>)<?php } ?>
								</a>
							</h3>
						<?php } ?>
						<?php if( $woo_des == 'yes' ){ ?>
							<div class="twi-pro-des">
							    <p><?php echo $pterm->description; ?></p>
							</div>
						<?php } ?>
                    </div>
                </div>
        </div>
	</div>