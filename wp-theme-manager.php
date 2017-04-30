<?php
/*
Plugin Name: Wordpress Theme Manager
Plugin URI: #
Description: This is a plugin for manager differents settings in the activated theme
Version: 0.1
Author: Jhony Penagos
License: GPLv2 or later
Text Domain: wp_theme_manager
*/

/**
 * All Constants for use in the plugin
 * ------------------------------------------------------------------------
 */
define(URL_WP_THEME_MANAGER,plugins_url("/",__FILE__));
define(DIR_WP_THEME_MANAGER,plugin_dir_path(__FILE__));

/**
 * Add menu item in the administrative panel of Wordpress
 * ------------------------------------------------------------------------
 */
function wp_tmgr_admin_menu(){
    $blogname = get_option("blogname");
    add_menu_page($blogname,__("Administrador","wp_theme_manager"), 'manage_options', sanitize_title($blogname),'wp_tmgr_settings_page');
}

function wp_tmgr_settings_page(){
    if (!current_user_can("manage_options")){
        wp_die(__("No tienes suficientes permisos para acceder a esta página.","wp_theme_manager"));
    } 

    require DIR_WP_THEME_MANAGER.'/functions/generate_sections.php';
    $sections = wp_tmgr_generate_sections();
    require DIR_WP_THEME_MANAGER.'/admin/pages/settings.php';
}
add_action('admin_menu','wp_tmgr_admin_menu'); 

/*
 * Load js scripts and css files
 * --------------------------------------------------------------------
 */
function wp_tmgr_load_styles_scripts(){
    wp_enqueue_style('wp-tmgr-admin-css', URL_WP_THEME_MANAGER.'/admin/styles/admin-style.css', false);
    wp_enqueue_style('thickbox');
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_media();

    wp_enqueue_script('jquery'); 
    /*wp_enqueue_script('jquery-ui');
    wp_enqueue_script('jquery-ui-autocomplete');
    wp_enqueue_script('jquery-form');*/
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('wp-tmgr-admin-js',URL_WP_THEME_MANAGER.'/admin/js/admin.js',array('jquery','media-upload','thickbox','wp-color-picker'));
}
add_action('admin_enqueue_scripts', 'wp_tmgr_load_styles_scripts'); 

/*
 * Save the differenst theme settings in database
 * --------------------------------------------------------------------
 */
require DIR_WP_THEME_MANAGER.'/admin/back.php';