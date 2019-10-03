<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
    <div class="sj-dashboardboxtitle" id="headingOne-1" data-toggle="collapse" data-target="#collapseOne-1"
    aria-expanded="true" aria-controls="collapseOne-1">
        <h2><?php echo e(trans('prs.add_social_icons')); ?></h2>
    </div>
    <div id="collapseOne-1" aria-labelledby="headingOne-1" data-parent="#accordion" class="sj-acsettingthold sj-active collapse">
        <div class="card-body">
            <?php echo Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store-settings', 'class' => 'sj-formtheme sj-formarticle
            sj-formsocical', 'id'=>'social_management']); ?>

                <fieldset class="social-icons-content">
                    <?php if(!empty($social_unSerialize_array)): ?>
                        <?php $counter = 0 ?>
                        <?php $__currentLoopData = $social_unSerialize_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unSerializeKey =>$unSerializeValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="wrap-social-icons">
                                <div class="form-group sj-authorhold">
                                    <span class="sj-select">
                                        <select name="social[<?php echo e($counter); ?>][title]" class="form-control">
                                            <option value="null" selected><?php echo e(trans('prs.select_social_icons')); ?></option>
                                            <?php $__currentLoopData = $social_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $selected = 'selected';
                                                    $selected_value = $unSerializeValue['title'] === $key ? $selected : '';
                                                ?>
                                                <option value="<?php echo e($key); ?>" <?php echo e($selected_value); ?>><?php echo e($value['title']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </span>
                                </div>
                                <div class="form-group sj-authorholdvtwo">
                                    <?php echo Form::text('social['.$counter.'][url]', $unSerializeValue['url'], ['class' => 'form-control author_title']); ?>

                                    <div class="sj-adddelbtns">
                                        <?php if($unSerializeKey == 0 ): ?>
                                            <span class="sj-addbtn" @click="addSocial"><i class="fa fa-plus"></i></span>
                                        <?php else: ?>
                                            <span class="sj-addbtn sj-delbtn delete-social" data-check="<?php echo e($counter); ?>">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php $counter++; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="wrap-social-icons">
                            <div class="form-group sj-authorhold">
                                <span class="sj-select">
                                    <select name="social[0][title]" class="form-control">
                                        <option value="null" selected><?php echo e(trans('prs.select_social_icons')); ?></option>
                                        <?php $__currentLoopData = $social_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($value['title']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </span>
                            </div>
                            <div class="form-group sj-authorholdvtwo">
                                <?php echo Form::text('social[0][url]', null, ['class' => 'form-control author_title', 'placeholder' => trans('prs.ph_social_url'),'v-model'
                                => 'first_social_url']); ?>

                                <div class="sj-adddelbtns">
                                    <span class="sj-addbtn" @click="addSocial"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div v-for="(social, index) in socials" v-cloak>
                        <div class="wrap-social-icons">
                            <div class="form-group sj-authorhold">
                                <select class="form-control" v-bind:name="'social['+[social.count]+'][title]'">
                                    <option value="null" selected><?php echo e(trans('prs.select_social_icons')); ?></option>
                                    <?php $__currentLoopData = $social_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($value['title']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group sj-authorholdvtwo">
                                <input placeholder="<?php echo e(trans('prs.ph_social_url')); ?>" v-bind:name="'social['+[social.count]+'][url]'" type="text" class="form-control"
                                    v-model="social.social_url">
                                <div class="sj-adddelbtns">
                                    <span class="sj-addbtn sj-delbtn" @click="removeSocial(index)"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="sj-btnarea sj-updatebtns">
                    <?php echo Form::submit(trans('prs.btn_submit'), ['class' => 'sj-btn sj-btnactive']); ?>

                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
