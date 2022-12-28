<?php
/**
 * Toolkit Filters
 *
 * @package Seva_Lite
 */

if( ! function_exists( 'seva_lite_default_icon_text_size' ) ) :
    function seva_lite_default_icon_text_size(){
        return 'full';
    }
endif;
add_filter( 'bttk_icon_img_size', 'seva_lite_default_icon_text_size' );

if( ! function_exists( 'seva_lite_featured_page_image_alignment' ) ) :
    function seva_lite_featured_page_image_alignment(){
        
        $align_array = array(
            'right'     => __( 'Right', 'seva-lite' ),
            'left'      => __( 'Left', 'seva-lite' ),
        );
        
        return $align_array;
    }
endif;
add_filter( 'bttk_img_alignment', 'seva_lite_featured_page_image_alignment' );

if( ! function_exists( 'seva_lite_cta_image_alignment' ) ) :
    function seva_lite_cta_image_alignment(){
        
        $align_array = array(
            'right'     => __( 'Right', 'seva-lite' ),
            'left'      => __( 'Left', 'seva-lite' ),
            'centered'  => __( 'Centered', 'seva-lite' )
        );
        
        return $align_array;
    }
endif;
add_filter( 'blossomthemes_cta_button_alignment', 'seva_lite_cta_image_alignment' );

if( ! function_exists( 'seva_lite_default_icon_text_size' ) ) :
    function seva_lite_default_icon_text_size(){
        return 'seva-promotion';
    }
endif;
add_filter( 'bttk_icon_img_size', 'seva_lite_default_icon_text_size' );

if( ! function_exists( 'seva_lite_portfolio_single_related_image_size' ) ) :
    function seva_lite_portfolio_single_related_image_size(){
        return 'seva-blog-grid';
    }
endif;
add_filter( 'bttk_related_portfolio_image', 'seva_lite_portfolio_single_related_image_size' );

if( ! function_exists( 'seva_lite_author_image' ) ) :
    function seva_lite_author_image(){
       return 'full';
    }
endif;
add_filter( 'author_bio_img_size', 'seva_lite_author_image' );

