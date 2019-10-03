<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
    <div class="sj-dashboardboxtitle" id="headingOne-11" data-toggle="collapse" data-target="#collapseOne-11" aria-expanded="true"
        aria-controls="collapseOne-11">
        <h2>{{{trans('prs.language_settings')}}}</h2>
    </div>
    <div id="collapseOne-11" aria-labelledby="headingOne-11" data-parent="#accordion" class="sj-uploadimgbars sj-active collapse">
        <div class="sj-acsettingthold sj-btnarea sj-updatebtns">
            <div class="sj-addarticleholdcontent">
                <div class="sj-dashboardboxtitle">
                    <h3>{{{trans('prs.select_language')}}}</h3>
                </div>
                {!! Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/language-settings',
                'class' => 'sj-formtheme sj-formarticle sj-formsocical']) !!}
                    <fieldset class="social-icons-content">
                        <div class="wrap-social-icons">
                            <div class="form-group sj-authorholdvtwo">
                                <span class="sj-select">
                                    {!! Form::select('language', $languages, $selected_language, array('class' => 'form-control', 'placeholder' => trans('prs.select_language'))) !!}
                                </span>
                            </div>
                        </div>
                    </fieldset>
                    <div class="sj-btnarea sj-updatebtns">
                        {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
