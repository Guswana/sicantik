<?php  defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $loading_logo = gambar_desa($desa['logo'] ?? null);
  $loading_logo_overrides = [
    'desa/pengaturan/bps_dashboard_kuansing/images/loading-logo.png',
    'desa/pengaturan/bps_dashboard_kuansing/images/loading-logo.jpg',
    'desa/pengaturan/bps_dashboard_kuansing/images/loading-logo.jpeg',
    'desa/pengaturan/bps_dashboard_kuansing/images/loading-logo.webp',
    'desa/pengaturan/bps_dashboard_kuansing/images/loading-logo.svg',
  ];

  foreach ($loading_logo_overrides as $loading_logo_override) {
    if (is_file(FCPATH . $loading_logo_override)) {
      $loading_logo = base_url($loading_logo_override);
      break;
    }
  }

  $loading_desa_name = trim((string) ($desa['nama_desa'] ?? ''));
  $loading_title = trim(ucwords($this->setting->sebutan_desa) . ' ' . ucwords($loading_desa_name));
  $loading_region_line_one = !empty($desa['nama_kecamatan'])
    ? ucfirst((string) $this->setting->sebutan_kecamatan_singkat) . ' ' . ucwords((string) $desa['nama_kecamatan'])
    : '';

  $loading_region_line_two_parts = [];

  if (!empty($desa['nama_kabupaten'])) {
    $loading_region_line_two_parts[] = ucfirst((string) $this->setting->sebutan_kabupaten_singkat) . ' ' . ucwords((string) $desa['nama_kabupaten']);
  }

  if (!empty($desa['nama_propinsi'])) {
    $loading_region_line_two_parts[] = ucwords((string) $desa['nama_propinsi']);
  }

  $loading_region_line_two = implode(' - ', $loading_region_line_two_parts);
?>

