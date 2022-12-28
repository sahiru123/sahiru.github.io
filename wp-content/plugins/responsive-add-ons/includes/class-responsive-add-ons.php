<?php
/**
 * Responsive Addons setup
 *
 * @package Responsive_Addons
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Responsive_Add_Ons Class.
 *
 * @class Responsive_Add_Ons
 */
class Responsive_Add_Ons {

	/**
	 * Options
	 *
	 * @since 1.0.0
	 * @var   array Options
	 */
	public $options;

	/**
	 * Options
	 *
	 * @since 1.0.0
	 * @var   array Plugin Options
	 */
	public $plugin_options;

	/**
	 * API Url
	 *
	 * @since 2.0.0
	 * @var   string API Url
	 */
	public static $api_url;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_notices', array( $this, 'add_theme_installation_notice' ), 1 );
		add_action( 'wp_head', array( $this, 'responsive_head' ) );
		add_action( 'plugins_loaded', array( $this, 'responsive_addons_translations' ) );
		$plugin = plugin_basename( __FILE__ );
		add_filter( "plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ) );

		// Responsive Ready Site Importer Menu.
		add_action( 'admin_enqueue_scripts', array( $this, 'responsive_ready_sites_admin_enqueue_scripts' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'responsive_ready_sites_admin_enqueue_styles' ) );

		if ( is_admin() ) {
			add_action( 'wp_ajax_responsive-ready-sites-activate-theme', array( $this, 'activate_theme' ) );
			add_action( 'wp_ajax_responsive-ready-sites-required-plugins', array( $this, 'required_plugin' ) );
			add_action( 'wp_ajax_responsive-ready-sites-required-plugin-activate', array( $this, 'required_plugin_activate' ) );
			add_action( 'wp_ajax_responsive-ready-sites-set-reset-data', array( $this, 'set_reset_data' ) );
			add_action( 'wp_ajax_responsive-ready-sites-backup-settings', array( $this, 'backup_settings' ) );
			add_action( 'wp_ajax_responsive-is-theme-active', array( $this, 'check_responsive_theme_active' ) );
			add_action( 'wp_ajax_get-responsive', array( $this, 'get_responsive_theme' ) );
			// Dismiss admin notice.
			add_action( 'wp_ajax_responsive-notice-dismiss', array( $this, 'dismiss_notice' ) );
			// Check if Responsive Addons pro plugin is active.
			add_action( 'wp_ajax_check-responsive-add-ons-pro-installed', array( $this, 'is_responsive_pro_is_installed' ) );

			// Check if Responsive Addons pro license is active.
			add_action( 'wp_ajax_check-responsive-add-ons-pro-license-active', array( $this, 'is_responsive_pro_license_is_active' ) );

			// Update first time activation.
			add_action( 'wp_ajax_update-first-time-activation', array( $this, 'update_first_time_activation_variable' ) );
		}

		// Responsive Addons Menu.
		add_action( 'admin_menu', array( $this, 'responsive_add_ons_admin_menu' ) );

		// Remove all admin notices from specific pages.
		add_action( 'admin_init', array( $this, 'responsive_add_ons_on_admin_init' ) );

		// Redirect to Getting Started Page on Plugin Activation.
		add_action( 'admin_init', array( $this, 'responsive_add_ons_maybe_redirect_to_getting_started' ) );

		$this->options        = get_option( 'responsive_theme_options' );
		$this->plugin_options = get_option( 'responsive_addons_options' );

		$this->load_responsive_sites_importer();

		add_action( 'responsive_addons_importer_page', array( $this, 'menu_callback' ) );

		// Add rating links to the Responsive Addons Admin Page.
		add_filter( 'admin_footer_text', array( $this, 'responsive_addons_admin_rate_us' ) );

		add_action( 'init', array( $this, 'app_output_buffer' ) );
		self::set_api_url();

	}

	/**
	 * Updates the variable defined for first time activation.
	 */
	public function update_first_time_activation_variable() {
		update_option( 'ra_first_time_activation', false );
	}

	/**
	 * Admin notice - install responsive theme
	 */
	public function add_theme_installation_notice() {

		$theme = wp_get_theme();

		if ( 'Responsive' === $theme->name || 'Responsive' === $theme->parent_theme || $this->is_activation_theme_notice_expired() || is_plugin_active( 'responsive-addons-pro/responsive-addons-pro.php' ) ) {
			return;
		}

		$class = 'responsive-notice notice notice-error';

		$theme_status = 'responsive-sites-theme-' . $this->get_theme_status();

		$image_path = RESPONSIVE_ADDONS_URI . 'admin/images/responsive-thumbnail.jpg';
		?>
			<div id="responsive-theme-activation" class="<?php echo esc_attr( $class ); ?>">
				<div class="responsive-addons-message-inner">
					<div class="responsive-addons-message-icon">
						<div class="">
							<img src="<?php echo esc_attr( $image_path ); ?>" alt="Responsive Starter Templates">
						</div>
					</div>
					<div class="responsive-addons-message-content">
						<p><?php echo esc_html( 'Responsive theme needs to be active to use the Responsive Starter Templates plugin.' ); ?> </p>
						<p class="responsive-addons-message-actions">
							<a href="#" class="<?php echo esc_attr( $theme_status ); ?> button button-primary" data-theme-slug="responsive">Install & Activate Now</a>
						</p>
					</div>
				</div>
			</div>
			<?php
	}

