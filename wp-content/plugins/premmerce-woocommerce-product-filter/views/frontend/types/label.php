<div class="filter__labels-box">
    <?php foreach ($attribute->terms as $term): ?>
        <?php $id = 'filter-checkgroup-id-' . $attribute->attribute_name . '-' . $term->slug; ?>

        <div class="filter__label-item">
            <input class="filter__checkgroup-control"
                   id="<?php echo $id ?>"
                   type="checkbox"
                   data-premmerce-filter-link="<?php echo $term->link ?>"
                <?php echo $term->count == 0 ? 'disabled' : '' ?>
                   <?php if ($term->checked): ?>checked<?php endif ?>
            >
            <label class="filter__label-button"
                   for="<?php echo $id ?>"
                   title="<?php echo $term->name; ?>"
            >
                <?php echo $term->name; ?>
            </label>
        </div>
    <?php endforeach ?>
</div>