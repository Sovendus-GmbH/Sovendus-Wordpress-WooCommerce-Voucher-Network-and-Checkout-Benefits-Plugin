<?php

defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');


require_once plugin_dir_path(__FILE__) . '../sovendus-plugins-commons/settings/get-settings-helper.php';

define('SETTINGS_KEYS', new SettingsKeys(
    "yes",
    false,
    "sovendus_settings",
    "{countryCode}_sovendus_activated",
    "{countryCode}_sovendus_trafficSourceNumber",
    "{countryCode}_sovendus_trafficMediumNumber",
    "{lang}_{countryCode}_sovendus_activated",
    "{lang}_{countryCode}_sovendus_trafficSourceNumber",
    "{lang}_{countryCode}_sovendus_trafficMediumNumber"
));
