<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * After setup theme hook
 */
function meditation_coach_theme_setup(){

    /*
     * Make child theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'meditation-coach', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'meditation_coach_theme_setup', 100 );

function meditation_coach_customize_script(){

    $my_theme = wp_get_theme();
    $version = $my_theme['Version'];
    wp_enqueue_script( 'meditation-coach-customize', get_stylesheet_directory_uri() . '/js/customize.js', array( 'jquery', 'customize-controls' ), $version, true );

}
add_action( 'customize_controls_enqueue_scripts', 'meditation_coach_customize_script' );

/**
 * Load assets.
 */
function meditation_coach_enqueue_styles() {

    $my_theme = wp_get_theme();
    $version = $my_theme['Version'];
    
    wp_enqueue_style( 'seva-lite', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'meditation-coach', get_stylesheet_directory_uri() . '/style.css', array( 'seva-lite' ), $version );

    wp_enqueue_script( 'meditation-coach', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), $version, true );

}
add_action( 'wp_enqueue_scripts', 'meditation_coach_enqueue_styles', 10 );

function meditation_coach_remove_parent_filters(){
    remove_action( 'customize_register', 'seva_lite_customize_register_appearance' );
    remove_action( 'wp_head', 'seva_lite_dynamic_css', 99 );
}
add_action( 'init', 'meditation_coach_remove_parent_filters' );

function meditation_coach_overide_values( $wp_customize ){
    if( seva_lite_is_wheel_of_life_activated() ) {
        $wp_customize->get_setting( 'wheeloflife_color' )->default = '#eff2f0';
    }
}
add_action( 'customize_register', 'meditation_coach_overide_values', 999 );

/**
 * Customizer Settings
 */
