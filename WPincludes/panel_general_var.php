<?php
add_action('admin_menu', 'general_var_add_to_menu');

function general_var_add_to_menu() {

//create new top-level menu
    add_menu_page('Setari generale', 'Setari generale', 'administrator', __FILE__, 'general_var_settings_page');

//call register settings function
    //add_action('admin_init', 'register_notif_settings');
}

/*
  function register_notif_settings() {
  register_setting('general_settings_group', 'live_refresh_time');
  }
 */

function general_var_settings_page() {


    if (isset($_POST['submit_general_settings'])) {
        if (isset($_POST['live_refresh_time'])) {
            update_option('live_refresh_time', $_POST['live_refresh_time']);
        } 
        if (isset($_POST['live_tournament_articles'])) {
            update_option('live_tournament_articles', $_POST['live_tournament_articles']);  
        }
        if (isset($_POST['test_live_tournament_articles'])) {
            update_option('test_live_tournament_articles', $_POST['test_live_tournament_articles']);  
        }
        $success_msg = '<div class="box box2">Detaliile au fost salvate</div>';
        
//        else {
//            $error_msg = '<div class="box box3">Nu ati adaugat intervalul de refresh.</div>';
//        }
    }



    $live_refresh_time = get_option('live_refresh_time');
    if (!$live_refresh_time || $live_refresh_time == "") {
        $live_refresh_time = 5;
    }

    $live_tournament_articles = get_option('live_tournament_articles');
    $test_live_tournament_articles = get_option('test_live_tournament_articles');
    
    ?>





    <style media="all" type="text/css">
        .bigTable{width:100%;}
        .bigTable th{text-weight: bold; text-align:left; border-bottom:1px solid #ccc; line-height:40px;}
        .smallTable{width:50%;}
        .smallTable th{text-weight: bold; text-align:left; border-bottom:1px solid #ccc; line-height:40px;}
        .smallTable input{width:100%;}
        .smallTable select{width:100%;}
        .bigTable textarea{ width:100%; height:300px;}
        .notificated_users{ width:100%; float:left; height:300px; overflow: hidden;}
        .notificated_users input{ margin-right: 10px;}
        .notif_list_item{ display: block; margin-bottom: 7px; background-color: #eee; padding: 5px 5px; cursor: pointer;}
        #submit_new_notification{ float: right; cursor: pointer;}
        .notification_item{width: 100%; padding: 5px 0; background-color: #eee; margin-top: 10px;}
        .box{
            position: relative;
            overflow: hidden;
            margin: 0px 0px 18px;
            padding: 12px 12px 8px;
            border: 1px solid #e5e5e5;
            border-right: none;
            border-left: none;
        }
        .box3 { background:#ffafaf; border-color: #eba1a1  }
        .box2 { background:#daffc7; border-color: #c9ebb7 }
        .past_notifications{ max-height: 200px; overflow-x: hidden;}
        .bigTable th button{display: inline-block; float:right;}
    </style>
    <div class="wrap">
        <?php
        if ($error_msg) {
            echo $error_msg;
        }
        if ($success_msg) {
            echo $success_msg;
        }
        ?>

        <h2>Setari generale</h2>
        
        <form method="post" action="">
            <h3>Timp de refresh al articolelor live (min)</h3>
            <input type="text" name="live_refresh_time" value="<?php echo $live_refresh_time; ?>" /><br />
            <h3>Turneul pentru care vor aparea articolele live</h3>
            <?php
            //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
            echo '<select name="live_tournament_articles" >';
            echo '<option value="">Selecteaza turneul pentru articole live</option>';
            query_posts(array('post_type' => array('turnee'), 'posts_per_page' => -1));
            while (have_posts()): the_post();
                $selected = '';
                $turn_id = get_the_id();
                $turn_title = get_the_title();
                if ($live_tournament_articles == $turn_id) {
                    $selected = 'selected="selected"';
                }
                echo '<option value="' . $turn_id . '" ' . $selected . '>' . $turn_title . '</option>';
            endwhile;
            wp_reset_query();
            echo '</select>';
            ?>
            <br />
            <h3>Turneul pentru care vor aparea articolele live (PE VARIANTA DE TEST)</h3>
            <?php
            //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
            echo '<select name="test_live_tournament_articles" >';
            echo '<option value="">Selecteaza turneul pentru articole live</option>';
            query_posts(array('post_type' => array('turnee'), 'posts_per_page' => -1));
            while (have_posts()): the_post();
                $selected = '';
                $turn_id = get_the_id();
                $turn_title = get_the_title();
                if ($test_live_tournament_articles == $turn_id) {
                    $selected = 'selected="selected"';
                }
                echo '<option value="' . $turn_id . '" ' . $selected . '>' . $turn_title . '</option>';
            endwhile;
            wp_reset_query();
            echo '</select>';
            ?>
            <br />
            <input name="submit_general_settings" id="submit_general_settings" type="submit" value="Salveaza"/><br />
        </form>
    </div>
    <?php
}
?>