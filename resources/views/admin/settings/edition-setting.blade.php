@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('editionSetting'); @endphp
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
    <div id="general_setting">
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
        <div class="provider-site-wrap" v-show="loading" v-cloak>
            <div class="provider-loader">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div id="sj-twocolumns" class="sj-twocolumns">
                    @include('includes.side-menu')
                    <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right">
                        <sticky_messages :message="this.message"></sticky_messages>
                        <div id="sj-content editiontemplate" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo sj-editiontemplate">
                            <div class="sj-dashboardboxtitle sj-titlewithform">
                                <h2>{{{trans('prs.manage_edition')}}}</h2>
                                {!! Form::open(['url' => '/dashboard/edition/settings/search-edition', 'method' => 'get', 'class' => 'sj-formtheme sj-formsearchvtwo']) !!}
                                    <div class="sj-sortupdown">
                                        <a href="javascript:void(0);"><i class="fa fa-sort-amount-up"></i></a>
                                    </div>
                                    <fieldset>
                                        <input type="search" name="keyword" value="{{{ !empty($_GET['keyword']) ? $_GET['keyword'] : '' }}}" class="form-control" id="search_edition_input" placeholder="{{{trans('prs.ph_search_here')}}}">
                                        <button type="submit" class="sj-btnsearch"><i class="lnr lnr-magnifier"></i></button>
                                    </fieldset>
                                {!! Form::close() !!}
                            </div>
                            <div class="sj-manageallsession sj-editionsettings">
                                <ul class="sj-allcategorys editions">
                                    <li class="sj-addcategorys">
                                        {!! Form::open(['url' => '/dashboard/general/settings/create-edition',
                                        'class'=>'sj-formtheme sj-formmanagevthree sj-formmanage' .$payment_class]) !!}
                                            <fieldset>
                                                <div class="form-group">
                                                    <input type="text" name="title" value="" class="form-control {{{$errors->has(" title ") ? "is-invalid " : " "}}}" placeholder="{{{trans('prs.ph_add_edit_title')}}}">
                                                </div>
                                                <div class="form-group">
                                                    <date-picker
                                                        name="edition_date"
                                                        v-model="date"
                                                        :config="config"
                                                        :placeholder="'{{trans("prs.ph_edition_date")}}'"
                                                        class="form-control {{ $errors->has('edition_date') ? ' is-invalid' : '' }}">
                                                    </date-picker>
                                                </div>
                                                @if ($payment_mode != "free")
                                                    <div class="form-group sj-tooltip">
                                                        <i class="fa fa-question-circle" rel="tooltip" title="{{ trans('prs.edition_def_price') }}"></i>
                                                        {!! Form::number('price', null, ['class' => 'form-control', 'min' => '1', 'placeholder' => trans('prs.ph_edition_price') ]) !!}
                                                    </div>
                                                @endif
                                                <div class="sj-categorysbtn">
                                                    {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-checkbtn']) !!}
                                                </div>
                                            </fieldset>
                                        {!! Form::close() !!}
                                    </li>
                                    @if ($editions->count() != 0)
                                        @foreach ($editions as $edition)
                                            @php $articles = App\Edition::getEditionArticle($edition->id); @endphp
                                            <li class="sj-categorysinfo delEdition-{{{$edition->id}}}" v-bind:id="editionID">
                                                <div class="sj-title">
                                                    <h3>
                                                        {{{ $edition->title }}}
                                                        <span> ({{{ Carbon\Carbon::parse($edition->edition_date)->format('F, j, Y') }}}) </span>
                                                        <br>
                                                    </h3>
                                                </div>
                                                <div class="sj-categorysrightarea">
                                                    @php
                                                        $delete_title = trans("prs.ph_delete_confirm_title");
                                                        $delete_message = trans("prs.ph_edition_delete_message");
                                                        $deleted = trans("prs.ph_delete_title");
                                                        $user_id = Auth::User()->id;
                                                        $role_type = App\User::getUserRoleType($user_id);
                                                        $role = $role_type->role_type;
                                                    @endphp
                                                    @if (!empty($articles))
                                                        <a class="sj-btn sj-btnactive" href="{{{url('/dashboard/general/settings/edit-edition/'.$edition->id)}}}">
                                                            View Assigned Manuscripts
                                                        </a>
                                                    @elseif ($role == 'editor' || $role == 'superadmin' )
                                                        <a href="{{{url('/dashboard/general/settings/edit-edition/'.$edition->id)}}}" class="sj-btn sj-btnactive">
                                                            Assign Manuscripts
                                                        </a>
                                                    @endif
                                                    <a title="Publish Article" href="#" v-on:click.prevent="publishEdition($event)" class="" id="{{{ $edition->id }}}">
                                                        <i class="fa fa-book"></i>
                                                    </a>
                                                    <a href="{{{url('/dashboard/general/settings/edit-edition/'.$edition->id)}}}" class="sj-pencilbtn" id="{{{ $edition->id }}}">
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                    <a href="#" v-on:click.prevent="deleteEdition($event,'{{{$delete_title}}}','{{{$delete_message}}}','{{{$deleted}}}')" class="sj-trashbtn" id="{{{ $edition->id }}}">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        @include('errors.no-record')
                                    @endif
                                </ul>
                                @if( method_exists($editions,'links') ) {{{ $editions->links('pagination.custom') }}} @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
