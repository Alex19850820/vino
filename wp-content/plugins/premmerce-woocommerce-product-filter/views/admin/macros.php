<?php

if ( ! defined('ABSPATH')) {
    exit;
}

if ( ! function_exists('premmerce_filter_admin_variables')) {

    function premmerce_filter_admin_variables($field)
    {
        ?>
        <button class="button-secondary" type="button" data-var="{name}" data-field="<?php echo $field ?>">
            <?php _e('Category name', 'premmerce-filter') ?>
        </button>
        <button class="button" type="button" data-var="{description}" data-field="<?php echo $field ?>">
            <?php _e('Category description', 'premmerce-filter') ?>
        </button>
        <button class="button" type="button" data-var="{attributes}" data-field="<?php echo $field ?>">
            <?php _e('Attributes', 'premmerce-filter') ?>
        </button>
        <button class="button" type="button" data-var="{brands}" data-field="<?php echo $field ?>">
            <?php _e('Brands', 'premmerce-filter') ?>
        </button>
        <button class="button" type="button" data-var="{min_price}" data-field="<?php echo $field ?>">
            <?php _e('Min price', 'premmerce-filter') ?>
        </button>
        <button class="button" type="button" data-var="{max_price}" data-field="<?php echo $field ?>">
            <?php _e('Max price', 'premmerce-filter') ?>
        </button>
        <button class="button" type="button" data-var="{count}" data-field="<?php echo $field ?>">
            <?php _e('Number of products', 'premmerce-filter') ?>
        </button>
        <?php
    }
}

if ( ! function_exists('premmerce_filter_admin_term_table_row')) {

    function premmerce_filter_admin_term_table_row($attributes, $selectedTaxonomy = null, $dataTermIds = null)
    {
        ?>
        <tr>
            <td>
                <select data-select-taxonomy data-select-two>
                    <option value=""><?php _e('Select taxonomy', 'premmerce-filter') ?></option>
                    <?php foreach ($attributes as $taxonomy => $label): ?>
                        <?php $selected = ($selectedTaxonomy == $taxonomy) ? 'selected' : '' ?>
                        <option <?php echo $selected ?>
                                value="<?php echo $taxonomy ?>"><?php echo $label ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <select data-select-term
                        data-select-two
                        multiple
                        data-allow-clear="true"
                        data-placeholder="<?php _e('Select term', 'premmerce-filter') ?>"
                        data-selected-value="<?php echo $dataTermIds ? htmlspecialchars(json_encode($dataTermIds),
                            ENT_QUOTES,
                            'UTF-8') : ''; ?>">
                    <option value="">
                        <?php _e('Select term', 'premmerce-filter') ?>
                    </option>
                </select>
            </td>
            <td>
                <span class="dashicons dashicons-no-alt remove-icon" data-remove-row></span>
            </td>
        </tr>

        <?php
    }
}

if ( ! function_exists('premmerce_filter_admin_seo_variable_inputs')) {
    function premmerce_filter_admin_seo_variable_inputs($rule = [])
    {
        $rule = array_merge([
            'h1'               => '',
            'title'            => '',
            'meta_description' => '',
            'description'      => '',
            'enabled'          => true,
        ], $rule);

        ?>
        <div class="premmerce-filter-form">
            <div class="form-field">
                <label for="h1">
                    <?php _e('H1', 'premmerce-filter') ?>
                </label>
                <input type="text" name="h1" id="rule-h1" value="<?php echo $rule['h1'] ?>">
                <?php premmerce_filter_admin_variables('#rule-h1') ?>
            </div>
            <div class="form-field">
                <label for="title">
                    <?php _e('Title', 'premmerce-filter') ?>
                </label>
                <input name="title" type="text" id="rule-title" value="<?php echo $rule['title'] ?>">
                <?php premmerce_filter_admin_variables('#rule-title') ?>
            </div>
            <div class="form-field">
                <label for="meta_description">
                    <?php _e('Meta description', 'premmerce-filter') ?>
                </label>
                <textarea name="meta_description" id="rule-meta-description" cols="30"
                          rows="5"><?php echo $rule['meta_description'] ?></textarea>
                <?php premmerce_filter_admin_variables('#rule-meta-description') ?>

            </div>
            <div class="form-field">
                <label for="description">
                    <?php _e('Description', 'premmerce-filter') ?>
                </label>
                <?php wp_editor($rule['description'], 'rule-description',
                    ['textarea_name' => 'description', 'textarea_rows' => 5]) ?>
                <?php premmerce_filter_admin_variables('#rule-description') ?>
            </div>
            <div class="form-field">
                <label>
                    <input type="checkbox" name="enabled" <?php checked(1, $rule['enabled']) ?>>
                    <?php _e('Enable', 'premmerce-filter'); ?>
                </label>
                <p class="description">
                    <?php _e('Enable this rule.', 'premmerce-filter'); ?>
                </p>
            </div>
        </div>

        <?php
    }
}