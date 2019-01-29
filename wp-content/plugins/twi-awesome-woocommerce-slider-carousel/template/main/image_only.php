		<div class="twi-panel twi-panel-box">
			<?php 
			   if($rib_dis == 'yes'){
			      require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/rib/rib.php'); 
			   }
			?>
		    <div class="twi-panel-teaser <?php if( $rib_dis == 'yes' && !$product->is_featured() && ($product->is_on_sale() || !$product->is_in_stock()) ){ echo 'twi-rib'; } if(!$product->is_featured() && ($product->is_on_sale() && !$product->is_in_stock()) ){echo "undefine"; } ?>">
			    	<a href="<?php echo get_permalink(); ?>">
			        <?php if(has_post_thumbnail()) {
				            echo get_the_post_thumbnail($loop->post->ID, $woo_img_sizes ); 
				         }else{ 
				         	echo woocommerce_placeholder_img( $woo_img_sizes );
				        } 
			        ?>
			        </a>
		    </div>
		</div>