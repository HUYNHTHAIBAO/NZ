@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">Danh sách rút tiền</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{--            {{ Breadcrumbs::render('backend.banner.index.blade.php') }}--}}
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
                                <table class="table color-table muted-table table-striped">
                                    <thead>
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
                                            <td>{{$item->user->fullname ?? ''}}</td>
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
                                                {{ number_format($item->price ?? 0, 0, ',', '.') }} vnđ
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
                                <nav aria-label="Page navigation example" class="d-flex justify-content-end">
                                    <ul class="pagination ">
                                        {{$data->links()}}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
