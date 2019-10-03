<?php $__env->startSection('title'); ?><?php echo e($page->title); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('description', "$meta_desc"); ?>
<?php $breadcrumbs = Breadcrumbs::generate('showPage',$page,$slug); ?>
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
    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9 float-left" id="article">
                    <div class="sj-aboutus">
                        <div class="sj-introduction sj-sectioninnerspace">
                            <span><?php echo e($page->sub_title); ?></span>
                            <h4><?php echo e($page->title); ?></h4>
                        </div>
                        <div class="sj-description">
                            <?php echo htmlspecialchars_decode(stripslashes($page->body)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-3 float-left" id="article">
                    <?php echo $__env->make('includes.detailsidebar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>