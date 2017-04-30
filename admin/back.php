<?php
/*
 * Save settings data send it by ajax
 * --------------------------------------------------------------------
 */
add_action('wp_ajax_wp_tmgr_settings_save', 'wp_tmgr_settings_save');
function wp_tmgr_settings_save(){
    if(!current_user_can('manage_options')){
        _e('No tienes suficientes permisos para acceder a esta página.','wp_theme_manager');
    }
    else{
        if(!isset($_POST['wp_tmgr_settings'])){
            _e("Hay un error procesando los datos.","wp_theme_manager");
        }
        else{
            if (!wp_verify_nonce($_POST['wp_tmgr_settings'], 'save_wp_tmgr_settings')){
                _e("Hay un error procesando los datos.","wp_theme_manager");
            }
            else{
                if(count($_POST)){
                    foreach ($_POST as $key => $value) {
                        update_option($key,stripslashes($value));
                    }
                }
            }
        }
    }
    wp_die();
}