<?php

include_once('panel_notifications.php');
include_once('extra_user_fields.php');
include_once('cpt_turnee.php');
include_once('cpt_festivaluri.php');
//include_once('includes/cpt_galerii_foto.php');
//include_once('cpt_galerii_video.php');
include_once('cpt_programe_turnee.php');
include_once('cpt_rezultate.php');
include_once('cpt_media_articles.php');
include_once('cpt_team_members.php');
include_once('cpt_testimonials.php');
include_once('cpt_partners.php');
include_once('cpt_articole_live.php');
//include_once('handle_photo_upload.php');
include_once('panel_general_var.php');
include_once('panel_user_activity.php');
include_once('panel_import_csv.php');
include_once('panel_export_database_csv.php');
include_once('panel_optiuni_cash.php');
include_once('widgets/widget-next_10_tournaments.php');
include_once('widgets/widget-next_2_tr.php');
include_once('widgets/widget-last-video.php');
include_once('widgets/widget-chat.php');

include_once('classes/user.php');
include_once('classes/tournament.php');
include_once('classes/leaderboard.php');

//include_once('tinymce/poker.php');
register_nav_menu('footer', 'Footer menu');

//confirma cont la logare
function check_confirmed($user_login, $user) {
    $confirmed = get_user_meta($user->ID, 'confirmed', true);
    if ($confirmed == 'yes') {
        
    } else {
        update_user_meta($user->ID, 'confirmed', 'yes');
    }
}

add_action('wp_login', 'check_confirmed', 10, 2);

//scoate coloana POSTS din tabelul USERS
add_action('manage_users_columns', 'remove_user_posts_column');

function remove_user_posts_column($column_headers) {
    unset($column_headers['posts']);
    return $column_headers;
}

//Adauga coloanele confirmed si data in tabelul USERS

function test_modify_user_table($column) {

    $column['date_created'] = 'Date created';
    //$column['confirmed'] = 'Confirmed';
    $column['active'] = 'Active user';
    return $column;
}

add_filter('manage_users_columns', 'test_modify_user_table');

function test_modify_user_table_row($val, $column_name, $user_id) {
    $user = get_userdata($user_id);

    switch ($column_name) {

        case 'date_created' :
            return $user->user_registered;
            break;
        case 'confirmed' :
            return get_user_meta($user_id, 'confirmed', true);
            break;
        case 'active' :
            $active = get_user_meta($user_id, 'active', true);
            if ($active == 'yes')
                $active_msg = 'selected="selected"';
            return '<select name="active_user' . $user_id . '" class="active_user"><option value="no">No</option><option value="yes" ' . $active_msg . '>Yes</option></select>';
            break;
        default:
    }
    return $return;
}

add_filter('manage_users_custom_column', 'test_modify_user_table_row', 10, 3);

//adauga scripturi in admin area
function le_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script("myUi", get_template_directory_uri() . "/includes/js/jquery-ui.min.js");
    wp_enqueue_script("timePicker", get_template_directory_uri() . "/includes/js/timePicker.js");
    wp_enqueue_script("lucian_custom", get_template_directory_uri() . "/includes/js/lucian_custom.js");
}

add_action('admin_enqueue_scripts', 'le_scripts');

function get_users_for_autocomplete() {
    $blogusers = get_users();
    $user_names = array();
    foreach ($blogusers as $bloguser) {
        array_push($user_names, $bloguser->display_name);
    }
    echo "<script type = 'text/javascript'>";
    $js_array = json_encode($user_names);
    echo "var availableNames  = " . $js_array . ";\n";
    echo "</script>";
}

add_action('admin_enqueue_scripts', 'get_users_for_autocomplete');

