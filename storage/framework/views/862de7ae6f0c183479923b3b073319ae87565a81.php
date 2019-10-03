<?php 
    $stored_site_title = App\SiteManagement::getMetaValue('site_title'); 
    $site_title = !empty($stored_site_title) ? $stored_site_title[0]['site_title']: ''; 
?>
<div class="container" id="footer_area">
    <div class="row">
        <a class="sj-btnscrolltotop" href="javascript:void(0);"><i class="fa fa-angle-up"></i></a>
        <div class="sj-footercolumns">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 float-left">
                <?php echo $__env->make('includes.widgets.about-us-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 float-left">
                <?php echo $__env->make('includes.widgets.resource-menu-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 float-left">
                <?php echo $__env->make('includes.widgets.get-in-touch-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
        <div class="sj-footerbottom">
            <p class="sj-copyrights">© <?php echo e(date("Y")); ?> <span><?php echo e($site_title); ?></span>. <?php echo e(trans('prs.copyright')); ?></p>
        </div>
    </div>
</div>