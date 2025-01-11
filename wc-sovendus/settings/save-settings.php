<?php

function save_sovendus_settings()
{
    error_log('save_sovendus_settings called');
    if (!check_ajax_referer('save_sovendus_settings_nonce', 'security', false)) {
        error_log('Nonce check failed');
        wp_send_json_error('Nonce check failed');
        return;
    }

    $settings = isset($_POST['settings']) ? json_decode(stripslashes($_POST['settings']), true) : array();
    error_log('Settings: ' . print_r($settings, true));

    $validated_settings = Sovendus_App_Settings::fromJson($settings);

    update_option('sovendus_settings', wp_json_encode($validated_settings));

    wp_send_json_success($settings);
}
