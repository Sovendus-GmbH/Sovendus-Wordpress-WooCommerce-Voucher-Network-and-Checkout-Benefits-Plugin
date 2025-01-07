<?php

require_once plugin_dir_path(__FILE__) . 'sovendus-plugins-commons/page-scripts/landing-page/sovendus-page.php';


/**
 * Add landing page script
 */
function wordpress_sovendus_page()
{
    $settings = WC_Sovendus_Helper::get_settings(countryCode: null);
    echo sovendus_landing_page(settings: $settings, pluginName: WC_PLUGIN_NAME, pluginVersion: WC_SOVENDUS_VERSION);

}