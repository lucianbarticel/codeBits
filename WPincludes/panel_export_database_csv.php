<?php
add_action('admin_menu', 'export_csv_add_to_menu');

function export_csv_add_to_menu() {

//create new top-level menu
    add_menu_page('Exporta CSV', 'Exporta CSV', 'administrator', __FILE__, 'export_csv_settings_page');

//call register settings function
    //add_action('admin_init', 'register_notif_settings');
}

function export_csv_settings_page() {
    ?>
    <div class="wrap">
        <h2>Exporta CSV</h2>
        <div class="csv_form_wrap">
            <form method="post" action="" enctype="multipart/form-data">
                <input type="submit" name="get_csv_file" id="get_csv_file" value="Exporta" />
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['get_csv_file'])) {
        ob_end_clean();
        $filename = 'pokerfest_db.csv';
        $header = array(
            array(
                //'ID',
                'Username',
                'Email',
                'Nume',
                'Prenume',
                'Data nasterii',
                'Numar de telefon',
                'Adresa',
                'Oras',
                'Tara',
                'Imagine de profil',
                'Act de identitate'
            )
        );
        
        $to_csv = array(
            //array(), // this array is going to be the first row
        );

        $users = get_users();
        foreach ($users as $user) {
            $id = $user->ID;
            $username = $user->user_login;
            $email = $user->user_email;
            $name = get_user_meta($id, 'last_name', true);
            $first_name = get_user_meta($id, 'first_name', true);
            $d_o_b = get_user_meta($id, 'date_of_birth', true);
            $phone_no = get_user_meta($id, 'phone', true);
            $address = get_user_meta($id, 'address', true);
            $city = get_user_meta($id, 'city', true);
            $country = get_user_meta($id, 'country', true);
            $profile_image = get_user_meta($id, 'user_profile_picture', true);
            $id_paper = get_user_meta($id, 'paper_id', true);
            $details = array(
                array(
                    $username, $email, $name, $first_name, $d_o_b, $phone_no, $address, $city, $country, $profile_image, $id_paper
                )
            );
            $to_csv = array_merge((array) $to_csv, (array)$details );
            
        }

        
        $result = array_merge((array) $header, (array) $to_csv);
        // tell the browser it's going to be a csv file
        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachement; filename="' . $filename . '"');
        $fp = fopen("php://output", 'w');

        foreach ($result as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        die();
    }
}
?>
