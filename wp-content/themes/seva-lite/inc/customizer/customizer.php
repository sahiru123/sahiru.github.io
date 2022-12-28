<?php
/**
 * Seva Lite Theme Customizer
 *
 * @package Seva_Lite
 */

/**
 * Requiring customizer panels & sections
*/
$seva_lite_sections     = array( 'info', 'site', 'appearance', 'layout', 'home', 'general', 'elementor', 'footer' );

foreach( $seva_lite_sections as $s ){
    require get_template_directory() . '/inc/customizer/' . $s . '.php';
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Active Callbacks
*/
require get_template_directory() . '/inc/customizer/active-callback.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function seva_lite_customize_preview_js() {
	wp_enqueue_script( 'seva-lite-customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), SEVA_LITE_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'seva_lite_customize_preview_js' );

function seva_lite_customize_script(){
    $array = array(
        'home'    			=> get_permalink( get_option( 'page_on_front' ) ),
        'flushFonts'        => wp_create_nonce( 'seva-lite-local-fonts-flush' ),
    );
    wp_enqueue_style( 'seva-lite-customize', get_template_directory_uri() . '/inc/css/customize.css', array(), SEVA_LITE_THEME_VERSION );
    wp_enqueue_script( 'seva-lite-customize', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery', 'customize-controls' ), SEVA_LITE_THEME_VERSION, true );
    wp_localize_script( 'seva-lite-customize', 'seva_lite_cdata', $array );

    wp_localize_script( 'seva-lite-repeater', 'seva_lite_customize',
		array(
			'nonce' => wp_create_nonce( 'seva_lite_customize_nonce' )
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'seva_lite_customize_script' );

/*
 * Notifications in customizer
 */
require get_template_directory() . '/inc/customizer-plugin-recommend/customizer-notice/class-customizer-notice.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-install-helper.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-recommend.php';

$config_customizer = array(
	'recommended_plugins' => array(
		//change the slug for respective plugin recomendation
        'blossomthemes-toolkit' => array(
			'recommended' => true,
			'description' => sprintf(
				/* translators: %s: plugin name */
				esc_html__( 'If you want to take full advantage of the features this theme has to offer, please install and activate %s plugin.', 'seva-lite' ), '<strong>BlossomThemes Toolkit</strong>'
			),
		),
	),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'seva-lite' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'seva-lite' ),
	'activate_button_label'     => esc_html__( 'Activate', 'seva-lite' ),
	'deactivate_button_label'   => esc_html__( 'Deactivate', 'seva-lite' ),
);
seva_lite_Customizer_Notice::init( apply_filters( 'seva_lite_customizer_notice_array', $config_customizer ) );

/**
 * Reset font folder
 *
 * @access public
 * @return void
 */
function seva_lite_ajax_delete_fonts_folder() {
	// Check request.
	if ( ! check_ajax_referer( 'seva-lite-local-fonts-flush', 'nonce', false ) ) {
		wp_send_json_error( 'invalid_nonce' );
	}
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_send_json_error( 'invalid_permissions' );
	}
	if ( class_exists( '\Seva_Lite_WebFont_Loader' ) ) {
		$font_loader = new \Seva_Lite_WebFont_Loader( '' );
		$removed = $font_loader->delete_fonts_folder();
		if ( ! $removed ) {
			wp_send_json_error( 'failed_to_flush' );
		}
		wp_send_json_success();
	}
	wp_send_json_error( 'no_font_loader' );
}
add_action( 'wp_ajax_seva_lite_flush_fonts_folder', 'seva_lite_ajax_delete_fonts_folder' );