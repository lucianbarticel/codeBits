<?php
add_action('admin_menu', 'import_csv_add_to_menu');

function import_csv_add_to_menu() {

//create new top-level menu
    add_menu_page('Importa CSV', 'Importa CSV', 'administrator', __FILE__, 'import_csv_settings_page');

//call register settings function
    //add_action('admin_init', 'register_notif_settings');
}

function import_csv_settings_page() {
    ?>
    <div class="wrap">
        <h2>Importa CSV</h2>
        <div class="csv_form_wrap">
            <form method="post" action="" enctype="multipart/form-data">
                <input type="FILE" name="csv_file" id="csv_file"/>
                <input type="submit" name="submit_csv_file" id="submit_csv_file" value="Importa"/>
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['submit_csv_file'])) {
        global $wpdb;
        if (!function_exists('wp_handle_upload'))
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        $uploadedfile = $_FILES['csv_file'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
        $my_fields = array();
        if ($movefile) {
            $row = 1;
            if (($handle = fopen($movefile['file'], "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                    $num = count($data);
                    if ($row == 1) {
                        for ($c = 0; $c < $num; $c++) {
                            if ($data[$c] == 'lastname') {
                                $my_fields['lastname'] = $c;
                            } elseif ($data[$c] == 'firstname') {
                                $my_fields['firstname'] = $c;
                            } elseif ($data[$c] == 'address_city') {
                                $my_fields['city'] = $c;
                            } elseif ($data[$c] == 'alias') {
                                $my_fields['nickname'] = $c;
                            } elseif ($data[$c] == 'contact_mobile_phone') {
                                $my_fields['mobile_phone'] = $c;
                            } elseif ($data[$c] == 'official_identification_id') {
                                $my_fields['cnp'] = $c;
                            } elseif ($data[$c] == 'dateofbirth') {
                                $my_fields['dob'] = $c;
                            } elseif ($data[$c] == 'identity_card') {
                                $my_fields['serie_numar'] = $c;
                            } elseif ($data[$c] == 'client_id') {
                                $my_fields['client_id'] = $c;
                            }

                            //array_push($my_fields, $c); || $data[$c] == 'firstname' || $data[$c] == 'contact_email'    
                        }
                    } elseif ($row == 2) {
                        
                    } else {
                        $client_id = $data[$my_fields['client_id']];
                        $lastname = $data[$my_fields['lastname']];
                        $firstname = $data[$my_fields['firstname']];
                        $full_name = $lastname . ' ' . $firstname;
                        $cnp = $data[$my_fields['cnp']];
                        if (!cnp_exists($cnp)) {
                            //if (username_exists($client_id)) {
                               // echo 'Clientul cu id-ul  ' . $client_id . ' si numele ' . $full_name . ' exista deja in baza de date si nu a fost adaugat.';
                            //} else {
                                $nickname = $data[$my_fields['nickname']];
                                //$full_name = $lastname.' '.$firstname;
                                //$serie_nr = $data[$my_fields['serie_numar']];
                                $dob = $data[$my_fields['dob']];
                                $act_dob = date("d-m-Y", strtotime($dob));
                                $city = $data[$my_fields['city']];
                                $phone = $data[$my_fields['mobile_phone']];
                                $pass = md5(rand(10000, 100000));
                                $userdata = array(
                                    'first_name' => $firstname,
                                    'last_name' => $lastname,
                                    'nickname' => $nickname,
                                    'role' => 'subscriber',
                                    'user_login' => $client_id,
                                    'user_pass' => $pass,
                                    'display_name' => $full_name
                                );
                                $new_user = wp_insert_user($userdata);
                                add_user_meta($new_user, 'date_of_birth', $act_dob);
                                add_user_meta($new_user, 'city', $city);
                                add_user_meta($new_user, 'phone', $phone);
                                add_user_meta($new_user, 'cnp', $cnp);
                                add_user_meta($new_user, 'client_id', $client_id);
                                echo 'Clientul cu id-ul  ' . $client_id . ' si numele ' . $full_name . ' a fost adaugat in baza de date.';
                            //}
                        }else{
                            echo 'Clientul cu id-ul  ' . $client_id . ' si numele ' . $full_name . ' exista deja in baza de date si nu a fost adaugat.';
                        }
                    }
                    $row++;
                    echo '<br />';
                }
                fclose($handle);
            }
        } else {
            echo
            $error_alert = '<div class="box box3">A aparut o eroare la upload</div>';
            echo $error_alert;
        }
    }
}
?>