<?php
/**
 * Displays footer site info
 *
 * @subpackage Yoga Meditation
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-info py-4 text-center">
	<?php
		echo esc_html( get_theme_mod( 'yoga_studio_footer_text' ) );
		printf(
			/* translators: %s: Yoga WordPress Theme. */
            '<a target="_blank" href="' . esc_url( 'https://www.ovationthemes.com/wordpress/free-meditation-wordpress-theme/') . '"> Meditation WordPress Theme</a>'
        );
	?>
</div>
