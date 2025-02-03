<?php

defined('ABSPATH') || exit('WordPress Error! Opening plugin file directly');

class Sovendus_Activator
{
    public static function activate($network_wide)
    {
        if (function_exists('is_multisite') && is_multisite()) {
            if ($network_wide) {
                $sites = get_sites();
                foreach ($sites as $site) {
                    switch_to_blog((int) $site->blog_id);
                    self::single_activate();
                    restore_current_blog();
                }
            } else {
                self::single_activate();
            }
        } else {
            self::single_activate();
        }
    }

    private static function single_activate()
    {
        // In case we need to run code on activation
    }
}
