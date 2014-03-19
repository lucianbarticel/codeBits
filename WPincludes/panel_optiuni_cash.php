<?php
add_action('admin_menu', 'cash_options_add_to_menu');

function cash_options_add_to_menu() {
    //create new top-level menu
    add_menu_page('Optiuni cash', 'Optiuni Cash', 'administrator', __FILE__, 'cash_options_page');

//call register settings function
    //add_action('admin_init', 'register_user_activity_settings');
}

function cash_options_page() {

    function add_new_cash_type() {
        $cash_types_no = get_option('cash_types_no');
        $new_cash_types_no = $cash_types_no + 1;
        update_option('cash_types_no', $new_cash_types_no);
    }

    function remove_last_cash_type() {
        $cash_types_no = get_option('cash_types_no');
        $new_cash_types_no = $cash_types_no - 1;
        update_option('cash_types_no', $new_cash_types_no);
    }

    function add_new_cash_type_bi($cash_type_no) {
        $this_cash_type_bi_no = get_option('cash_types_' . $cash_type_no . '_bi_no');
        $new_this_cash_type_bi_no = $this_cash_type_bi_no + 1;
        update_option('cash_types_' . $cash_type_no . '_bi_no', $new_this_cash_type_bi_no);
    }

    function remove_cash_type_bi($cash_type_no) {
        $this_cash_type_bi_no = get_option('cash_types_' . $cash_type_no . '_bi_no');
        $new_this_cash_type_bi_no = $this_cash_type_bi_no - 1;
        update_option('cash_types_' . $cash_type_no . '_bi_no', $new_this_cash_type_bi_no);
    }

    function save_cash_options() {
        $cash_types_no = get_option('cash_types_no');
        if ($cash_types_no && $cash_types_no != "" && $cash_types_no > 0) {
            for ($i = 1; $i <= $cash_types_no; $i++) {
                update_option('cash_type_' . $i . '_name', $_POST['cash_type_' . $i . '_name']);
                $this_cash_type_bi_no = get_option('cash_types_' . $i . '_bi_no');
                if ($this_cash_type_bi_no && $this_cash_type_bi_no != "" && $this_cash_type_bi_no > 0) {
                    for ($j = 1; $j <= $this_cash_type_bi_no; $j++) {
                        update_option('cash_type_' . $i . '_bi_' . $j . '_name', $_POST['cash_type_' . $i . '_bi_' . $j . '_name']);
                        update_option('cash_type_' . $i . '_bi_' . $j . '_min', $_POST['cash_type_' . $i . '_bi_' . $j . '_min']);
                        update_option('cash_type_' . $i . '_bi_' . $j . '_max', $_POST['cash_type_' . $i . '_bi_' . $j . '_max']);
                        update_option('cash_type_' . $i . '_bi_' . $j . '_rebuy', $_POST['cash_type_' . $i . '_bi_' . $j . '_rebuy']);
                    }
                }
            }
        }
    }

    if (isset($_POST['add_cash_type'])) {
        add_new_cash_type();
    }
    if (isset($_POST['remove_cash_type'])) {
        remove_last_cash_type();
    }
    if (isset($_POST['submit_cash_options'])) {
        save_cash_options();
    }
    $cash_types_no = get_option('cash_types_no');
    if (!$cash_types_no || $cash_types_no == "" || $cash_types_no == 0) {
        $cash_types_no = 0;
    } else {
        for ($k = 1; $k <= $cash_types_no; $k++) {
            if (isset($_POST['add_cash_type_bi_' . $k])) {
                add_new_cash_type_bi($k);
            }
            if(isset($_POST['remove_cash_type_bi_'.$k])){
                remove_cash_type_bi($k);
            }
        }
    }
    ?>    
    <div class="wrap">
        <h2>Optiuni cash</h2>
        <?php
        //$cash_types_no = get_option('cash_types_no');
        if (!$cash_types_no || $cash_types_no == "") {
            $cash_types_no = 0;
        }
        ?>
        <br/><br/>
        <form name="form_cash_options" method="POST" >
            <label for="cash_types_no">Numarul tipurilor de jocuri: </label><?php echo $cash_types_no; ?><br/>
            <input type="submit" name="add_cash_type" value="Adauga un nou tip de joc" />
            <input type="submit" name="remove_cash_type" value="Sterge ultimul tip de joc" />
            <hr/>
            <?
            if ($cash_types_no > 0) {
                for ($i = 1; $i <= $cash_types_no; $i++) {
                    $this_cash_type_name = get_option('cash_type_' . $i . '_name');
                    ?>
                    <label for="cash_type_<?php echo $i; ?>_name"><?php echo $i; ?>. Numele tipului de joc: </label><input type="text" name='cash_type_<?php echo $i; ?>_name' value="<?php echo $this_cash_type_name; ?>" /><br/>

                    <?php
                    $this_cash_type_bi_no = get_option('cash_types_' . $i . '_bi_no');
                    if (!$this_cash_type_bi_no || $this_cash_type_bi_no == "") {
                        $this_cash_type_bi_no = 0;
                    }
                    for ($j = 1; $j <= $this_cash_type_bi_no; $j++) {
                        $this_cash_type_bi_name = get_option('cash_type_' . $i . '_bi_' . $j . '_name');
                        $this_cash_type_bi_min = get_option('cash_type_' . $i . '_bi_' . $j . '_min');
                        $this_cash_type_bi_max = get_option('cash_type_' . $i . '_bi_' . $j . '_max');
                        $this_cash_type_bi_rebuy = get_option('cash_type_' . $i . '_bi_' . $j . '_rebuy');
                        ?>
                        <br />
                        <?php echo $i; ?>.<?php echo $j; ?>.  
                        <label for="cash_type_<?php echo $i; ?>_bi_<?php echo $j; ?>_name">Nume miza: </label><input type="text" name="cash_type_<?php echo $i; ?>_bi_<?php echo $j; ?>_name" value="<?php echo $this_cash_type_bi_name; ?>" />
                        <label for="cash_type_<?php echo $i; ?>_bi_<?php echo $j; ?>_min">BuyIn minim: </label><input type="text" name="cash_type_<?php echo $i; ?>_bi_<?php echo $j; ?>_min" value="<?php echo $this_cash_type_bi_min; ?>" />
                        <label for="cash_type_<?php echo $i; ?>_bi_<?php echo $j; ?>_max">BuyIn maxim: </label><input type="text" name="cash_type_<?php echo $i; ?>_bi_<?php echo $j; ?>_max" value="<?php echo $this_cash_type_bi_max; ?>" />
                        <label for="cash_type_<?php echo $i; ?>_bi_<?php echo $j; ?>_rebuy">Rebuy: </label><input type="text" name="cash_type_<?php echo $i; ?>_bi_<?php echo $j; ?>_rebuy" value="<?php echo $this_cash_type_bi_rebuy; ?>" />
                        <br />

                        <?php
                    }
                    ?><br /><input type="submit" name="add_cash_type_bi_<?php echo $i; ?>" value="Adauga o noua miza pentru acest tip de joc" /><input type="submit" name="remove_cash_type_bi_<?php echo $i; ?>" value="Sterge ultima miza pentru acest joc" /><br/><br/><hr /><br/><?php
        }
                ?><br /><input type="submit" name="submit_cash_options" value="Salveaza detaliile" /><?php
    }
            ?>
        </form>


    </div>
    <?php
}
?>
