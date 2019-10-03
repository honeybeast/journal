 
<?php $breadcrumbs = Breadcrumbs::generate('orders'); ?> 
<?php $__env->startSection('breadcrumbs'); ?> 
    <?php if(count($breadcrumbs)): ?>
        <ol class="sj-breadcrumb">
            <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                <?php if($breadcrumb->url && !$loop->last): ?>
                    <li><a href="<?php echo e($breadcrumb->url); ?>"><?php echo e($breadcrumb->title); ?></a></li>
                <?php else: ?>
                    <li class="active"><?php echo e($breadcrumb->title); ?></li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div id="sj-twocolumns" class="sj-twocolumns">
            <?php echo $__env->make('includes.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right">
                <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                    <div class="sj-dashboardboxtitle sj-titlewithform">
                        <h2><?php echo e(trans('prs.ph_order')); ?></h2>
                    </div>
                    <div class="sj-manageallsession">
                        <?php if($purchases->count() > 0): ?>
                            <ul class="sj-allcategorys sj-orders-holder">
                                <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="sj-categorysinfo">
                                        <div class="sj-title">
                                            <h3><?php echo e($product->article_title); ?></h3>
                                        </div>
                                        <div class="sj-categorysrightarea">
                                            <a title="Download" href="<?php echo e(route('getPublishFile', $product->article_publish_document)); ?>">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            <a href="<?php echo e(url('/superadmin/products/invoice/'.$product->id)); ?>">
                                                <span><?php echo e(trans('prs.generate_invoice')); ?></span>
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?> 
                        <?php if( method_exists($purchases,'links') ): ?>
                            <?php echo e($purchases->links('pagination.custom')); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>