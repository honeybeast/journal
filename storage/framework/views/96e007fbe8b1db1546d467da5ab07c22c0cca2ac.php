<div class="sj-addarticleholdcontent">
    <div class="sj-dashboardboxtitle">
        <h3><?php echo e(trans('prs.about_us')); ?></h3>
    </div>
    <div class="sj-acsettingthold">
        <?php echo Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/about-us-settings',
            'class' => 'sj-formtheme sj-formarticle sj-formsocical', 'enctype' => 'multipart/form-data', 'multiple' => true]); ?>

            <fieldset class="home-slider-content">
                <div class="wrap-home-slider">
                    <div class="form-group">
                        <?php echo Form::textarea('about_us', !empty($about_us_note) ? $about_us_note : '',
                            ['class' => 'form-control author_title','placeholder'=>trans('prs.about_us')]); ?>

                    </div>
                </div>
            </fieldset>
            <div class="sj-btnarea sj-updatebtns">
                <?php echo Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']); ?>

            </div>
        <?php echo Form::close(); ?>

    </div>
</div>
