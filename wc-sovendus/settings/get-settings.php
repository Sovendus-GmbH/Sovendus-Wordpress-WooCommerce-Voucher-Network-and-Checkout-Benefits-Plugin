<?php

require_once plugin_dir_path(file: __FILE__) . '../sovendus-plugins-commons/settings/app-settings.php';
require_once plugin_dir_path(file: __FILE__) . '../sovendus-plugins-commons/settings/sovendus-countries.php';

class WC_Sovendus_Helper
{
    public static function get_settings(string|null $countryCode): Sovendus_App_Settings
    {
        $settingsJson = get_option(option: "sovendus_settings");
        if ($settingsJson) {
            return Sovendus_App_Settings::fromJson($settingsJson);
        } else {
            $settings = new Sovendus_App_Settings(
                voucherNetwork: new VoucherNetwork(),
                optimize: new Optimize(
                    useGlobalId: true,
                    globalId: null,
                    globalEnabled: false,
                    countrySpecificIds: [],
                ),
                checkoutProducts: false,
            );
            $countries = $countryCode
                ? [$countryCode => LANGUAGES_BY_COUNTRIES[$countryCode]]
                : LANGUAGES_BY_COUNTRIES;
            foreach ($countries as $countryKey => $countryData) {
                $countriesLanguages = array_keys($countryData);
                $settings->voucherNetwork->addCountry(
                    countryCode: CountryCodes::from($countryKey),
                    country: new VoucherNetworkCountry(
                        languages: count(LANGUAGES_BY_COUNTRIES[$countryKey]) > 1
                        ? self::get_multilang_country_settings(countryCode: $countryKey, langs: $countriesLanguages)
                        : self::get_country_settings(countryCode: $countryKey, lang: $countriesLanguages[0])
                    )
                );
            }
            return $settings;
        }
    }

    private static function get_country_settings($countryCode, $lang)
    {
        $sovendusActive = get_option(option: "{$countryCode}_sovendus_activated");
        $trafficSourceNumber = (int) get_option(option: "{$countryCode}_sovendus_trafficSourceNumber");
        $trafficMediumNumber = (int) get_option(option: "{$countryCode}_sovendus_trafficMediumNumber");
        return [
            $lang => new Language(
                enabled: $sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
                trafficSourceNumber: $trafficSourceNumber,
                trafficMediumNumber: $trafficMediumNumber,
            )
        ];
    }

    private static function get_multilang_country_settings($countryCode, $langs)
    {
        $languageSettings = [];
        foreach ($langs as $lang) {
            $languageSettings[$lang] = new Language(
                enabled: get_option(option: "{$lang}_{$countryCode}_sovendus_activated"),
                trafficSourceNumber: (int) get_option(option: "{$lang}_{$countryCode}_sovendus_trafficSourceNumber"),
                trafficMediumNumber: (int) get_option(option: "{$lang}_{$countryCode}_sovendus_trafficMediumNumber"),
            );
        }
        return $languageSettings;
    }
}