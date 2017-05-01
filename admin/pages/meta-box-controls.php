<?php 
wp_nonce_field("wp_tmgr_custom_box", "wp_tmgr_custom_box_nonce");
$control = get_post_meta($post->ID,"wp_tmgr_kind_of_control",true);
?>


<label for="wp_tmgr_kind_of_control"><?php _e("Tipo de control", "wp_theme_manager");?></label>
<select name="wp_tmgr_kind_of_control">   
    <option value="text"   <?php echo ($control == "text")? "selected":"";?>><?php _e("Texto", "wp_theme_manager");?></option>
    <option value="color"  <?php echo ($control == "color")? "selected":"";?>><?php _e("Color", "wp_theme_manager");?></option>
    <option value="image"  <?php echo ($control == "image")? "selected":"";?>><?php _e("Imagen", "wp_theme_manager");?></option>
    <option value="editor" <?php echo ($control == "editor")? "selected":"";?>><?php _e("Editor", "wp_theme_manager");?></option>
</select>