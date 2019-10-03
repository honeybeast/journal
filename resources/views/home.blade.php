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
    @if (!empty($slide_unserialize_array))
        <div id="sj-homebanner" class="sj-homebanner owl-carousel">
            @foreach($slide_unserialize_array as $key => $slide)
            <div class="item">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="sj-postbook">
                                <figure class="sj-featureimg">
                                    <div class="sj-bookimg">
                                        <div class="sj-frontcover">
                                            <img src="{{{asset('uploads/slider/images/'.$slide['slide_image'])}}}" alt="{{{trans('prs.slide_img')}}}">
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        </div>
                        @if (!empty($slide['slide_title']) || !empty($slide['slide_desc']) )
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="sj-bannercontent">
                                <h1>@php echo htmlspecialchars_decode(stripslashes($slide['slide_title'])); @endphp</h1>
                                <div class="sj-description">
                                    <p>@php echo htmlspecialchars_decode(stripslashes($slide['slide_desc'])); @endphp</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
    @if (!empty($page_data))
    <div class="sj-haslayout sj-welcomegreetingsection sj-sectionspace">
        <div class="container">
            <div class="row">
                <div class="sj-welcomegreeting">
                    @if (!empty($welcome_slide_unSerialize_array))
                        <div class="col-12 col-sm-12 col-md-5 col-lg-5 sj-verticalmiddle">
                            <div id="sj-welcomeimgslider" class="sj-welcomeimgslider sj-welcomeslider owl-carousel">
                                @foreach ($welcome_slide_unSerialize_array as $key => $slide)
                                    <figure class="sj-welcomeimg item">
                                        <img src="{{{asset('uploads/settings/welcome_slider/'.$slide['welcome_slide_image'])}}}" alt="{{{trans('prs.img_desc')}}}">
                                    </figure>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="col-12 col-sm-12 col-md-7 col-lg-7 sj-verticalmiddle float-right">
                        <div class="sj-welcomecontent">
                            <div class="sj-welcomehead">
                                <span>{{{$page_data->sub_title}}}</span>
                                <h2>{{{$page_data->title}}}</h2>
                            </div>
                            <div class="sj-description">
                                @php echo str_limit(htmlspecialchars_decode(stripslashes($welcome_desc)), 300) @endphp
                            </div>
                            <div class="sj-btnarea">
                                <a class="sj-btn" href="{{{url('/page/'.$page_data->slug.'/')}}}">{{{trans('prs.btn_read_more')}}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="jorunal sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="col-md-12  sj-borderheading">
                        <h2 style="font-weight: bolder; float: left;">Jorunals</h2>
                        <a class="sj-btnview" style="margin-top: 30px;" href="{{{url('published/editions/articles')}}}">{{{trans('prs.btn_view_all')}}}</a>
                    </div>
                    @php
                        $journals = DB::table('categories')->orderBy('updated_at', 'desc') ->get();
                    @endphp
                    @if (count($journals))
                        @foreach ($journals as $val)
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
    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row">
                @if (!empty($published_articles))
                    <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                        <div id="sj-content" class="sj-content">
                            <section class="sj-haslayout sj-sectioninnerspace">
                                <div class="sj-borderheading">
                                    <h2 style="font-weight: bolder; float: left;" >{{{trans('prs.editions')}}}</h3>
                                    <a class="sj-btnview" style="margin-top: 30px;" href="{{{url('published/editions/articles')}}}">{{{trans('prs.btn_view_all')}}}</a>
                                </div>
                                <div id="sj-editorchoiceslider" class="sj-editorchoiceslider sj-editorschoice">
                                    @if (!empty($published_articles))
                                        @foreach ($published_articles as $article)
                                            @php $edition_image = App\Helper::getEditionImage($article->edition_id,'medium') ;@endphp
                                            <article class="sj-post sj-editorchoice">
                                                @if (!empty($edition_image))
                                                    <figure class="sj-postimg">
                                                        <img src="{{{asset($edition_image)}}}" alt="{{{trans('prs.article_img')}}}">
                                                    </figure>
                                                @endif
                                                <div class="sj-postcontent">
                                                    <div class="sj-head">
                                                        <span class="sj-username">{{{App\User::getUserNameByID($article->corresponding_author_id)}}}</span>
                                                        <h3><a href="{{{url('article/'.$article->slug)}}}">{{{$article->title}}}</a></h3>
                                                    </div>
                                                    <div class="sj-description">
                                                        @php echo str_limit($article->excerpt, 105); @endphp
                                                    </div>
                                                    <a class="sj-btn" href="{{{url('article/'.$article->slug)}}}">{{{trans('prs.btn_view_full_articles')}}}</a>
                                                </div>
                                            </article>
                                        @endforeach
                                    @endif
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                        @include('includes.widgetsidebar')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
