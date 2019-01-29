<div class="twi-woo-widget">
<?php
if($instance['twi_hide_title']!=1) : ?>
	   <h3 class="widget-title"><?php echo $instance['title']; ?></h3>
	   <?php endif; ?>
	 <?php
echo do_shortcode('[twi_woo_shortcode p_id="'.$instance['sh_id'].'"][/twi_woo_shortcode]');
?>
</div>