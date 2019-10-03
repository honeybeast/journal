<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold sj-formarticlevtwo">
    <div class="sj-dashboardboxtitle" id="headingOne-9" data-toggle="collapse" data-target="#collapseOne-9" aria-expanded="true"
        aria-controls="collapseOne-9">
        <h2><?php echo e(trans('prs.impact_factor')); ?></h2>
    </div>
    <div id="collapseOne-9" aria-labelledby="headingOne-9" data-parent="#accordion" class="sj-uploadimgbars sj-active collapse">
        <?php echo Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/success-factor-settings', 'class' => 'sj-formtheme
        sj-formarticle sj-formsocical', 'enctype' => 'multipart/form-data', 'multiple' => true]); ?>

            <fieldset class="home-slider-content">
                <?php if(!empty($successfactor)): ?>
                    <?php $__currentLoopData = $successfactor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="wrap-home-slider">
                            <div class="form-group sj-authorhold">
                                <?php echo Form::text('success_data[0][impact_factor]', e($value['impact_factor']),
                                    ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_impact_factor')]); ?>

                            </div>
                            <div class="form-group sj-authorhold">
                                <?php echo Form::text('success_data[0][time_impact_factor]', e($value['time_impact_factor']),
                                    ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_five_yrs_impact')]); ?>

                            </div>
                            <div class="form-group sj-authorhold">
                                <?php echo Form::text('success_data[0][commenter_name]', e($value['commenter_name']),
                                    ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_commenter')]); ?>

                            </div>
                            <div class="form-group sj-authorholdvtwo">
                                <?php echo Form::textarea('success_data[0][comment]', e($value['comment']),
                                    ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_comment')]); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="wrap-home-slider">
                        <div class="form-group sj-authorhold">
                            <?php echo Form::text('success_data[0][impact_factor]', null, ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_impact_factor')]); ?>

                        </div>
                        <div class="form-group sj-authorhold">
                            <?php echo Form::text('success_data[0][time_impact_factor]', null, ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_five_yrs_impact')]); ?>

                        </div>
                        <div class="form-group sj-authorhold">
                            <?php echo Form::text('success_data[0][commenter_name]', null, ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_commenter')]); ?>

                        </div>
                        <div class="form-group sj-authorholdvtwo">
                            <?php echo Form::textarea('success_data[0][comment]', null, ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_comment')]); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </fieldset>
            <div class="sj-btnarea sj-updatebtns">
                <?php echo Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']); ?>

            </div>
        <?php echo Form::close(); ?>

    </div>
</div>
