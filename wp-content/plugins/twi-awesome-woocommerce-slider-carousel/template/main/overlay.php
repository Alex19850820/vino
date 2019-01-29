     <div class="twi_over_<?php echo $twi_i; ?>">
        <div class="twi-overlay">
      
		<div class="twi-panel-teaser">
            <a href="<?php echo get_permalink(); ?>">
			        <?php if(has_post_thumbnail()) {
				            echo get_the_post_thumbnail($loop->post->ID, $woo_img_sizes ); 
				         }else{ 
				         	echo woocommerce_placeholder_img( $woo_img_sizes );
				        } 
			        ?>
			</a>
		</div>
                <div class="twi-overlay-panel twi-overlay-background twi-flex twi-flex-center twi-text-center twi-flex-column">
                    <div class="twi_pro_detail">
                         <?php if( $ti_hide == 'yes' || $ti_hide == NULL ) { ?>
						    <h3 class="twi_pro_title">
								<a href="<?php echo get_permalink(); ?>">
									<?php echo get_the_title(); ?>
								</a>
							</h3>
						<?php } ?>
						<?php if( $woo_des == 'yes' ){ ?>
		                    <div class="twi-pro-des">
							    <p><?php echo get_the_excerpt(); ?></p>
							</div>
						<?php } ?>
					    <?php if( $pr_hide == 'yes' || $pr_hide == NULL ) { ?>
						    <div class="twi_price"><?php echo $product->get_price_html(); ?></div>
						<?php } ?>
						<?php if( $ra_hide == 'yes' ) { ?>
						    <div class="twi_rating"><?php echo $product->get_rating_html(); ?></div>
						<?php } ?>
						<?php if( $cart_hide == 'yes' || $cart_hide == NULL ) { ?>
						    <div class="twi_cart">
								<a href="<?php echo $product->add_to_cart_url(); ?>"><?php echo $product->add_to_cart_text(); ?></a>
						    </div>
						<?php } ?>
                    </div>
                </div>
        </div>
	</div>