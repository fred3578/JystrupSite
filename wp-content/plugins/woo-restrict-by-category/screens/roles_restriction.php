<?php

$orderby = 'name';
$order = 'asc';
$hide_empty = false ;
$cat_args = array(
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
);

$product_categories = get_terms( 'product_cat', $cat_args );
if(is_wp_error($product_categories))
    $product_categories=array();
$category=array();
foreach($product_categories as $product)
{
    $category[]=array('slug'=>$product->slug,
                        'name'=>$product->name);
}

$roles=array();
wp_enqueue_script('jquery');
wp_enqueue_script('wcrbc-role-bundle',WC_RESTRICT_BY_CATEGORY_URL.'js/bundle/rolerestriction_bundle.js',array('jquery'));

wp_enqueue_style('wcrbc-bootstrap',WC_RESTRICT_BY_CATEGORY_URL.'css/bootstrap/css/bootstrap.min.css');
wp_enqueue_style('wcrbc-bootstrap-theme',WC_RESTRICT_BY_CATEGORY_URL.'css/bootstrap/css/bootstrap-theme.min.css');
wp_localize_script('wcrbc-role-bundle','rednaoWcrbcParams',array(
    'categories'=>$category,
    'roles'=>$roles,
    'title'=>'WooCommerce Role Privileges',
    'search_action'=>'rednao_wcrbc_search_roles',
    'save_action'=>'rednao_wcrbc_save_roles',
    'loading_message'=>'Loading Roles',
    'version'=>WC_RESTRICT_BY_CATEGORY_VERSION
));
echo '<div id="wcrbc-main"></div>';