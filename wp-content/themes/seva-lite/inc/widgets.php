<?php
/**
 * Seva Lite Widget Areas
 * 
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @package Seva_Lite
 */

function seva_lite_widgets_init(){    
    $sidebars = array(
        'sidebar'   => array(
            'name'        => __( 'Sidebar', 'seva-lite' ),
            'id'          => 'sidebar', 
            'description' => __( 'Default Sidebar', 'seva-lite' ),
        ),
        'newsletter' => array(
            'name'        => __( 'Newsletter Section', 'seva-lite' ),
            'id'          => 'newsletter', 
            'description' => __( 'Add "BlossomThemes: Email Newsletter" widget for newsletter section.', 'seva-lite' ),
        ),
        'about' => array(
            'name'        => __( 'About Section', 'seva-lite' ),
            'id'          => 'about', 
            'description' => __( 'Add "Blossom: Featured Page Widget" for about section.', 'seva-lite' ),
        ),
        'client' => array(
            'name'        => __( 'Client Section', 'seva-lite' ),
            'id'          => 'client', 
            'description' => __( 'Add "Blossom: Client Logo Widget" for client section. The recommended image size for this section is 330px by 190px in PNG format.', 'seva-lite' ),
        ),
        'service' => array(
            'name'        => __( 'Service Section', 'seva-lite' ),
            'id'          => 'service', 
            'description' => __( 'Add "Text" & "Blossom: Icon Text" widget for service section. The recommended image size for this section is 390px by 293px.', 'seva-lite' ),
        ),
        'cta' => array(
            'name'        => __( 'Call To Action Section', 'seva-lite' ),
            'id'          => 'cta', 
            'description' => __( 'Add "Blossom: Call To Action" widget for Call to Action section.', 'seva-lite' ),
        ),
        'testimonial' => array(
            'name'        => __( 'Testimonial Section', 'seva-lite' ),
            'id'          => 'testimonial', 
            'description' => __( 'Add "Blossom: Testimonial" widget for testimonial section.', 'seva-lite' ),
        ),
        'contact' => array(
            'name'        => __( 'Contact Section', 'seva-lite' ),
            'id'          => 'contact', 
            'description' => __( 'Add "Blossom: Contact Widget" & "Text" widgets for contact section.', 'seva-lite' ),
        ),
        'cta-two' => array(
            'name'        => __( 'Call To Action Two Section', 'seva-lite' ),
            'id'          => 'cta-two', 
            'description' => __( 'Add "Blossom: Call To Action" widget for Call to Action two section.', 'seva-lite' ),
        ),
        'footer-one'=> array(
            'name'        => __( 'Footer One', 'seva-lite' ),
            'id'          => 'footer-one', 
            'description' => __( 'Add footer one widgets here.', 'seva-lite' ),
        ),
        'footer-two'=> array(
            'name'        => __( 'Footer Two', 'seva-lite' ),
            'id'          => 'footer-two', 
            'description' => __( 'Add footer two widgets here.', 'seva-lite' ),
        ),
        'footer-three'=> array(
            'name'        => __( 'Footer Three', 'seva-lite' ),
            'id'          => 'footer-three', 
            'description' => __( 'Add footer three widgets here.', 'seva-lite' ),
        ),
        'footer-four'=> array(
            'name'        => __( 'Footer Four', 'seva-lite' ),
            'id'          => 'footer-four', 
            'description' => __( 'Add footer four widgets here.', 'seva-lite' ),
        )
    );
    
    foreach( $sidebars as $sidebar ){
        register_sidebar( array(
    		'name'          => esc_html( $sidebar['name'] ),
    		'id'            => esc_attr( $sidebar['id'] ),
    		'description'   => esc_html( $sidebar['description'] ),
    		'before_widget' => '<section id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</section>',
    		'before_title'  => '<h2 class="widget-title" itemprop="name">',
    		'after_title'   => '</h2>',
    	) );
    }
    
}
add_action( 'widgets_init', 'seva_lite_widgets_init' );