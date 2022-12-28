<?php
/**
 * Yoga Studio: Customizer
 *
 * @subpackage Yoga Studio
 * @since 1.0
 */

function yoga_studio_customize_register( $wp_customize ) {

	wp_enqueue_style('customizercustom_css', esc_url( get_template_directory_uri() ). '/assets/css/customizer.css');

	// Add custom control.
  	require get_parent_theme_file_path( 'inc/customize/customize_toggle.php' );

	// Register the custom control type.
	$wp_customize->register_control_type( 'Yoga_Studio_Toggle_Control' );

	$wp_customize->add_section( 'yoga_studio_typography_settings', array(
		'title'       => __( 'Typography', 'yoga-studio' ),
		'priority'       => 24,
	) );

	$yoga_studio_font_choices = array(
		'' => 'Select',
		'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
		'Open Sans:400italic,700italic,400,700' => 'Open Sans',
		'Oswald:400,700' => 'Oswald',
		'Playfair Display:400,700,400italic' => 'Playfair Display',
		'Montserrat:400,700' => 'Montserrat',
		'Raleway:400,700' => 'Raleway',
		'Droid Sans:400,700' => 'Droid Sans',
		'Lato:400,700,400italic,700italic' => 'Lato',
		'Arvo:400,700,400italic,700italic' => 'Arvo',
		'Lora:400,700,400italic,700italic' => 'Lora',
		'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
		'Oxygen:400,300,700' => 'Oxygen',
		'PT Serif:400,700' => 'PT Serif',
		'PT Sans:400,700,400italic,700italic' => 'PT Sans',
		'PT Sans Narrow:400,700' => 'PT Sans Narrow',
		'Cabin:400,700,400italic' => 'Cabin',
		'Fjalla One:400' => 'Fjalla One',
		'Francois One:400' => 'Francois One',
		'Josefin Sans:400,300,600,700' => 'Josefin Sans',
		'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
		'Arimo:400,700,400italic,700italic' => 'Arimo',
		'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
		'Bitter:400,700,400italic' => 'Bitter',
		'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
		'Roboto:400,400italic,700,700italic' => 'Roboto',
		'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
		'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
		'Roboto Slab:400,700' => 'Roboto Slab',
		'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
		'Rokkitt:400' => 'Rokkitt',
	);

	$wp_customize->add_setting( 'yoga_studio_headings_text', array(
		'sanitize_callback' => 'yoga_studio_sanitize_fonts',
	));
	$wp_customize->add_control( 'yoga_studio_headings_text', array(
		'type' => 'select',
		'description' => __('Select your suitable font for the headings.', 'yoga-studio'),
		'section' => 'yoga_studio_typography_settings',
		'choices' => $yoga_studio_font_choices
	));

	$wp_customize->add_setting( 'yoga_studio_body_text', array(
		'sanitize_callback' => 'yoga_studio_sanitize_fonts'
	));
	$wp_customize->add_control( 'yoga_studio_body_text', array(
		'type' => 'select',
		'description' => __( 'Select your suitable font for the body.', 'yoga-studio' ),
		'section' => 'yoga_studio_typography_settings',
		'choices' => $yoga_studio_font_choices
	) );

 	$wp_customize->add_section('yoga_studio_pro', array(
        'title'    => __('UPGRADE YOGA STUDIO PREMIUM', 'yoga-studio'),
        'priority' => 1,
    ));

    $wp_customize->add_setting('yoga_studio_pro', array(
        'default'           => null,
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new Yoga_Studio_Pro_Control($wp_customize, 'yoga_studio_pro', array(
        'label'    => __('YOGA STUDIO PREMIUM', 'yoga-studio'),
        'section'  => 'yoga_studio_pro',
        'settings' => 'yoga_studio_pro',
        'priority' => 1,
    )));

    //Logo
    $wp_customize->add_setting('yoga_studio_logo_max_height',array(
		'default'	=> '',
		'sanitize_callback'	=> 'yoga_studio_sanitize_number_absint'
	));
	$wp_customize->add_control('yoga_studio_logo_max_height',array(
		'label'	=> esc_html__('Logo Width','yoga-studio'),
		'section'	=> 'title_tagline',
		'type'		=> 'number'
	));
    $wp_customize->add_setting( 'yoga_studio_logo_title', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_logo_title', array(
		'label'       => esc_html__( 'Show Site Title', 'yoga-studio' ),
		'section'     => 'title_tagline',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_logo_title',
	) ) );

    $wp_customize->add_setting( 'yoga_studio_logo_text', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_logo_text', array(
		'label'       => esc_html__( 'Show Site Tagline', 'yoga-studio' ),
		'section'     => 'title_tagline',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_logo_text',
	) ) );

    // Theme General Settings
    $wp_customize->add_section('yoga_studio_theme_settings',array(
        'title' => __('Theme General Settings', 'yoga-studio'),
        'priority' => 1,
    ) );

    $wp_customize->add_setting( 'yoga_studio_sticky_header', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_sticky_header', array(
		'label'       => esc_html__( 'Show Sticky Header', 'yoga-studio' ),
		'section'     => 'yoga_studio_theme_settings',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_sticky_header',
	) ) );

    $wp_customize->add_setting( 'yoga_studio_theme_loader', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_theme_loader', array(
		'label'       => esc_html__( 'Show Site Loader', 'yoga-studio' ),
		'section'     => 'yoga_studio_theme_settings',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_theme_loader',
	) ) );

	$wp_customize->add_setting( 'yoga_studio_scroll_enable', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_scroll_enable', array(
		'label'       => esc_html__( 'Show Scroll Top', 'yoga-studio' ),
		'section'     => 'yoga_studio_theme_settings',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_scroll_enable',
	) ) );

	$wp_customize->add_setting('yoga_studio_scroll_options',array(
        'default' => 'right_align',
        'sanitize_callback' => 'yoga_studio_sanitize_choices'
	));
	$wp_customize->add_control('yoga_studio_scroll_options',array(
        'type' => 'select',
        'label' => __('Scroll Top Alignment','yoga-studio'),
        'section' => 'yoga_studio_theme_settings',
        'choices' => array(
            'right_align' => __('Right Align','yoga-studio'),
            'center_align' => __('Center Align','yoga-studio'),
            'left_align' => __('Left Align','yoga-studio'),
        ),
	) );

	$wp_customize->add_setting( 'yoga_studio_shop_page_sidebar', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_shop_page_sidebar', array(
		'label'       => esc_html__( 'Show Shop Page Sidebar', 'yoga-studio' ),
		'section'     => 'yoga_studio_theme_settings',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_shop_page_sidebar',
	) ) );

	$wp_customize->add_setting( 'yoga_studio_wocommerce_single_page_sidebar', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_wocommerce_single_page_sidebar', array(
		'label'       => esc_html__( 'Show Single Shop Page Sidebar', 'yoga-studio' ),
		'section'     => 'yoga_studio_theme_settings',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_wocommerce_single_page_sidebar',
	) ) );

	// Theme Width
	$wp_customize->add_section('yoga_studio_theme_width_settings',array(
        'title' => __('Theme Width Option', 'yoga-studio'),
    ) );

	$wp_customize->add_setting('yoga_studio_width_options',array(
        'default' => 'full_width',
        'sanitize_callback' => 'yoga_studio_sanitize_choices'
	));
	$wp_customize->add_control('yoga_studio_width_options',array(
        'type' => 'select',
        'label' => __('Theme Width Option','yoga-studio'),
        'section' => 'yoga_studio_theme_width_settings',
        'choices' => array(
            'full_width' => __('fullwidth','yoga-studio'),
            'container' => __('container','yoga-studio'),
            'container_fluid' => __('container fluid','yoga-studio'),
        ),
	) );

	// Post Layouts
    $wp_customize->add_section('yoga_studio_layout',array(
        'title' => __('Post Layout', 'yoga-studio'),
        'description' => __( 'Change the post layout from below options', 'yoga-studio' ),
        'priority' => 1
    ) );

	$wp_customize->add_setting( 'yoga_studio_post_sidebar', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_post_sidebar', array(
		'label'       => esc_html__( 'Show Fullwidth', 'yoga-studio' ),
		'section'     => 'yoga_studio_layout',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_post_sidebar',
	) ) );

	$wp_customize->add_setting( 'yoga_studio_single_post_sidebar', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_single_post_sidebar', array(
		'label'       => esc_html__( 'Show Single Post Fullwidth', 'yoga-studio' ),
		'section'     => 'yoga_studio_layout',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_single_post_sidebar',
	) ) );

    $wp_customize->add_setting('yoga_studio_post_option',array(
		'default' => 'simple_post',
		'sanitize_callback' => 'yoga_studio_sanitize_select'
	));
	$wp_customize->add_control('yoga_studio_post_option',array(
		'label' => esc_html__('Select Layout','yoga-studio'),
		'section' => 'yoga_studio_layout',
		'setting' => 'yoga_studio_post_option',
		'type' => 'radio',
        'choices' => array(
            'simple_post' => __('Simple Post','yoga-studio'),
            'grid_post' => __('Grid Post','yoga-studio'),
        ),
	));

    $wp_customize->add_setting('yoga_studio_grid_column',array(
		'default' => '3_column',
		'sanitize_callback' => 'yoga_studio_sanitize_select'
	));
	$wp_customize->add_control('yoga_studio_grid_column',array(
		'label' => esc_html__('Grid Post Per Row','yoga-studio'),
		'section' => 'yoga_studio_layout',
		'setting' => 'yoga_studio_grid_column',
		'type' => 'radio',
        'choices' => array(
            '1_column' => __('1','yoga-studio'),
            '2_column' => __('2','yoga-studio'),
            '3_column' => __('3','yoga-studio'),
            '4_column' => __('4','yoga-studio'),
            '5_column' => __('6','yoga-studio'),
        ),
	));

	$wp_customize->add_setting( 'yoga_studio_date', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_date', array(
		'label'       => esc_html__( 'Hide Date', 'yoga-studio' ),
		'section'     => 'yoga_studio_layout',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_date',
	) ) );

	$wp_customize->add_setting( 'yoga_studio_admin', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_admin', array(
		'label'       => esc_html__( 'Hide Author/Admin', 'yoga-studio' ),
		'section'     => 'yoga_studio_layout',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_admin',
	) ) );

	$wp_customize->add_setting( 'yoga_studio_comment', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_comment', array(
		'label'       => esc_html__( 'Hide Comment', 'yoga-studio' ),
		'section'     => 'yoga_studio_layout',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_comment',
	) ) );

	// Top Header
    $wp_customize->add_section('yoga_studio_top',array(
        'title' => __('Contact info', 'yoga-studio'),
        'description' => __( 'Add contact info in the below feilds', 'yoga-studio' ),
        'priority' => 1
    ) );

    $wp_customize->add_setting( 'yoga_studio_contact_enable', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_contact_enable', array(
		'label'       => esc_html__( 'Check to show contact details', 'yoga-studio' ),
		'section'     => 'yoga_studio_top',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_contact_enable',
	) ) );

    $wp_customize->add_setting('yoga_studio_top_text',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('yoga_studio_top_text',array(
		'label' => esc_html__('Add Text','yoga-studio'),
		'section' => 'yoga_studio_top',
		'setting' => 'yoga_studio_top_text',
		'type'    => 'text',
		'active_callback' => 'yoga_studio_contact_dropdown'
	));

	$wp_customize->add_setting('yoga_studio_phone',array(
		'default' => '',
		'sanitize_callback' => 'yoga_studio_sanitize_phone_number'
	));
	$wp_customize->add_control('yoga_studio_phone',array(
		'label' => esc_html__('Add Phone Number','yoga-studio'),
		'section' => 'yoga_studio_top',
		'setting' => 'yoga_studio_phone',
		'type'    => 'text',
		'active_callback' => 'yoga_studio_contact_dropdown'
	));

	$wp_customize->add_setting('yoga_studio_address',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('yoga_studio_address',array(
		'label' => esc_html__('Add Address','yoga-studio'),
		'section' => 'yoga_studio_top',
		'setting' => 'yoga_studio_address',
		'type'    => 'text',
		'active_callback' => 'yoga_studio_contact_dropdown'
	));

	$wp_customize->add_setting('yoga_studio_button_text',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('yoga_studio_button_text',array(
		'label' => esc_html__('Add Button Text','yoga-studio'),
		'section' => 'yoga_studio_top',
		'setting' => 'yoga_studio_button_text',
		'type'    => 'text',
		'active_callback' => 'yoga_studio_contact_dropdown'
	));

	$wp_customize->add_setting('yoga_studio_button_link',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('yoga_studio_button_link',array(
		'label' => esc_html__('Add Button URL','yoga-studio'),
		'section' => 'yoga_studio_top',
		'setting' => 'yoga_studio_button_link',
		'type'    => 'url',
		'active_callback' => 'yoga_studio_contact_dropdown'
	));

	// Social Media
    $wp_customize->add_section('yoga_studio_urls',array(
        'title' => __('Social Media', 'yoga-studio'),
        'description' => __( 'Add social media links in the below feilds', 'yoga-studio' ),
        'priority' => 2
    ) );

    $wp_customize->add_setting( 'yoga_studio_social_enable', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_social_enable', array(
		'label'       => esc_html__( 'Check to show social links', 'yoga-studio' ),
		'section'     => 'yoga_studio_urls',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_social_enable',
	) ) );

    $wp_customize->add_setting('yoga_studio_linkdin',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('yoga_studio_linkdin',array(
		'label' => esc_html__('Linkdin URL','yoga-studio'),
		'section' => 'yoga_studio_urls',
		'setting' => 'yoga_studio_linkdin',
		'type'    => 'url',
		'active_callback' => 'yoga_studio_social_dropdown'
	));

	$wp_customize->add_setting('yoga_studio_instagram',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('yoga_studio_instagram',array(
		'label' => esc_html__('Instagram URL','yoga-studio'),
		'section' => 'yoga_studio_urls',
		'setting' => 'yoga_studio_instagram',
		'type'    => 'url',
		'active_callback' => 'yoga_studio_social_dropdown'
	));

	$wp_customize->add_setting('yoga_studio_facebook',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('yoga_studio_facebook',array(
		'label' => esc_html__('Facebook URL','yoga-studio'),
		'section' => 'yoga_studio_urls',
		'setting' => 'yoga_studio_facebook',
		'type'    => 'url',
		'active_callback' => 'yoga_studio_social_dropdown'
	));

    $wp_customize->add_setting('yoga_studio_pintrest',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('yoga_studio_pintrest',array(
		'label' => esc_html__('Pintrest URL','yoga-studio'),
		'section' => 'yoga_studio_urls',
		'setting' => 'yoga_studio_pintrest',
		'type'    => 'url',
		'active_callback' => 'yoga_studio_social_dropdown'
	));

	$wp_customize->add_setting('yoga_studio_youtube',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('yoga_studio_youtube',array(
		'label' => esc_html__('Youtube URL','yoga-studio'),
		'section' => 'yoga_studio_urls',
		'setting' => 'yoga_studio_youtube',
		'type'    => 'url',
		'active_callback' => 'yoga_studio_social_dropdown'
	));

    //Slider
	$wp_customize->add_section( 'yoga_studio_slider_section' , array(
    	'title'      => __( 'Slider Settings', 'yoga-studio' ),
    	'description' => __('Slider Image Dimension ( 600px x 700px )','yoga-studio'),
		'priority'   => 3,
	) );

    $wp_customize->add_setting( 'yoga_studio_slider_arrows', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_slider_arrows', array(
		'label'       => esc_html__( 'Check to show slider', 'yoga-studio' ),
		'section'     => 'yoga_studio_slider_section',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_slider_arrows',
	) ) );

	$args = array('numberposts' => -1);
	$post_list = get_posts($args);
	$i = 0;
	$pst_sls[]= __('Select','yoga-studio');
	foreach ($post_list as $key => $p_post) {
		$pst_sls[$p_post->ID]=$p_post->post_title;
	}
	for ( $i = 1; $i <= 4; $i++ ) {
		$wp_customize->add_setting('yoga_studio_post_setting'.$i,array(
			'sanitize_callback' => 'yoga_studio_sanitize_select',
		));
		$wp_customize->add_control('yoga_studio_post_setting'.$i,array(
			'type'    => 'select',
			'choices' => $pst_sls,
			'label' => __('Select post','yoga-studio'),
			'section' => 'yoga_studio_slider_section',
			'active_callback' => 'yoga_studio_slider_dropdown'
		));
	}
	wp_reset_postdata();

	// Services Section
	$wp_customize->add_section( 'yoga_studio_service_box_section' , array(
    	'title'      => __( 'Services Settings', 'yoga-studio' ),
		'priority'   => 4,
	) );

	$wp_customize->add_setting( 'yoga_studio_services_enable', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'yoga_studio_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Yoga_Studio_Toggle_Control( $wp_customize, 'yoga_studio_services_enable', array(
		'label'       => esc_html__( 'Check to show services', 'yoga-studio' ),
		'section'     => 'yoga_studio_service_box_section',
		'type'        => 'toggle',
		'settings'    => 'yoga_studio_services_enable',
	) ) );

	$wp_customize->add_setting('yoga_studio_services_section_title',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('yoga_studio_services_section_title',array(
		'label' => esc_html__('Section Title','yoga-studio'),
		'section' => 'yoga_studio_service_box_section',
		'setting' => 'yoga_studio_services_section_title',
		'type'    => 'text',
		'active_callback' => 'yoga_studio_service_dropdown'
	));

	$wp_customize->add_setting('yoga_studio_services_section_text',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('yoga_studio_services_section_text',array(
		'label' => esc_html__('Section Text','yoga-studio'),
		'section' => 'yoga_studio_service_box_section',
		'setting' => 'yoga_studio_services_section_text',
		'type'    => 'text',
		'active_callback' => 'yoga_studio_service_dropdown'
	));

	$yoga_studio_categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= 'select';
	foreach($yoga_studio_categories as $category){
	if($i==0){
	  $default = $category->slug;
	  $i++;
	}
	$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('yoga_studio_category_setting',array(
		'default' => 'select',
		'sanitize_callback' => 'yoga_studio_sanitize_select',
	));
	$wp_customize->add_control('yoga_studio_category_setting',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => esc_html__('Select Category to display Post','yoga-studio'),
		'section' => 'yoga_studio_service_box_section',
		'active_callback' => 'yoga_studio_service_dropdown'
	));

	//Footer
    $wp_customize->add_section( 'yoga_studio_footer_copyright', array(
    	'title'      => esc_html__( 'Footer Text', 'yoga-studio' ),
    	'priority' => 5
	) );

    $wp_customize->add_setting('yoga_studio_footer_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('yoga_studio_footer_text',array(
		'label'	=> esc_html__('Copyright Text','yoga-studio'),
		'section'	=> 'yoga_studio_footer_copyright',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('yoga_studio_footer_widget',array(
		'default' => '4',
		'sanitize_callback' => 'yoga_studio_sanitize_select'
	));
	$wp_customize->add_control('yoga_studio_footer_widget',array(
		'label' => esc_html__('Footer Per Column','yoga-studio'),
		'section' => 'yoga_studio_footer_copyright',
		'setting' => 'yoga_studio_footer_widget',
		'type' => 'radio',
				'choices' => array(
						'1'   => __('1 Column', 'yoga-studio'),
						'2'  => __('2 Column', 'yoga-studio'),
						'3' => __('3 Column', 'yoga-studio'),
						'4' => __('4 Column', 'yoga-studio')
				),
	));

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'yoga_studio_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'yoga_studio_customize_partial_blogdescription',
	) );

	//front page
	$num_sections = apply_filters( 'yoga_studio_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'yoga_studio_sanitize_dropdown_pages',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'          => sprintf( __( 'Front Page Section %d Content', 'yoga-studio' ), $i ),
			'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'yoga-studio' ) ),
			'section'        => 'theme_options',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'yoga_studio_is_static_front_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'yoga_studio_front_page_section',
			'container_inclusive' => true,
		) );
	}
}
add_action( 'customize_register', 'yoga_studio_customize_register' );

function yoga_studio_customize_partial_blogname() {
	bloginfo( 'name' );
}
function yoga_studio_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
function yoga_studio_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}
function yoga_studio_is_view_with_layout_option() {
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

define('YOGA_STUDIO_PRO_LINK',__('https://www.ovationthemes.com/wordpress/yoga-wordpress-theme/','yoga-studio'));

/* Pro control */
if (class_exists('WP_Customize_Control') && !class_exists('Yoga_Studio_Pro_Control')):
    class Yoga_Studio_Pro_Control extends WP_Customize_Control{

    public function render_content(){?>
        <label style="overflow: hidden; zoom: 1;">
	        <div class="col-md-2 col-sm-6 upsell-btn">
                <a href="<?php echo esc_url( YOGA_STUDIO_PRO_LINK ); ?>" target="blank" class="btn btn-success btn"><?php esc_html_e('UPGRADE YOGA STUDIO PREMIUM','yoga-studio');?> </a>
	        </div>
            <div class="col-md-4 col-sm-6">
                <img class="yoga_studio_img_responsive " src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png">
            </div>
	        <div class="col-md-3 col-sm-6">
	            <h3 style="margin-top:10px; margin-left: 20px; text-decoration:underline; color:#333;"><?php esc_html_e('YOGA STUDIO PREMIUM - Features', 'yoga-studio'); ?></h3>
                <ul style="padding-top:10px">
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Responsive Design', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Boxed or fullwidth layout', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Shortcode Support', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Demo Importer', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Section Reordering', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Contact Page Template', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Multiple Blog Layouts', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Unlimited Color Options', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Designed with HTML5 and CSS3', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Customizable Design & Code', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Cross Browser Support', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Detailed Documentation Included', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Stylish Custom Widgets', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Patterns Background', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('WPML Compatible (Translation Ready)', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Woo-commerce Compatible', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Full Support', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('10+ Sections', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Live Customizer', 'yoga-studio');?> </li>
                   	<li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('AMP Ready', 'yoga-studio');?> </li>
                   	<li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Clean Code', 'yoga-studio');?> </li>
                   	<li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('SEO Friendly', 'yoga-studio');?> </li>
                   	<li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Supper Fast', 'yoga-studio');?> </li>
                </ul>
        	</div>
		    <div class="col-md-2 col-sm-6 upsell-btn upsell-btn-bottom">
	            <a href="<?php echo esc_url( YOGA_STUDIO_PRO_LINK ); ?>" target="blank" class="btn btn-success btn"><?php esc_html_e('UPGRADE YOGA STUDIO PREMIUM','yoga-studio');?> </a>
		    </div>
		    <p><?php printf(__('Please review us if you love our product on %1$sWordPress.org%2$s. </br></br>  Thank You', 'yoga-studio'), '<a target="blank" href="https://wordpress.org/support/theme/yoga-studio/reviews/">', '</a>');
            ?></p>
        </label>
    <?php } }
endif;
