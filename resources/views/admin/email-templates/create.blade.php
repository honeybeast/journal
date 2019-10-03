@extends('master')
@section('content')
    @if (Session::has('message'))
        <div class="toast-holder">
            <flash_messages :message="'{{{ Session::get('message') }}}'" :message_class="'success'" v-cloak></flash_messages>
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
    @php $counter = 0; @endphp
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="email_templates">
                    <sticky_messages :message="this.message"></sticky_messages>
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2>{{{trans('prs.manage_templates')}}}</h2>
                        </div>
                        <div class="sj-manageallsession sj-manageallsessionvtwo">
                            {!! Form::open(['url' => '/dashboard/superadmin/emails/store-templates','id'=>'email_templates',
                            'class'=>'sj-managesessionform']) !!}
                                <fieldset>
                                    <div class="form-group">
                                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('prs.ph_template_title')]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => trans('prs.ph_email_subject')]) !!}
                                    </div>
                                    <email_fields></email_fields>
                                    <div class="form-group">
                                        {!! Form::textarea('body', null, ['class' => 'form-control page-textarea', 'placeholder' => trans('prs.ph_email_message')]) !!}
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
