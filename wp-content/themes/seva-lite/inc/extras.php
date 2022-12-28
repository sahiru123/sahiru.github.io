<?php
/**
 * Seva Lite Standalone Functions.
 *
 * @package Seva_Lite
 */

if ( ! function_exists( 'seva_lite_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function seva_lite_posted_on() {
    $ed_post_date   = get_theme_mod( 'ed_post_date', false );
    if( $ed_post_date ) return false;

	$ed_updated_post_date = get_theme_mod( 'ed_post_update_date', true );
    $on = __( 'on ', 'seva-lite' );
    
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		if( $ed_updated_post_date ){
            $time_string = '<time class="entry-date published updated" datetime="%3$s" itemprop="dateModified">%4$s</time><time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';
            $on = __( 'Updated on ', 'seva-lite' );		  
		}else{
            $time_string = '<time class="entry-date published" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';  
		}        
	}else{
	   $time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';   
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
    
    $posted_on = sprintf( '%1$s %2$s', esc_html( $on ), '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>' );
	
	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'seva_lite_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current author.
 */
function seva_lite_posted_by() {
    $ed_post_author   = get_theme_mod( 'ed_post_author', false );
    if( $ed_post_author ) return false;
    
	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( '%s', 'post author', 'seva-lite' ),
		'<span itemprop="name"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" itemprop="url">' . esc_html( get_the_author() ) . '</a></span>' 
    );
    echo '<figure class="author-img">'; 
    echo get_avatar( get_the_author_meta( 'ID' ), 57 );
    echo '</figure>';
	echo '<span class="byline" itemprop="author" itemscope itemtype="https://schema.org/Person">' . $byline . '</span>';
}
endif;

if( ! function_exists( 'seva_lite_comment_count' ) ) :
/**
 * Comment Count
*/
function seva_lite_comment_count(){
    if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments"><i class="far fa-comment"></i>';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'seva-lite' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}    
}
endif;

if ( ! function_exists( 'seva_lite_category' ) ) :
/**
 * Prints categories
 */
function seva_lite_category(){
    $ed_cat_single  = get_theme_mod( 'ed_category', false );
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() && ! $ed_cat_single ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ' ', 'seva-lite' ) );
		if ( $categories_list ) {
			echo '<div class="entry-meta"><span class="category" itemprop="about">' . $categories_list . '</span></div>';
		}
	}
}
endif;

if ( ! function_exists( 'seva_lite_tag' ) ) :
/**
 * Prints tags
 */
function seva_lite_tag(){
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<div class="tags" itemprop="about">' . esc_html__( '%1$sTags:%2$s %3$s', 'seva-lite' ) . '</div>', '<span>', '</span>', $tags_list );
		}
	}
}
endif;

if( ! function_exists( 'seva_lite_get_posts_list' ) ) :
/**
 * Returns Latest, Related & Popular Posts
*/
function seva_lite_get_posts_list( $status ){
    global $post;
    if( !( is_singular( 'post' ) || is_404() ) ) return false;
    
    $args = array(
        'post_type'           => 'post',
        'posts_status'        => 'publish',
        'ignore_sticky_posts' => true
    );
    
    switch( $status ){
        case 'latest':        
        $args['posts_per_page'] = 3;
        $title                  = __( 'Recommended Articles', 'seva-lite' );
        $class                  = 'additional-post';
        $read_more              = get_theme_mod( 'read_more_text', __( 'Read More', 'seva-lite' ) );
        $add_it                 = false;
        $image_size             = 'seva-lite-related';        
        $blog                   = get_option( 'page_for_posts' );
        $label                  = get_theme_mod( 'error_404_button_label', __( 'Go To Blog', 'seva-lite' ) );
        break;
        
        case 'related':
        $args['posts_per_page'] = 3;
        $args['post__not_in']   = array( $post->ID );
        $args['orderby']        = 'rand';
        $title                  = get_theme_mod( 'related_post_title', __( 'You may also like...', 'seva-lite' ) );
        $read_more              = get_theme_mod( 'read_more_text', __( 'Read More', 'seva-lite' ) );
        $add_it                 = false;
        $class                  = 'additional-post';
        $image_size             = 'seva-lite-related';
        $blog                   = '';
        $label                  = '';
        $cats                   = get_the_category( $post->ID );        
        if( $cats ){
            $c = array();
            foreach( $cats as $cat ){
                $c[] = $cat->term_id; 
            }
            $args['category__in'] = $c;
        }        
        break;        
    }
    
    $qry = new WP_Query( $args );
    
    if( $qry->have_posts() ){ ?>    
        <div class="<?php echo esc_attr( $class ); ?>">
    		<?php 
            if( $title ) echo '<h5 class="post-title">' . esc_html( $title ) . '</h5>'; ?>
            <div class="article-wrap">
    			<?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                    <article class="post">
                        <figure class="post-thumbnail">
            				<a href="<?php the_permalink(); ?>">
                                <?php
                                    if( has_post_thumbnail() ){
                                        the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                                    }else{ 
                                        seva_lite_get_fallback_svg( $image_size );//fallback
                                    }
                                ?>
                            </a>
                        </figure>
                        <div class="content-wrap">
            				<header class="entry-header">
                                <?php seva_lite_category(); ?>
                                <?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
            				</header>
                            <?php if( $add_it ) : ?>
                                <div class="entry-content">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>
                            <?php if( $read_more && $add_it ) : ?>
                                <div class="button-wrap">
                                    <a href="<?php the_permalink(); ?>" class="btn-link btn-readmore"><?php echo esc_html( $read_more ); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
        			</article>
    			<?php } ?>    		
            </div>
            <?php if( $blog && $label ) :   ?>
                <div class="section-button-wrapper">
                    <a href="<?php the_permalink( $blog ); ?>" class="seva-btn btn-primary-two"><?php echo esc_html( $label ); ?></a>
                </div>
            <?php endif; ?>
    	</div>
        <?php
        wp_reset_postdata();
    }
}
endif;

