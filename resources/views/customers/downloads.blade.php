@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('downloads'); @endphp 
@section('breadcrumbs') 
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
                @include('includes.side-menu')
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="general_setting">
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2>{{{trans('prs.downloads')}}}</h2>
                        </div>
                        <div class="sj-manageallsession">
                            <ul class="sj-allcategorys">
                                @if($purchases->count() > 0)
                                    @foreach($purchases as $product)
                                        <li class="sj-categorysinfo">
                                            <div class="sj-title">
                                                <h3>{{{ $product->article_title }}}</h3>
                                            </div>
                                            <div class="sj-categorysrightarea">
                                                <a title="Download" href="{{{route('getPublishFile', $product->article_publish_document) }}}">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <a href="{{{url('/user/products/invoice/'.$product->id) }}}">
                                                    <span>{{{trans('prs.generate_invoice')}}}</span>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    @include('errors.no-record')
                                @endif
                            </ul>
                            @if ( method_exists($purchases,'links') ) 
                                {{{ $purchases->links('pagination.custom') }}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
