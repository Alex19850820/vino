<?php namespace Premmerce\Filter\Filter\Items\Types;

use stdClass;
use WP_Taxonomy;

class TaxonomyFilter extends BaseFilter
{
    /**
     * @var WP_Taxonomy
     */
    protected $taxonomy;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var stdClass[]
     */
    protected $terms;

    /**
     * @var bool
     */
    protected $hideEmpty;

    /**
     * @var
     */
    protected $config;

    /**
     * TaxonomyFilter constructor.
     *
     * @param $config
     * @param $taxonomy
     */
    public function __construct($config, $taxonomy)
    {
        $this->config    = $config;
        $this->taxonomy  = $taxonomy;
        $this->hideEmpty = ! empty($config['hide_empty']);

        if (in_array($this->getType(), array('radio', 'select'))) {
            $this->single = true;
        }

        $this->slug = taxonomy_is_product_attribute($this->getId()) ? substr($this->getId(), 3) : $this->getId();

        add_filter('woocommerce_product_query_tax_query', array($this, 'extendTaxQuery'));
    }

    /**
     * Unique item identifier
     *
     * @return string
     */
    public function getId()
    {
        return $this->taxonomy->name;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        if (taxonomy_is_product_attribute($this->taxonomy->name)) {
            return wc_attribute_label($this->taxonomy->name);
        }

        return $this->taxonomy->labels->singular_name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * checkbox|radio|select|label|color
     * @return string
     */
    public function getType()
    {
        return isset($this->config['type']) ? $this->config['type'] : '';
    }

    /**
     * Default|Dropdown|Scroll|Dropdown+Scroll
     * @return string
     */
    public function getDisplay()
    {
        return isset($this->config['display_type']) ? $this->config['display_type'] : '';
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        $filters = $this->getItems();

        return ! empty($filters);
    }

    /**
     * @return array
     */
    public function getItems()
    {
        $filters = array();

        foreach ($this->getTerms() as $termKey => $term) {
            if (! $this->hideEmpty || $term->count || $term->checked) {
                if ($term->term_id !== get_queried_object_id()) {
                    $filters[] = $term;
                }
            }
        }

        return $filters;
    }

    /**
     * @return array
     */
    public function getTerms()
    {
        return $this->terms ?: array();
    }

    /**
     * @param $term
     *
     * @return mixed
     */
    protected function processTerm($term)
    {
        if ($this->getType() === 'color') {
            $term->color = null;
            if (isset($this->config['colors'][$term->term_id])) {
                $term->color = $this->config['colors'][$term->term_id];
            }
        }

        return $term;
    }

    /**
     * Active items for Active filters Widget
     * @return array
     */
    public function getActiveItems()
    {
        $active = array();

        if ($this->isActive()) {
            foreach ($this->getTerms() as $term) {
                if ($term->checked) {
                    $active[] = array(
                        'title' => $term->name,
                        'link'  => $term->link,
                    );
                }
            };
        }

        return $active;
    }

    /**
     * @return array
     */
    public function getActiveProducts()
    {
        $products = array();
        foreach ($this->terms as $term) {
            if ($term->checked) {
                $products += $term->products;
            }
        }

        return $products;
    }

    /**
     * @param array $taxQuery
     *
     * @return mixed
     */
    public function extendTaxQuery($taxQuery)
    {
        $values = $this->getSelectedValues();

        if (! empty($values)) {
            $taxonomyQuery = array(
                "taxonomy"         => $this->getId(),
                "field"            => 'slug',
                "terms"            => $values,
                "operator"         => 'IN',
                "include_children" => false,
            );

            array_push($taxQuery, $taxonomyQuery);
        }

        return $taxQuery;
    }

    /**
     * @return void
     */
    public function init()
    {
        if (is_null($this->terms)) {
            $terms = $this->loadTerms();

            $activeTerms = $this->getSelectedValues();

            foreach ($terms as $key => $term) {
                $term->checked  = in_array($term->slug, $activeTerms);
                $term->link     = $this->getValueLink($term->slug);
                $term->products = array();
                $this->processTerm($term);
            }

            $this->terms = $terms;
        }
    }

    /**
     * @return array
     */
    protected function loadTerms()
    {
        $settings = $this->getSettings();

        $termIds = array_keys($settings);

        $terms = array();

        if (count($termIds)) {
            $query['taxonomy'] = $this->taxonomy->name;
            $query['orderby']  = 'include';
            $query['include']  = $termIds;

            $terms = get_terms($query);
        }

        return is_array($terms) ? $terms : array();
    }

    /**
     * @return array
     */
    protected function getSettings()
    {
        return array_filter(
            get_option('premmerce_filter_tax_' . $this->taxonomy->name . '_options', array()),
            function ($item) {
                return isset($item['active']) && $item['active'];
            }
        );
    }
}
