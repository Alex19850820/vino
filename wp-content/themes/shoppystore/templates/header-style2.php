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
		<div class="header-style2">
			<div class="yt-header-top">
				<div class="container">
					<div class="row">				
						<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 pull-right">
							<div class="yt-header-topv2">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 sl-header-text">
										<div class="offer-wrapper">
											<div class="offer-wrapper">
												<div class="offer-header">
													<ul id="offer-info">
														<li>
															<?php if($ya_phone != '') {?>
															<i class="sp-ic fa fa-phone-square">&nbsp;</i><?php esc_html_e('Telephone:','shoppystore') ;?> <a title="<?php echo esc_attr( $ya_phone ) ?>" href="#"><?php echo esc_html( $ya_phone ) ?></a> 
															<?php } ?>
														</li>
														<li>
															<?php if($email != '') {?>
															<i class="sp-ic fa fa-envelope">&nbsp;</i><?php esc_html_e('E-mail:','shoppystore') ;?> <a title="<?php echo esc_attr( $email ) ?>" href="mailto:<?php echo esc_attr( $email ) ?>"><?php echo esc_attr( $email ) ?></a>
															<?php } ?>
														</li>
													</ul>
												</div>
											</div>
										</div>							
									</div>
									<!-- LANGUAGE_CURENCY -->
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 top-links-action">
										<?php if (is_active_sidebar_YA('top')) {?>
												<?php dynamic_sidebar('top'); ?>
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
								</div>
							</div>
							<div class="yt-header-middle">
								
									<div class="row">							
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 yt-megamenu">
											<div class="yt-header-under">
												<?php if ( has_nav_menu('primary_menu') ) {?>
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
												<?php } ?>
												<div class="yt-searchpro">
												<a class="btn-search-mobilev2 phone-icon-search icon-search" title="Search"><i class="fa fa-search"></i></a>
												<div id="sm_serachbox_pro" class="sm-serachbox-pro">
														<?php if( $ya_search ) {?>
														<div class="sm-searbox-content">
															 <?php get_template_part( 'widgets/ya_top/searchcate' ); ?>
														</div>
														<?php } ?>
													</div>
												</div>
												<?php if ( class_exists( 'WooCommerce' ) && !ya_options()->getCpanelValue( 'disable_cart' ) ) { ?>
													<div class="mini-cart-header">
													<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
													</div>
												<?php } ?>
												
											</div>
											
										</div>

									</div>
								
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 logo-wrapper pull-left">
							<div class="logo-wrapperv2">
								<h1>
									<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<?php if( $main_logo != '' ) { ?>
								   	<img src="<?php echo esc_url( $main_logo ); ?>" alt="<?php bloginfo('name'); ?>" width="140" height="57"/>
								<?php }else{ 
											$logo = get_template_directory_uri().'/assets/img/logo_v2.png';
										?>
											<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php bloginfo('name'); ?>"  width="140" height="57"/>
									<?php } ?>
								   </a>
								</h1>
							</div>
						</div>
					</div>	
				</div>
				<!-- END CONTAINER -->
			</div>
		</div>
	</div>
	<div id="main" class="theme-clearfix" role="document">
	<?php

		if (function_exists('ya_breadcrumb')){
			ya_breadcrumb('<div class="breadcrumbs theme-clearfix"><div class="container">', '</div></div>');
		} 

	?>