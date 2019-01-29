<?php

if ( ! defined('ABSPATH')) {
    exit;
}

/** @var array $categories */
/** @var array $attributes */
?>

<div class="wrap">
    <div>
        <a href="<?php echo menu_page_url('premmerce-filter-admin', false) . '&tab=seo' ?>">
            ← <?php _e('Back', 'premmerce-filter') ?>
        </a>
    </div>
    <form data-generation-form method="post">

        <input type="hidden" name="action" value="generation_progress">

<!--        TODO: REMOVE[DEBUG] fot GET REQUEST-->
<!--        <input type="hidden" name="tab" value="seo">-->
<!--        <input type="hidden" name="page" value="premmerce-filter-admin">-->

        <div class="form-wrap">
            <h3><?php _e('Generate rules', 'premmerce-filter'); ?></h3>
            <div class="form-field form-required">
                <label><?php _e('Categories', 'premmerce-filter'); ?></label>
                <select multiple
                        data-generate-select-two
                        placeholder="<?php _e('Select category', 'premmerce-filter'); ?>"
                        name="filter_category[]"
                >
                    <?php foreach ($categories as $id => $category): ?>
                        <option value="<?php echo $id ?>"><?php echo $category ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div data-taxonomies-wrapper>
                <div class="form-field form-required">
                    <label><?php _e('Taxonomies', 'premmerce-filter'); ?></label>
                    <select multiple
                            data-generate-select-two
                            data-taxonomy-select
                            placeholder="<?php _e('Select taxonomy', 'premmerce-filter') ?>"
                            name="filter_taxonomy[1][]"
                    >
                        <?php foreach ($attributes as $taxonomy => $attribute): ?>
                            <option value="<?php echo $taxonomy ?>"><?php echo $attribute ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="button" class="button" data-add-taxonomy-button>
                <?php _e('Add taxonomy', 'premmerce-filter') ?>
            </button>

            <?php premmerce_filter_admin_seo_variable_inputs() ?>
            <button data-generate-button type="submit" class="button"><?php _e('Generate',
                    'premmerce-filter'); ?></button>
        </div>
    </form>
</div>

<div class="form-field form-required generation-taxonomy" data-taxonomy-prototype data-select-field hidden>
    <label><?php _e('Taxonomies', 'premmerce-filter'); ?></label>
    <div class="generation-taxonomy__select-wrapper">

        <select multiple
                placeholder="<?php _e('Select taxonomy', 'premmerce-filter') ?>"
                data-taxonomy-select
        >
            <?php foreach ($attributes as $taxonomy => $attribute): ?>
                <option value="<?php echo $taxonomy ?>"><?php echo $attribute ?></option>
            <?php endforeach; ?>
        </select>
        <span class="remove-icon dashicons dashicons-no-alt"
              data-remove-element="[data-select-field]"></span>
    </div>
</div>


