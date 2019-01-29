<?php namespace Premmerce\Filter\Filter\Items\Types;

abstract class BaseFilter implements FilterInterface
{
    /**
     * @var string
     */
    protected $queryType = 'or';

    /**
     * @var bool
     */
    protected $single = false;

    /**
     * @var string
     */
    protected $prefix = 'filter_';

    /**
     * @var string
     */
    protected $queryTypePrefix = 'query_type_';

    /**
     * checkbox|radio|select|label|color
     * @return string
     */
    public function getType()
    {
        return 'checkbox';
    }

    /**
     * @return string
     */
    public function getParamName()
    {
        return $this->prefix . $this->getSlug();
    }

    /**
     * @return string
     */
    public function getQueryTypeName()
    {
        return $this->queryTypePrefix . $this->getSlug();
    }

    /**
     * Default|Dropdown|Scroll|Dropdown+Scroll
     * @return string
     */
    public function getDisplay()
    {
        return '';
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return array();
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return array();
    }

    /**
     * @return array
     */
    public function getActiveItems()
    {
        return array();
    }

    /**
     * @return bool
     */
    public function isSingle()
    {
        return $this->single;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return count($this->getSelectedValues()) > 0;
    }

    /**
     * Term values in url get parameters
     *
     * @return array
     */
    protected function getSelectedValues()
    {
        $filterParam = $this->getParamName();

        $values = isset($_GET[$filterParam]) ? explode(',', wc_clean($_GET[$filterParam])) : array();

        $values = array_map('sanitize_title', $values);

        $values = array_filter($values, function ($item) {
            return $item !== '';
        });

        $values = array_unique($values);

        return $values;
    }

    /**
     * Link for term to select or deselect term
     *
     * @param $slug
     *
     * @return string
     */
    protected function getValueLink($slug)
    {
        $selectedValues = $this->getSelectedValues();

        $checked = in_array($slug, $selectedValues);

        $termKey = array_search($slug, $selectedValues);

        if ($this->isSingle()) {
            $selectedValues = $checked ? array() : array($slug);
        } else {
            if ($checked) {
                unset($selectedValues[$termKey]);
            } else {
                array_push($selectedValues, $slug);
            }
        }

        $link = $this->getResetUrl();


        if (count($selectedValues) > 0) {
            $link = add_query_arg($this->getParamName(), implode(',', $selectedValues), $link);
            $link = add_query_arg($this->getQueryTypeName(), $this->queryType, $link);
        }

        return apply_filters('premmerce_filter_term_link', $link);
    }

    /**
     * Get current page url except $taxonomy args (filter_$taxonomy || query_type_$taxonomy)
     *
     * @return string
     */
    public function getResetUrl()
    {
        global $wp;

        $link = home_url($wp->request);

        $pos = strpos($link, '/page');

        if ($pos !== false) {
            $link = substr($link, 0, $pos);
        }

        $currentParams = array(
            $this->getParamName(),
            $this->getQueryTypeName()
        );
        foreach ($_GET as $key => $value) {
            $isCurrent = in_array($key, $currentParams);

            if (! $isCurrent) {
                $link = add_query_arg($key, wc_clean($value), $link);
            }
        }

        return $link;
    }

    /**
     * Backward compat for templates
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case 'has_checked':
                return $this->isActive();
            case 'display_type':
                return $this->getDisplay();
            case 'attribute_label':
                return $this->getLabel();
            case 'attribute_name':
                return $this->getSlug();
            case 'terms':
                return $this->getItems();
            case 'html_type':
                return $this->getType();
            case 'reset_url':
                return $this->getResetUrl();
            case 'values':
                return $this->getOptions();
        }
    }

    /**
     * Backward compat for templates
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return in_array(
            $name,
            array(
                'has_checked',
                'display_type',
                'attribute_label',
                'attribute_name',
                'terms',
                'html_type',
                'reset_url',
                'values'
            )
        );
    }
}
