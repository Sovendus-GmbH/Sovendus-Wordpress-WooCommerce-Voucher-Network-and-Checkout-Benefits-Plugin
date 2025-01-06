<?php

class WC_Sovendus_Admin_Notices
{
    public static function install_admin_notice()
    {
        echo '<div class="notice notice-error">';
        echo '<p>' . wp_kses_post(__('Sovendus Voucher Network & Checkout Benefits for WooCommerce requires active WooCommerce Installation, please install and activate WooCommerce plugin!', 'wc-sovendus')) . '</p>';
        echo '</div>';
    }

    public static function multisite_admin_notice()
    {
        echo '<div class="notice notice-error">';
        echo '<p>' . wp_kses_post(__('Sovendus Voucher Network & Checkout Benefits for WooCommerce requires active WooCommerce Installation on the network, please install and activate WooCommerce plugin network-wide!', 'wc-sovendus')) . '</p>';
        echo '</div>';
    }
}