<?php
    $user_role = "";
    $dashboard = "";
    $role_name = "";
    $user_image = "";
    $user_name = "";
    if (!empty(Auth::user()->id)) {
        $user = Auth::user();
        $user_image = $user->user_image;
        $user_roles_type = App\User::getUserRoleType($user->id);
        $user_role = $user_roles_type->role_type;
        $role_name = $user_roles_type->name;
        $user_name = $user->name;

        if ($user_role == 'superadmin' || $user_role == 'editor') {
            $dashboard = 'dashboard';
        } else {
            $dashboard = 'user';
        }
        if ($user_role == 'superadmin') {
            $page_author = 'superadmin';
        } else {
            $page_author = 'editor';
        }
    }
?>
<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3 float-left">
    <aside id="sj-asidebar" class="sj-asidebar sj-widgetbox">
        <div class="sj-widgetprofile">
            <div class="sj-widgetcontent">
                <figure>
                    <img id="user_image_sidebar" src="<?php echo e(url(App\Helper::getUserImage(Auth::user()->id, $user_image) )); ?>" alt="<?php echo e(trans('prs.user_img')); ?>">
                    <a class="sj-btnedite" href="<?php echo e(url('/dashboard/general/settings/account-settings')); ?>"><i class="lnr lnr-pencil"></i></a>
                </figure>
                <div class="sj-admininfo">
                    <?php echo e(!empty($user) ? $user_name : trans('prs.user_name')); ?>

                    <h4><?php echo e($role_name); ?></h4>
                </div>
            </div>
        </div>
        <div class="sj-widgetdashboard">
            <nav id="sj-dashboardnav" class="sj-dashboardnav">
                <ul>
                    <?php if(!($user_role == 'reader')): ?>
                        <?php $page_id = Request::segment(4); ?>
                        <?php echo e(App\Helper::displayArticleMenu($page_id)); ?>

                    <?php endif; ?>
                    <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Categories')): ?> -->
                    <?php if($user_roles_type->role_type == 'superadmin'): ?>
                        <li class="<?php echo e(\Request::route()->getName() === 'editionSetting' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('/dashboard/edition/settings')); ?>">
                                <i class="lnr lnr-cog"></i><span><?php echo e(trans('prs.edition_settings')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(\Request::route()->getName() === 'categorySetting' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('/dashboard/category/settings')); ?>">
                                <i class="lnr lnr-layers"></i><span><?php echo e(trans('prs.category_settings')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- <?php endif; ?> -->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Users')): ?>
                        <li class="<?php echo e(\Request::route()->getName() === 'manageUsers' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('superadmin/users/manage-users')); ?>">
                                <i class="lnr lnr-users"></i><span><?php echo e(trans('prs.manage_users')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                        <li class="<?php echo e(\Request::route()->getName() === 'accountSetting' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('dashboard/general/settings/account-settings')); ?>">
                                <i class="lnr lnr-cog"></i><span><?php echo e(trans('prs.account_settings')); ?></span>
                            </a>
                        </li>
                    <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Pages')): ?> -->
                    <?php if($user_roles_type->role_type == 'superadmin'): ?>
                        <li class="<?php echo e(\Request::route()->getName() === 'managePages' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('/'.$page_author.'/dashboard/pages')); ?>">
                                <i class="lnr lnr-menu"></i><span><?php echo e(trans('prs.manage_pages')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- <?php endif; ?> -->
                    <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Site Management')): ?> -->
                    <?php if($user_roles_type->role_type == 'superadmin'): ?>
                        <li class="<?php echo e(\Request::route()->getName() === 'manageSite' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('/dashboard/'.$page_author.'/site-management/settings')); ?>">
                                <i class="lnr lnr-code"></i><span><?php echo e(trans('prs.manage_site')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- <?php endif; ?> -->
                    <?php if($user_roles_type->role_type == 'reader'): ?>
                        <li class="<?php echo e(\Request::route()->getName() === 'downloads' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('/user/products/downloads')); ?>">
                                <i class="lnr lnr-download"></i><span><?php echo e(trans('prs.downloads')); ?></span>
                            </a>
                        </li>
                    <?php elseif($user_roles_type->role_type == 'superadmin'): ?>
                        <li class="<?php echo e(\Request::route()->getName() === 'orders' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('/superadmin/downloads')); ?>">
                                <i class="lnr lnr-download"></i><span><?php echo e(trans('prs.downloads')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(\Request::route()->getName() === 'paymentSettings' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('/dashboard/superadmin/site-management/payment/settings')); ?>">
                                <i class="lnr lnr-cart"></i><span><?php echo e(trans('prs.payment_settings')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(\Request::route()->getName() === 'emailSettings' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('/dashboard/superadmin/site-management/settings/email')); ?>">
                                <i class="lnr lnr-envelope"></i><span><?php echo e(trans('prs.email_settings')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(\Request::route()->getName() === 'emailTemplates' ? 'sj-active' : ''); ?>">
                            <a href="<?php echo e(url('/dashboard/superadmin/emails/templates')); ?>">
                                <i class="lnr lnr-envelope"></i><span><?php echo e(trans('prs.email_templates')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-sidebarform').submit();">
                            <i class="lnr lnr-exit"></i>
                            <span><?php echo e(trans('prs.logout')); ?></span>
                        </a>
                        <form id="logout-sidebarform" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </li>
                </ul>
                <div class="sj-navdashboard-footer">
                    <span class="version-area"><?php echo e(config('app.version')); ?></span>
                </div>
            </nav>
        </div>
    </aside>
</div>
