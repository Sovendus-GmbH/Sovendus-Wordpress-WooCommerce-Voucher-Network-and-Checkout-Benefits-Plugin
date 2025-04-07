<?php
defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');

require_once __DIR__ . '/settings/get-settings.php';
require_once __DIR__ . '/settings/integration-data-helpers.php';


/**
 * Add landing page script
 */
function wordpress_sovendus_page()
{
    $country = null;
    $locale = get_locale();
    $language = strtoupper(substr($locale, 0, 2));
    // Try to get country from WooCommerce if available
    if (function_exists('WC') && isset(WC()->customer)) {
        $country = WC()->customer->get_billing_country();
    }
    // Try to get country from locale if not already set
    if (empty($country)) {
        $locale_parts = explode('_', $locale);
        if (isset($locale_parts[1])) {
            $country = $locale_parts[1];
        }
    }

    $js_file_url = plugins_url('dist/sovendus-page.js', __FILE__);
    wp_register_script('sovendus_page_script', $js_file_url, [], SOVENDUS_VERSION, true);
    wp_localize_script('sovendus_page_script', 'sovPageConfig', [
        'settings' => get_sovendus_settings(),
        'integrationType' => getIntegrationType(PLUGIN_NAME, SOVENDUS_VERSION),
        'country' => $country,
        'language' => $language,
    ]);
    wp_enqueue_script('sovendus_page_script');
}
