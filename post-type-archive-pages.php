<?php
/*
Plugin Name: Post Type Archive Pages
Plugin URI: https://highrise.digital/
Description: A WordPress plugin that provides a page / post like interface for adding content to a WordPress custom post type archive.
Version: 1.0
License: GPL-2.0+
Author: Highrise Digital Ltd
Author URI: https://highrise.digital/
Text domain: post-type-archive-pages

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* exist if directly accessed */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* define variable for path to this plugin file. */
define( 'HDPTAP_LOCATION', dirname( __FILE__ ) );
define( 'HDPTAP_LOCATION_URL', plugins_url( '', __FILE__ ) );

// load in the archive pages post type.
require_once( dirname( __FILE__ ) . '/inc/post-types.php' );
require_once( dirname( __FILE__ ) . '/inc/admin.php' );
require_once( dirname( __FILE__ ) . '/inc/template-functions.php' );

/**
 * Function to run on plugins load.
 */
function hdptap_plugins_loaded() {

	$locale = apply_filters( 'plugin_locale', get_locale(), 'post-type-archive-pages' );
	load_textdomain( 'post-type-archive-pages', WP_LANG_DIR . '/post-type-archive-pages/post-type-archive-pages-' . $locale . '.mo' );
	load_plugin_textdomain( 'post-type-archive-pages', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

}

add_action( 'plugins_loaded', 'hdptap_plugins_loaded' );

/**
 * Function to run when the plugin is activated.
 */
function hdptap_activation() {

	$hdtap_options = array(
		'post_types' => array(),
	);

	// add an option to store the version number of this plugin.
	update_option( 'hdptap_options', $hdtap_options );

	// flush the sites permalinks rules as we have registered post types.
	flush_rewrite_rules();

}

register_activation_hook( __FILE__, 'hdptap_activation' );

/**
 * Creates the archives pages for the post types that are set to use an archive.
 * If the pages already exist it does nothing for that post type.
 *
 * @param  string $post_type The name of the post type registered.
 * @param  array  $args       An array of registered post type arguments.
 */
function hdptap_create_archive_pages( $post_type, $args ) {

	// if this is the archive pages post type - do nothing.
	if ( 'hdptap_cpt_archive' === $post_type ) {
		return;
	}

	// if this post type is not supposed to support an archive - do nothing.
	if ( true !== $args->has_archive ) {
		return;
	}

	// get the current plugin options.
	$hdptap_options = get_option( 'hdptap_options' );

	// if we don't already have a post for this post types archive page.
	if ( ! isset( $hdptap_options['post_types'][ $post_type ] ) || '' === $hdptap_options['post_types'][ $post_type ] ) {

		// create the archive post for this post type.
		$post_type_archive_id = wp_insert_post(
			apply_filters(
				'hdptap_insert_archive_page_args',
				array(
					'post_type'   => 'hdptap_cpt_archive',
					'post_title'  => sanitize_text_field( $args->labels->name ),
					'post_status' => 'publish',
				),
				$hdptap_options['post_types'][ $post_type ]
			)
		);

		// if the new archive post was created succesfully.
		if ( 0 !== $post_type_archive_id && ! is_wp_error( $post_type_archive_id ) ) {

			// save meta data against this post to assocaite it as the archive page for this post type.
			update_post_meta( $post_type_archive_id, 'hdptap_post_type', $post_type );

			// add the newly created post id into the post types array of the options.
			$hdptap_options['post_types'][ $post_type ] = absint( $post_type_archive_id );

			// update the plugin options.
			update_option( 'hdptap_options', $hdptap_options );

			// fire a hook for devs - runs once the archive page is successfully created for a post type.
			do_action( 'hdptap_archive_page_created', $post_type_archive_id, $post_type );

		}
	}

}

add_action( 'registered_post_type', 'hdptap_create_archive_pages', 10, 2 );

/**
 * Updates the options value for a deleted archive page.
 *
 * @param  int $post_id The post id of the archive page removed.
 */
function hdptap_delete_archive_posts_options( $post_id ) {

	// get the post type of the post to be deleted.
	$post_type = get_post_type( $post_id );

	// if this post is not an archive page post do nothing.
	if ( 'hdptap_cpt_archive' !== $post_type ) {
		return;
	}

	// get the linked post type.
	$hdptap_post_type = get_post_meta( $post_id, 'hdptap_post_type', true );

	// get the current plugin options.
	$hdptap_options = get_option( 'hdptap_options' );

	// remove this post types entry from plugin optons.
	if ( isset( $hdptap_options['post_types'][ $hdptap_post_type ] ) && '' !== $hdptap_options['post_types'][ $hdptap_post_type ] ) {

		unset( $hdptap_options['post_types'][ $hdptap_post_type ] );

		// update the plugin options.
		update_option( 'hdptap_options', $hdptap_options );

	}

}

add_action( 'trashed_post', 'hdptap_delete_archive_posts_options', 10, 1 );
