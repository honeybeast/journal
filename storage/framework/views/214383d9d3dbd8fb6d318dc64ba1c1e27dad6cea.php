<aside id="article_sidebar" class="sj-sidebar">
    <?php echo $__env->make('includes.widgets.recent-articles-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('includes.widgets.success-factor-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('includes.widgets.notice-board-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('includes.widgets.advertisment-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</aside>
