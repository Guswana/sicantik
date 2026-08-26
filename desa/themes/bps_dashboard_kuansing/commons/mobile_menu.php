<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<?php
  $menu_atas = menu_tema() ?: [];
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

  $render_mobile_menu = function(array $items, int $level = 0) use (&$render_mobile_menu, $normalize_menu_link, $is_external_link, $current_host) {
    if (empty($items)) {
      return;
    }

    $list_class = $level === 0
      ? 'dashboard-mobile-menu-list divide-y divide-primary-200'
      : 'dashboard-mobile-submenu divide-y divide-primary-200';
?>
    <ul<?= $level === 0 ? ' x-show="menuOpen" x-transition.opacity.duration.200ms' : ' x-show="open" x-transition.opacity.duration.200ms' ?> class="<?= $list_class ?>"<?= $level > 0 ? ' data-level="' . $level . '"' : '' ?>>
      <?php foreach ($items as $menu) : ?>
        <?php
          $children = $menu['childrens'] ?? [];
          $has_dropdown = is_array($children) && count($children) > 0;
          $menu_name = trim(strip_tags((string) ($menu['nama'] ?? '')));
          $menu_modal_id = function_exists('dashboard_resolve_surat_modal_id') ? dashboard_resolve_surat_modal_id($menu_name) : null;
          $menu_link = $normalize_menu_link($menu['link_url'] ?? '#!', $menu['nama'] ?? '');
          $padding_left = number_format(1 + ($level * 0.9), 2, '.', '');
        ?>
        <li class="dashboard-mobile-menu-item<?= $has_dropdown ? ' dashboard-mobile-menu-item--has-children' : '' ?>"<?= $has_dropdown ? ' x-data="{open: false}"' : '' ?>>
          <?php if ($has_dropdown) : ?>
            <button
              type="button"
              class="dashboard-mobile-menu-trigger"
              style="padding-left: <?= $padding_left ?>rem;"
              @click="open = !open"
              :aria-expanded="open.toString()">
              <span><?= $menu_name ?></span>
              <i class="fas fa-chevron-down dashboard-mobile-menu-icon" :class="{'rotate-180': open}"></i>
            </button>

            <?php $render_mobile_menu($children, $level + 1); ?>
          <?php else : ?>
            <?php $menu_target = $is_external_link($menu['link_url'] ?? '', $current_host) ? ' target="_blank"' : '' ?>
            <?php if ($menu_modal_id) : ?>
              <button type="button" class="dashboard-mobile-menu-link dashboard-mobile-menu-link--button" style="padding-left: <?= $padding_left ?>rem;" onclick="dashboardOpenModal(event, '<?= $menu_modal_id ?>')"><?= $menu_name ?></button>
            <?php else : ?>
              <a href="<?= $menu_link ?>" class="dashboard-mobile-menu-link" style="padding-left: <?= $padding_left ?>rem;"<?= $menu_target ?>><?= $menu_name ?></a>
            <?php endif ?>
          <?php endif ?>
        </li>
      <?php endforeach ?>
    </ul>
<?php
  };
?>

<nav class="bg-primary-100 text-white lg:hidden block dashboard-mobile-nav" x-data="{menuOpen: false}" role="navigation">
  <div class="dashboard-mobile-topbar">
    <a href="<?= site_url() ?>" class="dashboard-mobile-home-link" title="Beranda"><i class="fa fa-home"></i></a>

    <?php $this->load->view($folder_themes . '/commons/header_clock', ['is_mobile_clock' => true]) ?>

    <div class="dashboard-mobile-action-wrap">
      <?php if($this->setting->layanan_mandiri == 1) : ?>
        <a href="<?= site_url('layanan-mandiri') ?>" class="dashboard-mobile-action-btn">Mandiri</a>
      <?php endif ?>
      <a href="<?= site_url('siteman') ?>" class="dashboard-mobile-action-btn">Admin</a>
    </div>

    <button type="button" class="dashboard-mobile-menu-toggle" @click="menuOpen = !menuOpen" :aria-expanded="menuOpen.toString()" aria-label="Toggle menu">
      <i class="fas" :class="{'fa-bars': !menuOpen, 'fa-times': menuOpen}"></i>
    </button>
  </div>

  <?php $render_mobile_menu($menu_atas); ?>
</nav>
