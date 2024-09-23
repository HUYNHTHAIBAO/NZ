@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">Danh sách đặt lịch</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.requestExpert.index') }}
        </div>
    </div>

    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="col-12">
                                    <table id="table_id" class="table color-table muted-table table-striped">
                                        <thead class="bg-secondary">
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Tên KH</th>
                                            <th>Tên chuyên gia</th>
                                            <th>Ngày gọi</th>
                                            <th>Thời lượng gọi</th>
                                            <th>Thời gian gọi</th>
                                            <th>Giá</th>
                                            <th>Thanh toán</th>
                                            <th>Trang thái CG</th>
                                            <th>Trang thái KH</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $key => $item)
                                            <tr>
                                                <td>{{$key+=1}}</td>
                                                <td>
                                                    <span class="font-weight-bold"> {{$item->order_code ?? ''}}</span>
                                                </td>
                                                <td><span
                                                        class="font-weight-bold">{{$item->user->fullname ?? ''}}</span>
                                                </td>
                                                <td><span
                                                        class="font-weight-bold">{{$item->userExpert->fullname ?? ''}}</span>
                                                </td>
                                                <td>{{format_date_custom($item->date ?? '')}}</td>
                                                <td>{{$item->duration_id ?? ''}}</td>
                                                <td>{{$item->time ?? ''}}</td>
                                                <td>
                                                    <mark>{{ number_format($item->price ?? 0, 0, ',', '.') }}
                                                        <sup>vnđ</sup>
                                                    </mark>
                                                </td>
                                                <td>
                                                    @if($item->status == 0)
                                                        <span class="badge badge-warning text-white">Chưa thanh toán</span>
                                                    @elseif($item->status == 1)
                                                        <span class="badge badge-success text-white">Đã thanh toán</span>
                                                    @elseif($item->status == 2)
                                                        <span class="badge badge-danger text-white">Thanh toán thất bại</span>
                                                    @else
                                                        <span class="badge badge-info text-white">Chưa xác định</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->type == 1)
                                                        <span class="badge badge-warning text-white">Chưa xác nhận</span>
                                                    @elseif($item->type == 2)
                                                        <span class="badge badge-info text-white">Đã xác nhận</span>
                                                    @elseif($item->type == 3)
                                                        <span class="badge badge-danger text-white">Từ chối</span>
                                                    @elseif($item->type == 4)
                                                        <span class="badge badge-success text-white">Hoàn thành</span>
                                                    @elseif($item->type == 5)
                                                        <span class="badge badge-primary text-white">Đã yêu cầu thương lượng</span>
                                                    @else
                                                        <span class="badge badge-warning text-white">Chưa xác định</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->type_request_user == 1)
                                                        <span class="badge badge-warning text-white">Chờ xác nhận</span>
                                                    @elseif($item->type_request_user == 2)
                                                        <span class="badge badge-info text-white">Đã xác nhận</span>
                                                    @elseif($item->type_request_user == 3)
                                                        <span class="badge badge-danger text-white">Từ chối</span>
                                                        @elseif($item->type_request_user == 4)
                                                            <span class="badge badge-success text-white">Thành công</span>
                                                        @elseif($item->type_request_user == 5)
                                                            <span class="badge badge-primary text-white">Đã xác nhận thương lượng</span>
                                                        @elseif($item->type_request_user == 6)
                                                            <span class="badge badge-danger text-white">Đã từ chối thương lượng</span>
                                                    @elseif($item->type_request_user == 7)
                                                        <span class="badge badge-danger text-white">Quá hạn</span>
                                                        @else
                                                        <span class="badge badge-info text-white">Chưa xác định</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty

                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
