<?php 
/*
 * Function for create controls
 * --------------------------------------------------------------------
 */
function wp_tmgr_create_control($type,$name,$label,$options = ""){
    $control     = '';
    $add_remove  = '';
    $name        = sanitize_title($name);
    $value       = get_option($name);

    if($type == "slide"){
        $add_remove  = '<span class="button button_add">+</span>';
        $add_remove .= '<span class="button button_remove">–</span>';
    }

    switch ($type) {
        case 'text':
            $control .= '<div class="fieldset">';
            $control .= '<label for="'.$name.'"><b>'.$label.': </b></label>';
            $control .= '<input type="text" class="regular-text" name="'.$name.'" value="'.htmlentities($value).'">';
            $control .= '</div>';
        break;
        case 'select':
            $control .= '<div class="fieldset">';
            $control .= '<label for="'.$name.'"><b>'.$label.': </b></label>';
            $control .= '<select name="'.$name.'">';

            foreach($options as $key => $val) {
                $selected = ($value == $key)?'selected':'';
                $control .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
            }
            
            $control .= '</select>';
            $control .= '</div>';
        break;
        case 'color':
            $control .= '<div class="fieldset">';
            $control .= '<label for="'.$name.'"><b>'.$label.': </b></label>';
            $control .= '<input type="text" class="regular-text btr-color-field" name="'.$name.'" value="'.$value.'">';
            $control .= '</div>';
        break;
        case 'image':
            $control .= wp_tmgr_generate_image_control($label,$name,$value,$add_remove);
        break;
        case 'slide':
            if(empty($value)){
                $control .= wp_tmgr_generate_image_control($label,$name."[]","",$add_remove);
            }
            else{
                $value = maybe_unserialize($value);
                foreach ($value as $key => $val){
                    $control .= wp_tmgr_generate_image_control($label,$name."[]",$val,$add_remove);
                }
            }
        break;
        case 'editor':
            ob_start();
            echo '<label for="'.$name.'"><b>'.$label.': </b></label>';
            
            $settings = array(
                'wpautop' => false
            );

            wp_editor($value,$name,$settings);
            $editor_contents = ob_get_clean();
            return $editor_contents;
        break;
        default:
            
        break;
    }

    return $control;
}

/*
 * Function for create images controls
 * --------------------------------------------------------------------
 */
function wp_tmgr_generate_image_control($label,$name,$value,$add_remove){
    $control .= '<div class="fieldset">';
    $control .= '<label for="'.$name.'"><b>'.$label.': </b></label>';
    $control .= '<div class="controls">';
    $control .= '<input type="text" class="upload regular-text" name="'.$name.'" value="'.$value.'">';
    $control .= $add_remove;
    $control .= '</div>';
    $control .= '<div class="upload_button_div">';
    $control .= '<span class="button media_upload_button">';
    $control .= __('Select','cip');
    $control .= '</span>';
    $control .= '<span class="button mlu_remove_button">';
    $control .= __('Remove','cip');
    $control .= '</span>';
    $control .= '</div>';

    if(!empty($value)):
        $control .= '<div class="screenshot" style="display:block;">';
        $control .= '<img src="'.$value.'">';
        $control .= '</div>';
    else:
        $control .= '<div class="screenshot">';
        $control .= '</div>';
    endif;
    $control .= '</div>';

    return $control;
}