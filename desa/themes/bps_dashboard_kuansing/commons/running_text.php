<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $wilayah_parts = [];

  if (!empty($desa['nama_desa'])) {
    $wilayah_parts[] = ucwords($this->setting->sebutan_desa) . ' ' . ucwords($desa['nama_desa']);
  }

  if (!empty($desa['nama_kecamatan'])) {
    $wilayah_parts[] = ucwords($this->setting->sebutan_kecamatan) . ' ' . ucwords($desa['nama_kecamatan']);
  }

  if (!empty($desa['nama_kabupaten'])) {
    $wilayah_parts[] = ucwords($this->setting->sebutan_kabupaten) . ' ' . ucwords($desa['nama_kabupaten']);
  }

  $running_text = 'Selamat Datang di Website Resmi Pemerintahan';

  if (!empty($wilayah_parts)) {
    $running_text .= ' ' . implode(' ', $wilayah_parts);
  }
?>

<section class="dashboard-running-text" aria-label="Pesan sambutan website">
  <div class="dashboard-running-text-track">
    <span><?= html_escape($running_text) ?></span>
    <span aria-hidden="true"><?= html_escape($running_text) ?></span>
    <span aria-hidden="true"><?= html_escape($running_text) ?></span>
  </div>
</section>
