<?php

class WC_Sovendus_Admin_Menu
{
    public static function submenu_entry()
    {
        add_submenu_page(
            'woocommerce',
            __('Sovendus'),
            __('Sovendus'),
            'manage_woocommerce',
            'admin.php?page=wc-settings&tab=products&section=wcsovendus'
        );
    }
}