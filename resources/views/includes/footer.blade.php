@php 
    $stored_site_title = App\SiteManagement::getMetaValue('site_title'); 
    $site_title = !empty($stored_site_title) ? $stored_site_title[0]['site_title']: ''; 
@endphp
<div class="container" id="footer_area">
    <div class="row">
        <a class="sj-btnscrolltotop" href="javascript:void(0);"><i class="fa fa-angle-up"></i></a>
        <div class="sj-footercolumns">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 float-left">
                @include('includes.widgets.about-us-widget')
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 float-left">
                @include('includes.widgets.resource-menu-widget')
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 float-left">
                @include('includes.widgets.get-in-touch-widget')
            </div>
        </div>
        <div class="sj-footerbottom">
            <p class="sj-copyrights">© {{date("Y")}} <span>{{{$site_title}}}</span>. {{trans('prs.copyright')}}</p>
        </div>
    </div>
</div>