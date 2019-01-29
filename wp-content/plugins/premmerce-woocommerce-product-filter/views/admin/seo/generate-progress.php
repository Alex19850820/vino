<?php

if ( ! defined('ABSPATH')) {
    exit;
}

/** @var string $complete */
/** @var string $action */
/** @var int $max */
?>

<div class="wrap">
    <div class="progress-bar">
        <div class="progress-bar__widget"></div>
        <div class="progress-bar__text">
            <span class="progress-bar__text-current" data-progressbar-current>0</span>/<span
                    class="progress-bar__text-max" data-progressbar-max><?php echo $max; ?></span>
        </div>
        <input type="hidden"
               data-progress-complete-url
               value="<?php echo $complete ?>"
        ><input type="hidden"
                data-progress-action
                value="<?php echo $action ?>"
        >
    </div>
</div>

