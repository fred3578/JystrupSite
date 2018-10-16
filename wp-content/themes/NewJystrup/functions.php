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
function justrup_widgets_init() {

	register_sidebar( array(
		'name'          => 'sidebar-widgets',
		'id'            => 'sidebar-wrapper',
		'before_widget' => '<div id="sidebar-brand">',
		'after_widget'  => '</div>',
	) );

}
add_action( 'widgets_init', 'justrup_widgets_init' );
*/

function wpb_widgets_init() {
 
 register_sidebar( array(
	 'name' => __( 'Main Sidebar', 'wpb' ),
	 'id' => 'sidebar-1',
	 'description' => __( 'The main sidebar appears on the right on each page except the front page template', 'wpb' ),
	 'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	 'after_widget' => '</aside>',
	 'before_title' => '<h3 class="widget-title">',
	 'after_title' => '</h3>',
 ) );

 register_sidebar( array(
	 'name' =>__( 'Front page sidebar', 'wpb'),
	 'id' => 'sidebar-2',
	 'description' => __( 'Appears on the static front page template', 'wpb' ),
	 'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	 'after_widget' => '</aside>',
	 'before_title' => '<h3 class="widget-title">',
	 'after_title' => '</h3>',
 ) );
 }

add_action( 'widgets_init', 'wpb_widgets_init' );

?>