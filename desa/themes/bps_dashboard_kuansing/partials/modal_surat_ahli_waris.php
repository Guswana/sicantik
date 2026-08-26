<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $modal_surat = [
    'id' => 'surat-ahli-waris-modal',
    'judul' => 'Surat Keterangan Ahli Waris',
    'ringkasan' => 'Surat ini dipakai untuk menerangkan daftar ahli waris yang sah sebelum pengurusan administrasi lanjutan.',
    'persyaratan' => [
      'KK/KTP Orang Tua dalam pdf',
      'KK/KTP Ahli Waris dalam pdf',
      'Surat Pernyataan Ahli Waris dalam pdf',
      'Nomor yang bisa di hubungi',
    ],
    'catatan' => 'Silakan upload setiap dokumen persyaratan melalui link di bawah dan silakan
                  kunjungi kantor desa pada hari yang sudah ditentukan di jam pelayanan kerja.',
  ];
  require __DIR__ . '/surat_modal_template.php';
