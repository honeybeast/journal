<?php $breadcrumbs = Breadcrumbs::generate('editionSetting'); ?>
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
    <div id="general_setting">
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
        <div class="provider-site-wrap" v-show="loading" v-cloak>
            <div class="provider-loader">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div id="sj-twocolumns" class="sj-twocolumns">
                    <?php echo $__env->make('includes.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right">
                        <sticky_messages :message="this.message"></sticky_messages>
                        <div id="sj-content editiontemplate" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo sj-editiontemplate">
                            <div class="sj-dashboardboxtitle sj-titlewithform">
                                <h2><?php echo e(trans('prs.manage_edition')); ?></h2>
                                <?php echo Form::open(['url' => '/dashboard/edition/settings/search-edition', 'method' => 'get', 'class' => 'sj-formtheme sj-formsearchvtwo']); ?>

                                    <div class="sj-sortupdown">
                                        <a href="javascript:void(0);"><i class="fa fa-sort-amount-up"></i></a>
                                    </div>
                                    <fieldset>
                                        <input type="search" name="keyword" value="<?php echo e(!empty($_GET['keyword']) ? $_GET['keyword'] : ''); ?>" class="form-control" id="search_edition_input" placeholder="<?php echo e(trans('prs.ph_search_here')); ?>">
                                        <button type="submit" class="sj-btnsearch"><i class="lnr lnr-magnifier"></i></button>
                                    </fieldset>
                                <?php echo Form::close(); ?>

                            </div>
                            <div class="sj-manageallsession sj-editionsettings">
                                <ul class="sj-allcategorys editions">
                                    <li class="sj-addcategorys">
                                        <?php echo Form::open(['url' => '/dashboard/general/settings/create-edition',
                                        'class'=>'sj-formtheme sj-formmanagevthree sj-formmanage' .$payment_class]); ?>

                                            <fieldset>
                                                <div class="form-group">
                                                    <input type="text" name="title" value="" class="form-control <?php echo e($errors->has(" title ") ? "is-invalid " : " "); ?>" placeholder="<?php echo e(trans('prs.ph_add_edit_title')); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <date-picker
                                                        name="edition_date"
                                                        v-model="date"
                                                        :config="config"
                                                        :placeholder="'<?php echo e(trans("prs.ph_edition_date")); ?>'"
                                                        class="form-control <?php echo e($errors->has('edition_date') ? ' is-invalid' : ''); ?>">
                                                    </date-picker>
                                                </div>
                                                <?php if($payment_mode != "free"): ?>
                                                    <div class="form-group sj-tooltip">
                                                        <i class="fa fa-question-circle" rel="tooltip" title="<?php echo e(trans('prs.edition_def_price')); ?>"></i>
                                                        <?php echo Form::number('price', null, ['class' => 'form-control', 'min' => '1', 'placeholder' => trans('prs.ph_edition_price') ]); ?>

                                                    </div>
                                                <?php endif; ?>
                                                <div class="sj-categorysbtn">
                                                    <?php echo Form::submit(trans('prs.btn_save'), ['class' => 'sj-checkbtn']); ?>

                                                </div>
                                            </fieldset>
                                        <?php echo Form::close(); ?>

                                    </li>
                                    <?php if($editions->count() != 0): ?>
                                        <?php $__currentLoopData = $editions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $articles = App\Edition::getEditionArticle($edition->id); ?>
                                            <li class="sj-categorysinfo delEdition-<?php echo e($edition->id); ?>" v-bind:id="editionID">
                                                <div class="sj-title">
                                                    <h3>
                                                        <?php echo e($edition->title); ?>

                                                        <span> (<?php echo e(Carbon\Carbon::parse($edition->edition_date)->format('F, j, Y')); ?>) </span>
                                                        <br>
                                                    </h3>
                                                </div>
                                                <div class="sj-categorysrightarea">
                                                    <?php
                                                        $delete_title = trans("prs.ph_delete_confirm_title");
                                                        $delete_message = trans("prs.ph_edition_delete_message");
                                                        $deleted = trans("prs.ph_delete_title");
                                                        $user_id = Auth::User()->id;
                                                        $role_type = App\User::getUserRoleType($user_id);
                                                        $role = $role_type->role_type;
                                                    ?>
                                                    <?php if(!empty($articles)): ?>
                                                        <a class="sj-btn sj-btnactive" href="<?php echo e(url('/dashboard/general/settings/edit-edition/'.$edition->id)); ?>">
                                                            View Assigned Manuscripts
                                                        </a>
                                                    <?php elseif($role == 'editor' || $role == 'superadmin' ): ?>
                                                        <a href="<?php echo e(url('/dashboard/general/settings/edit-edition/'.$edition->id)); ?>" class="sj-btn sj-btnactive">
                                                            Assign Manuscripts
                                                        </a>
                                                    <?php endif; ?>
                                                    <a title="Publish Article" href="#" v-on:click.prevent="publishEdition($event)" class="" id="<?php echo e($edition->id); ?>">
                                                        <i class="fa fa-book"></i>
                                                    </a>
                                                    <a href="<?php echo e(url('/dashboard/general/settings/edit-edition/'.$edition->id)); ?>" class="sj-pencilbtn" id="<?php echo e($edition->id); ?>">
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                    <a href="#" v-on:click.prevent="deleteEdition($event,'<?php echo e($delete_title); ?>','<?php echo e($delete_message); ?>','<?php echo e($deleted); ?>')" class="sj-trashbtn" id="<?php echo e($edition->id); ?>">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php endif; ?>
                                </ul>
                                <?php if( method_exists($editions,'links') ): ?> <?php echo e($editions->links('pagination.custom')); ?> <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>