<div class="admin-wrap">
   

    <div class="main-section-bar">
        <div class="settings-bar">
            <div class="menu-settings">
                <ul>
                    <li id="main">Images</li>
                    <li id="second">Recaptcha</li>
                    <li id="third">Colors</li>
                    <li id="fourth">Text Errors</li>
                </ul>
            </div>
            <form method="post" action="options.php" class="form-table" id="table-1">
                <?php
                
                settings_fields('custom_login_group');
                do_settings_fields('custom_login', 'main_section');
                submit_button();
                ?>
            </form>
            <form method="post" action="options.php" class="form-table" id="table-2">
                <?php
        
                settings_fields('second_login_group');
                do_settings_fields('custom_login', 'secondary_section');
                submit_button();
                do_action('encrypted_details');
                ?>
            </form>
            <form method="post" action="options.php" class="form-table" id="table-3">
                <?php 

                settings_fields('form_color');
                do_settings_fields('custom_login', 'third_section');
                submit_button();

                ?>
            </form>
            <form method="post" action="options.php" class="form-table" id="table-4">
                <?php 

                settings_fields('text_errors');
                do_settings_fields('custom_login', 'fourth_section');
                submit_button();

                ?>
            </form>
        </div>

        <!--<div class="iframe-bar">
            <img src="
            

        </div>-->

        <div class="iframe-bar">
            <iframe
                src="<?php echo wp_login_url(); ?>"
                width="100%"
                height="600"
                style="border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);"></iframe>
        </div> 
    </div>
</div>
