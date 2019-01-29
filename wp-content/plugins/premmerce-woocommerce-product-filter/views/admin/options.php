<?php

if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * @var \Premmerce\Filter\Admin\Tabs\Base\TabInterface[] $tabs
 */
?>
<div class="wrap">
    <h1><?php _e( 'Premmerce WooCommerce Product Filter', 'premmerce-filter' ) ?></h1>
    <h2 class="nav-tab-wrapper">
		<?php foreach ( $tabs as $tab ): ?>
			<?php if ( $tab->valid() ): ?>
				<?php $class = ( $tab == $current ) ? ' nav-tab-active' : ''; ?>
                <a class='nav-tab<?php echo $class ?>'
                   href='?page=premmerce-filter-admin&tab=<?php echo $tab->getName() ?>'><?php echo $tab->getLabel() ?></a>
			<?php endif; ?>
		<?php endforeach; ?>
    </h2>

	<?php echo $current->render() ?>

</div>

