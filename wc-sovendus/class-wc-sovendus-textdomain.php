<?php

class WC_Sovendus_Textdomain
{
    public static function load_textdomain()
    {
        load_plugin_textdomain('wc-sovendus', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
}