<?php

add_action('init', 'create_programe_festivaluri');

function create_programe_festivaluri() {
    $labels = array(
        'name' => _x('Programe festivaluri', 'post type general name'),
        'singular_name' => _x('Program festival', 'post type singular name'),
        'add_new' => _x('Adauga Program festival', 'video'),
        'add_new_item' => __('Adauga Program festival'),
        'edit_item' => __('Editeaza Program festival'),
        'new_item' => __('Programe festivaluri noi'),
        'view_item' => __('Vezi Programe festivaluri noi'),
        'search_items' => __('Cauta Programe festivaluri'),
        'not_found' => __('Nici un Program festival gasit'),
        'not_found_in_trash' => __('Nici un Program festival gasit in trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        'menu_position' => null,
        'supports' => array('title', 'thumbnail')
            //'taxonomies' => array('post_tag')
            //'register_meta_box_cb' => 'add_festivaluri_metaboxes'
    );
    register_post_type('programe_festivaluri', $args);
    flush_rewrite_rules(false);
}

add_action('load-post.php', 'programe_festivaluri_metaboxes_setup');
add_action('load-post-new.php', 'programe_festivaluri_metaboxes_setup');

function programe_festivaluri_metaboxes_setup() {
    add_action('add_meta_boxes', 'add_programe_festivaluri_metaboxes');
    add_action('save_post', 'save_programe_festivaluri_meta_box', 10, 2);
}

function add_programe_festivaluri_metaboxes() {
    add_meta_box('detalii_program', 'Detalii program', 'add_detalii_program', 'programe_festivaluri', 'normal', 'high');
    //add_meta_box('clasament', 'Clasament', 'add_locuri_clasament', 'rezultate', 'normal', 'high');
}

function add_detalii_program($object, $box) {
    $thePostID = $object->ID;
    $zile_turneu = get_post_meta($thePostID, 'program_days_no', true);
    //if(!$zile_turneu || $zile_turneu == ""){$zile_turneu = 0; }
    //wp_nonce_field(basename(__FILE__), 'video_full_meta_nonce');
    echo '<label for="zile_turneu">Zile turneu: </label><input type="text" name="zile_turneu" id="zile_turneu_input"  value="' . $zile_turneu . '"/> <button id="submit_zile_turneu">Salveaza zile</button><br/><br/> ';
    if ($zile_turneu && $zile_turneu != "") {
        echo '<hr>';
        for ($i = 1; $i <= $zile_turneu; $i++) {
            $this_turnee_no = get_post_meta($thePostID, 'no_turnee_ziua_' . $i, true);
            echo '<label>Numar turnee ziua ' . $i . ':  </label><input type="text" name="no_turnee_ziua_' . $i . '"  value="' . $this_turnee_no . '"/><button class="submit_no_turnee_zi" id="no_turnee_ziua_' . $i . '">Salveaza numar de turnee</button><br/><br/> ';
            if ($this_turnee_no && $this_turnee_no != "") {

                for ($j = 1; $j <= $this_turnee_no; $j++) {
                    echo '<label for ="turneu_' . $j . '_ziua_' . $i . '"> Turneu_' . $j . '_ziua_' . $i . ': </label>';
                    echo '<select name="turneu_' . $j . '_ziua_' . $i . '" >';
                    echo '<option value="">Selecteaza turneu numarul ' . $j . '</option>';
                    $this_festival = get_post_meta($thePostID, 'turneu_' . $j . '_ziua_' . $i, true);
                    query_posts(array('post_type' => array('turnee'), 'posts_per_page' => -1));
                    while (have_posts()): the_post();
                        $selected = '';
                        $turn_id = get_the_id();
                        $turn_title = get_the_title();
                        if ($this_festival == $turn_id) {
                            $selected = 'selected="selected"';
                        }
                        echo '<option value="' . $turn_id . '" ' . $selected . '>' . $turn_title . '</option>';
                    endwhile;
                    wp_reset_query();
                    echo '</select>';
                    echo '<br /><br />';
                    //echo '<label>Numar turnee ziua ' . $i . ':  </label><input type="text" name="no_turnee_ziua_' . $i . '"  value="' . $this_turnee_no . '"/><button class="submit_no_turnee_zi" id="no_turnee_ziua_' . $i . '">Salveaza numar de turnee</button><br/><br/> ';
                }
                echo '<hr>';
            }
        }
    }
}

/*
  function add_locuri_clasament($object, $box) {
  $thePostID = $object->ID;
  $locuri_premiate = get_option('results_' . $thePostID . '_no');
  if ($locuri_premiate && $locuri_premiate != "") {
  for ($i = 1; $i <= $locuri_premiate; $i++) {
  $this_name = get_post_meta($thePostID, 'turneu_' . $thePostID . '_loc_' . $i, true);
  echo '<label>Ocupant pozitia ' . $i . ':  </label><input type="text" name="turneu_' . $thePostID . '_loc_' . $i . '"  value="' . $this_name . '"/><br/><br/> ';
  }
  }
  }
 */


  function save_programe_festivaluri_meta_box($post_id, $post) {
  //$locuri_premiate = get_option('results_' . $post_id . '_no');
  
  // Get the post type object.
  $post_type = get_post_type_object($post->post_type);

  // Check if the current user has permission to edit the post.
  if (!current_user_can($post_type->cap->edit_post, $post_id))
  return $post_id;

  // Get the posted data and sanitize it for use as an HTML class.
  //$new_meta_value = ( isset($_POST['the_video_preview']) ? sanitize_html_class($_POST['the_video_preview']) : '' );
  $new_meta_values = array(
  //'gallery_id' => $_POST['gallery_id']
  );
  
  
  $zile_festival = get_post_meta($post_id, 'program_days_no', true);
  if($zile_festival && $zile_festival != ""){
      for($i = 1; $i <= $zile_festival; $i++){
           $this_day_turnee_no = get_post_meta($post_id, 'no_turnee_ziua_' . $i, true);
           if($this_day_turnee_no && $this_day_turnee_no != ""){
               for($j= 1; $j <=$this_day_turnee_no; $j++){
                   $this_festival = $_POST['turneu_' . $j . '_ziua_' . $i];
                   $new_meta_values['turneu_' . $j . '_ziua_' . $i] = $this_festival;
               }
           }
      }
  }else{
      if($_POST['zile_turneu'] != ""){
          $new_meta_values['program_days_no'] = $_POST['zile_turneu'];
      }
  }
  
  /*
  if ($locuri_premiate && $locuri_premiate != "") {
  for ($i = 1; $i <= $locuri_premiate; $i++) {
  if ($_POST['turneu_' . $post_id . '_loc_' . $i] != "") {
  $new_meta_values['turneu_' . $post_id . '_loc_' . $i] = $_POST['turneu_' . $post_id . '_loc_' . $i];
  }
  }
  }
  */
  
  
  //print_r($new_meta_values);
  // Get the meta key.
  //$meta_key = 'vimeo_video_id';
  foreach ($new_meta_values as $name => $value) {
  $meta_key = $name;
  $new_meta_value = $value;
  // Get the meta value of the custom field key.
  $meta_value = get_post_meta($post_id, $meta_key, true);

  // If a new meta value was added and there was no previous value, add it.
  if ($new_meta_value && '' == $meta_value)
  add_post_meta($post_id, $meta_key, $new_meta_value, true);

  // If the new meta value does not match the old value, update it.
  elseif ($new_meta_value && $new_meta_value != $meta_value)
  update_post_meta($post_id, $meta_key, $new_meta_value);

  // If there is no new meta value but an old value exists, delete it.
  elseif ('' == $new_meta_value && $meta_value)
  delete_post_meta($post_id, $meta_key, $meta_value);
  }
  }

?>