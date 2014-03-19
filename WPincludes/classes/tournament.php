<?php

if (!class_exists('LCTournament')) {

    class LCTournament {

        public $id, $resultid, $name, $date, $currency;

        function __construct($resultid){
            $this->resultid = $resultid;
            $this->set_details();
        }
        function __destruct(){}

        public function set_details(){
            global $wpdb;
            $resultsp = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'turneu_rezultate' AND meta_value = ".$this->resultid);
            $this->id = $resultsp[0]->post_id;
            //$this['result'] = $resultsp[0]->meta_value;

            //$resultspt = $wpdb->get_results("SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND ID = " . $this->id);
            $this->name =get_the_title($this->id);

            $resultspm = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = " . $this->id." AND meta_key = 'turneu_date_time'");
            $this->date = $resultspm[0]->meta_value;


            $resultspmc = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = " . $this->id." AND meta_key = 'turneu_currency'");
            $this->currency = $resultspmc[0]->meta_value;
        }
    }

}

?>