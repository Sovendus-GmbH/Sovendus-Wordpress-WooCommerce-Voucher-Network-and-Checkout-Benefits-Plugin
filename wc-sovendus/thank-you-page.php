<?php

require_once 'sovendus-plugins-commons/page-scripts/thankyou-page/thankyou-page.php';
require_once 'sovendus-plugins-commons/settings/get-settings-helper.php';
require_once 'settings/settings-keys.php';
require_once 'wc-sovendus.php';


/**
 * Display Sovendus banner on the thank you page
 */
function wordpress_sovendus_thankyou_page($order_id)
{
    $order = wc_get_order($order_id);
    $country = $order->get_billing_country();
    $settings = Get_Settings_Helper::get_settings(countryCode: $country, get_option_callback: 'get_option', settings_keys: SETTINGS_KEYS);

    // TODO handle session id 
    $sessionId = ""; // $order->cart_hash; 
    echo sovendus_thankyou_page(
        settings: $settings,
        pluginName: WC_PLUGIN_NAME,
        pluginVersion: WC_SOVENDUS_VERSION,
        sessionId: $sessionId,
        timestamp: time(),
        orderId: $order->get_order_number(),
        orderValue: $order->get_total() - $order->get_shipping_total() - $order->get_total_tax() + $order->get_shipping_tax(),
        orderCurrency: $order->get_currency(),
        usedCouponCodes: $order->get_coupon_codes(),
        consumerFirstName: $order->get_billing_first_name(),
        consumerLastName: $order->get_billing_last_name(),
        consumerEmail: $order->get_billing_email(),
        consumerStreetAndNumber: $order->get_billing_address_1(),
        consumerStreetNumber: null, // using splitStreetAndStreetNumber instead
        consumerStreet: null, // using splitStreetAndStreetNumber instead
        consumerZipcode: $order->get_billing_postcode(),
        consumerCity: $order->get_billing_city(),
        consumerCountry: $country,
        consumerLanguage: null, // TODO get the language somewhere
        consumerPhone: $order->get_billing_phone(),
    );
}
