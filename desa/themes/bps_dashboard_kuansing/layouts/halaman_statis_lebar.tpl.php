<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php $this->load->view($folder_themes . '/commons/meta') ?>
  <?php $this->load->view($folder_themes . '/commons/source_css') ?>
</head>
<body class="font-primary bg-gray-100 theme-bps-dashboard">

  <?php $this->load->view($folder_themes . '/commons/loading_screen') ?>
  <?php $this->load->view($folder_themes . '/commons/header') ?>

  <div class="container mx-auto lg:px-4 px-3 my-5 dashboard-content-wrap text-gray-600">
    <div class="dashboard-main-grid dashboard-main-grid--no-right">
      <?php $this->load->view($folder_themes . '/partials/left_sidebar') ?>
      <main class="dashboard-center-column">
        <?php $this->load->view($folder_themes . '/commons/running_text') ?>
        <div class="space-y-1 bg-white rounded-lg px-4 py-2 lg:py-4 lg:px-5 shadow">
          <?php
            $resolved_halaman_statis = str_replace('home/idm', 'idm/index', $halaman_statis);
            $resolved_halaman_statis = $resolved_halaman_statis === 'web/halaman_statis/lapak' ? 'lapak/index' : $resolved_halaman_statis;

            $theme_partial_file = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $this->theme_folder . '/' . $this->theme . '/partials/' . $resolved_halaman_statis . '.php');
            $use_theme_partial = !preg_match('/halaman_statis/i', $resolved_halaman_statis) && is_file($theme_partial_file);
          ?>

          <?php if ($use_theme_partial) : ?>
            <?php $this->load->view("{$folder_themes}/partials/{$resolved_halaman_statis}"); ?>
          <?php else : ?>
            <?php $this->load->view($resolved_halaman_statis); ?>
          <?php endif ?>
        </div>
      </main>
    </div>
  </div>

  <?php $this->load->view($folder_themes .'/commons/footer') ?>
  <?php $this->load->view($folder_themes . '/commons/source_js') ?>
  <script src="<?= base_url("$this->theme_folder/$this->theme/assets/js/script.min.js?" . THEME_VERSION) ?>"></script>

</body>
</html>
