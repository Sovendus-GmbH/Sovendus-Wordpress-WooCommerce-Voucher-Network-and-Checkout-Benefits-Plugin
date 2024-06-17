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
 * Version:           1.2.5
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

	add_action('before_woocommerce_init', function () {
		if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
		}
	});
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

			$sovendusSettings[] = array(
				'name' => __('Sovendus Voucher Network & Checkout Benefits', 'wc-sovendus'),
				'type' => 'title',
				'desc' => __('Official Sovendus Voucher Network & Checkout Benefits Plugin for WooCommerce', 'wc-sovendus'),
				'id' => 'title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Austria',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'AT_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Austria',
			);
			$sovendusSettings[] = array(
				'name' => 'Austria Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'AT_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Austria Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'AT_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Austria',
				'type' => 'title',
				'id' => 'AT_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Belgium French',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'FR_BE_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Belgium French',
			);
			$sovendusSettings[] = array(
				'name' => 'Belgium French Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'FR_BE_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Belgium French Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'FR_BE_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Belgium French',
				'type' => 'title',
				'id' => 'FR_BE_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Belgium Dutch',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'NL_BE_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Belgium Dutch',
			);
			$sovendusSettings[] = array(
				'name' => 'Belgium Dutch Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'NL_BE_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Belgium Dutch Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'NL_BE_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Belgium Dutch',
				'type' => 'title',
				'id' => 'NL_BE_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Denmark',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'DK_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Denmark',
			);
			$sovendusSettings[] = array(
				'name' => 'Denmark Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'DK_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Denmark Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'DK_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Denmark',
				'type' => 'title',
				'id' => 'DK_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for France',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'FR_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for France',
			);
			$sovendusSettings[] = array(
				'name' => 'France Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'FR_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'France Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'FR_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for France',
				'type' => 'title',
				'id' => 'FR_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Germany',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'DE_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Germany',
			);
			$sovendusSettings[] = array(
				'name' => 'Germany Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'DE_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Germany Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'DE_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Germany',
				'type' => 'title',
				'id' => 'DE_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Ireland',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'IE_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Ireland',
			);
			$sovendusSettings[] = array(
				'name' => 'Ireland Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'IE_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Ireland Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'IE_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Ireland',
				'type' => 'title',
				'id' => 'IE_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Italy',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'IT_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Italy',
			);
			$sovendusSettings[] = array(
				'name' => 'Italy Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'IT_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Italy Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'IT_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Italy',
				'type' => 'title',
				'id' => 'IT_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Netherland',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'NL_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Netherland',
			);
			$sovendusSettings[] = array(
				'name' => 'Netherland Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'NL_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Netherland Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'NL_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Netherland',
				'type' => 'title',
				'id' => 'NL_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Norway',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'NO_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Norway',
			);
			$sovendusSettings[] = array(
				'name' => 'Norway Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'NO_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Norway Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'NO_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Norway',
				'type' => 'title',
				'id' => 'NO_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Poland',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'PL_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Poland',
			);
			$sovendusSettings[] = array(
				'name' => 'Poland Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'PL_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Poland Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'PL_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Poland',
				'type' => 'title',
				'id' => 'PL_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Spain',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'ES_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Spain',
			);
			$sovendusSettings[] = array(
				'name' => 'Spain Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'ES_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Spain Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'ES_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Spain',
				'type' => 'title',
				'id' => 'ES_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Sweden',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'SE_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Sweden',
			);
			$sovendusSettings[] = array(
				'name' => 'Sweden Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'SE_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Sweden Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'SE_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Sweden',
				'type' => 'title',
				'id' => 'SE_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Switzerland French',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'FR_CH_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Switzerland French',
			);
			$sovendusSettings[] = array(
				'name' => 'Switzerland French Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'FR_CH_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Switzerland French Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'FR_CH_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Switzerland French',
				'type' => 'title',
				'id' => 'FR_CH_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Switzerland German',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'DE_CH_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Switzerland German',
			);
			$sovendusSettings[] = array(
				'name' => 'Switzerland German Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'DE_CH_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Switzerland German Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'DE_CH_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Switzerland German',
				'type' => 'title',
				'id' => 'DE_CH_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for Switzerland Italian',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'IT_CH_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for Switzerland Italian',
			);
			$sovendusSettings[] = array(
				'name' => 'Switzerland Italian Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'IT_CH_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Switzerland Italian Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'IT_CH_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for Switzerland Italian',
				'type' => 'title',
				'id' => 'IT_CH_sovendus_title',
			);


			$sovendusSettings[] = array(
				'name' => 'Enable Sovendus Banner for United Kingdom',
				'desc_tip' => 'This will enable the sovendus banner on the post checkout page',
				'id' => 'UK_sovendus_activated',
				'type' => 'checkbox',
				'css' => 'min-width:300px;',
				'desc' => 'Enable Sovendus Banner for United Kingdom',
			);
			$sovendusSettings[] = array(
				'name' => 'United Kingdom Traffic Source Number',
				'desc_tip' => 'The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'UK_sovendus_trafficSourceNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic source number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'United Kingdom Traffic Medium Number',
				'desc_tip' => 'The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.',
				'id' => 'UK_sovendus_trafficMediumNumber',
				'type' => 'number',
				'desc' => 'Enter the traffic medium number from your integration documentation',
			);
			$sovendusSettings[] = array(
				'name' => 'Settings for United Kingdom',
				'type' => 'title',
				'id' => 'UK_sovendus_title',
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

	add_action('woocommerce_before_thankyou', 'sovendus_thankyou_banner', 10, 2);

	function sovendus_thankyou_banner($order_id)
	{
		$order = wc_get_order($order_id);
		$country = $order->get_billing_country();
		list($sovendusActive, $trafficSourceNumber, $trafficMediumNumber) = getSovendusSettings($country);
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
			// Not available
			// $consumerYearOfBirth = "";
			// $consumerSalutation = "";
			$sovendusActive = json_encode($sovendusActive);
			$trafficSourceNumber = json_encode($trafficSourceNumber);
			$trafficMediumNumber = json_encode($trafficMediumNumber);
			echo <<<EOD
				<div id="sovendus-integration-container"></div>	
				<script type="text/javascript">
					let isActive = false;
					let trafficSourceNumber = "";
					let trafficMediumNumber = "";
					const multiLangCountries = ["CH", "BE"]
					if (multiLangCountries.includes("$country")){
						const lang = document.documentElement.lang.split("-")[0];
						isActive = JSON.parse('$sovendusActive')[lang];
						trafficSourceNumber = JSON.parse('$trafficSourceNumber')[lang];
						trafficMediumNumber = JSON.parse('$trafficMediumNumber')[lang];
					} else {
						isActive = true;
						trafficSourceNumber = '$trafficSourceNumber';
						trafficMediumNumber = '$trafficMediumNumber';
					}
					if (isActive && Number(trafficSourceNumber) > 0 && Number(trafficMediumNumber) > 0){
						window.sovIframes = window.sovIframes || [];
						window.sovIframes.push({
							trafficSourceNumber: trafficSourceNumber,
							trafficMediumNumber: trafficMediumNumber,
							sessionId: "$cartHash",
							timestamp: "$currentTime",
							orderId: "$orderNumber",
							orderValue: "$netValue",
							orderCurrency: "$currency",
							usedCouponCode: "$usedCouponCode",
							iframeContainerId: "sovendus-integration-container",
							integrationType: "woocommerce-1.2.5"
						});
						window.sovConsumer = {
							consumerFirstName: "$first_name",
							consumerLastName: "$last_name",
							consumerEmail: "$email",
							consumerStreet:"$streetName",
							consumerStreetNumber:"$streetNumber",
							consumerZipcode: "$postcode",
							consumerCity: "$city",
							consumerCountry: "$country",
							consumerPhone: "$consumerPhone",
						};
						var script = document.createElement("script");
						script.type = "text/javascript";
						script.async = true;
						script.src =
						  window.location.protocol +
						  "//api.sovendus.com/sovabo/common/js/flexibleIframe.js";
						document.body.appendChild(script);
					};
				</script>
				EOD;
		}
	}

	function getSovendusSettings(string $countryCode)
	{
		switch ($countryCode) {
			case "DE":
				$sovendusActive = get_option('DE_sovendus_activated');
				$trafficSourceNumber = (int) get_option('DE_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('DE_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "AT":
				$sovendusActive = get_option('AT_sovendus_activated');
				$trafficSourceNumber = (int) get_option('AT_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('AT_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "NL":
				$sovendusActive = get_option('NL_sovendus_activated');
				$trafficSourceNumber = (int) get_option('NL_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('NL_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "CH":
				$sovendusActive = array("de" => get_option('DE_CH_sovendus_activated'), "fr" => get_option('FR_CH_sovendus_activated'), "it" => get_option('FR_CH_sovendus_activated'));
				$trafficSourceNumber = array("de" => (int) get_option('DE_CH_sovendus_trafficSourceNumber'), "fr" => (int) get_option('FR_CH_sovendus_trafficSourceNumber'), "it" => (int) get_option('FR_CH_sovendus_trafficSourceNumber'));
				$trafficMediumNumber = array("de" => (int) get_option('DE_CH_sovendus_trafficMediumNumber'), "fr" => (int) get_option('FR_CH_sovendus_trafficMediumNumber'), "it" => (int) get_option('FR_CH_sovendus_trafficMediumNumber'));
				return array(
					$sovendusActive,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "FR":
				$sovendusActive = get_option('FR_sovendus_activated');
				$trafficSourceNumber = (int) get_option('FR_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('FR_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "IT":
				$sovendusActive = get_option('IT_sovendus_activated');
				$trafficSourceNumber = (int) get_option('IT_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('IT_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "IE":
				$sovendusActive = get_option('IE_sovendus_activated');
				$trafficSourceNumber = (int) get_option('IE_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('IE_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "GB":
				$sovendusActive = get_option('UK_sovendus_activated');
				$trafficSourceNumber = (int) get_option('UK_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('UK_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "DK":
				$sovendusActive = get_option('DK_sovendus_activated');
				$trafficSourceNumber = (int) get_option('DK_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('DK_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "SE":
				$sovendusActive = get_option('SE_sovendus_activated');
				$trafficSourceNumber = (int) get_option('SE_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('SE_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "ES":
				$sovendusActive = get_option('ES_sovendus_activated');
				$trafficSourceNumber = (int) get_option('ES_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('ES_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "BE":
				$sovendusActive = array("nl" => get_option('NL_BE_sovendus_activated'), "fr" => get_option('FR_NL_BE_sovendus_activated'));
				$trafficSourceNumber = array("nl" => (int) get_option('NL_BE_sovendus_trafficSourceNumber'), "fr" => (int) get_option('FR_BE_sovendus_trafficSourceNumber'));
				$trafficMediumNumber = array("nl" => (int) get_option('NL_BE_sovendus_trafficMediumNumber'), "fr" => (int) get_option('FR_BE_sovendus_trafficMediumNumber'));
				return array(
					$sovendusActive,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "PL":
				$sovendusActive = get_option('PL_sovendus_activated');
				$trafficSourceNumber = (int) get_option('PL_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('PL_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);
			case "NO":
				$sovendusActive = get_option('NO_sovendus_activated');
				$trafficSourceNumber = (int) get_option('NO_sovendus_trafficSourceNumber');
				$trafficMediumNumber = (int) get_option('NO_sovendus_trafficMediumNumber');
				return array(
					$sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
					$trafficSourceNumber,
					$trafficMediumNumber,
				);

			default:
				return array(
					false,
					0,
					0,
				);
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

add_action('wp_print_footer_scripts', 'sovendus_page_landing', 10, 0);
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


/* Admin notice if WooCommerce is not installed or active */

function wc_sovendus_install_admin_notice()
{
	echo '<div class="notice notice-error">';
	echo '<p>' . wp_kses_post(__('Sovendus Voucher Network & Checkout Benefits for WooCommerce requires active WooCommerce Installation, please install and activate WooCommerce plugin!', 'wc-sovendus')) . '</p>';
	echo '</div>';
}

function wc_sovendus_multisite_admin_notice()
{
	echo '<div class="notice notice-error">';
	echo '<p>' . wp_kses_post(__('Sovendus Voucher Network & Checkout Benefits for WooCommerce is not designed for Multisite, please contact us for a custom integration', 'wc-sovendus')) . '</p>';
	echo '</div>';
}