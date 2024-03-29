<?php

// Create Custom Post Type
	
	function register_slides_posttype() {
		$labels = array(
			'name' 				=> _x( 'Slides', 'post type general name' ),
			'singular_name'		=> _x( 'Slide', 'post type singular name' ),
			'add_new' 			=> __( 'Add New Slide' ),
			'add_new_item' 		=> __( 'Add New Slide' ),
			'edit_item' 		=> __( 'Edit Slide' ),
			'new_item' 			=> __( 'New Slide' ),
			'view_item' 		=> __( 'View Slide' ),
			'search_items' 		=> __( 'Search Slides' ),
			'not_found' 		=> __( 'Slide' ),
			'not_found_in_trash'=> __( 'Slide' ),
			'parent_item_colon' => __( 'Slide' ),
			'menu_name'			=> __( 'Slides' )
		);
		
		$taxonomies = array('HomeSlider');
		
		$supports = array('title', 'editor', 'custom-fields', 'thumbnail', 'category');
		
		$post_type_args = array(
			'labels' 			=> $labels,
			'singular_label' 	=> __('Slide'),
			'public' 			=> true,
			'show_ui' 			=> true,
			'publicly_queryable'=> true,
			'query_var'			=> true,
			'capability_type' 	=> 'post',
			'has_archive' 		=> false,
			'hierarchical' 		=> false,
			'rewrite' 			=> array('slug' => 'slides', 'with_front' => false ),
			'supports' 			=> $supports,
			'menu_position' 	=> 27, // Where it is in the menu. Change to 6 and it's below posts. 11 and it's below media, etc.
			'menu_icon' 		=> get_template_directory_uri() . '/inc/slider/images/icon.png',
			'taxonomies'		=> $taxonomies
		 );
		 register_post_type('slides',$post_type_args);
	}
	add_action('init', 'register_slides_posttype');



// Meta Box for Slider URL

	$slidelink_2_metabox = array( 
		'id' => 'slidelink',
		'title' => 'Slide Link',
		'page' => array('slides'),
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
	
					
					array(
						'name' 			=> 'Slide URL',
						'desc' 			=> '',
						'id' 				=> 'blink_slideurl',
						'class' 			=> 'blink_slideurl',
						'type' 			=> 'text',
						'rich_editor' 	=> 0,			
						'max' 			=> 0				
					),
					array(
						'name' 			=> 'Caption',
						'desc' 			=> '',
						'id' 				=> 'blink_slidecaption',
						'class' 			=> 'blink_slidecaption',
						'type' 			=> 'text',
						'rich_editor' 	=> 0,			
						'max' 			=> 0				
					),
					)

	);			
				
	add_action('admin_menu', 'blink_add_slidelink_2_meta_box');
	function blink_add_slidelink_2_meta_box() {
	
		global $slidelink_2_metabox;		
	
		foreach($slidelink_2_metabox['page'] as $page) {
			add_meta_box($slidelink_2_metabox['id'], $slidelink_2_metabox['title'], 'blink_show_slidelink_2_box', $page, 'normal', 'default', $slidelink_2_metabox);
		}
	}
	
	// function to show meta boxes
	function blink_show_slidelink_2_box()	{
		global $post;
		global $slidelink_2_metabox;
		global $blink_prefix;
		global $wp_version;
		
		// Use nonce for verification
		echo '<input type="hidden" name="blink_slidelink_2_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		
		echo '<table class="form-table">';
	
		foreach ($slidelink_2_metabox['fields'] as $field) {
			// get current post meta data
	
			$meta = get_post_meta($post->ID, $field['id'], true);
			
			echo '<tr>',
					'<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
					'<td class="blink_field_type_' . str_replace(' ', '_', $field['type']) . '">';
			switch ($field['type']) {
				case 'text':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%;" /><br/>', '', stripslashes($field['desc']);
					break;
			}
			echo    '<td>',
				'</tr>';
		}
		
		echo '</table>';
	}	
	
	// Save data from meta box
	add_action('save_post', 'blink_slidelink_2_save');
	function blink_slidelink_2_save($post_id) {
		global $post;
		global $slidelink_2_metabox;
		
		// verify nonce
		if (!wp_verify_nonce($_POST['blink_slidelink_2_meta_box_nonce'], basename(__FILE__))) {
			return $post_id;
		}
	
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
	
		// check permissions
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
		
		foreach ($slidelink_2_metabox['fields'] as $field) {
		
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			
			if ($new && $new != $old) {
				if($field['type'] == 'date') {
					$new = blink_format_date($new);
					update_post_meta($post_id, $field['id'], $new);
				} else {
					if(is_string($new)) {
						$new = $new;
					} 
					update_post_meta($post_id, $field['id'], $new);
					
					
				}
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}

function create_conference_taxonomy() {
    $topiclabels = array(
      'name' => ___('Position', '_s'),
      'singular_name' => 'topic',
      'search_items' =>  'Search topics',
      'popular_items' => 'Popular topics',
      'all_items' => 'All topics',
      'parent_item' => null,
      'parent_item_colon' => null,
      'edit_item' => 'Edit topic',
      'update_item' => 'Update topic',
      'add_new_item' => 'Add new topic',
      'new_item_name' => 'New topic name',
      'separate_items_with_commas' => 'Separate topics with commas',
      'add_or_remove_items' => 'Add or remove topics',
      'choose_from_most_used' => 'Choose from common topics',
      'menu_name' => 'Conference topics',
    );
    register_taxonomy( 'conference_topics', 'conference_session',
        array(
       'hierarchical' => false,
) );
}

add_action('init', 'create_conference_taxonomy', 0);	