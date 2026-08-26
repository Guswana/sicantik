<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $modal_surat = [
    'id' => 'surat-kurang-mampu-modal',
    'judul' => 'Keterangan Kurang Mampu',
    'ringkasan' => 'Surat ini dipakai untuk menerangkan kondisi ekonomi kurang mampu.',
    'persyaratan' => [
      'KK/KTP/Identitas Lain pelapor dalam pdf',
      'Surat Pernyataan Kurang Mampu dalam pdf',
      'Nomor yang bisa di hubungi',
    ],
    'catatan' => 'Silakan upload setiap dokumen persyaratan melalui link di bawah dan silakan
                  kunjungi kantor desa pada hari yang sudah ditentukan di jam pelayanan kerja.',
  ];
  require __DIR__ . '/surat_modal_template.php';
