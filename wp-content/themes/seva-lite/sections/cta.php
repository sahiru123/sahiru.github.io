<?php
/**
 * CTA Section
 * 
 * @package Seva_Lite
 */
if( is_active_sidebar( 'cta' ) ){ ?>
<section id="cta_section" class="cta-section cta-one">
    <?php dynamic_sidebar( 'cta' ); ?>
</section> <!-- .bg-cta-section -->
<?php
}