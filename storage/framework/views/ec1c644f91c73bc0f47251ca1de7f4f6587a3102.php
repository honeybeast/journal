<?php $breadcrumbs = Breadcrumbs::generate('editPage',$user_role,$id); ?>
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
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="manage_page">
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
                    <div id="sj-content" class="sj-content sj-addarticleholdcontent">
                        <div class="sj-dashboardboxtitle">
                            <h2><?php echo e(trans('prs.edit_page')); ?></h2>
                        </div>
                        <div class="sj-addarticlehold">
                            <?php echo Form::open(['url' => '/'.$user_role.'/dashboard/pages/page/'.$page->id.'/update-page/', 'class' => 'sj-formtheme sj-formarticle']); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <?php echo Form::text('title', $page->title, ['class' => 'form-control', 'placeholder' => trans('prs.ph_pge_title')]); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::text('sub_title', $page->sub_title, ['class' => 'form-control', 'placeholder' => trans('prs.ph_pge_subtitle')]); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::textarea('content', $page->body, ['class' => 'form-control page-textarea','placeholder' => trans('prs.ph_pge_desc')]); ?>

                                    </div>
                                    <?php if(empty($has_child)): ?>
                                        <?php if($parent_page->count() > 1): ?>
                                            <div class="form-group">
                                                <span class="sj-select">
                                                    <?php echo Form::select('parent_id', $parent_page, $parent_selected_id , array('class' => 'form-control jf-select2')); ?>

                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <?php echo Form::textarea('seo_desc', $seo_desc, array('class' => 'form-group seo-meta', 'placeholder' => trans('prs.ph_desc'))); ?>

                                    </div>
                                    <div class="sj-dashboardboxtitle">
                                         <div class="float-right">
                                            <switch_button v-model="show_page"><?php echo e(trans('prs.add_menu_to_navbar')); ?></switch_button>
                                            <input type="hidden" :value="show_page" name="show_page">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="sj-submitdetails">
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