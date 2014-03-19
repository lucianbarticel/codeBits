<?php

add_action('init', 'create_galerii_video');

function create_galerii_video() {
    $labels = array(
        'name' => _x('Galerii video', 'post type general name'),
        'singular_name' => _x('Galerie video', 'post type singular name'),
        'add_new' => _x('Adauga galerie video', 'video'),
        'add_new_item' => __('Adauga galerie video nou'),
        'edit_item' => __('Editeaza galerie video'),
        'new_item' => __('Galerie video noua'),
        'view_item' => __('Vezi galerie video'),
        'search_items' => __('Cauta galerie video'),
        'not_found' => __('Nici galerie video gasita'),
        'not_found_in_trash' => __('Nici o galerie video gasita in trash'),
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
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('post_tag')
        //'register_meta_box_cb' => 'add_festivaluri_metaboxes'
    );
    register_post_type('galerii_video', $args);
    flush_rewrite_rules(false);
}

/*
add_action('load-post.php', 'festivaluri_metaboxes_setup');
add_action('load-post-new.php', 'festivaluri_metaboxes_setup');

function festivaluri_metaboxes_setup() {
    add_action('add_meta_boxes', 'add_festivaluri_metaboxes');
    add_action('save_post', 'save_festivaluri_meta_box', 10, 2);
}

function add_festivaluri_metaboxes() {
    add_meta_box('festival_program', 'Program festival', 'add_program_festival', 'festivaluri', 'normal', 'high');
    add_meta_box('festival_cazare', 'Cazare festival', 'add_cazare_festival', 'festivaluri', 'normal', 'high');
    add_meta_box('festival_rezultate', 'Rezultate festival', 'add_rezultate_festival', 'festivaluri', 'normal', 'high');
    add_meta_box('festival_video', 'Galerie video festival', 'add_galerie_video_festival', 'festivaluri', 'normal', 'high');
    add_meta_box('festival_video', 'Galerie video festival', 'add_galerie_video_festival', 'festivaluri', 'normal', 'high');
}

function add_program_festival(){
    
}

function add_cazare_festival(){}
function add_rezultate_festival(){}
function add_galerie_video_festival(){
    
}
function add_galerie_video_festival(){}

function save_festivaluri_meta_box($post_id, $post) {

    // Get the post type object. 
    $post_type = get_post_type_object($post->post_type);

    // Check if the current user has permission to edit the post. 
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;

    // Get the posted data and sanitize it for use as an HTML class.
    //$new_meta_value = ( isset($_POST['the_video_preview']) ? sanitize_html_class($_POST['the_video_preview']) : '' );
    $new_meta_values = array(
        'festival_program' => $_POST['festival_program'],
        'festival_cazare' => $_POST['festival_cazare'],
        'festival_rezultate' => $_POST['festival_rezultate'],
        'festival_media' => $_POST['festival_media']
        );
    
    // Get the meta key.
    //$meta_key = 'vimeo_video_id';
    foreach ($new_meta_values as $name => $value) {
        $meta_key = $name;
        $new_meta_value = $value;
        // Get the meta value of the custom field key. 
        $meta_value = get_post_meta($post_id, $meta_key, true);

        // If a new meta value was added and there was no previous value, add it. 
        if ($new_meta_value && '' == $meta_value)
            add_post_meta($post_id, $meta_key, $new_meta_value, true);

        // If the new meta value does not match the old value, update it. 
        elseif ($new_meta_value && $new_meta_value != $meta_value)
            update_post_meta($post_id, $meta_key, $new_meta_value);

        // If there is no new meta value but an old value exists, delete it. 
        elseif ('' == $new_meta_value && $meta_value)
            delete_post_meta($post_id, $meta_key, $meta_value);
    }
}
*/
?>