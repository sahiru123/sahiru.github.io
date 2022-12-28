<?php
/**
 * Theme functions and definitions
 *
 * @package EasyWiz
 */

/**
 * After setup theme hook
 */
function easywiz_theme_setup(){
    /*
     * Make child theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'easywiz' );	
}
add_action( 'after_setup_theme', 'easywiz_theme_setup' );

/**
 * Load assets.
 */

function easywiz_theme_css() {
	wp_enqueue_style( 'easywiz-parent-theme-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style('easywiz-child-theme-style', get_stylesheet_directory_uri() . '/style.css');
	wp_enqueue_script('jquery-waypoint', get_stylesheet_directory_uri() . '/assets/vendors/js/jquery.waypoints.js', array('jquery'), false, true);	
	wp_enqueue_script('jquery-counterup', get_stylesheet_directory_uri() . '/assets/vendors/js/jquery.counterup.js', array('jquery'), false, true);		
}
add_action( 'wp_enqueue_scripts', 'easywiz_theme_css', 99);


require get_stylesheet_directory() . '/theme-functions/controls/class-customize.php';

/**
 * Import Options From Parent Theme
 *
 */
function easywiz_parent_theme_options() {
	$cosmobit_mods = get_option( 'theme_mods_cosmobit' );
	if ( ! empty( $cosmobit_mods ) ) {
		foreach ( $cosmobit_mods as $cosmobit_mod_k => $cosmobit_mod_v ) {
			set_theme_mod( $cosmobit_mod_k, $cosmobit_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'easywiz_parent_theme_options' );