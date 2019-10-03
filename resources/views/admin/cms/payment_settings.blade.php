@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('paymentSettings'); @endphp
@section('breadcrumbs')
    @if (count($breadcrumbs))
        <ol class="sj-breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
                @else
                    <li class="active">{{{ $breadcrumb->title }}}</li>
                @endif
            @endforeach
        </ol>
    @endif
@endsection
@section('content')
    <div id="sj-twocolumns" class="sj-twocolumns">
        @include('includes.side-menu')
        <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="payment_settings">
            @if (Session::has('success'))
                <div class="toast-holder">
                    <flash_messages :message="'{{{ Session::get('success') }}}'" :message_class="'success'" v-cloak></flash_messages>
                </div>
            @elseif (Session::has('error'))
                <div class="toast-holder">
                    <flash_messages :message="'{{{ Session::get('error') }}}'" :message_class="'danger'" v-cloak></flash_messages>
                </div>
            @elseif ($errors->any())
                <div class="toast-holder">
                    @foreach ($errors->all() as $error)
                        <flash_messages :message="'{{{$error}}}'" :message_class="'danger'" v-cloak></flash_messages>
                    @endforeach
                </div>
           @endif
            <div class="sj-addarticleholdcontent">
                <div class="sj-dashboardboxtitle">
                    <h2>{{ trans('prs.product_payment_mode') }}</h2>
                </div>
                <div class="sj-acsettingthold">
                    {!! Form::open(['url' => '/dashboard/superadmin/site-management/payment/store-product-type',
                        'class' => 'sj-formtheme sj-formarticle sj-formsocical', 'enctype' => 'multipart/form-data', 'multiple' => true]) !!}
                        <fieldset>
                            <div class="wrap-home-slider">
                                @foreach ($product_mode as $key => $mode)
                                    <div class="form-group half-width assign-role">
                                        <span class="sj-radio">
                                            {{ Form::radio('payment_mode[]', $key, ($existing_product_mode === $key) ? true : false, array('id' => $key))}}
                                            {{ Form::label($key, ucfirst($mode)) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                        <div class="sj-btnarea sj-updatebtns">
                            {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @if (!empty($existing_product_mode) && $existing_product_mode == "individual-product")
                <div class="sj-addarticleholdcontent">
                    <div class="sj-dashboardboxtitle">
                        <h2>{{{trans('prs.payment_settings')}}}</h2>
                    </div>
                    <div class="sj-acsettingthold">
                        {!! Form::open(['url' => '/dashboard/superadmin/site-management/payment/store-payment-settings', 'class' => 'sj-formtheme sj-formsocical']) !!}
                            @php
                                $existing_payment_settings_client = '';
                                $client_id = '';
                                $currency_from_db = array();
                                $vat = '';
                                $payment_type = '';
                                $existing_payment_password = '';
                                $existing_payment_secret = '';
                                if (!empty($existing_payment_settings)) {
                                    $client_id =  $existing_payment_settings[0]['client_id'];
                                    $currency_from_db = $existing_payment_settings[0]['currency'];
                                    $vat = $existing_payment_settings[0]['vat'];
                                    $payment_type = $existing_payment_settings[0]['payment_type'];
                                    $payment_password = $existing_payment_settings[0]['paypal_password'];
                                    $existing_payment_secret = $existing_payment_settings[0]['paypal_secret'];
                                }
                            @endphp
                            <fieldset>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        {!! Form::text('client_id', e($client_id), ['class' => 'form-control', 'placeholder' => trans('prs.ph_paypal_id')]) !!}
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        {{{Form::input('password', 'paypal_password', e($payment_password),['class' => 'form-control', 'placeholder' => trans('prs.ph_paypal_pass')])}}}
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        {{{Form::input('password', 'paypal_secret', e($existing_payment_secret),['class' => 'form-control', 'placeholder' => trans('prs.ph_paypal_secret')])}}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        <span class="sj-select">
                                            <select name="currency" class="form-control">
                                                @foreach($currency as $key => $value)
                                                    @php
                                                        if($currency_from_db == $value['code']){ $selected = 'selected';}else{$selected="";}
                                                    @endphp
                                                    <option value="{{{ $value['code'] }}}" {{{ $selected }}}> {{{ $value['code'] }}}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        {!! Form::text('vat', $vat, ['class' => 'form-control', 'placeholder' => trans('prs.vat')]) !!}
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 form-group">
                                        <span class="sj-select">
                                            <select name="payment_type" class="form-control">
                                                <option value="" @if($payment_type == "") selected @endif> {{ trans('prs.select_payment_mode') }}</option>
                                                <option value="test_mode" @if($payment_type == "test_mode") selected @endif> {{ trans('prs.test_mode') }}</option>
                                                <option value="live_mode" @if($payment_type == "live_mode") selected @endif> {{ trans('prs.live_mode') }}</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="sj-btnarea sj-updatebtns">
                                {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']) !!}
                            </div>
                    {!! Form::close() !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
