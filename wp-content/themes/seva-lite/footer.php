<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Seva_Lite
 */
    
    /**
     * After Content
     * 
     * @hooked seva_lite_content_end - 20
     * @hooked seva_lite_instagram - 30
    */
    do_action( 'seva_lite_before_footer' );
    
    /**
     * Footer
     * 
     * @hooked seva_lite_footer_start  - 20
     * @hooked seva_lite_footer_top    - 25
     * @hooked seva_lite_footer_mid    - 30
     * @hooked seva_lite_footer_bottom - 40
     * @hooked seva_lite_footer_end    - 50
    */
    do_action( 'seva_lite_footer' );
    
    /**
     * After Footer
     * 
     * @hooked seva_lite_page_end    - 20
    */
    do_action( 'seva_lite_after_footer' );

    wp_footer(); ?>

</body>
</html>
