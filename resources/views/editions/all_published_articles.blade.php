@extends('master')
@section('title')@php echo 'All Published Editions'; @endphp@stop
@section('description', 'This is description tag')
@section('content')
    <div id="sj-twocolumns" class="sj-twocolumns">
        @php
            $keyword = "";
            $requested_category = array();
            $requested_edition = array();
            $show_records = "";
            !empty($_GET['s']) ? $keyword = $_GET['s'] : '';
            !empty($_GET['show']) ? $show_records = $_GET['show'] : '';
            !empty($_GET['category']) ? $requested_category = $_GET['category'] : array();
            !empty($_GET['edition']) ? $requested_edition = $_GET['edition'] : array();
        @endphp
        <div class="container" id="public_publish_articles">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-5 col-lg-9 col-xl-9 float-left">
                    {!! Form::open(['url' => url('published/editions/filters'), 'method' => 'get', 'class' => 'sj-formtheme sj-formsearch','id'=>'edition_filters']) !!}
                        <div class="col-12 col-sm-12 col-md-5 col-lg-4 col-xl-4 float-left">
                            <aside id="sj-sidebarvtwo" class="sj-sidebar">
                                <div class="sj-widget sj-widgetsearch">
                                    <div class="sj-widgetcontent">
                                        <fieldset>
                                            <input type="search" name="s" value="{{{ $keyword}}}" class="form-control" placeholder="{{{trans('prs.ph_search_here')}}}">
                                        </fieldset>
                                    </div>
                                </div>
                                @if (!empty($categories))
                                    <div class="sj-widget sj-widgetarticles">
                                        <div class="sj-widgetheading">
                                            <h3>{{{trans('prs.article_type')}}}</h3>
                                        </div>
                                        <div class="sj-widgetcontent">
                                            <div class="sj-selectgroup">
                                                @foreach ($categories as $category)
                                                    @php $checked = ''; @endphp
                                                    @if (!empty($requested_category))
                                                        @if (in_array($category->id, $requested_category))
                                                            @php $checked = 'checked'; @endphp
                                                        @else
                                                            @php $checked = ''; @endphp
                                                        @endif
                                                    @endif
                                                    <span class="sj-checkbox">
                                                        <input id="checkbox-{{{$category->id}}}" type="checkbox" name="category[]" value="{{{$category->id}}}" {{{$checked}}}>
                                                        <label for="checkbox-{{{$category->id}}}">{{{$category->title}}}</label>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($editions))
                                    <div class="sj-widget sj-widgetdate">
                                        <div class="sj-widgetheading">
                                            <h3>{{{trans('prs.by_edition')}}}</h3>
                                        </div>
                                        <div class="sj-widgetcontent">
                                            <div class="sj-selectgroup">
                                                @foreach($editions as $edition)
                                                    @php $checked = ''; @endphp
                                                    @if (!empty($requested_edition))
                                                        @if (in_array($edition->id, $requested_edition))
                                                            @php $checked = 'checked'; @endphp
                                                        @else
                                                            @php $checked = ''; @endphp
                                                        @endif
                                                    @endif
                                                    <span class="sj-checkbox">
                                                        <input id="checkbox-{{{$edition->id}}}{{{$edition->id}}}" type="checkbox" name="edition[]" value="{{{$edition->id}}}" {{{$checked}}}>
                                                        <label for="checkbox-{{{$edition->id}}}{{{$edition->id}}}">{{{$edition->title}}}</label>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="sj-filterbtns">
                                    <button type="submit" class="sj-btn">{{{trans('prs.apply_filter')}}}</button>
                                </div>
                            </aside>
                        </div>
                        <div class="col-12 col-sm-12 col-md-7 col-lg-8 col-xl-8 float-left">
                            <div id="sj-content" class="sj-content">
                                @if (Auth::user())
                                    @php
                                        $user_id = Auth::user()->id;
                                        $user_role_type = App\User::getUserRoleType($user_id);
                                    @endphp
                                    @if ($user_role_type->role_type == 'author')
                                        <div class="sj-uploadarticle">
                                            <figure class="sj-uploadarticleimg">
                                                <img src="{{{url('images/upload-articlebg.jpg')}}}" alt="{{{trans('prs.img_desc')}}}">
                                                <figcaption>
                                                    <div class="sj-uploadcontent">
                                                        <span>{{{trans('prs.upload_article')}}}</span>
                                                        <h3>{{{trans('prs.online_presence')}}}</h3>
                                                        <a class="sj-btn" href="{{{route('checkAuthor')}}}">{{{trans('prs.btn_submit')}}}</a>
                                                    </div>
                                                </figcaption>
                                            </figure>
                                        </div>
                                    @endif
                                @else
                                    <div class="sj-uploadarticle">
                                        <figure class="sj-uploadarticleimg">
                                            <img src="{{{url('images/upload-articlebg.jpg')}}}" alt="{{{trans('prs.img_desc')}}}">
                                            <figcaption>
                                                <div class="sj-uploadcontent">
                                                    <span>{{{trans('prs.upload_article')}}}</span>
                                                    <h3>{{{trans('prs.online_presence')}}}</h3>
                                                    <a class="sj-btn" href="{{{route('checkAuthor')}}}">{{{trans('prs.btn_submit')}}}</a>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </div>
                                @endif
                                <div class="sj-articles sj-formsortitems">
                                    <fieldset>
                                        <div class="form-group">
                                            <span class="sj-select">
                                            <select name="sort" @change="onChange()">
                                                <option value="date">{{{trans('prs.sort_by')}}}</option>
                                                <option value="title">{{{trans('prs.lbl_name')}}}</option>
                                                <option value="updated_at">{{{trans('prs.date')}}}</option>
                                            </select>
                                        </span>
                                        </div>
                                        <div class="form-group">
                                            <em>{{{trans('prs.show')}}} </em>
                                            <span class="sj-select">
                                            <select name="show" @change="onChange()">
                                                <option @if ($show_records == 10) selected @endif >10</option>
                                                <option @if ($show_records == 20) selected @endif >20</option>
                                                <option @if ($show_records == 30) selected @endif >30</option>
                                                <option @if ($show_records == 40) selected @endif >40</option>
                                                <option @if ($show_records == 50) selected @endif >50</option>
                                            </select>
                                        </span>
                                        </div>
                                    </fieldset>
                                    @if (!empty($published_articles))
                                        @foreach ($published_articles as $article)
                                            @php $edition_image = App\Helper::getEditionImage($article->edition_id,'medium'); @endphp
                                            <article class="sj-post sj-editorchoice">
                                                @if (!empty($edition_image))
                                                    <figure class="sj-postimg">
                                                        <img src="{{{asset($edition_image)}}}" alt="{{{trans('prs.article_img')}}}">
                                                    </figure>
                                                @endif
                                                <div class="sj-postcontent">
                                                    <div class="sj-head">
                                                        <span class="sj-username"><a href="javascript:void(0);">
                                                            {{{App\User::getUserNameByID($article->corresponding_author_id)}}}
                                                        </span>
                                                        <h3><a href="{{{url('article/'.$article->slug)}}}">{{{$article->title}}}</a></h3>
                                                    </div>
                                                    <div class="sj-description">
                                                        @php echo str_limit($article->excerpt, 105); @endphp
                                                    </div>
                                                    <a class="sj-btn" href="{{{url('article/'.$article->slug)}}}">
                                                        {{{trans('prs.btn_view_full_articles')}}}
                                                    </a>
                                                </div>
                                            </article>
                                        @endforeach
                                    @else
                                        @if (Session::has('message'))
                                            <div class="toast-holder">
                                                <div id="toast-container">
                                                    <div class="alert toast-danger alart-message alert-dismissible fade show fixed_message">
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
                                    @endif
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    @if( method_exists($published_articles,'links') )
                        {{{ $published_articles->links('pagination.custom') }}}
                    @endif
                </div>
                <div class="col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 float-left">
                    @include('includes.widgetsidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
