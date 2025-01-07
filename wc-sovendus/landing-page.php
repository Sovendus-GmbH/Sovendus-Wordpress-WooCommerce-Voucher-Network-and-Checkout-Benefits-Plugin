<?php

require_once plugin_dir_path(__FILE__) . 'sovendus-plugins-commons/page-scripts/landing-page/sovendus-page.php';


/**
 * Add landing page script
 */
function wordpress_sovendus_page()
{

    echo sovendus_landing_page();
}