function le_styles() {
    wp_enqueue_style('stylesheet_name', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('timePickerCSS', get_template_directory_uri() . '/includes/css/timePicker.css');
    wp_enqueue_style('admin_css', get_template_directory_uri() . '/includes/css/lucian_custom_admin.css');
}

add_action('admin_enqueue_scripts', 'le_styles');

function ss_scripts() {
    wp_enqueue_script("myUi", get_template_directory_uri() . "/includes/js/jquery-ui.min.js");
    wp_enqueue_script("lucian_custom_frontend", get_template_directory_uri() . "/includes/js/lucian_custom_frontend.js");
}

add_action('wp_enqueue_scripts', 'ss_scripts');

function ss_styles() {
    wp_enqueue_style('stylesheet_name', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('TimePickerCss', get_template_directory_uri() . '/includes/css/timePicker.css');
    wp_enqueue_style('lucianCustom', get_template_directory_uri() . '/includes/css/lucian_custom.css');
}

add_action('wp_enqueue_scripts', 'ss_styles');

//functia pt ajax de activare a utilizatorului
function update_active_user() {
    $user_id = $_POST['user_id'];
    $value = $_POST['value'];
    update_user_meta($user_id, 'active', $value);
    $result = '<span class="updated">updated</updated>';
    die($result);
}

add_action('wp_ajax_nopriv_update_active_user', 'update_active_user');
add_action('wp_ajax_update_active_user', 'update_active_user');

//functioa pt ajax pentru salvare numar rezultate
function save_show_results() {
    $positions = $_POST['positions'];
    $post_ID = $_POST['post_id'];
    update_option('results_' . $post_ID . '_no', $positions);
    $result = $positions;
    die($result);
}

add_action('wp_ajax_nopriv_save_show_results', 'save_show_results');
add_action('wp_ajax_save_show_results', 'save_show_results');

//functie pt ajax pentru salvare nr zile festival
/*
  function save_festival_days(){
  $days= $_POST['days'];
  $post_ID = $_POST['post_id'];
  update_post_meta($post_ID, 'program_days_no', $days);
  $result = $days;
  $link_to_refresh = edit_post_link($post_ID);
  die($link_to_refresh);
  }
  add_action('wp_ajax_nopriv_save_festival_days', 'save_festival_days');
  add_action('wp_ajax_save_festival_days', 'save_festival_days');
 */
//functie pt ajax pentru adaugare turneu in festival
function add_tournament_no_per_day() {
    $var_name = $_POST['var_name'];
    $no_turnee = $_POST['no_turnee'];
    $post_ID = $_POST['post_id'];
    update_post_meta($post_ID, $var_name, $no_turnee);
    $result = $var_name . '**' . $no_turnee;
    die($result);
}

add_action('wp_ajax_nopriv_add_tournament_no_per_day', 'add_tournament_no_per_day');
add_action('wp_ajax_add_tournament_no_per_day', 'add_tournament_no_per_day');

// redirect catre home la logout
function logout_redirect765() {
    wp_redirect(home_url());
    exit;
}

add_action('wp_logout', 'logout_redirect765');
//dezactiveaza bara pentru subscriberi
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

//nu lasa subscriberi in admin
function restrict_admin_with_redirect() {
    if (!current_user_can('manage_options') && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php') {
        wp_redirect(site_url());
        exit;
    }
}

add_action('admin_init', 'restrict_admin_with_redirect');

// ia notificari pt utilizator
function get_notifications_number($user_id) {
    $my_notifications_nr = 0;
    $notifications_number = get_option('notifications_number');
    for ($i = 1; $i <= $notifications_number; $i++) {
        $users = get_option("user_list_notification_" . $i);
        if (in_array($user_id, $users)) {
            $my_notifications_nr++;
        }
    }
    return $my_notifications_nr;
}

// ia notificari noi pt utilizator
function get_new_notifications_number($user_id) {
    $my_notifications_nr = 0;
    $notifications_number = get_option('notifications_number');
    for ($i = 1; $i <= $notifications_number; $i++) {
        $users = get_option("user_list_notification_" . $i);
        if ($users) {
            if (in_array($user_id, $users)) {
                $status = get_user_meta($user_id, 'status_notification_' . $i, true);
                if ($status == 'not-seen') {
                    $my_notifications_nr++;
                }
            }
        }
    }
    return $my_notifications_nr;
}

// marcheaza notificarile ca si vazute
function mark_notification_as_seen() {
    $user_id = get_current_user_id();
//$my_notifications_nr=0;
    $notifications_number = get_option('notifications_number');
    for ($i = 1; $i <= $notifications_number; $i++) {
        $users = get_option("user_list_notification_" . $i);
        if (in_array($user_id, $users)) {
            $status = get_user_meta($user_id, 'status_notification_' . $i, true);
            if ($status == 'not-seen') {
                update_user_meta($user_id, 'status_notification_' . $i, 'seen');
            }
        }
    }
}

add_action('wp_ajax_mark_notification_as_seen', 'mark_notification_as_seen');
add_action('wp_ajax_nopriv_mark_notification_as_seen', 'mark_notification_as_seen');

//ia toate valorile pentru buy-in

function get_valori_fise_start() {
    $valori_fise_start = array();
    $args = array('post_type' => 'turnee');
    query_posts($args);
    if (have_posts()) : while (have_posts()): the_post();
            $turn_id = get_the_id();
            $fise_start = get_post_meta($turn_id, 'turneu_fise_start', true);
            if ($fise_start && $fise_start != "" && !in_array($fise_start, $valori_fise_start)) {
                array_push($valori_fise_start, $fise_start);
            }

        endwhile;
    endif;
    wp_reset_query();
    sort($valori_fise_start);
    return $valori_fise_start;
}

function get_valori_timp_blinduri() {
    $valori_timp_blind = array();
    $args = array('post_type' => 'turnee');
    query_posts($args);
    if (have_posts()) : while (have_posts()): the_post();
            $turn_id = get_the_id();
            $blind_time = get_post_meta($turn_id, 'turneu_timp_blind', true);
            if ($blind_time && $blind_time != "" && !in_array($blind_time, $valori_timp_blind)) {
                array_push($valori_timp_blind, $blind_time);
            }

        endwhile;
    endif;
    wp_reset_query();
    sort($valori_timp_blind);
    return $valori_timp_blind;
}

function is_user_full_logged($user_id) {
    $active = get_user_meta($user_id, 'active', true);
    if (is_user_logged_in() && current_user_can('manage_options')) {
        return true;
    } elseif (is_user_logged_in() && $active == 'yes') {
        return true;
    } else {
        return false;
    }
}

function user_turney_reg_dereg($turn_id, $user_id, $action) {
    $announced_players = get_post_meta($turn_id, 'announced_players', true);
    if ($action == 'register') {
        if (!is_user_registerd_to_turney($user_id, $turn_id)) {
            $new_announced_players_value = $announced_players + 1;
            update_user_meta($user_id, 'registration_turney_' . $turn_id, 'true');
            update_post_meta($turn_id, 'announced_players', $new_announced_players_value);
        }
    } else {
        if (is_user_registerd_to_turney($user_id, $turn_id)) {
            $new_announced_players_value = $announced_players - 1;
            update_user_meta($user_id, 'registration_turney_' . $turn_id, 'false');
            update_post_meta($turn_id, 'announced_players', $new_announced_players_value);
        }
    }
}

function is_user_registerd_to_turney($user_id, $turn_id) {
    $reg_value = get_user_meta($user_id, 'registration_turney_' . $turn_id, true);
    if ($reg_value && $reg_value == 'true') {
        return true;
    } else {
        return false;
    }
}

function get_pokerfest_points($displayName) {
    $total_points = 0;
    global $wpdb;
    $results = $wpdb->get_results("SELECT meta_key FROM $wpdb->postmeta WHERE meta_value = '" . $displayName . "'");
    foreach ($results as $result) {
        //echo $result->meta_key.'_points';
        $points = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '" . $result->meta_key . "_points'");
        foreach ($points as $single_points) {
            //echo $single_points->meta_value;
            $total_points = $total_points + $single_points->meta_value;
        }
    }
    return $total_points;
}

function get_periodic_pokerfest_points($displayName, $from, $to) {
    $somefrom = $from;
    $someto = $to;
    $total_points = 0;
    global $wpdb;
    //$displayName=replace($displayName,"'","\'");
    $results = $wpdb->get_results('SELECT meta_key FROM '.$wpdb->postmeta.' WHERE meta_value = "' . $displayName . '"');
    foreach ($results as $result) {
        //echo $result->meta_key.'_points';

        $points = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = '" . $result->meta_key . "_points'");
        //echo $points[0]->meta_key.'<br />';

        foreach ($points as $single_points) {
            //echo $single_points->meta_key.'<br />';
            $single_points_pieces = explode("_", $single_points->meta_key);
            $resultId = $single_points_pieces[1];
            //echo $resultId.'<br />';
            $ignoreVar = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = " . $resultId . " AND meta_key = 'tournament_ignore_from_leaderboard'");

            if (empty($ignoreVar) || $ignoreVar[0]->meta_value == "false") {
                $trid_res = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'turneu_rezultate' AND meta_value = " . $resultId);
                $trid = $trid_res[0]->post_id;
                $trdate_res = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'turneu_date_time' AND post_id = " . $trid);
                $trdate = $trdate_res[0]->meta_value;
                $trdate_pieces = explode(" ", $trdate);
                $trday = $trdate_pieces[0];
                $trday_str = strtotime($trday);
                $from_str = strtotime($from);
                $to_str = strtotime($to);
                if ($trday_str <= $to_str && $trday_str >= $from_str) {
                    $total_points = $total_points + $single_points->meta_value;
                }
            }


            //
            //echo $trdate->meta_value.'<br />';
            //var_dump($trdate);echo "///".$tournamentId.'<br />';
        //
        }
    }
    return $total_points;
}

function get_overal_winnings($displayName) {
    $total_prizes = 0;
    global $wpdb;
    $results = $wpdb->get_results("SELECT meta_key FROM $wpdb->postmeta WHERE meta_value = '" . $displayName . "'");
    foreach ($results as $result) {
        //echo $result->meta_key.'_points';
        $prizes = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '" . $result->meta_key . "_prize'");
        foreach ($prizes as $prize) {
            //echo $single_points->meta_value;
            $total_prizes = $total_prizes + $prize->meta_value;
        }
    }
    return $total_prizes;
}

function get_periodic_winnings($displayName, $from, $to) {
    $somefrom = $from;
    $someto = $to;
    $total_points = 0;
    global $wpdb;
    $results = $wpdb->get_results("SELECT meta_key FROM $wpdb->postmeta WHERE meta_value = '" . $displayName . "'");
    foreach ($results as $result) {
        //echo $result->meta_key.'_points';

        $points = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = '" . $result->meta_key . "_prize'");
        //echo $points[0]->meta_key.'<br />';

        foreach ($points as $single_points) {
            //echo $single_points->meta_key.'<br />';
            $single_points_pieces = explode("_", $single_points->meta_key);
            $resultId = $single_points_pieces[1];
            //echo $resultId.'<br />';
            $trid_res = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'turneu_rezultate' AND meta_value = " . $resultId);
            $trid = $trid_res[0]->post_id;
            $trdate_res = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'turneu_date_time' AND post_id = " . $trid);
            $trdate = $trdate_res[0]->meta_value;
            $trdate_pieces = explode(" ", $trdate);
            $trday = $trdate_pieces[0];
            $trday_str = strtotime($trday);
            $from_str = strtotime($from);
            $to_str = strtotime($to);
            if ($trday_str <= $to_str && $trday_str >= $from_str) {
                $total_points = $total_points + $single_points->meta_value;
            }

            //
            //echo $trdate->meta_value.'<br />';
            //var_dump($trdate);echo "///".$tournamentId.'<br />';
        //
        }
    }
    return $total_points;
}

function is_mobile() {

    if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android')) {

        return true;
    } else {

        return false;
    }
}

function is_private_profile($user_id) {
    $private_profile = get_user_meta($user_id, 'private_profile', true);
    if ($private_profile == 'yes') {
        return true;
    } else {
        return false;
    }
}

function tournament_currency($turn_id) {
    $currency = get_post_meta($turn_id, 'turneu_currency', true);
    if ($currency == 'lei') {
        echo 'RON';
    } else {
        echo '&#128;';
    }
}

add_filter('home_url', 'qtrans_convertURL');

add_action('wp_login_failed', 'my_front_end_login_fail');  // hook failed login

function my_front_end_login_fail($username) {
    $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
    // if there's a valid referrer, and it's not the default log-in screen
    if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin')) {
        wp_redirect($referrer . '?login=failed');  // let's append some information (login=failed) to the URL for the theme to use
        exit;
    }
}

