@extends('master')
@section('content')
    <div class="sj-haslayout">
        <div class="container">
            <div class="row justify-content-center">
                <div class=" col-sm-12 col-md-8 push-md-2 col-lg-8 push-lg-2 ">
                    @if (session()->has('product_id'))
                        @php
                            $id = session()->get('product_id');
                            $article = App\Article::select('title','edition_id')->where('id', $id)->first();
                            $sale_tax = App\Helper::getSaleTax();
                            $price = App\Helper::getProductPrice($id);
                            $currency_symbol = App\Helper::getCurrencySymbol($currency);
                            $tax = App\Helper::calculateSaleTax($price,$sale_tax);
                            $total = App\Helper::calculateGrandTotal($tax,$price);
                            $image = App\Helper::getEditionImage($article->edition_id,'small');
                        @endphp
                        <div class="sj-checkoutjournal">
                            <div class="sj-title">
                                <h3>{{{trans('prs.checkout')}}}</h3>
                            </div>
                            <table class="sj-checkouttable">
                                <thead>
                                    <tr>
                                        <th>{{{trans('prs.item_title')}}}</th>
                                        <th>{{{trans('prs.product_price')}}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="sj-producttitle">
                                                @if(!empty($image))
                                                    <figure>
                                                        <img src="{{{asset($image)}}}">
                                                    </figure>
                                                @endif
                                                <div class="sj-checkpaydetails">
                                                    <h4>{{{$article->title}}}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{{ $currency_symbol }}} {{{$price}}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{{trans('prs.product_subtotal')}}}:</td>
                                        <td>{{{ $currency_symbol ." ". $price}}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{{trans('prs.taxes')}}}:</td>
                                        <td>{{{$currency_symbol ." ". $tax}}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{{trans('prs.grand_total')}}}</td>
                                        <td>{{{ $currency_symbol ." ". $total}}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @php
                            session()->put(['product_title' => e($article->title)]);
                            session()->put(['product_price' => e($total)]);
                            if (!empty($tax)){
                                session()->put(['product_vat' => e($tax)]);
                            }
                        @endphp
                        <div class="sj-checkpaymentmethod">
                            <div class="sj-title">
                                <h3>{{{trans('prs.select_pay_method')}}}</h3>
                            </div>
                            <ul class="sj-paymentmethod">
                                <li>
                                    <a href="{{{url('paypal/ec-checkout')}}}">
                                        <i class="fa fa-paypal"></i>
                                        <span><em>{{{trans('prs.pay_amount_via')}}}</em>{{{trans('prs.gateway_note')}}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
