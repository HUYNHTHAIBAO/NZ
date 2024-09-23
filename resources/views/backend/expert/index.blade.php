@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
{{--            {{ Breadcrumbs::render('backend.expert.index') }}--}}
        </div>
    </div>

    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">

                    @if(auth()->guard('backend')->user()->can('users.add'))
                        <div class="row">
                            <div class="col-md-2 pull-right">
                                <a href="{{Route('backend.users.add')}}"
                                   class="btn waves-effect waves-light btn-block btn-info">
                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới
                                </a>
                            </div>
                        </div>
                    @endif

                    <form action="" method="get" id="form-filter">
                        <div class="form-body">
                            <div class="row p-t-20">

                                <div class="col-md-12">
                                    @include('backend.partials.msg')
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label font-weight-bold" for="fullname">Họ tên</label>
                                        <input type="text"
                                               name="fullname"
                                               value="{{$filter['fullname']}}"
                                               id="fullname"
                                               class="form-control" placeholder="Họ tên">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label font-weight-bold" for="phone">SĐT</label>
                                        <input type="phone"
                                               name="phone"
                                               value="{{$filter['phone']}}"
                                               id="phone"
                                               class="form-control" placeholder="SĐT">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label font-weight-bold" for="email">Email</label>
                                        <input type="email"
                                               name="email"
                                               value="{{$filter['email']}}"
                                               id="email"
                                               class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label font-weight-bold">Trạng thái</label>
                                        <select class="form-control custom-select"
                                                name="status">
                                            <option
                                                value="" {!! empty($filter['status'])? 'selected="selected"' : '' !!}>
                                                Tất cả
                                            </option>
                                            <option
                                                value="{{\App\Models\CoreUsers::$status_active}}" {!! $filter['status']==\App\Models\CoreUsers::$status_active ? 'selected="selected"' : '' !!}>
                                                Đang hoạt động
                                            </option>
                                            <option
                                                value="{{\App\Models\CoreUsers::$status_inactive}}" {!! $filter['status']==\App\Models\CoreUsers::$status_inactive ? 'selected="selected"' : '' !!}>
                                                Chưa kích hoạt
                                            </option>
                                            <option
                                                value="{{\App\Models\CoreUsers::$status_banned}}" {!! $filter['status'] == \App\Models\CoreUsers::$status_banned ? 'selected="selected"' : '' !!}>
                                                Đã bị cấm
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">&nbsp;</label>
                                    <div class="btn-group" role="group" style="display: inherit">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i>Tìm
                                        </button>


                                        <a title="Clear search"
                                           href="{{Route('backend.users.index')}}"
                                           class="btn btn-danger">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table color-table muted-table table-striped">
                            <thead>
                            <tr>
                                <th class="font-weight-bold">#</th>
                                <th class="font-weight-bold">SĐT</th>
                                <th class="font-weight-bold">Họ tên</th>
                                <th class="font-weight-bold">Trạng thái</th>
                                <th class="font-weight-bold">Thứ tự</th>
                                <th class="font-weight-bold">Tình trạng</th>
                                <th class="font-weight-bold">Ngày gửi</th>
                                <th class="font-weight-bold">Quản lý</th>
                                <th class="text-right font-weight-bold">Tùy chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $key => $user)
                                @if(Auth()->guard('backend')->user()->id == $user->id)
                                    @php continue; @endphp
                                @endif
                                <tr>
                                    <td>{{++$start}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td class="font-weight-bold">{{$user->fullname?$user->fullname:'Chưa cập nhật'}}</td>
                                    <td>
                                        @if($user->show == 1)
                                            <span class="badge bg-secondary text-white">Ẩn</span>
                                        @else
                                            <span class="badge bg-info text-white">Hiển thị</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-danger text-white">{{$user->priority ?? ''}}</span>
                                    </td>
                                    <td>
                                        @if($user->status == 1)
                                            <span class="label label-info">Đang hoạt động</span>
                                        @elseif($user->status == 0)
                                            <span class="label label-warning">Chưa kích hoạt</span>
                                        @else
                                            <span class="label label-danger">Đã bị cấm</span>
                                        @endif
                                    </td>
                                    <td>{{date_format($user->created_at, 'd/m/Y')}}</td>
                                    <td>
                                        <a href="{{Route('backend.calendarExpert.duration',[$user->id]) }}"
                                           class="btn waves-effect waves-light btn-primary btn-sm">
                                            <i class="mdi mdi-alert-circle-outline"></i> Thời gian & giá
                                        </a>
                                        <a href="{{Route('backend.calendarExpert.time',[$user->id]) }}"
                                           class="btn waves-effect waves-light btn-success btn-sm">
                                            <i class="mdi mdi-alert-circle-outline"></i> Lịch
                                        </a>
                                        <a href="{{Route('backend.users.chart',[$user->id]) }}"
                                           class="btn waves-effect waves-light btn-secondary btn-sm">
                                            <i class="fa-solid fa-chart-pie"></i> Thống kê
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        @if(Auth()->guard('backend')->user()->id != $user->id)

{{--                                            <a href="{{Route('backend.users.settingsExpert',[$user->id]). '?_ref=' .$current_url }}"--}}
{{--                                               class="btn waves-effect waves-light btn-primary btn-sm">--}}
{{--                                                <i class="fa fa-solid fa-gear"></i>--}}
{{--                                            </a>  --}}

                                            @if(auth()->guard('backend')->user()->can('users.edit'))
                                                <a href="{{Route('backend.users.edit',[$user->id]). '?_ref=' .$current_url }}"
                                                   class="btn waves-effect waves-light btn-info btn-sm">
                                                    <i class="fa fa-pencil-square-o"></i></a>
                                            @endif

                                            @if(auth()->guard('backend')->user()->can('users.delete'))
                                                <a href="{{Route('backend.users.delete',[$user->id]) . '?_ref=' .$current_url }}"
                                                   class="btn waves-effect waves-light btn-danger btn-sm"
                                                   data-bb="confirm" onclick="return confirm('Xóa tài khoản này?')">
                                                    <i class="fa fa-trash-o"></i></a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty

                            @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{--pagination--}}
                    <div class="text-center">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
