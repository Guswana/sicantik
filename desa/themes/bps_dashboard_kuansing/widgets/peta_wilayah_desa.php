<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
require_once dirname(__DIR__) . '/commons/mapbox_helper.php';

$mapbox_key = bps_dashboard_kuansing_mapbox_key();
$map_external_url = $mapbox_key
  ? 'https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11.html?title=false&access_token=' . $mapbox_key . '#15/' . $data_config['lat'] . '/' . $data_config['lng']
  : 'https://www.openstreetmap.org/#map=15/' . $data_config['lat'] . '/' . $data_config['lng'];
?>

<div class="box box-primary box-solid">
  <div class="box-header">
    <h3 class="box-title">
      <i class="fas fa-map-marker-alt mr-1"></i><?= $judul_widget ?>
    </h3>
  </div>
  <div class="box-body">
    <div id="map_wilayah" style="height:200px;"></div>
    <a href="<?= $map_external_url ?>" class="text-link" target="_blank" rel="noopener noreferrer">Buka peta</a>
  </div>
</div>

<script>
  //Jika posisi kantor desa belum ada, maka posisi peta akan menampilkan seluruh Indonesia
  <?php if (!empty($data_config['lat']) && !empty($data_config['lng'])): ?>
    var posisi = BpsDashboardKuansingMapbox.toLngLat(<?= json_encode($data_config['lat']) ?>, <?= json_encode($data_config['lng']) ?>);
    var zoom = <?=$data_config['zoom'] ?: 10?>;
  <?php else: ?>
    var posisi = BpsDashboardKuansingMapbox.toLngLat(-1.0546279422758742, 116.71875000000001);
    var zoom = 10;
  <?php endif; ?>

  var mapboxKey = <?= json_encode($mapbox_key) ?>;
  var jenisPetaDefault = mapboxKey ? "5" : "<?= setting('jenis_peta') ?>";
  var hasPolygon = <?= !empty($data_config['path']) ? 'true' : 'false' ?>;
  var hasFittedBounds = false;
  var polygonDesa = <?= !empty($data_config['path']) ? $data_config['path'] : 'null' ?>;

  BpsDashboardKuansingMapbox.createMap({
    accessToken: mapboxKey,
    center: posisi,
    container: 'map_wilayah',
    maxZoom: <?= setting('max_zoom_peta') ?>,
    minZoom: <?= setting('min_zoom_peta') ?>,
    onStyleLoad: function (map) {
      var polygonFeature;

      if (!hasPolygon) {
        return;
      }

      polygonFeature = BpsDashboardKuansingMapbox.renderPolygon(map, {
        fillColor: '#E9F600',
        fillOpacity: 0.5,
        lineColor: '#FF0000',
        lineWidth: 2,
        path: polygonDesa,
        popupHtml: 'Wilayah Desa',
        sourceId: 'bps-dashboard-blue-wilayah-desa',
      });

      if (!hasFittedBounds && polygonFeature) {
        BpsDashboardKuansingMapbox.fitFeatureBounds(map, polygonFeature, { padding: 16 });
        hasFittedBounds = true;
      }
    },
    showNavigation: true,
    showStyleSwitcher: true,
    styleControlPosition: 'top-right',
    styleId: jenisPetaDefault,
    zoom: zoom,
  });
</script>
