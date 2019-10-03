@extends('master') 
@section('content')
    <div class="sj-haslayout">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="invoice_list">
                    <div class="sj-transactionhold">
                        <div class="sj-borderheading sj-borderheadingvtwo" id="noprintable">
                            <h3>{{{trans('prs.transaction_detl')}}}</h3>
                            <a class="print-window" href="javascript:void(0);" @click="print()">
                                <i class="fa fa-print"></i>
                                {{{trans('prs.print')}}}
                            </a>
                        </div>
                        <div class="sj-transactioncontent" id="printable_area">
                            <ul class="sj-transactiondetails">
                                <li>
                                    <span><em>{{{trans('prs.pay_rec')}}}</em>{{{trans('prs.from')}}}{{{$invoice_info->payer_name}}}</span> 
                                    <span class="sj-grossamount">{{{trans('prs.gross_amnt')}}}</span>
                                </li>
                                <li>
                                    <span>
                                        {{{ Carbon\Carbon::parse($invoice_info->created_at)->diffForHumans()}}} on {{{Carbon\Carbon::parse($invoice_info->created_at)->format('l \\a\\t H:i:s')}}}
                                    </span>
                                    <span class="sj-transactionid">{{{trans('prs.transaction')}}} id:&nbsp;{{{$invoice_info->transaction_id}}}</span>
                                    <span class="sj-grossamount sj-grossamountusd">${{{$invoice_info->price}}}&nbsp;USD</span>
                                </li>
                                <li>
                                    <span>{{{trans('prs.pay_status')}}}&nbsp;&colon;</span> 
                                    <span class="sj-paymentstatus">{{{$invoice_info->payer_status}}}</span>
                                </li>
                            </ul>
                            <table class="table sj-carttable">
                                <thead>
                                    <tr>
                                        <th>{{{trans('prs.product_name')}}}</th>
                                        <th>{{{trans('prs.product_qty')}}}</th>
                                        <th>{{{trans('prs.product_price')}}}</th>
                                        <th>{{{trans('prs.product_Subtotal')}}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-title="Product Name">
                                            <em>{{{$invoice_info->item_name}}}</em>
                                        </td>
                                        <td data-title="Unit Price">{{{$invoice_info->item_qty}}}</td>
                                        <td data-title="Total">${{{$invoice_info->item_price}}}&nbsp;USD</td>
                                        <td data-title="Total">${{{$invoice_info->item_price}}}&nbsp;USD</td>
                                    </tr>
                                    <tr>
                                        <td data-title="Product Name"></td>
                                        <td data-title="Unit Price"></td>
                                        <td data-title="Unit Price">{{{trans('prs.purchase_total')}}}</td>
                                        <td data-title="Total">${{{$invoice_info->item_price}}}&nbsp;USD</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table sj-carttable sj-carttablevtwo">
                                <thead>
                                    <tr>
                                        <th>{{{trans('prs.pay_detl')}}}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-title="Product Name">
                                            <em>{{{trans('prs.purchase_total')}}}</em>
                                            <span>${{{$invoice_info->price}}} USD</span>
                                        </td>
                                        <td data-title="Unit Price"></td>
                                        <td data-title="Total"></td>
                                        <td data-title="Total"></td>
                                    </tr>
                                    <tr>
                                        <td data-title="Product Name">
                                            <em>{{{trans('prs.sales_tax')}}}</em>
                                            <span>${{{$invoice_info->sales_tax}}} USD</span>
                                        </td>
                                        <td data-title="Unit Price"></td>
                                        <td data-title="Total"></td>
                                        <td data-title="Total"></td>
                                    </tr>
                                    <tr>
                                        <td data-title="Product Name">
                                            <em>{{{trans('prs.shiping_amnt')}}}</em>
                                            <span>${{{$invoice_info->shipping_amount}}} USD</span>
                                        </td>
                                        <td data-title="Unit Price"></td>
                                        <td data-title="Total"></td>
                                        <td data-title="Total"></td>
                                    </tr>
                                    <tr>
                                        <td data-title="Product Name">
                                            <em>{{{trans('prs.handling_amnt')}}}</em>
                                            <span>${{{$invoice_info->handling_amount}}} USD</span>
                                        </td>
                                        <td data-title="Unit Price"></td>
                                        <td data-title="Total"></td>
                                        <td data-title="Total"></td>
                                    </tr>
                                    <tr>
                                        <td data-title="Product Name">
                                            <em>{{{trans('prs.insurance_amnt')}}}</em>
                                            <span>${{{$invoice_info->insurance_amount}}} USD</span>
                                        </td>
                                        <td data-title="Unit Price"></td>
                                        <td data-title="Total"></td>
                                        <td data-title="Total"></td>
                                    </tr>
                                    @php $net_price = $invoice_info->item_price - $invoice_info->paypal_fee; @endphp
                                    <tr>
                                        <td data-title="Product Name">
                                            <em>{{{trans('prs.gross_amnt')}}}</em>
                                            <span>${{{$invoice_info->item_price}}} USD</span>
                                        </td>
                                        <td data-title="Unit Price"></td>
                                        <td data-title="Total"></td>
                                        <td data-title="Total"></td>
                                    </tr>
                                    <tr>
                                        <td data-title="Product Name">
                                            <em>{{{trans('prs.paypal_fee')}}}</em>
                                            <span>&ndash;&nbsp;&nbsp;${{{$invoice_info->paypal_fee}}} USD</span>
                                        </td>
                                        <td data-title="Unit Price"></td>
                                        <td data-title="Total"></td>
                                        <td data-title="Total"></td>
                                    </tr>
                                    <tr>
                                        <td data-title="Product Name">
                                            <em>{{{trans('prs.net_amnt')}}}</em>
                                            <span>${{{$net_price}}} USD</span>
                                        </td>
                                        <td data-title="Unit Price"></td>
                                        <td data-title="Total"></td>
                                        <td data-title="Total"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="sj-createtransactionhold sj-createtransactionholdvtwo">
                                <div class="sj-createtransactionheading">
                                    <span></span>
                                </div>
                                <div class="sj-refundscontent">
                                    <ul class="sj-refundsdetails">
                                        <li>
                                            <strong>{{{trans('prs.invoice_id')}}}</strong>
                                            <div class="sj-rightarea"><span>{{{$invoice_info->invoice_id}}}</span></div>
                                        </li>
                                        <li>
                                            <strong>{{{trans('prs.paid_by')}}}</strong>
                                            <div class="sj-rightarea"><span>{{{$invoice_info->payer_name}}}</span>
                                                <span>{{{trans('prs.pay_sender_note')}}} <em>{{{$invoice_info->payer_status}}}</em></span><span>{{{$invoice_info->payer_email}}}</span></div>
                                        </li>
                                        <li>
                                            <strong><span>{{{trans('prs.need_help')}}}</span></strong>
                                            <span class="sj-refundsinfo">{{{trans('prs.paypal_note')}}}</span>
                                        </li>
                                        <li>
                                            <span class="sj-refundsinfo">{{{trans('prs.paypal_warning_note')}}}</span>
                                        </li>
                                        <li>
                                            <strong>{{{trans('prs.memo')}}}</strong>
                                            <div class="sj-rightarea"><span>{{{$invoice_info->title}}}</span></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
