<?php
/**
 * Custom header
 */

function yoga_studio_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'yoga_studio_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1600,
		'height'                 => 100,
		'wp-head-callback'       => 'yoga_studio_header_style',
	) ) );
}

add_action( 'after_setup_theme', 'yoga_studio_custom_header_setup' );

if ( ! function_exists( 'yoga_studio_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see yoga_studio_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'yoga_studio_header_style' );
function yoga_studio_header_style() {
	if ( get_header_image() ) :
	$yoga_studio_custom_css = "
        #header{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'yoga-studio-style', $yoga_studio_custom_css );
	endif;
}
endif;
