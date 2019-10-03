<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
    <div class="sj-dashboardboxtitle" id="headingOne-add-keyword" data-toggle="collapse" data-target="#collapseOne-add-keyword"
        aria-expanded="true" aria-controls="collapseOne-site-title">
        <!-- <h2><?php echo e(trans('prs.site_title_setting')); ?></h2> -->
        <h2>Add keywords</h2>
    </div>
    <div id="collapseOne-add-keyword" aria-labelledby="headingOne-add-keyword" data-parent="#accordion" class="sj-uploadimgbars sj-active collapse">
        <?php echo Form::open([ 'url' => '/dashboard/'.$user_role.'/site-management/store/add-keyword', 'class' => 'sj-formtheme
        sj-formarticle sj-formsocical' ]); ?>

        <fieldset class="social-icons-content">
            <div class="wrap-social-icons">
                <div class="form-group">
                    <select class="form-control" name="keywords[]" multiple data-role="tagsinput">
                        <?php if(!empty($keywords)): ?>
                            <?php $__currentLoopData = $keywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($keyword); ?>"><?php echo e($keyword); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </fieldset>
        <div class="sj-btnarea sj-updatebtns">
            <?php echo Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']); ?>

        </div>
        <?php echo Form::close(); ?>

    </div>
</div>
