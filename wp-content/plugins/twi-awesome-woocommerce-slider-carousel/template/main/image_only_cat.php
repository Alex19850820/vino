<?php $pterm_name = (int)$pterm->term_id; ?>
		<div class="twi-panel twi-panel-box twi_img_only">
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
		</div>