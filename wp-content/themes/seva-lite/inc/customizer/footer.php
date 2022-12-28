<?php
/**
 * Footer Setting
 *
 * @package Seva_Lite
 */

function seva_lite_customize_register_footer( $wp_customize ) {
    
    $wp_customize->add_section(
        'footer_settings',
        array(
            'title'      => __( 'Footer Settings', 'seva-lite' ),
            'priority'   => 199,
            'capability' => 'edit_theme_options',
        )
    );

    /** Enable footer branding section */
    $wp_customize->add_setting( 
        'ed_footer_branding', 
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_footer_branding',
            array(
                'section'         => 'footer_settings',
                'label'           => __( 'Footer Branding Section', 'seva-lite' ),
                'description'     => __( 'Enable to show footer branding section', 'seva-lite' ),
            )
        )
    );
    
    /** Footer Copyright */
    $wp_customize->add_setting(
        'footer_copyright',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'footer_copyright',
        array(
            'label'       => __( 'Footer Copyright Text', 'seva-lite' ),
            'section'     => 'footer_settings',
            'type'        => 'textarea',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
        'selector' => '.site-info .copyright',
        'render_callback' => 'seva_lite_get_footer_copyright',
    ) );
        
}
add_action( 'customize_register', 'seva_lite_customize_register_footer' );