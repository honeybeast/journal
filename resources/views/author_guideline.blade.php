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
        $author_guideline = 
            DB::table('categories')
            ->where('id', $journal[0]->id)
            ->get();

        $page_slug  = App\SiteManagement::getMetaValue('pages');
        $page_data = App\Page::getPageData($page_slug[0]);
        if(!empty($page_data)){
        $welcome_desc = preg_replace("/<img[^>]+\>/i", " ", $page_data->body);
        }else{
            $welcome_desc = "";
        }
    }
    @endphp

    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row">
                @if (!empty($author_guideline[0]->author_guideline))
                    <div class="col-md-12">
                        <h3 style="font-family: auto; font-weight: bolder;">Author's Guideline</h3>
                    </div>
                    <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                        <div id="sj-content" class="sj-content">
                            <section class="sj-haslayout sj-sectioninnerspace">
                                <div id="sj-editorchoiceslider" class="sj-editorchoiceslider sj-editorschoice">
                                    <p style="line-height: 35px;font-size: 18px;margin: 30px;word-break: break-word;">{{$author_guideline[0]->author_guideline}}</p>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 30px;">
                        @include('includes.widgets.most-download-widget')
                    </div>
                @else
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 400px;">
                        <h1 style="text-align: center; margin-top: 100px;">There is no Author's Guideline.</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
