@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
{{--            {{ Breadcrumbs::render('backend.expertCategory.edit') }}--}}
        </div>
    </div>

    <div class="row page-titles">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">
                    <form class="form-horizontal" action="{{route('backend.expertCategoryTags.edit', $data->id)}}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 row" style="margin: auto">



                                <div class="form-group col-12">
                                    <label for="name" class="font-weight-bold">Tên Tags <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{$data->name}}">
                                    @if ($errors->has('name'))
                                        <div class="custom_error">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group col-12">
                                    <label class="control-label font-weight-bold">
                                        Trạng thái
                                    </label>
                                    <select class="form-control form-control-sm" name="status">
                                        <option value="0" {{$data->status == 0 ? "selected" : ''}}>Không hoạt
                                            động
                                        </option>
                                        <option value="1" {{$data->status == 1 ? "selected" : ''}}>Hoạt động
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <div class="col-sm-12 text-center">
                                        <button class="btn btn-info" type="submit">Thêm</button>
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
