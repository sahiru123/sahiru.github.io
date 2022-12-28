<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Seva_Lite
 */

/**
 * 
 * @hooked seva_lite_entry_header   - 10 
 * @hooked seva_lite_post_thumbnail - 15
*/
do_action( 'seva_lite_before_single_entry_content' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

        seva_lite_article_meta();
        
        echo '<div class="content-wrap">';        
    
        /**
         * Entry Content
         * 
         * @hooked seva_lite_entry_content - 15
         * @hooked seva_lite_entry_footer  - 20
        */
        do_action( 'seva_lite_single_entry_content' );    

        echo '</div>';
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
