<?php

/** Creating News custom post type and taxonomy * */
class newPostType {

public function __construct()
	{
	
	
//	add_action('init', 'create_post_type',10,3);
	}


public function create_post_type($post_type,$singular,$plural,$post_type_args) {

//Parameters to pass are the post type, its singular form and its plural form and what the post type supports

    $custom_post_type = $post_type;
    $custom_post_tag = $post_type.'-tags';
    $custom_post_category = $post_type.'-category';

    $labels = array(
        'name' => _x($plural, 'post type general name'),
        'singular_name' => _x($singular, 'post type singular name'),
        'add_new' => _x('Add New', 'post type'),
        'add_new_item' => __('Add New '.$singular),
        'edit_item' => __('Edit News '.$singular),
        'new_item' => __('New '.$singular),
        'view_item' => __('View '.$singular),
        'search_items' => __('Search '.$singular),
        'not_found' => __('No '.$singular.' found'),
        'not_found_in_trash' => __('No '.$singular.' found in Trash'),
        'menu_name' => $plural
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 25,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'supports' =>$post_type_args,
        'taxonomies' => array($custom_post_category, $custom_post_tag)
    );
    register_post_type($custom_post_type, $args);

    // create a hierarchical taxonomy
    $labels = array(
        'name' => _x($plural.' Categories', 'taxonomy general name'),
        'singular_name' => _x($plural.' Category', 'taxonomy singular name'),
        'search_items' => __('Search '.$singular.' Categories'),
        'popular_items' => __('Popular '.$singular.' Categories'),
        'all_items' => __('All '.$singular.' Categories'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit '.$singular.' Category'),
        'update_item' => __('Update '.$singular.' Category'),
        'add_new_item' => __('Add New '.$singular.' Category'),
        'new_item_name' => __('New '.$singular.' Category Name'),
        'separate_items_with_commas' => __('Separate '.$singular.' Categories with commas'),
        'add_or_remove_items' => __('Add or remove '.$singular.' Categories'),
        'choose_from_most_used' => __('Choose from the most used '.$singular.' Categories'),
        'menu_name' => __($singular.' Categories'),
    );

    register_taxonomy($custom_post_category, $custom_post_type, array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => $custom_post_category),
    ));
    
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name' => _x($singular.' Tags', 'taxonomy general name'),
        'singular_name' => _x($singular.' Tag', 'taxonomy singular name'),
        'search_items' => __('Search '.$singular.' Tags'),
        'popular_items' => __('Popular '.$singular.' Tags'),
        'all_items' => __('All '.$singular.' Tags'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit '.$singular.' Tag'),
        'update_item' => __('Update '.$singular.' Tag'),
        'add_new_item' => __('Add New '.$singular.' Tag'),
        'new_item_name' => __('New '.$singular.' Tag Name'),
        'separate_items_with_commas' => __('Separate '.$singular.' Tags with commas'),
        'add_or_remove_items' => __('Add or remove '.$singular.' Tags'),
        'choose_from_most_used' => __('Choose from the most used '.$singular.' Tags'),
        'menu_name' => __($singular.' Tags'),
    );

    register_taxonomy($custom_post_tag, $custom_post_type, array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => $custom_post_tag),
    ));
}

}


?>