<?php

defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');

require_once __DIR__ . '/../sovendus-plugins-commons/settings/app-settings.php';
require_once __DIR__ . '/../sovendus-plugins-commons/settings/get-settings-helper.php';
require_once __DIR__ . '/../sovendus-plugins-commons/settings/sovendus-countries.php';
require_once __DIR__ . '/settings-keys.php';

/**
 * @param string|null $countryCode
 * @return Sovendus_App_Settings
 */
function get_sovendus_settings($countryCode)
{
    return Get_Settings_Helper::get_settings(
        $countryCode,
        'get_option',
        SETTINGS_KEYS
    );
}
