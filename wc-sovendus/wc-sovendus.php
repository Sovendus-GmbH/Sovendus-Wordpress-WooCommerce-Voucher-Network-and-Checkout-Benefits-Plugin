<?php

// TODO REMove
// define('WP_DEBUG_LOG', true);
// define('WP_DEBUG_DISPLAY', false);


/**
 *
 * @link    https://online.sovendus.com/en/contact/contact-corporate-customers/#
 * @since   1.1
 * @package wc_sovendus
 *
 * @wordpress-plugin
 * Plugin Name:       Sovendus App for WooCommerce
 * Plugin URI:        https://online.sovendus.com/produkte/sovendus-voucher-network/
 * Description:       Official Sovendus App for Wordpress WooCommerce
 * Version:           2.0.0
 * Author:            Sovendus - Marcus Brandstaetter
 * Author URI:        https://online.sovendus.com/en/contact/contact-corporate-customers/#
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       wc-sovendus
 * Requires PHP:      5.6
 * WC requires at least: 5.0
 * WC tested up to: 8.0
 */

// Exit if accessed directly
defined('ABSPATH') || die('WordPress Error! Opening plugin file directly');

define(constant_name: 'WC_PLUGIN_NAME', value: 'woocommerce');
define('WC_SOVENDUS_VERSION', '2.0.0');
define('WOOCOMMERCE_SOVENDUS_VOUCHER_NETWORK_CHECKOUT_BENEFITS_PLUGIN_PATH', plugins_url(__FILE__));
define('WOOCOMMERCE_SOVENDUS_VOUCHER_NETWORK_CHECKOUT_BENEFITS_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('WOOCOMMERCE_SOVENDUS_VOUCHER_NETWORK_CHECKOUT_BENEFITS_PLUGIN_VERSION', WC_SOVENDUS_VERSION);

require_once 'wordpress-helpers/class-wc-sovendus-woocommerce-check.php';
require_once 'wordpress-helpers/class-wc-sovendus-admin-notices.php';
require_once 'wordpress-helpers/class-wc-sovendus-textdomain.php';
require_once 'wordpress-helpers/class-wc-sovendus-admin-menu.php';
require_once 'wordpress-helpers/class-wc-sovendus-activator.php';
require_once 'wordpress-helpers/class-wc-sovendus-deactivator.php';
require_once 'settings/get-settings.php';
require_once 'settings/save-settings.php';
require_once 'landing-page.php';
require_once 'thank-you-page.php';
require_once 'admin-frontend/admin-frontend.php';
require_once 'sovendus-plugins-commons/helpers/integration-data-helpers.php';

if (!WC_Sovendus_WooCommerce_Check::is_woocommerce_active()) {
    if (is_multisite()) {
        add_action('network_admin_notices', ['WC_Sovendus_Admin_Notices', 'multisite_admin_notice']);
    } else {
        add_action('admin_notices', ['WC_Sovendus_Admin_Notices', 'install_admin_notice']);
    }
} else {
    add_action('init', ['WC_Sovendus_Textdomain', 'load_textdomain']);
    add_action('before_woocommerce_init', function () {
        if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
        }
    });
    add_action('admin_enqueue_scripts', ['WC_Sovendus_Admin_Menu', 'enqueue_admin_styles']);
    add_action('admin_menu', ['WC_Sovendus_Admin_Menu', 'submenu_entry'], 100);

    add_action('wp_ajax_save_sovendus_settings', 'save_sovendus_settings');
    add_action('admin_enqueue_scripts', 'enqueue_sovendus_react_scripts');

    add_action('woocommerce_before_thankyou', 'wordpress_sovendus_thankyou_page', 10, 2);
    add_action('wp_print_footer_scripts', 'wordpress_sovendus_page', 10, 0);
}

register_activation_hook(__FILE__, ['WC_Sovendus_Activator', 'activate']);
register_deactivation_hook(__FILE__, ['WC_Sovendus_Deactivator', 'deactivate']);
