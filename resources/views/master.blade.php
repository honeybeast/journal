<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
	<meta name="description" content="@yield('description')">
	<meta name="keywords" content="@yield('keywords')">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet" media="print" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/linearicons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icomoon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/color.css') }}" rel="stylesheet">
    <link href="{{ asset('css/transitions.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vue-transition.css') }}" rel="stylesheet">
    

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>

    <!-- <script src="{{ asset('js/jquery-3.3.1.js') }}"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    

    <link href="{{ asset('css/jquery.tagsinput-revisited.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.tagsinput-revisited.js') }}"></script>

    <script src="{{ asset('js/custom.js') }}"></script>    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1">
    @php
    if(Schema::hasTable('users')){
        $user_role = "";
        if(!empty(Auth::user()->id)){
            $user_id = Auth::user()->id;
            $user_role_type = App\User::getUserRoleType($user_id);
            $user_role = $user_role_type->role_type;
        }
    }
    @endphp
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}
        var USER_ROLE = {!! json_encode($user_role) !!}
    </script>
</head>

<body class="sj-login {{ \App\Helper::getBodyLangClass() }}">
    {{ \App::setLocale(env('APP_LANG')) }}
    <div id="sj-wrapper" class="sj-wrapper">
        <div class="sj-contentwrapper">
            <header id="sj-header" class="sj-header sj-haslayout">
                @if(Schema::hasTable('users'))
                @include('includes.header') @endif
            </header>
            <main id="sj-main" class="sj-main sj-haslayout sj-sectionspace">
                @yield('content')
            </main>
            <footer id="sj-footer" class="sj-footer sj-haslayout">
                @if(Schema::hasTable('users'))
                @include('includes.footer') @endif
            </footer>
        </div>
    </div>
    <div id="sj-searcharea" class="sj-searcharea">
        <button type="button" class="close">×</button>
        {!! Form::open([
            'url' => url('published/editions/filters'),'method'=> 'get', 'class' => 'sj-formtheme sj-formsearcmain'
            ])
        !!}
            <input type="search" value="" placeholder="{{trans('prs.ph_search_here')}}" name="s" />
            <button type="submit" class="sj-btn sj-btnactive"><span>Search</span></button>
        {!! Form::close() !!}
    </div>
    <!-- <script src="{{ asset('js/jquery-3.3.1.js') }}"></script> -->
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
</body>

</html>
