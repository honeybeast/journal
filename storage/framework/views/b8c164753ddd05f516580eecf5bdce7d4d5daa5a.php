<?php $__env->startSection('content'); ?>
    <?php
        if (!empty($_GET['user_id']) && !empty($_GET['email_type'])) {
            $user_id = $_GET['user_id'];
            $email_type = $_GET['email_type'];
            if (!empty($_GET['status']) && !empty($_GET['id'])) {
                $action = route('login',['user_id='.$user_id,'email_type='.$email_type,'status='.$_GET['status'],'id='.$_GET['id']]);
            } elseif (!empty($_GET['status'])) {
                $action = route('login',['user_id='.$user_id,'email_type='.$email_type,'status='.$_GET['status']]);
            } elseif (!empty($_GET['invoice_id'])) {
                $action = route('login',['user_id='.$user_id,'email_type='.$email_type,'invoice_id='.$_GET['invoice_id']]);
            } else {
                $action = route('login',['user_id='.$user_id,'email_type='.$email_type]);
            }
        }else{
            $action = route('login');
        }
        $reg_data = App\SiteManagement::getMetaValue('reg_data');
        $login_focus = '';
        $register_focus = '';
        if (!empty($_GET['type'])) {
            if ($_GET['type'] == 'login') {
                $login_focus = 'autofocus';
            } elseif ($_GET['type'] == 'register') {
                $register_focus = 'autofocus';
            }
        }
    ?>
    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row" id="user_register">
                <?php if(Session::has('message')): ?>
                    <div class="toast-holder">
                        <flash_messages :message="'<?php echo e(Session::get('message')); ?>'" :message_class="'success'" v-cloak></flash_messages>
                    </div>
                <?php elseif(Session::has('error')): ?>
                    <div class="toast-holder">
                        <flash_messages :message="'<?php echo e(Session::get('error')); ?>'" :message_class="'danger'" v-cloak></flash_messages>
                    </div>
                <?php endif; ?>
                <div class="provider-site-wrap" v-show="loading" v-cloak><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                    <aside id="sj-sidebarvtwo" class="sj-sidebar">
                        <div class="sj-widget sj-widgetlogin">
                            <div class="sj-widgetheading">
                                <h3><?php echo e(trans('prs.login_now')); ?></h3>
                            </div>
                            <div class="sj-widgetcontent">
                                <form method="POST" action="<?php echo e($action); ?>" class="sj-formtheme sj-formlogin">
                                    <?php echo csrf_field(); ?>
                                    <fieldset>
                                        <div class="form-group">
                                            <input type="email" name="email" value="<?php echo e($errors->has('email') ? old('email') : ''); ?>" class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>"
                                            placeholder="<?php echo e(trans('prs.ph_email')); ?>" <?php echo e($login_focus); ?>>
                                            <?php if($errors->has('email')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" placeholder="<?php echo e(trans('prs.ph_pass')); ?>">
                                            <?php if($errors->has('password')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group sj-forgotpass">
                                            <div class="sj-checkbox">
                                                <input type="checkbox" id="remember" name="remember">
                                                <label for="remember"><?php echo e(trans('prs.keep_logged_in')); ?></label>
                                            </div>
                                            <a class="sj-forgorpass" href="<?php echo e(route('password.request')); ?>"><?php echo e(trans('prs.forgot_pass')); ?></a>
                                        </div>
                                        <div class="sj-btnarea">
                                            <button type="submit" class="sj-btn sj-btnactive"><?php echo e(trans('prs.btn_login')); ?></button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                    <div id="sj-content" class="sj-content">
                        <div class="sj-registerarea">
                            <div class="registernow">
                                <div class="sj-widgetheading">
                                    <h3><?php echo e(trans('prs.reg_now')); ?></h3>
                                </div>
                                <div class="sj-registerformholder">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <form method="POST" action="<?php echo e(route('register')); ?>" class="sj-formtheme sj-formregister" id="register_form" @submit="showloading()">
                                                <?php echo csrf_field(); ?>
                                                <fieldset>
                                                    <div class="form-group">
                                                        <input id="name" type="text" class="form-control<?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>"
                                                        placeholder="<?php echo e(trans('prs.ph_firstname')); ?>" required <?php echo e($register_focus); ?>>
                                                        <?php if($errors->has('name')): ?>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($errors->first('name')); ?></strong>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="sur_name" value="<?php echo e(old('sur_name')); ?>" class="form-control<?php echo e($errors->has('sur_name') ? 'is-invalid' : ''); ?>"
                                                        placeholder="<?php echo e(trans('prs.ph_surname')); ?>*" required>
                                                        <?php if($errors->has('sur_name')): ?>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($errors->first('sur_name')); ?></strong>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="email" type="email" class="form-control <?php echo e($errors->register->first('email') ? ' is-invalid' : ''); ?>"  name="email"
                                                        value="<?php echo e($errors->register->first('email') ? old('email') : ''); ?>" placeholder="<?php echo e(trans('prs.ph_email')); ?>" required>
                                                        <?php if($errors->register->first('email')): ?>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($errors->register->first('email')); ?></strong>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="password" type="password" class="form-control<?php echo e($errors->register->first('password') ? ' is-invalid' : ''); ?>" name="password"
                                                        placeholder="<?php echo e(trans('prs.ph_pass')); ?>" required>
                                                        <?php if($errors->register->first('password')): ?>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($errors->register->first('password')); ?></strong>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="<?php echo e(trans('prs.ph_cnfrm_pass')); ?>" required>
                                                    </div>
                                                    <div class="form-group half-width assign-role">
                                                        <span class="sj-radio">
                                                            <input id="author" checked="checked" name="role" type="radio" value="author">
                                                            <label for="author"><?php echo e(trans('prs.author')); ?></label>
                                                        </span>
                                                    </div>
                                                    <div class="form-group half-width assign-role">
                                                        <span class="sj-radio">
                                                            <input id="reader" name="role" type="radio" value="reader">
                                                            <label for="reader"><?php echo e(trans('prs.reader')); ?></label>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="sj-checkbox">
                                                            <input type="checkbox" id="terms_condition" name="terms_condition" class="form-control<?php echo e($errors->register->first('terms_condition') ? ' is-invalid' : ''); ?>" value="registered">
                                                            <label for="terms_condition"><?php echo e(trans('prs.terms_note')); ?> <a href="javascript:void(0);"><?php echo e(trans('prs.terms_conditions')); ?></a></label>
                                                            <?php if($errors->register->first('terms_condition')): ?>
                                                                <span class="invalid-feedback invalid-checkbox invalid-terms" role="alert">
                                                                    <strong><?php echo e($errors->register->first('terms_condition')); ?></strong>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="sj-btnarea">
                                                        <button type="submit" class="sj-btn sj-btnactive"><?php echo e(trans('prs.btn_reg')); ?></button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <?php if(!empty($reg_data)): ?>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="sj-howtoregister">
                                                    <?php $__currentLoopData = $reg_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <h3><?php echo e($value['title']); ?></h3>
                                                        <div class="sj-description">
                                                            <?php echo htmlspecialchars_decode(stripslashes($value['desc'])); ?>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>