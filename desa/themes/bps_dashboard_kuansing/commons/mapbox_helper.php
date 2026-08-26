<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('bps_dashboard_kuansing_map_config')) {
    function bps_dashboard_kuansing_map_config()
    {
        static $config;

        if ($config !== null) {
            return $config;
        }

        $config = [];
        $configPath = dirname(__DIR__) . '/config/map.php';

        if (is_file($configPath)) {
            $loadedConfig = require $configPath;

            if (is_array($loadedConfig)) {
                $config = $loadedConfig;
            }
        }

        return $config;
    }
}

if (! function_exists('bps_dashboard_kuansing_mapbox_key')) {
    function bps_dashboard_kuansing_mapbox_key()
    {
        $config = bps_dashboard_kuansing_map_config();
        $key = trim((string) ($config['mapbox_key'] ?? ''));
        
        // Fallback ke setting global (sesuai pola tema lain)
        if (empty($key) && function_exists('setting')) {
            $key = trim((string) setting('mapbox_key'));
        }
        
        return $key;
    }
}

if (! function_exists('bps_dashboard_kuansing_mapbox_about_url')) {
    function bps_dashboard_kuansing_mapbox_about_url()
    {
        $config = bps_dashboard_kuansing_map_config();
        $aboutUrl = trim((string) ($config['mapbox_about_url'] ?? ''));

        return $aboutUrl !== '' ? $aboutUrl : 'https://www.mapbox.com/about/maps';
    }
}
