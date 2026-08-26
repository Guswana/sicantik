<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $items = [];
  $infografis_dir = FCPATH . 'desa/themes/bps_dashboard_kuansing/assets/infografis/';
  $infografis_paths = glob($infografis_dir . '*.{jpg,jpeg,png,webp,gif,svg}', GLOB_BRACE) ?: [];

  natcasesort($infografis_paths);

  foreach ($infografis_paths as $infografis_path) {
    if (!is_file($infografis_path)) {
      continue;
    }

    $relative_path = str_replace(FCPATH, '', $infografis_path);
    $items[] = [
      'judul' => str_replace(['-', '_'], ' ', pathinfo($infografis_path, PATHINFO_FILENAME)),
      'gambar' => base_url(str_replace('\\', '/', $relative_path)),
      'tautan' => '',
    ];
  }

  $infografis_widget_id = 'dashboard-infografis-' . substr(md5((string) ($judul_widget ?? 'infografis')), 0, 10);
?>

<section class="dashboard-infografis-widget dashboard-widget-box shadow rounded-lg bg-white overflow-hidden" aria-label="Infografis desa">
  <div class="box-header dashboard-infografis-header">
    <h3 class="box-title dashboard-infografis-title"><?= html_escape($judul_widget ?? 'Infografis') ?></h3>
    <p class="dashboard-infografis-subtitle">Visualisasi data dan informasi penting dalam format yang mudah dipahami</p>
  </div>
  <div class="box-body">
    <?php if ($items) : ?>
      <div class="dashboard-infografis-carousel" id="<?= html_escape($infografis_widget_id) ?>">
        <div class="owl-carousel dashboard-infografis-carousel__track">
          <?php foreach ($items as $item) : ?>
            <figure class="dashboard-infografis-slide">
              <div class="dashboard-infografis-media">
                <a href="<?= html_escape($item['gambar']) ?>" class="dashboard-infografis-link" title="<?= html_escape($item['judul']) ?>" data-fancybox="infografis-gallery" data-caption="<?= html_escape($item['judul']) ?>">
                  <img src="<?= html_escape($item['gambar']) ?>" alt="<?= html_escape($item['judul']) ?>" class="dashboard-infografis-image">
                </a>
              </div>

              <figcaption class="dashboard-infografis-caption"><?= html_escape($item['judul']) ?></figcaption>
            </figure>
          <?php endforeach; ?>
        </div>

        <?php if (count($items) > 1) : ?>
          <div class="dashboard-infografis-nav" aria-label="Navigasi infografis">
            <button type="button" class="dashboard-infografis-btn dashboard-infografis-prev" aria-label="Infografis sebelumnya">
              <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" class="dashboard-infografis-btn dashboard-infografis-next" aria-label="Infografis berikutnya">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
        <?php endif; ?>
      </div>
    <?php else : ?>
      <p class="py-2 text-sm text-gray-500">Belum ada data infografis untuk ditampilkan.</p>
    <?php endif; ?>
  </div>
</section>

<?php if (count($items) > 1) : ?>
  <script>
    (function ($) {
      if (!$ || !$.fn || !$.fn.owlCarousel) {
        return;
      }

      $(function () {
        var widgetSelector = '#<?= $infografis_widget_id ?>';
        var $widget = $(widgetSelector);

        if (!$widget.length) {
          return;
        }

        var $carousel = $widget.find('.owl-carousel').first();

        if (!$carousel.hasClass('owl-loaded')) {
          $carousel.owlCarousel({
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: 3200,
            dots: true,
            loop: <?= count($items) > 3 ? 'true' : 'false' ?>,
            margin: 14,
            nav: false,
            smartSpeed: 450,
            responsive: {
              0: {
                items: 1
              },
              768: {
                items: 2
              },
              1200: {
                items: 3
              }
            }
          });
        }

        $widget
          .off('click.infografisPrev', '.dashboard-infografis-prev')
          .on('click.infografisPrev', '.dashboard-infografis-prev', function (event) {
            event.preventDefault();
            $carousel.trigger('prev.owl.carousel', [300]);
          });

        $widget
          .off('click.infografisNext', '.dashboard-infografis-next')
          .on('click.infografisNext', '.dashboard-infografis-next', function (event) {
            event.preventDefault();
            $carousel.trigger('next.owl.carousel', [300]);
          });
      });
    })(window.jQuery);
  </script>
<?php endif; ?>
