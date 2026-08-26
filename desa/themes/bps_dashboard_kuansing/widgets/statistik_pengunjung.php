<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $visitor_rows = [
    'Hari Ini' => number_format((int) ($statistik_pengunjung['hari_ini'] ?? 0), 0, ',', '.'),
    'Kemarin' => number_format((int) ($statistik_pengunjung['kemarin'] ?? 0), 0, ',', '.'),
    'Jumlah Pengunjung' => number_format((int) ($statistik_pengunjung['total'] ?? 0), 0, ',', '.'),
  ];
?>

<div class="box box-primary box-solid">
  <div class="box-header">
    <h3 class="box-title"><i class="fas fa-chart-line mr-1"></i><?= html_escape($judul_widget) ?></h3>
  </div>
  <div class="box-body p-0">
    <table class="dashboard-visitor-table" role="presentation">
      <tbody>
        <?php foreach ($visitor_rows as $label => $value) : ?>
          <tr>
            <td class="dashboard-visitor-table__label"><?= html_escape($label) ?></td>
            <td class="dashboard-visitor-table__separator">:</td>
            <td class="dashboard-visitor-table__value"><?= html_escape($value) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
