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

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline-info">
                    <div class="card-body">
                        <form class="form-horizontal my-custom-form" action="" method="post">
                            @include('backend.partials.msg')
                            @include('backend.partials.errors')
                            {{ csrf_field() }}

                            <div class="order_detail_admin">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <h1 class="page-header text-center"
                                            style="border:0; margin: 5px 0;border-bottom: 1px solid #eee;">
                                            ĐƠN HÀNG</h1>
                                        <p style="text-align: center">Mã đơn hàng:
                                            <b style="color: #428bca; font-size: 16px;">{{$data_item->order_code}}</b>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{--Ngày xuất: {{date('d/m/Y',strtotime($data_item->created_at))}}</p>--}}
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

                                                <p>Mã giới thiệu: {{$data_item->referral_code}}</p>

                                                <br>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                @if(!empty($data_item->order_detail))
                                                    {!! $data_item->order_detail !!}
                                                @else
                                                    <table class="cart_summary" cellpadding="0" cellspacing="0"
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
{{--                                                                <td style="border: 1px solid #eee;text-align: center"--}}
{{--                                                                    align="center">--}}
{{--                                                                    Mã--}}
{{--                                                                </td>--}}
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
                                                                <td style="border: 1px solid #eee;text-align: center"
                                                                    align="center">

                                                                </td>
                                                            </tr>

                                                            @php $total_price=0; @endphp
                                                            @foreach($data_item->order_details as $k=>$item)
                                                                @php $total_price += ($item->price*$item->quantity); @endphp
                                                                <tr style="text-align: center;background: #fff;">
                                                                    <td style="border: 1px solid #eee;text-align: center"
                                                                        width="5%" align="center" valign="middle"
                                                                        class="stt_item">
                                                                        {{$k+1}}
                                                                    </td>
                                                                    <td style="border: 1px solid #eee;text-align: left"
                                                                        width="25%" align="left" valign="middle">
                                                                        {{$item->title}}
                                                                        {!! $item->product_variation_name?"<br>{$item->product_variation_name}":'' !!}
                                                                    </td>
{{--                                                                    <td style="border: 1px solid #eee;text-align: left"--}}
{{--                                                                        width="14%" align="left" valign="middle">--}}
{{--                                                                        {{$item->product_code}}--}}
{{--                                                                    </td>--}}
                                                                    <td style="border: 1px solid #eee;text-align: center"
                                                                        width="8%" align="center" valign="middle">
                                                                        {{number_format($item->quantity)}}
                                                                    </td>
                                                                    <td style="border: 1px solid #eee;text-align: right"
                                                                        width="10%" align="right" valign="middle">
                                                                        <span class="don-gia"
                                                                              data-don-gia="{{$item->price}}">{{number_format($item->price)}}</span>
                                                                        đ
                                                                    </td>
                                                                    <td style="border: 1px solid #eee;text-align: right"
                                                                        width="10%" align="right" valign="middle">
                                                                        <span class="thanh-tien"
                                                                              data-thanh-tien="{{$item->price}}">{{number_format($item->price*$item->quantity)}}</span>
                                                                        đ
                                                                    </td>
                                                                    <td style="border: 1px solid #eee;text-align: center"
                                                                        width="5%" align="center" valign="middle"
                                                                        class="stt_item">
                                                                        <a href="{{ route('backend.orders.detail.delete', $item->id) }}"
                                                                           class=" btn-sm" id="delete"
                                                                           data-bb="confirm">
                                                                            <i class="fa fa-trash-o" style="color: red"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <tr class="append_product">

                                                            </tr>
                                                            @if($data_item->total_reduce)
                                                                <tr class="">
                                                                    <td colspan="4" class="text-right">
                                                                        <sup><i class="text-danger">Mã giảm giá/Quà
                                                                                tặng</i></sup> Giảm giá
                                                                    </td>
                                                                    <td class="text-right">
                                                                        -{{number_format($data_item->total_reduce)}} đ
                                                                    </td>
                                                                    <td style="border: 1px solid #eee;"></td>
                                                                </tr>
                                                            @endif
                                                            @if($data_item->total_reduce_point)
                                                                <tr class="">
                                                                    <td colspan="4" class="text-right">
                                                                        <sup><i class="text-danger">Điểm tích
                                                                                lủy</i></sup>Giảm giá
                                                                    </td>
                                                                    <td class="text-right">
                                                                        -{{number_format($data_item->total_reduce_point)}}
                                                                        đ
                                                                    </td>
                                                                    <td style="border: 1px solid #eee;"></td>
                                                                </tr>
                                                            @endif
                                                            @if($data_item->reduce_point)
                                                                <tr class="">
                                                                    <td colspan="4" class="text-right">
                                                                        Trừ điểm
                                                                    </td>
                                                                    <td class="text-right">
                                                                        -{{number_format($data_item->reduce_point)}}
                                                                        đ
                                                                    </td>
                                                                    <td style="border: 1px solid #eee;"></td>
                                                                </tr>
                                                            @endif
                                                            @if($data_item->shipping_fee)
                                                                <tr class="">
                                                                    <td colspan="4" class="text-right">
                                                                        Phí ship
                                                                    </td>
                                                                    <td class="text-right">
                                                                        {{number_format($data_item->shipping_fee)}} đ
                                                                    </td>
                                                                    <td style="border: 1px solid #eee;"></td>
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
                                                                <td style="border: 1px solid #eee;"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group row">
                                                    <div class="col-lg-12 col-sm-12 col-xs-12" style="margin-top: 10px">
                                                        Ghi chú: {!! $data_item->note !!}
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 text-right"
                                                         style="margin-top: 30px">
                                                        Bình Dương, Ngày {{date('d',strtotime($data_item->created_at))}}
                                                        Tháng {{date('m',strtotime($data_item->created_at))}}
                                                        Năm {{date('Y',strtotime($data_item->created_at))}}
                                                    </div>
                                                </div>

                                                <div class="form-group row order-state">
                                                    <div class="col-lg-3">Trạng thái</div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <select
                                                                {!! in_array($data_item->status,[4,5])?'disabled="disabled"':'' !!}
                                                                id="status" name="status"
                                                                class="form-control main_font">
                                                                @foreach(\App\Models\Orders::$status as $k=> $v)
                                                                    <option value="{{$k}}"
                                                                        {{$k==$data_item->status?"selected":""}}
                                                                    >{{$v}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="hide-print">
                                            <input type="submit" value="Lưu"
                                                   class="btn btn-primary" {!! in_array($data_item->status,[4,5])?'disabled="disabled"':'' !!}/>
                                            <input type="button" value="Thoát"
                                                   onclick="javascript:window.location='{{route('backend.orders.index')}}'"
                                                   class="btn btn-default"/>
                                            <input type="button" value="In đơn hàng" id="print_button"
                                                   class="btn btn-default"
                                                   onclick="window.print()"/>
                                            <button type="button" class="btn btn-info" id="append_product">
                                                Thêm SP
                                            </button>
                                            @if($data_item->status_payment == 1)
                                                <a href="{{route('backend.orders.pay_debt', [$data_item->id])}}"><button type="button" class="btn btn-success">Hoàn thành nợ</button></a>
                                            @endif
                                            @if($data_item->status_payment == 3)
                                                <button type="button" disabled class="btn btn-secondary">Đã thanh toán nợ</button>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $arrays = \App\Models\Product::where('status', 1)->get();
    $dataFromDatabase = [];
    foreach ($arrays as $array) {
        $dataFromDatabase[] = [
            'id' => $array->id,
            'name' => $array->title,
            'price' => $array->price,
        ];
    }
    ?>
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style type="text/css" media="print">
        .btn-default,
        .hide-print,
        .page-titles,
        .topbar,
        .left-sidebar,
        .order-state {
            display: none;
        }
    </style>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        const arrays = <?php echo json_encode($dataFromDatabase); ?>;
        $(function () {
            $(document).on('click', '#delete', function (e) {
                e.preventDefault();
                var link = $(this).attr("href");
                Swal.fire({
                    title: 'Bạn có chắc xóa không?',
                    text: "Xóa dữ liệu này?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link
                        Swal.fire(
                            'Xóa!',
                            'Xóa dữ liệu thành công.',
                            'success'
                        )
                    }
                })
            });
            $(document).on('click', '#append_product', function () {
                let html = `
                        <td style="border: 1px solid #eee; text-align: center;" width="5%" align="center" valign="middle" class="stt_item">

                        </td>
                        <td style="border: 1px solid #eee; text-align: left;" width="25%" align="left" valign="middle">
                            <select class="js-example-disabled-results option-select" style="width: 100%;">
                                <option value="" >Chọn sản phẩm</option>
                                ${arrays.map(item => `<option value="${item.id}" data-price="${item.price}">${item.name}</option>`).join('')}
                            </select>
                        </td>
                        <td style="border: 1px solid #eee; text-align: center;" width="8%" align="center" valign="middle">
                            <div  class="append_quantity">0</div>
                        </td>
                        <td style="border: 1px solid #eee; text-align: right;" width="10%" align="right" valign="middle">
                            <span class="don-gia-appned" data-don-gia="">0</span>
                            đ
                        </td>
                        <td style="border: 1px solid #eee; text-align: right;" width="10%" align="right" valign="middle">
                            <span class="thanh-tien-appned" data-thanh-tien="">0</span>
                            đ
                        </td>
                        <td style="border: 1px solid #eee; text-align: center;" width="5%" align="center" valign="middle" class="stt_item">
                            <a href="" class="btn-sm" id="delete" data-bb="confirm"> <i class="fa fa-trash-o" style="color: red;"></i> </a>
                            <span class="btn-sm" id="save" data-bb="confirm"> <i class="fa fa-pencil-square-o" style="color: #083283; cursor: pointer"></i> </span>
                        </td>
                    `;

                $('.append_product').append(html);
                $('.js-example-disabled-results').select2();
                $(this).hide()
            });


        });

        $(document).on('change', '.option-select', function () {
            var id = $(this).val();
            var selectedOption = $(this).find(':selected');
            // Lấy giá trị thuộc tính 'data-price' của tùy chọn đã chọn
            var price = selectedOption.attr("data-price");
            $('.append_quantity').html(' <input type="number" class="form-control" id="quantity_apend" value="1" style="width: 50px">')
            var value = 1;
            updatePrice(price, value);
            // alert(price)
        });

        $(document).on('change', '#quantity_apend', function () {
            var value = $(this).val();
            var selectedOption = $('.option-select').find(':selected');
            var price = selectedOption.attr("data-price");
            updatePrice(price, value);

        });

        $(document).on('click', '#save', function () {

            var selectedOption = $('.option-select').find(':selected');
            var price = selectedOption.attr("data-price");
            var product_id = selectedOption.val()
            var quantity = $('#quantity_apend').val()
            var order_id = <?php echo $data_item->id; ?>;
            var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "POST",
                url: "{{ route('backend.orders.detail.add')}}",
                data: {price: price, product_id:product_id,quantity:quantity,order_id:order_id,  _token: _token},
                dataType: 'json',
                success: function (data) {
                    alert('Thao tác thành công!');
                    window.location.reload()
                },
                error: function (xhr, status, error) {
                    alert('Có lỗi xảy ra, vui lòng thử lại!');
                },
            });
        });

        function updatePrice(price, quantity = 1) {
            // Tính toán tổng giá trị dựa trên số lượng và giá
            var totalPrice = price * quantity;

            // Định dạng số tiền và cập nhật các phần tử trên trang
            $('.don-gia-appned').text(formatCurrency(price));
            $('.thanh-tien-appned').text(formatCurrency(totalPrice));
        }

        function formatCurrency(number) {
            return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        }
    </script>
@endsection
