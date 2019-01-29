<?php

if ( ! defined('ABSPATH')) {
    exit;
}

?>

<h2><?php _e('Cache', 'premmerce-filter') ?></h2>
<table>
    <tbody>
    <tr>
        <td>
            <form action="<?php echo admin_url('admin-post.php') ?>" method="post">
                <button class="button"><?php _e('Clear cache', 'premmerce-filter') ?></button>
                <input type="hidden" name="action" value="premmerce_filter_cache_clear">
            </form>
        </td>
    </tr>
    </tbody>
</table>
