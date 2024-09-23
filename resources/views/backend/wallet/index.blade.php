@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">Danh sách rút tiền</h3>
        </div>
        <div class="col-md-7 align-self-center">
                        {{ Breadcrumbs::render('frontend.wallet.index') }}
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
                                            <th>Tên chuyên gia</th>
                                            <th>Ngân hàng</th>
                                            <th>STK</th>
                                            <th>Tên tài khoản</th>
                                            <th>Số tiền rút</th>
                                            <th>Ghi chú</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th class="text-right">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $key => $item)
                                            <tr>
                                                <td>{{$key+=1}}</td>
                                                <td><span class="font-weight-bold">{{$item->user->fullname ?? ''}}</span></td>
                                                <td>
                                                    {{$item->bank_name ?? ''}}
                                                </td>
                                                <td>
                                                    {{$item->bank_stk ?? ''}}
                                                </td>
                                                <td>
                                                    {{$item->name ?? ''}}
                                                </td>
                                                <td>
                                                    <mark>{{ number_format($item->price ?? 0, 0, ',', '.') }} <sup>vnđ</sup></mark>
                                                </td>
                                                <td>
                                                    {{$item->note ?? ''}}
                                                </td>
                                                <td>
                                                    @if($item->status == 1)
                                                        <span class="badge badge-warning text-white">Đang chờ duyệt</span>
                                                    @elseif($item->status == 2)
                                                        <span class="badge badge-success text-white">Đã duyệt</span>
                                                    @else
                                                        <span class="badge badge-warning text-white">Từ chối</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    {{format_date_custom($item->created_at)}}
                                                </td>
                                                <td class="text-right">
                                                    @if($item->status == 1)
                                                    <form
                                                        action="{{ route('backend.walletExpert.approve', ['id' => $item->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn waves-effect waves-light btn-success btn-sm">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                            Duyệt
                                                        </button>
                                                    </form>
                                                    @else
                                                        <form
                                                            action="{{ route('backend.walletExpert.approve', ['id' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn waves-effect waves-light btn-success btn-sm" disabled>
                                                                <i class="fa fa-pencil-square-o"></i>
                                                                Duyệt
                                                            </button>
                                                        </form>
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