if( ! function_exists( 'seva_lite_site_branding' ) ) :
/**
 * Site Branding
*/
function seva_lite_site_branding(){
    $site_title       = get_bloginfo( 'name' );
    $site_description = get_bloginfo( 'description', 'display' );
    $header_text      = get_theme_mod( 'header_text', 1 );

    if( has_custom_logo() || $site_title || $site_description || $header_text ) :
        if( has_custom_logo() && ( $site_title || $site_description ) && $header_text ) {
            $branding_class = ' has-image-text';
        }else{
            $branding_class = '';
        }?>
        <div class="site-branding<?php echo esc_attr( $branding_class ); ?>" itemscope itemtype="http://schema.org/Organization">  
                <?php 
                if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                    echo '<div class="site-logo">';
                    the_custom_logo();
                    echo '</div>';
                }  ?>

            <?php 
            if( $site_title || $site_description ) :
                echo '<div class="site-title-wrap">';
                if( is_front_page() ){ ?>
                    <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php 
                }else{ ?>
                    <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                <?php }
                
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ){ ?>
                    <p class="site-description" itemprop="description"><?php echo $description; ?></p>
                <?php }
                echo '</div>';
            endif; ?>
        </div>    
    <?php endif;
}
endif;

if( ! function_exists( 'seva_lite_social_links' ) ) :
/**
 * Social Links 
*/
function seva_lite_social_links( $echo = true ){ 
    $social_links = get_theme_mod( 'social_links' );
    $ed_social    = get_theme_mod( 'ed_social_links', true ); 
    
    if( $ed_social && $social_links && $echo ){ ?>
    <ul class="social-list">
    	<?php 
        foreach( $social_links as $link ){
    	    if( $link['link'] ){ ?>
            <li>
                <a href="<?php echo esc_url( $link['link'] ); ?>" target="_blank" rel="nofollow noopener">
                    <i class="<?php echo esc_attr( $link['font'] ); ?>"></i>
                </a>
            </li>    	   
            <?php
            } 
        } 
        ?>
	</ul>
    <?php    
    }elseif( $ed_social && $social_links ){
        return true;
    }else{
        return false;
    }
    ?>
    <?php                                
}
endif;

if( ! function_exists( 'seva_lite_contact_button' ) ) :
/**
 * Form 
*/
function seva_lite_contact_button(){ 
    $ed_contact            = get_theme_mod( 'ed_contact_button', false );
    $header_contact_button = get_theme_mod( 'header_contact_button' );
    $header_contact_url    = get_theme_mod( 'header_contact_url' );
    $ed_new_tab            = get_theme_mod( 'ed_header_new_tab', false );
    $target                = ( $ed_new_tab ) ? ' target="_blank"' : '';
    
    if( $ed_contact && $header_contact_button && $header_contact_url ) : ?>
        <div class="header-button-wrap">
            <a href="<?php echo esc_url( $header_contact_url ); ?>" class="header-inquiry-btn header-btn seva-btn btn-sm" <?php echo esc_attr( $target ); ?>><?php echo esc_html( $header_contact_button ); ?></a>
        </div>
    <?php
    endif;
}
endif;

if( ! function_exists( 'seva_lite_header_contact' ) ) :
/**
 * Form 
*/
function seva_lite_header_contact(){ 
    $phone = get_theme_mod( 'phone' );
    $email = get_theme_mod( 'email' );

    if( $phone || $email ) :
        if( !empty( $phone ) ) echo '<div class="header-block"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="11.994" viewBox="0 0 12 11.994">
			    <path id="Path_23542" data-name="Path 23542" d="M14.446,13.234c-.229,0-.446.194-.932.681-.132.126-.309.309-.343.332a3.447,3.447,0,0,1-2.534-1.27A6.738,6.738,0,0,1,8.852,9.963a5.091,5.091,0,0,1,.572-.538c.429-.355.572-.486.606-.658A11.966,11.966,0,0,0,8.371,5.793c-.137-.154-.257-.263-.412-.263C7.5,5.513,5.5,8.018,5.5,8.338c0,.029.04,2.694,3.432,6.1,2.671,2.671,4.656,3.089,5.64,3.089h.063l.04-.286v.286h0a10.511,10.511,0,0,0,2.6-1.807.572.572,0,0,0,.223-.383C17.511,14.842,14.64,13.234,14.446,13.234Z" transform="translate(-5.5 -5.53)" ></path>
			</svg><a class="phone" href="tel:' . preg_replace( '/[^\d+]/', '', $phone ) . '">' . esc_html( $phone ) . '</a></div>';
        if( !empty( $email ) ) echo '<div class="header-block"><svg xmlns="http://www.w3.org/2000/svg" width="14.25" height="11.347" viewBox="0 0 14.25 11.347">
				<path id="Path_23543" data-name="Path 23543" d="M18.261,19.055H4.3V9.544H5.8l5.278,3.537L16.89,8.65H4.261V7.958h14ZM4.993,18.363H17.569V9L11.1,13.931l-5.514-3.7H4.993Z" transform="translate(-4.136 -7.833)"  stroke-linecap="round" stroke-linejoin="round" stroke-width="0.25"></path>
			</svg></i><a class="email" href="mailto:' . sanitize_email( $email ) . '">' . sanitize_email( $email ) . '</a></div>';
    endif;
}
endif;

