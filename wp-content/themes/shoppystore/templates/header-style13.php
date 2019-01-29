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
<div class="wrap-header">
	<header id="header" class="header-style13">
		<div class="container">
			<div class="top-header">
				<div class="header-close"></div>
				<div class="ya-logo pull-left">
					<?php ya_logo(); ?>
				</div>
				
				<div id="menu-header" class="menu-header">
					<?php
					if ( has_nav_menu( 'primary_menu' ) ) {
						 wp_nav_menu( array( 'theme_location' => 'primary_menu','menu_class' => 'vertical-megamenu' ) );
				} ?> 
				<div class="ya_social">
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
				</div>
			</div>
		</div>
	</header>
	<div class="header-open"></div>
</div>
<div class="wap-main">

	<div id="main" class="theme-clearfix" role="document">
	   <div class="header-main">
	
			<div id="sidebar-top-header" class="sidebar-top-header">
	                <?php if (is_active_sidebar_YA('top-header')) {?>
					    <?php dynamic_sidebar('top-header'); ?>
					<?php }?>
					<?php if ( class_exists( 'WooCommerce' ) && !ya_options()->getCpanelValue( 'disable_cart' ) ) { ?>
						<div class="top-header-sidebar-cart pull-right">
							 <?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
						</div>
					<?php } ?>
					
					<div class="my-account block-action-header pull-right">
					    <ul>
					        <li>
					            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php esc_html_e('My Account', 'shoppystore'); ?></a>
					        	<ul>
					        	<li><?php get_template_part('widgets/ya_top/login'); ?></li>
								   <li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e('My Account','shoppystore'); ?>"><?php esc_html_e('My Account','shoppystore'); ?></a></li>
								   <li><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" title="<?php esc_attr_e( 'Cart', 'shoppystore' ) ?>"><?php esc_html_e('My Cart', 'shoppystore'); ?></a></li>
								   <li><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>" title="<?php esc_attr_e( 'Check Out', 'shoppystore' ) ?>"><?php esc_html_e('Checkout', 'shoppystore'); ?></a></li>
						        </ul>
					        </li>
					        
					    </ul>
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
	<?php

		if (function_exists('ya_breadcrumb')){
			ya_breadcrumb('<div class="breadcrumbs theme-clearfix"><div class="container">', '</div></div>');
		} 

	?>
		