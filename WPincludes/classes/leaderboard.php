<?php
if (!class_exists('LCLeaderboard')) {

    class LCLeaderboard {

        public function display_overall() {
            ?>
            <table class="fest_sched">
                <tr>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Pozitie';
                        } else {
                            echo 'Position';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Jucator';
                        } else {
                            echo 'Player';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Puncte';
                        } else {
                            echo 'Points';
                        }
                        ?></th>
                </tr>
                <?php
                global $wpdb;
                //$users = $wpdb->get_results("SELECT m.meta_value, u.* from $wpdb->users AS u, $wpdb->usermeta AS m WHERE u.ID = m.user_id AND m.meta_key = 'pokerfest_points' ORDER BY m.meta_value ASC");
                //print_r($users);
                $my_users = array();
                $users = $wpdb->get_results("SELECT * from $wpdb->users");
                $j = 0;
                foreach ($users as $user) {
                    $id = $user->ID;
                    $display_name = $user->display_name;
                    $points = get_pokerfest_points($user->display_name);
                    $my_users[$j]['id'] = $id;
                    $my_users[$j]['name'] = $display_name;
                    $my_users[$j]['points'] = $points;
                    $j++;
                }

                function cmp($a, $b) {
                    return $a["points"] - $b["points"];
                }

                usort($my_users, "cmp");
                $length = count($my_users) - 1;
                $j = 1;
                for ($i = $length; $i >= 0; $i--) {
                    if ($my_users[$i]['points'] > 0) {
                        if (is_private_profile($my_users[$i]['id'])) {
                            $thisname = preg_replace('/[a-zA-Z0-9]/', '*', $my_users[$i]['name']);
                            if (qtrans_getLanguage() == 'ro') {
                                $tooltyptext = 'profil privat';
                            } else {
                                $tooltyptext = 'private profile';
                            }
                        } else {
                            $thisname = $my_users[$i]['name'];
                            $tooltyptext = $my_users[$i]['name'];
                        }
                        echo '<tr>';
                        echo '<td>' . $j . '</td>';
                        echo '<td><a rel="bookmark" href="http://pokerfestclub.ro/profil-utilizator/?user=' . encode_id($my_users[$i]['id'], "PokerfestClub") . '" original-title="' . $tooltyptext . '">' . $thisname . '</a></td>';
                        echo '<td>' . $my_users[$i]['points'] . '</td>';

                        echo '</tr>';

                        $j++;
                    }
                }
                ?>


            </table>

            <?php
        }

        public function display_last($number) {
            ?>

            <table class="fest_sched">
                <tr>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Pozitie';
                        } else {
                            echo 'Position';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Jucator';
                        } else {
                            echo 'Player';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Puncte';
                        } else {
                            echo 'Points';
                        }
                        ?></th>
                </tr>
                <?php
                global $wpdb;
                $users = $wpdb->get_results("SELECT * from $wpdb->users");
                //print_r($users);
                $my_users = array();
                //$users = get_users('role=subscriber');
                $j = 0;
                foreach ($users as $user) {
                    //if ($j < 10) {
                    $id = $user->ID;
                    $display_name = $user->display_name;
                    $points = get_pokerfest_points($user->display_name);
                    $my_users[$j]['id'] = $id;
                    $my_users[$j]['name'] = $display_name;
                    $my_users[$j]['points'] = $points;
                    $j++;
                    //}
                }

                function cmp($a, $b) {
                    return $a["points"] - $b["points"];
                }

                usort($my_users, "cmp");
                $length = count($my_users) - 1;
                $j = 1;
                for ($i = $length; $i >= 0; $i--) {
                    if ($j <= $number) {
                        if ($my_users[$i]['points'] > 0) {
                            if (is_private_profile($my_users[$i]['id'])) {
                                $thisname = preg_replace('/[a-zA-Z0-9]/', '*', $my_users[$i]['name']);
                                if (qtrans_getLanguage() == 'ro') {
                                    $tooltyptext = 'profil privat';
                                } else {
                                    $tooltyptext = 'private profile';
                                }
                            } else {
                                $thisname = $my_users[$i]['name'];
                                $tooltyptext = $my_users[$i]['name'];
                            }
                            echo '<tr>';
                            echo '<td>' . $j . '</td>';
                            echo '<td><a href="http://pokerfestclub.ro/profil-utilizator/?user=' . encode_id($my_users[$i]['id'], "PokerfestClub") . '" rel="bookmark" original-title="' . $tooltyptext . '" id="' . $my_users[$i]['id'] . '">' . $thisname . '</a></td>';
                            echo '<td>' . $my_users[$i]['points'] . '</td>';

                            echo '</tr>';

                            $j++;
                        }
                    }
                }
                ?>


            </table>

            <?php
        }

        public function display_periodic($from, $to) {
            ?>
            <table class="fest_sched">
                <tr>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Pozitie';
                        } else {
                            echo 'Position';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Jucator';
                        } else {
                            echo 'Player';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Puncte';
                        } else {
                            echo 'Points';
                        }
                        ?></th>
                </tr>
                <?php
                global $wpdb;
                //$users = $wpdb->get_results("SELECT m.meta_value, u.* from $wpdb->users AS u, $wpdb->usermeta AS m WHERE u.ID = m.user_id AND m.meta_key = 'pokerfest_points' ORDER BY m.meta_value ASC");
                //print_r($users);
                $my_users = array();
                $users = $wpdb->get_results("SELECT * from $wpdb->users");
                $j = 0;
                foreach ($users as $user) {
                    $id = $user->ID;
                    $display_name = $user->display_name;
                    $points = get_periodic_pokerfest_points($user->display_name, $from, $to);
                    $my_users[$j]['id'] = $id;
                    $my_users[$j]['name'] = $display_name;
                    $my_users[$j]['points'] = $points;
                    $j++;
                }

                function cmp($a, $b) {
                    return $a["points"] - $b["points"];
                }

                usort($my_users, "cmp");
                $length = count($my_users) - 1;
                $j = 1;
                for ($i = $length; $i >= 0; $i--) {
                    if ($my_users[$i]['points'] > 0) {
                        if (is_private_profile($my_users[$i]['id'])) {
                            $thisname = preg_replace('/[a-zA-Z0-9]/', '*', $my_users[$i]['name']);
                            if (qtrans_getLanguage() == 'ro') {
                                $tooltyptext = 'profil privat';
                            } else {
                                $tooltyptext = 'private profile';
                            }
                        } else {
                            $thisname = $my_users[$i]['name'];
                            $tooltyptext = $my_users[$i]['name'];
                        }
                        echo '<tr>';
                        echo '<td>' . $j . '</td>';
                        echo '<td><a rel="bookmark" href="http://pokerfestclub.ro/profil-utilizator/?user=' . encode_id($my_users[$i]['id'], "PokerfestClub") . '" original-title="' . $tooltyptext . '">' . $thisname . '</a></td>';
                        echo '<td>' . $my_users[$i]['points'] . '</td>';

                        echo '</tr>';

                        $j++;
                    }
                }
                ?>


            </table>

            <?php
        }

        public function display_periodic_last($number, $from, $to) {
            ?>

            <table class="fest_sched">
                <tr>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Pozitie';
                        } else {
                            echo 'Position';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Jucator';
                        } else {
                            echo 'Player';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Puncte';
                        } else {
                            echo 'Points';
                        }
                        ?></th>
                </tr>
                <?php
                global $wpdb;
                $users = $wpdb->get_results("SELECT * from $wpdb->users");
                //print_r($users);
                $my_users = array();
                //$users = get_users('role=subscriber');
                $j = 0;
                foreach ($users as $user) {
                    //if ($j < 10) {
                    $id = $user->ID;
                    $display_name = $user->display_name;
                    $points = get_periodic_pokerfest_points($user->display_name, $from, $to);
                    $my_users[$j]['id'] = $id;
                    $my_users[$j]['name'] = $display_name;
                    $my_users[$j]['points'] = $points;
                    $j++;
                    //}
                }

                function cmp($a, $b) {
                    return $a["points"] - $b["points"];
                }

                usort($my_users, "cmp");
                $length = count($my_users) - 1;
                $j = 1;
                for ($i = $length; $i >= 0; $i--) {
                    if ($j <= $number) {
                        if ($my_users[$i]['points'] > 0) {
                            if (is_private_profile($my_users[$i]['id'])) {
                                $thisname = preg_replace('/[a-zA-Z0-9]/', '*', $my_users[$i]['name']);
                                if (qtrans_getLanguage() == 'ro') {
                                    $tooltyptext = 'profil privat';
                                } else {
                                    $tooltyptext = 'private profile';
                                }
                            } else {
                                $thisname = $my_users[$i]['name'];
                                $tooltyptext = $my_users[$i]['name'];
                            }
                            echo '<tr>';
                            echo '<td>' . $j . '</td>';
                            echo '<td><a href="http://pokerfestclub.ro/profil-utilizator/?user=' . encode_id($my_users[$i]['id'], "PokerfestClub") . '" rel="bookmark" original-title="' . $tooltyptext . '" id="' . $my_users[$i]['id'] . '">' . $thisname . '</a></td>';
                            echo '<td>' . $my_users[$i]['points'] . '</td>';

                            echo '</tr>';

                            $j++;
                        }
                    }
                }
                ?>


            </table>

            <?php
        }

        public function get_periodic_last($number, $from, $to) {
            $content = '<table class="fest_sched">';
            $content .='<tr>';
            $content .='<th>';
            if (qtrans_getLanguage() == 'ro') {
                $content .='Pozitie';
            } else {
                $content .='Position';
            }
            $content .='</th>';

            $content .='<th>';
            if (qtrans_getLanguage() == 'ro') {
                $content .='Jucator';
            } else {
                $content .='Player';
            }
            $content .='</th>';

            $content .='<th>';
            if (qtrans_getLanguage() == 'ro') {
                $content .='Puncte';
            } else {
                $content .='Points';
            }
            $content .='</th>';


            $content .='</tr>';

            global $wpdb;
            $users = $wpdb->get_results("SELECT * from $wpdb->users");
            //print_r($users);
            $my_users = array();
            //$users = get_users('role=subscriber');
            $j = 0;
            foreach ($users as $user) {
                //if ($j < 10) {
                $id = $user->ID;
                $display_name = $user->display_name;
                $points = get_periodic_pokerfest_points($user->display_name, $from, $to);
                $my_users[$j]['id'] = $id;
                $my_users[$j]['name'] = $display_name;
                $my_users[$j]['points'] = $points;
                $j++;
                //}
            }

            function cmp($a, $b) {
                return $a["points"] - $b["points"];
            }

            usort($my_users, "cmp");
            $length = count($my_users) - 1;
            $j = 1;
            for ($i = $length; $i >= 0; $i--) {
                if ($j <= $number) {
                    if ($my_users[$i]['points'] > 0) {
                        if (is_private_profile($my_users[$i]['id'])) {
                            $thisname = preg_replace('/[a-zA-Z0-9]/', '*', $my_users[$i]['name']);
                            if (qtrans_getLanguage() == 'ro') {
                                $tooltyptext = 'profil privat';
                            } else {
                                $tooltyptext = 'private profile';
                            }
                        } else {
                            $thisname = $my_users[$i]['name'];
                            $tooltyptext = $my_users[$i]['name'];
                        }
                        $content .= '<tr>';
                        $content .= '<td>' . $j . '</td>';
                        $content .= '<td><a href="http://pokerfestclub.ro/profil-utilizator/?user=' . encode_id($my_users[$i]['id'], "PokerfestClub") . '" rel="bookmark" original-title="' . $tooltyptext . '" id="' . $my_users[$i]['id'] . '">' . $thisname . '</a></td>';
                        $content .= '<td>' . $my_users[$i]['points'] . '</td>';

                        $content .= '</tr>';

                        $j++;
                    }
                }
            }

            $content .='</table>';
            
            return $content;
        }

        public function overall_winnings_leaderboard() {
            ?>

            <table class="fest_sched">
                <tr>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Pozitie';
                        } else {
                            echo 'Position';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Jucator';
                        } else {
                            echo 'Player';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Castiguri';
                        } else {
                            echo 'Winnings';
                        }
                        ?></th>
                </tr>
                <?php
                global $wpdb;
                $users = $wpdb->get_results("SELECT * from $wpdb->users");
                //print_r($users);
                $my_users = array();
                //$users = get_users('role=subscriber');
                $j = 0;
                foreach ($users as $user) {
                    //if ($j < 10) {
                    $id = $user->ID;
                    $display_name = $user->display_name;
                    $prizes = get_overal_winnings($display_name);
                    //$my_user = new LCUser($id);
                    //var_dump($my_user);
                    //$pf_points = $my_user->leaderboard_points;
                    //echo $pf_points;
                    //$total_prizes = $my_user->total_prizes;
                    $my_users[$j]['id'] = $id;
                    $my_users[$j]['name'] = $display_name;
                    //$my_users[$j]['points'] = $points;
                    $my_users[$j]['winnings'] = $prizes;
                    $j++;
                    //}
                }

                function cmp($a, $b) {
                    return $a["winnings"] - $b["winnings"];
                }

                usort($my_users, "cmp");
                $length = count($my_users) - 1;
                $j = 1;
                for ($i = $length; $i >= 0; $i--) {
                    //if ($j <= $number) {
                    if ($my_users[$i]['winnings'] > 0) {
                        if (is_private_profile($my_users[$i]['id'])) {
                            $thisname = preg_replace('/[a-zA-Z0-9]/', '*', $my_users[$i]['name']);
                            if (qtrans_getLanguage() == 'ro') {
                                $tooltyptext = 'profil privat';
                            } else {
                                $tooltyptext = 'private profile';
                            }
                        } else {
                            $thisname = $my_users[$i]['name'];
                            $tooltyptext = $my_users[$i]['name'];
                        }
                        echo '<tr>';
                        echo '<td>' . $j . '</td>';
                        echo '<td><a href="http://pokerfestclub.ro/profil-utilizator/?user=' . encode_id($my_users[$i]['id'], "PokerfestClub") . '" rel="bookmark" original-title="' . $tooltyptext . '" id="' . $my_users[$i]['id'] . '">' . $thisname . '</a></td>';
                        echo '<td>' . $my_users[$i]['winnings'] . '</td>';

                        echo '</tr>';

                        $j++;
                    }
                    //}
                }
                ?>


            </table>

            <?php
        }

        public function periodic_winnings_leaderboard($from, $to) {
            ?>
            <table class="fest_sched">
                <tr>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Pozitie';
                        } else {
                            echo 'Position';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Jucator';
                        } else {
                            echo 'Player';
                        }
                        ?></th>
                    <th><?php
                        if (qtrans_getLanguage() == 'ro') {
                            echo 'Puncte';
                        } else {
                            echo 'Points';
                        }
                        ?></th>
                </tr>
                <?php
                global $wpdb;
                //$users = $wpdb->get_results("SELECT m.meta_value, u.* from $wpdb->users AS u, $wpdb->usermeta AS m WHERE u.ID = m.user_id AND m.meta_key = 'pokerfest_points' ORDER BY m.meta_value ASC");
                //print_r($users);
                $my_users = array();
                $users = $wpdb->get_results("SELECT * from $wpdb->users");
                $j = 0;
                foreach ($users as $user) {
                    $id = $user->ID;
                    $display_name = $user->display_name;
                    //$points = get_periodic_pokerfest_points($user->display_name, $from, $to);
                    $prizes = get_periodic_winnings($display_name, $from, $to);
                    $my_users[$j]['id'] = $id;
                    $my_users[$j]['name'] = $display_name;
                    //$my_users[$j]['points'] = $points;
                    $my_users[$j]['winnings'] = $prizes;
                    $j++;
                }

                function cmp($a, $b) {
                    return $a["winnings"] - $b["winnings"];
                }

                usort($my_users, "cmp");
                $length = count($my_users) - 1;
                $j = 1;
                for ($i = $length; $i >= 0; $i--) {
                    if ($my_users[$i]['winnings'] > 0) {
                        if (is_private_profile($my_users[$i]['id'])) {
                            $thisname = preg_replace('/[a-zA-Z0-9]/', '*', $my_users[$i]['name']);
                            if (qtrans_getLanguage() == 'ro') {
                                $tooltyptext = 'profil privat';
                            } else {
                                $tooltyptext = 'private profile';
                            }
                        } else {
                            $thisname = $my_users[$i]['name'];
                            $tooltyptext = $my_users[$i]['name'];
                        }
                        echo '<tr>';
                        echo '<td>' . $j . '</td>';
                        echo '<td><a rel="bookmark" href="http://pokerfestclub.ro/profil-utilizator/?user=' . encode_id($my_users[$i]['id'], "PokerfestClub") . '" original-title="' . $tooltyptext . '">' . $thisname . '</a></td>';
                        echo '<td>' . $my_users[$i]['winnings'] . '</td>';

                        echo '</tr>';

                        $j++;
                    }
                }
                ?>


            </table>

            <?php
        }

    }

}
?>