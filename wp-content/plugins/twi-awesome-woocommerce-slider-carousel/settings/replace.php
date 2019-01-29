<?php
$twi_woo_overide_off_on = vp_option("twi_woo_options.twi_woo_overide_off_on");
if($twi_woo_overide_off_on == 1){
    add_action( 'template_redirect', 'twi_woo_temp_overide',1 );
    add_filter( 'term_link', 'twi_term_to_type', 12, 3 );
    add_filter( 'the_title','twi_woo_title_overide' ,12,2);
}


function twi_woo_temp_overide()
{
    global $wp_query,$woocommerce,$wp,$_chosen_attributes;


    $twi_woo_posttype = $wp_query->query_vars['post_type'];
    $twi_woo_taxonomy =!empty($wp_query->query_vars['taxonomy'])?$wp_query->query_vars['taxonomy']:'';
    //PRODUCT CATEGORY
    $twi_woo_redirect_to = '';
    if ($twi_woo_taxonomy === 'product_cat') {
        $cat_page = vp_option("twi_woo_options.twi_woo_cat_re_page");
        $twi_woo_cat_overide_off_on = vp_option("twi_woo_options.twi_woo_cat_overide_off_on");
        if($twi_woo_cat_overide_off_on == 1){
            $query_args=array_merge( $wp_query->query, array( 'twi_filter' => 1 ) );
            $twi_woo_redirect_to = add_query_arg( $query_args, get_permalink($cat_page) );
        }
    }elseif($twi_woo_posttype === 'product' && is_search()){
        $search_page = vp_option("twi_woo_options.twi_woo_search_re_page");
        $twi_woo_search_overide_off_on = vp_option("twi_woo_options.twi_woo_search_overide_off_on");
        if($twi_woo_search_overide_off_on == 1){
            $query_args=array( 'twi_filter' => 1,'twi_woo_search' => $_GET['s']);
            $twi_woo_redirect_to = add_query_arg( $query_args, get_permalink($search_page) );
        }
    }elseif ( $twi_woo_posttype === 'product' && is_post_type_archive('product') && !is_single() ) {
        //SHOP
        $shop_page = vp_option("twi_woo_options.twi_woo_shop_re_page");
        $twi_woo_shop_overide_off_on = vp_option("twi_woo_options.twi_woo_shop_overide_off_on");
        if($twi_woo_shop_overide_off_on == 1){
            $query_args=array( 'twi_filter' => 1 );
            $twi_woo_redirect_to = add_query_arg( $query_args ,get_permalink($shop_page));
        }
    }elseif ( $twi_woo_taxonomy === 'product_tag' ) {
        // PRODUCT TAG
        $tag_page = vp_option("twi_woo_options.twi_woo_tag_re_page");
        $twi_woo_tag_overide_off_on = vp_option("twi_woo_options.twi_woo_tag_overide_off_on");
        if($twi_woo_tag_overide_off_on == 1){
            $query_args=array_merge( $wp_query->query, array( 'twi_filter' => 1 ) );
            $twi_woo_redirect_to = add_query_arg( $query_args, get_permalink($tag_page) );
        }
    }elseif ( $twi_woo_posttype === 'product' && is_single() && !is_post_type_archive('product')) {
        //Shop and Product Detail
    }
    if($twi_woo_redirect_to){
        wp_redirect($twi_woo_redirect_to);
    }
    
}

function twi_term_to_type( $link, $term, $taxonomy ) {
    if ( $term->taxonomy=== 'product_cat' ) {
            $cat_page = vp_option("twi_woo_options.twi_woo_cat_re_page");
            $twi_woo_cat_overide_off_on = vp_option("twi_woo_options.twi_woo_cat_overide_off_on");
            if($twi_woo_cat_overide_off_on == 1){
                $twi_woo_redirect_to = add_query_arg( array('product_cat'=>$term->slug,'twi_filter'=>1), get_permalink($cat_page) );
                if ( !empty( $twi_woo_redirect_to ) ) return $twi_woo_redirect_to;
            }
    }
    if ( $term->taxonomy=== 'product_tag' ) {
            $tag_page = vp_option("twi_woo_options.twi_woo_tag_re_page");
            $twi_woo_tag_overide_off_on = vp_option("twi_woo_options.twi_woo_tag_overide_off_on");
            if($twi_woo_tag_overide_off_on == 1){
                $twi_woo_redirect_to = add_query_arg( array('product_tag'=>$term->slug,'twi_filter'=>1), get_permalink($tag_page) );
                if ( !empty( $twi_woo_redirect_to ) ) return $twi_woo_redirect_to;
            }
    }
    return $link;
}

function twi_woo_title_overide($title='', $id='' ){
    $admin=is_admin();
    if( ($id != vp_option("twi_woo_options.twi_woo_shop_re_page")||
        $id != vp_option("twi_woo_options.twi_woo_cat_re_page")||
        $id != vp_option("twi_woo_options.twi_woo_search_re_page")||
        $id != vp_option("twi_woo_options.twi_woo_tag_re_page"))||
        $admin
        ){ return $title;}
    if($id == vp_option("twi_woo_options.twi_woo_shop_re_page")){
        return $title;
    }elseif($id == $cat_id = vp_option("twi_woo_options.twi_woo_cat_re_page") ){
        $product_slug_cat = get_query_var('product_cat');
        $category_name = get_term_by('slug', $product_slug_cat, 'product_cat');
        return $category_name->name;
    }elseif($id == $tag_id = vp_option("twi_woo_options.twi_woo_tag_re_page") ){
        $product_slug_tag = get_query_var('product_tag');
        $tag_name = get_term_by('slug', $product_slug_tag, 'product_tag');
        return $tag_name->name;
    }elseif($id == vp_option("twi_woo_options.twi_woo_search_re_page") ){
        return $title.' - '.$_GET['twi_woo_search'];
    }
}
?>