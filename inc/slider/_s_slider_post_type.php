<?php 
/*
Plugin Name: Slide Custom Post Type
Plugin URI: http://sitepoint.com
Description: This is a plugin that performs the functions defined in the Post Types chapter of the WordPress Anthology.
Author: Raena Jackson Armitage
Version: 0.1
Author URI: http://sitepoint.com/
*/

add_action( 'init', 'slider_post_types_register' );

function slider_post_types_register() {
	register_post_type( 'slider',
		array(
			'labels' => array(
				'name' => __( 'Slides' ),
				'singular_name' => __( 'Slide' ),
				'add_new' => __( 'Add New Slide' ),
				'add_new_item' => __( 'Add New Slide' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Slide' ),
				'new_item' => __( 'New Slide' ),
				'view' => __( 'View Slide' ),
				'view_item' => __( 'View Slide' ),
				'search_items' => __( 'Search Slides' ),
				'not_found' => __( 'No slides' ),
				'not_found_in_trash' => __( 'No slides in the Trash' ),
			),
			'public' => true,
			'hierarchical' => false,
			'exclude_from_search' => true,
			'menu_position' => 30,
			'query_var' => true,
			'can_export' => true,
			'has_archive' => 'speakers',
			'description' => "A slider tool to display images in the Theme.",
			'rewrite' => array('slug' => 'slide'),
			'supports' => array( 'title', 'excerpt', 'editor', 'thumbnail' ),

		)
	);
}

//hook into the init action and call create_slide_taxonomies when it fires
add_action( 'init', 'create_slider_taxonomies', 0 );

//create one taxonomy "position" for the post type "slider"
function create_slider_taxonomies() 
{
// Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name'                         => _x( 'Position', 'taxonomy general name' ),
    'singular_name'                => _x( 'Position', 'taxonomy singular name' ),
    'search_items'                 => __( 'Search Positions' ),
    'popular_items'                => __( 'Popular Positions' ),
    'all_items'                    => __( 'All Positions' ),
    'parent_item'                  => null,
    'parent_item_colon'            => null,
    'edit_item'                    => __( 'Edit Position' ), 
    'update_item'                  => __( 'Update Position' ),
    'add_new_item'                 => __( 'Add New Position' ),
    'new_item_name'                => __( 'New Position Name' ),
    'separate_items_with_commas'   => __( 'Separate Positions with commas' ),
    'add_or_remove_items'          => __( 'Add or remove Positions' ),
    'choose_from_most_used'        => __( 'Choose from the most used Positions' ),
    'menu_name'                    => __( 'Positions' )
  ); 

  $args = array(
    'hierarchical'            => false,
    'labels'                  => $labels,
    'show_ui'                 => true,
    'show_admin_column'       => true,
    'update_count_callback'   => '_update_post_term_count',
    'query_var'               => true,
    'rewrite'                 => array( 'slug' => 'position' )
  );

  register_taxonomy( 'position', 'slider', $args );
 }