/* 
* Code starts for changing structure of contact widget
*/
if( ! function_exists( 'seva_lite_featured_page_widget_filter' ) ) :
/**
 * Filter for Featured page widget
*/
function seva_lite_featured_page_widget_filter( $html, $args, $instance ){ 
    $read_more         = !empty( $instance['readmore'] ) ? $instance['readmore'] : __( 'Read More', 'seva-lite' );      
    $show_feat_img     = !empty( $instance['show_feat_img'] ) ? $instance['show_feat_img'] : '' ;  
    $show_page_content = !empty( $instance['show_page_content'] ) ? $instance['show_page_content'] : '' ;        
    $show_readmore     = !empty( $instance['show_readmore'] ) ? $instance['show_readmore'] : '' ;        
    $page_list         = !empty( $instance['page_list'] ) ? $instance['page_list'] : 1 ;
    $image_alignment   = !empty( $instance['image_alignment'] ) ? $instance['image_alignment'] : 'left' ;
    $about_secondary_image   = get_theme_mod( 'about_secondary_image' );

    if( !isset( $page_list ) || $page_list == '' ) return;
    
    $post_no = get_post( $page_list ); 
    
    $target = 'target="_blank"';
    if( isset($instance['target']) && $instance['target']!='' ) {
        $target = 'target="_self"';
    }
    
    if( $post_no ){
        setup_postdata( $post_no );
        ob_start(); ?>
        <div class="widget-featured-holder <?php echo esc_attr($image_alignment);?>">
            <?php
                echo is_page_template( 'templates/about.php' ) ? '<h1 class="widget-title">' : $args['before_title']; //Done for SEO
                echo esc_html( $post_no->post_title );
                echo is_page_template( 'templates/about.php' ) ? '</h1>' : $args['after_title'];
            ?>
            <?php if( has_post_thumbnail( $post_no ) && $show_feat_img ){ ?>
            <div class="img-holder bg-graphic">
                <a <?php echo $target;?> href="<?php the_permalink( $post_no ); ?>">
                    <?php 
                    $featured_img_size = apply_filters( 'featured_img_size', 'full' );
                    echo get_the_post_thumbnail( $post_no, $featured_img_size ); ?>
                    <?php if( $about_secondary_image ) echo '<div class="secondary-img-holder"><img src="' . esc_url( $about_secondary_image ) . '">' . '</div>'; ?>
                </a>
            </div>
            <?php } ?>
            <div class="text-holder">
                <div class="featured_page_content">
                    <?php 
                    if( isset( $show_page_content ) && $show_page_content != '' ){
                        echo do_shortcode( $post_no->post_content );                                
                    }else{
                        echo apply_filters( 'the_excerpt', get_the_excerpt( $post_no ) );                                
                    }
                    
                    if( isset( $show_readmore ) && $show_readmore != '' && ! $show_page_content ){ ?>
                        <a href="<?php the_permalink( $post_no ); ?>" <?php echo $target;?> class="btn-readmore"><?php echo esc_html( $read_more );?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>                    
        </div>                    
        <?php    
        $html = ob_get_clean();
        wp_reset_postdata();
        return $html;
    }
}
endif;
add_filter( 'blossom_featured_page_widget_filter', 'seva_lite_featured_page_widget_filter', 10, 3 );

if( ! function_exists( 'seva_lite_author_bio_widget_filter' ) ) :
    /**
     * Filter for Featured page widget
    */
    function seva_lite_author_bio_widget_filter( $html, $args, $instance ){ 
        $title            = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $name             = ! empty( $instance['name'] ) ? $instance['name'] : '';
        $email            = ! empty( $instance['email'] ) ? $instance['email'] : '';        
        $content          = ! empty( $instance['content'] ) ? $instance['content'] : '';
        $image            = ! empty( $instance['image'] ) ? $instance['image'] : '';
        $author_image     = ! empty( $instance['author-image'] ) ? $instance['author-image'] : '';
        $label            = ! empty( $instance['label'] ) ? $instance['label'] : '';
        $link             = ! empty( $instance['link'] ) ? $instance['link'] : '';
        $signaturetext    = ! empty( $instance['signature-text'] ) ? $instance['signature-text'] : '';
        $attachment_id    = $image;
        $author_image_id  = $author_image; 

        $option           = ! empty( $instance['author-image-option'] ) ? $instance['author-image-option'] : 'gravatar';
        $signature_option = ! empty( $instance['author-signature-option'] ) ? $instance['author-signature-option'] : 'text';
    
        if( $attachment_id ){
            $author_bio_img_size = apply_filters('author_bio_img_size','full');
        }

        if( $author_image_id ){
            $author_img_size = apply_filters('author_bio_img_size','full');
        }

        ob_start();
        
        if( $title ) echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance ) . $args['after_title']; 
        ?>
        <div class="bttk-author-bio-holder">
            <div class="image-holder">
                <?php 
                if( $option == 'gravatar' ){ 
                    echo get_avatar( $email, 300 ); 
                }
                elseif( $option == 'photo' && $author_image_id != '' ){ 
                    echo wp_get_attachment_image( $author_image_id, $author_img_size, false, array( 'alt' => esc_attr( $name ))); 
                }
                ?>
            </div> 
            <div class="text-holder">
                <div class="title-holder"><?php echo esc_html( $name ); ?></div> 
                <div class="author-bio-content">
                    <?php echo wpautop( wp_kses_post( $content ) ); ?>
                </div>
                <?php
                if( $signature_option == 'photo' && $attachment_id != '' ){ ?>
                    <div class="signature-holder">
                        <?php echo wp_get_attachment_image( $attachment_id, $author_bio_img_size, false, array( 'alt' => esc_html( $title ))); ?>
                    </div>
                <?php }
                elseif( $signaturetext ){ echo '<div class="text-signature">'.esc_html( $signaturetext ).'</div>';}?>                
                <?php if( $link && $label ){ ?>
                    <a <?php if( isset( $instance['target'] ) && $instance['target']=='1' ){ echo "rel=noopener target=_blank"; } ?> href="<?php echo esc_url( $link ); ?>" class="readmore"><?php echo esc_html( $label );?></a>
                <?php } ?>

    	        <div class="author-bio-socicons">
                    <?php
                    if( isset( $instance['socicon'] ) && !empty( $instance['socicon'] ) ): 
                        $icons = $instance['socicon']; ?>
                        <ul class="author-socicons">
        	        	<?php
                        $arr_keys  = array_keys( $icons );
                        foreach ( $arr_keys as $key => $value )
                        {
                            if ( array_key_exists( $value, $instance['socicon'] ) )
                            {
                                if( isset( $instance['socicon'][$value] ) && !empty( $instance['socicon'][$value] ) )
                                {       
                                    if( !isset( $instance['socicon_profile'][$value] ) || ( isset( $instance['socicon_profile'][$value] ) && $instance['socicon_profile'][$value] == '') )
                                    {
                                        $icon = $this->bttk_get_social_icon_name( $instance['socicon'][$value] );
                                        $class = ( $icon == 'rss' ) ? 'fas fa-'.$icon : 'fab fa-'.$icon;
                                    }
                                    elseif( isset( $instance['socicon_profile'][$value] ) && !empty( $instance['socicon_profile'][$value] ))
                                    {
                                        $icon = $instance['socicon_profile'][$value] ;
                                        $class = ( $icon == 'rss' ) ? 'fas fa-'.$icon : 'fab fa-'.$icon;
                                    }
                                    ?>
                		            <li class="social-share-list">
                		                <a <?php if( isset( $instance['target'] ) && $instance['target'] == '1' ){ echo "rel=noopener target=_blank"; } ?> href="<?php echo esc_url( $instance['socicon'][$value] );?>">
                                            <i class="<?php echo esc_attr( $class );?>"></i>
                                        </a>
                		                
                		            </li>
            		            <?php
                                } 
                            }
        		        }
        		        ?>
                        </ul>
                    <?php endif; ?>
    	        </div>
            </div>
	    </div>                 
        <?php    
        $html = ob_get_clean();
        wp_reset_postdata();
        return $html;
    } 
