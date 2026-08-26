<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">
      <i class="fas fa-user  mr-1"></i><?= $judul_widget ?>
    </h3>
  </div>
  <div class="box-body">
    <div class="aparatur-carousel-widget">
      <div class="owl-carousel">
        <?php foreach ($aparatur_desa['daftar_perangkat'] as $data) : ?>
          <div class="aparatur-carousel-slide relative space-y-2">
            <div class="aparatur-carousel-photo">
              <img src="<?= $data['foto'] ?>" alt="<?= $data['nama'] ?>" class="aparatur-carousel-image object-cover object-center bg-gray-300">
            </div>
            <?php if ($this->web_widget_model->get_setting('aparatur_desa', 'overlay') == true) : ?>
              <div class="aparatur-carousel-meta space-y-1 text-sm text-center z-10">
                <span class="text-h6"><?= $data['nama'] ?></span>
                <span class="block"><?= $data['jabatan'] ?></span>
                <?php if ($data['pamong_niap']) : ?>
                  <span class="block"><?= $this->setting->sebutan_nip_desa ?> : <?= $data['pamong_niap'] ?></span>
                <?php endif ?>
                <?php if ($data['kehadiran'] == 1) : ?>
                  <?php if ($data['status_kehadiran'] == 'hadir') : ?>
                    <span class="btn btn-primary w-auto mx-auto inline-block">Hadir</span>
                  <?php endif ?>
                  <?php if ($data['tanggal'] == date('Y-m-d') && $data['status_kehadiran'] != 'hadir') : ?>
                    <span class="btn btn-danger w-auto mx-auto inline-block"><?= ucwords($data['status_kehadiran']); ?></span>
                  <?php endif ?>
                  <?php if ($data['tanggal'] != date('Y-m-d')) : ?>
                    <span class="btn btn-danger w-auto mx-auto inline-block">Belum Rekam Kehadiran</span>
                  <?php endif ?>
                <?php endif ?>
              </div>
            <?php endif ?>
          </div>
        <?php endforeach ?>
      </div>

      <?php if (count($aparatur_desa['daftar_perangkat'] ?? []) > 1) : ?>
        <div class="aparatur-carousel-nav" aria-label="Navigasi aparatur desa">
          <button type="button" class="aparatur-carousel-btn aparatur-carousel-prev" aria-label="Aparatur sebelumnya">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button type="button" class="aparatur-carousel-btn aparatur-carousel-next" aria-label="Aparatur berikutnya">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>

<?php if (count($aparatur_desa['daftar_perangkat'] ?? []) > 1) : ?>
  <script>
    (function ($) {
      if (!$ || !$.fn || !$.fn.owlCarousel) {
        return;
      }

      $(function () {
        $(document)
          .off('click.aparaturCarouselPrev', '.aparatur-carousel-prev')
          .on('click.aparaturCarouselPrev', '.aparatur-carousel-prev', function (event) {
            event.preventDefault();
            $(this)
              .closest('.aparatur-carousel-widget')
              .find('.owl-carousel')
              .first()
              .trigger('prev.owl.carousel', [300]);
          });

        $(document)
          .off('click.aparaturCarouselNext', '.aparatur-carousel-next')
          .on('click.aparaturCarouselNext', '.aparatur-carousel-next', function (event) {
            event.preventDefault();
            $(this)
              .closest('.aparatur-carousel-widget')
              .find('.owl-carousel')
              .first()
              .trigger('next.owl.carousel', [300]);
          });
      });
    })(window.jQuery);
  </script>
<?php endif ?>
