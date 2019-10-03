<?php
    $pages = App\Page::all();
    $published_editions = App\Edition::getPublishedEdition();
?>
<?php if(auth()->guard()->check()): ?>
    <?php echo e(App\Helper::displayEmailWarning()); ?>

<?php endif; ?>
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="sj-topbar">
                <?php App\Helper::displaySocials(); ?>
                <div class="sj-languagelogin">
                    <?php if(auth()->guard()->guest()): ?>
                        <div class="sj-loginarea">
                            <ul class="sj-loging">
                                <li><a href="<?php echo e(route('login',['type=login'])); ?>"><?php echo e(trans('prs.login')); ?></a></li>
                                <li><a href="<?php echo e(route('login',['type=register'])); ?>"><?php echo e(trans('prs.register')); ?></a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <?php $user_roles_type = App\User::getUserRoleType(Auth::user()->id); ?>
                        <div class="sj-userloginarea">
                            <a href="javascript:void(0);">
                                <i class="fa fa-angle-down"></i>
                                <img id="site_user_image_header" src="<?php echo e(url(App\Helper::getUserImage(Auth::user()->id, Auth::user()->user_image, 'mini') )); ?>" alt="<?php echo e(trans('prs.user_img')); ?>">
                                <div class="sj-loginusername">
                                    <h3>Hi, <?php echo e(Auth::user()->name); ?></h3>
                                    <span><?php echo e($user_roles_type->name); ?></span>
                                </div>
                            </a>
                            <nav class="sj-usernav">
                                <ul>
                                    <?php if(!($user_roles_type->role_type == 'reader' )): ?>
                                        <?php echo e(App\Helper::displayArticleMenu()); ?>

                                    <?php endif; ?>
                                    <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Categories')): ?> -->
                                    <?php if($user_roles_type->role_type == 'superadmin'): ?>
                                        <li>
                                            <a href="<?php echo e(url('/dashboard/edition/settings')); ?>">
                                                <i class="lnr lnr-cog"></i><span><?php echo e(trans('prs.edition_settings')); ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('/dashboard/category/settings')); ?>">
                                                <i class="lnr lnr-layers"></i><span><?php echo e(trans('prs.category_settings')); ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <!-- <?php endif; ?> -->
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Users')): ?>
                                        <li>
                                            <a href="<?php echo e(url('superadmin/users/manage-users')); ?>">
                                                <i class="lnr lnr-users"></i><span><?php echo e(trans('prs.manage_users')); ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                        <li>
                                            <a href="<?php echo e(url('dashboard/general/settings/account-settings')); ?>">
                                                <i class="lnr lnr-cog"></i><span><?php echo e(trans('prs.account_settings')); ?></span>
                                            </a>
                                        </li>
                                    <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Pages')): ?> -->
                                    <?php if($user_roles_type->role_type == 'superadmin'): ?>
                                        <li>
                                            <a href="<?php echo e(url('/'.App\Helper::getPageAuthor().'/dashboard/pages')); ?>">
                                                <i class="lnr lnr-menu"></i><span><?php echo e(trans('prs.manage_pages')); ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <!-- <?php endif; ?> -->
                                    <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Site Management')): ?> -->
                                    <?php if($user_roles_type->role_type == 'superadmin'): ?>
                                        <li>
                                            <a href="<?php echo e(url('/dashboard/'.App\Helper::getPageAuthor().'/site-management/settings')); ?>">
                                                <i class="lnr lnr-code"></i><span><?php echo e(trans('prs.manage_site')); ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <!-- <?php endif; ?> -->
                                    <?php if($user_roles_type->role_type == 'reader'): ?>
                                        <li>
                                            <a href="<?php echo e(url('/user/products/downloads')); ?>">
                                                <i class="lnr lnr-download"></i><span><?php echo e(trans('prs.downloads')); ?></span>
                                            </a>
                                        </li>
                                    <?php elseif($user_roles_type->role_type == 'superadmin'): ?>
                                        <li>
                                            <a href="<?php echo e(url('/superadmin/downloads')); ?>">
                                                <i class="lnr lnr-download"></i><span><?php echo e(trans('prs.downloads')); ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('/dashboard/superadmin/site-management/payment/settings')); ?>">
                                                <i class="lnr lnr-cart"></i><span><?php echo e(trans('prs.payment_settings')); ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('/dashboard/superadmin/site-management/settings/email')); ?>">
                                                <i class="lnr lnr-envelope"></i><span><?php echo e(trans('prs.email_settings')); ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('/dashboard/superadmin/emails/templates')); ?>">
                                                <i class="lnr lnr-envelope"></i><span><?php echo e(trans('prs.email_templates')); ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="lnr lnr-exit"></i><?php echo e(trans('prs.logout')); ?>

                                        </a>
                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                            <?php echo e(csrf_field()); ?>

                                        </form>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="sj-navigationarea">
                <strong class="sj-logo">
                    <a href="<?php echo e(url('/')); ?>">
                        <img id="site_logo" src="<?php echo e(asset(App\SiteManagement::getLogo())); ?>" alt="<?php echo e(trans('prs.scientific_journal')); ?>">
                    </a>
                </strong>
                <div class="sj-rightarea">
                    <nav id="sj-nav" class="sj-nav navbar-expand-lg">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="lnr lnr-menu"></i>
                        </button>
                        <div class="collapse navbar-collapse sj-navigation" id="navbarNav">
                            <ul>
                                <li><a href="<?php echo e(url('/')); ?>"><i class="lnr lnr-home"></i></a></li>
                                <?php if(!empty($published_editions)): ?>
                                    <li class="menu-item-has-children page_item_has_children custom-active">
                                        <a href="javascript:void(0);"><?php echo e(trans('prs.editions')); ?></a>
                                        <ul class="sub-menu" id="edition_menu">
                                            <?php $__currentLoopData = $published_editions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="<?php if(Request::segment(2) == e($edition->slug) ): ?> current-menu-item <?php endif; ?>">
                                                    <a href="<?php echo e(url('edition/'.$edition->slug)); ?>">
                                                        <?php echo e($edition->title); ?>

                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if(!empty($pages)): ?>
                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $page_has_child = App\Page::pageHasChild($page->id); $pageID = Request::segment(2);
                                            $show_page = DB::table('sitemanagements')->where('meta_key', 'show-page-'.$page->id)->select('meta_value')->pluck('meta_value')->first();
                                        ?>
                                        <?php if($page->relation_type == 0 && $show_page == 'true'): ?>
                                            <li class="<?php echo e(!empty($page_has_child) ? 'menu-item-has-children page_item_has_children' : ''); ?> <?php if($pageID == $page->slug ): ?> current-menu-item <?php endif; ?>">
                                                <a href="<?php echo e(url('/page/'.$page->slug.'/')); ?>"><?php echo e($page->title); ?></a>
                                                <?php if(!empty($page_has_child)): ?>
                                                    <ul class="sub-menu">
                                                        <?php $__currentLoopData = $page_has_child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php $child = App\Page::getChildPages($parent->child_id);?>
                                                            <li class="<?php if($pageID == $child->slug ): ?> current-menu-item <?php endif; ?>">
                                                                <a href="<?php echo e(url('page/'.$child->slug.'/')); ?>">
                                                                    <?php echo e($child->title); ?>

                                                                </a>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </nav>
                    <?php if(App\Article::all()->count() > 0): ?>
                        <a class="sj-btntopsearch" href="#sj-searcharea">
                            <i class="lnr lnr-magnifier"></i>
                        </a>
                    <?php endif; ?>
                    <?php if(Auth::user()): ?>
                        <?php if($user_roles_type->role_type == 'author'): ?>
                            <a class="sj-btn sj-btnactive" href="<?php echo e(route('checkAuthor')); ?>">
                                <?php echo e(trans('prs.btn_submit_article')); ?>

                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                    <a class="sj-btn sj-btnactive" href="<?php echo e(route('checkAuthor')); ?>"> <?php echo e(trans('prs.btn_submit_article')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sj-innerbanner">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="sj-innerbannercontent">
                    <?php if(!empty($user)): ?>
                        <h1><?php echo e(Auth::user()->name); ?></h1>
                    <?php else: ?>
                        <!-- <h1><?php echo e(trans('prs.become_member')); ?></h1> -->
                    <?php endif; ?>
                    <?php echo $__env->yieldContent('breadcrumbs'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
