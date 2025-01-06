<?php

class WC_Sovendus_Settings
{
    public static function add_section($sections)
    {
        $sections['wcsovendus'] = __('Sovendus Voucher Network & Checkout Benefits', 'wc-sovendus');
        return $sections;
    }

    public static function settings($settings, $current_section)
    {
        if ($current_section === 'wcsovendus') {
            $countries = [
                'AT' => 'Austria',
                'FR_BE' => 'Belgium French',
                'NL_BE' => 'Belgium Dutch',
                'DK' => 'Denmark',
                'FR' => 'France',
                'DE' => 'Germany',
                'IE' => 'Ireland',
                'IT' => 'Italy',
                'NL' => 'Netherlands',
                'NO' => 'Norway',
                'PL' => 'Poland',
                'ES' => 'Spain',
                'SE' => 'Sweden',
                'FR_CH' => 'Switzerland French',
                'DE_CH' => 'Switzerland German',
                'IT_CH' => 'Switzerland Italian',
                'UK' => 'United Kingdom'
            ];

            $sovendusSettings = [
                [
                    'name' => __('Sovendus Voucher Network & Checkout Benefits', 'wc-sovendus'),
                    'type' => 'title',
                    'desc' => __('Official Sovendus Voucher Network & Checkout Benefits Plugin for WooCommerce', 'wc-sovendus'),
                    'id' => 'title',
                ]
            ];

            foreach ($countries as $code => $country) {
                $sovendusSettings[] = [
                    'name' => "Enable Sovendus Banner for $country",
                    'desc_tip' => "This will enable the sovendus banner on the post checkout page",
                    'id' => "{$code}_sovendus_activated",
                    'type' => 'checkbox',
                    'css' => 'min-width:300px;',
                    'desc' => "Enable Sovendus Banner for $country",
                ];
                $sovendusSettings[] = [
                    'name' => "$country Traffic Source Number",
                    'desc_tip' => "The traffic source number is used to assign your store in the Sovendus system. You can find it in your integration documentation.",
                    'id' => "{$code}_sovendus_trafficSourceNumber",
                    'type' => 'number',
                    'desc' => "Enter the traffic source number from your integration documentation",
                ];
                $sovendusSettings[] = [
                    'name' => "$country Traffic Medium Number",
                    'desc_tip' => "The traffic medium number is used to assign your integration in the Sovendus system. You can find it in your integration documentation.",
                    'id' => "{$code}_sovendus_trafficMediumNumber",
                    'type' => 'number',
                    'desc' => "Enter the traffic medium number from your integration documentation",
                ];
                $sovendusSettings[] = [
                    'name' => "Settings for $country",
                    'type' => 'title',
                    'id' => "{$code}_sovendus_title",
                ];
            }

            $sovendusSettings[] = [
                'type' => 'sectionend',
                'id' => 'wcsovendus',
            ];

            return $sovendusSettings;
        } else {
            return $settings;
        }
    }
}