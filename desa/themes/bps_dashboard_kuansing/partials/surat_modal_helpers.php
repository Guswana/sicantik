<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
if (!function_exists('dashboard_surat_modal_keywords')) {
    function dashboard_surat_modal_keywords()
    {
        return [
            'nikah kawin belum tercatat' => 'surat-nikah-belum-tercatat-modal',
            'pengantar nikah' => 'surat-pengantar-nikah-modal',
            'permohonan pindah' => 'surat-pindah-modal',
            'usaha' => 'surat-usaha-modal',
            'kurang mampu' => 'surat-kurang-mampu-modal',
            'penguburan' => 'surat-penguburan-modal',
            'kematian' => 'surat-kematian-modal',
            'ahli waris' => 'surat-ahli-waris-modal',
            'domisili' => 'surat-domisili-modal',
        ];
    }
}

if (!function_exists('dashboard_resolve_surat_modal_id')) {
    function dashboard_resolve_surat_modal_id($menu_name)
    {
        $menu_name = strtolower(trim(strip_tags((string) $menu_name)));

        foreach (dashboard_surat_modal_keywords() as $needle => $modal_id) {
            if ($needle !== '' && stripos($menu_name, $needle) !== false) {
                return $modal_id;
            }
        }

        return null;
    }
}
