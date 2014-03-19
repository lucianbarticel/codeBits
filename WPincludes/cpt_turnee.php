<?php

//le_scripts();

add_action('init', 'create_turnee');

function create_turnee() {
    $labels = array(
        'name' => _x('Turnee', 'post type general name'),
        'singular_name' => _x('Turneu', 'post type singular name'),
        'add_new' => _x('Adauga turneu', 'video'),
        'add_new_item' => __('Adauga turneu nou'),
        'edit_item' => __('Editeaza turneu'),
        'new_item' => __('Turneu nou'),
        'view_item' => __('Vezi turneu'),
        'search_items' => __('Cauta turneu'),
        'not_found' => __('Nici un turneu gasit'),
        'not_found_in_trash' => __('Nici un turneu gasit in trash'),
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
        'register_meta_box_cb' => 'add_turnee_metaboxes'
    );
    register_post_type('turnee', $args);
    flush_rewrite_rules(false);
}

add_action('init', 'build_turnee_taxonomy', 0);

function build_turnee_taxonomy() {
    $labels = array(
        'name' => 'Categorii de turnee',
    );
    register_taxonomy('taxonomie_turnee', array('turnee'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'show_in_nav_menus' => true,
    ));
}

add_action('load-post.php', 'turnee_metaboxes_setup');
add_action('load-post-new.php', 'turnee_metaboxes_setup');

function turnee_metaboxes_setup() {
    add_action('add_meta_boxes', 'add_turnee_metaboxes');
    add_action('save_post', 'save_turne_meta_box', 10, 2);
}

function add_turnee_metaboxes() {
    add_meta_box('tournament_club', 'Clubul de poker', 'add_tournament_club', 'turnee', 'normal', 'high');
    add_meta_box('turneu_date_time', 'Data si ora turneului', 'add_turneu_date_time', 'turnee', 'normal', 'high');
    add_meta_box('turneu_buy_in', 'Buy In + Bounty + Fee', 'add_turneu_buy_in', 'turnee', 'normal', 'high');
    add_meta_box('turneu_currency', 'Moneda', 'add_turneu_currency', 'turnee', 'normal', 'high');
    add_meta_box('turneu_is_satelite', 'Satelit', 'add_turneu_is_satelit', 'turnee', 'normal', 'high');
    add_meta_box('turneu_satelite_to', 'Turneu pentru care e satelit', 'add_turneu_satelite_to', 'turnee', 'normal', 'high');
    add_meta_box('turneu_fise_start', 'Fise start', 'add_turneu_fise_start', 'turnee', 'normal', 'high');
    add_meta_box('turneu_timp_blind', 'Durata blind', 'add_turneu_timp_blind', 'turnee', 'normal', 'high');
    add_meta_box('turneu_premii', 'Valoare premii', 'add_turneu_premii', 'turnee', 'normal', 'high');
    add_meta_box('turneu_rezultate', 'Rezultate turneu', 'add_turneu_rezultate', 'turnee', 'normal', 'high');
    add_meta_box('turneu_has_late_reg', 'Inscrieri tarzii', 'add_has_late_reg', 'turnee', 'normal', 'high');
    add_meta_box('late_reg', 'Perioada Inscrieri tarzii', 'add_late_reg', 'turnee', 'normal', 'high');
    add_meta_box('has_online_satelites', 'Sateliti online', 'add_has_online_satelites', 'turnee', 'normal', 'high');
    add_meta_box('online_satelites_link', 'Link catre sateliti online', 'add_online_satelites_link', 'turnee', 'normal', 'high');
    add_meta_box('reg_available', 'Inscriere valabila', 'add_reg_available', 'turnee', 'normal', 'high');
    
    
}

