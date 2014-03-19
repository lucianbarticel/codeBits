<?php

add_action('init', 'create_festivaluri');

function create_festivaluri() {
    $labels = array(
        'name' => _x('Festivaluri', 'post type general name'),
        'singular_name' => _x('Festival', 'post type singular name'),
        'add_new' => _x('Adauga festival', 'video'),
        'add_new_item' => __('Adauga festival nou'),
        'edit_item' => __('Editeaza festival'),
        'new_item' => __('Festival nou'),
        'view_item' => __('Vezi festival'),
        'search_items' => __('Cauta festival'),
        'not_found' => __('Nici un festival gasit'),
        'not_found_in_trash' => __('Nici un festival gasit in trash'),
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
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies' => array('post_tag')
            //'register_meta_box_cb' => 'add_festivaluri_metaboxes'
    );
    register_post_type('festivaluri', $args);
    flush_rewrite_rules(false);
}

add_action('load-post.php', 'festivaluri_metaboxes_setup');
add_action('load-post-new.php', 'festivaluri_metaboxes_setup');

function festivaluri_metaboxes_setup() {
    add_action('add_meta_boxes', 'add_festivaluri_metaboxes');
    add_action('save_post', 'save_festivaluri_meta_box', 10, 2);
}

function add_festivaluri_metaboxes() {

    add_meta_box('festival_cazare', 'Cazare festival', 'add_cazare_festival', 'festivaluri', 'normal', 'high');
    add_meta_box('festival_program', 'Program festival', 'add_program_festival', 'festivaluri', 'normal', 'high');
    add_meta_box('festival_rezultate', 'Rezultate festival', 'add_rezultate_festival', 'festivaluri', 'normal', 'high');
    add_meta_box('festival_foto', 'Galerie foto festival', 'add_galerie_foto_festival', 'festivaluri', 'normal', 'high');
    add_meta_box('festival_video', 'Galerie video festival', 'add_galerie_video_festival', 'festivaluri', 'normal', 'high');
    add_meta_box('festival_external_url', 'Link extern festival', 'add_external_link_festival', 'festivaluri', 'normal', 'high');
}

function add_cazare_festival($object, $box) {
    $thePostID = $object->ID;
    $festival_cazare = get_post_meta($thePostID, 'festival_cazare', true);
    if(!$festival_cazare || $festival_cazare == ""){ $festival_cazare == 'Nu exista detalii despre cazare'; }
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    //wp_editor('', 'festival_cazare', $settings = array());
    echo "<textarea name='cazare_festival' id='cazare_festival'>".$festival_cazare."</textarea>";
}

function add_program_festival($object, $box) {
    $thePostID = $object->ID;
    $festival_program = get_post_meta($thePostID, 'festival_program', true);
    echo '<select name="festival_program" >';
    echo '<option value="">Selecteaza program</option>';
    query_posts(array('post_type' => array('programe_festivaluri')));
    while (have_posts()): the_post();
        $selected = '';
        $turn_id = get_the_id();
        $turn_title = get_the_title();
        if ($festival_program == $turn_id) {
            $selected = 'selected="selected"';
        }
        echo '<option value="' . $turn_id . '" ' . $selected . '>' . $turn_title . '</option>';
    endwhile;
    wp_reset_query();
    echo '</select>';
}

function add_rezultate_festival($object, $box) {
    $thePostID = $object->ID;
    $festival_rezultate = get_post_meta($thePostID, 'festival_rezultate', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<select name="festival_rezultate" >';
    echo '<option value="">Selecteaza rezultate</option>';
    query_posts(array('post_type' => array('rezultate')));
    while (have_posts()): the_post();
        $selected = '';
        $turn_id = get_the_id();
        $turn_title = get_the_title();
        if ($festival_rezultate == $turn_id) {
            $selected = 'selected="selected"';
        }
        echo '<option value="' . $turn_id . '" ' . $selected . '>' . $turn_title . '</option>';
    endwhile;
    wp_reset_query();
    echo '</select>';
}

function add_galerie_foto_festival($object, $box) {
    $thePostID = $object->ID;
    global $nggdb;
    $gallerylist = $nggdb->find_all_galleries('gid', 'asc', TRUE, 25, $start, false);
    //print_r($gallerylist);
    $choosen_gallery = get_post_meta($thePostID, 'festival_foto', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<select name="festival_foto" >';
    echo '<option value="">Selecteaza galerie foto</option>';

    foreach ($gallerylist as $gallery) {
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

function add_galerie_video_festival() {
    
}

function add_external_link_festival($object, $box){
    $thePostID = $object->ID;
    $festival_link = get_post_meta($thePostID, 'festival_external_link', true);
    echo '<input type="text" name="festival_external_link"  value="' . $festival_link . '"/>';
}

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
        'festival_cazare' => $_POST['cazare_festival'],
        'festival_rezultate' => $_POST['festival_rezultate'],
        'festival_foto' => $_POST['festival_foto'],
        'festival_video' => $_POST['festival_video'],
        'festival_external_link' => $_POST['festival_external_link']
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
