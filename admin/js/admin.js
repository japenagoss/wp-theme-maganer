jQuery(document).ready(function($){

    /**
     * Show and hide content for each item on menu 
     * -----------------------------------------------------------------------------
     */
    $('#wp_tmgr_container .of-nav li a').click(function(e){
        e.preventDefault();
        var element = $(this),
            id      = element.attr('href');

        $(id).show();
        $(id).siblings('.content-hide').hide();
        element.parent().addClass('current');
        element.parent().siblings('li').removeClass('current');
    });

    /**
     * Save by ajax form data
     * ----------------------------------------------------------------------------
     */
    $('#wp_tmgr_save').click(function(){
        var data =  $('#wp_tmgr_container form').serialize()+'&action=wp_tmgr_settings_save';
        $.post(ajaxurl, data, function(response) {
            alert(response);
        });
    });

    $('#wp_tmgr_container #wp_tmgr_save').mousedown(function(){
        tinyMCE.triggerSave();
    });

    /**
     * Add Color Picker to all inputs that have 'color-field' class
     * ------------------------------------------------------------------------------
     */
    $('.btr-color-field').wpColorPicker();

    /**
     * Upload any images with media popup of Wordpress
     * ------------------------------------------------------------------------------
     */
    var imageControl;

    $('#wp_tmgr_container .media_upload_button').click(function(){
        var element       = $(this),
            title         = element.parent().prev().prev().text();

        imageControl    = element.parent().prev().children('.upload');
        
        window.send_to_editor = function(html) {
            var content = $.parseHTML("<div>"+html+"</div>");
            var imgurl  = "";
            
            if($(content).find("a").length > 0){
                imgurl = $(content).find("a").children("img").attr("src");
            }
            else{
                imgurl = $(content).find("img").attr("src");
            }

            $(imageControl).val(imgurl);
            $(imageControl).parents('.fieldset').children('.screenshot').show().html('<img src="'+imgurl+'">');
            tb_remove();
        }

        tb_show(title, 'media-upload.php?type=image&amp;TB_iframe=true' );
        return false;
    });

    /**
     * Remove url of textbox for images
     * ------------------------------------------------------------------------------
     */
    $('#wp_tmgr_container .mlu_remove_button').click(function(){
        var element    = $(this);
        element.parent().next().hide().html('');
        element.parent().prev().children('.upload').val('');
    });
     
});