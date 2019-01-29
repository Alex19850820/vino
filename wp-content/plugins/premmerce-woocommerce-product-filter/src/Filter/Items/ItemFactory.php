<?php namespace Premmerce\Filter\Filter\Items;

use Premmerce\Filter\Filter\Items\Types\AttributeFilter;
use Premmerce\Filter\Filter\Items\Types\FilterInterface;
use Premmerce\Filter\Filter\Items\Types\SliderFilter;
use Premmerce\Filter\Filter\Items\Types\TaxonomyFilter;
use Premmerce\Filter\FilterPlugin;

class ItemFactory
{
    /**
     * @var array
     */
    private $colorOptions;

    /**
     * @var array
     */
    private $attributes;

    public function __construct()
    {
        $this->colorOptions = get_option(FilterPlugin::OPTION_COLORS, array());
    }

    /**
     * @param string $id
     * @param array $config
     *
     * @return null|FilterInterface
     */
    public function createItem($id, $config)
    {
        $type = $config['type'];

        $taxonomy  = null;
        $attribute = null;

        if ($attribute = $this->getAttribute($id)) {
            $taxonomy = get_taxonomy(wc_attribute_taxonomy_name($attribute->attribute_name));
        } elseif (taxonomy_exists($id)) {
            $taxonomy = get_taxonomy($id);
        }

        $item = null;


        if ($type === 'color' && $taxonomy) {
            if (isset($this->colorOptions[$taxonomy->name])) {
                $config['colors'] = $this->colorOptions[$taxonomy->name];
            }
        }
        if ($type === 'slider' && $taxonomy) {
            $item = new SliderFilter($config, $taxonomy);
        } elseif ($attribute && $taxonomy) {
            $item = new AttributeFilter($config, $attribute);
        } elseif ($taxonomy) {
            $item = new TaxonomyFilter($config, $taxonomy);
        }

        return apply_filters("filter_item_{$type}", $item, $config);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    private function getAttribute($id)
    {
        $at = $this->getAttributes();

        if (array_key_exists($id, $at)) {
            return $at[$id];
        }
    }

    /**
     * @return array
     */
    private function getAttributes()
    {
        if (is_null($this->attributes)) {
            $this->attributes = array();
            foreach (wc_get_attribute_taxonomies() as $item) {
                $this->attributes[$item->attribute_id] = $item;
            }
        }

        return $this->attributes;
    }
}
