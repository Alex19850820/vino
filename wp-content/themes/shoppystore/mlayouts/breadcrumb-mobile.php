<header id="header" class="header-page">
	<div class="header-shop clearfix">
		<div class="back-history"></div>
		<h1 class="page-title"><?php bosmarket_title(); ?></h1>
		<?php if ( has_nav_menu('vertical_menu') && !has_nav_menu('mobile_header_menu') ) {?>
			<div class="vertical_megamenu vertical_megamenu_shop pull-right">
				<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
			</div>
		<?php }else{ ?>
			<div class="vertical_megamenu vertical_megamenu_shop pull-right">
				<?php wp_nav_menu(array('theme_location' => 'mobile_header_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
			</div>
		<?php } ?>
	</div>
</header>