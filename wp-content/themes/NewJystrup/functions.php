<?php
require_once('wp_bootstrap_navwalker.php');
register_nav_menu('top', 'Top menu');
function themebs_enqueue_styles() {

    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css' );
    wp_enqueue_style( 'core', get_template_directory_uri() . '/style.css' );

}
add_action( 'wp_enqueue_scripts', 'themebs_enqueue_styles');

function themebs_enqueue_scripts() {
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.bundle.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'themebs_enqueue_scripts');


function wpb_custom_new_menu() {
    register_nav_menu('my-custom-menu',__( 'My Custom Menu' ));
}
add_action( 'init', 'wpb_custom_new_menu' );

add_action('wp_enqueue_scripts','my_theme_enqueue_styles');

function my_theme_enqueue_styles(){
    wp_enqueue_style('parent-style',get_template_directory_uri().'/style.css');
}

/*
    Function for making the parents of dropdowns clickable without compromising hover function.
*/

add_action( 'wp_enqueue_scripts', 'add_my_script' );
function add_my_script() {
    wp_enqueue_script(
        'your-script', // name your script so that you can attach other scripts and de-register, etc.
        get_template_directory_uri() . '/js/DropdownParentHover.js', // this is the location of your script file
        array('jquery') // this array lists the scripts upon which your script depends
    );
}