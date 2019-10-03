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
    <?php if(!empty($slide_unserialize_array)): ?>
        <div id="sj-homebanner" class="sj-homebanner owl-carousel">
            <?php $__currentLoopData = $slide_unserialize_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="sj-postbook">
                                <figure class="sj-featureimg">
                                    <div class="sj-bookimg">
                                        <div class="sj-frontcover">
                                            <img src="<?php echo e(asset('uploads/slider/images/'.$slide['slide_image'])); ?>" alt="<?php echo e(trans('prs.slide_img')); ?>">
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        </div>
                        <?php if(!empty($slide['slide_title']) || !empty($slide['slide_desc']) ): ?>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="sj-bannercontent">
                                <h1><?php echo htmlspecialchars_decode(stripslashes($slide['slide_title'])); ?></h1>
                                <div class="sj-description">
                                    <p><?php echo htmlspecialchars_decode(stripslashes($slide['slide_desc'])); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
    <?php if(!empty($page_data)): ?>
    <div class="sj-haslayout sj-welcomegreetingsection sj-sectionspace">
        <div class="container">
            <div class="row">
                <div class="sj-welcomegreeting">
                    <?php if(!empty($welcome_slide_unSerialize_array)): ?>
                        <div class="col-12 col-sm-12 col-md-5 col-lg-5 sj-verticalmiddle">
                            <div id="sj-welcomeimgslider" class="sj-welcomeimgslider sj-welcomeslider owl-carousel">
                                <?php $__currentLoopData = $welcome_slide_unSerialize_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <figure class="sj-welcomeimg item">
                                        <img src="<?php echo e(asset('uploads/settings/welcome_slider/'.$slide['welcome_slide_image'])); ?>" alt="<?php echo e(trans('prs.img_desc')); ?>">
                                    </figure>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-12 col-sm-12 col-md-7 col-lg-7 sj-verticalmiddle float-right">
                        <div class="sj-welcomecontent">
                            <div class="sj-welcomehead">
                                <span><?php echo e($page_data->sub_title); ?></span>
                                <h2><?php echo e($page_data->title); ?></h2>
                            </div>
                            <div class="sj-description">
                                <?php echo str_limit(htmlspecialchars_decode(stripslashes($welcome_desc)), 300) ?>
                            </div>
                            <div class="sj-btnarea">
                                <a class="sj-btn" href="<?php echo e(url('/page/'.$page_data->slug.'/')); ?>"><?php echo e(trans('prs.btn_read_more')); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="jorunal sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="col-md-12  sj-borderheading">
                        <h2 style="font-weight: bolder; float: left;">Jorunals</h2>
                        <a class="sj-btnview" style="margin-top: 30px;" href="<?php echo e(url('published/editions/articles')); ?>"><?php echo e(trans('prs.btn_view_all')); ?></a>
                    </div>
                    <?php
                        $journals = DB::table('categories')->orderBy('updated_at', 'desc') ->get();
                    ?>
                    <?php if(count($journals)): ?>
                        <?php $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 j_individual">
                                 <div class="logo">
                                    <a href="<?php echo e(url('journal_detail/'.$val->id)); ?>">
                                        <?php if(!empty($val->image)): ?>
                                            <img src="<?php echo e(asset($val->image)); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('uploads/default_journal.jpg')); ?>">
                                        <?php endif; ?>
                                    </a>
                                 </div>
                                 <div class="j_title">
                                     <h3><?php echo e($val->title); ?></h3>
                                 </div>
                                 <div class="j_des">
                                     <p class="j_des_txt"><?php echo e($val->description); ?></p>
                                 </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
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
                <?php if(!empty($published_articles)): ?>
                    <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                        <div id="sj-content" class="sj-content">
                            <section class="sj-haslayout sj-sectioninnerspace">
                                <div class="sj-borderheading">
                                    <h2 style="font-weight: bolder; float: left;" ><?php echo e(trans('prs.editions')); ?></h3>
                                    <a class="sj-btnview" style="margin-top: 30px;" href="<?php echo e(url('published/editions/articles')); ?>"><?php echo e(trans('prs.btn_view_all')); ?></a>
                                </div>
                                <div id="sj-editorchoiceslider" class="sj-editorchoiceslider sj-editorschoice">
                                    <?php if(!empty($published_articles)): ?>
                                        <?php $__currentLoopData = $published_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $edition_image = App\Helper::getEditionImage($article->edition_id,'medium') ;?>
                                            <article class="sj-post sj-editorchoice">
                                                <?php if(!empty($edition_image)): ?>
                                                    <figure class="sj-postimg">
                                                        <img src="<?php echo e(asset($edition_image)); ?>" alt="<?php echo e(trans('prs.article_img')); ?>">
                                                    </figure>
                                                <?php endif; ?>
                                                <div class="sj-postcontent">
                                                    <div class="sj-head">
                                                        <span class="sj-username"><?php echo e(App\User::getUserNameByID($article->corresponding_author_id)); ?></span>
                                                        <h3><a href="<?php echo e(url('article/'.$article->slug)); ?>"><?php echo e($article->title); ?></a></h3>
                                                    </div>
                                                    <div class="sj-description">
                                                        <?php echo str_limit($article->excerpt, 105); ?>
                                                    </div>
                                                    <a class="sj-btn" href="<?php echo e(url('article/'.$article->slug)); ?>"><?php echo e(trans('prs.btn_view_full_articles')); ?></a>
                                                </div>
                                            </article>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                        <?php echo $__env->make('includes.widgetsidebar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>