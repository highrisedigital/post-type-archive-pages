<?php
/**
 * WordPress admin related functions.
 *
 * @package Post_Type_Archive_Pages
 */

/**
 * Adds the link to the newly created archive page at the bottom of the admin menu for that post type.
 */
function hdptap_add_admin_menu_archive_pages() {

	// get the plugin options.
	$hdptap_options = get_option( 'hdptap_options', array() );

	// if we have any post types to add archive page links to.
	if ( ! empty( $hdptap_options ) && isset( $hdptap_options['post_types'] ) ) {

		// loop through each post type.
		foreach ( $hdptap_options['post_types'] as $post_type => $post_id ) {

			// add the menu item for this post type.
			add_submenu_page(
				'edit.php?post_type=' . $post_type,
				__( 'Archive Page', 'post-type-archive-pages' ),
				__( 'Archive Page', 'post-type-archive-pages' ),
				'edit_posts',
				'post.php?post=' . absint( $post_id ) . '&action=edit',
				false
			);

		}
	}

}

add_action( 'admin_menu', 'hdptap_add_admin_menu_archive_pages', 99 );

/**
 * Makes sure that the post type admin menu stays expanded when editing its archive page.
 *
 * @param  string $parent_file The current parent file.
 * @return string              The modified parent file.
 */
function hdptap_admin_menu_correction( $parent_file ) {

	global $current_screen;

	// if this is a post edit screen for the archive page post type.
	if ( 'post' === $current_screen->base && 'hdptap_cpt_archive' === $current_screen->post_type ) {

		// get the plugin options.
		$hdptap_options = get_option( 'hdptap_options', array() );

		// find this posts archive post type - the post type it is the archive for.
		$archive_post_type = array_search( absint( $_GET['post'] ), $hdptap_options['post_types'], true );

		// if we have an archive post type returned.
		if ( false !== $archive_post_type ) {

			// set the parent file to the archive post type.
			$parent_file = 'edit.php?post_type=' . $archive_post_type;

		}
	}

	return $parent_file;

}

add_action( 'parent_file', 'hdptap_admin_menu_correction' );