<?php
/**
 * Plugin Name: ShoutMix Chat

 */
add_action('widgets_init', 'chat_shoutmix');

function chat_shoutmix() {

    register_widget('chat_shoutmix');
}

class chat_shoutmix extends WP_Widget {

    /**
     * Widget setup.

     */
    function chat_shoutmix() {

        /* Widget settings. */

        $widget_ops = array('classname' => 'chat_shoutmix', 'description' => __('Chat ShoutMix.', 'lioit'));


        /* Widget control settings. */

        $control_ops = array('width' => 250, 'height' => 350, 'id_base' => 'next_2');


        /* Create the widget. */

        $this->WP_Widget('next_2', __('( Luc ) chat_shoutmix', 'lioit'), $widget_ops, $control_ops);
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

        <!-- Begin ShoutMix -->
        <iframe id="shoutmix_3fb157" src="http://sht.mx/3fb157" width="300" height="480" frameborder="0" scrolling="auto">
        <a href="http://sht.mx/3fb157">ShoutMix Live Chat</a>
        </iframe>
        <!-- End ShoutMix -->

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
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
                   value="<?php echo $instance['title']; ?>" style="width:90%;"/>
        </p>

                <?php
            }

        }
        ?>
