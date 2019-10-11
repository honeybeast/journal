@php
    $pages = App\Page::all();
    $published_editions = App\Edition::getPublishedEdition();
@endphp
@auth
    {{App\Helper::displayEmailWarning()}}
@endauth
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="sj-topbar">
                @php App\Helper::displaySocials(); @endphp
                <div class="sj-languagelogin">
                    @guest
                        <div class="sj-loginarea">
                            <ul class="sj-loging">
                                <li><a href="{{ route('login',['type=login']) }}">{{{trans('prs.login')}}}</a></li>
                                <li><a href="{{ route('login',['type=register']) }}">{{{trans('prs.register')}}}</a></li>
                            </ul>
                        </div>
                    @else
                        @php $user_roles_type = App\User::getUserRoleType(Auth::user()->id); @endphp
                        <div class="sj-userloginarea">
                            <a href="javascript:void(0);">
                                <i class="fa fa-angle-down"></i>
                                <img id="site_user_image_header" src="{{url(App\Helper::getUserImage(Auth::user()->id, Auth::user()->user_image, 'mini') )}}" alt="{{{trans('prs.user_img')}}}">
                                <div class="sj-loginusername">
                                    <h3>Hi, {{{Auth::user()->name}}}</h3>
                                    <span>{{{$user_roles_type->name}}}</span>
                                </div>
                            </a>
                            <nav class="sj-usernav">
                                <ul>
                                    @if (!($user_roles_type->role_type == 'reader' ))
                                        {{App\Helper::displayArticleMenu()}}
                                    @endif
                                    <!-- @can ('View Categories') -->
                                    @if ($user_roles_type->role_type == 'superadmin')
                                        <li>
                                            <a href="{{url('/dashboard/edition/settings')}}">
                                                <i class="lnr lnr-cog"></i><span>{{{trans('prs.edition_settings')}}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('/dashboard/category/settings')}}">
                                                <i class="lnr lnr-layers"></i><span>{{{trans('prs.category_settings')}}}</span>
                                            </a>
                                        </li>
                                    @endif
                                    <!-- @endcan -->
                                    @can ('Manage Users')
                                        <li>
                                            <a href="{{url('superadmin/users/manage-users')}}">
                                                <i class="lnr lnr-users"></i><span>{{{trans('prs.manage_users')}}}</span>
                                            </a>
                                        </li>
                                    @endcan
                                        <li>
                                            <a href="{{url('dashboard/general/settings/account-settings')}}">
                                                <i class="lnr lnr-cog"></i><span>{{{trans('prs.account_settings')}}}</span>
                                            </a>
                                        </li>
                                    <!-- @can ('Manage Pages') -->
                                    @if ($user_roles_type->role_type == 'superadmin')
                                        <li>
                                            <a href="{{url('/'.App\Helper::getPageAuthor().'/dashboard/pages')}}">
                                                <i class="lnr lnr-menu"></i><span>{{{trans('prs.manage_pages')}}}</span>
                                            </a>
                                        </li>
                                    @endif
                                    <!-- @endcan -->
                                    <!-- @can ('Site Management') -->
                                    @if ($user_roles_type->role_type == 'superadmin')
                                        <li>
                                            <a href="{{url('/dashboard/'.App\Helper::getPageAuthor().'/site-management/settings')}}">
                                                <i class="lnr lnr-code"></i><span>{{{trans('prs.manage_site')}}}</span>
                                            </a>
                                        </li>
                                    @endif
                                    <!-- @endcan -->
                                    @if ($user_roles_type->role_type == 'reader')
                                        <li>
                                            <a href="{{url('/user/products/downloads')}}">
                                                <i class="lnr lnr-download"></i><span>{{{trans('prs.downloads')}}}</span>
                                            </a>
                                        </li>
                                    @elseif ($user_roles_type->role_type == 'superadmin')
                                        <li>
                                            <a href="{{url('/superadmin/downloads')}}">
                                                <i class="lnr lnr-download"></i><span>{{{trans('prs.downloads')}}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('/dashboard/superadmin/site-management/payment/settings')}}">
                                                <i class="lnr lnr-cart"></i><span>{{{trans('prs.payment_settings')}}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('/dashboard/superadmin/site-management/settings/email')}}">
                                                <i class="lnr lnr-envelope"></i><span>{{{trans('prs.email_settings')}}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('/dashboard/superadmin/emails/templates')}}">
                                                <i class="lnr lnr-envelope"></i><span>{{{trans('prs.email_templates')}}}</span>
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="lnr lnr-exit"></i>{{{trans('prs.logout')}}}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    @endguest
                </div>
            </div>
            <div class="sj-navigationarea">
                <strong class="sj-logo">
                    <a href="{{url('/')}}">
                        <img id="site_logo" src="{{asset(App\SiteManagement::getLogo())}}" alt="{{trans('prs.scientific_journal')}}">
                    </a>
                </strong>
                <div class="sj-rightarea">
                    <nav id="sj-nav" class="sj-nav navbar-expand-lg">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="lnr lnr-menu"></i>
                        </button>
                        <div class="collapse navbar-collapse sj-navigation" id="navbarNav">
                            <ul>
                                <li><a href="{{url('/')}}"><i class="lnr lnr-home"></i></a></li>
                                @php
                                    $category_list = DB::table('category_list')->get();
                                @endphp
                                @if (!empty($category_list))
                                    <li class="menu-item-has-children page_item_has_children custom-active">
                                        <a href="javascript:void(0);">Category list</a>
                                        <ul class="sub-menu" id="edition_menu">
                                            @foreach ($category_list as $val)
                                                <li class="">
                                                    <a href="{{url('journal_by_category/'.$val->id)}}">
                                                        {{{$val->category_list}}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                                @if (!empty($published_editions))
                                    <li class="menu-item-has-children page_item_has_children custom-active">
                                        <a href="javascript:void(0);">{{ trans('prs.editions') }}</a>
                                        <ul class="sub-menu" id="edition_menu">
                                            @foreach ($published_editions as $edition)
                                                <li class="@if(Request::segment(2) == e($edition->slug) ) current-menu-item @endif">
                                                    <a href="{{url('edition/'.$edition->slug)}}">
                                                        {{{$edition->title}}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                                @if (!empty($pages))
                                    @foreach ($pages as $page)
                                        @php
                                            $page_has_child = App\Page::pageHasChild($page->id); $pageID = Request::segment(2);
                                            $show_page = DB::table('sitemanagements')->where('meta_key', 'show-page-'.$page->id)->select('meta_value')->pluck('meta_value')->first();
                                        @endphp
                                        @if ($page->relation_type == 0 && $show_page == 'true')
                                            <li class="{{!empty($page_has_child) ? 'menu-item-has-children page_item_has_children' : '' }} @if ($pageID == $page->slug ) current-menu-item @endif">
                                                <a href="{{url('/page/'.$page->slug.'/')}}">{{{$page->title}}}</a>
                                                @if (!empty($page_has_child))
                                                    <ul class="sub-menu">
                                                        @foreach($page_has_child as $parent)
                                                            @php $child = App\Page::getChildPages($parent->child_id);@endphp
                                                            <li class="@if ($pageID == $child->slug ) current-menu-item @endif">
                                                                <a href="{{url('page/'.$child->slug.'/')}}">
                                                                    {{{$child->title}}}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </nav>
                    @if (App\Article::all()->count() > 0)
                        <a class="sj-btntopsearch" href="#sj-searcharea">
                            <i class="lnr lnr-magnifier"></i>
                        </a>
                    @endif
                    @if (Auth::user())
                        @if ($user_roles_type->role_type == 'author')
                            <a class="sj-btn sj-btnactive" href="{{route('checkAuthor')}}">
                                {{{trans('prs.btn_submit_article')}}}
                            </a>
                        @endif
                    @else
                    <a class="sj-btn sj-btnactive" href="{{route('checkAuthor')}}"> {{{trans('prs.btn_submit_article')}}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sj-innerbanner">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="sj-innerbannercontent">
                    @if (!empty($user))
                        <h1>{{{Auth::user()->name}}}</h1>
                    @else
                        <!-- <h1>{{{trans('prs.become_member')}}}</h1> -->
                    @endif
                    @yield ('breadcrumbs')
                </div>
            </div>
        </div>
    </div>
</div>
