<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $modal_surat = [
    'id' => 'surat-domisili-modal',
    'judul' => 'Surat Keterangan Domisili',
    'ringkasan' => 'Surat ini dipakai untuk menerangkan daftar penduduk yang tinggal di wilayah desa.',
    'persyaratan' => [
      'KK/KTP/Identitas Lain dalam pdf',
      'Surat Pernyataan Domisili yang di Ketahui RT dan Kepala Dusun dalam pdf',
      'Nomor yang bisa di hubungi',
    ],
    'catatan' => 'Silakan upload setiap dokumen persyaratan melalui link di bawah dan silakan
                  kunjungi kantor desa pada hari yang sudah ditentukan di jam pelayanan kerja.',
  ];
  require __DIR__ . '/surat_modal_template.php';
