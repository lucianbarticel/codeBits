<?php require( '../../../../wp-load.php' ); ?>
<?php
if(isset($_POST["lastPost"])){$last_post = $_POST["lastPost"];}

$live_tournament = $_POST["tournament"];
$method = $_POST["method"];


if ($method == "getNextPosts") {
    $offset = $_POST["offset"];
    $nr_of_posts = 0;
    query_posts(array("posts_per_page" => 10, "post_type" => "articole_live", 'meta_query' => array(array('key' => 'tournament_to_assign', 'value' => $live_tournament)), "offset" =>$offset));
    $content = '';
    ob_start();
    if (have_posts()) : while (have_posts()) : the_post('');
            $this_id = get_the_ID();

                ?>
                <div class="liveArticle article mainBorder" id="<?php echo $this_id; ?>">
                    <div class="articleDetails">
                        <div class="articleTitle">
                            <h1><div class="<?php echo $type_badge; ?> articleType"></div><?php the_title(); ?></h1>
                        </div><!--End articleTitle-->
                    </div>
                    <div class="articleContent">
                        <p><?php the_content() ?>
                        </p>
                    </div>
                    <div class="articleBtm">
                        <?php require Lioit_TM . '/share.php'; ?>
                    </div><!--End Article Bottom-->
                </div>
                <?php
                $nr_of_posts ++;
        endwhile;
    endif;
    $content = ob_get_contents();
    ob_end_clean();
    $postOffset = $offset + $nr_of_posts;
    $response = array("nr_of_posts"=>$nr_of_posts, "content" => $content, "postOffset" =>$postOffset);
    echo json_encode($response);
} else {
    query_posts(array("posts_per_page" => 10, "post_type" => "articole_live", 'meta_query' => array(array('key' => 'tournament_to_assign', 'value' => $live_tournament))));
    $content = '';
    ob_start();
    if (have_posts()) : while (have_posts()) : the_post('');
            $this_id = get_the_ID();
            if ($this_id > $last_post) {
                ?>
                <div class="liveArticle article mainBorder" id="<?php echo $this_id; ?>">
                    <div class="articleDetails">
                        <div class="articleTitle">
                            <h1><div class="<?php echo $type_badge; ?> articleType"></div><?php the_title(); ?></h1>
                        </div><!--End articleTitle-->
                    </div>
                    <div class="articleContent">
                        <p><?php the_content() ?>
                        </p>
                    </div>
                    <div class="articleBtm">
                        <?php require Lioit_TM . '/share.php'; ?>
                    </div><!--End Article Bottom-->
                </div>
                <?php
            }
        endwhile;
    endif;
    $content = ob_get_contents();
    ob_end_clean();
    echo $content;
//die(json_encode(""));
}
?>