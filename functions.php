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
    $content = '<p>' . get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'style' => 'float:left; margin:0 1em 1em 0;' ) ) . '' . $content . '</p>';
}
return $content;
}

add_filter('the_excerpt_rss', 'add_featured_image_in_rss');
add_filter('the_content_feed', 'add_featured_image_in_rss');


?>