function cnp_exists($cnp) {
    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM $wpdb->usermeta WHERE meta_key = 'cnp' AND meta_value = '" . $cnp . "'");
    if (!$results) {
        return false;
    } else {
        return true;
    }
}

function getPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count . ' Views';
}

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function five_most_viewed() {
    $args = array(
        'posts_per_page' => 5,
        'meta_key' => 'post_views_count',
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'post_views_count',
                'compare' => 'LIKE',
            )
        )
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo "<a href='" . get_permalink() . "' original-title = '" . get_the_excerpt() . "' >• " . get_the_title() . "</a>";
            //echo 'aa';
        }
    }
    wp_reset_postdata();
}

function encode_id($string, $key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string, $i, 1));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }
    return $hash;
}

function decode_id($string, $key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

function your_custom_wp_title() {
    global $wp_query;
    $title = '';

    $user_id = decode_id($_GET['user'], "PokerfestClub");
    $user_info = get_userdata($user_id);
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    $this_login = $user_info->user_login;
    if ($first_name != "" || $last_name != "") {
        $title = $first_name . ' ' . $last_name . ' - PokerFest Club - Cel mai mare club de poker din Romania';
    } else {
        $title = $this_login . ' - PokerFest Club - Cel mai mare club de poker din Romania';
    }


    return $title;
}

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype($output) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}

