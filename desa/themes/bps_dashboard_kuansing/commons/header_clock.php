<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $is_mobile_clock = $is_mobile_clock ?? false; ?>

<div class="dashboard-topbar-datetime<?= $is_mobile_clock ? ' dashboard-topbar-datetime--mobile' : ' dashboard-topbar-datetime--desktop' ?>" data-dashboard-wib-clock>
  <div class="dashboard-topbar-datetime-icon" aria-hidden="true">
    <span class="dashboard-topbar-clock-face">
      <span class="dashboard-topbar-clock-hand dashboard-topbar-clock-hand--hour" data-clock-hour></span>
      <span class="dashboard-topbar-clock-hand dashboard-topbar-clock-hand--minute" data-clock-minute></span>
      <span class="dashboard-topbar-clock-hand dashboard-topbar-clock-hand--second" data-clock-second></span>
      <span class="dashboard-topbar-clock-center"></span>
    </span>
  </div>

  <div class="dashboard-topbar-datetime-meta">
    <span class="dashboard-topbar-datetime-date" data-dashboard-date>Selasa, 28 April 2026</span>
    <span class="dashboard-topbar-datetime-time">
      <strong data-dashboard-time>00:00:00 WIB</strong>
      <small>Waktu Indonesia Barat</small>
    </span>
  </div>
</div>
