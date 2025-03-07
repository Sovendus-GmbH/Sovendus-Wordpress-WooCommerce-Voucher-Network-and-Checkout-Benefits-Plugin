<?php

defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');

/**
 * @return string
 */
function get_sovendus_settings()
{
    $data = json_decode(get_option('sovendus_settings'), true);
    if (json_last_error() === JSON_ERROR_NONE) {
        return $data;
    } else {
        // this should never happen
        return [];
    }
}
