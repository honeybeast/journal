@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('editPage',$user_role,$id); @endphp
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
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="manage_page">
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
                    <div id="sj-content" class="sj-content sj-addarticleholdcontent">
                        <div class="sj-dashboardboxtitle">
                            <h2>{{{trans('prs.edit_page')}}}</h2>
                        </div>
                        <div class="sj-addarticlehold">
                            {!! Form::open(['url' => '/'.$user_role.'/dashboard/pages/page/'.$page->id.'/update-page/', 'class' => 'sj-formtheme sj-formarticle']) !!}
                                <fieldset>
                                    <div class="form-group">
                                        {!! Form::text('title', $page->title, ['class' => 'form-control', 'placeholder' => trans('prs.ph_pge_title')]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::text('sub_title', $page->sub_title, ['class' => 'form-control', 'placeholder' => trans('prs.ph_pge_subtitle')]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::textarea('content', $page->body, ['class' => 'form-control page-textarea','placeholder' => trans('prs.ph_pge_desc')]) !!}
                                    </div>
                                    @if (empty($has_child))
                                        @if ($parent_page->count() > 1)
                                            <div class="form-group">
                                                <span class="sj-select">
                                                    {!! Form::select('parent_id', $parent_page, $parent_selected_id , array('class' => 'form-control jf-select2')) !!}
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="form-group">
                                        {!! Form::textarea('seo_desc', $seo_desc, array('class' => 'form-group seo-meta', 'placeholder' => trans('prs.ph_desc'))) !!}
                                    </div>
                                    <div class="sj-dashboardboxtitle">
                                         <div class="float-right">
                                            <switch_button v-model="show_page">{{{ trans('prs.add_menu_to_navbar') }}}</switch_button>
                                            <input type="hidden" :value="show_page" name="show_page">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="sj-submitdetails">
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
