<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
require_once dirname(__DIR__) . '/commons/mapbox_helper.php';

$mapbox_key = bps_dashboard_kuansing_mapbox_key();
$map_external_url = $mapbox_key
  ? 'https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11.html?title=false&access_token=' . $mapbox_key . '#15/' . $data_config['lat'] . '/' . $data_config['lng']
  : 'https://www.openstreetmap.org/#map=15/' . $data_config['lat'] . '/' . $data_config['lng'];

$detail_panel_id = 'detail-kantor-' . substr(md5((string) $judul_widget . '-' . ($desa['nama_desa'] ?? '')), 0, 10);
?>

<div class="box box-primary box-solid">
  <div class="box-header">
    <h3 class="box-title">
      <i class="fas fa-map-marker-alt mr-1"></i><?= $judul_widget ?>
    </h3>
  </div>
  <div class="box-body">
    <div id="map_canvas" style="height:200px;"></div>
    <a class="btn btn-accent btn-block mt-5 text-center" href="<?= html_escape($map_external_url) ?>" target="_blank" rel="noopener noreferrer">Buka Peta</a>
    <button type="button" class="btn btn-accent btn-block mt-5 js-kantor-detail-toggle" data-target="#<?= html_escape($detail_panel_id) ?>" aria-expanded="false" aria-controls="<?= html_escape($detail_panel_id) ?>">
      Detail
    </button>
    <div id="<?= html_escape($detail_panel_id) ?>" class="dashboard-kantor-detail" hidden>
      <div class="dashboard-kantor-detail__header">
        <h5>Detail <?= html_escape(ucwords($this->setting->sebutan_desa)) ?></h5>
      </div>
      <div class="dashboard-kantor-detail__body">
        <table class="dashboard-kantor-detail__table">
          <tbody>
            <tr>
              <td>Alamat</td>
              <td>: </td>
              <td> <?= html_escape($desa['alamat_kantor']) ?></td>
            </tr>
            <tr>
              <td><?= html_escape(ucwords($this->setting->sebutan_desa)) ?></td>
              <td>: </td>
              <td> <?= html_escape($desa['nama_desa']) ?></td>
            </tr>
            <tr>
              <td><?= html_escape(ucwords($this->setting->sebutan_kecamatan)) ?></td>
              <td>: </td>
              <td> <?= html_escape($desa['nama_kecamatan']) ?></td>
            </tr>
            <tr>
              <td><?= html_escape(ucwords($this->setting->sebutan_kabupaten)) ?></td>
              <td>: </td>
              <td> <?= html_escape($desa['nama_kabupaten']) ?></td>
            </tr>
            <tr>
              <td>Kodepos</td>
              <td>: </td>
              <td> <?= html_escape($desa['kode_pos']) ?></td>
            </tr>
            <tr>
              <td>Telepon</td>
              <td>: </td>
              <td> <?= html_escape($desa['telepon']) ?></td>
            </tr>
            <tr>
              <td>Email</td>
              <td>: </td>
              <td> <?= html_escape($desa['email_desa']) ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<style>
  .dashboard-kantor-detail {
    margin-top: 1rem;
    border: 1px solid rgba(0, 0, 0, 0.14);
    border-radius: 0.85rem;
    background: #FFFEF8;
    overflow: hidden;
  }

  .dashboard-kantor-detail__header {
    padding: 0.8rem 1rem;
    background: linear-gradient(120deg, rgba(0, 0, 0, 0.06) 0%, rgba(233, 246, 0, 0.04) 100%);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  }

  .dashboard-kantor-detail__header h5 {
    margin: 0;
    font-size: 0.95rem;
    font-weight: 700;
    color: #000000;
  }

  .dashboard-kantor-detail__body {
    padding: 0;
  }

  .dashboard-kantor-detail__table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.82rem;
    color: #888888;
  }

  .dashboard-kantor-detail__table td {
    padding: 0.42rem 0.75rem;
    vertical-align: top;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
  }

  .dashboard-kantor-detail__table tr:last-child td {
    border-bottom: 0;
  }

  .dashboard-kantor-detail__table td:first-child {
    width: 31%;
    padding-left: 0.55rem;
    padding-right: 0.35rem;
    font-weight: 700;
    color: #000000;
  }

  .dashboard-kantor-detail__table td:nth-child(2) {
    width: 18px;
    min-width: 18px;
    padding-left: 0;
    padding-right: 0;
    text-align: center;
    color: #666666;
  }

  .dashboard-kantor-detail__table td:last-child {
    padding-left: 0.1rem;
    overflow-wrap: anywhere;
    word-break: break-word;
  }

  .dashboard-kantor-detail[hidden] {
    display: none !important;
  }
</style>


<script>
  //Jika posisi kantor desa belum ada, maka posisi peta akan menampilkan seluruh Indonesia
  <?php if (!empty($data_config['lat']) && !empty($data_config['lng'])): ?>
    var posisi = BpsDashboardKuansingMapbox.toLngLat(<?= json_encode($data_config['lat']) ?>, <?= json_encode($data_config['lng']) ?>);
    var zoom = <?=$data_config['zoom'] ?: 10?>;
    var hasKantorMarker = true;
  <?php else: ?>
    var posisi = BpsDashboardKuansingMapbox.toLngLat(-1.0546279422758742, 116.71875000000001);
    var zoom = 10;
    var hasKantorMarker = false;
  <?php endif; ?>

  var mapboxKey = <?= json_encode($mapbox_key) ?>;
  var jenisPetaDefault = mapboxKey ? "5" : "<?= setting('jenis_peta') ?>";
  BpsDashboardKuansingMapbox.createMap({
    accessToken: mapboxKey,
    center: posisi,
    container: 'map_canvas',
    maxZoom: <?= setting('max_zoom_peta') ?>,
    minZoom: <?= setting('min_zoom_peta') ?>,
    onLoad: function (map) {
      if (!hasKantorMarker) {
        return;
      }

      BpsDashboardKuansingMapbox.addMarker(map, {
        color: '#000000',
        lngLat: posisi,
      });
    },
    showNavigation: true,
    showStyleSwitcher: true,
    styleControlPosition: 'top-right',
    styleId: jenisPetaDefault,
    zoom: zoom,
  });

  document.querySelectorAll('.js-kantor-detail-toggle').forEach(function (button) {
    button.addEventListener('click', function () {
      var targetSelector = button.getAttribute('data-target');
      var detailPanel = targetSelector ? document.querySelector(targetSelector) : null;

      if (!detailPanel) {
        return;
      }

      var isHidden = detailPanel.hasAttribute('hidden');

      if (isHidden) {
        detailPanel.removeAttribute('hidden');
      } else {
        detailPanel.setAttribute('hidden', 'hidden');
      }

      button.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
    });
  });
</script>
