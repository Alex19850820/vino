<?php
/**
 * Array of plugin options
 */

$options = array();


$options['common'][] = array(
    "id"    => "search_instance",
    "value" => "Search Form"
);

$options['common'][] = array(
    "id"    => "filter_num",
    "value" => "1"
);


$options['form'][] = array(
    "name"  => __( "Text for search field", "aws" ),
    "desc"  => __( "Text for search field placeholder.", "aws" ),
    "id"    => "search_field_text",
    "value" => __( "Search", "aws" ),
    "type"  => "text"
);

$options['form'][] = array(
    "name"  => __( "Nothing found field", "aws" ),
    "desc"  => __( "Text when there is no search results. HTML tags is allowed.", "aws" ),
    "id"    => "not_found_text",
    "value" => __( "Nothing found", "aws" ),
    "type"  => "textarea"
);

$options['form'][] = array(
    "name"  => __( "Minimum number of characters", "aws" ),
    "desc"  => __( "Minimum number of characters required to run ajax search.", "aws" ),
    "id"    => "min_chars",
    "value" => 1,
    "type"  => "number"
);

$options['form'][] = array(
    "name"  => __( "Show loader", "aws" ),
    "desc"  => __( "Show loader animation while searching.", "aws" ),
    "id"    => "show_loader",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['form'][] = array(
    "name"  => __( "Show 'View All Results'", "aws" ),
    "desc"  => __( "Show link to search results page at the bottom of search results block.", "aws" ),
    "id"    => "show_more",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['form'][] = array(
    "name"  => __( "Search Results", "aws" ),
    "desc"  => __( "Choose how to view search results.", "aws" ),
    "id"    => "show_page",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'     => __( 'Both ajax search results and search results page', 'aws' ),
        'false'    => __( 'Only ajax search results ( no search results page )', 'aws' ),
        'ajax_off' => __( 'Only search results page ( no ajax search results )', 'aws' )
    )
);

$options['form'][] = array(
    "name"  => __( "Show title in input", "aws" ),
    "desc"  => __( "Show title of hovered search result in the search input field.", "aws" ),
    "id"    => "show_addon",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['form'][] = array(
    "name"  => __( "Form Styling", "aws" ),
    "desc"  => __( "Choose search form layout", "aws" ) . '<br>' . __( "Filter button will be visible only if you have more than one active filter for current search form instance.", "aws" ),
    "id"    => "buttons_order",
    "value" => '1',
    "type"  => "radio-image",
    'choices' => array(
        '1' => 'btn-layout1.png',
        '2' => 'btn-layout2.png',
        '3' => 'btn-layout3.png',
        '4' => 'btn-layout4.png',
        '5' => 'btn-layout5.png',
        '6' => 'btn-layout6.png',
    )
);


$options['results'][] = array(
    "name"  => __( "Filter name", "aws" ),
    "desc"  => __( "Name for current filter.", "aws" ),
    "id"    => "filter_name",
    "value" => "All",
    "type"  => "text"
);

$options['results'][] = array(
    "name"  => __( "Style", "aws" ),
    "desc"  => __( "Set style for search results output.", "aws" ),
    "id"    => "style",
    "value" => 'style-inline',
    "type"  => "radio",
    'choices' => array(
        'style-inline'   => __( "Inline Style", "aws" ),
        'style-grid'     => __( "Grid Style", "aws" ),
        'style-big-grid' => __( "Big Grid Style", "aws" ),
    )
);

$options['results'][] = array(
    "name"  => __( "Description content", "aws" ),
    "desc"  => __( "What to show in product description?", "aws" ),
    "id"    => "mark_words",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( "Smart scrapping sentences with searching terms from product description.", "aws" ),
        'false' => __( "First N words of product description ( number of words that you choose below. )", "aws" ),
    )
);

$options['results'][] = array(
    "name"  => __( "Description length", "aws" ),
    "desc"  => __( "Maximal allowed number of words for product description.", "aws" ),
    "id"    => "excerpt_length",
    "value" => 20,
    "type"  => "number"
);

$options['results'][] = array(
    "name"  => __( "Max number of results", "aws" ),
    "desc"  => __( "Maximum number of displayed search results.", "aws" ),
    "id"    => "results_num",
    "value" => 10,
    "type"  => "number"
);

$options['results'][] = array(
    "name"  => __( "Products stock status", "aws" ),
    "desc"  => __( "Search only for products with selected stock status", "aws" ),
    "id"    => "outofstock",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'Show in-stock and out-of-stock', 'aws' ),
        'false' => __( 'Show only in-stock', 'aws' ),
        'out'   => __( 'Show only out-of-stock', 'aws' ),
    )
);

$options['results'][] = array(
    "name"  => __( "Products visibility", "aws" ),
    "desc"  => __( "Search only products with this visibilities.", "aws" ),
    "id"    => "product_visibility",
    "value" => array(
        'visible'  => 1,
        'catalog'  => 1,
        'search'   => 1,
        'hidden'   => 0,
    ),
    "type"  => "checkbox",
    'choices' => array(
        'visible'  => __( 'Catalog/search', 'aws' ),
        'catalog'  => __( 'Catalog', 'aws' ),
        'search'   => __( 'Search', 'aws' ),
        'hidden'   => __( 'Hidden', 'aws' ),
    )
);

