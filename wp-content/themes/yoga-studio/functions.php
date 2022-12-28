<?php
/**
 * Yoga Studio functions and definitions
 *
 * @subpackage Yoga Studio
 * @since 1.0
 */

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'yoga_studio_loop_columns', 999);
if (!function_exists('yoga_studio_loop_columns')) {
	function yoga_studio_loop_columns() {
		return 3;
	}
}

function yoga_studio_sanitize_dropdown_pages( $page_id, $setting ) {
	$page_id = absint( $page_id );
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function yoga_studio_sanitize_phone_number( $phone ) {
  return preg_replace( '/[^\d+]/', '', $phone );
}

function yoga_studio_sanitize_checkbox( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function yoga_studio_sanitize_select( $input, $setting ){
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function yoga_studio_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function yoga_studio_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );

	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}

function yoga_studio_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf(
		'<div class="link-more text-center"><a href="%1$s" class="more-link py-2 px-4">%2$s</a></div>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Read More<span class="screen-reader-text"> "%s"</span>', 'yoga-studio' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'yoga_studio_excerpt_more' );

function yoga_studio_notice(){
    global $pagenow;
    if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
        wp_safe_redirect( admin_url("themes.php?page=yoga-studio-guide-page") );
    }
}
add_action('after_setup_theme', 'yoga_studio_notice');

function yoga_studio_add_new_page() {
  $edit_page = admin_url().'post-new.php?post_type=page';
  echo json_encode(['page_id'=>'','edit_page_url'=> $edit_page ]);

  exit;
}
add_action( 'wp_ajax_yoga_studio_add_new_page','yoga_studio_add_new_page' );

function yoga_studio_setup() {

	add_theme_support( 'woocommerce' );
	add_theme_support( "align-wide" );
	add_theme_support( "wp-block-styles" );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( "responsive-embeds" );
	add_theme_support( 'title-tag' );
	add_theme_support('custom-background',array(
		'default-color' => 'ffffff',
	));
	add_image_size( 'yoga-studio-featured-image', 2000, 1200, true );
	add_image_size( 'yoga-studio-thumbnail-avatar', 100, 100, true );

	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'yoga-studio' ),
	) );

	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', yoga_studio_fonts_url() ) );

}
add_action( 'after_setup_theme', 'yoga_studio_setup' );

function yoga_studio_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'yoga-studio' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'yoga-studio' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'yoga-studio' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'yoga-studio' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'yoga-studio' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'yoga-studio' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'yoga-studio' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'yoga-studio' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'yoga-studio' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'yoga-studio' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'yoga-studio' ),
		'id'            => 'footer-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'yoga-studio' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'yoga_studio_widgets_init' );

function yoga_studio_fonts_url(){
	$yoga_studio_font_url = '';
	$yoga_studio_font_family = array();
	$yoga_studio_font_family[] = 'Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900';
	$yoga_studio_font_family[] = 'Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700';

	$yoga_studio_query_args = array(
		'family'	=> rawurlencode(implode('|',$yoga_studio_font_family)),
	);
	$yoga_studio_font_url = add_query_arg($yoga_studio_query_args,'//fonts.googleapis.com/css');
	return $yoga_studio_font_url;
	$yoga_studio_contents = wptt_get_webfont_url( esc_url_raw( $yoga_studio_fonts_url ) );
}

