 
<?php $breadcrumbs = Breadcrumbs::generate('categorySetting'); ?> 
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
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="general_setting">
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
                    <sticky_messages :message="this.message"></sticky_messages>
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2><?php echo e(trans('prs.manage_category')); ?></h2>
                        </div>
                        <div class="sj-manageallsession">
                            <form class="sj-formtheme sj-managesessionform">
                                <fieldset>
                                    <div class="form-group">
                                        <a href="#" data-toggle="modal" data-target="#categoryModal" class="sj-btn sj-btnactive">
                                            <?php echo e(trans('prs.new_cat')); ?>

                                        </a>
                                    </div>
                                </fieldset>
                            </form>
                            <ul class="sj-allcategorys">
                                <?php if($categories->count() > 0): ?> 
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="sj-categorysinfo del-<?php echo e($category->id); ?>" v-bind:id="categoryID">
                                            <div class="sj-title">
                                                <h3><?php echo e($category->title); ?></h3>
                                            </div>
                                            <div class="sj-categorysrightarea">
                                                <?php 
                                                    $delete_title = trans("prs.ph_delete_confirm_title"); 
                                                    $delete_message = trans("prs.ph_category_delete_message");
                                                    $deleted = trans("prs.ph_delete_title"); 
                                                ?>
                                                <a href="#" class="sj-pencilbtn" data-toggle="modal" data-target="#categoryEditModal-<?php echo e($counter); ?>">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                                <a href="#" v-on:click.prevent="deleteCategory($event,'<?php echo e($delete_title); ?>','<?php echo e($delete_message); ?>','<?php echo e($deleted); ?>')" class="sj-trashbtn" id="<?php echo e($category->id); ?>">
                                                    <i class="ti-trash"></i>
                                                </a>
                                            </div>
                                        </li>
                                        <div class="sj-modalboxarea modal fade del-<?php echo e($category->id); ?>" tabindex="-1" role="dialog" 
                                            aria-labelledby="categoryEditModalLabel" aria-hidden="true" id="categoryEditModal-<?php echo e($counter); ?>">
                                            <div class="modal-dialog" role="document">
                                                <div class="sj-modalcontent modal-content cat-model">
                                                    <div class="sj-popuptitle">
                                                        <h2><?php echo e(trans('prs.edit_cat')); ?></h2>
                                                        <a href="javascript;void(0);" class="sj-closebtn close">
                                                            <i class="lnr lnr-cross" data-dismiss="modal" aria-label="Close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo Form::open(['url' => '/dashboard/general/settings/edit-category/'.$category->id,'class'=>'category_edit_form edit_form', 
                                                        'files' => true, 'enctype' => 'multipart/form-data']); ?>

                                                            <fieldset>
                                                                <div class="form-group">
                                                                    <?php echo Form::text('title', $category->title, ['class' => 'form-control', 'required' => 'required']); ?>

                                                                </div>
                                                                <div class="form-group">
                                                                    <?php echo Form::textarea('description', $category->description, ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('prs.ph_cat_desc')]); ?>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ISSN for Print</label>
                                                                    <?php echo Form::text('issn_print', $category->issn_print, ['class' => 'form-control', 'placeholder' => "ISSN for Print"]); ?>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ISSN for Electronic</label>
                                                                    <?php echo Form::text('issn_electronic', $category->issn_electronic, ['class' => 'form-control', 'placeholder' => "ISSN for Electronic"]); ?>

                                                                </div>
                                                                <div class="form-group">
                                                                    <upload-files-field
                                                                        :field_title="this.uploadArticleTitle"
                                                                        :uploaded_file="'<?php echo e(App\UploadMedia::getImageName($category->image)); ?>'"
                                                                        :hidden_field_name="'hidden_category_image'"
                                                                        :doc_id="edit_category +'<?php echo e($category->id); ?>'"
                                                                        :file_name="this.file_input_name"
                                                                        :file_placeholder="'<?php echo e(trans("prs.ph_upload_file_label")); ?>'"
                                                                        :file_size_label="'<?php echo e(trans("prs.ph_article_file_size")); ?>'"
                                                                        :file_uploaded_label="'<?php echo e(trans("prs.ph_file_uploaded")); ?>'"
                                                                        :file_not_uploaded_label="'<?php echo e(trans("prs.ph_file_not_uploaded")); ?>'">
                                                                    </upload-files-field>
                                                                </div>
                                                                <label>Abstract and Indexing<span class="abs_add_btn" id="add_abs_cur" ><i class="fa fa-plus"></i></span></label>
                                                                  <div class="form-group abstract-cur">
                                                                    <?php
                                                                      $abstract = DB::table('abstract')->where('jo_id', $category->id)->get();
                                                                    ?>
                                                                    <?php if(count($abstract)): ?>
                                                                          <?php $__currentLoopData = $abstract; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="abstract-item-cur">
                                                                              <div style="position: relative;">
                                                                                <input type="hidden" class="abstract-id" name="abstract_id[]" value="<?php echo e($val->id); ?>">
                                                                                <input type="hidden" class="logo-img-flag" name="logo_img_changed[]" value="0">
                                                                                <input type="file" class="form-control file_input file" name="logo_img[]" title="" style="margin-bottom: 10px; position: absolute; z-index: 2;opacity: 0;">
                                                                                <span class="file_val" style="display: block;height: 42px; background-color: white;     border: 1px solid #dbdbdb; border-radius: 6px; margin-bottom: 10px; padding: 10px;"><?php echo e($val->logo_img); ?></span>
                                                                              </div>
                                                                              <input class="form-control" required="required" type="text" name="abstract_title[]" placeholder="Input Title" style="margin-bottom: 10px" value="<?php echo e($val->abstract_title); ?>">
                                                                              <input class="form-control valid_url" required="required" name="abstract_url[]" placeholder="Input Url" style="margin-bottom: 10px" value="<?php echo e($val->abstract_url); ?>">
                                                                              <span class="sj-addbtn sj-delbtn abs_del_cur"style="float: right; margin-bottom: 10px"><i class="fa fa-plus"></i></span>
                                                                              <div style="clear:both;"></div>
                                                                            </div>
                                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php endif; ?> 
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
                                        <?php $counter++; ?> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                <?php else: ?>
                                    <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                                <?php endif; ?>
                            </ul>
                            <div class="sj-modalboxarea modal fade" id="categoryModal" tabindex="-1" role="dialog" 
                                aria-labelledby="categoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="sj-modalcontent modal-content cat-model">
                                        <div class="sj-popuptitle">
                                            <h2><?php echo e(trans('prs.new_cat')); ?></h2>
                                            <a href="javascript;void(0);" class="sj-closebtn close">
                                                <i class="lnr lnr-cross" data-dismiss="modal" aria-label="Close"></i>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo Form::open(['url' => '/dashboard/general/settings/create-category','class'=>'category_edit_form edit_form', 'id'=>'group_form', 
                                            'enctype' => 'multipart/form-data', 'multiple' => true]); ?>

                                                <fieldset>
                                                    <div class="form-group">
                                                        <?php echo Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('prs.ph_cat_title')]); ?>

                                                    </div>
                                                    <div class="form-group">
                                                        <?php echo Form::textarea('description', null, ['class' => 'form-control', 'required' =>'required', 'placeholder' => trans('prs.ph_cat_desc')]); ?>

                                                    </div>
                                                    <div class="form-group">
                                                        <label>ISSN for Print</label>
                                                        <?php echo Form::text('issn_print', null, ['class' => 'form-control', 'placeholder' => "ISSN for Print"]); ?>

                                                    </div>
                                                    <div class="form-group">
                                                        <label>ISSN for Electronic</label>
                                                        <?php echo Form::text('issn_electronic', null, ['class' => 'form-control', 'placeholder' => "ISSN for Electronic"]); ?>

                                                    </div>
                                                    <div class="form-group">
                                                        <upload-files-field
                                                            :field_title="'<?php echo e(trans("prs.ph_upload_file")); ?>'"
                                                            :doc_id="this.create_category"
                                                            :hidden_field_name="'hidden_category_image'"
                                                            :file_name="this.file_input_name"
                                                            :file_placeholder="'<?php echo e(trans("prs.ph_upload_file_label")); ?>'"
                                                            :file_size_label="'<?php echo e(trans("prs.ph_article_file_size")); ?>'"
                                                            :file_uploaded_label="'<?php echo e(trans("prs.ph_file_uploaded")); ?>'"
                                                            :file_not_uploaded_label="'<?php echo e(trans("prs.ph_file_not_uploaded")); ?>'" >
                                                        </upload-files-field>
                                                    </div>
                                                    <label>Abstract and Indexing<span class="abs_add_btn" id="add_abs"><i class="fa fa-plus"></i></span></label>
                                                    <div class="form-group abstract">
                                                      <div class="abstract-item">
                                                        <input type="file" title="" class="form-control file" name="logo_img[]" style="margin-bottom: 10px;">
                                                        <input type="hidden" class="logo-img-flag" name="logo_img_changed[]" value="0">
                                                        <input class="form-control" required="required" type="text" name="abstract_title[]" placeholder="Input Title" style="margin-bottom: 10px">
                                                        <input class="form-control add_url" required="required" name="abstract_url[]" placeholder="Input Url" style="margin-bottom: 10px">
                                                        <span class="sj-addbtn sj-delbtn abs_del" style="float: right; margin-bottom: 10px"><i class="fa fa-plus"></i></span>
                                                      </div>
                                                    </div>
                                                </fieldset>
                                                <div class="sj-popupbtn">
                                                    <?php echo Form::submit(trans('prs.btn_submit'), ['class' => 'sj-btn sj-btnactive']); ?>

                                                </div>
                                            <?php echo Form::close(); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if( method_exists($categories,'links') ): ?> <?php echo e($categories->links('pagination.custom')); ?> <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php echo $__env->make('includes.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>