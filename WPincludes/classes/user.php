<?php

if (!class_exists('LCUser')) {

    class LCUser
    {
        public $id, $display_name, $leaderboard_points, $total_prizes;

        function __construct($id) {
            $this->id = $id;
            $user_info = get_userdata($this->id);
            $this->display_name = $user_info->display_name;
            $this->set_pokerfest_details();
        }

        function __destruct() {

        }

        public function get_results(){

        }

        public function get_itm(){
            global $wpdb;
            $i=0;
            $Lresult = array();
            $results = $wpdb->get_results("SELECT meta_key FROM $wpdb->postmeta WHERE meta_value = '" . $this->display_name . "'");
            foreach ($results as $result) {

                $ex_rest = explode("_", $result->meta_key);
                $turn_id = $ex_rest[1];
                $Lresult[$i]['turn_id'] = $turn_id;
                $position = $ex_rest[3];
                $Lresult[$i]['position'] = $position;
            //    //echo $result->meta_key.'_points';
             $points = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '" . $result->meta_key . "_points'");
                foreach ($points as $single_points) {
                    $Lresult[$i]['points'] = $single_points->meta_value;
                }
             $prize = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '" . $result->meta_key . "_prize'");
                foreach($prize as $single_prize){
                    $Lresult[$i]['prize'] = $single_prize->meta_value;
             }
                $i++;
            }
            //print_r($Lresult);
            return $Lresult;

        }

        private function set_pokerfest_details() {
            $total_points = 0;
            $total_prizes = 0;
            global $wpdb;
            $results = $wpdb->get_results("SELECT meta_key FROM $wpdb->postmeta WHERE meta_value = '" . $this->display_name . "'");
            foreach ($results as $result) {
                //echo $result->meta_key.'_points';
                $points = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '" . $result->meta_key . "_points'");

                foreach ($points as $single_points) {
                    //echo $single_points->meta_value;
                    $total_points = $total_points + $single_points->meta_value;
                }

                $prize = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '" . $result->meta_key . "_prize'");
                foreach($prize as $single_prize){
                    $total_prizes = $total_prizes + $single_prize->meta_value;
                }
            }
            $this->leaderboard_points = $total_points;
            $this->total_prizes = $total_prizes;
        }

    }
}

?>