function meditation_coach_customizer_register( $wp_customize ){

    $wp_customize->add_section( 'theme_info', array(
        'title'       => __( 'Demo & Documentation' , 'meditation-coach' ),
        'priority'    => 6,
    ) );
    
    /** Important Links */
    $wp_customize->add_setting( 'theme_info_theme',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $theme_info = '<p>';
    $theme_info .= sprintf( __( 'Demo Link: %1$sClick here.%2$s', 'meditation-coach' ),  '<a href="' . esc_url( 'https://blossomthemes.com/theme-demo/?theme=meditation-coach' ) . '" target="_blank">', '</a>' );
    $theme_info .= '</p><p>';
    $theme_info .= sprintf( __( 'Documentation Link: %1$sClick here.%2$s', 'meditation-coach' ),  '<a href="' . esc_url( 'https://docs.blossomthemes.com/meditation-coach/' ) . '" target="_blank">', '</a>' );
    $theme_info .= '</p>';

    $wp_customize->add_control( new Seva_Lite_Note_Control( $wp_customize,
        'theme_info_theme', 
            array(
                'section'     => 'theme_info',
                'description' => $theme_info
            )
        )
    );

    /** Appearance Settings */
    $wp_customize->add_panel( 
        'appearance_settings', 
        array(
            'title'       => __( 'Appearance Settings', 'meditation-coach' ),
            'priority'    => 25,
            'capability'  => 'edit_theme_options',
            'description' => __( 'Change color and body background.', 'meditation-coach' ),
        ) 
    );

    /** Typography */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'    => __( 'Typography', 'meditation-coach' ),
            'priority' => 20,
            'panel'    => 'appearance_settings',
        )
    );
    
    /** Primary Font */
    $wp_customize->add_setting(
        'primary_font',
        array(
            'default'           => 'DM Sans',
            'sanitize_callback' => 'seva_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Seva_Lite_Select_Control(
            $wp_customize,
            'primary_font',
            array(
                'label'       => __( 'Primary Font', 'meditation-coach' ),
                'description' => __( 'Primary font of the site.', 'meditation-coach' ),
                'section'     => 'typography_settings',
                'choices'     => seva_lite_get_all_fonts(), 
            )
        )
    );
    
    /** Secondary Font */
    $wp_customize->add_setting(
        'secondary_font',
        array(
            'default'           => 'Zilla Slab',
            'sanitize_callback' => 'seva_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Seva_Lite_Select_Control(
            $wp_customize,
            'secondary_font',
            array(
                'label'       => __( 'Secondary Font', 'meditation-coach' ),
                'description' => __( 'Secondary font of the site.', 'meditation-coach' ),
                'section'     => 'typography_settings',
                'choices'     => seva_lite_get_all_fonts(), 
            )
        )
    );

    /** Font Size*/
    $wp_customize->add_setting( 
        'font_size', 
        array(
            'default'           => 18,
            'sanitize_callback' => 'seva_lite_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Slider_Control( 
            $wp_customize,
            'font_size',
            array(
                'section'     => 'typography_settings',
                'label'       => __( 'Font Size', 'meditation-coach' ),
                'description' => __( 'Change the font size of your site.', 'meditation-coach' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 50,
                    'step'  => 1,
                )                 
            )
        )
    );

    $wp_customize->add_setting(
        'ed_localgoogle_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_localgoogle_fonts',
            array(
                'section'       => 'typography_settings',
                'label'         => __( 'Load Google Fonts Locally', 'meditation-coach' ),
                'description'   => __( 'Enable to load google fonts from your own server instead from google\'s CDN. This solves privacy concerns with Google\'s CDN and their sometimes less-than-transparent policies.', 'meditation-coach' )
            )
        )
    );   

    $wp_customize->add_setting(
        'ed_preload_local_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_preload_local_fonts',
            array(
                'section'       => 'typography_settings',
                'label'         => __( 'Preload Local Fonts', 'meditation-coach' ),
                'description'   => __( 'Preloading Google fonts will speed up your website speed.', 'meditation-coach' ),
                'active_callback' => 'seva_lite_ed_localgoogle_fonts'
            )
        )
    );   

    ob_start(); ?>
        
        <span style="margin-bottom: 5px;display: block;"><?php esc_html_e( 'Click the button to reset the local fonts cache', 'meditation-coach' ); ?></span>
        
        <input type="button" class="button button-primary seva-lite-flush-local-fonts-button" name="seva-lite-flush-local-fonts-button" value="<?php esc_attr_e( 'Flush Local Font Files', 'meditation-coach' ); ?>" />
    <?php
    $meditation_coach_flush_button = ob_get_clean();

    $wp_customize->add_setting(
        'ed_flush_local_fonts',
        array(
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'ed_flush_local_fonts',
        array(
            'label'         => __( 'Flush Local Fonts Cache', 'meditation-coach' ),
            'section'       => 'typography_settings',
            'description'   => $meditation_coach_flush_button,
            'type'          => 'hidden',
            'active_callback' => 'seva_lite_ed_localgoogle_fonts'
        )
    );

    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'colors' )->panel              = 'appearance_settings';
    $wp_customize->get_section( 'colors' )->priority           = 10;
    $wp_customize->get_section( 'background_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority = 15;
    $wp_customize->get_setting( 'background_color' )->default  = '#ffffff';

    /** Adding panel for layouts */
    $wp_customize->add_panel( 
        'layout_settings',
         array(
            'priority'    => 35,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Layout Settings', 'meditation-coach' ),
            'description' => __( 'Customize Typography, Header Image & Background Image', 'meditation-coach' ),
        ) 
    );

    /** Move general layout section to Layout panel */
    $wp_customize->get_section( 'general_layout_settings' )->panel       = 'layout_settings';
    $wp_customize->get_section( 'general_layout_settings' )->title       = __( 'General Layout Settings', 'meditation-coach' );
    
    /** Header Layout Settings */
    $wp_customize->add_section(
        'header_layout_section',
        array(
            'priority'  => 5,
            'title'     => __( 'Header Layout', 'meditation-coach' ),
            'panel'     => 'layout_settings',
        )
    );

    $wp_customize->add_setting( 
        'header_layout', 
        array(
            'default'           => 'two',
            'sanitize_callback' => 'seva_lite_sanitize_radio'
        ) 
    );

    $wp_customize->add_control(
        new Seva_Lite_Radio_Image_Control(
            $wp_customize,
            'header_layout',
            array(
                'section'     => 'header_layout_section',
                'label'       => __( 'Header Layout', 'meditation-coach' ),
                'description' => __( 'Choose the layout of the header for your site.', 'meditation-coach' ),
                'choices'     => array(
					'one'   => get_stylesheet_directory_uri() . '/images/header/one.jpg',
                    'two' => get_stylesheet_directory_uri() . '/images/header/two.jpg',
                )
            )
        )
    );

    /** CTA Banner Layout Settings */
    $wp_customize->add_section(
        'banner_layout_section',
        array(
            'priority'  => 10,
            'title'     => __( 'CTA Banner Layout', 'meditation-coach' ),
            'panel'     => 'layout_settings',
        )
    );

    $wp_customize->add_setting( 
        'banner_layout', 
        array(
            'default'           => 'six',
            'sanitize_callback' => 'seva_lite_sanitize_radio'
        ) 
    );

    $wp_customize->add_control(
        new Seva_Lite_Radio_Image_Control(
            $wp_customize,
            'banner_layout',
            array(
                'section'     => 'banner_layout_section',
                'label'       => __( 'CTA Banner Layout', 'meditation-coach' ),
                'description' => __( 'Choose the layout for the slider for your site.', 'meditation-coach' ),
                'choices'     => array(
                    'six'   => get_stylesheet_directory_uri() . '/images/static_banner/cta_six.jpg',
                    'two'   => get_stylesheet_directory_uri() . '/images/static_banner/cta_two.jpg',
                )
            )
        )
    );

    $wp_customize->add_setting(
        'cta_static_banner_layout_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Note_Control( 
            $wp_customize,
            'cta_static_banner_layout_text',
            array(
                'section'     => 'banner_layout_section',
                'description' => sprintf( __( '%1$sClick here%2$s to configure static banner settings.', 'meditation-coach' ), '<span class="text-inner-link cta_static_banner_layout_text">', '</span>' ),
            )
        )
    );


    $wp_customize->add_setting(
        'cta_static_banner_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Note_Control( 
            $wp_customize,
            'cta_static_banner_text',
            array(
                'section'     => 'header_image',
                'description' => sprintf( __( '%1$sClick here%2$s to select the layout of static banner.', 'meditation-coach' ), '<span class="text-inner-link cta_static_banner_text">', '</span>' ),
                'active_callback' => 'meditation_coach_ac'
            )
        )
    );

    /** Enable Header Search */
    $wp_customize->add_setting( 
        'ed_header_search', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Seva_Lite_Toggle_Control( 
			$wp_customize,
			'ed_header_search',
			array(
				'section'     => 'header_settings',
				'label'	      => __( 'Enable Header Search', 'meditation-coach' ),
                'description' => __( 'Enable to show Search button in header.', 'meditation-coach' ),
                'active_callback' => 'meditation_coach_ac'
			)
		)
	);

    /** Shopping Cart */
    $wp_customize->add_setting( 
        'ed_shopping_cart', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_shopping_cart',
            array(
                'section'         => 'header_settings',
                'label'	          => __( 'Shopping Cart', 'meditation-coach' ),
                'description'     => __( 'Enable to show Shopping cart in the header.', 'meditation-coach' ),
                'active_callback' => 'seva_lite_is_woocommerce_activated'
            )
        )
    );

    $wp_customize->add_setting(
        'header_layout_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Note_Control( 
            $wp_customize,
            'header_layout_text',
            array(
                'section'     => 'header_layout_section',
                'description' => sprintf( __( '%1$sClick here%2$s to change header settings.', 'meditation-coach' ), '<span class="text-inner-link header_layout_text">', '</span>' ),
            )
        )
    ); 

    $wp_customize->add_setting(
        'header_setting_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Note_Control( 
            $wp_customize,
            'header_setting_text',
            array(
                'section'     => 'header_settings',
                'description' => sprintf( __( '%1$sClick here%2$s to change header layout.', 'meditation-coach' ), '<span class="text-inner-link header_setting_text">', '</span>' ),
            )
        )
    );
}
add_action( 'customize_register', 'meditation_coach_customizer_register', 40 );

