<?php

//add_action('admin_init', 'get_users_for_autocomplete');

add_action('init', 'create_rezultate');

function create_rezultate() {
    $labels = array(
        'name' => _x('Rezultate', 'post type general name'),
        'singular_name' => _x('Rezultate', 'post type singular name'),
        'add_new' => _x('Adauga Rezultate', 'video'),
        'add_new_item' => __('Adauga Rezultate'),
        'edit_item' => __('Editeaza Rezultate'),
        'new_item' => __('Rezultate noi'),
        'view_item' => __('Vezi Rezultate'),
        'search_items' => __('Cauta Rezultate'),
        'not_found' => __('Nici un Rezultat gasit'),
        'not_found_in_trash' => __('Nici un Rezultate gasit in trash'),
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
    register_post_type('rezultate', $args);
    flush_rewrite_rules(false);
}

add_action('load-post.php', 'rezultate_metaboxes_setup');
add_action('load-post-new.php', 'rezultate_metaboxes_setup');

function rezultate_metaboxes_setup() {
    //get_users_for_autocomplete();
    add_action('add_meta_boxes', 'add_rezultate_metaboxes');
    add_action('save_post', 'save_rezultate_meta_box', 10, 2);
}

function add_rezultate_metaboxes() {
    add_meta_box('tournament_ignore_from_leaderboard', 'Ignora in leaderboard (Puncte)', 'add_ignore_leaderboard', 'rezultate', 'normal', 'high');
    add_meta_box('tournament_buy_in', 'BuyIn', 'add_buyIn', 'rezultate', 'normal', 'high');
    add_meta_box('registered_players', 'Jucatori inscrisi', 'add_registered_players', 'rezultate', 'normal', 'high');
    add_meta_box('locuri_premiate', 'Locuri premiate', 'add_locuri_premiate_rezultate', 'rezultate', 'normal', 'high');
    add_meta_box('clasament', 'Clasament', 'add_locuri_clasament', 'rezultate', 'normal', 'high');
}
function add_ignore_leaderboard($object, $box) {
    $thePostID = $object->ID;
    $tournament_ignore_from_leaderboard = get_post_meta($thePostID, 'tournament_ignore_from_leaderboard', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    if($tournament_ignore_from_leaderboard && $tournament_ignore_from_leaderboard == "true"){ $ignore = "checked"; }else{ $notignore = "checked"; }
    echo '<input type="radio" name="tournament_ignore_from_leaderboard" value="true" '.$ignore.'/> Ignora <br/>';
    echo '<input type="radio" name="tournament_ignore_from_leaderboard" value="false" '.$notignore.'/>Nu ignora';
}

function add_buyIn($object, $box) {
    $thePostID = $object->ID;
    $tournament_buy_in = get_post_meta($thePostID, 'tournament_buy_in', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<input type="text" name="tournament_buy_in"  value="' . $tournament_buy_in . '"/>';
}

function add_registered_players($object, $box) {
    $thePostID = $object->ID;
    $registered_players = get_post_meta($thePostID, 'registered_players', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<input type="text" name="registered_players"  value="' . $registered_players . '"/>';
}

function add_locuri_premiate_rezultate($object, $box) {
    $thePostID = $object->ID;
    $locuri_premiate = get_option('results_' . $thePostID . '_no');
    if (!$locuri_premiate || $locuri_premiate == "") {
        $locuri_premiate = 0;
    }
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<input type="text" name="locuri_premiate" id="locuri_premiate_input"  value="' . $locuri_premiate . '"/> <button id="submit_locuri_premiate">Afiseaza clasament</button>';
}

function add_locuri_clasament($object, $box) {
    $thePostID = $object->ID;
    $locuri_premiate = get_option('results_' . $thePostID . '_no');
    if ($locuri_premiate && $locuri_premiate != "") {
        for ($i = 1; $i <= $locuri_premiate; $i++) {
            $this_name = get_post_meta($thePostID, 'turneu_' . $thePostID . '_loc_' . $i, true);
            $this_prize = get_post_meta($thePostID, 'turneu_' . $thePostID . '_loc_' . $i . '_prize', true);
            $registered_players = get_post_meta($thePostID, 'registered_players', true);
            $tournament_buy_in = get_post_meta($thePostID, 'tournament_buy_in', true);
            if ($registered_players && $tournament_buy_in && $registered_players != "" && $tournament_buy_in != "") {
                $pokerfest_points = compute_pokerfest_points($registered_players, $tournament_buy_in, $i);
            } else {
                $pokerfest_points = '0';
            }

            echo '<label>Ocupant pozitia ' . $i . ':  </label>';
            echo '<input type="text" class="auto_jucator" name="turneu_' . $thePostID . '_loc_' . $i . '"  value="' . $this_name . '"/>';
            echo ' Puncte pokerfest:';
            echo ' <input type="text" name="turneu_' . $thePostID . '_loc_' . $i . '_points" value=" '.intval($pokerfest_points).'" />';
            echo ' Valoare premiu: ';
            echo '<input type="text" name="turneu_' . $thePostID . '_loc_' . $i . '_prize" value="' . $this_prize . '"';
            echo '<br/><br/> ';
        }
    }
}

function compute_pokerfest_points($registered_players, $tournament_buy_in, $pos) {
    $points = sqrt(($registered_players/$pos)*$tournament_buy_in*10);
    return $points;
}

function save_rezultate_meta_box($post_id, $post) {
    $locuri_premiate = get_option('results_' . $post_id . '_no');
    // Get the post type object. 
    $post_type = get_post_type_object($post->post_type);

    // Check if the current user has permission to edit the post. 
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;

    // Get the posted data and sanitize it for use as an HTML class.
    //$new_meta_value = ( isset($_POST['the_video_preview']) ? sanitize_html_class($_POST['the_video_preview']) : '' );
    $new_meta_values = array(
            //'gallery_id' => $_POST['gallery_id']
    );
    if ($locuri_premiate && $locuri_premiate != "") {
        for ($i = 1; $i <= $locuri_premiate; $i++) {
            //if ($_POST['turneu_' . $post_id . '_loc_' . $i] != "") {
            $new_meta_values['turneu_' . $post_id . '_loc_' . $i] = $_POST['turneu_' . $post_id . '_loc_' . $i];
            $new_meta_values['turneu_' . $post_id . '_loc_' . $i.'_points'] = $_POST['turneu_' . $post_id . '_loc_' . $i.'_points'];
            $new_meta_values['turneu_' . $post_id . '_loc_' . $i.'_prize'] = $_POST['turneu_' . $post_id . '_loc_' . $i.'_prize'];
            //}
        }
    }
    
    $new_meta_values['tournament_ignore_from_leaderboard'] = $_POST['tournament_ignore_from_leaderboard'];
    $new_meta_values['tournament_buy_in'] = $_POST['tournament_buy_in'];
    $new_meta_values['registered_players'] = $_POST['registered_players'];

    //print_r($new_meta_values);
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