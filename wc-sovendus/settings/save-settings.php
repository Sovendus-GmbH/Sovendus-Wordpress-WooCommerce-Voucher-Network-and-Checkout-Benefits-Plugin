<?php
function save_settings()
{
    error_log("Sovendus: save_sovendus_settings called");

    try {
        error_log("Sovendus: Request method: " . $_SERVER['REQUEST_METHOD']);
        error_log("Sovendus: Raw input starting");
        $raw_input = file_get_contents('php://input');
        error_log("Sovendus: Raw input: " . $raw_input);

        if (!current_user_can('manage_woocommerce')) {
            throw new Exception('Unauthorized access');
        }

        if (!$raw_input) {
            throw new Exception('No input received');
        }

        $data = json_decode($raw_input, true);
        error_log("Sovendus: Decoded data: " . print_r($data, true));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('JSON parse error: ' . json_last_error_msg());
        }

        if (!isset($data['settings'])) {
            throw new Exception('Missing settings in payload');
        }
        
        $success = update_option('sovendus_settings', wp_json_encode($data['settings']));
        error_log("Sovendus: Update result: " . ($success ? 'success' : 'failed'));

        if (!$success) {
            throw new Exception('Failed to save settings to database');
        }

        wp_send_json_success($data['settings']);

    } catch (Exception $e) {
        error_log("Sovendus Error: " . $e->getMessage());
        wp_send_json_error($e->getMessage());
    }
}