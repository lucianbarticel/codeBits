<?php
//user profile meta fields
add_action('show_user_profile', 'my_show_extra_profile_fields');
add_action('edit_user_profile', 'my_show_extra_profile_fields');

function my_show_extra_profile_fields($user) {
    $cnp = esc_attr(get_the_author_meta('cnp', $user->ID));
    global $wpdb;
    $results_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->usermeta WHERE meta_key = 'cnp' AND meta_value = '" . $cnp . "'");
    if ($results_count > 1) {
        echo 'duplicate user!!';
        $result_id = $wpdb->get_results("SELECT user_id FROM $wpdb->usermeta WHERE user_id != " . $user->ID . " AND meta_key = 'cnp' AND meta_value = '" . $cnp . "'");
        echo $result_id[0]->user_id;
        ///// delete the casino user here!!!////
    } else {
        echo "cool";
    }

    $prenume = $user->first_name;
    $nume = $user->last_name;
    $nume_complet = $prenume . ' ' . $nume;
    $pf_points = esc_attr(get_pokerfest_points($user->display_name));
    $active_user = get_user_meta($user->ID, 'active', true);
    $paper_id = get_user_meta($user->ID, 'paper_id', true);

    $dob = esc_attr(get_the_author_meta('date_of_birth', $user->ID));
    $phone = esc_attr(get_the_author_meta('phone', $user->ID));
    $ocupation = esc_attr(get_the_author_meta('ocup', $user->ID));
    $address = esc_attr(get_the_author_meta('address', $user->ID));
    $city = esc_attr(get_the_author_meta('city', $user->ID));
    $country = esc_attr(get_the_author_meta('country', $user->ID));
    $private_profile = get_user_meta($user->ID, 'private_profile', true);
    $the_profile_picture = get_user_meta($user->ID, 'user_profile_picture', true);




//le_scripts();
    ?>
    <h3>Detalii suplimentare</h3>
    <table class="form-table">
        <tr>
            <th>Poza de profil:</th>
            <td>
                <?php if ($the_profile_picture && $the_profile_picture != "") {
                    echo '<img src="' . $the_profile_picture . '" alt="fotografia de profil" class="the_profile_picture" style="width:300px; height: auto;"/>';
                } else {
                    echo '<img src="' . get_template_directory_uri() . '/images/user.jpg" alt="fotografia de profil" class="the_profile_picture"/>';
                } ?></td>
        </tr>
        <tr>
            <th><label for="pokerfest_points">Puncte pokerfest: </label></th>
            <td><input type="text" name="pokerfest_points" value="<?php echo $pf_points; ?>"/></td>
        </tr>
        <tr>
            <th><label for="country">Utilizator activ: </label></th>
            <td>
                <select name="active_user" class="active_user">
                    <option value="no">No</option>
                    <option value="yes" <?php
                if ($active_user == 'yes') {
                    echo 'selected="selected"';
                };
                ?> >Yes
                    </option>
                </select>
            </td>
        </tr>
    <?php
    if ($paper_id) {
        ?>

            <tr>
                <th>Act de identitate:</th>
                <td>
                    <a href="<?php echo $paper_id; ?>"><img src="<?php echo $paper_id; ?>" alt="act de identitate"
                                                            style="width:300px; height: auto;"/></a>
                </td>
            </tr>
        <?php
    }
    ?>
        <tr>
            <th>Pagina de profil</th>
            <td>
                <a href='http://pokerfestclub.ro/profil-utilizator/?user=<?php echo encode_id($user->ID, "PokerfestClub"); ?>'><strong><?php echo 'http://pokerfestclub.ro/profil-utilizator/?user=' . encode_id($user->ID, "PokerfestClub"); ?></strong></a>
            </td>
        </tr>
        <tr>
            <th><label for="pokerfest_points">CNP: </label></th>
            <td><input type="text" name="cnp" value="<?php echo $cnp; ?>"/></td>
        </tr>
        <tr>
            <th><label for="dob">Data nasterii: </label></th>
            <td><input type="text" name="date_of_birth" id="datepicker" value="<?php echo $dob; ?>"/></td>
        </tr>
        <tr>
            <th><label for="phone">Numar de telefon: </label></th>
            <td><input type="text" name="phone" value="<?php echo $phone; ?>"/></td>
        </tr>
        <tr>
            <th><label for="ocup">Ocupatie: </label></th>
            <td><input type="text" name="ocup" value="<?php echo $ocupation; ?>"/></td>
        </tr>
        <tr>
            <th><label for="address">Adresa: </label></th>
            <td><input type="text" name="address" value="<?php echo $address; ?>"/></td>
        </tr>
        <tr>
            <th><label for="city">Oras: </label></th>
            <td><input type="text" name="city" value="<?php echo $city; ?>"/></td>
        </tr>
        <tr>
            <th><label for="country">Tara: </label></th>
            <td><input type="text" name="country" value="<?php echo $country; ?>"/></td>
        </tr>
        <tr>
            <th><label for="private_profile">Profil privat: </label></th>
            <td>
                <select name="private_profile" class="active_user">
                    <option value="no">No</option>
                    <option value="yes" <?php
    if ($private_profile == 'yes') {
        echo 'selected="selected"';
    };
    ?> >Yes
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <th>
                <label for="send_details_here">Trimite detaliile utilizatorului la adresa: </label>
            </th>
            <th>
                <input name="send_details_here" type="email"/>
                <input type="submit" value="Trimite" name="send_details_to_email" class="button button-primary"/>

            </th>
        </tr>

    </table>
    <?php
}

