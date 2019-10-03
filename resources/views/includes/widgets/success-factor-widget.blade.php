@php $success_data = App\SiteManagement::getMetaValue('success_data'); @endphp 
@if (!empty($success_data))
    <div class="sj-widget sj-widgetimpactfector">
        <div class="sj-widgetcontent">
            @foreach ($success_data as $key => $value)
                <ul>
                    <li>
                        <h3>{{{trans('prs.impact_factor')}}}<span>{{{$value['impact_factor']}}}</span></h3>
                        <h3>{{{trans('prs.time_impact_factor')}}}<span>{{{$value['time_impact_factor']}}}</span></h3>
                    </li>
                    <li>
                        <h3>{{{$value['commenter_name']}}}</h3>
                        <div class="sj-description">
                            <p>{{{str_limit($value['comment'], 50)}}}</p>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
@endif
