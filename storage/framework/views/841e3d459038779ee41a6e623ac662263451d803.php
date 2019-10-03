<?php  $breadcrumbs = Breadcrumbs::generate('editorArticles',$user_role,$user_id,$article_status); ?>
<?php $__env->startSection('breadcrumbs'); ?>
    <?php if(count($breadcrumbs)): ?>
        <ol class="sj-breadcrumb">
            <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($breadcrumb->url && !$loop->last): ?>
                    <li><a href="<?php echo e($breadcrumb->url); ?>"><?php echo e($breadcrumb->title); ?></a></li>
                <?php else: ?>
                    <li class="active"><?php echo e(App\Helper::displayArticleBreadcrumbsTitle($breadcrumb->title)); ?></li>
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
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="article">
                <div id="sj-content" class="sj-content sj-addarticleholdcontent">
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
                    <sticky_messages :message="this.success_message"></sticky_messages>
                    <div class="sj-dashboardboxtitle sj-titlewithform">
                        <h2><?php echo e($page_title); ?></h2>
                        <?php echo Form::open(['url' => url('/'.$user_role.'/dashboard/'.$user_id.'/'.Request::segment(4).'/article-search'), 'method' => 'get', 'class' => 'sj-formtheme sj-formsearchvtwo']); ?>

                            <div class="sj-sortupdown">
                                <a href="javascript:void(0);"><i class="fa fa-sort-amount-up"></i></a>
                            </div>
                            <fieldset>
                                <input type="search" name="keyword" value="<?php echo e(!empty($_GET['keyword']) ? $_GET['keyword'] : ''); ?>" class="form-control" placeholder="<?php echo e(trans('prs.ph_search_here')); ?>">
                                <button type="submit" class="sj-btnsearch"><i class="lnr lnr-magnifier"></i></button>
                            </fieldset>
                        <?php echo Form::close(); ?>

                    </div>
                    <ul id="accordion" class="sj-articledetails sj-articledetailsvtwo">
                        <?php if($articles->count() > 0): ?>
                            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $category = App\Category::getCategoryByID($article->article_category_id);
                                    $author = App\User::getUserDataByID($article->corresponding_author_id);
                                    $edition = App\Article::getArticleEdition($article->edition_id);
                                ?>
                                <li v-on:click.prevent="func($event)" id="headingOne-<?php echo e($article->id); ?>" class="sj-articleheader <?php echo e($errors->has('article_pdf') ? 'is-invalid' : ''); ?>"
                                    data-toggle="collapse" data-target="#collapseOne-<?php echo e($article->id); ?>" aria-expanded="true" aria-controls="collapseOne-<?php echo e($article->id); ?>">
                                    <div class="sj-detailstime">
                                        <?php if($article->notify == 1): ?>
                                            <span class="notify-icon" v-if="notified"><i class="fas fa-comment"></i></span>
                                        <?php endif; ?>
                                            <span><i class="ti-calendar"></i><?php echo e(Carbon\Carbon::parse($article->created_at)->format('d-m-Y')); ?></span>
                                        <?php if(!empty($category->title)): ?>
                                            <span><i class="ti-layers"></i><?php echo e($category->title); ?></span>
                                        <?php endif; ?>
                                            <span><i class="ti-bookmark"></i><?php echo e(trans('prs.id')); ?><?php echo e($article->unique_code); ?></span>
                                        <?php if(!empty($edition)): ?>
                                            <span><i class="ti-bookmark-alt"></i><?php echo e(trans('prs.edition')); ?>: <?php echo e($edition->title); ?></span>
                                        <?php endif; ?>
                                        <h4><?php echo e($article->title); ?></h4>
                                    </div>
                                    <div class="sj-nameandmail">
                                        <span><?php echo e(trans('prs.corresponding_author')); ?></span>
                                        <h4><?php echo e($author->name); ?></h4>
                                        <span class="sj-mailinfo"><?php echo e($author->email); ?></span>
                                    </div>
                                </li>
                                <li id="collapseOne-<?php echo e($article->id); ?>" class="collapse sj-active sj-userinfohold" aria-labelledby="headingOne-<?php echo e($article->id); ?>" data-parent="#accordion">
                                    <div class="sj-userinfoimgname">
                                        <figure class="sj-userinfimg">
                                            <img src="<?php echo e(asset(App\Helper::getUserImage($article->corresponding_author_id,$author->user_image,'medium'))); ?>" alt="<?php echo e(trans('prs.user_img')); ?>">
                                        </figure>
                                        <div class="sj-userinfoname">
                                            <span><?php echo e(Carbon\Carbon::parse($article->created_at)->diffForHumans()); ?> <?php echo e(trans('prs.on')); ?> <?php echo e(Carbon\Carbon::parse($article->created_at)->format('l \\a\\t H:i:s')); ?></span>
                                            <h3><?php echo e($article->title); ?></h3>
                                        </div>
                                        <?php if($article->status == "accepted_articles"): ?>
                                            <?php
                                                $edition = !empty($editions) ? $editions : array();
                                                $editionStatus = App\Edition::getEditionStatusByID($article->edition_id);
                                            ?>
                                            <div class="sj-acceptedarticleshold">
                                                <?php echo Form::open(['url' => url('/'.$user_role.'/dashboard/update-accepted-article'),'class'=>'sj-categorysform', 'id'  => $article->id, 'files' => true, 'enctype' => 'multipart/form-data']); ?>

                                                    <fieldset>
                                                        <div class="form-group">
                                                            <upload-files-field
                                                                :doc_id="assign_article_pdf+'<?php echo e($article->id); ?>'"
                                                                :uploaded_file="'<?php echo e(App\Article::getArticleFullName($article->publish_document)); ?>'"
                                                                :file_name="this.file_name"
                                                                :hidden_field_name="'hidden_pdf_field'"
                                                                :file_placeholder="'<?php echo e(trans("prs.ph_upload_pdf")); ?>'"
                                                                :file_size_label="'<?php echo e(trans("prs.ph_article_file_size")); ?>'"
                                                                :file_uploaded_label="'<?php echo e(trans("prs.ph_file_uploaded")); ?>'"
                                                                :file_not_uploaded_label="'<?php echo e(trans("prs.ph_file_not_uploaded")); ?>'">
                                                            </upload-files-field>
                                                        </div>
                                                        <?php if($payment_mode != "free"): ?>
                                                            <div class="form-group">
                                                                <?php echo Form::number('price',!empty($article->price) ? $article->price : null  , ['class' => 'form-control', 'min' => '1', 'placeholder' => trans('prs.ph_article_price') ]); ?>

                                                            </div>
                                                        <?php endif; ?>
                                                        <?php echo Form::hidden('article', $article->id); ?>

                                                        <div class="sj-categorysbtn">
                                                            <?php echo Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive','id' =>$article->id ]); ?>

                                                        </div>
                                                    </fieldset>
                                                <?php echo Form::close(); ?>

                                            </div>
                                        <?php elseif($article->status == "articles_under_review"): ?>
                                            <div class="sj-userbtnarea">
                                                <a href="<?php echo e(url('/'.$user_role.'/dashboard/'.$user_id.'/'.'articles-under-review'.'/'.$article->slug.'')); ?>" class="sj-btn sj-btnactive"><?php echo e(trans('prs.btn_view_detail')); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="sj-description">
                                            <?php echo htmlspecialchars_decode(stripslashes($article->excerpt)); ?>
                                        </div>
                                        <div class="sj-preview" style="float: right;">
                                            <p>
                                                <span>
                                                    <img src="<?php echo e(asset('images/thumbnails/pdf-img.png')); ?>" style="margin-right: 5px;">
                                                </span>
                                                <a href="<?php echo e(url('author/create-pdf/'. $article->id)); ?>" style="text-decoration: none !important;">Preview</a> | <a href="<?php echo e(url('author/download-pdf/'. $article->id)); ?>" style="text-decoration: none !important;">Download</a>
                                            </p>
                                        </div>
                                        <div class="sj-downloadheader">
                                            <div class="sj-title">
                                                <h3><?php echo e(trans('prs.attached_doc')); ?></h3>
                                                <a href="<?php echo e(route('getfile', $article->submitted_document)); ?>">
                                                    <i class="lnr lnr-download"></i><?php echo e(trans('prs.btn_download')); ?>

                                                </a>
                                            </div>
                                            <div class="sj-docdetails">
                                                <figure class="sj-docimg">
                                                    <img src="<?php echo e(asset('images/thumbnails/doc-img.jpg')); ?>" alt="<?php echo e(trans('prs.doc_img')); ?>">
                                                </figure>
                                                <div class="sj-docdescription">
                                                    <h4><?php echo e(App\Article::getArticleFullName($article->submitted_document)); ?></h4>
                                                    <span><?php echo e(trans('prs.file_size')); ?> <?php echo e(App\UploadMedia::getArticleSize($article->corresponding_author_id,$article->submitted_document)); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $comments = App\Article::getAdminArticleComments($article->id,'reviewer'); ?>
                                    <?php if(!empty($comments)): ?>
                                        <div class="sj-feedbacktitle">
                                            <h2><?php echo e(trans('prs.feedback')); ?></h2>
                                        </div>
                                        <div id="subaccordion" class="sj-statusholder">
                                            <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div id="subheadingOne-<?php echo e($comment->id); ?>" class="sj-statusheaderholder sj-statuspadding" data-toggle="collapse"
                                                     data-target="#subcollapseOne-<?php echo e($comment->id); ?>" aria-expanded="true" aria-controls="subcollapseOne-<?php echo e($comment->id); ?>" role="button">
                                                    <div class="sj-reviewer-acronym">
                                                        <span><?php echo e(App\Helper::getAcronym($comment->name)); ?></span>
                                                    </div>
                                                    <div class="sj-statusheader">
                                                        <div class="sj-statusasidetitle">
                                                            <span><?php echo e(Carbon\Carbon::parse($comment->created_at)->format('F j, Y')); ?></span>
                                                            <h4><?php echo e($comment->name); ?></h4>
                                                            <p><?php echo e($comment->role_type); ?></p>
                                                        </div>
                                                        <div class="sj-statusasidetitle sj-statusasidetitlevtwo">
                                                            <span><?php echo e(trans('prs.status')); ?></span>
                                                            <h4><?php if($comment->status != "articles_under_review" ): ?> <?php echo e(App\Helper::displayReviewerCommentStatus($comment->status)); ?> <?php endif; ?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="subcollapseOne-<?php echo e($comment->id); ?>" class="sj-statusdescription collapse sj-active" aria-labelledby="subheadingOne-<?php echo e($comment->id); ?>" data-parent="#subaccordion">
                                                    <div class="sj-description">
                                                        <?php echo e($comment->comment); ?>

                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?>
                    </ul>
                    <?php if( method_exists($articles,'links') ): ?>
                        <?php echo e($articles->links('pagination.custom')); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>