<?php 
/*
 * Register section taxonomy and controls post type
 * --------------------------------------------------------------------
 */
function wp_tmgr_sections_init() {
    $sections_labels = array(
        "name"              => __("Secciones", "wp_theme_manager"),
        "singular_name"     => __("Sección", "wp_theme_manager"),
        "search_items"      => __("Buscar sección", "wp_theme_manager"),
        "all_items"         => __("Todas las secciones", "wp_theme_manager"),
        "parent_item"       => __("Sección padre", "wp_theme_manager"),
        "parent_item_colon" => __("Sección padre:", "wp_theme_manager"),
        "edit_item"         => __("Editar sección", "wp_theme_manager"),
        "update_item"       => __("Actualizar sección", "wp_theme_manager"),
        "add_new_item"      => __("Añadir nueva sección", "wp_theme_manager"),
        "new_item_name"     => __("Nombre de la nueva sección", "wp_theme_manager"),
        "menu_name"         => __("Sección", "wp_theme_manager"),
    );

    $args_sections =  array(
        "hierarchical"      => true,
        "labels"            => $sections_labels,
        "show_ui"           => true,
        "show_admin_column" => true,
        "query_var"         => true
    );

    register_taxonomy("tmgr_sections","tmgr_controls",$args_sections);


    $labels = array(
        "name"               => __("Controles", "wp_theme_manager"),
        "singular_name"      => __("Control", "wp_theme_manager"),
        "menu_name"          => __("Controles", "wp_theme_manager"),
        "name_admin_bar"     => __("Control", "wp_theme_manager"),
        "add_new"            => __("Añadir nuevo", "wp_theme_manager"),
        "add_new_item"       => __("Añadir nuevo control", "wp_theme_manager" ),
        "new_item"           => __("Nuevo control", "wp_theme_manager" ),
        "edit_item"          => __("Editar control", "wp_theme_manager" ),
        "view_item"          => __("Ver control", "wp_theme_manager" ),
        "all_items"          => __("Todos", "wp_theme_manager" ),
        "search_items"       => __("Buscar controles", "wp_theme_manager" ),
        "parent_item_colon"  => __("Control padre:", "wp_theme_manager" ),
        "not_found"          => __("No se encontraron controles.", "wp_theme_manager" ),
        "not_found_in_trash" => __("No se encontraron controle en la papelera.", "wp_theme_manager" )
    );

    $args = array(
        "labels"             => $labels,
        "description"        => __("Crear controles administrativos.", "wp_theme_manager"),
        "public"             => false,
        "publicly_queryable" => false,
        "show_ui"            => true,
        "show_in_menu"       => true,
        "query_var"          => true,
        "exclude_from_search"=> false,
        "capability_type"    => "post",
        "has_archive"        => false,
        "hierarchical"       => false,
        "menu_position"      => null,
        "supports"           => array("title")
    );

    register_post_type("tmgr_controls",$args);
}
add_action("init", "wp_tmgr_sections_init");

/*
 * Add meta boxes for tmgr_controls posttype
 * --------------------------------------------------------------------
 */
function wp_tmgr_register_meta_boxes() {
    add_meta_box( 
        "wp-tmgr-kind-of-control", 
        __("Tipo de control", "wp_theme_manager"), 
        "wp_tmgr_kind_control_display", 
        "tmgr_controls" 
    );
}

function wp_tmgr_kind_control_display($post){
    require DIR_WP_THEME_MANAGER."/admin/pages/meta-box-controls.php";
}

/*
 * Save data sengind by meta box
 * --------------------------------------------------------------------
 */
function wp_tmgr_save_meta_box($post_id){
    if(!isset($_POST["wp_tmgr_custom_box_nonce"])){
        return $post_id;
    }
    $nonce = $_POST["wp_tmgr_custom_box_nonce"];

    if(!wp_verify_nonce($nonce,"wp_tmgr_custom_box")){
        return $post_id;
    }
    if(defined("DOING_AUTOSAVE")&& DOING_AUTOSAVE){
        return $post_id;
    }

    if("tmgr_controls" == $_POST["post_type"]){
        if(!current_user_can("edit_post", $post_id)){
            return $post_id;
        }
    } 
    $mydata = sanitize_text_field($_POST["wp_tmgr_kind_of_control"]);
    update_post_meta($post_id,"wp_tmgr_kind_of_control", $mydata);

}

function wp_tmgr_load_posts(){
    add_action("add_meta_boxes", "wp_tmgr_register_meta_boxes");
    add_action("save_post","wp_tmgr_save_meta_box");
}

if(is_admin()){
    add_action("load-post.php",     "wp_tmgr_load_posts");
    add_action("load-post-new.php", "call_someClass");
}