<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        <?php echo e($setting->admin_title . ' ' . ucwords($setting->sebutan_desa . ' ' . ($desa['nama_desa'] ?? '')) . get_dynamic_title_page_from_path()); ?>

    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="<?php echo e(favico_desa()); ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo e(base_url('rss.xml')); ?>" />
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo e(asset('bootstrap/css/bootstrap.min.css')); ?>" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('bootstrap/css/font-awesome.min.css')); ?>" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo e(asset('bootstrap/css/ionicons.min.css')); ?>" />
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo e(asset('bootstrap/css/select2.min.css')); ?>" />
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('css/AdminLTE.min.css')); ?>" />
    <!-- AdminLTE Skins. -->
    <link rel="stylesheet" href="<?php echo e(asset('css/skins/_all-skins.min.css')); ?>" />
    <!-- Sweetalert CSS-->
    <link rel="stylesheet" href="<?php echo e(asset('js/sweetalert2/sweetalert2.min.css')); ?>">
    <!-- Modifikasi -->
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-style.css')); ?>" />
    <!-- Loading Lazy -->
    <link rel="stylesheet" href="<?= asset('js/progressive-image/progressive-image.css') ?>">
    <?php echo $__env->yieldPushContent('css'); ?>
</head>

<body id="sidebar_collapse" class="<?php echo e($setting->warna_tema_admin); ?> fixed sidebar-mini">
    <div class="wrapper">

        <?php echo $__env->make('admin.layouts.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('admin.layouts.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <?php echo $__env->yieldContent('title'); ?>

                <?php echo $__env->make('admin.layouts.components.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </section>

            <section id="maincontent" class="content">

                <?php echo $__env->make('admin.layouts.partials.info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->yieldContent('content'); ?>

            </section>
        </div>

        <?php echo $__env->make('admin.pengaturan.pengaturan_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if($notif['pengumuman']): ?>
            <?php echo $__env->make('admin.layouts.components.pengumuman', $notif['pengumuman'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php echo $__env->make('admin.layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('admin.layouts.partials.control_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Untuk menampilkan modal bootstrap umum -->
        <div class="modal fade" id="modalBox" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="fetched-data"></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var SITE_URL = "<?php echo e(site_url()); ?>";
        var BASE_URL = "<?php echo e(base_url()); ?>";
    </script>
    <!-- jQuery 3 -->
    <script src="<?php echo e(asset('bootstrap/js/jquery.min.js')); ?>"></script>
    <?php if(config_item('csrf_protection')): ?>
        <!-- CSRF Token -->
        <script type="text/javascript">
            var csrfParam = "<?php echo e($token); ?>";
            var getCsrfToken = () => document.cookie.match(new RegExp(csrfParam + '=(\\w+)'))[1];
        </script>
        <script src="<?php echo e(asset('js/anti-csrf.js')); ?>"></script>
    <?php endif; ?>

    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo e(asset('bootstrap/js/bootstrap.min.js')); ?>"></script>
    <!-- Select2 -->
    <script src="<?php echo e(asset('bootstrap/js/select2.full.min.js')); ?>"></script>
    <!-- Slimscroll -->
    <script src="<?php echo e(asset('bootstrap/js/jquery.slimscroll.min.js')); ?>"></script>
    <!-- jquery validasi -->
    <script src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo e(asset('bootstrap/js/fastclick.js')); ?>"></script>
    <!-- AdminLTE -->
    <script src="<?php echo e(asset('js/adminlte.min.js')); ?>"></script>
    <!-- Sweetalert JS -->
    <script src="<?php echo e(asset('js/sweetalert2/sweetalert2.all.min.js')); ?>"></script>
    <!-- jquery validasi -->
    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin.js')); ?>"></script>
    <!-- Loading Lazy -->
    <script src="<?= asset('js/progressive-image/progressive-image.js') ?>"></script>
    <!-- Modifikasi -->
    <?php if(config_item('demo_mode')): ?>
        <!-- Website Demo -->
        <script src="<?php echo e(asset('js/demo.js')); ?>"></script>
    <?php endif; ?>
    <?php if(!setting('inspect_element')): ?>
        <script src="<?php echo e(asset('js/disabled.min.js')); ?>"></script>
    <?php endif; ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('ul.sidebar-menu').on('expanded.tree', function(e) {
                e.stopImmediatePropagation();
                setTimeout(scrollTampil($('li.treeview.menu-open')[0]), 500);
            });

            function scrollTampil(elem) {
                elem.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    </script>

    <?php if(isset($perbaharui_langganan) && !config_item('demo_mode')): ?>
        <!-- cek status langganan -->
        <script type="text/javascript">
            var controller = '<?php echo e($controller); ?>';
            $.ajax({
                    url: `<?= config_item('server_layanan') ?>/api/v1/pelanggan/pemesanan`,
                    headers: {
                        "Authorization": `Bearer <?php echo e($setting->layanan_opendesa_token); ?>`,
                        "X-Requested-With": `XMLHttpRequest`,
                    },
                    type: 'Post',
                })
                .done(function(response) {
                    let data = {
                        body: response
                    }
                    $.ajax({
                        url: `${SITE_URL}pelanggan/pemesanan`,
                        type: 'Post',
                        dataType: 'json',
                        data: data,
                    }).done(function() {
                        if (controller == 'pelanggan') {
                            location.reload();
                        }
                    });
                })
        </script>
    <?php endif; ?>
</body>

</html>
<?php /**PATH C:\laragon\www\sicantik\resources\views/admin/layouts/index.blade.php ENDPATH**/ ?>