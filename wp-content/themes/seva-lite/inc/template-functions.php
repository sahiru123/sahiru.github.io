<?php
/**
 * Seva Lite Template Functions which enhance the theme by hooking into WordPress
 *
 * @package Seva_Lite
 */

if( ! function_exists( 'seva_lite_doctype' ) ) :
/**
 * Doctype Declaration
*/
function seva_lite_doctype(){ ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'seva_lite_doctype', 'seva_lite_doctype' );

if( ! function_exists( 'seva_lite_head' ) ) :
/**
 * Before wp_head 
*/
function seva_lite_head(){ ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
}
endif;
add_action( 'seva_lite_before_wp_head', 'seva_lite_head' );

if( ! function_exists( 'seva_lite_page_start' ) ) :
/**
 * Page Start
*/
function seva_lite_page_start(){ ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content (Press Enter)', 'seva-lite' ); ?></a>
    <?php
}
endif;
add_action( 'seva_lite_before_header', 'seva_lite_page_start', 20 );

if( ! function_exists( 'seva_lite_header' ) ) :
/**
 * Header Start
*/
function seva_lite_header(){
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
    <?php
}
endif;
add_action( 'seva_lite_header', 'seva_lite_header', 20 );

if( ! function_exists( 'seva_lite_content_start' ) ) :
/**
 * Content Start
*/
function seva_lite_content_start(){       
    global $post;
    $home_sections = seva_lite_get_home_sections();
    $ed_elementor  = get_theme_mod( 'ed_elementor', false ); 
    $ed_banner     = get_theme_mod( 'ed_banner_section', 'static_banner' ); 
    echo '<div id="content" class="site-content">';
    if( is_front_page() && !$home_sections && $ed_banner == 'no_banner' && get_option( 'page_on_front' ) == $post->ID && !( seva_lite_is_elementor_activated() && seva_lite_is_elementor_activated_post() ) ) echo '<div class="container">';
    if( is_singular( array( 'page', 'elementor_library' ) ) && seva_lite_is_elementor_activated() && seva_lite_is_elementor_activated_post() ) return false;
    if( !( is_front_page() && ! is_home() ) && ! is_404() && !is_singular( 'post' ) && ! is_page_template( 'templates/event.php' ) && ! is_singular( 'seva-event' ) ) seva_lite_page_header();
    
    if( is_singular( 'post' ) ) { ?>
        <div class="breadcrumb-wrapper">
            <div class="container">
                <?php seva_lite_breadcrumb(); ?>
            </div>
        </div><!-- .breadcrumb-wrapper --> 
    <?php }

    if( !( is_front_page() && ! is_home() ) ) echo '<div class="container">';
}
endif;
add_action( 'seva_lite_content', 'seva_lite_content_start' );

if ( ! function_exists( 'seva_lite_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function seva_lite_post_thumbnail() {
	global $wp_query;
    $image_size     = 'thumbnail';
    $ed_featured    = get_theme_mod( 'ed_featured_image', true );
    $ed_crop_blog   = get_theme_mod( 'ed_crop_blog', false );
    $ed_crop_single = get_theme_mod( 'ed_crop_single', false );
    $sidebar        = seva_lite_sidebar();
    
    if( is_home() || is_archive() || is_search() ){ 
        if ( is_tax( 'blossom_portfolio_categories' ) ) {
            $image_size = 'seva-lite-blog-full';           
        }else{
            $image_size = ( $sidebar ) ? 'seva-lite-blog' : 'seva-lite-blog-full';
        }       
        if( has_post_thumbnail() ){                        
            echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '">';
                if( $ed_crop_blog ){
                    the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );    
                }else{
                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
                }
            echo '</a></figure>';
        }       
    }elseif( is_singular() ){
        $image_size = ( $sidebar ) ? 'seva-lite-single' : 'seva-lite-blog-full';
        if( is_single() ){
            if( $ed_featured && has_post_thumbnail() ){
                echo '<figure class="post-thumbnail">';
                if( $ed_crop_single ){
                    the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
                }else{
                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                }
                echo '</figure>';    
            }
        }else{
            if( has_post_thumbnail() ){
                echo '<div class="post-thumbnail">';
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                echo '</div>';    
            }            
        }
    }
}
endif;
add_action( 'seva_lite_before_page_entry_content', 'seva_lite_post_thumbnail' );
add_action( 'seva_lite_before_post_entry_content', 'seva_lite_post_thumbnail', 20 );
add_action( 'seva_lite_before_single_entry_content', 'seva_lite_post_thumbnail', 15 );

