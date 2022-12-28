<?php
/**
 * Client Section
 * 
 * @package Seva_Lite
 */
if( is_active_sidebar( 'client' ) ){ ?>
<section id="client_section" class="client-section wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
	<div class="container">
	    <?php dynamic_sidebar( 'client' ); ?>
	</div>
</section> <!-- .client-section -->
<?php
}