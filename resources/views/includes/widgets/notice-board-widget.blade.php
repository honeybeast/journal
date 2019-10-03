@php $notice_data = App\SiteManagement::getMetaValue('notices'); @endphp 
@if (!empty($notice_data))
    <div class="sj-widget sj-widgetnoticeboard">
        <div class="sj-widgetheading">
            <h3>{{trans('prs.notice_board')}}</h3>
        </div>
        <div class="sj-widgetcontent">
            @php echo htmlspecialchars_decode(stripslashes($notice_data['notice'])); @endphp
        </div>
    </div>
@endif
