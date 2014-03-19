<?php
add_action('admin_menu', 'notifications_add_to_menu');

function notifications_add_to_menu() {

//create new top-level menu
    add_menu_page('Administrare notificari', 'Notificari utilizatori', 'administrator', __FILE__, 'notifications_settings_page');

//call register settings function
    //add_action('admin_init', 'register_notif_settings');
}

function register_notif_settings() {
    register_setting('notif_settings_group', 'notifications_number');

    $notifications_number = get_option('notifications_number');
    $next_notification = $notifications_number + 1;
    register_setting('notif_settings_group', 'notification_' . $next_notification);
}

function notifications_settings_page() {


    if (isset($_POST['submit_new_notification'])) {
        $next_nr = $_POST['notifications_number'];
        if (isset($_POST['notificated_users']) && $_POST['notification_' . $next_nr] != "") {
            update_option('notifications_number', $_POST['notifications_number']);
            $this_notification_user_array = array();
            foreach ($_POST['notificated_users'] as $user) {
                //$user_info = get_userdata($user);
                array_push($this_notification_user_array, $user);
                //update_user_meta($user, 'user_notification_' . $next_nr, $_POST['notification_' . $next_nr]);
                //seen / not-seen
                update_user_meta($user, 'status_notification_' . $next_nr, 'not-seen');
            }
            update_option('user_list_notification_' . $next_nr, $this_notification_user_array);
            update_option('notification_' . $next_nr, $_POST['notification_' . $next_nr]);
            $success_msg = '<div class="box box2">Notificarea a fost trimisa.</div>';
        } else {
            $error_msg = '<div class="box box3">Mesajul e gol sau nu ati ales nici un utilizator.</div>';
        }
    }



    $notifications_number = get_option('notifications_number');
    if ($notifications_number) {
        $next_notification = $notifications_number + 1;
    } else {
        $next_notification = 1;
    }
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

        <h2>Trimite notificari catre utilizatori</h2>
        <h3>Notificare noua</h3>
        <form method="post" action="">
            <table class="bigTable" cellpadding="5" cellspacing="20">
                <tr>
                    <th>Mesajul de notificare</th>
                    <th>Utilizatorii notificati <button class="btn2 grey" id="select_all">Selecteaza pe toti</button></th>
                </tr>
                <tr>
                    <td class="notification_msg">
                        <textarea name="notification_<?php echo $next_notification; ?>" ></textarea>
                    </td>

                    <td class="notificated_users">
                        <?php
                        $users = get_users();
                        foreach ($users as $user) {
                            ?>
                            <div class="notif_list_item"><input type="checkbox" name="notificated_users[]" value="<?php echo $user->ID; ?>"><?php echo $user->user_login; ?></div>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="notifications_number" value="<?php echo $next_notification; ?>" />
            <input name="submit_new_notification" id="submit_new_notification" type="submit" value="Trimite"/>
        </form>
        <h3>Notificari precedente</h3>
        <table>
            <tr>

            <div class="past_notifications">
                <?php
                if ($notifications_number) {
                    for ($i = 1; $i <= $notifications_number; $i++) {
                        ?>
                        <div class="notification_item">
                            <?php echo 'Mesaj: ' . get_option('notification_' . $i); ?>
                            <span>
                                <?php
                                $users = get_option("user_list_notification_" . $i);
                                if ($users && !empty($users)) {
                                    $user_nr = count($users);
                                    echo '<br /> utilizatori: ';
                                    foreach ($users as $user) {
                                        $user_info = get_userdata($user);
                                        if ($user == end($users)) {
                                            echo $user_info->user_login;
                                        } else {
                                            echo $user_info->user_login . ', ';
                                        }
                                    }
                                    //echo ')';
                                }
                                ?>
                            </span>
                        </div>
                        <?php
                    }
                } else {
                    echo 'Nu sunt notificari precente';
                }
                ?>
            </div>
            </tr>
        </table>
    </div>
    <?php
}
?>