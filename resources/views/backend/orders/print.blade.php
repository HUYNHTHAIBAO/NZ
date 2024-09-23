@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.orders.detail') }}
        </div>
    </div>

    <div class="print">
        @foreach($arrayIds as $arrayId)
                <?php $data_item = \App\Models\Orders::get_detail($arrayId); ?>

            @if(!empty($data_item))
                <div class="container-fluid page">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline-info">
                                <div class="card-body">
                                    <form class="form-horizontal my-custom-form" action="" method="post">

                                        <div class="order_detail_admin">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <h1 class="page-header text-center"
                                                        style="border:0; margin: 5px 0;border-bottom: 1px solid #eee;">
                                                        ĐƠN HÀNG</h1>
                                                    <div >
                                                        <p style="text-align: center">Mã đơn hàng: {{$data_item->order_code}}

                                                        </p>
                                                        <p class="text-center"> Ngày In : {{date('d/m/Y',strtotime($data_item->created_at))}}</p>
                                                    </div>
                                                </div>
                                                <!-- /.col-lg-12 -->
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <div class="row" style="padding-top:20px;">
                                                        <div class="col-lg-12 text-left">
                                                            <p>{{$data_item->fullname}}</p>
                                                            <p>ĐC: {{$data_item->address}}
                                                            </p>
                                                            <p>ĐT: {{$data_item->phone}}</p>
                                                            <p>Email: {{$data_item->email}}</p>
                                                            <p>Hình thức thanh
                                                                toán: {{\App\Models\Orders::$payment_type[$data_item->payment_type]}}</p>
                                                            <p>Ngày nhận: {{$data_item->date_receiver}}</p>

                                                            <br>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            @if(!empty($data_item->order_detail))
                                                                {!! $data_item->order_detail !!}
                                                            @else
                                                                <table class="cart_summary" cellpadding="0"
                                                                       cellspacing="0"
                                                                       style="width: 100%; margin: 0;">
                                                                    <tbody>
                                                                    <tr bgcolor="#f8f8f8"
                                                                        style="font-weight:bold;height: 30px;">
                                                                        <td style="border: 1px solid #eee;text-align: center"
                                                                            align="center">
                                                                            STT
                                                                        </td>
                                                                        <td style="border: 1px solid #eee;text-align: center"
                                                                            align="center">
                                                                            Tên sản phẩm
                                                                        </td>

                                                                        <td style="border: 1px solid #eee;text-align: center"
                                                                            align="center">
                                                                            SL
                                                                        </td>
                                                                        <td style="border: 1px solid #eee;text-align: center"
                                                                            align="center">
                                                                            Đơn giá
                                                                        </td>
                                                                        <td style="border: 1px solid #eee;text-align: center"
                                                                            align="center">
                                                                            Thành tiền
                                                                        </td>

                                                                    </tr>

                                                                    @php $total_price=0; @endphp
                                                                    @foreach($data_item->order_details as $k=>$item)
                                                                        @php $total_price += ($item->price*$item->quantity); @endphp
                                                                        <tr style="text-align: center;background: #fff;">
                                                                            <td style="border: 1px solid #eee;text-align: center"
                                                                                width="5%" align="center"
                                                                                valign="middle"
                                                                                class="stt_item">
                                                                                {{$k+1}}
                                                                            </td>
                                                                            <td style="border: 1px solid #eee;text-align: left"
                                                                                width="25%" align="left"
                                                                                valign="middle">
                                                                                {{$item->title}}
                                                                                {!! $item->product_variation_name?"<br>{$item->product_variation_name}":'' !!}
                                                                            </td>

                                                                            <td style="border: 1px solid #eee;text-align: center"
                                                                                width="8%" align="center"
                                                                                valign="middle">
                                                                                {{number_format($item->quantity)}}
                                                                            </td>
                                                                            <td style="border: 1px solid #eee;text-align: right"
                                                                                width="10%" align="right"
                                                                                valign="middle">
                                                                        <span class="don-gia"
                                                                              data-don-gia="{{$item->price}}">{{number_format($item->price)}}</span>
                                                                                đ
                                                                            </td>
                                                                            <td style="border: 1px solid #eee;text-align: right"
                                                                                width="10%" align="right"
                                                                                valign="middle">
                                                                        <span class="thanh-tien"
                                                                              data-thanh-tien="{{$item->price}}">{{number_format($item->price*$item->quantity)}}</span>
                                                                                đ
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach

                                                                    @if($data_item->total_reduce)
                                                                        <tr class="">
                                                                            <td colspan="4" class="text-right"
                                                                                style="border: 1px solid #eee;text-align: right">
                                                                                <sup><i class="text-danger">Mã giảm
                                                                                        giá/Quà
                                                                                        tặng</i></sup> Giảm giá
                                                                            </td>
                                                                            <td class="text-right"
                                                                                style="border: 1px solid #eee;text-align: right">
                                                                                -{{number_format($data_item->total_reduce)}}
                                                                                đ
                                                                            </td>

                                                                        </tr>
                                                                    @endif
                                                                    @if($data_item->total_reduce_point)
                                                                        <tr class="">
                                                                            <td colspan="4" class="text-right"
                                                                                style="border: 1px solid #eee;text-align: right">
                                                                                <sup><i class="text-danger">Điểm tích
                                                                                        lủy</i></sup>Giảm giá
                                                                            </td>
                                                                            <td class="text-right"
                                                                                style="border: 1px solid #eee;text-align: right">
                                                                                -{{number_format($data_item->total_reduce_point)}}
                                                                                đ
                                                                            </td>

                                                                        </tr>
                                                                    @endif
                                                                    @if($data_item->reduce_point)
                                                                        <tr class="">
                                                                            <td colspan="4" class="text-right"
                                                                                style="border: 1px solid #eee;text-align: right">
                                                                                Trừ điểm
                                                                            </td>
                                                                            <td class="text-right"
                                                                                style="border: 1px solid #eee;text-align: right">
                                                                                -{{number_format($data_item->reduce_point)}}
                                                                                đ
                                                                            </td>

                                                                        </tr>
                                                                    @endif
                                                                    @if($data_item->shipping_fee)
                                                                        <tr class="">
                                                                            <td colspan="4" class="text-right"
                                                                                style="border: 1px solid #eee;text-align: right">
                                                                                Phí ship
                                                                            </td>
                                                                            <td class="text-right"
                                                                                style="border: 1px solid #eee;text-align: right">
                                                                                {{number_format($data_item->shipping_fee)}}
                                                                                đ
                                                                            </td>

                                                                        </tr>
                                                                    @endif

                                                                    <tr style="text-align: center;background: #fff;">
                                                                        <td colspan="4"
                                                                            style="border: 1px solid #eee;text-align: right">
                                                                            Tổng cộng
                                                                        </td>
                                                                        <td align="right"
                                                                            style="border: 1px solid #eee;text-align: right">
                                                                    <span style="color: #f00;">
                                                                        <strong><span
                                                                                class="tong-cong">{{number_format($data_item->total_price)}}</span>
                                                                        đ</strong>
                                                                    </span>
                                                                        </td>

                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            @endif
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group row">
                                                                <div class="col-lg-12 col-sm-12 col-xs-12"
                                                                     style="margin-top: 10px">
                                                                    Ghi chú: {!! $data_item->note !!}
                                                                </div>
                                                                <div class="col-lg-12 col-sm-12 col-xs-12 text-right"
                                                                     style="margin-top: 30px">
                                                                    Bình Dương,
                                                                    Ngày {{date('d',strtotime($data_item->created_at))}}
                                                                    Tháng {{date('m',strtotime($data_item->created_at))}}
                                                                    Năm {{date('Y',strtotime($data_item->created_at))}}
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach


    </div>

@endsection

@section('style')

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print, .print * {
                visibility: visible;
            }

            .page {
                page-break-after: always;
            }
        }

    </style>
@endsection

@section('script')

    <script type="text/javascript">
        function printDiv() {
            window.print();

        }

        window.onload = function () {
            printDiv();
        }
    </script>
@endsection
