<?php 
require DIR_WP_THEME_MANAGER."/functions/controls.php";

function wp_tmgr_generate_sections(){
    $sections   = array();
    $terms      = get_terms("tmgr_sections",array());

    foreach($terms as $section){

        $sections["'".$section->slug."'"] = array(
            "name"  => $section->name,
            "id"    => $section->slug,
            "controls"  => array()
        );

        $args = array(
            "post_type"         => "tmgr_controls",
            "posts_per_page"    => -1,
            "orderby"           => "menu_order",
            "order"             => "DESC",
            "tax_query"         => array(
                array(
                    "taxonomy" => "tmgr_sections",
                    "field"    => "slug",
                    "terms"    => $section->slug,
                ),
            ),
        );

        $controls = new WP_Query($args);
        if($controls->have_posts()){
            while($controls->have_posts()){
                $controls->the_post();
                
                $id     = get_the_ID();
                $title  = get_the_title();

                array_push(
                    $sections["'".$section->slug."'"]["controls"],
                    wp_tmgr_create_control(
                        get_post_meta($id,"wp_tmgr_kind_of_control",true),
                        "wp-tmgr-".get_post_meta($id,"wp_tmgr_logical_name",true)."-".$id,
                        $title
                    )
                );
            }
        }
    }

    return $sections;
}