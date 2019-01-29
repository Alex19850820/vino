<?php namespace Premmerce\Filter\Frontend;

use Premmerce\Filter\Ajax\Strategy\ThemeStrategyInterface;
use Premmerce\Filter\Ajax\Strategy\WidgetsStrategy;
use Premmerce\Filter\Filter\Container;
use Premmerce\Filter\FilterPlugin;
use Premmerce\SDK\V2\FileManager\FileManager;

class Frontend
{
    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @var Container
     */
    private $container;

    /**
     * Frontend constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->fileManager = $container->getFileManager();

        $this->container = $container;

        add_action("wp_enqueue_scripts", array($this, 'registerAssets'));

        add_action('template_redirect', function () {

            /**
             * Strategy can add own hooks , so it should be instantiated independently
             */
            $this->loadStrategy();

            if (! empty($_REQUEST['premmerce_filter_ajax_action'])) {
                $action = $_REQUEST['premmerce_filter_ajax_action'];

                switch ($action) {
                    case 'reload':
                        $response = apply_filters('premmerce_filter_ajax_response_reload', array());
                        wp_send_json($response);
                        break;

                    case 'deferred':
                        $response = apply_filters(
                            'premmerce_filter_ajax_response_deferred',
                            (new WidgetsStrategy())->updateResponse(array())
                        );
                        wp_send_json($response);
                        break;
                }
            }
        });
    }

    /**
     * Instantiate current ajax strategy
     */
    public function loadStrategy()
    {
        $strategy = apply_filters('premmerce_filter_ajax_current_strategy', null);

        if (is_string($strategy) && class_exists($strategy)) {
            $strategy = new $strategy;
        }

        if ($strategy instanceof ThemeStrategyInterface) {
            add_filter('premmerce_filter_ajax_response_reload', array($strategy, 'updateResponse'));
        }
    }

    /**
     * Register assets
     */
    public function registerAssets()
    {
        if (apply_filters('premmerce_product_filter_active', false)) {
            $settings = $this->container->getOption('settings');

            wp_enqueue_script('premmerce_filter_script', $this->fileManager->locateAsset('front/js/script.js'), array(
                'jquery',
                'jquery-ui-slider',
            ), FilterPlugin::VERSION, true);

            wp_enqueue_style(
                'premmerce_filter_style',
                $this->fileManager->locateAsset('front/css/style.css'),
                array(),
                FilterPlugin::VERSION
            );

            $localizeOptions = array();

            $localizeOptions['useAjax']      = ! empty($settings['use_ajax']);
            $localizeOptions['loadDeferred'] = ! empty($settings['load_deferred']);

            wp_localize_script('premmerce_filter_script', 'premmerce_filter_settings', $localizeOptions);
        }
    }
}