<div
  x-data="{loading: true, onLoading() {setTimeout(() => {this.loading = false}, 1500)}}"
  x-init="onLoading()">
  <div
    class="dashboard-loading-screen fixed left-0 top-0 w-screen h-screen z-[9999] flex justify-center items-center"
    x-cloak
    x-show="loading"
    x-transition.opacity.duration.300ms>
    <div class="dashboard-loading-screen__card">
      <div class="dashboard-loading-screen__brand">
        <div class="dashboard-loading-screen__logo-wrap" aria-hidden="true">
          <span class="dashboard-loading-screen__orb dashboard-loading-screen__orb--1"></span>
          <span class="dashboard-loading-screen__orb dashboard-loading-screen__orb--2"></span>
          <span class="dashboard-loading-screen__orb dashboard-loading-screen__orb--3"></span>
          <span class="dashboard-loading-screen__orb dashboard-loading-screen__orb--4"></span>
          <span class="dashboard-loading-screen__orb dashboard-loading-screen__orb--5"></span>
          <img src="<?= html_escape($loading_logo) ?>" alt="Logo <?= html_escape($loading_title) ?>" class="dashboard-loading-screen__logo">
        </div>

        <span class="dashboard-loading-screen__eyebrow">Website Resmi</span>
        <h2 class="dashboard-loading-screen__title"><?= html_escape($loading_title) ?></h2>

        <?php if ($loading_region_line_one !== '') : ?>
          <p class="dashboard-loading-screen__meta"><?= html_escape($loading_region_line_one) ?></p>
        <?php endif; ?>

        <?php if ($loading_region_line_two !== '') : ?>
          <p class="dashboard-loading-screen__meta dashboard-loading-screen__meta--secondary"><?= html_escape($loading_region_line_two) ?></p>
        <?php endif; ?>

        <div class="dashboard-loading-screen__progress" role="status" aria-live="polite">
          <span></span>
          <span></span>
          <span></span>
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  [x-cloak] {
    display: none !important;
  }

  .dashboard-loading-screen {
    padding: 1.5rem;
    background:
      radial-gradient(circle at top left, rgba(233, 246, 0, 0.22) 0%, rgba(233, 246, 0, 0) 30%),
      radial-gradient(circle at bottom right, rgba(217, 37, 28, 0.18) 0%, rgba(217, 37, 28, 0) 28%),
      linear-gradient(180deg, var(--dashboard-bg-soft, #FFFFFF) 0%, #ffffff 100%);
  }

  .dashboard-loading-screen__card {
    width: min(92vw, 640px);
    padding: 2rem 1.5rem;
    border-radius: 1.4rem;
    border: 1px solid rgba(0, 0, 0, 0.12);
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.97) 0%, rgba(255, 255, 255, 0.96) 100%);
    box-shadow: 0 30px 60px -32px rgba(0, 0, 0, 0.24);
    backdrop-filter: blur(10px);
  }

  .dashboard-loading-screen__brand {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
  }

  .dashboard-loading-screen__logo-wrap {
    position: relative;
    width: 146px;
    height: 146px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.85rem;
  }

  .dashboard-loading-screen__logo {
    position: relative;
    z-index: 2;
    width: 94px;
    max-width: 100%;
    height: auto;
    object-fit: contain;
    filter: drop-shadow(0 12px 26px rgba(0, 0, 0, 0.18));
    animation: dashboard-loading-logo-blink 1.1s ease-in-out infinite alternate;
  }

  .dashboard-loading-screen__orb {
    position: absolute;
    border-radius: 9999px;
    opacity: 0.92;
    animation: dashboard-loading-orb-float 2.2s ease-in-out infinite;
  }

  .dashboard-loading-screen__orb--1 {
    top: 16px;
    left: 20px;
    width: 14px;
    height: 14px;
    background: var(--secondary-base-color, #D9251C);
  }

  .dashboard-loading-screen__orb--2 {
    top: 34px;
    right: 20px;
    width: 18px;
    height: 18px;
    background: var(--accent-base-color, #E9F600);
    animation-delay: 0.24s;
  }

  .dashboard-loading-screen__orb--3 {
    right: 28px;
    bottom: 28px;
    width: 11px;
    height: 11px;
    background: var(--primary-base-color, #000000);
    animation-delay: 0.45s;
  }

  .dashboard-loading-screen__orb--4 {
    bottom: 18px;
    left: 24px;
    width: 17px;
    height: 17px;
    background: rgba(0, 0, 0, 0.45);
    animation-delay: 0.65s;
  }

  .dashboard-loading-screen__orb--5 {
    top: 60px;
    left: 10px;
    width: 9px;
    height: 9px;
    background: rgba(233, 246, 0, 0.65);
    animation-delay: 0.88s;
  }

  .dashboard-loading-screen__eyebrow {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.35rem 0.75rem;
    border-radius: 9999px;
    background: rgba(0, 0, 0, 0.08);
    color: var(--primary-base-color, #000000);
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
  }

  .dashboard-loading-screen__title {
    margin: 0.9rem 0 0;
    color: var(--dashboard-text-strong, #000000);
    font-size: clamp(1.6rem, 3.6vw, 2.25rem);
    line-height: 1.15;
    font-weight: 800;
  }

  .dashboard-loading-screen__meta {
    margin: 0.45rem 0 0;
    color: var(--primary-darken-color, #0E0202);
    font-size: 1rem;
    line-height: 1.45;
    font-weight: 600;
  }

  .dashboard-loading-screen__meta--secondary {
    margin-top: 0.1rem;
    color: rgba(0, 0, 0, 0.82);
    font-size: 0.95rem;
    font-weight: 500;
  }

  .dashboard-loading-screen__progress {
    display: inline-flex;
    align-items: center;
    gap: 0.42rem;
    margin-top: 1.15rem;
  }

  .dashboard-loading-screen__progress span:not(.visually-hidden) {
    width: 9px;
    height: 9px;
    border-radius: 9999px;
    background: var(--primary-base-color, #000000);
    animation: dashboard-loading-progress 0.9s ease-in-out infinite;
  }

  .dashboard-loading-screen__progress span:nth-child(2) {
    animation-delay: 0.15s;
    background: var(--accent-base-color, #E9F600);
  }

  .dashboard-loading-screen__progress span:nth-child(3) {
    animation-delay: 0.3s;
    background: var(--secondary-base-color, #D9251C);
  }

  @keyframes dashboard-loading-logo-blink {
    0% {
      opacity: 0.62;
      transform: scale(0.96);
    }

    100% {
      opacity: 1;
      transform: scale(1.03);
    }
  }

  @keyframes dashboard-loading-orb-float {
    0%,
    100% {
      transform: translate3d(0, 0, 0) scale(1);
    }

    50% {
      transform: translate3d(0, -8px, 0) scale(1.08);
    }
  }

  @keyframes dashboard-loading-progress {
    0%,
    100% {
      opacity: 0.35;
      transform: translateY(0);
    }

    50% {
      opacity: 1;
      transform: translateY(-3px);
    }
  }

  @media (max-width: 640px) {
    .dashboard-loading-screen__card {
      padding: 1.6rem 1.1rem;
      border-radius: 1.15rem;
    }

    .dashboard-loading-screen__logo-wrap {
      width: 126px;
      height: 126px;
    }

    .dashboard-loading-screen__logo {
      width: 82px;
    }

    .dashboard-loading-screen__meta {
      font-size: 0.92rem;
    }
  }
</style>
