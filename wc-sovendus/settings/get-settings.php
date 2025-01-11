<?php

require_once plugin_dir_path(__FILE__) . '../sovendus-plugins-commons/settings/app-settings.php';
require_once plugin_dir_path(__FILE__) . '../sovendus-plugins-commons/settings/get-settings-helper.php';
require_once plugin_dir_path(__FILE__) . '../sovendus-plugins-commons/settings/sovendus-countries.php';
require_once plugin_dir_path(__FILE__) . 'settings-keys.php';


function get_sovendus_settings(string|null $countryCode): Sovendus_App_Settings
{
    // update_option('sovendus_settings', null);

    return Get_Settings_Helper::get_settings(countryCode: $countryCode, get_option_callback: 'get_option', settings_keys: SETTINGS_KEYS);
}
