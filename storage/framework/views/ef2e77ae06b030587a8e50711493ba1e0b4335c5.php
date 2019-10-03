<?php $pages = !empty($page_data) ? $page_data : array();?>
<sticky_messages :message="this.message"></sticky_messages>
<div class="sj-addarticleholdcontent">
    <div class="sj-dashboardboxtitle">
        <h3><?php echo e(trans('prs.resources')); ?></h3>
    </div>
    <div class="sj-acsettingthold">
        <?php echo Form::open(['url' => url('/dashboard/'.$user_role.'/site_management/store/store-resource-pages'), 'id' => 'resource_page_widget',
        'class'=>'sj-formtheme sj-formarticle sj-formsocical sj-categorydetails', '@submit.prevent' => 'resource_page_widget']); ?>

            <fieldset class="home-slider-content">
                <div class="form-group">
                    <span class="sj-select">
                        <select data-placeholder="<?php echo e(!empty($page) ? trans('prs.choose_resource_pages') : trans('prs.create_page_selction')); ?>"
                            multiple class="chosen-select" name="page[]">
                            <optgroup>
                                <?php $__currentLoopData = $page; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(in_array($key, $pages) ? 'selected' : ''); ?> ><?php echo e($p); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </optgroup>
                        </select>
                    </span>
                </div>
            </fieldset>
            <div class="sj-btnarea sj-updatebtns">
                <input type="submit" class="sj-btn sj-btnactive" value="<?php echo e(trans('prs.btn_save')); ?>">
            </div>
        <?php echo Form::close(); ?>

    </div>
</div>
