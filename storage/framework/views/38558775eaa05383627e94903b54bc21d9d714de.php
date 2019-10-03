<?php $breadcrumbs = Breadcrumbs::generate('editEdition',$id); ?>
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
<?php $counter = 0; ?>
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                <?php echo $__env->make('includes.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="general_setting">
                    <?php if(Session::has('error')): ?>
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
                    <sticky_messages :message="this.message"></sticky_messages>
                    <div id="sj-content editiontemplate" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo sj-editiontemplate">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2><?php echo e(trans('prs.edit_edition')); ?></h2>
                        </div>
                        <div class="sj-manageallsession sj-editionsettings">
                            <?php echo Form::open(['url' => '/dashboard/general/settings/update-edition/'.$edition->id,
                            'class'=>'sj-categorydetails category_edit_form sj-formtheme', 'files'=>'true']); ?>

                                <fieldset>
                                    <div class="form-category form-group">
                                        <?php echo Form::text('title', $edition->title, ['class' => 'form-control', 'required' => 'required']); ?>

                                    </div>
                                    <div class="form-group">
                                        <date-picker name="edition_date" value="<?php echo e($edition->edition_date); ?>" :config="config"></date-picker>
                                    </div>
                                    <?php if($payment_mode != "free"): ?>
                                        <div class="form-group">
                                            <?php echo Form::number('price', $edition->edition_price, ['class' => 'form-control', 'min' => '1', 'placeholder' => trans('prs.ph_edition_price')]); ?>

                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <upload-files-field
                                            :doc_id="'edition_cover'"
                                            :uploaded_file="'<?php echo e(App\Edition::getEditionImageByID($edition->id)); ?>'"
                                            :hidden_field_name="'hidden_edition_cover'"
                                            :file_name="'edition_cover'"
                                            :file_placeholder="'<?php echo e(trans("upload cover image")); ?>'"
                                            :file_size_label="'<?php echo e(trans("prs.ph_article_file_size")); ?>'"
                                            :file_uploaded_label="'<?php echo e(trans("prs.ph_file_uploaded")); ?>'"
                                            :file_not_uploaded_label="'<?php echo e(trans("prs.ph_file_not_uploaded")); ?>'">
                                        </upload-files-field>
                                    </div>
                                    <div class="form-group margin-none">
                                        <span class="sj-select">
                                            <select data-placeholder="<?php echo e(!empty($unassigned_articles) ? trans('prs.assing_articles') : trans('prs.no_article_found')); ?>"
                                             multiple class="chosen-select" name="articles[]">
                                                <optgroup>
                                                    <?php $__currentLoopData = $unassigned_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($article->id); ?>" <?php echo e(in_array($article->id, $assign_articles) ? 'selected' : ''); ?> >
                                                            <?php echo e($article->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </optgroup>
                                            </select>
                                        </span>
                                    </div>
                                </fieldset>
                                <div class="sj-popupbtn">
                                    <?php echo Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']); ?>

                                </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>