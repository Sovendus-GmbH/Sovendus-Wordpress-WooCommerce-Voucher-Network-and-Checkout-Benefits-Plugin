<?php

defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');

class Sovendus_Deactivator
{
    public static function deactivate($network_wide)
    {
        if (function_exists('is_multisite') && is_multisite()) {
            if ($network_wide) {
                $sites = get_sites();
                foreach ($sites as $site) {
                    switch_to_blog((int) $site->blog_id);
                    self::single_deactivate();
                    restore_current_blog();
                }
            } else {
                self::single_deactivate();
            }
        } else {
            self::single_deactivate();
        }
    }

    private static function single_deactivate()
    {
        // In case we need to run code on deactivation
    }
}
