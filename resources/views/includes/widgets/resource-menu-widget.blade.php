@php $page_data = App\SiteManagement::getMetaValue('r_menu_pages'); @endphp
@if (!empty($page_data))
    <div class="sj-fcol sj-widget sj-widgetresources">
        <div class="sj-widgetheading">
            <h3>{{{trans('prs.resources')}}}</h3>
        </div>
        <div class="sj-widgetcontent">
            <ul id="resource-menu">
                @foreach ($page_data as $key => $p)
                    @php $page = App\Page::getPageData($p); @endphp
                    <li><a href="{{{url('page/'.$p.'')}}}">{{{$page->title}}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

