@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('manageSite',$user_role); @endphp
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
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="site_management">
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
                    <div id="sj-content" class="sj-content">
                        @include('admin.cms.social_settings')
                        @include('admin.cms.site_title_settings')
                        @include('admin.cms.site_logo_settings')
                        @include('admin.cms.home_slider_settings')
                        <div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
                            @include('admin.cms.welcome_page_settings')
                        </div>
                        @include('admin.cms.success_factor_settings')
                        @include('admin.cms.notice_board_settings')
                        @include('admin.cms.ad_image_settings')
                        <div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
                            <div class="sj-dashboardboxtitle" id="headingOne-4" data-toggle="collapse" data-target="#collapseOne-4"
                                aria-expanded="true" aria-controls="collapseOne-4">
                                <h2>{{{trans('prs.footer_settings')}}}</h2>
                            </div>
                            <div id="collapseOne-4" aria-labelledby="headingOne-4" data-parent="#accordion" class="sj-active collapse">
                                <div class="sj-acsettingthold sj-btnarea sj-updatebtns">
                                    @include('admin.cms.contact_info_settings')
                                </div>
                                <div class="sj-acsettingthold sj-btnarea sj-updatebtns">
                                    @include('admin.cms.about_us_settings')
                                </div>
                                <div class="sj-acsettingthold sj-btnarea sj-updatebtns">
                                    @include('admin.cms.resources_settings')
                                </div>
                            </div>
                        </div>
                        @include('admin.cms.cache_settings')
                        @include('admin.cms.change_languages_settings')
                        @include('admin.cms.add_keyword_settings')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
