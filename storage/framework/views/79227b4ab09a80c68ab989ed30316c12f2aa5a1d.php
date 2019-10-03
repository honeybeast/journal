<?php if(!empty(App\SiteManagement::getAdImage())): ?>
    <div class="sj-widget sj-widgetadd">
        <span class="sj-headtitle"><?php echo e(trans('prs.ad_text')); ?></span>
        <div class="sj-widgetcontent">
            <figure class="sj-addimage">
                <a href="javascript:void(0);">
                    <img id="site_logo" src="<?php echo e(asset(App\SiteManagement::getAdImage())); ?>" alt="<?php echo e(trans('prs.ad_img')); ?>">
                </a>
            </figure>
        </div>
    </div>
<?php endif; ?>