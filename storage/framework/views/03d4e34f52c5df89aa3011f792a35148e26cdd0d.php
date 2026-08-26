<div class="modal fade in" id="pengaturan-bantuan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Pengaturan Program Bantuan</h4>
            </div>
            <?php echo form_open(ci_route('notif.update_setting'), 'id="main_bantuan"'); ?>

            <div class="modal-body">
                <div class="form-group">
                    <label>Program Bantuan Untuk Ditampilkan</label>
                    <select name="dashboard_program_bantuan" class="form-control input-sm select2">
                        <option value="">Semua Program Bantuan</option>
                        <?php $__currentLoopData = $bantuan['program']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e(selected($id, $setting->dashboard_program_bantuan)); ?>><?php echo e($nama); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-social btn-danger btn-sm"><i class="fa fa-times"></i> Batal</button>
                <button type="submit" class="btn btn-social btn-info btn-sm" id="ok"><i class="fa fa-check"></i> Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
            $("#main_bantuan").validate();
        })
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\sicantik\resources\views/admin/home/bantuan.blade.php ENDPATH**/ ?>