if( ! function_exists( 'seva_lite_primary_navigation' ) ) :
/**
 * Primary Navigation.
*/
function seva_lite_primary_navigation(){ 
    
    if( current_user_can( 'manage_options' ) || has_nav_menu( 'primary' ) ) { ?>
    	<nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
            <button class="toggle-btn">
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
            </button>
    		<?php
    			wp_nav_menu( array(
    				'theme_location' => 'primary',
                    'menu_class'     => 'nav-menu',
    				'menu_id'        => 'primary-menu',
                    'fallback_cb'    => 'seva_lite_primary_menu_fallback',
    			) );
    		?>
    	</nav><!-- #site-navigation -->
        <?php
    }
}
endif;

if( ! function_exists( 'seva_lite_primary_menu_fallback' ) ) :
/**
 * Fallback for primary menu
*/
function seva_lite_primary_menu_fallback(){
    if( current_user_can( 'manage_options' ) ){
        echo '<div class="menu-primary-container"><ul id="primary-menu" class="nav-menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to add a menu', 'seva-lite' ) . '</a></li>';
        echo '</ul></div>';
    }
}
endif;

if( ! function_exists( 'seva_lite_sticky_navigation' ) ) :
/**
 * Sticky Navigation
*/
function seva_lite_sticky_navigation(){ 

    if( current_user_can( 'manage_options' ) || has_nav_menu( 'primary' ) ) { ?>
        <nav id="sticky-navigation" class="main-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
            <button class="toggle-btn">
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
            </button>
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'nav-menu',
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => 'seva_lite_primary_menu_fallback',
                ) );
            ?>
        </nav><!-- #site-navigation -->
    <?php
    }
}
endif;

if( ! function_exists( 'seva_lite_mobile_navigation' ) ) :
/**
 * Mobile Navigation
*/
function seva_lite_mobile_navigation(){ 
    ?>
    <div class="mobile-header">
        <div class="header-main">
            <div class="container">
                <div class="mob-nav-site-branding-wrap">
                    <div class="header-left">
                        <div class="toggle-btn-wrap">
                            <button class="toggle-btn">
                                <span class="toggle-bar"></span>
                                <span class="toggle-bar"></span>
                                <span class="toggle-bar"></span>
                            </button>
                        </div>          
                    </div>
                    <div class="header-center">
                        <?php seva_lite_site_branding(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom-slide">
            <div class="header-bottom-slide-inner">
                <div class="container">
                    <div class="mobile-header-wrap">
                        <?php if( seva_lite_social_links( false ) ){
                            echo '<div class="header-social">';
                            seva_lite_social_links();
                            echo '</div>';
                        } ?>
                        <button class="close"></button>
                    </div>
                    <div class="mobile-header-wrapper">
                        <div class="header-left">
                            <?php seva_lite_primary_navigation(); ?>
                        </div>
                        <div class="header-right">
                            <?php seva_lite_secondary_navigation(); ?>
                        </div>
                    </div>
                    <div class="mob-ctc-btn"> 
                        <?php seva_lite_header_contact(); ?>                   
                        <?php seva_lite_contact_button(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php   
}
endif;

if( ! function_exists( 'seva_lite_sticky_header' ) ) :
/**
 * Fallback for secondary menu
*/
function seva_lite_sticky_header(){ 
    $sticky_header = get_theme_mod( 'ed_sticky_header', false );
    if( $sticky_header ) : ?>
        <div class="sticky-header">
            <div class="container">
                <?php seva_lite_site_branding(); ?>
                <div class="nav-plus-btn-wrapper">
                    <?php seva_lite_sticky_navigation(); ?>
                    <?php seva_lite_contact_button(); ?>
                </div>
                
            </div>
        </div>
    <?php 
    endif;
}
endif;

if( ! function_exists( 'seva_lite_secondary_navigation' ) ) :
/**
 * Secondary Navigation
*/
function seva_lite_secondary_navigation(){ 
    if( current_user_can( 'manage_options' ) || has_nav_menu( 'secondary' ) ) { ?>
    	<nav id="secondary-nav" class="secondary-menu">
            <button class="toggle-btn">
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
            </button>
    		<?php
    			wp_nav_menu( array(
    				'theme_location' => 'secondary',
                    'menu_class'     => 'nav-menu',
    				'menu_id'        => 'secondary-menu',
                    'fallback_cb'    => 'seva_lite_secondary_menu_fallback',
    			) );
    		?>
    	</nav>
        <?php
    }
}
endif;

if( ! function_exists( 'seva_lite_secondary_menu_fallback' ) ) :
/**
 * Fallback for secondary menu
*/
function seva_lite_secondary_menu_fallback(){
    if( current_user_can( 'manage_options' ) ){
        echo '<div class="menu-secondary-container"><ul id="secondary-menu" class="nav-menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to add a menu', 'seva-lite' ) . '</a></li>';
        echo '</ul></div>';
    }
}
endif;

if( ! function_exists( 'seva_lite_footer_navigation' ) ) :
/**
 * footer Navigation
*/
function seva_lite_footer_navigation(){ ?>
    <nav class="footer-navigation">
        <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'menu_class'     => 'nav-menu',
                'menu_id'        => 'footer-menu',
                'fallback_cb'    => 'seva_lite_footer_menu_fallback',
            ) );
        ?>
    </nav>
    <?php
}
endif;

if( ! function_exists( 'seva_lite_footer_menu_fallback' ) ) :
/**
 * Fallback for footer menu
*/
function seva_lite_footer_menu_fallback(){
    if( current_user_can( 'manage_options' ) ){
        echo '<ul id="footer-menu" class="nav-menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to add a menu', 'seva-lite' ) . '</a></li>';
        echo '</ul>';
    }
}
endif;

