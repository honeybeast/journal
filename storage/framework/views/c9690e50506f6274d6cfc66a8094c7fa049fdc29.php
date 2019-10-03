<?php $success_data = App\SiteManagement::getMetaValue('success_data'); ?> 
<?php if(!empty($success_data)): ?>
    <div class="sj-widget sj-widgetimpactfector">
        <div class="sj-widgetcontent">
            <?php $__currentLoopData = $success_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <ul>
                    <li>
                        <h3><?php echo e(trans('prs.impact_factor')); ?><span><?php echo e($value['impact_factor']); ?></span></h3>
                        <h3><?php echo e(trans('prs.time_impact_factor')); ?><span><?php echo e($value['time_impact_factor']); ?></span></h3>
                    </li>
                    <li>
                        <h3><?php echo e($value['commenter_name']); ?></h3>
                        <div class="sj-description">
                            <p><?php echo e(str_limit($value['comment'], 50)); ?></p>
                        </div>
                    </li>
                </ul>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
