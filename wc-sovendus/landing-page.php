<?php
defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');

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
    $settings = Get_Settings_Helper::get_settings(null, 'get_option', SETTINGS_KEYS);
    $integrationType = getIntegrationType(PLUGIN_NAME, SOVENDUS_VERSION);

    $js_file_url = plugins_url('dist/sovendus-page.js', __FILE__);
    wp_register_script('sovendus_page_script', $js_file_url, [], SOVENDUS_VERSION, true);
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