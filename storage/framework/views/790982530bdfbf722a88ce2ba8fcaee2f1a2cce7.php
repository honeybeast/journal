<?php $__env->startSection('title'); ?><?php echo 'All Published Editions'; ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('description', 'This is description tag'); ?>
<?php $__env->startSection('content'); ?>
    <div id="sj-twocolumns" class="sj-twocolumns">
        <?php
            $keyword = "";
            $requested_category = array();
            $requested_edition = array();
            $show_records = "";
            !empty($_GET['s']) ? $keyword = $_GET['s'] : '';
            !empty($_GET['show']) ? $show_records = $_GET['show'] : '';
            !empty($_GET['category']) ? $requested_category = $_GET['category'] : array();
            !empty($_GET['edition']) ? $requested_edition = $_GET['edition'] : array();
        ?>
        <div class="container" id="public_publish_articles">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-5 col-lg-9 col-xl-9 float-left">
                    <?php echo Form::open(['url' => url('published/editions/filters'), 'method' => 'get', 'class' => 'sj-formtheme sj-formsearch','id'=>'edition_filters']); ?>

                        <div class="col-12 col-sm-12 col-md-5 col-lg-4 col-xl-4 float-left">
                            <aside id="sj-sidebarvtwo" class="sj-sidebar">
                                <div class="sj-widget sj-widgetsearch">
                                    <div class="sj-widgetcontent">
                                        <fieldset>
                                            <input type="search" name="s" value="<?php echo e($keyword); ?>" class="form-control" placeholder="<?php echo e(trans('prs.ph_search_here')); ?>">
                                        </fieldset>
                                    </div>
                                </div>
                                <?php if(!empty($categories)): ?>
                                    <div class="sj-widget sj-widgetarticles">
                                        <div class="sj-widgetheading">
                                            <h3><?php echo e(trans('prs.article_type')); ?></h3>
                                        </div>
                                        <div class="sj-widgetcontent">
                                            <div class="sj-selectgroup">
                                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $checked = ''; ?>
                                                    <?php if(!empty($requested_category)): ?>
                                                        <?php if(in_array($category->id, $requested_category)): ?>
                                                            <?php $checked = 'checked'; ?>
                                                        <?php else: ?>
                                                            <?php $checked = ''; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <span class="sj-checkbox">
                                                        <input id="checkbox-<?php echo e($category->id); ?>" type="checkbox" name="category[]" value="<?php echo e($category->id); ?>" <?php echo e($checked); ?>>
                                                        <label for="checkbox-<?php echo e($category->id); ?>"><?php echo e($category->title); ?></label>
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($editions)): ?>
                                    <div class="sj-widget sj-widgetdate">
                                        <div class="sj-widgetheading">
                                            <h3><?php echo e(trans('prs.by_edition')); ?></h3>
                                        </div>
                                        <div class="sj-widgetcontent">
                                            <div class="sj-selectgroup">
                                                <?php $__currentLoopData = $editions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $checked = ''; ?>
                                                    <?php if(!empty($requested_edition)): ?>
                                                        <?php if(in_array($edition->id, $requested_edition)): ?>
                                                            <?php $checked = 'checked'; ?>
                                                        <?php else: ?>
                                                            <?php $checked = ''; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <span class="sj-checkbox">
                                                        <input id="checkbox-<?php echo e($edition->id); ?><?php echo e($edition->id); ?>" type="checkbox" name="edition[]" value="<?php echo e($edition->id); ?>" <?php echo e($checked); ?>>
                                                        <label for="checkbox-<?php echo e($edition->id); ?><?php echo e($edition->id); ?>"><?php echo e($edition->title); ?></label>
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="sj-filterbtns">
                                    <button type="submit" class="sj-btn"><?php echo e(trans('prs.apply_filter')); ?></button>
                                </div>
                            </aside>
                        </div>
                        <div class="col-12 col-sm-12 col-md-7 col-lg-8 col-xl-8 float-left">
                            <div id="sj-content" class="sj-content">
                                <?php if(Auth::user()): ?>
                                    <?php
                                        $user_id = Auth::user()->id;
                                        $user_role_type = App\User::getUserRoleType($user_id);
                                    ?>
                                    <?php if($user_role_type->role_type == 'author'): ?>
                                        <div class="sj-uploadarticle">
                                            <figure class="sj-uploadarticleimg">
                                                <img src="<?php echo e(url('images/upload-articlebg.jpg')); ?>" alt="<?php echo e(trans('prs.img_desc')); ?>">
                                                <figcaption>
                                                    <div class="sj-uploadcontent">
                                                        <span><?php echo e(trans('prs.upload_article')); ?></span>
                                                        <h3><?php echo e(trans('prs.online_presence')); ?></h3>
                                                        <a class="sj-btn" href="<?php echo e(route('checkAuthor')); ?>"><?php echo e(trans('prs.btn_submit')); ?></a>
                                                    </div>
                                                </figcaption>
                                            </figure>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="sj-uploadarticle">
                                        <figure class="sj-uploadarticleimg">
                                            <img src="<?php echo e(url('images/upload-articlebg.jpg')); ?>" alt="<?php echo e(trans('prs.img_desc')); ?>">
                                            <figcaption>
                                                <div class="sj-uploadcontent">
                                                    <span><?php echo e(trans('prs.upload_article')); ?></span>
                                                    <h3><?php echo e(trans('prs.online_presence')); ?></h3>
                                                    <a class="sj-btn" href="<?php echo e(route('checkAuthor')); ?>"><?php echo e(trans('prs.btn_submit')); ?></a>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </div>
                                <?php endif; ?>
                                <div class="sj-articles sj-formsortitems">
                                    <fieldset>
                                        <div class="form-group">
                                            <span class="sj-select">
                                            <select name="sort" @change="onChange()">
                                                <option value="date"><?php echo e(trans('prs.sort_by')); ?></option>
                                                <option value="title"><?php echo e(trans('prs.lbl_name')); ?></option>
                                                <option value="updated_at"><?php echo e(trans('prs.date')); ?></option>
                                            </select>
                                        </span>
                                        </div>
                                        <div class="form-group">
                                            <em><?php echo e(trans('prs.show')); ?> </em>
                                            <span class="sj-select">
                                            <select name="show" @change="onChange()">
                                                <option <?php if($show_records == 10): ?> selected <?php endif; ?> >10</option>
                                                <option <?php if($show_records == 20): ?> selected <?php endif; ?> >20</option>
                                                <option <?php if($show_records == 30): ?> selected <?php endif; ?> >30</option>
                                                <option <?php if($show_records == 40): ?> selected <?php endif; ?> >40</option>
                                                <option <?php if($show_records == 50): ?> selected <?php endif; ?> >50</option>
                                            </select>
                                        </span>
                                        </div>
                                    </fieldset>
                                    <?php if(!empty($published_articles)): ?>
                                        <?php $__currentLoopData = $published_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $edition_image = App\Helper::getEditionImage($article->edition_id,'medium'); ?>
                                            <article class="sj-post sj-editorchoice">
                                                <?php if(!empty($edition_image)): ?>
                                                    <figure class="sj-postimg">
                                                        <img src="<?php echo e(asset($edition_image)); ?>" alt="<?php echo e(trans('prs.article_img')); ?>">
                                                    </figure>
                                                <?php endif; ?>
                                                <div class="sj-postcontent">
                                                    <div class="sj-head">
                                                        <span class="sj-username"><a href="javascript:void(0);">
                                                            <?php echo e(App\User::getUserNameByID($article->corresponding_author_id)); ?>

                                                        </span>
                                                        <h3><a href="<?php echo e(url('article/'.$article->slug)); ?>"><?php echo e($article->title); ?></a></h3>
                                                    </div>
                                                    <div class="sj-description">
                                                        <?php echo str_limit($article->excerpt, 105); ?>
                                                    </div>
                                                    <a class="sj-btn" href="<?php echo e(url('article/'.$article->slug)); ?>">
                                                        <?php echo e(trans('prs.btn_view_full_articles')); ?>

                                                    </a>
                                                </div>
                                            </article>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php if(Session::has('message')): ?>
                                            <div class="toast-holder">
                                                <div id="toast-container">
                                                    <div class="alert toast-danger alart-message alert-dismissible fade show fixed_message">
                                                        <div class="toast-message">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <?php echo e(Session::get('message')); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php echo Form::close(); ?>

                    <?php if( method_exists($published_articles,'links') ): ?>
                        <?php echo e($published_articles->links('pagination.custom')); ?>

                    <?php endif; ?>
                </div>
                <div class="col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 float-left">
                    <?php echo $__env->make('includes.widgetsidebar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>