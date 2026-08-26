<?php $__env->startPush('css'); ?>
    <style>
        .catatan-scroll {
            height: 400px;
            overflow-y: scroll;
        }

        @media (max-width: 576px) {
            .komunikasi-opendk {
                display: none !important;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title'); ?>
    <h1>
        Tentang <?= config_item('nama_aplikasi') ?>
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="active">Tentang <?= config_item('nama_aplikasi') ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.layouts.components.notifikasi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('admin.home.saas', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('admin.home.premium', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('admin.home.rilis', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('admin.home.bantuan', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <?php if(can('b', 'wilayah-administratif')): ?>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3><?php echo e($dusun); ?></h3>
                        <p><?php echo e(SebutanDesa('Wilayah [Desa]')); ?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-location"></i>
                    </div>
                    <a href="<?php echo e(ci_route('wilayah')); ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>

        <?php if(can('b', 'penduduk')): ?>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo e($penduduk); ?></h3>
                        <p>Penduduk</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="<?php echo e(ci_route('penduduk.clear')); ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>

        <?php if(can('b', 'keluarga')): ?>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo e($keluarga); ?></h3>
                        <p>Keluarga</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-people"></i>
                    </div>
                    <a href="<?php echo e(ci_route('keluarga.clear')); ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>

        <?php if(can('b', 'arsip-layanan')): ?>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3><?php echo e($surat); ?></h3>
                        <p>Surat Tercetak</p>
                    </div>
                    <div class="icon">
                        <i class="ion-ios-paper"></i>
                    </div>
                    <a href="<?php echo e(ci_route('keluar')); ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>

        <?php if(can('b', 'kelompok')): ?>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo e($kelompok); ?></h3>
                        <p>Kelompok</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-people"></i>
                    </div>
                    <a href="<?php echo e(ci_route('kelompok.clear')); ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>

        <?php if(can('b', 'rumah-tangga')): ?>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-gray">
                    <div class="inner">
                        <h3><?php echo e($rtm); ?></h3>
                        <p>Rumah Tangga</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-home"></i>
                    </div>
                    <a href="<?php echo e(ci_route('rtm.clear')); ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>

        <?php if(can('b', 'bantuan')): ?>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo e($bantuan['jumlah']); ?></h3>
                        <p><?php echo e($bantuan['nama']); ?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pie"></i>
                    </div>
                    <div class="small-box-footer">
                        <a href="#" class="inner text-white rilis_pengaturan" data-remote="false" data-toggle="modal" data-target="#pengaturan-bantuan"><i class="fa fa-gear"></i></a>
                        <?php if(can('b', 'statistik')): ?>
                            <a href="<?php echo e(ci_route($bantuan['link_detail'])); ?>" class="inner text-white">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                        <?php else: ?>
                            &nbsp;
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(can('b', 'pendaftar-layanan-mandiri')): ?>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box" style="background-color: #39CCCC;">
                    <div class="inner">
                        <h3><?php echo e($pendaftaran); ?></h3>
                        <p>Verifikasi Layanan Mandiri</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="<?php echo e(ci_route('mandiri')); ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sicantik\resources\views/admin/home/index.blade.php ENDPATH**/ ?>