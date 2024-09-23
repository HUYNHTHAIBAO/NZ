@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">Danh sách cập nhật hồ sơ chuyên gia</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.expert.expertApplicationUpdate') }}
        </div>
    </div>

    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="col-12">
                        <table id="table_id" class="table color-table muted-table table-striped">
                            <thead class="bg-secondary">
                            <tr>
                                <th class="font-weight-bold">#</th>
                                <th class="font-weight-bold">Họ tên</th>
                                <th class="font-weight-bold">SĐT</th>
                                <th class="font-weight-bold">Tình trạng</th>
                                <th class="font-weight-bold">Tùy chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $key => $item)
                                <tr>
                                    <td>{{$key+=1}}</td>
                                    <td class="font-weight-bold">
                                        {{$item->user->fullname ?? ''}}
                                    </td>
                                    <td>{{$item->user->phone ?? ''}}</td>
                                    <td>
                                        @if($item->approved == 1)
                                            <span class="badge bg-warning text-light">Đang chờ duyệt</span>
                                            <small class="font-weight-bold">
                                                {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i:s') }}
                                            </small>
                                        @elseif($item->approved == 2)
                                            <span class="badge bg-success text-light">Đã duyệt</span>
                                            <small class="font-weight-bold">
                                                {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i:s') }}
                                            </small>
                                        @elseif($item->approved == 3)
                                            <span class="badge bg-danger text-light">Từ chối</span>
                                            <small class="font-weight-bold">
                                                {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i:s') }}
                                            </small>
                                        @else
                                            <span class="badge bg-secondary text-light">Chưa xác định</span>
                                            <small class="font-weight-bold">
                                                {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i:s') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{Route('backend.expert.detailUpdate',[$item->id]) }}"
                                           class="btn waves-effect waves-light btn-primary btn-sm">
                                            <i class="mdi mdi-alert-circle-outline"></i> Xem hồ sơ
                                        </a>
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

@endsection
