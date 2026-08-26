<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php $url = site_url('artikel/' . buat_slug($post)) ?>
<?php $abstract = potong_teks(strip_tags($post['isi']), 300) ?>
<?php $jumlah_komentar = $this->db->where('id_artikel', $post['id'])->count_all_results('komentar') ?>
<?php $image = ($post['gambar'] && is_file(LOKASI_FOTO_ARTIKEL . 'sedang_' . $post['gambar'])) ?
  AmbilFotoArtikel($post['gambar'], 'sedang') :
  gambar_desa($desa['logo']);
?>

<article class="dashboard-article-card max-w-full w-full bg-white p-4 lg:p-5">
  <div class="dashboard-article-grid">
    <figure class="dashboard-article-media">
      <img src="<?= $image ?>" alt="<?= $post['judul'] ?>" class="dashboard-article-image">
    </figure>
    <div class="dashboard-article-body">
      <a href="<?= $url ?>" class="dashboard-article-title text-h5"><?= potong_teks($post['judul'], 80) ?><?= strlen($post['judul']) > 80 ? '...' : '' ?></a>
      <p class="dashboard-article-excerpt"><?= potong_teks($abstract, 100) ?><?= strlen($abstract) > 100 ? '...' : '' ?></p>
      <ul class="dashboard-article-meta">
        <li><i class="fas fa-calendar-alt mr-1"></i> <?= tgl_indo($post['tgl_upload']) ?></li>
        <li><i class="fas fa-user mr-1"></i> <?= $post['owner'] ?></li>
        <?php if ($post['kategori']) : ?>
          <li><i class="fas fa-bookmark mr-1"></i> <?= $post['kategori'] ?></li>
        <?php endif ?>
        <li><i class="fas fa-eye mr-1"></i> <?= hit($post['hit']) ?> dibaca</li>
        <li><i class="fas fa-comments mr-1"></i> <?= number_format((int) $jumlah_komentar, 0, ',', '.') ?> komentar</li>
      </ul>
      <a href="<?= $url ?>" class="dashboard-article-readmore">Baca detail <i class="fas fa-arrow-right ml-2 text-xs"></i></a>
    </div>
  </div>
</article>
