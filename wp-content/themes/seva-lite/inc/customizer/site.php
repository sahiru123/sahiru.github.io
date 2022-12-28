<?php
/**
 * Site Title Setting
 *
 * @package Seva_Lite
 */

function seva_lite_customize_register( $wp_customize ) {
	
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'background_image' )->transport = 'refresh';
	
	if( isset( $wp_customize->selective_refresh ) ){
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'seva_lite_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'seva_lite_customize_partial_blogdescription',
		) );
	}
    
    /** Logo Width */
    $wp_customize->add_setting(
        'logo_width',
        array(
            'default'           => 150,
            'sanitize_callback' => 'seva_lite_sanitize_number_absint',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'logo_width',
        array(
            'label'       => __( 'Logo Width', 'seva-lite' ),
            'description' => __( 'Set the width(px) of your Site Logo.', 'seva-lite' ),
            'section'     => 'title_tagline',
            'type'        => 'number',
            'input_attrs' => array(
                'min' => 1
            )
        )
    );

    /** Site Title Font */
    $wp_customize->add_setting( 
        'site_title_font', 
        array(
            'default' => array(                                			
                'font-family' => 'Nunito Sans',
                'variant'     => 'regular',
            ),
            'sanitize_callback' => array( 'Seva_Lite_Fonts', 'sanitize_typography' )
        ) 
    );

	$wp_customize->add_control( 
        new Seva_Lite_Typography_Control( 
            $wp_customize, 
            'site_title_font', 
            array(
                'label'       => __( 'Site Title Font', 'seva-lite' ),
                'description' => __( 'Site title and tagline font.', 'seva-lite' ),
                'section'     => 'title_tagline',
                'priority'    => 60, 
            ) 
        ) 
    );
    
    /** Site Title Font Size*/
    $wp_customize->add_setting( 
        'site_title_font_size', 
        array(
            'default'           => 30,
            'sanitize_callback' => 'seva_lite_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
		new Seva_Lite_Slider_Control( 
			$wp_customize,
			'site_title_font_size',
			array(
				'section'	  => 'title_tagline',
				'label'		  => __( 'Site Title Font Size', 'seva-lite' ),
				'description' => __( 'Change the font size of your site title.', 'seva-lite' ),
                'priority'    => 65,
                'choices'	  => array(
					'min' 	=> 10,
					'max' 	=> 200,
					'step'	=> 1,
				)                 
			)
		)
	);
    
}
add_action( 'customize_register', 'seva_lite_customize_register' );