if( ! function_exists( 'seva_lite_entry_header' ) ) :
/**
 * Entry Header
*/
function seva_lite_entry_header(){ 
    ?>
    <header class="entry-header">
        <?php 
            seva_lite_category();
            
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
            endif; 
        
            if( 'post' === get_post_type() ){
                echo '<div class="entry-meta">';
                seva_lite_posted_on();
                echo '</div>';
            }       
        ?>
    </header>         
    <?php    
}
endif;
add_action( 'seva_lite_post_entry_content', 'seva_lite_entry_header', 10 );
add_action( 'seva_lite_before_single_entry_content', 'seva_lite_entry_header', 10 );

if( ! function_exists( 'seva_lite_entry_content' ) ) :
/**
 * Entry Content
*/
function seva_lite_entry_content(){ 
    $ed_excerpt          = get_theme_mod( 'ed_excerpt', true );
    ?>
    <div class="entry-content" itemprop="text">
		<?php
			if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
                the_content();    
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'seva-lite' ),
    				'after'  => '</div>',
    			) );
            }else{
                the_excerpt();
            }
        ?>
	</div><!-- .entry-content -->
    <?php
}
endif;
add_action( 'seva_lite_page_entry_content', 'seva_lite_entry_content', 15 );
add_action( 'seva_lite_post_entry_content', 'seva_lite_entry_content', 15 );
add_action( 'seva_lite_single_entry_content', 'seva_lite_entry_content', 15 );

if( ! function_exists( 'seva_lite_entry_footer' ) ) :
/**
 * Entry Footer
*/
function seva_lite_entry_footer(){ 
    $readmore = get_theme_mod( 'read_more_text', __( 'Read More', 'seva-lite' ) );
    ?>
	<footer class="entry-footer">
		<?php
			if( is_singular( 'post' ) ){
			    seva_lite_tag();
			}
            
            if( is_home() || is_archive() || is_search() ){
                echo '<div class="button-wrap"><a href="' . esc_url( get_the_permalink() ) . '" class="btn-link btn-readmore">' . esc_html( $readmore ) . '</a></div>';    
            }
            
            if( get_edit_post_link() ){
                edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'seva-lite' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
            }
		?>
	</footer><!-- .entry-footer -->
	<?php 
}
endif;
add_action( 'seva_lite_page_entry_content', 'seva_lite_entry_footer', 20 );
add_action( 'seva_lite_post_entry_content', 'seva_lite_entry_footer', 20 );
add_action( 'seva_lite_single_entry_content', 'seva_lite_entry_footer', 20 );

