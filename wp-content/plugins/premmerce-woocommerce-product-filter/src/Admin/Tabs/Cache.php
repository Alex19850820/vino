<?php namespace Premmerce\Filter\Admin\Tabs;

use Premmerce\Filter\Admin\Tabs\Base\TabInterface;
use Premmerce\SDK\V2\FileManager\FileManager;

class Cache implements TabInterface
{
    /**
     * @var FileManager
     */
    private $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function init()
    {
        add_action('admin_post_premmerce_filter_cache_clear', function () {
            (new \Premmerce\Filter\Cache\Cache())->clear();
            wp_redirect($_SERVER['HTTP_REFERER']);
            die;
        });
    }

    public function render()
    {
        $this->fileManager->includeTemplate('admin/tabs/cache.php');
    }

    public function getLabel()
    {
        return __('Cache', 'premmerce-filter');
    }

    public function getName()
    {
        return 'cache';
    }

    public function valid()
    {
        return true;
    }
}
