<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav role="navigation" aria-label="navigation" class="breadcrumb">
  <ol>
    <li><a href="<?= site_url() ?>">Beranda</a></li>
    <li aria-current="page">Galeri</li>
  </ol>
</nav>
<h1 class="text-h2">Album Galeri</h1>

<?php
  $gallery_cards = array_values(array_filter(is_array($w_gal ?? null) ? $w_gal : [], static function ($album) {
    return !empty($album['gambar']) && is_file(LOKASI_GALERI . 'kecil_' . $album['gambar']);
  }));
?>

<?php if(count($gallery_cards)) : ?>
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 main-content py-4">
    <?php foreach($gallery_cards as $album) : ?>
      <?php $link = IS_PREMIUM ? site_url('galeri/' . $album['id']) : site_url('first/sub_gallery/' . $album['id']) ?>
      <a href="<?= $link ?>" class="block overflow-hidden rounded-xl border border-blue-100 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
        <img src="<?= AmbilGaleri($album['gambar'], 'sedang') ?>" alt="<?= $album['nama'] ?>" class="h-52 w-full object-cover object-center" title="<?= $album['nama'] ?>">
        <div class="p-4">
          <p class="text-sm font-bold text-primary-200 leading-6"><?= $album['nama'] ?></p>
        </div>
      </a>
    <?php endforeach ?>
  </div>
<?php else : ?>
  <div class="alert text-primary-100">Maaf album galeri belum tersedia!</div>
<?php endif ?>
