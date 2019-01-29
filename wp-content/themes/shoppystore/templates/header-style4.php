<?php 
	$ya_colorset = ya_options()->getCpanelValue('scheme');
	$ya_phone = ya_options() ->getCpanelValue('phone');
	$email = ya_options() ->getCpanelValue('email');
	$ya_search = ya_options()->getCpanelValue('search');
?>
	<div id="yt_header" class="yt-header wrap">
		<div class="header-style4">
			<div class="yt-header-middle">
				<div class="container">
					<div class="row">
					    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 hot-line">
						    <?php if($ya_phone != '') {?>
								<i class="fa fa-phone"></i>&nbsp;&nbsp;<?php esc_html_e('Hotline:','shoppystore') ;?> <a title="<?php echo esc_attr( $ya_phone ) ?>" href="#"><?php echo esc_html( $ya_phone ) ?></a> 
							<?php } ?> 
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 logo-wrapper">
							<h1>
								<?php ya_logo(); ?>
							</h1>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 my-account">
						    <div class="top-header-sidebar-menu pull-right">
								<i class="fa fa-bars"></i> 
								<?php if (is_active_sidebar_YA('top-right')) {?>
									<div id="sidebar-top" class="sidebar-top">
										<?php dynamic_sidebar('top-right'); ?>
									</div>
								<?php }?>
									
							</div>
							<?php if( class_exists( 'WooCommerce' ) ){ ?>
							 <div class="modal fade" id="login_form" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog block-popup-login">
											<a href="javascript:void(0)" title="Close" class="close close-login" data-dismiss="modal"><?php esc_html_e('Close','shoppystore') ?></a>
											<div class="tt_popup_login"><strong><?php esc_html_e('Sign in Or Register', 'shoppystore'); ?></strong></div>
											<?php get_template_part('woocommerce/myaccount/login-form'); ?>
										</div>
							</div>
							<?php } ?>
						     <div class="account pull-right"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e( 'My Account', 'shoppystore' ); ?>" class="btn-reg-popup"><?php esc_html_e( 'My Account', 'shoppystore' ); ?></a></div>
						</div>
					</div>
				</div>
			</div>
			<div class="yt-header-under-2">
				<div class="container">
					<div class="row yt-header-under-wrap">
						<div class="yt-main-menu col-md-12">
							<div class="header-under-2-wrapper">

								<div class="yt-searchbox-vermenu">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="yt-header-under">
											<nav id="primary-menu" class="primary-menu" >
												<div class="yt-menu">
													<div class="navbar-inner navbar-inverse">
														<?php
															$menu_class = 'nav nav-pills';
															if ( 'mega' == ya_options()->getCpanelValue('menu_type') ){
																$menu_class .= ' nav-mega';
															} else $menu_class .= ' nav-css';
														?>
														<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $menu_class)); ?>
													</div>
												</div>
											 </nav>
											    <?php if ( class_exists( 'WooCommerce' ) && !ya_options()->getCpanelValue( 'disable_cart' ) ) { ?>
													<div class="mini-cart-headerv4">
														  <?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
													</div>
												<?php } ?>
												
												<div class="search  pull-right">
													<a class="phone-icon-search  fa fa-search" title="Search"></a>
													<div id="sm_serachbox_pro" class="sm-serachbox-pro">
															<?php if( $ya_search ) {
															     if (is_active_sidebar_YA('search')) { ?>
															        <?php dynamic_sidebar('search');
															}else { ?>
															<div class="sm-searbox-content">
																 <?php get_template_part( 'widgets/ya_top/searchcate' ); ?>
															</div>
															<?php } } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="main" class="theme-clearfix" role="document">
	<?php

		if (function_exists('ya_breadcrumb')){
			ya_breadcrumb('<div class="breadcrumbs theme-clearfix"><div class="container">', '</div></div>');
		} 

	?>
