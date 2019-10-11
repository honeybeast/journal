@extends('master')
@section('title'){{ config('app.name') }} @stop
@section('description', 'This is description tag')
@section('content')
    @if (Session::has('payment_message'))
        @php $response = Session::get('payment_message') @endphp
        <div class="toast-holder">
            <div id="toast-container">
                <div class="alert toast-{{{$response['code']}}} alart-message alert-dismissible fade show fixed_message">
                    <div class="toast-message">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        {{{ $response['message'] }}}
                    </div>
                </div>
            </div>
        </div>
    @endif
    @php
    if (Schema::hasTable('users')){
        $slide_unserialize_array = App\SiteManagement::getMetaValue('slides');
        $welcome_slide_unSerialize_array = App\SiteManagement::getMetaValue('welcome_slides');
        $published_articles = App\Article::getPublishedArticle();
        $page_slug  = App\SiteManagement::getMetaValue('pages');
        $page_data = App\Page::getPageData($page_slug[0]);
        if(!empty($page_data)){
        $welcome_desc = preg_replace("/<img[^>]+\>/i", " ", $page_data->body);
        }else{
            $welcome_desc = "";
        }
    }
    @endphp
        <style type="text/css">
.j_individual{
            min-height: 380px;
        }
    </style>

    <div class="jorunal sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="col-md-12  sj-borderheading">
                        <h3 style="font-family: inherit; float: left;">{{{$journal[0]->category_list}}}</h3>
                    </div>
                    @if (count($journal))
                        @foreach ($journal as $val)
                            <div class="col-md-6 j_individual">
                                 <div class="logo">
                                    <a href="{{{url('journal_detail/'.$val->id)}}}">
                                        @if(!empty($val->image))
                                            <img src="{{{asset($val->image)}}}">
                                        @else
                                            <img src="{{{asset('uploads/default_journal.jpg')}}}">
                                        @endif
                                    </a>
                                 </div>
                                 <div class="j_title">
                                     <h3>{{{$val->title}}}</h3>
                                 </div>
                                 <div class="j_des">
                                     <p class="j_des_txt">{{{$val->description}}}</p>
                                 </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                    @include('includes.widgets.most-download-widget')
                </div>
            </div>
        </div>
    </div>

@endsection
