<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * @package Seva_Lite
 */

$error_404_image = get_theme_mod( 'error_404_image', get_template_directory_uri() . '/images/error.jpg' );

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<section class="error-404 not-found">
				<div class="container">
					<div class="error-404-content-wrapper">
						<?php if( $error_404_image ) : ?>
							<figure class="error-img">
			                    <img src="<?php echo esc_url( $error_404_image ); ?>" alt="<?php esc_attr_e( 'error image', 'seva-lite' ); ?>">
			                </figure>
						<?php endif; ?>
						<div class="page-content">
							<span class="error404-text"><?php esc_html_e( '404 error', 'seva-lite' ); ?></span>
                            <h2><?php esc_html_e( 'Page Not found!', 'seva-lite' ); ?></h2>
							<p><?php esc_html_e( 'The page you are looking for may have been moved, deleted, or possibly never existed.', 'seva-lite' ); ?></p>
							<a class="seva-btn btn-primary-one" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go to Homepage', 'seva-lite' ); ?></a>
						</div><!-- .page-content -->
						<div class="error-404-search">
							<?php get_search_form(); ?>
						</div>
					</div>
				</div>
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
    
    <?php
    /**
     * @see seva_lite_latest_posts
    */
    do_action( 'seva_lite_latest_posts' );
    
get_footer();