function meditation_coach_ac( $control ){
    $banner        = $control->manager->get_setting( 'ed_banner_section' )->value();
    $header_layout = $control->manager->get_setting( 'header_layout' )->value();
    $control_id    = $control->id;

    if( $control_id == 'ed_header_search' && $header_layout != 'one' ) return true;
    if( $control_id == 'cta_static_banner_text' && $banner == 'static_banner' ) return true;

    return false;
}

/**
 * Form 
*/
function meditation_coach_header_search(){ ?>
    <div class="header-search">
        <button class="search-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="16.197" height="16.546" viewBox="0 0 16.197 16.546">
                <path id="icons8-search" d="M9.939,3a5.939,5.939,0,1,0,3.472,10.754l4.6,4.585.983-.983L14.448,12.8A5.939,5.939,0,0,0,9.939,3Zm0,.7A5.24,5.24,0,1,1,4.7,8.939,5.235,5.235,0,0,1,9.939,3.7Z" transform="translate(-3.5 -2.5)" fill="#222" stroke="#222" stroke-width="1" opacity="0.8"/>
            </svg>
        </button>
        <div class="header-search-wrap">
            <div class="header-search-inner">
                <?php get_search_form(); ?>
                <button class="close"><?php esc_html_e( 'Close', 'meditation-coach' ); ?></button>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Woocommerce Cart Count
 * 
 * @link https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header 
*/
function meditation_coach_wc_cart_count(){
    $cart_page = get_option( 'woocommerce_cart_page_id' );
    $count = WC()->cart->cart_contents_count; 
    if( $cart_page ){ ?>
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart" title="<?php esc_attr_e( 'View your shopping cart', 'meditation-coach' ); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
            <g id="shopping-cart_3_" data-name="shopping-cart (3)" opacity="0.8">
                <g id="shopping-cart">
                <path id="Path_4343" data-name="Path 4343" d="M4.5,12A1.5,1.5,0,1,0,6,13.5,1.5,1.5,0,0,0,4.5,12ZM0,0V1.5H1.5L4.2,7.2,3.15,9A2.665,2.665,0,0,0,3,9.75a1.5,1.5,0,0,0,1.5,1.5h9V9.75H4.8a.161.161,0,0,1-.15-.15V9.525L5.325,8.25h5.55A1.368,1.368,0,0,0,12.15,7.5l2.7-4.875A.413.413,0,0,0,15,2.25a.709.709,0,0,0-.75-.75H3.15L2.475,0ZM12,12a1.5,1.5,0,1,0,1.5,1.5A1.5,1.5,0,0,0,12,12Z" fill="#222"/>
                </g>
            </g>
        </svg> 
        <span class="number"><?php echo absint( $count ); ?></span>
    </a>
    <?php
    }
}

function seva_lite_mobile_navigation(){ 
    $ed_cart   = get_theme_mod( 'ed_shopping_cart', false );
    $ed_search = get_theme_mod( 'ed_header_search', false );
    ?>
    <div class="mobile-header">
        <div class="header-main">
            <div class="container">
                <div class="mob-nav-site-branding-wrap">
                    <div class="header-left">
                        <div class="toggle-btn-wrap">
                            <button class="toggle-btn">
                                <span class="toggle-bar"></span>
                                <span class="toggle-bar"></span>
                                <span class="toggle-bar"></span>
                            </button>
                        </div>          
                    </div>
                    <div class="header-center">
                        <?php seva_lite_site_branding(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom-slide">
            <div class="header-bottom-slide-inner">
                <div class="container">
                    <div class="mobile-header-wrap">
                        <?php if( seva_lite_social_links( false ) ){
                            echo '<div class="header-social">';
                            seva_lite_social_links();
                            echo '</div>';
                        } ?>
                        <?php if( $ed_search ) meditation_coach_header_search(); ?>
                        <?php if( seva_lite_is_woocommerce_activated() && $ed_cart ) {
                            echo '<div class="header-cart">';
                            meditation_coach_wc_cart_count();
                            echo '</div>';
                        } ?>
                        <button class="close"></button>
                    </div>
                    <div class="mobile-header-wrapper">
                        <div class="header-left">
                            <?php seva_lite_primary_navigation(); ?>
                        </div>
                        <div class="header-right">
                            <?php seva_lite_secondary_navigation(); ?>
                        </div>
                    </div>
                    <div class="mob-ctc-btn"> 
                        <?php seva_lite_header_contact(); ?>                   
                        <?php seva_lite_contact_button(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php   
}

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 * 
 * @link https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header
 */
function meditation_coach_add_to_cart_fragment( $fragments ){
    ob_start();
    $count = WC()->cart->cart_contents_count; ?>
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart" title="<?php esc_attr_e( 'View your shopping cart', 'meditation-coach' ); ?>">
        <i class="fas fa-shopping-cart"></i>
        <span class="number"><?php echo absint( $count ); ?></span>
    </a>
    <?php
 
    $fragments['a.cart'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'meditation_coach_add_to_cart_fragment' );

if( ! function_exists( 'seva_lite_header_search' ) ) :
/**
 * Form 
*/
function seva_lite_header_search(){ ?>
    <div class="header-search">
        <button class="search-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="16.197" height="16.546" viewBox="0 0 16.197 16.546">
                <path id="icons8-search" d="M9.939,3a5.939,5.939,0,1,0,3.472,10.754l4.6,4.585.983-.983L14.448,12.8A5.939,5.939,0,0,0,9.939,3Zm0,.7A5.24,5.24,0,1,1,4.7,8.939,5.235,5.235,0,0,1,9.939,3.7Z" transform="translate(-3.5 -2.5)" fill="#222" stroke="#222" stroke-width="1" opacity="0.8"/>
            </svg>
        </button>
        <div class="header-search-wrap">
            <div class="header-search-inner">
                <?php get_search_form(); ?>
                <button class="close"><?php esc_html_e( 'Close', 'meditation-coach' ); ?></button>
            </div>
        </div>
    </div>
    <?php
}
endif;


/**
 * Header Start
*/
function seva_lite_header(){ 

    $header_array = array( 'one', 'two' );
    $header = get_theme_mod( 'header_layout', 'two' );
    if( in_array( $header, $header_array ) ){            
        get_template_part( 'headers/' . $header );
    }
}

/**
 * Footer Bottom
*/
function seva_lite_footer_bottom(){ 
    ?>
    <div class="footer-bottom">
        <div class="container">
            <div class="site-info">            
            <?php
                seva_lite_get_footer_copyright();
                echo esc_html__( ' Meditation Coach | Developed By ', 'meditation-coach' ); 
                echo '<a href="' . esc_url( 'https://blossomthemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Blossom Themes', 'meditation-coach' ) . '</a>.';                
                printf( esc_html__( ' Powered by %s. ', 'meditation-coach' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'meditation-coach' ) ) .'" target="_blank">WordPress</a>' );
                if( function_exists( 'the_privacy_policy_link' ) ){
                    the_privacy_policy_link();
                }
            ?>               
            </div>
            <?php if( seva_lite_social_links( false ) ) : ?>
                <div class="footer-social-network">
                    <?php seva_lite_social_links(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

function seva_lite_fonts_url(){
    $fonts_url = '';
    
    $primary_font       = get_theme_mod( 'primary_font', 'DM Sans' );
    $ig_primary_font    = seva_lite_is_google_font( $primary_font );    
    $secondary_font     = get_theme_mod( 'secondary_font', 'Zilla Slab' );
    $ig_secondary_font  = seva_lite_is_google_font( $secondary_font );    
    $site_title_font    = get_theme_mod( 'site_title_font', array( 'font-family'=> 'DM Sans', 'variant'=>'regular' ) );
    $ig_site_title_font = seva_lite_is_google_font( $site_title_font['font-family'] );
        
    /* Translators: If there are characters in your language that are not
    * supported by respective fonts, translate this to 'off'. Do not translate
    * into your own language.
    */
    $primary    = _x( 'on', 'Primary Font: on or off', 'meditation-coach' );
    $secondary  = _x( 'on', 'Secondary Font: on or off', 'meditation-coach' );
    $site_title = _x( 'on', 'Site Title Font: on or off', 'meditation-coach' );
    
    
    if ( 'off' !== $primary || 'off' !== $secondary || 'off' !== $site_title ) {
        
        $font_families = array();
     
        if ( 'off' !== $primary && $ig_primary_font ) {
            $primary_variant = seva_lite_check_varient( $primary_font, 'regular', true );
            if( $primary_variant ){
                $primary_var = ':' . $primary_variant;
            }else{
                $primary_var = '';    
            }            
            $font_families[] = $primary_font . $primary_var;
        }
         
        if ( 'off' !== $secondary && $ig_secondary_font ) {
            $secondary_variant = seva_lite_check_varient( $secondary_font, 'regular', true );
            if( $secondary_variant ){
                $secondary_var = ':' . $secondary_variant;    
            }else{
                $secondary_var = '';
            }
            $font_families[] = $secondary_font . $secondary_var;
        }
        
        if ( 'off' !== $site_title && $ig_site_title_font ) {
            
            if( ! empty( $site_title_font['variant'] ) ){
                $site_title_var = ':' . seva_lite_check_varient( $site_title_font['font-family'], $site_title_font['variant'] );    
            }else{
                $site_title_var = '';
            }
            $font_families[] = $site_title_font['font-family'] . $site_title_var;
        }
        
        $font_families = array_diff( array_unique( $font_families ), array('') );
        
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),            
        );
        
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    if( get_theme_mod( 'ed_localgoogle_fonts', false ) ) {
        $fonts_url = seva_lite_get_webfont_url( add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ) );
    }

    return esc_url( $fonts_url );
}

/*
Dynamic CSS
*/
function meditation_coach_dynamic_css(){
    
    $primary_font    = get_theme_mod( 'primary_font', 'DM Sans' );
    $primary_fonts   = seva_lite_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Zilla Slab' );
    $secondary_fonts = seva_lite_get_fonts( $secondary_font, 'regular' );
    $font_size       = get_theme_mod( 'font_size', 18 );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'DM Sans', 'variant'=>'regular' ) );
    $site_title_fonts     = seva_lite_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 30 );
    
    $primary_color    = '#5e7e6e';
    $secondary_color  = '#ca9470';
    $logo_width       = get_theme_mod( 'logo_width', 150 );
    $background_color = get_theme_mod( 'background_color', '#ffffff' );

    $tc_font_size = get_theme_mod( 'testimonial_content_font_size', 20 );

    $rgb = seva_lite_hex2rgb( seva_lite_sanitize_hex_color( $primary_color ) );
    $rgb2 = seva_lite_hex2rgb( seva_lite_sanitize_hex_color( $secondary_color ) ); 
    $rgb4 = seva_lite_hex2rgb( seva_lite_sanitize_hex_color( $background_color ) );

    $about_bg   = get_theme_mod( 'about_bg_image', get_template_directory_uri() . '/images/about-bg-img.png' );
    $contact_bg = get_theme_mod( 'contact_bg_image' );

    $wheeloflife_color = get_theme_mod( 'wheeloflife_color', '#eff2f0' );
     
    echo "<style type='text/css' media='all'>"; ?>
    
    :root {
        --primary-color: <?php echo seva_lite_sanitize_hex_color( $primary_color ); ?>;
		--primary-color-rgb: <?php printf( '%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ); ?>;
        --secondary-color: <?php echo seva_lite_sanitize_hex_color( $secondary_color ); ?>;
        --secondary-color-rgb: <?php printf( '%1$s, %2$s, %3$s', $rgb2[0], $rgb2[1], $rgb2[2] ); ?>;
        --global-body-font: <?php echo esc_html( $primary_fonts['font'] ); ?>;
        --global-heading-font: <?php echo esc_html( $secondary_fonts['font'] ); ?>;
        --background-color: <?php echo seva_lite_sanitize_hex_color( $background_color ); ?>;
        --background-color-rgb: <?php printf( '%1$s, %2$s, %3$s', $rgb4[0], $rgb4[1], $rgb4[2] ); ?>;
	}

    body{
        font-size: <?php echo absint( $font_size ); ?>px;
    }
    
    <?php 

    if( $about_bg ){ ?>
        .about-section .bg-graphic::before {
            background-image: url("<?php echo esc_url( $about_bg ); ?>");
        }
        <?php 
    }

    if( $contact_bg ){ ?>
        .contact-section .section-grid .widget:last-child::after {
            background-image: url("<?php echo esc_url( $contact_bg ); ?>");
        }
        <?php 
    } 
    ?>
    
    section#wheeloflife_section {
        background-color: <?php echo seva_lite_sanitize_hex_color( $wheeloflife_color ); ?>;
    }

    .site-title{    
        font-size   : <?php echo absint( $site_title_font_size ); ?>px;
        font-family : <?php echo esc_html( $site_title_fonts['font'] ); ?>;
        font-weight : <?php echo esc_html( $site_title_fonts['weight'] ); ?>;
        font-style  : <?php echo esc_html( $site_title_fonts['style'] ); ?>;        
    }
    
	.custom-logo-link img{
        width    : <?php echo absint( $logo_width ); ?>px;
        max-width: 100%;
    }

    .testimonial-section .testimonial-inner-wrapper .bttk-testimonial-inner-holder .testimonial-content{
        font-size: <?php echo absint( $tc_font_size ); ?>px;
    }

    .owl-nav button.owl-prev {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" width="32.309" height="20.164" viewBox="0 0 32.309 20.164"><g id="Group_1442" data-name="Group 1442" transform="translate(-111.801 -7500.775)"><path id="Path_1" data-name="Path 1" d="M1092.416,244.108h-30.082" transform="translate(-949.306 7266.763)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="2"/><path id="Path_2" data-name="Path 2" d="M1096.586,226.065c-1,3.743-2.41,7.2-9.671,8.868" transform="translate(-973.915 7275.936)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="2"/><path id="Path_3" data-name="Path 3" d="M1096.586,234.933c-1-3.743-2.41-7.2-9.671-8.868" transform="translate(-973.915 7284.782)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="2"/></g></svg>') !important;
    }

    .owl-nav button.owl-next {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" width="32.309" height="20.165" viewBox="0 0 32.309 20.165"><g id="Group_1441" data-name="Group 1441" transform="translate(-169.747 -7500.775)"><path id="Path_1" data-name="Path 1" d="M1062.334,244.108h30.082" transform="translate(-891.588 7266.763)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="2"/><path id="Path_2" data-name="Path 2" d="M1086.915,226.065c1,3.743,2.41,7.2,9.671,8.868" transform="translate(-895.73 7275.936)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="2"/><path id="Path_3" data-name="Path 3" d="M1086.915,234.933c1-3.743,2.41-7.2,9.671-8.868" transform="translate(-895.73 7284.782)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="2"/></g></svg>') !important;
    }
    
    .btn-readmore::after, .btn-readmore:visited::after {
        background-image: url('data:image/svg+xml; uft-8, <svg xmlns="http://www.w3.org/2000/svg" width="21.956" height="13.496" viewBox="0 0 21.956 13.496"><g id="Group_1417" data-name="Group 1417" transform="translate(-721 -3593.056)"><path id="Path_1" data-name="Path 1" d="M1062.334,244.108h20.837" transform="translate(-340.835 3355.706)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/><path id="Path_2" data-name="Path 2" d="M1086.915,226.065c.695,2.593,1.669,4.985,6.7,6.143" transform="translate(-351.258 3367.603)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/><path id="Path_3" data-name="Path 3" d="M1086.915,232.208c.695-2.593,1.669-4.985,6.7-6.143" transform="translate(-351.258 3373.731)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/></g></svg>');
    }
    
    .btn-readmore:hover::after, .btn-readmore:visited:hover::after {
        background-image: url('data:image/svg+xml; uft-8, <svg xmlns="http://www.w3.org/2000/svg" width="21.956" height="13.496" viewBox="0 0 21.956 13.496"><g id="Group_1417" data-name="Group 1417" transform="translate(-721 -3593.056)"><path id="Path_1" data-name="Path 1" d="M1062.334,244.108h20.837" transform="translate(-340.835 3355.706)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $secondary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/><path id="Path_2" data-name="Path 2" d="M1086.915,226.065c.695,2.593,1.669,4.985,6.7,6.143" transform="translate(-351.258 3367.603)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $secondary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/><path id="Path_3" data-name="Path 3" d="M1086.915,232.208c.695-2.593,1.669-4.985,6.7-6.143" transform="translate(-351.258 3373.731)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $secondary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/></g></svg>');
    }

    .cta-section-two .widget_blossomtheme_companion_cta_widget .centered .blossomtheme-cta-container .button-wrap::before, .cta-section-two .widget_blossomtheme_companion_cta_widget .left .blossomtheme-cta-container .button-wrap::before, .cta-section-two .widget_blossomtheme_companion_cta_widget .right .blossomtheme-cta-container .button-wrap::before, .cta-section-two .widget_blossomtheme_companion_cta_widget .bttk-cta-bg .blossomtheme-cta-container .button-wrap::before {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" width="164.571" height="31.596" viewBox="0 0 164.571 31.596"><g id="Group_4384" data-name="Group 4384" transform="translate(-1006.431 -9374.817) rotate(-1)"><path id="Path_2" data-name="Path 2" d="M0,0C1.065,3.973,2.558,7.638,10.264,9.411" transform="translate(996.156 9402.237) rotate(26)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="2"/><path id="Path_3" data-name="Path 3" d="M0,9.411C1.065,5.439,2.558,1.773,10.264,0" transform="translate(992.039 9410.677) rotate(26)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="2"/><path id="Path_23545" data-name="Path 23545" d="M7120.348,9406.9c32.079-16.261,86.3-31.426,155.039,1.042" transform="translate(-6276.387 5.928)" fill="none" stroke="<?php echo seva_lite_hash_to_percent23( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="2"/></g></svg>');
    }

    <?php echo "</style>";
}
add_action( 'wp_head', 'meditation_coach_dynamic_css', 99 );

function seva_lite_dynamic_mce_css_ajax_callback(){
 
    /* Check nonce for security */
    $nonce = isset( $_REQUEST['_nonce'] ) ? $_REQUEST['_nonce'] : '';
    if( ! wp_verify_nonce( $nonce, 'seva_lite_dynamic_mce_nonce' ) ){
        die(); // don't print anything
    }
 
    /* Get Link Color */
    $primary_font    = get_theme_mod( 'primary_font', 'DM Sans' );
    $primary_fonts   = seva_lite_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Zilla Slab' );
    $secondary_fonts = seva_lite_get_fonts( $secondary_font, 'regular' );

    $background_color = get_theme_mod( 'background_color','#ffffff' );
    $rgb4 = seva_lite_hex2rgb( seva_lite_sanitize_hex_color( $background_color ) );
 
    /* Set File Type and Print the CSS Declaration */
    header( 'Content-type: text/css' );
    echo ':root .mce-content-body {
        --primary-font: ' . esc_html( $primary_fonts['font'] ) . ';
        --secondary-font: ' . esc_html( $secondary_fonts['font'] ) . ';
        --background-color: ' . seva_lite_sanitize_hex_color( $background_color ) . ';
        --background-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb4[0], $rgb4[1], $rgb4[2] ) . ';
    }';
    die(); // end ajax process.
}

