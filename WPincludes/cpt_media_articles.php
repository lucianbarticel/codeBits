<?php

add_action('init', 'create_media_articles');

function create_media_articles() {
    $labels = array(
        'name' => _x('Media', 'post type general name'),
        'singular_name' => _x('Articol media', 'post type singular name'),
        'add_new' => _x('Adauga articol media', 'partner'),
        'add_new_item' => __('Adauga articol media nou'),
        'edit_item' => __('Editeaza articol media'),
        'new_item' => __('Articol media nou'),
        'view_item' => __('Vezi articol media'),
        'search_items' => __('Cauta articol media'),
        'not_found' => __('Nici un articol media gasit'),
        'not_found_in_trash' => __('Nici un articol media gasit in trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        'menu_position' => null,
        'supports' => array('title','editor', 'thumbnail', 'excerpt'),
        'taxonomies' => array('post_tag')
        //'register_meta_box_cb' => 'add_festivaluri_metaboxes'
    );
    register_post_type('media_post', $args);
    flush_rewrite_rules(false);
}
?>