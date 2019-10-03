@extends('master') 
@php $breadcrumbs = Breadcrumbs::generate('createUser'); @endphp 
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
<div class="container">
    <div class="row">
        <div id="sj-twocolumns" class="sj-twocolumns">
            @include('includes.side-menu')
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="user_management">
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
                <div id="sj-content" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                    <div class="sj-dashboardbox sj-newcourse">
                        <div class="sj-dashboardboxtitle">
                            <div class="sj-title">
                                <h2>{{{trans('prs.add_user')}}}</h2>
                                <span>{{{trans('prs.provide_users_dtl')}}}</span>
                            </div>
                        </div>
                        <div class="sj-addnewuserform sj-manageallsession">
                            {!! Form::open(['url' => url('superadmin/users/store-users'),'id'=>'user_form','class'=>'sj-formtheme prs-add-user',
                            'enctype' => 'multipart/form-data']) !!}
                            <fieldset>
                                <div class="form-group">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('prs.ph_name')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::text('sur_name', null, ['class' => 'form-control', 'placeholder' => trans('prs.ph_surname')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('prs.ph_email')]) !!}
                                </div>
                                @foreach ($roles as $role) 
                                    @php $excludedRole = $role->role_type; @endphp 
                                    @if (!($excludedRole === "superadmin"))
                                        <div class="form-group half-width assign-role">
                                            <span class="sj-radio">
                                                {{ Form::radio('roles[]', e($role->id), null, array('id' => e($role->name), 'data-assignrole' => e($role->name))) }}
                                                {{ Form::label(e($role->name), ucfirst(e($role->name))) }}
                                            </span>
                                        </div>
                                    @endif 
                                @endforeach
                                <div class="form-group sj-formbtns">
                                    {!! Form::submit(trans('prs.btn_create_now'), ['class' => 'sj-btn sj-btnactive']) !!}
                                </div>
                            </fieldset>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
