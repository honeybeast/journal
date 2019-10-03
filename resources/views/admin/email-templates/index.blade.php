@extends('master')
@php
    $breadcrumbs = Breadcrumbs::generate('emailTemplates');
    $selected_role = !empty($_GET['role']) ? $_GET['role'] : '';
    $selected_type = !empty($_GET['type']) ? $_GET['type'] : '';
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
    @php $counter = 0; @endphp
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                @include('includes.side-menu')
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="email_templates">
                    @if (Session::has('message'))
                        <div class="toast-holder">
                            <flash_messages :message="'{{{ Session::get('message') }}}'" :message_class="'success'" v-cloak></flash_messages>
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
                        <div class="sj-manageallsession">
                            <div class="sj-formtheme sj-managesessionform search-filters">
                                @if ($create_template == false)
                                    <fieldset>
                                        <div class="form-group">
                                            <a href="{{{url('dashboard/superadmin/emails/create-templates')}}}" class="sj-btn sj-btnactive">
                                                {{{trans('prs.new_email_template')}}}
                                            </a>
                                        </div>
                                    </fieldset>
                                @endif
                                <div class="sj-filter-form">
                                    {!! Form::open(['url' => url('/dashboard/superadmin/emails/filter-templates'),'method' => 'get',
                                    'class' => 'sj-formtheme sj-formsearchvtwo','id'=>'template_filter_form']) !!}
                                        <fieldset class="float-right">
                                            <div class="form-group">
                                                <span class="sj-select">
                                                    <select name="type" @change="submitTemplateFilter">
                                                        <option value="">{{ trans('prs.search_by_email_type') }}</option>
                                                        @foreach ($template_types as $type)
                                                            <option value="{{{$type['value']}}}" {{{$selected_type == $type['value'] ? 'selected' : '' }}}>
                                                                {{{$type['title']}}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </span>
                                            </div>
                                            <div class="form-group">
                                                <span class="sj-select">
                                                    {!! Form::select('role', $roles ,$selected_role, array('placeholder' => trans('prs.search_by_role'), '@change'=>'submitTemplateFilter')) !!}
                                                </span>
                                            </div>
                                        </fieldset>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            @if ($email_templates->count() > 0)
                            <ul class="sj-allcategorys">
                                @foreach ($email_templates as $template)
                                    <li class="sj-categorysinfo delTemplate-{{{$template->id}}}">
                                        <div class="sj-title">
                                            <h3>{{{ $template->title }}}</h3>
                                        </div>
                                        @php
                                            $delete_title = trans("prs.ph_delete_confirm_title");
                                            $delete_message = trans("prs.ph_template_delete_message");
                                            $deleted = trans("prs.ph_delete_title");
                                        @endphp
                                        <div class="sj-categorysrightarea">
                                            <a href="{{{url('/dashboard/superadmin/emails/edit-template/')}}}/{{{$template->id}}}" class="sj-pencilbtn">
                                                <i class="ti-pencil"></i>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            @else
                                @include('errors.no-record')
                            @endif
                            @if ( method_exists($email_templates,'links') )
                                {{{ $email_templates->links('pagination.custom') }}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
