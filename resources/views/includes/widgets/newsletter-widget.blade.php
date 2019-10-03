<div class="sj-widget sj-widgetadd">
    <div class="sj-widgetcontent">
        <figure class="sj-addimage">
            <a data-toggle="modal" data-target="#newsletterModal" href="javascript:void(0);">
                <img src="{{asset('images/widget-add2.jpg')}}" alt="{{ trans('prs.img') }}">
            </a>
        </figure>
    </div>
</div>
<div class="sj-modalboxarea modal fade" tabindex="-1" role="dialog" aria-labelledby="newsletterModal" aria-hidden="true" id="newsletterModal">
    <div class="modal-dialog" role="document">
        <div class="sj-modalcontent modal-content cat-model">
            <div class="sj-popuptitle">
                <h2>{{trans('prs.news_letter_information')}}</h2>
                <a href="javascript;void(0);" class="sj-closebtn close"><i class="lnr lnr-cross" data-dismiss="modal" aria-label="Close"></i></a>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => '/prs/store-subscriber','class'=>'category_edit_form']) !!}
                    <div class="form-group">
                        {!! Form::text('user_name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('prs.ph_name')]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('prs.ph_email')]) !!}
                    </div>
                    <div class="sj-popupbtn">
                        {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
