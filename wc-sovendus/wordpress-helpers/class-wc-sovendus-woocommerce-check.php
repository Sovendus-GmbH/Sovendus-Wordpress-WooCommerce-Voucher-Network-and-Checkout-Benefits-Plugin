<?php

class WC_Sovendus_WooCommerce_Check
{
    public static function is_woocommerce_active()
    {
        if (is_multisite()) {
            $active_plugins = get_site_option('active_sitewide_plugins');
            if (isset($active_plugins['woocommerce/woocommerce.php'])) {
                return true;
            }
        }
        return in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')), true);
    }
}