function add_tournament_club($object, $box) {
    $thePostID = $object->ID;
    $tournament_club = get_post_meta($thePostID, 'tournament_club', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<select name="tournament_club" >';
//    echo '<option value="">Selecteaza clubul</option>';
    if ($tournament_club == "marriott") {
            $is_marriott = 'selected="selected"';
        }elseif($tournament_club == "vitan"){
            $is_vitan = 'selected="selected"';
        }
    echo '<option value="marriott" ' . $is_marriott . '>Marriott</option>';
    echo '<option value="vitan" ' . $is_vitan . '>Vitan</option>';
    echo '</select>';
}


function add_turneu_date_time($object, $box) {
    $thePostID = $object->ID;
    $turneu_date_time = get_post_meta($thePostID, 'turneu_date_time', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<input type="text" name="turneu_date_time" id="datepicker" value="' . $turneu_date_time . '"/>';
}

function add_turneu_buy_in($object, $box) {
    $thePostID = $object->ID;
    $turneu_buy_in = get_post_meta($thePostID, 'turneu_buy_in', true);
    $turneu_fee = get_post_meta($thePostID, 'turneu_fee', true);
    $turneu_bounty = get_post_meta($thePostID, 'turneu_bounty', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<input type="text" name="turneu_buy_in" id="turneu_buy_in" value="' . $turneu_buy_in . '"/> + ';
    echo '<input type="text" name="turneu_bounty" id="turneu_bounty" value="' . $turneu_bounty . '"/> + ';
    echo '<input type="text" name="turneu_fee" id="turneu_fee" value="' . $turneu_fee . '"/>';
}

function add_turneu_is_satelit($object, $box) {
    $thePostID = $object->ID;
    $turneu_is_satelite = get_post_meta($thePostID, 'turneu_is_satelite', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    if (!$turneu_is_satelite || $turneu_is_satelite != "yes") {
        $sat_no = 'checked';
    } else {
        $sat_yes = 'checked';
    }
    echo '<input type="radio" name="turneu_is_satelite" value="yes" ' . $sat_yes . '/> Da  ';
    echo ' <input type="radio" name="turneu_is_satelite" value="no" ' . $sat_no . '/> Nu';
}

function add_turneu_satelite_to($object, $box) {
    $thePostID = $object->ID;
    $turneu_satelite_to = get_post_meta($thePostID, 'turneu_satelite_to', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<select name="turneu_satelite_to" >';
    echo '<option value="">Selecteaza turneul</option>';
    query_posts(array('post_type' => array('turnee'), 'posts_per_page' => -1));
    while (have_posts()): the_post();
        $selected = '';
        $turn_id = get_the_id();
        $turn_title = get_the_title();
        if ($turneu_satelite_to == $turn_id) {
            $selected = 'selected="selected"';
        }
        echo '<option value="' . $turn_id . '" ' . $selected . '>' . $turn_title . '</option>';
    endwhile;
    wp_reset_query();
    echo '</select>';
}

function add_turneu_fise_start($object, $box) {
    $thePostID = $object->ID;
    $turneu_fise_start = get_post_meta($thePostID, 'turneu_fise_start', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<input type="text" name="turneu_fise_start"  value="' . $turneu_fise_start . '"/>';
}

function add_turneu_timp_blind($object, $box) {
    $thePostID = $object->ID;
    $turneu_timp_blind = get_post_meta($thePostID, 'turneu_timp_blind', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<input type="text" name="turneu_timp_blind"  value="' . $turneu_timp_blind . '"/>';
}

function add_turneu_premii($object, $box) {
    $thePostID = $object->ID;
    $turneu_premii = get_post_meta($thePostID, 'turneu_premii', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<input type="text" name="turneu_premii"  value="' . $turneu_premii . '"/>';
}

function add_has_late_reg($object, $box) {
    $thePostID = $object->ID;
    $turneu_has_late_reg = get_post_meta($thePostID, 'turneu_has_late_reg', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    if (!$turneu_has_late_reg || $turneu_has_late_reg != "yes") {
        $lr_no = 'checked';
    } else {
        $lr_yes = 'checked';
    }
    echo '<input type="radio" name="turneu_has_late_reg" value="yes" ' . $lr_yes . '/> Da  ';
    echo ' <input type="radio" name="turneu_has_late_reg" value="no" ' . $lr_no . '/> Nu';
}

function add_late_reg($object, $box) {
    $thePostID = $object->ID;
    $late_reg = get_post_meta($thePostID, 'late_reg', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<input type="text" name="late_reg"  value="' . $late_reg . '"/>';
}

function add_turneu_rezultate($object, $box) {
    $thePostID = $object->ID;
    $turneu_rezultate = get_post_meta($thePostID, 'turneu_rezultate', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<select name="turneu_rezultate" >';
    echo '<option value="">Selecteaza rezultate</option>';
    query_posts(array('post_type' => array('rezultate'), 'posts_per_page' => -1));
    while (have_posts()): the_post();
        $selected = '';
        $turn_id = get_the_id();
        $turn_title = get_the_title();
        if ($turneu_rezultate == $turn_id) {
            $selected = 'selected="selected"';
        }
        echo '<option value="' . $turn_id . '" ' . $selected . '>' . $turn_title . '</option>';
    endwhile;
    wp_reset_query();
    echo '</select>';
}

function add_has_online_satelites($object, $box) {
    $thePostID = $object->ID;
    $has_online_satelites = get_post_meta($thePostID, 'has_online_satelites', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    if (!$has_online_satelites || $has_online_satelites != "yes") {
        $onsat_no = 'checked';
    } else {
        $onsat_yes = 'checked';
    }
    echo '<input type="radio" name="has_online_satelites" value="yes" ' . $onsat_yes . '/> Da  ';
    echo ' <input type="radio" name="has_online_satelites" value="no" ' . $onsat_no . '/> Nu';
}

function add_online_satelites_link($object, $box) {
    $thePostID = $object->ID;
    $online_satelites_link = get_post_meta($thePostID, 'online_satelites_link', true);
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<input type="text" name="online_satelites_link"  value="' . $online_satelites_link . '"/>';
}
function add_reg_available($object, $box){
    $thePostID = $object->ID;
    $reg_available = get_post_meta($thePostID, 'reg_available', true);
    if (!$reg_available || $reg_available != "no") {
        $lr_yes = 'checked';
    } else {
        $lr_no = 'checked';
    }
    echo '<input type="radio" name="reg_available" value="yes" ' . $lr_yes . '/> Da  ';
    echo ' <input type="radio" name="reg_available" value="no" ' . $lr_no . '/> Nu';
}
function add_turneu_currency($object, $box){
    $thePostID = $object->ID;
    $currency = get_post_meta($thePostID, 'turneu_currency', true);
    if (!$currency || $currency != "euro") {
        $lr_yes = 'checked';
    } else {
        $lr_no = 'checked';
    }
    echo '<input type="radio" name="turneu_currency" value="lei" ' . $lr_yes . '/> Lei  ';
    echo ' <input type="radio" name="turneu_currency" value="euro" ' . $lr_no . '/> Euro';
}


function save_turne_meta_box($post_id, $post) {

    // Get the post type object. 
    $post_type = get_post_type_object($post->post_type);

    // Check if the current user has permission to edit the post. 
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;

    // Get the posted data and sanitize it for use as an HTML class.
    //$new_meta_value = ( isset($_POST['the_video_preview']) ? sanitize_html_class($_POST['the_video_preview']) : '' );
    $new_meta_values = array(
        'turneu_buy_in' => $_POST['turneu_buy_in'],
        'turneu_bounty' => $_POST['turneu_bounty'],
        'turneu_fee' => $_POST['turneu_fee'],
        'turneu_currency' => $_POST['turneu_currency'],
        'turneu_is_satelite' => $_POST['turneu_is_satelite'],
        'turneu_satelite_to' => $_POST['turneu_satelite_to'],
        'turneu_date_time' => $_POST['turneu_date_time'],
        'turneu_timp_blind' => $_POST['turneu_timp_blind'],
        'turneu_premii' => $_POST['turneu_premii'],
        'turneu_rezultate' => $_POST['turneu_rezultate'],
        'turneu_fise_start' => $_POST['turneu_fise_start'],
        'turneu_has_late_reg' => $_POST['turneu_has_late_reg'],
        'has_online_satelites' => $_POST['has_online_satelites'],
        'online_satelites_link' => $_POST['online_satelites_link'],
        'late_reg' => $_POST['late_reg'],
        'reg_available' => $_POST['reg_available'],
        'tournament_club' => $_POST["tournament_club"]
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
