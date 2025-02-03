<?php

defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');

require_once __DIR__ . '/../settings/get-settings.php';

function enqueue_sovendus_react_scripts($hook)
{
    if ($hook !== 'toplevel_page_wc-sovendus') {
        return;
    }
    wp_enqueue_script(
        'frontend_react_loader',
        // source is in admin-frontend/frontend_react_loader.ts
        plugins_url('../dist/frontend_react_loader.js', __FILE__),
        ['react', 'react-dom'],
        SOVENDUS_VERSION,
        true
    );
    wp_localize_script('frontend_react_loader', 'sovendusSettings', [
        'settings' => get_sovendus_settings(null),
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('save_sovendus_settings_nonce'),
    ]);
}
