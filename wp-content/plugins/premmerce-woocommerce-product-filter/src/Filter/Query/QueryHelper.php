<?php namespace Premmerce\Filter\Filter\Query;

use WC_Query;
use WP_Meta_Query;
use WP_Tax_Query;

class QueryHelper
{
    /**
     * @var string
     */
    protected $searchQuery;

    /**
     * @param string $searchQuery
     */
    public function setSearchQuery($searchQuery)
    {
        $this->searchQuery = $searchQuery;
    }

    /**
     * @return string
     */
    public function getSearchQuery()
    {
        return $this->searchQuery;
    }

    /**
     * Main query to term relations table
     *
     * @param array $exceptTaxonomies
     *
     * @return array
     */
    public function getTaxQuerySql($exceptTaxonomies = array())
    {
        global $wpdb;

        $taxQuery = WC_Query::get_main_tax_query();

        if (! empty($exceptTaxonomies)) {
            foreach ($taxQuery as $key => $query) {
                if (is_array($query) && in_array($query['taxonomy'], $exceptTaxonomies)) {
                    unset($taxQuery[$key]);
                }
            }
        }

        $taxQuery = new WP_Tax_Query($taxQuery);

        $taxQuerySql = $taxQuery->get_sql($wpdb->posts, 'ID');

        return $taxQuerySql;
    }

    /**
     * Main query to post meta table
     *
     * @param null $remove
     *
     * @return array|false
     */
    public function getMetaQuerySql($remove = null)
    {
        global $wpdb;

        $meta_query = WC_Query::get_main_meta_query();

        if (is_array($remove)) {
            foreach ($remove as $key) {
                if (isset($meta_query[$key])) {
                    unset($meta_query[$key]);
                }
            }
        }

        $meta_query     = new WP_Meta_Query($meta_query);
        $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');

        return $meta_query_sql;
    }

    /**
     * @return string
     */
    public function getPostWhereQuery()
    {
        global $wpdb;

        $postType = $this->arraySql(apply_filters('woocommerce_price_filter_post_type', array('product')));

        $sql[] = "WHERE {$wpdb->posts}.post_type IN {$postType}";
        $sql[] = "AND {$wpdb->posts}.post_status = 'publish'";

        return implode(' ', $sql);
    }

    /**
     * @param array $values
     *
     * @return string
     */
    public function arraySql($values)
    {
        return "('" . implode("','", array_map('esc_sql', $values)) . "')";
    }

    /**
     * Get queried object id and children ids
     * @return array
     */
    public function getQueriedObjectIds()
    {
        $term    = get_queried_object();
        $termIds = array();
        if ($term instanceof \WP_Term) {
            $termIds = array($term->term_taxonomy_id);

            if (is_taxonomy_hierarchical($term->taxonomy)) {
                $children = get_term_children($term->term_id, $term->taxonomy);

                if (is_array($children)) {
                    foreach ($children as $child) {
                        $term      = get_term($child);
                        $termIds[] = $term->term_taxonomy_id;
                    }
                }
            }
        }

        return $termIds;
    }
}
