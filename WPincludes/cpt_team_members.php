<?php

add_action('init', 'create_team_members');

function create_team_members() {
    $labels = array(
        'name' => _x('Echipa', 'post type general name'),
        'singular_name' => _x('Membru echipa', 'post type singular name'),
        'add_new' => _x('Adauga membru echipa', 'partner'),
        'add_new_item' => __('Adauga membru echipa nou'),
        'edit_item' => __('Editeaza membru echipa'),
        'new_item' => __('Membru echipa nou'),
        'view_item' => __('Vezi membru echipa'),
        'search_items' => __('Cauta membru echipa'),
        'not_found' => __('Nici un membru gasit'),
        'not_found_in_trash' => __('Nici un membru gasit in trash'),
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
    register_post_type('team_members', $args);
    flush_rewrite_rules(false);
}

add_action('load-post.php', 'tm_metaboxes_setup');
add_action('load-post-new.php', 'tm_metaboxes_setup');

function tm_metaboxes_setup() {
    add_action('add_meta_boxes', 'add_tm_metaboxes');
    add_action('save_post', 'save_tm_metaboxes', 10, 2);
}

function add_tm_metaboxes() {
    add_meta_box('tm_function', 'Functiie in cadrul PokerFest Club', 'add_tm_function', 'team_members', 'normal', 'high');
}

function add_tm_function($object, $box) {
    $thePostID = $object->ID;
    $tm_function = get_post_meta($thePostID, 'tm_function', true);
    $tm_function_en = get_post_meta($thePostID, 'tm_function_en', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<label>Functia in cadrul clubului (RO)</label><input type="text" name="tm_function" id="tm_function" value="' . $tm_function . '"/> <br /><br />';
    echo '<label>Functia in cadrul clubului (EN)</label><input type="text" name="tm_function_en" id="tm_function_en" value="' . $tm_function_en . '"/>';
}

function save_tm_metaboxes($post_id, $post) {
    // Get the post type object. 
    $post_type = get_post_type_object($post->post_type);

    // Check if the current user has permission to edit the post. 
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;

    // Get the posted data and sanitize it for use as an HTML class.
    //$new_meta_value = ( isset($_POST['the_video_preview']) ? sanitize_html_class($_POST['the_video_preview']) : '' );
    $new_meta_values = array(
        'tm_function' => $_POST['tm_function'],
        'tm_function_en' => $_POST['tm_function_en']
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