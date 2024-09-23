@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.staff.edit') }}

        </div>

        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">

                    <form class="form-horizontal" action="" method="post">

                        @include('backend.partials.msg')
                        @include('backend.partials.errors')

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" readonly
                                           class="form-control form-control-line"
                                           value="{{$form_init->phone}}"
                                           name="phone">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Trạng thái <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-line"
                                            name="status">
                                        <option value="">Chọn</option>
                                        <option value="{{\App\Models\CoreUsers::STATUS_REGISTERED}}" {!! $form_init->status ==\App\Models\CoreUsers::STATUS_REGISTERED ? 'selected="selected"' : '' !!}>
                                            Đang hoạt động
                                        </option>
                                        <option value="{{\App\Models\CoreUsers::STATUS_BANNED}}" {!! $form_init->status == \App\Models\CoreUsers::STATUS_BANNED ? 'selected="selected"' : '' !!}>
                                            Đã bị cấm
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Chức vụ <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-line"
                                            name="account_position">
                                        <option value="">Chọn</option>
                                        @foreach($account_position as $v)
                                            <option value="{{$v['id']}}" {!! $form_init->account_position ==$v['id'] ? 'selected="selected"' : '' !!}>{{$v['name']}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Đại lý</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="id_branchs">
                                        <option value="" > Chọn đại lý </option>
                                        @foreach($branch as $key => $item)
                                            <option value="{{$item->id}}"  {!! $form_init->id_branchs ==$item['id'] ? 'selected="selected"' : '' !!}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="title">Quyền trong hệ thống </h4>

                                <div class="form-group">
                                    @foreach($all_permissions as $k => $v)
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="text-danger">{{ucfirst($k)}}:</p>
                                            </div>
                                            <div class="col-md-8">
                                                @foreach($v as $k2 => $v2)
                                                    <input type="checkbox" id="basic_checkbox_{{$v2->name}}"
                                                           name="grant_permissions[]"
                                                           value="{{$v2->id}}" {{ $form_init->grant_permissions && in_array($v2->id,$form_init->grant_permissions)?"checked":'' }}/>
                                                    <label for="basic_checkbox_{{$v2->name}}"
                                                           class="filled-in chk-col-red">{{$v2->title}}</label>
                                                    &nbsp; &nbsp;

                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-info" type="submit">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
