<?php
/**
 * Free Vs Pro Panel.
 *
 * @package Seva_Lite
 */
?>
<!-- Free Vs Pro panel -->
<div id="free-pro-panel" class="panel-left">
	<div class="panel-aside">               		
		<img src="<?php echo esc_url( get_template_directory_uri() . '/inc/getting-started/images/free-vs-pro.jpg' ); //@todo change respective images.?>" alt="<?php esc_attr_e( 'Free vs Pro', 'seva-lite' ); ?>"/>
		<a class="button button-primary" href="<?php echo esc_url( 'https://blossomthemes.com/wordpress-themes/seva/' ); ?>" title="<?php esc_attr_e( 'View Premium Version', 'seva-lite' ); ?>" target="_blank">
            <?php esc_html_e( 'View Pro', 'seva-lite' ); ?>
        </a>
	</div><!-- .panel-aside -->
</div>