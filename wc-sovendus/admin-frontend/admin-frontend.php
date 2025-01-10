<?php

require_once plugin_dir_path(file: __FILE__) . '../settings/get-settings.php';

class WC_Sovendus_Settings
{
    public static function add_section($sections)
    {
        $sections['wcsovendus'] = __('Sovendus App', 'wc-sovendus');
        return $sections;
    }

    public static function settings($settings, $current_section)
    {
        if ($current_section === 'wcsovendus') {
            echo '<div id="sovendus-settings-container"></div>';
            return [];
        } else {
            return $settings;
        }
    }
}

function enqueue_sovendus_react_scripts($hook)
{
    if ($hook !== 'toplevel_page_wc-sovendus') {
        return;
    }
    wp_enqueue_style(
        'frontend_react_style',
        plugin_dir_url(__FILE__) . '../dist/style.css',
        array(), // Dependencies, if any
        '1.0.0'
    );
    wp_enqueue_script(
        'frontend_react_loader',
        plugins_url('../dist/frontend_react_loader.js', __FILE__),
        ['react', 'react-dom'],
        null,
        true
    );

    wp_localize_script('frontend_react_loader', 'sovendusSettings', [
        'settings' => get_sovendus_settings(countryCode: null),
        'ajaxurl' => "/wp-json/sovendus/v1/save-settings",
        'nonce' => wp_create_nonce('wp_rest'),
    ]);
}