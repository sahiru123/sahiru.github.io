<?php

add_action( 'admin_menu', 'yoga_studio_gettingstarted' );
function yoga_studio_gettingstarted() {    	
	add_theme_page( esc_html__('Theme Documentation', 'yoga-studio'), esc_html__('Theme Documentation', 'yoga-studio'), 'edit_theme_options', 'yoga-studio-guide-page', 'yoga_studio_guide');   
}

function yoga_studio_admin_theme_style() {
   wp_enqueue_style('yoga-studio-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/dashboard/dashboard.css');
}
add_action('admin_enqueue_scripts', 'yoga_studio_admin_theme_style');

if ( ! defined( 'YOGA_STUDIO_SUPPORT' ) ) {
	define('YOGA_STUDIO_SUPPORT',__('https://wordpress.org/support/theme/yoga-studio/','yoga-studio'));
}
if ( ! defined( 'YOGA_STUDIO_REVIEW' ) ) {
	define('YOGA_STUDIO_REVIEW',__('https://wordpress.org/support/theme/yoga-studio/reviews/','yoga-studio'));
}
if ( ! defined( 'YOGA_STUDIO_LIVE_DEMO' ) ) {
	define('YOGA_STUDIO_LIVE_DEMO',__('https://www.ovationthemes.com/demos/yoga-studio-pro/','yoga-studio'));
}
if ( ! defined( 'YOGA_STUDIO_BUY_PRO' ) ) {
	define('YOGA_STUDIO_BUY_PRO',__('https://www.ovationthemes.com/wordpress/yoga-wordpress-theme/','yoga-studio'));
}
if ( ! defined( 'YOGA_STUDIO_PRO_DOC' ) ) {
	define('YOGA_STUDIO_PRO_DOC',__('https://ovationthemes.com/docs/ot-yoga-studio-pro-doc/','yoga-studio'));
}
if ( ! defined( 'YOGA_STUDIO_THEME_NAME' ) ) {
	define('YOGA_STUDIO_THEME_NAME',__('Premium Yoga Studio Theme','yoga-studio'));
}

/**
 * Theme Info Page
 */
