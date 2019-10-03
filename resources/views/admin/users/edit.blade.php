@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('editUser',$id); @endphp
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
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="account_setting">
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
                                <h2>{{{trans('prs.edit_user')}}}</h2>
                                <span>{{ trans('prs.provide') }}<strong>{{{$role->name}}}</strong> {{ trans('prs.detls') }}</span>
                            </div>
                        </div>
                        <div class="sj-addnewuserform sj-manageallsession sj-edituser">
                            @php $roleCounter = 0; @endphp
                            {{{ Form::model($users, array('url' => url('/superadmin/users/update-users/'.$users->id.''),
                            'method' => 'POST', 'enctype' => 'multipart/form-data',
                            'class' => 'sj-formtheme sj-formarticle sj-formcontactus sj-formcontactusvtwo sj-formsocical sj-categorydetails')) }}}
                                <fieldset class="home-slider-content">
                                    <div class="form-group">
                                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::text('sur_name', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                    </div>
                                    @if ($role->role_type === 'reviewer')
                                        <div class="form-group">
                                            <span class="sj-select">
                                                <select data-placeholder="{{{!empty($categories) ? trans('prs.choose_cat') : trans('prs.choose_cat_for_sel')}}}"
                                                     multiple class="chosen-select" name="category[]">
                                                    @foreach ($categories as $category)
                                                        <option value="{{{$category->id}}}" {{{ in_array($category->id, $categories_id) ? 'selected' : '' }}} >
                                                            {{{$category->title}}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </div>
                                    @endif
                                    <div class="sj-formtheme sj-formpassword">
                                        <div class="form-group sj-inputwithicon sj-password">
                                            <i class="lnr lnr-lock"></i>
                                            @php $old_error = $errors->has("old_password") ? 'is-invalid' : ""; @endphp
                                            {!! Form::password('old_password', ['class' => ['.$old_error.'],'placeholder' => trans('prs.ph_oldpass')]) !!}
                                        </div>
                                        <div class="form-group sj-inputwithicon sj-password">
                                            <i class="lnr lnr-lock"></i>
                                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('prs.ph_newpass')]) !!}
                                        </div>
                                        <div class="form-group sj-inputwithicon sj-password">
                                            <i class="lnr lnr-lock"></i>
                                            {!! Form::password('confirm_password', ['class' => 'form-control','placeholder' => trans('prs.ph_retype_pass')]) !!}
                                        </div>
                                        {!! Form::hidden('user_id', $id) !!}
                                    </div>
                                    <div class="form-group">
                                        <upload-files-field
                                            :field_title="'{{{trans('prs.user_img')}}}'"
                                            :uploaded_file="'{{{App\UploadMedia::getImageName($users->user_image)}}}'"
                                            :hidden_field_name="'hidden_user_image'"
                                            :doc_id="'user_img'"
                                            :file_name="'user_image'"
                                            :file_placeholder="'{{{trans("prs.ph_upload_file_label")}}}'"
                                            :file_size_label="'{{{trans("prs.ph_article_file_size")}}}'"
                                            :file_uploaded_label="'{{{trans("prs.ph_file_uploaded")}}}'"
                                            :file_not_uploaded_label="'{{{trans("prs.ph_file_not_uploaded")}}}'">
                                        </upload-files-field>
                                    </div>
                                    <div class="form-group sj-formbtns">
                                        {!! Form::submit(trans('prs.btn_submit'), ['class' => 'sj-btn sj-btnactive']) !!}
                                    </div>
                                </fieldset>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
