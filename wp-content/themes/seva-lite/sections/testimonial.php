<?php
/**
 * Testimonial Section
 * 
 * @package Seva_Lite
 */

$testimonial_subtitle 		= get_theme_mod( 'testimonial_subtitle', __( 'TESTIMONIAL', 'seva-lite' ) );
$testimonial_title 			= get_theme_mod( 'testimonial_title', __( 'Words from People', 'seva-lite' ) );
$testimonial_content 		= get_theme_mod( 'testimonial_content', __( 'Read what my clients are saying to whom I\'ve helped to make a difference in their life.', 'seva-lite' ) );
$testimonial_btn_url 		= get_theme_mod( 'testimonial_btn_url', '#' );
$testimonial_btn_label 		= get_theme_mod( 'testimonial_btn_label', __( 'VIEW ALL TESTIMONIALS', 'seva-lite' ) );

if( is_active_sidebar( 'testimonial' ) ){ ?>
<section id="testimonial_section" class="testimonial-section wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
	<div class="container">
		<?php if( $testimonial_title || $testimonial_subtitle || $testimonial_content ) : ?>
			<header class="section-header">
				<?php if( $testimonial_subtitle ) echo '<span class="section-subtitle">' . esc_html( $testimonial_subtitle ) . '</span>'; ?>
				<?php if( $testimonial_title ) echo '<h2 class="section-title">' . esc_html( $testimonial_title ) . '</h2>'; ?>
				<?php if( $testimonial_content ) echo '<div class="section-desc">' . esc_html( $testimonial_content ) . '</div>'; ?>
	    	</header>
	    <?php endif; ?>
			<div class="testimonial-inner-wrapper owl-carousel" >
			    <?php dynamic_sidebar( 'testimonial' ); ?>
			</div>
		<?php if( $testimonial_btn_label && $testimonial_btn_url ) : ?>
			<div class="section-button-wrapper" >
				<a href="<?php echo esc_url( $testimonial_btn_url ); ?>" class="seva-btn btn-primary-two"><?php echo esc_html( $testimonial_btn_label ); ?></a>
			</div>
	    <?php endif; ?>
	</div>
</section> <!-- .testimonial-section -->
<?php
}