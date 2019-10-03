<?php $breadcrumbs = Breadcrumbs::generate('manageSite',$user_role); ?>
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
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="site_management">
                    <?php if(Session::has('success')): ?>
                        <div class="toast-holder">
                            <flash_messages :message="'<?php echo e(Session::get('success')); ?>'" :message_class="'success'" v-cloak></flash_messages>
                        </div>
                    <?php elseif(Session::has('error')): ?>
                        <div class="toast-holder">
                            <flash_messages :message="'<?php echo e(Session::get('error')); ?>'" :message_class="'danger'" v-cloak></flash_messages>
                        </div>
                    <?php elseif($errors->any()): ?>
                        <div class="toast-holder">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <flash_messages :message="'<?php echo e($error); ?>'" :message_class="'danger'" v-cloak></flash_messages>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                   <?php endif; ?>
                    <div id="sj-content" class="sj-content">
                        <?php echo $__env->make('admin.cms.social_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php echo $__env->make('admin.cms.site_title_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php echo $__env->make('admin.cms.site_logo_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php echo $__env->make('admin.cms.home_slider_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
                            <?php echo $__env->make('admin.cms.welcome_page_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <?php echo $__env->make('admin.cms.success_factor_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php echo $__env->make('admin.cms.notice_board_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php echo $__env->make('admin.cms.ad_image_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
                            <div class="sj-dashboardboxtitle" id="headingOne-4" data-toggle="collapse" data-target="#collapseOne-4"
                                aria-expanded="true" aria-controls="collapseOne-4">
                                <h2><?php echo e(trans('prs.footer_settings')); ?></h2>
                            </div>
                            <div id="collapseOne-4" aria-labelledby="headingOne-4" data-parent="#accordion" class="sj-active collapse">
                                <div class="sj-acsettingthold sj-btnarea sj-updatebtns">
                                    <?php echo $__env->make('admin.cms.contact_info_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div>
                                <div class="sj-acsettingthold sj-btnarea sj-updatebtns">
                                    <?php echo $__env->make('admin.cms.about_us_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div>
                                <div class="sj-acsettingthold sj-btnarea sj-updatebtns">
                                    <?php echo $__env->make('admin.cms.resources_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $__env->make('admin.cms.cache_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php echo $__env->make('admin.cms.change_languages_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php echo $__env->make('admin.cms.add_keyword_settings', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>