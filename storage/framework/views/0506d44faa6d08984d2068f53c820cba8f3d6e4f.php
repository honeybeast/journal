<?php
    $breadcrumbs = Breadcrumbs::generate('manageUsers');
    $selected_role = !empty($_GET['role']) ? $_GET['role'] : '';
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
    <div class="container">
        <div class="row">
        <div id="sj-twocolumns" class="sj-twocolumns">
                <?php echo $__env->make('includes.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="user_management">
                    <?php if(Session::has('message')): ?>
                        <div class="toast-holder">
                            <flash_messages :message="'<?php echo e(Session::get('message')); ?>'" :message_class="'success'" v-cloak></flash_messages>
                        </div>
                    <?php endif; ?>
                    <sticky_messages :message="this.success_message"></sticky_messages>
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2><?php echo e(trans('prs.manage_users')); ?></h2>
                        </div>
                        <div class="sj-manageallsession">
                            <div class="sj-formtheme sj-managesessionform search-filters">
                                <fieldset>
                                    <div class="form-group">
                                        <a class="sj-btn sj-btnactive create-user" href="<?php echo e(url('superadmin/users/create-users')); ?>">
                                            <?php echo e(trans('prs.add_user')); ?>

                                        </a>
                                    </div>
                                </fieldset>
                                <?php echo Form::open(['url' => url('/superadmin/users/role-filters'), 'method' => 'get',
                                'class' => 'sj-formtheme sj-formsearchvtwo', 'id'=>'role_filter_form']); ?>

                                    <fieldset>
                                        <div class="form-group sj-inputwithicon float-right">
                                            <span class="sj-select">
                                                <?php echo Form::select('role', $role_list ,$selected_role, array('placeholder' => trans('prs.select_roles'), '@change'=>'submitRoleForm()')); ?>

                                            </span>
                                        </div>
                                    </fieldset>
                                <?php echo Form::close(); ?>

                            </div>
                            <?php if($users->count() > 0): ?>
                                <ul class="sj-allcategorys sj-allcategorysvtwo">
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $user_roles_type = App\User::getUserRoleType($user->id);
                                            $userRole = $user_roles_type->role_type;
                                        ?>
                                        <li class="sj-categorysinfo delUser-<?php echo e($user->id); ?>">
                                            <figure class="sj-assignuserimg">
                                                <img src="<?php echo e(url(App\Helper::getUserImage($user->id, $user->user_image, 'small'))); ?>" alt="<?php echo e(trans('prs.img')); ?>">
                                            </figure>
                                            <div class="sj-title">
                                                <h3><?php echo e($user->name); ?><span class="sj-assignedinfo"><?php echo e($userRole); ?></span></h3>
                                            </div>
                                            <?php
                                                $delete_title = trans("prs.ph_delete_confirm_title");
                                                $delete_message = trans("prs.ph_user_delete_message");
                                                $deleted = trans("prs.ph_delete_title");
                                                $categories_id = App\Category::getCategoryByReviewerID($user->id);
                                                $counter = 0;
                                            ?>
                                            <div class="sj-categorysrightarea">
                                                <?php if($userRole === 'reviewer'): ?>
                                                    <?php if(!empty($categories)): ?>
                                                        <ul class="sj-userdropdown">
                                                            <?php echo Form::open(['url' => '/superadmin/users/assign-category', '@submit.prevent' => 'assignCategory',
                                                            'id'=>$user->id.'-reviewer_assign_category']); ?>

                                                                <li>
                                                                    <a href="javascript:void(0);" class="sj-userdropdownbtn">
                                                                        <span><i class="lnr lnr-user"></i></span>
                                                                        <i class="fa fa-angle-down"></i>
                                                                    </a>
                                                                    <ul class="sj-userdropdownmanu">
                                                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <li class="sj-checked">
                                                                                <span class="sj-checkbox">
                                                                                    <input type="checkbox" id="checkbox-<?php echo e($user->id); ?><?php echo e($counter); ?>" class="category_value" name=category[] value="<?php echo e($category->id); ?>" data-categoryname="<?php echo e($category->title); ?>"
                                                                                        <?php echo e(in_array($category->id, $categories_id ) ? 'checked="checked"' : ''); ?>>
                                                                                    <label for="checkbox-<?php echo e($user->id); ?><?php echo e($counter); ?>">
                                                                                        <span><?php echo e($category->title); ?></span>
                                                                                    </label>
                                                                                </span>
                                                                            </li>
                                                                            <?php $counter++ ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <input type="hidden" name="reviewer_id" value="<?php echo e($user->id); ?>">
                                                                    </ul>
                                                                </li>
                                                                <li class="sj-checkbtnbox">
                                                                    <?php echo e(Form::button('<i class="ti-check"></i>', ['class' => 'sj-checkbtn', 'type' => 'submit'])); ?>

                                                                </li>
                                                            <?php echo Form::close(); ?>

                                                        </ul>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <div class="sj-addremove">
                                                    <a href="<?php echo e(url('/superadmin/users/edit-user')); ?>/<?php echo e($user->id); ?>" class="sj-pencilbtn">
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                    <?php if($userRole != 'superadmin'): ?>
                                                        <a href="#" v-on:click.prevent="deleteUser($event,'<?php echo e($delete_title); ?>','<?php echo e($delete_message); ?>','<?php echo e($deleted); ?>')" class="sj-trashbtn" id="<?php echo e($user->id); ?>">
                                                            <i class="ti-trash"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="custom-error"></div>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php else: ?>
                                <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endif; ?>
                            <?php if( method_exists($users,'links') ): ?>
                                <?php echo e($users->links('pagination.custom')); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>