<?php

if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * @var array $attributes
 * @var array $attributesConfig
 * @var array $types
 * @var array $actions
 * @var array $display
 */

?>

<h2><?php _e('Attributes', 'premmerce-filter') ?></h2>


<div class="tablenav top">
    <?php include __DIR__ . '/actions.php' ?>
</div>

<table class="widefat striped premmerce-filter-table">
    <thead>
    <tr>
        <td width="5%" class="check-column">
            <label for="">
                <input type="checkbox" data-select-all="attribute">
            </label>
        </td>
        <th width="20%"><?php _e('Field type', 'premmerce-filter') ?></th>
        <th width="20%"><?php _e('Display as', 'premmerce-filter') ?></th>
        <th width="25%"><?php _e('Attribute', 'premmerce-filter') ?></th>
        <th width="20%" class="premmerce-filter-table__align-center">
            <?php _e('Visibility', 'premmerce-filter') ?>
        </th>
        <th width="10%" class="premmerce-filter-table__align-right"></th>
    </tr>
    </thead>
    <tbody data-sortable="premmerce_filter_sort_attributes">

    <?php if (count($attributes) > 0): ?>
        <?php foreach ($attributes as $id => $label): ?>

            <tr>
                <td>
                    <input data-selectable="attribute" type="checkbox" data-id="<?php echo $id ?>">
                </td>

                <td>
                    <select data-single-action="premmerce_filter_bulk_action_attributes" data-id="<?php echo $id ?>">
                        <?php foreach ($types as $key => $type): ?>
                            <option <?php echo selected($key, $attributesConfig[$id]['type']) ?>
                                    value="<?php echo $key ?>"><?php echo $type ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($attributesConfig[$id]['type'] === 'color'): ?>
                        <a class="button" href="#" data-open-dialog="[data-color-dialog]"
                           data-attribute-id="<?php echo $id ?>">
                            <?php _e('Setup colors', 'premmerce-filter') ?>
                        </a>
                    <?php endif; ?>
                </td>
                <td>
                    <select data-single-action="premmerce_filter_bulk_action_attributes" data-id="<?php echo $id ?>">
                        <?php foreach ($display as $key => $type): ?>
                            <?php $displayValue = substr($key, strlen('display_')) ?>
                            <option <?php echo selected($displayValue, $attributesConfig[$id]['display_type']) ?>
                                    value="<?php echo $key ?>"><?php echo $type ?></option>
                        <?php endforeach; ?>
                    </select>

                </td>
                <td><?php echo $label ?></td>
                <td class="premmerce-filter-table__align-center">
                    <?php $active = $attributesConfig[$id]['active'] ?>
                    <span data-single-action="premmerce_filter_bulk_action_attributes" data-id="<?php echo $id ?>"
                          data-value="<?= $active ? 'hide' : 'display' ?>"
                          title="<?php $active ? _e('Hide', 'premmerce-filter') : _e('Display',
                              'premmerce-filter') ?>"
                          class="dashicons dashicons-<?php echo $active ? "visibility" : "hidden" ?> click-action-span"></span>
                </td>
                <td class="premmerce-filter-table__align-right"><span data-sortable-handle
                                                                      class="sortable-handle dashicons dashicons-menu"></span>
                </td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="5">
                <?php _e('No items found', 'premmerce-filter') ?>
            </td>
        </tr>
    <?php endif ?>
    </tbody>
</table>
<div class="tablenav bottom">
    <?php include __DIR__ . '/actions.php' ?>
</div>

<div data-color-dialog title="" class="hidden" data-save-text="<?php _e('Save','premmerce-filter')?>">

</div>