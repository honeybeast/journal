 
<?php $breadcrumbs = Breadcrumbs::generate('accountSetting'); ?> 
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
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                <?php echo $__env->make('includes.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="account_setting">
                    <?php if(Session::has('message')): ?>
                        <div class="toast-holder">
                            <flash_messages :message="'<?php echo e(Session::get('message')); ?>'" :message_class="'success'" v-cloak></flash_messages>
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
                    <div id="sj-content" class="sj-content">
                        <div class="sj-addarticleholdcontent">
                            <div class="sj-dashboardboxtitle">
                                <h2><?php echo e(trans('prs.change_pswd')); ?></h2>
                            </div>
                            <div class="sj-acsettingthold">
                                <?php echo Form::open(['url' => '/dashboard/general/settings/account-settings/request-new-password', 
                                'class' => 'sj-formtheme sj-formpassword', 'id'=>'request_password']); ?>

                                    <fieldset>
                                        <div class="form-group sj-inputwithicon sj-password">
                                            <i class="lnr lnr-lock"></i> 
                                            <?php $old_error = $errors->has("old_password") ? 'is-invalid': "" ?> 
                                            <?php echo Form::password('old_password', ['class' => ['.e($old_error).'],'placeholder' => trans('prs.ph_oldpass')]); ?>

                                        </div>
                                        <div class="form-group sj-inputwithicon sj-password">
                                            <i class="lnr lnr-lock"></i> 
                                            <?php echo Form::password('password', ['class' => 'form-control', 'placeholder' => trans('prs.ph_newpass')]); ?>

                                        </div>
                                        <div class="form-group sj-inputwithicon sj-password">
                                            <i class="lnr lnr-lock"></i> 
                                            <?php echo Form::password('confirm_password', ['class' => 'form-control','placeholder' => trans('prs.ph_retype_pass')]); ?>

                                        </div>
                                        <?php echo Form::hidden('user_id', $user_id); ?>

                                    </fieldset>
                                    <div class="sj-btnarea sj-updatebtns">
                                        <?php echo Form::submit(trans('prs.btn_update'), ['class' => 'sj-btn sj-btnactive']); ?>

                                    </div>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                        <div class="sj-addarticleholdcontent">
                            <div class="sj-dashboardboxtitle">
                                <h2><?php echo e(trans('prs.profile_photo')); ?></h2>
                            </div>
                            <div class="sj-uploadimgbars">
                                <div class="sj-acsettingthold">
                                    <image-upload
                                        :delete_confirm_title="'<?php echo e(trans("prs.ph_file_delete_confirm_title")); ?>'"  
                                        :file_placeholder="'<?php echo e(trans("prs.ph_upload_file_label")); ?>'" 
                                        :file_size_label="'<?php echo e(trans("prs.ph_article_file_size")); ?>'" 
                                        :file_uploaded_label="'<?php echo e(trans("prs.ph_file_uploaded")); ?>'" 
                                        :file_not_uploaded_label="'<?php echo e(trans("prs.ph_file_not_uploaded")); ?>'"
                                        :delete_url=config.img_deleted
                                        :submit_url=config.img_upload
                                        :get_url=config.get_img
                                        :id="'user_img'"
                                        :submit_btn="'<?php echo e(trans('prs.btn_submit')); ?>'">
                                    </image-upload>
                                </div>
                            </div>
                        </div>
                        <div class="sj-addarticleholdcontent">
                            <div class="sj-dashboardboxtitle">
                                <h2>Author biography</h2>
                            </div>
                            <div class="sj-acsettingthold">
                                <form id="myForm" action="<?php echo e(url('dashboard/general/settings/account-settings/add_author_bio')); ?>" method="POST" target="notify">
                                    <?php echo e(csrf_field()); ?>

                                    <fieldset style="border:0; padding: 30px">
                                        <label>Title</label>
                                        <div class="form-group bio">
                                            <input type="text" name="title" required>
                                        </div>
                                        <label>Bio</label>
                                        <div class="form-group bio">
                                            <textarea required rows="8" name="bio"></textarea>
                                        </div>
                                        <label>Academic Affiliation</label>
                                        <div class="form-group bio">
                                           <select name="academic" required>
                                               <option disabled value="" selected hidden>Select Academic Affiliation</option>
                                               <option value="Postgrade student">Postgrade student</option>
                                               <option value="Teacher">Teacher</option>
                                               <option value="Lecturer">Lecturer</option>
                                               <option value="Senior lecturer">Senior lecturer</option>
                                               <option value="Asc prof">Asc prof</option>
                                               <option value="Prof">Prof</option>
                                               <option value="Assistant Prof">Assistant Prof</option>
                                           </select>
                                        </div>
                                        <label>Institute / university</label>
                                        <div class="form-group bio">
                                            <input type="text" name="institute" required="">
                                        </div>
                                        <?php echo Form::hidden('user_id', $user_id); ?>

                                    </fieldset>
                                    <div class="sj-btnarea sj-updatebtns">
                                        <input class="sj-btn sj-btnactive" type="submit" name="" value="Submit Now">
                                    </div>
                                </form>
                                <iframe name="notify" style="display: none;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        .bio{
            text-align: center;
        }
        .bio input, .bio textarea, .bio select{
            width: 100%;
        }
        .bio textarea{
            height: unset;
        }
    </style>
    <script type="text/javascript">
        function success_add(){
            swal("Success!", "Data Saved Successfully.", "success");
        }
        function success_update(){
            swal("Success!", "Data Updated Successfully.", "success");
        }
       
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>