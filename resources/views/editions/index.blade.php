@extends('master')
@section('title'){{ $published_articles[0]->edition_title }}@stop
@section('description', 'This is description tag')
@section('breadcrumbs')
    @php $breadcrumbs = Breadcrumbs::generate('editListing', $slug, $title); @endphp
    @if (count($breadcrumbs))
        <ol class="sj-breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
                @else
                    <li class="active">{{{ $breadcrumb->title }}}</li>
                @endif
            @endforeach
        </ol>
    @endif
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-left">
                    <div id="sj-content" class="sj-content">
                        @if(!empty($published_articles))
                            <section class="sj-haslayout sj-sectioninnerspace">
                                <div class="sj-borderheading">
                                    <h3>{{{ $published_articles[0]->edition_title }}}</h3>
                                </div>
                                <div id="sj-editorchoiceslider" class="sj-editorchoiceslider sj-editorschoice">
                                    @foreach($published_articles as $pub_edit_article)
                                        @php
                                            $author = App\User::getUserDataByID($pub_edit_article->corresponding_author_id);
                                            $edition_image = App\Helper::getEditionImage($pub_edit_article->edition_id, 'medium');
                                        @endphp
                                        <article class="sj-post sj-editorchoice">
                                            @if(!empty($edition_image))
                                                <figure class="sj-postimg">
                                                    <img src="{{{asset($edition_image)}}}" alt="{{{trans('prs.article_img')}}}">
                                                </figure>
                                            @endif
                                            <div class="sj-postcontent">
                                                <div class="sj-head">
                                                    <span class="sj-username"><a href="javascript:void(0);">{{{$author->name}}}</a></span>
                                                    <h3><a href="{{{url('article/'.$pub_edit_article->slug)}}}">{{{$pub_edit_article->title}}}</a></h3>
                                                </div>
                                                <div class="sj-description">
                                                    @php echo str_limit($pub_edit_article->excerpt, 150); @endphp
                                                </div>
                                                <a class="sj-btn" href="{{{url('article/'.$pub_edit_article->slug)}}}">
                                                    {{{trans('prs.btn_view_full_articles')}}}
                                                </a>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 float-right">
                    @include('includes.widgetsidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
