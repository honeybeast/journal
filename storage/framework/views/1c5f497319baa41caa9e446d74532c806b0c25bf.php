<?php $breadcrumbs = Breadcrumbs::generate('emailSettings'); ?>
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
        <?php echo $__env->make('includes.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="email_settings_holder">
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
            <div class="sj-addarticleholdcontent sj-content">
                <div class="sj-dashboardboxtitle">
                    <h2><?php echo e(trans('prs.email_settings')); ?></h2>
                </div>
                <div class="sj-acsettingthold">
                    <?php echo Form::open(['url' => '/dashboard/superadmin/site-management/email/store-email-settings', 'class' =>
                    'sj-formtheme sj-formsocical']); ?>

                        <fieldset>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 form-group">
                                    <?php if(!empty($existing_email_settings)): ?>
                                        <?php echo Form::text('email', e($existing_email_settings[0]['email']), ['class' => 'form-control',
                                        'placeholder' => trans('prs.ph_email')]); ?>

                                    <?php else: ?>
                                        <?php echo Form::text('email', null, ['class' => 'form-control', 'placeholder' =>
                                        trans('prs.ph_email')]); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </fieldset>
                        <div class="sj-btnarea sj-updatebtns">
                            <?php echo Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']); ?>

                        </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>