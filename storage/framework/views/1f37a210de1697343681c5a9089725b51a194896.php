<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $__env->yieldContent('title'); ?></h6>
        </div>
        <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.config.update')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <labe>Site Title</labe>
                                <input type="text" name="title" required class="form-control" value="<?php echo e($config->title); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <labe>Site Access Status</labe>
                                <select class="form-control" name="active">
                                    <option <?php if($config->active == 1): ?> selected <?php endif; ?> value="1">Accessible</option>
                                    <option <?php if($config->active == 0): ?> selected <?php endif; ?> value="0">Inaccessible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <labe>Site Logo</labe>
                                <input type="file" name="logo" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <labe>Site Favicon</labe>
                                <input type="file" name="favicon" class="favicon">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <labe>Facebook</labe>
                                <input type="text" name="facebook" required class="facebook" value="<?php echo e($config->facebook); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <labe>Twitter</labe>
                                <input type="text" name="twitter" required class="twitter" value="<?php echo e($config->twitter); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <labe>Github</labe>
                                <input type="text" name="github" required class="github" value="<?php echo e($config->github); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <labe>Linkedin</labe>
                                <input type="text" name="linkedin" required class="linkedin" value="<?php echo e($config->linkedin); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <labe>Youtube</labe>
                                <input type="text" name="youtube" required class="youtube" value="<?php echo e($config->youtube); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <labe>Instagram</labe>
                                <input type="text" name="instagram" required class="instagram" value="<?php echo e($config->instagram); ?>">
                            </div>"
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-md btn-success">Update</button>
                    </div>
                </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Sefa\Desktop\blog\resources\views/back/config/index.blade.php ENDPATH**/ ?>