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

    <div class="jorunal sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
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
                        $editors = DB::table('model_has_roles')->where('role_id', 2)->select('model_id')->get();
                            for($i=0; $i < count($editors) ; $i++){
                                $bio_data[$i] = DB::table('author_bio')
                                ->join('users', 'users.id', '=', 'author_bio.user_id')
                                ->where('author_bio.user_id', $editors[$i]->model_id)
                                ->get();
                            };
                    @endphp
                    @if (count($editors))
                        <h5 style="font-size: 20px; font-family: none; font-weight: bolder;">Editor's Bio</h5>
                        <div style="margin-left: 30px">
                            @foreach ($bio_data as $val)
                                <hr>
                                <p><span style="font-weight: bolder;">Name : </span>{{{$val[0]->name}}}</p>
                                <p><span style="font-weight: bolder;">Bio : </span><br>{{{$val[0]->bio}}}</p>
                                <p><span style="font-weight: bolder;">Academic : </span>{{{$val[0]->academic}}}</p>
                                <p><span style="font-weight: bolder;">Institute : </span>{{{$val[0]->institute}}}</p>
                                <hr>
                            @endforeach
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
                        <h5 style="font-size: 20px; font-family: none; font-weight: bolder;">Peer reviewers list</h5>
                        @foreach($reviewers as $val)
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
                                        <img src="{{{asset('uploads/categories/'.$val->logo_img)}}}" style="max-height: 70px; float: left; margin-right: 30px;">
                                    @else                                    
                                        <img src="{{{asset('uploads/scholar.png')}}}" style="max-height: 70px; max-width: 100px; float: left; margin-right: 30px;">
                                    @endif
                                    <p style="margin: 10px 0; font-family: serif;">{{{$val->abstract_title}}}</p>
                                    <a href="{{{$val->abstract_url}}}">{{{$val->abstract_url}}}</a>
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
