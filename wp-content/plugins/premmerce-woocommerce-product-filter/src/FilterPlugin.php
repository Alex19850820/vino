<?php namespace Premmerce\Filter;

use Premmerce\Filter\Admin\Admin;
use Premmerce\Filter\Cache\Cache;
use Premmerce\Filter\Filter\Container;
use Premmerce\Filter\Filter\Filter;
use Premmerce\Filter\Frontend\Frontend;
use Premmerce\Filter\Updates\Updater;
use Premmerce\SDK\V2\FileManager\FileManager;
use Premmerce\SDK\V2\Notifications\AdminNotifier;
use Premmerce\SDK\V2\Plugin\PluginInterface;

/**
 * Class FilterPlugin
 *
 * @package Premmerce\Filter
 */
class FilterPlugin implements PluginInterface
{
    const VERSION = '3.1';

    const DOMAIN = 'premmerce-filter';

    const OPTION_ATTRIBUTES = 'premmerce_filter_attributes';

    const OPTION_COLORS = 'premmerce_filter_colors';

    const DEFAULT_TAXONOMIES = array("product_cat", "product_tag", "product_brand");

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @var AdminNotifier
     */
    private $notifier;

    /**
     * PluginManager constructor.
     *
     * @param string $mainFile
     */
    public function __construct($mainFile)
    {
        $this->fileManager = new FileManager($mainFile, 'premmerce-woocommerce-product-filter');
        $this->notifier    = new AdminNotifier();

        Container::getInstance()->addService('file_manager', $this->fileManager);

        $this->registerHooks();
    }

    /**
     * Run plugin part
     */
    public function run()
    {
        $valid = count($this->validateRequiredPlugins()) == 0;

        if ($valid) {
            (new Updater())->update();
            new Filter(Container::getInstance());
        }

        if (is_admin()) {
            new Admin($this->fileManager);
        } else {
            new Frontend(Container::getInstance());
        }
    }

    public function registerHooks()
    {
        add_action('plugins_loaded', array($this, 'loadTextDomain'));
        add_action('admin_init', array($this, 'checkRequirePlugins'));
    }

    /**
     * Fired when the plugin is activated
     */
    public function activate()
    {
        if (! get_option('premmerce_filter_settings')) {
            $defaultOptions = array(
                "show_price_filter" => "on",
                "hide_empty"        => "on",
                "product_cat"       => "on",
                "tag"               => "on",
                "product_brand"     => "on",
                "search"            => "on",
                "shop"              => "on",
                "attribute"         => "on",
            );
            add_option('premmerce_filter_settings', $defaultOptions);
        }

        (new Updater())->installDb();
    }

    /**
     * Fired when the plugin is deactivated
     */
    public function deactivate()
    {
        $cache = new Cache();
        $cache->clear();
        rmdir($cache->getCacheDir());
    }

    /**
     * Fired during plugin uninstall
     */
    public static function uninstall()
    {
        delete_option(self::OPTION_ATTRIBUTES);
        delete_option(self::OPTION_COLORS);
        delete_option('premmerce_filter_settings');
        delete_option('premmerce_filter_permalink_settings');
        delete_option(Updater::DB_OPTION);
    }

    /**
     * Check required plugins and push notifications
     */
    public function checkRequirePlugins()
    {
        $message = __('The %s plugin requires %s plugin to be active!', 'premmerce-filter');

        $plugins = $this->validateRequiredPlugins();

        if (count($plugins)) {
            foreach ($plugins as $plugin) {
                $error = sprintf($message, 'Premmerce WooCommerce Product Filter', $plugin);
                $this->notifier->push($error, AdminNotifier::ERROR, false);
            }
        }
    }

    /**
     * Validate required plugins
     *
     * @return array
     */
    private function validateRequiredPlugins()
    {
        $plugins = array();

        if (! function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        /**
         * Check if WooCommerce is active
         **/
        if (! (is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active_for_network('woocommerce/woocommerce.php'))) {
            $plugins[] = '<a target="_blank" href="https://wordpress.org/plugins/woocommerce/">WooCommerce</a>';
        }

        return $plugins;
    }

    /**
     * Load plugin translations
     */
    public function loadTextDomain()
    {
        $name = $this->fileManager->getPluginName();
        load_plugin_textdomain('premmerce-filter', false, $name . '/languages/');
    }
}
