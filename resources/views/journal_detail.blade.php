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
        .heading_item{
            float: left;
            border-right: 2px dotted #636b77;
            line-height: 20px;
        }
        .heading_item:first-child{
            border-left: 2px dotted #636b77;
        }
        .heading_item a{
            color: #636b77;
            font-weight: bolder;
            padding: 5px 8px;
        }
        .heading_item a:hover{
            background-color: #636b77;
            color: white;
            font-weight: bolder;
        }
    </style>
    <div class="jorunal sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="">
                        @php
                            $id = $journal[0]->id;
                        @endphp
                        <ul class="heading">
                            <li class="heading_item"><a href="{{{url('published_articles/'.$id)}}}">Current and Archive</a></li>
                            <li class="heading_item"><a href="{{{url('author_guideline/'.$id)}}}">Author's guideline</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12  sj-borderheading">
                        <h2 style="font-weight: bolder; float: left; font-family: auto;">{{{$journal[0]->title}}}</h2>
                    </div>
                    @php
                        $journals = DB::table('categories')->orderBy('updated_at', 'desc') ->get();
                    @endphp
                    <div class="j_content">
                        <div class="j_img">
                            @if(!empty($journal[0]->image))
                                <img src="{{{asset($journal[0]->image)}}}">
                            @else
                                <img src="{{{asset('uploads/default_journal.jpg')}}}">
                            @endif
                        </div>
                        <p class="j_detail">{{{$journal[0]->description}}}</p>
                        @if($journal[0]->issn_print)
                            <p class="issn">ISSN Number (Print) : {{{$journal[0]->issn_print}}}</p>
                        @endif
                        @if($journal[0]->issn_electronic)
                            <p class="issn">ISSN Number (Electronic) : {{{$journal[0]->issn_electronic}}}</p>
                        @endif
                    </div>
                    <div class="editor" style="margin: 30px 0;">
                    @php
                        $editor_name = DB::table('categories')
                            ->join('users','users.id','=','categories.editor_id')
                            ->where('categories.id', $journal[0]->id)
                            ->select('users.name')
                            ->get();
                    @endphp
                    @if (isset($editor_name))
                        <h5 style="font-size: 20px; font-family: none; font-weight: bolder;">Editor in chief</h5>
                        <div style="margin-left: 30px">
                            <p style="font-family: auto; font-size: 18px;">{{{$editor_name[0]->name}}}</p>
                        </div>
                    @endif
                    </div>
                    @php
                        $id = $journal[0]->id;
                        $reviewers = DB::table('reviewers_categories')
                        ->join('users','users.id', '=', 'reviewers_categories.reviewer_id' )
                        ->where('reviewers_categories.category_id', $id)
                        ->select('reviewers_categories.reviewer_id','users.name')->get();
                    @endphp
                    @if(count($reviewers))
                    <div class="reviewer_list">
                        @foreach($reviewers as $val)
                            <h5 style="font-size: 20px; font-family: none; font-weight: bolder;">Peer reviewers list</h5>
                            <p style="margin-left: 30px; font-family: auto; font-size: 18px;">{{{$val->name}}}</p>
                        @endforeach
                    </div>
                    @endif
                    <div class="abstract_list">
                        @php
                            $abstract = DB::table('abstract')->where('jo_id', $journal[0]->id) ->get();
                        @endphp
                        @if(isset($abstract[0]))
                            <h5 style="font-size: 20px; font-family: none; font-weight: bolder;">Abstracting and Indexing</h5>
                        @endif
                        @if (count($abstract))
                            @foreach ($abstract as $val)
                                <div class="col-md-6" style="float: left; margin-bottom: 20px;">
                                    @if($val->logo_img)
                                        <a href="{{{$val->abstract_url}}}"><img src="{{{asset('uploads/categories/'.$val->logo_img)}}}" style="max-height: 70px; float: left; margin-right: 30px;"></a>
                                    @else                                    
                                        <a href="{{{$val->abstract_url}}}"><img src="{{{asset('uploads/scholar.png')}}}" style="max-height: 70px; max-width: 100px; float: left; margin-right: 30px;"></a>
                                    @endif
                                    <p style="margin: 10px 0; font-family: serif;">{{{$val->abstract_title}}}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>



                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                    @include('includes.widgets.most-download-widget')
                </div>
            </div>
        </div>
    </div>
    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </div>
@endsection
