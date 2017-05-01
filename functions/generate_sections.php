<?php 
require DIR_WP_THEME_MANAGER."/functions/controls.php";

function wp_tmgr_generate_sections(){
    $sections = array();

    $sections = get_terms("tmgr_sections",array(
        "hide_empty" => false,
    ));

    foreach($sections as $section){
        $sections["'"+$section->slug+"'"] = array(
            "name"  => $section->name,
            "id"    => $section->slug,
            "controls"  => array()
        );

        $args = array(
            "post_type"         => "tmgr_controls",
            "posts_per_page"    => -1,
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
                
                array_push(
                    $sections["'"+$section->slug+"'"]["controls"],
                    wp_tmgr_create_control(
                        get_post_meta(get_the_ID(),"wp_tmgr_kind_of_control",true),
                        "wp-tmgr-".sanitize_title(get_the_title()),
                        get_the_title()
                    )
                );
            }
        }
    }

    return $sections;
}