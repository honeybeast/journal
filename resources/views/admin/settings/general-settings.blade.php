@extends('master') 
@section('breadcrumbs') 
    @php $breadcrumbs = Breadcrumbs::generate('general_setting'); @endphp 
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
    @if (Session::has('message'))
        <div class="toast-holder">
            <div id="toast-container">
                <div class="alert toast-success alart-message alert-dismissible fade show fixed_message">
                    <div class="toast-message">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                        {{{ Session::get('message') }}}
                    </div>
                </div>
            </div>
        </div>
    @endif 
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
    @php $counter = 0; @endphp
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                @include('includes.side-menu')
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="general_setting">
                    <div id="sj-content editiontemplate" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo sj-editiontemplate">
                        @include('admin.settings.edition-setting')
                    </div>
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        @include('admin.settings.category-setting')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
