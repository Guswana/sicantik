<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $dashboard_menu = menu_tema() ?: [];
  $left_menu_groups = $dashboard_menu;
  if (!is_array($left_menu_groups) || count($left_menu_groups) === 0) {
    $left_menu_groups = [
      ['nama' => 'Profil Desa', 'link_url' => site_url('first'), 'childrens' => []],
      ['nama' => 'Pemerintahan Desa', 'link_url' => site_url('pemerintah-desa'), 'childrens' => []],
      ['nama' => 'Pembangunan Desa', 'link_url' => site_url('pembangunan'), 'childrens' => []],
      ['nama' => 'Publikasi', 'link_url' => site_url('arsip'), 'childrens' => []],
    ];
  }

  $current_host = parse_url(site_url(), PHP_URL_HOST) ?: '';

  $is_external_link = static function ($link, $current_host) {
    if (preg_match('~^(?:https?:)?//~i', $link)) {
      $parsed_host = parse_url($link, PHP_URL_HOST) ?: '';
      if ($parsed_host && $current_host && strcasecmp($parsed_host, $current_host) !== 0) {
        return true;
      }
    }
    return false;
  };

  $normalize_menu_link = static function ($link, $menu_name = '') use ($current_host) {
    $link = trim((string) $link);
    $menu_name = strtolower(trim(strip_tags((string) $menu_name)));

    if ($menu_name === 'prestasi desa') {
      return site_url('artikel/kategori/prestasi-desa');
    }

    $query = '';

    if ($link === '' || $link === '#!') {
      return '#!';
    }

    if (strpos($link, 'mailto:') === 0 || strpos($link, 'tel:') === 0 || strpos($link, '#') === 0) {
      return $link;
    }

    if (preg_match('~^(?:https?:)?//~i', $link)) {
      $parsed_host = parse_url($link, PHP_URL_HOST) ?: '';
      $parsed_path = parse_url($link, PHP_URL_PATH) ?: '';
      $parsed_query = parse_url($link, PHP_URL_QUERY) ?: '';

      if ($parsed_host && $current_host && strcasecmp($parsed_host, $current_host) === 0 && $parsed_path !== '') {
        $link = ltrim($parsed_path, '/');
        $query = $parsed_query;
      } else {
        return $link;
      }
    }

    if ($current_host && stripos($link, $current_host . '/') === 0) {
      $link = substr($link, strlen($current_host) + 1);
    }

    $link = preg_replace('~^/?index\.php/~i', '', $link);
    $link = ltrim($link, '/');

    if ($link === '') {
      return site_url();
    }

    $legacy_link_patterns = [
      '~^artikel/\d+$~i',
      '~^kategori/\d+$~i',
      '~^data-suplemen/\d+$~i',
      '~^data-kelompok/\d+$~i',
      '~^data-lembaga/\d+$~i',
      '~^statistik/[^/]+$~i',
    ];

    foreach ($legacy_link_patterns as $pattern) {
      if (preg_match($pattern, $link)) {
        return menu_slug($link);
      }
    }

    return site_url($link . ($query ? '?' . $query : ''));
  };

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
    'desa/themes/bps_dashboard_kuansing/assets/images/brand-background.jpg',
  ];

  foreach ($brand_background_overrides as $brand_background_override) {
    if (is_file(FCPATH . $brand_background_override)) {
      $brand_background = base_url($brand_background_override);
      $brand_background_position = '28% center';
      break;
    }
  }
?>