add_action('personal_options_update', 'my_save_extra_profile_fields');
add_action('edit_user_profile_update', 'my_save_extra_profile_fields');

function my_save_extra_profile_fields($user_id) {


    if (isset($_POST['send_details_to_email'])) {
        $user_info = get_userdata($user_id);
        $prenume = $user_info->first_name;
        $nume = $user_info->last_name;
        $nume_complet = $prenume . ' ' . $nume;
        $pf_points = esc_attr(get_pokerfest_points($user_info->display_name));
        $cnp = esc_attr(get_the_author_meta('cnp', $user_id));
        $dob = esc_attr(get_the_author_meta('date_of_birth', $user_id));
        $phone = esc_attr(get_the_author_meta('phone', $user_id));
        $ocupation = esc_attr(get_the_author_meta('ocup', $user_id));
        $address = esc_attr(get_the_author_meta('address', $user_id));
        $city = esc_attr(get_the_author_meta('city', $user_id));
        $paper_id = get_the_author_meta('paper_id', $user_id);
        $country = esc_attr(get_the_author_meta('country', $user_id));

        if (isset($_POST['send_details_here'])) {

            $headers = 'From: pokerFestClub.ro' . "\r\n" .
                    'Reply-To: webmaster@pokerFestClub.ro' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            $send_here = $_POST['send_details_here'];

            ob_start();
            ?>
            Nume: <?php echo $nume; ?>

            Prenume: <?php echo $prenume; ?>

            Puncte pokerfest: <?php echo $pf_points; ?>

            CNP: <?php echo $cnp; ?>

            Data nasterii: <?php echo $dob; ?>

            Numar de telefon: <?php echo $phone; ?>

            Ocupatie: <?php echo $ocupation; ?>

            Adresa: <?php echo $address; ?>

            Oras: <?php echo $city; ?>

            Tara: <?php echo $country; ?>
            <?php
            $mail_content = ob_get_contents();
            ob_end_clean();
            if ($paper_id && $paper_id != "") {
                wp_mail($send_here, 'Detalii utilizator ' . $nume_complet . ' - PokerFunClub.ro', $mail_content, $headers, $paper_id);
            } else {
                wp_mail($send_here, 'Detalii utilizator ' . $nume_complet . ' - PokerFunClub.ro', $mail_content, $headers);
            }
        }
    }



    if (!current_user_can('edit_user', $user_id))
        return false;

    update_usermeta($user_id, 'date_of_birth', $_POST['date_of_birth']);
    update_usermeta($user_id, 'pokerfest_points', $_POST['pokerfest_points']);
    update_usermeta($user_id, 'phone', $_POST['phone']);
    update_usermeta($user_id, 'ocup', $_POST['ocup']);
    update_usermeta($user_id, 'address', $_POST['address']);
    update_usermeta($user_id, 'city', $_POST['city']);
    update_usermeta($user_id, 'country', $_POST['country']);
    update_usermeta($user_id, 'cnp', $_POST['cnp']);
    update_usermeta($user_id, 'active', $_POST['active_user']);
    update_usermeta($user_id, 'private_profile', $_POST['private_profile']);
}
?>
