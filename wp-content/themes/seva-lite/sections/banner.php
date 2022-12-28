<?php
/**
 * Banner Section
 * 
 * @package Seva_Lite
 */

$ed_banner        = get_theme_mod( 'ed_banner_section', 'static_banner' );
$slider_type      = get_theme_mod( 'slider_type', 'latest_posts' ); 
$slider_cat       = get_theme_mod( 'slider_cat' );
$posts_per_page   = get_theme_mod( 'no_of_slides', 3 );
$ed_full_image    = get_theme_mod( 'slider_full_image', false );
$ed_caption       = get_theme_mod( 'slider_caption', true );
$read_more        = get_theme_mod( 'slider_readmore', __( 'Read More', 'seva-lite' ) );
$banner_title     = get_theme_mod( 'banner_title', __( 'Let\'s Build your Dream life together', 'seva-lite' ) );
$banner_subtitle  = get_theme_mod( 'banner_subtitle', __( 'Welcome', 'seva-lite' ) );
$banner_content   = get_theme_mod( 'banner_content', __( 'To empower women to make a positive impact on the world with fiery passion, unbridled self-belief, and head-turning style.', 'seva-lite' ) );
$banner_label     = get_theme_mod( 'banner_label', __( 'GET STARTED', 'seva-lite' ) );
$banner_link      = get_theme_mod( 'banner_link', '#' );
$banner_caption_layout    = get_theme_mod( 'banner_caption_layout', 'left' );
        
if( $ed_banner == 'static_banner' && has_custom_header() ){ ?>
    <div id="banner_section" class="site-banner static-cta style-six<?php if( has_header_video() ) echo esc_attr( ' video-banner' ); ?>">
        <div class="container">
            <div class="item <?php echo esc_attr( $banner_caption_layout ); ?>">
            <?php 
                the_custom_header_markup(); 
                if( $banner_title || $banner_subtitle || $banner_content || ( $banner_label && $banner_link ) ){
                    echo '<div class="banner-caption">';
                    if( $banner_subtitle ) echo '<h5 class="subtitle">' . esc_html( $banner_subtitle ) . '</h5>';
                    if( $banner_title ) echo '<h2 class="title">' . esc_html( $banner_title ) . '</h2>';
                    if( $banner_content ) echo '<div class="banner-desc">' . wp_kses_post( wpautop( $banner_content ) ) . '</div>';
            		if( $banner_label && $banner_link ) echo '<div class="button-wrap"><a href="' . esc_url( $banner_link ) . '" class="seva-btn btn-primary-one">' . esc_html( $banner_label ) . '</a></div>';
                    echo '</div>';
                }
                
            ?>
            </div>
        </div>
    </div>
<?php
}elseif( $ed_banner == 'slider_banner' ){
    if( $slider_type == 'latest_posts' || $slider_type == 'cat' || $slider_type == 'pages' ){
        $image_size = $ed_full_image ? 'full' : 'seva-lite-slider';
        $args = array(
            'post_status'         => 'publish',            
            'ignore_sticky_posts' => true
        );
        
        if( $slider_type === 'cat' && $slider_cat ){
            $args['post_type']      = 'post';
            $args['cat']            = $slider_cat; 
            $args['posts_per_page'] = -1;  
        }elseif( $slider_type == 'pages' && $slider_pages ){
            $args['post_type']      = 'page';
            $args['posts_per_page'] = -1;
            $args['post__in']       = seva_lite_get_id_from_page( $slider_pages );
            $args['orderby']        = 'post__in';
        }else{
            $args['post_type']      = 'post';
            $args['posts_per_page'] = $posts_per_page;
        }
            
        $qry = new WP_Query( $args );
        
        if( $qry->have_posts() ){ ?>
            <div id="banner_section" class="site-banner banner-slider style-one">
                <div class="container">
                    <div class="item-wrap owl-carousel">            
            			<?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                        <div class="item<?php if( $ed_full_image ) echo ' full-image'; ?>">
                            <div class="banner-img">
                				<?php 
                                if( has_post_thumbnail() ){
                				    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
                				}else{ 
                				    seva_lite_get_fallback_svg( 'seva-lite-slider' );//fallback
                                } ?>
                            </div>
                            <?php                        
                			if( $ed_caption ){
                                echo '<div class="banner-caption">';
                                the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                echo '<div class="banner-desc">' . esc_html( get_the_excerpt() ) . '</div>';
                                if( $read_more ) {
                                    echo '<div class="button-wrap"><a href="' . esc_url( get_permalink() ) . '" class="seva-btn btn-primary-one">' . esc_html( $read_more ) . '</a></div>';
                                }
                                echo '</div>';
                            } ?>
            			</div>
            			<?php } ?>                        
                    </div>
                </div>                
        	</div>
        <?php
        wp_reset_postdata();
        }
    
    }
}