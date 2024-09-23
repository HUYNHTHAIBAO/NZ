@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            @isset($form_init->id)
                {{ Breadcrumbs::render('backend.users.edit') }}
            @else
                {{ Breadcrumbs::render('backend.users.add') }}
            @endisset
        </div>
    </div>

    <div class="row page-titles">
            <div class="col-md-12">
                <div class="card card-outline-info">
                    <div class="card-body">

                        <form class="form-horizontal" action="" method="post">

                            <div class="row">
                                <div class="col-md-6" style="margin: auto">
                                    @include('backend.partials.msg')
                                    @include('backend.partials.errors')

                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="col-md-12 font-weight-bold">Họ tên <span class="text-danger">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text"
                                                   class="form-control form-control-line"
                                                   name="fullname"
                                                   value="{{$form_init->fullname}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12 font-weight-bold">Email <span class="text-danger">*</span></label>
                                        <div class="col-md-12">
                                            <input type="email"
                                                   class="form-control form-control-line"
                                                   name="email"
                                                   value="{{$form_init->email}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 font-weight-bold">Điện thoại <span class="text-danger">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text"
                                                   class="form-control form-control-line"
                                                   value="{{$form_init->phone}}"
                                                   name="phone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 font-weight-bold">Mật khẩu <span class="text-danger">*</span></label>
                                        <div class="col-md-12">
                                            <input type="password"
                                                   class="form-control form-control-line"
                                                   value="{{$form_init->password}}"
                                                   name="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12 font-weight-bold">Trạng thái <span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line"
                                                    name="status">
                                                <option value="">Chọn</option>
                                                <option
                                                    value="{{\App\Models\CoreUsers::$status_inactive}}" {!! $form_init->status ==\App\Models\CoreUsers::$status_inactive ? 'selected="selected"' : '' !!}>
                                                    Chưa kích hoạt
                                                </option>
                                                <option
                                                    value="{{\App\Models\CoreUsers::STATUS_REGISTERED}}" {!! $form_init->status ==\App\Models\CoreUsers::STATUS_REGISTERED ? 'selected="selected"' : '' !!}>
                                                    Đang hoạt động
                                                </option>
                                                <option
                                                    value="{{\App\Models\CoreUsers::STATUS_BANNED}}" {!! $form_init->status == \App\Models\CoreUsers::STATUS_BANNED ? 'selected="selected"' : '' !!}>
                                                    Đã bị cấm
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12 text-center">
                                            <button class="btn btn-info" type="submit">Lưu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
@endsection
