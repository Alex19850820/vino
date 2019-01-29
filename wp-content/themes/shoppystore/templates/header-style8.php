<?php 
	$ya_colorset = ya_options()->getCpanelValue('scheme');
	$ya_phone = ya_options() ->getCpanelValue('phone');
	$email = ya_options() ->getCpanelValue('email');
	$ya_search = ya_options()->getCpanelValue('search');
?>
	<!-- BEGIN: Header -->
	<div id="yt_header" class="yt-header wrap">
		<div class="header-style8">
			<div class="yt-header-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 top-links-action">
							<?php if (is_active_sidebar_YA('top')) {?>
									<?php dynamic_sidebar('top'); ?>
							<?php }?>
						</div>
					</div>
				</div>
			</div>

			<div class="yt-header-middle">
				<div class="container">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 logo-wrapper">
							<?php ya_logo(); ?>
						</div>
						<div class="yt-bao">
						<div class="col-lg-7 col-md-7 col-sm-2 col-xs-3 yt-menu-wrapper">
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
						
						<div class="col-lg-3 col-md-3 col-sm-10 col-xs-9 yt-cart">
								<div class="yt-header-under">
								     <?php if ( class_exists( 'WooCommerce' ) && !ya_options()->getCpanelValue( 'disable_cart' ) ) { ?>
										<div class="mini-cart-header">
											 <?php get_template_part( 'woocommerce/minicart-ajax-style1' ); ?>
										</div>
									<?php } ?>
								    
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

	<div id="main" class="theme-clearfix" role="document">
	<?php

		if (function_exists('ya_breadcrumb')){
			ya_breadcrumb('<div class="breadcrumbs theme-clearfix"><div class="container">', '</div></div>');
		} 

	?>