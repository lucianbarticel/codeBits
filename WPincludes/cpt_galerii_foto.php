<?php

add_action('init', 'create_galerii_foto');

function create_galerii_foto() {
    $labels = array(
        'name' => _x('Galerii foto', 'post type general name'),
        'singular_name' => _x('Galerie foto', 'post type singular name'),
        'add_new' => _x('Adauga galerie foto', 'video'),
        'add_new_item' => __('Adauga galerie foto nou'),
        'edit_item' => __('Editeaza galerie foto'),
        'new_item' => __('Galerie foto noua'),
        'view_item' => __('Vezi galerie foto'),
        'search_items' => __('Cauta galerie foto'),
        'not_found' => __('Nici galerie foto gasita'),
        'not_found_in_trash' => __('Nici o galerie foto gasita in trash'),
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
        'supports' => array('title', 'thumbnail')
        //'taxonomies' => array('post_tag')
        //'register_meta_box_cb' => 'add_festivaluri_metaboxes'
    );
    register_post_type('galerii_foto', $args);
    flush_rewrite_rules(false);
}


add_action('load-post.php', 'galerii_foto_metaboxes_setup');
add_action('load-post-new.php', 'galerii_foto_metaboxes_setup');

function galerii_foto_metaboxes_setup() {
    add_action('add_meta_boxes', 'add_galerii_foto_metaboxes');
    add_action('save_post', 'save_galerii_foto_meta_box', 10, 2);
}

function add_galerii_foto_metaboxes() {
    add_meta_box('galerie_foto', 'Galerie foto', 'add_alege_galerie_foto_festival', 'galerii_foto', 'normal', 'high');
}

function add_alege_galerie_foto_festival($object, $box){
    $thePostID = $object->ID;
    global $nggdb;
    $gallerylist = $nggdb->find_all_galleries('gid', 'asc', TRUE, 25, $start, false);
    //print_r($gallerylist);
    $choosen_gallery = get_post_meta($thePostID, 'gallery_id', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<select name="gallery_id" >';
    echo '<option value="">Selecteaza galerie foto</option>';
    
    foreach($gallerylist as $gallery){
        $selected = '';
        $gal_id = $gallery->gid;
        $gal_title = $gallery->name;
        if ($choosen_gallery == $gal_id) {
            $selected = 'selected="selected"';
        }
        echo '<option value="' . $gal_id . '" ' . $selected . '>' . $gal_title . '</option>';
    }
    echo '</select>';
}

function save_galerii_foto_meta_box($post_id, $post) {

    // Get the post type object. 
    $post_type = get_post_type_object($post->post_type);

    // Check if the current user has permission to edit the post. 
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;

    // Get the posted data and sanitize it for use as an HTML class.
    //$new_meta_value = ( isset($_POST['the_video_preview']) ? sanitize_html_class($_POST['the_video_preview']) : '' );
    $new_meta_values = array(
        'gallery_id' => $_POST['gallery_id']
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

?>