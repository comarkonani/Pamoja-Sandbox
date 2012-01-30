<?php
/*
This file is part of SANDBOX.

SANDBOX is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

SANDBOX is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with SANDBOX. If not, see http://www.gnu.org/licenses/.
*/

// Translate, if applicable
load_theme_textdomain('sandbox');

require_once('custom-post-news.php');

/*
* Disables the admin bar at the backend and also the front end. Also removes the 28px padding that the admin bar leaves behind
* Function: disableAdminBar
* Author: Comark
*/

if (!function_exists('disableAdminBar')) {

	function disableAdminBar(){

  	remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 ); // for the admin page
    remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 ); // for the front end

    function remove_admin_bar_style_backend() {  // css override for the admin page
      echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
    }

    add_filter('admin_head','remove_admin_bar_style_backend');

    function remove_admin_bar_style_frontend() { // css override for the frontend
      echo '<style type="text/css" media="screen">
      html { margin-top: 0px !important; }
      * html body { margin-top: 0px !important; }
      </style>';
    }

    add_filter('wp_head','remove_admin_bar_style_frontend', 99);

  }

}

add_action('init','disableAdminBar'); // New version
/***************************************/

/*
* Creates custom post types with the post type name, tag name as 'postname-tag' and taxonomy as 'postname-category'. 
* Parameters: post type name, singular name, plural name and the arguments it supports in an array
* Example: $newPostType = create_post_type('song','Song','Songs', array('title','editor')) ;
* Function: create_post_type
* Author: Comark
*/
$newPostType = new newPostType(); 
$post_type_args =  array('title', 'editor', 'thumbnail', 'excerpt', 'tags', 'author', 'tracbacks', 'revisions', 'comments');
$newPostType->create_post_type('song','Song','Songs',$post_type_args);


// For category lists on category archives: Returns other categories except the current one (redundant)
function sandbox_cats_meow($glue) {
    $current_cat = single_cat_title('', false);
    $separator = "\n";
    $cats = explode($separator, get_the_category_list($separator));
    foreach ($cats as $i => $str) {
        if (strstr($str, ">$current_cat<")) {
            unset($cats[$i]);
            break;
        }
    }
    if (empty($cats))
        return false;

    return trim(join($glue, $cats));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function sandbox_tag_ur_it($glue) {
    $current_tag = single_tag_title('', '', false);
    $separator = "\n";
    $tags = explode($separator, get_the_tag_list("", "$separator", ""));
    foreach ($tags as $i => $str) {
        if (strstr($str, ">$current_tag<")) {
            unset($tags[$i]);
            break;
        }
    }
    if (empty($tags))
        return false;

    return trim(join($glue, $tags));
}

// Produces an avatar image with the hCard-compliant photo class
function sandbox_commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
	$avatar_size = apply_filters( 'avatar_size', '32' ); // Available filter: avatar_size
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, $avatar_size ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}

// Widgets plugin: intializes the plugin after the widgets above have passed snuff
function sandbox_widgets_init() {
    if (!function_exists('register_sidebars') || !function_exists('register_nav_menus'))
    return;

    register_nav_menus(array(
        'top' => __('Top Menu', 'themename'),
        'side' => __('Side Menu', 'themename'),
        'footer' => __('Footer Menu', 'themename')
    ));

    // Formats the Sandbox widgets, adding readability-improving whitespace
    register_sidebars(1, array(
        'name' => 'Sidebar',
        'before_widget' => '<div id="%1$s" class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
            )
    );
}

// Runs our code at the end to check that everything needed has loaded
add_action( 'init', 'sandbox_widgets_init' );

// Add support for Featured Images
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}

// Load jQuery from google cdn
/*if (!function_exists(core_mods)) {

    function core_mods() {
        if (!is_admin()) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"), false);
            wp_enqueue_script('jquery');
        }
    }

    core_mods();
} 
*/

add_action('wp_footer', 'add_sandbox_scripts');

function add_sandbox_scripts() {
    //wp_enqueue_script('jquery-ui-datepicker');
}
?>