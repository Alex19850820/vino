<?php 
	$ya_colorset = ya_options()->getCpanelValue('scheme');
	$ya_phone = ya_options() ->getCpanelValue('phone');
	$email = ya_options() ->getCpanelValue('email');
	$ya_search = ya_options()->getCpanelValue('search');
?>
	<!-- BEGIN: Header -->
	<div id="yt_header" class="yt-header wrap">
		<div class="header-style7">
			<div class="yt-header-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 top-links-action">
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
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 logo-wrapper">
							<?php ya_logo(); ?>
						</div>
						<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 yt-megamenu">
							<div class="yt-header-under">
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
						<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 yt-cart">
						    <?php if ( class_exists( 'WooCommerce' ) && !ya_options()->getCpanelValue( 'disable_cart' ) ) { ?>
								<div class="mini-cart-header">
									 <?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
								</div>
							<?php } ?>
							
						</div>
					</div>
				</div>
			</div>
			<div class="yt-header-under-2">
				<div class="container">
					<div class="row">
					    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-2 vertical-mega">
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
						<div class="search-pro col-lg-3 col-md-3 col-sm-4 col-xs-10">
							<?php if($ya_phone != '') {?>
							<i class="sp-ic fa fa-phone-square">&nbsp;</i><?php esc_html_e('  Hotline:','shoppystore') ;?> <a title="<?php echo esc_attr( $ya_phone ) ?>" href="#"><?php echo esc_html( $ya_phone ) ?></a> 
							<?php } ?>
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