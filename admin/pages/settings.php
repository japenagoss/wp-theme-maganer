<section id='wp_tmgr_container'>
    <form method="post" action="options.php">
 
        <?php wp_nonce_field('save_wp_tmgr_settings', 'wp_tmgr_settings');?>

        <header class="header">
            <div class="logo">
                <h2>
                    <?php _e('Configuraciones - ','wp_theme_manager');?>
                    <?php echo get_option("blogname");?>
                </h2>
            </div>
            <div class="icon-option"></div>
        </header>

        <section class="info_bar">
            <button id="wp_tmgr_save" type="button" class="button-primary">
                <?php _e('Guardar los cambios','wp_theme_manager');?>
            </button>
        </section>
        
         <!-- Print menu of sections -->
        <section class="main">
            <section class="of-nav">
                <ul>
                    <?php for($i = 0; $i < count($sections); $i++):?>
                        <li>
                            <a href="#<?php echo $sections[$i]['id'];?>"><?php echo $sections[$i]['name'];?></a>
                        </li>
                    <?php endfor;?>
                </ul>
            </section>

            <section class="content">
                <!-- Print content of sections -->
                <?php for($i = 0; $i < count($sections); $i++):?>
                    <div id='<?php echo $sections[$i]['id'];?>' class='content-hide'>
                        <?php for($j = 0; $j < count($sections[$i]['controls']); $j++):?>
                            <?php echo $sections[$i]['controls'][$j];?>
                        <?php endfor;?> 
                    </div>
                <?php endfor;?>
            
            </section>
        </section>

    </form>
</section>