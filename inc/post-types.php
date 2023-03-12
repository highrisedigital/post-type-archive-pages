<?php
/**
 * Registers the post type required by the plugin for archive post type pages.
 *
 * @package Post_Type_Archive_Pages
 */

/**
 * Registers the post type for archive pages.
 */
function hdptap_register_cpt_archive_post_type() {

	/**
	 * Lets register the conditions post type
	 * post type name is docp_condition
	 */
	register_post_type(
		'hdptap_cpt_archive',
		array(
			'description'         => __( 'Archive posts associated with each post type.', 'post-type-archive-pages' ),
			'public'              => false,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => false, // TODO remove.
			'can_export'          => true,
			'delete_with_user'    => false,
			'hierarchical'        => false,
			'has_archive'         => false,
			'menu_icon'           => 'dashicons-media-text',
			'query_var'           => 'hdptap_cpt_archive',
			'menu_position'       => 26,
			'map_meta_cap'        => true, // Set to `false`, if users are not allowed to edit/delete existing posts.
			'capabilities'        => array(
				'create_posts' => false, // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups ).
			),

			'labels'              => array(
				'name'                  => _x( 'Archive Pages', 'post type general name', 'post-type-archive-pages' ),
				'singular_name'         => _x( 'Archive Page', 'post type singular name', 'post-type-archive-pages' ),
				'add_new'               => _x( 'Add New', 'Call to Action', 'post-type-archive-pages' ),
				'add_new_item'          => __( 'Add New Archive Page', 'post-type-archive-pages' ),
				'edit_item'             => __( 'Edit Archive Page', 'post-type-archive-pages' ),
				'new_item'              => __( 'New Archive Page', 'post-type-archive-pages' ),
				'view_item'             => __( 'View Archive Page', 'post-type-archive-pages' ),
				'search_items'          => __( 'Search Archive Pages', 'post-type-archive-pages' ),
				'not_found'             => __( 'No Archive Pages found', 'post-type-archive-pages' ),
				'not_found_in_trash'    => __( 'No Archive Pages found in Trash', 'post-type-archive-pages' ),
				'menu_name'             => __( 'Archive Pages', 'post-type-archive-pages' ),
				'featured_image'        => __( 'Archive Page Image', 'post-type-archive-pages' ),
				'set_featured_image'    => __( 'Set Archive Page Image', 'post-type-archive-pages' ),
				'remove_featured_image' => __( 'Remove Archive Page Image', 'post-type-archive-pages' ),
				'use_featured_image'    => __( 'Use Archive Page Image', 'post-type-archive-pages' ),
			),

			'supports'            => array(
				'title',
				'editor',
				'thumbnail',
			),
		)
	);

}

add_action( 'init', 'hdptap_register_cpt_archive_post_type', 1 );
