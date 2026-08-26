<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $modal_surat = [
    'id' => 'surat-penguburan-modal',
    'judul' => 'Keterangan Penguburan',
    'ringkasan' => 'Surat ini dipakai untuk melaporkan penguburan jenazah.',
    'persyaratan' => [
      'KK/KTP/Identitas Lain Individu yang di kubur dalam pdf',
      'KK/KTP/Identitas Lain Individu yang Melaporkan dalam pdf',
      'Surat Pernyataan Penguburan dalam pdf',
      'Nomor yang bisa di hubungi',
    ],
    'catatan' => 'Silakan upload setiap dokumen persyaratan melalui link di bawah dan silakan
                  kunjungi kantor desa pada hari yang sudah ditentukan di jam pelayanan kerja.',
  ];
  require __DIR__ . '/surat_modal_template.php';
