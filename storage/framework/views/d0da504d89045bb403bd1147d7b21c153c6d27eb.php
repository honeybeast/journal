 
<?php $breadcrumbs = Breadcrumbs::generate('managePages',$user_role); ?> 
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
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="manage_page">
                    <?php if(Session::has('message')): ?>
                        <div class="toast-holder">
                            <flash_messages :message="'<?php echo e(Session::get('message')); ?>'" :message_class="'success'" v-cloak></flash_messages>
                        </div>
                    <?php endif; ?>
                    <sticky_messages :message="this.message"></sticky_messages>
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2><?php echo e(trans('prs.manage_pages')); ?></h2>
                        </div>
                        <div class="sj-manageallsession">
                            <form class="sj-formtheme sj-managesessionform">
                                <fieldset>
                                    <div class="form-group">
                                        <a class="sj-btn sj-btnactive create-user" href="<?php echo e(url('/'.$user_role.'/dashboard/'.$editor_id.'/pages/page/create-page')); ?>">
                                            <?php echo e(trans('prs.add_new_pge')); ?>

                                        </a>
                                    </div>
                                </fieldset>
                            </form>
                            <ul class="sj-allcategorys">
                                <?php if($pages->count() > 0): ?> 
                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="sj-categorysinfo delPage-<?php echo e($page->id); ?>">
                                            <div class="sj-title">
                                                <h3><?php echo e($page->title); ?></h3>
                                            </div>
                                            <?php 
                                                $delete_title = trans("prs.ph_delete_confirm_title"); 
                                                $delete_message = trans("prs.ph_page_delete_message"); 
                                                $deleted = trans("prs.ph_delete_title"); 
                                            ?>
                                            <div class="sj-categorysrightarea">
                                                <a href="<?php echo e(url('/'.$user_role.'/dashboard/pages/page')); ?>/<?php echo e($page->id); ?>/edit-page" class="sj-pencilbtn">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                                <a href="#" v-on:click.prevent="deletePage($event,'<?php echo e($delete_title); ?>','<?php echo e($delete_message); ?>','<?php echo e($deleted); ?>')" class="sj-trashbtn" id="<?php echo e($page->id); ?>">
                                                    <i class="ti-trash"></i>
                                                </a>
                                            </div>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                <?php else: ?>
                                    <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                                <?php endif; ?>
                            </ul>
                            <?php if( method_exists($pages,'links') ): ?> <?php echo e($pages->links('pagination.custom')); ?> <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>