@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.debt.index') }}
        </div>
    </div>

    <div class="col-12">
        <table class="table" id="table_id">
            <thead style="background-color: #ccc">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Số đơn</th>
                <th scope="col">Tổng tiền nợ</th>
                <th scope="col">Tùy chọn</th>
            </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $item)
            <tr>
                <th scope="row">{{$key += 1}}</th>
                <td>{{$item->fullname}}</td>
                <td>{{$item->phone}}</td>
                <td>
                    {{$item->user->address}}</td>
                <td>{{ $item->orders_count }}</td>
                <td>{{ $item->total_debt }}</td>
                <td>
                    <span>
                        <a href="{{route('backend.debt.detail', [$item->user_id] )}}" class="btn btn-info">Chi tiết</a>
                    </span>
                </td>
            </tr>
                @endforeach
            </tbody>
        </table>

    </div>



@endsection
