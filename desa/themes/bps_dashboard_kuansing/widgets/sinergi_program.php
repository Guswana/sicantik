<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $program_items = is_array($sinergi_program ?? null) ? array_values($sinergi_program) : [];
  $sinergi_widget_id = 'sinergi-program-' . substr(md5((string) ($judul_widget ?? 'sinergi_program')), 0, 10);
?>

<style>
  .dashboard-sinergi-program {
    position: relative;
  }

  .dashboard-sinergi-program .owl-stage {
    display: flex;
    align-items: stretch;
  }

  .dashboard-sinergi-program .owl-item {
    display: flex;
  }

  .dashboard-sinergi-program__slide {
    width: 100%;
    height: 100%;
    padding: 0.25rem;
  }

  .dashboard-sinergi-program__link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 148px;
    padding: 0.9rem;
    border-radius: 0.9rem;
    border: 1px solid rgba(0, 0, 0, 0.12);
    background: linear-gradient(180deg, #ffffff 0%, #FFFFFF 100%);
    border-radius: 0.85rem;
    overflow: hidden;
  }

  .dashboard-sinergi-program__slide:hover {
    border-color: rgba(233, 246, 0, 0.35);
    box-shadow: 0 14px 28px -24px rgba(0, 0, 0, 0.35);
  }

  .dashboard-sinergi-program__link:hover {
    transform: translateY(-2px);
    border-color: rgba(233, 246, 0, 0.35);
    box-shadow: 0 14px 28px -24px rgba(0, 0, 0, 0.35);
  }

  .dashboard-sinergi-program__image {
    width: 118px;
    height: 118px;
    max-width: 100%;
    object-fit: contain;
    object-position: center;
    transition: transform 0.22s ease;
  }

  .dashboard-sinergi-program__link:hover .dashboard-sinergi-program__image {
    transform: scale(1.04);
  }

  .dashboard-sinergi-program__nav {
    position: absolute;
    inset: 0;
    z-index: 5;
    pointer-events: none;
    margin-top: 0;
  }

  .dashboard-sinergi-program__btn {
    position: absolute;
    top: 50%;
    width: 34px;
    height: 34px;
    border: 0;
    border-radius: 9999px;
    background: linear-gradient(120deg, #000000 0%, #E9F600 100%);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    z-index: 6;
    pointer-events: auto;
    box-shadow: 0 12px 22px -18px rgba(0, 0, 0, 0.65);
    transform: translateY(-50%);
    transition: transform 0.18s ease, filter 0.18s ease;
  }

  .dashboard-sinergi-program__btn:hover {
    transform: translateY(calc(-50% - 1px));
    filter: brightness(1.06);
  }

  .dashboard-sinergi-program__prev {
    left: -0.55rem;
  }

  .dashboard-sinergi-program__next {
    right: -0.55rem;
  }

  @media (max-width: 420px) {
    .dashboard-sinergi-program__link {
      min-height: 132px;
      padding: 0.75rem;
    }

    .dashboard-sinergi-program__image {
      width: 104px;
      height: 104px;
    }

    .dashboard-sinergi-program__prev {
      left: -0.25rem;
    }

    .dashboard-sinergi-program__next {
      right: -0.25rem;
    }
  }
</style>

<div class="box box-primary box-solid">
  <div class="box-header">
    <h3 class="box-title"><i class="fas fa-external-link-alt mr-1"></i><?= html_escape($judul_widget) ?></h3>
  </div>
  <div id="sinergi_program" class="box-body">
    <?php if ($program_items) : ?>
      <div class="dashboard-sinergi-program" id="<?= html_escape($sinergi_widget_id) ?>">
        <div class="owl-carousel">
          <?php foreach ($program_items as $program) : ?>
            <div class="dashboard-sinergi-program__slide">
              <a
                href="<?= html_escape($program['tautan']) ?>"
                class="dashboard-sinergi-program__link"
                target="_blank"
                rel="noopener noreferrer"
                title="<?= html_escape($program['judul']) ?>">
                <img
                  src="<?= base_url(LOKASI_GAMBAR_WIDGET . $program['gambar']) ?>"
                  alt="<?= html_escape($program['judul']) ?>"
                  class="dashboard-sinergi-program__image">
              </a>
            </div>
          <?php endforeach; ?>
        </div>

        <?php if (count($program_items) > 1) : ?>
          <div class="dashboard-sinergi-program__nav" aria-label="Navigasi sinergi program">
            <button type="button" class="dashboard-sinergi-program__btn dashboard-sinergi-program__prev" aria-label="Program sebelumnya">
              <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" class="dashboard-sinergi-program__btn dashboard-sinergi-program__next" aria-label="Program berikutnya">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
        <?php endif; ?>
      </div>
    <?php else : ?>
      <p class="py-2 text-center text-sm text-gray-500">Belum ada sinergi program yang ditampilkan.</p>
    <?php endif; ?>
  </div>
</div>

<?php if (count($program_items) > 1) : ?>
  <script>
    (function ($) {
      if (!$ || !$.fn || !$.fn.owlCarousel) {
        return;
      }

      $(function () {
        var widgetSelector = '#<?= $sinergi_widget_id ?>';
        var $widget = $(widgetSelector);

        if (!$widget.length) {
          return;
        }

        var $carousel = $widget.find('.owl-carousel').first();

        if (!$carousel.hasClass('owl-loaded')) {
          $carousel.owlCarousel({
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: 2800,
            dots: true,
            items: 2,
            loop: <?= count($program_items) > 2 ? 'true' : 'false' ?>,
            margin: 10,
            nav: false,
            responsive: {
              0: {
                items: 2,
              },
              480: {
                items: 2,
              },
              768: {
                items: 3,
              }
            },
            smartSpeed: 450,
          });
        }

        $widget
          .off('click.sinergiPrev', '.dashboard-sinergi-program__prev')
          .on('click.sinergiPrev', '.dashboard-sinergi-program__prev', function (event) {
            event.preventDefault();
            $carousel.trigger('prev.owl.carousel', [300]);
          });

        $widget
          .off('click.sinergiNext', '.dashboard-sinergi-program__next')
          .on('click.sinergiNext', '.dashboard-sinergi-program__next', function (event) {
            event.preventDefault();
            $carousel.trigger('next.owl.carousel', [300]);
          });
      });
    })(window.jQuery);
  </script>
<?php endif; ?>
