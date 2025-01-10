<?php

require_once plugin_dir_path(__FILE__) . '../sovendus-plugins-commons/settings/get-settings-helper.php';

define(constant_name: 'SETTINGS_KEYS', value: new SettingsKeys(
    active_value: "yes",
    uses_lower_case: false,
    newSettingsKey: "sovendus_settings",
    active: "{countryCode}_sovendus_activated",
    trafficSourceNumber: "{countryCode}_sovendus_trafficSourceNumber",
    trafficMediumNumber: "{countryCode}_sovendus_trafficMediumNumber",
    multiLangCountryActive: "{lang}_{countryCode}_sovendus_activated",
    multiLangCountryTrafficSourceNumber: "{lang}_{countryCode}_sovendus_trafficSourceNumber",
    multiLangCountryTrafficMediumNumber: "{lang}_{countryCode}_sovendus_trafficMediumNumber",
));
