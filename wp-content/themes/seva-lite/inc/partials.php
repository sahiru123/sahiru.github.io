<?php
/**
 * Seva Lite Customizer Partials
 *
 * @package Seva_Lite
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function seva_lite_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function seva_lite_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if( ! function_exists( 'seva_lite_get_slider_readmore' ) ) :
/**
 * Banner Title
*/
function seva_lite_get_slider_readmore(){
    return esc_html( get_theme_mod( 'slider_readmore', __( 'Read More', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_banner_title' ) ) :
/**
 * Banner Title
*/
function seva_lite_get_banner_title(){
    return esc_html( get_theme_mod( 'banner_title', __( 'Let\'s Build your Dream life together', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_banner_subtitle' ) ) :
/**
 * Banner Subtitle
*/
function seva_lite_get_banner_subtitle(){
    return esc_html( get_theme_mod( 'banner_subtitle', __( 'Welcome', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_banner_content' ) ) :
/**
 * Banner Content
*/
function seva_lite_get_banner_content(){
    return wp_kses_post( wpautop( get_theme_mod( 'banner_content', __( 'To empower women to make a positive impact on the world with fiery passion, unbridled self-belief, and head-turning style.', 'seva-lite' ) ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_banner_label' ) ) :
/**
 * Banner Button Label
*/
function seva_lite_get_banner_label(){
    return esc_html( get_theme_mod( 'banner_label', __( 'GET STARTED', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_phone' ) ) :
/**
 * Header Phone
*/
function seva_lite_get_phone(){
    return esc_html( get_theme_mod( 'phone', __( '+123-456-7890', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_email' ) ) :
/**
 * Header email
*/
function seva_lite_get_email(){
    return esc_html( get_theme_mod( 'email', __( 'mail@domain.com', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_header_contact_button' ) ) :
/**
 * Header Contact Button
*/
function seva_lite_get_header_contact_button(){
    return esc_html( get_theme_mod( 'header_contact_button', __( 'INQUIRY', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_read_more' ) ) :
/**
 * Display blog readmore button
*/
function seva_lite_get_read_more(){
    return esc_html( get_theme_mod( 'read_more_text', __( 'Read More', 'seva-lite' ) ) );    
}
endif;

if( ! function_exists( 'seva_lite_get_related_title' ) ) :
/**
 * Display blog readmore button
*/
function seva_lite_get_related_title(){
    return esc_html( get_theme_mod( 'related_post_title', __( 'You may also like...', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_author_subtitle' ) ) :
/**
 * Display blog readmore button
*/
function seva_lite_get_author_subtitle(){
    return esc_html( get_theme_mod( 'author_subtitle', __( 'About The Author', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_footer_copyright' ) ) :
/**
 * Footer Copyright
*/
function seva_lite_get_footer_copyright(){
    $copyright = get_theme_mod( 'footer_copyright' );
    echo '<span class="copyright">';
    if( $copyright ){
        echo wp_kses_post( $copyright );
    }else{
        esc_html_e( '&copy; Copyright ', 'seva-lite' );
        echo date_i18n( esc_html__( 'Y', 'seva-lite' ) );
        echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>. ';
        esc_html_e( 'All Rights Reserved. ', 'seva-lite' );
    }
    echo '</span>'; 
}
endif;

if( ! function_exists( 'seva_lite_service_btn_label' ) ) :
/**
 * Display service section readmore button
*/
function seva_lite_service_btn_label(){
    return esc_html( get_theme_mod( 'service_btn_label', __( 'VIEW ALL SERVICES', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_testimonial_btn_label' ) ) :
/**
 * Display testimonial button
 */
function seva_lite_testimonial_btn_label(){
    return esc_html( get_theme_mod( 'testimonial_btn_label', __( 'VIEW ALL TESTIMONIALS', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_testimonial_subtitle' ) ) :
/**
 * Display testimonial subtitle
 */
function seva_lite_get_testimonial_subtitle(){
    return esc_html( get_theme_mod( 'testimonial_subtitle', __( 'TESTIMONIAL', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_testimonial_title' ) ) :
/**
 * Display testimonial title
 */
function seva_lite_get_testimonial_title(){
    return esc_html( get_theme_mod( 'testimonial_title', __( 'Words from People', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_testimonial_content' ) ) :
/**
 * Display testimonial content
 */
function seva_lite_get_testimonial_content(){
    return esc_html( get_theme_mod( 'testimonial_content', __( 'Read what my clients are saying to whom I\'ve helped to make a difference in their life.', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_blog_title_selective_refresh' ) ) :
/**
 * Display blog title
 */
function seva_lite_blog_title_selective_refresh(){
    return esc_html( get_theme_mod( 'blog_section_title', __( 'Latest Articles', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_blog_subtitle_selective_refresh' ) ) :
/**
 * Display blog subtitle
 */
function seva_lite_blog_subtitle_selective_refresh(){
    return esc_html( get_theme_mod( 'blog_section_subtitle', __( 'BLOG', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_blog_description_selective_refresh' ) ) :
/**
 * Display blog description
 */
function seva_lite_blog_description_selective_refresh(){
    return wp_kses_post( wpautop( get_theme_mod( 'blog_section_content' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_blog_readmore_selective_refresh' ) ) :
/**
 * Display blog readmore
 */
function seva_lite_blog_readmore_selective_refresh(){
    return esc_html( get_theme_mod( 'blog_readmore', __( 'Read More', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_blog_view_all_btn' ) ) :
/**
 * Display blog view all button
 */
function seva_lite_get_blog_view_all_btn(){
    return esc_html( get_theme_mod( 'blog_view_all', __( 'VIEW ALL ARTICLES', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_contact_title' ) ) :
/**
 * Contact Section Title
 */
function seva_lite_get_contact_title(){
    return esc_html( get_theme_mod( 'contact_sec_title', __( 'Contact Me', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_contact_subtitle' ) ) :
/**
 * Contact Section Subtitle
 */
function seva_lite_get_contact_subtitle(){
    return esc_html( get_theme_mod( 'contact_sec_subtitle', __( 'GET IN TOUCH', 'seva-lite' ) ) );
}
endif;

if( ! function_exists( 'seva_lite_get_contact_description' ) ) :
/**
 * Contact Section Description
 */
function seva_lite_get_contact_description(){
    return esc_html( get_theme_mod( 'contact_sec_content' ) );
}
endif;

if( ! function_exists( 'seva_lite_get_wol_section_title' ) ) :
/**
 * Wheel of life section title
 */
function seva_lite_get_wol_section_title(){
    return esc_html( get_theme_mod( 'wol_section_title' ) );
}
endif;

if( ! function_exists( 'seva_lite_get_wol_section_content' ) ) :
/**
 * Wheel of life section content
 */
function seva_lite_get_wol_section_content(){
    return esc_html( get_theme_mod( 'wol_section_content' ) );
}
endif;