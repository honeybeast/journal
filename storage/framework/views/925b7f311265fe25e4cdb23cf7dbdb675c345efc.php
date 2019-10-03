<?php $breadcrumbs = Breadcrumbs::generate('editUser',$id); ?>
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
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="account_setting">
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
                                <h2><?php echo e(trans('prs.edit_user')); ?></h2>
                                <span><?php echo e(trans('prs.provide')); ?><strong><?php echo e($role->name); ?></strong> <?php echo e(trans('prs.detls')); ?></span>
                            </div>
                        </div>
                        <div class="sj-addnewuserform sj-manageallsession sj-edituser">
                            <?php $roleCounter = 0; ?>
                            <?php echo e(Form::model($users, array('url' => url('/superadmin/users/update-users/'.$users->id.''),
                            'method' => 'POST', 'enctype' => 'multipart/form-data',
                            'class' => 'sj-formtheme sj-formarticle sj-formcontactus sj-formcontactusvtwo sj-formsocical sj-categorydetails'))); ?>

                                <fieldset class="home-slider-content">
                                    <div class="form-group">
                                        <?php echo Form::text('name', null, ['class' => 'form-control']); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::text('sur_name', null, ['class' => 'form-control']); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::email('email', null, ['class' => 'form-control']); ?>

                                    </div>
                                    <?php if($role->role_type === 'reviewer'): ?>
                                        <div class="form-group">
                                            <span class="sj-select">
                                                <select data-placeholder="<?php echo e(!empty($categories) ? trans('prs.choose_cat') : trans('prs.choose_cat_for_sel')); ?>"
                                                     multiple class="chosen-select" name="category[]">
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category->id); ?>" <?php echo e(in_array($category->id, $categories_id) ? 'selected' : ''); ?> >
                                                            <?php echo e($category->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="sj-formtheme sj-formpassword">
                                        <div class="form-group sj-inputwithicon sj-password">
                                            <i class="lnr lnr-lock"></i>
                                            <?php $old_error = $errors->has("old_password") ? 'is-invalid' : ""; ?>
                                            <?php echo Form::password('old_password', ['class' => ['.$old_error.'],'placeholder' => trans('prs.ph_oldpass')]); ?>

                                        </div>
                                        <div class="form-group sj-inputwithicon sj-password">
                                            <i class="lnr lnr-lock"></i>
                                            <?php echo Form::password('password', ['class' => 'form-control', 'placeholder' => trans('prs.ph_newpass')]); ?>

                                        </div>
                                        <div class="form-group sj-inputwithicon sj-password">
                                            <i class="lnr lnr-lock"></i>
                                            <?php echo Form::password('confirm_password', ['class' => 'form-control','placeholder' => trans('prs.ph_retype_pass')]); ?>

                                        </div>
                                        <?php echo Form::hidden('user_id', $id); ?>

                                    </div>
                                    <div class="form-group">
                                        <upload-files-field
                                            :field_title="'<?php echo e(trans('prs.user_img')); ?>'"
                                            :uploaded_file="'<?php echo e(App\UploadMedia::getImageName($users->user_image)); ?>'"
                                            :hidden_field_name="'hidden_user_image'"
                                            :doc_id="'user_img'"
                                            :file_name="'user_image'"
                                            :file_placeholder="'<?php echo e(trans("prs.ph_upload_file_label")); ?>'"
                                            :file_size_label="'<?php echo e(trans("prs.ph_article_file_size")); ?>'"
                                            :file_uploaded_label="'<?php echo e(trans("prs.ph_file_uploaded")); ?>'"
                                            :file_not_uploaded_label="'<?php echo e(trans("prs.ph_file_not_uploaded")); ?>'">
                                        </upload-files-field>
                                    </div>
                                    <div class="form-group sj-formbtns">
                                        <?php echo Form::submit(trans('prs.btn_submit'), ['class' => 'sj-btn sj-btnactive']); ?>

                                    </div>
                                </fieldset>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>