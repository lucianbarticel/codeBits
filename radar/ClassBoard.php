<?php

class Board {

    public $teams_profit_array;

    function __construct($file) {
        $this->teams_profit_array = array();
        $my_fields = array();
        $row = 0;
        if (($handle = fopen($file, "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                if ($row == 0) {
                    $num = count($data);

                    for ($c = 0; $c < $num; $c++) {
                        if ($data[$c] == 'HomeTeam') {
                            $my_fields['HomeTeam'] = $c;
                        } elseif ($data[$c] == 'AwayTeam') {
                            $my_fields['AwayTeam'] = $c;
                        } elseif ($data[$c] == 'FTR') {
                            $my_fields['FTR'] = $c;
                        } elseif ($data[$c] == 'B365H') {
                            $my_fields['B365H'] = $c;
                        } elseif ($data[$c] == 'B365A') {
                            $my_fields['B365A'] = $c;
                        }
                    }
                } else {
                    $home_team = $data[$my_fields['HomeTeam']];
                    $away_team = $data[$my_fields['AwayTeam']];
                    $result = $data[$my_fields['FTR']];
                    $home_win_odd = $data[$my_fields['B365H']];
                    $away_win_odd = $data[$my_fields['B365A']];
                    $this->compute_result($home_team, $away_team, $result, $home_win_odd, $away_win_odd);
                }
                $row++;
            }
            fclose($handle);
        } else {
            echo "o eroare ceva;";
        }
        arsort($this->teams_profit_array);
    }

    function compute_result($home_team, $away_team, $result, $home_win_odd, $away_win_odd) {
        switch ($result) {
            case "H":
                $this->teams_profit_array[$home_team] += 10 * $home_win_odd;
                $this->teams_profit_array[$away_team] -= 10;
                break;
            case "D":
                $this->teams_profit_array[$home_team] -= 10;
                $this->teams_profit_array[$away_team] -= 10;
                break;
            case "A":
                $this->teams_profit_array[$home_team] -= 10;
                $this->teams_profit_array[$away_team] += 10 * $away_win_odd;
                break;
        }
    }

    function display() {
        $index = 1;
        $content = "<table>";
        $content .= "<th><td>Team</td><td>Profit/Loss</td></th>";

        foreach ($this->teams_profit_array as $key => $value) {
            $content .= "<tr>";
            $content .= "<td>" . $index . "</td>";
            $content .= "<td>" . $key . "</td>";
            $content .= "<td>" . $value . "</td>";
            $content .= "</tr>";
            $index++;
        }
        $content .= "</table>";
        echo $content;
    }

}

?>