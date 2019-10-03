<?php $articles = App\Article::getPublishedDownloadedArticle(); ?>
<?php if(!empty($articles)): ?>
    <div class="sj-widget sj-widgetrelatedarticles">
        <div class="sj-widgetheading">
            <h3 style="text-align: center; line-height: 20px;">Most downloaded Manuscripts</h3>
        </div>
        <div class="sj-widgetcontent">
            <ul>
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                <?php $author = App\User::getUserDataByID($article->corresponding_author_id); ?>
                <li>
                    <span class="sj-username"><?php echo e($author->name); ?></span>
                    <div class="sj-description"><a href="<?php echo e(url('article/'.$article->slug.'')); ?>"><?php echo e($article->title); ?></a></div>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
