<?php
if ( ! defined('ABSPATH')) {
    exit;
}
/** @var array $terms */
/** @var array $termsConfig */
/** @var string $taxonomyName */
/** @var string $dataAction */
/** @var string $taxonomy */
?>
<h2><?php echo $taxonomy->label; ?></h2>
<div class="tablenav top">
    <?php include __DIR__ . '/actions.php' ?>
</div>

<table class="widefat premmerce-filter-table">
    <thead>
    <tr>
        <td class="check-column">
            <label for="">
                <input type="checkbox" data-select-all="attribute">
            </label>
        </td>
        <th><?php _e('Terms', 'premmerce-filter') ?></th>
        <th class="premmerce-filter-table__align-center"><?php _e("Visibility", 'premmerce-filter') ?></th>
        <th class="premmerce-filter-table__align-right"></th>
    </tr>
    </thead>
    <tbody data-sortable="premmerce_filter_sort_<?php echo $taxonomyName; ?>">


    <?php if(count($terms) > 0): ?>
        <?php foreach($terms as $id => $label): ?>
            <tr>
                <td>
                    <input data-selectable="attribute" type="checkbox" data-id="<?php echo $id ?>">
                </td>
                <td><?php echo $label ?></td>

                <td class="premmerce-filter-table__align-center">
                    <?php $active = $termsConfig[ $id ]['active'] ?>
                    <span data-single-action="<?php echo $dataAction; ?>" data-id="<?php echo $id ?>"
                          data-value="<?=$active? 'hide' : 'display'?>"
                          title="<?php $active? _e('Hide', 'premmerce-filter') : _e('Display', 'premmerce-filter') ?>"
                          class="dashicons dashicons-<?php echo $active? "visibility" : "hidden" ?> click-action-span"></span>
                </td>
                <td class="premmerce-filter-table__align-right"><span data-sortable-handle
                                                                      class="sortable-handle dashicons dashicons-menu"></span>
                </td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="2">
                <?php _e('No items found', 'premmerce-filter') ?>
            </td>
        </tr>
    <?php endif ?>
    </tbody>
</table>

<div class="tablenav bottom">
    <?php include __DIR__ . '/actions.php' ?>
</div>