<?php $contact_info = App\SiteManagement::getMetaValue('contact_info'); ?> 
<?php if(!empty($contact_info)): ?>
    <div class="sj-fcol sj-widget sj-widgetcontactus">
        <div class="sj-widgetheading">
            <h3><?php echo e(trans('prs.get_in_touch')); ?></h3>
        </div>
        <div class="sj-widgetcontent">
            <?php $__currentLoopData = $contact_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <ul>
                    <?php if(!empty($value['address'])): ?>
                        <li><i class="lnr lnr-home"></i><address><?php echo e($value['address']); ?></address></li>
                    <?php endif; ?>
                    <?php if(!empty($value['phone_no'])): ?>
                        <li><a href="tel:<?php echo e($value['phone_no']); ?>"><i class="lnr lnr-phone"></i><span><?php echo e($value['phone_no']); ?></span></a></li>
                    <?php endif; ?>
                    <?php if(!empty($value['fax_no'])): ?>
                        <li><a href="tel:<?php echo e($value['fax_no']); ?>"><i class="lnr lnr-screen"></i><span><?php echo e($value['fax_no']); ?></span></a></li>
                    <?php endif; ?>
                    <?php if(!empty($value['email'])): ?>
                        <li><a href="mailto:<?php echo e($value['email']); ?>"><i class="lnr lnr-envelope"></i><span><?php echo e($value['email']); ?></span></a></li>
                    <?php endif; ?>
                </ul>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
