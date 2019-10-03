<?php
    $breadcrumbs = Breadcrumbs::generate('emailTemplates');
    $selected_role = !empty($_GET['role']) ? $_GET['role'] : '';
    $selected_type = !empty($_GET['type']) ? $_GET['type'] : '';
?>
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
    <?php $counter = 0; ?>
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                <?php echo $__env->make('includes.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="email_templates">
                    <?php if(Session::has('message')): ?>
                        <div class="toast-holder">
                            <flash_messages :message="'<?php echo e(Session::get('message')); ?>'" :message_class="'success'" v-cloak></flash_messages>
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
                        <div class="sj-manageallsession">
                            <div class="sj-formtheme sj-managesessionform search-filters">
                                <?php if($create_template == false): ?>
                                    <fieldset>
                                        <div class="form-group">
                                            <a href="<?php echo e(url('dashboard/superadmin/emails/create-templates')); ?>" class="sj-btn sj-btnactive">
                                                <?php echo e(trans('prs.new_email_template')); ?>

                                            </a>
                                        </div>
                                    </fieldset>
                                <?php endif; ?>
                                <div class="sj-filter-form">
                                    <?php echo Form::open(['url' => url('/dashboard/superadmin/emails/filter-templates'),'method' => 'get',
                                    'class' => 'sj-formtheme sj-formsearchvtwo','id'=>'template_filter_form']); ?>

                                        <fieldset class="float-right">
                                            <div class="form-group">
                                                <span class="sj-select">
                                                    <select name="type" @change="submitTemplateFilter">
                                                        <option value=""><?php echo e(trans('prs.search_by_email_type')); ?></option>
                                                        <?php $__currentLoopData = $template_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($type['value']); ?>" <?php echo e($selected_type == $type['value'] ? 'selected' : ''); ?>>
                                                                <?php echo e($type['title']); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </span>
                                            </div>
                                            <div class="form-group">
                                                <span class="sj-select">
                                                    <?php echo Form::select('role', $roles ,$selected_role, array('placeholder' => trans('prs.search_by_role'), '@change'=>'submitTemplateFilter')); ?>

                                                </span>
                                            </div>
                                        </fieldset>
                                    <?php echo Form::close(); ?>

                                </div>
                            </div>
                            <?php if($email_templates->count() > 0): ?>
                            <ul class="sj-allcategorys">
                                <?php $__currentLoopData = $email_templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="sj-categorysinfo delTemplate-<?php echo e($template->id); ?>">
                                        <div class="sj-title">
                                            <h3><?php echo e($template->title); ?></h3>
                                        </div>
                                        <?php
                                            $delete_title = trans("prs.ph_delete_confirm_title");
                                            $delete_message = trans("prs.ph_template_delete_message");
                                            $deleted = trans("prs.ph_delete_title");
                                        ?>
                                        <div class="sj-categorysrightarea">
                                            <a href="<?php echo e(url('/dashboard/superadmin/emails/edit-template/')); ?>/<?php echo e($template->id); ?>" class="sj-pencilbtn">
                                                <i class="ti-pencil"></i>
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php else: ?>
                                <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endif; ?>
                            <?php if( method_exists($email_templates,'links') ): ?>
                                <?php echo e($email_templates->links('pagination.custom')); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>