if( ! function_exists( 'seva_lite_navigation' ) ) :
/**
 * Navigation
*/
function seva_lite_navigation(){
    if( is_singular( 'post' ) ){
        $primary_color = '#FF5000';
        $next_post     = get_next_post();
        $prev_post     = get_previous_post();
        $sidebar       = seva_lite_sidebar();
        $image_size    = ( $sidebar ) ? 'seva-lite-related' : 'seva-lite-blog';

        $time_string = '<time class="entry-date published updated" datetime="%3$s" itemprop="dateModified">%4$s</time><time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );

        if( $prev_post || $next_post ){?>            
            <nav class="post-navigation pagination" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Post Navigation', 'seva-lite' ); ?></h2>
                <div class="nav-links">
                    <?php if( $prev_post ){ ?>
                    <div class="nav-previous">
                        <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
                            <article class="post">
                                <figure class="post-thumbnail">
                                    <?php
                                    $prev_img = get_post_thumbnail_id( $prev_post->ID );
                                    if( $prev_img ){
                                        $prev_url = wp_get_attachment_image_url( $prev_img, $image_size );
                                        echo '<img src="' . esc_url( $prev_url ) . '" alt="' . the_title_attribute( 'echo=0', $prev_post ) . '">';                                        
                                    }else{
                                        seva_lite_get_fallback_svg( $image_size );
                                    }
                                    ?>
                                </figure>
                                <div class="content-wrap">
                                    <header class="entry-header">
                                        <h3 class="entry-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></h3>
                                    </header>                               
                                </div>
                            </article>
                            <span class="meta-nav"><svg xmlns="http://www.w3.org/2000/svg" width="21.956" height="13.496" viewBox="0 0 21.956 13.496"><g id="Group_1417" data-name="Group 1417" transform="translate(742.952 0.612)"><path id="Path_1" data-name="Path 1" d="M1083.171,244.108h-20.837" transform="translate(-1804.667 -237.962)" fill="none" stroke="<?php echo ( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/><path id="Path_2" data-name="Path 2" d="M1093.614,226.065c-.695,2.593-1.669,4.985-6.7,6.143" transform="translate(-1829.267 -226.065)" fill="none" stroke="<?php echo ( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/><path id="Path_3" data-name="Path 3" d="M1093.614,232.208c-.695-2.593-1.669-4.985-6.7-6.143" transform="translate(-1829.267 -219.937)" fill="none" stroke="<?php echo ( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/></g></svg><?php esc_html_e( 'Previous', 'seva-lite' ); ?></span>
                        </a>                        
                    </div>
                    <?php } ?>
                    <?php if( $next_post ){ ?>
                    <div class="nav-next">
                        <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" rel="next">
                            <article class="post">
                                <figure class="post-thumbnail">
                                    <?php
                                    $next_img = get_post_thumbnail_id( $next_post->ID );
                                    if( $next_img ){
                                        $next_url = wp_get_attachment_image_url( $next_img, $image_size );
                                        echo '<img src="' . esc_url( $next_url ) . '" alt="' . the_title_attribute( 'echo=0', $next_post ) . '">';                                        
                                    }else{
                                        seva_lite_get_fallback_svg( $image_size );
                                    }
                                    ?>
                                </figure>
                                <div class="content-wrap">
                                    <header class="entry-header">
                                        <h3 class="entry-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></h3>
                                    </header>                               
                                </div>
                            </article>
                            <span class="meta-nav"><?php esc_html_e( 'Next', 'seva-lite' ); ?><svg xmlns="http://www.w3.org/2000/svg" width="21.956" height="13.496" viewBox="0 0 21.956 13.496"><g id="Group_1417" data-name="Group 1417" transform="translate(-721 -3593.056)"><path id="Path_1" data-name="Path 1" d="M1062.334,244.108h20.837" transform="translate(-340.835 3355.706)" fill="none" stroke="<?php echo ( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/><path id="Path_2" data-name="Path 2" d="M1086.915,226.065c.695,2.593,1.669,4.985,6.7,6.143" transform="translate(-351.258 3367.603)" fill="none" stroke="<?php echo ( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/><path id="Path_3" data-name="Path 3" d="M1086.915,232.208c.695-2.593,1.669-4.985,6.7-6.143" transform="translate(-351.258 3373.731)" fill="none" stroke="<?php echo ( seva_lite_sanitize_hex_color( $primary_color ) ); ?>" stroke-linecap="round" stroke-width="1"/></g></svg></span>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </nav>        
            <?php
        }
    }else{
            
        the_posts_pagination( array(
            'prev_text'          => __( 'Previous', 'seva-lite' ),
            'next_text'          => __( 'Next', 'seva-lite' ),
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'seva-lite' ) . ' </span>',
        ) );
    }
}
endif;
add_action( 'seva_lite_after_post_content', 'seva_lite_navigation', 15 );
add_action( 'seva_lite_after_posts_content', 'seva_lite_navigation' );

if( ! function_exists( 'seva_lite_author' ) ) :
/**
 * Author Section
*/
function seva_lite_author(){ 
    $ed_author    = get_theme_mod( 'ed_author', false );
    $author_title = get_the_author();
    $author_subtitle = get_theme_mod( 'author_subtitle', __( 'About The Author', 'seva-lite' ) );
    $author_description = get_the_author_meta( 'description' );
    
    if( ! $ed_author && $author_description ){ ?>
    <div class="author-section">
        <div class="author-img-title-wrap">
            <figure class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 170 ); ?></figure>
            <div class="author-title-wrap">
                <?php 
                    if( $author_subtitle ) echo '<span class="sub-title">' . esc_html( $author_subtitle ) . '</span>';
                    echo '<h1 class="author-name">' . esc_html( $author_title ) . '</h1>';
                ?>      
            </div>
        </div>
        <?php echo '<div class="author-content">' . wp_kses_post( wpautop( $author_description ) ) . '</div>'; ?>
    </div>
    <?php
    }
}
endif;
add_action( 'seva_lite_after_post_content', 'seva_lite_author', 25 );

if( ! function_exists( 'seva_lite_newsletter' ) ) :
/**
 * Newsletter
*/
function seva_lite_newsletter(){ 
    $ed_newsletter = get_theme_mod( 'ed_newsletter', false );
    $newsletter    = get_theme_mod( 'newsletter_shortcode' );
    if( $ed_newsletter && $newsletter ){ ?>
        <div class="newsletter">
            <?php echo do_shortcode( $newsletter ); ?>
        </div>
        <?php
    }
}
endif;
add_action( 'seva_lite_after_post_content', 'seva_lite_newsletter', 30 );

if( ! function_exists( 'seva_lite_related_posts' ) ) :
/**
 * Related Posts 
*/
function seva_lite_related_posts(){ 
    $ed_related_post = get_theme_mod( 'ed_related', true );
    
    if( $ed_related_post ){
        seva_lite_get_posts_list( 'related' );    
    }
}
endif;                                                                               
add_action( 'seva_lite_after_post_content', 'seva_lite_related_posts', 35 );

if( ! function_exists( 'seva_lite_latest_posts' ) ) :
/**
 * Latest Posts
*/
function seva_lite_latest_posts(){ 
    seva_lite_get_posts_list( 'latest' );
}
endif;
add_action( 'seva_lite_latest_posts', 'seva_lite_latest_posts' );

if( ! function_exists( 'seva_lite_comment' ) ) :
/**
 * Comments Template 
*/
function seva_lite_comment(){
    // If comments are open or we have at least one comment, load up the comment template.
	if( get_theme_mod( 'ed_comments', true ) && ( comments_open() || get_comments_number() ) ) :
		comments_template();
	endif;
}
endif;
add_action( 'seva_lite_after_post_content', 'seva_lite_comment', seva_lite_comment_toggle() );
add_action( 'seva_lite_after_page_content', 'seva_lite_comment' );

if( ! function_exists( 'seva_lite_content_end' ) ) :
/**
 * Content End
*/
function seva_lite_content_end(){ 
    global $post;
    $ed_elementor   = get_theme_mod( 'ed_elementor', false );
    $ed_banner      = get_theme_mod( 'ed_banner_section', 'static_banner' );

    $home_sections = seva_lite_get_home_sections(); 
    if( is_front_page() && !$home_sections && $ed_banner == 'no_banner' && get_option( 'page_on_front' ) == $post->ID && !( seva_lite_is_elementor_activated() && seva_lite_is_elementor_activated_post() ) ) echo '</div><!-- .container/page -->';
    if( !( is_front_page() && ! is_home() && $home_sections ) && !( is_singular( array( 'page', 'elementor_library' ) ) && seva_lite_is_elementor_activated() && seva_lite_is_elementor_activated_post() ) ){ ?>            
        </div><!-- .container/ -->        
    <?php }
    echo '</div><!-- .site-content -->';
}
endif;
add_action( 'seva_lite_before_footer', 'seva_lite_content_end', 20 );

if( ! function_exists( 'seva_lite_instagram' ) ) :
/**
 * Before Footer
*/
function seva_lite_instagram(){ 

    if( seva_lite_is_btif_activated() ){
        $ed_instagram = get_theme_mod( 'ed_instagram', false );
        if( $ed_instagram ){
            echo '<div class="instagram-section">';
            echo do_shortcode( '[blossomthemes_instagram_feed]' );
            echo '</div>';    
        }
    }
}
endif;
add_action( 'seva_lite_before_footer', 'seva_lite_instagram', 30 );

if( ! function_exists( 'seva_lite_footer_start' ) ) :
/**
 * Footer Start
*/
function seva_lite_footer_start(){
    ?>
    <footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'seva_lite_footer', 'seva_lite_footer_start', 20 );

if( ! function_exists( 'seva_lite_footer_top' ) ) :
/**
 * Footer Top
*/
function seva_lite_footer_top(){ 
    $footer_branding = get_theme_mod( 'ed_footer_branding', true );
    if( $footer_branding ){ ?>
        <div class="footer-top">
            <div class="container">
                <div class="footer-brand-area">
                    <?php seva_lite_site_branding(); ?>
                    <?php seva_lite_footer_navigation(); ?>
                </div>
            </div>
        </div>
    <?php } 
}
endif;
add_action( 'seva_lite_footer', 'seva_lite_footer_top', 25 );

if( ! function_exists( 'seva_lite_footer_mid' ) ) :
/**
 * Footer Mid
*/
function seva_lite_footer_mid(){    
    $footer_sidebars = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
    $active_sidebars = array();
    $sidebar_count   = 0;
    
    foreach ( $footer_sidebars as $sidebar ) {
        if( is_active_sidebar( $sidebar ) ){
            array_push( $active_sidebars, $sidebar );
            $sidebar_count++ ;
        }
    }
                 
    if( $active_sidebars ){ ?>
        <div class="footer-mid">
            <div class="container">
                <div class="grid column-<?php echo esc_attr( $sidebar_count ); ?>">
                <?php foreach( $active_sidebars as $active ){ ?>
                    <div class="col">
                       <?php dynamic_sidebar( $active ); ?> 
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
        <?php 
    }
}
endif;
add_action( 'seva_lite_footer', 'seva_lite_footer_mid', 30 );

if( ! function_exists( 'seva_lite_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function seva_lite_footer_bottom(){ 
    ?>
    <div class="footer-bottom">
		<div class="container">
			<div class="site-info">            
            <?php
                seva_lite_get_footer_copyright();
                echo esc_html__( ' Seva Lite | Developed By ', 'seva-lite' ); 
                echo '<a href="' . esc_url( 'https://blossomthemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Blossom Themes', 'seva-lite' ) . '</a>.';                
                printf( esc_html__( ' Powered by %s. ', 'seva-lite' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'seva-lite' ) ) .'" target="_blank">WordPress</a>' );
                if( function_exists( 'the_privacy_policy_link' ) ){
                    the_privacy_policy_link();
                }
            ?>               
            </div>
            <?php if( seva_lite_social_links( false ) ) : ?>
                <div class="footer-social-network">
                    <?php seva_lite_social_links(); ?>
                </div>
            <?php endif; ?>
		</div>
	</div>
    <?php
}
endif;
add_action( 'seva_lite_footer', 'seva_lite_footer_bottom', 40 );

if( ! function_exists( 'seva_lite_footer_end' ) ) :
/**
 * Footer End 
*/
function seva_lite_footer_end(){ ?>
        <button id="back-to-top-btn"></button>
    </footer><!-- #colophon -->
    <?php
}
endif;
add_action( 'seva_lite_footer', 'seva_lite_footer_end', 50 );

if( ! function_exists( 'seva_lite_page_end' ) ) :
/**
 * Page End
*/
function seva_lite_page_end(){ ?>
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'seva_lite_after_footer', 'seva_lite_page_end', 20 );