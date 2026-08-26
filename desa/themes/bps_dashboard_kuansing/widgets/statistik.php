<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $statistik_url = 'data-statistik/rentang-umur';
  foreach ((daftar_statistik()['penduduk'] ?? []) as $submenu) {
    if (($submenu['slug'] ?? null) === 'rentang-umur') {
      $statistik_url = $submenu['url'] ?? null;
      break;
    }
  }

  $statistik_href = $statistik_url && $this->web_menu_model->menu_aktif('statistik/13')
    ? site_url($statistik_url)
    : null;
?>

<?php if ($statistik_href) : ?>
<a href="<?= $statistik_href ?>" class="dashboard-statistik-widget-link">
<?php endif ?>
<div class="box box-primary box-solid">
  <div class="box-header">
    <h3 class="box-title"><span><i class="fa fa-chart-pie mr-2 mr-1"></i><?= $judul_widget ?></span></h3>
  </div>
  <div class="box-body">
    <script type="text/javascript">
      $(function ()
      {
        var chart_widget;
        $(document).ready(function ()
        {
          // Build the chart
          chart_widget = new Highcharts.Chart(
          {
            chart:
            {
              renderTo: 'container_widget',
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false
            },
            title:
            {
              text: 'Jumlah Penduduk'
            },
            yAxis:
            {
              title:
              {
                text: 'Jumlah'
              }
            },
            xAxis:
            {
              categories:
              [
                <?php foreach($stat_widget as $data): ?>
                  <?php if ($data['jumlah'] > 0 AND $data['nama']!= "JUMLAH"): ?>
                    ['<?= $data['jumlah']?> <br> <?= $data['nama']?>'],
                  <?php endif; ?>
                <?php endforeach; ?>
              ]
            },
            legend:
            {
              enabled:false
            },
            plotOptions:
            {
              series:
              {
                colorByPoint: true
              },
              column:
              {
                pointPadding: 0,
                borderWidth: 0
              }
            },
            series: [
            {
              type: 'column',
              name: 'Populasi',
              data: [
                <?php foreach($stat_widget as $data): ?>
                  <?php if ($data['jumlah'] > 0 AND $data['nama']!= "JUMLAH"): ?>
                    ['<?= $data['nama']?>',<?= $data['jumlah']?>],
                  <?php endif; ?>
                <?php endforeach; ?>
              ]
            }]
          });
        });
      });
    </script>
    <div id="container_widget" style="width: 100%; height: 300px; margin: 0 auto"></div>
  </div>
</div>
<?php if ($statistik_href) : ?>
</a>
<?php endif ?>
