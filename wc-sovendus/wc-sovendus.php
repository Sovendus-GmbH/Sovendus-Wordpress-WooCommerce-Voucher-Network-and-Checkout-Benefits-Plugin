<?php

/**
 *
 * @link    https://online.sovendus.com/kontakt/kontakt-firmenkunden/
 * @since   1.1
 * @package wc_sovendus
 *
 * @wordpress-plugin
 * Plugin Name:       Sovendus Voucher Network & Checkout Benefits for WooCommerce
 * Plugin URI:        https://online.sovendus.com/produkte/sovendus-voucher-network/
 * Description:       Official Sovendus Voucher Network & Checkout Benefits Plugin for Wordpress WooCommerce
 * Version:           1.3.0
 * Author:            Sovendus - Marcus Brandstaetter
 * Author URI:        https://online.sovendus.com/kontakt/kontakt-firmenkunden/
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       wc-sovendus
 * Requires PHP:      5.6
 * WC requires at least: 5.0
 * WC tested up to: 8.0
 */

// Exit if accessed directly
defined('ABSPATH') || die('WordPress Error! Opening plugin file directly');

define('WOOCOMMERCE_SOVENDUS_VOUCHER_NETWORK_CHECKOUT_BENEFITS_PLUGIN_PATH', plugins_url(__FILE__));
define('WOOCOMMERCE_SOVENDUS_VOUCHER_NETWORK_CHECKOUT_BENEFITS_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('WOOCOMMERCE_SOVENDUS_VOUCHER_NETWORK_CHECKOUT_BENEFITS_PLUGIN_VERSION', '1.2.5');

require_once plugin_dir_path(__FILE__) . 'class-wc-sovendus-woocommerce-check.php';
require_once plugin_dir_path(__FILE__) . 'class-wc-sovendus-admin-notices.php';
require_once plugin_dir_path(__FILE__) . 'class-wc-sovendus-textdomain.php';
require_once plugin_dir_path(__FILE__) . 'class-wc-sovendus-admin-menu.php';
require_once plugin_dir_path(__FILE__) . 'class-wc-sovendus-activator.php';
require_once plugin_dir_path(__FILE__) . 'class-wc-sovendus-deactivator.php';
require_once plugin_dir_path(__FILE__) . 'class-wc-sovendus-settings.php';
require_once plugin_dir_path(__FILE__) . 'class-wc-sovendus-helper.php';

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
    add_action('admin_menu', ['WC_Sovendus_Admin_Menu', 'submenu_entry'], 100);
    add_filter('woocommerce_get_sections_products', ['WC_Sovendus_Settings', 'add_section']);
    add_filter('woocommerce_get_settings_products', ['WC_Sovendus_Settings', 'settings'], 10, 2);
    add_action('woocommerce_before_thankyou', 'sovendus_thankyou_banner', 10, 2);
    add_action('wp_print_footer_scripts', 'sovendus_page_landing', 10, 0);
}

register_activation_hook(__FILE__, ['WC_Sovendus_Activator', 'activate']);
register_deactivation_hook(__FILE__, ['WC_Sovendus_Deactivator', 'deactivate']);

/**
 * Display Sovendus banner on the thank you page
 */
function sovendus_thankyou_banner($order_id)
{
    $order = wc_get_order($order_id);
    $country = $order->get_billing_country();
    list($sovendusActive, $trafficSourceNumber, $trafficMediumNumber) = WC_Sovendus_Helper::get_settings($country);
    if ($sovendusActive) {
        $first_name = $order->get_billing_first_name();
        $last_name = $order->get_billing_last_name();
        $city = $order->get_billing_city();
        $postcode = $order->get_billing_postcode();
        list($streetName, $streetNumber) = splitStreetAndStreetNumber($order->get_billing_address_1());
        $email = $order->get_billing_email();
        $currency = $order->get_currency();
        $currentTime = time();
        $orderNumber = $order->get_order_number();
        $usedCoupons = $order->get_coupon_codes();
        $usedCouponCode = $usedCoupons[0];
        $cartHash = $order->cart_hash;
        $netValue = $order->get_total() - $order->get_shipping_total() - $order->get_total_tax() + $order->get_shipping_tax();
        $consumerPhone = $order->get_billing_phone();
        $sovendusActive = json_encode($sovendusActive);
        $trafficSourceNumber = json_encode($trafficSourceNumber);
        $trafficMediumNumber = json_encode($trafficMediumNumber);

        $js_file_path = plugin_dir_path(__FILE__) . 'sovendus-thankyou-banner.js';
        $js_content = file_get_contents($js_file_path);
        $iframeContainerId = "sovendus-integration-container";
        $integrationType = "woocommerce-1.3.0";
        echo <<<EOD
            <div id="sovendus-integration-container"></div>    
            <script type="text/javascript">
                window.sovPluginConfig = {
                    trafficSourceNumber: "$trafficSourceNumber",
                    trafficMediumNumber: "$trafficMediumNumber",
                    cartHash: "$cartHash",
                    currentTime: "$currentTime",
                    orderNumber: "$orderNumber",
                    netValue: "$netValue",
                    currency: "$currency",
                    usedCouponCode: "$usedCouponCode",
                    iframeContainerId: "$iframeContainerId",
                    integrationType: "$integrationType",
                    first_name: "$first_name",
                    last_name: "$last_name",
                    email: "$email",
                    streetName: "$streetName",
                    streetNumber: "$streetNumber",
                    postcode: "$postcode",
                    city: "$city",
                    country: "$country",
                    consumerPhone: "$consumerPhone",
                }
                $js_content
            </script>
            EOD;
    }
}

/**
 * Split street and street number
 */
function splitStreetAndStreetNumber($street)
{
    if ((strlen($street) > 0) && preg_match_all('#([0-9/ -]+ ?[a-zA-Z]?(\s|$))#', trim($street), $match)) {
        $housenr = end($match[0]);
        $consumerStreet = trim(str_replace(array($housenr, '/'), '', $street));
        $consumerStreetNumber = trim($housenr);
        return array($consumerStreet, $consumerStreetNumber);
    } else {
        return array($street, "");
    }
}

/**
 * Add landing page script
 */
function sovendus_page_landing()
{
    echo <<<EOD
        <script>
            var hostName = window.location.hostname.split(".");
            if (
                hostName[hostName.length - 1] === "ch" ||
                ["CH", undefined].includes(document.documentElement.lang.split("-")[1])
            ) {
                var script = document.createElement("script");
                script.type = "text/javascript";
                script.async = true;
                script.src = "https://api.sovendus.com/js/landing.js";
                document.body.appendChild(script);
            }
        </script>
    EOD;
}