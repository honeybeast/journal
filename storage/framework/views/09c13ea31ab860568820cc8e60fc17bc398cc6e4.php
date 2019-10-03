<?php $__env->startSection('title'); ?><?php echo e($published_articles[0]->edition_title); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('description', 'This is description tag'); ?>
<?php $__env->startSection('breadcrumbs'); ?>
    <?php $breadcrumbs = Breadcrumbs::generate('editListing', $slug, $title); ?>
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
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-left">
                    <div id="sj-content" class="sj-content">
                        <?php if(!empty($published_articles)): ?>
                            <section class="sj-haslayout sj-sectioninnerspace">
                                <div class="sj-borderheading">
                                    <h3><?php echo e($published_articles[0]->edition_title); ?></h3>
                                </div>
                                <div id="sj-editorchoiceslider" class="sj-editorchoiceslider sj-editorschoice">
                                    <?php $__currentLoopData = $published_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pub_edit_article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $author = App\User::getUserDataByID($pub_edit_article->corresponding_author_id);
                                            $edition_image = App\Helper::getEditionImage($pub_edit_article->edition_id, 'medium');
                                        ?>
                                        <article class="sj-post sj-editorchoice">
                                            <?php if(!empty($edition_image)): ?>
                                                <figure class="sj-postimg">
                                                    <img src="<?php echo e(asset($edition_image)); ?>" alt="<?php echo e(trans('prs.article_img')); ?>">
                                                </figure>
                                            <?php endif; ?>
                                            <div class="sj-postcontent">
                                                <div class="sj-head">
                                                    <span class="sj-username"><a href="javascript:void(0);"><?php echo e($author->name); ?></a></span>
                                                    <h3><a href="<?php echo e(url('article/'.$pub_edit_article->slug)); ?>"><?php echo e($pub_edit_article->title); ?></a></h3>
                                                </div>
                                                <div class="sj-description">
                                                    <?php echo str_limit($pub_edit_article->excerpt, 150); ?>
                                                </div>
                                                <a class="sj-btn" href="<?php echo e(url('article/'.$pub_edit_article->slug)); ?>">
                                                    <?php echo e(trans('prs.btn_view_full_articles')); ?>

                                                </a>
                                            </div>
                                        </article>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </section>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 float-right">
                    <?php echo $__env->make('includes.widgetsidebar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>