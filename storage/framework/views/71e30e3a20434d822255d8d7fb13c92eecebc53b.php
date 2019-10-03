<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
    <div class="sj-dashboardboxtitle" id="headingOne-6" data-toggle="collapse" data-target="#collapseOne-6"
        aria-expanded="true" aria-controls="collapseOne-6">
        <h2><?php echo e(trans('prs.notice_board_settings')); ?></h2>
    </div>
    <div id="collapseOne-6" aria-labelledby="headingOne-6" data-parent="#accordion" class="sj-acsettingthold sj-active collapse">
        <?php echo Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/notice-board-settings', 'class' =>
        'sj-formtheme sj-formarticle sj-formsocical', 'enctype' => 'multipart/form-data', 'multiple' => true]); ?>

            <fieldset class="home-slider-content">
                <div class="wrap-home-slider">
                    <div class="form-group">
                        <?php echo Form::textarea('notice_board[notice]', !empty($notice_board) ? $notice_board['notice'] : null,
                        ['class' => 'form-control page-textarea author_title','placeholder' =>
                        trans('prs.ph_add_notices')]); ?>

                    </div>
                </div>
            </fieldset>
            <div class="sj-btnarea sj-updatebtns">
                <?php echo Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']); ?>

            </div>
        <?php echo Form::close(); ?>

    </div>
</div>
