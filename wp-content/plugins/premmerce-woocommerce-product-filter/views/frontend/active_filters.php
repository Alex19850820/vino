<?php

if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * @var array  $activeFilters
 * @var array  $args
 * @var array  $instance
 * @var bool   $showResetFilter
 * @var string $resetFilter
 */

?>

<?php if (empty($activeFilters)): ?>
    <div class="premmerce-active-filters-widget-wrapper"></div>
<?php else: ?>
    <?php echo $args['before_widget']; ?>

    <?php if ( ! empty($instance['title'])): ?>
        <?php echo $args['before_title'] . $instance['title'] . $args['after_title'] ?>
    <?php endif; ?>

    <div class="pc-active-filter" data-premmerce-active-filter>
        <div class="pc-active-filter__list">
            <?php foreach ($activeFilters as $item): ?>

                <?php do_action('premmerce_filter_render_active_item_before', $item); ?>

                <div class="pc-active-filter__list-item">
                    <a data-premmerce-active-filter-link class="pc-active-filter__item-link" rel="nofollow"
                       aria-label="<?= esc_attr__('Remove filter', 'woocommerce') ?>" href="<?= $item['link'] ?>">
                    <span class="pc-active-filter__item-text-el">
                        <?php echo apply_filters('premmerce_filter_render_active_item_title', $item['title']) ?>
                    </span>
                        <span class="pc-active-filter__item-delete">
                        <?php echo apply_filters('premmerce_filter_render_active_item_close', 'x') ?>
                    </span>
                    </a>
                </div>

                <?php do_action('premmerce_filter_render_active_item_after', $item); ?>

            <?php endforeach; ?>

            <?php if ($showResetFilter): ?>
            <div class="pc-active-filter__list-item">
                <a data-premmerce-active-filter-link class="pc-active-filter__item-link" rel="nofollow"
                   aria-label="<?= esc_attr__('Reset filter', 'premmerce-filter') ?>"
                   href="<?= $resetFilter ?>">
                    <span class="pc-active-filter__item-text-el">
                        <?php echo apply_filters('premmerce_filter_render_active_item_title',
                            __('Reset filter', 'premmerce-filter')) ?>
                    </span>
                    <span class="pc-active-filter__item-delete">
                        <?php echo apply_filters('premmerce_filter_render_active_item_close', 'x') ?>
                    </span>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php echo $args['after_widget']; ?>
<?php endif; ?>

