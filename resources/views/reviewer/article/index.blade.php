@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('reviewerArticles',$reviewer_id,$status); @endphp
@section('breadcrumbs')
    @if (count($breadcrumbs))
        <ol class="sj-breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
                @else
                    <li class="active">{{{ App\Helper::displayArticleBreadcrumbsTitle($breadcrumb->title) }}}</li>
                @endif
            @endforeach
        </ol>
    @endif
@endsection
@section('content')
    <div class="container" id="reviewer_feedback">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns reviewer-index">
                @if (Session::has('message'))
                    <div class="toast-holder">
                        <flash_messages :message="'{{{ Session::get('message') }}}'" :message_class="'success'" v-cloak></flash_messages>
                    </div>
                @elseif (Session::has('error'))
                    <div class="toast-holder">
                        <flash_messages :message="'{{{ Session::get('error') }}}'" :message_class="'danger'" v-cloak></flash_messages>
                    </div>
                @endif
                @include('includes.side-menu')
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="assign_article">
                    <div id="sj-content" class="sj-content sj-addarticleholdcontent">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2>{{{ $page_title }}}</h2>
                            {!! Form::open(['url' => '/reviewer/user/'.$reviewer_id.'/'.Request::segment(4).'/search-article', 'method' => 'get', 'class' => 'sj-formtheme sj-formsearchvtwo']) !!}
                                <div class="sj-sortupdown">
                                    <a href="javascript:void(0);"><i class="fa fa-sort-amount-up"></i></a>
                                </div>
                                <fieldset>
                                    <fieldset>
                                        <input type="search" name="keyword" value="{{{ !empty($_GET['keyword']) ? $_GET['keyword'] : '' }}}" class="form-control" placeholder="{{{trans('prs.ph_search_here')}}}">
                                        <button type="submit" class="sj-btnsearch"><i class="lnr lnr-magnifier"></i></button>
                                    </fieldset>
                                </fieldset>
                            {!! Form::close() !!}
                        </div>
                        @if ($articles->count() > 0)
                            <ul id="accordion" class="sj-articledetails sj-articledetailsvtwo">
                                @foreach ($articles as $article)
                                    @php
                                        $category = App\Category::getCategoryByID($article->article_category_id);
                                        $author_image = App\User::getArticleAuthorImage($article->id);
                                    @endphp
                                    <li id="headingOne-{{{ $article->id }}}" class="sj-articleheader" data-toggle="collapse"
                                        data-target="#collapseOne-{{{ $article->id }}}" aria-expanded="true" aria-controls="collapseOne-{{{$article->id}}}">
                                        <div class="sj-detailstime">
                                            <span>
                                                <i class="ti-calendar"></i> {{{ Carbon\Carbon::parse($article->created_at)->format('M j H:i:s') }}}
                                            </span>
                                            @if (!empty($category))
                                                <span><i class="ti-layers"></i>{{{$category->title}}}</span>
                                            @endif
                                            <span><i class="ti-bookmark"></i>{{ trans('prs.id') }} {{{ $article->unique_code }}}</span>
                                            @if ($article->status == 'major_revisions' || $article->status == 'minor_revisions')
                                                <span><i class="ti-bookmark"></i>Status: {{{ $article->status }}}</span>
                                            @endif
                                            <h4>{{{$article->title}}}</h4>
                                        </div>
                                        @if ($article->status == 'articles_under_review')
                                            <div class="sj-userbtnarea">
                                                <a href="{{{url('reviewer-feedback')}}}/{{{ $reviewer_id }}}/articles-under-review/{{{ $article->id }}}" class="sj-btn sj-btnactive">
                                                    {{{ trans('prs.submit_feedback') }}}
                                                </a>
                                            </div>
                                        @endif
                                    </li>
                                    <li id="collapseOne-{{{ $article->id }}}" class="collapse sj-active sj-userinfohold"
                                        aria-labelledby="headingOne-{{{ $article->id }}}" data-parent="#accordion">
                                        <div class="sj-userinfoimgname">
                                            <figure class="sj-userinfimg">
                                                <img src="{{{ asset(App\Helper::getUserImage($article->corresponding_author_id, $author_image, 'medium')) }}}" alt="{{{ trans('prs.user_img') }}}">
                                            </figure>
                                            <div class="sj-userinfoname">
                                                <span>
                                                    {{{ Carbon\Carbon::parse($article->created_at)->diffForHumans() }}} on {{{ Carbon\Carbon::parse($article->created_at)->format('l \\a\\t H:i:s') }}}
                                                </span>
                                                <h3>{{{$article->title}}}</h3>
                                            </div>
                                            <div class="sj-description">
                                                @php echo htmlspecialchars_decode(stripslashes($article->excerpt)); @endphp
                                            </div>
                                            <div class="sj-preview" style="float: right;">
                                                <p>
                                                    <span>
                                                        <img src="{{{asset('images/thumbnails/pdf-img.png')}}}" style="margin-right: 5px;">
                                                    </span>
                                                    <a href="{{ url('author/create-pdf-reviewer/'. $article->id) }}" style="text-decoration: none !important;">Preview</a> | <a href="{{ url('author/download-pdf-reviewer/'. $article->id) }}" style="text-decoration: none !important;">Download</a>
                                                </p>
                                            </div>
                                            <div class="sj-downloadheader">
                                                <div class="sj-title">
                                                    <h3>{{{trans('prs.attached_doc')}}}</h3>
                                                    <a href="{{{route('getfile', $article->submitted_document)}}}"><i class="lnr lnr-download"></i>{{{trans('prs.btn_download')}}}</a>
                                                </div>
                                                <div class="sj-docdetails">
                                                    <figure class="sj-docimg">
                                                        <img src="{{{asset('images/thumbnails/doc-img.jpg')}}}" alt="{{{trans('prs.doc_img')}}}">
                                                    </figure>
                                                    <div class="sj-docdescription">
                                                        <h4>{{{ App\Article::getArticleFullName($article->submitted_document) }}}</h4>
                                                        <span>
                                                            {{{ trans('prs.file_size') }}}
                                                            {{{ App\UploadMedia::getArticleSize($article->corresponding_author_id,$article->submitted_document) }}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php $comments = App\Article::getArticleCommentsByUserID($reviewer_id,$article->id); @endphp
                                        @if (!empty($comments))
                                            <div class="sj-feedbacktitle">
                                                <h2>{{{trans('prs.reviewer_feedback')}}}</h2>
                                            </div>
                                            <div id="subaccordion" class="sj-statusholder">
                                                @foreach ($comments as $comment)
                                                    <div id="subheadingOne-{{{$comment->id}}}" class="sj-statusheaderholder sj-statuspadding" data-toggle="collapse"
                                                        data-target="#subcollapseOne-{{{$comment->id}}}" aria-expanded="true" aria-controls="subcollapseOne-{{{$comment->id}}}"
                                                        role="button">
                                                        <div class="sj-reviewer-acronym">
                                                            <span>{{{ App\Helper::getAcronym(Auth::user()->name) }}}</span>
                                                        </div>
                                                        <div class="sj-statusheader">
                                                            <div class="sj-statusasidetitle">
                                                                <span>{{{ Carbon\Carbon::parse($comment->created_at)->format('F j, Y') }}}</span>
                                                                <h4>{{{ Auth::user()->name }}}</h4>
                                                            </div>
                                                            <div class="sj-statusasidetitle sj-statusasidetitlevtwo">
                                                                <span>{{{trans('prs.status')}}}</span>
                                                                <h4>
                                                                    @if($comment->status != "articles_under_review" )
                                                                        {{{ App\Helper::displayReviewerCommentStatus($comment->status) }}}
                                                                    @endif
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="subcollapseOne-{{{$comment->id}}}" class="sj-statusdescription collapse sj-active"
                                                        aria-labelledby="subheadingOne-{{{$comment->id}}}" data-parent="#subaccordion">
                                                        <div class="sj-description">
                                                            {{{ $comment->comment }}}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            @if( method_exists($articles,'links') )
                                {{ $articles->links('pagination.custom') }}
                            @endif
                        @else
                            @include('errors.no-record')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
