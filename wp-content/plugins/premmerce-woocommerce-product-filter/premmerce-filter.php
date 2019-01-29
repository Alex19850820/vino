<?php

use Premmerce\Filter\FilterPlugin;

/**
 * Premmerce WooCommerce Product Filter
 *
 * @package           Premmerce\Filter
 *
 * @wordpress-plugin
 * Plugin Name:       Premmerce WooCommerce Product Filter
 * Plugin URI:        https://premmerce.com/woocommerce-product-filter/
 * Description:       Premmerce WooCommerce Product Filter plugin is a convenient and flexible tool for managing filters for WooCommerce products.
 * Version:           3.1.2
 * Author:            premmerce
 * Author URI:        https://premmerce.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       premmerce-filter
 * Domain Path:       /languages
 *
 * WC requires at least: 3.0.0
 * WC tested up to: 3.5
 *
 * @fs_premium_only /src/Admin/Tabs/SeoRules.php, /src/Admin/Tabs/SeoSettings.php, /src/Admin/Tabs/PermalinkSettings.php, /src/Seo/, /src/Permalinks/, /src/Exceptions/
 */

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

if ( ! function_exists('premmerce_pwpf_fs')) {

    call_user_func(function () {

        require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

        require_once plugin_dir_path(__FILE__) . '/freemius.php';

        $main = new FilterPlugin(__FILE__);

        register_activation_hook(__FILE__, [$main, 'activate']);

        register_deactivation_hook(__FILE__, [$main, 'deactivate']);

        register_uninstall_hook(__FILE__, [FilterPlugin::class, 'uninstall']);

        $main->run();
    });

}
