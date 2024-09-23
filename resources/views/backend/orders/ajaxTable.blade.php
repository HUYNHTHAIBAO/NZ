<form action="" method="get" id="form-filter">
    <div class="form-body">
        <div class="row">
            <div class="col-md-12">
                @include('backend.partials.msg')
                @include('backend.partials.errors')
            </div>
        </div>
    </div>
</form>
<form action="{{route('backend.orders.export')}}" method="GET">
    <div class="table-responsive ajax-result">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 20px;"><input type="checkbox"
                                                    class="checkbox-basic check-all"></th>
                    <th>Mã đơn hàng</th>
                    <th>Họ tên</th>
                    <th>Số ĐT</th>
                    <th>Ngày đặt</th>
                    <th>Tiền ship</th>
                    <th>Thanh toán đơn</th>
                    <th>Tổng tiền</th>
                    <th>Tình trạng</th>
                    <th class="text-right" style="min-width: 86px">Tùy chọn</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data_list as $key => $item)
                    <tr>
                        <td>{{++$start}}</td>
                        <td>
                            <input type="checkbox" name="ids[]" value="{{$item->id}}"
                                   id="{{$item->id}}" class="checkbox-basic check-all-child">
                        </td>
                        <td>{{$item->order_code}}</td>
                        <td>{{$item->fullname}}</td>
                        <td>{{$item->phone}}</td>
                        <td>{{date('d/m/Y',strtotime($item->created_at))}}</td>

                        <td data-id="{{$item->id}}">
                            <div class="input-group">
                                <input type="number" class="form-control form-control-sm"
                                       placeholder="Tiền ship" value="{{$item->shipping_fee}}">
                                <div class="input-group-append">
                                    <button class="btn btn-info btn-sm save-shipping-fee" type="button">
                                        <i class="fa fa-save"></i></button>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($item->status_payment == 1 )
                                <span class="badge bg-danger text-light">Thanh toán nợ</span>
                             @elseif($item->status_payment == 3)
                                <span class="badge bg-success text-light">Nợ đã thanh toán</span>
                            @else
                                <span class="badge bg-secondary text-light">Tiền mặt</span>
                            @endif
                        </td>
                        <td>{{number_format($item->total_price)}} đ</td>

                        <td>{{\App\Models\Orders::$status[$item->status]}}</td>

                        <td class="text-right">
                            <a href="{{Route('backend.orders.detail',[$item->id]). '?_ref=' .$current_url }}"
                               class="btn waves-effect waves-light btn-info btn-sm">
                                <i class="fa fa-pencil-square-o"></i> </a>

                            <a href="{{Route('backend.orders.delete',[$item->id]) . '?_ref=' .$current_url }}"
                               class="btn waves-effect waves-light btn-danger btn-sm" data-bb="confirm">
                                <i class="fa fa-trash-o"></i> </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center">Chưa có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 10px">
        <label> Chọn tất cả <input type="checkbox" class="checkbox-basic check-all"></label>

        <input type="number" class="input-btn-type" name="type" value="" hidden>
        <button type="submit" class="btn waves-effect waves-light btn-xs btn-success btn-type1"
        >Hoàn thành nhanh
        </button>
        <button type="submit" class="btn waves-effect waves-light btn-xs btn-info btn-type2"
        >In nhiều đơn
        </button>


    </div>
</form>

<div class="pull-right ajax-pagination">
    {{ $data_list->links() }}
</div>
{{--Xuât excel--}}
<div class="modal fade" id="ExPortExcel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông tin xuất</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{route('backend.orders.excel.export')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <select class="option-export form-control form-control-sm custom-select" name="option">
                            <option value="1">Xuất theo tất cả</option>
                            <option value="2">từ ngày đến ngày</option>
                        </select>
                        <div class="date-export row mt-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="date"
                                           name="date_start"
                                           value=""
                                           id="date_from"
                                           class="form-control" placeholder="Từ ngày">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <input type="date"
                                           name="date_end"
                                           value=""
                                           id="date_to"
                                           class="form-control" placeholder="Đến ngày">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-close" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Xuất</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{--Xuât excel--}}
{{-- Phiêu xuất kho--}}
<div class="modal fade" id="ExPortWhereHouse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông tin xuất</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{route('backend.orders.wherehouse.export')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <select class="option-export form-control form-control-sm custom-select" name="option">
                            <option value="1">Phiếu hôm nay</option>
                            <option value="2">Từ ngày đến ngày</option>
                        </select>
                        <div class="date-export row mt-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="date"
                                           name="date_start"
                                           value=""
                                           id="date_from"
                                           class="form-control" placeholder="Từ ngày">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <input type="date"
                                           name="date_end"
                                           value=""
                                           id="date_to"
                                           class="form-control" placeholder="Đến ngày">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-close" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-warning">Tạo phiếu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Phiêu xuất kho--}}
@section('script')

    <script>
        $('.date-export').hide()
        $(document).on('click', '.save-shipping-fee', function () {
            var id = $(this).parent().parent().parent().data('id');
            var shipping_fee = $(this).parent().parent().find('input').val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            if (shipping_fee == '') {
                alert('Vui lòng nhập chiết khấu!');
                return;
            }
            $.ajax({
                type: 'POST',
                url: "{{route('backend.ajax.shipping-fee')}}",
                data: {id: id, shipping_fee: shipping_fee, _token: _token},
                dataType: 'json',
                success: function (data) {
                    if (data.code == 200) {
                        alert('Cập nhật thành công');
                        window.location.reload();
                    } else {
                        alert(data.error);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Có lỗi xảy ra!');
                }
            });
        });
        jQuery(document).on("click", ".btn-type1", function (e) {
            $('.input-btn-type').val(1);

        });
        jQuery(document).on("click", ".btn-type2", function (e) {
            $('.input-btn-type').val(2);

        });

        // xuat excel

        jQuery(document).on("click", ".close-modal", function (e) {
            $('#ExPortExcel').modal('hide');
            $('#ExPortWhereHouse').modal('hide');
        });
        jQuery(document).on("click", ".btn-close", function (e) {
            $('#ExPortExcel').modal('hide');
            $('#ExPortWhereHouse').modal('hide');
        });
        jQuery(document).on("change", ".option-export", function (e) {

            var val = $(this).val();

            if( parseInt(val) === 2 ) {
                $('.date-export').show()
            } else  {
                $('.date-export').hide()
            }

        });
        jQuery(document).on("click", ".btn-ExPortExcel", function (e) {
            $('#ExPortExcel').modal('show');

        });

        //  Phiêu xuất kho

        jQuery(document).on("click", ".btn-ExPortWhereHouse", function (e) {
            $('#ExPortWhereHouse').modal('show');

        });
    </script>
@endsection
