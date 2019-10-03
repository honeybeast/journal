<div class="sj-addarticleholdcontent">
    <div class="sj-dashboardboxtitle">
        <h3><?php echo e(trans('prs.contact_info')); ?></h3>
    </div>
    <div class="sj-acsettingthold">
        <?php echo Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/contact-info-settings', 'class' =>
        'sj-formtheme sj-formarticle sj-formsocical sj-footercontact', 'enctype' => 'multipart/form-data', 'multiple'
        => true]); ?>

            <fieldset class="home-slider-content">
                <?php if(!empty($contactinfo)): ?>
                    <?php $__currentLoopData = $contactinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="wrap-home-slider">
                            <div class="form-group sj-authorhold">
                                <?php echo Form::text('contact_info[0][address]', e($value['address']), ['class' => 'form-control
                                author_title','placeholder'=>trans('prs.ph_address')]); ?>

                            </div>
                            <div class="form-group sj-authorhold">
                                <?php echo Form::text('contact_info[0][phone_no]', e($value['phone_no']), ['class' => 'form-control
                                author_title','placeholder'=>trans('prs.ph_phone_no')]); ?>

                            </div>
                            <div class="form-group sj-authorhold">
                                <?php echo Form::text('contact_info[0][fax_no]', e($value['fax_no']), ['class' => 'form-control
                                author_title','placeholder'=>trans('prs.ph_fax')]); ?>

                            </div>
                            <div class="form-group sj-authorhold">
                                <?php echo Form::email('contact_info[0][email]', e($value['email']), ['class' => 'form-control
                                author_title','placeholder'=>trans('prs.ph_email')]); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="wrap-home-slider">
                        <div class="form-group sj-authorhold">
                            <?php echo Form::text('contact_info[0][address]', null, ['class' => 'form-control
                            author_title','placeholder'=>trans('prs.ph_address')]); ?>

                        </div>
                        <div class="form-group sj-authorhold">
                            <?php echo Form::text('contact_info[0][phone_no]', null, ['class' => 'form-control
                            author_title','placeholder'=>trans('prs.ph_phone_no')]); ?>

                        </div>
                        <div class="form-group sj-authorhold">
                            <?php echo Form::text('contact_info[0][fax_no]', null, ['class' => 'form-control
                            author_title','placeholder'=>trans('prs.ph_fax')]); ?>

                        </div>
                        <div class="form-group sj-authorhold">
                            <?php echo Form::email('contact_info[0][email]', null, ['class' => 'form-control
                            author_title', 'placeholder'=>trans('prs.ph_email')]); ?>

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
