@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.users.settingsExpert') }}
        </div>
    </div>

    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">

                    <form class="form-horizontal" action="{{route('backend.users.settingsExpert', $user->id)}}" method="post">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6" style="margin: auto">
                                @include('backend.partials.msg')
                                @include('backend.partials.errors')


                                <div class="form-group">
                                    <label class="col-sm-12 font-weight-bold">Trạng thái Hiển thị trên trang chủ <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <select class="form-control form-control-line"
                                                name="show">
                                            <option value="">Chọn</option>
                                            <option value="1" {{$user->show == 1 ? 'selected' : ''}}>
                                                Ẩn
                                            </option>
                                            <option value="2" {{$user->show == 2 ? 'selected' : ''}}>
                                                Hiển thị
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12 font-weight-bold">Thứ tự ưu tiên <span
                                            class="text-danger">( Từ 1 -> ) <sup>1 ưu tiên cao nhất</sup></span></label>
                                    <div class="col-md-12">
                                        <input type="text"
                                               class="form-control form-control-line"
                                               value="{{old('priority', $user->priority ?? '')}}"
                                               name="priority">
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
