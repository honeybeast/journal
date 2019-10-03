<div class="sj-addarticleholdcontent">
    <div class="sj-dashboardboxtitle">
        <h3>{{trans('prs.about_us')}}</h3>
    </div>
    <div class="sj-acsettingthold">
        {!! Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/about-us-settings',
            'class' => 'sj-formtheme sj-formarticle sj-formsocical', 'enctype' => 'multipart/form-data', 'multiple' => true]) !!}
            <fieldset class="home-slider-content">
                <div class="wrap-home-slider">
                    <div class="form-group">
                        {!! Form::textarea('about_us', !empty($about_us_note) ? $about_us_note : '',
                            ['class' => 'form-control author_title','placeholder'=>trans('prs.about_us')])
                        !!}
                    </div>
                </div>
            </fieldset>
            <div class="sj-btnarea sj-updatebtns">
                {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']) !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>
