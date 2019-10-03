<?php $__env->startSection('title'); ?><?php echo e(config('app.name')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('description', 'This is description tag'); ?>
<?php $__env->startSection('content'); ?>
    <?php if(Session::has('payment_message')): ?>
        <?php $response = Session::get('payment_message') ?>
        <div class="toast-holder">
            <div id="toast-container">
                <div class="alert toast-<?php echo e($response['code']); ?> alart-message alert-dismissible fade show fixed_message">
                    <div class="toast-message">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <?php echo e($response['message']); ?>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php
    if (Schema::hasTable('users')){
        $slide_unserialize_array = App\SiteManagement::getMetaValue('slides');
        $welcome_slide_unSerialize_array = App\SiteManagement::getMetaValue('welcome_slides');
        $published_articles = App\Article::getPublishedArticle();
        $page_slug  = App\SiteManagement::getMetaValue('pages');
        $page_data = App\Page::getPageData($page_slug[0]);
        if(!empty($page_data)){
        $welcome_desc = preg_replace("/<img[^>]+\>/i", " ", $page_data->body);
        }else{
            $welcome_desc = "";
        }
    }
    ?>

    <div class="jorunal sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="col-md-12  sj-borderheading">
                        <h2 style="font-weight: bolder; float: left; font-family: auto;"><?php echo e($journal[0]->title); ?></h2>
                    </div>
                    <?php
                        $journals = DB::table('categories')->orderBy('updated_at', 'desc') ->get();
                    ?>
                    <div class="j_content">
                        <div class="j_img">
                            <?php if(!empty($journal[0]->image)): ?>
                                <img src="<?php echo e(asset($journal[0]->image)); ?>">
                            <?php else: ?>
                                <img src="<?php echo e(asset('uploads/default_journal.jpg')); ?>">
                            <?php endif; ?>
                        </div>
                        <p class="j_detail"><?php echo e($journal[0]->description); ?></p>
                        <?php if($journal[0]->issn_print): ?>
                            <p class="issn">ISSN Number (Print) : <?php echo e($journal[0]->issn_print); ?></p>
                        <?php endif; ?>
                        <?php if($journal[0]->issn_electronic): ?>
                            <p class="issn">ISSN Number (Electronic) : <?php echo e($journal[0]->issn_electronic); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="editor" style="margin: 30px 0;">
                    <?php
                        $editors = DB::table('model_has_roles')->where('role_id', 2)->select('model_id')->get();
                            for($i=0; $i < count($editors) ; $i++){
                                $bio_data[$i] = DB::table('author_bio')
                                ->join('users', 'users.id', '=', 'author_bio.user_id')
                                ->where('author_bio.user_id', $editors[$i]->model_id)
                                ->get();
                            };
                    ?>
                    <?php if(count($editors)): ?>
                        <h5 style="font-size: 20px; font-family: none; font-weight: bolder;">Editor's Bio</h5>
                        <div style="margin-left: 30px">
                            <?php $__currentLoopData = $bio_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <hr>
                                <p><span style="font-weight: bolder;">Name : </span><?php echo e($val[0]->name); ?></p>
                                <p><span style="font-weight: bolder;">Bio : </span><br><?php echo e($val[0]->bio); ?></p>
                                <p><span style="font-weight: bolder;">Academic : </span><?php echo e($val[0]->academic); ?></p>
                                <p><span style="font-weight: bolder;">Institute : </span><?php echo e($val[0]->institute); ?></p>
                                <hr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                    </div>
                    <?php
                        $id = $journal[0]->id;
                        $reviewers = DB::table('reviewers_categories')
                        ->join('users','users.id', '=', 'reviewers_categories.reviewer_id' )
                        ->where('reviewers_categories.category_id', $id)
                        ->select('reviewers_categories.reviewer_id','users.name')->get();
                    ?>
                    <?php if(count($reviewers)): ?>
                    <div class="reviewer_list">
                        <h5 style="font-size: 20px; font-family: none; font-weight: bolder;">Peer reviewers list</h5>
                        <?php $__currentLoopData = $reviewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p style="margin-left: 30px; font-family: auto; font-size: 18px;"><?php echo e($val->name); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                    <div class="abstract_list">
                        <?php
                            $abstract = DB::table('abstract')->where('jo_id', $journal[0]->id) ->get();
                        ?>
                        <?php if(isset($abstract[0])): ?>
                            <h5 style="font-size: 20px; font-family: none; font-weight: bolder;">Abstracting and Indexing</h5>
                        <?php endif; ?>
                        <?php if(count($abstract)): ?>
                            <?php $__currentLoopData = $abstract; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6" style="float: left; margin-bottom: 20px;">
                                    <?php if($val->logo_img): ?>
                                        <img src="<?php echo e(asset('uploads/categories/'.$val->logo_img)); ?>" style="max-height: 70px; float: left; margin-right: 30px;">
                                    <?php else: ?>                                    
                                        <img src="<?php echo e(asset('uploads/scholar.png')); ?>" style="max-height: 70px; max-width: 100px; float: left; margin-right: 30px;">
                                    <?php endif; ?>
                                    <p style="margin: 10px 0; font-family: serif;"><?php echo e($val->abstract_title); ?></p>
                                    <a href="<?php echo e($val->abstract_url); ?>"><?php echo e($val->abstract_url); ?></a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>



                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                    <?php echo $__env->make('includes.widgets.most-download-widget', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
        </div>
    </div>
    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>