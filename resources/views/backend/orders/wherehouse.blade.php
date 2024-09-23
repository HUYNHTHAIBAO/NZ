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

        <div class="container-fluid page">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline-info">
                        <div class="card-body">
                            <div class="text-head text-left">
                                <strong>CÔNG TY TNHH MỘT THÀNH VIÊN XUẤT NHẬP KHẨU BẢO CHÂU</strong>
                                <p>143/358, Khu phố 2, Phường Tân Đông, Thành phố Đồng Xoài, Tin Bình Phước, Việt
                                    Nam</p>
                                <p>Mã số thuế: 3801120431 </p>
                                <p>Tell: 0397777708</p>
                            </div>
                            <div class="text-title text-center">
                                <p><b>TỔNG HỢP BÁN HÀNG THEO MẶT HÀNG VÀ NHÂN VIÊN</b></p>
                                <b style="font-size: 16px"><i>Ngày 07 tháng 9 năm 2023</i></b>
                            </div>

                            <!-- begin: table -->
                            <table>
                                <tr>
                                    <th style="width: 30px; font-weight: bold;">STT</th>
                                    <th style="width: 150px; font-weight: bold;">Tên KH</th>
                                    <th style="width: 100px; font-weight: bold;">DVT</th>
                                    <th style="font-weight: bold;">Số lượng</th>
                                    <th style="font-weight: bold;">Doanh số</th>
                                    <th style="font-weight: bold;">Chiết khấu</th>
                                    <th style="font-weight: bold;">DG sau CK</th>
                                    <th style="font-weight: bold;">Số lượng trả lại</th>
                                    <th style="font-weight: bold;">Giá trị trả lại</th>
                                    <th style="font-weight: bold;">Giá trị giảm giá</th>
                                </tr>
                                @if(count($data))
                                    @foreach($data as $k=>$item)
                                        <tr>
                                            <td colspan="10" style="font-weight: bold;">Tên hàng: {{ $item[$k]['title'] }}</td>
                                        </tr>
                                            <?php
                                            $quantity = 0;
                                            $total_price = 0;
                                            ?>
                                        @foreach($item as $j=>$childitem)
                                                <?php $quantity += $childitem['quantity']; $total_price += $childitem['total_price'] ?>

                                            <tr>
                                                <td style="width: 30px;">{{$j+1}}</td>
                                                <td style="width: 150px;">{{ \App\Models\Orders::find($childitem['order_id'])->fullname ?? null }}</td>
                                                <td style="width: 100px;">{{$childitem['specifications']}}</td>
                                                <td>{{$childitem['quantity']}}</td>
                                                <td style="width: 150px;">{{ number_format($childitem['total_price']) }} đ</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td style="font-weight: bold;" colspan="3">Cộng nhóm: {{ $item[$k]['title'] }}</td>
                                            <td style="font-weight: bold;">{{$quantity}}</td>
                                            <td style="font-weight: bold;">{{ number_format($total_price) }} đ</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                            <!-- end: table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('style')

    <style>
        .text-head {
            font-family: "Times New Roman";
            line-height: 25px;
            font-size: 18px;
        }

        .text-title p,
        .text-head p {
            margin-bottom: 0px;
        }

        .text-title {
            font-family: "Times New Roman";
            font-size: 24px;
            font-weight: bold;
        }

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

        table, td, th {
            border: 1px solid;
            padding: 2px;
            font-family: "Times New Roman";
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
