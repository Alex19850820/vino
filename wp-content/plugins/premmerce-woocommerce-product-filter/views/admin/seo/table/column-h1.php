<?php

if ( ! defined('ABSPATH')) {
    exit;
}

/** @var array $item */
$term     = get_term($item['term_id']);
$editLink = $url . '&action=edit&id=' . $item['id'];

$path = apply_filters('wpml_permalink',home_url($item['path']));
?>
<strong><a href="<?php echo $editLink ?>"><?php echo $term->name ?></a></strong>
<div class="row-actions">
                <span class="edit">
                    <a href="<?php echo $editLink ?>">
                        <?php _e('Edit', 'premmerce-filter') ?>
                    </a> | 
                </span>
    <span class="delete">
                    <a data-id="<?php echo $item['id'] ?>" data-link="delete"
                       href="<?php echo $url . '&action=delete&ids[]=' . $item['id'] ?>">
                        <?php _e('Delete', 'premmerce-filter') ?>
                    </a> |
                </span>
    <span class="view">
                    <a href="<?php echo $path ?>" target="_blank">
                        <?php _e('View', 'premmerce-filter') ?>
                    </a>
                </span>
</div>