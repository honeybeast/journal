@php $pages = !empty($page_data) ? $page_data : array();@endphp
<sticky_messages :message="this.message"></sticky_messages>
<div class="sj-addarticleholdcontent">
    <div class="sj-dashboardboxtitle">
        <h3>{{{trans('prs.resources')}}}</h3>
    </div>
    <div class="sj-acsettingthold">
        {!! Form::open(['url' => url('/dashboard/'.$user_role.'/site_management/store/store-resource-pages'), 'id' => 'resource_page_widget',
        'class'=>'sj-formtheme sj-formarticle sj-formsocical sj-categorydetails', '@submit.prevent' => 'resource_page_widget'])
        !!}
            <fieldset class="home-slider-content">
                <div class="form-group">
                    <span class="sj-select">
                        <select data-placeholder="{{{ !empty($page) ? trans('prs.choose_resource_pages') : trans('prs.create_page_selction') }}}"
                            multiple class="chosen-select" name="page[]">
                            <optgroup>
                                @foreach ($page as $key => $p)
                                    <option value="{{{$key}}}" {{{ in_array($key, $pages) ? 'selected' : '' }}} >{{{$p}}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </span>
                </div>
            </fieldset>
            <div class="sj-btnarea sj-updatebtns">
                <input type="submit" class="sj-btn sj-btnactive" value="{{ trans('prs.btn_save') }}">
            </div>
        {!! Form::close() !!}
    </div>
</div>