function seva_lite_gutenberg_inline_style(){
 
    /* Get Link Color */
    $primary_font    = get_theme_mod( 'primary_font', 'DM Sans' );
    $primary_fonts   = seva_lite_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Zilla Slab' );
    $secondary_fonts = seva_lite_get_fonts( $secondary_font, 'regular' );

    $primary_color    = '#5e7e6e';
    $secondary_color  = '#ca9470';
    $rgb = seva_lite_hex2rgb( seva_lite_sanitize_hex_color( $primary_color ) );
    $rgb2 = seva_lite_hex2rgb( seva_lite_sanitize_hex_color( $secondary_color ) ); 

    $background_color = get_theme_mod( 'background_color','#ffffff' );
    $rgb4 = seva_lite_hex2rgb( seva_lite_sanitize_hex_color( $background_color ) );
 
    $custom_css = ':root .block-editor-page {
        --primary-font: ' . esc_html( $primary_fonts['font'] ) . ';
        --secondary-font: ' . esc_html( $secondary_fonts['font'] ) . ';
        --background-color: ' . seva_lite_sanitize_hex_color( $background_color ) . ';
        --background-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb4[0], $rgb4[1], $rgb4[2] ) . ';
        --primary-color: ' . seva_lite_sanitize_hex_color( $primary_color ) . ';
        --primary-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ) . ';
        --secondary-color: ' . seva_lite_sanitize_hex_color( $secondary_color ) . ';
        --secondary-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb2[0], $rgb2[1], $rgb2[2] ) . ';
    }';

    return $custom_css;
}