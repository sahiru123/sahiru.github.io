<?php

class Yoga_Customizer_Notify {

	private $recommended_actions;

	
	private $recommended_plugins;

	
	private static $instance;

	
	private $recommended_actions_title;

	
	private $recommended_plugins_title;

	
	private $dismiss_button;

	
	private $install_button_label;

	
	private $activate_button_label;

	
	private $deactivate_button_label;

	
	public static function init( $config ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof yoga_Customizer_Notify ) ) {
			self::$instance = new yoga_Customizer_Notify;
			if ( ! empty( $config ) && is_array( $config ) ) {
				self::$instance->config = $config;
				self::$instance->setup_config();
				self::$instance->setup_actions();
			}
		}

	}

	
	public function setup_config() {

		global $yoga_customizer_notify_recommended_plugins;
		global $yoga_customizer_notify_recommended_actions;

		global $install_button_label;
		global $activate_button_label;
		global $deactivate_button_label;

		$this->recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
		$this->recommended_plugins = isset( $this->config['recommended_plugins'] ) ? $this->config['recommended_plugins'] : array();

		$this->recommended_actions_title = isset( $this->config['recommended_actions_title'] ) ? $this->config['recommended_actions_title'] : '';
		$this->recommended_plugins_title = isset( $this->config['recommended_plugins_title'] ) ? $this->config['recommended_plugins_title'] : '';
		$this->dismiss_button            = isset( $this->config['dismiss_button'] ) ? $this->config['dismiss_button'] : '';

		$yoga_customizer_notify_recommended_plugins = array();
		$yoga_customizer_notify_recommended_actions = array();

		if ( isset( $this->recommended_plugins ) ) {
			$yoga_customizer_notify_recommended_plugins = $this->recommended_plugins;
		}

		if ( isset( $this->recommended_actions ) ) {
			$yoga_customizer_notify_recommended_actions = $this->recommended_actions;
		}

		$install_button_label    = isset( $this->config['install_button_label'] ) ? $this->config['install_button_label'] : '';
		$activate_button_label   = isset( $this->config['activate_button_label'] ) ? $this->config['activate_button_label'] : '';
		$deactivate_button_label = isset( $this->config['deactivate_button_label'] ) ? $this->config['deactivate_button_label'] : '';

	}

	
	public function setup_actions() {

		// Register the section
		add_action( 'customize_register', array( $this, 'yoga_plugin_notification_customize_register' ) );

		// Enqueue scripts and styles
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'yoga_customizer_notify_scripts_for_customizer' ), 0 );

		/* ajax callback for dismissable recommended actions */
		add_action( 'wp_ajax_quality_customizer_notify_dismiss_action', array( $this, 'yoga_customizer_notify_dismiss_recommended_action_callback' ) );

		add_action( 'wp_ajax_ti_customizer_notify_dismiss_recommended_plugins', array( $this, 'yoga_customizer_notify_dismiss_recommended_plugins_callback' ) );

	}

	
	public function yoga_customizer_notify_scripts_for_customizer() {

		wp_enqueue_style( 'yoga-customizer-notify-css', get_template_directory_uri() . '/inc/ansar/customizer-notify/css/yoga-customizer-notify.css', array());
		wp_style_add_data( 'yoga-customizer-notify-css', 'rtl', 'replace' );

		wp_enqueue_style( 'plugin-install' );
		wp_enqueue_script( 'plugin-install' );
		wp_add_inline_script( 'plugin-install', 'var pagenow = "customizer";' );

		wp_enqueue_script( 'updates' );

		wp_enqueue_script( 'yoga-customizer-notify-js', get_template_directory_uri() . '/inc/ansar/customizer-notify/js/yoga-customizer-notify.js', array( 'customize-controls' ));
		wp_localize_script(
			'yoga-customizer-notify-js', 'yogaCustomizercompanionObject', array(
				'template_directory' => esc_url(get_template_directory_uri()),
				'base_path'          => esc_url(admin_url()),
				'activating_string'  => __( 'Activating', 'yoga' ),
			)
		);

	}

	
	public function yoga_plugin_notification_customize_register( $wp_customize ) {

		
		require_once get_template_directory() . '/inc/ansar/customizer-notify/yoga-customizer-notify-section.php';

		$wp_customize->register_section_type( 'yoga_Customizer_Notify_Section' );

		$wp_customize->add_section(
			new yoga_Customizer_Notify_Section(
				$wp_customize,
				'yoga-customizer-notify-section',
				array(
					'title'          => $this->recommended_actions_title,
					'plugin_text'    => $this->recommended_plugins_title,
					'dismiss_button' => $this->dismiss_button,
					'priority'       => 0,
				)
			)
		);

	}


	public function yoga_customizer_notify_dismiss_recommended_action_callback() {

		global $yoga_customizer_notify_recommended_actions;

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			
			if ( get_theme_mod( 'yoga_customizer_notify_show' ) ) {

				$yoga_customizer_notify_show_recommended_actions = get_theme_mod( 'yoga_customizer_notify_show' );
				switch ( $_GET['todo'] ) {
					case 'add':
						$yoga_customizer_notify_show_recommended_actions[ $action_id ] = true;
						break;
					case 'dismiss':
						$yoga_customizer_notify_show_recommended_actions[ $action_id ] = false;
						break;
				}
				echo esc_html($yoga_customizer_notify_show_recommended_actions);
				
			} else {
				$yoga_customizer_notify_show_recommended_actions = array();
				if ( ! empty( $yoga_customizer_notify_recommended_actions ) ) {
					foreach ( $yoga_customizer_notify_recommended_actions as $yoga_lite_customizer_notify_recommended_action ) {
						if ( $yoga_lite_customizer_notify_recommended_action['id'] == $action_id ) {
							$yoga_customizer_notify_show_recommended_actions[ $yoga_lite_customizer_notify_recommended_action['id'] ] = false;
						} else {
							$yoga_customizer_notify_show_recommended_actions[ $yoga_lite_customizer_notify_recommended_action['id'] ] = true;
						}
					}
					echo esc_html($yoga_customizer_notify_show_recommended_actions);
				}
			}
		}
		die(); 
	}

	
	public function yoga_customizer_notify_dismiss_recommended_plugins_callback() {

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			$yoga_lite_customizer_notify_show_recommended_plugins = get_theme_mod( 'yoga_customizer_notify_show_recommended_plugins' );

			switch ( $_GET['todo'] ) {
				case 'add':
					$yoga_lite_customizer_notify_show_recommended_plugins[ $action_id ] = false;
					break;
				case 'dismiss':
					$yoga_lite_customizer_notify_show_recommended_plugins[ $action_id ] = true;
					break;
			}
			echo esc_html($yoga_customizer_notify_show_recommended_actions);
		}
		die(); 
	}

}