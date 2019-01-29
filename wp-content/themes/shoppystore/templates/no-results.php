<?php
	global $ya_detect;
	$mobile_check   = ya_options()->getCpanelValue( 'mobile_enable' );
	if( !empty( $ya_detect ) && ( $ya_detect->isMobile() ) && $mobile_check ) :?>
	<div class="no-result">
		<div class="no-result-image">
			<span class="image">
				<img class="img_logo" alt="404" src="<?php echo get_template_directory_uri(); ?>/assets/img/no-result.png">
			</span>
		</div>
		<h3><?php esc_html_e('no products found','shoppystore');?></h3>
		<p><?php esc_html_e('Sorry, but nothing matched your search terms.','shoppystore');?><br/><?php  esc_html_e('Please try again with some different keywords.', 'shoppystore'); ?></p>
		<button class="back-to"><?php esc_html_e('back to categories','shoppystore');?></button>
	</div>
<?php else : ?>

	<div class="no-result">		
			<p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'shoppystore'); ?></p>
		<?php get_search_form(); ?>
	</div>

<?php endif; ?>