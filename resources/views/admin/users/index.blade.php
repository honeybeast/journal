@extends('master')
@php
    $breadcrumbs = Breadcrumbs::generate('manageUsers');
    $selected_role = !empty($_GET['role']) ? $_GET['role'] : '';
@endphp
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
                    @if (Session::has('message'))
                        <div class="toast-holder">
                            <flash_messages :message="'{{{ Session::get('message') }}}'" :message_class="'success'" v-cloak></flash_messages>
                        </div>
                    @endif
                    <sticky_messages :message="this.success_message"></sticky_messages>
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2>{{{trans('prs.manage_users')}}}</h2>
                        </div>
                        <div class="sj-manageallsession">
                            <div class="sj-formtheme sj-managesessionform search-filters">
                                <fieldset>
                                    <div class="form-group">
                                        <a class="sj-btn sj-btnactive create-user" href="{{{url('superadmin/users/create-users')}}}">
                                            {{{trans('prs.add_user')}}}
                                        </a>
                                    </div>
                                </fieldset>
                                {!! Form::open(['url' => url('/superadmin/users/role-filters'), 'method' => 'get',
                                'class' => 'sj-formtheme sj-formsearchvtwo', 'id'=>'role_filter_form']) !!}
                                    <fieldset>
                                        <div class="form-group sj-inputwithicon float-right">
                                            <span class="sj-select">
                                                {!! Form::select('role', $role_list ,$selected_role, array('placeholder' => trans('prs.select_roles'), '@change'=>'submitRoleForm()')) !!}
                                            </span>
                                        </div>
                                    </fieldset>
                                {!! Form::close() !!}
                            </div>
                            @if ($users->count() > 0)
                                <ul class="sj-allcategorys sj-allcategorysvtwo">
                                    @foreach ($users as $user)
                                        @php
                                            $user_roles_type = App\User::getUserRoleType($user->id);
                                            $userRole = $user_roles_type->role_type;
                                        @endphp
                                        <li class="sj-categorysinfo delUser-{{{$user->id}}}">
                                            <figure class="sj-assignuserimg">
                                                <img src="{{{url(App\Helper::getUserImage($user->id, $user->user_image, 'small'))}}}" alt="{{ trans('prs.img') }}">
                                            </figure>
                                            <div class="sj-title">
                                                <h3>{{{ $user->name }}}<span class="sj-assignedinfo">{{{$userRole}}}</span></h3>
                                            </div>
                                            @php
                                                $delete_title = trans("prs.ph_delete_confirm_title");
                                                $delete_message = trans("prs.ph_user_delete_message");
                                                $deleted = trans("prs.ph_delete_title");
                                                $categories_id = App\Category::getCategoryByReviewerID($user->id);
                                                $counter = 0;
                                            @endphp
                                            <div class="sj-categorysrightarea">
                                                @if ($userRole === 'reviewer')
                                                    @if (!empty($categories))
                                                        <ul class="sj-userdropdown">
                                                            {!! Form::open(['url' => '/superadmin/users/assign-category', '@submit.prevent' => 'assignCategory',
                                                            'id'=>$user->id.'-reviewer_assign_category']) !!}
                                                                <li>
                                                                    <a href="javascript:void(0);" class="sj-userdropdownbtn">
                                                                        <span><i class="lnr lnr-user"></i></span>
                                                                        <i class="fa fa-angle-down"></i>
                                                                    </a>
                                                                    <ul class="sj-userdropdownmanu">
                                                                        @foreach ($categories as $category)
                                                                            <li class="sj-checked">
                                                                                <span class="sj-checkbox">
                                                                                    <input type="checkbox" id="checkbox-{{{$user->id}}}{{{$counter}}}" class="category_value" name=category[] value="{{{$category->id}}}" data-categoryname="{{{$category->title}}}"
                                                                                        {{{ in_array($category->id, $categories_id ) ? 'checked="checked"' : '' }}}>
                                                                                    <label for="checkbox-{{{$user->id}}}{{{$counter}}}">
                                                                                        <span>{{{$category->title}}}</span>
                                                                                    </label>
                                                                                </span>
                                                                            </li>
                                                                            @php $counter++ @endphp
                                                                        @endforeach
                                                                        <input type="hidden" name="reviewer_id" value="{{{$user->id}}}">
                                                                    </ul>
                                                                </li>
                                                                <li class="sj-checkbtnbox">
                                                                    {{ Form::button('<i class="ti-check"></i>', ['class' => 'sj-checkbtn', 'type' => 'submit']) }}
                                                                </li>
                                                            {!! Form::close() !!}
                                                        </ul>
                                                    @endif
                                                @endif
                                                <div class="sj-addremove">
                                                    <a href="{{{url('/superadmin/users/edit-user')}}}/{{{$user->id}}}" class="sj-pencilbtn">
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                    @if ($userRole != 'superadmin')
                                                        <a href="#" v-on:click.prevent="deleteUser($event,'{{{$delete_title}}}','{{{$delete_message}}}','{{{$deleted}}}')" class="sj-trashbtn" id="{{{$user->id}}}">
                                                            <i class="ti-trash"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="custom-error"></div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                @include('errors.no-record')
                            @endif
                            @if ( method_exists($users,'links') )
                                {{{ $users->links('pagination.custom') }}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
