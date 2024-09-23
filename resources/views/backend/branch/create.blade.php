@extends('backend.layouts.main')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.brands.index') }}

        </div>

        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-body">

                    <form class="form-horizontal form-bordered"
                          action="{{ $isEditable ? Route('backend.brands.update',['id'=>$branch->id]) : Route('backend.brands.store') }}"
                          method="post">
                        @csrf
                        <div class="x">

                            <div class="form-group row">
                                <label class="control-label text-left col-md-2" for="META_TITLE">
                                    Tên đại lý<span style="color: red"> (*)</span>
                                </label>
                                <div class="col-md-10">
                                    <input type="text"
                                           name="name"
                                           value="{{old('name',!empty($branch) ? $branch->name : '')}}"
                                           class="form-control" id="name"
                                           placeholder="Vui lòng nhập tên chính nhánh">
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback" style="display:block">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-12">Giờ mở cửa</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control form-control-line" name="daily"
                                           value="@if (!empty($branch)) {{old('daily', $branch->daily)}}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Số điện thoại</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control form-control-line" name="phone"
                                           value="@if (!empty($branch)) {{old('phone', $branch->phone)}}@endif ">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">Địa chỉ</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control form-control-line" name="address"
                                           value="@if (!empty($branch)) {{old('address', $branch->address)}}@endif ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Điểm đầu (Lat)</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control form-control-line" name="o_lat"
                                           value="@if (!empty($branch)) {{old('o_lat', $branch->o_lat)}}@endif ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Điểm cuối (Long)</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control form-control-line" name="o_long"
                                           value="@if (!empty($branch)) {{old('o_long', $branch->o_long)}}@endif ">
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="form-group">
                                    @if($isEditable)
                                        <button class="btn btn-info" type="submit">Cập nhật</button>
                                    @else
                                        <button class="btn btn-info" type="submit">Tạo mới</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link href="{{ asset('/storage/backend')}}/assets/plugins/codemirror/lib/codemirror.css" rel="stylesheet">
    <link href="{{ asset('/storage/backend')}}/assets/plugins/codemirror/theme/monokai.css" rel="stylesheet">
@stop

@section('script')
    <script type="text/javascript">

        $(document).ready(function () {

        });

        function sendFileToServer(formData, d) {

            $.ajax({
                url: "{{route('backend.ajax.uploadImage')}}",
                type: "POST",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    if (data.e) {
                        alert(data.r);
                    } else {
                        d.parent().find('img').attr('src', data.r[0].url);
                        d.parent().find('input.upload_img_value').val(data.r[0].path);
                        d.parent().parent().find('.upload_img_select').val('');
                    }
                }
            });

        }
    </script>
@stop
