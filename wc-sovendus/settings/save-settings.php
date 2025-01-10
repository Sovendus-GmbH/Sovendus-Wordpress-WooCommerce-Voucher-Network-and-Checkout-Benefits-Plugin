<?php


function register_saving_api_endpoint() {
    register_rest_route('sovendus/v1', '/save-settings', array(
        'methods' => 'POST',
        'callback' => 'save_sovendus_settings',
        'permission_callback' => '__return_true',
    ));
}



function save_sovendus_settings(WP_REST_Request $request)
{
    $settings = $request->get_param('settings');
    if (update_option('sovendus_settings', wp_json_encode($settings))) {
        return new WP_REST_Response('Settings saved successfully', 200);
    } else {
        return new WP_REST_Response('Failed to save settings', 500);
    }
}