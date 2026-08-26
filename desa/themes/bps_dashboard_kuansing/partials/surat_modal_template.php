<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  if (empty($modal_surat) || !is_array($modal_surat)) {
    return;
  }

  $modal_id = $modal_surat['id'] ?? '';
  $modal_title = $modal_surat['judul'] ?? '';
  $modal_ringkasan = $modal_surat['ringkasan'] ?? '';
  $modal_persyaratan = $modal_surat['persyaratan'] ?? [];
  $modal_catatan = $modal_surat['catatan'] ?? 'Silakan bawa dokumen ke kantor desa pada jam operasional kerja.';
  $modal_icon = $modal_surat['icon'] ?? 'fas fa-home';
?>

<div
  id="<?= $modal_id ?>"
  class="dashboard-modal-backdrop"
  role="presentation"
  aria-hidden="true"
  hidden
  style="display:none;"
  onclick="if (event.target === this) dashboardCloseModal('<?= $modal_id ?>')">
  
  <div class="dashboard-modal-panel style-surat-modern" role="dialog" aria-modal="true" aria-labelledby="<?= $modal_id ?>-title" onclick="event.stopPropagation()">
    
    <!-- Modal Header -->
    <div class="dashboard-modal-header">
      <div class="dashboard-modal-header-content">
        <div class="dashboard-modal-header-icon">
          <i class="<?= html_escape($modal_icon) ?>"></i>
        </div>
        <div class="dashboard-modal-header-text">
          <h3 id="<?= $modal_id ?>-title" class="dashboard-modal-title"><?= html_escape($modal_title) ?></h3>
          <?php if (!empty($modal_ringkasan)) : ?>
            <p class="dashboard-modal-description"><?= html_escape($modal_ringkasan) ?></p>
          <?php endif ?>
        </div>
      </div>
      <button type="button" class="dashboard-modal-close" onclick="dashboardCloseModal('<?= $modal_id ?>')" aria-label="Tutup modal">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Modal Body -->
    <div class="dashboard-modal-body">
      
      <!-- Section: Persyaratan Title -->
      <div class="dashboard-modal-section-head">
        <i class="fas fa-clipboard-list dashboard-modal-section-icon"></i>
        <h4 class="dashboard-modal-section-title">Persyaratan yang Harus Disiapkan</h4>
      </div>

      <!-- Stepper / Timeline List -->
      <div class="dashboard-modal-stepper">
        <?php 
          $total_syarat = count((array) $modal_persyaratan);
          foreach ((array) $modal_persyaratan as $index => $syarat) : 
            $step_num = $index + 1;
            $is_last = ($step_num === $total_syarat);
        ?>
          <div class="dashboard-modal-step-item">
            <div class="dashboard-modal-step-indicator">
              <div class="dashboard-modal-step-badge"><?= $step_num ?></div>
              <?php if (!$is_last) : ?>
                <div class="dashboard-modal-step-line"></div>
              <?php endif ?>
            </div>
            <div class="dashboard-modal-step-card">
              <span><?= html_escape($syarat) ?></span>
            </div>
          </div>
        <?php endforeach ?>
      </div>

      <!-- Note / Catatan Box -->
      <?php if (!empty($modal_catatan)) : ?>
        <div class="dashboard-modal-note-box">
          <div class="dashboard-modal-note-icon">
            <i class="fas fa-info"></i>
          </div>
          <div class="dashboard-modal-note-content">
            <h5 class="dashboard-modal-note-title">Sudah melengkapi syarat?</h5>
            <p class="dashboard-modal-note-desc"><?= html_escape($modal_catatan) ?></p>
          </div>
        </div>
      <?php endif ?>

      <!-- TOMBOL PENGAJUAN -->
      <div class="dashboard-modal-action">
        <a href="https://forms.gle/qLZyJsJD9dDx1aC37" target="_blank" rel="noopener noreferrer" class="btn-ajukan-surat">
          <i class="fas fa-paper-plane"></i> Upload Dokumen & Ajukan Surat
        </a>
      </div>

    </div>
  </div>
</div>

<script>
  (function () {
    var modalId = '<?= $modal_id ?>';
    var modal = document.getElementById(modalId);

    if (!modal) {
      return;
    }

    if (!window.dashboardOpenModal) {
      window.dashboardOpenModal = function (event, id) {
        if (event) {
          event.preventDefault();
        }

        var target = document.getElementById(id);
        if (!target) {
          return;
        }

        target.hidden = false;
        target.style.display = 'flex';
        target.classList.add('is-open');
        target.setAttribute('aria-hidden', 'false');
        document.body.classList.add('dashboard-modal-is-open');
      };
    }

    if (!window.dashboardCloseModal) {
      window.dashboardCloseModal = function (id) {
        var target = document.getElementById(id);
        if (!target) {
          return;
        }

        target.hidden = true;
        target.style.display = 'none';
        target.classList.remove('is-open');
        target.setAttribute('aria-hidden', 'true');

        if (document.querySelectorAll('.dashboard-modal-backdrop.is-open').length === 0) {
          document.body.classList.remove('dashboard-modal-is-open');
        }
      };
    }

    if (!window.dashboardModalKeydownBound) {
      window.dashboardModalKeydownBound = true;

      document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') {
          return;
        }

        var openModals = document.querySelectorAll('.dashboard-modal-backdrop.is-open');
        if (!openModals.length) {
          return;
        }

        var lastModal = openModals[openModals.length - 1];
        if (lastModal && lastModal.id) {
          window.dashboardCloseModal(lastModal.id);
        }
      });
    }

    window.dashboardCloseModal(modalId);
  })();
</script>