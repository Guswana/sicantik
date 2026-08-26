<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $modal_surat = [
    'id' => 'surat-pindah-modal',
    'judul' => 'Surat Permohonan Pindah',
    'ringkasan' => 'Surat ini dipakai untuk mengajukan kepindahan individu atau keluarga.',
    'persyaratan' => [
      'KK/KTP Individu/Keluarga yang akan Pindah dalam pdf',
      'Surat Pernyataan Permohonan Pindah dalam pdf',
      'Nomor yang bisa di hubungi',
    ],
    'catatan' => 'Silakan upload setiap dokumen persyaratan melalui link di bawah dan silakan
                  kunjungi kantor desa pada hari yang sudah ditentukan di jam pelayanan kerja.',
  ];
  require __DIR__ . '/surat_modal_template.php';
