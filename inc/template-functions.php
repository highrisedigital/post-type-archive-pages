<?php
/**
 * Functions which can be called in templates and other places.
 *
 * @package Post_Type_Archive_Pages
 */

/**
 * Gets the plugins options array from the options table.
 *
 * @param  array $default What to return by default should the options not exist. Defaults to empty array.
 * @return array          The options array of the plugin.
 */
function hdptap_get_options( $default = array() ) {

	// return the options - filterable.
	return apply_filters( 'hdptap_get_options', get_option( 'hdptap_options', $default ) );

}

/**
 * Gets the post id of the archive page for a given post type.
 *
 * @param  string $post_type The post type to get the ID of.
 * @return mixed             Either zero if no post id exists of the post id integer.
 */
function hdptap_get_post_type_archive_post_id( $post_type = '' ) {

	// get the options array.
	$hdptap_options = hdptap_get_options();

	// if we have a post id for this post type.
	if ( isset( $hdptap_options['post_types'][ $post_type ] ) ) {

		// return the post id of this posts types archive page.
		return apply_filters( 'hdptap_post_type_archive_post_id', absint( $hdptap_options['post_types'][ $post_type ] ) );

	}

	// return zero if no post id exists for this post type.
	return 0;

}

/**
 * Gets the title of the archive page for a given post type.
 *
 * @param  string $post_type The post type to return the title for.
 * @param  string $default   If the title doesn't exist what to return. Defaults to empty string.
 * @return mixed             An empty string by default if no title exists or the posts title field.
 */
function hdptap_get_post_type_archive_title( $post_type = '', $default = '' ) {

	// get this post types archive page post id.
	$archive_page_id = hdptap_get_post_type_archive_post_id( $post_type );

	// if we have no archive page id.
	if ( 0 === $archive_page_id ) {

		// return an empty string - the default.
		return $default;

	}

	// return the title of the archive page post.
	return apply_filters( 'hdptap_post_type_archive_title', get_the_title( $archive_page_id ) );

}

/**
 * Get the content field from the archive page post for a post type.
 *
 * @param  string $post_type The post type to return the title for.
 * @param  string $default   If the title doesn't exist what to return. Defaults to empty string.
 * @return string            The content of the post from the database.
 */
function hdptap_get_post_type_archive_content( $post_type = '', $default = '' ) {

	// get this post types archive page post id.
	$archive_page_id = hdptap_get_post_type_archive_post_id( $post_type );

	// if we have no archive page id.
	if ( 0 === $archive_page_id ) {

		// return an empty string - the default.
		return $default;

	}

	// get the post object of the archive page.
	$archive_page_post = get_post( absint( $archive_page_id ) );

	// return the content of the archive page post.
	return apply_filters( 'hdptap_post_type_archive_content', $archive_page_post->post_content );

}

/**
 * Gets the post thumbnail or featuerd image markup for an archive page.
 *
 * @param  string $post_type The post type to get the image of.
 * @param  string $size      The size of image to return.
 * @param  string $attr      Attributes to add to the image markup.
 * @return mixed             Empty string if no thumbnail exists or the image tag markup of the post thumbnail.
 */
function hdptap_get_post_type_archive_post_thumbnail( $post_type = '', $size = 'post-thumbnail', $attr = '' ) {

	// get this post types archive page post id.
	$archive_page_id = hdptap_get_post_type_archive_post_id( $post_type );

	// return the post thumbnail.
	return get_the_post_thumbnail( $archive_page_id, $size, $attr );

}

