<?php if($rilis['update_available']): ?>
    <div class="row">
        <div class='col-md-12'>
            <div class="callout callout-success update">
                <h4><i class="fa fa-bullhorn"></i>&nbsp;&nbsp;Pembaruan Tersedia!</h4>
                <p align="justify">
                    <?php echo e(config_item('nama_aplikasi')); ?> <code><?php echo e($rilis['latest_version']); ?></code> telah tersedia.
                    Periksa catatan rilis untuk melihat daftar perubahan di versi ini. Sangat dianjurkan untuk melakukan
                    pembaruan ke versi terkini, karena setiap rilis berisi perbaikan termasuk peningkatan keamanan data
                    sejak versi yang anda gunakan saat ini <code><?php echo e($rilis['current_version']); ?></code>. Petunjuk
                    melakukan pembaruan dapat dilihat di <a href="https://github.com/<?php echo e(config_item('nama_aplikasi')); ?>/<?php echo e(config_item('nama_aplikasi')); ?>/wiki/Panduan-Update-<?php echo e(config_item('nama_aplikasi')); ?>" target="_blank">sini</a>.
                </p>
                <button class="btn btn-social btn-info btn-sm" data-toggle="modal" data-target="#modal-catatan-rilis">
                    <i class="fa fa-book"></i> Catatan Rilis
                </button>
                <a href="<?php echo e($rilis['url_download']); ?>" class="btn btn-social bg-navy btn-sm" style="text-decoration: none">
                    <i class="fa fa-download none"></i> Unduh
                </a>
            </div>
            <div id="modal-catatan-rilis" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title"><i class="fa fa-book"></i>&nbsp;&nbsp;Catatan Rilis
                                <?php echo e(config_item('nama_aplikasi')); ?> <small class="label label-success"><?php echo e($rilis['latest_version']); ?></small></h4>
                        </div>
                        <div class="modal-body rilis">
                            <?php echo nl2br($rilis['release_body']); ?>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-social btn-danger btn-sm pull-left" data-dismiss="modal"><i class='fa fa-sign-out'></i> Tutup</button>
                            <a href="<?php echo e($rilis['url_download']); ?>" class="btn btn-social bg-navy btn-sm pull-right">
                                <i class="fa fa-download"></i> Unduh
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\sicantik\resources\views/admin/home/rilis.blade.php ENDPATH**/ ?>