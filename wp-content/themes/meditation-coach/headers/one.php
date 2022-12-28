<?php
/**
 * Header One
 * 
 * @package Meditation_Coach
 */
 
?>
<header id="masthead" class="site-header style-one" itemscope itemtype="http://schema.org/WPHeader">
	<div class="header-top">
		<div class="container">
			<div class="header-left">
				<?php seva_lite_secondary_navigation(); ?>
				<?php if( seva_lite_social_links( false ) ){
					echo '<div class="header-social">';
                    seva_lite_social_links();
                    echo '</div>';
                } ?>  
			</div>
			<div class="header-right">
				<?php seva_lite_header_contact(); ?>
			</div>
		</div>
	</div>
	<div class="header-main">
		<div class="container">
			<?php seva_lite_site_branding(); ?>
			<?php seva_lite_primary_navigation(); ?>
			<?php seva_lite_contact_button(); ?>
		</div>
	</div>
	<?php seva_lite_mobile_navigation(); ?>
	<?php seva_lite_sticky_header(); ?>
</header>