<div class="admin-wrap">
   

    <div class="main-section-bar">
        <div class="settings-bar">
            <div class="menu-settings">
                <ul>
                    <li id="main">Main Options</li>
                    <li id="second">Secondary</li>
                </ul>
            </div>
            <form method="post" action="options.php" class="form-table" id="table-1">
                <?php
                
                settings_fields('custom_login_group');
                do_settings_fields('custom_login', 'main_section');
                submit_button();
                ?>
                <button>Reset changes</button>
            </form>
            <form method="post" action="options.php" class="form-table" id="table-2">
                <?php
        
                settings_fields('second_login_group');
                do_settings_fields('custom_login', 'secondary_section');
                submit_button();
                do_action('encrypted_details');
                ?>
            </form>
        </div>

        <div class="iframe-bar">
            <img src="<?php echo Class_Options::getLive(wp_login_url()); ?>" alt="">

        </div>

        <!--<div class="iframe-bar">
            <iframe
                src="<?php echo wp_login_url(); ?>"
                width="100%"
                height="600"
                style="border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);"></iframe>
        </div> -->
    </div>
</div>