add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info

function insert_fb_in_head() {
    global $post;

    if (!is_singular()) //if it is not a post or a page
        return;

    $user_id = decode_id($_GET['user'], "PokerfestClub");
    $user_info = get_userdata($user_id);
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    $the_profile_picture = get_user_meta($user_id, 'user_profile_picture', true);
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //echo $actual_link;
    if ($first_name != "" || $last_name != "") {
        echo '<meta property="og:title" content="' . $first_name . ' ' . $last_name . ' - PokerFest Club - Cel mai mare club de poker din Romania' . '"/>';
        echo '<meta property="og:description" content="Vezi rezultatele si statisticile jucatorului de poker ' . $first_name . ' ' . $last_name . ' la PokerFest Club Bucuresti - Cel mai mare club de poker din Romania" />';
    } else {
        echo '<meta property="og:title" content="' . $this_login . ' - PokerFest Club - Cel mai mare club de poker din Romania' . '"/>';
        echo '<meta property="og:description" content="Vezi rezultatele si statisticile jucatorului de poker ' . $user_login . ' la PokerFest Club Bucuresti - Cel mai mare club de poker din Romania" />';
    }
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . $actual_link . '"/>';
    echo '<meta property="og:site_name" content="PokerFest Club - Cel mai mare club de poker din Romania"/>';

    if ($the_profile_picture && $the_profile_picture != "") {
        echo '<meta property="og:image" content="' . esc_attr($the_profile_picture) . '"/>';
    } else {
        echo '<meta property="og:image" content="' . esc_attr(get_template_directory_uri() . '/images/user.jpg') . '"/>';
    }
    echo "
";
}

