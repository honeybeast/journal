 
<?php $breadcrumbs = Breadcrumbs::generate('createUser'); ?> 
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
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="user_management">
                <?php if(Session::has('error')): ?>
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
                <div id="sj-content" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                    <div class="sj-dashboardbox sj-newcourse">
                        <div class="sj-dashboardboxtitle">
                            <div class="sj-title">
                                <h2><?php echo e(trans('prs.add_user')); ?></h2>
                                <span><?php echo e(trans('prs.provide_users_dtl')); ?></span>
                            </div>
                        </div>
                        <div class="sj-addnewuserform sj-manageallsession">
                            <?php echo Form::open(['url' => url('superadmin/users/store-users'),'id'=>'user_form','class'=>'sj-formtheme prs-add-user',
                            'enctype' => 'multipart/form-data']); ?>

                            <fieldset>
                                <div class="form-group">
                                    <?php echo Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('prs.ph_name')]); ?>

                                </div>
                                <div class="form-group">
                                    <?php echo Form::text('sur_name', null, ['class' => 'form-control', 'placeholder' => trans('prs.ph_surname')]); ?>

                                </div>
                                <div class="form-group">
                                    <?php echo Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('prs.ph_email')]); ?>

                                </div>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <?php $excludedRole = $role->role_type; ?> 
                                    <?php if(!($excludedRole === "superadmin")): ?>
                                        <div class="form-group half-width assign-role">
                                            <span class="sj-radio">
                                                <?php echo e(Form::radio('roles[]', e($role->id), null, array('id' => e($role->name), 'data-assignrole' => e($role->name)))); ?>

                                                <?php echo e(Form::label(e($role->name), ucfirst(e($role->name)))); ?>

                                            </span>
                                        </div>
                                    <?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group sj-formbtns">
                                    <?php echo Form::submit(trans('prs.btn_create_now'), ['class' => 'sj-btn sj-btnactive']); ?>

                                </div>
                            </fieldset>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>