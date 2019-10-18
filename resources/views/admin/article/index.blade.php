
@extends('master')
@php  $breadcrumbs = Breadcrumbs::generate('editorArticles',$user_role,$user_id,$article_status); @endphp
@section('breadcrumbs')
    @if (count($breadcrumbs))
        <ol class="sj-breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li><a href="{{{ $breadcrumb->url }}}">{{{$breadcrumb->title}}}</a></li>
                @else
                    <li class="active">{{{App\Helper::displayArticleBreadcrumbsTitle($breadcrumb->title)}}}</li>
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
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="article">
                <div id="sj-content" class="sj-content sj-addarticleholdcontent">
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
                    <sticky_messages :message="this.success_message"></sticky_messages>
                    <div class="sj-dashboardboxtitle sj-titlewithform">
                        <h2>{{{$page_title}}}</h2>
                        {!! Form::open(['url' => url('/'.$user_role.'/dashboard/'.$user_id.'/'.Request::segment(4).'/article-search'), 'method' => 'get', 'class' => 'sj-formtheme sj-formsearchvtwo']) !!}
                            <div class="sj-sortupdown">
                                <a href="javascript:void(0);"><i class="fa fa-sort-amount-up"></i></a>
                            </div>
                            <fieldset>
                                <input type="search" name="keyword" value="{{{ !empty($_GET['keyword']) ? $_GET['keyword'] : '' }}}" class="form-control" placeholder="{{{ trans('prs.ph_search_here') }}}">
                                <button type="submit" class="sj-btnsearch"><i class="lnr lnr-magnifier"></i></button>
                            </fieldset>
                        {!! Form::close() !!}
                    </div>
                    <ul id="accordion" class="sj-articledetails sj-articledetailsvtwo">
                        @if($user_role=='editor')
                            @php
                                if($keyword == "") {
                                    $articles = DB::table('articles')
                                            ->join('categories','categories.id','=','articles.article_category_id')
                                            ->where('categories.editor_id', $user_id)
                                            ->where('articles.status', $article_status)
                                            ->select('articles.id as article_id', 'categories.id as category_id', 'articles.title as article_title', 'categories.title as category_title', 'articles.*', 'categories.*')
                                            ->get();
                                }
                                else
                                {
                                    $articles = DB::table('articles')
                                            ->join('categories','categories.id','=','articles.article_category_id')
                                            ->where('categories.editor_id', $user_id)
                                            ->where('articles.status', $article_status)
                                            ->where('articles.title', 'like', '%' . $keyword . '%')
                                            ->select('articles.id as article_id', 'categories.id as category_id', 'articles.title as article_title', 'categories.title as category_title', 'articles.*', 'categories.*')
                                            ->get();
                                }

                            @endphp
                            @if($articles->count() > 0)
                                @foreach($articles as $article)
                                    @php
                                        $category = App\Category::getCategoryByID($article->article_category_id);
                                        $author = App\User::getUserDataByID($article->corresponding_author_id);
                                        $edition = App\Article::getArticleEdition($article->edition_id);
                                    @endphp
                                    <li v-on:click.prevent="func($event)" id="headingOne-{{{$article->article_id}}}" class="sj-articleheader {{{ $errors->has('article_pdf') ? 'is-invalid' : '' }}}"
                                        data-toggle="collapse" data-target="#collapseOne-{{{$article->article_id}}}" aria-expanded="true" aria-controls="collapseOne-{{{$article->article_id}}}">
                                        <div class="sj-detailstime">
                                            @if($article->notify == 1)
                                                <span class="notify-icon" v-if="notified"><i class="fas fa-comment"></i></span>
                                            @endif
                                                <span><i class="ti-calendar"></i>{{{ Carbon\Carbon::parse($article->created_at)->format('d-m-Y') }}}</span>
                                            @if(!empty($category->category_title))
                                                <span><i class="ti-layers"></i>{{{$category->category_title}}}</span>
                                            @endif
                                                <span><i class="ti-bookmark"></i>{{ trans('prs.id') }}{{{$article->unique_code}}}</span>
                                            @if(!empty($edition))
                                                <span><i class="ti-bookmark-alt"></i>{{{ trans('prs.edition') }}}: {{{$edition->title}}}</span>
                                            @endif
                                            <h4>{{{$article->article_title}}}</h4>
                                        </div>
                                        <div class="sj-nameandmail">
                                            <span>{{{ trans('prs.corresponding_author') }}}</span>
                                            <h4>{{{$author->name}}}</h4>
                                            <span class="sj-mailinfo">{{{$author->email}}}</span>
                                        </div>
                                    </li>
                                    <li id="collapseOne-{{{$article->article_id}}}" class="collapse sj-active sj-userinfohold" aria-labelledby="headingOne-{{{$article->article_id}}}" data-parent="#accordion">
                                        <div class="sj-userinfoimgname">
                                            <figure class="sj-userinfimg">
                                                <img src="{{{ asset(App\Helper::getUserImage($article->corresponding_author_id,$author->user_image,'medium')) }}}" alt="{{{trans('prs.user_img')}}}">
                                            </figure>
                                            <div class="sj-userinfoname">
                                                <span>{{{ Carbon\Carbon::parse($article->created_at)->diffForHumans()}}} {{ trans('prs.on') }} {{{Carbon\Carbon::parse($article->created_at)->format('l \\a\\t H:i:s')}}}</span>
                                                <h3>{{{$article->article_title}}}</h3>
                                            </div>

                                            @if ($article->status == "accepted_articles")
                                                @php
                                                    $edition = !empty($editions) ? $editions : array();
                                                    $editionStatus = App\Edition::getEditionStatusByID($article->edition_id);
                                                @endphp
                                                <div class="sj-acceptedarticleshold">
                                                    {!! Form::open(['url' => url('/'.$user_role.'/dashboard/update-accepted-article'),'class'=>'sj-categorysform', 'id'  => $article->article_id, 'files' => true, 'enctype' => 'multipart/form-data']) !!}
                                                        <fieldset>
                                                            <div class="form-group">
                                                                <upload-files-field
                                                                    :doc_id="assign_article_pdf+'{{{$article->article_id}}}'"
                                                                    :uploaded_file="'{{{App\Article::getArticleFullName($article->publish_document)}}}'"
                                                                    :file_name="this.file_name"
                                                                    :hidden_field_name="'hidden_pdf_field'"
                                                                    :file_placeholder="'{{{ trans("prs.ph_upload_pdf") }}}'"
                                                                    :file_size_label="'{{{ trans("prs.ph_article_file_size") }}}'"
                                                                    :file_uploaded_label="'{{{ trans("prs.ph_file_uploaded") }}}'"
                                                                    :file_not_uploaded_label="'{{{ trans("prs.ph_file_not_uploaded") }}}'">
                                                                </upload-files-field>
                                                            </div>
                                                            @if($payment_mode != "free")
                                                                <div class="form-group">
                                                                    {!! Form::number('price',!empty($article->price) ? $article->price : null  , ['class' => 'form-control', 'min' => '1', 'placeholder' => trans('prs.ph_article_price') ]) !!}
                                                                </div>
                                                            @endif
                                                            {!! Form::hidden('article', $article->article_id) !!}
                                                            <div class="sj-categorysbtn">
                                                                {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive','id' =>$article->article_id ]) !!}
                                                            </div>
                                                        </fieldset>
                                                    {!! Form::close() !!}
                                                </div>
                                            @elseif ($article->status == "articles_under_review")
                                                <div class="sj-userbtnarea">
                                                    <a href="{{{url('/'.$user_role.'/dashboard/'.$user_id.'/'.'articles-under-review'.'/'.$article->slug.'')}}}" class="sj-btn sj-btnactive">{{{trans('prs.btn_view_detail')}}}</a>
                                                </div>
                                            @endif
                                            <div class="sj-description">
                                                @php echo htmlspecialchars_decode(stripslashes($article->excerpt)); @endphp
                                            </div>
                                            <div class="sj-preview" style="float: right;">
                                                <p>
                                                    <span>
                                                        <img src="{{{asset('images/thumbnails/pdf-img.png')}}}" style="margin-right: 5px;">
                                                    </span>
                                                    <a href="{{ url('author/create-pdf/'. $article->article_id) }}" style="text-decoration: none !important;">Preview</a> | <a href="{{ url('author/download-pdf/'. $article->article_id) }}" style="text-decoration: none !important;">Download</a>
                                                </p>
                                            </div>
                                            <div class="sj-downloadheader">
                                                <div class="sj-title">
                                                    <h3>{{{trans('prs.attached_doc')}}}</h3>
                                                    <a href="{{{route('getfile', $article->submitted_document)}}}">
                                                        <i class="lnr lnr-download"></i>{{{trans('prs.btn_download')}}}
                                                    </a>
                                                </div>
                                                <div class="sj-docdetails">
                                                    <figure class="sj-docimg">
                                                        <img src="{{{asset('images/thumbnails/doc-img.jpg')}}}" alt="{{{trans('prs.doc_img')}}}">
                                                    </figure>
                                                    <div class="sj-docdescription">
                                                        <h4>{{{App\Article::getArticleFullName($article->submitted_document)}}}</h4>
                                                        <span>{{{trans('prs.file_size')}}} {{{App\UploadMedia::getArticleSize($article->corresponding_author_id,$article->submitted_document)}}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php $comments = App\Article::getAdminArticleComments($article->article_id,'reviewer'); @endphp
                                        @if (!empty($comments))
                                            <div class="sj-feedbacktitle">
                                                <h2>{{{trans('prs.feedback')}}}</h2>
                                            </div>
                                            <div id="subaccordion" class="sj-statusholder">
                                                @foreach ($comments as $comment)
                                                    <div id="subheadingOne-{{{$comment->id}}}" class="sj-statusheaderholder sj-statuspadding" data-toggle="collapse"
                                                         data-target="#subcollapseOne-{{{$comment->id}}}" aria-expanded="true" aria-controls="subcollapseOne-{{{$comment->id}}}" role="button">
                                                        <div class="sj-reviewer-acronym">
                                                            <span>{{{App\Helper::getAcronym($comment->name)}}}</span>
                                                        </div>
                                                        <div class="sj-statusheader">
                                                            <div class="sj-statusasidetitle">
                                                                <span>{{{ Carbon\Carbon::parse($comment->created_at)->format('F j, Y') }}}</span>
                                                                <h4>{{{$comment->name}}}</h4>
                                                                <p>{{{$comment->role_type}}}</p>
                                                            </div>
                                                            <div class="sj-statusasidetitle sj-statusasidetitlevtwo">
                                                                <span>{{{ trans('prs.status') }}}</span>
                                                                <h4>@if($comment->status != "articles_under_review" ) {{{ App\Helper::displayReviewerCommentStatus($comment->status) }}} @endif</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="subcollapseOne-{{{$comment->id}}}" class="sj-statusdescription collapse sj-active" aria-labelledby="subheadingOne-{{{$comment->id}}}" data-parent="#subaccordion">
                                                        <div class="sj-description">
                                                            {{{$comment->comment}}}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                @include('errors.no-record')
                            @endif
                        @else
                            @if($articles->count() > 0)
                                @foreach($articles as $article)
                                    @php
                                        $editor_id = DB::table('articles')
                                            ->join('categories','categories.id','=','articles.article_category_id')
                                            ->where('articles.id', $article->id)
                                            ->get();
                                    @endphp
                                    @php
                                        $category = App\Category::getCategoryByID($article->article_category_id);
                                        $author = App\User::getUserDataByID($article->corresponding_author_id);
                                        $edition = App\Article::getArticleEdition($article->edition_id);
                                    @endphp
                                    <li v-on:click.prevent="func($event)" id="headingOne-{{{$article->id}}}" class="sj-articleheader {{{ $errors->has('article_pdf') ? 'is-invalid' : '' }}}"
                                        data-toggle="collapse" data-target="#collapseOne-{{{$article->id}}}" aria-expanded="true" aria-controls="collapseOne-{{{$article->id}}}">
                                        <div class="sj-detailstime">
                                            @if($article->notify == 1)
                                                <span class="notify-icon" v-if="notified"><i class="fas fa-comment"></i></span>
                                            @endif
                                                <span><i class="ti-calendar"></i>{{{ Carbon\Carbon::parse($article->created_at)->format('d-m-Y') }}}</span>
                                            @if(!empty($category->title))
                                                <span><i class="ti-layers"></i>{{{$category->title}}}</span>
                                            @endif
                                                <span><i class="ti-bookmark"></i>{{ trans('prs.id') }}{{{$article->unique_code}}}</span>
                                            @if(!empty($edition))
                                                <span><i class="ti-bookmark-alt"></i>{{{ trans('prs.edition') }}}: {{{$edition->title}}}</span>
                                            @endif
                                            <h4>{{{$article->title}}}</h4>
                                        </div>
                                        <div class="sj-nameandmail">
                                            <span>{{{ trans('prs.corresponding_author') }}}</span>
                                            <h4>{{{$author->name}}}</h4>
                                            <span class="sj-mailinfo">{{{$author->email}}}</span>
                                        </div>
                                    </li>
                                    <li id="collapseOne-{{{$article->id}}}" class="collapse sj-active sj-userinfohold" aria-labelledby="headingOne-{{{$article->id}}}" data-parent="#accordion">
                                        <div class="sj-userinfoimgname">
                                            <figure class="sj-userinfimg">
                                                <img src="{{{ asset(App\Helper::getUserImage($article->corresponding_author_id,$author->user_image,'medium')) }}}" alt="{{{trans('prs.user_img')}}}">
                                            </figure>
                                            <div class="sj-userinfoname">
                                                <span>{{{ Carbon\Carbon::parse($article->created_at)->diffForHumans()}}} {{ trans('prs.on') }} {{{Carbon\Carbon::parse($article->created_at)->format('l \\a\\t H:i:s')}}}</span>
                                                <h3>{{{$article->title}}}</h3>
                                            </div>
                                            @if ($article->status == "accepted_articles")
                                                @php
                                                    $edition = !empty($editions) ? $editions : array();
                                                    $editionStatus = App\Edition::getEditionStatusByID($article->edition_id);
                                                @endphp
                                                <div class="sj-acceptedarticleshold">
                                                    {!! Form::open(['url' => url('/'.$user_role.'/dashboard/update-accepted-article'),'class'=>'sj-categorysform', 'id'  => $article->id, 'files' => true, 'enctype' => 'multipart/form-data']) !!}
                                                        <fieldset>
                                                            <div class="form-group">
                                                                <upload-files-field
                                                                    :doc_id="assign_article_pdf+'{{{$article->id}}}'"
                                                                    :uploaded_file="'{{{App\Article::getArticleFullName($article->publish_document)}}}'"
                                                                    :file_name="this.file_name"
                                                                    :hidden_field_name="'hidden_pdf_field'"
                                                                    :file_placeholder="'{{{ trans("prs.ph_upload_pdf") }}}'"
                                                                    :file_size_label="'{{{ trans("prs.ph_article_file_size") }}}'"
                                                                    :file_uploaded_label="'{{{ trans("prs.ph_file_uploaded") }}}'"
                                                                    :file_not_uploaded_label="'{{{ trans("prs.ph_file_not_uploaded") }}}'">
                                                                </upload-files-field>
                                                            </div>
                                                            @if($payment_mode != "free")
                                                                <div class="form-group">
                                                                    {!! Form::number('price',!empty($article->price) ? $article->price : null  , ['class' => 'form-control', 'min' => '1', 'placeholder' => trans('prs.ph_article_price') ]) !!}
                                                                </div>
                                                            @endif
                                                            {!! Form::hidden('article', $article->id) !!}
                                                            <div class="sj-categorysbtn">
                                                                {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive','id' =>$article->id ]) !!}
                                                            </div>
                                                        </fieldset>
                                                    {!! Form::close() !!}
                                                </div>
                                            @elseif ($article->status == "articles_under_review")
                                                <div class="sj-userbtnarea">
                                                    <a href="{{{url('/'.$user_role.'/dashboard/'.$user_id.'/'.'articles-under-review'.'/'.$article->slug.'')}}}" class="sj-btn sj-btnactive">{{{trans('prs.btn_view_detail')}}}</a>
                                                </div>
                                            @endif
                                            <div class="sj-description">
                                                @php echo htmlspecialchars_decode(stripslashes($article->excerpt)); @endphp
                                            </div>
                                            <div class="sj-preview" style="float: right;">
                                                <p>
                                                    <span>
                                                        <img src="{{{asset('images/thumbnails/pdf-img.png')}}}" style="margin-right: 5px;">
                                                    </span>
                                                    <a href="{{ url('author/create-pdf/'. $article->id) }}" style="text-decoration: none !important;">Preview</a> | <a href="{{ url('author/download-pdf/'. $article->id) }}" style="text-decoration: none !important;">Download</a>
                                                </p>
                                            </div>
                                            <div class="sj-downloadheader">
                                                <div class="sj-title">
                                                    <h3>{{{trans('prs.attached_doc')}}}</h3>
                                                    <a href="{{{route('getfile', $article->submitted_document)}}}">
                                                        <i class="lnr lnr-download"></i>{{{trans('prs.btn_download')}}}
                                                    </a>
                                                </div>
                                                <div class="sj-docdetails">
                                                    <figure class="sj-docimg">
                                                        <img src="{{{asset('images/thumbnails/doc-img.jpg')}}}" alt="{{{trans('prs.doc_img')}}}">
                                                    </figure>
                                                    <div class="sj-docdescription">
                                                        <h4>{{{App\Article::getArticleFullName($article->submitted_document)}}}</h4>
                                                        <span>{{{trans('prs.file_size')}}} {{{App\UploadMedia::getArticleSize($article->corresponding_author_id,$article->submitted_document)}}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php $comments = App\Article::getAdminArticleComments($article->id,'reviewer'); @endphp
                                        @if (!empty($comments))
                                            <div class="sj-feedbacktitle">
                                                <h2>{{{trans('prs.feedback')}}}</h2>
                                            </div>
                                            <div id="subaccordion" class="sj-statusholder">
                                                @foreach ($comments as $comment)
                                                    <div id="subheadingOne-{{{$comment->id}}}" class="sj-statusheaderholder sj-statuspadding" data-toggle="collapse"
                                                         data-target="#subcollapseOne-{{{$comment->id}}}" aria-expanded="true" aria-controls="subcollapseOne-{{{$comment->id}}}" role="button">
                                                        <div class="sj-reviewer-acronym">
                                                            <span>{{{App\Helper::getAcronym($comment->name)}}}</span>
                                                        </div>
                                                        <div class="sj-statusheader">
                                                            <div class="sj-statusasidetitle">
                                                                <span>{{{ Carbon\Carbon::parse($comment->created_at)->format('F j, Y') }}}</span>
                                                                <h4>{{{$comment->name}}}</h4>
                                                                <p>{{{$comment->role_type}}}</p>
                                                            </div>
                                                            <div class="sj-statusasidetitle sj-statusasidetitlevtwo">
                                                                <span>{{{ trans('prs.status') }}}</span>
                                                                <h4>@if($comment->status != "articles_under_review" ) {{{ App\Helper::displayReviewerCommentStatus($comment->status) }}} @endif</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="subcollapseOne-{{{$comment->id}}}" class="sj-statusdescription collapse sj-active" aria-labelledby="subheadingOne-{{{$comment->id}}}" data-parent="#subaccordion">
                                                        <div class="sj-description">
                                                            {{{$comment->comment}}}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                @include('errors.no-record')
                            @endif
                        @endif
                    </ul>
                    @if( method_exists($articles,'links') )
                        {{ $articles->links('pagination.custom') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