if( ! function_exists( 'seva_lite_page_header' ) ) :
/**
 * Page Header
*/
function seva_lite_page_header(){ 

    if( seva_lite_is_woocommerce_activated() && is_singular( 'product' ) ) return false;
    if( seva_lite_is_learndash_lms_activated() && ( is_singular( 'sfwd-courses' ) || is_singular( 'sfwd-lessons' ) || is_singular( 'sfwd-topic' ) || is_singular( 'sfwd-quiz' ) || is_singular( 'sfwd-certificates' ) || is_singular( 'sfwd-assignment' ) ) ) return false;
    if( seva_lite_is_tutor_lms_activated() && is_singular( 'courses' ) ) return false;
    if( ! apply_filters( 'seva_lite_page_title', true ) ) return false;

    $blog_featured_post = get_theme_mod( 'blog_featured_post' );
    if( is_home() && !$blog_featured_post ) return false;
    $image_url = ( $blog_featured_post ) ? get_the_post_thumbnail_url( absint( $blog_featured_post ) ) : '';

    ?>
    <header class="page-header<?php if( is_home() && $image_url ) echo ' has-bg-img'; ?>" <?php if( is_home() && $image_url ) { ?> style="background-image: url('<?php echo esc_url( $image_url ); ?>');" <?php } ?>>
        <?php if( ! is_front_page() ) : ?>
            <div class="breadcrumb-wrapper">
                <div class="container">
                    <?php seva_lite_breadcrumb(); ?>
                </div>
            </div><!-- .breadcrumb-wrapper -->   
        <?php endif;
            echo '<div class="container">';
                if ( is_home() ){ 
                    seva_lite_blog_featured_post();
                }
                
                if( is_archive() ){ 
                    if( is_author() ){
                        $author_title = get_the_author();
                        $author_subtitle = get_theme_mod( 'author_subtitle', __( 'About The Author', 'seva-lite' ) );
                        $author_description = get_the_author_meta( 'description' ); ?>
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
                    else{
                        the_archive_title();
                        the_archive_description( '<div class="archive-description">', '</div>' );
                    }      
                }
                
                if( is_search() ){ 
                    echo '<span class="section-subtitle">' . esc_html__( 'SEARCH RESULT FOR', 'seva-lite' ) . '</span>';
                    get_search_form();
                }
                
                if( is_page() ){
                    the_title( '<h1 class="page-title">', '</h1>' );
                }
                
                if( is_archive() || is_search() ) seva_lite_per_page_count();
            ?>
        </div>
    </header>
    <?php
}
endif;

if( ! function_exists( 'seva_lite_breadcrumb' ) ) :
/**
 * Breadcrumbs
*/
function seva_lite_breadcrumb(){ 
    global $post;
    $post_page  = get_option( 'page_for_posts' ); //The ID of the page that displays posts.
    $show_front = get_option( 'show_on_front' ); //What to show on the front page    
    $home       = get_theme_mod( 'home_text', __( 'Home', 'seva-lite' ) ); // text for the 'Home' link
    $delimiter  = '<span class="separator"><i class="fas fa-angle-right"></i></span>';
    $before     = '<span class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'; // tag before the current crumb
    $after      = '</span>'; // tag after the current crumb
    
    if( get_theme_mod( 'ed_breadcrumb', true ) ){
        $depth = 1;
        echo '<div id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a href="' . esc_url( home_url() ) . '" itemprop="item"><span itemprop="name">' . esc_html( $home ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
        
        if( is_home() ){ 
            $depth = 2;                       
            echo $before . '<a itemprop="item" href="'. esc_url( get_the_permalink() ) .'"><span itemprop="name">' . esc_html( single_post_title( '', false ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;            
        }elseif( is_category() ){  
            $depth = 2;          
            $thisCat = get_category( get_query_var( 'cat' ), false );            
            if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                $p = get_post( $post_page );
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;  
            }            
            if( $thisCat->parent != 0 ){
                $parent_categories = get_category_parents( $thisCat->parent, false, ',' );
                $parent_categories = explode( ',', $parent_categories );
                foreach( $parent_categories as $parent_term ){
                    $parent_obj = get_term_by( 'name', $parent_term, 'category' );
                    if( is_object( $parent_obj ) ){
                        $term_url  = get_term_link( $parent_obj->term_id );
                        $term_name = $parent_obj->name;
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                        $depth++;
                    }
                }
            }
            echo $before . '<span itemprop="name">' .  esc_html( single_cat_title( '', false ) ) . '</span><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;       
        }elseif( seva_lite_is_woocommerce_activated() && ( is_product_category() || is_product_tag() ) ){ //For Woocommerce archive page
            $depth = 2;
            $current_term = $GLOBALS['wp_query']->get_queried_object();            
            if( wc_get_page_id( 'shop' ) ){ //Displaying Shop link in woocommerce archive page
                $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                if ( ! $_name ) {
                    $product_post_type = get_post_type_object( 'product' );
                    $_name = $product_post_type->labels->singular_name;
                }
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;
            }
            if( is_product_category() ){
                $ancestors = get_ancestors( $current_term->term_id, 'product_cat' );
                $ancestors = array_reverse( $ancestors );
                foreach ( $ancestors as $ancestor ) {
                    $ancestor = get_term( $ancestor, 'product_cat' );    
                    if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                        $depth++;
                    }
                }
            }
            echo $before . '<span itemprop="name">' . esc_html( $current_term->name ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
        }elseif( seva_lite_is_woocommerce_activated() && is_shop() ){ //Shop Archive page
            $depth = 2;
            if( get_option( 'page_on_front' ) == wc_get_page_id( 'shop' ) ){
                return;
            }
            $_name    = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
            $shop_url = ( wc_get_page_id( 'shop' ) && wc_get_page_id( 'shop' ) > 0 )  ? get_the_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );
            if( ! $_name ){
                $product_post_type = get_post_type_object( 'product' );
                $_name             = $product_post_type->labels->singular_name;
            }
            echo $before . '<span itemprop="name">' . esc_html( $_name ) . '</span><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_tag() ){ 
            $depth          = 2;
            $queried_object = get_queried_object();
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( single_tag_title( '', false ) ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />'. $after;
        }elseif( is_author() ){  
            global $author;
            $depth    = 2;
            $userdata = get_userdata( $author );
            echo $before . '<span itemprop="name">' . esc_html( $userdata->display_name ) .'</span><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;     
        }elseif( is_search() ){ 
            $depth       = 2;
            $request_uri = $_SERVER['REQUEST_URI'];
            echo $before . '<span itemprop="name">' . sprintf( __( 'Search Results for "%s"', 'seva-lite' ), esc_html( get_search_query() ) ) . '</span><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;        
        }elseif( is_day() ){            
            $depth = 2;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'seva-lite' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'seva-lite' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'seva-lite' ) ), get_the_time( __( 'm', 'seva-lite' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'seva-lite' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo $before . '<a itemprop="item" href="' . esc_url( get_day_link( get_the_time( __( 'Y', 'seva-lite' ) ), get_the_time( __( 'm', 'seva-lite' ) ), get_the_time( __( 'd', 'seva-lite' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'd', 'seva-lite' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;        
        }elseif( is_month() ){            
            $depth = 2;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'seva-lite' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'seva-lite' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo $before . '<a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'seva-lite' ) ), get_the_time( __( 'm', 'seva-lite' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'seva-lite' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;        
        }elseif( is_year() ){ 
            $depth = 2;
            echo $before .'<a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'seva-lite' ) ) ) ) . '"><span itemprop="name">'. esc_html( get_the_time( __( 'Y', 'seva-lite' ) ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;  
        }elseif( is_single() && !is_attachment() ){   
            $depth = 2;         
            if( seva_lite_is_woocommerce_activated() && 'product' === get_post_type() ){ //For Woocommerce single product
                if( wc_get_page_id( 'shop' ) ){ //Displaying Shop link in woocommerce archive page
                    $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                    if ( ! $_name ) {
                        $product_post_type = get_post_type_object( 'product' );
                        $_name = $product_post_type->labels->singular_name;
                    }
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                    $depth++;                    
                }           
                if( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ){
                    $main_term = apply_filters( 'woocommerce_breadcrumb_main_term', $terms[0], $terms );
                    $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                    $ancestors = array_reverse( $ancestors );
                    foreach ( $ancestors as $ancestor ) {
                        $ancestor = get_term( $ancestor, 'product_cat' );    
                        if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                            $depth++;
                        }
                    }
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( $main_term->name ) . '</span><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                    $depth++;
                }
                echo $before . '<span itemprop="name">' . esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
            }elseif( get_post_type() != 'post' ){                
                $post_type = get_post_type_object( get_post_type() );                
                if( $post_type->has_archive == true ){// For CPT Archive Link                   
                   // Add support for a non-standard label of 'archive_title' (special use case).
                   $label = !empty( $post_type->labels->archive_title ) ? $post_type->labels->archive_title : $post_type->labels->name;
                   echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( get_post_type() ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '</span>';
                   $depth++;    
                }
                echo $before . '<span itemprop="name">' . esc_html( get_the_title() ) . '</span><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
            }else{ //For Post                
                $cat_object       = get_the_category();
                $potential_parent = 0;
                if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                    $p = get_post( $post_page );
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '</span>';  
                    $depth++; 
                }
                
                if( $cat_object ){ //Getting category hierarchy if any        
                    //Now try to find the deepest term of those that we know of
                    $use_term = key( $cat_object );
                    foreach( $cat_object as $key => $object ){
                        //Can't use the next($cat_object) trick since order is unknown
                        if( $object->parent > 0  && ( $potential_parent === 0 || $object->parent === $potential_parent ) ){
                            $use_term         = $key;
                            $potential_parent = $object->term_id;
                        }
                    }                    
                    $cat  = $cat_object[$use_term];              
                    $cats = get_category_parents( $cat, false, ',' );
                    $cats = explode( ',', $cats );
                    foreach ( $cats as $cat ) {
                        $cat_obj = get_term_by( 'name', $cat, 'category' );
                        if( is_object( $cat_obj ) ){
                            $term_url  = get_term_link( $cat_obj->term_id );
                            $term_name = $cat_obj->name;
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $delimiter . '</span>';
                            $depth++;
                        }
                    }
                }
                echo $before . '<span itemprop="name">' . esc_html( get_the_title() ) . '</span><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;   
            }        
        }elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ){ //For Custom Post Archive
            $depth     = 2;
            $post_type = get_post_type_object( get_post_type() );
            if( get_query_var('paged') ){
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '/</span>';
                echo $before . sprintf( __('Page %s', 'seva-lite'), get_query_var('paged') ) . $after; //@todo need to check this
            }else{
                echo $before . '<span itemprop="name">' . esc_html( $post_type->label ) . '</span><meta itemprop="position" content="' . absint( $depth ). '" />' . $after;
            }    
        }elseif( is_attachment() ){ 
            $depth = 2;           
            echo $before . '<span itemprop="name">' . esc_html( get_the_title() ) . '</span><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_page() && !$post->post_parent ){            
            $depth = 2;
            echo $before . '<span itemprop="name">' . esc_html( get_the_title() ) . '</span><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_page() && $post->post_parent ){            
            $depth       = 2;
            $parent_id   = $post->post_parent;
            $breadcrumbs = array();
            while( $parent_id ){
                $current_page  = get_post( $parent_id );
                $breadcrumbs[] = $current_page->ID;
                $parent_id     = $current_page->post_parent;
            }
            $breadcrumbs = array_reverse( $breadcrumbs );
            for ( $i = 0; $i < count( $breadcrumbs) ; $i++ ){
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $breadcrumbs[$i] ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $breadcrumbs[$i] ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;
            }
            echo $before . '<span itemprop="name">' . esc_html( get_the_title() ) . '</span><meta itemprop="position" content="' . absint( $depth ) . '" /></span>' . $after;
        }elseif( is_404() ){
            $depth = 2;
            echo $before . '<a itemprop="item" href="' . esc_url( home_url() ) . '"><span itemprop="name">' . esc_html__( '404 Error - Page Not Found', 'seva-lite' ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $after;
        }
        
        if( get_query_var('paged') ) printf( __( ' (Page %s)', 'seva-lite' ), get_query_var('paged') );
        
        echo '</div><!-- .crumbs -->';
        
    }                
}
endif;

if( ! function_exists( 'seva_lite_theme_comment' ) ) :
/**
 * Callback function for Comment List *
 * 
 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
 */
function seva_lite_theme_comment( $comment, $args, $depth ){
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body" itemscope itemtype="http://schema.org/UserComments">
	<?php endif; ?>
    	
        <footer class="comment-meta">
            <div class="comment-author vcard">
        	   <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        	</div><!-- .comment-author vcard -->
            <?php printf( __( '<b class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</b> <span class="says">says:</span>', 'seva-lite' ), get_comment_author_link() ); ?>
            <div class="comment-metadata commentmetadata">
                <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
                    <time itemprop="commentTime" datetime="<?php echo esc_attr( get_gmt_from_date( get_comment_date() . get_comment_time(), 'Y-m-d H:i:s' ) ); ?>"><?php printf( esc_html__( '%1$s at %2$s', 'seva-lite' ), get_comment_date(),  get_comment_time() ); ?></time>
                </a>
            </div>
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'seva-lite' ); ?></em>
                <br />
            <?php endif; ?>
        </footer>
        <div class="comment-content" itemprop="commentText"><?php comment_text(); ?></div>
        <div class="reply">
            <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div>
        
	<?php if ( 'div' != $args['style'] ) : ?>
    </div><!-- .comment-body -->
	<?php endif;
}
endif;

if( ! function_exists( 'seva_lite_sidebar' ) ) :
/**
 * Return sidebar layouts for pages/posts
*/
function seva_lite_sidebar( $class = false ){
    global $post;
    $return = false;
    $page_layout = get_theme_mod( 'page_sidebar_layout', 'right-sidebar' ); //Default Layout Style for Pages
    $post_layout = get_theme_mod( 'post_sidebar_layout', 'right-sidebar' ); //Default Layout Style for Posts
    $layout      = get_theme_mod( 'layout_style', 'right-sidebar' ); //Default Layout Style for Styling Settings
    
    if( is_singular( array( 'page', 'post' ) ) ){          
        if( get_post_meta( $post->ID, '_seva_lite_sidebar_layout', true ) ){
            $sidebar_layout = get_post_meta( $post->ID, '_seva_lite_sidebar_layout', true );
        }else{
            $sidebar_layout = 'default-sidebar';
        }
        
        if( is_page() ){ 
            if( is_active_sidebar( 'sidebar' ) ){
                if( $sidebar_layout == 'no-sidebar' || ( $sidebar_layout == 'default-sidebar' && $page_layout == 'no-sidebar' ) ){
                    $return = $class ? 'full-width' : false;
                }elseif( $sidebar_layout == 'centered' || ( $sidebar_layout == 'default-sidebar' && $page_layout == 'centered' ) ){
                    $return = $class ? 'full-width centered' : false;
                }elseif( ( $sidebar_layout == 'default-sidebar' && $page_layout == 'right-sidebar' ) || ( $sidebar_layout == 'right-sidebar' ) ){
                    $return = $class ? 'rightsidebar' : 'sidebar';
                }elseif( ( $sidebar_layout == 'default-sidebar' && $page_layout == 'left-sidebar' ) || ( $sidebar_layout == 'left-sidebar' ) ){
                    $return = $class ? 'leftsidebar' : 'sidebar';
                }
            }else{
                $return = $class ? 'full-width' : false;
            }
        }elseif( is_single() ){ 
            if( is_active_sidebar( 'sidebar' ) ){
                if( $sidebar_layout == 'no-sidebar' || ( $sidebar_layout == 'default-sidebar' && $post_layout == 'no-sidebar' ) ){
                    $return = $class ? 'full-width' : false;
                }elseif( $sidebar_layout == 'centered' || ( $sidebar_layout == 'default-sidebar' && $post_layout == 'centered' ) ){
                    $return = $class ? 'full-width centered' : false;
                }elseif( ( $sidebar_layout == 'default-sidebar' && $post_layout == 'right-sidebar' ) || ( $sidebar_layout == 'right-sidebar' ) ){
                    $return = $class ? 'rightsidebar' : 'sidebar';
                }elseif( ( $sidebar_layout == 'default-sidebar' && $post_layout == 'left-sidebar' ) || ( $sidebar_layout == 'left-sidebar' ) ){
                    $return = $class ? 'leftsidebar' : 'sidebar';
                }
            }else{
                $return = $class ? 'full-width' : false;
            }
        }
    }elseif( seva_lite_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || get_post_type() == 'product' ) ){ 
        if( $layout == 'no-sidebar' ){
            $return = $class ? 'full-width' : false;
        }elseif( is_active_sidebar( 'shop-sidebar' ) ){            
            if( $class ){
                if( $layout == 'right-sidebar' ) $return = 'rightsidebar'; //With Sidebar
                if( $layout == 'left-sidebar' ) $return = 'leftsidebar';
            }         
        }else{
            $return = $class ? 'full-width' : false;
        } 
    }elseif( is_404() ){
        $return = $class ? 'full-width' : false;
    }elseif( 'blossom-portfolio' === get_post_type() ){
        $return = 'full-width centered';  
    }else{ 
        if( $layout == 'no-sidebar' ){
            $return = $class ? 'full-width' : false;
        }elseif( is_active_sidebar( 'sidebar' ) ){            
            if( $class ){
                if( $layout == 'right-sidebar' ) $return = 'rightsidebar'; //With Sidebar
                if( $layout == 'left-sidebar' ) $return = 'leftsidebar';
            }else{
                $return = 'sidebar';    
            }                         
        }else{
            $return = $class ? 'full-width' : false;
        } 
    }    
    return $return; 
}
endif;

if( ! function_exists( 'seva_lite_get_posts' ) ) :
/**
 * Fuction to list Custom Post Type
*/
function seva_lite_get_posts( $post_type = 'post', $slug = false ){    
    $args = array(
    	'posts_per_page'   => -1,
    	'post_type'        => $post_type,
    	'post_status'      => 'publish',
    	'suppress_filters' => true 
    );
    $posts_array = get_posts( $args );
    
    // Initate an empty array
    $post_options = array();
    $post_options[''] = __( ' -- Choose -- ', 'seva-lite' );
    if ( ! empty( $posts_array ) ) {
        foreach ( $posts_array as $posts ) {
            if( $slug ){
                $post_options[ $posts->post_title ] = $posts->post_title;
            }else{
                $post_options[ $posts->ID ] = $posts->post_title;    
            }
        }
    }
    return $post_options;
    wp_reset_postdata();
}
endif;

if( ! function_exists( 'seva_lite_get_categories' ) ) :
/**
 * Function to list post categories in customizer options
*/
function seva_lite_get_categories( $select = true, $taxonomy = 'category', $slug = false ){    
    /* Option list of all categories */
    $categories = array();
    
    $args = array( 
        'hide_empty' => false,
        'taxonomy'   => $taxonomy 
    );
    
    $catlists = get_terms( $args );
    if( $select ) $categories[''] = __( 'Choose Category', 'seva-lite' );
    foreach( $catlists as $category ){
        if( $slug ){
            $categories[$category->slug] = $category->name;
        }else{
            $categories[$category->term_id] = $category->name;    
        }        
    }
    
    return $categories;
}
endif;

if( ! function_exists( 'seva_lite_get_id_from_page' ) ) :
/**
 * Get page ids from page name.
*/
function seva_lite_get_id_from_page( $slider_pages ){
    if( $slider_pages ){
        $ids = array();
        foreach( $slider_pages as $p ){
             if( !empty( $p['page'] ) ){
                $page_ids = get_page_by_title( $p['page'] );
                $ids[] = $page_ids->ID;
             }
        }   
        return $ids;
    }else{
        return false;
    }
}
endif;

if( ! function_exists( 'seva_lite_get_home_sections' ) ) :
/**
 * Returns Home Sections 
*/
function seva_lite_get_home_sections(){
    
    $ed_banner = get_theme_mod( 'ed_banner_section', 'static_banner' );
    
    $sections = array( 
        'newsletter'        => array( 'sidebar' => 'newsletter' ),
        'about'             => array( 'sidebar' => 'about' ),
        'client'            => array( 'sidebar' => 'client' ),
        'service'           => array( 'sidebar' => 'service' ),
        'cta'               => array( 'sidebar' => 'cta' ),
        'testimonial'       => array( 'sidebar' => 'testimonial' ),
        'wheeloflife'       => array( 'wsection' => 'wheeloflife' ),
        'blog'              => array( 'bsection' => 'blog' ), 
        'contact'           => array( 'sidebar' => 'contact' ), 
        'cta-two'           => array( 'sidebar' => 'cta-two' ) 
    );
    
    $enabled_section = array();
    
    if( $ed_banner == 'static_banner' || $ed_banner == 'slider_banner' ) array_push( $enabled_section, 'banner' );
    
    foreach( $sections as $k => $v ){
        if( array_key_exists( 'sidebar', $v ) ){
            if( is_active_sidebar( $v['sidebar'] ) ) array_push( $enabled_section, $v['sidebar'] );
        }else{
            if( array_key_exists( 'wsection', $v ) && get_theme_mod( 'ed_wheeloflife_section', false ) ) array_push( $enabled_section, $v['wsection'] );
            if( array_key_exists( 'bsection', $v ) && get_theme_mod( 'ed_blog_section', true ) ) array_push( $enabled_section, $v['bsection'] );
        }
    }  
    
    return apply_filters( 'seva_lite_home_sections', $enabled_section );
}
endif;

if( ! function_exists( 'seva_lite_get_image_sizes' ) ) :
/**
 * Get information about available image sizes
 */
function seva_lite_get_image_sizes( $size = '' ) {
 
    global $_wp_additional_image_sizes;
 
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
 
    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array( 
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    } 
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}
endif;

if ( ! function_exists( 'seva_lite_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function seva_lite_get_fallback_svg( $post_thumbnail ) {
    if( ! $post_thumbnail ){
        return;
    }
    
    $image_size = seva_lite_get_image_sizes( $post_thumbnail );
     
    if( $image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:#fbe2d8;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
	/**
	 * Triggered after the opening <body> tag.
    */
	do_action( 'wp_body_open' );
}
endif;

if ( ! function_exists( 'seva_lite_comment_toggle' ) ):
/**
 * Function toggle comment section position
*/
function seva_lite_comment_toggle(){
    $comment_postion = get_theme_mod( 'toggle_comments', false );

    if ( $comment_postion ) {
        $priority = 5;
    }else{
        $priority = 45;
    }
    return absint( $priority ) ;
}
endif;

/**
 * Is BlossomThemes Email Newsletters active or not
*/
function seva_lite_is_btnw_activated(){
    return class_exists( 'Blossomthemes_Email_Newsletter' ) ? true : false;        
}

/**
 * Is Blossom Theme Toolkit active or not
*/
function seva_lite_is_bttk_activated(){
    return class_exists( 'Blossomthemes_Toolkit' ) ? true : false;
}

/**
 * Is BlossomThemes Social Feed active or not
*/
function seva_lite_is_btif_activated(){
    return class_exists( 'Blossomthemes_Instagram_Feed' ) ? true : false;
}

/**
 * Query WooCommerce activation
 */
function seva_lite_is_woocommerce_activated() {
	return class_exists( 'woocommerce' ) ? true : false;
}

/**
 * Check if Contact Form 7 Plugin is installed
*/
function seva_lite_is_cf7_activated(){
    return class_exists( 'WPCF7' ) ? true : false;
}

/**
 * Query Jetpack activation
*/
function seva_lite_is_jetpack_activated( $gallery = false ){
	if( $gallery ){
        return ( class_exists( 'jetpack' ) && Jetpack::is_module_active( 'tiled-gallery' ) ) ? true : false;
	}else{
        return class_exists( 'jetpack' ) ? true : false;
    }           
}

/**
 * Checks if elementor is active or not
*/
function seva_lite_is_elementor_activated(){
    return class_exists( 'Elementor\\Plugin' ) ? true : false; 
}

/**
 * Is Wheel of life activated
 */
function seva_lite_is_wheel_of_life_activated() {
    return class_exists( 'WheelOfLife\Wheel_Of_Life' ) ? true : false;
}

/**
 * Checks if elementor has override that particular page/post or not
*/
function seva_lite_is_elementor_activated_post(){
    if( seva_lite_is_elementor_activated() &&  is_singular() ){
        global $post;
        $post_id = $post->ID;
        return \Elementor\Plugin::$instance->documents->get( $post_id )->is_built_with_elementor() ? true : false;
    }else{
        return false;
    }
}

/**
 * Checks if classic editor is active or not
*/
function seva_lite_is_classic_editor_activated(){
    return class_exists( 'Classic_Editor' ) ? true : false; 
}

/**
 * Checks if LearnDash LMS is active or not
*/
function seva_lite_is_learndash_lms_activated(){
    return class_exists( 'SFWD_LMS' ) ? true : false; 
}

/**
 * Checks if Tutor LMS is active or not
*/
function seva_lite_is_tutor_lms_activated(){
    return class_exists( '\TUTOR\Tutor' ) ? true : false; 
}

if( ! function_exists( 'seva_lite_blog_featured_post' ) ) :
/**
 * Blog Featured
*/
function seva_lite_blog_featured_post(){
    
    $blog_featured_post = get_theme_mod( 'blog_featured_post' );
    $read_more          = get_theme_mod( 'read_more_text', __( 'Read More', 'seva-lite' ) );
    $sec_args = array();

    if( $blog_featured_post ){
        $sec_args = array(
            'p'   => absint( $blog_featured_post ),
        );
    }

    $sec_qry = new WP_Query( $sec_args );
    
    if( $sec_qry->have_posts() ){ 
        while ( $sec_qry->have_posts() ) : $sec_qry->the_post();
            if( has_post_thumbnail() ){ ?>                
                <div class="page-header-content">
                    <header class="entry-header">
                        <?php seva_lite_category(); ?>
                        <?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
                    </header>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                    <?php if( $read_more ) : ?>
                        <div class="button-wrap">
                            <a href="<?php the_permalink(); ?>" class="seva-btn btn-primary-two"><?php echo esc_html( $read_more ); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php } 
        endwhile; // End of the loop. 
    } wp_reset_postdata();
}
endif;

if( ! function_exists( 'seva_lite_per_page_count' ) ):
/**
*   Counts the Number of total posts in Archive, Search and Author
*/
function seva_lite_per_page_count(){
    global $wp_query;
    if( is_archive() || is_search() && $wp_query->found_posts > 0 ) {        
        $posts_per_page = get_option( 'posts_per_page' );
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $start_post_number = 0;
        $end_post_number   = 0;

        if( $wp_query->found_posts > 0 && !( seva_lite_is_woocommerce_activated() && is_shop() ) ):                
            $start_post_number = 1;
            if( $wp_query->found_posts < $posts_per_page  ) {
                $end_post_number = $wp_query->found_posts;
            }else{
                $end_post_number = $posts_per_page;
            }

            if( $paged > 1 ){
                $start_post_number = $posts_per_page * ( $paged - 1 ) + 1;
                if( $wp_query->found_posts < ( $posts_per_page * $paged )  ) {
                    $end_post_number = $wp_query->found_posts;
                }else{
                    $end_post_number = $paged * $posts_per_page;
                }
            }

            printf( esc_html__( '%1$s Showing:  %2$s - %3$s of %4$s RESULTS %5$s', 'seva-lite' ), '<span class="result-count">', absint( $start_post_number ), absint( $end_post_number ), esc_html( number_format_i18n( $wp_query->found_posts ) ), '</span>' );
        endif;
    }
}
endif;

if( ! function_exists( 'seva_lite_article_meta' ) ) :
/**
 * Article Meta
*/
function seva_lite_article_meta(){ 
    if( is_singular( 'post' ) ) : ?>
        <div class="article-meta">
            <div class="article-meta-inner">
                <?php 
                    seva_lite_posted_by();
                    seva_lite_comment_count();
                ?>
            </div>         
        </div>         
        <?php    
    endif;
}
endif;