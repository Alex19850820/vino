<?php 
	$ya_colorset = ya_options()->getCpanelValue('scheme');
	$ya_phone = ya_options() ->getCpanelValue('phone');
	$email = ya_options() ->getCpanelValue('email');
	$ya_search = ya_options()->getCpanelValue('search');
	$flytheme_header_style = ya_options()->getCpanelValue('header_style');
	$flytheme_my_social_fb = ya_options()->getCpanelValue('my-social-fb');
	$flytheme_my_social_tw = ya_options()->getCpanelValue('my-social-tw');
	$flytheme_my_social_in = ya_options()->getCpanelValue('my-social-in');
	$flytheme_my_social_go = ya_options()->getCpanelValue('my-social-go');
	$flytheme_my_social_pi = ya_options()->getCpanelValue('my-social-pi');
?>
	<!-- BEGIN: Header -->
	<div id="yt_header" class="yt-header wrap">
		<div class="header-style12">
			<div class="yt-header-top">
				<div class="container">
					<div class="row">
					
						<!-- LANGUAGE_CURENCY -->
						<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12 top-links-action">
							<?php if (is_active_sidebar_YA('top2')) {?>
									<?php dynamic_sidebar('top2'); ?>
							<?php }?>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12 sl-header-text">
						         <div class="sl-login pull-right">
							     	<?php get_template_part('widgets/ya_top/login-header12'); ?>
							     </div>
							<?php if(($flytheme_my_social_fb != '') || ($flytheme_my_social_tw != '') || ($flytheme_my_social_in != '') || ($flytheme_my_social_go != '') || ($flytheme_my_social_go != '') || ($flytheme_my_social_pi != '')) { ?>
								<div class="flytheme_social pull-right">
									<ul class="main-social">
										<li class="social-fb">
											<a target="_blank" href="<?php echo esc_attr( $flytheme_my_social_fb ); ?>"><i class="fa fa-facebook"></i></a>
										</li>
										<li class="social-tw">
											<a target="_blank" href="<?php echo esc_attr( $flytheme_my_social_tw ); ?>"><i class="fa fa-twitter"></i></a>
										</li>
										<li class="social-in">
											<a target="_blank" href="<?php echo esc_attr( $flytheme_my_social_in ); ?>"><i class="fa fa-linkedin"></i></a>
										</li>
										<li class="social-go">
											<a target="_blank" href="<?php echo esc_attr( $flytheme_my_social_go ); ?>"><i class="fa fa-google-plus"></i></a>
										</li>
										<li class="social-pi">
											<a target="_blank" href="<?php echo esc_attr( $flytheme_my_social_pi ); ?>"><i class="fa fa-pinterest"></i></a>
										</li>
									</ul>
								</div>
							<?php } ?>
							     
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
					</div>
				</div>
			</div>

			<div class="yt-header-middle">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-2 col-sm-12 col-xs-12 logo-wrapper">
							<?php ya_logo(); ?>
						</div>
						
						<div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 yt-megamenu">
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
							<?php if ( class_exists( 'WooCommerce' ) && !ya_options()->getCpanelValue( 'disable_cart' ) ) { ?>
								<div class="top-header-sidebar-cart pull-right">
									 <?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
								</div>
							<?php } ?>
							
									
							<div class="top-header-sidebar-search pull-right"> 
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

	<div id="main" class="theme-clearfix" role="document">
	<?php

		if (function_exists('ya_breadcrumb')){
			ya_breadcrumb('<div class="breadcrumbs theme-clearfix"><div class="container">', '</div></div>');
		} 

	?>