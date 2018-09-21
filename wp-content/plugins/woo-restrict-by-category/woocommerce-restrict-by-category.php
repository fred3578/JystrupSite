<?php
/*
Plugin Name: WooCommerce Restrict By Category
Description: Restrict the categories that the customers can view
Author: EdgarRojas
Author URI: http://rednao.com
Version: 1.1
*/
require_once ('woocommerce-restrict-by-category-config.php');
require_once ('ajax.php');
require_once ('filter-manager.php');
add_action('admin_menu','rednao_wc_restrict_by_category_create_menu');
add_action('init', 'rednao_wcrbc_init');

function rednao_wc_restrict_by_category_create_menu(){
    add_menu_page('WC Restrict By Category','WC Restrict By Category','manage_options',"wc_restrict_category_menu",'wc_restrict_category_roles_restriction',plugin_dir_url(__FILE__).'images/smartFormsIcon.png');
    //add_submenu_page("wc_restrict_category_menu",'Restrict By User','Restrict By User','manage_options',__FILE__.'entries', 'wc_restrict_category_by_user');
}

function wc_restrict_category_roles_restriction(){
    require_once(WC_RESTRICT_BY_CATEGORY_DIR.'screens/roles_restriction.php');
}

function wc_restrict_category_by_user(){
    require_once(WC_RESTRICT_BY_CATEGORY_DIR.'screens/user_restriction.php');
}

add_action('admin_init','rednao_wcrbc_was_activated');
register_activation_hook(__FILE__,'rednao_wcrbc_was_activated');


function rednao_wcrbc_init()
{
    if(get_option('REDNAO_WCRBC_RESTRICTED_PRODUCT_PAGE_ID')==false)
    {
        rednao_wcrbc_create_page();

    }
}

function rednao_wcrbc_create_page(){
    $post = array(
        'post_content'   => 'Sorry you have no access to view this product',
        'post_name'      => 'Product Access Denied',
        'post_title'     => 'Product Access Denied',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'ping_status'    => 'closed',
        'comment_status' => 'closed'
    );
    $page_id= wp_insert_post( $post );
    update_option('REDNAO_WCRBC_RESTRICTED_PRODUCT_PAGE_ID',$page_id);
    return $page_id;
}
function rednao_wcrbc_was_activated()
{
    $dbversion=get_option("WC_RESTRICT_BY_CATEGORY_DB_VERSION");
    if($dbversion<WC_RESTRICT_BY_CATEGORY_DB_VERSION )
    {
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');

        $sql="CREATE TABLE ".WC_RESTRICT_BY_CATEGORY_TABLE." (
            privilege_id int AUTO_INCREMENT,
            type char(4) NOT NULL,
            target_slug char(200) NOT NULL,
            privilege_slug char(200) NOT NULL, 
            PRIMARY KEY  (privilege_id)  
        ) COLLATE utf8_general_ci;";
        dbDelta($sql);



        update_option("WC_RESTRICT_BY_CATEGORY_DB_VERSION",SMART_FORMS_LATEST_DB_VERSION);
    }
}


require_once('pr.php');

