<?php 
require DIR_WP_THEME_MANAGER.'/functions/controls.php';

function wp_tmgr_generate_sections(){
    $sections = array();
    $sections[0]    = array(
        'name'  => __('Encabezado','wp_theme_manager'),
        'id'    => 'wp-tmgr-header',
        'controls'  => array()
    );

    array_push(
        $sections[0]['controls'],
        wp_tmgr_create_control(
            'editor',
            'wp-tmgr-logo',
            __('Logo','wp_theme_manager')
        )
    );

    return $sections;
}