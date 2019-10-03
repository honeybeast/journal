<?php 
    $editionID = Request::segment(4); 
    $articleID = Request::segment(5); 
    $published_articles = App\Edition::getPublishedRelatedArticles($editionID,$articleID);
?> 
<?php if(!empty($published_articles)): ?>
    <div class="sj-widget sj-widgetrelatedarticles">
        <div class="sj-widgetheading">
            <h3><?php echo e(trans('prs.related_articles')); ?></h3>
        </div>
        <div class="sj-widgetcontent">
            <ul>
                <?php $__currentLoopData = $published_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <?php $author = App\User::getUserDataByID($article->corresponding_author_id); ?>
                    <li>
                        <span class="sj-username"><?php echo e($author->name); ?></span>
                        <a href="<?php echo e(url('/published/article/detail/'.$article->edition_id.'/'.$article->id.'')); ?>">
                            <div class="sj-description"><?php echo e($article->title); ?></div>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>