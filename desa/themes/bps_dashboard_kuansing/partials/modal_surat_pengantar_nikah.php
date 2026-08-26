<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $modal_surat = [
    'id' => 'surat-pengantar-nikah-modal',
    'judul' => 'Surat Pengantar Nikah',
    'ringkasan' => 'Surat ini dipakai untuk pengantar administrasi pernikahan.',
    'persyaratan' => [
      'KK dan KTP Kedua Pihak yang Menikah digabung dalam satu file pdf',
      'Surat Pengantar dari Ninik Mamak Suku Masing-masing Pihak yang menikah dalam pdf',
      'Nomor yang bisa di hubungi',
    ],
    'catatan' => 'Silakan upload setiap dokumen persyaratan melalui link di bawah dan silakan
                  kunjungi kantor desa pada hari yang sudah ditentukan di jam pelayanan kerja.',
  ];
  require __DIR__ . '/surat_modal_template.php';
