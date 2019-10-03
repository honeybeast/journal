@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('emailSettings'); @endphp
@section('breadcrumbs')
    @if (count($breadcrumbs))
        <ol class="sj-breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
                @else
                    <li class="active">{{{ $breadcrumb->title }}}</li>
                @endif
            @endforeach
        </ol>
    @endif
@endsection
@section('content')
    <div id="sj-twocolumns" class="sj-twocolumns">
        @include('includes.side-menu')
        <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="email_settings_holder">
            @if (Session::has('success'))
                <div class="toast-holder">
                    <flash_messages :message="'{{{ Session::get('success') }}}'" :message_class="'success'" v-cloak></flash_messages>
                </div>
            @elseif (Session::has('error'))
                <div class="toast-holder">
                    <flash_messages :message="'{{{ Session::get('error') }}}'" :message_class="'danger'" v-cloak></flash_messages>
                </div>
            @elseif ($errors->any())
                <div class="toast-holder">
                    @foreach ($errors->all() as $error)
                        <flash_messages :message="'{{{$error}}}'" :message_class="'danger'" v-cloak></flash_messages>
                    @endforeach
                </div>
           @endif
            <div class="sj-addarticleholdcontent sj-content">
                <div class="sj-dashboardboxtitle">
                    <h2>{{{trans('prs.email_settings')}}}</h2>
                </div>
                <div class="sj-acsettingthold">
                    {!! Form::open(['url' => '/dashboard/superadmin/site-management/email/store-email-settings', 'class' =>
                    'sj-formtheme sj-formsocical']) !!}
                        <fieldset>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 form-group">
                                    @if (!empty($existing_email_settings))
                                        {!! Form::text('email', e($existing_email_settings[0]['email']), ['class' => 'form-control',
                                        'placeholder' => trans('prs.ph_email')]) !!}
                                    @else
                                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' =>
                                        trans('prs.ph_email')]) !!}
                                    @endif
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
@endsection
