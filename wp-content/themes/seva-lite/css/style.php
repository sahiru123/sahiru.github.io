<?php
/**
 * Seva Dynamic Styles
 * 
 * @package Seva_Lite
*/

function seva_lite_dynamic_css(){
    
    $primary_font    = get_theme_mod( 'primary_font', 'Nunito Sans' );
    $primary_fonts   = seva_lite_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'DM Serif Display' );
    $secondary_fonts = seva_lite_get_fonts( $secondary_font, 'regular' );
    $font_size       = get_theme_mod( 'font_size', 18 );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'Nunito Sans', 'variant'=>'regular' ) );
    $site_title_fonts     = seva_lite_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 30 );
    
    $logo_width       = get_theme_mod( 'logo_width', 150 );
    $background_color = get_theme_mod( 'background-color', '#fbf3f0' );

    $tc_font_size = get_theme_mod( 'testimonial_content_font_size', 20 );
     
    $rgb4 = seva_lite_hex2rgb( seva_lite_sanitize_hex_color( $background_color ) );

    $about_bg   = get_theme_mod( 'about_bg_image', get_template_directory_uri() . '/images/about-bg-img.png' );
    $contact_bg = get_theme_mod( 'contact_bg_image' );

    $wheeloflife_color = get_theme_mod( 'wheeloflife_color', '#fff8f5' );
     
    echo "<style type='text/css' media='all'>"; ?>
    
    :root {
        --global-body-font: <?php echo esc_html( $primary_fonts['font'] ); ?>;
        --global-heading-font: <?php echo esc_html( $secondary_fonts['font'] ); ?>;
        --background-color: <?php echo seva_lite_sanitize_hex_color( $background_color ); ?>;
        --background-color-rgb: <?php printf( '%1$s, %2$s, %3$s', $rgb4[0], $rgb4[1], $rgb4[2] ); ?>;
	}

    body{
        font-size: <?php echo absint( $font_size ); ?>px;
    }
    
    section#wheeloflife_section {
        background-color: <?php echo seva_lite_sanitize_hex_color( $wheeloflife_color ); ?>;
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
           
    <?php echo "</style>";
}
add_action( 'wp_head', 'seva_lite_dynamic_css', 99 );

/**
 * Function for sanitizing Hex color 
 */
function seva_lite_sanitize_hex_color( $color ){
	if ( '' === $color )
		return '';

    // 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;
}

/**
 * convert hex to rgb
 * @link http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
*/
function seva_lite_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

if ( ! function_exists( 'seva_lite_gutenberg_inline_style' ) ) : 
/**
 * Gutenberg Dynamic Style
 */
function seva_lite_gutenberg_inline_style(){
 
    /* Get Link Color */
    $primary_font    = get_theme_mod( 'primary_font', 'Nunito Sans' );
    $primary_fonts   = seva_lite_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'DM Serif Display' );
    $secondary_fonts = seva_lite_get_fonts( $secondary_font, 'regular' );

    $background_color = get_theme_mod( 'background_custom_color','#fbf3f0' );
    $rgb4 = seva_lite_hex2rgb( seva_lite_sanitize_hex_color( $background_color ) );
 
    $custom_css = ':root .block-editor-page {
        --primary-font: ' . esc_html( $primary_fonts['font'] ) . ';
        --secondary-font: ' . esc_html( $secondary_fonts['font'] ) . ';
        --background-color: ' . seva_lite_sanitize_hex_color( $background_color ) . ';
        --background-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb4[0], $rgb4[1], $rgb4[2] ) . ';
    }';

    return $custom_css;
}
endif;

/**
 * Convert '#' to '%23'
*/
function seva_lite_hash_to_percent23( $color_code ){
    $color_code = str_replace( "#", "%23", $color_code );
    return $color_code;
}