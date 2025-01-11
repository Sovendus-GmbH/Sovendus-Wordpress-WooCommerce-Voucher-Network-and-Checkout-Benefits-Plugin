<?php

class WC_Sovendus_Admin_Menu
{
    public static function submenu_entry()
    {
        add_menu_page(
            __('Sovendus App', 'wc-sovendus'),
            __('Sovendus App', 'wc-sovendus'),
            'manage_woocommerce',
            'wc-sovendus',
            [self::class, 'display_sovendus_page'],
            plugin_dir_url(__FILE__) . '../sovendus-plugins-commons/sovendus-logo.png', // Update this path to the correct location of your PNG icon
            56
        );
    }

    public static function display_sovendus_page()
    {
        echo '<div id="sovendus-settings-container"></div>';
    }

    public static function enqueue_admin_styles()
    {
        // TODO figure out a better way to display the logo properly
        echo '<style>
                #toplevel_page_wc-sovendus .wp-menu-image img {
                    width: 20px;
                    height: auto;
                    margin: auto;
                }
              </style>';
    }
}
