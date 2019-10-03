<?php if($paginator->hasPages()): ?>
    <nav class="sj-pagination">
        <ul>
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="sj-prevpage"><span><i class="fa fa-angle-left"></i> <?php echo e(trans('prs.previous')); ?></span></li>
            <?php else: ?>
                <li class="sj-prevpage"><a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev"> <i class="fa fa-angle-left"></i> <?php echo e(trans('prs.previous')); ?></a></li>
            <?php endif; ?>
            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_string($element)): ?>
                    <li class="disabled"><span><?php echo e($element); ?></span></li>
                <?php endif; ?>
                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="sj-active"><span>0<?php echo e($page); ?></span></li>
                        <?php else: ?>
                            <li><a href="<?php echo e($url); ?>">0<?php echo e($page); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php if($paginator->hasMorePages()): ?>
                <li class="sj-nextpage"><a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next"><?php echo e(trans('prs.next')); ?> <i class="fa fa-angle-right"></i> </a></li>
            <?php else: ?>
                <li class="disabled sj-nextpage"><span><?php echo e(trans('prs.next')); ?> <i class="fa fa-angle-right"></i> </span></li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
