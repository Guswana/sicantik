<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $gallery_items = array_values(array_filter(is_array($w_gal ?? null) ? $w_gal : [], static function ($data) {
    return !empty($data['gambar']) && is_file(LOKASI_GALERI . 'sedang_' . $data['gambar']);
  }));
?>

<div class="box box-primary box-solid">
  <div class="box-header">
    <h3 class="box-title">
      <a href="<?= site_url('first/gallery');?>"><i class="fas fa-camera mr-1 mr-1"></i><?= $judul_widget ?></a>
    </h3>
  </div>
  <div class="box-body">
    <?php if ($gallery_items) : ?>
      <div class="dashboard-gallery-widget owl-carousel" data-itemsnumber="1">
        <?php foreach ($gallery_items as $data): ?>
          <div class="dashboard-gallery-widget__slide">
            <a href="<?= site_url("first/sub_gallery/{$data['id']}"); ?>" class="dashboard-gallery-widget__link" title="<?= 'Album : ' . $data['nama'] ?>">
              <img src="<?= AmbilGaleri($data['gambar'], 'sedang') ?>" alt="<?= 'Album : ' . $data['nama'] ?>" class="dashboard-gallery-widget__image">
              <span class="dashboard-gallery-widget__caption"><?= $data['nama'] ?></span>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <p class="text-sm text-gray-500">Maaf album galeri belum tersedia!</p>
    <?php endif; ?>
  </div>
</div>
