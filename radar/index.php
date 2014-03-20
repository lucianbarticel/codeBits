<html>
    <head>
        <title>Football Radar</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <?php
        include("ClassBoard.php"); 
        $my_file = "09-10.csv";
        $this_board = new Board($my_file);
        $this_board->display();
        ?>
    </body>
</html>