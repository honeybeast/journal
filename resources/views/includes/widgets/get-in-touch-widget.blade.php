@php $contact_info = App\SiteManagement::getMetaValue('contact_info'); @endphp 
@if (!empty($contact_info))
    <div class="sj-fcol sj-widget sj-widgetcontactus">
        <div class="sj-widgetheading">
            <h3>{{{trans('prs.get_in_touch')}}}</h3>
        </div>
        <div class="sj-widgetcontent">
            @foreach ($contact_info as $key => $value)
                <ul>
                    @if (!empty($value['address']))
                        <li><i class="lnr lnr-home"></i><address>{{{$value['address']}}}</address></li>
                    @endif
                    @if (!empty($value['phone_no']))
                        <li><a href="tel:{{{$value['phone_no']}}}"><i class="lnr lnr-phone"></i><span>{{{$value['phone_no']}}}</span></a></li>
                    @endif
                    @if (!empty($value['fax_no']))
                        <li><a href="tel:{{{$value['fax_no']}}}"><i class="lnr lnr-screen"></i><span>{{{$value['fax_no']}}}</span></a></li>
                    @endif
                    @if (!empty($value['email']))
                        <li><a href="mailto:{{{$value['email']}}}"><i class="lnr lnr-envelope"></i><span>{{{$value['email']}}}</span></a></li>
                    @endif
                </ul>
            @endforeach
        </div>
    </div>
@endif
