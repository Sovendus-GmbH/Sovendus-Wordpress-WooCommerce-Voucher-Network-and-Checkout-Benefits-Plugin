<?php

defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');


class Sovendus_Admin_Notices
{
    public static function install_admin_notice()
    {
        echo '<div class="notice notice-error">';
        echo '<p>' . wp_kses_post(__('Sovendus App for WooCommerce requires active WooCommerce Installation, please install and activate WooCommerce plugin!', 'wc-sovendus')) . '</p>';
        echo '</div>';
    }

    public static function multisite_admin_notice()
    {
        echo '<div class="notice notice-error">';
        echo '<p>' . wp_kses_post(__('Sovendus App for WooCommerce requires active WooCommerce Installation, please install and activate WooCommerce plugin network-wide!', 'wc-sovendus')) . '</p>';
        echo '</div>';
    }
    public static function multisite_beta_admin_notice()
    {
        echo '<div class="notice notice-error">';
        echo '<p>' . wp_kses_post(__('Sovendus App for WooCommerce is still in beta on multisites, let us know if you encounter any issues', 'wc-sovendus')) . '</p>';
        echo '</div>';
    }
}
