<div class="sj-addarticleholdcontent">
    <div class="sj-dashboardboxtitle">
        <h3>{{trans('prs.contact_info')}}</h3>
    </div>
    <div class="sj-acsettingthold">
        {!! Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/contact-info-settings', 'class' =>
        'sj-formtheme sj-formarticle sj-formsocical sj-footercontact', 'enctype' => 'multipart/form-data', 'multiple'
        => true]) !!}
            <fieldset class="home-slider-content">
                @if (!empty($contactinfo))
                    @foreach ($contactinfo as $key => $value)
                        <div class="wrap-home-slider">
                            <div class="form-group sj-authorhold">
                                {!! Form::text('contact_info[0][address]', e($value['address']), ['class' => 'form-control
                                author_title','placeholder'=>trans('prs.ph_address')]) !!}
                            </div>
                            <div class="form-group sj-authorhold">
                                {!! Form::text('contact_info[0][phone_no]', e($value['phone_no']), ['class' => 'form-control
                                author_title','placeholder'=>trans('prs.ph_phone_no')]) !!}
                            </div>
                            <div class="form-group sj-authorhold">
                                {!! Form::text('contact_info[0][fax_no]', e($value['fax_no']), ['class' => 'form-control
                                author_title','placeholder'=>trans('prs.ph_fax')]) !!}
                            </div>
                            <div class="form-group sj-authorhold">
                                {!! Form::email('contact_info[0][email]', e($value['email']), ['class' => 'form-control
                                author_title','placeholder'=>trans('prs.ph_email')]) !!}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="wrap-home-slider">
                        <div class="form-group sj-authorhold">
                            {!! Form::text('contact_info[0][address]', null, ['class' => 'form-control
                            author_title','placeholder'=>trans('prs.ph_address')]) !!}
                        </div>
                        <div class="form-group sj-authorhold">
                            {!! Form::text('contact_info[0][phone_no]', null, ['class' => 'form-control
                            author_title','placeholder'=>trans('prs.ph_phone_no')]) !!}
                        </div>
                        <div class="form-group sj-authorhold">
                            {!! Form::text('contact_info[0][fax_no]', null, ['class' => 'form-control
                            author_title','placeholder'=>trans('prs.ph_fax')]) !!}
                        </div>
                        <div class="form-group sj-authorhold">
                            {!! Form::email('contact_info[0][email]', null, ['class' => 'form-control
                            author_title', 'placeholder'=>trans('prs.ph_email')]) !!}
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
