<?php

function save_sovendus_settings()
{
    if (!check_ajax_referer('save_sovendus_settings_nonce', 'security', false)) {
        wp_send_json_error('Nonce check failed');
        return;
    }
    $settings = isset($_POST['settings']) ? json_decode(sanitize_text_field(wp_unslash($_POST['settings'])), true) : array();
    $validated_settings = Sovendus_App_Settings::fromJson($settings);
    update_option('sovendus_settings', wp_json_encode($validated_settings));
    wp_send_json_success($settings);
}
