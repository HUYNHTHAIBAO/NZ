@extends('frontend.layouts.frontend')

@section('content')

    @include('frontend.parts.breadcrumbs')

    <!-- blog main wrapper start -->
    <div class="blog-main-wrapper section-padding pt-20">

        <div class="container">
            @if(!$order)
                <form action="" method="get">
                    <div class="row justify-content-center text-center">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="order_code" required
                                       placeholder="Nhập mã đơn hàng">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="phone" required
                                       placeholder="Nhập số điện thoại">
                            </div>
                        </div>

                        <div class="col-md-2 text-left">
                            <button type="submit" class="btn btn-black">Kiểm tra</button>
                        </div>

                    </div>
                </form>
            @endif

            <div class="mb-10 cart-table">
                @if($order)
                    <p class="text-black">

                        Mã đơn hàng: <b>{{$order->order_code}}</b><br>
                        Họ tên: <b>{{$order->fullname}}</b><br>
                        Địa chỉ: <b>{{$order->address}}</b><br>
                        Ngày đặt: <b>{{$order->created_at->format('H:i d-m-Y')}}</b><br>
                        Trạng thái:
                        <span class="label label-info "> <b
                                class="text-danger">{{\App\Models\Orders::$status[$order->status]}}</b></span><br>
                        Ghi chú: <b>{{$order->note}}</b>
                        @if($order->payment_type == 2)
                            <b class="text-danger">Bạn đã chọn thanh toán bằng chuyển khoản bạn vui lòng chuyển tiền vào
                                tài khoản để hoàn tất thanh toán</b>
                            <br>
                            STK: <b class="text-danger">{{$BANK_ACCOUNT_NUMBER}}</b> Tại {{$BANK_NAME}}<br>
                            Tên chủ tài khoản:  <b class="text-danger">{{$BANK_ACCOUNT_NAME}}</b><br>
                            Ghi chú chuyển khoản:  <b class="text-danger">{{$order->order_code}} _ {{$order->phone}} _
                                Thanh toán đơn hàng</b>@endif
                    </p>
                    <form class="mb-4" action="" method="post">
                        <table class="table" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">&nbsp;</th>
                                    <th class="product-name">Sản phẩm</th>
                                    <th class="product-price">Đơn giá</th>
                                    <th class="product-price">ĐVT</th>
                                    <th class="product-quantity w-lg-15">Số lượng</th>
                                    <th class="product-subtotal">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->order_details as $product)
                                    <tr class="">
                                        <td class="d-none d-md-table-cell text-left">
                                            <img class="border" style="width: 60px;height: auto"
                                                 src="{{$product->thumbnail_src}}"
                                                 alt="{{$product->title}}">
                                        </td>

                                        <td data-title="">
                                            {{$product->title}}
                                            {!! $product->product_variation_name?"<p>{$product->product_variation_name}</p>":'' !!}
                                        </td>

                                        <td data-title="">
                                            <span class="">{{number_format($product->price)}} đ</span>
                                        </td>

                                        <td data-title="">
                                            {{ $product->specifications}}
                                        </td>
                                        <td data-title="Số lượng">
                                            {{number_format($product->quantity)}}
                                        </td>

                                        <td data-title="Thành tiền">
                                            <span> {{number_format($product->total_price)}} đ</span>
                                        </td>
                                    </tr>
                                @endforeach

                                @if($order->total_reduce)
                                    <tr>
                                        <td colspan="5" class="text-right">
                                            <sup><i class="text-danger">Mã giảm giá/Quà tặng</i></sup> Giảm giá:
                                        </td>
                                        <td>
                                            - {{number_format($order->total_reduce)}} đ
                                        </td>
                                    </tr>
                                @endif
                                @if($order->total_reduce_point)
                                    <tr>
                                        <td colspan="5" class="text-right">
                                            <sup><i class="text-danger">Điểm tích lủy</i></sup> Giảm giá:
                                        </td>
                                        <td>
                                            - {{number_format($order->total_reduce_point)}} đ
                                        </td>
                                    </tr>
                                @endif
                                @if($order->shipping_fee)
                                    <tr>
                                        <td colspan="5" class="text-right">
                                            Phí vận chuyển
                                        </td>
                                        <td>
                                            {{number_format($order->shipping_fee)}} đ
                                        </td>
                                    </tr>
                                @endif
                                <tr class="">
                                    <td colspan="5" class="text-right">
                                        Tổng cộng:
                                    </td>
                                    <td class="text-danger">
                                        <b> {{number_format($order->total_price)}} đ</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                @else

                @endif
            </div>

        </div>
    </div>
@endsection