endif;
add_filter( 'blossom_author_bio_widget_filter', 'seva_lite_author_bio_widget_filter', 10, 3 );

if( ! function_exists( 'seva_lite_contact_widget_filter' ) ) :
/**
 * Filter for contact widget
*/
function seva_lite_contact_widget_filter( $html, $args, $instance ){
    $title       = ! empty( $instance['title'] ) ? $instance['title'] : '';        
    $size        = isset( $instance['size'] ) ? esc_attr($instance['size']) : '20';
    $description = ! empty( $instance['description'] ) ? $instance['description'] : '';        
    $telephone   = ! empty( $instance['telephone'] ) ? $instance['telephone'] : '';        
    $email       = ! empty( $instance['email'] ) ? $instance['email'] : '';        
    $address     = ! empty( $instance['address'] ) ? $instance['address'] : '';
    $follow_on_text     = get_theme_mod( 'follow_on_text', __( 'Follow Me On:', 'seva-lite' ) );

    ob_start();
    
    if( $title ) echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance ) . $args['after_title']; ?>  

    <div class="bttk-contact-widget-wrap contact-info">
    <?php 
        if( $description !='' ) echo wpautop( wp_kses_post( $description ) ); 
        
        if( $telephone || $email || $address ){ 
            echo '<ul class="contact-list">';
            
            if( $telephone != '' ) echo '<span class="contact-title">' . __( 'Contact:', 'seva-lite' ) . '</span><li><i class="fa fa-phone"></i><a href="' . esc_url( 'tel:' . preg_replace( '/\D/', '', $telephone ) ) . '">' . esc_html( $telephone ) . '</a></li>';
            if( $telephone != '' && $email !='' ) echo '<li><i class="fa fa-envelope"></i><a href="' . esc_url( 'mailto:' . sanitize_email( $email ) ) . '">' . esc_html( $email ) . '</a></li>';
            if( $telephone == '' && $email !='' ) echo '<span class="contact-title"><li><i class="fa fa-envelope"></i><a href="' . esc_url( 'mailto:' . sanitize_email( $email ) ) . '">' . esc_html( $email ) . '</a></li>';
            if( $address !='' ) echo '<span class="address-title">' . __( 'Location:', 'seva-lite' ) . '</span><li><i class="fa fa-map-marker"></i>' . esc_html( $address ) . '</li>';

            echo '</ul>';
        }
        
        if( isset( $instance['social'] ) && !empty( $instance['social'] ) )
        { 
            $icons = $instance['social']; ?>                
            <?php if( $follow_on_text ) echo '<strong class="contact-list-title">' . esc_html( $follow_on_text ) . '</strong>'; ?>
            <ul class="social-networks">
                <?php
                    $arr_keys  = array_keys( $icons );
                    foreach ( $arr_keys as $key => $value )
                    { 
                        if ( array_key_exists( $value, $instance['social'] ) )
                        { 
                            if( isset( $instance['social'][$value] ) && !empty( $instance['social'][$value] ) )
                            {
                                if( !isset( $instance['social_profile'][$value] ) || ( isset( $instance['social_profile'][$value] ) && $instance['social_profile'][$value] == '' ) )
                                {
                                    $icon = $this->bttk_get_social_icon_name( $instance['social'][$value] );
                                    $class = ( $icon == 'rss' ) ? 'fas fa-'.$icon : 'fab fa-'.$icon;
                                }
                                elseif( isset( $instance['social_profile'][$value] ) && !empty( $instance['social_profile'][$value] ) )
                                {
                                    $icon = $instance['social_profile'][$value] ;
                                    $class = ( $icon == 'rss' ) ? 'fas fa-'.$icon : 'fab fa-'.$icon;
                                }
                                ?>
                                <li class="bttk-contact-social-icon-wrap">
                                    <a <?php if( isset( $instance['target'] ) && $instance['target'] == '1' ){ echo "target=_blank"; } ?> href="<?php echo esc_url( $instance['social'][$value] );?>">
                                        <span class="bttk-contact-social-links-field-handle"><i class="<?php echo esc_attr( $class );?>"></i></span>
                                    </a>
                                </li>
                            <?php
                            }
                        }
                    }
                ?>
            </ul>
            <?php 
        } 
        ?>
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}
endif;
add_filter( 'blossom_contact_widget_filter', 'seva_lite_contact_widget_filter', 10, 3 );