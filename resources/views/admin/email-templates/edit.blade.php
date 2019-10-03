@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('editTemplate',$id); @endphp
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
    @php $counter = 0;  @endphp
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="email_templates">
                    @if (Session::has('error'))
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
                    <sticky_messages :message="this.message"></sticky_messages>
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2>{{{trans('prs.email_templates')}}}</h2>
                        </div>
                        <div class="sj-manageallsession sj-manageallsessionvtwo">
                            {!! Form::open(['url' => '/dashboard/superadmin/emails/email/'.$email_template->id.'/update-template',
                            'id'=>'email_templates', 'class' => 'sj-formtheme sj-managesessionform']) !!}
                                <fieldset>
                                    <div class="form-group">
                                        {!! Form::text('subject', $email_template->subject, ['class' => 'form-control', 'placeholder' => trans('prs.ph_email_subject')]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::text('title', $email_template->title, ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('prs.ph_email_title')]) !!}
                                    </div>
                                    <div class="form-group">
                                        <span class="sj-select">
                                            <select id="email_types" name="template_types" disabled>
                                                <option selected value="">{{ trans('prs.ph_select_email_type') }}</option>
                                                    @foreach($email_types as $types)
                                                        <option value="{{{$types['value']}}}"
                                                            {{{($types['value'] == $email_template->email_type) ? "selected" : ''}}}>{{{$types['title']}}}
                                                        </option>
                                                    @endforeach
                                            </select>
                                        </span>
                                    </div>
                                    @if(!($email_template->role_id == null))
                                        <div class="form-group">
                                            <span class="sj-select">
                                                <select id="user_types" name="user_types" disabled>
                                                    <option selected="selected" value="">{{ trans('prs.ph_select_user_type') }}/option>
                                                    @foreach($user_types as $user)
                                                        <option value="{{{$user->role_id}}}" {{{($user->role_id == $email_template->role_id) ? "selected" : ''}}}>
                                                            {{{$user->role_name}}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </div>
                                    @endif
                                    <div class="jf-settingvari">
                                        <div class="jf-title">
                                            <h3>{{ trans('prs.email_sett_var') }}</h3>
                                        </div>
                                        <ul class="jf-settingdetails">
                                            @foreach($variables as $variable)
                                                <li>
                                                    <span>{{{$variable['key']}}}</span> <em>- {{{$variable['value']}}}</em>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::textarea('body', $email_template->body, ['class' => 'form-control page-textarea',
                                        'required' => 'required', 'placeholder' => trans('prs.ph_email_message')]) !!}
                                    </div>
                                </fieldset>
                                <div class="sj-popupbtn">
                                    {!! Form::submit(trans('prs.btn_submit'), ['class' => 'sj-btn sj-btnactive']) !!}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                @include('includes.side-menu')
            </div>
        </div>
    </div>
@endsection
