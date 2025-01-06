<?php

class WC_Sovendus_Helper
{
    public static function get_settings($countryCode)
    {
        switch ($countryCode) {
            case "DE":
                return self::get_country_settings('DE');
            case "AT":
                return self::get_country_settings('AT');
            case "NL":
                return self::get_country_settings('NL');
            case "CH":
                return self::get_multilang_country_settings('CH', ['de', 'fr', 'it']);
            case "FR":
                return self::get_country_settings('FR');
            case "IT":
                return self::get_country_settings('IT');
            case "IE":
                return self::get_country_settings('IE');
            case "GB":
                return self::get_country_settings('UK');
            case "DK":
                return self::get_country_settings('DK');
            case "SE":
                return self::get_country_settings('SE');
            case "ES":
                return self::get_country_settings('ES');
            case "BE":
                return self::get_multilang_country_settings('BE', ['nl', 'fr']);
            case "PL":
                return self::get_country_settings('PL');
            case "NO":
                return self::get_country_settings('NO');
            default:
                return array(false, 0, 0);
        }
    }

    private static function get_country_settings($countryCode)
    {
        $sovendusActive = get_option("{$countryCode}_sovendus_activated");
        $trafficSourceNumber = (int) get_option("{$countryCode}_sovendus_trafficSourceNumber");
        $trafficMediumNumber = (int) get_option("{$countryCode}_sovendus_trafficMediumNumber");
        return array(
            $sovendusActive === "yes" && $trafficSourceNumber && $trafficMediumNumber ? true : false,
            $trafficSourceNumber,
            $trafficMediumNumber,
        );
    }

    private static function get_multilang_country_settings($countryCode, $langs)
    {
        $sovendusActive = array();
        $trafficSourceNumber = array();
        $trafficMediumNumber = array();
        foreach ($langs as $lang) {
            $sovendusActive[$lang] = get_option("{$lang}_{$countryCode}_sovendus_activated");
            $trafficSourceNumber[$lang] = (int) get_option("{$lang}_{$countryCode}_sovendus_trafficSourceNumber");
            $trafficMediumNumber[$lang] = (int) get_option("{$lang}_{$countryCode}_sovendus_trafficMediumNumber");
        }
        return array($sovendusActive, $trafficSourceNumber, $trafficMediumNumber);
    }
}