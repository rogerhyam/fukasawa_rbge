<?php

// Add parent theme's styles
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style',     get_template_directory_uri() . '/style.css' );
   wp_enqueue_script('fukasawa_rbge_js', get_stylesheet_directory_uri() . '/main.js', null, '1.0', true );
}

/*
    Add featured images to the RSS feeds
*/
function add_featured_image_in_rss($content) {
    global $post;
    if ( has_post_thumbnail( $post->ID ) ){
        $content = '<p style="clear:both;overflow:hidden;">' . get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'style' => 'float:left; margin:0 1em 1em 0;' ) ) . '' . $content . '</p>';
    }
return $content;
}

add_filter('the_excerpt_rss', 'add_featured_image_in_rss');
add_filter('the_content_feed', 'add_featured_image_in_rss');

/* mechanism to hide low visability category items from main blog roll */
function exclude_category( $query ) {
    if ( ($query->is_home() && $query->is_main_query()) || $query->is_feed() ) {
        $query->set( 'cat', '-280' );
    }
}
add_action( 'pre_get_posts', 'exclude_category' );

/* hide some meta boxes from the innocent  */

function remove_scary_meta_boxes() {
 
    if(!current_user_can('administrator')){
        remove_meta_box( 'post_is_sticky' , 'post' , 'normal' );
        remove_meta_box( 'post_is_sticky' , 'post' , 'side' );
        remove_meta_box( 'formatdiv' , 'post' , 'normal' );     
        remove_meta_box( 'trackbacksdiv' , 'post' , 'normal' );
        remove_meta_box( 'postcustom' , 'post' , 'normal' );     
        remove_meta_box( 'slugdiv' , 'post' , 'normal' );
        remove_meta_box( 'shareaholic' , 'post' , 'normal' );    
    }

}
// add_action( 'admin_menu' , 'remove_scary_meta_boxes' );
add_action( 'add_meta_boxes' , 'remove_scary_meta_boxes' );

?>