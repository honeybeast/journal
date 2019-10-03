<?php
    $social_list = App\Helper::getSocialData();
    $social_unserialize_array = App\SiteManagement::getMetaValue('socials');
    $about_us_note = App\SiteManagement::getMetaValue('about_us');
?>
<div class="sj-fcol sj-footeraboutus">
    <strong class="sj-logo">
        <a href="<?php echo e(url('/')); ?>">
            <img id="footer_site_logo" src="<?php echo e(asset(App\SiteManagement::getLogo())); ?>" alt="<?php echo e(trans('prs.scientific_journal')); ?>">
        </a>
    </strong> 
    <?php if(!empty($about_us_note)): ?>
        <div class="sj-description">
            <?php echo e($about_us_note); ?>

        </div>
    <?php endif; ?>
    <ul class="sj-socialicons sj-socialiconssimple">
        <?php if(!empty($social_unserialize_array)): ?>
            <?php $__currentLoopData = $social_unserialize_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                <?php if(array_key_exists($value['title'],$social_list)): ?>
                    <?php $socialList = $social_list[$value['title']]; ?>
                    <li class="sj-<?php echo e($value['title']); ?>">
                        <a href="https://<?php echo e($value['url']); ?>" target="_blank">
                            <i class="fa <?php echo e($socialList['icon']); ?>">
                            </i>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        <?php endif; ?>
    </ul>
</div>
