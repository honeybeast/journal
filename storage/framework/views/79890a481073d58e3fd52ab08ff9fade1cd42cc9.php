<?php $notice_data = App\SiteManagement::getMetaValue('notices'); ?> 
<?php if(!empty($notice_data)): ?>
    <div class="sj-widget sj-widgetnoticeboard">
        <div class="sj-widgetheading">
            <h3><?php echo e(trans('prs.notice_board')); ?></h3>
        </div>
        <div class="sj-widgetcontent">
            <?php echo htmlspecialchars_decode(stripslashes($notice_data['notice'])); ?>
        </div>
    </div>
<?php endif; ?>
