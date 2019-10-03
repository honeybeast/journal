<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
    <div class="sj-dashboardboxtitle" id="headingOne-cache-clear" data-toggle="collapse" data-target="#collapseOne-cache-clear"
        aria-expanded="true" aria-controls="collapseOne-cache-clear">
        <h2><?php echo e(trans('prs.clear_cache')); ?></h2>
    </div>
    <div id="collapseOne-cache-clear" aria-labelledby="headingOne-cache-clear" data-parent="#accordion" class="sj-uploadimgbars sj-active collapse">
        <?php echo Form::open([ 'url' => '', 'class' => 'sj-formtheme sj-formarticle sj-formsocical', 'id'
        =>'cache-clear', '@submit.prevent'=>'clearAllCache' ]); ?>

        <fieldset class="social-icons-content">
            <div class="wrap-social-icons">
                <p><?php echo e(trans('prs.clear_all_cache_note')); ?></p>
            </div>
        </fieldset>
        <div class="sj-btnarea sj-updatebtns">
            <?php echo Form::submit(trans('prs.clear_all_cache'), ['class' => 'sj-btn sj-btnactive']); ?>

        </div>
        <?php echo Form::close(); ?>

    </div>
</div>