	/**
	 * Is notice expired?
	 *
	 * @since 2.0.3
	 *
	 * @return boolean
	 */
	public static function is_activation_theme_notice_expired() {

		// Check the user meta status if current notice is dismissed.
		$meta_status = get_user_meta( get_current_user_id(), 'responsive-theme-activation', true );

		if ( empty( $meta_status ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Dismiss Notice.
	 *
	 * @since 2.0.3
	 * @return void
	 */
	public function dismiss_notice() {
		check_ajax_referer( 'responsive-addons', '_ajax_nonce' );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( __( 'You are not allowed to activate the Theme', 'responsive-addons' ) );
		}

		$notice_id = ( isset( $_POST['notice_id'] ) ) ? sanitize_key( $_POST['notice_id'] ) : '';

		// check for Valid input.
		if ( ! empty( $notice_id ) ) {
			update_user_meta( get_current_user_id(), $notice_id, 'notice-dismissed' );
			wp_send_json_success();
		}

		wp_send_json_error();
	}

	/**
	 * Activate theme
	 *
	 * @since 2.0.3
	 * @return void
	 */
	public function activate_theme() {

		check_ajax_referer( 'responsive-addons', '_ajax_nonce' );

		if ( ! current_user_can( 'switch_themes' ) ) {
			wp_send_json_error( __( 'You are not allowed to activate the Theme', 'responsive-addons' ) );
		}

		switch_theme( 'responsive' );

		wp_send_json_success(
			array(
				'success' => true,
				'message' => __( 'Theme Activated', 'responsive-addons' ),
			)
		);
	}

	/**
	 * Get theme install, active or inactive status.
	 *
	 * @since 1.3.2
	 *
	 * @return string Theme status
	 */
	public function get_theme_status() {

		$theme = wp_get_theme();

		// Theme installed and activate.
		if ( 'Responsive' === $theme->name || 'Responsive' === $theme->parent_theme ) {
			return 'installed-and-active';
		}

		// Theme installed but not activate.
		foreach ( (array) wp_get_themes() as $theme_dir => $theme ) {
			if ( 'Responsive' === $theme->name || 'Responsive' === $theme->parent_theme ) {
				return 'installed-but-inactive';
			}
		}

		return 'not-installed';
	}

	/**
	 * Stuff to do when you activate
	 */
	public static function activate() {
	}

	/**
	 * Clean up after Deactivation
	 */
	public static function deactivate() {
	}

	/**
	 * Setter for $api_url
	 *
	 * @since  1.0.0
	 */
	public static function set_api_url() {
		self::$api_url = apply_filters( 'responsive_ready_sites_api_url', 'https://ccreadysites.cyberchimps.com/wp-json/wp/v2/' );
	}

	/**
	 * Hook into WP admin_init
	 * Responsive 1.x settings
	 *
	 * @param array $options Options.
	 */
	public function admin_init( $options ) {
		$this->init_settings();
	}

	/**
	 * Create plugin translations
	 */
	public function responsive_addons_translations() {
		// Load the text domain for translations.
		load_plugin_textdomain( 'responsive-addons', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Settings
	 */
	public function init_settings() {
		register_setting(
			'responsive_addons',
			'responsive_addons_options',
			array( $this, 'responsive_addons_sanitize' )
		);

	}

	/**
	 * Test to see if the current theme is Responsive
	 *
	 * @return bool
	 */
	public static function is_responsive() {
		$theme = wp_get_theme();

		if ( 'Responsive' === $theme->Name || 'responsive' === $theme->Template || 'Responsive Pro' === $theme->Name || 'responsivepro' === $theme->Template ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Add to wp head
	 */
	public function responsive_head() {

		// Test if using Responsive theme. If yes load from responsive options else load from plugin options.
		$responsive_options = ( $this->is_responsive() ) ? $this->options : $this->plugin_options;

		if ( ! empty( $responsive_options['google_site_verification'] ) ) {
			echo '<meta name="google-site-verification" content="' . esc_attr( $responsive_options['google_site_verification'] ) . '" />' . "\n";
		}

		if ( ! empty( $responsive_options['bing_site_verification'] ) ) {
			echo '<meta name="msvalidate.01" content="' . esc_attr( $responsive_options['bing_site_verification'] ) . '" />' . "\n";
		}

		if ( ! empty( $responsive_options['yahoo_site_verification'] ) ) {
			echo '<meta name="y_key" content="' . esc_attr( $responsive_options['yahoo_site_verification'] ) . '" />' . "\n";
		}

		if ( ! empty( $responsive_options['site_statistics_tracker'] ) ) {
			echo wp_kses_post( $responsive_options['site_statistics_tracker'] );
		}
	}

	/**
	 * Responsive Addons Sanitize
	 *
	 * @since 2.0.3
	 *
	 * @param string $input Input.
	 *
	 * @return string
	 */
	public function responsive_addons_sanitize( $input ) {

		$output = array();

		foreach ( $input as $key => $test ) {
			switch ( $key ) {
				case 'google_site_verification':
					$output[ $key ] = wp_filter_post_kses( $test );
					break;
				case 'yahoo_site_verification':
					$output[ $key ] = wp_filter_post_kses( $test );
					break;
				case 'bing_site_verification':
					$output[ $key ] = wp_filter_post_kses( $test );
					break;
				case 'site_statistics_tracker':
					$output[ $key ] = wp_kses_stripslashes( $test );
					break;

			}
		}

		return $output;
	}

	/**
	 * Add settings link to plugin activate page
	 *
	 * @param array $links Links.
	 *
	 * @return mixed
	 */
	public function plugin_settings_link( $links ) {
		$settings_link = '<a href="themes.php?page=responsive-add-ons">' . __( 'Settings', 'responsive-addons' ) . '</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Menu callback
	 *
	 * @since 2.0.0
	 */
	public function menu_callback() {
		?>
			<div class="responsive-sites-menu-page-wrapper">
			<?php require_once RESPONSIVE_ADDONS_DIR . 'admin/partials/responsive-ready-sites-admin-display.php'; ?>
			</div>
			<?php
	}

	/**
	 * Load Responsive Ready Sites Importer
	 *
	 * @since 2.0.0
	 */
	public function load_responsive_sites_importer() {
		require_once RESPONSIVE_ADDONS_DIR . 'includes/importers/class-responsive-ready-sites-importer.php';
	}

	/**
	 * Include Admin JS
	 *
	 * @param string $hook Hook.
	 *
	 * @since 2.0.0
	 */
	public function responsive_ready_sites_admin_enqueue_scripts( $hook = '' ) {

		wp_enqueue_script( 'install-responsive-theme', RESPONSIVE_ADDONS_URI . 'admin/js/install-responsive-theme.js', array( 'jquery', 'updates' ), RESPONSIVE_ADDONS_VER, true );
		wp_enqueue_style( 'install-responsive-theme', RESPONSIVE_ADDONS_URI . 'admin/css/install-responsive-theme.css', null, RESPONSIVE_ADDONS_VER, 'all' );
		$data = apply_filters(
			'responsive_sites_install_theme_localize_vars',
			array(
				'installed'   => __( 'Installed! Activating..', 'responsive-addons' ),
				'activating'  => __( 'Activating..', 'responsive-addons' ),
				'activated'   => __( 'Activated! Reloading..', 'responsive-addons' ),
				'installing'  => __( 'Installing..', 'responsive-addons' ),
				'ajaxurl'     => esc_url( admin_url( 'admin-ajax.php' ) ),
				'_ajax_nonce' => wp_create_nonce( 'responsive-addons' ),
			)
		);
		wp_localize_script( 'install-responsive-theme', 'ResponsiveInstallThemeVars', $data );

		if ( 'responsive_page_responsive-add-ons' === $hook && empty( $_GET['action'] ) ) {

			wp_enqueue_script( 'responsive-ready-sites-admin-js', RESPONSIVE_ADDONS_URI . 'admin/js/responsive-ready-sites-admin.js', array( 'jquery', 'wp-util', 'updates', 'jquery-ui-autocomplete' ), RESPONSIVE_ADDONS_VER, true );

			$data = apply_filters(
				'responsive_sites_localize_vars',
				array(
					'debug'                           => ((defined('WP_DEBUG') && WP_DEBUG) || isset($_GET['debug'])) ? true : false, //phpcs:ignore
					'ajaxurl'                         => esc_url( admin_url( 'admin-ajax.php' ) ),
					'siteURL'                         => site_url(),
					'_ajax_nonce'                     => wp_create_nonce( 'responsive-addons' ),
					'XMLReaderDisabled'               => ! class_exists( 'XMLReader' ) ? true : false,
					'required_plugins'                => array(),
					'ApiURL'                          => self::$api_url,
					/* translators: %s is a template name */
					'importSingleTemplateButtonTitle' => __( 'Import "%s" Template', 'responsive-addons' ),
					'default_page_builder_sites'      => $this->get_sites_by_page_builder(),
					'strings'                         => array(
						'syncCompleteMessage'  => $this->get_sync_complete_message(),
						/* translators: %s is a template name */
						'importSingleTemplate' => __( 'Import "%s" Template', 'responsive-addons' ),
					),
					'dismiss'                         => __( 'Dismiss this notice.', 'responsive-addons' ),
					'syncTemplatesLibraryStart'       => '<span class="message">' . esc_html__( 'Syncing Responsive Starter Templates in the background. The process can take anywhere between 2 to 3 minutes. We will notify you once done.', 'responsive-addons' ) . '</span>',
					'activated_first_time'            => get_option( 'ra_first_time_activation' ),
				)
			);

			wp_localize_script( 'responsive-ready-sites-admin-js', 'responsiveSitesAdmin', $data );
		}
	}

	/**
	 * Get Sync Complete Message
	 *
	 * @since 2.0.0
	 * @param  boolean $echo Echo the message.
	 * @return mixed
	 */
	public function get_sync_complete_message( $echo = false ) {

		$message = __( 'Responsive Templates data refreshed!', 'responsive-addons' );
		if ( $echo ) {
			echo esc_html( $message );
		} else {
			return esc_html( $message );
		}
	}

	/**
	 * Include Admin css
	 *
	 * @since 2.0.0
	 * @param string $hook Hook.
	 */
	public function responsive_ready_sites_admin_enqueue_styles( $hook = '' ) {
		if ( 'toplevel_page_responsive_add_ons' === $hook || 'responsive_page_responsive-add-ons' === $hook || 'responsive_page_responsive_add_ons_go_pro' === $hook ) {
			// Responsive Ready Sites admin styles.
			wp_register_style( 'responsive-ready-sites-admin', RESPONSIVE_ADDONS_URI . 'admin/css/responsive-ready-sites-admin.css', false, RESPONSIVE_ADDONS_VER );
			wp_enqueue_style( 'responsive-ready-sites-admin' );
		}
	}

	/**
	 * Backup existing settings.
	 */
	public function backup_settings() {
		check_ajax_referer( 'responsive-addons', '_ajax_nonce' );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( __( 'User does not have permission!', 'responsive-addons' ) );
		}

		$file_name    = 'responsive-ready-sites-backup-' . date( 'd-M-Y-h-i-s' ) . '.json';
		$old_settings = get_option( 'responsive_theme_options', array() );

		$upload_dir  = Responsive_Ready_Sites_Importer_Log::get_instance()->log_dir();
		$upload_path = trailingslashit( $upload_dir['path'] );
		$log_file    = $upload_path . $file_name;
		$file_system = Responsive_Ready_Sites_Importer_Log::get_instance()->get_filesystem();

		// If file Write fails.
		if ( false === $file_system->put_contents( $log_file, wp_json_encode( $old_settings ), FS_CHMOD_FILE ) ) {
			update_option( 'responsive_ready_sites_' . $file_name, $old_settings );
		}

		wp_send_json_success();
	}

	/**
	 * Get Active site data
	 */
	public function get_active_site_data() {
		$current_active_site = get_option( 'responsive_current_active_site' );
		return $current_active_site;
	}

	/**
	 * Set reset data
	 */
	public function set_reset_data() {
		check_ajax_referer( 'responsive-addons', '_ajax_nonce' );
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		global $wpdb;

		$post_ids = $wpdb->get_col( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_responsive_ready_sites_imported_post'" );
		$form_ids = $wpdb->get_col( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_responsive_ready_sites_imported_wp_forms'" );
		$term_ids = $wpdb->get_col( "SELECT term_id FROM {$wpdb->termmeta} WHERE meta_key='_responsive_ready_sites_imported_term'" );

		wp_send_json_success(
			array(
				'reset_posts'    => $post_ids,
				'reset_wp_forms' => $form_ids,
				'reset_terms'    => $term_ids,
			)
		);
	}

	/**
	 * Required Plugin
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function required_plugin() {

		// Verify Nonce.
		check_ajax_referer( 'responsive-addons', '_ajax_nonce' );

		$response = array(
			'active'       => array(),
			'inactive'     => array(),
			'notinstalled' => array(),
		);

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( $response );
		}

		$required_plugins_count = ( isset( $_POST['required_plugins'] ) ) ? count( $_POST['required_plugins'] ) : array();

		if ( $required_plugins_count > 0 ) {

			for ( $i = 0; $i < $required_plugins_count; $i++ ) {
				$name = isset( $_POST['required_plugins'][ $i ]['name'] ) ? sanitize_text_field( wp_unslash( $_POST['required_plugins'][ $i ]['name'] ) ) : '';
				$slug = isset( $_POST['required_plugins'][ $i ]['slug'] ) ? sanitize_text_field( wp_unslash( $_POST['required_plugins'][ $i ]['slug'] ) ) : '';
				$init = isset( $_POST['required_plugins'][ $i ]['init'] ) ? sanitize_text_field( wp_unslash( $_POST['required_plugins'][ $i ]['init'] ) ) : '';

				$plugin = array(
					'name' => $name,
					'slug' => $slug,
					'init' => $init,
				);

				if ( file_exists( WP_PLUGIN_DIR . '/' . $init ) && is_plugin_inactive( $init ) ) {

					$response['inactive'][] = $plugin;

				} elseif ( ! file_exists( WP_PLUGIN_DIR . '/' . $init ) ) {

					$response['notinstalled'][] = $plugin;

				} else {
					$response['active'][] = $plugin;
				}
			}
		}

		// Send response.
		wp_send_json_success(
			array(
				'required_plugins' => $response,
			)
		);
	}


	/**
	 * Required Plugin Activate
	 *
	 * @since 1.0.0
	 */
	public function required_plugin_activate() {

		check_ajax_referer( 'responsive-addons', '_ajax_nonce' );

		if ( ! current_user_can( 'activate_plugins' ) ) {
			wp_send_json_error(
				array(
					'success' => false,
					'message' => __( 'Error: You don\'t have the required permissions to install plugins.', 'responsive-addons' ),
				)
			);
		}

		if ( ! isset( $_POST['init'] ) || empty( $_POST['init'] ) ) {
			wp_send_json_error(
				array(
					'success' => false,
					'message' => __( 'Plugins data is missing.', 'responsive-addons' ),
				)
			);
		}

		$data        = array();
		$plugin_init = ( isset( $_POST['init'] ) ) ? wp_kses_post( wp_unslash( $_POST['init'] ) ) : '';

		$activate = activate_plugin( $plugin_init, '', false, true );

		if ( is_wp_error( $activate ) ) {
			wp_send_json_error(
				array(
					'success' => false,
					'message' => $activate->get_error_message(),
				)
			);
		}

		wp_send_json_success(
			array(
				'success' => true,
				'message' => __( 'Plugin Activated', 'responsive-addons' ),
			)
		);

	}

	/**
	 * Check if Responsive Addons Pro is installed.
	 */
	public function is_responsive_pro_is_installed() {
		$responsive_pro_slug = 'responsive-addons-pro/responsive-addons-pro.php';
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$all_plugins = get_plugins();

		if ( ! empty( $all_plugins[ $responsive_pro_slug ] ) ) {
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}
	}

	/**
	 * Check if Responsive Addons Pro License is Active.
	 */
	public function is_responsive_pro_license_is_active() {
		global $wcam_lib_responsive_pro;
		if ( is_null( $wcam_lib_responsive_pro ) ) {
			wp_send_json_error();
		}
		$license_status = $wcam_lib_responsive_pro->license_key_status();

		if ( ! empty( $license_status['data']['activated'] ) && $license_status['data']['activated'] ) {
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}
	}

	/**
	 * Check if Responsive Addons Pro License is Active.
	 */
	public function responsive_pro_license_is_active() {
		global $wcam_lib_responsive_pro;
		if ( is_null( $wcam_lib_responsive_pro ) ) {
			return false;
		}
		$license_status = $wcam_lib_responsive_pro->license_key_status();

		if ( ! empty( $license_status['data']['activated'] ) && $license_status['data']['activated'] ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Adding the theme menu page
	 */
	public function responsive_addons_admin_page() {

		if ( $this->is_responsive() ) {
			$menu_title = 'Responsive Templates';
		} else {
			$menu_title = 'Responsive Starter Templates';
		}

		add_theme_page(
			'Responsive Website Templates',
			$menu_title,
			'administrator',
			'responsive-add-ons',
			array( $this, 'responsive_add_ons' )
		);
	}

	/**
	 * Responsive Addons Admin Page
	 */
	public function responsive_add_ons_templates() {

		if ( $this->is_responsive_addons_pro_is_active() && ! $this->responsive_pro_license_is_active() ) {
			wp_redirect( admin_url( '/options-general.php?page=wc_am_client_responsive_addons_pro_dashboard' ) );
			exit();
		}
		?>
			<div class="wrap">
					<?php
						$this->init_nav_menu( 'general' );
						do_action( 'responsive_addons_importer_page' );
					?>
			</div>

			<?php
	}
	/**
	 * Init Nav Menu
	 *
	 * @param mixed $action Action name.
	 * @since 2.5.0
	 */
	public function init_nav_menu( $action = '' ) {

		if ( '' !== $action ) {
			$this->render_tab_menu( $action );
		}
	}

	/**
	 * Render tab menu
	 *
	 * @param mixed $action Action name.
	 * @since 2.5.0
	 */
	public function render_tab_menu( $action = '' ) {
		?>
		<div id="responsive-sites-menu-page">
			<?php $this->render( $action ); ?>
		</div>
		<?php
	}


	/**
	 * Prints HTML content for tabs
	 *
	 * @param mixed $action Action name.
	 * @since 2.5.0
	 */
	public function render( $action ) {
		?>
			<div class="nav-tab-wrapper">
				<div class="logo">
					<div class="responsive-sites-logo-wrap">
							<img src="<?php echo esc_url( RESPONSIVE_ADDONS_URI . 'admin/images/responsive-thumbnail.jpg' ); ?>">
					</div>
				</div>
				<div id="responsive-sites-filters" class="hide-on-mobile">
					<?php $this->site_filters(); ?>
				</div>
				<div class="form">
					<div class="sync-ready-sites-templates-wrap header-actions">
						<div class="filters-slug">
							<a title="<?php esc_html_e( 'Sync Responsive Starter Templates', 'responsive-add-ons' ); ?>" href="#" class="responsive-ready-sites-sync-templates-button">
								<span class="dashicons dashicons-update-alt"></span>
							</a>
						</div>
					</div>
					<span class="page-builder-icon">
						<div class="selected-page-builder">
							<?php
							$page_builder = array(
								'name' => 'Elementor',
								'slug' => 'elementor',
							);
							if ( $page_builder ) {
								?>
								<span class="page-builder-title"><?php echo esc_html( $page_builder['name'] ); ?></span>
								<span class="dashicons dashicons-arrow-down"></span>
							<?php } ?>
						</div>
						<ul class="page-builders">
							<?php
							$default_page_builder = 'elementor';
							$page_builders        = $this->get_default_page_builders();
							foreach ( $page_builders as $key => $page_builder ) {
								$class = '';
								if ( $default_page_builder === $page_builder['slug'] ) {
									$class = 'active';
								}
								?>
								<li data-page-builder="<?php echo esc_html( $page_builder['slug'] ); ?>" class="<?php echo esc_html( $class ); ?>">
									<div class="title"><?php echo esc_html( $page_builder['name'] ); ?></div>
								</li>
								<?php
							}
							?>
						</ul>
						<form id="responsive-sites-welcome-form-inline" enctype="multipart/form-data" method="post" style="display: none;">
							<div class="fields">
								<input type="hidden" name="page_builder" class="page-builder-input" required="required" />
							</div>
							<input type="hidden" name="message" value="saved" />
							<?php wp_nonce_field( 'responsive-sites-welcome-screen', 'responsive-sites-page-builder' ); ?>
						</form>
					</span>
					<div class="guided-overlay step-one" id="step-one">
						<p class="guide-text">Select your desired page builder.</p>
						<div class="guided-overlay-buttons">
							<button class="skip-tour" id="skip-tour">Skip tour</button>
							<button id="step-one-next">Next</button>
						</div>
					</div>
				</div>
			</div><!-- .nav-tab-wrapper -->
			<div id="responsive-sites-filters" class="hide-on-desktop">
			<?php $this->site_filters(); ?>
		</div>
			<?php
	}

	/**
	 * Site Filters
	 *
	 * @since 2.5.0
	 *
	 * @return void
	 */
	public function site_filters() {
		?>
		<div class="wp-filter hide-if-no-js">
			<div class="section-left">
				<div class="search-form">
					<?php
					$categories = array(
						array(
							'name' => 'Business',
							'slug' => 'business',
						),
						array(
							'name' => 'Blog',
							'slug' => 'blog',
						),
						array(
							'name' => 'Ecommerce',
							'slug' => 'ecommerce',
						),
						array(
							'name' => 'Onepage',
							'slug' => 'onepage',
						),
					);
					if ( ! empty( $categories ) ) {
						?>
						<div id="responsive-sites__category-filter" class="dropdown-check-list" tabindex="100">
							<span class="responsive-sites__category-filter-anchor" data-slug=""><?php esc_html_e( 'All', 'responsive-addons' ); ?></span>
							<ul class="responsive-sites__category-filter-items">
								<li class="responsive-sites__filter-wrap category-active" data-slug=""><?php esc_html_e( 'All', 'responsive-addons' ); ?> </li>
								<?php
								foreach ( $categories as $key => $value ) {
									?>
										<li class="responsive-sites__filter-wrap" data-slug="<?php echo esc_attr( $value['slug'] ); ?>"><?php echo esc_html( $value['name'] ); ?> </li>
									<?php
								}
								?>
								<li class="responsive-sites__filter-wrap-checkbox first-wrap">
									<label>
										<input id="radio-all" type="radio" name="responsive-sites-radio" class="checkbox active" value="" checked /><?php esc_html_e( 'All', 'responsive-addons' ); ?>
									</label>
								</li>
								<li class="responsive-sites__filter-wrap-checkbox">
									<label>
										<input id="radio-free" type="radio" name="responsive-sites-radio" class="checkbox" value="free" /><?php esc_html_e( 'Free', 'responsive-addons' ); ?>
									</label>
								</li>
								<li class="responsive-sites__filter-wrap-checkbox">
									<label>
										<input id="radio-premium" type="radio" name="responsive-sites-radio" class="checkbox" value="premium" /><?php esc_html_e( 'Premium', 'responsive-addons' ); ?>
									</label>
								</li>
							</ul>
						</div>
						<div class="guided-overlay step-two" id="step-two">
							<p class="guide-text">Choose the category and type of the template from the dropdown.</p>
							<div class="guided-overlay-buttons">
								<button class="skip-tour"id="skip-tour-two">Skip tour</button>
								<button id="step-two-previous">Previous</button>
								<button id="step-two-next">Next</button>
							</div>
						</div>
						<?php
					}
					?>
					<input autocomplete="off" placeholder="<?php esc_html_e( 'Search...', 'responsive-addons' ); ?>" type="search" aria-describedby="live-search-desc" id="wp-filter-search-input" class="wp-filter-search">
					<span class="responsive-icon-search search-icon"></span>
					<div class="responsive-sites-autocomplete-result"></div>
				</div>
			</div>
		</div>
		<?php
	}


	/**
	 * Get Default Page Builders
	 *
	 * @since 2.5.0
	 * @return array
	 */
	public function get_default_page_builders() {
		return array(
			array(
				'id'   => 1,
				'slug' => 'all',
				'name' => 'ALL',
			),
			array(
				'id'   => 2,
				'slug' => 'elementor',
				'name' => 'Elementor',
			),
			array(
				'id'   => 3,
				'slug' => 'gutenberg',
				'name' => 'Gutenberg',
			),
		);
	}

	/**
	 * Check if Responsive Addons Pro is installed.
	 */
	public function is_responsive_addons_pro_is_active() {
		$responsive_pro_slug = 'responsive-addons-pro/responsive-addons-pro.php';
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( is_plugin_active( $responsive_pro_slug ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Add rating links to the Responsive Addons Admin Page
	 *
	 * @param string $footer_text The existing footer text.
	 *
	 * @return string
	 * @since 2.0.6
	 * @global string $typenow
	 */
	public function responsive_addons_admin_rate_us( $footer_text ) {
		$page        = isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : '';
		$show_footer = array( 'responsive-add-ons' );

		if ( in_array( $page, $show_footer ) ) {
			$rate_text = sprintf(
				/* translators: %s: Link to 5 star rating */
				__( 'If you like the <strong>Responsive Starter Templates</strong> plugin please leave us a %s rating. It takes a minute and helps a lot. Thanks in advance!', 'responsive-addons' ),
				'<a href="https://wordpress.org/support/view/plugin-reviews/responsive-add-ons?filter=5#postform" target="_blank" class="responsive-rating-link" style="text-decoration:none;" data-rated="' . esc_attr__( 'Thanks :)', 'responsive-addons' ) . '">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
			);

			return $rate_text;
		} else {
			return $footer_text;
		}
	}

	/**
	 * Output buffer
	 */
	public function app_output_buffer() {
		ob_start();
	}

	/**
	 * Check if Responsive theme or Child theme of Responsive is Active
	 *
	 * @since 2.1.1
	 */
	public function check_responsive_theme_active() {

		check_ajax_referer( 'responsive-addons', '_ajax_nonce' );

		if ( ! current_user_can( 'switch_themes' ) ) {
			wp_send_json_error( __( 'User does not have permission!', 'responsive-addons' ) );
		}

		$current_theme = wp_get_theme();
		if ( ( 'Responsive' === $current_theme->get( 'Name' ) ) || ( is_child_theme() && 'Responsive' === $current_theme->parent()->get( 'Name' ) ) ) {
			wp_send_json_success(
				array( 'success' => true )
			);
		} else {
			wp_send_json_error(
				array( 'success' => false )
			);
		}
	}

	/**
	 * Check if Responsive theme or Child theme of Responsive is Active
	 *
	 * @since 2.1.1
	 */
	public function get_responsive_theme() {

		if ( ! current_user_can( 'install_themes' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to install themes on this site.' ) );
		}

		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php'; // For themes_api().

		$theme = 'responsive';

		$api = themes_api(
			'theme_information',
			array(
				'slug' => $theme,
			)
		); // Save on a bit of bandwidth.

		if ( is_wp_error( $api ) ) {
			wp_die( esc_html( $api ) );
		}

		/* translators: %s: Theme name and version. */
		$upgrader = new Theme_Upgrader( new Theme_Installer_Skin() );
		$res      = $upgrader->install( $api->download_link );
		switch_theme( 'responsive' );
		if ( $res ) {
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}
	}

	/**
	 * Register the menu for the plugin.
	 *
	 * @since 2.2.8
	 */
	public function responsive_add_ons_admin_menu() {
		// Create Menu for Responsive Pro.
		add_menu_page(
			__( 'Responsive', 'responsive-addons' ),
			__( 'Responsive', 'responsive-addons' ),
			'manage_options',
			'responsive_add_ons',
			array( $this, 'responsive_add_ons_getting_started' ),
			RESPONSIVE_ADDONS_URI . '/admin/images/responsive-add-ons-menu-icon.png',
			59.5
		);

		add_submenu_page(
			'responsive_add_ons',
			__( 'Getting Started', 'responsive-addons' ),
			__( 'Getting Started', 'responsive-addons' ),
			'manage_options',
			'responsive_add_ons',
			array( $this, 'responsive_add_ons_getting_started' ),
			10
		);

		add_submenu_page(
			'responsive_add_ons',
			'Responsive Starter Templates',
			__( 'Responsive Templates', 'responsive-addons' ),
			'manage_options',
			'responsive-add-ons',
			array( $this, 'responsive_add_ons_templates' ),
			20
		);
	}

	/**
	 * Display Getting Started Page.
	 *
	 * Output the content for the getting started page.
	 *
	 * @since 2.2.8
	 * @access public
	 */
	public function responsive_add_ons_getting_started() {

		?>
		<div class="wrap">
			<div class="responsive-add-ons-getting-started">
				<div class="responsive-add-ons-getting-started__box postbox">
					<div class="responsive-add-ons-getting-started__header">
						<div class="responsive-add-ons-getting-started__title">
							<?php echo esc_html__( 'Getting Started', 'responsive-addons' ); ?>
						</div>
						<a class="responsive-add-ons-getting-started__skip" href="<?php echo esc_url( admin_url( 'admin.php?page=responsive-add-ons' ) ); ?>">
							<span class="responsive-add-ons-getting-started__skip_button"><span class="screen-reader-text">Skip</span></span>
						</a>
					</div>
					<div class="responsive-add-ons-getting-started__content">
						<div class="responsive-add-ons-getting-started__content--narrow">
							<h2><?php echo esc_html__( 'Welcome to Responsive Starter Templates', 'responsive-addons' ); ?></h2>
							<p class="slogan-text"><?php echo esc_html__( 'Create Responsive, Fast and Customizable websites in minutes.', 'responsive-addons' ); ?></p>
						</div>

						<div class="responsive-add-ons-getting-started__content--sub-content">
							<div class="responsive-add-ons-getting-started__video">
								<iframe src="https://www.youtube-nocookie.com/embed/1eKjI0qjXPI?rel=0&amp;controls=1&amp;modestbranding=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>

						<div class="responsive-add-ons-getting-started__links">
							<div class="responsive-add-ons-getting-started__card">
								<div class="getting-started-svgs help-center"></div>
								<h3><?php echo esc_html__( 'Help Center', 'responsive-addons' ); ?></h3>
								<p class="card-text"><?php echo esc_html__( 'Read the documentation to find answers to your questions.', 'responsive-addons' ); ?></p>
								<a href="https://docs.cyberchimps.com/responsive/responsive-sites?utm_source=plugin&utm_medium=responsive-add-ons&utm_campaign=help-resources" target="_blank"><?php echo esc_html__( 'Learn More >>', 'responsive-addons' ); ?></a>
							</div>
							<div class="responsive-add-ons-getting-started__card">
								<div class="getting-started-svgs video-guides"></div>
								<h3><?php echo esc_html__( 'Video Guides', 'responsive-addons' ); ?></h3>
								<p class="card-text"><?php echo esc_html__( 'Browse through these video tutorials to learn more about how the plugin functions.', 'responsive-addons' ); ?></p>
								<a href="https://youtube.com/playlist?list=PLXTwxw3ZJwPSpE3RYanAdYgnDptbSvjXl" target="_blank"><?php echo esc_html__( 'Watch Now >>', 'responsive-addons' ); ?></a>
							</div>
							<div class="responsive-add-ons-getting-started__card">
								<div class="getting-started-svgs community-support"></div>
								<h3><?php echo esc_html__( 'Community Support', 'responsive-addons' ); ?></h3>
								<p class="card-text"><?php echo esc_html__( 'Find help to the commonly asked questions in our exclusive Community on Facebook.', 'responsive-addons' ); ?></p>
								<a href="https://www.facebook.com/groups/responsive.theme" target="_blank"><?php echo esc_html__( 'Find Help >>', 'responsive-addons' ); ?></a>
							</div>
						</div>

						<?php
						$support_link = 'https://cyberchimps.com/my-account/';
						if ( ! defined( 'RESPONSIVE_ADDONS_PRO_VERSION' ) ) {
							$support_link = ' https://wordpress.org/support/plugin/responsive-add-ons/';
							?>
							<div class="go-pro-container">
								<p class="responsive-add-ons-getting-started__text"><?php echo esc_html__( 'Get access to all the pro templates and unlock more theme customizer settings using Responsive Pro', 'responsive-addons' ); ?></p>
								<a href="https://cyberchimps.com/pricing/?utm_source=plugin&utm_medium=responsive-add-ons&utm_campaign=go-pro" target="_blank">
									<button class="getting-started-button responsive-add-ons-getting-started--button-go-pro">
										<?php echo esc_html__( 'Go Pro!', 'responsive-addons' ); ?>
									</button>
								</a>
							</div>
						<?php } ?>

						<?php self::responsive_add_ons_quick_links(); ?>

						<div class="responsive-add-ons-getting-started__footer">
							<p class="getting-started-footer-text"><?php echo esc_html__( 'Have questions? Get in touch with us. We\'ll be happy to help', 'responsive-addons' ); ?></p>
							<a href="<?php echo esc_url( $support_link ); ?>" target="_blank">
								<button class="getting-started-button footer-community-button">
									<?php echo esc_html__( 'Request Support', 'responsive-addons' ); ?>
								</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.wrap -->
		<?php
	}

	/**
	 * Display quick links.
	 *
	 * @static
	 * @since 2.6.0
	 * @access public
	 */
	public static function responsive_add_ons_quick_links() {
		$help_icon      = RESPONSIVE_ADDONS_DIR_URL . '/admin/images/help-doc.png';
		$video_icon     = RESPONSIVE_ADDONS_DIR_URL . '/admin/images/video.png';
		$support_icon   = RESPONSIVE_ADDONS_DIR_URL . '/admin/images/support.png';
		$community_icon = RESPONSIVE_ADDONS_DIR_URL . '/admin/images/community.png';
		?>
		<div class="responsive-ready-sites-quick-links-wrapper">
			<div class="responsive-ready-sites-quick-links">
				<a href="<?php echo esc_url( 'https://docs.cyberchimps.com/responsive/responsive-sites?utm_source=plugin&utm_medium=responsive-add-ons&utm_campaign=quick-links' ); ?>" target="_blank" class="link-anchor help-doc-link">
					<span class="quick-links-text"><?php esc_html_e( 'Help and Documentation', 'responsive-addons' ); ?></span>
					<span class="quick-link-icon help-doc-icon">
						<img src="<?php echo esc_attr( $help_icon ); ?>" alt="">
					</span>
				</a>
				<a href="<?php echo esc_url( 'https://youtube.com/playlist?list=PLXTwxw3ZJwPSpE3RYanAdYgnDptbSvjXl' ); ?>" target="_blank" class="link-anchor video-guides-link">
					<span class="quick-links-text"><?php esc_html_e( 'Video Guides', 'responsive-addons' ); ?></span>
					<span class="quick-link-icon video-icon">
						<img src="<?php echo esc_attr( $video_icon ); ?>" alt="">
					</span>
				</a>	
				<?php

				$support_link = defined( 'RESPONSIVE_ADDONS_PRO_VERSION' ) ? esc_url( 'https://cyberchimps.com/my-account/' ) : esc_url( ' https://wordpress.org/support/plugin/responsive-add-ons/' );
				?>
				<a href="<?php echo esc_url( $support_link ); ?>" target="_blank" class="link-anchor support-link">
					<span class="quick-links-text"><?php esc_html_e( 'Request Support', 'responsive-addons' ); ?></span>
					<span class="quick-link-icon support-icon">
						<img src="<?php echo esc_attr( $support_icon ); ?>" alt="">
					</span>
				</a>	
				<a href="<?php echo esc_url( 'https://www.facebook.com/groups/responsive.theme' ); ?>" target="_blank" class="link-anchor community-link">
					<span class="quick-links-text"><?php esc_html_e( 'Join Our Community', 'responsive-addons' ); ?></span>
					<span class="quick-link-icon community-icon">
						<img src="<?php echo esc_attr( $community_icon ); ?>" alt="">
					</span>
				</a>	
			</div>
			<button class="responsive-ready-sites-quick-links-toggler-button">
				<div class="responsive-addons-cyberchimps-mascot"></div>
				<div class="quick-links-text responsive-addons-quick-link-label"><?php esc_html_e( 'See Quick Links', 'responsive-addons' ); ?></div>	
			</button>
		</div>
		<script type="text/javascript">
			jQuery('.responsive-ready-sites-quick-links-toggler-button').on('click', function(e) {
				jQuery('.responsive-ready-sites-quick-links').toggleClass('show');
			});
		</script>
		<?php
	}

	/**
	 * Go to Responsive Pro support.
	 *
	 * Fired by `admin_init` action.
	 *
	 * @since 2.2.8
	 * @access public
	 */
	public function responsive_add_ons_community_support() {
		if ( empty( $_GET['page'] ) ) {
			return;
		}
		wp_redirect( 'https://www.facebook.com/groups/responsive.theme' );
		die;
	}

	/**
	 * Free vs Pro features list.
	 *
	 * @since 2.2.8
	 * @access public
	 */
	public function responsive_add_ons_go_pro() {
		require_once RESPONSIVE_ADDONS_DIR . 'admin/templates/free-vs-pro.php';
	}

	/**
	 * On admin init.
	 *
	 * Preform actions on WordPress admin initialization.
	 *
	 * Fired by `admin_init` action.
	 *
	 * @since 2.2.8
	 * @access public
	 */
	public function responsive_add_ons_on_admin_init() {

		$this->responsive_add_ons_remove_all_admin_notices();
	}

	/**
	 * Removes all the admin notices.
	 *
	 * @since 2.2.8
	 * @access private
	 */
	private function responsive_add_ons_remove_all_admin_notices() {
		$responsive_add_ons_pages = array(
			'responsive_add_ons',
			'responsive-add-ons',
			'responsive_addons_pro_system_info',
		);

		if ( empty( $_GET['page'] ) || ! in_array( $_GET['page'], $responsive_add_ons_pages, true ) ) {
			return;
		}

		remove_all_actions( 'admin_notices' );
	}

	/**
	 * Redirect to getting started.
	 *
	 * @since 2.2.8
	 * @access public
	 */
	public function responsive_add_ons_maybe_redirect_to_getting_started() {
		if ( ! get_transient( 'responsive_add_ons_activation_redirect' ) ) {
			return;
		}

		if ( wp_doing_ajax() ) {
			return;
		}

		delete_transient( 'responsive_add_ons_activation_redirect' );

		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}

		wp_safe_redirect( admin_url( 'admin.php?page=responsive_add_ons' ) );

		exit;
	}

	/**
	 * Get all sites
	 *
	 * @since 2.5.0
	 * @return array All sites.
	 */
	public function get_all_sites() {
		$sites_and_pages = array();

		$total_requests = $this->get_total_requests();

		for ( $page = 1; $page <= $total_requests; $page++ ) {
			$current_page_data = get_site_option( 'responsive-ready-sites-and-pages-page-' . $page, array() );
			if ( ! empty( $current_page_data ) ) {
				foreach ( $current_page_data as $page_id => $page_data ) {
					$sites_and_pages[] = $page_data;
				}
			}
		}
		return $sites_and_pages;
	}

	/**
	 * Get Page Builder Sites
	 *
	 * @since 2.5.0
	 *
	 * @return array page builder sites.
	 */
	public function get_sites_by_page_builder() {
		$sites_and_pages            = $this->get_all_sites();
		$current_page_builder_sites = array();
		if ( ! empty( $sites_and_pages ) ) {
			foreach ( $sites_and_pages as $site_id => $site_details ) {
					$current_page_builder_sites[] = $site_details;
			}
		}

		return $current_page_builder_sites;
	}

	/**
	 * Get Total Requests
	 *
	 * @since 2.5.0
	 * @return integer
	 */
	public function get_total_requests() {

		$api_args = array(
			'timeout' => 60,
		);

		$api_url = self::$api_url . 'get-ready-sites-requests-count/?per_page=15';

		$response = wp_remote_get( $api_url, $api_args );

		if ( ! is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 200 ) {

			$total_requests = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( isset( $total_requests ) ) {

				update_site_option( 'responsive-ready-sites-requests', $total_requests );

				return $total_requests;
			}
		}

		$this->get_total_requests();
	}
}
