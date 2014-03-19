<?php

add_action('init', 'create_testimonials');

function create_testimonials() {
    $labels = array(
        'name' => _x('Testimoniale', 'post type general name'),
        'singular_name' => _x('Tesimonial', 'post type singular name'),
        'add_new' => _x('Adauga testimonial', 'partner'),
        'add_new_item' => __('Adauga nou'),
        'edit_item' => __('Editeaza testimonial'),
        'new_item' => __('Articol testimonial nou'),
        'view_item' => __('Vezi testimonial'),
        'search_items' => __('Cauta testimonial'),
        'not_found' => __('Nici un testimonial gasit'),
        'not_found_in_trash' => __('Nici un testimonial gasit in trash'),
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
        'supports' => array('title','editor', 'thumbnail'),
        'taxonomies' => array('post_tag')
        //'register_meta_box_cb' => 'add_festivaluri_metaboxes'
    );
    register_post_type('testimonials', $args);
    flush_rewrite_rules(false);
}
?>