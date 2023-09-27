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
 * Version:           1.0.0
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

define('WOOCOMMERCE_THANKS_REDIRECT_PLUGIN_PATH', plugins_url(__FILE__));
define('WOOCOMMERCE_THANKS_REDIRECT_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('WOOCOMMERCE_THANKS_REDIRECT_PLUGIN_VERSION', '1.0.0');


/**
 * Check if WooCommerce is active
 */

if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')), true)) {
	if (is_multisite()) {
		add_action('admin_notices', 'wc_sovendus_multisite_admin_notice');
	} else {
		add_action('admin_notices', 'wc_sovendus_install_admin_notice');
	}
} else {
	add_action('init', 'wc_sovendus_load_textdomain');

	/**
	 * Load plugin textdomain.
	 */
	function wc_sovendus_load_textdomain()
	{
		load_plugin_textdomain('wc-sovendus', false, dirname(plugin_basename(__FILE__)) . '/languages');
	}

	// Add submenu under woocommerce
	add_action('admin_menu', 'wc_sovendus_submenu_entry', 100);

	function wc_sovendus_submenu_entry()
	{
		add_submenu_page(
			'woocommerce',
			__('Sovendus'),
			__('Sovendus'),
			'manage_woocommerce',
			// Required user capability
			'admin.php?page=wc-settings&tab=products&section=wcsovendus'
		);
	}

	/**
	 * Create the section beneath the products tab
	 */

	add_filter('woocommerce_get_sections_products', 'wc_sovendus_add_section');
	function wc_sovendus_add_section($sections)
	{
		$sections['wcsovendus'] = __('Sovendus Voucher Network & Checkout Benefits', 'wc-sovendus');
		return $sections;
	}

	/**
	 * Add settings to the specific section created before
	 */

	add_filter('woocommerce_get_settings_products', 'wc_sovendus_settings', 10, 2);

	function wc_sovendus_settings($settings, $current_section)
	{

		/**
		 * Check the current section
		 */

		if ($current_section === 'wcsovendus') {
			$sovendusSettings = array();

			// Add Title to the Settings
			$sovendusSettings[] = array(
				'name' => __('Sovendus Voucher Network & Checkout Benefits', 'wc-sovendus'),
				'type' => 'title',
				'desc' => __('Official Sovendus Voucher Network & Checkout Benefits Plugin for WooCommerce', 'wc-sovendus'),
				'id' => 'enabled',
			);

			// Add first checkbox option

			$sovendusSettings[] = array(
				'name' => __('Enable Sovendus Banner', 'wc-sovendus'),
				'desc_tip' => __('This will enable the sovendus banner on the post checkout page', 'wc-sovendus'),
				'id' => 'wc_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => __('Enable Sovendus Banner', 'wc-sovendus'),
			);

			// Add second text field option

			$sovendusSettings[] = array(
				'name' => __('Traffic Source Number', 'wc-sovendus'),
				'desc_tip' => __('The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.', 'wc-sovendus'),
				'id' => 'wc_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => __('Enter the traffic source number from your integration documentation', 'wc-sovendus'),
			);

			// Add third text field option

			$sovendusSettings[] = array(
				'name' => __('Traffic Medium Number', 'wc-sovendus'),
				'desc_tip' => __('The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.', 'wc-sovendus'),
				'id' => 'wc_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => __('Enter the traffic medium number from your integration documentation', 'wc-sovendus'),
			);

			$sovendusSettings[] = array(
				'type' => 'sectionend',
				'id' => 'wcsovendus',
			);
			return $sovendusSettings;

		} else {
			/**
			 * If not, return the standard settings
			 */
			return $settings;
		}
	}

	add_action('woocommerce_thankyou', 'sovendus_thankyou_banner', 10, 2);

	function sovendus_thankyou_banner($order_id)
	{
		$sovendusActive = get_option('wc_sovendus_activated');
		$trafficSourceNumber = get_option('wc_sovendus_trafficSourceNumber');
		$trafficMediumNumber = get_option('wc_sovendus_trafficMediumNumber');
		if ($sovendusActive == "yes" && $trafficSourceNumber && $trafficMediumNumber) {
			$order = wc_get_order($order_id);
			$first_name = $order->get_billing_first_name();
			$last_name = $order->get_billing_last_name();
			$city = $order->get_billing_city();
			$postcode = $order->get_billing_postcode();
			$country = $order->get_billing_country();
			list($streetName, $streetNumber) = splitStreetAndStreetNumber($order->get_billing_address_1());
			$email = $order->get_billing_email();
			$currency = $order->get_currency();
			$currentTime = time();
			$orderNumber = $order->get_order_number();
			$usedCoupons = $order->get_coupon_codes();
			$usedCouponCode = $usedCoupons[0];
			$cartHash = $order->cart_hash;
			$netValue = $order->get_total() - $order->get_shipping_total() - $order->get_total_tax() + $order->get_shipping_tax();
			echo <<<EOD
				<div id="sovendus-integration-container"></div>	
				<script type="text/javascript">
					window.sovIframes = window.sovIframes || [];
					window.sovIframes.push({
						trafficSourceNumber: "$trafficSourceNumber",
						trafficMediumNumber: "$trafficMediumNumber",
						sessionId: "$cartHash",
						timestamp: "$currentTime",
						orderId: "$orderNumber",
						orderValue: "$netValue",
						orderCurrency: "$currency",
						usedCouponCode: "$usedCouponCode",
						iframeContainerId: "sovendus-integration-container",
					});
					window.sovConsumer = window.sovConsumer || {};
					window.sovConsumer = {
						consumerFirstName: "$first_name",
						consumerLastName: "$last_name",
						consumerEmail: "$email",
						consumerStreet:"$streetName",
						consumerStreetNumber:"$streetNumber",
						consumerZipcode: "$postcode",
						consumerCity: "$city",
						consumerCountry: "$country",
					};
				</script>
				<script
					async=true
					src="https://api.sovendus.com/sovabo/common/js/flexibleIframe.js"
					type="text/javascript"
				>
				</script>
				EOD;
		}
	}

	function splitStreetAndStreetNumber(string $street)
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
}
/* Admin notice if WooCommerce is not installed or active */

function wc_sovendus_install_admin_notice()
{
	echo '<div class="notice notice-error">';
	echo '<p>' . wp_kses_post(__('Sovendus Thank You Page for WooCommerce requires active WooCommerce Installation, please install and activate WooCommerce plugin!', 'wc-sovendus')) . '</p>';
	echo '</div>';
}

function wc_sovendus_multisite_admin_notice()
{
	echo '<div class="notice notice-error">';
	echo '<p>' . wp_kses_post(__('Sovendus Thank You Page for WooCommerce is not designed for Multisite, please contact us for a custom integration', 'wc-sovendus')) . '</p>';
	echo '</div>';
}