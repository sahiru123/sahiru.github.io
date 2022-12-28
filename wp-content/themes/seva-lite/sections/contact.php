<?php
/**
 * Contact Section
 * 
 * @package Seva_Lite
 */

$contact_subtitle 	= get_theme_mod( 'contact_sec_subtitle', __( 'GET IN TOUCH', 'seva-lite' ) );
$contact_title 		= get_theme_mod( 'contact_sec_title', __( 'Contact Me', 'seva-lite' ) );
$contact_content 	= get_theme_mod( 'contact_sec_content' );

if( is_active_sidebar( 'contact' ) ){ ?>
<section id="contact_section" class="contact-section"  >
	<div class="container">
		<?php if( $contact_title || $contact_subtitle || $contact_content ) : ?>
			<header class="section-header wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
				<?php if( $contact_subtitle ) echo '<span class="section-subtitle">' . esc_html( $contact_subtitle ) . '</span>'; ?>
				<?php if( $contact_title ) echo '<h2 class="section-title">' . esc_html( $contact_title ) . '</h2>'; ?>
				<?php if( $contact_content ) echo '<div class="section-desc">' . esc_html( $contact_content ) . '</div>'; ?>
	    	</header>
		<?php endif; ?>
		
			<div class="section-grid wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
				<?php if( is_active_sidebar( 'contact' ) ){
					dynamic_sidebar( 'contact' );
				} ?>
    		</div>
		
    	
	</div>
</section> <!-- .testimonial-section -->
<?php
}