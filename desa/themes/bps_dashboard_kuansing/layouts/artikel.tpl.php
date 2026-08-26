<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php $this->load->view($folder_themes . '/commons/meta') ?>
  <?php $this->load->view($folder_themes . '/commons/source_css') ?>
  <?php $this->load->view($folder_themes . '/commons/source_js') ?>
</head>
<body class="font-primary bg-gray-100 theme-bps-dashboard">

  <?php if($single_artikel['id']) : ?>
    <?php $this->load->view($folder_themes . '/commons/loading_screen') ?>
    <?php $this->load->view($folder_themes . '/commons/header') ?>
    <?php $show_right_sidebar = in_array((int) $single_artikel['tampilan'], [1, 2], true) ?>
    <?php $grid_class = 'dashboard-main-grid' ?>
    <?php if(!$show_right_sidebar): ?>
      <?php $grid_class .= ' dashboard-main-grid--no-right' ?>
    <?php elseif((int) $single_artikel['tampilan'] === 2): ?>
      <?php $grid_class .= ' dashboard-main-grid--content-right' ?>
    <?php endif ?>
    
    <div class="container mx-auto lg:px-4 px-3 my-5 dashboard-content-wrap text-gray-600">
      <div class="<?= $grid_class ?>">
        <?php $this->load->view($folder_themes . '/partials/left_sidebar') ?>
        <?php if($show_right_sidebar && (int) $single_artikel['tampilan'] === 2): ?>
          <aside class="dashboard-right-column dashboard-sidebar-panel">
            <?php $this->load->view($folder_themes . '/partials/sidebar') ?>
          </aside>
        <?php endif ?>
        <main class="dashboard-center-column">
          <?php $this->load->view($folder_themes . '/commons/running_text') ?>
          <div class="overflow-hidden space-y-1 bg-white rounded-lg px-4 py-2 lg:py-4 lg:px-5 shadow">
            <?php $this->load->view($folder_themes . '/partials/article'); ?>
            <?php $this->load->view($folder_themes . '/partials/comment') ?>
            <?php $this->load->view($folder_themes . '/commons/sticky_share'); ?>
          </div>
        </main>
        <?php if($show_right_sidebar && (int) $single_artikel['tampilan'] === 1): ?>
          <aside class="dashboard-right-column dashboard-sidebar-panel">
            <?php $this->load->view($folder_themes . '/partials/sidebar') ?>
          </aside>
        <?php endif ?>
      </div>
    </div>

    <?php $this->load->view($folder_themes .'/commons/footer') ?>

    <?php else : ?>
      <?php $this->load->view($folder_themes .'/commons/404') ?>
  <?php endif ?>

  <script src="<?= base_url("$this->theme_folder/$this->theme/assets/js/script.min.js?" . THEME_VERSION) ?>"></script>

</body>
</html>
