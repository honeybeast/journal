<?php $__env->startSection('title'); ?><?php echo e(!empty($article) ? $article->title : ''); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('description', "$meta_desc"); ?>
<?php $__env->startSection('breadcrumbs'); ?>
    <?php $breadcrumbs = Breadcrumbs::generate('articleDetail', $edition_slug, $edition_title, $article); ?>
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
    <?php
        $author = App\User::getUserDataByID($article->corresponding_author_id);
        $edition_image = App\Helper::getEditionImage($article->edition_id);
    ?>
    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div id="sj-content" class="sj-content">
                        <div class="sj-articledetail">
                            <ul class="sj-downloadprint">
                                <?php if(App\SiteManagement::getMetaValue('payment_mode') === 'individual-product'): ?>
                                    <li>
                                        <a href="<?php echo e(url('/user/products/checkout/'.$article->id)); ?>">
                                            <?php echo e(trans('prs.buy_just_in')); ?> <span class="currency"><?php echo e(App\Helper::getCurrencySymbol($currency_symbol)); ?><?php echo e(App\Helper::getProductPrice($article->id)); ?></span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a href="<?php echo e(route('getPublishFile', $article->publish_document)); ?>">
                                            <i class="fa fa-download"></i><?php echo e(trans('prs.btn_download')); ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            <?php if(!empty($edition_image)): ?>
                                <figure class="sj-articledetailimg">
                                    <img src="<?php echo e(asset($edition_image)); ?>" alt="<?php echo e(trans('prs.article_img')); ?>">
                                </figure>
                            <?php endif; ?>
                            <div class="sj-articledescription sj-sectioninnerspace">
                                <span class="sj-username"><?php echo e($author->name); ?></span>
                                <h4><?php echo e($article->title); ?></h4>
                                <div class="sj-description">
                                    <?php echo htmlspecialchars_decode(stripslashes($article->abstract)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                    <?php echo $__env->make('includes.detailsidebar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>