if (isset($_GET["user"]) && $_GET['user'] != "") {
    add_filter('wp_title', 'your_custom_wp_title', 100);
    add_action('wp_head', 'insert_fb_in_head', 5);
}

function SearchFilter($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}

add_filter('pre_get_posts', 'SearchFilter');

/* Add poker inserts */
add_action('init', 'add_poker_button');

function add_poker_button() {
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
        return;
    if (get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'add_poker_tinymce_plugin');
        add_filter('mce_buttons', 'register_poker_button');
    }
}

function register_poker_button($buttons) {
    array_push($buttons, "|", "pokershortcodes");
    return $buttons;
}

function add_poker_tinymce_plugin($plugin_array) {
    $plugin_array['pokershortcodes'] = get_bloginfo('template_url') . '/includes/tinymce/poker.js';
    return $plugin_array;
}

function parse_poker($text) {
    $content2 = "";
    $lignes = explode("\n", $text);
    for ($i = 0; $i < count($lignes); $i++) {
        $ligne = $lignes[$i];
        $ligne = trans_cards($ligne);
        $ligne = render_card($ligne);
        $content2.=$ligne;
    }
    return $content2;
}

function trans_cards($texte) {
    $return = $texte;
    $pos = strpos($texte, "[");
    while ($pos <> false) {
        $debut = $pos;
        $fin = strpos($texte, "]", $pos);
        $chaine = substr($texte, $debut + 1, $fin - $debut - 1);
        $chaine_ori = substr($texte, $debut, $fin - $debut + 1);
        $split = explode(" ", trim($chaine));
        $occ = "";
        for ($i = 0; $i < count($split); $i++) {
            $occ.="[" . trim($split[$i]) . "]";
        }
        $return = str_replace($chaine_ori, $occ, $return);
        $pos = strpos($texte, "[", $fin + 1);
    }

    return $return;
}

function render_card($texte) {
    $motif = '`\[([xakqjtXAKQJT2-9]|10)([xscdhXDSCH])\]`e';
    $chaine = "'<IMG SRC=\"" . get_bloginfo('template_url') . "/includes/tinymce/cards/'.(strtolower($1)).(strtolower($2)).'.gif\" alt=\"$1$2\" border=\"0\">'";
    $chain = preg_replace($motif, $chaine, $texte);
    $motif = '`\[\:([akqjtAKQJT2-9]|10)([xscdhDSCH])\]`';
    $chaine = "[$1$2]";
    $chain = preg_replace($motif, $chaine, $chain);
    return $chain;
}

add_filter('the_content', parse_poker);
add_filter('the_excerpt', parse_poker);
add_filter('comment_text', parse_poker);
?>