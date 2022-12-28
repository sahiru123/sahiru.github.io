<?php
/**
 * Header Four
 *
 * @package Meditation_Coach
 */

$ed_cart = get_theme_mod( 'ed_shopping_cart', false );
$ed_search = get_theme_mod( 'ed_header_search', false ); ?>

<header id="masthead" class="site-header style-two" itemscope itemtype="http://schema.org/WPHeader">
	<div class="header-top">
		<div class="container">
			<div class="header-left">
				<?php seva_lite_site_branding(); ?>
			</div>
			<div class="header-right">
				<?php seva_lite_header_contact(); ?>
				<?php seva_lite_contact_button(); ?>
			</div>
		</div>
	</div>
	<div class="header-main">
		<div class="container">
			<div class="header-left">			
				<?php seva_lite_primary_navigation(); ?>
			</div>
			<div class="header-right">		
				<?php if( seva_lite_social_links( false ) ){
					echo '<div class="header-social">';
                    seva_lite_social_links();
                    echo '</div>';
                } ?>	
				<?php if( $ed_search || ( seva_lite_is_woocommerce_activated() && $ed_cart ) ) { ?>
	                <div class="search-cart-wrap">
						<?php if( $ed_search ) seva_lite_header_search(); ?>
						<?php if( seva_lite_is_woocommerce_activated() && $ed_cart ) {
							echo '<div class="header-cart">';
							meditation_coach_wc_cart_count();
							echo '</div>';
						} ?>
					</div>
				<?php } ?>
				<?php seva_lite_secondary_navigation(); ?>
			</div>

		</div>
	</div>
	<?php seva_lite_mobile_navigation(); ?>
	<?php seva_lite_sticky_header(); ?>
</header>