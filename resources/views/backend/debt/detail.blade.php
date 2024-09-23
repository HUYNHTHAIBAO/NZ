@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Chi tiết công nợ</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.debt.detail') }}
        </div>
    </div>

        <div class="col-12">
            <table class="table" id="table_id">
                <thead style="background-color: #ccc">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Họ tên</th>
                    <th scope="col">Mã đơn hàng</th>
                    <th scope="col">Đại lý</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Tiền nợ</th>
                    <th scope="col">Tùy chọn</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $item)
                <tr>
                        <th scope="row">{{$key += 1}}</th>
                        <td>{{ $item->fullname }}</td>
                        <td>{{ $item->order_code }}</td>
                        <td>{{ $item->branch->name }}</td>
{{--                        <td>{{App\Models\Orders::getByBranchs($data->id_branchs)->name}}</td>--}}
                        <td>{{ $item->title }}</td>
                        <td>1</td>
                        <td>{{ $item->total_price }}</td>
                        <td>
                            <span>
                                <a href="{{route('backend.orders.detail', [$item->id])}}" class="btn btn-info">Xem</a>
                            </span>
                        </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

@endsection
