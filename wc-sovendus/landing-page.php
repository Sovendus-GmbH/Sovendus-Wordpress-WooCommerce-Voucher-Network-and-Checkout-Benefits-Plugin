<?php

require_once 'sovendus-plugins-commons/page-scripts/landing-page/sovendus-page.php';
require_once 'sovendus-plugins-commons/settings/get-settings-helper.php';
require_once 'settings/settings-keys.php';

/**
 * Add landing page script
 */
function wordpress_sovendus_page()
{
    $country = null;
    $language = null;
    $settings = Get_Settings_Helper::get_settings(countryCode: null, get_option_callback: 'get_option', settings_keys: SETTINGS_KEYS);
    $integrationType = getIntegrationType(pluginName: WC_PLUGIN_NAME, pluginVersion: WC_SOVENDUS_VERSION);

    $js_file_url = plugins_url('dist/sovendus-page.js', __FILE__);
    wp_register_script('sovendus_page_script', $js_file_url, [], WC_SOVENDUS_VERSION, true);
    // ------------------------------------------------------------
    // IMPORTANT CHANGES HERE HAVE TO BE REPLICATED IN THE OTHER FILE
    // ------------------------------------------------------------
    wp_localize_script('sovendus_page_script', 'sovPageConfig', [
        'settings' => $settings,
        'integrationType' => $integrationType,
        'country' => $country,
        'language' => $language,
    ]);
    wp_enqueue_script('sovendus_page_script');
}
