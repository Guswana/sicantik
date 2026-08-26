<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  if ($jam_kerja) {
    $jam_kerja_items = is_array($jam_kerja)
      ? $jam_kerja
      : ($jam_kerja instanceof Traversable ? iterator_to_array($jam_kerja, false) : []);

    $normalisasi_hari = static function ($hari) {
      return preg_replace('/[^a-z]/', '', strtolower(trim((string) $hari)));
    };

    $urutan_hari = [
      'senin' => 1,
      'selasa' => 2,
      'rabu' => 3,
      'kamis' => 4,
      'jumat' => 5,
      'sabtu' => 6,
      'minggu' => 7,
      'ahad' => 7,
    ];

    $format_jam = static function ($jam) {
      if (empty($jam)) {
        return '-';
      }

      $timestamp = strtotime((string) $jam);

      return $timestamp ? date('H:i', $timestamp) : (string) $jam;
    };

    usort($jam_kerja_items, static function ($a, $b) use ($normalisasi_hari, $urutan_hari) {
      $hari_a = $normalisasi_hari($a->nama_hari ?? '');
      $hari_b = $normalisasi_hari($b->nama_hari ?? '');
      $urutan_a = $urutan_hari[$hari_a] ?? 99;
      $urutan_b = $urutan_hari[$hari_b] ?? 99;

      if ($urutan_a === $urutan_b) {
        return strcmp((string) ($a->nama_hari ?? ''), (string) ($b->nama_hari ?? ''));
      }

      return $urutan_a <=> $urutan_b;
    });
  }
?>

<?php if ($jam_kerja) : ?>
  <style>
    .dashboard-jam-kerja {
      border: 1px solid #E2DCC8;
      border-radius: 12px;
      overflow: hidden;
      background: #ffffff;
    }

    .dashboard-jam-kerja table {
      width: 100%;
      border-collapse: collapse;
      color: #1f2937;
    }

    .dashboard-jam-kerja thead th {
      padding: 12px 14px;
      text-align: center;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.02em;
      color: #ffffff;
      background: linear-gradient(135deg, #000000 0%, #0E0202 100%);
    }

    .dashboard-jam-kerja tbody td {
      padding: 12px 14px;
      border-bottom: 1px solid #ECE5D0;
      background: #ffffff;
      font-size: 13px;
    }

    .dashboard-jam-kerja tbody tr:nth-child(even) td {
      background: #FFFFFF;
    }

    .dashboard-jam-kerja tbody tr:last-child td {
      border-bottom: 0;
    }

    .dashboard-jam-kerja tbody td:first-child {
      font-weight: 600;
      color: #0f172a;
    }

    .dashboard-jam-kerja tbody td:not(:first-child) {
      text-align: center;
      color: #334155;
    }

    .dashboard-jam-kerja__status {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 9999px;
      background: #F5D8D7;
      color: #8F4D4C;
      font-size: 12px;
      font-weight: 700;
      line-height: 1.4;
    }
  </style>

  <div class="box box-primary box-solid">
    <div class="box-header">
      <h3 class="box-title">
        <i class="fa fa-clock-o mr-1"></i> <?= html_escape($judul_widget) ?>
      </h3>
    </div>
    <div class="box-body">
      <div class="dashboard-jam-kerja overflow-x-auto">
        <table cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>Hari</th>
              <th>Mulai</th>
              <th>Selesai</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($jam_kerja_items as $value) : ?>
              <tr>
                <td><?= html_escape($value->nama_hari) ?></td>
                <?php if ($value->status) : ?>
                  <td><?= html_escape($format_jam($value->jam_masuk)) ?></td>
                  <td><?= html_escape($format_jam($value->jam_keluar)) ?></td>
                <?php else : ?>
                  <td colspan="2"><span class="dashboard-jam-kerja__status">Libur</span></td>
                <?php endif ?>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php endif ?>
