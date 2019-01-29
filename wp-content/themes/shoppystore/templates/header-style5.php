<?php 
	$ya_colorset = ya_options()->getCpanelValue('scheme');
	$ya_phone = ya_options() ->getCpanelValue('phone');
	$email = ya_options() ->getCpanelValue('email');
	$ya_search = ya_options()->getCpanelValue('search');
	$meta_img_ID = get_post_meta( get_the_ID(), 'page_logo', true );
	$meta_img 	 = ( $meta_img_ID != '' ) ? wp_get_attachment_image_url( $meta_img_ID, 'full' ) : '';
	$meta_img_ID = get_post_meta( get_the_ID(), 'page_logo', true );
	$logo_select = ya_options()->getCpanelValue( 'sitelogo' );
	$main_logo	 = ( $meta_img != '' )? $meta_img : $logo_select;
?>
	<div id="yt_header" class="yt-header wrap">
		<div class="header-style5">
			<div class="yt-header-middle">
				<?php if (is_active_sidebar_YA('top')) {?>
					<?php dynamic_sidebar('top'); ?>
				<?php }?>
			</div>
			<div class="yt-header-under-2">
				<div class="container">
					<div class="row yt-header-under-wrap">
						<div class="yt-main-menu col-md-12">
							<div class="header-under-2-wrapper">

								<div class="yt-searchbox-vermenu">
									<div class="row">
									    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 logo-wrapper">
											<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
												<?php if( $main_logo != '' ) { ?>
								   	<img src="<?php echo esc_url( $main_logo ); ?>" alt="<?php bloginfo('name'); ?>" width="140" height="57"/>
								<?php }else{ ?>
													<img src="<?php echo get_template_directory_uri().'/assets/img/logo-white.png' ?>" alt="<?php bloginfo('name'); ?>"  width="140" height="57"/>
											<?php } ?>
											</a>
										</div>
										<div class="col-lg-8 col-md-8 col-sm-6 col-xs-5 yt-megamenu">
											<div class="yt-header-under">
												<?php if ( has_nav_menu('primary_menu') ) {?>
													<nav id="primary-menu" class="primary-menu">
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
												<?php } ?>
											</div>	
										</div>
										<div class="top-header-sidebar col-lg-2 col-md-2 col-sm-3 col-xs-7">
												<div class="top-header-sidebar-menu">
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
																<a href="javascript:void(0)" title="Close" class="close close-login" data-dismiss="modal">Close</a>
																<div class="tt_popup_login"><strong><?php esc_html_e('Sign in Or Register', 'shoppystore'); ?></strong></div>
																<?php get_template_part('woocommerce/myaccount/login-form'); ?>
															</div>
												</div>
												<?php } ?>
												<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e( 'My Account', 'shoppystore' ); ?>" class="btn-reg-popup"><div class="account pull-right"></div></a>
												<?php if ( class_exists( 'WooCommerce' ) && !ya_options()->getCpanelValue( 'disable_cart' ) ) { ?>
													<div class="top-header-sidebar-cart">
														 <?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
													</div>
												<?php } ?>
												
											
												<div class="top-header-sidebar-search"> 
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
	<div id="main" class="theme-clearfix" role="document">
	<?php

		if (function_exists('ya_breadcrumb')){
			ya_breadcrumb('<div class="breadcrumbs theme-clearfix"><div class="container">', '</div></div>');
		} 

	?>
