@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('editorArticleDetail', $article,$user_role,$user_id, $article->status,$slug); @endphp
@section('breadcrumbs')
    @if (count($breadcrumbs))
        <ol class="sj-breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li>
                        <a href="{{{ $breadcrumb->url }}}">
                        @if ($breadcrumb->title == "Home")
                            {{{ $breadcrumb->title }}}
                        @else
                            {{{App\Helper::displayArticleBreadcrumbsTitle($breadcrumb->title)}}}
                        @endif
                        </a>
                    </li>
                @else
                    <li class="active">{{{$breadcrumb->title}}}</li>
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
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="article_detail">
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
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2>{{{$article->title}}}</h2>
                        </div>
                        <ul id="accordion" class="sj-articledetails sj-articledetailsvtwo">
                            @php
                                $category = App\Category::getCategoryByID($article->article_category_id);
                                $author = App\User::getUserDataByID($article->corresponding_author_id);
                            @endphp
                            <li class="sj-articleheader">
                                <div class="sj-detailstime">
                                    <span><i class="ti-calendar"></i>{{{ Carbon\Carbon::parse($article->updated_at)->format('d-m-Y') }}}</span>
                                    @if (!empty($category))
                                        <span><i class="ti-layers"></i>{{{$category->title}}}</span>
                                    @endif
                                    <span><i class="ti-bookmark"></i>{{{trans('prs.id')}}}: {{{$article->unique_code}}}</span>
                                    <span><i class="ti-bookmark-alt"></i>{{{trans('prs.edition')}}}</span>
                                </div>
                                <div class="sj-nameandmail">
                                    <span>{{{trans('prs.corresponding_author')}}}</span>
                                    <h4>{{{$author->name}}}</h4>
                                    <span class="sj-mailinfo">{{{$author->email}}}</span>
                                </div>
                            </li>
                            <li class="sj-userinfohold sj-active">
                                <div class="sj-userinfoimgname">
                                    <figure class="sj-userinfimg">
                                        <img src="{{{asset(App\Helper::getUserImage($article->corresponding_author_id, $author->user_image, 'medium'))}}}" alt="{{{ trans('prs.user_img') }}}">
                                    </figure>
                                    <div class="sj-userinfoname">
                                        <span>{{{ Carbon\Carbon::parse($article->created_at)->diffForHumans() }}} {{ trans('prs.on') }} {{{Carbon\Carbon::parse($article->created_at)->format('l \\a\\t H:i:s')}}}</span>
                                        <h3>{{{$article->title}}}</h3>
                                    </div>
                                    <div class="sj-description">
                                        {{{ $article->excerpt }}}
                                    </div>
                                    <div class="sj-downloadheader">
                                        <div class="sj-title">
                                            <h3>{{{trans('prs.attached_doc')}}}</h3>
                                            <a href="{{{route('getfile', $article->submitted_document)}}}"><i class="lnr lnr-download"></i>{{{trans('prs.btn_download')}}}</a>
                                        </div>
                                        <div class="sj-docdetails">
                                            <figure class="sj-docimg">
                                                <img src="{{{asset('images/thumbnails/doc-img.jpg')}}}" alt="{{{ trans('prs.doc_img') }}}">
                                            </figure>
                                            <div class="sj-docdescription">
                                                <h4>{{{App\Article::getArticleFullName($article->submitted_document)}}}</h4>
                                            <span>
                                                {{{ trans('prs.file_size') }}}
                                                {{{App\UploadMedia::getArticleSize($article->corresponding_author_id,$article->submitted_document)}}}
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php $comments = App\Article::getArticleComments($article->id,'reviewer'); @endphp
                                @if (!empty($comments))
                                <div class="sj-feedbacktitle">
                                    <h2>{{{trans('prs.reviewer_feedback')}}}</h2>
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
                                                </div>
                                                <div class="sj-statusasidetitle sj-statusasidetitlevtwo">
                                                    <span>{{{trans('prs.status')}}}</span>
                                                    <h4>
                                                        @if ($comment->status != "articles_under_review")
                                                            {{{App\Helper::displayReviewerCommentStatus($comment->status)}}}
                                                        @endif
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="subcollapseOne-{{{$comment->id}}}" class="sj-statusdescription collapse sj-active"
                                            aria-labelledby="subheadingOne-{{{$comment->id}}}" data-parent="#subaccordion">
                                            <div class="sj-description">
                                                {{{$comment->comment}}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                                @if ($article->status != "accepted_articles")
                                    <div class="sj-dashboardboxtitle sj-titlewithform">
                                        <h2>{{{trans('prs.assign_reviewer')}}}</h2>
                                        <div class="provider-site-wrap" v-show="loading" v-cloak>
                                            <div class="provider-loader">
                                                <div class="bounce1"></div>
                                                <div class="bounce2"></div>
                                                <div class="bounce3"></div>
                                            </div>
                                        </div>
                                        <sticky_messages :message="this.success_message"></sticky_messages>
                                    </div>
                                    @if ($existed_categories->count() > 0 && !empty($existed_reviewers))
                                        {!! Form::open(['url' => url('/'.$user_role.'/dashboard/assign-reviewer'), 'id' => 'assign_reviewer_article', 'class'=>'sj-formtheme sj-categorydetails', 'enctype' => 'multipart/form-data', '@submit.prevent' => 'assign_reviewer_article']) !!}
                                            <fieldset>
                                                <div class="form-group">
                                                    <span class="sj-select">
                                                        <select data-placeholder=" {{{($reviewers_categories->count() > 0) ? trans('prs.choose_reviewer') : trans('prs.assign_cat_reviewer')}}} "
                                                            multiple class="chosen-select" name="reviewers[]">
                                                            @php $count = 0; @endphp
                                                            @foreach ($reviewers_categories as $category)
                                                                @php
                                                                    $reviewers = App\User::getReviewersByCategory($category->id);
                                                                    $reviewersID = App\Article::getReviewerIdByArticle($article->id);
                                                                @endphp
                                                                <optgroup label="{{{$category->title}}}">
                                                                    @foreach ($reviewers as $reviewer)
                                                                        <option value="{{{$reviewer->id}}}" {{{ in_array($reviewer->id, $article_reviewers ) ? 'selected' : '' }}} >{{{$reviewer->name}}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="reviewer_article" value="{{{$article->id}}}">
                                                    </span>
                                                </div>
                                                <div class="sj-popupbtn">
                                                    <input type="submit" class="sj-btn sj-btnactive" value="{{ trans('prs.btn_assign') }}">
                                                </div>
                                            </fieldset>
                                        {!! Form::close() !!}
                                    @elseif ($existed_categories->count() == 0 && !empty($existed_reviewers))
                                        {!! Form::open(['url' => url('/'.$user_role.'/dashboard/assign-reviewer'), 'id' => 'assign_reviewer_article',
                                        'class'=>'sj-formtheme sj-categorydetails', 'enctype' => 'multipart/form-data', '@submit.prevent' => 'assign_reviewer_article']) !!}
                                            <fieldset>
                                                <div class="form-group">
                                                    <span class="sj-select">
                                                        <select data-placeholder="{{ trans('prs.choose_reviewer') }}" multiple class="chosen-select" name="reviewers[]">
                                                            @php $count = 0; @endphp
                                                            @foreach ($existed_reviewers as $reviewers)
                                                                <option value="{{{$reviewers->id}}}" {{{ in_array($reviewers->id, $article_reviewers ) ? 'selected' : '' }}} >
                                                                    {{{$reviewers->name}}} {{{$reviewers->sur_name}}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    <input type="hidden" name="reviewer_article" value="{{{$article->id}}}">
                                                    </span>
                                                </div>
                                                <div class="sj-popupbtn">
                                                    <input type="submit" class="sj-btn sj-btnactive" value="{{ trans('prs.btn_assign') }}">
                                                </div>
                                            </fieldset>
                                        {!! Form::close() !!}
                                    @else
                                        <div class="form-group">
                                            <input type="text" value="{{ trans('prs.add_reviewers') }}" class="form-control" readonly>
                                        </div>
                                    @endif
                                    {!! Form::open(['url' => url('submit-editor-feedback/'.$article->id), 'class'=>'sj-formtheme sj-formsearchvthree','id'=>'admin_feedback']) !!}
                                        <fieldset>
                                            <div class="sj-dashboardboxtitle sj-titlewithform"><h2>{{{trans('prs.reply_revision')}}}</h2></div>
                                            <div class="form-group sj-firstformgroup">
                                                <span class="sj-select">
                                                    {!! Form::select('status', array(
                                                        'accepted_articles' => trans('prs.accept_article'),
                                                        'minor_revisions' => trans('prs.minor_revision'),
                                                        'major_revisions'=>trans('prs.major_revision'),
                                                        'rejected' => trans('prs.reject_article'),
                                                        null))
                                                    !!}
                                                </span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::textarea('comments', null, ['class' => 'form-control comment', 'required', 'placeholder' => trans('prs.ph_add_feedback')]) !!}
                                            </div>
                                            {!! Form::hidden('article', $article->id) !!}
                                        </fieldset>
                                        <div class="sj-popupbtn sj-popupbtnvtwo">
                                            {!! Form::submit(trans('prs.btn_submit'), ['id'=>'comment_submit', 'class' => 'sj-btn sj-btnactive','v-on:click' => 'showloading']) !!}
                                        </div>
                                    {!! Form::close() !!}
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
