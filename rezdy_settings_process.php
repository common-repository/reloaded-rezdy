<?php
function rzd_settings_save() {	
    global $wpdb;

    $rzd_post_name_slug = $_REQUEST['rzd_post_name_slug'];
    $rzd_post_name_slug_old = $_REQUEST['rzd_post_name_slug_old'];
    
    $rzd_post_category = $_REQUEST['rzd_post_category'];
    
    $rzd_thumbnail_width = $_REQUEST['rzd_thumbnail_width'];
    $rzd_thumbnail_height = $_REQUEST['rzd_thumbnail_height'];
    $rzd_image_width = $_REQUEST['rzd_image_width'];
    $rzd_image_height = $_REQUEST['rzd_image_height'];

    $rzd_api_link = $_REQUEST['rzd_api_link'];

    $name_post = get_option('rzd_post_name_slug');
    $name_old_post = get_option('rzd_post_name_slug_old');

    $rzd_data_old = array('option_value' => $name_post);
    $rzd_old_where = array('option_name' => 'rzd_post_name_slug_old');

    $wpdb->update($wpdb->options, $rzd_data_old, $rzd_old_where);

    $rzd_data = array('option_value' => $rzd_post_name_slug);
    $rzd_where = array('option_name' => 'rzd_post_name_slug');

    $wpdb->update($wpdb->options, $rzd_data, $rzd_where);

    $rzd_post_data = array('post_type' => $rzd_post_name_slug);
    $rzd_post_where = array('post_type' => $rzd_post_name_slug_old);

    $wpdb->update($wpdb->posts, $rzd_post_data, $rzd_post_where);

    $rzd_menu = explode('-',$rzd_post_name_slug);

    $rzd_implode = implode(' ',$rzd_menu);
    $rzd_side_menu = ucwords($rzd_implode);

    $rzd_title_name = array('post_title' => $rzd_side_menu, 'post_name' => $rzd_post_name_slug);
    $rzd_title_name_where = array('post_content' => '[rezdy-items]');

    $wpdb->update($wpdb->posts, $rzd_title_name, $rzd_title_name_where);
    
    $rzd_post_category_value = array('option_value' => $rzd_post_category);
    $rzd_post_category_where = array('option_name' => 'rzd_post_category');
    $wpdb->update($wpdb->options, $rzd_post_category_value, $rzd_post_category_where);
    
    $rzd_thumb_width_value = array('option_value' => $rzd_thumbnail_width);
    $rzd_thumb_width_where = array('option_name' => 'rzd_thumbnail_width');
    $wpdb->update($wpdb->options, $rzd_thumb_width_value, $rzd_thumb_width_where);

    $rzd_thumb_height_value = array('option_value' => $rzd_thumbnail_height);
    $rzd_thumb_height_where = array('option_name' => 'rzd_thumbnail_height');
    $wpdb->update($wpdb->options, $rzd_thumb_height_value, $rzd_thumb_height_where);

    $rzd_image_width_value = array('option_value' => $rzd_image_width);
    $rzd_image_width_where = array('option_name' => 'rzd_image_width');
    $wpdb->update($wpdb->options, $rzd_image_width_value, $rzd_image_width_where);

    $rzd_image_height_value = array('option_value' => $rzd_image_height);
    $rzd_image_height_where = array('option_name' => 'rzd_image_height');
    $wpdb->update($wpdb->options, $rzd_image_height_value, $rzd_image_height_where);

    $rzd_api_value = array('option_value' => $rzd_api_link);
    $rzd_api_where = array('option_name' => 'rzd_api_link');
    $wpdb->update($wpdb->options, $rzd_api_value, $rzd_api_where);
}
?>