<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package KFUM
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function taastrup_spejder_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'taastrup_spejder_jetpack_setup' );
