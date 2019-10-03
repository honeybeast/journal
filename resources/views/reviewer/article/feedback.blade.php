@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('reviewerArticleDetail',$article, $reviewer_id, $status,$id); @endphp
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
    <div class="container" id="reviewer_feedback">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                <div class="provider-site-wrap" v-show="loading" v-cloak>
                    <div class="provider-loader">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </div>
                @include('includes.side-menu')
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="assign_article">
                    @if ($errors->any())
                        <div class="toast-holder">
                            @foreach ($errors->all() as $error)
                                <div id="toast-container">
                                    <div class="alert toast-danger alart-message alert-dismissible fade show fixed_message">
                                        <div class="toast-message">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            {{{$error}}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div id="sj-content" class="sj-content sj-addarticleholdcontent">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2>{{{$article[0]->title}}}</h2>
                        </div>
                        <ul id="accordion" class="sj-articledetails sj-articledetailsvtwo">
                            @php
                                $category = App\Category::getCategoryByID($article[0]->article_category_id);
                                $author = App\User::getUserDataByID($article[0]->corresponding_author_id);
                            @endphp
                            <li class="sj-articleheader">
                                <div class="sj-detailstime">
                                    <span><i class="ti-calendar"></i>{{{ Carbon\Carbon::parse($article[0]->created_at)->format('M j H:i:s') }}}</span>
                                    @if (!empty($category))
                                        <span><i class="ti-layers"></i>{{{$category->title}}}</span>
                                    @endif
                                    <span><i class="ti-bookmark"></i>{{ trans('prs.id') }} {{{$article[0]->unique_code}}}</span>
                                </div>
                            </li>
                            <li>
                                @if ($article[0]->status != 'articles_under_review')
                                    <div class="sj-feedbacktitle">
                                        <h2>{{{trans('prs.reviewer_feedback')}}}</h2>
                                    </div>
                                    <div id="subaccordion" class="sj-statusholder">
                                        @foreach ($comments as $comment)
                                            <div id="subheadingOne-{{{$comment->id}}}" class="sj-statusheaderholder sj-statuspadding"
                                                data-toggle="collapse" data-target="#subcollapseOne-{{{$comment->id}}}"
                                                aria-expanded="true" aria-controls="subcollapseOne-{{{$comment->id}}}" role="button">
                                                <figure class="sj-statusimg">
                                                    <img src="{{{asset('images/thumbnails/img-03.jpg')}}}" alt="{{{trans('prs.user_img')}}}">
                                                </figure>
                                                <div class="sj-statusheader">
                                                    <div class="sj-statusasidetitle">
                                                        <span>{{{ Carbon\Carbon::parse($comment->created_at)->format('d-m-Y') }}}</span>
                                                        <h4>
                                                            @if ($comment->status == "major_revisions" )
                                                                {{{trans('prs.major_revisions')}}}
                                                            @else
                                                                {{{trans('prs.minor_revisions')}}}
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
                                {!! Form::open(['url' => '/reviewer/user/submit-feedback/'.$article[0]->id, 'class'=>'sj-formtheme sj-formsearchvthree']) !!}
                                    <fieldset>
                                        <div class="sj-dashboardboxtitle sj-titlewithform">
                                            <h2>{{{trans('prs.reply_revision')}}}</h2>
                                        </div>
                                        <div class="form-group sj-firstformgroup">
                                            <span class="sj-select">
                                                {!! Form::select('status', array('accepted_articles' => 'Accept Article', 'minor_revisions' => 'Minor Rivision','major_revisions'=>'Major Rivision','rejected' => 'Reject Article'), null ,array('class' => '')) !!}
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::textarea('comments', null, ['class' => 'form-control', 'placeholder' => trans('prs.ph_add_feedback')]) !!}
                                        </div>
                                        {!! Form::hidden('article', $article[0]->id) !!}
                                    </fieldset>
                                    <div class="sj-popupbtn sj-popupbtnvtwo">
                                        {!! Form::submit(trans('prs.btn_submit'), ['class' => 'sj-btn sj-btnactive','v-on:click' => 'showloading']) !!}
                                    </div>
                                {!! Form::close() !!}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
