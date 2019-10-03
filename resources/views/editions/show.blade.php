@extends('master')
@section('title'){{ !empty($article) ? $article->title : '' }}@stop
@section('description', "$meta_desc")
@section('breadcrumbs')
    @php $breadcrumbs = Breadcrumbs::generate('articleDetail', $edition_slug, $edition_title, $article); @endphp
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
    @php
        $author = App\User::getUserDataByID($article->corresponding_author_id);
        $edition_image = App\Helper::getEditionImage($article->edition_id);
    @endphp
    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div id="sj-content" class="sj-content">
                        <div class="sj-articledetail">
                            <ul class="sj-downloadprint">
                                @if (App\SiteManagement::getMetaValue('payment_mode') === 'individual-product')
                                    <li>
                                        <a href="{{url('/user/products/checkout/'.$article->id)}}">
                                            {{ trans('prs.buy_just_in') }} <span class="currency">{{ App\Helper::getCurrencySymbol($currency_symbol) }}{{App\Helper::getProductPrice($article->id)}}</span>
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{route('getPublishFile', $article->publish_document)}}">
                                            <i class="fa fa-download"></i>{{trans('prs.btn_download')}}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                            @if(!empty($edition_image))
                                <figure class="sj-articledetailimg">
                                    <img src="{{{asset($edition_image)}}}" alt="{{trans('prs.article_img')}}">
                                </figure>
                            @endif
                            <div class="sj-articledescription sj-sectioninnerspace">
                                <span class="sj-username">{{$author->name}}</span>
                                <h4>{{ $article->title }}</h4>
                                <div class="sj-description">
                                    @php echo htmlspecialchars_decode(stripslashes($article->abstract)); @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                    @include('includes.detailsidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
