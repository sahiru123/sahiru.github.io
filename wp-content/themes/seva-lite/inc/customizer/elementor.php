<?php
/**
 * Elementor Setting
 *
 * @package Seva_Lite
 */

function seva_lite_customize_register_elementor( $wp_customize ) {
    
    $wp_customize->add_section(
        'elementor_settings',
        array(
            'title'      => __( 'Elementor Settings', 'seva-lite' ),
            'priority'   => 80,
            'capability' => 'edit_theme_options',
        )
    );
    
    $wp_customize->add_setting(
        'ed_elementor',
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_elementor',
            array(
                'section'       => 'elementor_settings',
                'label'         => __( 'Enable Elementor Page Builder in FrontPage', 'seva-lite' ),
                'description'   => __( 'You can override your Homepage Contents from this Elementor Page Builder', 'seva-lite' ),
            )
        )
    );   
        
}
add_action( 'customize_register', 'seva_lite_customize_register_elementor' );