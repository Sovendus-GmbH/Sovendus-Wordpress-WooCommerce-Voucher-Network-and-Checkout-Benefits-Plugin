<?php

defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');

require_once __DIR__ . '/settings/get-settings.php';
require_once __DIR__ . '/settings/integration-data-helpers.php';
require_once __DIR__ . '/wc-sovendus.php';

/**
 * Display Sovendus banner on the thank you page
 */
function wordpress_sovendus_thankyou_page($order_id)
{
    $order = wc_get_order($order_id);
    $country = $order->get_billing_country();
    // TODO handle session id 
    $sessionId = ""; // $order->cart_hash; 
    // TODO get the language somewhere
    $language = null;
    $consumerStreetAndNumber = $order->get_billing_address_1();
    $consumerStreet = null;
    $consumerStreetNumber = null;
    if ($consumerStreetAndNumber) {
        list($consumerStreet, $consumerStreetNumber) = splitStreetAndStreetNumber($consumerStreetAndNumber);
    }
    $js_file_url = plugins_url('dist/thankyou-page.js', __FILE__);

    echo "<div id='sovendus-integration-container'></div>";

    wp_register_script('sovendus_thankyou_script', $js_file_url, [], SOVENDUS_VERSION, true);
    wp_localize_script('sovendus_thankyou_script', 'sovThankyouConfig', [
        'settings' => get_sovendus_settings(),
        "iframeContainerId" => "sovendus-integration-container",
        "integrationType" => getIntegrationType(PLUGIN_NAME, SOVENDUS_VERSION),
        "orderData" => [
            "sessionId" => $sessionId,
            "orderId" => $order->get_order_number(),
            "orderValue" => $order->get_total() - $order->get_shipping_total() - $order->get_total_tax() + $order->get_shipping_tax(),
            "orderCurrency" => $order->get_currency(),
            "usedCouponCodes" => $order->get_coupon_codes(),
        ],
        "customerData" => [
            "consumerFirstName" => $order->get_billing_first_name(),
            "consumerLastName" => $order->get_billing_last_name(),
            "consumerEmail" => $order->get_billing_email(),
            "consumerStreetNumber" => $consumerStreetNumber,
            "consumerStreet" => $consumerStreet,
            "consumerZipcode" => $order->get_billing_postcode(),
            "consumerCity" => $order->get_billing_city(),
            "consumerCountry" => $country,
            "consumerLanguage" => $language,
            "consumerPhone" => $order->get_billing_phone(),
        ],
    ]);
    wp_enqueue_script('sovendus_thankyou_script');
}
