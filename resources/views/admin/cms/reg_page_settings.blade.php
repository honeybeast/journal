<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold sj-formarticlevtwo">
    <div class="sj-dashboardboxtitle" id="headingOne-register" data-toggle="collapse" data-target="#collapseOne-register"
     aria-expanded="true" aria-controls="collapseOne-register">
        <h2>{{trans('prs.reg_page_settings')}}</h2>
    </div>
    <div  id="collapseOne-register" aria-labelledby="headingOne-register" data-parent="#accordion" class="sj-uploadimgbars sj-active collapse">
        {!! Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/register-settings',
            'class' => 'sj-formtheme sj-formarticle sj-formsocical', 'enctype' => 'multipart/form-data', 'multiple' => true]) !!}
            <fieldset class="home-slider-content">
                @if (!empty($reg_data))
                    @foreach ($reg_data as $key => $value)
                        <div class="wrap-home-slider">
                            <div class="form-group sj-authorhold">
                                {!! Form::text('reg_data[0][title]', e($value['title']),
                                    ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_title')]) !!}
                            </div>
                            <div class="form-group sj-authorholdvtwo">
                                {!! Form::textarea('reg_data[0][desc]', e($value['desc']),
                                    ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_desc')]) !!}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="wrap-home-slider">
                        <div class="form-group sj-authorhold">
                            {!! Form::text('reg_data[0][title]', null, ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_title')]) !!}
                        </div>
                        <div class="form-group sj-authorholdvtwo">
                            {!! Form::textarea('reg_data[0][desc]', null, ['class' => 'form-control author_title','placeholder'=>trans('prs.ph_desc')]) !!}
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
