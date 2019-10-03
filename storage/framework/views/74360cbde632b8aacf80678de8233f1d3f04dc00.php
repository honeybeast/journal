<?php $breadcrumbs = Breadcrumbs::generate('paymentSettings'); ?>
<?php $__env->startSection('breadcrumbs'); ?>
    <?php if(count($breadcrumbs)): ?>
        <ol class="sj-breadcrumb">
            <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($breadcrumb->url && !$loop->last): ?>
                    <li><a href="<?php echo e($breadcrumb->url); ?>"><?php echo e($breadcrumb->title); ?></a></li>
                <?php else: ?>
                    <li class="active"><?php echo e($breadcrumb->title); ?></li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div id="sj-twocolumns" class="sj-twocolumns">
        <?php echo $__env->make('includes.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="payment_settings">
            <?php if(Session::has('success')): ?>
                <div class="toast-holder">
                    <flash_messages :message="'<?php echo e(Session::get('success')); ?>'" :message_class="'success'" v-cloak></flash_messages>
                </div>
            <?php elseif(Session::has('error')): ?>
                <div class="toast-holder">
                    <flash_messages :message="'<?php echo e(Session::get('error')); ?>'" :message_class="'danger'" v-cloak></flash_messages>
                </div>
            <?php elseif($errors->any()): ?>
                <div class="toast-holder">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <flash_messages :message="'<?php echo e($error); ?>'" :message_class="'danger'" v-cloak></flash_messages>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
           <?php endif; ?>
            <div class="sj-addarticleholdcontent">
                <div class="sj-dashboardboxtitle">
                    <h2><?php echo e(trans('prs.product_payment_mode')); ?></h2>
                </div>
                <div class="sj-acsettingthold">
                    <?php echo Form::open(['url' => '/dashboard/superadmin/site-management/payment/store-product-type',
                        'class' => 'sj-formtheme sj-formarticle sj-formsocical', 'enctype' => 'multipart/form-data', 'multiple' => true]); ?>

                        <fieldset>
                            <div class="wrap-home-slider">
                                <?php $__currentLoopData = $product_mode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group half-width assign-role">
                                        <span class="sj-radio">
                                            <?php echo e(Form::radio('payment_mode[]', $key, ($existing_product_mode === $key) ? true : false, array('id' => $key))); ?>

                                            <?php echo e(Form::label($key, ucfirst($mode))); ?>

                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </fieldset>
                        <div class="sj-btnarea sj-updatebtns">
                            <?php echo Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']); ?>

                        </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
            <?php if(!empty($existing_product_mode) && $existing_product_mode == "individual-product"): ?>
                <div class="sj-addarticleholdcontent">
                    <div class="sj-dashboardboxtitle">
                        <h2><?php echo e(trans('prs.payment_settings')); ?></h2>
                    </div>
                    <div class="sj-acsettingthold">
                        <?php echo Form::open(['url' => '/dashboard/superadmin/site-management/payment/store-payment-settings', 'class' => 'sj-formtheme sj-formsocical']); ?>

                            <?php
                                $existing_payment_settings_client = '';
                                $client_id = '';
                                $currency_from_db = array();
                                $vat = '';
                                $payment_type = '';
                                $existing_payment_password = '';
                                $existing_payment_secret = '';
                                if (!empty($existing_payment_settings)) {
                                    $client_id =  $existing_payment_settings[0]['client_id'];
                                    $currency_from_db = $existing_payment_settings[0]['currency'];
                                    $vat = $existing_payment_settings[0]['vat'];
                                    $payment_type = $existing_payment_settings[0]['payment_type'];
                                    $payment_password = $existing_payment_settings[0]['paypal_password'];
                                    $existing_payment_secret = $existing_payment_settings[0]['paypal_secret'];
                                }
                            ?>
                            <fieldset>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        <?php echo Form::text('client_id', e($client_id), ['class' => 'form-control', 'placeholder' => trans('prs.ph_paypal_id')]); ?>

                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        <?php echo e(Form::input('password', 'paypal_password', e($payment_password),['class' => 'form-control', 'placeholder' => trans('prs.ph_paypal_pass')])); ?>

                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        <?php echo e(Form::input('password', 'paypal_secret', e($existing_payment_secret),['class' => 'form-control', 'placeholder' => trans('prs.ph_paypal_secret')])); ?>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        <span class="sj-select">
                                            <select name="currency" class="form-control">
                                                <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        if($currency_from_db == $value['code']){ $selected = 'selected';}else{$selected="";}
                                                    ?>
                                                    <option value="<?php echo e($value['code']); ?>" <?php echo e($selected); ?>> <?php echo e($value['code']); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        <?php echo Form::text('vat', $vat, ['class' => 'form-control', 'placeholder' => trans('prs.vat')]); ?>

                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        <span class="sj-select">
                                            <select name="payment_type" class="form-control">
                                                <option value="" <?php if($payment_type == ""): ?> selected <?php endif; ?>> <?php echo e(trans('prs.select_payment_mode')); ?></option>
                                                <option value="test_mode" <?php if($payment_type == "test_mode"): ?> selected <?php endif; ?>> <?php echo e(trans('prs.test_mode')); ?></option>
                                                <option value="live_mode" <?php if($payment_type == "live_mode"): ?> selected <?php endif; ?>> <?php echo e(trans('prs.live_mode')); ?></option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="sj-btnarea sj-updatebtns">
                                <?php echo Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']); ?>

                            </div>
                    <?php echo Form::close(); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>