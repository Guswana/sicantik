<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $title = (!empty($judul_kategori))? $judul_kategori: 'Artikel Terkini';
  $slug = 'terkini';
  if(is_array($title)){
    $slug = $title['slug'];
    $title = $title['kategori'];
  }

  $jumlah_artikel = isset($artikel) && is_array($artikel) ? count($artikel) : 0;
  $jumlah_slider = isset($slider_gambar['gambar']) && is_array($slider_gambar['gambar']) ? count($slider_gambar['gambar']) : 0;
  $jumlah_widget = isset($w_cos) && is_array($w_cos) ? count($w_cos) : 0;

  $alamat_parts = [];
  if (!empty($desa['alamat_kantor'])) {
    $alamat_parts[] = ucwords($desa['alamat_kantor']);
  }
  if (!empty($desa['nama_kecamatan'])) {
    $alamat_parts[] = ucfirst($this->setting->sebutan_kecamatan_singkat) . ' ' . ucwords($desa['nama_kecamatan']);
  }
  if (!empty($desa['nama_kabupaten'])) {
    $alamat_parts[] = ucfirst($this->setting->sebutan_kabupaten_singkat) . ' ' . ucwords($desa['nama_kabupaten']);
  }
  if (!empty($desa['nama_propinsi'])) {
    $alamat_parts[] = 'Provinsi ' . ucwords($desa['nama_propinsi']);
  }
  if (!empty($desa['kode_pos'])) {
    $alamat_parts[] = $desa['kode_pos'];
  }

  $alamat_lengkap = implode(', ', $alamat_parts);
  $brand_background = !empty($latar_website) ? $latar_website : gambar_desa($desa['logo']);
  $brand_background_position = 'center';

  $brand_background_overrides = [
    'desa/pengaturan/bps_dashboard_kuansing/images/brand-background.jpg',
    'desa/pengaturan/bps_dashboard_kuansing/images/brand-background.jpeg',
    'desa/pengaturan/bps_dashboard_kuansing/images/brand-background.png',
    'desa/pengaturan/bps_dashboard_kuansing/images/brand-background.webp',
  ];

  foreach ($brand_background_overrides as $brand_background_override) {
    if (is_file(FCPATH . $brand_background_override)) {
      $brand_background = base_url($brand_background_override);
      $brand_background_position = '28% center';
      break;
    }
  }

  $show_highlight = empty($cari)
    && isset($slider_gambar['gambar'])
    && is_array($slider_gambar['gambar'])
    && count($slider_gambar['gambar']) > 0
    && $this->uri->segment(2) != 'kategori'
    && ($this->uri->segment(2) !== 'index' && $this->uri->segment(1) !== 'index');
  $is_article_category_page = $this->uri->segment(1) === 'artikel' && $this->uri->segment(2) === 'kategori';

?>
<div class="container mx-auto lg:px-4 px-3 my-5 dashboard-content-wrap dashboard-homepage text-gray-700">
  <div class="dashboard-main-grid">
    <?php $this->load->view($folder_themes .'/partials/left_sidebar') ?>

    <main class="dashboard-center-column">
      <section class="dashboard-mobile-brand">
        <section class="dashboard-left-brand" style="background-image: url(<?= html_escape($brand_background) ?>); background-position: <?= html_escape($brand_background_position) ?>;">
          <div class="dashboard-left-brand-overlay"></div>
          <div class="dashboard-left-brand-content">
            <img src="<?= gambar_desa($desa['logo']) ?>" alt="Logo <?= NAMA_DESA ?>" class="dashboard-left-logo">
            <h4 class="dashboard-left-title"><?= NAMA_DESA ?></h4>
            <p class="dashboard-left-subtitle"><?= $alamat_lengkap ?: ucfirst($this->setting->sebutan_kecamatan_singkat) . ' ' . ucwords($desa['nama_kecamatan']) ?></p>
          </div>
        </section>
      </section>

      <section class="dashboard-mobile-search">
        <form action="<?= site_url() ?>" role="form" class="relative dashboard-search-form">
          <i class="fas fa-search absolute top-1/2 left-0 transform -translate-y-1/2 z-10 px-3 text-gray-500"></i>
          <input type="text" name="cari" class="form-input px-10 w-full h-12 bg-white relative inline-block dashboard-search-input" placeholder="Cari layanan, berita, atau data desa...">
        </form>
      </section>

      <?php $this->load->view($folder_themes . '/commons/running_text') ?>

      <?php if (!$is_article_category_page) : ?>
        <?php
          $this->load->view($folder_themes . '/widgets/infografis', [
            'judul_widget' => 'Infografis',
          ]);
        ?>

        <section class="dashboard-stat-grid">
          <article class="dashboard-stat-card">
            <span class="dashboard-stat-label">Artikel Ditampilkan</span>
            <strong class="dashboard-stat-value"><?= number_format($jumlah_artikel, 0, ',', '.') ?></strong>
            <span class="dashboard-stat-desc">Publikasi terbaru pada halaman aktif</span>
          </article>
          <article class="dashboard-stat-card">
            <span class="dashboard-stat-label">Slider Beranda</span>
            <strong class="dashboard-stat-value"><?= number_format($jumlah_slider, 0, ',', '.') ?></strong>
            <span class="dashboard-stat-desc">Visual utama untuk informasi prioritas</span>
          </article>
          <article class="dashboard-stat-card">
            <span class="dashboard-stat-label">Widget Aktif</span>
            <strong class="dashboard-stat-value"><?= number_format($jumlah_widget, 0, ',', '.') ?></strong>
            <span class="dashboard-stat-desc">Panel layanan dan data pendukung</span>
          </article>
        </section>
      <?php endif; ?>

      <?php if($show_highlight) : ?>
        <section class="dashboard-highlight-grid">
          <div class="dashboard-highlight-slider">
            <?php $this->load->view($folder_themes .'/partials/slider') ?>
          </div>
        </section>
      <?php endif; ?>


      <div class="dashboard-section-head">
        <h3 class="text-h4 text-primary-200"><?= $title ?></h3>
        <a href="<?= site_url('arsip') ?>" class="text-sm dashboard-link">Indeks <i class="fas fa-chevron-right ml-1"></i></a>
      </div>

      <?php if($artikel) : ?>
        <div class="dashboard-article-list">
          <?php foreach($artikel as $post) : ?>
            <?php $data['post'] = $post ?>
            <?php $this->load->view($folder_themes .'/partials/article_list', $data) ?>
          <?php endforeach ?>
        </div>
        <?php $use_direct_paging = $paging_page === 'index' || ($paging_page && IS_PREMIUM && $this->uri->segment(2) === 'kategori') ?>
        <?php $data['paging_page'] = $use_direct_paging ? $paging_page : 'first/'.$paging_page ?>
        <div class="pagination space-y-1 flex-wrap w-full">
          <?php $this->load->view($folder_themes .'/commons/paging', $data) ?>
        </div>
      <?php else : ?>
        <?php $data['title'] = $title ?>
        <?php $this->load->view($folder_themes .'/partials/empty_article', $data) ?>
      <?php endif ?>
    </main>

    <aside class="dashboard-right-column dashboard-sidebar-panel">
      <?php $this->load->view($folder_themes .'/partials/sidebar') ?>
    </aside>
  </div>
</div>
