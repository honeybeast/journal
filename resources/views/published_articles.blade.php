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
        $published_articles = 
            DB::table('articles')
            ->join('editions', 'editions.id', '=', 'articles.edition_id')
            ->select('articles.*')
            ->where('articles.publish_document', '!=', null)
            ->where('articles.edition_id', '!=', null)
            ->where('editions.edition_status', 1)
            ->where('articles.article_category_id', $journal[0]->id)

            ->get()->all();

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
                @if (!empty($published_articles))
                    <div class="col-md-12">
                        <h3 style="font-family: auto; font-weight: bolder;">Current and Archived Manuscripts</h3>
                    </div>
                    <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                        <div id="sj-content" class="sj-content">
                            <section class="sj-haslayout sj-sectioninnerspace">
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
                    <div class="col-12 col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 30px;">
                        @include('includes.widgets.most-download-widget')
                    </div>
                @else
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 400px;">
                        <h1 style="text-align: center; margin-top: 100px;">There Is No Published Manuscript.</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
