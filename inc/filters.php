<?php
/**
 * Functions which filters parts of WordPress.
 *
 * @package Post_Type_Archive_Pages
 */

/**
 * Filters the archive title using the title from this post types archice post title.
 *
 * @param  string $title The current archive title.
 * @return string        The newly filtered archive title.
 */
function hdptap_the_archive_title( $title ) {

	// only proceed if this is a post type archive.
	if ( ! is_post_type_archive() ) {
		return $title;
	}

	// get the current post type.
	$current_post_type = get_queried_object()->name;

	// get the post type archive title for this post type.
	$post_type_archive_title = hdptap_get_post_type_archive_title( $current_post_type );

	// if we have a title.
	if ( '' !== $post_type_archive_title ) {

		// set the title to it.
		$title = $post_type_archive_title;

	}

	// return the (maybe) modified title.
	return $title;

}

add_filter( 'get_the_archive_title', 'hdptap_the_archive_title', 10, 1 );

/**
 * Add the post type archive content to the archive description on post type archive pages.
 *
 * @param  string $desc The current description.
 * @return string       The new description.
 */
function hdptap_the_archive_description( $desc ) {

	// only proceed if this is a post type archive.
	if ( ! is_post_type_archive() ) {
		return $desc;
	}

	// get the current post type.
	$current_post_type = get_queried_object()->name;

	// get the post type archive desc for this post type.
	$post_type_archive_desc = hdptap_get_post_type_archive_content( $current_post_type );

	// if we have a desc.
	if ( '' !== $post_type_archive_desc ) {

		// set the title to it.
		$desc = wp_kses_post( wpautop( $post_type_archive_desc ) );

	}

	// return the (maybe) modified description.
	return $desc;

}

add_filter( 'get_the_archive_description', 'hdptap_the_archive_description', 10, 1 );
