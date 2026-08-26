<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Cari file .env dengan traversal naik secara aman
$mapboxKey = '';
$currentDir = __DIR__;
$maxLevels = 10;

for ($i = 0; $i < $maxLevels; $i++) {
    $envPath = $currentDir . DIRECTORY_SEPARATOR . '.env';
    
    if (file_exists($envPath)) {
        $envLines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($envLines as $line) {
            $trimmedLine = trim($line);
            if (strpos($trimmedLine, 'MAPBOX_PUBLIC_TOKEN=') === 0) {
                list(, $value) = explode('=', $trimmedLine, 2);
                $mapboxKey = trim($value);
                break 2;
            }
        }
    }
    
    $currentDir = dirname($currentDir);
}

return [
    // Ambil dari environment variable MAPBOX_PUBLIC_TOKEN.
    // Jangan isi token langsung di file ini agar aman dari commit.
    'mapbox_key' => trim($mapboxKey),

    // Halaman referensi atribusi Mapbox
    'mapbox_about_url' => 'https://www.mapbox.com/about/maps',
];
