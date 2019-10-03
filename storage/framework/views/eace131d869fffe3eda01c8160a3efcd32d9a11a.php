<?php $page_data = App\SiteManagement::getMetaValue('r_menu_pages'); ?>
<?php if(!empty($page_data)): ?>
    <div class="sj-fcol sj-widget sj-widgetresources">
        <div class="sj-widgetheading">
            <h3><?php echo e(trans('prs.resources')); ?></h3>
        </div>
        <div class="sj-widgetcontent">
            <ul id="resource-menu">
                <?php $__currentLoopData = $page_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $page = App\Page::getPageData($p); ?>
                    <li><a href="<?php echo e(url('page/'.$p.'')); ?>"><?php echo e($page->title); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