//Enqueue scripts and styles.
function yoga_studio_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'yoga-studio-fonts', yoga_studio_fonts_url(), array() );

	//Bootstarp
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri().'/assets/css/bootstrap.css' );

	// Theme stylesheet.
	wp_enqueue_style( 'yoga-studio-style', get_stylesheet_uri() );

	wp_style_add_data('yoga-studio-style', 'rtl', 'replace');

	// Theme Customize CSS.
	require get_parent_theme_file_path( 'inc/extra_customization.php' );
	wp_add_inline_style( 'yoga-studio-style',$yoga_studio_custom_style );

	//font-awesome
	wp_enqueue_style( 'font-awesome-style', get_template_directory_uri().'/assets/css/fontawesome-all.css' );

	// Block Style
	wp_enqueue_style( 'yoga-studio-block-style',get_template_directory_uri().'/assets/css/blocks.css' );

	//Custom JS
	wp_enqueue_script( 'yoga-studio-custom.js', get_theme_file_uri( '/assets/js/theme-script.js' ), array( 'jquery' ), true );

	//Nav Focus JS
	wp_enqueue_script( 'yoga-studio-navigation-focus', get_theme_file_uri( '/assets/js/navigation-focus.js' ), array( 'jquery' ), true );

	//Superfish JS
	wp_enqueue_script( 'superfish-js', get_theme_file_uri( '/assets/js/jquery.superfish.js' ), array( 'jquery' ),true );

	//Bootstarp JS
	wp_enqueue_script( 'bootstrap-js', get_theme_file_uri( '/assets/js/bootstrap.js' ), array( 'jquery' ),true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'yoga_studio_scripts' );

function yoga_studio_fonts_scripts() {
	$yoga_studio_headings_font = esc_html(get_theme_mod('yoga_studio_headings_text'));
	$yoga_studio_body_font = esc_html(get_theme_mod('yoga_studio_body_text'));

	if( $yoga_studio_headings_font ) {
		wp_enqueue_style( 'yoga-studio-headings-fonts', '//fonts.googleapis.com/css?family='. $yoga_studio_headings_font );
	} else {
		wp_enqueue_style( 'yoga-studio-source-sans', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
	}
	if( $yoga_studio_body_font ) {
		wp_enqueue_style( 'yoga-studio-body-fonts', '//fonts.googleapis.com/css?family='. $yoga_studio_body_font );
	} else {
		wp_enqueue_style( 'yoga-studio-source-body', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,700,600');
	}
}
add_action( 'wp_enqueue_scripts', 'yoga_studio_fonts_scripts' );

function yoga_studio_enqueue_admin_script( $hook ) {

	// Admin JS
	wp_enqueue_script( 'yoga-studio-admin.js', get_theme_file_uri( '/assets/js/yoga-studio-admin.js' ), array( 'jquery' ), true );

	wp_localize_script('yoga-studio-admin.js', 'yoga_studio_scripts_localize',
        array(
            'ajax_url' => esc_url(admin_url('admin-ajax.php'))
        )
    );
}
add_action( 'admin_enqueue_scripts', 'yoga_studio_enqueue_admin_script' );

// Enqueue editor styles for Gutenberg
function yoga_studio_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'yoga-studio-block-editor-style', trailingslashit( esc_url ( get_template_directory_uri() ) ) . '/assets/css/editor-blocks.css' );

	// Add custom fonts.
	wp_enqueue_style( 'yoga-studio-fonts', yoga_studio_fonts_url(), array() );
}
add_action( 'enqueue_block_editor_assets', 'yoga_studio_block_editor_styles' );

function yoga_studio_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'yoga_studio_front_page_template' );

require get_parent_theme_file_path( '/inc/custom-header.php' );

require get_parent_theme_file_path( '/inc/template-tags.php' );

require get_parent_theme_file_path( '/inc/template-functions.php' );

require get_parent_theme_file_path( '/inc/customizer.php' );

require get_parent_theme_file_path( '/inc/dashboard/dashboard.php' );

require get_parent_theme_file_path( '/inc/typofont.php' );

require get_template_directory() . '/inc/wptt-webfont-loader.php';

// Customiser Sections Dropdown

function yoga_studio_contact_dropdown(){
	if(get_theme_mod('yoga_studio_contact_enable') == true ) {
		return true;
	}
	return false;
}
function yoga_studio_social_dropdown(){
	if(get_theme_mod('yoga_studio_social_enable') == true ) {
		return true;
	}
	return false;
}
function yoga_studio_slider_dropdown(){
	if(get_theme_mod('yoga_studio_slider_arrows') == true ) {
		return true;
	}
	return false;
}
function yoga_studio_service_dropdown(){
	if(get_theme_mod('yoga_studio_services_enable') == true ) {
		return true;
	}
	return false;
}
