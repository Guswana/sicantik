<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav class="bg-primary-100 text-white hidden lg:block dashboard-topbar-nav" role="navigation">
  <div class="dashboard-topbar-inner">
    <div class="dashboard-topbar-home-item">
      <a href="<?= site_url() ?>" class="dashboard-topbar-home-link" title="Beranda"><i class="fa fa-home"></i></a>
    </div>

    <?php $this->load->view($folder_themes . '/commons/header_clock') ?>

    <div class="dashboard-topbar-actions">
      <?php if($this->setting->layanan_mandiri == 1) : ?>
        <a href="<?= site_url('layanan-mandiri') ?>" class="dashboard-topbar-btn" target="_blank">Layanan Mandiri <i class="fas fa-external-link-alt ml-1"></i></a>
      <?php endif ?>
      <a href="<?= site_url('siteman') ?>" class="dashboard-topbar-btn" target="_blank">Login Admin <i class="fas fa-external-link-alt ml-1"></i></a>
    </div>
  </div>
</nav>