$options['results'][] = array(
    "name"    => __( "Search Sources", "aws" ),
    "type"    => "heading"
);

//$options['results'][] = array(
//    "name"  => __( "Search in", "aws" ),
//    "desc"  => __( "Search source: Drag&drop sources order to change priority, or exclude by moving to deactivated sources.", "aws" ),
//    "id"    => "search_in",
//    "value" => "title,content,sku,excerpt",
//    "choices" => array(
//        "title"    => __( "Title", "aws" ),
//        "content"  => __( "Content", "aws" ),
//        "sku"      => __( "SKU", "aws" ),
//        "excerpt"  => __( "Excerpt", "aws" ),
//        "category" => __( "Category", "aws" ),
//        "tag"      => __( "Tag", "aws" )
//    ),
//    "type"  => "sortable"
//);

$options['results'][] = array(
    "name"    => __( "Search in", "aws" ),
    "desc"    => __( "Click on status icon to enable or disable search source.", "aws" ),
    "id"      => "search_in",
    "value" => array(
        'title'    => 1,
        'content'  => 1,
        'sku'      => 1,
        'excerpt'  => 1,
        'category' => 0,
        'tag'      => 0,
        'attr'     => 0,
        'tax'      => 0,
        'meta'     => 0,
    ),
    "choices" => array(
        "title"    => __( "Title", "aws" ),
        "content"  => __( "Content", "aws" ),
        "sku"      => __( "SKU", "aws" ),
        "excerpt"  => __( "Excerpt", "aws" ),
        "category" => __( "Category", "aws" ),
        "tag"      => __( "Tag", "aws" ),
        "attr"     => __( "Attributes", "aws" ),
        "tax"      => __( "Taxonomies", "aws" ),
        "meta"     => __( "Custom Fields", "aws" )
    ),
    "type"    => "table"
);

$options['results'][] = array(
    "name"    => __( "Attributes search", "aws" ),
    "desc"    => __( "Choose product attributes that must be searchable.", "aws" ),
    "id"      => "search_in_attr",
    "section" => "attr",
    "value"   => AWS_Helpers::get_attributes( true ),
    "choices" => AWS_Helpers::get_attributes(),
    "type"    => "table"
);

$options['results'][] = array(
    "name"    => __( "Taxonomies search", "aws" ),
    "desc"    => __( "Choose product taxonomies that must be searchable.", "aws" ),
    "id"      => "search_in_tax",
    "section" => "tax",
    "value"   => AWS_Helpers::get_taxonomies( true ),
    "choices" => AWS_Helpers::get_taxonomies(),
    "type"    => "table"
);

$options['results'][] = array(
    "name"    => __( "Custom fields search", "aws" ),
    "desc"    => __( "Choose product custom fields that must be searchable.", "aws" ),
    "id"      => "search_in_meta",
    "section" => "meta",
    "value"   => AWS_Helpers::get_custom_fields( true ),
    "choices" => AWS_Helpers::get_custom_fields(),
    "type"    => "table"
);

$options['results'][] = array(
    "name"    => __( "View", "aws" ),
    "type"    => "heading"
);

$options['results'][] = array(
    "name"  => __( "Show image", "aws" ),
    "desc"  => __( "Show product image for each search result.", "aws" ),
    "id"    => "show_image",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show description", "aws" ),
    "desc"  => __( "Show product description for each search result.", "aws" ),
    "id"    => "show_excerpt",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show categories for results", "aws" ),
    "desc"  => __( "Include categories in products search results.", "aws" ),
    "id"    => "show_result_cats",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show brands in products", "aws" ),
    "desc"  => __( "Show brands with all products in search results.", "aws" ),
    "id"    => "show_result_brands",
    "value" => 'false',
    "type"  => "radio",
    "depends" => AWS_Helpers::is_plugin_active( 'woocommerce-brands/woocommerce-brands.php' ),
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show brands archive", "aws" ),
    "desc"  => __( "Show brands archives in search results.", "aws" ),
    "id"    => "show_brands_archive",
    "value" => 'false',
    "type"  => "radio",
    "depends" => AWS_Helpers::is_plugin_active( 'woocommerce-brands/woocommerce-brands.php' ),
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show rating", "aws" ),
    "desc"  => __( "Show product rating.", "aws" ),
    "id"    => "show_rating",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show featured", "aws" ),
    "desc"  => __( "Show featured badge near product title.", "aws" ),
    "id"    => "show_featured",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show variations", "aws" ),
    "desc"  => __( "Show product variations.", "aws" ),
    "id"    => "show_variations",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show price", "aws" ),
    "desc"  => __( "Show product price for each search result.", "aws" ),
    "id"    => "show_price",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show categories", "aws" ),
    "desc"  => __( "Include categories in search result.", "aws" ),
    "id"    => "show_cats",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show tags", "aws" ),
    "desc"  => __( "Include tags in search result.", "aws" ),
    "id"    => "show_tags",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show sale badge", "aws" ),
    "desc"  => __( "Show sale badge for products in search results.", "aws" ),
    "id"    => "show_sale",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show product SKU", "aws" ),
    "desc"  => __( "Show product SKU in search results.", "aws" ),
    "id"    => "show_sku",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['results'][] = array(
    "name"  => __( "Show stock status", "aws" ),
    "desc"  => __( "Show stock status for every product in search results.", "aws" ),
    "id"    => "show_stock",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'      => __( 'Show', 'aws' ),
        'quantity'  => __( 'Show with product quantity', 'aws' ),
        'false'     => __( 'Hide', 'aws' )
    )
);

