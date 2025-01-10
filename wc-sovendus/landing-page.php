<?php

require_once plugin_dir_path(__FILE__) . 'sovendus-plugins-commons/page-scripts/landing-page/sovendus-page.php';
require_once plugin_dir_path(__FILE__) . 'sovendus-plugins-commons/settings/get-settings-helper.php';


/**
 * Add landing page script
 */
function wordpress_sovendus_page()
{
    $countryCode = null;
    $languageCode = null;
    $settings = Get_Settings_Helper::get_settings(countryCode: null, get_option_callback: 'get_option');
    echo sovendus_landing_page(
        settings: $settings,
        pluginName: WC_PLUGIN_NAME,
        pluginVersion: WC_SOVENDUS_VERSION,
        country: $countryCode,
        language: $languageCode
    );

}