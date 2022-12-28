<?php
/**
 * Blossomthemes Email Newsletter Functions.
 *
 * @package Seva_Lite
 */

if( ! function_exists( 'seva_lite_add_inner_div' ) ) :
    function seva_lite_add_inner_div(){
        return true;
    }
endif;
add_filter( 'bt_newsletter_widget_inner_wrap_display', 'seva_lite_add_inner_div' );

if( ! function_exists( 'seva_lite_start_inner_div' ) ) :
    function seva_lite_start_inner_div(){
        echo '<div class="container">';
    }
endif;
add_action( 'bt_newsletter_widget_inner_wrap_start', 'seva_lite_start_inner_div' );

if( ! function_exists( 'seva_lite_end_inner_div' ) ) :
    function seva_lite_end_inner_div(){
        echo '</div>';
    }
endif;
add_action( 'bt_newsletter_widget_inner_wrap_close', 'seva_lite_end_inner_div' );

if( ! function_exists( 'seva_lite_shortcode_add_inner_div' ) ) :
    function seva_lite_shortcode_add_inner_div(){
        return true;
    }
endif;
add_filter( 'bt_newsletter_shortcode_inner_wrap_display', 'seva_lite_shortcode_add_inner_div' );

if( ! function_exists( 'seva_lite_shortcode_start_inner_div' ) ) :
    function seva_lite_shortcode_start_inner_div(){
        echo '<div class="container">';
    }
endif;
add_action( 'bt_newsletter_shortcode_inner_wrap_start', 'seva_lite_shortcode_start_inner_div' );

if( ! function_exists( 'seva_lite_shortcode_end_inner_div' ) ) :
    function seva_lite_shortcode_end_inner_div(){
        echo '</div>';
    }
endif;
add_action( 'bt_newsletter_shortcode_inner_wrap_close', 'seva_lite_shortcode_end_inner_div' );