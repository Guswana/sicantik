<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $modal_surat = [
    'id' => 'surat-kematian-modal',
    'judul' => 'Keterangan Kematian',
    'ringkasan' => 'Surat ini dipakai untuk melaporkan peristiwa kematian.',
    'persyaratan' => [
      'KK/KTP/Identitas Lain Individu yang meninggal dalam pdf',
      'KK/KTP/Identitas Lain Individu yang Melaporkan dalam pdf',
      'Surat Pernyataan Kematian dalam pdf',
      'Nomor yang bisa di hubungi',
    ],
    'catatan' => 'Silakan upload setiap dokumen persyaratan melalui link di bawah dan silakan
                  kunjungi kantor desa pada hari yang sudah ditentukan di jam pelayanan kerja.',
  ];
  require __DIR__ . '/surat_modal_template.php';
