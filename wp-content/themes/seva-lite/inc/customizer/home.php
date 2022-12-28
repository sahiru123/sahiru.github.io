<?php
/**
 * Front Page Settings
 *
 * @package Seva_Lite
 */

function seva_lite_customize_register_frontpage( $wp_customize ) {
	
    /** Front Page Settings */
    $wp_customize->add_panel( 
        'frontpage_settings',
         array(
            'priority'    => 40,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Front Page Settings', 'seva-lite' ),
            'description' => __( 'Static Home Page settings.', 'seva-lite' ),
        ) 
    );  

    /** Banner Settings */
    $wp_customize->get_section( 'header_image' )->panel                    = 'frontpage_settings';
    $wp_customize->get_section( 'header_image' )->title                    = __( 'Banner Section', 'seva-lite' );
    $wp_customize->get_section( 'header_image' )->priority                 = 10;
    $wp_customize->get_control( 'header_image' )->active_callback          = 'seva_lite_banner_ac';
    $wp_customize->get_control( 'header_video' )->active_callback          = 'seva_lite_banner_ac';
    $wp_customize->get_control( 'external_header_video' )->active_callback = 'seva_lite_banner_ac';
    $wp_customize->get_section( 'header_image' )->description              = '';                                               
    $wp_customize->get_setting( 'header_image' )->transport                = 'refresh';
    $wp_customize->get_setting( 'header_video' )->transport                = 'refresh';
    $wp_customize->get_setting( 'external_header_video' )->transport       = 'refresh';
    
    /** Banner Options */
    $wp_customize->add_setting(
        'ed_banner_section',
        array(
            'default'           => 'static_banner',
            'sanitize_callback' => 'seva_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Seva_Lite_Select_Control(
            $wp_customize,
            'ed_banner_section',
            array(
                'label'       => __( 'Banner Options', 'seva-lite' ),
                'description' => __( 'Choose banner as static image/video or as a slider.', 'seva-lite' ),
                'section'     => 'header_image',
                'choices'     => array(
                    'no_banner'        => __( 'Disable Banner Section', 'seva-lite' ),
                    'static_banner'    => __( 'Static/Video CTA Banner', 'seva-lite' ),
                    'slider_banner'    => __( 'Banner as Slider', 'seva-lite' ),
                ),
                'priority' => 5 
            )            
        )
    );
    
    /** Title */
    $wp_customize->add_setting(
        'banner_title',
        array(
            'default'           => __( 'Let\'s Build your Dream life together', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_title',
        array(
            'label'           => __( 'Title', 'seva-lite' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'seva_lite_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_title', array(
        'selector' => '.site-banner .banner-caption h2.title',
        'render_callback' => 'seva_lite_get_banner_title',
    ) );
    
    /** Sub Title */
    $wp_customize->add_setting(
        'banner_subtitle',
        array(
            'default'           => __( 'Welcome', 'seva-lite' ),
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_subtitle',
        array(
            'label'           => __( 'Subtitle', 'seva-lite' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'seva_lite_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_subtitle', array(
        'selector' => '.site-banner .banner-caption h5.subtitle',
        'render_callback' => 'seva_lite_get_banner_subtitle',
    ) );

    /** Sub Title */
    $wp_customize->add_setting(
        'banner_content',
        array(
            'default'           => __( 'To empower women to make a positive impact on the world with fiery passion, unbridled self-belief, and head-turning style.', 'seva-lite' ),
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_content',
        array(
            'label'           => __( 'Description', 'seva-lite' ),
            'section'         => 'header_image',
            'type'            => 'textarea',
            'active_callback' => 'seva_lite_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_content', array(
        'selector' => '.site-banner .banner-caption .banner-desc',
        'render_callback' => 'seva_lite_get_banner_content',
    ) );
    
    /** Banner Label */
    $wp_customize->add_setting(
        'banner_label',
        array(
            'default'           => __( 'GET STARTED', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_label',
        array(
            'label'           => __( 'Button Label', 'seva-lite' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'seva_lite_banner_ac'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'banner_label', array(
        'selector' => '.site-banner .banner-caption .button-wrap a.seva-btn',
        'render_callback' => 'seva_lite_get_banner_label',
    ) );
    
    /** Banner Link */
    $wp_customize->add_setting(
        'banner_link',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'banner_link',
        array(
            'label'           => __( 'Button Link', 'seva-lite' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'seva_lite_banner_ac'
        )
    );

    $wp_customize->add_setting( 'cta_banner_secondary_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'seva_lite_sanitize_image',
        )
    );
    
    $wp_customize->add_control( 
        new WP_Customize_Image_Control( $wp_customize, 'cta_banner_secondary_image',
            array(
                'label'         => esc_html__( 'Secondary Image', 'seva-lite' ),
                'description'   => esc_html__( 'Choose the secondary image for cta banner section.', 'seva-lite' ),
                'section'       => 'header_image',
                'type'          => 'image',
                'active_callback' => 'seva_lite_banner_ac'
            )
        )
    );

    $wp_customize->add_setting( 
        'banner_caption_layout', 
        array(
            'default'           => 'left',
            'sanitize_callback' => 'seva_lite_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Radio_Buttonset_Control(
            $wp_customize,
            'banner_caption_layout',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Banner Caption Alignment', 'seva-lite' ),
                'description' => __( 'Choose alignment for banner caption.', 'seva-lite' ),
                'choices'     => array(
                    'left'      => __( 'Left', 'seva-lite' ),
                    'right'     => __( 'Right', 'seva-lite' ),
                ),
                'active_callback' => 'seva_lite_banner_ac' 
            )
        )
    );

    /** Slider Content Style */
    $wp_customize->add_setting(
        'slider_type',
        array(
            'default'           => 'latest_posts',
            'sanitize_callback' => 'seva_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Seva_Lite_Select_Control(
            $wp_customize,
            'slider_type',
            array(
                'label'   => __( 'Slider Content Style', 'seva-lite' ),
                'section' => 'header_image',
                'choices' => array(
                    'latest_posts' => __( 'Latest Posts', 'seva-lite' ),
                    'cat'          => __( 'Category', 'seva-lite' ),
                ),
                'active_callback' => 'seva_lite_banner_ac'  
            )
        )
    );
    
    /** Slider Category */
    $wp_customize->add_setting(
        'slider_cat',
        array(
            'default'           => '',
            'sanitize_callback' => 'seva_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Seva_Lite_Select_Control(
            $wp_customize,
            'slider_cat',
            array(
                'label'           => __( 'Slider Category', 'seva-lite' ),
                'section'         => 'header_image',
                'choices'         => seva_lite_get_categories(),
                'active_callback' => 'seva_lite_banner_ac'  
            )
        )
    );
    
    /** No. of slides */
    $wp_customize->add_setting(
        'no_of_slides',
        array(
            'default'           => 3,
            'sanitize_callback' => 'seva_lite_sanitize_number_absint'
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Slider_Control( 
            $wp_customize,
            'no_of_slides',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Number of Slides', 'seva-lite' ),
                'description' => __( 'Choose the number of slides you want to display', 'seva-lite' ),
                'choices'     => array(
                    'min'   => 1,
                    'max'   => 20,
                    'step'  => 1,
                ),
                'active_callback' => 'seva_lite_banner_ac'                 
            )
        )
    );
    
    /** HR */
    $wp_customize->add_setting(
        'hr',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Note_Control( 
            $wp_customize,
            'hr',
            array(
                'section'     => 'header_image',
                'description' => '<hr/>',
                'active_callback' => 'seva_lite_banner_ac'
            )
        )
    ); 
    
    /** Slider Auto */
    $wp_customize->add_setting(
        'slider_auto',
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'slider_auto',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Auto', 'seva-lite' ),
                'description' => __( 'Enable slider auto transition.', 'seva-lite' ),
                'active_callback' => 'seva_lite_banner_ac'
            )
        )
    );
    
    /** Slider Loop */
    $wp_customize->add_setting(
        'slider_loop',
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'slider_loop',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Loop', 'seva-lite' ),
                'description' => __( 'Enable slider loop.', 'seva-lite' ),
                'active_callback' => 'seva_lite_banner_ac'
            )
        )
    );
    
    /** Slider Caption */
    $wp_customize->add_setting(
        'slider_caption',
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'slider_caption',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Caption', 'seva-lite' ),
                'description' => __( 'Enable slider caption.', 'seva-lite' ),
                'active_callback' => 'seva_lite_banner_ac'
            )
        )
    );
    
    /** Full Image */
    $wp_customize->add_setting(
        'slider_full_image',
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'slider_full_image',
            array(
                'section'         => 'header_image',
                'label'           => __( 'Full Image', 'seva-lite' ),
                'description'     => __( 'Enable to use full size image in slider.', 'seva-lite' ),
                'active_callback' => 'seva_lite_banner_ac'
            )
        )
    );
    
    /** Slider Animation */
    $wp_customize->add_setting(
        'slider_animation',
        array(
            'default'           => '',
            'sanitize_callback' => 'seva_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Seva_Lite_Select_Control(
            $wp_customize,
            'slider_animation',
            array(
                'label'       => __( 'Slider Animation', 'seva-lite' ),
                'section'     => 'header_image',
                'choices'     => array(
                    'bounceOut'      => __( 'Bounce Out', 'seva-lite' ),
                    'bounceOutLeft'  => __( 'Bounce Out Left', 'seva-lite' ),
                    'bounceOutRight' => __( 'Bounce Out Right', 'seva-lite' ),
                    'bounceOutUp'    => __( 'Bounce Out Up', 'seva-lite' ),
                    'bounceOutDown'  => __( 'Bounce Out Down', 'seva-lite' ),
                    'fadeOut'        => __( 'Fade Out', 'seva-lite' ),
                    'fadeOutLeft'    => __( 'Fade Out Left', 'seva-lite' ),
                    'fadeOutRight'   => __( 'Fade Out Right', 'seva-lite' ),
                    'fadeOutUp'      => __( 'Fade Out Up', 'seva-lite' ),
                    'fadeOutDown'    => __( 'Fade Out Down', 'seva-lite' ),
                    'flipOutX'       => __( 'Flip OutX', 'seva-lite' ),
                    'flipOutY'       => __( 'Flip OutY', 'seva-lite' ),
                    'hinge'          => __( 'Hinge', 'seva-lite' ),
                    'pulse'          => __( 'Pulse', 'seva-lite' ),
                    'rollOut'        => __( 'Roll Out', 'seva-lite' ),
                    'rotateOut'      => __( 'Rotate Out', 'seva-lite' ),
                    'rubberBand'     => __( 'Rubber Band', 'seva-lite' ),
                    'shake'          => __( 'Shake', 'seva-lite' ),
                    ''               => __( 'Slide', 'seva-lite' ),
                    'slideOutLeft'   => __( 'Slide Out Left', 'seva-lite' ),
                    'slideOutRight'  => __( 'Slide Out Right', 'seva-lite' ),
                    'slideOutUp'     => __( 'Slide Out Up', 'seva-lite' ),
                    'slideOutDown'   => __( 'Slide Out Down', 'seva-lite' ),
                    'swing'          => __( 'Swing', 'seva-lite' ),
                    'tada'           => __( 'Tada', 'seva-lite' ),
                    'zoomOut'        => __( 'Zoom Out', 'seva-lite' ),
                    'zoomOutLeft'    => __( 'Zoom Out Left', 'seva-lite' ),
                    'zoomOutRight'   => __( 'Zoom Out Right', 'seva-lite' ),
                    'zoomOutUp'      => __( 'Zoom Out Up', 'seva-lite' ),
                    'zoomOutDown'    => __( 'Zoom Out Down', 'seva-lite' ),                    
                ),
                'active_callback' => 'seva_lite_banner_ac'                                  
            )
        )
    );
    
    /** Slider Speed */
    $wp_customize->add_setting(
        'slider_speed',
        array(
            'default'           => 5000,
            'sanitize_callback' => 'seva_lite_sanitize_number_absint'
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Slider_Control( 
            $wp_customize,
            'slider_speed',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Speed', 'seva-lite' ),
                'description' => __( 'Controls the speed of slider in miliseconds.', 'seva-lite' ),
                'choices'     => array(
                    'min'  => 1000,
                    'max'  => 20000,
                    'step' => 500,
                ),
                'active_callback' => 'seva_lite_banner_ac'
            )
        )
    );

    /** Read More Text */
    $wp_customize->add_setting(
        'slider_readmore',
        array(
            'default'           => __( 'Read More', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'slider_readmore',
        array(
            'type'            => 'text',
            'section'         => 'header_image',
            'label'           => __( 'Slider Read More', 'seva-lite' ),
            'active_callback' => 'seva_lite_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'slider_readmore', array(
        'selector' => '.site-banner.banner-slider .banner-caption .button-wrap a.seva-btn',
        'render_callback' => 'seva_lite_get_slider_readmore',
    ) );

    /** Slider Settings Ends */   

    /** About Section */
    $wp_customize->add_section(
        'about',
        array(
            'title'    => __( 'About Section', 'seva-lite' ),
            'priority' => 30,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting( 'about_secondary_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'seva_lite_sanitize_image',
        )
    );
    
    $wp_customize->add_control( 
        new WP_Customize_Image_Control( $wp_customize, 'about_secondary_image',
            array(
                'label'         => esc_html__( 'Secondary Image', 'seva-lite' ),
                'description'   => esc_html__( 'Choose the secondary image for about section.', 'seva-lite' ),
                'section'       => 'about',
                'type'          => 'image',
                'priority'      => -1,
            )
        )
    );

    $wp_customize->add_setting( 'about_bg_image',
        array(
            'default'           => esc_url( get_template_directory_uri() . '/images/about-bg-img.png' ),
            'sanitize_callback' => 'seva_lite_sanitize_image',
        )
    );
    
    $wp_customize->add_control( 
        new WP_Customize_Image_Control( $wp_customize, 'about_bg_image',
            array(
                'label'         => esc_html__( 'Background Image', 'seva-lite' ),
                'description'   => esc_html__( 'Choose the background image for about section.', 'seva-lite' ),
                'section'       => 'about',
                'type'          => 'image',
                'priority'      => -1,
            )
        )
    );

    $wp_customize->add_setting(
        'about_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Note_Control( 
            $wp_customize,
            'about_note_text',
            array(
                'section'     => 'about',
                'description' => __( '<hr/>Add "Blossom: Featured Page Widget" for about section.', 'seva-lite' ),
                'priority'    => -1
            )
        )
    );

    $about_section = $wp_customize->get_section( 'sidebar-widgets-about' );
    if ( ! empty( $about_section ) ) {

        $about_section->panel     = 'frontpage_settings';
        $about_section->priority  = 30;
        $wp_customize->get_control( 'about_note_text' )->section = 'sidebar-widgets-about';
        $wp_customize->get_control( 'about_secondary_image' )->section = 'sidebar-widgets-about';
        $wp_customize->get_control( 'about_bg_image' )->section = 'sidebar-widgets-about';
    }  
    
    /** About Section Ends */   

     /** Service Section */
    $wp_customize->add_section(
        'service',
        array(
            'title'    => __( 'Service Section', 'seva-lite' ),
            'priority' => 50,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting(
        'ed_service_count',
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control(
            $wp_customize,
            'ed_service_count',
            array(
                'label'       => __( 'Enable Service Count', 'seva-lite' ),
                'description' => __( 'Enable to show count of services.', 'seva-lite' ),
                'section'     => 'service',
                'priority'    => -1
            )            
        )
    );

    $wp_customize->add_setting(
        'service_btn_label',
        array(
            'default'           => __( 'VIEW ALL SERVICES', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );
    
    $wp_customize->add_control(
        'service_btn_label',
        array(
            'label'           => __( 'Button Label', 'seva-lite' ),
            'section'         => 'service',
            'priority'    => -1
        )
    );

    $wp_customize->selective_refresh->add_partial( 'service_btn_label', array(
        'selector' => '.service-section .section-button-wrapper .seva-btn',
        'render_callback' => 'seva_lite_service_btn_label',
    ) );

    $wp_customize->add_setting(
        'service_btn_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'service_btn_url',
        array(
            'label'           => __( 'Button Link', 'seva-lite' ),
            'section'         => 'service',
            'type'            => 'url',
            'priority'        => -1
        )
    );

    $wp_customize->add_setting(
        'service_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Note_Control( 
            $wp_customize,
            'service_note_text',
            array(
                'section'     => 'service',
                'description' => __( '<hr/>Add "Text" & "Blossom: Icon Text" widget for service section. The recommended image size for this section is 390px by 293px.', 'seva-lite' ),
                'priority'    => -1
            )
        )
    );

    $service_section = $wp_customize->get_section( 'sidebar-widgets-service' );
    if ( ! empty( $service_section ) ) {

        $service_section->panel     = 'frontpage_settings';
        $service_section->priority  = 50;
        $wp_customize->get_control( 'service_note_text' )->section = 'sidebar-widgets-service';
        $wp_customize->get_control( 'ed_service_count' )->section  = 'sidebar-widgets-service';
        $wp_customize->get_control( 'service_btn_label' )->section  = 'sidebar-widgets-service';
        $wp_customize->get_control( 'service_btn_url' )->section  = 'sidebar-widgets-service';
    }  
    
    /** Service Section Ends */ 

    /** Testimonial Section */
    $wp_customize->add_section(
        'testimonial',
        array(
            'title'    => __( 'Testimonial Section', 'seva-lite' ),
            'priority' => 70,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting(
        'ed_testimonial_count',
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control(
            $wp_customize,
            'ed_testimonial_count',
            array(
                'label'       => __( 'Enable Testimonial Count', 'seva-lite' ),
                'description' => __( 'Enable to show count of testimonial.', 'seva-lite' ),
                'section'     => 'testimonial',
                'priority'    => -1
            )            
        )
    );

    /** Testimonial SubTitle  */
    $wp_customize->add_setting(
        'testimonial_subtitle',
        array(
            'default'           => __( 'TESTIMONIAL', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );
    
    $wp_customize->add_control(
        'testimonial_subtitle',
        array(
            'label'           => __( 'Section Subtitle', 'seva-lite' ),
            'section'         => 'testimonial',
            'type'            => 'text',
            'priority'    => -1
        )
    );

    $wp_customize->selective_refresh->add_partial( 'testimonial_subtitle', array(
        'selector' => '.testimonial-section .section-header .section-subtitle',
        'render_callback' => 'seva_lite_get_testimonial_subtitle',
    ) );

    /** Testimonial Title  */
    $wp_customize->add_setting(
        'testimonial_title',
        array(
            'default'           => __( 'Words from People', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );
    
    $wp_customize->add_control(
        'testimonial_title',
        array(
            'label'           => __( 'Section Title', 'seva-lite' ),
            'section'         => 'testimonial',
            'priority'    => -1
        )
    );

    $wp_customize->selective_refresh->add_partial( 'testimonial_title', array(
        'selector' => '.testimonial-section .section-header h2.section-title',
        'render_callback' => 'seva_lite_get_testimonial_title',
    ) );    

    /** Testimonial SubTitle  */
    $wp_customize->add_setting(
        'testimonial_content',
        array(
            'default'           => __( 'Read what my clients are saying to whom I\'ve helped to make a difference in their life.', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );
    
    $wp_customize->add_control(
        'testimonial_content',
        array(
            'label'           => __( 'Section Description', 'seva-lite' ),
            'section'         => 'testimonial',
            'type'            => 'text',
            'priority'    => -1
        )
    );

    $wp_customize->selective_refresh->add_partial( 'testimonial_content', array(
        'selector' => '.testimonial-section .section-header .section-desc',
        'render_callback' => 'seva_lite_get_testimonial_content',
    ) );

    $wp_customize->add_setting(
        'testimonial_auto',
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'testimonial_auto',
            array(
                'section'     => 'testimonial',
                'label'       => __( 'Testimonial Auto', 'seva-lite' ),
                'description' => __( 'Enable testimonial auto transition.', 'seva-lite' ),
                'priority'    => -1
            )
        )
    );

    $wp_customize->add_setting(
        'testimonial_loop',
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'testimonial_loop',
            array(
                'section'     => 'testimonial',
                'label'       => __( 'Testimonial Loop', 'seva-lite' ),
                'description' => __( 'Enable testimonial loop transition.', 'seva-lite' ),
                'priority'    => -1
            )
        )
    );

     $wp_customize->add_setting(
        'testimonial_speed',
        array(
            'default'           => 10000,
            'sanitize_callback' => 'seva_lite_sanitize_number_absint'
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Slider_Control( 
            $wp_customize,
            'testimonial_speed',
            array(
                'section'     => 'testimonial',
                'label'       => __( 'Testimonial Speed', 'seva-lite' ),
                'description' => __( 'Controls the speed of testimonial.', 'seva-lite' ),    
                'choices'     => array(
                    'min'   => 3000,
                    'max'   => 20000,
                    'step'  => 100,
                ),    
                'priority'    => -1             
            )
        )
    );

    $wp_customize->add_setting( 
        'testimonial_content_font_size', 
        array(
            'default'           => 20,
            'sanitize_callback' => 'seva_lite_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Slider_Control( 
            $wp_customize,
            'testimonial_content_font_size',
            array(
                'section'     => 'testimonial',
                'label'       => __( 'Font Size', 'seva-lite' ),
                'description' => __( 'Change the font size of testimonial content.', 'seva-lite' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 50,
                    'step'  => 1,
                ),              
                'priority'    => -1   
            )
        )
    );

    $wp_customize->add_setting(
        'testimonial_btn_label',
        array(
            'default'           => __( 'VIEW ALL TESTIMONIALS', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );
    
    $wp_customize->add_control(
        'testimonial_btn_label',
        array(
            'label'           => __( 'Button Label', 'seva-lite' ),
            'section'         => 'testimonial',
            'priority'    => -1
        )
    );

    $wp_customize->selective_refresh->add_partial( 'testimonial_btn_label', array(
        'selector' => '.testimonial-section .section-button-wrapper .seva-btn',
        'render_callback' => 'seva_lite_testimonial_btn_label',
    ) );

    $wp_customize->add_setting(
        'testimonial_btn_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'testimonial_btn_url',
        array(
            'label'           => __( 'Button Link', 'seva-lite' ),
            'section'         => 'testimonial',
            'type'            => 'url',
            'priority'        => -1
        )
    );

    $wp_customize->add_setting(
        'testimonial_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Note_Control( 
            $wp_customize,
            'testimonial_note_text',
            array(
                'section'     => 'testimonial',
                'description' => __( '<hr/>Add "Blossom: Testimonial" widget for testimonial section.', 'seva-lite' ),
                'priority'    => -1
            )
        )
    );

    $testimonial_section = $wp_customize->get_section( 'sidebar-widgets-testimonial' );
    if ( ! empty( $testimonial_section ) ) {

        $testimonial_section->panel     = 'frontpage_settings';
        $testimonial_section->priority  = 70;
        $wp_customize->get_control( 'testimonial_note_text' )->section = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'ed_testimonial_count' )->section     = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_title' )->section     = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_subtitle' )->section  = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_content' )->section  = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_btn_label' )->section  = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_btn_url' )->section  = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_auto' )->section  = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_loop' )->section  = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_speed' )->section  = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_content_font_size' )->section  = 'sidebar-widgets-testimonial';
    }  
    
    /** Testimonial Section Ends */

    /** Wheel of life section */
    $wp_customize->add_section(
        'wheel_of_life',
        array(
            'title'    => __( 'Wheel of Life Section', 'seva-lite' ),
            'priority' => 80,
            'panel'    => 'frontpage_settings',
        )
    );

    if( seva_lite_is_wheel_of_life_activated() ){

        $wp_customize->add_setting(
            'ed_wheeloflife_section',
            array(
                'default'           => false,
                'sanitize_callback' => 'seva_lite_sanitize_checkbox'
            )
        );
    
        $wp_customize->add_control(
            new Seva_Lite_Toggle_Control(
                $wp_customize,
                'ed_wheeloflife_section',
                array(
                    'label'       => __( 'Enable Wheel of Life Section', 'seva-lite' ),
                    'section'     => 'wheel_of_life',
                )            
            )
        );

        /** Note */
        $wp_customize->add_setting(
            'wheeloflife_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post' 
            )
        );
        
        $wp_customize->add_control(
            new Seva_Lite_Note_Control( 
                $wp_customize,
                'wheeloflife_text',
                array(
                    'section'     => 'wheel_of_life',
                    'description' => sprintf( __( 'Refer to this %1$sdocumentation%2$s to configure the plugin.', 'seva-lite' ), '<a href="https://kraftplugins.com/wheel-of-life/docs/" target="_blank">', '</a>' ),
                    'active_callback' => 'seva_lite_wheeloflife_ac'
                )
            )
        );
        
        $wp_customize->add_setting(
            'wol_section_title',
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage'
            )
        );
        
        $wp_customize->add_control(
            'wol_section_title',
            array(
                'label'   => __( 'Section Title', 'seva-lite' ),
                'section' => 'wheel_of_life',
                'type'    => 'text',
                'active_callback' => 'seva_lite_wheeloflife_ac'
            )
        );
        
        $wp_customize->selective_refresh->add_partial( 'wol_section_title', array(
            'selector'        => '.wheeloflife-section h2.section-title',
            'render_callback' => 'seva_lite_get_wol_section_title',
        ) );

        $wp_customize->add_setting(
            'wol_section_content',
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage'
            )
        );
        
        $wp_customize->add_control(
            'wol_section_content',
            array(
                'label'   => __( 'Section Content', 'seva-lite' ),
                'section' => 'wheel_of_life',
                'type'    => 'text',
                'active_callback' => 'seva_lite_wheeloflife_ac'
            )
        );

        $wp_customize->selective_refresh->add_partial( 'wol_section_content', array(
            'selector'        => '.wheeloflife-section .section-content p',
            'render_callback' => 'seva_lite_get_wol_section_content',
        ) );

        /** Image */
        $wp_customize->add_setting(
            'wheeloflife_img',
            array(
                'default'           => get_template_directory_uri() . '/images/chart.png',
                'sanitize_callback' => 'seva_lite_sanitize_image',
            )
        );
        
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'wheeloflife_img',
                array(
                    'label'             => __( 'Wheel of Life Image', 'seva-lite' ),
                    'section'           => 'wheel_of_life',
                    'active_callback'   => 'seva_lite_wheeloflife_ac'
                )
            )
        );

        $wp_customize->add_setting(
			'wheeloflife_shortcode',
			array(
				'default'            => '',
				'sanitize_callback'  => 'wp_kses_post',
			)
		);

		$wp_customize->add_control(
			'wheeloflife_shortcode',
			array(
				'label'         => __('Wheel of Life shortcode', 'seva-lite'),
				'description'   => __('Enter the Wheel of Life shortcode. Ex. [wheeloflife id=1456]', 'seva-lite'),
				'section'       => 'wheel_of_life',
				'type'          => 'text',
                'active_callback' => 'seva_lite_wheeloflife_ac'
			)
		);

        $wp_customize->add_setting(
            'wheeloflife_learn_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post' 
            )
        );
        
        $wp_customize->add_control(
            new Seva_Lite_Note_Control( 
                $wp_customize,
                'wheeloflife_learn_text',
                array(
                    'section'     => 'wheel_of_life',
                    'description' => sprintf( __( 'Refer to this %1$sdocumentation%2$s to learn how to use the shortcode.', 'seva-lite' ), '<a href="https://kraftplugins.com/wheel-of-life/docs/how-to-display-embed-wheel-of-life-assessments/" target="_blank">', '</a>' ),
                    'active_callback' => 'seva_lite_wheeloflife_ac'
                )
            )
        );

        $wp_customize->add_setting( 
            'wheeloflife_color', 
            array(
                'default'           => '#fff8f5',
                'sanitize_callback' => 'sanitize_hex_color',
            ) 
        );
    
        $wp_customize->add_control( 
            new WP_Customize_Color_Control( 
                $wp_customize, 
                'wheeloflife_color', 
                array(
                    'label'       => __( 'Section color', 'seva-lite' ),
                    'section'     => 'wheel_of_life',
                    'active_callback' => 'seva_lite_wheeloflife_ac'
                )
            )
        );

    }else{

        $wp_customize->add_setting(
    		'wol_activate_note',
    		array(
    			'sanitize_callback' => 'wp_kses_post'
    		)
    	);
    
    	$wp_customize->add_control(
    		new Seva_Lite_Note_Control( 
    			$wp_customize,
    			'wol_activate_note',
    			array(
    				'section'     => 'wheel_of_life', 
                    'label'       => __( 'Wheel of Life', 'seva-lite' ),   				
                    'description' => sprintf( __( 'Please install and activate the recommended plugin %1$sWheel of Life%2$s. After that option related with this section will be visible.', 'seva-lite' ), '<a href="' . admin_url( 'themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">', '</a>' ),
    			)
    		)
       ); 
    }
    /** Wheel of life section ends */

    /** Blog Section */
    $wp_customize->add_section(
        'blog_section',
        array(
            'title'    => __( 'Blog Section', 'seva-lite' ),
            'priority' => 90,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting(
        'ed_blog_section',
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_blog_section',
            array(
                'section'     => 'blog_section',
                'label'       => __( 'Enable Blog', 'seva-lite' ),
                'description' => __( 'Enable blog section.', 'seva-lite' ),
            )
        )
    );

    /** Blog title */
    $wp_customize->add_setting(
        'blog_section_title',
        array(
            'default'           => __( 'Latest Articles', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_title',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Section Title', 'seva-lite' ),
            'type'    => 'text',
            'active_callback' => 'seva_lite_blog_ac'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_section_title', array(
        'selector' => '.blog-section .section-header h2.section-title',
        'render_callback' => 'seva_lite_blog_title_selective_refresh',
    ) ); 

    /*
    * Blog description 
    */
    $wp_customize->add_setting(
        'blog_section_subtitle',
        array(
            'default'           => __( 'BLOG', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_subtitle',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Section Subtitle', 'seva-lite' ),
            'type'    => 'text',
            'active_callback' => 'seva_lite_blog_ac'
        )
    ); 

    $wp_customize->selective_refresh->add_partial( 'blog_section_subtitle', array(
        'selector' => '.blog-section .section-header .section-subtitle',
        'render_callback' => 'seva_lite_blog_subtitle_selective_refresh',
    ) );
   
    
    $wp_customize->add_setting(
        'blog_section_content',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_content',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Section Description', 'seva-lite' ),
            'type'    => 'textarea',
            'active_callback' => 'seva_lite_blog_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'blog_section_content', array(
        'selector' => '.blog-section .section-header .section-desc',
        'render_callback' => 'seva_lite_blog_description_selective_refresh',
    ) );

    /** Read More Label */
    $wp_customize->add_setting(
        'blog_readmore',
        array(
            'default'           => __( 'Read More', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_readmore',
        array(
            'label'           => __( 'Read More Label', 'seva-lite' ),
            'section'         => 'blog_section',
            'type'            => 'text',
            'active_callback' => 'seva_lite_blog_ac'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_readmore', array(
        'selector' => '.blog-section .button-wrap a.btn-link',
        'render_callback' => 'seva_lite_blog_readmore_selective_refresh',
    ) );
    
    /** View All Label */
    $wp_customize->add_setting(
        'blog_view_all',
        array(
            'default'           => __( 'VIEW ALL ARTICLES', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_view_all',
        array(
            'label'           => __( 'View All Label', 'seva-lite' ),
            'section'         => 'blog_section',
            'type'            => 'text',
            'active_callback' => 'seva_lite_blog_ac'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_view_all', array(
        'selector' => '.blog-section .section-button-wrapper a.seva-btn',
        'render_callback' => 'seva_lite_get_blog_view_all_btn',
    ) );
 
    /** Blog Section Ends */ 

    /** Contact Section */
    $wp_customize->add_section(
        'contact',
        array(
            'title'    => __( 'Contact Section', 'seva-lite' ),
            'priority' => 110,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Title */
        $wp_customize->add_setting(
            'contact_sec_title',
            array(
                'default'           => __( 'Contact Me', 'seva-lite' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage'
            )
        );
        
        $wp_customize->add_control(
            'contact_sec_title',
            array(
                'label'           => __( 'Section Title', 'seva-lite' ),
                'section'         => 'contact',
                'type'            => 'text',
                'priority'        => -1
            )
        );
        
        $wp_customize->selective_refresh->add_partial( 'contact_sec_title', array(
            'selector' => '.contact-section .section-header h2.section-title',
            'render_callback' => 'seva_lite_get_contact_title',
        ) );
    
        /** SubTitle */
        $wp_customize->add_setting(
            'contact_sec_subtitle',
            array(
                'default'           => __( 'GET IN TOUCH', 'seva-lite' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage'
            )
        );
        
        $wp_customize->add_control(
            'contact_sec_subtitle',
            array(
                'label'           => __( 'Section Subtitle', 'seva-lite' ),
                'section'         => 'contact',
                'type'            => 'text',
                'priority'        => -1
            )
        );
        
        $wp_customize->selective_refresh->add_partial( 'contact_sec_subtitle', array(
            'selector' => '.contact-section .section-header .section-subtitle',
            'render_callback' => 'seva_lite_get_contact_subtitle',
        ) );
    
        /** Content */
        $wp_customize->add_setting(
            'contact_sec_content',
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage'
            )
        );
        
        $wp_customize->add_control(
            'contact_sec_content',
            array(
                'label'           => __( 'Section Description', 'seva-lite' ),
                'section'         => 'contact',
                'type'            => 'text',
                'priority'        => -1
            )
        );
        
        $wp_customize->selective_refresh->add_partial( 'contact_sec_content', array(
            'selector' => '.contact-section .section-header .section-desc',
            'render_callback' => 'seva_lite_get_contact_description',
        ) );

    $wp_customize->add_setting( 'contact_bg_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'seva_lite_sanitize_image',
        )
    );
    
    $wp_customize->add_control( 
        new WP_Customize_Image_Control( $wp_customize, 'contact_bg_image',
            array(
                'label'         => esc_html__( 'Background Image', 'seva-lite' ),
                'description'   => esc_html__( 'Choose the background image for contact section.', 'seva-lite' ),
                'section'       => 'contact',
                'type'          => 'image',
                'priority'      => -1,
            )
        )
    );

    $wp_customize->add_setting(
        'contact_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Note_Control( 
            $wp_customize,
            'contact_note_text',
            array(
                'section'     => 'contact',
                'description' => __( '<hr/>Add "Blossom: Contact Widget" & "Text" widgets for contact section', 'seva-lite' ),
                'priority'    => -1
            )
        )
    );

    $wp_customize->add_setting(
        'follow_on_text',
        array(
            'default'           => __( 'Follow Me On:', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field', 
        )
    );
    
    $wp_customize->add_control(
        'follow_on_text',
        array(
            'type'            => 'text',
            'section'         => 'contact',
            'label'           => __( 'Contact Section Social Title', 'seva-lite' ),
            'active_callback' => 'seva_lite_contact_section_ac'
        )
    );

    $contact_section = $wp_customize->get_section( 'sidebar-widgets-contact' );
    if ( ! empty( $contact_section ) ) {

        $contact_section->panel     = 'frontpage_settings';
        $contact_section->priority  = 110;
        $wp_customize->get_control( 'contact_sec_title' )->section = 'sidebar-widgets-contact';
        $wp_customize->get_control( 'contact_sec_subtitle' )->section = 'sidebar-widgets-contact';
        $wp_customize->get_control( 'contact_sec_content' )->section = 'sidebar-widgets-contact';
        $wp_customize->get_control( 'contact_note_text' )->section = 'sidebar-widgets-contact';
        $wp_customize->get_control( 'contact_bg_image' )->section = 'sidebar-widgets-contact';
        $wp_customize->get_control( 'follow_on_text' )->section = 'sidebar-widgets-contact';
    }  
    
    /** Contact Section Ends */ 
      
}
add_action( 'customize_register', 'seva_lite_customize_register_frontpage' );