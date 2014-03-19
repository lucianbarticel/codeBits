<?php
add_action('admin_menu', 'user_activity_add_to_menu');

function user_activity_add_to_menu() {

//create new top-level menu
    add_menu_page('Activitate utilizatori', 'Activitate utilizatori', 'administrator', __FILE__, 'user_activity_page');

//call register settings function
    //add_action('admin_init', 'register_user_activity_settings');
}

function user_activity_page() {
    ?>
    <style media="all" type="text/css">
        .bigTable{width:100%;}
        .bigTable th{text-weight: bold; text-align:left; border-bottom:1px solid #ccc; line-height:40px;}
        .smallTable{width:50%;}
        .smallTable th{text-weight: bold; text-align:left; border-bottom:1px solid #ccc; line-height:40px;}
        .smallTable input{width:100%;}
        .smallTable select{width:100%;}
        .bigTable textarea{ width:100%; height:300px;}
    </style>
    <div class="wrap">
        <h2>Activitatea utilizatorilor</h2>
        <table class="bigTable" cellpadding="5" cellspacing="20">
            <tr>
                <th>Activitati: </th>
            </tr>

            <?php
            $activities_number = get_option('user_activities_number');
            for ($i = $activities_number; $i >= 1; $i--) {
                ?>
                <?php
                $activity_text = get_option('user_activity_' . $i);
                if ($activity_text != "") {
                    ?>
                    <tr>
                        <td class="activities_msg">
                            <?php echo $i . ': ' . $activity_text; ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

        </table>
    </div>
    <?php
}
?>