function yoga_studio_guide() {

	// Theme info
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme(); ?>

	<div class="getting-started__header">
		<div class="col-md-10">
			<h2><?php echo esc_html( $theme ); ?></h2>
			<p><?php esc_html_e('Version: ', 'yoga-studio'); ?><?php echo esc_html($theme['Version']);?></p>
		</div>
		<div class="col-md-2">
			<div class="btn_box">
				<a class="button-primary" href="<?php echo esc_url( YOGA_STUDIO_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support', 'yoga-studio'); ?></a>
				<a class="button-primary" href="<?php echo esc_url( YOGA_STUDIO_REVIEW ); ?>" target="_blank"><?php esc_html_e('Review', 'yoga-studio'); ?></a>
			</div>
		</div>
	</div>

	<div class="wrap getting-started">
		<div class="container">
			<div class="col-md-9">
				<div class="leftbox">
					<h3><?php esc_html_e('Documentation','yoga-studio'); ?></h3>
					<p><?php esc_html_e('To step the yoga studio theme follow the below steps.','yoga-studio'); ?></p>

					<h4><?php esc_html_e('1. Setup Logo','yoga-studio'); ?></h4>
					<p><?php esc_html_e('Go to dashboard >> Appearance >> Customize >> Site Identity >> Upload your logo or Add site title and site description.','yoga-studio'); ?></p>
					<a class="button-primary" href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','yoga-studio'); ?></a>

					<h4><?php esc_html_e('2. Setup Contact Info','yoga-studio'); ?></h4>
					<p><?php esc_html_e('Go to dashboard >> Appearance >> Customize >> Contact info >> Add your phone number and email address.','yoga-studio'); ?></p>
					<a class="button-primary" href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=yoga_studio_top') ); ?>" target="_blank"><?php esc_html_e('Add Contact Info','yoga-studio'); ?></a>

					<h4><?php esc_html_e('3. Setup Menus','yoga-studio'); ?></h4>
					<p><?php esc_html_e('Go to dashboard >> Appearance >> Menus >> Create Menus >> Add pages, post or custom link then save it.','yoga-studio'); ?></p>
					<a class="button-primary" href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Add Menus','yoga-studio'); ?></a>

					<h4><?php esc_html_e('4. Setup Social Icons','yoga-studio'); ?></h4>
					<p><?php esc_html_e('Go to dashboard >> Appearance >> Customize >> Social Media >> Add social links.','yoga-studio'); ?></p>
					<a class="button-primary" href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=yoga_studio_urls') ); ?>" target="_blank"><?php esc_html_e('Add Social Icons','yoga-studio'); ?></a>

					<h4><?php esc_html_e('5. Setup Footer','yoga-studio'); ?></h4>
					<p><?php esc_html_e('Go to dashboard >> Appearance >> Widgets >> Add widgets in footer 1, footer 2, footer 3, footer 4. >> ','yoga-studio'); ?></p>
					<a class="button-primary" href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widgets','yoga-studio'); ?></a>

					<h4><?php esc_html_e('5. Setup Footer Text','yoga-studio'); ?></h4>
					<p><?php esc_html_e('Go to dashboard >> Appearance >> Customize >> Footer Text >> Add copyright text. >> ','yoga-studio'); ?></p>
					<a class="button-primary" href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=yoga_studio_footer_copyright') ); ?>" target="_blank"><?php esc_html_e('Footer Text','yoga-studio'); ?></a>

					<h3><?php esc_html_e('Setup Home Page','yoga-studio'); ?></h3>
					<p><?php esc_html_e('To step the home page follow the below steps.','yoga-studio'); ?></p>

					<h4><?php esc_html_e('1. Setup Page','yoga-studio'); ?></h4>
					<p><?php esc_html_e('Go to dashboard >> Pages >> Add New Page >> Select "Custom Home Page" from templates >> Publish it.','yoga-studio'); ?></p>
					<a class="dashboard_add_new_page button-primary"><?php esc_html_e('Add New Page','yoga-studio'); ?></a>

					<h4><?php esc_html_e('2. Setup Slider','yoga-studio'); ?></h4>
					<p><?php esc_html_e('Go to dashboard >> Post >> Add New Post >> Add title, content and featured image >> Publish it.','yoga-studio'); ?></p>
					<p><?php esc_html_e('Go to dashboard >> Appearance >> Customize >> Slider Settings >> Select post.','yoga-studio'); ?></p>
					<a class="button-primary" href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=yoga_studio_slider_section') ); ?>" target="_blank"><?php esc_html_e('Add Slider','yoga-studio'); ?></a>

					<h4><?php esc_html_e('3. Setup Services','yoga-studio'); ?></h4>
					<p><?php esc_html_e('Go to dashboard >> Post >> Add New Category >> Add Category Name >> Publish it.','yoga-studio'); ?></p>
					<p><?php esc_html_e('Go to dashboard >> Post >> Add New Post >> Add title, content, select category and featured image >> Publish it.','yoga-studio'); ?></p>
					<p><?php esc_html_e('Go to dashboard >> Appearance >> Customize >> Services Settings >> Select category','yoga-studio'); ?></p>
					<a class="button-primary" href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=yoga_studio_service_box_section') ); ?>" target="_blank"><?php esc_html_e('Add Services','yoga-studio'); ?></a>
				</div>
          	</div>
			<div class="col-md-3">
				<h3><?php echo esc_html(YOGA_STUDIO_THEME_NAME); ?></h3>
				<img class="yoga_studio_img_responsive" style="width: 100%;" src="<?php echo esc_url( $theme->get_screenshot() ); ?>" />
				<div class="pro-links">
					<hr>
					<a class="button-primary buynow" href="<?php echo esc_url( YOGA_STUDIO_BUY_PRO ); ?>" target="_blank"><?php esc_html_e('Buy Now', 'yoga-studio'); ?></a>
					<a class="button-primary livedemo" href="<?php echo esc_url( YOGA_STUDIO_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'yoga-studio'); ?></a>
					<a class="button-primary docs" href="<?php echo esc_url( YOGA_STUDIO_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation', 'yoga-studio'); ?></a>
					<hr>
				</div>
				<ul style="padding-top:10px">
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Responsive Design', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Boxed or fullwidth layout', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Shortcode Support', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Demo Importer', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Section Reordering', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Contact Page Template', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Multiple Blog Layouts', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Unlimited Color Options', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Designed with HTML5 and CSS3', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Customizable Design & Code', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Cross Browser Support', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Detailed Documentation Included', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Stylish Custom Widgets', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Patterns Background', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('WPML Compatible (Translation Ready)', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Woo-commerce Compatible', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Full Support', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('10+ Sections', 'yoga-studio');?> </li>
                    <li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Live Customizer', 'yoga-studio');?> </li>
                   	<li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('AMP Ready', 'yoga-studio');?> </li>
                   	<li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Clean Code', 'yoga-studio');?> </li>
                   	<li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('SEO Friendly', 'yoga-studio');?> </li>
                   	<li class="upsell-yoga_studio"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Supper Fast', 'yoga-studio');?> </li>                    
                </ul>
        	</div>
		</div>
	</div>

<?php }?>
