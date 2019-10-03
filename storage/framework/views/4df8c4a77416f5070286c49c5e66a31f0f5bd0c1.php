 
<?php $__env->startSection('content'); ?>
    <div class="sj-404error">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 offset-sm-0 col-md-8 offset-md-2 col-lg-8 offset-lg-2">
                    <div class="sj-404content">
                        <div class="sj-404head">
                            <h2><?php echo e(trans('prs.access_denied')); ?></h2>
                            <?php $server_error = $exception->getMessage(); ?> 
                            <?php if(!empty($server_error)): ?>
                                <h3><?php echo e($server_error); ?></h3>
                            <?php else: ?>
                                <h3><?php echo e(trans('prs.no_access')); ?></h3>
                            <?php endif; ?>
                        </div>
                        <span class="sj-gobackhome"><?php echo e(trans('prs.go_back')); ?><a href="<?php echo e(url('/')); ?>"> <?php echo e(trans('prs.homepage')); ?> </a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>