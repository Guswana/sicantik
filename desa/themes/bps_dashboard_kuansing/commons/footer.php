<?php  defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <?php if($transparansi) $this->load->view($folder_themes .'/partials/apbdesa', $transparansi) ?>
</div>

<?php 
    $social_media = [
        'facebook' => [
            'color' => 'bg-blue-600',
            'icon' => 'fa-facebook-f'
        ],
        'twitter' => [
            'color' => 'bg-blue-500',
            'icon' => 'fa-twitter'
        ],
        'instagram' => [
            'color' => 'bg-primary-200',
            'icon' => 'fa-instagram'
        ],
        'telegram' => [
            'color' => 'bg-primary-100',
            'icon' => 'fa-telegram'
        ],
        'whatsapp' => [
            'color' => 'bg-accent-100',
            'icon' => 'fa-whatsapp'
        ],
        'youtube' => [
            'color' => 'bg-secondary-100',
            'icon' => 'fa-youtube'
        ]
    ];

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
?>

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

<?php foreach($sosmed as $social) : ?>
    <?php if($social['link']) : ?>
        <?php $social_media[strtolower($social['nama'])]['link'] = $fix_whatsapp_link($social['nama'], $social['link']); ?>
    <?php endif ?>
<?php endforeach ?>

<?php $this->load->view($folder_themes .'/commons/back_to_top') ?>

<footer class="container mx-auto lg:px-5 px-3 pt-5 footer footer-dashboard">
    <div class="footer-dashboard-inner rounded-t-xl overflow-hidden">
        <div class="footer-dashboard-main text-white py-8 px-5 lg:px-10">
            <div class="footer-dashboard-brand">
                <img src="<?= gambar_desa($desa['logo']) ?>" alt="Logo <?= NAMA_DESA ?>" class="footer-dashboard-logo">
                <div>
                    <p class="footer-dashboard-brand-label">Pemerintah</p>
                    <h3 class="footer-dashboard-brand-title"><?= strtoupper(NAMA_DESA) ?></h3>
                </div>
            </div>

            <div class="footer-dashboard-info">
                <p class="footer-dashboard-address"><?= html_escape($alamat_lengkap ?: ucfirst($this->setting->sebutan_kecamatan_singkat) . ' ' . ucwords($desa['nama_kecamatan'])) ?></p>
                <div class="footer-dashboard-important">
                    <p class="footer-dashboard-important-item"><i class="fas fa-fire-extinguisher"></i> Damkar Sektor Baserah: <a href="tel:07602525330">07602525330</a></p>
                    <p class="footer-dashboard-important-item"><i class="fas fa-shield-alt "></i> Kepolisian: <a href="tel:110">110</a></p>
                    <p class="footer-dashboard-important-item"><i class="fas fa-hospital"></i> Puskesmas: <a href="tel:082379811110">082379811110</a></p>
                </div>
            </div>

            <ul class="footer-dashboard-social">
                <?php foreach($social_media as $sm) : ?>
                    <?php if($link = ($sm['link'] ?? null)) : ?>
                    <li class="inline-block"><a href="<?= $link ?>" class="inline-flex items-center justify-center <?= $sm['color'] ?> h-8 w-8 rounded-full footer-social-link"><i class="fab fa-lg <?= $sm['icon'] ?>"></i></a></li>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>

            <?php if (setting('tte')): ?>
                <div class="footer-dashboard-bsre">
                    <img src="<?=asset('assets/images/bsre.png?v', false); ?>" alt="Bsre" class="img-responsive" style="width: 185px;" />
                </div>
            <?php endif ?>
        </div>

        <div class="footer-dashboard-bottom text-white py-4 px-5 text-sm text-center">
            <p>Hak cipta situs &copy; <?= date('Y') ?> - <?= NAMA_DESA ?></p>
            <p><a href="https://opensid.my.id" target="_blank" rel="noopener">BPS Dashboard Kuansing v1.0.0</a> - <a href="https://opensid.my.id" target="_blank" rel="noopener">OpenSID <?= ambilVersi() ?></a>
            <?php if (file_exists('mitra')): ?>
                - Hosting didukung <a href="https://my.idcloudhost.com/aff.php?aff=3172" rel="noopener noreferrer" target="_blank"><img src="<?= base_url('/assets/images/Logo-IDcloudhost.png')?>" class="h-4 inline-block" alt="Logo-IDCloudHost" title="Logo-IDCloudHost"></a>
            <?php endif; ?>
            </p>
        </div>
    </div>
</footer>

<?php
  $surat_helper = FCPATH . $this->theme_folder . '/' . $this->theme . '/partials/surat_modal_helpers.php';
  if (file_exists($surat_helper)) {
    require_once $surat_helper;
  }

  $modal_dir = FCPATH . $this->theme_folder . '/' . $this->theme . '/partials/';
  foreach (glob($modal_dir . 'modal_surat_*.php') as $modal_file) {
    require $modal_file;
  }
?>
