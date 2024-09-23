@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{--            {{ Breadcrumbs::render('backend.users.index') }}--}}
        </div>

        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">

                    <form class="form-horizontal" action="{{route('backend.setting.coupon')}}" method="post">

                        <div class="row">
                            <div class="col-md-6" style="margin: auto">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="">Mã giới thiệu Cấp 1 ( % )</span></label>
                                    <div class="col-md-12">
                                        <input type="text"
                                               class="form-control form-control-line"
                                               name="admin_coupon"  value="{{$data->admin_discount}}">
                                        {{--                                       "--}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="">Mã giới thiệu cấp 2 ( % )</span></label>
                                    <div class="col-md-12">
                                        <input type="text"
                                               class="form-control form-control-line"
                                               name="user_coupon" value="{{$data->user_discount}}">
                                        {{--                                        value="{{$form_init->fullname}}"--}}
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

