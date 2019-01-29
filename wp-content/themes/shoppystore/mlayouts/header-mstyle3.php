<?php 
	/* 
	** Content Header
	*/
	$ya_mobile_logo = ya_options()->getCpanelValue( 'mobile_logo' );
?>
<?php if( is_front_page() || get_post_meta( get_the_ID(), 'page_mobile_enable', true ) || is_search() || ya_options()->getCpanelValue( 'mobile_header_inside' ) ): ?>
<header id="header" class="header header-mobile-style3">
	<div class="header-wrrapper clearfix">
		<div class="header-top-mobile">
			<div class="header-menu-categories pull-left">
				<?php if ( has_nav_menu('leftmenu') ) {?>
					<div class="vertical_megamenu">
						<?php wp_nav_menu(array('theme_location' => 'leftmenu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
			<?php } ?>
			</div>
			<div class="ya-logo">
				<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if( $ya_mobile_logo != '' ){ ?>
						<img src="<?php echo esc_url( $ya_mobile_logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
					<?php }else{
						$logo = get_template_directory_uri().'/assets/img/logo-mobile3.png'; ?>
						<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
					<?php } ?>					
				</a>
			</div>
			<div class="header-right pull-right">
				<div class="header-wishlist">
					<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>" title="<?php esc_attr_e('Wishlist','shoppystore'); ?>">
						<span class="fa fa-heart-o"></span>
					</a>
				</div>
				<div class="header-cart">
					<a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id') ); ?>">
						<?php get_template_part( 'woocommerce/minicart-ajax-mobile' ); ?>
					</a>
				</div>
			</div>			
		</div>
		<div class="mobile-search">
			<?php if( is_active_sidebar( 'search' ) && class_exists( 'sw_woo_search_widget' ) ): ?>
				<?php dynamic_sidebar( 'search' ); ?>
			<?php else : ?>
				<div class="non-margin">
					<div class="widget-inner">
					<div class="top-form top-search">
						<div class="topsearch-entry">
							<?php get_template_part( 'widgets/ya_top/searchcate' ); ?>
						</div>
					</div>
						
					</div>
				</div>
			<?php endif; ?>	
		</div>
	</div>
</header>
<?php else : ?>
<!--  header page -->
<header id="header-page" class="header-page">
	<div class="header-shop clearfix">
		<div class="container">
			<div class="back-history"></div>
			<h1 class="page-title"><?php ya_title(); ?></h1>
			<?php if ( has_nav_menu('leftmenu') ) {?>
					<div class="vertical_megamenu vertical_megamenu_shop pull-right">
						<?php wp_nav_menu(array('theme_location' => 'leftmenu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
			<?php } ?>
		</div>
	</div>
</header>
	<!-- End header -->
<?php endif; ?>