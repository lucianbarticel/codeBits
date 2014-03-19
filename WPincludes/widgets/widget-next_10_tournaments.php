<?php
/**

 * Plugin Name: Homepage Two-Column Widget

 */
add_action('widgets_init', 'next_10');

function next_10() {

    register_widget('next_10');
}

class next_10 extends WP_Widget {

    /**

     * Widget setup.

     */
    function next_10() {

        /* Widget settings. */

        $widget_ops = array('classname' => 'next_10', 'description' => __('Afiseaza urmatoarele 10 turnee.', 'lioit'));



        /* Widget control settings. */

        $control_ops = array('width' => 250, 'height' => 350, 'id_base' => 'next_10');



        /* Create the widget. */

        $this->WP_Widget('next_10', __('( L ) Urmatoarele 10 turnee', 'lioit'), $widget_ops, $control_ops);
    }

    /**

     * How to display the widget on the screen.

     */
    function widget($args, $instance) {

        extract($args);



        /* Our variables from the widget settings. */

        $title = apply_filters('widget_title', $instance['title']);

        //$categories = $instance['categories'];




        echo $before_widget;
        
        
        ?>

        <div class="lioLatestPosts mainCatWidget">
            <div class="LioLatestCat">
                <h2>
                    <!--<a href="<?php //echo get_category_link($categories); ?>"><?php// echo $title; ?></a>-->
                    <?php
                    if (qtrans_getLanguage() == 'ro') {
                        if (isset($_SESSION["selected_club"])) {
                            echo 'Urmatoarele 10 turnee - ' . $_SESSION["selected_club"] . ':';
                        } ELSE {
                            echo 'Urmatoarele 10 turnee - Marriott:';
                        }
                    } else {
                        if (isset($_SESSION["selected_club"])) {
                            echo 'Next 10 tournaments - ' . $_SESSION["selected_club"] . ':';
                        } ELSE {
                            echo 'Next 10 tournaments - Marriott:';
                        }
                    }
                    ?>
                </h2>
                <ul class="LioCatPosts">
                    <?php
                    $queried_turnee = array();
                    if (isset($_SESSION["selected_club"])) {
                        $args = array('post_type' => 'turnee', 'posts_per_page' => -1, 'meta_query' => array(array('key' => 'tournament_club','value' => $_SESSION["selected_club"])));
                    }else{
                        $args = array('post_type' => 'turnee', 'posts_per_page' => -1, 'meta_query' => array(array('key' => 'tournament_club','value' => 'marriott')));
                    }
//                    $args = array('post_type' => 'turnee', 'posts_per_page' => -1);
                    query_posts($args);
                    if (have_posts()) : while (have_posts()): the_post();
                            $turn_id = get_the_id();
                            $act_date_time = strtotime(get_post_meta($turn_id, 'turneu_date_time', true));
                            $now = strtotime(date('j-m-Y'));
                            if ($act_date_time > $now) {

                                array_unshift($queried_turnee, $turn_id);
                            }

                        endwhile;
                    endif;
                    wp_reset_query();

                    function cmpsc($a, $b) {
                        $date_time1 = strtotime(get_post_meta($a, 'turneu_date_time', true));
                        $date_time2 = strtotime(get_post_meta($b, 'turneu_date_time', true));
                        return $date_time1 - $date_time2;
                    }

                    usort($queried_turnee, "cmpsc");
                    $i = 0;
                    foreach ($queried_turnee as $turneu):
                        if ($i < 10) {
                            $turn_id = $turneu;
                            $date_time = get_post_meta($turn_id, 'turneu_date_time', true);
                            $date_time = date("l d-m-Y H:i", strtotime($date_time));
                            $buy_in = get_post_meta($turn_id, 'turneu_buy_in', true);
                            if ($buy_in == "" || !$buy_in) {
                                $buy_in = 0;
                            }
                            $bounty = get_post_meta($turn_id, 'turneu_bounty', true);
                            if ($bounty == "" || !$bounty) {
                                $bounty = 0;
                            }
                            $fee = get_post_meta($turn_id, 'turneu_fee', true);
                            if ($fee == "" || !$fee) {
                                $fee = 0;
                            }
                            ?>
                            <li> 
                                <h5>
                                    <a href="<?php echo get_permalink($turn_id); ?>" class="lioCatPostTitle">
                                        <div class="articleType"></div><?php echo get_the_title($turn_id); ?>
                                    </a>
                                </h5>
                                <div class="wid_tr_date">Data si ora : <span><?php echo $date_time; ?></span></div>
                                <div class="wid_tr_buy_in">Buy In : <span><?php
                echo $buy_in;
                if ($bounty > 0) {
                    echo ' + ' . $bounty;
                } if ($fee > 0) {
                    echo ' + ' . $fee;
                }
                            ?> <?php tournament_currency($turn_id); ?></span></div>
                            </li>
                        <?php } $i++; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php
            echo $after_widget;

            /* After widget (defined by themes). */
        }

        /**

         * Update the widget settings.

         */
        function update($new_instance, $old_instance) {

            $instance = $old_instance;



            /* Strip tags for title and name to remove HTML (important for text inputs). */

            $instance['title'] = strip_tags($new_instance['title']);

            //$instance['categories'] = $new_instance['categories'];





            return $instance;
        }

        function form($instance) {



            /* Set up some default widget settings. */
            ?>

            <!-- Widget Title: Text Input -->

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">
                    <?php _e('Title:', 'lioit'); ?>
                </label>
                <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
            </p>

            <?php
        }

    }
    ?>
