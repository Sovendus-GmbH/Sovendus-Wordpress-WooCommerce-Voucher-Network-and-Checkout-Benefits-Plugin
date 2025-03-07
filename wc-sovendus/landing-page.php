<?php
defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');

require_once __DIR__ . '/settings/get-settings.php';
require_once __DIR__ . '/settings/integration-data-helpers.php';


/**
 * Add landing page script
 */
function wordpress_sovendus_page()
{
    $country = null;
    $language = null;

    $js_file_url = plugins_url('dist/sovendus-page.js', __FILE__);
    wp_register_script('sovendus_page_script', $js_file_url, [], SOVENDUS_VERSION, true);
    wp_localize_script('sovendus_page_script', 'sovPageConfig', [
        'settings' => get_sovendus_settings(),
        'integrationType' => getIntegrationType(PLUGIN_NAME, SOVENDUS_VERSION),
        'country' => $country,
        'language' => $language,
    ]);
    wp_enqueue_script('sovendus_page_script');
}
