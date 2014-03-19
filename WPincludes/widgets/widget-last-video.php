<?php
/**

 * Plugin Name: Lucian last video widget

 */
add_action('widgets_init', 'last_video');

function last_video() {

    register_widget('last_video');
}

class last_video extends WP_Widget {

/**

 * Widget setup.

 */
function last_video() {

    /* Widget settings. */

    $widget_ops = array('classname' => 'last_video', 'description' => __('Afiseaza ultimul video adaugat.', 'lioit'));



    /* Widget control settings. */

    $control_ops = array('width' => 250, 'height' => 350, 'id_base' => 'last_video');



    /* Create the widget. */

    $this->WP_Widget('last_video', __('( L ) Ultimul video adaugat', 'lioit'), $widget_ops, $control_ops);
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
        <h2><a href="<?php echo get_category_link($categories); ?>"><?php echo $title; ?></a></h2>
        <ul class="LioCatPosts">
            <?php
            $queried_turnee = array();
            $args = array('post_type' => 'videos', 'posts_per_page' => 1);
            query_posts($args);
            if (have_posts()) : while (have_posts()): the_post();
                $vid_id = get_the_id();
                $video_type= get_post_meta($vid_id, 'lioit_video_type', true);
                $video_id = get_post_meta($vid_id, 'lioit_video_id', true);
            ?>
            <li>
                <?php echo do_shortcode('[video width="300" height="225" id="'.$video_id.'" type="'.$video_type.'"]'); ?>
            </li>
            <?php

            endwhile;
            endif;
            wp_reset_query(); ?>

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
