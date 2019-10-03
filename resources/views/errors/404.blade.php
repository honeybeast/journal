@extends('master') 
@section('content')
    <div class="sj-404error">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 offset-sm-0 col-md-8 offset-md-2 col-lg-8 offset-lg-2">
                    <div class="sj-404content">
                        <div class="sj-404head">
                            <h2>{{{trans('prs.access_denied')}}}</h2>
                            @php $server_error = $exception->getMessage(); @endphp 
                            @if (!empty($server_error))
                                <h3>{{{$server_error}}}</h3>
                            @else
                                <h3>{{{trans('prs.no_access')}}}</h3>
                            @endif
                        </div>
                        <span class="sj-gobackhome">{{{trans('prs.go_back')}}}<a href="{{{url('/')}}}"> {{{trans('prs.homepage')}}} </a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
