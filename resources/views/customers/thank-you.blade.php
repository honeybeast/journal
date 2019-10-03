@extends('master') 
@section('content')
    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9 float-left" id="article">
                    <div class="sj-aboutus">
                        <div class="sj-dashboardboxtitle">
                            <h2>{{{trans('prs.thankyou')}}}</h2>
                        </div>
                        {{{trans('prs.thanks_note')}}}.
                        <a href="{{{url('/user/products/downloads')}}}">{{{trans('prs.download_doc')}}}</a>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-3 float-left" id="article">
                    @include('includes.detailsidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
