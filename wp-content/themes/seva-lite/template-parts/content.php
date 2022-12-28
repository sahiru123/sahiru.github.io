<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Seva_Lite
 */
?>

<article  data-wow-duration="1s" data-wow-delay="0.1s" id="post-<?php the_ID(); ?>" <?php post_class(); echo ' itemscope itemtype="https://schema.org/Blog"'; ?>>
	<?php 
        /**
         * @hooked seva_lite_post_thumbnail - 20
        */
        do_action( 'seva_lite_before_post_entry_content' );
        
        echo '<div class="content-wrap">';
        
        /**
         * @hooked seva_lite_entry_header  - 10 
         * @hooked seva_lite_entry_content - 15
         * @hooked seva_lite_entry_footer  - 20
        */
        do_action( 'seva_lite_post_entry_content' );
        
        echo '</div>';
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
