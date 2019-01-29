<?php namespace Premmerce\Filter\Filter\Items\Types;

class SliderFilter extends TaxonomyFilter
{
    /**
     * @return bool
     */
    public function isVisible()
    {
        $options = $this->getOptions();

        return $this->isActive() || $options['min'] !== $options['max'];
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        $terms = $this->getTerms();

        if (count($terms)) {
            $terms = array_filter($terms, function ($term) {
                return $term->count;
            });

            $values = array_map(function ($term) {
                return intval($term->slug);
            }, $terms);


            $min = $max = 0;

            if (! empty($values)) {
                $min = min($values);
                $max = max($values);
            }

            $values = array(
                'min'          => $min,
                'max'          => $max,
                'min_selected' => $min,
                'max_selected' => $max,
            );

            $selected = $this->getSelectedValues();

            $values = array_merge($values, $selected);

            return $values;
        }
    }

    public function getActiveItems()
    {
        $url = $_SERVER['REQUEST_URI'];

        $values = $this->getSelectedValues();

        $activeFilters = array();

        if (key_exists('min_selected', $values)) {
            $link            = remove_query_arg('min_' . $this->getSlug(), $url);
            $title           = sprintf(
                __('%s from %s', 'premmerce-filter'),
                $this->getLabel(),
                $values['min_selected']
            );
            $activeFilters[] = array('title' => $title, 'link' => esc_url($link));
        }

        if (key_exists('max_selected', $values)) {
            $link            = remove_query_arg('max_' . $this->getSlug(), $url);
            $title           = sprintf(__('%s to %s', 'premmerce-filter'), $this->getLabel(), $values['max_selected']);
            $activeFilters[] = array('title' => $title, 'link' => esc_url($link),);
        }

        return $activeFilters;
    }

    public function getTermsInInterval($terms)
    {
        $values = $this->getSelectedValues();


        if (isset($values['min_selected']) || isset($values['max_selected'])) {
            $terms = array_map(function ($term) {
                return $term->slug;
            }, $terms);

            $terms = array_filter($terms, function ($item) use ($values) {
                $result = true;
                $item   = intval($item);

                if (isset($values['min_selected'])) {
                    $result = $item >= $values['min_selected'];
                }
                if (isset($values['max_selected'])) {
                    $result = $result && $item <= $values['max_selected'];
                }

                return $result;
            });

            return $terms;
        }

        return array();
    }

    protected function getSelectedValues()
    {
        $values = array();

        $minKey = 'min_' . $this->getSlug();
        $maxKey = 'max_' . $this->getSlug();

        if (key_exists($minKey, $_GET)) {
            $values['min_selected'] = intval($_GET[$minKey]);
        }

        if (key_exists($maxKey, $_GET)) {
            $values['max_selected'] = intval($_GET[$maxKey]);
        }

        return $values;
    }

    public function extendTaxQuery($taxQuery)
    {
        if ($this->isActive()) {
            //This filter type should be initialized here, because active values are selected from db
            $this->init();

            $terms = $this->getTerms();

            $slugs = array();
            foreach ($terms as $term) {
                if ($term->checked) {
                    $slugs[] = $term->slug;
                }
            }

            if (empty($slugs)) {
                $slugs = $this->getSelectedValues();
                $slugs = array_values($slugs);
            }

            $taxonomyQuery = array(
                "taxonomy"         => $this->getId(),
                "field"            => 'slug',
                "terms"            => $slugs,
                "operator"         => 'IN',
                "include_children" => false,
            );

            array_push($taxQuery, $taxonomyQuery);
        }

        return $taxQuery;
    }

    public function init()
    {
        if (is_null($this->terms)) {
            $terms = get_terms(array('taxonomy' => $this->taxonomy->name));

            $activeTerms = $this->getTermsInInterval($terms);

            foreach ($terms as $term) {
                $term->checked = false;
                if (in_array($term->slug, $activeTerms)) {
                    $term->checked = true;
                }
                $term->link     = $this->getValueLink($term->slug);
                $term->products = array();
            }
            $this->terms = $terms;
        }
    }
}
