<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (!function_exists('dashboard_resolve_surat_modal_id')): $helper = FCPATH . $this->theme_folder . '/' . $this->theme . '/partials/surat_modal_helpers.php'; if (file_exists($helper)) { require_once $helper; } endif; ?>

<div class="dashboard-header-wrap">
  <div class="container md:px-4 lg:px-4">
    <?php $this->load->view($folder_themes .'/commons/main_menu') ?>
    <?php $this->load->view($folder_themes .'/commons/mobile_menu') ?>
  </div>
</div>

<script>
  (function () {
    const roots = document.querySelectorAll('[data-dashboard-wib-clock]');

    if (!roots.length) {
      return;
    }

    const timezone = 'Asia/Jakarta';
    const dateFormatter = new Intl.DateTimeFormat('id-ID', {
      weekday: 'long',
      day: 'numeric',
      month: 'long',
      year: 'numeric',
      timeZone: timezone,
    });
    const timePartsFormatter = new Intl.DateTimeFormat('en-GB', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      hour12: false,
      timeZone: timezone,
    });
    const rotationState = new WeakMap();

    function capitalize(text) {
      return text ? text.charAt(0).toUpperCase() + text.slice(1) : text;
    }

    function partsFromDate(date) {
      const parts = {};

      timePartsFormatter.formatToParts(date).forEach(function (part) {
        if (part.type !== 'literal') {
          parts[part.type] = part.value;
        }
      });

      return {
        hour: parseInt(parts.hour, 10),
        minute: parseInt(parts.minute, 10),
        second: parseInt(parts.second, 10),
      };
    }

    function setHandRotation(root, selector, key, rotation) {
      const hand = root.querySelector(selector);

      if (!hand) {
        return;
      }

      const state = rotationState.get(root) || {};
      let nextRotation = rotation;

      if (typeof state[key] === 'number') {
        while (nextRotation <= state[key]) {
          nextRotation += 360;
        }
      }

      state[key] = nextRotation;
      rotationState.set(root, state);
      hand.style.transform = 'translateX(-50%) rotate(' + nextRotation + 'deg)';
    }

    function updateClock(root) {
      const now = new Date();
      const parts = partsFromDate(now);
      const hourRotation = ((parts.hour % 12) + (parts.minute / 60) + (parts.second / 3600)) * 30;
      const minuteRotation = (parts.minute + (parts.second / 60)) * 6;
      const secondRotation = parts.second * 6;
      const dateElement = root.querySelector('[data-dashboard-date]');
      const timeElement = root.querySelector('[data-dashboard-time]');

      if (dateElement) {
        dateElement.textContent = capitalize(dateFormatter.format(now));
      }

      if (timeElement) {
        timeElement.textContent = String(parts.hour).padStart(2, '0') + ':' + String(parts.minute).padStart(2, '0') + ':' + String(parts.second).padStart(2, '0') + ' WIB';
      }

      setHandRotation(root, '[data-clock-hour]', 'hour', hourRotation);
      setHandRotation(root, '[data-clock-minute]', 'minute', minuteRotation);
      setHandRotation(root, '[data-clock-second]', 'second', secondRotation);
    }

    function init() {
      roots.forEach(function (root) {
        updateClock(root);
        window.setInterval(function () {
          updateClock(root);
        }, 1000);
      });
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', init, { once: true });
      return;
    }

    init();
  })();
</script>
