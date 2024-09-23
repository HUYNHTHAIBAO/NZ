@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.staff.index') }}
        </div>

        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">

                    @if(auth()->guard('backend')->user()->can('staff.add'))
                        <div class="row">
                            <div class="col-md-2 pull-right">
                                <a href="{{Route('backend.staff.add')}}"
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
                                        <label class="control-label" for="fullname">Họ tên</label>
                                        <input type="text"
                                               name="fullname"
                                               value="{{$filter['fullname']}}"
                                               id="fullname"
                                               class="form-control" placeholder="Họ tên">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="phone">SĐT</label>
                                        <input type="phone"
                                               name="phone"
                                               value="{{$filter['phone']}}"
                                               id="phone"
                                               class="form-control" placeholder="SĐT">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="email">Email</label>
                                        <input type="email"
                                               name="email"
                                               value="{{$filter['email']}}"
                                               id="email"
                                               class="form-control" placeholder="Email">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Chức vụ</label>
                                        <select class="form-control form-control-line"
                                                name="account_position">
                                            <option value="">Tất cả</option>
                                            @foreach($account_position as $v)
                                                <option value="{{$v['id']}}" {!! $filter['account_position'] ==$v['id'] ? 'selected="selected"' : '' !!}>{{$v['name']}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Trạng thái</label>
                                        <select class="form-control custom-select"
                                                name="status">
                                            <option value="" {!! empty($filter['status'])? 'selected="selected"' : '' !!}>
                                                Tất cả
                                            </option>
                                            <option value="{{\App\Models\CoreUsers::STATUS_REGISTERED}}" {!! $filter['status']==\App\Models\CoreUsers::STATUS_REGISTERED ? 'selected="selected"' : '' !!}>
                                                Đang hoạt động
                                            </option>
                                            <option value="{{\App\Models\CoreUsers::STATUS_BANNED}}" {!! $filter['status'] == \App\Models\CoreUsers::STATUS_BANNED ? 'selected="selected"' : '' !!}>
                                                Đã bị cấm
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label">&nbsp;</label>
                                    <div class="btn-group" role="group" style="display: inherit">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i>Tìm
                                        </button>

                                        <a title="Clear search"
                                           href="{{Route('backend.staff.index')}}"
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
                                    <th>#</th>
                                    <th>SĐT</th>
                                    <th>Họ tên</th>
                                    <th>Chức vụ</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th class="text-right">Tùy chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $key => $user)
                                    <tr>
                                        <td>{{++$start}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->fullname?$user->fullname:'Chưa cập nhật'}}</td>
                                        <td>
                                            @foreach($account_position as $st)
                                                @if($st['id']==$user->account_position)
                                                    {{$st['name']}}
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            {!! $user->status != \App\Models\CoreUsers::STATUS_BANNED ? '<span class="label label-info">đang hoạt động</span>' :
                                        '<span class="label label-danger">đã bị cấm</span>' !!}
                                        </td>
                                        <td>{{$user->created_at}}</td>
                                        <td class="text-right">
                                            @if(Auth()->guard('backend')->user()->id != $user->id)
                                                @if(auth()->guard('backend')->user()->can('staff.edit'))
                                                    <a href="{{Route('backend.staff.edit',[$user->id]). '?_ref=' .$current_url }}"
                                                       class="btn waves-effect waves-light btn-info btn-sm">
                                                        <i class="fa fa-pencil-square-o"></i> Cập nhật</a>
                                                @endif

                                                @if(auth()->guard('backend')->user()->can('staff.delete'))
                                                    <a href="{{Route('backend.staff.delete',[$user->id]) . '?_ref=' .$current_url }}"
                                                       class="btn waves-effect waves-light btn-danger btn-sm" data-bb="confirm" onclick="return confirm('Xóa nhân viên này?')">
                                                        <i class="fa fa-trash-o"></i> Xóa</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">-</td>
                                    </tr>
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