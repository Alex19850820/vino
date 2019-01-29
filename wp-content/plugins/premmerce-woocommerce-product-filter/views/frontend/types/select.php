<select data-filter-control-select class="filter__scroll form-control input-sm">
    <option value="<?php echo $attribute->reset_url ?>"><?php printf(__('Any %s',
            'woocommerce'),
            $attribute->attribute_label) ?></option>
    <?php foreach ($attribute->terms as $term): ?>
        <?php $selected = $term->checked ? 'selected' : ''; ?>
        <option <?php echo $selected ?>
            value="<?php echo $term->link ?>"><?php echo $term->name . ' (' . ($term->count) . ')' ?></option>
    <?php endforeach ?>
</select>