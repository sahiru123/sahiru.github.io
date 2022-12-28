<?php
/* Notify in customizer */
require get_template_directory() . '/inc/ansar/customizer-notify/yoga-customizer-notify.php';

$config_customizer = array(
	'recommended_plugins'       => array(
		'icyclub' => array(
			'recommended' => true,
			'description' => sprintf('Activate by installing <strong>ICYCLUB</strong> plugin to use front page and all theme features %s.', 'yoga'),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'yoga' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'yoga' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'yoga' ),
	'activate_button_label'     => esc_html__( 'Activate', 'yoga' ),
	'deactivate_button_label'   => esc_html__( 'Deactivate', 'yoga' ),
);
Yoga_Customizer_Notify::init( apply_filters( 'yoga_customizer_notify_array', $config_customizer ) );