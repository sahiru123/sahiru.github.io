<?php
/**
 * CTA Section
 * 
 * @package Seva_Lite
 */
if( is_active_sidebar( 'cta-two' ) ){ ?>
<section id="cta_two_section" class="cta-section-two wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
	<div class="container">
	    <?php dynamic_sidebar( 'cta-two' ); ?>
	</div>
</section> <!-- .-cta-section -->
<?php
}