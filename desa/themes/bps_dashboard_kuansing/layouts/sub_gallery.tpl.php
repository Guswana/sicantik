<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php $this->load->view($folder_themes . '/commons/meta') ?>
  <?php $this->load->view($folder_themes . '/commons/source_css') ?>
  <?php $this->load->view($folder_themes . '/commons/source_js') ?>
</head>
<body class="font-primary bg-gray-100 theme-bps-dashboard">
  
  <?php $this->load->view($folder_themes . '/commons/loading_screen') ?>
  <?php $this->load->view($folder_themes . '/commons/header') ?>
  <div class="container mx-auto lg:px-4 px-3 my-5 dashboard-content-wrap text-gray-600">
    <div class="dashboard-main-grid">
      <?php $this->load->view($folder_themes . '/partials/left_sidebar') ?>
      <main class="dashboard-center-column">
        <?php $this->load->view($folder_themes . '/commons/running_text') ?>
        <div class="overflow-hidden space-y-1 bg-white rounded-lg px-4 py-2 lg:py-4 lg:px-5 shadow">
          <?php $this->load->view($folder_themes . '/partials/sub_gallery') ?>
          <?php $data['paging_page'] = ($paging_page ?? 'first/sub_gallery/'. $parrent['id']) ?>
          <?php $this->load->view($folder_themes .'/commons/paging', $data) ?>
        </div>
      </main>
      <aside class="dashboard-right-column dashboard-sidebar-panel">
        <?php $this->load->view($folder_themes .'/partials/sidebar') ?>
      </aside>
    </div>
  </div>

  <?php $this->load->view($folder_themes .'/commons/footer') ?>
  <script src="<?= base_url("$this->theme_folder/$this->theme/assets/js/script.min.js?" . THEME_VERSION) ?>"></script>
</body>
</html>
