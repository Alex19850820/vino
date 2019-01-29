<?php namespace Premmerce\Filter\Filter;

use Premmerce\SDK\V2\FileManager\FileManager;

class ItemRenderer
{
    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * ItemRenderer constructor.
     *
     * @param FileManager $fileManager
     */
    public function __construct($fileManager)
    {
        $this->fileManager = $fileManager;

        add_action('premmerce_filter_render_item_checkbox', array($this, 'renderCheckbox'), 10);
        add_action('premmerce_filter_render_item_radio', array($this, 'renderRadio'), 10);
        add_action('premmerce_filter_render_item_select', array($this, 'renderSelect'), 10);
        add_action('premmerce_filter_render_item_label', array($this, 'renderLabel'), 10);
        add_action('premmerce_filter_render_item_color', array($this, 'renderColor'), 10);
        add_action('premmerce_filter_render_item_slider', array($this, 'renderSlider'), 10);
        add_action('premmerce_filter_render_item_after_title', array($this, 'renderAfterTitle'), 10);
    }

    /**
     * @param $attribute
     */
    public function renderCheckbox($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/checkbox.php', array('attribute' => $attribute));
    }

    /**
     * @param $attribute
     */
    public function renderRadio($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/radio.php', array('attribute' => $attribute));
    }

    /**
     * @param $attribute
     */
    public function renderSelect($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/select.php', array('attribute' => $attribute));
    }

    /**
     * @param $attribute
     */
    public function renderColor($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/color.php', array('attribute' => $attribute));
    }

    /**
     * @param $attribute
     */
    public function renderSlider($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/slider.php', array('attribute' => $attribute));
    }

    /**
     * @param $attribute
     */
    public function renderLabel($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/label.php', array('attribute' => $attribute));
    }

    /**
     * @param $attribute
     */
    public function renderAfterTitle($attribute)
    {
        $this->fileManager->includeTemplate('frontend/parts/dropdown-handle.php', array('attribute' => $attribute));
    }
}