<aside class="dashboard-left-column">
  <div class="dashboard-left-column-scroll">
    <section class="dashboard-left-brand" style="background-image: url(<?= html_escape($brand_background) ?>); background-position: <?= html_escape($brand_background_position) ?>;">
      <div class="dashboard-left-brand-overlay"></div>
      <div class="dashboard-left-brand-content">
        <img src="<?= gambar_desa($desa['logo']) ?>" alt="Logo <?= NAMA_DESA ?>" class="dashboard-left-logo">
        <h4 class="dashboard-left-title"><?= NAMA_DESA ?></h4>
        <p class="dashboard-left-subtitle"><?= $alamat_lengkap ?: ucfirst($this->setting->sebutan_kecamatan_singkat) . ' ' . ucwords($desa['nama_kecamatan']) ?></p>
      </div>
    </section>

    <section class="dashboard-left-accordion">
      <?php foreach($left_menu_groups as $index => $menu): ?>
        <?php $children = $menu['childrens'] ?? [] ?>
        <?php $has_children = count($children) > 0 ?>

        <?php if($has_children): ?>
          <div class="dashboard-accordion-item" x-data="{open: false}">
            <button type="button" class="dashboard-accordion-btn" @click="open = !open">
              <span><?= strip_tags($menu['nama']) ?></span>
              <i class="fas fa-chevron-down text-xs" :class="{'rotate-180': open}"></i>
            </button>
            <ul class="dashboard-accordion-list" x-show="open" x-transition>
              <?php foreach($children as $child): ?>
                <?php $child_link = $normalize_menu_link($child['link_url'] ?? '#!', $child['nama'] ?? '') ?>
                <?php $child_name = trim(strip_tags((string) ($child['nama'] ?? ''))) ?>
                <?php $child_modal_id = function_exists('dashboard_resolve_surat_modal_id') ? dashboard_resolve_surat_modal_id($child_name) : null ?>
                <?php $child_target = $is_external_link($child['link_url'] ?? '', $current_host) ? ' target="_blank"' : '' ?>
                <li>
                  <?php if ($child_modal_id) : ?>
                    <button type="button" class="dashboard-sub-link dashboard-sub-link--button" onclick="dashboardOpenModal(event, '<?= $child_modal_id ?>')"><?= $child_name ?></button>
                  <?php else : ?>
                    <a href="<?= $child_link ?>"<?= $child_target ?>><?= $child_name ?></a>
                  <?php endif ?>
                </li>
                <?php if(!empty($child['childrens'])): ?>
                  <?php foreach($child['childrens'] as $subchild): ?>
                    <?php $subchild_link = $normalize_menu_link($subchild['link_url'] ?? '#!', $subchild['nama'] ?? '') ?>
                    <?php $subchild_name = trim(strip_tags((string) ($subchild['nama'] ?? ''))) ?>
                    <?php $subchild_modal_id = function_exists('dashboard_resolve_surat_modal_id') ? dashboard_resolve_surat_modal_id($subchild_name) : null ?>
                    <?php $subchild_target = $is_external_link($subchild['link_url'] ?? '', $current_host) ? ' target="_blank"' : '' ?>
                    <li>
                    <?php if ($subchild_modal_id) : ?>
                        <button type="button" class="dashboard-sub-link dashboard-sub-link--button" onclick="dashboardOpenModal(event, '<?= $subchild_modal_id ?>')">- <?= $subchild_name ?></button>
                      <?php else : ?>
                        <a href="<?= $subchild_link ?>" class="dashboard-sub-link"<?= $subchild_target ?>>- <?= $subchild_name ?></a>
                      <?php endif ?>
                    </li>
                  <?php endforeach ?>
                <?php endif ?>
              <?php endforeach ?>
            </ul>
          </div>
        <?php else: ?>
          <?php $menu_link = $normalize_menu_link($menu['link_url'] ?? '#!', $menu['nama'] ?? '') ?>
          <?php $menu_name = trim(strip_tags((string) ($menu['nama'] ?? ''))) ?>
          <?php $menu_modal_id = function_exists('dashboard_resolve_surat_modal_id') ? dashboard_resolve_surat_modal_id($menu_name) : null ?>
          <?php $menu_name_normalized = strtolower($menu_name) ?>
          <?php $hide_link_icon = in_array($menu_name_normalized, ['publikasi', 'lapak desa'], true) ?>
          <?php $menu_target = $is_external_link($menu['link_url'] ?? '', $current_host) ? ' target="_blank"' : '' ?>
          <div class="dashboard-accordion-item dashboard-accordion-item--link">
            <?php if ($menu_modal_id) : ?>
              <button type="button" class="dashboard-accordion-link dashboard-accordion-link--button<?= $hide_link_icon ? ' dashboard-accordion-link--plain' : '' ?>" onclick="dashboardOpenModal(event, '<?= $menu_modal_id ?>')">
                <span><?= $menu_name ?></span>
                <?php if(!$hide_link_icon): ?>
                  <i class="fas fa-chevron-right text-xs"></i>
                <?php endif ?>
              </button>
            <?php else : ?>
              <a href="<?= $menu_link ?>" class="dashboard-accordion-link<?= $hide_link_icon ? ' dashboard-accordion-link--plain' : '' ?>"<?= $menu_target ?>>
                <span><?= $menu_name ?></span>
                <?php if(!$hide_link_icon): ?>
                  <i class="fas fa-chevron-right text-xs"></i>
                <?php endif ?>
              </a>
            <?php endif ?>
          </div>
        <?php endif ?>
      <?php endforeach ?>
    </section>
  </div>
</aside>
