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
                <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding: 30px 70px;min-height: 400px;">
                    <p style="word-wrap: break-word;line-height: 2.3em;font-size: 15px;">
                        Dear Editor,



                        As a corresponding author, I declare that the said paper submitted for publication by Affirm publications is my original research work, it does not infringe any personal or property rights of another, the work does not contain
                        anything libelous or otherwise illegal, and that the journal has the full power
                        to enter into this agreement and assignment. I also agree that the work
                        contains no material from other works protected by copyright that have been
                        used without the written consent of the copyright owner, or that I can provide
                        copies of all such required written consents to journal upon request. I have
                        properly cited the work/s of others in the text as well as in the reference
                        list. I further declare that the manuscript that the submitted for publication
                        in the said journal, has not been previously published and is not currently
                        under review elsewhere. If the article was prepared jointly with other authors,
                        I have informed the co-author of the terms of this publishing agreement and
                        that I am signing on their behalf as their agent, and I am authorized to do so.
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
