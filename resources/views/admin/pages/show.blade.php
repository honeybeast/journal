@extends('master')
@section('title'){{ $page->title }} @stop
@section('description', "$meta_desc")
@php $breadcrumbs = Breadcrumbs::generate('showPage',$page,$slug); @endphp
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
    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9 float-left" id="article">
                    <div class="sj-aboutus">
                        <div class="sj-introduction sj-sectioninnerspace">
                            <span>{{{$page->sub_title}}}</span>
                            <h4>{{{$page->title}}}</h4>
                        </div>
                        <div class="sj-description">
                            @php echo htmlspecialchars_decode(stripslashes($page->body)); @endphp
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-3 float-left" id="article">
                    @include('includes.detailsidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
