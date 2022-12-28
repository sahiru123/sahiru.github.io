<?php
/**
 * Services Section
 * 
 * @package Seva_Lite
 */

$service_btn_url 		= get_theme_mod( 'service_btn_url', '#' );
$service_btn_label 		= get_theme_mod( 'service_btn_label', __( 'VIEW ALL SERVICES', 'seva-lite' ) );

if( is_active_sidebar( 'service' ) ){ ?>
<section id="service_section" class="service-section" >
	<div class="container">
		<div class="service-widget-wrapper">
		    <?php dynamic_sidebar( 'service' ); ?>
		</div>
		<?php if( $service_btn_label && $service_btn_url ) : ?>
		<div class="section-button-wrapper wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" >
			<a href="<?php echo esc_url( $service_btn_url ); ?>" class="seva-btn btn-primary-two"><?php echo esc_html( $service_btn_label ); ?></a>
		</div>
    <?php endif; ?>
	</div>
</section> <!-- .service-section -->
<?php
}