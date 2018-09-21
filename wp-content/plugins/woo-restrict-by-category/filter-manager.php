<?php

add_action( 'pre_get_posts', 'rednao_wcrbc_additional_woo_query' );
function rednao_wcrbc_additional_woo_query( $args ) {
    if(is_admin())
        return;

    $query=$args->query;
    if((!isset($query['post_type'])||$query['post_type']!='product')&&!isset($query['product_cat']))
        return;
    if($query['post_type']=='product'&&$args->is_singular&&isset($query['product']))
    {
        $productId=$query['product'];
        $post=get_posts(array(
            'name' => $productId,
            'posts_per_page' => 1,
            'post_type' => 'product',
            'post_status' => 'publish'
        ));
        if(count($post)==0)
            return;
        $postPrivileges=get_the_terms($post[0]->ID, 'product_cat');
        $userPrivileges=rednao_wcrbc_get_user_privileges();

        foreach($postPrivileges as $postPrivilege)
        {
            if(in_array($postPrivilege->slug,$userPrivileges))
                return;
        }
        $pageId=get_option('REDNAO_WCRBC_RESTRICTED_PRODUCT_PAGE_ID');
        if($pageId==false||get_post_status($pageId)!='publish')
                $pageId=rednao_wcrbc_create_page();
        $args->set( 'page_id', $pageId );
        return;
    }

    if (  is_shop() || is_product_category() || is_product_tag() || is_product()||true) {
        $userPrivileges=rednao_wcrbc_get_user_privileges();

        $query=$args->get('tax_query');
        if($query=='')
            $query=array();
        else
            $query["relation"]='AND';
        array_push($query,array(
            'taxonomy'=>'product_cat',
            'field' => 'slug',
            'operator'=>'IN',
            'terms'=>$userPrivileges
        ));

        $args->set('tax_query',$query);
    }
}


add_filter('woocommerce_shortcode_products_query', 'rednao_wcrbc_fix_shortcode_query');
add_filter('woocommerce_shortcode_product_cat_query', 'rednao_wcrbc_fix_shortcode_query');
add_filter('woocommerce_shortcode_recent_products_query', 'rednao_wcrbc_fix_shortcode_query');
add_filter('woocommerce_shortcode_sale_products_query', 'rednao_wcrbc_fix_shortcode_query');
add_filter('woocommerce_shortcode_best_selling_products_query', 'rednao_wcrbc_fix_shortcode_query');
add_filter('woocommerce_shortcode_top_rated_products_query', 'rednao_wcrbc_fix_shortcode_query');
add_filter('woocommerce_shortcode_featured_products_query', 'rednao_wcrbc_fix_shortcode_query');
add_filter('woocommerce_shortcode_product_attribute_query', 'rednao_wcrbc_fix_shortcode_query');

function rednao_wcrbc_fix_shortcode_query( $args ) {
    $userPrivileges=rednao_wcrbc_get_user_privileges();
    $query=&$args["tax_query"];
    $query["relation"]='AND';
    array_push($query,array(
        'taxonomy'=>'product_cat',
        'field' => 'slug',
        'operator'=>'IN',
        'terms'=>$userPrivileges
    ));
    $products = new WP_Query( $args );
    return $args;
    //access values with $args[0], $args[1] etc.
}

function rednao_wcrbc_get_user_privileges(){

    $userid=get_current_user_id();
    $result=array();
    if($userid==0)
    {
        global $wpdb;
        $results= $wpdb->get_results("SELECT privilege_slug FROM ".WC_RESTRICT_BY_CATEGORY_TABLE." WHERE type='none'","ARRAY_A");
    }else{
        $userData=get_userdata($userid);
        $userId=$userData->get('user_nicename');
        $roles=$userData->roles;
        $roles = array_map(function($v) {
            return "'" . esc_sql($v) . "'";
        }, $roles);
        $roles = implode(',', $roles);
        global $wpdb;
        $results= $wpdb->get_results($wpdb->prepare("SELECT privilege_slug FROM ".WC_RESTRICT_BY_CATEGORY_TABLE." WHERE (type='role' and target_slug IN (" . $roles . ")) or (type='user' and target_slug =%s)",$userId),"ARRAY_A");
    }

    $privileges=array();
    foreach($results as $result)
        $privileges[]=$result['privilege_slug'];
    return $privileges;

}

add_action('woocommerce_no_products_found','rednao_wcrbc_no_product_found');
function rednao_wcrbc_no_product_found(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('wcrbc-role-bundle',WC_RESTRICT_BY_CATEGORY_URL.'js/bundle/rolerestriction_bundle.js',array('jquery'));
}


add_filter('woocommerce_is_purchasable','rednao_wcrbc_is_purchasablle');
function rednao_wcrbc_is_purchasablle($args)
{
    /*$args=false;
    echo "<div style='color:red;'>Sorry you don't have access to purchase this product</div>";
    return $args;*/

}