$options['results'][] = array(
    "name"    => __( "Exclude/include", "aws" ),
    "type"    => "heading"
);

$options['results'][] = array(
    "name"  => __( "Filter relation", "aws" ),
    "desc"  => __( "Choose how filter must works.", "aws" ),
    "id"    => "exclude_rel",
    "value" => 'exclude',
    "type"  => "radio",
    'choices' => array(
        'exclude'  => __( 'Exclude', 'aws' ),
        'include'  => __( 'Include', 'aws' ),
    )
);

$options['results'][] = array(
    "name"    => __( "Categories filter", "aws" ),
    "desc"    => sprintf( __( "Comma separated list of products categories %s that will be filtered.", "aws" ), '<strong>IDs</strong>' ),
    "id"      => "exclude_cats",
    "value"   => '',
    "type"    => "textarea"
);

$options['results'][] = array(
    "name"    => __( "Tags filter", "aws" ),
    "desc"    => sprintf( __( "Comma separated list of products tags %s that will be filtered.", "aws" ), '<strong>IDs</strong>' ),
    "id"      => "exclude_tags",
    "value"   => '',
    "type"    => "textarea"
);

$options['results'][] = array(
    "name"    => __( "Products filter", "aws" ),
    "desc"    => sprintf( __( "Comma separated list of products %s that will be filtered.", "aws" ), '<strong>IDs</strong>' ),
    "id"      => "exclude_products",
    "value"   => '',
    "type"    => "textarea"
);

$options['general'][] = array(
    "name"  => __( "Cache results", "aws" ),
    "desc"  => __( "Turn off if you have old data in the search results after content of products was changed.<br><strong>CAUTION:</strong> can dramatically increase search speed", "aws" ),
    "id"    => "cache",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false'  => __( 'Off', 'aws' )
    )
);

$options['general'][] = array(
    "name"  => __( "Search logic", "aws" ),
    "desc"  => __( "Search rules.", "aws" ),
    "id"    => "search_logic",
    "value" => 'or',
    "type"  => "radio",
    'choices' => array(
        'or'  => __( 'OR. Show result if at least one word exists in product.', 'aws' ),
        'and'  => __( 'AND. Show result if only all words exists in product.', 'aws' ),
        //'exact'  => __( 'EXACT MATCH', 'Show result if product contains exact same phrase.' )
    )
);

$options['general'][] = array(
    "name"  => __( "Description source", "aws" ),
    "desc"  => __( "From where to take product description.<br>If first source is empty data will be taken from other sources.", "aws" ),
    "id"    => "desc_source",
    "value" => 'content',
    "type"  => "radio",
    'choices' => array(
        'content'  => __( 'Content', 'aws' ),
        'excerpt'  => __( 'Excerpt', 'aws' ),
    )
);

$options['general'][] = array(
    "name"  => __( "Open product in new tab", "aws" ),
    "desc"  => __( "When user clicks on one of the search result new window will be opened.", "aws" ),
    "id"    => "target_blank",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false' => __( 'Off', 'aws' )
    )
);

$options['general'][] = array(
    "name"  => __( "Image source", "aws" ),
    "desc"  => __( "Source of image that will be shown with search results. Position of fields show the priority of each source.", "aws" ),
    "id"    => "image_source",
    "value" => "featured,gallery,content,description,default",
    "choices" => array(
        "featured"    => __( "Featured image", "aws" ),
        "gallery"     => __( "Gallery first image", "aws" ),
        "content"     => __( "Content first image", "aws" ),
        "description" => __( "Description first image", "aws" ),
        "default"     => __( "Default image", "aws" )
    ),
    "type"  => "sortable"
);

$options['general'][] = array(
    "name"  => __( "Default image", "aws" ),
    "desc"  => __( "Default image for search results.", "aws" ),
    "id"    => "default_img",
    "value" => "",
    "type"  => "image",
    'size'  => "thumbnail"
);

$options['general'][] = array(
    "name"  => __( "Use Google Analytics", "aws" ),
    "desc"  => __( "Use google analytics to track searches. You need google analytics to be installed on your site.", "aws" ) . '<br>' . __( "Will send event with category - 'AWS search', action - 'AWS Search Form {form_id}' and label of value of search term.", "aws" ),
    "id"    => "use_analytics",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'aws' ),
        'false'  => __( 'Off', 'aws' ),
    )
);