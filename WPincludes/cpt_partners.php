<?php

add_action('init', 'create_partners');

function create_partners() {
    $labels = array(
        'name' => _x('Parteneri', 'post type general name'),
        'singular_name' => _x('Parteneri', 'post type singular name'),
        'add_new' => _x('Adauga partener nou', 'partner'),
        'add_new_item' => __('Adauga partener nou'),
        'edit_item' => __('Editeaza partener'),
        'new_item' => __('Partener nou'),
        'view_item' => __('Vezi partener'),
        'search_items' => __('Cauta partener'),
        'not_found' => __('Nici un partener gasit'),
        'not_found_in_trash' => __('Nici un partener gasit in trash'),
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
        'supports' => array('title', 'thumbnail'),
        'taxonomies' => array('post_tag')
        //'register_meta_box_cb' => 'add_festivaluri_metaboxes'
    );
    register_post_type('partner', $args);
    flush_rewrite_rules(false);
}
?>