<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="breadcrumb">
    <ol>
        <li><a href="<?= site_url() ?>">Beranda</a></li>
        <li>Data Statistik</li>
    </ol>
</div>
<h1 class="text-h2">Data Penduduk Menurut <?= $heading ?></h1>
<div class="flex justify-between items-center space-x-1 py-5">
    <h2 class="text-h4">Grafik <?= $heading ?></h2>
    <div class="text-right space-x-2 text-sm space-y-2 md:space-y-0">
        <button class="btn btn-secondary button-switch" data-type="column">Bar Graph</button>
        <button class="btn btn-secondary button-switch is-active" data-type="pie">Pie Graph</button>
        <button class="btn btn-secondary" id="downloadExcel"><i class="fa fa-file-excel-o"></i> Unduh Excel</button>
    </div>
</div>
<div id="statistics"></div>
<h2 class="text-h4">Tabel <?= $heading ?></h2>
<div class="content py-3">
    <div class="table-responsive">
        <table class="w-full text-sm">
            <thead>
                <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kelompok</th>
                <th colspan="2">Jumlah</th>
                <th colspan="2">Laki-laki</th>
                <th colspan="2">Perempuan</th>
                </tr>
                <tr>
                <th>n</th>
                <th>%</th>
                <th>n</th>
                <th>%</th>
                <th>n</th>
                <th>%</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0; $l=0; $p=0; $hide=''; $h=0; $jm1=1; $jm = count($stat ?? []);?>
                <?php foreach ($stat as $data):?>
                <?php $jm1++; if (1):?>
                <?php $h++; if ($h > 12 AND $jm > 10): $hide='more'; ?>
                <?php endif;?>
                <tr class="<?=$hide?>">
                    <td class="text-center">
                    <?php if ($jm1 > $jm - 2):?>
                        <?=$data['no']?>
                    <?php else:?>
                        <?=$h?>
                    <?php endif;?>
                    </td>
                    <td><?=$data['nama']?></td>
                    <td class="text-right <?php ($jm1 <= $jm - 2) and ($data['jumlah'] == 0) and print('zero')?>"><?=$data['jumlah']?>
                    </td>
                    <td class="text-right"><?=$data['persen']?></td>
                    <td class="text-right"><?=$data['laki']?></td>
                    <td class="text-right"><?=$data['persen1']?></td>
                    <td class="text-right"><?=$data['perempuan']?></td>
                    <td class="text-right"><?=$data['persen2']?></td>
                </tr>
                <?php $i += $data['jumlah'];?>
                <?php $l += $data['laki']; $p += $data['perempuan'];?>
                <?php endif;?>
                <?php endforeach;?>
            </tbody>
        </table>
        <p style="color: red">
            Diperbarui pada : <?= tgl_indo($last_update); ?>
        </p>
    </div>
    <div class="flex justify-between py-5">
        <?php if($hide == 'more') : ?>
            <button class="btn btn-primary button-more" id="showData">Selengkapnya...</button>
        <?php endif ?>
        <button id="showZero" class="btn btn-secondary">Tampilkan Nol</button>
    </div>

    <?php if ($this->setting->daftar_penerima_bantuan && $bantuan) : ?>
        <script>
        const bantuanUrl = '<?= site_url('first/ajax_peserta_program_bantuan')?>';
        </script>

        <input id="stat" type="hidden" value="<?=$st?>">
        <h2 class="text-h4">Daftar <?= $heading ?></h2>

        <div class="table-responsive content py-3">
            <table class="w-full text-sm" id="peserta_program">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Program</th>
                        <th>Nama Peserta</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
    .button-switch.is-active {
        background-color: #efefef;
        color: #999;
    }
</style>
<script>
    const dataStats = Object.values(<?= json_encode($stat) ?>);

    document.getElementById('downloadExcel').addEventListener('click', function() {
        var table = document.querySelector('.table-responsive table');
        if (!table) return;

        var wb = XLSX.utils.book_new();
        var wsData = [];

        // Header row 1
        wsData.push(['No', 'Kelompok', 'Jumlah', '', 'Laki-laki', '', 'Perempuan', '']);
        // Header row 2
        wsData.push(['', '', 'n', '%', 'n', '%', 'n', '%']);

        // Data rows
        var dataRows = table.querySelectorAll('tbody tr');
        var rowNum = 0;
        dataRows.forEach(function(row) {
            var cells = row.querySelectorAll('td');
            if (cells.length >= 8) {
                rowNum++;
                wsData.push([
                    rowNum,
                    cells[1].textContent.trim(),
                    parseFloat(cells[2].textContent.trim().replace(/,/g, '')) || 0,
                    cells[3].textContent.trim(),
                    parseFloat(cells[4].textContent.trim().replace(/,/g, '')) || 0,
                    cells[5].textContent.trim(),
                    parseFloat(cells[6].textContent.trim().replace(/,/g, '')) || 0,
                    cells[7].textContent.trim()
                ]);
            }
        });

        var ws = XLSX.utils.aoa_to_sheet(wsData);

        // Set column widths
        ws['!cols'] = [
            { wch: 5 },   // No
            { wch: 25 },  // Kelompok
            { wch: 10 },  // Jumlah n
            { wch: 10 },  // Jumlah %
            { wch: 12 },  // Laki-laki n
            { wch: 12 },  // Laki-laki %
            { wch: 14 },  // Perempuan n
            { wch: 14 }   // Perempuan %
        ];

        // Merge header cells
        ws['!merges'] = [
            { s: { r: 0, c: 0 }, e: { r: 1, c: 0 } },  // No
            { s: { r: 0, c: 1 }, e: { r: 1, c: 1 } },  // Kelompok
            { s: { r: 0, c: 2 }, e: { r: 0, c: 3 } },  // Jumlah
            { s: { r: 0, c: 4 }, e: { r: 0, c: 5 } },  // Laki-laki
            { s: { r: 0, c: 6 }, e: { r: 0, c: 7 } }   // Perempuan
        ];

        XLSX.utils.book_append_sheet(wb, ws, 'Data Statistik');

        var fileName = 'Data_Penduduk_Menurut_<?= strtolower(str_replace(' ', '_', $heading)) ?>_' + new Date().toISOString().slice(0,10) + '.xlsx';
        XLSX.writeFile(wb, fileName);
    });
</script>