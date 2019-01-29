		<div class="twi-panel twi-panel-box">
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
		</div>