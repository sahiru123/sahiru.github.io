<?php
/**
 * Custom template tags for this theme
 *
 * @subpackage Yoga Studio
 * @since 1.0
 */

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */

if ( ! function_exists( 'yoga_studio_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function yoga_studio_entry_footer() {
	$separate_meta = __( ', ', 'yoga-studio' );
	$yoga_studio_categories_list = get_the_category_list( $separate_meta );
	$tags_list = get_the_tag_list( '', $separate_meta );
	if ( ( ( yoga_studio_categorized_blog() && $yoga_studio_categories_list ) || $tags_list ) || get_edit_post_link() ) {

		echo '<footer class="entry-footer">';

			yoga_studio_edit_link();

		echo '</footer> <!-- .entry-footer -->';
	}
}
endif;

if ( ! function_exists( 'yoga_studio_edit_link' ) ) :
function yoga_studio_edit_link() {
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'yoga-studio' ),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

function yoga_studio_categorized_blog() {
	$yoga_studio_category_count = get_transient( 'yoga_studio_categories' );

	if ( false === $yoga_studio_category_count ) {
		// Create an array of all the categories that are attached to posts.
		$yoga_studio_categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$yoga_studio_category_count = count( $yoga_studio_categories );

		set_transient( 'yoga_studio_categories', $yoga_studio_category_count );
	}

	// Allow viewing case of 0 or 1 categories in post preview.
	if ( is_preview() ) {
		return true;
	}

	return $yoga_studio_category_count > 1;
}

if ( ! function_exists( 'yoga_studio_the_custom_logo' ) ) :

function yoga_studio_the_custom_logo() {
	the_custom_logo();
}
endif;

function yoga_studio_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'yoga_studio_categories' );
}
add_action( 'edit_category', 'yoga_studio_category_transient_flusher' );
add_action( 'save_post',     'yoga_studio_category_transient_flusher' );
