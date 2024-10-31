<?php
/*
  Plugin Name: Rezdy Reloaded
  Plugin URI: http://wordpress.org/plugins/reloaded-rezdy
  Description: Elegant Rezdy integration for WordPress
  Author: EnigmaWeb
  Version: 1.0.1
  Author URI: http://enigmaplugins.com
  Text Domain: reloaded-rezdy
  Domain Path: /languages
 */

/* ++++_ Activation Hook _++++ */
function wp_rzd_hook() {
    create_rzd_items();
    flush_rewrite_rules();

    create_rezdy_tags();
    flush_rewrite_rules();

    global $wpdb;

    $rzd_pageSql = $wpdb->get_results("Select *
                                       From " . $wpdb->posts . "
                                       Where post_content like '%[rezdy-items]%'
                                       And post_type = 'page'");
    if (!$rzd_pageSql) {
        $rzd_max_page_Sql = $wpdb->get_results("SELECT Max(ID) As rzd_maxId FROM " . $wpdb->posts);
        foreach ($rzd_max_page_Sql as $rzd_max_page_row) {
            $rzd_maxId = $rzd_max_page_row->rzd_maxId;
            $rzd_maxId = $rzd_maxId + 1;
        }

        $rzd_now = date('Y-m-d H:i:s');
        $rzd_now_gmt = gmdate('Y-m-d H:i:s');
        $rzd_guid = get_option('home') . '/?page_id=' . $rzd_maxId;
        $rzd_user_id = get_current_user_id();

        $rzd_data_posts = array(
            'post_author' => $rzd_user_id,
            'post_date' => $rzd_now,
            'post_date_gmt' => $rzd_now_gmt,
            'post_content' => '[rezdy-items]',
            'post_title' => 'Rezdy Items',
            'post_excerpt' => '',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_password' => '',
            'post_name' => 'rezdy-items',
            'to_ping' => '',
            'pinged' => '',
            'post_modified' => $rzd_now,
            'post_modified_gmt' => $rzd_now_gmt,
            'post_content_filtered' => '',
            'post_parent' => '0',
            'guid' => $rzd_guid,
            'menu_order' => '0',
            'post_type' => 'page',
            'post_mime_type' => '',
            'comment_count' => '0',
        );
        $wpdb->insert($wpdb->posts, $rzd_data_posts) or die(mysql_error());

        $rzd_tempTableSql = $wpdb->get_results("Select *
                                                From " . $wpdb->posts . "
                                                Where post_content Like '%[rezdy-items]%'
                                                And post_type = 'page'");
        foreach ($rzd_tempTableSql as $rzd_tempTableRow) {
            $tempPageId = $rzd_tempTableRow->ID;

            //  Set Rezdy Reloaded page template
            add_post_meta($tempPageId, '_wp_page_template', 'rezdy-template/rezdy-items.php');
        }
    }
    
    register_setting('rzd_plugin_settings', 'rzd_plugin_activate');
    add_option('rzd_plugin_activate', 'rzd_rezdy_activated', '', 'yes');
}
register_activation_hook(__FILE__, 'wp_rzd_hook');

/* ++++_ Include Post Type _++++ */
include "includes/rezdy_items_posttype.php";

/* ++++_ Define Plugin Path _++++ */
define('WP_REZDY_URL', plugin_dir_url(__FILE__));
define('WP_REZDY_DIR', plugin_dir_path(__FILE__));

/* ++++_ Define Theme Directory _++++ */
define('RZD_THEME_URL', get_stylesheet_directory_uri());
define('RZD_THEME_DIR', get_stylesheet_directory());

function rzd_styles() {
?>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="HandheldFriendly" content="true">
<?php
    if( file_exists( RZD_THEME_DIR . '/rezdy-template/rezdy-style.css' ) ){
        $stylesheet = RZD_THEME_URL . '/rezdy-template/rezdy-style.css'; 
        wp_enqueue_style('rzd_theme_style', RZD_THEME_URL . '/rezdy-template/rezdy-style.css');
    } else {
        $stylesheet = WP_REZDY_URL . '/rezdy-template/rezdy-style.css';
        wp_enqueue_style('rzd_theme_style', WP_REZDY_URL . '/rezdy-template/rezdy-style.css');
    }
}
add_action('wp_enqueue_scripts', 'rzd_styles');

/* ++++_ Get Page Name _++++ */
global $wpdb;

$rzd_title_sql = $wpdb->get_results("Select * From " . $wpdb->posts . "
                                     Where post_type = 'page'
                                     And post_content Like '%[rezdy-items]%'
                                     And post_status = 'publish'");
foreach ($rzd_title_sql as $rzd_title_data) {
    $rzd_page_title = $rzd_title_data->post_title;

    define('RZD_PAGE_TITLE', $rzd_page_title);
}

/* ++++_ Plugin Menu _++++ */
add_action('admin_menu', 'rzd_plugin_menu');
function rzd_plugin_menu() {
    $rezdy_post_slug = 'rezdy_items';
    $rezdy_post_slug = get_option('rzd_post_name_slug');

    add_submenu_page('edit.php?post_type=' . $rezdy_post_slug, 'Settings', 'Settings', 'manage_options', 'rzd_items_settings', 'wp_rezdy_settings');

    flush_rewrite_rules();
}

/* ++++_ Include Files _++++ */
function wp_rezdy_settings() {
    require "rezdy_settings.php";
}

/* ++++_ Plugin Settings _++++ */
add_action('admin_init', 'rzd_settings');
function rzd_settings() {
    register_setting('rzd_plugin_settings', 'rzd_post_name_slug');
    register_setting('rzd_plugin_settings', 'rzd_post_name_slug_old');
    
    register_setting('rzd_plugin_settings', 'rzd_post_category');
	
    register_setting('rzd_plugin_settings', 'rzd_api_link');
    
    register_setting('rzd_plugin_settings', 'rzd_thumbnail_width');
    register_setting('rzd_plugin_settings', 'rzd_thumbnail_height');
    register_setting('rzd_plugin_settings', 'rzd_image_width');
    register_setting('rzd_plugin_settings', 'rzd_image_height');
    
    add_option('rzd_post_name_slug_old', 'rezdy-items', '', 'yes');
    add_option('rzd_post_name_slug', 'rezdy-items', '', 'yes');
    
    add_option('rzd_thumbnail_width', '224', '', 'yes');
    add_option('rzd_thumbnail_height', '335', '', 'yes');
    add_option('rzd_image_width', '300', '', 'yes');
    add_option('rzd_image_height', '498', '', 'yes');
    
    add_option('rzd_post_category', '', '', 'yes');
    
    add_option('rzd_api_link', '#', '', 'yes');
}

define('RZD_POST_NAME_SLUG', get_option('rzd_post_name_slug'));
define('RZD_POST_NAME_SLUG_OLD', get_option('rzd_post_name_slug_old'));
define('RZD_POST_CATEGORY', get_option('rzd_post_category'));
define('RZD_THUMBNAIL_WIDTH', get_option('rzd_thumbnail_width'));
define('RZD_THUMBNAIL_HEIGHT', get_option('rzd_thumbnail_height'));
define('RZD_IMAGE_WIDTH', get_option('rzd_image_width'));
define('RZD_IMAGE_HEIGHT', get_option('rzd_image_height'));
define('RZD_API_LINK', get_option('rzd_api_link'));

/* ++++_ Plugin Activate Message _++++ */

$rzd_plugin_activate = get_option('rzd_plugin_activate');

if(is_admin() && $rzd_plugin_activate === 'rzd_rezdy_activated') {
    add_filter( 'gettext',
    function( $translated_text, $untranslated_text, $domain ) {
        $old = array(
            "Plugin <strong>activated</strong>.",
            "Selected plugins <strong>activated</strong>."
        );
		
        $path = get_option('rzd_post_name_slug');

        $new = "<strong>Plugin Activated. Go to</strong>
                <a href='".site_url()."/wp-admin/edit.php?post_type=".$path."&page=rzd_items_settings'>Rezdy Reloaded Settings</a>";

        if ( in_array( $untranslated_text, $old, true ) ) {
            $translated_text = $new;
        }
        
        return $translated_text;
     }
, 99, 3 );
    delete_option('rzd_plugin_activate');
}
//

/* ++++_ Enqueue admin jquery _++++ */
add_action('admin_enqueue_scripts', 'rzd_admin_jquery');
function rzd_admin_jquery() {
    wp_enqueue_script('jquery');
}

/* ++++_ Call AJAX _++++ */
require 'rezdy_settings_process.php';

add_action('wp_ajax_rzd_settings_ajax', 'rzd_settings_save');
add_action('wp_ajax_nopriv_rzd_settings_ajax', 'rzd_settings_save');

add_action('admin_head', 'rzd_ajax_save_settings');
function rzd_ajax_save_settings() {
?>
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
            jQuery("#rzd_save_settings_btn").click(function(){
                var rzd_slug			=	encodeURIComponent(jQuery("#rzd_post_name_slug").val());
                var rzd_slug_old		=	encodeURIComponent(jQuery("#rzd_post_name_slug_old").val());
                var rzd_category		=	encodeURIComponent(jQuery("#rzd_post_category:checked").val());
                var rzd_thumbnail_width		=	encodeURIComponent(jQuery("#rzd_thumbnail_width").val());
                var rzd_thumbnail_height	=	encodeURIComponent(jQuery("#rzd_thumbnail_height").val());
                var rzd_image_width		=	encodeURIComponent(jQuery("#rzd_image_width").val());
                var rzd_image_height		=	encodeURIComponent(jQuery("#rzd_image_height").val());
                var rzd_api_link		=	encodeURIComponent(jQuery("#rzd_api_link").val());
                
                jQuery.ajax({
                        method: "POST",
                        url: ajaxurl,
                        data: 'action=rzd_settings_ajax&rzd_post_name_slug='+rzd_slug+'&rzd_post_name_slug_old='+rzd_slug_old+'&rzd_post_category='+rzd_category+'&rzd_thumbnail_width='+rzd_thumbnail_width+'&rzd_thumbnail_height='+rzd_thumbnail_height+'&rzd_image_width='+rzd_image_width+'&rzd_image_height='+rzd_image_height+'&rzd_api_link='+rzd_api_link,
                        success: function(res){
                            //alert(res);
                            jQuery("#rzd_setting_save_msg").fadeIn(500).delay(1000).fadeOut(500);
                        }
                });

                jQuery('#menu-posts-' + rzd_slug_old + ' a').attr('href', 'edit.php?post_type=' + rzd_slug);
                jQuery('#menu-posts-' + rzd_slug_old + ' ul.wp-submenu-wrap li:nth-child(2) a').attr('href', 'edit.php?post_type=' + rzd_slug);
                jQuery('#menu-posts-' + rzd_slug_old + ' ul.wp-submenu-wrap li:nth-child(3) a').attr('href', 'post-new.php?post_type=' + rzd_slug);
                jQuery('#menu-posts-' + rzd_slug_old + ' ul.wp-submenu-wrap li:nth-child(4) a').attr('href', 'edit-tags.php?taxonomy=rezdy-category&post_type=' + rzd_slug);
                jQuery('#menu-posts-' + rzd_slug_old + ' ul.wp-submenu-wrap li:nth-child(5) a').attr('href', 'edit-tags.php?taxonomy=rezdy-tags&post_type=' + rzd_slug);
                jQuery('#menu-posts-' + rzd_slug_old + ' ul.wp-submenu-wrap li:nth-child(6) a').attr('href', 'edit.php?post_type=' + rzd_slug + '&page=rzd_items_settings');
            });
        });
    </script>
<?php
}

/* ++++_ Plugin Admin Styling _++++ */
add_action('admin_head', 'rzd_admin_styling');
function rzd_admin_styling() {
    ?>
    <style type="text/css">
        #rzd_setting_save_msg{
            color:#008001;
            border:solid 2px #008001;
            padding:10px 20px 10px 20px;
            font-size: 20px;
            font-weight: bold;
            position: absolute;
            background:#F9F9F9;
            border-radius: 10px;
            margin-top:250px;
            margin-left:230px;
            display:none;
        }
        .rzd_settings_left {
            float: left;
            width: 75%;
            height: auto;
            margin-top: 20px;
        }
        .rzd_settings_left_heading {
            float: left;
            width: 100%;
            height: auto;
            padding: 16px;
            background-color: #f1f1f1;
            border: 1px solid #DFDFDF;
            background-image: -moz-linear-gradient(center top , #f9f9f9, #ececec);
            box-shadow: 0 1px 0 #ffffff inset;
            border-radius: 3px;
        }
        .rzd_settings_left_heading h3 {
            padding: 0px;
            margin: 0px;
            color: #464646;
            cursor: pointer;
            font-size: 18px;
            text-shadow: 0 1px 0 #ffffff;
        }
        .rzd_settings_left_wrap {
            float: left;
            width: 100%;
            height: auto;
            padding: 16px;
            background-color: #fff;
            border: 1px solid #DFDFDF;
            border-radius: 3px;
            margin-top: -3px;
            margin-bottom: 35px;
        }
        .rzd_settings_left_wrap input[type=text] {
            width: 100%;
            height: 28px;
            border-radius: 3px;
        }
        .rzd_settings_left_wrap input[type=button] {
            background: #2ea2cc none repeat scroll 0 0;
            border: 1px solid #0074a2;
            border-radius: 5px;
            box-shadow: 0 1px 0 rgba(120, 200, 230, 0.5) inset, 0 1px 0 rgba(0, 0, 0, 0.15);
            color: #fff;
            cursor: pointer;
            font-family: Arial;
            font-size: 13px;
            font-weight: bold;
            margin-top: 14px;
            padding: 6px 10px;
            text-decoration: none;
        }
        .rzd_settings_left_wrap input[type=button]:hover {
            background: #1e73be none repeat scroll 0 0;
            border: 1px solid #0074a2;
            border-radius: 5px;
            box-shadow: 0 1px 0 rgba(120, 200, 230, 0.5) inset, 0 1px 0 rgba(0, 0, 0, 0.15);
            color: #fff;
            cursor: pointer;
            font-family: Arial;
            font-size: 13px;
            font-weight: bold;
            margin-top: 14px;
            padding: 6px 10px;
            text-decoration: none;
        }
        .rzd_settings_right {
            float: right;
            width: 20%;
            height: auto;
            margin-top: 20px;
        }
    </style>
    <?php
}

/* ++++_ Add Image Sizes _++++ */
add_action('init', 'rzd_add_image_sizes');
function rzd_add_image_sizes() {
    add_image_size('rzd_item_list_img', RZD_THUMBNAIL_WIDTH, RZD_THUMBNAIL_HEIGHT, true);
    add_image_size('rzd_item_detail_img', RZD_IMAGE_WIDTH, RZD_IMAGE_HEIGHT, true);
}

function rzd_template_chooser($template){
    $template_path = apply_filters( 'rzd_template_path', 'rezdy-template/' );

    $find = array();
    $file = '';

    if ( is_single() && get_post_type() == RZD_POST_NAME_SLUG ) {
        $file   = 'single-' . RZD_POST_NAME_SLUG . '.php';
        $find[] = $file;
        $find[] = $template_path . $file;

    } elseif ( is_tax('rezdy-category') || is_tax('rezdy-tags') ) {
        $term = get_queried_object();

        if ( is_tax('rezdy-category') || is_tax( 'rezdy-tags' ) ) {
            $file = 'taxonomy-' . $term->taxonomy . '.php';
        } else {
            $file = 'archive.php';
        }

        $find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
        $find[] = $template_path . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
        $find[] = 'taxonomy-' . $term->taxonomy . '.php';
        $find[] = $template_path . 'taxonomy-' . $term->taxonomy . '.php';
        $find[] = $file;
        $find[] = $template_path . $file;

    } elseif ( is_post_type_archive( RZD_POST_NAME_SLUG ) || is_page( RZD_PAGE_TITLE ) ) {
        $file   = 'rezdy-items.php';
        $find[] = $file;
        $find[] = $template_path . $file;
    }

    if ( $file ) {
        $template       = locate_template( array_unique( $find ) );
        if ( ! $template ) {
            $template = trailingslashit( dirname(__FILE__) ) . 'rezdy-template/' . $file;
        }
    }

    return $template;
}
add_filter('template_include', 'rzd_template_chooser');

/* ++++_ Shortcode _++++ */
function rzd_shortcode($atts, $content = null) {
    $return_string = require 'rezdy-template/rezdy-items.php';
    wp_reset_query();
    return $return_string;
}

add_action('init', 'register_rzd_shortcode');
function register_rzd_shortcode() {
    add_shortcode('rezdy-items', 'rzd_shortcode');
}

/* ++++_ Rezdy Items Pagination _++++ */
function rzd_pagination() {
    if (get_query_var('page')) {
        $rzd_paged = get_query_var('page');
    } else {
        $rzd_paged = 1;
    }

    $rzd_path = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $rzd_permalink = get_option('permalink_structure');
    $rzd_posts_per_page = get_option('posts_per_page');
    
    $rzd_tax_slug = '';
    if(is_tax('rezdy-tags') || is_tax('rezdy-category')) {
        $rzd_tax_slug = get_queried_object()->slug;
    }
    
    if ((strpos($rzd_path, '/rezdy-category/')) || (strpos($rzd_path, '?rezdy-category'))) {
        $rzd_post_args = array(
            'post_type' => RZD_POST_NAME_SLUG,
            'posts_per_page' => $rzd_posts_per_page,
            'order' => 'DESC',
            'paged' => $rzd_paged,
            'tax_query' => array(
                array(
                    'taxonomy' => 'rezdy-category',
                    'field' => 'slug',
                    'terms' => $rzd_tax_slug
                )
            )
        );
    } elseif ((strpos($rzd_path, '/rezdy-tags/')) || (strpos($rzd_path, '?rezdy-tags'))) {
        $rzd_post_args = array(
            'post_type' => RZD_POST_NAME_SLUG,
            'posts_per_page' => $rzd_posts_per_page,
            'order' => 'DESC',
            'paged' => $rzd_paged,
            'tax_query' => array(
                array(
                    'taxonomy' => 'rezdy-tags',
                    'field' => 'slug',
                    'terms' => $rzd_tax_slug
                )
            )
        );
    } else {
        $rzd_post_args = array(
            'post_type' => RZD_POST_NAME_SLUG,
            'posts_per_page' => $rzd_posts_per_page,
            'order' => 'DESC',
            'paged' => $rzd_paged
        );
    }

    $rzd_post_qry = new WP_Query($rzd_post_args);

    $rzd_last_page = ceil($rzd_post_qry->found_posts / $rzd_posts_per_page);
    $rzd_second_last = $rzd_last_page - 1;
    $rzd_page_id = get_queried_object_id();
    
    $rzd_term_slug = '';
    if(is_tax('rezdy-category') || is_tax('rezdy-tags')) {
        $rzd_term_slug = get_queried_object()->slug;
    }

    $rzd_adjacents = 2;
    $rzd_previous_page = $rzd_paged - 1;
    $rzd_next_page = $rzd_paged + 1;

    if ($rzd_last_page > 1) {
        echo '<div class="rzd_pagination">';
        if ($rzd_paged > 1) {
            if (!empty($rzd_permalink)) {
                echo "<a href='?page=$rzd_previous_page' class='rzd_page_link_previous'>previous</a>";
            } elseif (strpos($rzd_path, "rezdy-items")) {
                echo "<a href='?rezdy-items=$rzd_term_slug&page=$rzd_previous_page' class='rzd_page_link_previous'>previous</a>";
            } elseif (strpos($rzd_path, "rezdy-tags")) {
                echo "<a href='?rezdy-tags=$rzd_tag_slug&page=$rzd_previous_page' class='rzd_page_link_previous'>previous</a>";
            } elseif (strpos($rzd_path, "rezdy-category")) {
                echo "<a href='?rezdy-category=$rzd_tax_slug&page=$rzd_previous_page' class='rzd_page_link_previous'>previous</a>";
            } else {
                echo "<a href='?page_id=$rzd_page_id&page=$rzd_previous_page' class='rzd_page_link_previous'>previous</a>";
            }
        }

        if ($rzd_last_page < 7 + ($rzd_adjacents * 2)) { //not enough pages to bother breaking it up
            for ($rzd_prod_counter = 1; $rzd_prod_counter <= $rzd_last_page; $rzd_prod_counter++) {
                if ($rzd_prod_counter == $rzd_paged) {
                    echo "<span class='rzd_page_link_disabled'>$rzd_prod_counter</span>";
                } else {
                    if (!empty($rzd_permalink)) {
                        echo "<a href='?page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                    } elseif (strpos($rzd_path, "rezdy-items")) {
                        echo "<a href='?rezdy_items=$rzd_term_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                    } elseif (strpos($rzd_path, "rezdy-tags")) {
                        echo "<a href='?rezdy-tags=$rzd_tag_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                    } elseif (strpos($rzd_path, "rezdy-category")) {
                        echo "<a href='?rezdy-category=$rzd_tax_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                    } else {
                        echo "<a href='?page_id=$rzd_page_id&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                    }
                }
            }
        } elseif ($rzd_last_page > 5 + ($rzd_adjacents * 2)) { //enough pages to hide some
            //close to beginning; only hide later pages
            if ($rzd_paged < 1 + ($rzd_adjacents * 2)) {
                for ($rzd_prod_counter = 1; $rzd_prod_counter < 3 + ($rzd_adjacents * 2); $rzd_prod_counter++) {
                    if ($rzd_prod_counter == $rzd_paged) {
                        echo "<span class='rzd_page_link_disabled'>$rzd_prod_counter</span>";
                    } else {
                        if (!empty($rzd_permalink)) {
                            echo "<a href='?page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } elseif (strpos($rzd_path, "rezdy-items")) {
                            echo "<a href='?rezdy_items=$rzd_term_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } elseif (strpos($rzd_path, "rezdy-tags")) {
                            echo "<a href='?rezdy-tags=$rzd_tag_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } elseif (strpos($rzd_path, "rezdy-category")) {
                            echo "<a href='?rezdy-category=$rzd_tax_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } else {
                            echo "<a href='?page_id=$rzd_page_id&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        }
                    }
                }
                echo "<span class='rzd_page_last_dot'>...</span>";
                if (!empty($rzd_permalink)) {
                    echo "<a href='?page=$rzd_second_last'>$rzd_second_last</a>";
                    echo "<a href='?page=$rzd_last_page'>$rzd_last_page</a>";
                } elseif (strpos($rzd_path, "rezdy-items")) {
                    echo "<a href='?rezdy_items=$rzd_term_slug&page=$rzd_second_last'>$rzd_second_last</a>";
                    echo "<a href='?rezdy_items=$rzd_term_slug&page=$rzd_last_page'>$rzd_last_page</a>";
                } elseif (strpos($rzd_path, "rezdy-tags")) {
                    echo "<a href='?rezdy-tags=$rzd_tag_slug&page=$rzd_second_last'>$rzd_second_last</a>";
                    echo "<a href='?rezdy-tags=$rzd_tag_slug&page=$rzd_last_page'>$rzd_last_page</a>";
                } elseif (strpos($rzd_path, "rezdy-category")) {
                    echo "<a href='?rezdy-category=$rzd_tax_slug&page=$rzd_second_last'>$rzd_second_last</a>";
                    echo "<a href='?rezdy-category=$rzd_tax_slug&page=$rzd_last_page'>$rzd_last_page</a>";
                } else {
                    echo "<a href='?page_id=$rzd_page_id&page=$rzd_second_last'>$rzd_second_last</a>";
                    echo "<a href='?page_id=$rzd_page_id&page=$rzd_last_page'>$rzd_last_page</a>";
                }
            } elseif ($rzd_last_page - ($rzd_adjacents * 2) > $rzd_paged && $rzd_paged > ($rzd_adjacents * 2)) {
                //in middle; hide some front and some back
                if (!empty($rzd_permalink)) {
                    echo "<a href='?page=1'>1</a>";
                    echo "<a href='?page=2'>2</a>";
                } elseif (strpos($rzd_path, "rezdy-items")) {
                    echo "<a href='?rezdy_items=$rzd_term_slug&page=1'>1</a>";
                    echo "<a href='?rezdy_items=$rzd_term_slug&page=2'>2</a>";
                } elseif (strpos($rzd_path, "rezdy-tags")) {
                    echo "<a href='?rezdy-tags=$rzd_tag_slug&page=1'>1</a>";
                    echo "<a href='?rezdy-tags=$rzd_tag_slug&page=2'>2</a>";
                } elseif (strpos($rzd_path, "rezdy-category")) {
                    echo "<a href='?rezdy-category=$rzd_tax_slug&page=1'>1</a>";
                    echo "<a href='?rezdy-category=$rzd_tax_slug&page=2'>2</a>";
                } else {
                    echo "<a href='?page_id=$rzd_page_id&page=1'>1</a>";
                    echo "<a href='?page_id=$rzd_page_id&page=2'>2</a>";
                }
                echo "<span class='rzd_page_last_dot'>...</span>";
                for ($rzd_prod_counter = $rzd_paged - $rzd_adjacents; $rzd_prod_counter <= $rzd_paged + $rzd_adjacents; $rzd_prod_counter++) {
                    if ($rzd_prod_counter == $rzd_paged) {
                        echo "<span class='rzd_page_link_disabled'>$rzd_prod_counter</span>";
                    } else {
                        if (!empty($rzd_permalink)) {
                            echo "<a href='?page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } elseif (strpos($rzd_path, "rezdy-items")) {
                            echo "<a href='?rezdy_items=$rzd_term_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } elseif (strpos($rzd_path, "rezdy-tags")) {
                            echo "<a href='?rezdy-tags=$rzd_tag_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } elseif (strpos($rzd_path, "rezdy-category")) {
                            echo "<a href='?rezdy-category=$rzd_tax_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } else {
                            echo "<a href='?page_id=$rzd_page_id&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        }
                    }
                }
                echo "<span class='rzd_page_last_dot'>...</span>";
                if (!empty($rzd_permalink)) {
                    echo "<a href='?page=$rzd_second_last'>$rzd_second_last</a>";
                    echo "<a href='?page=$rzd_last_page'>$rzd_last_page</a>";
                } elseif (strpos($rzd_path, "rezdy-items")) {
                    echo "<a href='?rezdy_items=$rzd_term_slug&page=$rzd_second_last'>$rzd_second_last</a>";
                    echo "<a href='?rezdy_items=$rzd_term_slug&page=$rzd_last_page'>$rzd_last_page</a>";
                } elseif (strpos($rzd_path, "rezdy-tags")) {
                    echo "<a href='?rezdy-tags=$rzd_tag_slug&page=$rzd_second_last'>$rzd_second_last</a>";
                    echo "<a href='?rezdy-tags=$rzd_tag_slug&page=$rzd_last_page'>$rzd_last_page</a>";
                } elseif (strpos($rzd_path, "rezdy-category")) {
                    echo "<a href='?rezdy-category=$rzd_tax_slug&page=$rzd_second_last'>$rzd_second_last</a>";
                    echo "<a href='?rezdy-category=$rzd_tax_slug&page=$rzd_last_page'>$rzd_last_page</a>";
                } else {
                    echo "<a href='?page_id=$rzd_page_id&page=$rzd_second_last'>$rzd_second_last</a>";
                    echo "<a href='?page_id=$rzd_page_id&page=$rzd_last_page'>$rzd_last_page</a>";
                }
            } else {
                //close to end; only hide early pages
                if (!empty($rzd_permalink)) {
                    echo "<a href='?page=1'>1</a>";
                    echo "<a href='?page=2'>2</a>";
                } elseif (strpos($rzd_path, "rezdy-items")) {
                    echo "<a href='?rezdy_items=$rzd_term_slug&page=1'>1</a>";
                    echo "<a href='?rezdy_items=$rzd_term_slug&page=2'>2</a>";
                } elseif (strpos($rzd_path, "rezdy-tags")) {
                    echo "<a href='?rezdy-tags=$rzd_tag_slug&page=1'>1</a>";
                    echo "<a href='?rezdy-tags=$rzd_tag_slug&page=2'>2</a>";
                } elseif (strpos($rzd_path, "rezdy-category")) {
                    echo "<a href='?rezdy-category=$rzd_tax_slug&page=1'>1</a>";
                    echo "<a href='?rezdy-category=$rzd_tax_slug&page=2'>2</a>";
                } else {
                    echo "<a href='?page_id=$rzd_page_id&page=1'>1</a>";
                    echo "<a href='?page_id=$rzd_page_id&page=2'>2</a>";
                }
                echo "<span class='rzd_page_last_dot'>...</span>";
                for ($rzd_prod_counter = $rzd_last_page - (2 + ($rzd_adjacents * 2)); $rzd_prod_counter <= $rzd_last_page; $rzd_prod_counter++) {
                    if ($rzd_prod_counter == $rzd_paged) {
                        echo "<span class='rzd_page_link_disabled'>$rzd_prod_counter</span>";
                    } else {
                        if (!empty($rzd_permalink)) {
                            echo "<a href='?page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } elseif (strpos($rzd_path, "rezdy-items")) {
                            echo "<a href='?rezdy_items=$rzd_term_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } elseif (strpos($rzd_path, "rezdy-tags")) {
                            echo "<a href='?rezdy-tags=$rzd_tag_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } elseif (strpos($rzd_path, "rezdy-category")) {
                            echo "<a href='?rezdy-category=$rzd_tax_slug&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        } else {
                            echo "<a href='?page_id=$rzd_page_id&page=$rzd_prod_counter'>$rzd_prod_counter</a>";
                        }
                    }
                }
            }
        }

        if ($rzd_paged < $rzd_prod_counter - 1) {
            if (!empty($rzd_permalink)) {
                echo "<a href='?page=$rzd_next_page' class='rzd_page_link_next'>next</a>";
            } elseif (strpos($rzd_path, "rezdy-items")) {
                echo "<a href='?rezdy_items=$rzd_term_slug&page=$rzd_next_page' class='rzd_page_link_next'>next</a>";
            } elseif (strpos($rzd_path, "rezdy-tags")) {
                echo "<a href='?rezdy-tags=$rzd_tag_slug&page=$rzd_next_page' class='rzd_page_link_next'>next</a>";
            } elseif (strpos($rzd_path, "rezdy-category")) {
                echo "<a href='?rezdy-category=$rzd_tax_slug&page=$rzd_next_page' class='rzd_page_link_next'>next</a>";
            } else {
                echo "<a href='?page_id=$rzd_page_id&page=$rzd_next_page' class='rzd_page_link_next'>next</a>";
            }
        }
        echo '</div>';
    }
}

/* ++++_ Enqueue jQuery in head for list / grid layout _++++ */
add_action('wp_head', 'rzd_head_jquery');
function rzd_head_jquery() {
?>
    <script type="text/javascript">
        jQuery(document).ready(function (e) {
            jQuery('.rzd_grid_btn').click(function () {
                jQuery('.items_body .items_grid').removeClass('items_list');
            });

            jQuery('.rzd_list_btn').click(function () {
                jQuery('.items_body .items_grid').addClass('items_list');
            });
            
            jQuery('#rzd_terms_list').change(function(){
                window.location = jQuery(this).val();
            });
        });
    </script>
<?php
}

function rzd_get_terms() {
    if(RZD_POST_CATEGORY == 'on') {
?>
        <select name="rzd_terms_list" id="rzd_terms_list">
            <option value="">Filter by Category</option>
        <?php
            $rzd_path = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            
            $rzd_path_name_split = explode('/', $rzd_path);
            $rzd_path_name_slug = $rzd_path_name_split[3];
            
            $rzd_path_default_split = explode('/', $rzd_path);
            $rzd_path_default_slug = $rzd_path_default_split[2];

            $rzd_get_terms = get_terms('rezdy-category');
            $rzd_option_permalink = get_option('permalink_structure');
            
            foreach($rzd_get_terms as $rzd_terms_data) :
                $rzd_cat_path_name = site_url().'/rezdy-category/'.$rzd_terms_data->slug;
                $rzd_cat_path_deafult = site_url().'/?rezdy-category='.$rzd_terms_data->slug;

                $rzd_selected = '';
                if(($rzd_path_name_slug == $rzd_terms_data->slug) || ($rzd_path_default_slug == '?rezdy-category='.$rzd_terms_data->slug)) {
                    $rzd_selected = 'selected';
                }
        ?>
                <option value="<?php echo ($rzd_option_permalink == '/%postname%/' ? $rzd_cat_path_name : $rzd_cat_path_deafult); ?>" <?php echo $rzd_selected; ?>>
                    <?php echo $rzd_terms_data->name; ?>
                </option>
        <?php
            endforeach;
        ?>
        </select>
<?php
    }
}

/* ++++_ For excerpt limit _++++ */
function rzd_excerpt(){
    $excerpt = get_the_excerpt();
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);

    $the_str = substr($excerpt, 0, 420).' ....';
    return $the_str;
}

/* ++++_ Rename Old Single file wth new Slug _++++ */
$rzd_post_name_slug = get_option('rzd_post_name_slug');
$name_old_post = get_option('rzd_post_name_slug_old');

$rzd_old_single_file = WP_REZDY_DIR.'/rezdy-template/single-'.$name_old_post.'.php';
$rzd_new_single_file = WP_REZDY_DIR.'/rezdy-template/single-'.$rzd_post_name_slug.'.php';
	
if(!file_exists($rzd_new_single_file)) {
    rename($rzd_old_single_file,$rzd_new_single_file);
}