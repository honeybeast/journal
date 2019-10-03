<?php $breadcrumbs = Breadcrumbs::generate('editTemplate',$id); ?>
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
    <?php $counter = 0;  ?>
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="email_templates">
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
                    <sticky_messages :message="this.message"></sticky_messages>
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2><?php echo e(trans('prs.email_templates')); ?></h2>
                        </div>
                        <div class="sj-manageallsession sj-manageallsessionvtwo">
                            <?php echo Form::open(['url' => '/dashboard/superadmin/emails/email/'.$email_template->id.'/update-template',
                            'id'=>'email_templates', 'class' => 'sj-formtheme sj-managesessionform']); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <?php echo Form::text('subject', $email_template->subject, ['class' => 'form-control', 'placeholder' => trans('prs.ph_email_subject')]); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::text('title', $email_template->title, ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('prs.ph_email_title')]); ?>

                                    </div>
                                    <div class="form-group">
                                        <span class="sj-select">
                                            <select id="email_types" name="template_types" disabled>
                                                <option selected value=""><?php echo e(trans('prs.ph_select_email_type')); ?></option>
                                                    <?php $__currentLoopData = $email_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $types): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($types['value']); ?>"
                                                            <?php echo e(($types['value'] == $email_template->email_type) ? "selected" : ''); ?>><?php echo e($types['title']); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </span>
                                    </div>
                                    <?php if(!($email_template->role_id == null)): ?>
                                        <div class="form-group">
                                            <span class="sj-select">
                                                <select id="user_types" name="user_types" disabled>
                                                    <option selected="selected" value=""><?php echo e(trans('prs.ph_select_user_type')); ?>/option>
                                                    <?php $__currentLoopData = $user_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($user->role_id); ?>" <?php echo e(($user->role_id == $email_template->role_id) ? "selected" : ''); ?>>
                                                            <?php echo e($user->role_name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="jf-settingvari">
                                        <div class="jf-title">
                                            <h3><?php echo e(trans('prs.email_sett_var')); ?></h3>
                                        </div>
                                        <ul class="jf-settingdetails">
                                            <?php $__currentLoopData = $variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <span><?php echo e($variable['key']); ?></span> <em>- <?php echo e($variable['value']); ?></em>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::textarea('body', $email_template->body, ['class' => 'form-control page-textarea',
                                        'required' => 'required', 'placeholder' => trans('prs.ph_email_message')]); ?>

                                    </div>
                                </fieldset>
                                <div class="sj-popupbtn">
                                    <?php echo Form::submit(trans('prs.btn_submit'), ['class' => 'sj-btn sj-btnactive']); ?>

                                </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
                <?php echo $__env->make('includes.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>