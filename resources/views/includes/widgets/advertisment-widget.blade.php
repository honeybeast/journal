@if (!empty(App\SiteManagement::getAdImage()))
    <div class="sj-widget sj-widgetadd">
        <span class="sj-headtitle">{{{trans('prs.ad_text')}}}</span>
        <div class="sj-widgetcontent">
            <figure class="sj-addimage">
                <a href="javascript:void(0);">
                    <img id="site_logo" src="{{{asset(App\SiteManagement::getAdImage())}}}" alt="{{{trans('prs.ad_img')}}}">
                </a>
            </figure>
        </div>
    </div>
@endif