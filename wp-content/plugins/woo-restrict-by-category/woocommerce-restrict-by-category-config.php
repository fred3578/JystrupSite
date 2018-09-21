<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 9/6/2017
 * Time: 6:54 PM
 */

global $wpdb;
if(!defined('ABSPATH'))
    die('Forbidden');

define('WC_RESTRICT_BY_CATEGORY_PLUGIN_NAME',dirname(plugin_basename(__FILE__)));
define('WC_RESTRICT_BY_CATEGORY_DIR',WP_PLUGIN_DIR.'/'.WC_RESTRICT_BY_CATEGORY_PLUGIN_NAME.'/');
define('WC_RESTRICT_BY_CATEGORY_URL',plugin_dir_url(__FILE__));
define('WC_RESTRICT_BY_CATEGORY_TABLE',$wpdb->prefix . "rednao_wcrbc_privileges");
define('WC_RESTRICT_BY_CATEGORY_DB_VERSION',13);
define('WC_RESTRICT_BY_CATEGORY_URL',"http://smartforms.rednao.com/");
define('WC_RESTRICT_BY_CATEGORY_VERSION','NR');
