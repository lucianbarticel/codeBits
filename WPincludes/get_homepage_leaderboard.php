<?php require( '../../../../wp-load.php' ); ?>
<?php

if (isset($_POST["method"]) && $_POST["method"] == "getHomepageLeaderboard") {
    $leaderboard = new LCLeaderboard();

    $thisLeaderboard = $leaderboard->display_periodic_last(5, "1-01-2014", "31-12-2014");
    echo $thisLeaderboard;
}else{
    echo "command not valid";
}
?>