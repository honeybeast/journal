@extends('master') 
@section('content')
    <div class="sj-404error">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 offset-sm-0 col-md-8 offset-md-2 col-lg-8 offset-lg-2">
                    <div class="sj-404content">
                        <div class="sj-404head">
                            <h3>{{{trans('prs.page_not_found')}}}</h3>
                        </div>
                        <span class="sj-gobackhome">{{{trans('prs.go_back')}}}<a href="{{{url('/')}}}"> {{{trans('prs.homepage')}}} </a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
