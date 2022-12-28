<?php
/**
 * Blog Section
 * 
 * @package Seva_Lite
 */

$blog_title      = get_theme_mod( 'blog_section_title', __( 'Latest Articles', 'seva-lite' ) );
$bog_subtitle    = get_theme_mod( 'blog_section_subtitle', __( 'BLOG', 'seva-lite' ) );
$blog_content    = get_theme_mod( 'blog_section_content' );
$readmore     = get_theme_mod( 'blog_readmore', __( 'Read More', 'seva-lite' ) );
$blog         = get_option( 'page_for_posts' );
$label        = get_theme_mod( 'blog_view_all', __( 'VIEW ALL ARTICLES', 'seva-lite' ) );
$ed_crop_blog = get_theme_mod( 'ed_crop_blog', false );

$args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => true
);

$qry = new WP_Query( $args );

if( $blog_title || $bog_subtitle || $blog_content || $qry->have_posts() ){ ?>

<section id="blog_section" class="blog-section">
	<div class="container">
        
        <?php if( $blog_title || $bog_subtitle || $blog_content ){ ?>
            <header class="section-header wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">	
                <?php 
                    if( $bog_subtitle ) echo '<span class="section-subtitle">' . esc_html( $bog_subtitle ) . '</span>'; 
                    if( $blog_title ) echo '<h2 class="section-title">' . esc_html( $blog_title ) . '</h2>';
                    if( $blog_content ) echo '<div class="section-desc">' . wp_kses_post( wpautop( $blog_content ) ) . '</div>'; 
                ?>
    		</header>
        <?php } ?>
        
        <?php if( $qry->have_posts() ){ ?>
            <div class="blog-inner-wrapper">
    			<?php 
                while( $qry->have_posts() ){
                    $qry->the_post(); ?>
                    <article class="post horizontal wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
        				<figure class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                            <?php 
                                if( has_post_thumbnail() ){
                                    if( $ed_crop_blog ){
                                        the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
                                    }else{
                                        the_post_thumbnail( 'seva-lite-blog-section', array( 'itemprop' => 'image' ) );
                                    }
                                }else{ 
                                    seva_lite_get_fallback_svg( 'seva-lite-blog-section' );//fallback
                                }                            
                            ?>                        
                            </a>
                        </figure>
                        <div class="content-wrap">
        					<header class="entry-header">
                                <div class="entry-meta">
                                    <?php seva_lite_category(); ?>
                                </div>
        					</header>
                            <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php if( $qry->current_post == 0 ) : ?>
            					<div class="entry-content">
            						<?php the_excerpt(); ?>
            					</div>        					
                                <div class="button-wrap">
                                    <a href="<?php the_permalink(); ?>" class="btn-link btn-readmore"><?php echo esc_html( $readmore ); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
        			</article>			
        			<?php 
                }
                wp_reset_postdata();
                ?>
    		</div>
    		
            <?php if( $blog && $label ){ ?>
                <div class="section-button-wrapper wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
        			<a href="<?php the_permalink( $blog ); ?>" class="seva-btn btn-primary-two"><?php echo esc_html( $label ); ?></a>
        		</div>
            <?php } ?>
        
        <?php } ?>
	</div>
</section>
<?php 
}