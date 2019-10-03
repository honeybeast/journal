<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
    <div class="sj-dashboardboxtitle" id="headingOne-add-keyword" data-toggle="collapse" data-target="#collapseOne-add-keyword"
        aria-expanded="true" aria-controls="collapseOne-site-title">
        <!-- <h2>{{trans('prs.site_title_setting')}}</h2> -->
        <h2>Add keywords</h2>
    </div>
    <div id="collapseOne-add-keyword" aria-labelledby="headingOne-add-keyword" data-parent="#accordion" class="sj-uploadimgbars sj-active collapse">
        {!! Form::open([ 'url' => '/dashboard/'.$user_role.'/site-management/store/add-keyword', 'class' => 'sj-formtheme
        sj-formarticle sj-formsocical' ]) !!}
        <fieldset class="social-icons-content">
            <div class="wrap-social-icons">
                <div class="form-group">
                    <select class="form-control" name="keywords[]" multiple data-role="tagsinput">
                        @if(!empty($keywords))
                            @foreach ($keywords as $keyword)
                                <option value="{{$keyword}}">{{$keyword}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </fieldset>
        <div class="sj-btnarea sj-updatebtns">
            {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
