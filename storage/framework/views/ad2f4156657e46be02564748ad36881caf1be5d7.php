<?php $breadcrumbs = Breadcrumbs::generate('checkAuthor'); ?>
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
    <style type="text/css">
        .chosen-container-multi .chosen-choices li.search-field input[type="text"] {
            height: 42px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="sj-twocolumns" id="new_article">
                <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 float-right">
                    <?php if(Session::has('upload_error')): ?>
                        <div class="toast-holder">
                            <flash_messages :message="'<?php echo e(Session::get('upload_error')); ?>'" :message_class="'danger'" v-cloak></flash_messages>
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
                    <transition name="fade">
                        <div class="toast-holder" v-if="form_errors.length" v-show="custom_error" v-cloak>
                            <div id="toast-container" v-for="error in form_errors">
                                <div class="alert toast-danger alart-message alert-dismissible fade show fixed_message">
                                    <div class="toast-message">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button> {{error}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>
                    <div class="provider-site-wrap" v-show="loading" v-cloak>
                        <div class="provider-loader">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div>
                    <sticky_messages :message="'Article is Submitting'" v-show="progressing" v-cloak></sticky_messages>
                    <div id="sj-content" class="sj-content sj-addarticleholdcontent">
                        <div class="sj-dashboardboxtitle">
                            <h2><?php echo e(trans('prs.add_article')); ?></h2>
                        </div>
                        <div class="sj-addarticlehold">
                            <?php echo Form::open(['url' => 'author/store-article', 'enctype' => 'multipart/form-data', 'multiple' => true,
                            'id'=>'article_form', 'class' => 'total-fields sj-formtheme sj-formarticle', '@submit' => 'checkForm']); ?>

                                <fieldset class="">
                                    <div class="form-group" id="title_input">
                                        <?php echo Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('prs.ph_article_title'), 'id'=>'article_title', '@keyup' => 'autoComplete' ]); ?>

                                    </div>
                                    <?php if(($categories != "")): ?>
                                        <div class="form-group">
                                            <span class="sj-select">
                                                <?php echo Form::select('category', $categories, null ,array('class' => '')); ?>

                                            </span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group sj-authorhold">
                                        <?php echo Form::text('authors[0][title]', null, ['class' => 'form-control author_title' ,'id'=>'first_author_name', 'placeholder' => trans('prs.ph_author_name'), '@keyup' => 'autoComplete']); ?>

                                    </div>
                                    <div class="form-group sj-authorholdvtwo">
                                        <?php echo Form::email('authors[0][email]', null, ['class' => 'form-control author_email','id'=>'first_author_email','placeholder' => trans('prs.ph_author_email'), '@keyup' => 'autoComplete']); ?>

                                        <div class="sj-adddelbtns">
                                            <span class="sj-addbtn" @click="addAnother"><i class="fa fa-plus"></i></span>
                                        </div>
                                    </div>
                                    <div v-for="(author, index) in authors" v-cloak>
                                        <div class="form-group sj-authorhold">
                                            <input placeholder="<?php echo e(trans('prs.ph_author_name')); ?>" v-bind:name="'authors['+[author.count]+'][title]'" type="text" class="form-control" v-model="author.author_name">
                                        </div>
                                        <div class="form-group sj-authorholdvtwo">
                                            <input placeholder="<?php echo e(trans('prs.ph_author_email')); ?>" v-bind:name="'authors['+[author.count]+'][email]'" type="email" class="form-control author_email" v-model="author.author_email">
                                            <div class="sj-adddelbtns">
                                                <span class="sj-addbtn sj-delbtn" @click="removeAuthor(index)"><i class="fa fa-plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::textarea('abstract', null, ['class' => 'form-control template_data page-textarea', 'id' => 'abstract', 'placeholder' => trans('prs.ph_add_abstract'), '@keyup' => 'autoComplete']); ?>

                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" id="keywords" name="keywords[]" type="text" value="">

                                        <div class="sj-filedetails"><span>You should add 4 keywords, maximum 6 keywords.</span></div>
                                        <!-- <?php echo Form::textarea('abstract', null, ['class' => 'form-control template_data page-textarea', 'id' => 'abstract', 'placeholder' => trans('prs.ph_add_abstract'), '@keyup' => 'autoComplete']); ?> -->
                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::textarea('excerpt', null, ['class' => 'form-control excerpt', 'id' => 'excerpt', 'placeholder' => trans('prs.ph_excerpt'), '@keyup' => 'autoComplete']); ?>

                                    </div>
                                    <upload-files-field
                                        :doc_id="create_article"
                                        :field_title="'<?php echo e(trans("prs.ph_upload_article")); ?>'"
                                        :file_name="this.file_input_name"
                                        :file_placeholder="'<?php echo e(trans("prs.ph_upload_file_label")); ?>'"
                                        :file_size_label="'<?php echo e(trans("prs.ph_article_file_size")); ?>'"
                                        :file_not_uploaded_label="'<?php echo e(trans("prs.ph_file_not_uploaded")); ?>'">
                                    </upload-files-field>
                                </fieldset>
                                <div class="sj-submitdetails">
                                    <input style="margin-left: 10px;" type="checkbox" value="policy" class="form-check-input required" id="policy">
                                    <span style="margin-left: 30px;"><?php echo e(trans('prs.accept_note')); ?><a href="javascript:void(0);" style="margin-left: 5px;"><?php echo e(trans('prs.terms_conditions')); ?></a></span>
                                    <?php echo Form::submit(trans('prs.btn_submit'), ['class' => 'sj-btn sj-btnactive']); ?>

                                    <!-- <input type="submit" name="submit" value="Submit Now" class="sj-btn sj-btnactive"> -->
                                </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 float-left">
                    <aside id="sj-sidebarvtwo" class="sj-sidebar">
                        <div class="sj-profilestrenght">
                            <div class="sj-headerhold">
                                <div class="sj-dashboardboxtitle">
                                    <h2><?php echo e(trans('prs.req_fields')); ?></h2>
                                    <span><?php echo e(trans('prs.foll_fields_must')); ?></span>
                                </div>
                            </div>
                            <ul class="sj-profilecomplete">
                                <li v-bind:class="{ 'sj-profileerror': this.title_error, 'sj-profilecompleted': this.title_completed }">
                                    <i v-bind:class="{ 'ti-na': this.title_na, 'ti-check': this.title_check }"></i>
                                    <span><?php echo e(trans('prs.article_title')); ?></span>
                                </li>
                                <li v-bind:class="{ 'sj-profileerror': this.author_error, 'sj-profilecompleted': this.author_completed }">
                                    <i v-bind:class="{ 'ti-na': this.author_na, 'ti-check': this.author_check }"></i>
                                    <span><?php echo e(trans('prs.first_author')); ?></span>
                                </li>
                                <li v-bind:class="{ 'sj-profileerror': this.abst_error, 'sj-profilecompleted': this.abst_completed }">
                                    <i v-bind:class="{ 'ti-na': this.abst_na, 'ti-check': this.abst_check }"></i>
                                    <span><?php echo e(trans('prs.add_abstract')); ?></span>
                                </li>
                                <li v-bind:class="{ 'sj-profileerror': this.excerpt_error, 'sj-profilecompleted': this.excerpt_completed }">
                                    <i v-bind:class="{ 'ti-na': this.excerpt_na, 'ti-check': this.excerpt_check }"></i>
                                    <span><?php echo e(trans('prs.add_excerpt')); ?></span>
                                </li>
                                <li class="uploadfilestatus" v-bind:class="{ 'sj-profileerror': this.upload_file_error, 'sj-profilecompleted': this.upload_file_completed }">
                                    <i class="uploadstatusinner" v-bind:class="{ 'ti-na': this.upload_file_na, 'ti-check': this.upload_file_check }"></i>
                                    <span><?php echo e(trans('prs.upload_doc')); ?></span>
                                </li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        //     function check(e){

        //     var theEditor = tinymce.activeEditor;
        //     var wordCount = theEditor.plugins.wordcount.getCount();
        //     var keywords = $('#keywords').val();
        //     var keyword = keywords.split(",");

        //     if (wordCount>5) {
        //         swal("Warning!", "Abstract can't over more than 250 words.");
        //         e.preventDefault();
        //         return false;
        //     }
        //     else if( keyword.length < 4 || keyword.length > 6){
        //        swal("Warning!", "The number of keywords must be between 4 and 6.");
        //     }
        //     else{
        //         $('#article_form').submit();
        //     }
        // }

        (function($) {
            $(document).ready(function() {
                source_url = "<?php echo e(url('author/user/articlekeywords')); ?>";
                $('#keywords').tagsInput({
                    'autocomplete_url': source_url,
                    'autocomplete': {
                        source: source_url,
                        dataType: "json",
                    }
                });
            });
        })(jQuery);

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>