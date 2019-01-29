<?php $ya_header_style 	= ya_options()->getCpanelValue('header_style'); ?>

<?php get_header( $ya_header_style ) ?>
<div class="container">
		<div class="row">
			<?php $ya_404page = ya_options()->getCpanelValue( 'page_404' ); ?>
			<?php if( $ya_404page != '' ) : ?>
					<?php echo sw_get_the_content_by_id( $ya_404page ); ?>
			<?php else: ?>	
            <div class="col-lg-12 col-md-12">
				<div class="col-1-wrapper">
					<div class="std">
						<div class="wrapper_404page">
							<div class="col-lg-7 col-md-7">
								<div class="content-404page">
									<p class="top-text"><?php esc_html_e( "Don't worry you will be back on track in no time!", 'shoppystore' )?></p>
									<p class="img-404"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/404-img-text.png" alt=""></p>
									<p class="bottom-text"><?php esc_html_e( "Page doesn't exist or some other error occured. Go to our home page or go back previous page", 'shoppystore' )?></p>
									<div class="button-404">
										<a href="javascript:void(0);" onclick="goBack()" class="btn-404 prev-page-btn" title="PREVIOUS PAGE"><?php esc_html_e( "PREVIOUS PAGE", 'shoppystore' )?></a>
										<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-404 back2home" title="BACK TO HOMEPAGE"><?php esc_html_e( "BACK TO HOMEPAGE", 'shoppystore' )?></a>
									</div>
								</div>
							</div>
		
							<div class="col-lg-5 col-md-5">
								<div class="img-right-404">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/img/404-image.png" alt="">
								</div>
							</div>
							<div class="clear">&nbsp;</div>
							<script>
								function goBack() {
									window.history.back()
								}
							</script>
						</div>
					</div>   
				</div>
			</div>
			<?php endif; ?>
        </div>
</div>
<?php get_template_part('footer'); ?>