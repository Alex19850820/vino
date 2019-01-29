<div class="filter__properties-list">
    <?php foreach ($attribute->terms as $term): ?>
        <?php $id = 'filter-checkgroup-id-' . $attribute->attribute_name . '-' . $term->slug; ?>
        <div class="filter__properties-item">
            <div class="filter__checkgroup" data-filter-control-checkgroup>
                <div class="filter__checkgroup-body">
                    <div class="filter__checkgroup-link">
                        <input class="filter__checkgroup-control"
                               <?php if ($term->checked): ?>checked<?php endif ?>
                               type="checkbox"
                               data-filter-control
                               id="<?php echo $id ?>"
                            <?php echo $term->count == 0 ? 'disabled' : '' ?>
                               data-premmerce-filter-link="<?php echo $term->link ?>">
                        <label class="filter__checkgroup-check"
                               data-filter-control-label
                               for="<?php echo $id ?>"></label>
                        <label class="filter__checkgroup-title <?php echo $term->count == 0 ? 'disabled' : '' ?>"
                               for="<?php echo $id ?>">
                            <?php echo $term->name; ?>
                        </label>
                    </div>
                </div>
                <div class="filter__checkgroup-aside">
                                    <span class="filter__checkgroup-count">
                                        <?php echo '(' . ($term->count) . ')' ?>
                                    </span>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>