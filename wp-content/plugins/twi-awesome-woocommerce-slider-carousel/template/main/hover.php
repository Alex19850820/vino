		<div class="pic-twi twi-overlay-hover">
			<?php 
			   if($rib_dis == 'yes'){
			      require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/rib/rib.php'); 
			   }
			?>
		    <div class="twi-panel-teaser <?php if( $rib_dis == 'yes' && !$product->is_featured() && ($product->is_on_sale() || !$product->is_in_stock()) ){ echo 'twi-rib'; } if(!$product->is_featured() && ($product->is_on_sale() && !$product->is_in_stock()) ){echo "undefine"; } ?>">
			        <?php if(has_post_thumbnail()) {
				            echo get_the_post_thumbnail($loop->post->ID, $woo_img_sizes ); 
				         }else{ 
				         	echo woocommerce_placeholder_img( $woo_img_sizes );
				        } 
			        ?>
		    </div>
		    <div class="pic-twi-caption twi_ho_anima <?php echo $over_eff_ho; ?>" data-cart="animated <?php echo $cart_an; ?>" data-title="animated <?php echo $title_an; ?>" data-price="animated <?php echo $price_an; ?>" data-rating="animated <?php echo $rating_an; ?>" data-des="animated <?php echo $des_an; ?>">
			    <div class="twi-details twi-overlay-panel twi-flex twi-flex-center twi-flex-middle twi-text-center twi-flex-column">
				    <?php if( $ti_hide == 'yes' || $ti_hide == NULL ) { ?>
					    <h3 class="twi_pro_title">
							<a href="<?php echo get_permalink(); ?>">
								<?php echo get_the_title(); ?>
							</a>
						</h3>
					<?php } ?>
					<?php if( $woo_des ==NULL || $woo_des == 'yes' ){ ?>
		                <div class="twi-pro-des twi_des">
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