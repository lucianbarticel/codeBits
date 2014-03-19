<?php

add_action('init', 'create_articole_live');

function create_articole_live() {
    $labels = array(
        'name' => _x('Articole live', 'post type general name'),
        'singular_name' => _x('Articol live', 'post type singular name'),
        'add_new' => _x('Adauga articol live', 'partner'),
        'add_new_item' => __('Adauga articol nou'),
        'edit_item' => __('Editeaza articol'),
        'new_item' => __('Articol nou'),
        'view_item' => __('Vezi articol'),
        'search_items' => __('Cauta articol'),
        'not_found' => __('Nici un articol gasit'),
        'not_found_in_trash' => __('Nici un articol gasit in trash'),
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
        'taxonomies' => array('post_tag'),
        'register_meta_box_cb' => 'add_articole_live_metaboxes'
    );
    register_post_type('articole_live', $args);
    flush_rewrite_rules(false);
}

add_action('load-post.php', 'articole_live_metaboxes_setup');
add_action('load-post-new.php', 'articole_live_metaboxes_setup');

function articole_live_metaboxes_setup() {
    add_action('add_meta_boxes', 'add_articole_live_metaboxes');
    add_action('save_post', 'save_articole_live_meta_box', 10, 2);
}

function add_articole_live_metaboxes() {
    add_meta_box('tournament_to_assign', 'Turneul pentru articole live', 'add_tournament_to_assign', 'articole_live', 'normal', 'high');
}

function add_tournament_to_assign($object, $box) {
    $thePostID = $object->ID;
    $tournament_to_assign = get_post_meta($thePostID, 'tournament_to_assign', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<select name="tournament_to_assign" >';
    echo '<option value="">Selecteaza turneul pentru articolul live</option>';
    query_posts(array('post_type' => array('turnee'), 'posts_per_page' => -1));
    while (have_posts()): the_post();
        $selected = '';
        $turn_id = get_the_id();
        $turn_title = get_the_title();
        if ($tournament_to_assign == $turn_id) {
            $selected = 'selected="selected"';
        }
        echo '<option value="' . $turn_id . '" ' . $selected . '>' . $turn_title . '</option>';
    endwhile;
    wp_reset_query();
    echo '</select>';
}

function save_articole_live_meta_box($post_id, $post) {

    // Get the post type object. 
    $post_type = get_post_type_object($post->post_type);

    // Check if the current user has permission to edit the post. 
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;

    // Get the posted data and sanitize it for use as an HTML class.
    //$new_meta_value = ( isset($_POST['the_video_preview']) ? sanitize_html_class($_POST['the_video_preview']) : '' );
    $new_meta_values = array(
        'tournament_to_assign' => $_POST['tournament_to_assign']
            // 'registered_players' => $_POST['registered_players']
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