<?php if($notif_langganan): ?>
    <?php if($notif_langganan['status'] > 1): ?>
        <div class="row">
            <div class='col-md-12'>
                <div class="callout callout-warning">
                    <h4><i class="fa fa-bullhorn"></i>&nbsp;&nbsp;Pengingat Layanan Premium!</h4>
                    <p align="justify">
                        Pelanggan yang terhomat,
                        <br>
                        Ini adalah pengingat bahwa layanan Premium akan segera berakhir.
                        <br>
                        Silahkan lakukan perpanjangan layanan Premium agar tetap bisa update ke versi terbaru dari
                        <?= config_item('nama_aplikasi') ?>.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\sicantik\resources\views/admin/home/premium.blade.php ENDPATH**/ ?>