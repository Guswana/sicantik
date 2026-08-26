<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$fix_whatsapp_link = static function ($nama, $link) {
    $nama_lower = strtolower(trim(strip_tags($nama)));
    if ($nama_lower === 'whatsapp' && preg_match('/instagram\.com\/(\d+)/', $link, $m)) {
        return 'https://api.whatsapp.com/send?phone=62' . ltrim($m[1], '0');
    }
    if ($nama_lower === 'whatsapp' && preg_match('/(\d{10,15})/', $link, $m) && ! str_contains($link, 'whatsapp.com')) {
        return 'https://api.whatsapp.com/send?phone=62' . ltrim($m[1], '0');
    }
    return $link;
};
?>

<div class="box box-primary box-solid">
  <div class="box-header">
    <h3 class="box-title"><i class="fas fa-globe mr-1"></i><?= $judul_widget ?></h3>
  </div>
  <div class="box-body flex gap-2">
    <?php foreach ($sosmed As $data): ?>
    <?php if (!empty($data["link"])): ?>
    <?php $fixed_link = $fix_whatsapp_link($data['nama'], $data['link']); ?>
    <a href="<?= $fixed_link?>" target="_blank">
      <img src="<?= base_url("assets/front/{$data['gambar']}") ?>" alt="<?= $data['nama'] ?>"
        style="width:50px;height:50px;" />
    </a>
    <?php endif; ?>
    <?php endforeach; ?>
  </div>
</div>