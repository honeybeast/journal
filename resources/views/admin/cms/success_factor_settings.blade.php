<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold sj-formarticlevtwo">
    <div class="sj-dashboardboxtitle" id="headingOne-9" data-toggle="collapse" data-target="#collapseOne-9" aria-expanded="true"
        aria-controls="collapseOne-9">
        <h2>{{{trans('prs.impact_factor')}}}</h2>
    </div>
    <div id="collapseOne-9" aria-labelledby="headingOne-9" data-parent="#accordion" class="sj-uploadimgbars sj-active collapse">
        {!! Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/success-factor-settings', 'class' => 'sj-formtheme
        sj-formarticle sj-formsocical', 'enctype' => 'multipart/form-data', 'multiple' => true]) !!}
            <fieldset class="home-slider-content">
                @if (!empty($successfactor))
                    @foreach ($successfactor as $key => $value)
                        <div class="wrap-home-slider">
                            <div class="form-group sj-authorhold">
                                {!! Form::text('success_data[0][impact_factor]', e($value['impact_factor']),
                                    ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_impact_factor')]) !!}
                            </div>
                            <div class="form-group sj-authorhold">
                                {!! Form::text('success_data[0][time_impact_factor]', e($value['time_impact_factor']),
                                    ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_five_yrs_impact')]) !!}
                            </div>
                            <div class="form-group sj-authorhold">
                                {!! Form::text('success_data[0][commenter_name]', e($value['commenter_name']),
                                    ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_commenter')]) !!}
                            </div>
                            <div class="form-group sj-authorholdvtwo">
                                {!! Form::textarea('success_data[0][comment]', e($value['comment']),
                                    ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_comment')]) !!}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="wrap-home-slider">
                        <div class="form-group sj-authorhold">
                            {!! Form::text('success_data[0][impact_factor]', null, ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_impact_factor')]) !!}
                        </div>
                        <div class="form-group sj-authorhold">
                            {!! Form::text('success_data[0][time_impact_factor]', null, ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_five_yrs_impact')]) !!}
                        </div>
                        <div class="form-group sj-authorhold">
                            {!! Form::text('success_data[0][commenter_name]', null, ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_commenter')]) !!}
                        </div>
                        <div class="form-group sj-authorholdvtwo">
                            {!! Form::textarea('success_data[0][comment]', null, ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_comment')])  !!}
                        </div>
                    </div>
                @endif
            </fieldset>
            <div class="sj-btnarea sj-updatebtns">
                {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']) !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>
