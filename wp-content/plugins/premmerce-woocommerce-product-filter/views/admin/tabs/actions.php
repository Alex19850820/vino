<?php

if ( ! defined('ABSPATH')) {
    exit;
}

/** @var array $actions */
/** @var string $dataAction */
?>
<div class="alignleft actions bulkactions" data-bulk-actions>
    <label for="bulk-action-selector-top"
           class="screen-reader-text"><?php _e('Select bulk action', 'premmerce-filter') ?></label>
    <select data-bulk-action-select>
		<?php foreach($actions as $key => $title): ?>
			<?php if(is_array($title)): ?>
                <optgroup label="<?=$key?>">
					<?php foreach($title as $itemKey => $itemTitle): ?>
                        <option value="<?php echo $itemKey ?>"><?php echo $itemTitle ?></option>
					<?php endforeach; ?>
                </optgroup>
			<?php else: ?>
                <option value="<?php echo $key ?>"><?php echo $title ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
    </select>
    <button type="button" data-action="<?php echo $dataAction ?>"
            class="button"><?php _e('Apply', 'premmerce-filter') ?></button>
</div>