<?php

defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');


class Sovendus_Admin_Menu
{
    public static function submenu_entry()
    {
        add_menu_page(
            __('Sovendus App', 'wc-sovendus'),
            __('Sovendus App', 'wc-sovendus'),
            'manage_woocommerce',
            'wc-sovendus',
            [self::class, 'display_sovendus_page'],
            plugin_dir_url(__FILE__) . '../dist/sovendus-logo-white.png',
            56
        );
    }

    public static function display_sovendus_page()
    {
        echo '<div id="sovendus-settings-container"></div>';
    }

    public static function enqueue_admin_styles()

    {
        wp_enqueue_style('sovendus-admin-style', plugins_url('admin-menu-style.css', __FILE__));
    }
}
